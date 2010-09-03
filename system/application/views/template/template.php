<?php

$return_url = str_replace('/','-',$this->uri->uri_string());
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?= $title ?></title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />

        <meta name="description" content="<?= $page_description ?>" />


        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.1/build/datatable/assets/skins/sam/datatable.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'index.php/css/main'; ?>" />
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.1/build/yahoo-dom-event/yahoo-dom-event.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.1/build/dragdrop/dragdrop-min.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.1/build/element/element-min.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.1/build/datasource/datasource-min.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.1/build/datatable/datatable-min.js"></script>

        <script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/globals.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/tabber.js'; ?>">
        </script>
        <link rel="stylesheet" href="<?php echo base_url().'css/tabs.css'; ?>" type="text/css" />
        <link type="text/css" href="http://jquery-ui.googlecode.com/svn/tags/latest/themes/base/jquery-ui.css" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo base_url().'js/jquery.ui.core.js'; ?>"></script>
        <script language="javascript" type="text/javascript">

            function get_most_viewed_bill_part(page_part_id){

                $url = "<?php echo base_url().'index.php/bill/get_most_viewed_bill'; ?>";
                //$url = 'http://localhost/OpenBama/index.php/bill/get_most_viewed_bill';

                $('#'+ page_part_id).load($url,function() {
                    $('#'+ page_part_id).removeClass('ajax_spinner');
                });

            }

            function get_most_popular_bill_part(page_part_id){

                $url = "<?php echo base_url().'index.php/bill/get_most_popular_bill'; ?>";


                $('#'+ page_part_id).load($url,function() {
                    $('#'+ page_part_id).removeClass('ajax_spinner');
                });

            }

            function get_most_popular_senator_part(page_part_id){

                $url = "<?php echo base_url().'index.php/person/get_most_popular_senator'; ?>";


                $('#'+ page_part_id).load($url,function() {
                    $('#'+ page_part_id).removeClass('ajax_spinner');
                });

            }

            function get_most_popular_representative_part(page_part_id){

                $url = "<?php echo base_url().'index.php/person/get_most_popular_representative'; ?>";


                $('#'+ page_part_id).load($url,function() {
                    $('#'+ page_part_id).removeClass('ajax_spinner');
                });

            }

            function get_most_viewed_issue_part(page_part_id){

                $url = "<?php echo base_url().'index.php/issue/get_most_viewed_issue'; ?>";


                $('#'+ page_part_id).load($url,function() {
                    $('#'+ page_part_id).removeClass('ajax_spinner');
                });

            }

            function get_most_viewed_senator_part(page_part_id){

                $url = "<?php echo base_url().'index.php/person/get_most_viewed_senator'; ?>";


                $('#'+ page_part_id).load($url,function() {
                    $('#'+ page_part_id).removeClass('ajax_spinner');
                });

            }

            function get_most_viewed_representative_part(page_part_id){

                $url = "<?php echo base_url().'index.php/person/get_most_viewed_representative'; ?>";


                $('#'+ page_part_id).load($url,function() {
                    $('#'+ page_part_id).removeClass('ajax_spinner');
                });

            }

            function get_senators_part(page_part_id,filter,sort,rec_count){

                $url = "<?php echo base_url().'index.php/person/senators_ajax/'; ?>"+filter+'/'+sort+'/'+rec_count+'/'+page_part_id;


                $('#'+ page_part_id).load($url,function() {
                    $('#'+ page_part_id).removeClass('ajax_spinner');
                });

            }


        </script>
        <!--<link rel="stylesheet" href="main.css" type="text/css" />-->
        <style type="text/css">
            body {
                color: #003366;
                font-family: Tahoma, san-serif;
                margin: 0;
            }

            #content {
                padding: 10px;
                background-image: url("<?php echo base_url().'img/bg2.jpg'; ?>");
                background-repeat: repeat-x;
                background-color: #FFFFFF;
                overflow: auto;
                height: 100%;
            }

            #mainmenu {
                font-size: small;
            }

            #mainmenu a:link {
                color: white;
                text-decoration: underline;
                font-weight: bold;
                padding: 5px 10px 5px 15px;
            }

            #mainmenu a:visited {
                color: white;
                text-decoration: underline;
                font-weight: bold;
                padding: 5px 10px 5px 15px;
            }

            #topheader {
                background: gray;
                height: 50px;
                border-bottom: 1px solid black;
                line-height: 50px;
            }

            #topheader a:link {
                color: white;
                text-decoration: underline;
                font-weight: bold;
                padding: 5px 10px 5px 10px;

            }

            #topheader a:visited {
                color: white;
                text-decoration: underline;
                font-weight: bold;
                padding: 5px 10px 5px 15px;
            }
            .mistakes_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                font-weight:bold;
                background: url(<?php echo base_url().'img/mistakes_bg.png'; ?>) no-repeat center center;


            }
            .mistakes_div h3{
                text-align:center;
                text-decoration:underline;
            }

            .find_legislator_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                background: url(<?php echo base_url().'img/search_bg.png'; ?>) no-repeat center center;
                font-weight:bold;

            }
            .find_legislator_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .most_viewed_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                background: url(<?php echo base_url().'img/binoculars_bg.png'; ?>) no-repeat center center;
                font-weight:bold;

            }
            .most_viewed_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .most_popular_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                background: url(<?php echo base_url().'img/fire2.png'; ?>) no-repeat center center;
                font-weight:bold;

            }
            .most_popular_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .about_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                background: url(<?php echo base_url().'img/capitol.png'; ?>) no-repeat center center;
                font-weight:bold;

            }
            .about_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .summary_content_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                font-weight:bold;
            }
            .summary_content_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .standard_button {
                margin: 5px 0 0 0;
                background: #3D58B8;
                border: 1px solid #000;
                font-size: 15px;
                font-family: Tahoma, Arial, sans-serif;
                /*padding: 5px 15px 5px 15px;*/
                padding: 7px 3px 7px 7px;
                font-weight: bold;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                color: #fff;
                text-decoration: none;
            }

            .standard_text_box {
                border: 1px solid #338199;
                padding: 7px 3px 7px 7px;
                font-size: 15px;
                letter-spacing: 0.2px;
                margin: 3px 0 0 1px;
                background: #fff;
                -moz-border-radius: 2px;
                -webkit-border-radius: 2px;
            }
            .ajax_spinner {
                width: 100%;
                height: 50px;
                background: url(<?php echo base_url().'img/spinner.gif'; ?>) no-repeat center center;
            }

            #searchdiv {
                float: left;
                color: #fff
            }

            #logindiv {
                float: right;
                color: white;
                font-weight: bold;
            }

            #header {
                height: 120px;
                line-height: 120px;
                background-color: #95B83D;
                padding: 6px;
                border-top: 1px;
                border-left: 1px;
                border-bottom: 1px;
                border-right: 1px;
                display:block;
                margin-left:auto;
                margin-right:auto;
            }

            #mainmenu {
                background: #25282C;
                height: 30px;
                line-height: 30px;
            }

            #leftdiv {
                float: left;
                width: 60%;
                padding-right: 5px;
            }

            #rightdiv {
                float: right;
                width: 39%;
            }
            #footer{
                height: 120px;
                line-height: 120px;
                border-top:solid 1px gray;
                text-align:center;
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

            .rss_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                font-weight:bold;
                background: url(<?php echo base_url().'img/970191_rss_icon_31.jpg'; ?>) no-repeat center center;
            }
            .rss_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .contact_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                font-weight:bold;
                background: url(<?php echo base_url().'img/email_bg.png'; ?>) no-repeat center center;
            }
            .contact_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .wikipedia_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                font-weight:bold;
                background: url(<?php echo base_url().'img/Wikipedia-logo.png'; ?>) no-repeat left center;
            }
            .wikipedia_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .tag_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                font-weight:bold;
                background: url(<?php echo base_url().'img/tag_bg.png'; ?>) no-repeat left center;
            }
            .tag_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .meetings_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                font-weight:bold;
                background: url(<?php echo base_url().'img/meeting_bg.png'; ?>) no-repeat left center;
            }
            .meetings_div h3{
                text-align:center;
                text-decoration:underline;
            }
            .take_action_div {
                -moz-border-radius: 8px;
                -webkit-border-radius: 8px;
                background: #fafafa;
                border: solid 1px gray;
                margin: 0;
                padding: 5px;
                font-weight:bold;
                background: url(<?php echo base_url().'img/action.png'; ?>) no-repeat right center;
            }
            .take_action_div h3{
                text-align:center;
                text-decoration:underline;
            }
            #bill-detail h3{
                text-decoration:underline;
            }
            #person-detail h3{
                text-decoration:underline;
            }
            .yui-skin-sam .yui-dt-liner { white-space:nowrap; }
        </style>
        <?php echo $this->xajax->getJavascript(base_url()) ?>
    </head>
    <body>
        <div id="topheader">
            <div id="searchdiv">

                <?php
                $attributes = array('id' => 'myform');
                echo form_open('search/text_search',$attributes); ?>
                <input id="search_text" name="search_text" type="text"
                       class="standard_text_box" onfocus="if(this.value=='Search...')this.value=''" onblur="if(this.value=='')this.value='Search...'" value="Search..."/> <input class="standard_button" type="submit" value="Find" />
                       <?php echo form_close(); ?>

            </div>
            <div id="logindiv">
                <?php  if($this->redux_auth->logged_in()) {
                    $user_profile = $this->redux_auth->profile();

                    $user_id = $user_profile->id;
                    $user_name = $user_profile->username;
                    echo 'You are currently logged in as '.$user_name.'. <a href="'.base_url().'index.php/auth/logout">Log out</a>';
                }else {
                    echo '<a href="'.base_url().'index.php/auth/login/'.$return_url.'">Login</a> or create an <a href="'.base_url().'index.php/auth/register">account</a>';
                }

                ?>
            </div>
        </div>
        <div id="header">
            <div id="logo"><a href="<?php echo base_url().'index.php'; ?>"><img border="0" title="OpenBama.org" alt="OpenBama.org" src="<?php echo base_url().'img/Logo2.png'; ?>"></img></a></div>
        </div>
        <div id="mainmenu">
            <a href="<?php echo base_url().'index.php'; ?>">Home</a>
            <a href="<?php echo base_url().'index.php/bill/all'; ?>">Bills</a>

            <a href="<?php echo base_url().'index.php/person/senators/all'; ?>">Senators</a>
            <a href="<?php echo base_url().'index.php/person/representatives/all'; ?>">Representatives</a>
            <a href="<?php echo base_url().'index.php/committee/name'; ?>">Committees</a>
            <a href="<?php echo base_url().'index.php/issue/index'; ?>">Issues</a>
            <a href="<?php echo base_url().'index.php/vote/all'; ?>">Votes</a>
           <!-- <a href="<?php echo base_url().'index.php/blog/index'; ?>">Blog</a> -->
            <a href="<?php echo base_url().'index.php/about/index'; ?>">About OpenBama.org</a>
        </div>
        <?= $contents ?>
        <div id="footer">
            <a href="<?php echo base_url().'index.php'; ?>">Home</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/bill/all'; ?>">Bills</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/person/senators/all'; ?>">Senators</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/person/representatives/all'; ?>">Representatives</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/committee/name'; ?>">Committees</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/issue/index'; ?>">Issues</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/vote/all'; ?>">Votes</a>&nbsp;|&nbsp;<a href="<?php echo base_url().'index.php/about/index'; ?>">About OpenBama.org</a>&nbsp;|&nbsp;<a href="mailto:contact@openbama.org">Contact OpenBama.org</a>&nbsp;<!--|&nbsp;<a href="http://blog.openbama.org">Blog</a> --> <br/>&copy; OpenBama.org 2010<br/><br/>
        </div>
    </body>
</html>
