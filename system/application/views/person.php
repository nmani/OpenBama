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
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" type="text/javascript"></script> 
<script type="text/javascript">
    $(function() {
        $("#slider").slider({
            value:<?php if($user_rating) {echo $user_rating->rating; }else {echo '0';}?>,
            min: 0,
            max: 100,
            step: 1,
            slide: function(event, ui) {
                $("#percent_rating").val(ui.value + '%');

            }
        });
        $("#percent_rating").val($("#slider").slider("value") + '%');

    });

    $(document).ready(function() {
        $('#rate_them').click(function() {


            //This random number is a hack for IE.  it caches the url
            // So you have to trick IE into thinking the url is a new one each time.
            //In the PHP code, the random number is ignored in the url.
            var randomnumber=Math.floor(Math.random()*100);

            var myRating = $("#slider").slider("value");


            $.post("<?php echo base_url().INDEX_TO_INCLUDE.'person/rate_them'; ?>", {
                person: <?php echo $member->id; ?>,
                person_rating: myRating
            }, function() {
                $('#person_rating_div').load("<?php echo base_url().INDEX_TO_INCLUDE.'person/reload_rating/'; ?><?php echo $member->id; ?>/" + randomnumber);
            });
        });
    });
</script>
<input id="currently_displayed" type="hidden" value="section-1" />
<?php
$post_url = site_url('person/add_comment');
$load_url = site_url('person/view_comments/'.$member->id);

echo "<script type=\"text/javascript\">
    $(document).ready(function() {
        $('#submit').click(function() {

            var msg = $('#comment_text').val();
//This random number is a hack for IE.  it caches the url
// So you have to trick IE into thinking the url is a new one each time.
//In the PHP code, the random number is ignored in the url.
            var randomnumber=Math.floor(Math.random()*100);


            $.post(\"".$post_url."\", {comment: msg, person: '".$member->id."'}, function() {
                $('#person_comments_div').load(\"".$load_url."/\" + randomnumber);
                $('#comment_text').val('');
            });
        });
    });
</script>"; ?>
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
    .section-4 #menu li#nav-3 a,
    .section-5 #menu li#nav-4 a,
    .section-6 #menu li#nav-5 a,
    .section-7 #menu li#nav-6 a{
        background : #fff;
        border-bottom : 1px solid #fff;
        color : #000;
    }

    #menu #subnav-2 {
        display : none;
        /*width: 90%;*/
    }

    .section-2 #menu ul#subnav-2 {
        display : inline;
        left : 0px;
        position : absolute;
        top : 25px;

    }

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
<?php $image_file_name = MEMBER_IMAGE_LOCATION.$member->id.'.jpg'; ?>

