<?php

class Issue extends Controller {

    function Issue() {
        parent::Controller();
        $this->load->model('issue_model');
        $this->load->library('Cache');
		$this->load->library('user_agent');
    }

    function get_most_viewed_issue() {

        if (!$most_viewed_issue = $this->cache->get('most-viewed-issue')) {
        //echo("Cache miss!");
        
        //This would be a really 'heavy' object (slow to generate)
            $most_viewed_issue = $this->issue_model->get_most_viewed_issue_past7days(DEFAULT_SESSION);

            $this->cache->save('most-viewed-issue', $most_viewed_issue, NULL, 900);

        }

        $data['most_viewed_issue'] = $most_viewed_issue;

        $this->load->view('page_parts/most_viewed_issue',$data);
    }
    function display() {

        $issue_id = $this->uri->segment(3);

        //Get ip of visitor
        $ip = $_SERVER['REMOTE_ADDR'];

        //Record this viewing
        if (!$this->agent->is_robot()){
			$this->issue_model->insert_issue_view($ip,$issue_id);
        }

        $issue = $this->issue_model->get_issue_by_id($issue_id);

        if(!$issue) {

            redirect('error/error_404');
        }

        $data['issue'] = $issue;
        $data['bills'] = $this->issue_model->get_bills_by_issue_id($issue_id, DEFAULT_SESSION);

        $this->template->set('page_description',"Displays all bills associated with the issue ".$issue->subject);
        $this->template->set('title', 'OpenBama - Issue Detail for '.$issue->subject);
        $this->template->load('template/template', 'issue', $data);
    }

    function index() {



        $issues = $this->issue_model->get_all_issues(DEFAULT_SESSION,'name');
        $data['issues'] = $issues;

        $this->template->set('page_description',"List all issues.");
        $this->template->set('title', 'OpenBama - Issues ');
        $this->template->load('template/template', 'issues', $data);

    }

    function viewed() {



        $issues = $this->issue_model->get_all_issues(DEFAULT_SESSION,'viewed');
        $data['issues'] = $issues;


        $this->template->set('page_description',"List all issues sorted by most viewed.");
        $this->template->set('title', 'OpenBama - Issues sorted by most viewed');
        $this->template->load('template/template', 'issues', $data);

    }

    function bills() {



        $issues = $this->issue_model->get_all_issues(DEFAULT_SESSION,'bills');
        $data['issues'] = $issues;


        $this->template->set('page_description',"All issues sorted by the number bills associated with each issue.");
        $this->template->set('title', 'OpenBama - Issues ');
        $this->template->load('template/template', 'issues', $data);

    }
}

/* End of file issue.php */
/* Location: ./system/application/controllers/issue.php */