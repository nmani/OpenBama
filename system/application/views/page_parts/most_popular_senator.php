<?php
$senator_image_file_name = MEMBER_IMAGE_LOCATION.$popular_senator->id.'.jpg';
if(!file_exists($senator_image_file_name)) {
	$senator_image_file_name = base_url().'img/members/image_not_avail.gif';
}else {
	$senator_image_file_name = base_url().'img/members/'.$popular_senator->id.'.jpg';
}

?>
<h3>Most Popular Senator <a href="#" onmouseout="popUp(event,'most_popular_help_div')" onmouseover="popUp(event,'most_popular_help_div')" onclick="return false"><img border="0" src="<?php echo base_url().'img/questionmark.png'; ?>" width="15" height="15" /></a></h3>
        <?php echo '<center><img src="'.$senator_image_file_name.'" width="69" height="100" title="'.$popular_senator->full_name.'" alt="'.$popular_senator->full_name.'" /><br>'; ?>
        <a href="<?php echo base_url().'index.php/person/display/'.$popular_senator->id; ?>">
            <u>
                <?php echo $popular_senator->full_name;?>
                <?php echo '['.substr($popular_senator->party,0,1).', '.$popular_senator->district.']'; ?>
            </u>
        </a>
        </center>