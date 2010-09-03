<?php
class Credits extends Controller {

    function Credits() {
        parent::Controller();
    }

    function index(){
        $this->template->set('title', 'Credits');
        $this->template->load('template/template', 'credits');
    }
}

/* End of file committee.php */
/* Location: ./system/application/controllers/committee.php */