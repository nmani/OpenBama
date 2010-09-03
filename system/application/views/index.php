<?php
$senator_image_file_name = MEMBER_IMAGE_LOCATION.$popular_senator->id.'.jpg';
if(!file_exists($senator_image_file_name)) {
	$senator_image_file_name = base_url().'img/members/image_not_avail.gif';
}else {
	$senator_image_file_name = base_url().'img/members/'.$popular_senator->id.'.jpg';
}

$representative_image_file_name = MEMBER_IMAGE_LOCATION.$popular_representative->id.'.jpg';
if(!file_exists($representative_image_file_name)) {
	$representative_image_file_name = base_url().'img/members/image_not_avail.gif';
}else {
	$representative_image_file_name = base_url().'img/members/'.$popular_representative->id.'.jpg';
}
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
    .section-4 #menu li#nav-4 a,
    .section-5 #menu li#nav-5 a,
    .section-6 #menu li#nav-6 a {
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
    <div>
        <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=381c3502-600d-4f37-b237-c6b7ff990f48&amp;type=website"></script>
    </div>
    <hr>
    <div class="ui-widget">
        <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
            <p><span class="ui-icon ui-icon-lightbulb" style="float: left; margin-right: .3em;"></span>
                <strong>Ideas!</strong> Now that the 2010 session of the Alabama Legislature has officially ended, it's time to begin looking forward to the next session.  The vision for OpenBama.org is to provide a platform for the citizens of Alabama to peer into and influence the political process in Montgomery.  Let's make OpenBama.org even better to accomplish this goal.  Do you have ideas for the site? If you have ideas that will bring more information to the fingertips of Alabamians, please drop a line to <a href="mailto:contact@openbama.org">contact@openbama.org</a>. </p>
        </div>
    </div>
    <h2>
        Welcome to OpenBama.org</h2>
    <p>
        The 2010 Alabama Legislative session convened on January 12. Here you can learn about and track the more than a thousand bills and resolutions that are proposed, voted on, and possibly become law.
    </p>

    <h2>Browse Bills</h2>
    <?php

    if(count($subjects) > 0) {

    	$subjectsArray = array('0' => '-- Select an issue --');

    	foreach($subjects as $row) {
    		$subjectsArray[$row->id] = $row->subject;
    	}
    }

    $dateSearchTypeArray = array('0' => '-- Select Date Search Type --',
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
                <li id="nav-2"><a href="#" onclick="display_tab('section-2');return false;">Sponsor</a></li>
                <li id="nav-3"><a href="#" onclick="display_tab('section-3');return false;">Status</a></li>
                <li id="nav-4"><a href="#" onclick="display_tab('section-4');return false;">Date</a></li>
                <li id="nav-5"><a href="#" onclick="display_tab('section-5');return false;">Bill #</a></li>
                <li id="nav-6"><a href="#" onclick="display_tab('section-6');return false;">Tag Cloud</a></li>

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
                        <select id="sponsorTypeDD" name="sponsorTypeDD" onchange="open_bama_toggle('sponsor_location_div');return false;">
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
                    <table width="100%"><tr><td valign="top" align="center">
                                <?php echo form_open('search/date'); ?>
                                <?php echo form_dropdown('dateTypeDD',$dateSearchTypeArray,set_value('dateTypeDD')); ?>
                                <br>
                                Begin Date: <br><input type="text" class="datepicker" id="datepickerBegin" name="datepickerBegin" readonly="true">

                                <br>
                                End Date: <br><input type="text" class="datepicker" id="datepickerEnd" name="datepickerEnd" readonly="true">
                                <div>
                                    <br/>
                                    <input type="submit" class="ob_button" name="searchDateBTN" value="Go!" />
                                </div>
                                <?php echo form_close(); ?>
                            </td><td valign="middle" align="center"><strong>Or</strong></td><td valign="top" align="center">
							<label>Select a date:</label>
                                <?php
                                echo form_open('search/action_date');

                                echo '<select name="action_date_list">';
                                foreach($action_dates as $a_date) {
                                	echo '<option value="'.date("m-d-Y",strtotime($a_date->action_date)).'">'.date("m/d/Y",strtotime($a_date->action_date)).'</option>';

                                }
                                echo '</select>';
                                ?>
                                <div>
                                    <br/>
                                    <input type="submit" class="ob_button" name="search_action_date_btn" value="Go!" />
                                </div>
                                <?php
                                echo form_close();

                                ?>
                            </td></tr></table>

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
            <div id="section-6" style="display: none;">
                <a href="http://en.wikipedia.org/wiki/Tag_cloud">What is a tag cloud?</a><br><br>
                <?php
                //                $myArray = array (
                //                    array(10, 'PHP', 'http://php.com'),
                //                    array(32, 'MySQL', 'http://mysql.com'),
                //                    array(5, 'CodeIgniter', 'http://codeigniter.com')
                //                );

                if($bill_tag_cloud) {
                	foreach($bill_tag_cloud as $tag) {

                		$myArray[] = array($tag->tag_count,$tag->tag_name,base_url().'index.php/tagcloud/display/'.$tag->id);

                	}
                	$configArray = array (
                		'min_font' => 9,
                		'max_font' => 40,
                		'shuffle' => TRUE,
                		'class' => 'my_css_class',
                		'match_Class' => 'bold',
                		);
                	echo $this->taggly->cloud($myArray,$configArray);
                }else {
                	echo 'No tags added yet';
                }



                ?>

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
            OpenBama.org is a website designed to be used by the public to track and research the legislation the Alabama Legislature is considering to become law. To learn more about OpenBama.org and how it works please click <a href="<?php echo base_url().'index.php/about/index'; ?>">here</a>.
            <br>
            <br>
        <div style="text-align:center">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="SXGUK6S6GF5AU">
                <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
        </p>
        <?php if ($most_viewed_bill): ?>
	<h3>
	Most Viewed Bill
	</h3>
	<p>
            <a href="<?php echo base_url().'index.php/bill/display/'.$most_viewed_bill->id; ?>"><u><?php echo strtoupper($most_viewed_bill->bill_type).$most_viewed_bill->number; ?>
                    - Subject: <?php echo $most_viewed_bill->subject; ?></u></a> &nbsp;(<?php echo $most_viewed_bill->page_view_count; ?> views)
<br>
                <?php echo $most_viewed_bill->description; ?>
</p>
        <?php endif; ?>
        <div id="most_popular_help_div" class="tip">Popularity is based on a combination of unique views, the number of user votes,number of legislative actions (for bills only), user comments, and the number of sponsors (for bills only).</div>


        <h3>Most Popular Bill <a href="#" onmouseout="popUp(event,'most_popular_help_div')" onmouseover="popUp(event,'most_popular_help_div')" onclick="return false"><img border="0" src="<?php echo base_url().'img/questionmark.png'; ?>" width="15" height="15" /></a></h3>
        <p>

            <a href="<?php echo base_url().'index.php/bill/display/'.$popular_bill->id; ?>"><u><?php echo strtoupper($popular_bill->bill_type).$popular_bill->number; ?>
                    - Subject: <?php echo $popular_bill->subject; ?></u></a>
            <br>
            <?php echo $popular_bill->description; ?>
        </p>
        <h3>Most Popular Senator <a href="#" onmouseout="popUp(event,'most_popular_help_div')" onmouseover="popUp(event,'most_popular_help_div')" onclick="return false"><img border="0" src="<?php echo base_url().'img/questionmark.png'; ?>" width="15" height="15" /></a></h3>
        <p>
            <?php echo '<center><img src="'.$senator_image_file_name.'" width="69" height="100" title="'.$popular_senator->full_name.'" alt="'.$popular_senator->full_name.'" /><br>'; ?>
            <a href="<?php echo base_url().'index.php/person/display/'.$popular_senator->id; ?>"><u><?php echo $popular_senator->full_name;?>
                <?php echo '['.substr($popular_senator->party,0,1).', '.$popular_senator->district.']'; ?></u></a></center>
        </p>
        <h3>Most Popular Representative <a href="#" onmouseout="popUp(event,'most_popular_help_div')" onmouseover="popUp(event,'most_popular_help_div')" onclick="return false"><img border="0" src="<?php echo base_url().'img/questionmark.png'; ?>" width="15" height="15" /></a></h3>
        <p>
            <?php echo '<center><img src="'.$representative_image_file_name.'" width="69" height="100" title="'.$popular_representative->full_name.'" alt="'.$popular_representative->full_name.'" /><br>'; ?>
            <a href="<?php echo base_url().'index.php/person/display/'.$popular_representative->id; ?>"><u><?php echo $popular_representative->full_name;?>
                <?php echo '['.substr($popular_representative->party,0,1).', '.$popular_representative->district.']'; ?></u></a></center>
        </p>
        <h3>Most Viewed Issue (last 7 days)</h3>
        <p>
		<?php if($most_viewed_issue): ?>
            <a href="<?php echo base_url().'index.php/issue/display/'.$most_viewed_issue->id; ?>"><u><?php echo $most_viewed_issue->subject; ?></u></a> &nbsp;(<?php echo $most_viewed_issue->page_view_count; ?> views)
			<?php else: ?>
			None
			<?php endif; ?>
        </p>

        <?php $this->load->view('page_parts/find_your_legislator'); ?>

        <?php $this->load->view('rss_feeds_side_view'); ?>

    </div>
</div>