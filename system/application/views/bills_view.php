<?php if($bills): ?>
    <?php foreach($bills as $row) : ?>

<div style="-moz-border-radius:8px; -webkit-border-radius:8px;background:#fafafa;border: solid 1px #ddd; margin:0; padding:0.8em;">
    <h3>
        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'bill/display/'.$row->id; ?>"><u><?php echo strtoupper($row->bill_type).$row->number; ?>
                - Subject: <?php echo $row->subject; ?></u></a></h3>
    <strong>Sponsor:</strong>&nbsp;<a href="<?php echo base_url().INDEX_TO_INCLUDE.'person/display/'.$row->sponsor_id; ?>"><?php echo $row->sponsor_name.'</a><br>'; ?>
    <p>
        
        <b>Current Status:</b> <?php echo $row->current_alison_status; ?><br><br>
                <?php echo $row->description; ?><br>
        <br>


        <b>Introduced:</b> <?php echo date("M j, Y",strtotime($row->introduced)); ?><br>
                <?php if (strrpos($row->current_alison_status,"Enacted") > -1) {
                    echo '<b>Enacted On: </b>';
                    echo date("M j, Y",strtotime($row->last_action_date));
                }
                else {
                    echo '<b>Last Action On: </b>';
                    echo date("M j, Y",strtotime($row->last_action_date));

                }?>

        <span>
            <table width="100%"><tr><td align="right">[<a href="#">Top</a>]</td></tr></table>
        </span>
    </p>

</div>
<br>
    <?php endforeach; ?>
<?php else: ?>

<p>
    None to display
</p>
    <?php endif; ?>