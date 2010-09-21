<?php

class Welcome extends Controller {

    function Welcome() {
        parent::Controller();
        $this->load->library('Cache');
    }
    function test() {
        echo $this->uri->segment(1);
        echo $this->uri->segment(2);
    }

    function index() {

        $data['user_logged_in'] = $this->redux_auth->logged_in();
        $this->_load_xajax();
        $this->load->model('lookup_model');

        //get subjects from cache first
        if (!$subjects = $this->cache->get('all-subjects')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
            $subjects = $this->lookup_model->get_subjects_list(DEFAULT_SESSION);

            $this->cache->save('all-subjects', $subjects,NULL,900);

        }

        //get subjects from cache first
        //if (!$action_dates = $this->cache->get('action-dates')) {
        //echo("Cache miss!");

        //This would be a really 'heavy' object (slow to generate)
        $action_dates = $this->lookup_model->get_action_date_list(DEFAULT_SESSION);

        $this->cache->save('action-dates', $action_dates,NULL,900);

        //}

        $data['action_dates'] = $action_dates;

        //$subjects = $this->lookup_model->get_subjects_list(DEFAULT_SESSION);
        $data['subjects'] = $subjects;

        $this->load->model('person_model');




        //$popular_senator = $this->person_model->get_most_popular_person(DEFAULT_SESSION,'sen');
        //$popular_representative = $this->person_model->get_most_popular_person(DEFAULT_SESSION,'rep');
        $this->load->model('bill_model');


        $this->load->model('issue_model');





//        if (!$bill_tag_cloud = $this->cache->get('bill-tag-cloud')) {

            $this->load->model('tagcloud_model');

            //This would be a really 'heavy' object (slow to generate)
            $bill_tag_cloud = $this->tagcloud_model->get_bill_tag_cloud(DEFAULT_SESSION);

//            $this->cache->save('bill-tag-cloud', $bill_tag_cloud, NULL, 900);
//
//        }

        $data['bill_tag_cloud'] = $bill_tag_cloud;

        $this->template->set('page_description',"OpenBama.org is a website that compiles data from various sources regarding the Alabama Legislature into an easy to use format and tools placing the legislative process within reach of the the general public.  OpenBama.org is an independent, volunteer-run website that is not affiliated with the Alabama Legislature or state government.");
        $this->template->set('title', 'Welcome to OpenBama');
        $this->template->load('template/template', 'index2',$data);


    }

    function populate_sponsors_onchange($locationID) {

        $objResponse = new xajaxResponse();


        if ($locationID != '0') {
            $output = $this->build_sponsor_dropdownlist($locationID,'0');
            $objResponse->Assign("sponsorsListDiv", "innerHTML", $output);

        }
        else {
            $objResponse->Assign("sponsorsListDiv", "innerHTML", "");
        }


        return $objResponse;
    }

    function build_sponsor_dropdownlist($locationID,$selected) {
        $this->load->model('person_model');

        $output = "<select id='sponsor_list' name='Sponsor_list' onchange=\"open_bama_toggle('sponsor_submit_div')\">";

        $output .= $this->new_option('-- Please select a sponsor --', '0', $selected);

        $query = $this->person_model->get_Sponsors_By_Location($locationID,DEFAULT_SESSION);

        foreach ($query->result() as $row) {
            $output .= $this->new_option($row->full_name, $row->id, 0);
        }

        $output .= "</select'>";

        return ($output);
    }

    function _load_xajax() {

        $this->xajax->registerFunction(array('populate_sponsors_onchange', &$this, 'populate_sponsors_onchange'));
        $this->xajax->processRequest();

    }

    function new_option($text, $value, $value_cmp) {
        $output = "<option value=\"" . $value . "\"";

        if ($value === $value_cmp) {
            $output .= " selected";
        }

        $output .= ">" . $text . "</option>";

        return ($output);
    }

    function autocomplete() {
        $sys_lib = BASEPATH . '/libraries';
        $app_lib = APPPATH . '/libraries';
        $app_model = APPPATH . '/models';

        echo "&lt;?php<br><br>";
        echo "/**<br/>";
        echo '* @property CI_DB_active_record $db<br/>';
        echo '* @property CI_DB_forge $dbforge<br/>';

        if ($handle = opendir($sys_lib)) {
			/* This is the correct way to loop over the directory. */
            while (false !== ($file = readdir($handle))) {
                if($file[0] == '.') continue;
                $files = explode('.', $file);
                $file = $files[0];
                $file2 = $file;
                if($file == 'index') continue;
                if($file == 'Loader') $file2 = 'load';
                echo "* @property CI_" . $file . " $" . strtolower($file2) . "<br/>";

            }
            closedir($handle);
        }
        if ($handle = opendir($app_lib)) {
			/* This is the correct way to loop over the directory. */
            while (false !== ($file = readdir($handle))) {
                if($file[0] == '.') continue;
                $files = explode('.', $file);
                $file = $files[0];
                $file_parts = explode('_', $file);
                $first_part = $file_parts[0];
                if($first_part == 'index' || $first_part == 'MY') continue;
                if(count($file_parts) > 1) {
                    $last_part = $file_parts[1];
                    echo "* @property " . ucfirst($first_part) . "_" . ucfirst($last_part) . " $" . strtolower($first_part) . "_" . strtolower($last_part) ."<br/>";
                }
                else {
                    echo "* @property " . ucfirst($first_part) . " $" . strtolower($first_part)."<br/>";
                }

            }
            closedir($handle);
        }
        if ($handle = opendir($app_model)) {
			/* This is the correct way to loop over the directory. */
            while (false !== ($file = readdir($handle))) {
                if($file[0] == '.') continue;
                $files = explode('.', $file);
                $file = $files[0];
                if($file == 'index') continue;
                $file_parts = explode('_', $file);
                $first_part = $file_parts[0];
                $last_part = $file_parts[1];
                echo "* @property " . ucfirst($first_part) . "_" . ucfirst($last_part) . " $" . strtolower($first_part) . "_" . strtolower($last_part) ."<br/>";

            }
            closedir($handle);
        }
        echo "*/<br><br>";
        echo "class Controller {}<br><br>";
        echo "?>";
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */