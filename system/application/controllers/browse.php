<?php
class Browse extends Controller {

    function Browse() {
        parent::Controller();
        $this->load->model('bill_model');
    }

    function index() {
        $data['user_logged_in'] = $this->redux_auth->logged_in();
        $this->_load_xajax();
        $this->load->model('lookup_model');
        $subjects = $this->lookup_model->get_subjects_list(DEFAULT_SESSION);
        $data['subjects'] = $subjects;

        $this->template->set('page_description','Browse all bills');
        $this->template->set('title', 'OpenBama.org - Browse Bills');
        $this->template->load('template/template', 'browse',$data);

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

        $output = "<select id='sponsor_list' name='Sponsor_list' onchange=\"toggle('sponsor_submit_div')\">";

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
}

/* End of file bill.php */
/* Location: ./system/application/controllers/bill.php */