        <?php if($committees): ?>
            <?php foreach($committees as $committee) : ?>


                <?php
                if ($committee->subcommittee_name) {
                    echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/display/'.$committee->id.'">'.$committee->committee_name.' ('.$committee->subcommittee_name.')</a>('.$committee->page_views.' view(s))<br>';
                }else {
                    echo '<a href="'.base_url().INDEX_TO_INCLUDE.'committee/display/'.$committee->id.'">'.$committee->committee_name.'</a> ('.$committee->page_views.' view(s))<br>';
                }


                ?>

            <?php endforeach; ?>
        <?php else: ?>

None to display

        <?php endif; ?>