<?php
class Bill extends Controller {

    function Bill() {
        parent::Controller();
        $this->load->model('bill_model');
        $this->load->library('pagination');
        $this->load->library('Cache');
    }

    function get_most_popular_bill() {

        if (!$popular_bill = $this->cache->get('popular-bill')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $popular_bill = $this->bill_model->get_most_popular_bill(DEFAULT_SESSION);

            $this->cache->save('popular-bill', $popular_bill, NULL, 900);

        }
        //$popular_bill = $this->bill_model->get_most_popular_bill(DEFAULT_SESSION);


        $data['popular_bill'] = $popular_bill;

        $this->load->view('page_parts/most_popular_bill',$data);
    }

    function get_most_viewed_bill() {

        if (!$most_viewed_bill = $this->cache->get('most-viewed-bill')) {

        //This would be a really 'heavy' object (slow to generate)
            $most_viewed_bill = $this->bill_model->get_most_viewed_bill(DEFAULT_SESSION);

            $this->cache->save('most-viewed-bill', $most_viewed_bill, NULL, 900);

        }

        //$most_viewed = $this->bill_model->get_most_viewed_bill(DEFAULT_SESSION);
        $data['most_viewed_bill'] = $most_viewed_bill;

        $this->load->view('page_parts/most_viewed_bill',$data);
    }

    function display () {
        $return_url = str_replace('/','-',$this->uri->uri_string());

        $bill_id = $this->uri->segment(3);

        if(!$bill_id)
            redirect('bill/all');

        //Register ajax functions
        $this->_load_xajax();

        //Set login status
        $logged_in = $this->redux_auth->logged_in();

        //Set $user_looged_in variable
        $data['user_logged_in'] = $logged_in;

        //Determin user specific variables based on login status
        if ($logged_in) {
            $user_profile = $this->redux_auth->profile();

            $user_id = $user_profile->id;

            $data['support_vote_onclick'] = 'xajax_vote(true);return false;';
            $data['no_support_vote_onclick'] = 'xajax_vote(false);return false;';
            $data['support_vote_href'] = '#';
            $data['no_support_vote_href'] = '#';


            $user_support = $this->bill_model->get_bill_support_status_for_user($bill_id,$user_id);

            if ($user_support && $user_support->support) {
                $data['support_status'] = '<span class="ui-icon ui-icon-info"
				style="float: left; margin-right: .3em;"></span>
                You are currently a supporter.<br>';
            //$data['support_status'] = 'You are currently a supporter.<br><br>';
            }elseif($user_support && !$user_support->support) {
                $data['support_status'] = '<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                You are not a supporter.<br>';
            //$data['support_status'] = 'You are not a supporter.<br><br>';
            }else {
                $data['support_status'] = '';
            }
        }else {
            $data['support_vote_onclick'] = '';
            $data['no_support_vote_onclick'] = '';
            $data['support_vote_href'] = base_url().'index.php/auth/login/'.$return_url;
            $data['no_support_vote_href'] = base_url().'index.php/auth/login/'.$return_url;

            $data['support_status'] = '';
        }

        //Get ip of visitor
        $ip = $_SERVER['REMOTE_ADDR'];

        //Record this viewing
        $this->bill_model->insert_bill_view($ip,$bill_id);

        $bill = $this->bill_model->get_Bill_Detail_By_ID($bill_id);

        if(!$bill) {

            redirect('error/error_404');
        }

        $data['bill'] = $bill;
        $data['cosponsors'] = $this->bill_model->get_All_Bill_CoSponsors($bill_id);
        $data['related_bills'] = $this->bill_model->get_related_bills($bill_id);
        $data['committees'] = $this->bill_model->get_bill_committees($bill_id);
        $bill_actions = $this->bill_model->get_bill_actions($bill_id);
        $data['bill_actions'] = $bill_actions;
        $data['dem_party_support'] = $this->bill_model->get_bill_dem_support($bill_id);
        $data['repub_party_support'] = $this->bill_model->get_bill_repub_support($bill_id);

        $data['committee_meetings'] = $this->bill_model->get_committee_meetings_for_bill($bill_id);

        if ($bill_actions) {
            $data['last_action'] = array_pop($bill_actions);
        }else {
            $data['last_action'] = false;
        }
        $data['bill_status_list'] = $this->bill_model->get_bill_status_list_by_id($bill_id);
        $data['bill_version_types'] = $this->bill_model->get_bill_version_types($bill_id);
        $data['comments'] =  $this->bill_model->get_bill_comments($bill_id);
        $data['page_view_stats'] = $this->bill_model->get_page_view_stats($bill_id);
        $data['vote_stats'] = $this->bill_model->get_bill_rating($bill_id);

        $this->load->model('tagcloud_model');

        $data['tags'] = $this->tagcloud_model->get_bill_tags($bill_id);

        $this->template->set('page_description',"Complete detail for bill/resolution ".strtoupper($bill->bill_type).$bill->number.' - '.$bill->description);
        $this->template->set('title', 'OpenBama - Bill Detail for '.strtoupper($bill->bill_type).$bill->number);
        $this->template->load('template/template', 'bill', $data);

    }

