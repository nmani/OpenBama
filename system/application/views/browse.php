<input id="currently_displayed" type="hidden" value="section-1" />
<script type="text/javascript">
    $(function() {
        $("#datepickerBegin").datepicker();
        $("#datepickerEnd").datepicker();
    });
</script>

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
    .section-4 #menu li#nav-4 a,
    .section-5 #menu li#nav-5 av{
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
<div id="content">
    <hr>
    <h2>Browse Bills</h2>
    <?php

    if(count($subjects) > 0) {

        $subjectsArray = array('0' => '-- Select an issue --');

        foreach($subjects as $row) {
            $subjectsArray[$row->id] = $row->subject;
        }
    }

    $dateSearchTypeArray = array('0' => '-- Select Date Type --',
        'intro' => 'Introduced Date',
        'enact' => 'Enacted Date',
        'lastAction' => 'Last Action Date',
        'lastVote' => 'Last Vote Date',
        'sponsor' => 'Date Sponsor Added'
    );

    $sponsorSearchOptions = array ('id' => 'searchDateBTN');

    ?>

    <div style="position: relative;">

        <div id="menu_div" class="section-1">
            <ul id="menu">
                <li id="nav-1"><a href="#" onclick="display_tab('section-1');return false;">Issue</a></li>
                <li id="nav-2"><a href="#" onclick="display_tab('section-2');return false;">Sponsor/Cosponsor</a></li>
                <li id="nav-3"><a href="#" onclick="display_tab('section-3');return false;">Status</a></li>
                <li id="nav-4"><a href="#" onclick="display_tab('section-4');return false;">Date</a></li>
                <li id="nav-5"><a href="#" onclick="display_tab('section-5');return false;">Bill Number</a></li>

            </ul>
        </div>

    </div>

    <div id="menu-content">
        <div style="margin-top: 30px;">
            <div id="section-1" style="display: block;">


                <?php echo form_open('search/subject'); ?>

                <div>
                    <?php echo form_dropdown('subjects_list', $subjectsArray,set_value('subjects_list')); ?>
                </div>
                <div>
                    <input class="ob_button" type="submit" name="searchSubjectBTN" id="searchSubjectBTN" value="Go!"  />
                </div>
                <?php echo form_close(); ?>



            </div>
            <div id="section-2" style="display: none;">
                <div id="sponsor_search_div">
                    <?php echo form_open('search/sponsors'); ?>
                    <div>
                        <select id="sponsorTypeDD" name="sponsorTypeDD" onchange="toggle('sponsor_location_div');return false;">
                            <option value="0">-- Select Sponsor Type --</option>
                            <option value="S">Sponsor</option>
                            <option value="C">Co-Sponsor</option>
                        </select>
                    </div>
                    <div id="sponsor_location_div" style="display:none">
                        <select name="locationDD" onchange="xajax_populate_sponsors_onchange(this[this.selectedIndex].value);">
                            <option value="0">-- Select House --</option>
                            <option value="H">House of Representatives</option>
                            <option value="S">Senate</option>

                        </select>
                    </div>

                    <div id="sponsorsListDiv">

                    </div>
                    <div id="sponsor_submit_div" style="display:none">
                        <input type="submit" name="searchSponsorInput" id="searchSponsorBTN" value="Go!" class="ob_button" />
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
            <div id="section-3" style="display: none;">
                <div id="statusSearchDiv">
                    <?php echo form_open('search/status'); ?>
                    <select id="status_dropdownlist" name="status_dropdownlist">
                        <option value="0">-- Select a status --</option>
                        <option value="introduced">Introduced</option>
                        <option value="vote">Vote in house of orgin</option>
                        <option value="vote2">Vote in second house</option>
                        <option value="togovernor">Sent to Governor</option>
                        <option value="veto">Vetoed</option>
                        <option value="override">Override</option>
                        <option value="enacted">Enacted</option>
                    </select>
                    <input type="submit" name="searchStatusInput" id="searchStatusInput" value="Go!" class="ob_button" />
                    <?php echo form_close(); ?>

                </div>
            </div>
            <div id="section-4" style="display: none;">

                <div id="dateSearchDiv">
                    <?php echo form_open('search/date'); ?>
                    <?php echo form_dropdown('dateTypeDD',$dateSearchTypeArray,set_value('dateTypeDD')); ?>
                    <br>
                    Begin Date: <br><input type="text" id="datepickerBegin" name="datepickerBegin" readonly="true">
                    <br>
                    End Date: <br><input type="text" id="datepickerEnd" name="datepickerEnd" readonly="true">
                    <div>

                        <input type="submit" class="ob_button" name="searchDateBTN" value="Go!" />
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
            <div id="section-5" style="display: none;">

                <div id="numberSearchDiv">
                    <?php echo form_open('search/number'); ?>
                    <input type="text" name="bill_number" value="" />
                    <input type="submit" value="Go" name="search_bill_number_btn" class="ob_button" />
                    <?php echo form_close(); ?>
                </div>
                <div><i>Example: hb1</i></div>
            </div>

        </div>
    </div>

</div>
<div id="sidebar">
    <div class="box">

        <h3>
            About OpenBama.org
        </h3>
        <p>
            OpenBama.org is a website designed to be used by the public to track and research the legislation the Alabama Legislature is considering to become law. To learn more about OpenBama.org and how it works please click <a href="<?php echo base_url().INDEX_TO_INCLUDE.'about/index'; ?>">here</a>.
        </p>
        <?php $this->load->view('rss_feeds_side_view'); ?>
    </div>
</div>