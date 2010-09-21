<?php if($votes): ?>
<p><?php echo $links;?></p>
    <?php foreach($votes as $vote) : ?>
<div style="-moz-border-radius:8px; -webkit-border-radius:8px;background:#fafafa;border: solid 1px #ddd; margin:0; padding:0.8em">
            <?php
            echo '<table>';
            echo '<tr><td><a href="'.base_url().INDEX_TO_INCLUDE.'vote/display/'.$vote->vote_id.'">'.strtoupper($vote->bill_number).'</a> - '.$vote->action_text.'</td></tr></table>';
            echo '<table><tr style="border-bottom: 1px solid gray;"><td width="50%">';
            echo "<font color='green'>Ayes </font>".$vote->ayes." <font color='red'>Nayes</font> ".$vote->nays.'</td>';
            //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<td width="40%">'.date("M j, Y",strtotime($vote->vote_date)).'</td>';
            echo '<td align="right"><span>
            <table><tr><td width="10%" align="right">[<a href="#">Top</a>]</td></tr></table></td>
        </span></tr>';
            echo '</table>';
            ?>
</div>
<br>
    <?php endforeach; ?>
<p><?php echo $links;?></p>
<?php else: ?>
<table>
    <tr><td>
            None to display
        </td></tr></table>

        <?php endif; ?>