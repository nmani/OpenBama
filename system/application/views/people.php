<?php
        if (isset($_GET['filter'])) {
            $current_filter = $_GET['filter'];
        }else {
            $current_filter = 'all';
        }
?>
<script language="javascript" type="text/javascript">
    function filterList(option_selected){


        if (option_selected == 'All'){

            window.location = "<?php echo base_url().INDEX_TO_INCLUDE.'person/'.$this->uri->segment('2').'?filter=all'; ?>";
        }else if(option_selected == 'Democrat'){
            window.location = "<?php echo base_url().INDEX_TO_INCLUDE.'person/'.$this->uri->segment('2').'?filter=dem'; ?>";
        }
        else if(option_selected == 'Republican'){
            window.location = "<?php echo base_url().INDEX_TO_INCLUDE.'person/'.$this->uri->segment('2').'?filter=repub'; ?>";
        }
        else if(option_selected == 'Other Party'){
            window.location = "<?php echo base_url().INDEX_TO_INCLUDE.'person/'.$this->uri->segment('2').'?filter=other'; ?>";
        }
    }
</script>
<script language="javascript" type="text/javascript">

    $(document).ready(function(){

<?php if ($this->uri->segment(2) == 'senators'): ?>
        get_most_viewed_senator_part('most_viewed_senator_div');
        //get_senators_part('all_list_div','all','name','0');
        //get_senators_part('dem_list_div','dem','name','0');
<?php else: ?>
        get_most_viewed_representative_part('most_viewed_representative_div');

<?php endif; ?>

    });
</script>

<div id="content">
    <div id="leftdiv">
        <hr>
        <h2><?php if ($this->uri->segment(2) == 'senators') {
                echo 'Senators';
            }else {
                echo 'Representatives';
            }
            ?></h2>
        
           
        <form name="filter_dropdown_form">
            <strong>Filter by:</strong><select name="people_filter_drop_down" onchange="filterList(filter_dropdown_form.people_filter_drop_down.options[selectedIndex].value);">

                <?php if ($current_filter == 'all'): ?>
                <option selected>All</option>
                <option>Democrat</option>
                <option>Republican</option>
                <option>Other Party</option>
                <?php elseif($current_filter == 'dem'): ?>
                <option>All</option>
                <option selected>Democrat</option>
                <option>Republican</option>
                <option>Other Party</option>
                <?php elseif($current_filter == 'repub'): ?>
                <option>All</option>
                <option>Democrat</option>
                <option selected>Republican</option>
                <option>Other Party</option>
                <?php elseif($current_filter == 'other'): ?>
                <option>All</option>
                <option>Democrat</option>
                <option>Republican</option>
                <option selected>Other Party</option>
                <?php endif; ?>

            </select>
        </form>
        
        
        
        <strong>Sort by:</strong>
        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'person/'.$this->uri->segment('2').'?filter='.$current_filter.'&sort=name'; ?>">Name</a>
        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'person/'.$this->uri->segment('2').'?filter='.$current_filter.'&sort=popular'; ?>">Popular</a>
        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'person/'.$this->uri->segment('2').'?filter='.$current_filter.'&sort=district'; ?>">District</a>
        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'person/'.$this->uri->segment('2').'?filter='.$current_filter.'&sort=viewed'; ?>">Most Viewed</a>
        
        
        <br/><br/>
        <?php $this->load->view('page_parts/people_list'); ?>

    </div>

    <div id="rightdiv">

        <?php if ($this->uri->segment(2) == 'senators'): ?>
        <div class="most_viewed_div">
            <div id="most_viewed_senator_div" class="ajax_spinner">
            </div>
        </div>
        <?php else: ?>
        <div class="most_viewed_div">
            <div id="most_viewed_representative_div" class="ajax_spinner">
            </div>
        </div>

        <?php endif; ?>
        <br/>
        <div class="find_legislator_div">
            <?php $this->load->view('page_parts/find_your_legislator'); ?>
        </div>

        <br/>
        <div class="mistakes_div">
            <?php $this->load->view('page_parts/mistakes_corrections'); ?>
        </div>

    </div>
</div>