<?php if(!file_exists($image_file_name)) {
    $image_file_name = base_url().'img/members/image_not_avail.gif';
}else {
    $image_file_name = base_url().'img/members/'.$member->id.'.jpg';
}
?>
<div id="content">

    <div id="leftdiv">

        <div>
            <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=381c3502-600d-4f37-b237-c6b7ff990f48&amp;type=website"></script>
        </div>
        <hr>
        <?php if ($member) {
            echo '<h2>'.$member->full_name.' ['.$member->party.', '.$member->district.']</h2>';
            echo '<strong>District '.$member->district.':</strong>'.$member->district_description.'<br><br>';
        }
        ?>
        <?php  if($this->redux_auth->logged_in()): ?>
        <label for="percent_rating">Rate this individual:</label>
        <input type="text" id="percent_rating" style="border:0; color:#f6931f; font-weight:bold;" />
        <div id="slider" style="width: 200px;"></div>
        <br>
        <input type="submit" class="ob_button" value="Rate Them!" name="rate_them" id="rate_them" />
        <?php else: ?>
        To rate this individual, please <a href="<?php echo base_url().INDEX_TO_INCLUDE.'auth/login/'.$return_url; ?>">log in</a>.
        <? endif;?>

        <div id="person_rating_div">
            <?php $this->load->view('person_rating_view'); ?>
        </div>

        <div style="position: relative;margin-top:20px;">

            <div id="menu_div" class="section-1">
                <ul id="menu">
                    <li id="nav-1"><a href="#" onclick="display_tab('section-1');return false;">Bio</a></li>
                    <li id="nav-2"><a href="#" onclick="display_tab('section-2');return false;">Bills</a>
                        <ul id="subnav-2">
                            <li><a href="#" onclick="display_sub_tab('section-2','section-2');return false;">Sponsored</a></li>
                            <li><a href="#" onclick="display_sub_tab('section-3','section-2');return false;">Cosponsored</a></li>
                        </ul>
                    </li>
                    <li id="nav-3"><a href="#" onclick="display_tab('section-4');return false;">Committees</a></li>
                    <li id="nav-4"><a href="#" onclick="display_tab('section-5');return false;">Votes</a></li>
                    <li id="nav-5"><a href="#" onclick="display_tab('section-6');return false;">Comments</a></li>
                    <li id="nav-6"><a href="#" onclick="display_tab('section-7');return false;">Money Trail</a></li>
                </ul>
            </div>

        </div>
        <div id="menu-content">
            <div style="margin-top: 30px;">


                <div id="section-1" style="display: block;">


                    <div id="person-detail">
                        <div style="float: left;padding: 5px;">
                            <?php echo '<img src="'.$image_file_name.'" width="69" height="100" title="'.$member->full_name.'" alt="'.$member->full_name.'" />'; ?>
                        </div><br><br><br><br>
                        <?php if($vote_smart_bio): ?>
                            <?php echo '<strong>Home City:</strong>'.$vote_smart_bio->candidate->homeCity.', '.$vote_smart_bio->candidate->homeState.'<br>';
                            echo '<strong>Birthday:</strong>'.$vote_smart_bio->candidate->birthDate;
                            ?>
                        <h3>Family</h3>

                            <?php echo $vote_smart_bio->candidate->family; ?>
                        <h3>Professional</h3>
                            <?php echo $vote_smart_bio->candidate->profession; ?>
                        <h3>Political</h3>
                            <?php echo $vote_smart_bio->candidate->political; ?>
                        <h3>Organizations</h3>
                            <?php echo $vote_smart_bio->candidate->orgMembership; ?>
                        <h3>Religious/Congregation</h3>
                            <?php echo $vote_smart_bio->candidate->religion.'<br>'; ?>
                            <?php echo $vote_smart_bio->candidate->congMembership; ?>

                        <h3>In the Blogs</h3>
                        <p>
                            Blog links provided by <a href="http://blogsearch.google.com">Google</a>.<br>
                                <?php


                                foreach($blog_entries as $item) {

                                    echo "<li>";
                                    echo "<a href='" .$item->get_link() . "'>";
                                    echo $item->get_title();
                                    echo "</a>";
                                    echo '<br><br>'.$item->get_date("M j, Y");
                                    echo '<br>'.$item->get_description().'<br><br>';

                                    echo "</li>";
                                }



                                ?>

                                <?php
                                echo '<a href="'.$google_blogsearch_url.'" target="_blank">More blog results >> </a>';
                                ?>
                        </p>

                        <?php endif; ?>
                    </div>

                </div>
                <div id="section-2" style="display: none;">
                    <h2>Sponsored Bills</h2>
                    <?php $data['bills'] = $sponsored_bills;
                    $this->load->view('bills_view',$data);
                    ?>
                </div>
                <div id="section-3" style="display: none;">
                    <h2>Cosponsored Bills</h2>
                    <?php $data['bills'] = $cosponsored_bills;
                    $this->load->view('bills_view',$data);
                    ?>


                </div>
                <div id="section-4" style="display: none;">

                    <?php if($committees): ?>
                        <?php foreach($committees as $committee) : ?>

                            <?php



                            if ($committee->subcommittee_name) {
                                echo ' &nbsp;&nbsp;&nbsp;Sub committee: '.'<a href="'.base_url().INDEX_TO_INCLUDE.'committee/display/'.$committee->id.'">'.$committee->subcommittee_name.'</a>';
                            }else {
                                echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/display/'.$committee->id.'">'.$committee->committee_name.'</a>';
                            }


                            ?> (<?php echo $committee->role; ?>)<br>
                        <?php endforeach; ?>
                    <?php else: ?>

                    No committee assignments

                    <?php endif; ?>

                </div>
                <div id="section-5" style="display: none;">

                    <?php if($votes): ?>
                        <?php foreach($votes as $vote) : ?>
                    <div style="-moz-border-radius:8px; -webkit-border-radius:8px;background:#fafafa;border: solid 1px #ddd; margin:0; padding:0.8em">
                                <?php
                                echo '<table>';
                                echo '<tr><td colspan="3"><a href="'.base_url().INDEX_TO_INCLUDE.'vote/display/'.$vote->vote_id.'">'.strtoupper($vote->bill_number).'</a> - '.$vote->action_text.'</td></tr>';
                                echo '<tr style="border-bottom: 1px solid gray;"><td width="40%">';
                                echo "<font color='green'>Ayes </font>".$vote->ayes." <font color='red'>Nayes</font> ".$vote->nays.'</td>';
                                //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo '<td width="40%">'.date("M j, Y",strtotime($vote->vote_date)).'</td>';
                                echo '<td><span>
            <table><tr><td align="right">[<a href="#">Top</a>]</td></tr></table></td>
        </span></tr>';
                                echo '</table>';
                                ?>
                    </div>
                    <br>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <table>
                        <tr><td>
                                None to display
                            </td></tr></table>

                    <?php endif; ?>

                </div>
                <div id="section-6" style="display: none;">
                    <div id="person_comments_div">
                        <?php
                        $this->load->view('comments_list');
                        ?>

                    </div>
                    <hr>
                    <br>
                    <div>
                        <?php if($user_logged_in): ?>
                        <input type="hidden" id="person_id_field" value="<?php echo $member->id?>"/>
                        <table>
                            <tr><td align="right">Comment:</td><td>
                                    <textarea name="comment_text" id="comment_text" rows="6" cols="40" ></textarea><br><br></td></tr>
                            <tr><td></td><td>
                                    <input type="submit" class="ob_button" value="Add Comment" name="submit" id="submit" />
                                </td></tr>
                        </table>
                        <?php else: ?>
                        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'auth/login'.$return_url; ?>">Login</a> or create an
                        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'auth/register'; ?>">account</a> to add a comment.
                        <?php endif; ?>
                    </div>

                </div>

                <div id="section-7" style="display: none;">

                    <div class="widget_tableDiv">
                        <?php
                        if ($contributions) {
                            setlocale(LC_MONETARY, 'en_US');
                            $result = '<table id="myTable">';
                            $result .= '<thead><tr><td>Contributor Name</td><td>Business/Sector</td><td>% of Total</td><td>Total Dollars</td></tr></thead>';
                            foreach($contributions['top_contributor'] as $row) {

                                $result .= '<tr>';
                                $result .= '<td style="border-bottom: 1px solid gray;">'.$row['@attributes']['contributor_name'].'</td>';
                                $result .= '<td style="border-bottom: 1px solid gray;">'.$row['@attributes']['business_name'].'</td>';
                                $result .= '<td style="border-bottom: 1px solid gray;">'.$row['@attributes']['percent_of_total_total_dollars'].'</td>';
                                $result .= '<td style="border-bottom: 1px solid gray;">'.$row['@attributes']['total_dollars'].'</td>';
                                $result .= '</tr>';

                            }
                            $result .='</table>';
                            echo $result;
                        }else {
                            echo 'Not Available';
                        }

