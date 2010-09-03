<?php

class Person extends Controller {

    function Person() {
        parent::Controller();
        $this->load->model('person_model');
        $this->load->library('pagination');
        $this->load->library('Cache');
    }

    function get_most_viewed_senator() {
        $most_viewed = $this->person_model->get_most_viewed_person(DEFAULT_SESSION,'sen');
        $data['most_viewed_person'] = $most_viewed;

        $this->load->view('page_parts/most_viewed_senator',$data);
    }

    function get_most_viewed_representative() {
        $most_viewed = $this->person_model->get_most_viewed_person(DEFAULT_SESSION,'rep');
        $data['most_viewed_person'] = $most_viewed;

        $this->load->view('page_parts/most_viewed_representative',$data);
    }

    function get_most_popular_senator() {
        if (!$popular_senator = $this->cache->get('popular-senator')) {

        //This would be a really 'heavy' object (slow to generate)
            $popular_senator = $this->person_model->get_most_popular_person(DEFAULT_SESSION,'sen');

            $this->cache->save('popular-senator', $popular_senator, NULL, 900);

        }

        $data['popular_senator'] = $popular_senator;

        $this->load->view('page_parts/most_popular_senator',$data);
    }

    function get_most_popular_representative() {
        if (!$popular_representative = $this->cache->get('popular-rep')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $popular_representative = $this->person_model->get_most_popular_person(DEFAULT_SESSION,'rep');

            $this->cache->save('popular-rep', $popular_representative, NULL, 900);

        }

        $data['popular_representative'] = $popular_representative;

        $this->load->view('page_parts/most_popular_representative',$data);
    }

    function senators() {

        $filter = $this->uri->segment(3);
        $sort = $this->uri->segment(4);
        $row = $this->uri->segment(5);

        if(!$sort) $sort = 'name';

        if(!$filter) $filter = 'all';

        if(!$row) $row = 0;

        $senators = $this->person_model->get_Senators(DEFAULT_SESSION, $filter, $sort,$row);

        $data['members'] = $senators;
        $row_count = $this->person_model->get_senators_count(DEFAULT_SESSION, $filter)->row_count;

        $config['base_url']= base_url().'index.php/person/senators/'.$filter.'/'.$sort.'/';
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['uri_segment'] = 5;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        $most_viewed = $this->person_model->get_most_viewed_person(DEFAULT_SESSION,'sen');
        $data['most_viewed_person'] = $most_viewed;

        $this->template->set('page_description',"List of all senators.");
        $this->template->set('title', 'OpenBama - Senators');
        $this->template->load('template/template','people',$data);

    }

    function senators_ajax() {

        $filter = $this->uri->segment(3);
        $sort = $this->uri->segment(4);
        $row = $this->uri->segment(5);
        $div_id = $this->uri->segment(6);

        if(!$sort) $sort = 'name';

        if(!$filter) $filter = 'all';

        if(!$row) $row = 0;

        $senators = $this->person_model->get_Senators(DEFAULT_SESSION, $filter, $sort,$row);

        $data['members'] = $senators;
        $row_count = $this->person_model->get_senators_count(DEFAULT_SESSION, $filter)->row_count;

        $config['base_url']= "get_senators_part('".$div_id."','".$filter."','".$sort."',<NEXT_SET_COUNT>);";
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['is_onclick_event'] = TRUE;
        $config['uri_segment'] = 5;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;


        $this->load->view('page_parts/people_list',$data);

    }

    function representatives() {



        $filter = $this->uri->segment(3);
        $sort = $this->uri->segment(4);
        $row = $this->uri->segment(5);

        if(!$sort) $sort = 'name';

        if(!$filter) $filter = 'all';

        if(!$row) $row = 0;

        $reps = $this->person_model->get_Representatives(DEFAULT_SESSION,$sort,$filter,$row);
        $data['members'] = $reps;

        $row_count = $this->person_model->get_representatives_count(DEFAULT_SESSION, $filter)->row_count;

        $config['base_url']= base_url().'index.php/person/representatives/'.$filter.'/'.$sort.'/';
        $config['total_rows']= $row_count;
        $config['per_page']='10';
        $config['uri_segment'] = 5;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        $most_viewed = $this->person_model->get_most_viewed_person(DEFAULT_SESSION,'rep');
        $data['most_viewed_person'] = $most_viewed;

        $this->template->set('page_description',"List of all representatives.");
        $this->template->set('title', 'OpenBama - Representatives');
        $this->template->load('template/template','people',$data);
    }

