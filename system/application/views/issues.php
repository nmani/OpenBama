<script language="javascript" type="text/javascript">

    $(document).ready(function(){

        get_most_viewed_issue_part('most_viewed_issue_div');

    });
</script>
<div id="content">
    <div id="leftdiv">
        <hr>
        <h2>Issues</h2>

        <strong>Sort by:</strong>
        <a href="<?php echo base_url().'index.php/issue/index'; ?>">Name</a>
        <a href="<?php echo base_url().'index.php/issue/viewed'; ?>">Most Viewed</a>
        <a href="<?php echo base_url().'index.php/issue/bills'; ?>">Most Bills</a>
        <br/>
        <br/>
        <?php if($issues): ?>
            <?php foreach($issues as $issue) : ?>


                <?php

                echo '<a href="'.base_url().'index.php/issue/display/'.$issue->id.'">'.$issue->subject.'</a> ('.$issue->bill_count.' bills)('.$issue->page_views.' view(s))<br>';

                ?>

            <?php endforeach; ?>
        <?php else: ?>

        None to display

        <?php endif; ?>

    </div>
    <div id="rightdiv">


        <div class="most_viewed_div">
            <div id="most_viewed_issue_div" class="ajax_spinner">
            </div>
        </div>
        <br>
        <div class="mistakes_div">
            <?php $this->load->view('page_parts/mistakes_corrections'); ?>
        </div>
    </div>
</div>