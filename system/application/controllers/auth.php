<?php
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" :
 * <thepixeldeveloper@googlemail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Mathew Davies
 * ----------------------------------------------------------------------------
 */
class Auth extends Controller {

/**
 * index
 *
 * @return void
 * @author Mathew
 **/
    function index() {
        redirect('auth/status');
    }

    /**
     * activate
     * doesn't currently work
     *
     * @return void
     * @author Mathew
     **/
    function activate() {
        $this->form_validation->set_rules('code', 'Verification Code', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        $code_from_link = $this->uri->segment(3);

        if (strlen($code_from_link) > 0) {
            $activate = $this->redux_auth->activate($code_from_link);

            if ($activate) {
                $this->session->set_flashdata('message', '<p class="success">Your Account is now activated, please <a href="'.base_url().'index.php/auth/login">login</a>.</p>');
                redirect('auth/activate');
            }
            else {
                $this->session->set_flashdata('message', '<p class="error">Your account is already activated or doesn\'t need activating.</p>');
                redirect('auth/activate');
            }
        }elseif ($this->form_validation->run() == false) {
        //$data['content'] = $this->load->view('activate', null, true);
            $this->template->set('page_description','Account activation');
            $this->template->set('title', 'OpenBama - Avtivate account');
            $this->template->load('template/template','activate');
        }
        else {
            $code = $this->input->post('code');
            $activate = $this->redux_auth->activate($code);

            if ($activate) {
                $this->session->set_flashdata('message', '<p class="success">Your Account is now activated, please login.</p>');
                redirect('auth/activate');
            }
            else {
                $this->session->set_flashdata('message', '<p class="error">Your account is already activated or doesn\'t need activating.</p>');
                redirect('auth/activate');
            }
        }
    }

    /**
     * register
     *
     * @return void
     * @author Mathew
     **/
    function register() {
        $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check|min_length[5]|max_length[15]');
        $this->form_validation->set_rules('email', 'Email Address', 'required|callback_email_check|valid_email|matches[confirmEmail]');
        $this->form_validation->set_rules('confirmEmail', 'Confirm Email Address', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[confirmPassword]');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false) {
        //$data['content'] = $this->load->view('register', null, true);
            $this->template->set('page_description','Register for OpenBama.org account');
            $this->template->set('title', 'OpenBama - Account Registration');
            $this->template->load('template/template','register');
        }
        else {
            $username = $this->input->post('username');
            $email    = $this->input->post('email');
            $password = $this->input->post('password');

            $register = $this->redux_auth->register($username, $password, $email);

            if ($register) {
                $this->session->set_flashdata('message', '<p class="success">You have now registered. You will receive an account activation email shortly.</p>');
                redirect('auth/register');
            }
            else {
                $this->session->set_flashdata('message', '<p class="error">An error occurred, please try again or <a href="mailto:contact@openbama.org">contact us</a></p>');
                redirect('auth/register');
            }
        }
    }

    /**
     * Username check
     *
     * @return void
     * @author Mathew
     **/
    public function username_check($username) {
        $check = $this->redux_auth_model->username_check($username);

        if ($check) {
            $this->form_validation->set_message('username_check', 'The username "'.$username.'" already exists.');
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Email check
     *
     * @return void
     * @author Mathew
     **/
    public function email_check($email) {
        $check = $this->redux_auth_model->email_check($email);

        if ($check) {
            $this->form_validation->set_message('email_check', 'The email "'.$email.'" already exists.');
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * login
     *
     * @return void
     * @author Mathew
     **/
    function login($return_url = NULL) {
    //$return_url = $this->session->userdata('return_url');
        $return_url = str_replace('-','/',$return_url);

        $this->form_validation->set_rules('email', 'Email Address', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false) {
        //$data['content'] = $this->load->view('login', null, true);
            $data['return_url'] = $return_url;
            $this->template->set('page_description','Login into OpenBama.org');
            $this->template->set('title', 'OpenBama - Account Login');
            $this->template->load('template/template', 'login',$data);
        }
        else {
            $email    = $this->input->post('email');
            $password = $this->input->post('password');

            $login = $this->redux_auth->login($email, $password);

            if($login) {

                $return_url = $this->input->post('return_url');

                if ($return_url) {
                    redirect($return_url);
                }else {
                    redirect('welcome/index');
                }
            }else {
                redirect('auth/bad_login');
            }


        }
    }

    /**
     * logout
     *
     * @return void
     * @author Mathew
     **/
    function logout() {
        $this->redux_auth->logout();
        redirect('welcome/index');
    }

    /**
     * status
     *
     * @return void
     * @author Mathew
     **/
    function status() {
        $data['status'] = $this->redux_auth->logged_in();
        //$data['content'] = $this->load->view('status', $data, true);
        $this->template->load('template/template','status', $data);
    }
    /**
     * change password
     *
     * @return void
     * @author Mathew
     **/
    function change_password() {
        $this->form_validation->set_rules('old', 'Old password', 'required');
        $this->form_validation->set_rules('new', 'New Password', 'required|matches[new_repeat]');
        $this->form_validation->set_rules('new_repeat', 'Repeat New Password', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false) {
        //$data['content'] = $this->load->view('change_password', null, true);
            $this->template->set('page_description','Change Password');
            $this->template->set('title', 'OpenBama - Change Password');
            $this->template->load('template/template', 'change_password');
        }
        else {
            $old = $this->input->post('old');
            $new = $this->input->post('new');

            $identity = $this->session->userdata($this->config->item('identity'));

            $change = $this->redux_auth->change_password($identity, $old, $new);

            if ($change) {
                $this->logout();
            }
            else {
                echo "Password Change Failed";
            }
        }
    }

    /**
     * forgotten password
     *
     * @return void
     * @author Mathew
     **/
    function forgotten_password() {
        $this->form_validation->set_rules('email', 'Email Address', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false) {
        //$data['content'] = $this->load->view('forgotten_password', null, true);

            $this->template->set('page_description','Retrieve forgotten password');
            $this->template->set('title', 'OpenBama - Forgotten Password');
            $this->template->load('template/template','forgotten_password');
        }
        else {
            $email = $this->input->post('email');
            $forgotten = $this->redux_auth->forgotten_password($email);

            if ($forgotten) {
                $this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
                redirect('auth/forgotten_password');
            }
            else {
                $this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
                redirect('auth/forgotten_password');
            }
        }
    }

    /**
     * forgotten_password_complete
     *
     * @return void
     * @author Mathew
     **/
    public function forgotten_password_complete() {
        $this->form_validation->set_rules('code', 'Verification Code', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        $code_from_link = $this->uri->segment(3);

        if(strlen($code_from_link) > 0) {
            $forgotten = $this->redux_auth->forgotten_password_complete($code_from_link);

            if ($forgotten) {
                $this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
                redirect('auth/forgotten_password_complete');
            }
            else {
                $this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
                redirect('auth/forgotten_password_complete');
            }
        }elseif ($this->form_validation->run() == false) {
        //redirect('auth/forgotten_password');
            $this->template->set('page_description','Reset password');
            $this->template->set('title', 'OpenBama - Reset Password');
            $this->template->load('template/template','forgotten_password_complete');
        }
        else {
            $code = $this->input->post('code');
            $forgotten = $this->redux_auth->forgotten_password_complete($code);

            if ($forgotten) {
                $this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
                redirect('auth/forgotten_password_complete');
            }
            else {
                $this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
                redirect('auth/forgotten_password_complete');
            }
        }
    }

    function bad_login() {
        $this->template->set('page_description','Incorrect username/password');
        $this->template->set('title', 'OpenBama - Incorrect Login');
        $this->template->load('template/template','bad_login');
    }

    /**
     * Profile
     *
     * @return void
     * @author Mathew
     **/
    public function profile() {
        if ($this->redux_auth->logged_in()) {
            $data['profile'] = $this->redux_auth->profile();
            $data['content'] = $this->load->view('profile', $data, true);

            $this->template->set('page_description','Account profile');
            $this->template->set('title', 'OpenBama - Account Profile');
            $this->template->load('template/template','profile', $data);
        }
        else {
            redirect('auth/login');
        }
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */