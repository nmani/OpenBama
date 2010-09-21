<style type="text/css">

    p{
        margin-bottom:0px;
        font-weight:bold;
    }

    /* Start layout CSS */
    .tableWidget_headerCell,.tableWigdet_headerCellOver,.tableWigdet_headerCellDown{	/* General rules for both standard column header and mouse on header of sortable columns */
                                                                                     cursor:pointer;
                                                                                     border-bottom:3px solid #C5C2B2;
                                                                                     border-right:1px solid #ACA899;
                                                                                     border-left:1px solid #FFF;
                                                                                     background-color: #ECE9D8;
    }

    .tableWidget_headerCell{	/* Standard column header */
                             border-top:2px solid #ECE9D8;

    }

    .tableWigdet_headerCellOver{	/* Rollover on sortable column header */
                                 border-top:2px solid #FFC83C;
    }
    .tableWidget tbody .tableWidget_dataRollOver{	/* Rollover style on mouse over (Data) */
                                                  background-color:#FFF;	/* No mouseover color in this example - specify another color if you want this */
    }

    .tableWigdet_headerCellDown{
        border-top:2px solid #FFC83C;
        background-color:#DBD8C5;
        border-left:1px solid #ACA899;
        border-right:1px solid #FFF;
    }
    .tableWidget td{
        margin:0px;
        padding:2px;
        border-bottom:1px solid #EAE9E1;	/* Border bottom of table data cells */

    }
    .tableWidget tbody{
        background-color:#FFF;
    }
    .tableWidget{
        font-family:arial;
        font-size:12px;
        width:400px;
    }

    /* End layout CSS */


    div.widget_tableDiv {
        border:1px solid #ACA899;	/* Border around entire widget */
        height: 200px;
        overflow:auto;
        overflow-y:auto;
        overflow:-moz-scrollbars-vertical;
        width:400px;

    }

    html>body div.widget_tableDiv {
        overflow: hidden;
        width:400px;
    }

    .tableWidget thead{
        position:relative;
    }
    .tableWidget thead tr{
        position:relative;
        top:0px;
        bottom:0px;
    }



    .tableWidget .scrollingContent{
        overflow-y:auto;
        overflow:-moz-scrollbars-vertical;
        width:100%;

    }
</style>