    function all() {



        $sort = $this->uri->segment(3);
        $row = $this->uri->segment(4);

        if(!$row) $row = 0;
        if(!$sort) $sort = 'intro';

        if (!$bills = $this->cache->get('all-bills'.$sort.$row)) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $bills = $this->bill_model->get_All(DEFAULT_SESSION, $sort,'',$row);

            $this->cache->save('all-bills'.$sort.$row, $bills, NULL, 900);

        }

        //$bills = $this->bill_model->get_All(DEFAULT_SESSION, $sort,'',$row);

        $data['bills'] = $bills;

        if (!$row_count = $this->cache->get('all-bills-count')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $row_count = $this->bill_model->get_all_count(DEFAULT_SESSION, '')->row_count;

            $this->cache->save('all-bills-count', $row_count, NULL, 900);

        }

        $config['base_url']= base_url().'index.php/bill/all/'.$sort.'/';
        $config['total_rows']= $row_count;
        $config['per_page']='50';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;




        //            $this->session->set_flashdata('most_viewed_bill',$most_viewed);
        //        }else
        //        {
        //            $data['most_viewed_bill'] = $this->session->userdata('most_viewed_bill');
        //        }

        $this->template->set('page_description','Listing all bills and resolutions');
        $this->template->set('title', 'OpenBama - All Bills');
        $this->template->load('template/template', 'bills', $data);

    }

    function bills() {



        $sort = $this->uri->segment(3);
        $row = $this->uri->segment(4);

        if(!$row) $row = 0;

        if(!$sort) $sort = 'intro';

        if (!$bills = $this->cache->get('bills-only-'.$sort.$row)) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $bills = $this->bill_model->get_All(DEFAULT_SESSION,$sort,'bills',$row);

            $this->cache->save('bills-only-'.$sort.$row, $bills, NULL, 900);

        }

        $data['bills'] = $bills;

        $row_count = $this->bill_model->get_all_count(DEFAULT_SESSION, 'bills')->row_count;

        $config['base_url']= base_url().'index.php/bill/bills/'.$sort.'/';
        $config['total_rows']= $row_count;
        $config['per_page']='50';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        if (!$most_viewed = $this->cache->get('most-viewed-bill')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $most_viewed = $this->bill_model->get_most_viewed_bill(DEFAULT_SESSION);

            $this->cache->save('most-viewed-bill', $most_viewed, NULL, 900);

        }

        $data['most_viewed_bill'] = $most_viewed;

        if (!$most_popular = $this->cache->get('most-popular-bill')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $most_popular = $this->bill_model->get_popular_bill(DEFAULT_SESSION);

            $this->cache->save('most-popular-bill', $most_popular, NULL, 900);

        }

        $data['most_popular_bill'] = $most_popular;


        $this->template->set('page_description','Listing of all bills');
        $this->template->set('title', 'OpenBama - All Bills');
        $this->template->load('template/template', 'bills', $data);

    }

    function resolutions() {



        $sort = $this->uri->segment(3);

        $row = $this->uri->segment(4);

        if(!$row) $row = 0;

        if(!$sort) $sort = 'intro';


        $data['bills'] = $this->bill_model->get_All(DEFAULT_SESSION,$sort,'resolutions',$row);
        $row_count = $this->bill_model->get_all_count(DEFAULT_SESSION, 'resolutions')->row_count;

        $config['base_url']= base_url().'index.php/bill/resolutions/'.$sort.'/';
        $config['total_rows']= $row_count;
        $config['per_page']='50';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        if (!$most_viewed = $this->cache->get('most-viewed-bill')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $most_viewed = $this->bill_model->get_most_viewed_bill(DEFAULT_SESSION);

            $this->cache->save('most-viewed-bill', $most_viewed, NULL, 900);

        }

        $data['most_viewed_bill'] = $most_viewed;

        if (!$most_popular = $this->cache->get('most-popular-bill')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $most_popular = $this->bill_model->get_popular_bill(DEFAULT_SESSION);

            $this->cache->save('most-popular-bill', $most_popular, NULL, 900);

        }

        $data['most_popular_bill'] = $most_popular;

        $this->template->set('page_description','Listing of all resolutions');
        $this->template->set('title', 'OpenBama - All Resolutions');
        $this->template->load('template/template', 'bills', $data);

    }

    function house() {

        $sort = $this->uri->segment(3);

        $row = $this->uri->segment(4);

        if(!$row) $row = 0;
        if(!$sort) $sort = 'intro';


        $data['bills'] = $this->bill_model->get_All(DEFAULT_SESSION,$sort,'house',$row);

        $row_count = $this->bill_model->get_all_count(DEFAULT_SESSION, 'house')->row_count;

        $config['base_url']= base_url().'index.php/bill/house/'.$sort.'/';
        $config['total_rows']= $row_count;
        $config['per_page']='50';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        if (!$most_viewed = $this->cache->get('most-viewed-bill')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $most_viewed = $this->bill_model->get_most_viewed_bill(DEFAULT_SESSION);

            $this->cache->save('most-viewed-bill', $most_viewed, NULL, 900);

        }

        $data['most_viewed_bill'] = $most_viewed;

        if (!$most_popular = $this->cache->get('most-popular-bill')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $most_popular = $this->bill_model->get_popular_bill(DEFAULT_SESSION);

            $this->cache->save('most-popular-bill', $most_popular, NULL, 900);

        }

        $data['most_popular_bill'] = $most_popular;

        $this->template->set('page_description','Listing of all bills in the House of Representatives.');
        $this->template->set('title', 'OpenBama - All House Bills');
        $this->template->load('template/template', 'bills', $data);


    }

    function senate() {




        $sort = $this->uri->segment(3);

        $row = $this->uri->segment(4);

        if(!$row) $row = 0;
        if(!$sort) $sort = 'intro';


        $data['bills'] = $this->bill_model->get_All(DEFAULT_SESSION,$sort,'senate',$row);

        $row_count = $this->bill_model->get_all_count(DEFAULT_SESSION, 'senate')->row_count;

        $config['base_url']= base_url().'index.php/bill/senate/'.$sort.'/';
        $config['total_rows']= $row_count;
        $config['per_page']='50';
        $config['uri_segment'] = 4;
        $config['num_links'] = 10;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $data['row_count'] = $row_count;

        if (!$most_viewed = $this->cache->get('most-viewed-bill')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $most_viewed = $this->bill_model->get_most_viewed_bill(DEFAULT_SESSION);

            $this->cache->save('most-viewed-bill', $most_viewed, NULL, 900);

        }

        $data['most_viewed_bill'] = $most_viewed;

        if (!$most_popular = $this->cache->get('most-popular-bill')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $most_popular = $this->bill_model->get_popular_bill(DEFAULT_SESSION);

            $this->cache->save('most-popular-bill', $most_popular, NULL, 900);

        }

        $data['most_popular_bill'] = $most_popular;

        $this->template->set('page_description','Listing of all bills in the Senate');
        $this->template->set('title', 'OpenBama - All Senate Bills');
        $this->template->load('template/template', 'bills', $data);


    }

    function recent() {

        $data['bills'] = $this->bill_model->get_All_Recent(DEFAULT_SESSION);

        $most_viewed = $this->bill_model->get_most_viewed_bill(DEFAULT_SESSION);
        $data['most_viewed_bill'] = $most_viewed;

        $most_popular = $this->bill_model->get_popular_bill(DEFAULT_SESSION);
        $data['most_popular_bill'] = $most_popular;

        $this->template->set('page_description','Listing of bills sorted by most recent activity.');
        $this->template->set('title', 'OpenBama - Recent Activity');
        $this->template->load('template/template', 'bills', $data);

    }

    function get_version_text($bill_id,$version_type) {
        $objResponse = new xajaxResponse();

        // $this->load->model('bill_model');

        if ($version_type != '0') {
            $bill_text = $this->bill_model->get_bill_text($bill_id,$version_type);
            //            $bill = $this->bill_model->get_Bill_Detail_By_ID($bill_id);
            $output = "<br><br>";

            //Check to see if text avaialbe
            if ($bill_text) {
                foreach($bill_text as $row) {
                    $output = $output.'<pre id="'.$row->id.'">'.$row->node_text.'</pre>';
                }
            }else {
                $output = $output.'<b>Text current not available</b>';
            }

            //            $bill_file_path = BILLS_FILE_LOCATION.$bill->session_identifier.'/'.$bill->bill_type.$bill->number.'-'.$version_type.'.html';
            //            $output = $output.file_get_contents($bill_file_path);
            //
            $objResponse->Assign("bill_text_div", "innerHTML", $output);

        }
        else {
            $objResponse->Assign("bill_text_div", "innerHTML", "");
        }


        return $objResponse;
    }

    function vote($vote) {
    //$this->load->model('bill_model');

        $bill_id = $this->uri->segment(3);

        $user_profile = $this->redux_auth->profile();

        $user_id = $user_profile->id;

        $current_vote = $this->bill_model->get_bill_user_vote($bill_id,$user_id);

        if ($current_vote) {
            $bill_votes_id = $current_vote->id;

            $this->bill_model->update_bill_vote($bill_votes_id, $vote);
        }else {

            $this->bill_model->insert_bill_vote($bill_id,$user_id,$vote);
        }

        $objResponse = new xajaxResponse();

        $vote_stats = $this->bill_model->get_bill_rating($bill_id);

        if ($vote) {
        //$support_text = 'You support this legislation.';
            $support_html = '<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                Your vote has been recorded.  Thank you for your vote!  You support this legislation.<br><br>';
            $support_html = $support_html.'<strong>'.round($vote_stats->PercentSupport).'%</strong> users support this bill<br>';
            $support_html = $support_html.$vote_stats->TotalSupport.' support /';
            $support_html = $support_html.$vote_stats->TotalNotSupport.' do not support';
        }else {
        //$support_text = 'You do not support this legislation.';
            $support_html = '<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                Your vote has been recorded.  Thank you for your vote!  You do not support this legislation.<br><br>';
            $support_html = $support_html.'<strong>'.round($vote_stats->PercentSupport).'%</strong> users support this bill<br>';
            $support_html = $support_html.$vote_stats->TotalSupport.' support /';
            $support_html = $support_html.$vote_stats->TotalNotSupport.' do not support';
        }

        $objResponse->Assign("bill_vote_results_div", "innerHTML", $support_html);

        return $objResponse;
    }

    function login_to_vote() {
        redirect('auth/login');
    }

    function add_comment() {

        $logged_in = $this->redux_auth->logged_in();

        if (!$logged_in) {

            redirect('auth/login');
        }

        // if HTTP POST is sent, add the data to database
        if($_POST && $_POST['comment'] != NULL) {

            $comment = $_POST['comment'];

            $user_profile = $this->redux_auth->profile();

            $user_id = $user_profile->id;
            $user_name = $user_profile->username;
            $bill_id = $_POST['bill'];

            $this->bill_model->insert_bill_comment($bill_id,$user_id,$comment,$user_name);

        } else
            redirect('bill/view_comments');

    }

    function view_comments($bill_id = NULL) {

        $data['comments'] =  $this->bill_model->get_bill_comments($bill_id);

        //if ($type == "ajax") // load inline view for call from ajax
        $this->load->view('comments_list', $data);
    //else // load the default view
    // $this->load->view('default', $data);

    }

    function fulltext($bill_id = null) {

        $bill = $this->bill_model->get_Bill_Detail_By_ID($bill_id);

        if(!$bill) {
            redirect('error/error_404');
        }

        $data['bill'] = $bill;

        $session = $this->bill_model->get_html_repository_for_session($bill->session_identifier);

        if($bill->bill_type != 'sb' && $bill->bill_type != 'hb') {
            $base_url = $session->bill_html_repository.'resolutions/';
        }else {
            $base_url = $session->bill_html_repository.'bills/';
        }

        $data['bill_version_types'] = $this->bill_model->get_bill_version_types($bill_id);

        $opts = array(
            'http'=>array(
            'method'=>"GET",
            'header'=>"Accept-language: en\r\n" .
            "Cookie: foo=bar\r\n"
            )
        );

        $context = stream_context_create($opts);

        try {
            $output = file_get_contents($base_url.$bill->bill_type.$bill->number.'.htm',false,$context);
        } catch (Exception $e) {
            $output = 'Text unavailable at this time.  Please contact <a href="mailto:info@openbama.org">OpenBama.org</a> to inquire about the text of this legislation.';
        }

        $data['bill_text'] = $output;

        $this->template->set('page_description','The full text of bill '.strtoupper($bill->bill_type).$bill->number);
        $this->template->set('title', 'OpenBama - Full Text of bill '.strtoupper($bill->bill_type).$bill->number);
        $this->template->load('template/template', 'bill_full_text', $data);

    }

    function _load_xajax() {

        $this->xajax->registerFunction(array('get_version_text', &$this, 'get_version_text'));
        $this->xajax->registerFunction(array('vote', &$this, 'vote'));

        $this->xajax->processRequest();

    }
}

/* End of file bill.php */
/* Location: ./system/application/controllers/bill.php */