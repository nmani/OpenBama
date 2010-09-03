<style type="text/css">
    #menu {
        border-bottom : 1px solid #ccc;
        margin : 0;
        padding-bottom : 19px;
        padding-left : 10px;
    }

    #menu ul, #menu li	{
        display : inline;
        list-style-type : none;
        margin : 0;
        padding : 0;
    }


    #menu a:link, #menu a:visited	{
        background : #E8EBF0;
        border : 1px solid #ccc;
        color : #666;
        float : left;
        font-size : small;
        font-weight : normal;
        line-height : 14px;
        margin-right : 8px;
        padding : 2px 10px 2px 10px;
        text-decoration : none;
    }

    #menu a:link.active, #menu a:visited.active	{
        background : #fff;
        border-bottom : 1px solid #fff;
        color : #000;
    }

    #menu a:hover	{
        color : #f00;
    }

    .section-1 #menu li#nav-1 a {
        background : #fff;
        border-bottom : 1px solid #fff;
        color : #000;
    }

    #menu #subnav-1,
    #menu #subnav-2 {
        display : none;
        /*width: 90%;*/
    }

    .section-1 #menu ul#subnav-1,
    .section-2 #menu ul#subnav-2 {
        display : inline;
        left : 0px;
        position : absolute;
        top : 25px;

    }

    .section-1 #menu ul#subnav-1 a,
    .section-2 #menu ul#subnav-2 a {
        background : #fff;
        border : none;
        border-left : 1px solid #ccc;
        color : #999;
        font-size : smaller;
        font-weight : bold;
        line-height : 10px;
        margin-right : 4px;
        padding : 2px 10px 2px 10px;
        text-decoration : none;
    }

    #menu ul a:hover {
        color : #f00 !important;
    }
    #menu-content {
        background : #fff;
        border : 1px solid #ccc;
        border-top : none;
        clear : both;
        margin : 0px;
        padding : 15px;


    }

</style>
<div id="content">
    <div id="leftdiv">
        <div>
            <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=381c3502-600d-4f37-b237-c6b7ff990f48&amp;type=website"></script>
        </div>
        <hr>
        <?php if ($vote) {
            echo '<h2><a href="'.base_url().'index.php/bill/display/'.$vote->bill_id.'">'.strtoupper($vote->bill_label).'</a></h2>';
            echo $vote->description;
        }
        ?>

        <hr>
        <strong>Vote regarding</strong><br>
        <?php echo $vote->action_text; ?>
        <br><br>
        <strong>Vote Date</strong><br>
        <?php echo date("M j, Y",strtotime($vote->vote_date)); ?>
        <br><br>
        <div>
            <?php if($roll_call_votes): ?>
            <table><tr><td>
                        <div style="float:left;">
                            <table>
                                <tr><td width="260px"><strong>Name</strong></td><td width="50px"><strong>Voted</strong></td></tr>
                                    <?php foreach($roll_call_votes as $member_vote) : ?>
                                <tr>
                                    <td>
                                                <?php echo '<a href="'.base_url().'index.php/person/display/'.$member_vote->person_id.'">'.substr($member_vote->full_name,4);
                                                echo '['.substr($member_vote->party,0,1).', '.$member_vote->district.']'.'</a>'; ?>
                                    </td>
                                    <td><?php echo $member_vote->vote_text; ?></td>
                                </tr>
                                    <?php endforeach; ?>
                            </table>
                        </div>


                        <?php else: ?>
                        None to display
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

        </div>


    </div>
    <div id="rightdiv">
        <div class="summary_content_div">
            <div id="vote-stats">
                <h3>Vote Stats</h3>
                <p>
                    <?php
                    $dem_yes_percent = 0;
                    $dem_no_percent = 0;
                    $repub_no_percent = 0;
                    $repub_yes_percent = 0;

                    ?>
                    <?php if($vote_stats): ?>
                        <?php foreach($vote_stats as $stat_item) : ?>

                            <?php if($stat_item->vote == 'Y'): ?>
                                <?php $dem_yes_percent = round(($stat_item->dem_count/$stat_item->vote_count) * 100);
                                $repub_yes_percent = round(($stat_item->repub_count/$stat_item->vote_count) * 100);?>
                    <font color="green">Ayes:</font><?php echo $stat_item->vote_count;
                                echo '(Dem:'.$stat_item->dem_count.';Rep:'.$stat_item->repub_count.')';
                                ?>
                            <?php elseif ($stat_item->vote == 'N'): ?>
                                <?php $dem_no_percent = round(($stat_item->dem_count/$stat_item->vote_count) * 100);
                                $repub_no_percent = round(($stat_item->repub_count/$stat_item->vote_count) * 100);?>
                    <font color="red">Nays:</font><?php echo $stat_item->vote_count;
                                echo '(Dem:'.$stat_item->dem_count.';Rep:'.$stat_item->repub_count.')';
                                ?>
                            <?php elseif ($stat_item->vote == 'P'): ?>
                    <font color="black">Pass:</font><?php echo $stat_item->vote_count;
                                echo '(Dem:'.$stat_item->dem_count.';Rep:'.$stat_item->repub_count.')';
                                ?>
                            <?php elseif ($stat_item->vote == 'A'): ?>
                    <font color="black">Abstained:</font><?php echo $stat_item->vote_count;
                                echo '(Dem:'.$stat_item->dem_count.';Rep:'.$stat_item->repub_count.')';
                                ?>
                            <?php else: ?>
                    <font color="black"><?php echo $stat_item->vote.':</font>'.$stat_item->vote_count;
                                    echo '(Dem:'.$stat_item->dem_count.';Rep:'.$stat_item->repub_count.')';
                                    ?>
                                <?php endif; ?>


                            <?php endforeach; ?>
                        <strong>Result:<?php
                                if($vote->result == 'LOST') {
                                    echo '<font color="red">'.$vote->result.'</font>';
                                }else {
                                    echo '<font color="green">'.$vote->result.'</font>';
                                }

                                ?>
                        </strong>
            </div>
        </div>
        <br/>
        <div class="summary_content_div">
                <? if ($dem_yes_percent > 0 || $repub_yes_percent): ?>
            <h3>Yes Votes By Party</h3>
<center>
                    <?php
                    echo '<img width="300px" height="170px" src="http://chart.apis.google.com/chart?chf=bg,s,65432100&chco=0000FF|FF0000&chs=280x100&chd=t:'.$dem_yes_percent.','.$repub_yes_percent.'&cht=p3&chl=Dem. ('.$dem_yes_percent.'%)|Rep. ('.$repub_yes_percent.'%)" />'; ?>
                    <br/><?php echo 'Dem: '.$dem_yes_percent.'%'.' Repub: '.$repub_yes_percent.'%';
                    ?>

</center>

                <?php endif; ?>
        </div>
        <br/>

            <? if ($dem_no_percent > 0 || $repub_no_percent): ?>
        <div class="summary_content_div">
            <h3>No Votes By Party</h3>

<center>
                    <?php
                    echo '<img width="300px" height="170px" src="http://chart.apis.google.com/chart?chf=bg,s,65432100&chco=0000FF|FF0000&chs=280x100&chd=t:'.$dem_no_percent.','.$repub_no_percent.'&cht=p3&chl=Dem. ('.$dem_no_percent.'%)|Rep. ('.$repub_no_percent.'%)" />'; ?>
            <br/>
                    <?php echo 'Dem: '.$dem_no_percent.'%'.' Repub: '.$repub_no_percent.'%';
                    ?>
</center>
                <?php endif; ?>
        </div>
        <?php endif; ?>



    </div>


</div>