<script type="text/javascript">
    /*
(C) www.dhtmlgoodies.com, October 2005

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.

Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Thank you!

www.dhtmlgoodies.com
Alf Magne Kalleland

     */
    var tableWidget_tableCounter = 0;
    var tableWidget_arraySort = new Array();
    var tableWidget_okToSort = true;
    var activeColumn = new Array();
    var arrowImagePath = "<?php echo base_url().'img/'; ?>";	// Path to arrow images

    function addEndCol(obj)
    {
        if(document.all)return;
        var rows = obj.getElementsByTagName('TR');
        for(var no=0;no<rows.length;no++){
            var cell = rows[no].insertCell(-1);
            cell.innerHTML = ' ';
            cell.style.width = '13px';
            cell.width = '13';

        }

    }

    function highlightTableHeader()
    {
        this.className='tableWigdet_headerCellOver';
        if(document.all){	// I.E fix for "jumping" headings
            var divObj = this.parentNode.parentNode.parentNode.parentNode;
            this.parentNode.style.top = divObj.scrollTop + 'px';

        }

    }

    function deHighlightTableHeader()
    {
        this.className='tableWidget_headerCell';
    }

    function mousedownTableHeader()
    {
        this.className='tableWigdet_headerCellDown';
        if(document.all){	// I.E fix for "jumping" headings
            var divObj = this.parentNode.parentNode.parentNode.parentNode;
            this.parentNode.style.top = divObj.scrollTop + 'px';
        }
    }

    function sortNumeric(a,b){

        a = a.replace(/,/,'.');
        b = b.replace(/,/,'.');
        a = a.replace(/[^\d\-\.\/]/g,'');
        b = b.replace(/[^\d\-\.\/]/g,'');
        if(a.indexOf('/')>=0)a = eval(a);
        if(b.indexOf('/')>=0)b = eval(b);
        return a/1 - b/1;
    }


    function sortString(a, b) {

        if ( a.toUpperCase() < b.toUpperCase() ) return -1;
        if ( a.toUpperCase() > b.toUpperCase() ) return 1;
        return 0;
    }

    function sortDate(a, b) {
        aDate = new Date(a);
        bDate = new Date(b);
        if ( aDate < bDate ) return -1;
        if ( aDate > bDate ) return 1;
        return 0;
    }
    function cancelTableWidgetEvent()
    {
        return false;
    }

    function sortTable()
    {
        if(!tableWidget_okToSort)return;
        tableWidget_okToSort = false;
        /* Getting index of current column */
        var obj = this;
        var indexThis = 0;
        while(obj.previousSibling){
            obj = obj.previousSibling;
            if(obj.tagName=='TD')indexThis++;
        }
        var images = this.getElementsByTagName('IMG');

        if(this.getAttribute('direction') || this.direction){
            direction = this.getAttribute('direction');
            if(navigator.userAgent.indexOf('Opera')>=0)direction = this.direction;
            if(direction=='ascending'){
                direction = 'descending';
                this.setAttribute('direction','descending');
                this.direction = 'descending';
            }else{
                direction = 'ascending';
                this.setAttribute('direction','ascending');
                this.direction = 'ascending';
            }
        }else{
            direction = 'ascending';
            this.setAttribute('direction','ascending');
            this.direction = 'ascending';
        }



        if(direction=='descending'){
            images[0].style.display='inline';
            images[0].style.visibility='visible';
            images[1].style.display='none';
        }else{
            images[1].style.display='inline';
            images[1].style.visibility='visible';
            images[0].style.display='none';
        }


        var tableObj = this.parentNode.parentNode.parentNode;
        var tBody = tableObj.getElementsByTagName('TBODY')[0];

        var widgetIndex = tableObj.id.replace(/[^\d]/g,'');
        var sortMethod = tableWidget_arraySort[widgetIndex][indexThis]; // N = numeric, S = String
        if(activeColumn[widgetIndex] && activeColumn[widgetIndex]!=this){
            var images = activeColumn[widgetIndex].getElementsByTagName('IMG');
            images[0].style.display='none';
            images[1].style.display='inline';
            images[1].style.visibility = 'hidden';
            if(activeColumn[widgetIndex])activeColumn[widgetIndex].removeAttribute('direction');
        }

        activeColumn[widgetIndex] = this;

        var cellArray = new Array();
        var cellObjArray = new Array();
        for(var no=1;no<tableObj.rows.length;no++){
            var content= tableObj.rows[no].cells[indexThis].innerHTML+'';
            cellArray.push(content);
            cellObjArray.push(tableObj.rows[no].cells[indexThis]);
        }

        if(sortMethod=='N'){
            cellArray = cellArray.sort(sortNumeric);
        }else if(sortMethod=='S')
        {
            cellArray = cellArray.sort(sortString);
        }else if(sortMethod=='D'){
            cellArray = cellArray.sort(sortDate);

        }else
        {
            cellArray = cellArray.sort(sortString);
        }

        if(direction=='descending'){
            for(var no=cellArray.length;no>=0;no--){
                for(var no2=0;no2<cellObjArray.length;no2++){
                    if(cellObjArray[no2].innerHTML == cellArray[no] && !cellObjArray[no2].getAttribute('allreadySorted')){
                        cellObjArray[no2].setAttribute('allreadySorted','1');
                        tBody.appendChild(cellObjArray[no2].parentNode);
                    }
                }
            }
        }else{
            for(var no=0;no<cellArray.length;no++){
                for(var no2=0;no2<cellObjArray.length;no2++){
                    if(cellObjArray[no2].innerHTML == cellArray[no] && !cellObjArray[no2].getAttribute('allreadySorted')){
                        cellObjArray[no2].setAttribute('allreadySorted','1');
                        tBody.appendChild(cellObjArray[no2].parentNode);
                    }
                }
            }
        }

        for(var no2=0;no2<cellObjArray.length;no2++){
            cellObjArray[no2].removeAttribute('allreadySorted');
        }

        tableWidget_okToSort = true;


    }

    function initTableWidget(objId,width,height,sortArray)
    {
        width = width + '';
        height = height + '';
        var obj = document.getElementById(objId);
        obj.parentNode.className='widget_tableDiv';
        if(navigator.userAgent.indexOf('MSIE')>=0){
            obj.parentNode.style.overflowY = 'auto';
        }
        tableWidget_arraySort[tableWidget_tableCounter] = sortArray;
        if(width.indexOf('%')>=0){
            obj.style.width = width;
            obj.parentNode.style.width = width;
        }else{
            obj.style.width = width + 'px';
            obj.parentNode.style.width = width + 'px';
        }

        if(height.indexOf('%')>=0){
            //obj.style.height = height;
            obj.parentNode.style.height = height;

        }else{
            //obj.style.height = height + 'px';
            obj.parentNode.style.height = height + 'px';
        }
        obj.id = 'tableWidget' + tableWidget_tableCounter;
        addEndCol(obj);

        obj.cellSpacing = 0;
        obj.cellPadding = 0;
        obj.className='tableWidget';
        var tHead = obj.getElementsByTagName('THEAD')[0];
        var cells = tHead.getElementsByTagName('TD');
        for(var no=0;no<cells.length;no++){
            cells[no].className = 'tableWidget_headerCell';
            cells[no].onselectstart = cancelTableWidgetEvent;
            if(no==cells.length-1){
                cells[no].style.borderRight = '0px';
            }
            if(sortArray[no]){
                cells[no].onmouseover = highlightTableHeader;
                cells[no].onmouseout =  deHighlightTableHeader;
                cells[no].onmousedown = mousedownTableHeader;
                cells[no].onmouseup = highlightTableHeader;
                cells[no].onclick = sortTable;

                var img = document.createElement('IMG');
                img.src = arrowImagePath + 'arrow_up.gif';
                cells[no].appendChild(img);
                img.style.visibility = 'hidden';

                var img = document.createElement('IMG');
                img.src = arrowImagePath + 'arrow_down.gif';
                cells[no].appendChild(img);
                img.style.display = 'none';


            }else{
                cells[no].style.cursor = 'default';
            }


        }
        var tBody = obj.getElementsByTagName('TBODY')[0];
        if(document.all && navigator.userAgent.indexOf('Opera')<0){
            tBody.className='scrollingContent';
            tBody.style.display='block';
        }else{
            tBody.className='scrollingContent';

            if(tBody.offsetHeight>(tBody.parentNode.parentNode.offsetHeight - 50)) {
                tBody.style.height = (obj.parentNode.clientHeight-tHead.offsetHeight) + 'px';
            }else{
                tBody.style.overflow='hidden';
            }
            if(navigator.userAgent.indexOf('Opera')>=0){
                obj.parentNode.style.overflow = 'auto';
            }
        }

        for(var no=1;no<obj.rows.length;no++){
            obj.rows[no].onmouseover = highlightDataRow;
            obj.rows[no].onmouseout = deHighlightDataRow;
            for(var no2=0;no2<sortArray.length;no2++){	/* Right align numeric cells */
                if(sortArray[no2] && sortArray[no2]=='N')obj.rows[no].cells[no2].style.textAlign='right';
            }
        }
        for(var no2=0;no2<sortArray.length;no2++){	/* Right align numeric cells */
            if(sortArray[no2] && sortArray[no2]=='N')obj.rows[0].cells[no2].style.textAlign='right';
        }

        tableWidget_tableCounter++;
    }


    function highlightDataRow()
    {
        if(navigator.userAgent.indexOf('Opera')>=0)return;
        this.className='tableWidget_dataRollOver';
        if(document.all){	// I.E fix for "jumping" headings
            var divObj = this.parentNode.parentNode.parentNode;
            var tHead = divObj.getElementsByTagName('TR')[0];
            tHead.style.top = divObj.scrollTop + 'px';

        }
    }

    function deHighlightDataRow()
    {
        if(navigator.userAgent.indexOf('Opera')>=0)return;
        this.className=null;
        if(document.all){	// I.E fix for "jumping" headings
            var divObj = this.parentNode.parentNode.parentNode;
            var tHead = divObj.getElementsByTagName('TR')[0];
            tHead.style.top = divObj.scrollTop + 'px';
        }
    }

