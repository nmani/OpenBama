<script language="javascript" type="text/javascript">
    function filterList(option_selected){


        if (option_selected == 'All'){

            window.location = "<?php echo base_url().INDEX_TO_INCLUDE.'bill/all?sort=intro&per_page=0'; ?>";
        }else if(option_selected == 'House'){
            window.location = "<?php echo base_url().INDEX_TO_INCLUDE.'bill/house?sort=intro&per_page=0'; ?>";
        }
        else if(option_selected == 'Senate'){
            window.location = "<?php echo base_url().INDEX_TO_INCLUDE.'bill/senate?sort=intro&per_page=0'; ?>";
        }
        else if(option_selected == 'Bills Only'){
            window.location = "<?php echo base_url().INDEX_TO_INCLUDE.'bill/bills?sort=intro&per_page=0'; ?>";
        }else if(option_selected == 'Resolutions Only'){
            window.location = "<?php echo base_url().INDEX_TO_INCLUDE.'bill/resolutions?sort=intro&per_page=0'; ?>";
        }
    }
</script>
<script language="javascript" type="text/javascript">

    $(document).ready(function(){

        get_most_viewed_bill_part('most_viewed_bill_div');
        get_most_popular_bill_part('most_popular_bill_div');

    });
</script>

<div id="content">
    <div id="leftdiv">
        <hr>
        <h2>Bills (<?php if ($bills) {echo $row_count;} ?>)</h2>

        
                <form name="filter_dropdown_form">
                    <strong>Filter by:</strong><select name="bills_filter_drop_down" onchange="filterList(filter_dropdown_form.bills_filter_drop_down.options[selectedIndex].value);">

                        <?php if ($this->uri->segment(2) == 'all'): ?>
                        <option selected>All</option>
                        <option>House</option>
                        <option>Senate</option>
                        <option>Bills Only</option>
                        <option>Resolutions Only</option>
                        <?php elseif($this->uri->segment(2) == 'house'): ?>
                        <option>All</option>
                        <option selected>House</option>
                        <option>Senate</option>
                        <option>Bills Only</option>
                        <option>Resolutions Only</option>
                        <?php elseif($this->uri->segment(2) == 'senate'): ?>
                        <option>All</option>
                        <option>House</option>
                        <option selected>Senate</option>
                        <option>Bills Only</option>
                        <option>Resolutions Only</option>
                        <?php elseif($this->uri->segment(2) == 'bills'): ?>
                        <option>All</option>
                        <option>House</option>
                        <option>Senate</option>
                        <option selected>Bills Only</option>
                        <option>Resolutions Only</option>
                        <?php elseif($this->uri->segment(2) == 'resolutions'): ?>
                        <option>All</option>
                        <option>House</option>
                        <option>Senate</option>
                        <option>Bills Only</option>
                        <option selected>Resolutions Only</option>
                        <?php endif; ?>

                    </select>
                </form>
                
                <strong>Sort by:</strong>
                <a href="<?php echo base_url().INDEX_TO_INCLUDE.'bill/'.$this->uri->segment(2).'?sort=intro&per_page=0'; ?>">Introduced</a>
                <a href="<?php echo base_url().INDEX_TO_INCLUDE.'bill/'.$this->uri->segment(2).'?sort=recent&per_page=0'; ?>">Recent Activity</a>
                <a href="<?php echo base_url().INDEX_TO_INCLUDE.'bill/'.$this->uri->segment(2).'?sort=viewed&per_page=0'; ?>">Most Viewed</a>
                <a href="<?php echo base_url().INDEX_TO_INCLUDE.'bill/'.$this->uri->segment(2).'?sort=popular&per_page=0'; ?>">Popular</a>
                <a href="<?php echo base_url().INDEX_TO_INCLUDE.'bill/'.$this->uri->segment(2).'?sort=most&per_page=0'; ?>">Most Sponsors</a>

        <br/>
        <br/>
        <p><?php echo $links;?></p>
        <?php $this->load->view('bills_view'); ?>
        <p><?php echo $links;?></p>
        
    </div>
    <div id="rightdiv">

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
        <div class="mistakes_div">
            <?php $this->load->view('page_parts/mistakes_corrections'); ?>
        </div>

    </div>
</div>