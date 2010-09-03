<?php

$return_url = str_replace('/','-',$this->uri->uri_string());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        <meta name="description" content="<?= $page_description ?>" />

        <meta name="keywords" content="alabama,legislature,montgomery,alabama alison,alabama legislative information system online" />
        <script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js'; ?>"></script>
        <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/datepicker.css'; ?>" />
        <?php if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'welcome'): ?>
        <script type="text/javascript" src="<?php echo base_url().'js/prototype.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/prototype-base-ext.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/prototype-date-ext.js'; ?>"></script>
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo base_url().'js/datepicker.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/globals.js'; ?>"></script>
        <link type="text/css" href="<?php echo base_url().'css/ui.all.css'; ?>" rel="stylesheet" />
        <link type="text/css" href="http://jquery-ui.googlecode.com/svn/tags/latest/themes/base/jquery-ui.css" rel="stylesheet" />

        <script type="text/javascript" src="<?php echo base_url().'js/jquery.ui.core.js'; ?>"></script>
        <title><?= $title ?></title>
        <?php echo $this->xajax->getJavascript(base_url()) ?>
        <style type="text/css">
            body
            {
                font-family: Verdana, Arial, sans-serif;
                font-size: medium;
                text-align: center;
                background-color: #666;
                color: #000;
                margin: 0 0.4em 0 0.4em;
            }
            #page-wrap
            {
                font-size: 75%;
                line-height: 1.666em;
                width: 66em;
                margin: 0 auto;
                text-align: center;
            }
            #page
            {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                margin: 0 auto;
                margin-top: 1%;
                text-align: left;
                width: 65.167em;
                background: white;
            }
            #ads{
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                margin: 0 auto;
                margin-top: 2%;
                text-align: center;
                width: 65.167em;
                background: white;
            }
            #content
            {
                clear: both;
            }
            #header
            {
                color: black;
                /*height: 100px;*/
            }
            #header div, #header ul
            {
                padding: 0 0.8333em;
            }
            #header #logo
            {
                float: left;
                width: 300px;
                text-align:left;
            }
            #header #find-box
            {
                float: right;
                padding: 10px;
            }
            #login-box
            {

                float: right;
                margin-right: 10px;
                margin-top: 10px;

            }
            #content
            {
                padding: 1em 1.667em;
                width: 41.667em;
                float: left;
            }
            #content h2
            {
                font: 150% Georgia, Times, serif;
                padding-bottom: 0;
                margin-top: 1em;
            }
            #content h3
            {
                font: 125% Georgia, Times, serif;
                padding-bottom: 0.667em;
                margin-top: 1em;
                margin-bottom: .25em;
                text-decoration: underline;

            }
            div#content div.left_side
            {
                width: 40%;
                float: left;
                margin-right: 10%;
            }
            div#content div.right_side
            {
                width: 40%;
                float: right;
            }
            #sidebar
            {
                background: #f4eee5;
                margin-left: 45em;
            }
            #sidebar h3
            {
                font-family: Verdana, 'Lucida Sans' , Arial, Helvetica, 'sans serif';
                font-weight: bold;
                font-size: 100%;
                background: #dccbaf;
                padding: 0.333em 0.833em;
                margin-bottom: 0.5em;
            }
            #sidebar ul.tags
            {
                line-height: 1.3em;
            }

            #sidebar div.box
            {
                margin-top: 30px;
                font-size: .9em;
                line-height: 1.5em;
                padding-bottom: 5px;
            }

            #sidebar div.box p
            {
                padding: 0 0.909em;
                margin-bottom: .5em;
            }
            #sidebar ul, #sidebar ol
            {
                margin-bottom: 0;
            }
            #footer
            {
                clear: both;
                -moz-border-radius-bottomright: 8px;
                -moz-border-radius-bottomleft: 8px;
                -webkit-border-bottom-right-radius: 8px;
                -webkit-border-bottom-left-radius: 8px;
                font-size: 85%;
                padding: 1em 0 0 2.5em;
                margin-top: 2em;
                color: #333;
                text-align: center;
                background-color: #f4eee5;
                border-top: 1px solid #dccbaf;
            }
            #footer p.quote
            {
                font-family: Georgia;
                font-size: 1.75em;
                color: #666;
                font-style: italic;
            }
            /*Credits: Dynamic Drive CSS Library *//*URL: http://www.dynamicdrive.com/style/ */
            .invertedshiftdown
            {
                margin-top: 1px;
                padding: 0;
                width: 100%;
                border-top: 5px solid #D10000; /*Red color theme*/
                background: transparent;
                voice-family: "\"}\"";
                voice-family: inherit;
            }
            .invertedshiftdown ul
            {
                margin: 0;
                margin-left: 40px; /*margin between first menu item and left browser edge*/
                padding: 0;
                list-style: none;
            }
            .invertedshiftdown li
            {
                display: inline;
                margin: 0 2px 0 0;
                padding: 0;
                text-transform: uppercase;
            }
            .invertedshiftdown a
            {
                float: left;
                display: block;
                font: bold 12px Arial;
                color: black;
                text-decoration: none;
                margin: 0 1px 0 0; /*Margin between each menu item*/
                padding: 5px 10px 9px 10px; /*Padding within each menu item*/
                background-color: white; /*Default menu color*/ /*BELOW 4 LINES add rounded bottom corners to each menu item.
	  ONLY WORKS IN FIREFOX AND FUTURE CSS3 CAPABLE BROWSERS
	  REMOVE IF DESIRED*/
                -moz-border-radius-bottomleft: 5px;
                border-bottom-left-radius: 5px;
                -moz-border-radius-bottomright: 5px;
                border-bottom-right-radius: 5px;
            }
            .invertedshiftdown a:hover
            {
                background-color: #D10000; /*Red color theme*/
                padding-top: 9px; /*Flip default padding-top value with padding-bottom */
                padding-bottom: 5px; /*Flip default padding-bottom value with padding-top*/
                color: white;
            }
            .invertedshiftdown .current a
            {
                /** currently selected menu item **/
                background-color: #D10000; /*Red color theme*/
                padding-top: 9px; /*Flip default padding-top value with padding-bottom */
                padding-bottom: 5px; /*Flip default padding-bottom value with padding-top*/
                color: white;
            }
            /* End Dynamic Drive CSS*/#body-main
            {
                /*background-color: #406e91;*/
                margin-top: 0.2em;
                line-height: 2.91em;
            }
            .ob_button
            {
                font: normal 12px Verdana;
                height: 22px;
                border: 1px solid #D10000;
                background-color: black;
                color: white;
            }
            div#person-detail h3 {
                font: 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
            }
            div#actions-detail h3 {
                font: 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
            }
            div#bill-detail h3 {
                font: 1em Verdana, Arial, Helvetica, 'sans serif';
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
            .tip {font:10px/12px
                      Arial,Helvetica,sans-serif;
                  border:solid 1px #666666;
                  width:270px;
                  padding:1px;
                  position:absolute;
                  z-index:100;
                  visibility:hidden;
                  color:#333333;
                  top:20px;
                  left:90px;
                  background-color:#ffffcc;
                  layer-background-color:#ffffcc;}
            .grid-header {
                font: 1em Verdana, Arial, Helvetica, 'sans serif';
                padding: 3px 0 3px 5px;
                font-size: 1.1em;
                background-color: #dccbaf;
            }


        </style>
        <script type="text/javascript">
            function createPickers() { $(document.body).select('input.datepicker').each( function(e) { new Control.DatePicker(e, { 'icon': './img/calendar.png' }); } ); } Event.observe(window, 'load', createPickers);
        </script>
    </head>
    <body id="body-main">
        <div id="page-wrap">
            <div id="ads">
                <script type="text/javascript"><!--
                    google_ad_client = "pub-1326491028236037";
                    /* 728x90, created 4/22/10 */
                    google_ad_slot = "9315693038";
                    google_ad_width = 728;
                    google_ad_height = 90;
                    //-->
                </script>
                <script type="text/javascript"
                        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                </script>
            </div>
            <div id="page">
                <div id="header">
                    <table width="100%">
                        <tr>
                            <td width="50%" alig="left" valign="top">
                                <div style="padding: 5px;">
                                    <a href="<?php echo base_url().'index.php'; ?>"><img border="0" src="<?php echo base_url().'img/logo2.png'?>" title="OpenBama.org" alt="OpenBama.org" /></a>
                                </div>
                            </td>

                            <td width="50%" align="right" valign="top">
                                <table style="height:50px;">
                                    <tr>
                                        <td height="100%" align="right" valign="top">
                                            <div style="padding: 5px;vertical-align:middle;margin-right:5px;">
                                                <?php  if($this->redux_auth->logged_in()) {
                                                    $user_profile = $this->redux_auth->profile();

                                                    $user_id = $user_profile->id;
                                                    $user_name = $user_profile->username;
                                                    echo 'You are currently logged in as '.$user_name.'. <a href="'.base_url().'index.php/auth/logout">Log out</a>';
                                                }else {
                                                    echo '<a href="'.base_url().'index.php/auth/login/'.$return_url.'">Login</a> or create an <a href="'.base_url().'index.php/auth/register">account</a>.';
                                                }

                                                ?>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">
                                            <div style="padding: 2px;vertical-align:middle;margin-right:5px;">
                                                <?php
                                                $attributes = array('id' => 'myform');
                                                echo form_open('search/text_search',$attributes); ?>
                                                <strong>Search:</strong> <input id="search_text" name="search_text" type="text" class="textinput" /> <input class="ob_button" type="submit" value="Find" />
                                                <?php echo form_close(); ?>
                                            </div>


                                        </td></tr>
                                </table>


                            </td>
                        </tr>

                    </table>

                </div>
                <!-- Insert Menu here -->
                <div class="invertedshiftdown">
                  
                    <ul>
                        <li <?php if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'welcome') {
                            echo 'class="current"';

                        }
                        else {echo '';
                        } ?>
                            ><a href="<?php echo base_url().'index.php'; ?>" title="Home">Home</a></li>
                        <li <?php if ($this->uri->segment(1) == 'bill') {
                            echo 'class="current"';

                        }
                        else {echo '';
                            } ?>><a href="<?php echo base_url().'index.php/bill/all'; ?>" title="Bills">Bills</a></li>
                        <li <?php if ($this->uri->segment(1) == 'person' && $this->uri->segment(2) == 'senators') {
                            echo 'class="current"';

                        }
                        else {echo '';
                            } ?>><a href="<?php echo base_url().'index.php/person/senators/all'; ?>" title="Senators">Senators</a></li>
                        <li <?php if ($this->uri->segment(1) == 'person' && $this->uri->segment(2) == 'representatives') {
                            echo 'class="current"';

                        }
                        else {echo '';
                            } ?>><a href="<?php echo base_url().'index.php/person/representatives/all'; ?>" title="Representatives">Representatives</a></li>
                        <li <?php if ($this->uri->segment(1) == 'committee') {
                            echo 'class="current"';

                        }
                        else {echo '';
                            } ?>><a href="<?php echo base_url().'index.php/committee/name'; ?>" title="Committees">Committees</a></li>
                        <li <?php if ($this->uri->segment(1) == 'issue') {
                            echo 'class="current"';

                        }
                        else {echo '';
                            } ?>><a href="<?php echo base_url().'index.php/issue/index'; ?>" title="Issues">Issues</a></li>
                        <li <?php if ($this->uri->segment(1) == 'vote') {
                            echo 'class="current"';

                        }
                        else {echo '';
                            } ?>><a href="<?php echo base_url().'index.php/vote/all'; ?>" title="Votes">Votes</a></li>
                        <!-- <li><a href="http://blog.openbama.org" title="Blog">Blog</a></li> -->
                    </ul>

                </div>
                <!-- end menu -->

                <?= $contents ?>


                <div id="footer">
                    <a href="<?php echo base_url().'index.php'; ?>">Home</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/bill/all'; ?>">Bills</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/person/senators/all'; ?>">Senators</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/person/representatives/all'; ?>">Representatives</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/committee/name'; ?>">Committees</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/issue/index'; ?>">Issues</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/vote/all'; ?>">Votes</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/about/index'; ?>">About OpenBama.org</a>&nbsp;|&nbsp;<a href="mailto:contact@openbama.org">Contact OpenBama.org</a>&nbsp;<!--|&nbsp;<a href="http://blog.openbama.org">Blog</a> --> <br>&copy; OpenBama.org 2010
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try {
                var pageTracker = _gat._getTracker("UA-16038200-1");
                pageTracker._trackPageview();
            } catch(err) {}</script>
    </body>
</html>
