<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * 	Model class to manage the database table :  manage_users_model
 *
 * 	@author	Sathish
 *
 */
Class Manage_furnace_model extends APP_Model {

    /**
     * 	Define table attributes
     */
    var $db_table = "furnace_info";
    var $primary_key = "furnace_info_id";

    /**
     * 	Define all valid insert columns (leave out the primary key)
     */
    var $valid_columns = array(
        'furnace_number',
        'description',
        'created_date'
      );

    /**
     * 	Define all valid update (set) columns
     */
    var $valid_set_columns = array(
        'furnace_number',
        'description',
        'created_date'
    );

    // --------------------------------------------------------------------

    /**
     * 	Constructor -- Loads parent class
     */
    function __construct() {
        parent::__construct();
    }

    // --------------------------------------------------------------------
    // INSERT DATA
    // --------------------------------------------------------------------

    /**
     * 	method to insert a new event
     *
     * 	@param	array	An assoc array of data
     * 	@return	int	The new $users_id
     */
    function insert_users_info($data = array()) {
        $data += array(
            "created_on" => $this->current_dts,
        );
        return $this->create_data($data);
    }

    // --------------------------------------------------------------------
    // UPDATE METHODS
    // --------------------------------------------------------------------

    /**
     * 	method to update a state by their $users_id
     * 	
     * 	@param	array	An assoc array of data
     * 	@param	int	The $users_id
     * 	@return boolean	True on success, false on failure
     */
    // --------------------------------------------------------------------
    function set_users_info_data_by_id($data = array(), $users_id) {
        return $this->update_data_by_id($data, $users_id);
    }

    // --------------------------------------------------------------------
    // DELETE METHODS
    // --------------------------------------------------------------------

    /**
     * 	method to delete a state by their $users_id
     * 	
     * 	@param	array	An assoc array of data
     * 	@param	int	The $users_id
     * 	@return boolean	True on success, false on failure
     */
    function delete_users_info_data_by_id($users_id) {
        return $this->delete_data_by_id($users_id);
    }

    // --------------------------------------------------------------------
    // GET DATA
    // --------------------------------------------------------------------

    /**
     * 	method to get a single school by their $users_id
     * 	
     * 	@param	int	The $users_id
     * 	@return	array	The array of data, or false if not found
     */
    function get_users_info_by_id($users_id) {
        return $this->read_data_by_id($users_id);
    }

    // --------------------------------------------------------------------
    /**
     * 	
     *
     * 	@author	Sathish
     *
     */
    function remove_users_data_by_id($users_id) {

        $this->db->where('users_id', $users_id);
        $this->db->delete('users');
    }

      

    //other users starts
    /* 	
      # Function          :	list_manage_other_users_limit
      # Purpose           :	List users with start point and limit, order with selected column
      # params            :	sorting column name, sorting order, limit, starting point
      # Return            :   array
     */
    function list_manage_other_users_limit($sort_column, $sort_order, $limit, $start) {

        $this->db->select("*");

        $this->db->where("(users_groups.group_id != '1')");//users_groups.group_id = '2' AND 
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        $this->db->join('groups', 'groups.id = users_groups.group_id', 'LEFT');

        $this->db->from('users');
        $this->db->order_by($sort_column, $sort_order);
        $this->db->limit($start, $limit);
        //echo $this->db->last_query();
        $queryOrg = $this->db->get();
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return 'failure';
        }
    }

    /* 	
      # Function          :	manage_other_material_live_search
      # Purpose           :	List users with keyword, start point and limit, order with selected column
      # params            :	keyword, sorting column name, sorting order, limit, starting point
      # Return            :   array
     */

    function manage_other_furnace_live_search($searchdata, $keyword, $sort_column, $sort_order, $limit, $start) {
        
        // $first_name = $searchdata['first_name'];
        // $logged_users_id = $searchdata['logged_users_id'];

        $this->db->select("furnace_info.*");
       // $this->db->select("users.id AS users_id");

        //$this->db->select("CASE users.active WHEN '0' THEN 'Inactive' WHEN '1' THEN 'Active' END AS active_status", FALSE);
        
        //$this->db->select("(select CASE payment_details.present_status WHEN '1' THEN 'Active' WHEN '2' THEN 'Inactive' END AS subscrip_status from payment_details where payment_details.sms_users_id=users_id)", FALSE);
        
        // $this->db->select("groups.name as user_type",FALSE);
        // $this->db->where("(users_groups.group_id != '1')");//users_groups.group_id = '2' AND 

        // if ($searchdata['first_name'] != "") {
        //     $this->db->where("users.first_name = '$first_name'");
        // }
        // if ($searchdata['logged_users_id'] != "") {
        //     $this->db->where("(users_groups.group_id != '2' AND users_groups.group_id != '3')");
        // }
        if ($keyword) {
            $this->db->where("(furnace_info.furnace_number LIKE '%$keyword%' OR  furnace_info.description LIKE '%$keyword%')");
        }

        // $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        // $this->db->join('groups', 'groups.id = users_groups.group_id', 'LEFT');

        $this->db->from('furnace_info');
        // $this->db->order_by($sort_column, $sort_order);
        $this->db->limit($start, $limit);
         $this->db->group_by("furnace_info.furnace_info_id");
        $queryOrg = $this->db->get();
        //echo $this->db->last_query();exit;
        $rowcount = $queryOrg->num_rows();
        $result = $queryOrg->result();
        return array('result' => $result, 'count' => $rowcount);
    }

    /* 	
      # Function          :	manage_other_users_tbl_count
      # Purpose           :	count the total entry in table
      # params            :	none
      # Return            :   number
     */

    function manage_other_users_tbl_count() {
        $this->db->select("users.*");
        $this->db->where("(users_groups.group_id != '1')");//users_groups.group_id = '2' AND 

        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        $this->db->join('groups', 'groups.id = users_groups.group_id', 'LEFT');

        $this->db->from('users');
        $queryOrg = $this->db->get();
        $rowcount = $queryOrg->num_rows();
        return $rowcount;
    }

    /* 	
      # Function          :	manage_other_furnace_live_search_count
      # Purpose           :	count for the keyword
      # params            :	keyword
      # Return            :   number
     */

    function manage_other_furnace_live_search_count($searchdata, $keyword) {
        
        // $first_name = $searchdata['first_name'];
        // $logged_users_id = $searchdata['logged_users_id'];

        //$this->db->select('COUNT(*) AS count');
        $this->db->select('COUNT(*) AS count');
       // $this->db->where("(users_groups.group_id != '1')");

       // if ($searchdata['first_name'] != "") {
       //      $this->db->where("users.first_name = '$first_name'");
       //  }
        // if ($searchdata['logged_users_id'] != "") {
        //     $this->db->where("(users_groups.group_id != '2' AND users_groups.group_id != '3')");
        // }
        if ($keyword) {
            $this->db->where("(furnace_info.furnace_number LIKE '%$keyword%' OR  furnace_info.description LIKE '%$keyword%')");
        }

        // $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        // $this->db->join('groups', 'groups.id = users_groups.group_id', 'LEFT');

        $this->db->from('furnace_info');
        //$this->db->group_by("users.id");
        $queryOrg = $this->db->get();
        //echo $this->db->last_query();
        $response = $queryOrg->result();
        return $response[0];
    }
  
    /* 	
      # Function          :	update_user_group
      # Purpose           :	count for the keyword
      # params            :	keyword
      # Return            :   number
     */

    // --------------------------------------------------------------------
    function update_user_group($update_user_group, $update_other_user_id) {
        $this->db->where('user_id', $update_other_user_id);
        $this->db->update('users_groups', $update_user_group);
        //echo $this->db->last_query();
    }

    function insert_furnace($data= array()) {
        // print_r($data);exit;
      return $this->db->insert('furnace_info', $data);
    }
     
     function get_furnace($data = array()) {
       //print_r($data);exit;
      $this->db->select("*");
      $this->db->where('furnace_info_id', $data);
      $this->db->from('furnace_info');
      $queryOrg = $this->db->get();
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return 'failure';
        }
     }

  function update_furnace($data=array(), $furnace_id) {
    $this->db->where('furnace_info_id', $furnace_id);
    return $this->db->update('furnace_info', $data);
        
  }

  function delete_furnace($data) {
  return $this->delete_data_by_id($data);
  }

}

?>