    function display() {

    //Set login status
        $logged_in = $this->redux_auth->logged_in();

        if ($logged_in) {
            $user_profile = $this->redux_auth->profile();

            $user_id = $user_profile->id;
        }

        //Set $user_looged_in variable
        $data['user_logged_in'] = $logged_in;

        $person_id = $this->uri->segment(3);
        $member = $this->person_model->get_Person_By_ID($person_id);

        if(!$member) {

            redirect('error/error_404');
        }

        $ip = $_SERVER['REMOTE_ADDR'];

        $this->person_model->insert_person_view($ip, $person_id);

        $data['member'] = $member;
        $data['comments'] = $this->person_model->get_Person_Comments($person_id);
        $data['sponsored_bills'] =  $this->person_model->get_Sponsored_Bills($person_id,DEFAULT_SESSION);
        $data['cosponsored_bills'] =  $this->person_model->get_CoSponsored_Bills($person_id,DEFAULT_SESSION);
        $data['committees'] = $this->person_model->get_person_committees($person_id,DEFAULT_SESSION);
        $data['votes'] = $this->person_model->get_person_votes($person_id,DEFAULT_SESSION);
        $data['member_bio'] = $this->person_model->get_person_bio_by_id($person_id);
        $data['member_addresses'] = $this->person_model->get_person_addresses_by_id($person_id);
        $data['member_webaddress'] = $this->person_model->get_person_electronic_addresses_by_id($person_id);
        if($logged_in) {
            $data['user_rating'] = $this->person_model->get_user_person_rating($person_id,$user_id);
        }else {
            $data['user_rating'] = false;
        }

        if($member->title == 'Rep.') {
            $title_short = 'rep';
            $title_long = 'representative';
        }else {
            $title_short = 'sen';
            $title_long = 'senator';
        }
        $data['blog_entries'] = $this->_get_blog_entries($title_short, $title_long, $member->firstname, $member->lastname);
        $data['google_blogsearch_url'] = 'http://blogsearch.google.com/blogsearch?hl=en&ie=UTF-8&q='.$member->firstname.'+'.$member->lastname.'+'.$title_short.'+OR+'.$title_long.'&btnG=Search+Blogs';
        //'http://blogsearch.google.com/blogsearch?hl=en&ie=UTF-8&q='.$member->firstname.'+'.$member->lastname.'+'.$title_short.'+'.$title_long.'&btnG=Search+Blogs'
        //http://blogsearch.google.com/blogsearch_feeds?as_q=&safe=active&q=%22'.$first_name.'+'.$last_name.'%22+'.$title_short.'+OR+'.$title_long.'&ie=utf-8&num=10&output=rss'

        $data['person_rating'] =  $this->person_model->get_person_rating($person_id);

        $data['contributions'] = $this->person_model->get_person_contributions($member->imsp_candidate_id);

        $this->template->set('page_description',"Full detail for ".$member->full_name);
        $this->template->set('title', 'OpenBama - Detail for '.$member->full_name);
        $this->template->load('template/template','person',$data);

    }

    function add_comment() {

        $logged_in = $this->redux_auth->logged_in();

        if (!$logged_in) {
            $this->session->set_flashdata('return_url', $this->uri->uri_string());
            redirect('auth/login');
        }

        // if HTTP POST is sent, add the data to database
        if($_POST && $_POST['comment'] != NULL) {

            $comment = $_POST['comment'];

            $user_profile = $this->redux_auth->profile();

            $user_id = $user_profile->id;
            $user_name = $user_profile->username;
            $person_id = $_POST['person'];

            $this->person_model->insert_person_comment($person_id,$user_id,$comment,$user_name);

        } else
            redirect('person/view_comments');

    }

    function view_comments($person_id = NULL) {

        $data['comments'] =  $this->person_model->get_Person_Comments($person_id);

        //if ($type == "ajax") // load inline view for call from ajax
        $this->load->view('comments_list', $data);
    //else // load the default view
    // $this->load->view('default', $data);

    }

    function find_legislator() {
        $this->form_validation->set_rules('zippart1_text_box', 'Zip Code', 'required');

        if ($this->form_validation->run() == false) {
        //$data['content'] = $this->load->view('register', null, true);
            $this->template->set('page_description',"Locate your legislator.");
            $this->template->set('title', 'OpenBama - Find Your Legislator');
            $this->template->load('template/template','find_legislators');
        }else {
            $address = $this->input->post('address_text_box');
            $city = $this->input->post('city_text_box');
            $zippart1 = $this->input->post('zippart1_text_box');
            $zippart2 = $this->input->post('zippart2_text_box');

            $address = str_replace(' ','+',$address);
            $city = str_replace(' ','+',$city);

            $search_url = 'http://capwiz.com/state-al/dbq/zs.dbq?street='.$address.'&town='.$city.'&azip='.$zippart1.'&bzip='.$zippart2.'&state=AL';
            //'http://capwiz.com/state-al/dbq/zs.dbq?street=510+forest+lakes+drive&town=sterrett&azip=35147&bzip=&state=AL'

            header("Location: ".$search_url);
        }


    }

    function reload_rating($person_id = NULL) {

        $data['person_rating'] =  $this->person_model->get_person_rating($person_id);
        $this->load->view('person_rating_view',$data);
    }

    function rate_them() {
    // if HTTP POST is sent, add the data to database
        if($_POST && $_POST['person_rating'] != NULL) {

            $rating = $_POST['person_rating'];
            $person_id = $_POST['person'];

            $user_profile = $this->redux_auth->profile();

            $user_id = $user_profile->id;
            $user_name = $user_profile->username;


            $this->person_model->update_person_rating($person_id,$user_id,$rating);

        } else
            redirect('person/view_comments');
    }

    function _get_blog_entries($title_short,$title_long,$first_name,$last_name) {
        $this->load->library('simplepie');
        $this->simplepie->set_feed_url('http://blogsearch.google.com/blogsearch_feeds?as_q=&safe=active&q=%22'.$first_name.'+'.$last_name.'%22+'.$title_short.'+OR+'.$title_long.'&ie=utf-8&num=10&output=rss');
        $this->simplepie->set_cache_location(APPPATH.'cache/rss');
        $this->simplepie->init();
        $this->simplepie->handle_content_type();

        return $this->simplepie->get_items();
    }
}

/* End of file person.php */
/* Location: ./system/application/controllers/person.php */