<?php

class User extends Controller {

    function register () {
    // Required Field Rules.
        $rules['username']	= "required";
        $rules['password']	= "required";
        $rules['password2'] 	= "required";
        $rules['email'] 		= "required";
        $rules['question'] 	= "required";
        $rules['answer'] 		= "required";

        $this->validation->set_rules($rules);

        // Required Field Names
        $fields['username'] 	= "Username";
        $fields['password'] 	= "Password";
        $fields['password2'] 	= "Repeat Password";
        $fields['email'] 		= "Email Address";
        $fields['question']		= "Secret Question";
        $fields['answer']		= "Secret Answer";

        $this->validation->set_fields($fields);

        if ($this->validation->run()) {
        // Validation Passed

            $redux = $this->redux_auth->register
                (
                $this->input->post('username'),
                $this->input->post('password'),
                $this->input->post('email'),
                $this->input->post('question'),
                $this->input->post('answer')
            );

            // The reason we put the method into a variable is so we can deal
            // with the different return messages.

            // I use a switch statement to deal with the different return
            // messages produced by the registration method.

            switch ($redux) {
                case 'REGISTRATION_SUCCESS':
                # code...

                    break;
                case 'REGISTRATION_SUCCESS_EMAIL':
                # code...
                    break;
                case false:
                # code...
                    break;
                case true:
                # code...
                    break;
            }
        }
        else {
            /*$this->load->view("register");*/
            $this->template->set('title', 'Register');
            $this->template->load('template','register');
        }
    }

    function login () {
        $rules['email'] = "required";
        $rules['password'] = "required";

        $this->validation->set_rules($rules);

        $fields['email']		= 'Email Address';
        $fields['password']	= 'Password';

        $this->validation->set_fields($fields);

        if ($this->validation->run() == true) {
            echo "about to authenticate";
            echo $this->input->post('email');
            echo $this->input->post('password');
            $redux = $this->redux_auth->login
                (
                $this->input->post('email'),
                $this->input->post('password')
            );

            echo $redux;
            switch ($redux) {
                case 'NOT_ACTIVATED':
                # code...
                    echo 'Not activated';
                    break;
                case 'BANNED':
                # code...
                    break;
                case false:
                # code...
                echo "Not Success";
                    break;
                case true:
                # code...
                echo "Success";
                    break;
            }
        }
        else {
            /*$this->load->view("login");*/
            $this->template->set('title', 'Login');
            $this->template->load('template','login');

        }
    }

    public function logout () {
        $this->redux_auth->logout();
    }

    function forgotten_begin () {
        $rules['email'] 	= "required";

        $this->validation->set_rules($rules);

        $fields['email']	= 'Email Address';

        $this->validation->set_fields($fields);

        if ($this->validation->run() == true) {
            $redux = $this->redux_auth->forgotten_begin($this->input->post('email'));

            if ($redux) {
            # code...
            }
            else {
            # code...
            }
        }
        else {
            $this->template->set('title', 'Forgot your password?');
            $this->template->load('template', 'forgotten_begin');
        }
    }

    function forgotten_process () {
        $rules['forgotten_code'] = "required";

        $this->validation->set_rules($rules);

        $fields['forgotton_code']= 'Forgotten Password Validation Code';

        $this->validation->set_fields($fields);

        if ($this->validation->run()) {
            $redux = $this->redux_auth->forgotten_process($this->input->post('forgotten_code'));

            if ($redux != false) {
                $data['question'] = $redux;
                $this->template->set('title', 'Forgot Password?');
                $this->template->load('template','forgotten_end',$data);
                /*$this->load->view('forgotten_end', $data);*/
            }
            else {
               /* $this->load->view('forgotten_process');*/
                $this->template->set('title', 'Forgot Password?');
                $this->template->load('template','forgotten_process');
            }
        }
        else {
            /*$this->load->view('forgotten_process');*/
            $this->template->set('title', 'Forgot Password?');
            $this->template->load('template','forgotten_process');
        }
    }
}

?>