</script>
<?php

$return_url = str_replace('/','-',$this->uri->uri_string());
?>
<input id="currently_displayed" type="hidden" value="section-1" />
<style type="text/css">
    #menu {
        border-bottom : 1px solid #ccc;
        margin : 0;
        padding-bottom : 19px;
        padding-left : 10px;
    }

    #menu ul, #menu li	{
        display : inline;
        list-style-type : none;
        margin : 0;
        padding : 0;
    }


    #menu a:link, #menu a:visited	{
        background : #E8EBF0;
        border : 1px solid #ccc;
        color : #666;
        float : left;
        font-size : small;
        font-weight : normal;
        line-height : 14px;
        margin-right : 8px;
        padding : 2px 10px 2px 10px;
        text-decoration : none;
    }

    #menu a:link.active, #menu a:visited.active	{
        background : #fff;
        border-bottom : 1px solid #fff;
        color : #000;
    }

    #menu a:hover	{
        color : #f00;
    }

    .section-1 #menu li#nav-1 a,
    .section-2 #menu li#nav-2 a,
    .section-3 #menu li#nav-3 a,
    .section-4 #menu li#nav-4 a {
        background : #fff;
        border-bottom : 1px solid #fff;
        color : #000;
    }

    #menu #subnav-1,
    #menu #subnav-2 {
        display : none;
        /*width: 90%;*/
    }

    .section-1 #menu ul#subnav-1,
    .section-2 #menu ul#subnav-2 {
        display : inline;
        left : 0px;
        position : absolute;
        top : 25px;

    }

    .section-1 #menu ul#subnav-1 a,
    .section-2 #menu ul#subnav-2 a {
        background : #fff;
        border : none;
        border-left : 1px solid #ccc;
        color : #999;
        font-size : smaller;
        font-weight : bold;
        line-height : 10px;
        margin-right : 4px;
        padding : 2px 10px 2px 10px;
        text-decoration : none;
    }

    #menu ul a:hover {
        color : #f00 !important;
    }
    #menu-content {
        background : #fff;
        border : 1px solid #ccc;
        border-top : none;
        clear : both;
        margin : 0px;
        padding : 15px;


    }

