<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mailserver_manage extends APP_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('excel');
    }

    // redirect if needed, otherwise display the user list
    function index() {
        $data = array();
        
        if ($this->ion_auth->is_admin()) {
           $this->_tpl_super_admin('mailbox/mail_box_compose_view', $data);
        } else {
           redirect('auth/login');
        }
    }
 
////////////other users starts    
    // ---------------------------------------------------------------------
    /**
      # Function      :   manage_other_mail
      # Purpose       :   Load manage_other_mail
      # params        :   none
      # Return        :   none
      # Created_by    :   Rajesh
      # Created_date  :   13th Feb,2017
     */
    function manage_other_mail() {
        $data = array();
        $data['title'] = "MailBox";
        $data['id'] = $this->session->userdata('user_id');
        $data['active'] = '1';
        $data['grouplist'] = $this->ion_auth_model->grouplist();
       
        if ($this->ion_auth->is_admin()) {
             $data['messages'] = $this->api_model->get_message($data);
             
             // $data['sender_mail'] = $this->api_model->get_sender_mail($data['messages']->userID);
             // echo "<pre>";
             // print_r($data['messages']);exit;
             
             $this->_tpl_super_admin('mailbox/mail_box_view', $data);
	    } else if ($this->ion_auth->get_users_groups()->row()->name == 'user'){
             $data['messages'] = $this->api_model->get_message($data);
             // echo "<pre>";
             // print_r($data['messages']);exit;
             $this->_tpl_user('mailbox/mail_box_view', $data);
        } else {
             redirect('auth/login');
        }
    }

    function mail_compose() {
    		$data = array();
    		$data ['title'] = "Compose Mail";
    		$data_user['id'] = $this->session->userdata('user_id');
        $data_user['active'] = '1';
        $data['grouplist'] = $this->ion_auth_model->grouplist();
        $data['user_id'] = $this->session->userdata('user_id');
        $data['get_users_info'] = $this->api_model->get_users_info($data);
        
        if ($this->ion_auth->is_admin()) {
            $this->_tpl_super_admin('mailbox/mail_box_compose_view', $data);
        } else {
           	$this->_tpl_user('mailbox/mail_box_compose_view', $data);
        }
    }

    function insert_mail() {
        
      // print_r($_POST);exit;
        $orgResponse = array();
        $this->form_validation->set_rules('sender', 'To', 'trim|required|max_length[1000]');
        
        // $hide_value = $this->input->post('hide_value');
        $photo_last_modified_date = date('Y-m-d H:i:s');
        if ($this->form_validation->run() == FALSE) {

            $sender = form_error('sender');
            // $photo_title = form_error('photo_title');

            if ($sender)
                $orgResponse['error'] = form_error('sender');
                echo json_encode($orgResponse);
        }else { 

            $attach_file = strtolower($this->input->post('attach_file'));
            $sender = strtolower($this->input->post('sender'));
           
            $photo_name_new_name = "";$image_url="";
                if (!empty($_FILES['attach_file'])) {
                    if ($_FILES['attach_file']['name'] != "") {

                        // Initialize CI file Upload Library
                        $config['upload_path'] = './assets/uploads/attach_file/';
                        $config['allowed_types'] = '*'; //doc|docx|pdf|txt|csv|xls|xlsx|png|gif|jpg|jpeg';
                        $config['max_size'] = 1024 * 50;
                        $config['encrypt_name'] = FALSE;

                        $this->upload->initialize($config);

                        if (!$this->upload->do_upload('attach_file')) {
                          // echo"hai";exit;
                            $data['error'] = $this->upload->display_errors();
                            //$this->session->set_flashdata('msg1','Mail Sending Failed'.$error);
                            //redirect('contact/premium');  
                        } else {

                            $upload_file = $this->upload->data();
                            //print_r($upload_file);
                            //$file_rename = date('Y-m-d-His_').underscore($upload_file['attach_file']); 
                            $file_rename = date('Y-m-d-His_') . $upload_file['file_name'];
                            //echo "else<br/>";print $file_rename."<br/>";

                            rename($config['upload_path'] . $upload_file['file_name'], $config['upload_path'] . $file_rename);
                            chmod($config['upload_path'] . $file_rename, 0777);

                            //insert into database
                            $photo_name_new_name = $file_rename;
                            $image_url = "assets/uploads/attach_file/";
                            //echo $file_rename;exit;
                        }
                    }
                   } 
                   // print_r($photo_name_new_name);exit;


            $sender = $this->input->post('sender');
            $user_id = $this->session->userdata("user_id");
            $get_sender = $this->api_model->get_sender_id($user_id);
            // print_r($get_sender);exit;
            $receiver = $this->input->post('sender');
            $subject = $this->input->post('subject');
            // $email = $this->input->post('email');
            $compose = $this->input->post('compose');
            // $user_id = $this->session->userdata("user_id");
            $data = array(
                "receiverID" => $receiver,
                "subject" => $subject,
                "message" => $compose,
                "useremail" => $get_sender->email,
                "userId" => $user_id,
                "attach_file_name" => $photo_name_new_name
                );
             // echo "<pre>";
             // print_r($data);exit;
            $send_mail = $this->api_model->send_mail($data);

            if($send_mail) {
                $arr = array("result" => '1', "message"=>"message sent Successfully");
                print_r(json_encode($arr));
                redirect('mailserver_manage/mail_compose');
            } else {
                $arr = array("result" => '2', "message"=>"message sent Failed");
                print_r(json_encode($arr));
                exit;
            }


        }

            
            //    print_r($photo_name_new_name); exit;

            
    }

    function read_message() {
        $data = array();
        $data ['title'] = "Mail";
        $data_user['id'] = $this->session->userdata('user_id');
        $data_user['active'] = '1';
        $msg_id  = $this->uri->segment(3);
        $user_id  = $this->uri->segment(4);
        $data['sender_id'] = $this->api_model->get_attach_id($msg_id);
         // print_r($data['sender_id']['result']);exit;
        $subject = $data['sender_id']['result']->subject;
        $attach = $data['sender_id']['result']->attach_file_name;
        $compose = $data['sender_id']['result']->message;
        $date  = $data['sender_id']['result']->create_date;
        $sender  = $data['sender_id']['result']->receiverID;
        // $attach  = 
        $data['values'] = array(
            "sender" => $sender,
            "subject" => $subject,
            "attach" => $attach,
            "message" => $compose,
            "date" => $date,
            "receiver" => $msg_id
            );
        // echo "<pre>";
        // print_r($data['values']);exit;
        $data['sender_id'] = $this->api_model->get_sender_id($user_id);
       
        if ($this->ion_auth->is_admin()) {
             $this->_tpl_super_admin('mailbox/message_box_open', $data);
        } else if ($this->ion_auth->get_users_groups()->row()->name == 'user'){
             $this->_tpl_user('mailbox/message_box_open', $data);
        } else {
             redirect('auth/login');
      }

   }

   function mail_sent() {
        $data = array();
        $data ['title'] = "Sent Mail";
        $data_user['id'] = $this->session->userdata('user_id');
        $data['sent_message'] = $this->api_model->get_sent_message($data_user);
        // print_r($data['sent_message']);
        if ($this->ion_auth->is_admin()) {
             $this->_tpl_super_admin('mailbox/message_box_sent', $data);
        } else if ($this->ion_auth->get_users_groups()->row()->name == 'user'){
             $this->_tpl_user('mailbox/message_box_sent', $data);
        } else {
             redirect('auth/login');
      }
   }
    
   function del_message_user() {
       
       $message_id  = $this->uri->segment(3);
       $sender  = $this->session->userdata('user_id');
       $update_status = array(
        "status" => "1");
       $update_trash = $this->db->where('messageID',$message_id)->update('message',$update_status);
        // echo $this->db->last_query();exit;
       redirect('mailserver_manage/mail_sent');

        // print_r($update_trash->result());exit;
    }

    function del_message_inbox() {
       
       $message_id  = $this->uri->segment(3);
       $sender  = $this->session->userdata('user_id');
       $update_status = array(
        "status" => "1");
       $update_trash = $this->db->where('messageID',$message_id)->update('message',$update_status);
        // echo $this->db->last_query();exit;
       redirect('mailserver_manage/manage_other_mail');

        // print_r($update_trash->result());exit;
    }



    function trash_view() {
        $data = array();
        $data ['title'] = "Trash Mail";
        $trast_status = "1";
        $data['trash_view'] = $this->api_model->update_trash_mail();
         // print_r($data['trash_view']);exit;
        $data['count'] = $data['trash_view']['count'];
        if ($this->ion_auth->is_admin()) {
             $this->_tpl_super_admin('mailbox/message_box_trash', $data);
        } else if ($this->ion_auth->get_users_groups()->row()->name == 'user'){
             $this->_tpl_user('mailbox/message_box_trash', $data);
        } else {
             redirect('auth/login');
      }


    }

    function image_view() {
      
      $data = array();
        $data ['title'] = "Image View";
        $data['image'] = $this->uri->segment(3);
      if ($this->ion_auth->is_admin()) {
             $this->_tpl_super_admin('mailbox/message_box_view_attach', $data);
        } else if ($this->ion_auth->get_users_groups()->row()->name == 'user'){
             $this->_tpl_user('mailbox/message_box_view_attach', $data);
        } else {
             redirect('auth/login');
      }

    }

}
