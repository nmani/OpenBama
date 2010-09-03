<?php

class Mobile extends Controller {

    function Mobile() {
        parent::Controller();
    }

    function index(){
        
    }

    function continue_main(){
        $this->session->set_userdata('mobile_continue_status', 'continue');
		redirect('welcome/index');
    }
}