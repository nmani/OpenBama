<div id="content">
    <div id="leftdiv">
        <hr>
        <h2>Page Not Found</h2>

        <p>We're sorry, the page you've attempted to load cannot be found.</p>

        <h3>Cause</h3>
        <p>If you've followed a link to OpenBama.org from another website, the
		link may just be wrong.  If you've followed a link from within our website,
		then <em>we</em> are wrong.  In either case, the fact that you've had this
		trouble has been noted, and we'll investigate how we can keep this from
		happening again.</p>


        <h3>Solutions</h3>
        <ul>
            <li><a href="<?php echo base_url().'index.php'; ?>">Start back at the home page</a> and browse your way to the
			information that you're looking for.</li>

            <li><a href="mailto:contact@openbama.org">E-mail us and tell us the problem</a>. Please
			include the URL of the page you were trying to access, the URL of the
			page that provide you the inaccurate link, and any other information that
			you think might help us track down and solve the problem for you.</li>

        </ul>
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