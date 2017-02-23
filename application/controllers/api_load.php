<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require_once(BASEPATH . 'libraries/REST_Controller.php');

class Api_load extends REST_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->database();
        //define('SITE_API_URL', str_replace("admin_cms/", "", base_url()));
    }

    // redirect if needed, otherwise display the user list no changes
    function index_get() {
        $this->response([
            'returned from delete:' => "ssssss",
        ]);
    }

    // --------------------------------------------------------------------
    /**
      # Function      :   app_load_call
      # Purpose       :   api to get app date changes
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   06th Mar,2016
     */
    function app_load_call_post() {
        if (isset($_POST)) {

            $api = $this->input->post('api');
            $data = array();
            $todaysdate = date('Y-m-d');
            $todaysdatetime = date('Y-m-d H:i:s');
            
            
            $created_date = date('Y-m-d H:i:s');
            
            if ($api == "event_detail") {

                $arr = array('main_result' => '1', 'message' => "Event Details", "pdf_url" => base_url() . "assets/uploads/pdf/omega.pdf");
                header("Content-type: application/json; charset=utf-8");
                print(json_encode($arr));
                exit;
            } else if ($api == "visitor_detail") {

                $data['user_id'] = $user_id = $this->input->post('user_id');
                $get_user_details = $this->api_model->get_user_details($data);
                
                if ($get_user_details['count'] > 0) {
                    $get_user_details['result'] = $get_user_details['result'][0];
                    $arr = array('main_result' => '1', 'user_details' => $get_user_details['result']);
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else {
                    $arr = array('main_result' => '0', 'user_details' => "No Data");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                }
            } else if ($api == "event_list") {


                $get_event_list = $this->api_model->get_event_list($data);

                if ($get_event_list['count'] > 0) {
                    $arr = array('main_result' => '1', 'event_listing' => $get_event_list['result']);
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else {
                    $arr = array('main_result' => '0', 'user_details' => "No Data");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                }
            } else if ($api == "visitor_stall_link") {
                $server_response = '';
                $username = $data['username'] = $this->input->post('username');
                $data['active'] = 1;
                $check_username = $this->api_model->check_username($data);
                //print_r($check_username);exit;
                if($check_username['count'] <= 0){
                    $arr = array('main_result' => '0', 'message' => "No Data");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                }
                //get event_id for stall client
                $get_stall_event_link_data = $this->api_model->get_stall_event_link_data($check_username['result'][0]->id);

                /* $user_data = $data['user_data'] =  '[{"user_id":"11","name":"Ramesh","gender":"Male","email":"rameshxyz@gmail.com","mobile":"9856325698"},{"user_id":"23","name":"SomasdRamesh","gender":"Male","email":"somrameshxyz@gmail.com","mobile":"9856325698"}]';//$this->input->post('user_data'); */
                $user_data = $data['user_data'] = $this->input->post('user_data');

                $json = json_decode($user_data, true);
                if (count($json) > 0) {
                    foreach ($json as $json_value) {
                        $user_id_pass = $json_value['user_id'];
                        $visitor_stall_link_array = array(
                            "visitor_id" => $json_value['user_id'],
                            "stall_id" => $check_username['result'][0]->id,
                            "event_details_id" => $json_value['event_details_id'],
                            "created_date" => $todaysdatetime
                        );
                        //check prev visitor entry
                        $check_visitor_stall_link = $this->api_model->check_visitor_stall_link($visitor_stall_link_array);
                        if ($check_visitor_stall_link == 1) {
                            $server_response = '1';
                        } else {
                            $insert_visitor_stall_link = $this->api_model->insert_visitor_stall_link($visitor_stall_link_array);
                            if ($insert_visitor_stall_link > 0) {
                                $server_response = '2';
                            } else {
                                $server_response = '2';
                            }
                        }
                    }
                }
                if ($server_response == '1') {
                    $arr = array('main_result' => '2', 'message' => "Already registered");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else if ($server_response == '2') {
                    $arr = array('main_result' => '1', 'message' => "Visitor added to stall");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else if ($server_response == '3') {
                    $arr = array('main_result' => '0', 'message' => "Error in processing");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else {
                    $arr = array('main_result' => '0', 'message' => "Error in processing");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                }


//                print_r($json);
                exit;
                //echo $json['name'];
                $visitor_stall_link_array = array(
                    "visitor_id" => $json['user_id'],
                    "stall_id" => $check_username['result'][0]->id,
                    "created_date" => $todaysdatetime
                );
                //check prev visitor entry
                $check_visitor_stall_link = $this->api_model->check_visitor_stall_link($visitor_stall_link_array);
                if ($check_visitor_stall_link == 1) {
                    $arr = array('main_result' => '2', 'message' => "Already registered");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else {
                    $insert_visitor_stall_link = $this->api_model->insert_visitor_stall_link($visitor_stall_link_array);
                    if ($insert_visitor_stall_link > 0) {
                        $arr = array('main_result' => '1', 'message' => "Visitor added to stall");
                        header("Content-type: application/json; charset=utf-8");
                        print(json_encode($arr));
                        exit;
                    } else {
                        $arr = array('main_result' => '0', 'message' => "Error in processing");
                        header("Content-type: application/json; charset=utf-8");
                        print(json_encode($arr));
                        exit;
                    }
                }
            } else if ($api == "stall_sync_from_visitors") {
                $server_response = '';
                $username = $data['username'] = $this->input->post('username');
                $data['active'] = 1;
                $check_username = $this->api_model->check_username($data);


                /* $user_data = $data['user_data'] =  '[{"user_id":"11","name":"Ramesh","gender":"Male","email":"rameshxyz@gmail.com","mobile":"9856325698"},{"user_id":"23","name":"SomasdRamesh","gender":"Male","email":"somrameshxyz@gmail.com","mobile":"9856325698"}]';//$this->input->post('user_data'); */
                $user_data = $data['user_data'] = $this->input->post('user_data');

                $json = json_decode($user_data, true);
                if (count($json) > 0) {
                    foreach ($json as $json_value) {
                        //$user_id_pass = $json_value['user_id'];
                        $stall_sync_from_visitors_array = array(
                            "visitor_id" => $check_username['result'][0]->id,
                            "stall_id" => $json_value['stall_user_id'],
                            "event_details_id" => $json_value['event_details_id'],
                            "created_date" => $todaysdatetime
                        );
                        //check prev visitor entry
                        $check_stall_sync_from_visitors_data = $this->api_model->check_stall_sync_from_visitors_data($stall_sync_from_visitors_array);
                        if ($check_stall_sync_from_visitors_data == 1) {
                            $server_response = '1';
                        } else {
                            $insert_stall_sync_from_visitors = $this->api_model->insert_stall_sync_from_visitors($stall_sync_from_visitors_array);
                            if ($insert_stall_sync_from_visitors > 0) {
                                $server_response = '2';
                            } else {
                                $server_response = '2';
                            }
                            $stall_user_ids[] = $json_value['stall_user_id'];
                        }
                    }
                }
                if ($server_response == '1') {
                    $arr = array('main_result' => '2', 'message' => "Already registered");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else if ($server_response == '2') {
                    $arr = array('main_result' => '1', 'message' => "Stall added to visitor", "success_result" => $stall_user_ids);
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else if ($server_response == '3') {
                    $arr = array('main_result' => '0', 'message' => "Error in processing");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else {
                    $arr = array('main_result' => '0', 'message' => "Error in processing");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                }
            } else if ($api == "get_visitor_stall_details") {

                $data['user_id'] = $user_id = $this->input->post('user_id');
                $get_visitor_stall_details = $this->api_model->get_visitor_stall_details($data);
                //$get_visitor_stall_details['result'] = $get_visitor_stall_details['result'];
                if ($get_visitor_stall_details['count'] > 0) {
                    $arr = array('main_result' => '1', 'visitor_stall_details' => $get_visitor_stall_details['result']);
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                } else {
                    $arr = array('main_result' => '0', 'user_details' => "No Data");
                    header("Content-type: application/json; charset=utf-8");
                    print(json_encode($arr));
                    exit;
                }
            } else if ($api == "profile") {
                $data['username'] = $username = strtolower($this->input->post('username'));
                $data['active'] = $active = 1;
                $check_username = $this->api_model->check_username($data);

                if ($check_username['count'] > 0) {
                    $getUserDetArray = $check_username['result'][0];
                    $sms_users_id = $getUserDetArray->id;
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
            } else if ($api == "update_visitor") {
                //print_r($_POST);
                $data['username'] = $username = strtolower($this->input->post('username'));
                $data['active'] = $active = "0";
                $fathers_name = $this->input->post('fathers_name');
                $pref_course = $this->input->post('pref_course');
                $curr_course = $this->input->post('curr_course');
                $gender = $this->input->post('gender');
                $upd_visitor_id = $this->input->post('upd_visitor_id');
                $check_username = $this->api_model->check_username($data);
                if ($check_username['count'] > 0) {
                    $id = $check_username['result'][0]->id;
                    $active = $check_username['result'][0]->active;

                    if ($active == 1) {
                        $data_update['email'] = $email = strtolower($this->input->post('email'));
                        $data_update['password'] = $password = $this->input->post('password');
                        $data_update['first_name'] = $first_name = $this->input->post('first_name');
                        $data_update['age'] = $company = $this->input->post('age');
                        $data_update['phone'] = $phone = $this->input->post('phone');
                        $data_update['gender'] = $phone = $this->input->post('gender');


                        $this->ion_auth->update($id, $data_update);

                        $update_vis_det = array(
                            "school_name" => $this->input->post('school_name'),
                            "fathers_name" => $fathers_name,
                            "pref_course" => $pref_course,
                            "curr_course" => $curr_course,
                            "city" => $this->input->post('city')
                        );
                        $this->visitors_details_model->update_visitor_details_by_user_id($update_vis_det, $upd_visitor_id);

                        $arr = array('result' => '1', 'message' => "Profile Updated");
                        print(json_encode($arr));
                        exit;
                    } else {
                        $arr = array('result' => '1', 'message' => "Username inactive.");
                        print(json_encode($arr));
                        exit;
                    }
                } else {
                    $arr = array('result' => '0', 'message' => "Username not exist");
                    print(json_encode($arr));
                    exit;
                    //insert into DB
                }
            }     else if ($api == "get_sms_report") {
                
            }
        } else {
            $arr = array('main_result' => '401', 'message' => "Not In Post Method");
            print(json_encode($arr));
            exit;
        }
    }

    // --------------------------------------------------------------------
    /**
      # Function      :   update_
      # Purpose       :   api to register
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   08th Mar,2016
     */
    function register_post() {

        if (isset($_POST)) {

            

           
        } else {
            $arr = array('result' => '401', 'message' => "Not In Post Method");
            print(json_encode($arr));
            exit;
        }
    }

}
