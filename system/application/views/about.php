<div id="content">
    <div id="leftdiv">
        <hr>
        <h2>About OpenBama.org</h2>
        <h3>What is OpenBama.org</h3>
        <p>
            OpenBama.org is a website that compiles data from various sources regarding the Alabama Legislature into an easy to use format and tools placing the legislative process within reach of the the general public.  OpenBama.org is an independent, volunteer-run website that is not affiliated with the Alabama Legislature or state government.

        </p>
        <h3>Data Sources</h3>
        <p>
            Below is a listing of the data sources used by OpenBama.org:
        <ol>
            <li>The bill data provided on OpenBama.org is captured from the <a href="http://alisondb.legislature.state.al.us/acas/acaslogin.asp" target="_blank">ALISON</a> (Alabama Legislative Information System Online) website daily.  The process that updates the data on OpenBama.org occurs everyday at 6 PM (central time zone).</li>
            <li>In addition to the bill information retrieved from ALISON, the biogharpical informtion is provided by <a href="http://www.votesmart.org" target="_blank">Project Vote Smart</a>.</li>
            <li>The photos of the senators and representatives have been provided by the official website of the <a href="http://www.legislature.state.al.us/" target="_blank">Alabama Legislature</a>.</li>
        </ol>
        </p>
        <h3>Credits</h3>
        <p>
        <h4>Software/Technology</h4>
        <p>
            OpenBama.org relies heavily on many open source technologies including:
        <ol>
            <li><a href="http://www.codeigniter.com" target="_blank">CodeIgniter</a> - OpenBama.org is built on this wonderful PHP MVC platform.</li>
            <li><a href="http://www.icsharpcode.net/OpenSource/SD/" target="_blank">SharpDevelop</a> - The data capture application has been developed in C#.NET using this open source .NET IDE.</li>
            <li><a href="http://www.mysql.com" target="_blank">MySql</a> - MySql is the database backend to OpenBama.org.</li>
            <li><a href="http://www.sphinxsearch.com/" target="_blank">Sphinx</a> - This open source full-text search engine supports the bill text searching functionality.</li>
            <li><a href="http://netbeans.org/" target="_blank">NetBeans IDE</a> - This integrated development environment is used to develop the web site.</li>
        </ol>
        </p>

        </p>
        <!--
        <h3>How to use?</h3>
        <p>

        </p>
        <h3>Comming Soon</h3>
        <p>

        </p>
        -->

    </div>
    <div id="rightdiv">

        <div class="about_div">
            <?php $this->load->view('page_parts/about_openbama'); ?>
        </div>
        <br/>
        <div class="rss_div">
            <?php $this->load->view('rss_feeds_side_view'); ?>
        </div>
    </div>
</div>