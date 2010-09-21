<?php $first_record = true; ?>

<?php if($committees): ?>
<p><?php echo $links;?></p>
    <?php foreach($committees as $committee) : ?>

        <?php if (!$committee->subcommittee_name): ?>
            <?php if(!$first_record): ?>
<span>
    <table width="100%">
        <tr>
            <td align="right">
                [<a href="#">Top</a>]
            </td>
        </tr>
    </table>
</span>
</div>
<br>
            <?php endif; ?>
<div style="-moz-border-radius:8px; -webkit-border-radius:8px;background:#fafafa;border: solid 1px #ddd; margin:0; padding:0.8em">
    <h3>
        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'committee/display/'.$committee->id; ?>"<u><?php echo $committee->committee_name;?>
            </u></a></h3>
                <?php if($committee->subcommittee_count > 0): ?>
    <strong>Subcommittees</strong><br>
                <?php else: ?>
    No subcommittees
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($committee->subcommittee_name) {
                echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/display/'.$committee->id.'">'.$committee->subcommittee_name.'</a><br>';
            }
            ?>
            <?php $first_record = false; ?>
        <?php endforeach; ?>
    <span>
        <table width="100%">
            <tr>
                <td align="right">
                    [<a href="#">Top</a>]
                </td>
            </tr>
        </table>
    </span>
</div>
<p><?php echo $links;?></p>
<?php else: ?>

None to display

            <?php endif; ?>