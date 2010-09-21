<h3>Most Viewed Issue (last 7 days)</h3>
    <?php if($most_viewed_issue): ?>
    <a href="<?php echo base_url().INDEX_TO_INCLUDE.'issue/display/'.$most_viewed_issue->id; ?>">
        <u>
            <?php echo $most_viewed_issue->subject; ?>
        </u>
    </a>
    &nbsp;(
    <?php echo $most_viewed_issue->page_view_count; ?>
    views)
    <?php else: ?>
    None
    <?php endif; ?>