<?php if ($most_viewed_bill): ?>

    <h3>Most Viewed Bill</h3>
    <a href="<?php echo base_url().'index.php/bill/display/'.$most_viewed_bill->id; ?>">
        <u>
            <?php echo strtoupper($most_viewed_bill->bill_type).$most_viewed_bill->number; ?>
            - Subject: 
            <?php echo $most_viewed_bill->subject; ?>
        </u>
    </a>
    &nbsp;(
    <?php echo $most_viewed_bill->page_view_count; ?>
    views)
    <br>
    <?php echo $most_viewed_bill->description; ?>
<?php else: ?>

<?php endif; ?>
