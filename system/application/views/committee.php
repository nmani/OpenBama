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
    .section-3 #menu li#nav-3 a {
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
    <div id="leftdiv">
        <div>
            <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=381c3502-600d-4f37-b237-c6b7ff990f48&amp;type=website"></script>
        </div>
        <hr>
        <?php if ($committee) {
            if ($committee->subcommittee_name) {
                echo '<h2>'.$committee->committee_name.' ('.$committee->subcommittee_name.')</h2>';
            }else {
                echo '<h2>'.$committee->committee_name.'</h2>';
            }

        }
        ?>
        <div style="position: relative;">

            <div id="menu_div" class="section-1">
                <ul id="menu">
                    <li id="nav-1"><a href="#" onclick="display_tab('section-1');return false;">Subcommittees</a></li>
                    <li id="nav-2"><a href="#" onclick="display_tab('section-2');return false;">Members</a></li>
                    <li id="nav-3"><a href="#" onclick="display_tab('section-3');return false;">Bills</a></li>

                </ul>
            </div>

        </div>
        <div id="menu-content">
            <div style="margin-top: 30px;">

                <div id="section-1" style="display: block;">
                    <?php if($subcommittees): ?>
                        <?php foreach($subcommittees as $subcommittee) : ?>
                            <?php echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/display/'.$subcommittee->id.'">'.$subcommittee->subcommittee_name.'</a><br>'; ?>

                        <?php endforeach; ?>
                    <?php else: ?>
                    No subcommittees
                    <?php endif; ?>


                </div>
                <div id="section-2" style="display: none;">

                    <?php if($members): ?>
                        <?php foreach($members as $member) : ?>
                            <?php echo '<a href="'.base_url().INDEX_TO_INCLUDE.'person/display/'.$member->person_id.'">'.$member->full_name;
                            echo '['.$member->party.', '.$member->district.']'.'</a> ('.$member->role.')<br>'; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>
                <div id="section-3" style="display: none;">
                    <?php $this->load->view('bills_view'); ?>
                </div>

            </div>
        </div>
    </div>
    <div id="rightdiv">
        <div class="about_div">
            <?php $this->load->view('page_parts/about_openbama'); ?>
        </div>
        <br/>
        <div class="take_action_div">
            <h3>Take Action</h3>

            <?php echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/contact_sheet/'.$committee->id.'" target="_blank">Contact sheet</a>'; ?>
            <br>
            <?php
            if($contact_info) {

                $first = true;

                foreach($contact_info as $contact) {
                    if($first) {
                        echo '<a href="mailto:'.$contact->web_address;
                        $first = false;

                    }else {
                        echo ','.$contact->web_address;

                    }

                }

                echo '">Email committee members</a>';

            }
            ?>

        </div>
        <br/>
        <?php if ($committee_meetings): ?>
        <div class="meetings_div">
            <h3>Committee Meetings</h3>

                <?php
                foreach($committee_meetings as $meeting) {


                    echo '<strong>Location:</strong>'.$meeting->meeting_location.'<br>';
                    echo '<strong>Date:</strong>'.date("m/d/Y",strtotime($meeting->meeting_date)).'<br>';
                    echo '<strong>Time:</strong>'.$meeting->meeting_time.'<br>';
                    echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/meeting/'.$meeting->id.'">View Details >></a><br><br>';

                }

                ?>


        </div>
        <br/>
        <?php endif; ?>
        <div class="rss_div">
            <?php $this->load->view('rss_feeds_side_view'); ?>
        </div>

    </div>
</div>