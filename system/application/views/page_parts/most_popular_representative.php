<?php 
$representative_image_file_name = MEMBER_IMAGE_LOCATION.$popular_representative->id.'.jpg';
if(!file_exists($representative_image_file_name)) {
	$representative_image_file_name = base_url().'img/members/image_not_avail.gif';
}else {
	$representative_image_file_name = base_url().'img/members/'.$popular_representative->id.'.jpg';
}
?>
<h3>Most Popular Representative <a href="#" onmouseout="popUp(event,'most_popular_help_div')" onmouseover="popUp(event,'most_popular_help_div')" onclick="return false"><img border="0" src="<?php echo base_url().'img/questionmark.png'; ?>" width="15" height="15" /></a></h3>
    <?php echo '<center><img src="'.$representative_image_file_name.'" width="69" height="100" title="'.$popular_representative->full_name.'" alt="'.$popular_representative->full_name.'" /><br>'; ?>
    <a href="<?php echo base_url().'index.php/person/display/'.$popular_representative->id; ?>">
        <u>
            <?php echo $popular_representative->full_name;?>
            <?php echo '['.substr($popular_representative->party,0,1).', '.$popular_representative->district.']'; ?>
        </u>
    </a>
    </center>