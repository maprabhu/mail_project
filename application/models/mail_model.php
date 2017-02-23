<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * 	Model class to manage the database table :  manage_users_model
 *
 * 	@author	Sathish
 *
 */
Class Mail_model extends APP_Model {

    /**
     * 	Define table attributes
     */
    var $db_table = "message";
    var $primary_key = "messageID";

    /**
     * 	Define all valid insert columns (leave out the primary key)
     */
    var $valid_columns = array(
        'email',
        'receiverID',
        'receiverType',
        'subject',
        'message',
        'attach'
        'attach_file_name'
        'userID'
        'usertype'
        'useremail'
        'year'
        'date'
        'create_date'
        'read_status'
        'from_status'
        'to_status'
        'fav_status'
        'fav_status_sent'
        'reply_status'

      );

    /**
     * 	Define all valid update (set) columns
     */
    var $valid_set_columns = array(
        'email',
        'receiverID',
        'receiverType',
        'subject',
        'message',
        'attach'
        'attach_file_name'
        'userID'
        'usertype'
        'useremail'
        'year'
        'date'
        'create_date'
        'read_status'
        'from_status'
        'to_status'
        'fav_status'
        'fav_status_sent'
        'reply_status'
    );

    // --------------------------------------------------------------------

    /**
     * 	Constructor -- Loads parent class
     */
    function __construct() {
        parent::__construct();
    }
    

    function send_mail($data= array()) {
        print_r($data);exit;
    // return $this->db->insert('billet_info', $data);
    }
 
}

?>