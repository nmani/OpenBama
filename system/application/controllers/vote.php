<?php
class Vote extends Controller {

    function Vote() {
        parent::Controller();
        $this->load->model('vote_model');
        $this->load->library('pagination');
		$this->load->library('user_agent');
    }

    function index() {
        redirect('vote/all');
    }

    function display() {

    //get vote id from url for display
        $vote_id = $this->uri->segment(3);

        //Get ip of visitor
        $ip = $_SERVER['REMOTE_ADDR'];

        //Record this viewing
        if (!$this->agent->is_robot()){
			$this->vote_model->insert_vote_view($ip,$vote_id);
        }

        $vote = $this->vote_model->get_vote_by_id($vote_id);

        if(!$vote) {

            redirect('error/error_404');
        }

        $data['vote'] = $vote;

        $data['roll_call_votes'] = $this->vote_model->get_roll_call_votes($vote_id);
        $data['vote_stats'] = $this->vote_model->get_roll_call_stats($vote_id);

        if($vote->location == 'h') {
            $location = 'House';
        }else {
            $location = 'Senate';
        }

        $this->template->set('page_description','Complete detail for '.$location.' Roll Call '.$vote->number);
        $this->template->set('title', 'OpenBama - Vote Detail for '.$location.' Roll Call '.$vote->number);
        $this->template->load('template/template', 'vote', $data);

    }

    function all() {

        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }else {
            $sort = 'intro';
        }

        if (isset($_GET['per_page'])) {
            $row = $_GET['per_page'];
        }else {
            $row = 0;
        }

        $votes = $this->vote_model->get_votes($sort, 'all', DEFAULT_SESSION,$row);
        $data['votes'] = $votes;

        $row_count = $this->vote_model->get_votes_count('all',DEFAULT_SESSION)->row_count;

        $config['base_url']= base_url().INDEX_TO_INCLUDE.'vote/all?sort='.$sort;
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        $most_viewed = $this->vote_model->get_most_viewed_vote(DEFAULT_SESSION);
        $data['most_viewed_vote'] = $most_viewed;

        $this->template->set('page_description','Listing of all votes.');
        $this->template->set('title', 'OpenBama - Votes ');
        $this->template->load('template/template', 'votes', $data);
    }

    function house() {

        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }else {
            $sort = 'intro';
        }

        if (isset($_GET['per_page'])) {
            $row = $_GET['per_page'];
        }else {
            $row = 0;
        }

        $votes = $this->vote_model->get_votes($sort, 'house', DEFAULT_SESSION,$row);
        $data['votes'] = $votes;

        $row_count = $this->vote_model->get_votes_count('house',DEFAULT_SESSION)->row_count;

        $config['base_url']= base_url().INDEX_TO_INCLUDE.'vote/house?sort='.$sort;
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        $most_viewed = $this->vote_model->get_most_viewed_vote(DEFAULT_SESSION);
        $data['most_viewed_vote'] = $most_viewed;

        $this->template->set('page_description','Listing of all votes in the House of Representatives');
        $this->template->set('title', 'OpenBama - Votes ');
        $this->template->load('template/template', 'votes', $data);
    }

    function senate() {
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }else {
            $sort = 'intro';
        }

        if (isset($_GET['per_page'])) {
            $row = $_GET['per_page'];
        }else {
            $row = 0;
        }

        $votes = $this->vote_model->get_votes($sort, 'senate', DEFAULT_SESSION,$row);
        $data['votes'] = $votes;

        $row_count = $this->vote_model->get_votes_count('senate',DEFAULT_SESSION)->row_count;

        $config['base_url']= base_url().INDEX_TO_INCLUDE.'vote/senate?sort='.$sort;
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        $most_viewed = $this->vote_model->get_most_viewed_vote(DEFAULT_SESSION);
        $data['most_viewed_vote'] = $most_viewed;

        $this->template->set('page_description','Listing of all votes in the Senate');
        $this->template->set('title', 'OpenBama - Votes ');
        $this->template->load('template/template', 'votes', $data);
    }

    function fail() {
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }else {
            $sort = 'intro';
        }

        if (isset($_GET['per_page'])) {
            $row = $_GET['per_page'];
        }else {
            $row = 0;
        }

        $votes = $this->vote_model->get_votes($sort, 'fail', DEFAULT_SESSION,$row);
        $data['votes'] = $votes;

        $row_count = $this->vote_model->get_votes_count('fail',DEFAULT_SESSION)->row_count;

        $config['base_url']= base_url().INDEX_TO_INCLUDE.'vote/fail?sort='.$sort;
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        $most_viewed = $this->vote_model->get_most_viewed_vote(DEFAULT_SESSION);
        $data['most_viewed_vote'] = $most_viewed;

        $this->template->set('page_description','Listing of all failed votes');
        $this->template->set('title', 'OpenBama - Votes ');
        $this->template->load('template/template', 'votes', $data);
    }

    function pass() {
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }else {
            $sort = 'intro';
        }

        if (isset($_GET['per_page'])) {
            $row = $_GET['per_page'];
        }else {
            $row = 0;
        }

        $votes = $this->vote_model->get_votes($sort, 'pass', DEFAULT_SESSION,$row);
        $data['votes'] = $votes;

        $row_count = $this->vote_model->get_votes_count('pass',DEFAULT_SESSION)->row_count;

        $config['base_url']= base_url().INDEX_TO_INCLUDE.'vote/pass?sort='.$sort;
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        $most_viewed = $this->vote_model->get_most_viewed_vote(DEFAULT_SESSION);
        $data['most_viewed_vote'] = $most_viewed;

        $this->template->set('page_description','Listing of all passed votes');
        $this->template->set('title', 'OpenBama - Votes ');
        $this->template->load('template/template', 'votes', $data);

    }

    function latest() {

    }
}

/* End of file vote.php */
/* Location: ./system/application/controllers/vote.php */