</style>

<?php
$post_url = site_url('bill/add_comment');
$load_url = site_url('bill/view_comments/'.$bill->id);

echo "<script type=\"text/javascript\">
    $(document).ready(function() {
        $('#submit').click(function() {

            var msg = $('#comment_text').val();
//This random number is a hack for IE.  it caches the url
// So you have to trick IE into thinking the url is a new one each time.
//In the PHP code, the random number is ignored in the url.
            var randomnumber=Math.floor(Math.random()*100);


            $.post(\"".$post_url."\", {comment: msg, bill: '".$bill->id."'}, function() {
                $('#bill_comments_div').load(\"".$load_url."/\" + randomnumber);
                $('#comment_text').val('');
            });
        });
    });
</script>"; ?>

<?php
if(count($bill_version_types) > 0) {

    $version_extra_options = 'id="version_type_list" onchange="xajax_get_version_text('.$this->uri->segment(3).',this[this.selectedIndex].value);configure_download_links(this[this.selectedIndex].value);"';
    $bill_version_type_list = array('0' => '-- Select an version --');

    if($bill_version_types) {
        foreach($bill_version_types as $row) {
            $bill_version_type_list[$row->version_type] = $row->version_type_desc;
        }
    }
}

?>

<script type="text/javascript">

    function configure_download_links(textType){
        var baseURL = document.getElementById('billDownloadLinkBase');
        var pdfLink = document.getElementById('pdf_link');
        var txtLink = document.getElementById('txt_link');

        if (textType == 0){
            pdfLink.href = '#';
            txtLink.href = '#';
        }else{
            pdfLink.href = baseURL.value + '-' + textType + '.pdf';
            txtLink.href = baseURL.value + '-' + textType + '.txt';
        }
    }
