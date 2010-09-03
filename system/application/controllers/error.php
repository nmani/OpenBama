<?php
class Error extends Controller {

    function error_404() {
        $this->template->set('title', 'OpenBama - Page not found');
        $this->template->set('page_description','Error page: page not found.');
        $this->template->load('template/template', 'errors/404');
    }
}