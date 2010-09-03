<?php
class Committee extends Controller {

    function Committee() {
        parent::Controller();
        $this->load->model('committee_model');
        $this->load->library('pagination');
    }

    function index() {

        redirect('committee/name');

    }

    function name() {
       
        $row = $this->uri->segment(3);

        if(!$row) $row = 0;

        $data['committees'] = $this->committee_model->get_all_committees('name',$row);
        $data['committee_meetings_house'] = $this->committee_model->get_all_committee_meetings_for_house();
        $data['committee_meetings_senate'] = $this->committee_model->get_all_committee_meetings_for_senate();

        $row_count = $this->committee_model->get_all_committees_count()->row_count;

        $config['base_url']= base_url().'index.php/committee/name/';
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['uri_segment'] = 3;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;
        $most_viewed = $this->committee_model->get_most_viewed_committee(DEFAULT_SESSION);
        $data['most_viewed_committee'] = $most_viewed;

        $this->template->set('page_description','Listing of committees');
        $this->template->set('title', 'OpenBama - Committees ');
        $this->template->load('template/template', 'committees', $data);
    }

    function viewed() {
        
        $row = $this->uri->segment(3);

        if(!$row) $row = 0;

        $data['committees'] = $this->committee_model->get_all_committees('viewed',$row);
        $data['committee_meetings_house'] = $this->committee_model->get_all_committee_meetings_for_house();
        $data['committee_meetings_senate'] = $this->committee_model->get_all_committee_meetings_for_senate();

        $row_count = $this->committee_model->get_all_committees_count()->row_count;

        $config['base_url']= base_url().'index.php/committee/viewed/';
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['uri_segment'] = 3;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        $most_viewed = $this->committee_model->get_most_viewed_committee(DEFAULT_SESSION);
        $data['most_viewed_committee'] = $most_viewed;

        $this->template->set('page_description','Listing of committees sorted by most viewed');
        $this->template->set('title', 'OpenBama - Committees ');
        $this->template->load('template/template', 'committees_viewed', $data);
    }

    function display() {

    //get committee id from url for display
        $committee_id = $this->uri->segment(3);

        //Get ip of visitor
        $ip = $_SERVER['REMOTE_ADDR'];

        //Record this viewing
        $this->committee_model->insert_committee_view($ip,$committee_id);

        $committee = $this->committee_model->get_committee_by_id($committee_id);

        if(!$committee) {

            redirect('error/error_404');
        }

        $data['committee'] = $committee;

        $data['members'] = $this->committee_model->get_committee_members($committee_id, DEFAULT_SESSION);
        $data['subcommittees'] = $this->committee_model->get_committee_subcommittees($committee_id);
        $data['bills'] = $this->committee_model->get_committee_bills($committee_id,DEFAULT_SESSION);

        $data['committee_meetings'] = $this->committee_model->get_committee_meetings($committee_id);

        if ($committee->subcommittee_name) {
            $title_bar_text = 'OpenBama - Committee Detail for '.$committee->committee_name.' ('.$committee->subcommittee_name.')';
        }else {
            $title_bar_text = 'OpenBama - Committee Detail for '.$committee->committee_name;
        }

        $contact_info = $this->committee_model->get_committee_members_email_addresses($committee_id,DEFAULT_SESSION);


        $data['contact_info'] = $contact_info;

        $this->template->set('page_description',$title_bar_text);
        $this->template->set('title', $title_bar_text);
        $this->template->load('template/template', 'committee', $data);

    }

    function meeting($meeting_id = null) {
        $data['meeting'] = $this->committee_model->get_committee_meeting_detail($meeting_id);
        $data['bills'] = $this->committee_model->get_committee_meeting_bills($meeting_id);

        $this->template->set('page_description','Committee meeting detail');
        $this->template->set('title', 'OpenBama.org - Committee Meeting');
        $this->template->load('template/template', 'meeting', $data);
    }

    function contact_sheet($committee_id = NULL){
        
        $contact_info = $this->committee_model->get_committee_members_contact_info($committee_id,DEFAULT_SESSION);
        
        $data['contact_info'] = $contact_info;

        $this->template->set('page_description','Committee members contact sheet');
        $this->template->set('title', 'OpenBama.org - Committee Contact Sheet');
        $this->load->view('committee_contact_sheet', $data);
    }
}

/* End of file committee.php */
/* Location: ./system/application/controllers/committee.php */