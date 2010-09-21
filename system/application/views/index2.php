<script language="javascript" type="text/javascript">

    $(document).ready(function(){

        get_most_viewed_bill_part('most_viewed_bill_div');
        get_most_popular_bill_part('most_popular_bill_div');
        get_most_popular_senator_part('most_popular_senator_div');
        get_most_popular_representative_part('most_popular_representative_div');
        get_most_viewed_issue_part('most_viewed_issue_div');

    });
</script>
<script type="text/javascript">
    $(function() {
        $("#datepickerBegin").datepicker();
        $("#datepickerEnd").datepicker();
    });
</script>

<input id="currently_displayed" type="hidden" value="section-1" />
<div id="content">
    <div id="leftdiv">
        <div>
            <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=381c3502-600d-4f37-b237-c6b7ff990f48&amp;type=website">
            </script>
        </div>
        <hr>
        <div class="ui-widget">
            <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
                <p>
                    <span class="ui-icon ui-icon-lightbulb" style="float: left; margin-right: .3em;"></span>
                    <strong>Ideas!</strong>
                    Now that the 2010 session of the Alabama Legislature has officially ended, it's time to begin looking forward to the next session.  The vision for OpenBama.org is to provide a platform for the citizens of Alabama to peer into and influence the political process in Montgomery.  Let's make OpenBama.org even better to accomplish this goal.  Do you have ideas for the site? If you have ideas that will bring more information to the fingertips of Alabamians, please drop a line to <a href="mailto:contact@openbama.org">contact@openbama.org</a>. 
                </p>
            </div>
        </div>
        <div style="width:100%;height:400px;background: url(<?php echo base_url().'img/alabama_seal.png'; ?>) no-repeat center center;">
            <h2>Welcome to OpenBama.org</h2>
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


            <div class="tabber">
                <div class="tabbertab">
                    <h3>Issue</h3>
                    <?php echo form_open('search/subject'); ?>
                    <div>
                        <?php echo form_dropdown('subjects_list', $subjectsArray,set_value('subjects_list')); ?>
                        <input class="standard_button" style="width: 100px;" type="submit" name="searchSubjectBTN" id="searchSubjectBTN" value="Go!" />
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="tabbertab" title="Sponsor">
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
                        <input type="submit" style="width: 100px;" name="searchSponsorInput" id="searchSponsorBTN" value="Go!" class="standard_button" />
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="tabbertab" title="Current Status">
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
                    <input type="submit" name="searchStatusInput" id="searchStatusInput" style="width: 100px;" value="Go!" class="standard_button" />
                    <?php echo form_close(); ?>
                </div>
                <div class="tabbertab" title="Date">
                    <table width="100%">
                        <tr>
                            <td valign="top" align="center">
                                <?php echo form_open('search/date'); ?>
                                <?php echo form_dropdown('dateTypeDD',$dateSearchTypeArray,set_value('dateTypeDD')); ?>
                                <br>
                                Begin Date:
                                <br>
                                <input type="text" class="datepicker" id="datepickerBegin" name="datepickerBegin" readonly="true">
                                <br>
                                End Date:
                                <br>
                                <input type="text" class="datepicker" id="datepickerEnd" name="datepickerEnd" readonly="true">
                                <div>
                                    <br/>
                                    <input type="submit" class="standard_button" style="width: 100px;" name="searchDateBTN" value="Go!" />
                                </div>
                                <?php echo form_close(); ?>
                            </td>
                            <td valign="middle" align="center">
                                <strong>Or</strong>
                            </td>
                            <td valign="top" align="center">
                                <label>
                                    Select a date:
                                </label>
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
                                    <input type="submit" style="width: 100px;" class="standard_button" name="search_action_date_btn" value="Go!" />
                                </div>
                                <?php
                                echo form_close();

                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="tabbertab" title="Bill #">
                    <div id="numberSearchDiv">
                        <?php echo form_open('search/number'); ?>
                        <input type="text" name="bill_number" value="" /><input type="submit" style="width: 100px;" value="Go" name="search_bill_number_btn" class="standard_button" />
                        <?php echo form_close(); ?>
                    </div>
                    <div>
                        <i>Example: hb1</i>
                    </div>
                </div>
                <div class="tabbertab" title="Tag Cloud">
                    <a href="http://en.wikipedia.org/wiki/Tag_cloud">What is a tag cloud?</a>
                    <br>
                    <br>
                    <?php
                    //                $myArray = array (
                    //                    array(10, 'PHP', 'http://php.com'),
                    //                    array(32, 'MySQL', 'http://mysql.com'),
                    //                    array(5, 'CodeIgniter', 'http://codeigniter.com')
                    //                );

                    if($bill_tag_cloud) {
                        foreach($bill_tag_cloud as $tag) {

                            $myArray[] = array($tag->tag_count,$tag->tag_name,base_url().INDEX_TO_INCLUDE.'tagcloud/display/'.$tag->id);

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


    <div id="rightdiv">
        <div class="about_div">
            <?php $this->load->view('page_parts/about_openbama'); ?>
        </div>
        <br/>
        <div class="most_viewed_div">
            <div id="most_viewed_bill_div" class="ajax_spinner">
            </div>
        </div>
        <br/>
        <div class="most_popular_div">
            <div id="most_popular_bill_div" class="ajax_spinner">
            </div>
        </div>
        <br/>
        <div class="most_popular_div">
            <div id="most_popular_senator_div" class="ajax_spinner">
            </div>
        </div>
        <br/>
        <div class="most_popular_div">
            <div id="most_popular_representative_div" class="ajax_spinner">
            </div>
        </div>
        <br/>
        <div class="most_viewed_div">
            <div id="most_viewed_issue_div" class="ajax_spinner">
            </div>
        </div>
        <br/>
        <div class="find_legislator_div">
            <?php $this->load->view('page_parts/find_your_legislator'); ?>
        </div>
        <br/>
        <div class="rss_div">
            <?php $this->load->view('rss_feeds_side_view'); ?>
        </div>
        <br/>
    </div>
</div>
