<div id="most_popular_help_div" class="tip">
                Popularity is based on a combination of unique views, the number of user votes,number of legislative actions (for bills only), user comments, and the number of sponsors (for bills only).
            </div>
            <h3>Most Popular Bill <a href="#" onmouseout="popUp(event,'most_popular_help_div')" onmouseover="popUp(event,'most_popular_help_div')" onclick="return false"><img border="0" src="<?php echo base_url().'img/questionmark.png'; ?>" width="15" height="15" /></a></h3><a href="<?php echo base_url().INDEX_TO_INCLUDE.'bill/display/'.$popular_bill->id; ?>">
                <u>
                    <?php echo strtoupper($popular_bill->bill_type).$popular_bill->number; ?>
                    - Subject: 
                    <?php echo $popular_bill->subject; ?>
                </u>
            </a>
            <br>
            <?php echo $popular_bill->description; ?>