</script>
<div id="content">
    <div id="leftdiv">

        <div>
            <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=381c3502-600d-4f37-b237-c6b7ff990f48&amp;type=website"></script>
        </div>
        <hr>
        <?php if ($bill) {
            echo '<h2>'.strtoupper($bill->bill_type).$bill->number.'</h2>';
        }
        ?>

        <a href="<?php echo $support_vote_href; ?>" onclick="<?php echo $support_vote_onclick; ?>"><img border="0" src="<?php echo base_url().'img/green_thumb.png'; ?>"></img></a> &nbsp;<a href="<?php echo $support_vote_href; ?>" onclick="<?php echo $support_vote_onclick; ?>">I Support</a>&nbsp;&nbsp; | &nbsp;&nbsp;
        <a href="<?php echo $support_vote_href; ?>" onclick="<?php echo $no_support_vote_onclick; ?>"><img border="0" src="<?php echo base_url().'img/red_thumb.png'; ?>"></img></a> &nbsp;<a href="<?php echo $support_vote_href; ?>" onclick="<?php echo $no_support_vote_onclick; ?>">I Do Not Support</a>

        <div class="ui-widget">
            <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
                <div id="bill_vote_results_div"><?php echo $support_status; ?>
                    <?php if ($vote_stats): ?>
                    <br>
                        <?php echo '<strong>'.round($vote_stats->PercentSupport).'%</strong>'.' users support this bill'; ?>
                    <br>
                        <?php echo $vote_stats->TotalSupport.' support /'; ?>

                        <?php echo $vote_stats->TotalNotSupport.' do not support'; ?>
                    <?php else: ?>
                        <?php echo 'No votes have been cast.'; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="ui-widget">
            <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
                <strong>Page View Stats</strong><br>
                Total views:<?php echo $page_view_stats->TotalAll; ?>
                <br>
                Past seven days:<?php echo $page_view_stats->Total7Days; ?>
                <br>
                Today:<?php echo $page_view_stats->TotalToday; ?>
            </div>
        </div>
        <br>

        <div style="position: relative;">

            <div id="menu_div" class="section-1">
                <ul id="menu">
                    <li id="nav-1"><a href="#" onclick="display_tab('section-1');return false;">Main</a></li>

                    <li id="nav-2"><a href="#" onclick="display_tab('section-2');return false;">Actions & Votes</a></li>
                    <li id="nav-3"><a href="#" onclick="display_tab('section-3');return false;">Comments</a></li>
                    <!--<li id="nav-4"><a href="#" onclick="display_tab('section-4');return false;">Official Text</a></li>-->


                </ul>
            </div>

        </div>
        <div id="menu-content">
            <div style="margin-top: 30px;">



                <div id="section-1" style="display: block;">
                    <div>
                        <?php $vote1 = false;
                        $vote2 = false;
                        $introduced = false;
                        $enacted = false;
                        $vote1_passed = false;
                        $vote2_passed = false;
                        $to_governor = false;
                        $vote1_date = false;
                        $vote2_date = false;
                        $introduced_date = false;
                        $enacted_date = false;
                        $to_governor_date = false;

                        ?>
                        <?php foreach($bill_status_list as $status) : ?>
                            <?php if($status->action_type == 'introduced') {

                                $introduced = true;
                                $introduced_date = date("m/d/Y",strtotime($status->action_date));

                            }elseif ($status->action_type == 'vote1') {
                                $vote1 = true;
                                $vote1_date = date("m/d/Y",strtotime($status->action_date));

                                if($status->result == 'PASSED') {
                                    $vote1_passed = true;
                                }else {
                                    $vote1_passed = false;
                                }
                            }elseif ($status->action_type == 'vote2') {
                                $vote2 = true;
                                $vote2_date  = date("m/d/Y",strtotime($status->action_date));

                                if($status->result == 'PASSED') {
                                    $vote2_passed = true;
                                }else {
                                    $vote2_passed = false;
                                }

                                $vote1 = true;
                                $vote1_passed = true;

                            }elseif ($status->action_type == 'togovernor') {

                                $to_governor_date  = date("m/d/Y",strtotime($status->action_date));
                                $to_governor = true;

                            }elseif ($status->action_type == 'enacted') {

                                $enacted = true;
                                $enacted_date  = date("m/d/Y",strtotime($status->action_date));

                            }
                            ?>
                        <?php endforeach; ?>

                        <table>
                            <tr>
                                <td>
                                    <div id="bill-detail">

                                        <?php
                                        if ($bill) {
                                            $image_file_name = MEMBER_IMAGE_LOCATION.$bill->sponsor_id.'.jpg';
                                            if(!file_exists($image_file_name)) {
                                                $image_file_name = base_url().'img/members/image_not_avail.gif';
                                            }else {
                                                $image_file_name = base_url().'img/members/'.$bill->sponsor_id.'.jpg';
                                            }
                                            echo '<h3>Basic Information</h3>';
                                            echo '<p>';
                                            echo '<strong>Date Introduced</strong><br>';

                                            echo date("M j, Y",strtotime($bill->introduced));
                                            echo '<br><strong>Subject</strong><br>';
                                            echo $bill->subject;
                                            echo '<br><strong>Status</strong><br>';
                                            echo $bill->current_alison_status;
                                            echo '</p>';
                                            echo '<h3>Summary</h3>';
                                            echo '<p>';
                                            echo $bill->description.'<br>';
                                            echo '<a href="'.base_url().INDEX_TO_INCLUDE.'bill/fulltext/'.$bill->id.'">View the full text >></a>';
                                            echo '</p>';

                                            echo '<h3>Last Action</h3>';
                                            echo '<p>';
                                            if ($last_action) {
                                                echo date("M j",strtotime($last_action->action_date));
                                                echo '('.$last_action->action_text.')<br>';
                                            }else {
                                                echo 'No action';
                                            }
                                            echo '</p>';

                                            echo '<h3>Sponsor</h3>';
                                            echo '<p>';
                                            echo '<center><img src="'.$image_file_name.'" width="69" height="100" title="'.$bill->sponsor.'" alt="'.$bill->sponsor.'" /><br>';

                                            echo '<a href="'.base_url().INDEX_TO_INCLUDE.'person/display/'.$bill->sponsor_id.'"><strong>'.$bill->sponsor.'['.$bill->party.', '.$bill->district.']</strong></a><br></center>';
                                            echo '</p>';

                                            echo '<h3>Cosponsors</h3>';
                                            echo '<p>';
                                            echo '(Democrat: '.$dem_party_support->party_support.';';
                                            echo 'Republican: '.$repub_party_support->party_support;
                                            echo ')<br><br>';
                                            if ($cosponsors) {


                                                foreach($cosponsors as $cosponsor) {

                                                    echo '<a href="'.base_url().INDEX_TO_INCLUDE.'person/display/'.$cosponsor->id.'">'.$cosponsor->full_name.'['.substr($cosponsor->party,0,1).', '.$cosponsor->district.']</a> (Sponsor date - '.date("M j, Y",strtotime($cosponsor->sponsor_date)).')<br>';
                                                }

                                            }else {
                                                echo 'No cosponsors at this time.';
                                            }
                                            echo '</p>';

                                            if ($committees) {
                                                echo '<h3>Committees</h3>';
                                                echo '<p>';
                                                foreach($committees as $committee) {

                                                    echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/display/'.$committee->id.'">'.$committee->committee_name.'</a><br>';
                                                }
                                                echo '</p>';
                                            }

                                            echo '<h3>Related Bills</h3>';
                                            if ($related_bills) {

                                                echo '<p>';
                                                foreach($related_bills as $related) {
                                                    echo '<a href="'.base_url().INDEX_TO_INCLUDE.'bill/display/'.$related->id.'">'.strtoupper($related->bill_type).$related->number.'</a><br>';
                                                }
                                                echo '</p>';
                                            }else {
                                                echo '<p>';
                                                echo 'No related bills.';
                                                echo '<p>';
                                            }

                                            if ($bill->fiscal_note) {
                                                echo '<h3>Fiscal Notes</h3>';
                                                echo '<p>'.$bill->fiscal_note.'</p>';
                                            }

                                        }

                                        ?>
                                    </div>
                                </td>
                                <td valign="top">

                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
                <div id="section-2" style="display: none;">
                    <div id="actions-detail">
                        <h3>Actions</h3>
                        <div class="yui-skin-sam"><div id="actions_div"></div></div>

                        <div class="widget_tableDiv">
                            <table id="myTable">
                                <thead><tr><td>Date</td><td>Action</td></tr></thead>
                                <?php foreach($bill_actions as $row) : ?>
                                <tr><td><?php echo date("m/d/Y",strtotime($row->action_date)); ?></td>
                                    <td><?php
                                            $action_string = "";
                                            if ($row->roll_call_id) {
                                                if (strrpos($row->action_text, "Roll Call")) {
                                                    $action_string = str_replace('Roll Call', '<a href="'.base_url().INDEX_TO_INCLUDE.'vote/display/'.$row->roll_call_id.'">Roll Call</a>',$row->action_text);
                                                }else {
                                                    $action_string = $row->action_text.' <a href="'.base_url().INDEX_TO_INCLUDE.'vote/display/'.$row->roll_call_id.'">Roll Call '.$row->roll_call_number.'</a>';
                                                }


                                            }else {
                                                if($row->amendment_id) {
                                                    $action_string = $row->action_text.' (<a href="'.base_url().'bills/'.$bill->session_identifier.'/'.$row->amendmentidentifier.'.pdf">'.$row->amendmentidentifier.'</a>)';
                                                }else {
                                                    $action_string = $row->action_text;
                                                }
                                            }



                                            echo $action_string; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <script type="text/javascript">
                            initTableWidget('myTable','100%','100%',Array('D','S'));
                        </script>
                    </div>
                </div>
                <div id="section-3" style="display: none;">
                    <div id="bill_comments_div">
                        <?php
                        $this->load->view('comments_list');
                        ?>

                    </div>
                    <hr>
                    <br>
                    <div>
                        <?php if($user_logged_in): ?>
                        <input type="hidden" id="bill_id_field" value="<?php echo $bill->id?>"/>
                        <table>
                            <tr><td align="right">Comment:</td><td>
                                    <textarea name="comment_text" id="comment_text" rows="6" cols="40" ></textarea><br><br></td></tr>
                            <tr><td></td><td>
                                    <input type="submit" class="ob_button" value="Add Comment" name="submit" id="submit" />
                                </td></tr>
                        </table>
                        <?php else: ?>
                        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'auth/login/'.$return_url; ?>">Login</a> or create an
                        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'auth/register'; ?>">account</a> to add a comment.
                        <?php endif; ?>


                    </div>
                </div>
                <div id="section-4" style="display: none;">
                    <div>

                        <input type="hidden" id="billDownloadLinkBase" name="billDownloadLinkBase" value="<?php echo base_url().'bills/'.$bill->session_identifier.'/'.strtoupper($bill->bill_type).$bill->number; ?>" />
                        <?php echo form_dropdown('version_type_list',$bill_version_type_list,'0',$version_extra_options); ?>
                        <!--
                        <a id="pdf_link" href="#" target="_blank"><img src="<?php echo base_url().'img/pdf_icon.jpg'; ?>" alt="Download PDF version" title="Download PDF version" width="35px" height="48px" border="0"></img></a>
                        <a id="txt_link" href="#" target="_blank"><img src="<?php echo base_url().'img/txt_icon.jpg'; ?>" alt="Download text version" title="Download text version" width="35px" height="48px" border="0"></img></a>
                        -->
                        [<a id="pdf_link" href="#" target="_blank">Export to PDF</a>]
                        [<a id="txt_link" href="#" target="_blank">Export to Text</a>]
                    </div>
                    <div id="bill_text_div">
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div id="rightdiv">
        <div class="summary_content_div">
            <div id="bill-progress">
                <h3>Progress</h3>

                <table id="bill-progress">
                    <tr class="alt">
                        <td>
                            <?php if($introduced): ?>
                            <div class="checkbox passed">&#9745;</div>
                            <?php else: ?>
                            <div>&#9744;</div>
                            <?php endif; ?>

                        </td>
                        <td class="text">Introduced <?php if ($introduced_date) echo '- '.$introduced_date; ?></td>

                    </tr>
                    <tr class="alt">
                        <td>
                            <?php if($vote1 && $vote1_passed): ?>
                            <div class="checkbox passed">&#9745;</div>
                            <?php elseif($vote1 && !$vote1_passed): ?>
                            <div class="checkbox failed">&#9746;</div>
                            <?php else: ?>
                            <div>&#9744;</div>
                            <?php endif; ?>

                        </td>
                        <td class="text">Passed House of Origin <?php if ($vote1_date) echo '- '.$vote1_date; ?></td>

                    </tr>
                    <tr>
                        <td>
                            <?php if($vote2 && $vote2_passed): ?>
                            <div class="checkbox passed">&#9745;</div>
                            <?php elseif($vote2 && !$vote2_passed): ?>
                            <div class="checkbox failed">&#9746;</div>
                            <?php else: ?>
                            <div>&#9744;</div>
                            <?php endif; ?>

                        </td>
                        <td class="text">Passed Second House <?php if ($vote2_date) echo '- '.$vote2_date; ?></td>
                    </tr>
                    <tr class="alt">
                        <td>
                            <?php if($to_governor): ?>
                            <div class="checkbox passed">&#9745;</div>
                            <?php else: ?>
                            <div>&#9744;</div>
                            <?php endif; ?>

                        </td>
                        <td class="text">Sent to Governor <?php if ($to_governor_date) echo '- '.$to_governor_date; ?></td>

                    </tr>
                    <tr>
                        <td>
                            <?php if($enacted): ?>
                            <div class="checkbox passed">&#9745;</div>
                            <?php else: ?>
                            <div>&#9744;</div>
                            <?php endif; ?>

                        </td>
                        <td class="text">Became Law <?php if ($enacted_date) echo '- '.$enacted_date; ?></td>
                    </tr>
                </table>

            </div>
        </div>
        <br/>
        <div class="summary_content_div">
            <h3>Full Text of The Bill</h3>

            <?php echo '<a href="'.base_url().INDEX_TO_INCLUDE.'bill/fulltext/'.$bill->id.'">View the full text >></a>'; ?>

        </div>
        <br/>
        <?php if ($committee_meetings): ?>
        <div class="meetings_div">

            <h3>Committee Meetings</h3>

                <?php
                foreach($committee_meetings as $meeting) {

                    echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/display/'.$meeting->committee_id.'">'.$meeting->committee_name.'</a><br>';
                    echo '<strong>Location:</strong>'.$meeting->meeting_location.'<br>';
                    echo '<strong>Date:</strong>'.date("m/d/Y",strtotime($meeting->meeting_date)).'<br>';
                    echo '<strong>Time:</strong>'.$meeting->meeting_time.'<br>';

                }

                ?>



        </div><br/>
        <?php endif; ?>
        <div class="tag_div">
            <h3>Add a tag</h3>

            <?php
            foreach($tags as $tag) {
                echo '<a href="'.base_url().INDEX_TO_INCLUDE.'tagcloud/display/'.$tag->id.'">'.$tag->tag_name.'</a><br>';

            }

            ?>

            <?php if (validation_errors()): ?>
            <div class="ui-widget">
                <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                    <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                            <?php

                            echo validation_errors();

                            ?>
                    </p>
                </div>

            </div>
            <?php endif; ?>

            <?php echo form_open('tagcloud/add_tag_bill'); ?>
            <input type="text" id="tag_text_box" name="tag_text_box" value="" />
            <br>
            <input type="hidden" id="bill_id_text_box" name="bill_id_text_box" value="<?php echo $bill->id; ?>" />
            <input type="submit" value="Add Tag" id="add_tag_button" name="add_tag_button" />
            <?php echo form_close(); ?>
        </div><br/>
        <div class="rss_div">
            <h3>Subscribe</h3>

            Follow the status of this bill by subscribing to this RSS feed.<br>

            <a href="<?php echo base_url().INDEX_TO_INCLUDE.'rss/follow_bill/'.$bill->id; ?>"><img src="<?php echo base_url().'img/rss-icon.png'; ?>" border="0" /></a>&nbsp;Subscribe

        </div>


    </div>
</div>


