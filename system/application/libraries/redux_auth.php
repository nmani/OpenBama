<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" :
 * <thepixeldeveloper@googlemail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Mathew Davies
 * ----------------------------------------------------------------------------
 */

/**
 * Redux Authentication 2
 */
class redux_auth {
/**
 * CodeIgniter global
 *
 * @var string
 **/
    protected $ci;

    /**
     * account status ('not_activated', etc ...)
     *
     * @var string
     **/
    protected $status;

    /**
     * __construct
     *
     * @return void
     * @author Mathew
     **/
    public function __construct() {
        $this->ci =& get_instance();
        $email = $this->ci->config->item('email');
        $this->ci->load->library('email', $email);
    }

    /**
     * Activate user.
     *
     * @return void
     * @author Mathew
     **/
    public function activate($code) {
        return $this->ci->redux_auth_model->activate($code);
    }

    /**
     * Deactivate user.
     *
     * @return void
     * @author Mathew
     **/
    public function deactivate($identity) {
        return $this->ci->redux_auth_model->deactivate($code);
    }

    /**
     * Change password.
     *
     * @return void
     * @author Mathew
     **/
    public function change_password($identity, $old, $new) {
        return $this->ci->redux_auth_model->change_password($identity, $old, $new);
    }

    /**
     * forgotten password feature
     *
     * @return void
     * @author Mathew
     **/
    public function forgotten_password($email) {
        $forgotten_password = $this->ci->redux_auth_model->forgotten_password($email);

        if ($forgotten_password) {
        // Get user information.
            $profile = $this->ci->redux_auth_model->profile($email);

            $data = array('identity'                => $profile->{$this->ci->config->item('identity')},
                'forgotten_password_code' => $this->ci->redux_auth_model->forgotten_password_code);

            $message = $this->ci->load->view($this->ci->config->item('email_templates').'forgotten_password', $data, true);

            $this->ci->email->clear();
            $this->ci->email->set_newline("\r\n");
            $this->ci->email->from('member@openbama.org', '');
            $this->ci->email->to($profile->email);
            $this->ci->email->subject('Email Verification (Forgotten Password) for OpenBama.org');
            $this->ci->email->message($message);
            return $this->ci->email->send();
        }
        else {
            return false;
        }
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Mathew
     **/
    public function forgotten_password_complete($code) {
        $identity                 = $this->ci->config->item('identity');
        $profile                  = $this->ci->redux_auth_model->profile($code);
        $forgotten_password_complete = $this->ci->redux_auth_model->forgotten_password_complete($code);

        if ($forgotten_password_complete) {
            $data = array('identity'    => $profile->{$identity},
                'new_password' => $this->ci->redux_auth_model->new_password);

            $message = $this->ci->load->view($this->ci->config->item('email_templates').'new_password', $data, true);

            $this->ci->email->clear();
            $this->ci->email->set_newline("\r\n");
            $this->ci->email->from('member@openbama.org', '');
            $this->ci->email->to($profile->email);
            $this->ci->email->subject('New Password for OpenBama.org');
            $this->ci->email->message($message);
            return $this->ci->email->send();
        }
        else {
            return false;
        }
    }

    /**
     * register
     *
     * @return void
     * @author Mathew
     **/
    public function register($username, $password, $email) {
        $email_activation = $this->ci->config->item('email_activation');
        $email_folder     = $this->ci->config->item('email_templates');

        if (!$email_activation) {
            return $this->ci->redux_auth_model->register($username, $password, $email);
        }
        else {
            $register = $this->ci->redux_auth_model->register($username, $password, $email);

            if (!$register) { return false; }

            $deactivate = $this->ci->redux_auth_model->deactivate($username);

            if (!$deactivate) { return false; }

            $activation_code = $this->ci->redux_auth_model->activation_code;

            $data = array('username' => $username,
                'password'   => $password,
                'email'      => $email,
                'activation' => $activation_code);

            $message = $this->ci->load->view($email_folder.'activation', $data, true);

            $this->ci->email->clear();
            $this->ci->email->set_newline("\r\n");
            $this->ci->email->from('member@openbama.org', '');
            $this->ci->email->to($email);
            $this->ci->email->bcc('member@openbama.org');
            $this->ci->email->subject('Email Activation (Registration) for OpenBama.org');
            $this->ci->email->message($message);

            return $this->ci->email->send();
        }
    }

    /**
     * login
     *
     * @return void
     * @author Mathew
     **/
    public function login($identity, $password) {
        return $this->ci->redux_auth_model->login($identity, $password);
    }

    /**
     * logout
     *
     * @return void
     * @author Mathew
     **/
    public function logout() {
        $identity = $this->ci->config->item('identity');
        $this->ci->session->unset_userdata($identity);
        $this->ci->session->sess_destroy();
    }

    /**
     * logged_in
     *
     * @return void
     * @author Mathew
     **/
    public function logged_in() {
        $identity = $this->ci->config->item('identity');
        return ($this->ci->session->userdata($identity)) ? true : false;
    }

    /**
     * Profile
     *
     * @return void
     * @author Mathew
     **/
    public function profile() {
        $session  = $this->ci->config->item('identity');
        $identity = $this->ci->session->userdata($session);
        return $this->ci->redux_auth_model->profile($identity);
    }

}
