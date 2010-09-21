<html>
    <head>
        <script type="text/javascript" src="<?php echo base_url().'js/cal.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/globals.js'; ?>"></script>
        <link type="text/css" href="<?php echo base_url().'css/ui.all.css'; ?>" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo base_url().'js/jquery.ui.core.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/jquery.ui.datepicker.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/addclasskillclass.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/attachevent.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/addcss.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/tabtastic.js'; ?>"></script>
        <title><?= $title ?></title>
        <?php echo $this->xajax->getJavascript(base_url()) ?>

        <style type="text/css">
            <!--
            body
            {
                padding: 0;
                margin: 0;
                background-color: #666;
                color: #000;
                font-family: Verdana, Arial, Helvetica, 'sans serif';
                font-size: 14px;
            }

            #contents
            {
                -moz-border-radius:8px;
                -webkit-border-radius:8px;
                margin-top: 10px;
                margin-left: 15%;
                margin-right: 15%;
                padding: 10px;
                background-color: #FFF;
                color: #000;
            }

            #footer
            {
                -moz-border-radius:8px;
                -webkit-border-radius:8px;
                border-top: 1px solid #gray;
                margin-left: 15%;
                margin-right: 15%;
                padding: 10px;
                background-color: #FFF;
                color: #000;
                
            }

            h1
            {
                color: #333;
                background-color: transparent;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 20px;
            }

            p
            {
                color: #333;
                background-color: transparent;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 0.8em;
            }

            -->
            /*Credits: Dynamic Drive CSS Library */
            /*URL: http://www.dynamicdrive.com/style/ */

            .invertedshiftdown{
                padding: 0;
                width: 100%;
                border-top: 5px solid #D10000; /*Red color theme*/
                background: transparent;
                voice-family: "\"}\"";
                voice-family: inherit;
            }

            .invertedshiftdown ul{
                margin:0;
                margin-left: 40px; /*margin between first menu item and left browser edge*/
                padding: 0;
                list-style: none;
            }

            .invertedshiftdown li{
                display: inline;
                margin: 0 2px 0 0;
                padding: 0;
                text-transform:uppercase;
            }

            .invertedshiftdown a{
                float: left;
                display: block;
                font: bold 12px Arial;
                color: black;
                text-decoration: none;
                margin: 0 1px 0 0; /*Margin between each menu item*/
                padding: 5px 10px 9px 10px; /*Padding within each menu item*/
                background-color: white; /*Default menu color*/

                /*BELOW 4 LINES add rounded bottom corners to each menu item.
                  ONLY WORKS IN FIREFOX AND FUTURE CSS3 CAPABLE BROWSERS
                  REMOVE IF DESIRED*/
                -moz-border-radius-bottomleft: 5px;
                border-bottom-left-radius: 5px;
                -moz-border-radius-bottomright: 5px;
                border-bottom-right-radius: 5px;
            }

            .invertedshiftdown a:hover{
                background-color: #D10000; /*Red color theme*/
                padding-top: 9px; /*Flip default padding-top value with padding-bottom */
                padding-bottom: 5px; /*Flip default padding-bottom value with padding-top*/
                color: white;
            }

            .invertedshiftdown .current a{ /** currently selected menu item **/
                                           background-color: #D10000; /*Red color theme*/
                                           padding-top: 9px; /*Flip default padding-top value with padding-bottom */
                                           padding-bottom: 5px; /*Flip default padding-bottom value with padding-top*/
                                           color: white;
            }

            #myform{ /*CSS for sample search box. Remove if desired */
                     float: right;
                     margin: 0;
                     margin-top: 2px;
                     padding: 0;
            }

            #myform .textinput{
                width: 190px;
                border: 1px solid gray;
            }

            #myform .submit{
                font: normal 12px Verdana;
                height: 22px;
                border: 1px solid #D10000;
                background-color: black;
                color: white;
            }

            .ob_button
            {
                font: normal 12px Verdana;
                height: 22px;
                border: 1px solid #D10000;
                background-color: black;
                color: white;
            }
            .bill_item{
                border-top: 1px solid gray;border-bottom: 1px solid gray;
            }
            div#bill-progress {
                width: 150px;
                float: right;
                margin: 0 0 1em 1em;
                font-size: .85em;
                background-color: #f4eee5;
            }
            div#bill-progress h2 {
                font: bold 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
            }
            div.checkbox {
                font-size: 12px;
                font-weight: bold;
            }
            div.checkbox.failed {
                color: #900;
                font-size: 20px;
                font-weight: normal;
            }
            div.checkbox.passed {
                color: #090;
                font-size: 19px;
                font-weight: normal;
            }
            div#actions-detail{
                /*width: 400px;*/

                margin: 0 0 1em 1em;
                font-size: .9em;
            }
            div#actions-detail h2 {
                font: 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
                width: 600px;
            }
            div#bill-detail{
                width: 450px;
                               
                /*margin: 0 0 1em 1em;*/
                /*font-size: .9em;*/
            }
            div#bill-detail h2 {
                font: 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
            }
            div#person-detail{
                width: 350px;

                margin: 0 0 1em 1em;
                /*font-size: .9em;*/
            }
            div#person-detail h2 {
                font: 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
            }
            div#person-sidebar {
                width: 250px;
                float: right;
                margin: 0 0 1em 1em;
                font-size: .85em;
                background-color: #f4eee5;
            }
            div#person-sidebar h2 {
                font: bold 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
            }
            div#vote-stats {
                float: right;
                background-color: #f4eee5;
                -moz-border-radius:8px;
                -webkit-border-radius:8px;
                border-top: 1px solid #dccbaf;
                border-left: 1px solid #dccbaf;
                border-right: 1px solid #dccbaf;
                border-bottom: 1px solid #dccbaf;
            }
            div#vote-stats h2{
                font: 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
            }
            #menu-content h2 {
                font: 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
            }
        </style>
    </head>
    <body>
        <div id="contents">

            <div style="float: right;">

                <?php  if($this->redux_auth->logged_in()) {
                    $user_profile = $this->redux_auth->profile();

                    $user_id = $user_profile->id;
                    $user_name = $user_profile->username;
                    echo 'You are currently logged in as '.$user_name.'. <a href="'.base_url().INDEX_TO_INCLUDE.'auth/logout">Log out</a>';
                }else {
                    echo '<a href="'.base_url().INDEX_TO_INCLUDE.'auth/login">Login</a> or create an <a href="'.base_url().INDEX_TO_INCLUDE.'auth/register">account</a>.';
                }

                ?>

            </div>
            <table width="200px"><tr><td> <?php
                        $attributes = array('id' => 'myform');
                        echo form_open('search/text_search',$attributes); ?>
                        <input id="search_text" name="search_text" type="text" class="textinput" /> <input class="submit" type="submit" value="Find" />
                    <?php echo form_close(); ?></td></tr></table>
            <h1>
		OpenBama.org
            </h1>
            <h4><?php echo DEFAULT_SESSION_TITLE; ?></h4>

            <div class="invertedshiftdown">
                <ul>
                    <li <?php if ($this->uri->segment(1) == '') {
                        echo 'class="current"';

                    }
                    else {echo '';
                    } ?>
                        ><a href="<?php echo base_url().'index.php'; ?>" title="Home">Home</a></li>
                    <li <?php if ($this->uri->segment(1) == 'bill') {
                        echo 'class="current"';

                    }
                    else {echo '';
                        } ?>><a href="<?php echo base_url().INDEX_TO_INCLUDE.'bill/all'; ?>" title="Bills">Bills</a></li>
                    <li <?php if ($this->uri->segment(1) == 'person' && $this->uri->segment(2) == 'senators') {
                        echo 'class="current"';

                    }
                    else {echo '';
                        } ?>><a href="<?php echo base_url().INDEX_TO_INCLUDE.'person/senators/all'; ?>" title="Senators">Senators</a></li>
                    <li <?php if ($this->uri->segment(1) == 'person' && $this->uri->segment(2) == 'representatives') {
                        echo 'class="current"';

                    }
                    else {echo '';
                        } ?>><a href="<?php echo base_url().INDEX_TO_INCLUDE.'person/representatives/all'; ?>" title="Representatives">Representatives</a></li>
                    <li <?php if ($this->uri->segment(1) == 'committee') {
                        echo 'class="current"';

                    }
                    else {echo '';
                        } ?>><a href="<?php echo base_url().INDEX_TO_INCLUDE.'committee/name'; ?>" title="Committees">Committees</a></li>
                    <li <?php if ($this->uri->segment(1) == 'issue') {
                        echo 'class="current"';

                    }
                    else {echo '';
                        } ?>><a href="<?php echo base_url().INDEX_TO_INCLUDE.'issue/index'; ?>" title="Issues">Issues</a></li>
                    <li <?php if ($this->uri->segment(1) == 'vote') {
                        echo 'class="current"';

                    }
                    else {echo '';
                        } ?>><a href="<?php echo base_url().INDEX_TO_INCLUDE.'vote/all'; ?>" title="Votes">Votes</a></li>

                </ul>

                <!--
                            <form id="myform">
                <input type="text" class="textinput" /> <input class="submit" type="submit" value="Find" />
                </form>
                -->
            </div>

            <br style="clear: both;" />

            <div>
                <br>
                <div style="float:right;">
                    <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=381c3502-600d-4f37-b237-c6b7ff990f48&amp;type=website"></script>
                </div>
                <br>
                <?= $contents ?>
            </div>
            <br>
            <br>
            <br>
            <br>
        </div>
        <div id="footer">
            &copy; OpenBama.org 2010
        </div>

    </body>
</html>