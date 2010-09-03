                <?php if($comments):?>
<br>
                    <?php foreach($comments as $comment):?>
<br>
<strong>Author: </strong><?php echo $comment->username; ?><br>

<strong>Comment:</strong> <?php echo date("M j, Y",strtotime($comment->created_on)); ?><br>

                        <?php echo $comment->comment; ?><br>


                    <?php endforeach;?>

                <?php else: ?>
No comments.<br>
                <?php endif;?>