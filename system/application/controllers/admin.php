<?php
class Admin extends Controller {

    function Admin() {
        parent::Controller();
        $this->load->model('admin_model');

    }

    function index(){
        $this->template->set('title', 'OpenBama - Admin');
        $this->template->load('template/template', 'admin/index');
    }

    function committee_members(){
        $data['committees'] = $this->admin_model->get_committees();
        $data['people'] = $this->admin_model->get_all_people(DEFAULT_SESSION);
        $data['committee_members'] = $this->admin_model->get_all_committee_members(DEFAULT_SESSION);
        $this->template->set('title', 'OpenBama - Add Committee Members');
        $this->template->load('template/template', 'admin/committee_members',$data);
    }

    function add_committee_member(){
        $committee_id = $this->input->post('committees');
        $person_id = $this->input->post('people');
        $role = $this->input->post('role');
        $this->admin_model->insert_committee_member($committee_id,$person_id,$role,DEFAULT_SESSION);

        redirect('admin/committee_members');
        
    }

    function delete_committee_member($id = null){
        $this->admin_model->delete_committee_member($id);

        redirect('admin/committee_members');
    }
}