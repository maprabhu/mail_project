<?php

class Api extends APP_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
 
    }

    // redirect if needed, otherwise display the user list
    function index() {
        
    }

    // log the user in
    function login() {
        // echo "hai";exit;
        // check to see if the user is logging in
        // check for "remember me"
        $email = $this->input->post('username');
        $password = $this->input->post('password');
        // $data['userauthkey'] = $userauthkey = $this->input->post('userauthkey');
        //if (isset($email) || isset($password) || isset($userauthkey)) {
        if ($email != '' && $password != '') {

            $login_model = $this->api_model->login($this->input->post('username'), $this->input->post('password'));
            //print_r($login_model);
            if ($login_model['response'] == 2) {
                //$arr = array('response' => "2");
                print (json_encode($login_model));
                exit;
            } else if ($login_model['response'] == 0) {
                //$arr = array('response' => "0");
                print (json_encode($login_model));
                exit;
            } else if ($login_model['response'] == 1) {
                //$arr = array('response' => "1");
                print (json_encode($login_model));
                exit;
            } else if ($login_model['response'] == 3) {
                //$arr = array('response' => "1");
                print (json_encode($login_model));
                exit;
            }
        } else {
            $arr = array('response' => "4", "message" => "Parameter missing.");
            print(json_encode($arr));
            exit;
        }
    }
 

       

    function accountapi() {
    
    // echo "hai rajesh";exit;
    //print_r($_POST);exit;

        if (isset($_POST)) {
            $arr = array();
            
            $api = $this->input->post('api');
            $todaysdate = date('Y-m-d');
            if ($api == "insert") {
               //  echo "hai rajesh";exit;
                // $this->form_validation->set_rules('email', 'email', 'trim|required');
                $this->form_validation->set_rules('username', 'username', 'trim|required');
                // $this->form_validation->set_rules('first_name', 'first_name', 'trim|required');
                $this->form_validation->set_rules('group_id', 'group_id', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    $delResponse['error'] = 'Required fields missing.';
                    echo json_encode($delResponse);
                    exit;
                }
                //echo "hai kutty";exit;
                //$email = strtolower($this->input->post('email'));
                $username = strtolower($this->input->post('username'));
                $password = $this->input->post('password');
                $identity_column = $this->config->item('identity', 'ion_auth');
                $identity = ($identity_column === 'username') ? $username : $this->input->post('identity');
                //$first_name = $this->input->post('first_name');
                $username = $this->input->post('username');
                $email = $this->input->post('email');
                $description = $this->input->post('description');
                $phone = $this->input->post('phone');
                $data['active'] = $active = "";
                $userauthkey = substr(sha1(mt_rand()), 10, 25); //To Generate Random Numbers with Letters.;//rand(10,99).strtotime($created_date);
               
                $group_ins = array($this->input->post('group_id')); //
                //echo $email; exit;
                $data['random_numbers'] = $random_numbers = rand();
                //print_r($_FILES['photo_name']);exit;
                // $photo_name_new_name="";
                // if (!empty($_FILES['photo_name'])) {
                //     if ($_FILES['photo_name']['name'] != "") {

                //         // Initialize CI file Upload Library
                //         $config['upload_path'] = './assets/uploads/profile/';
                //         $config['allowed_types'] = '*'; //doc|docx|pdf|txt|csv|xls|xlsx|png|gif|jpg|jpeg';
                //         $config['max_size'] = 1024 * 50;
                //         $config['encrypt_name'] = FALSE;

                //         $this->upload->initialize($config);

                //         if (!$this->upload->do_upload('photo_name')) {
                //             $data['error'] = $this->upload->display_errors();
                //             //$this->session->set_flashdata('msg1','Mail Sending Failed'.$error);
                //             //redirect('contact/premium');  
                //         } else {

                //             $upload_file = $this->upload->data();
                //             //print_r($upload_file);
                //             //$file_rename = date('Y-m-d-His_').underscore($upload_file['photo_name']); 
                //             $file_rename = date('Y-m-d-His_') . $upload_file['file_name'];
                //             //echo "else<br/>";print $file_rename."<br/>";

                //             rename($config['upload_path'] . $upload_file['file_name'], $config['upload_path'] . $file_rename);
                //             chmod($config['upload_path'] . $file_rename, 0777);

                //             //insert into database
                //             $photo_name_new_name = $file_rename;
                //             $image_url = "assets/uploads/profile/";
                //             //echo $file_rename;exit;
                //             //echo $photo_name_new_name;exit;
                //         }
                //     }
                // }
                
                $additional_data = array(
                    'username' => $this->input->post('username'),
                    'phone' => $this->input->post('phone'),
                    'random_numbers' => $random_numbers,
                    'email' => $email,
                    'userauthkey' => $userauthkey,
                    'created_by' => $this->session->userdata('user_id'),
                    'description' => $this->input->post('description'),
                    'active' => '1'
                );
                 // print_r($additional_data);exit;
                $data['username'] = $username;

                //insert into DB
                $insert_SQL = $this->ion_auth->register_api($identity, $password, $additional_data, $group_ins);

                if ($insert_SQL > 1) {
                    $arr = array('result' => '1', 'message' => "User created Successfully");
                    print(json_encode($arr));
                    exit;
                } 
                else {
                    $arr = array('result' => '2', 'message' => $insert_SQL);
                    print(json_encode($arr));
                    exit;
                }
                

                
            } else if ($api == "update") {
                $data['email'] = $email = strtolower($this->input->post('email'));
                $data['active'] = $active = "0";
                $data['userauthkey'] = $userauthkey = $this->input->post('userauthkey');

                $check_email = $this->api_model->check_email($data);
                
                    $id = $check_email['result'][0]->id;
                    $active = $check_email['result'][0]->active;
                    
                    if ($active == 1) {
                        $data_update['email'] = $email = strtolower($this->input->post('email'));
                        $data_update['password'] = $password = $this->input->post('password');
                        $data_update['first_name'] = $first_name = $this->input->post('first_name');
                        $data_update['company'] = $company = $this->input->post('company');
                        $data_update['phone'] = $phone = $this->input->post('phone');

                        $update_api = $this->ion_auth->update_api($id, $data_update);
                        if($update_api == 1)
                        {
                            $arr = array('result' => '1', 'message' => "Profile Updated");
                            print(json_encode($arr));
                            exit;    
                        }elseif($update_api == 2){
                            $arr = array('result' => '2', 'message' => "Duplicate account name");
                            print(json_encode($arr));
                            exit;    
                        }elseif($update_api == 3){
                            $arr = array('result' => '3', 'message' => "Update Failed");
                            print(json_encode($arr));
                            exit;    
                        }
                        
                    } else {
                        $arr = array('result' => '2', 'message' => "Emailid inactive.");
                        print(json_encode($arr));
                        exit;
                    }
                 
            } else if ($api == "web_update") {
                //print_r($_POST);exit;
                $data['id'] = $id = strtolower($this->input->post('update_other_user_id'));
                // $data['email'] = $email = strtolower($this->input->post('email'));
                // $data['active'] = $active = "1";
                // $data['userauthkey'] = $userauthkey = $this->input->post('userauthkey');
 
                $data_update['username'] = $username = strtolower($this->input->post('username'));
                $data_update['password'] = $password = $this->input->post('password');
                // $data_update['first_name'] = $first_name = $this->input->post('first_name');
                $data_update['description'] = $company = $this->input->post('description');
                $data_update['phone'] = $phone = $this->input->post('phone');

                $update_api = $this->ion_auth->update_api($id, $data_update);
                if($update_api == 1)
                {
                    $arr = array('result' => '1', 'message' => "Profile Updated");
                    print(json_encode($arr));
                    exit;    
                }elseif($update_api == 2){
                    $arr = array('result' => '2', 'message' => "Duplicate account name");
                    print(json_encode($arr));
                    exit;    
                }elseif($update_api == 3){
                    $arr = array('result' => '3', 'message' => "Update Failed");
                    print(json_encode($arr));
                    exit;    
                }
                        
                     
                }
                else if ($api == "forgot_password") {
                $data['email'] = $email = strtolower($this->input->post('email'));
                $data['active'] = $active = 1;
                $check_email = $this->api_model->check_email($data);

                $data['random_numbers'] = $random_numbers = rand();

                if ($check_email['count'] > 0) {
                    $getUserDetArray = $check_email['result'][0];
                    $sms_users_id = $getUserDetArray->id;
                    $first_name = $getUserDetArray->first_name;
                    $org_name = $getUserDetArray->org_name;
                    $site_url = $getUserDetArray->site_url;
                    $from_email = $getUserDetArray->from_email;


                    //update forgotten password code
                    $update_code_array = array(
                        'forgotten_password_code' => $random_numbers,
                        'random_numbers' => $random_numbers
                    );
                    $update_forgotten_password_code = $this->api_model->update_forgotten_password_code($update_code_array, $sms_users_id);
                    //$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});


                    $to = $email;
                    $subject = "Forgot Password in app";
                    $txt = "Hello " . $first_name . ",\r\n \r\n";
                    $txt .= "Please click this link to reset your password \r\n \r\n";
                    $txt .= $site_url . "/auth/reset_password/" . $random_numbers . "\r\n \r\n";

                    $txt .= "Thanks,\n" . $org_name;
                    $headers = "From: " . $from_email . "\r\n";
                    // ."CC: sathish@cobrasoftwares.in"

                    mail($to, $subject, $txt, $headers);

                    $arr = array('code' => '1', 'message' => "Forgot Password link sent to your email");
                    print(json_encode($arr));
                    exit;
                } else {
                    $arr = array('code' => '0', 'message' => "User Is not existing / inactive");
                    print(json_encode($arr));
                    exit;
                }
            } else if ($api == "profile") {
                $data['email'] = $email = strtolower($this->input->post('email'));
                $data['active'] = $active = 1;
                $data['userauthkey'] = $userauthkey = $this->input->post('userauthkey');

                $check_email = $this->api_model->check_email($data);
                if ($userauthkey != $check_email['result'][0]->mobile_auth_key) {
                    $arr = array('code' => '3', 'message' => "Mobile Auth Key Mismatch");
                    print(json_encode($arr));
                    exit;
                }
                if ($check_email['count'] > 0) {
                    $getUserDetArray = $check_email['result'][0];
                    $first_name = $getUserDetArray->first_name;
                    $company = $getUserDetArray->company;
                    $email = $getUserDetArray->email;
                    $phone = $getUserDetArray->phone;

                    $arr = array('code' => '1', 'first_name' => $first_name, 'company' => $company, 'email' => $email, 'phone' => $phone);
                    print(json_encode($arr));
                    exit;
                } else {
                    $arr = array('code' => '0', 'message' => "User Is not existing / inactive");
                    print(json_encode($arr));
                    exit;
                }
            }  else {
                $arr = array('result' => '401', 'message' => "Not In Post Method");
                print(json_encode($arr));
                exit;
            }
        } else {
            $arr = array('result' => '401', 'message' => "Not In Post Method");
            print(json_encode($arr));
            exit;
        }
    }
 

    // edit a user
    function edit_user($id) {
        $this->data['title'] = "Edit User";

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                );

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }



                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData)) {

                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                }

                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                } else {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                }
            }
        }

        // display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email', $user->email),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password'
        );

        $this->_tpl_super_admin('auth/edit_user', $this->data);
    }

    // create a new group
    function create_group() {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

        if ($this->form_validation->run() == TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        } else {
            // display the create group form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('description'),
            );

            $this->_tpl_super_admin('auth/create_group', $this->data);
        }
    }

    // --------------------------------------------------------------------
    /**
      # Function      :   sign_up
      # Purpose       :   sign_up
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   26th jan,2016
     */
    function sign_up() {
        $data = array();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]|max_length[20]|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|matches[password]|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('company', 'Company', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('auth_message', '');
            $this->load->helper('form');

            $this->load->view('auth/sign_up', $data);
        } else {
            $first_name = $this->input->post('first_name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $company = $this->input->post('company');
            $phone = $this->input->post('phone');

            $created_date = date('Y-m-d H:i:s');
            $created_from = $this->input->post('created_from');
            $login_status = 0;
            $random_numbers = rand();
            $data['active'] = $active = "";
            $userauthkey = substr(sha1(mt_rand()), 10, 25); //To Generate Random Numbers with Letters.;//rand(10,99).strtotime($created_date);

            $additional_data = array(
                'first_name' => $first_name,
                'company' => $company,
                'phone' => $phone,
                'created_from' => $created_from,
                'userauthkey' => $userauthkey,
                'active' => 0
            );

            $this->load->library('ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');

            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');

            $insert_SQL = $this->ion_auth->register($identity, $password, $email, $additional_data);
            if ($insert_SQL) {
                $this->session->set_flashdata('auth_message', 'The account has been created. You may now login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('auth_message', $this->ion_auth->errors());
                $this->session->flashdata('auth_message');
                redirect('api/sign_up');
                //$this->load->view('auth/sign_up',$data);
            }
        }
    }

    // edit a group
    function edit_group($id) {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['group'] = $group;
        $readonly = '';
        if ($group->name == 'admin' || $group->name == 'employee' || $group->name == 'manager' || $group->name == 'reportee' || $group->name == 'client' || $group->name == 'marketing') {
            //$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';
            $readonly = 'readonly';
        }
        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        $this->_tpl_super_admin('auth/edit_group', $this->data);
    }

    function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce() {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
                $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function _render_page($view, $data = null, $returnhtml = false) {//I think this makes more sense
        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml)
            return $view_html; //This will return html on 3rd argument being true
    }
         
    // --------------------------------------------------------------------
    /**
      # Function      :   activate_deactivate_user
      # Purpose       :   api to activate_deactivate_user
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   26th jan,2016
     */
    function activate_deactivate_user() {

        $id = $this->input->post('activate_deactivate_user_sms_users_id');
        $data_update['active'] = $active = $this->input->post('active');
        if($active == '1'){
            $activation = $this->ion_auth->activate($id);
        }else{
            $this->ion_auth->deactivate($id);
        }
        $arr = array('code' => '1', 'message' => "Updated");
        print(json_encode($arr));
        exit;
    }
    
     

    // --------------------------------------------------------------------
    /**
      # Function      :   htmlmail
      # Purpose       :   api to htmlmail
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   26th jan,2016
     */
    public function htmlmail($data) {
        $from_email = $data['from_email'];
        $from_email_name = $data['from_email_name'];
        $email_subject = $data['email_subject'];
        $email_message = $data['email_message'];
        $email_to = $data['email_to'];
        $email_bcc = $data['email_bcc'];

        //$body = $this->load->view('emails/anillabs.php', $data, TRUE);
        $this->email->clear();
        $this->email->from($from_email, $from_email_name);
        if ($email_to) {
            $this->email->to($email_to);
        }
        //print_r($email_bcc[0]);
        $email_bccim = implode(",", $email_bcc);
        //if($email_bcc){
        //for($i=0;$i<count($email_bcc);$i++)
        $this->email->bcc($email_bccim);
        //echo $email_bccim;
        //}
        $this->email->subject($email_subject);
        $this->email->message($email_message);
        $this->email->send();
    }

     
    function inbox_view() {
        $data['id'] = $this->input->post('user_id');
        $data['active'] = '1';
        $data['grouplist'] = $this->ion_auth_model->grouplist();
       
        $data['messages'] = $this->api_model->get_message($data);
        // print_r($data['messages']);exit;
        if($data['messages']) {
                $arr = array("result" => 'Success', "message"=> $data['messages']);
                print_r(json_encode($arr));
                // redirect('mailserver_manage/mail_compose');
                exit;
            } else {
                $arr = array("result" => 'Failed', "message"=>"Failed To View Message List");
                print_r(json_encode($arr));
                exit;
            }

    }

    
    function view_message() {

        $msg_id = $this->input->post('messageID');
        // $ = $this->input->post('user_id');
        
        $data['sender_id'] = $this->api_model->get_attach_id($msg_id);
        if($data['sender_id']) {

        $arr = array("result" => 'Success', "message"=> $data['sender_id']['result']);
        print_r(json_encode($arr));
                exit;
        } else {
            
        $arr = array("result" => 'Failed', "message"=> "Failed to open message");
        print_r(json_encode($arr));
                exit;
        }
    }



}