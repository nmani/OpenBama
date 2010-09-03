<?php
/**
 * This is the Controller for the About OpenBama page.
 *
 */
class About extends Controller {

    function About() {
        parent::Controller();

    }

    function index(){
        $this->template->set('page_description','OpenBama.org is a website that compiles data from various sources regarding the Alabama Legislature into an easy to use format and tools placing the legislative process within reach of the the general public.  OpenBama.org is an independent, volunteer-run website that is not affiliated with the Alabama Legislature or state government.');
        $this->template->set('title', 'OpenBama - About OpenBama.org');
        $this->template->load('template/template', 'about');
    }
}