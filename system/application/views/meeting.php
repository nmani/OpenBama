
<div id="content">
    <hr>
    <h2>Meeting Detail for Committee <?php echo $meeting->committee_name; ?></h2>
    <p>
        <strong>Location:</strong><?php echo $meeting->meeting_location; ?><br>
        <strong>Date:</strong><?php echo date("m/d/Y",strtotime($meeting->meeting_date)); ?><br>
        <strong>Time:</strong><?php echo $meeting->meeting_time; ?>
    </p>
    <h3>Bills To Be Discussed</h3>
    <p>
        <?php if ($bills) {
            foreach($bills as $bill) {
                echo '<a href="'.base_url().'index.php/bill/display/'.$bill->bill_id.'">'.strtoupper($bill->label).'</a><br>';

            }
        }else {
            echo '<p><br><br>No bills on roster.<br><br></p>';
        }
        ?>
    </p>
</div>