/*
That it is an implementation of the function format_money for the
platforms that do not it bear.

The function accepts to same string of format accepts for the
original function of the PHP.

(Sorry. my writing in English is very bad)

The function is tested using PHP 5.1.4 in Windows XP
and Apache WebServer.
*/
                        function format_money($format, $number) {
                            $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
                                '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
                            if (setlocale(LC_MONETARY, 0) == 'C') {
                                setlocale(LC_MONETARY, '');
                            }
                            $locale = localeconv();
                            preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
                            foreach ($matches as $fmatch) {
                                $value = floatval($number);
                                $flags = array(
                                    'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                                    $match[1] : ' ',
                                    'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
                                    'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                                    $match[0] : '+',
                                    'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
                                    'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
                                );
                                $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
                                $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
                                $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
                                $conversion = $fmatch[5];

                                $positive = true;
                                if ($value < 0) {
                                    $positive = false;
                                    $value  *= -1;
                                }
                                $letter = $positive ? 'p' : 'n';

                                $prefix = $suffix = $cprefix = $csuffix = $signal = '';

                                $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
                                switch (true) {
                                    case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                                        $prefix = $signal;
                                        break;
                                    case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                                        $suffix = $signal;
                                        break;
                                    case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                                        $cprefix = $signal;
                                        break;
                                    case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                                        $csuffix = $signal;
                                        break;
                                    case $flags['usesignal'] == '(':
                                    case $locale["{$letter}_sign_posn"] == 0:
                                        $prefix = '(';
                                        $suffix = ')';
                                        break;
                                }
                                if (!$flags['nosimbol']) {
                                    $currency = $cprefix .
                                        ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                                        $csuffix;
                                } else {
                                    $currency = '';
                                }
                                $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

                                $value = number_format($value, $right, $locale['mon_decimal_point'],
                                    $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
                                $value = @explode($locale['mon_decimal_point'], $value);

                                $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
                                if ($left > 0 && $left > $n) {
                                    $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
                                }
                                $value = implode($locale['mon_decimal_point'], $value);
                                if ($locale["{$letter}_cs_precedes"]) {
                                    $value = $prefix . $currency . $space . $value . $suffix;
                                } else {
                                    $value = $prefix . $value . $space . $currency . $suffix;
                                }
                                if ($width > 0) {
                                    $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                                        STR_PAD_RIGHT : STR_PAD_LEFT);
                                }

                                $format = str_replace($fmatch[0], $value, $format);
                            }
                            return $format;
                        }

                        function perc($num) {
                            return number_format($num,1)." %";
                        }
                        ?>
                        <script type="text/javascript">
                            initTableWidget('myTable','100%','100%',Array('S','S','N','N'));
                        </script>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div id="rightdiv">


        <div class="contact_div">
            <h3>Contact Information</h3>

            <?php if($vote_smart_addresses): ?>
						
                <?php foreach($vote_smart_addresses as $address) : ?>
                    <?php
					if (isset($address->address->type)){
						echo '<strong>'.$address->address->type.'</strong><br>'.$address->address->street.'<br>';
						echo $address->address->city.', '.$address->address->state.' '.$address->address->zip.'<br>';
                    if(strlen($address->phone->phone1) > 0) {
                        echo $address->phone->phone1.'<br>';
                    }
                    if(strlen($address->phone->phone2) > 0) {
                        echo $address->phone->phone2.'<br>';
                    }
                    if(strlen($address->phone->fax1) > 0) {
                        echo $address->phone->fax1.'(Fax)<br>';
                    }
                    if(strlen($address->phone->fax2) > 0) {
                        echo $address->phone->fax2.' (Fax)<br>';
                    }
                    if(strlen($address->phone->ttyd) > 0) {
                        echo $address->phone->ttyd.' (ttyd)<br>';
                    }
						echo '<br>';
					}
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if($vote_smart_webaddresses): ?>

                <?php foreach($vote_smart_webaddresses as $e_address) : ?>

                    <?php if($e_address->webAddressType == 'Email') {
                        echo '<strong>'.$e_address->webAddressType.'</strong><br>'.'<a href="mailto:'.$e_address->webAddress.'">'.$e_address->webAddress.'</a><br><br>';
                    }elseif($e_address->webAddressType == 'Website') {
                        if(strrpos($e_address->webAddress,"legislature")) {
                            echo '<strong>'.$e_address->webAddressType.'</strong><br>'.'<a href="'.$e_address->webAddress.'">State website</a><br><br>';
                        }
                        else {

                            echo '<strong>'.$e_address->webAddressType.'</strong><br>'.'<a href="'.$e_address->webAddress.'">'.$e_address->webAddress.'</a><br><br>';
                        }
                    }
                    ?>


                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <br/>

        <?php if($member->wikipedia_id): ?>
        <div class="wikipedia_div">
            <h3>Wikipedia</h3>

            Check out my <a href="http://en.wikipedia.org/wiki/<?php echo $member->wikipedia_id; ?>">wikipedia</a> page.

        </div><br/>

        <?php endif; ?>
        <div class="rss_div">
            <h3>Subscribe</h3>

            Follow the status of bills introduced by this legislator by subscribing to this RSS feed.<br>

            <a href="<?php echo base_url().INDEX_TO_INCLUDE.'rss/follow_legislator/'.$member->id; ?>"><img src="<?php echo base_url().'img/rss-icon.png'; ?>" border="0" /></a>&nbsp;Subscribe

        </div>
        <br/>
        <div class="mistakes_div">
            <h3>Mistakes and Corrections?</h3>

            Help us ensure that the information on OpenBama.org is correct.  Let us know about missing or incorrect information so that we may <a href="mailto:contact@openbama.org">correct</a> it.

        </div>

    </div>
</div>