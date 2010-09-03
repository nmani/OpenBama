<?php
class Rss extends Controller {

    function Rss() {
        parent::Controller();
        $this->load->model('rss_model', '', TRUE);
        $this->load->helper('xml');
    }

    function index() {
        $this->template->set('title', 'OpenBama - RSS Feeds');
        $this->template->load('template/template', 'rss_feeds');
    }

    function new_bills() {
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'OpenBama.org - New Bills';
        $data['feed_url'] = 'http://www.openbama.org';
        $data['page_description'] = 'Bills recently introduced in the Alabama Legislature';
        $data['page_language'] = 'en-ca';
        $data['creator_email'] = 'info@openbama.org';
        $data['posts'] = $this->rss_model->get_introduced_bills(DEFAULT_SESSION);
        header("Content-Type: application/rss+xml");
        $this->load->view('rss_bill', $data);
    }

    function recently_updated_bills() {
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'OpenBama.org - Recently Updated Bills';
        $data['feed_url'] = 'http://www.openbama.org';
        $data['page_description'] = 'Bills recently updated in the Alabama Legislature';
        $data['page_language'] = 'en-ca';
        $data['creator_email'] = 'info@openbama.org';
        $data['posts'] = $this->rss_model->get_recently_bills_acted_on(DEFAULT_SESSION);
        header("Content-Type: application/rss+xml");
        $this->load->view('rss_bill', $data);
    }

    function follow_bill($bill_id = NULL) {
        $this->load->model('bill_model');

        $bill =  $this->bill_model->get_Bill_Detail_By_ID($bill_id);
        $bill_title = strtoupper($bill->bill_type).$bill->number;

        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'OpenBama.org - Status of '.$bill_title;
        $data['feed_url'] = 'http://www.openbama.org';
        $data['page_description'] = 'The activity of bill '.$bill_title.' in the Alabama Legislature';
        $data['page_language'] = 'en-ca';
        $data['creator_email'] = 'info@openbama.org';
        $data['posts'] = $this->rss_model->get_recent_activity_by_bill_id($bill_id);
        header("Content-Type: application/rss+xml");
        $this->load->view('rss_bill', $data);
    }

    function follow_legislator($person_id = NULL) {
        $this->load->model('person_model');

        $person =  $this->person_model->get_Person_By_ID($person_id);
        $full_name = $person->full_name.' ['.substr($person->party,0,1).', '.$person->district.']';

        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'OpenBama.org - Status of bills introduced by '.$full_name;
        $data['feed_url'] = 'http://www.openbama.org';
        $data['page_description'] = 'The activity of bills introduced by '.$full_name.' in the Alabama Legislature';
        $data['page_language'] = 'en-ca';
        $data['creator_email'] = 'info@openbama.org';
        $data['posts'] = $this->rss_model->get_recent_activity_by_person_id($person_id);
        header("Content-Type: application/rss+xml");
        $this->load->view('rss_bill', $data);
    }

    function follow_issue($subject_id = NULL) {
        $this->load->model('issue_model');

        $issue =  $this->issue_model->get_issue_by_id($subject_id);
        $issue_name = $issue->subject;

        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'OpenBama.org - Status of bills associated with issue '.$issue_name;
        $data['feed_url'] = 'http://www.openbama.org';
        $data['page_description'] = 'The activity of bills associated with issue '.$issue_name.' in the Alabama Legislature.';
        $data['page_language'] = 'en-ca';
        $data['creator_email'] = 'info@openbama.org';
        $data['posts'] = $this->rss_model->get_recent_activity_by_subject_id($subject_id);
        //$data['posts'] = false;
        header("Content-Type: application/rss+xml");
        $this->load->view('rss_bill', $data);
    }

}

/* End of file committee.php */
/* Location: ./system/application/controllers/committee.php */