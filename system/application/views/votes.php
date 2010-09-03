
<script language="javascript" type="text/javascript">
    function filterList(option_selected){


        if (option_selected == 'All'){

            window.location = "<?php echo base_url().'index.php/vote/all'; ?>";
        }else if(option_selected == 'House'){
            window.location = "<?php echo base_url().'index.php/vote/house'; ?>";
        }
        else if(option_selected == 'Senate'){
            window.location = "<?php echo base_url().'index.php/vote/senate'; ?>";
        }
        else if(option_selected == 'Passed'){
            window.location = "<?php echo base_url().'index.php/vote/pass'; ?>";
        }else if(option_selected == 'Failed'){
            window.location = "<?php echo base_url().'index.php/vote/fail'; ?>";
        }
    }
</script>
<div id="content">
    <div id="leftdiv">
        <hr>
        <h2>Votes</h2>

        <form name="filter_dropdown_form">
            <strong>Filter by:</strong><select name="votes_filter_drop_down" onchange="filterList(filter_dropdown_form.votes_filter_drop_down.options[selectedIndex].value);">

                <?php if ($this->uri->segment(2) == 'all'): ?>
                <option selected>All</option>
                <option>House</option>
                <option>Senate</option>
                <option>Passed</option>
                <option>Failed</option>
                <?php elseif($this->uri->segment(2) == 'house'): ?>
                <option>All</option>
                <option selected>House</option>
                <option>Senate</option>
                <option>Passed</option>
                <option>Failed</option>
                <?php elseif($this->uri->segment(2) == 'senate'): ?>
                <option>All</option>
                <option>House</option>
                <option selected>Senate</option>
                <option>Passed</option>
                <option>Failed</option>
                <?php elseif($this->uri->segment(2) == 'fail'): ?>
                <option>All</option>
                <option>House</option>
                <option>Senate</option>
                <option>Passed</option>
                <option selected>Failed</option>
                <?php elseif($this->uri->segment(2) == 'pass'): ?>
                <option>All</option>
                <option>House</option>
                <option>Senate</option>
                <option selected>Passed</option>
                <option>Failed</option>
                <?php endif; ?>

            </select>
        </form>

        <strong>Sort by:</strong>
        <a href="<?php echo base_url().'index.php/vote/'.$this->uri->segment(2).'/new'; ?>">Newest</a>
        <a href="<?php echo base_url().'index.php/vote/'.$this->uri->segment(2).'/old'; ?>">Oldest</a>
        <a href="<?php echo base_url().'index.php/vote/'.$this->uri->segment(2).'/popular'; ?>">Popular Bills</a>

        <br/>
        <br/>
        <?php $this->load->view('page_parts/vote_list'); ?>
    </div>
    <div id="rightdiv">


        <?php if ($most_viewed_vote): ?>
        <div class="most_viewed_div">
            <h3>
                Most Viewed Vote
            </h3>

            <a href="<?php echo base_url().'index.php/vote/display/'.$most_viewed_vote->id; ?>"><u><?php echo 'Roll Call '.$most_viewed_vote->number.', Bill: '.strtoupper($most_viewed_vote->bill_label); ?></u></a> &nbsp;(<?php echo $most_viewed_vote->page_view_count; ?> views)
            <br>
            <strong>Regarding: </strong><?php echo $most_viewed_vote->action_text; ?>

        </div>
        <br/>
        <?php endif; ?>

        <div class="mistakes_div">
            <h3>Mistakes and Corrections?</h3>

            Help us ensure that the information on OpenBama.org is correct.  Let us know about missing or incorrect information so that we may <a href="mailto:contact@openbama.org">correct</a> it.

        </div>

    </div>
</div>