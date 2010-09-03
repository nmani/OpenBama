<?php
$representative_image_file_name = MEMBER_IMAGE_LOCATION.$most_viewed_person->id.'.jpg';
if(!file_exists($representative_image_file_name)) {
	$representative_image_file_name = base_url().'img/members/image_not_avail.gif';
}else {
	$representative_image_file_name = base_url().'img/members/'.$most_viewed_person->id.'.jpg';
}

?>
<h3>Most Viewed Representative </h3>
        <?php echo '<center><img src="'.$representative_image_file_name.'" width="69" height="100" title="'.$most_viewed_person->full_name.'" alt="'.$most_viewed_person->full_name.'" /><br>'; ?>
        <a href="<?php echo base_url().'index.php/person/display/'.$most_viewed_person->id; ?>">
            <u>
                <?php echo $most_viewed_person->full_name;?>
                <?php echo '['.substr($most_viewed_person->party,0,1).', '.$most_viewed_person->district.']'; ?>
            </u>
        </a>
        </center>