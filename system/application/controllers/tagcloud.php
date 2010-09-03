<?php
class Tagcloud extends Controller {

    function Tagcloud() {
        parent::Controller();
        $this->load->model('tagcloud_model');

    }

    function display($tag_id = NULL) {
        $bills = $this->tagcloud_model->get_bills_by_tag_id($tag_id,DEFAULT_SESSION);
        $tag = $this->tagcloud_model->get_tag_by_id($tag_id);
        $data['tag'] = $tag;
        $data['bills'] = $bills;
        $data['heading'] = 'Bills tagged with "'.$tag->tag_name.'"';

        $this->template->set('page_description',"List bills for tag ".$tag->tag_name.'.');
        $this->template->set('title', 'OpenBama - Bills With Tag '.$tag->tag_name);
        $this->template->load('template/template', 'bills_by_tag', $data);
    }

    function add_tag_bill() {

    //        $this->form_validation->set_rules('tag_text_box', 'Tag', 'required');
    //        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

    //        if ($this->form_validation->run() == true) {
        $bill_id = $this->input->post('bill_id_text_box');
        $tag = strtolower($this->input->post('tag_text_box'));

        $this->tagcloud_model->insert_bill_tag($bill_id,$tag);


        //        }

        redirect('bill/display/'.$bill_id);
    }


}