<?php


class Search extends Controller {

    function Search() {
        parent::Controller();
        $this->load->model('bill_model');
        $this->load->model('issue_model');
    }

    function text_search() {
        $search_string = $this->input->post('search_text');

        $bills = $this->bill_model->bill_search($search_string);

        $data['bills'] = $bills;

        $data['heading'] = 'Search by text - '.$search_string;

        $this->template->set('page_description','Text search results');
        $this->template->set('title', 'Search Results');
        $this->template->load('template/template','searchresults',$data);
    }

    function status() {

        $status = $this->input->post('status_dropdownlist');
        if ($status == 'introduced') {
            $status_title = 'Introduced';
        }elseif ($status == 'vote') {
            $status_title = 'Vote in House of Origin';
        }elseif ($status == 'vote2') {
            $status_title = 'Vote in Second House';
        }elseif ($status == 'enacted') {
            $status_title = 'Enacted';
        }elseif ($status == 'veto') {
            $status_title = 'Veto';
        }elseif ($status == 'override') {
            $status_title = 'Override';
        }elseif ($status == 'togovernor') {
            $status_title = 'Sent to the Governor';
        }

        $data['heading'] = 'Search by status - '.$status_title;
        $data['bills'] = $this->bill_model->get_bills_by_status($status,DEFAULT_SESSION);

        $this->template->set('page_description','Bill status search results for status '.$status_title);
        $this->template->set('title', 'Search Results');
        $this->template->load('template/template','searchresults',$data);

    }

    function subject() {

        $issue_id = $this->input->post('subjects_list');

        $issue_name = $this->issue_model->get_issue_by_id($issue_id)->subject;

        if ($issue_id != '0') {
            $data['bills'] = $this->bill_model->get_bills_by_subject_id($issue_id,DEFAULT_SESSION);
            $data['heading'] = 'Search by issue - '.$issue_name;

            $this->template->set('page_description','Issue search results for issue '.$issue_name);
            $this->template->set('title', 'Search Results');
        }else {
            $data['bills'] = false;

            $this->template->set('page_description','Issue search results for unknown parameter');
            $this->template->set('title', 'Search Results');
            $data['heading'] = 'Search by date - Unknown searh parameter';

        }

        $this->template->load('template/template','searchresults',$data);

    }

    function action_date(){
        $action_date = $this->input->post('action_date_list');

        $data['heading'] = 'Search by date - Action Date '.$action_date;
        $data['bills'] = $this->bill_model->get_bills_by_action_date($action_date,DEFAULT_SESSION);

        $this->template->set('page_description','Action Date search results');
        $this->template->set('title', 'Search Results');
        $this->template->load('template/template','searchresults',$data);

    }

    function date() {

        $from_date = $this->input->post('datepickerBegin');
        $to_date = $this->input->post('datepickerEnd');
        $search_type = $this->input->post('dateTypeDD');

        if (strlen($from_date) > 0 && strlen($to_date) > 0 && $search_type != '0') {
            if($search_type == 'intro') {
                $data['heading'] = 'Search by date - Date introduced between '.$from_date.' and '.$to_date;
                $data['bills'] = $this->bill_model->get_Bills_By_Introduced_Date($from_date,$to_date,DEFAULT_SESSION);

            }elseif($search_type == 'enact') {
                $data['bills'] = $data['bills'] = $this->bill_model->get_Bills_By_Enacted_Date($from_date,$to_date,DEFAULT_SESSION);
                $data['heading'] = 'Search by date - Date enacted between '.$from_date.' and '.$to_date;

            }elseif($search_type == 'lastAction') {
                $data['bills'] = $this->bill_model->get_Bills_By_Last_Action_Date($from_date,$to_date,DEFAULT_SESSION);
                $data['heading'] = 'Search by date - Last action date between '.$from_date.' and '.$to_date;

            }elseif($search_type == 'lastVote') {
                $data['bills'] = $this->bill_model->get_Bills_By_Last_Vote_Date($from_date,$to_date,DEFAULT_SESSION);
                $data['heading'] = 'Search by date - Last action date between '.$from_date.' and '.$to_date;

            }elseif($search_type == 'sponsor') {
                $data['bills'] = $data['bills'] = $this->bill_model->get_Bills_By_Sponsor_Added_Date($from_date,$to_date,DEFAULT_SESSION);
                $data['heading'] = 'Search by date - Date sponsor added between '.$from_date.' and '.$to_date;
            }
        }else {
            $data['bills'] = false;
            $data['heading'] = 'Search by date - Unknown searh parameter';

        }

        $this->template->set('page_description','Date search results');
        $this->template->set('title', 'Search Results');
        $this->template->load('template/template','searchresults',$data);
    }

    function number() {
        $bill_number = $this->input->post('bill_number');

        $data['heading'] = 'Search by bill number - '.$bill_number;
        $data['bills'] = $this->bill_model->get_Bills_By_Number($bill_number,DEFAULT_SESSION);

        $this->template->set('page_description',"Search results for bill ".$bill_number);
        $this->template->set('title', 'Search Results');
        $this->template->load('template/template','searchresults',$data);
    }

    function sponsors() {
        $sponsor_id = $this->input->post('Sponsor_list');
        $sponsor_type = $this->input->post('sponsorTypeDD');
        $sponsor_location = $this->input->post('locationDD');

        $this->load->model('person_model');

        if ($sponsor_id != '0' && $sponsor_type != '0' && $sponsor_location != '0') {
            $sponsor_name = $this->person_model->get_Person_By_ID($sponsor_id)->full_name;

            if ($sponsor_type == 'C') {
                $data['heading'] = 'Search by cosponsor - '.$sponsor_name;
                $data['bills'] = $this->bill_model->get_Bills_By_CoSponsor($sponsor_id,DEFAULT_SESSION);

            }else {
                $data['heading'] = 'Search by sponsor - '.$sponsor_name;
                $data['bills'] = $this->bill_model->get_Bills_By_Sponsor($sponsor_id,DEFAULT_SESSION);

            }
        }else {
            $data['bills'] = false;
            $data['heading'] = 'Search by date - Unknown searh parameter';

        }

        $this->template->set('page_description','Search results for sponsor '.$sponsor_name);
        $this->template->set('title', 'Search Results');
        $this->template->load('template/template','searchresults',$data);

    }
}

/* End of file search.php */
/* Location: ./system/application/controllers/search.php */