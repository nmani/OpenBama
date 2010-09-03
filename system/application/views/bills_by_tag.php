<div id="content">
    <div id="leftdiv">
        <hr>

        <h2><?php echo $heading; ?>
            <?php if($bills) {
                echo '&nbsp;(Total results:&nbsp;'.count($bills).')';
            }else {
                echo '&nbsp;(Total results:&nbsp;0)';
            }
            ?>
        </h2>

        <?php $this->load->view('bills_view'); ?>
    </div>
    <div id="rightdiv">

        <div class="about_div">
            <?php $this->load->view('page_parts/about_openbama'); ?>
        </div>
        <br/>
        <div class="rss_div">
            <?php $this->load->view('rss_feeds_side_view'); ?>
        </div>

    </div>
</div>