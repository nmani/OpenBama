
<div id="content">
    <div id="leftdiv">
        <hr>
        <h2>Committees</h2>
        <div style="float:left;">
        <strong>Sort by:</strong><a href="<?php echo base_url().INDEX_TO_INCLUDE.'committee/name'; ?>">Name</a>
        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'committee/viewed'; ?>">Most Viewed</a>
        </div>
        <br/>
        <br/>
        <?php $this->load->view('page_parts/committees_list'); ?>

    </div>

    <div id="rightdiv">


        <?php if ($most_viewed_committee): ?>
        <div class="most_viewed_div">
            <h3>
                Most Viewed Committee
            </h3>

            <a href="<?php echo base_url().INDEX_TO_INCLUDE.'committee/display/'.$most_viewed_committee->id; ?>"><u>
                        <?php echo $most_viewed_committee->committee_name.' ';
                        if ($most_viewed_committee->subcommittee_name) {
                            echo '('.$most_viewed_committee.subcommittee_name.')';
                        }

                        ?></u></a> &nbsp;(<?php echo $most_viewed_committee->page_view_count; ?> views)


        </div>
        <br/>
        <?php endif; ?>
        <div class="meetings_div">
            <h3>Committee Meetings</h3>

            <a href="#" onclick="toggle_visibility('committee_meetings_div');toggle_text(this,'Show meetings >>','<< Hide meetings');return false;">Show meetings >></a>
            <div id="committee_meetings_div" style="display:none;">
                <strong><u>House</u></strong><br><br>
                <?php if ($committee_meetings_house): ?>




                    <?php
                    foreach($committee_meetings_house as $meeting) {

                        echo '<strong>'.$meeting->committee_name.'</strong><br>';
                        echo '<strong>Location:</strong>'.$meeting->meeting_location.'<br>';
                        echo '<strong>Date:</strong>'.date("m/d/Y",strtotime($meeting->meeting_date)).'<br>';
                        echo '<strong>Time:</strong>'.$meeting->meeting_time.'<br>';
                        echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/meeting/'.$meeting->id.'">View Details >></a><br><br>';

                    }

                    ?>


                <?php endif; ?>

                <strong><u>Senate</u></strong><br><br>
                <?php if ($committee_meetings_senate): ?>




                    <?php
                    foreach($committee_meetings_senate as $meeting) {

                        echo '<strong>'.$meeting->committee_name.'</strong><br>';
                        echo '<strong>Location:</strong>'.$meeting->meeting_location.'<br>';
                        echo '<strong>Date:</strong>'.date("m/d/Y",strtotime($meeting->meeting_date)).'<br>';
                        echo '<strong>Time:</strong>'.$meeting->meeting_time.'<br>';
                        echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/meeting/'.$meeting->id.'">View Details >></a><br><br>';

                    }

                    ?>


                <?php endif; ?>

            </div>
        </div>
        <br/>
        <div class="mistakes_div">
            <h3>Mistakes and Corrections?</h3>

            Help us ensure that the information on OpenBama.org is correct.  Let us know about missing or incorrect information so that we may <a href="mailto:contact@openbama.org">correct</a> it.

        </div>
    </div>
</div>
