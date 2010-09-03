<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <script type="text/javascript" src="<?php echo base_url().'js/jquery.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/globals.js'; ?>"></script>

        <link type="text/css" href="http://jqueryui.com/latest/themes/base/ui.all.css" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo base_url().'js/jquery.ui.core.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/jquery.ui.datepicker.js'; ?>"></script>
        <title><?= $title ?></title>
        <?php echo $this->xajax->getJavascript(base_url()) ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            body {
                margin: 0;
                padding: 0;
                background-color: #fff;
                font-family: Verdana,sans-serif;
                font-size: 12px;
                color: #333;
            }

            p {
                font-size: 1.3em;
                color: #232323;
                font-family: georgia, times, "times new roman";
                line-height: 1.3em;
                margin: 0 0 15px 0;
            }
            a {
                color: #3671a1;
                margin: 0;
                padding: 0;
            }

            a img {
                border: 0;
                padding: 0;
            }

            h1 {
                /*text-align: center;*/
                font-size: 2.5em;
                letter-spacing: -1px;
                font-family: helvetica, arial, sans-serif;
                margin: 0;
                padding: 0;
                color: #000;
            }

            div.topmenu{

                background-color: black;
                height: 10px;
                width: 100%;
            }
            div.logo{



            }

            div.top {
                margin: 0 auto 30px auto;
                padding: 20px 0 0 0;
                width: 100%;
                height: 80px;
                background-color: #E8ECDC;
                border-bottom: 1px solid #dadfcb;
                background-image: url(../../../img/texture.png);
            }

            div.footer{
                background-color: black;
                height: 100px;
                width: 100%;
            }

        </style>
    </head>
    <body>
        <div class="topmenu">

        </div>
        <div class="top">
            <div class="logo"><h1>OpenBama</h1></div></div>
        <div align="center">
        <div class="main" align="center" style="width: 700px;">
            <p>
                <?= $contents ?>
            </p>
        </div>
        </div>
        <div class="footer"><p>&copy; <?php echo date("Y") ?> &ndash; <a href="./">OpenBama</a></p></div>
    </body>
</html>
