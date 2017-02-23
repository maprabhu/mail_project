<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$ci = & get_instance();
$ci->load->database();
$ci->db->query("SET SESSION sql_mode = ''");
/**
 * 	The enum_select 
 *
 * 	@author	Sathish
 */
if (!function_exists('enum_select')) {

    function enum_select($table, $field) {
        $ci = & get_instance();
        $ci->load->database();

        $row = $ci->db->query("SHOW COLUMNS FROM " . $table . " LIKE '$field'")->row()->Type;

        $regex = "/'(.*?)'/";
        preg_match_all($regex, $row, $enum_array);
        $enum_fields = $enum_array[1];
        foreach ($enum_fields as $key => $value) {
            $enums[$value] = $value;
        }

        return $enums;
    }

}

if (!function_exists('get_task_status')) {

    /**
     * 
     * get_task_status
     *
     * @author Sathish
     */
    function get_task_status($data) {
        $state = $data['state'];
        
        $CI = &get_instance();
        $CI->db->select("CASE state WHEN '1' THEN 'In Progress' WHEN '2' THEN 'Complete' ELSE 'Inactive' END AS state_status",false);
        	
        if ($state) {
            $CI->db->where("(project_objects.`state` = '$state')");
        }
        
        $CI->db->from('project_objects');
        $query = $CI->db->get();
        //echo $CI->db->last_query()."<br/>";exit;
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return '';
        }
		
    }
}

if (!function_exists('get_category_name')) {

    /**
     * 
     * get_task_status
     *
     * @author Sathish
     */
    function get_category_name($categories_id) {
       
        $CI = &get_instance();
        $CI->db->select("categories.name AS cat_name",false);
        	
        if ($categories_id) {
            $CI->db->where("(categories.`categories_id` = '$categories_id')");
        }
        
        $CI->db->from('categories');
        $query = $CI->db->get();
        //echo $CI->db->last_query()."<br/>";exit;
        if ($query->num_rows() > 0) {
            return $query->result()['0']->cat_name;
        } else {
            return '';
        }
		
    }
}

function send_sms($data) {
    define("authKey","110339AgCZSTsK2i57120ab8");
    define("SMS_URL","http://login.smscentral.in/api/sendhttp.php");
    define("SENDER_ID","COBRAS");
    //define("SMS_ROUTE_TYPE","4");
    //Multiple mobiles numbers separated by comma
    $receiver_mobile = $data['receiver_mobile'];
    
    //Your message to send, Add URL encoding here.
    $message = urlencode($data['message']);
    
//Your authentication key
    $authKey = authKey;


    

//Sender ID,While using route4 sender id should be 6 characters long.
    $senderId = SENDER_ID;



//Define route 
    $route = SMS_ROUTE_TYPE;
//Prepare you post parameters
    $postData = array(
        'authkey' => $authKey,
        'mobiles' => $receiver_mobile,
        'message' => $message,
        'sender' => $senderId,
        'route' => $route
    );

//API URL
    $url = SMS_URL;

// init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
    ));


//Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
    $output = curl_exec($ch);

//Print error if any
    if (curl_errno($ch)) {
        return 'error:' . curl_error($ch);
        //return "error";
    }

    curl_close($ch);

    return $output;
}

function send_voice_sms($data) {
    
    $voice_sms_url = $data['voice_sms_url'];$username = $data['username'];
    $password = $data['password'];$script_id = $data['script_id'];
    $Destination = $data['Destination'];$message = $data['message'];
    $sender_mobile = $data['sender_mobile'];$camp_name = $data['camp_name'];
    $phonebook_id = $data['phonebook_id'];$start_date = $data['start_date'];
    $end_date = $data['end_date'];$start_time = $data['start_time'];
    $end_time = $data['end_time'];$retry = $data['retry'];
    $interval = $data['interval'];
    
//Prepare you post parameters
     
    $qry = "?username=".$username."&password=".$password."&script_id=".$script_id."&Destination=".$Destination
            ."&camp_name=".$camp_name."&phonebook_id=".$phonebook_id."&start_date=".$start_date
            ."&end_date=".$end_date."&start_time=".$start_time."&end_time=".$end_time."&retry=".$retry
            ."&interval=".$interval;
    //echo $voice_sms_url . $qry;exit;
    $ch = curl_init();
   
    // Set query data here with the URL
    curl_setopt($ch, CURLOPT_URL, $voice_sms_url . $qry); 

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
    $content = trim(curl_exec($ch));
    curl_close($ch);
    //echo json_encode($content);

    return $content;
}

if (!function_exists('get_site_config')) {

    /**
     * 
     * get_task_status
     *
     * @author Sathish
     */
    function get_site_config() {
        
        $CI = &get_instance();
        $id = $CI->session->userdata('user_id');
        
        $CI->db->select("*",false);
        $CI->db->where("id",$id);	
        
        $CI->db->from('users');
        $query = $CI->db->get();
        //echo $CI->db->last_query()."<br/>";//exit;
        if ($query->num_rows() > 0) {
            return $query->result()['0'];
        } else {
            return '';
        }
		
    }
}


/*
 * Send push details to other clients server
 */
function push_messages_to_other_server($data) {
    //Multiple mobiles numbers separated by comma
    $receiver_mobile = $data['receiver_mobile'];
    $sender_mobile = $data['sender_mobile'];
    $send_sms_output = $data['send_sms_output'];
    $msg_sent_date = $data['msg_sent_date'];
    
    //Your message to send, Add URL encoding here.
    $message = $data['message'];

//Prepare you post parameters
    $postData = array(
        'receiver_mobile' => $receiver_mobile,
        'sender_mobile' => $sender_mobile,
        'send_sms_output' => $send_sms_output,
        'msg_sent_date' => $msg_sent_date,
        'message' => $message
    );

//API URL
    $url = "http://demo.cobrasoftwares.in/misscallapi/pushMessageUrl.php";

// init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
    ));


//Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
    $output = curl_exec($ch);

//Print error if any
    if (curl_errno($ch)) {
        return 'error:' . curl_error($ch);
        //return "error";
    }

    curl_close($ch);

    return $output;
}


if (!function_exists('get_user_details_helper')) {

    /**
     * 
     * get_task_status
     *
     * @author Sathish
     */
    function get_user_details_helper($data) {
        $id = $data['id'];
        
        $CI = &get_instance();
        $CI->db->select("*",FALSE);
        	
        if ($id) {
            $CI->db->where("users.`id`",$id);
        }
        
        $CI->db->from('users');
        $query = $CI->db->get();
        //echo $CI->db->last_query()."<br/>";exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return '';
        }
		
    }
}