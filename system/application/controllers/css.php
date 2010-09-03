<?php
/**
 * This is the Controller for the About OpenBama page.
 *
 */
class Css extends Controller {

    function Css() {
        parent::Controller();

    }

    function index() {
        $this->load->view('main_css');
    }

    function main() {
        $this->load->view('main_css');
    }
}