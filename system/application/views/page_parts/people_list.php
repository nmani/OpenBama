 <?php if($members): ?>
<p><?php echo $links;?></p>
     <?php foreach($members as $member) : ?>

         <?php $image_file_name = MEMBER_IMAGE_LOCATION.$member->id.'.jpg'; ?>

         <?php if(!file_exists($image_file_name)) {
             $image_file_name = base_url().'img/members/image_not_avail.gif';
         }else {
             $image_file_name = base_url().'img/members/'.$member->id.'.jpg';
         }
         ?>
<div style="-moz-border-radius:8px; -webkit-border-radius:8px;background:#fafafa;border: solid 1px #ddd; margin:0; padding:0.8em">
    <h3>
        <a href="<?php echo base_url().INDEX_TO_INCLUDE.'person/display/'.$member->id; ?>"><u><?php echo $member->full_name;?>
                     <?php echo '['.$member->party.', '.$member->district.']'; ?></u></a></h3>
    <p><span>
            <table width="100%">
                <tr>
                    <td valign="top">
                                 <?php echo '<img src="'.$image_file_name.'" width="69" height="100" title="'.$member->full_name.'" alt="'.$member->full_name.'" />'; ?>

                    </td>
                    <td valign="top"><?php

                                 if($member->PersonRating) {
                                     echo '<strong>User approval: </strong>'.round($member->PersonRating).'%';
                                 }else {
                                     echo '<strong>User approval: </strong>'.'Not rated';
                                 }
                                 ?>
                                 <?php
                                 echo '<br>';
                                 echo '<strong>Sponsored bills: </strong>'.$member->SponsoredBillTotal;
                                 ?>
                                 <?php
                                 echo '<br>';
                                 echo '<strong>Cosponsored bills: </strong>'.$member->CoSponsoredTotal;

                                 ?>
                    </td>
                    <td width="40%" valign="bottom" align="right">[<a href="#">Top</a>]
                    </td>
                </tr>
            </table>
        </span>
    </p>
</div>
<br>

     <?php endforeach; ?>
<p><?php echo $links;?></p>
 <?php else: ?>

None to display
                <?php endif; ?>