<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="cs" />
        <meta name="author" lang="cs" content="tvoÅ™Ã­mestrÃ¡nky.cz - tvorba www strÃ¡nek" />
        <meta name="copyright" lang="cs" content="www.tvorimestranky.cz" />
        <meta name="description" content="..." />
        <meta name="keywords" content="OpenBama,Alabama" />
        <meta name="robots" content="all,follow" />
        <link href="<?php echo base_url().'/css/screen.css'; ?>" type="text/css" rel="stylesheet" media="screen,projection" />
        <title><?= $title ?></title>
    </head>
    <body>
        <!-- Layout -->
        <div id="layout">

            <!-- Header -->
            <div id="header">

                <h1 id="logo"><a href="<?php echo base_url().'index.php'; ?>" title="OpenBama">OpenBama</a></h1>
                <span id="slogan">Your legislature at your fingertips</span>
                <hr class="noscreen" />

                <!-- Quick hidden nav -->
                <p class="noscreen noprint">
                    <em>RychlÃ¡ navigace: <a href="#obsah">obsah</a>, <a href="#nav">navigace</a>.</em>
                </p>

                <!-- Quick nav -->
                <div id="quicknav">
                    <a href="<?php echo base_url().'index.php'; ?>">Home</a>
                    <a href="#">Contact</a>
                    <a href="#">Sitemap</a>
                </div>

                <!-- Search -->
                <div id="search">
                    <form action="" method="post">
                        <fieldset>
                            <input type="text" id="phrase" name="phrase" value="search phrase" onfocus="if(this.value=='search phrase')this.value=''" />
                            <input type="submit" id="submit" value="SEARCH" />
                        </fieldset>
                    </form>
                </div>

            </div>
            <!-- end/ Header -->

            <hr class="noscreen" />

            <!-- Navigation -->
            <div id="nav" class="box">
                <ul>
                    <li id="active"><a href="<?php echo base_url().'index.php'; ?>">Home</a></li> <!-- Active link -->
                    <li><a href="<?php echo base_url().INDEX_TO_INCLUDE.'bill/all'; ?>">Bills</a></li>
                    <li><a href="#">Reps</a></li>
                    <li><a href="#">Senators</a></li>
                    <li><a href="#" class="nosep">Issues</a></li>
                    <li><a href="#" class="nosep">Committees</a></li>
                </ul>
                <hr class="noscreen" />
            </div>
            <!-- end/ Navigation -->

            <div id="container" class="box">

                <!-- Content -->
                <div id="obsah" class="content box">
                    <div class="in">
                        <?= $contents ?>
                    </div>
                </div>
                <!-- end/ Content-->

                <!-- Right sidebox -->
                <div id="panel-right" class="box panel">
                    <div id="bottom">
                        <div class="in">
                            <strong class="title">About me</strong>
                            <div class="f-left about-img"><img src="<?php echo base_url().'/tmp/about.jpg'?>" alt="about.jpg" title="about me" /><div></div></div>
                            <p class="f-left about-me">
                                <em>Name Surname</em>
                                "Lorem ipsum dolor sit
                                amet, consectetuer adip
                                iscing elit, sed diam non
                                ummy nibh euismod
                                tincidunt uâ€
                            </p>
                            <div class="clear"></div>
                            <br />

                            <strong class="title">Categories</strong>
                            <ul>
                                <li><a href="#">Business</a></li>
                                <li><a href="#">Art &amp; Photography</a></li>
                                <li><a href="#">Communications</a></li>
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Hosting</a></li>
                                <li><a href="#">Interior &amp; Furniture</a></li>
                                <li><a href="#">Music</a></li>
                                <li><a href="#">Real Estate</a></li>
                                <li><a href="#">Sport</a></li>
                                <li><a href="#">Travel</a></li>
                                <li><a href="#">Web design</a></li>
                            </ul>

                            <strong class="title">Entries by month</strong>
                            <ul>
                                <li><a href="#">August 2008 (38)</a></li>
                                <li><a href="#">July 2008 (81)</a></li>
                                <li><a href="#">June 2008 (58)</a></li>
                                <li><a href="#">May 2008 (60)</a></li>
                                <li><a href="#">April 2008 (68)</a></li>
                                <li><a href="#">March 2008 (82)</a></li>
                                <li><a href="#">February 2008 (36)</a></li>
                            </ul>

                        </div>
                    </div>
                </div>
                <!-- end/ Right sidebox -->

            </div>

        </div>
        <!-- end/ Layout -->
        <div id="footer">
            <div id="foot">
                <div id="page-bottom">
                    <a href="#header">Go up</a>
                </div>
                <p class="f-left">&copy; <?php echo date("Y") ?> &ndash; <a href="./">OpenBama</a></p>
                <p class="f-right"><a href="http://www.tvorimestranky.cz" id="webdesign">Webdesign</a>: <a href="http://www.tvorimestranky.cz">TvorimeStranky.cz</a> | Sponsored by: <a href="http://www.topas-tachlovice.cz/topas-tachlovice.aspx" title="ObÄanskÃ© sdruÅ¾enÃ­ Topas Tachlovice">Tachlovice</a></p>
            </div>
        </div>

    </body>
</html>
