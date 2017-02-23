<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * 	Model class to manage the database table :  organization
 *
 * 	@author	Sathish
 *
 */
Class Common_Model extends APP_Model {
    // --------------------------------------------------------------------

    /**
     * 	Constructor -- Loads parent class
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * 	method to check the user email existence
     * 	
     * 	@param	array	An assoc array of data
     * 	@return boolean	True on success, false on failure
     */
    // --------------------------------------------------------------------
    function get_all_users($data = array()) {
        
        $this->db->select("users.*");
        $this->db->where("users_groups.group_id != 1");
        $this->db->join('users_groups', 'users_groups.id = users.id', 'LEFT');
        $this->db->from('users');
        //echo "sssssss=".$this->db->last_query();exit
        $queryOrg = $this->db->get();
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return 'failure';
        }
    }
    
      
    /**
     * 	method to check the user email existence
     * 	
     * 	@param	array	An assoc array of data
     * 	@return boolean	True on success, false on failure
     */
    // --------------------------------------------------------------------
    function get_all_users_data($data = array()) {
        $this->db->select("users.*");
        
        $this->db->where("users_groups.group_id != 1");
        
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        
        $this->db->from('users');
        
        $queryOrg = $this->db->get();
        //echo "get_all_users_data=".$this->db->last_query();exit;
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return 'failure';
        }
    }
    
    /**
     * 	method to check the user email existence
     * 	
     * 	@param	array	An assoc array of data
     * 	@return boolean	True on success, false on failure
     */
    // --------------------------------------------------------------------
    function get_grp_users_data($data = array()) {
        $group_name = $data['group_name'];
        $this->db->select("users.*");
        if($group_name){
            $this->db->where("groups.name",$group_name);
        }
        $this->db->where("users_groups.group_id != 1");
        
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        $this->db->join('groups', 'groups.id = users_groups.group_id', 'LEFT');
        $this->db->from('users');
        
        $queryOrg = $this->db->get();
        //echo "get_all_users_data=".$this->db->last_query();exit;
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return 'failure';
        }
    }
    
        
}

?>
