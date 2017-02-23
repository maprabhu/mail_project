<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 	Extend the CI_Model class to add support for CRUD database methods
 *
 * 	// --------------------------------------------------------------------
 *
 * 	C => CREATE METHODS:
 *
 * 		create_data($data = array()) 
 *
 * 	R => READ METHODS:
 *
 * 		read_data_by_id($id)
 *
 * 	U => UPDATE METHODS:
 *
 * 		update_data_by_id($data = array(), $id)
 * 		update_data_where($data = array(), $where)
 *
 * 	D => DELETE METHODS:
 *
 * 		delete_data_by_id($id) 
 *
 * 	// --------------------------------------------------------------------
 *
 * 	@author		asmitha
 * 	@version	1.0.0
 */
class APP_Model extends CI_Model {

    /**
     * 	Init & set defaults
     */
    var $db_table = "";
    var $primary_key = "";
    var $valid_columns = array();

    // --------------------------------------------------------------------

    /**
     * 	The class constructor.
     *
     * 	@author	asmitha
     */
    public function __construct() {
        parent::__construct();
    }

    // --------------------------------------------------------------------
    // CREATE METHODS
    // --------------------------------------------------------------------

    /**
     * 	CRUD method to handle creating a new record
     *
     * 	@author	asmitha
     *
     * 	@param	array 	The assoc array of data to insert
     * 	@return mixed	The last insert id or False on failure
     */
    function create_data($data = array()) {
        // insert only valid columns
        foreach ($data as $key => $value) {
            if (in_array($key, $this->valid_columns)) {
                $this->db->set($key, $value);
            }
        }

        if (!$this->db->insert($this->db_table)) {
            return FALSE;
        }

        return $this->db->insert_id();
    }

    // --------------------------------------------------------------------
    // READ METHODS
    // --------------------------------------------------------------------

    /**
     * 	CRUD method to handle reading a single record's data by its id
     *
     * 	@author	asmitha
     *
     * 	@param 	int		The primary key's $id
     * 	@return mixed	The array of data or False if no results found.
     */
    function read_data_by_id($id) {
        $this->db->from($this->db_table);
        $this->db->where($this->primary_key, (int) $id);

        $query = $this->db->get();

        /** / // For debugging.
          $this->dbg->last_query($this->db);
          $this->dbg->display($query->result_array()); exit;
          /* */
        if ($query->num_rows == 1) {
            $data = $query->result_array();
            return $data[0];
        } else {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------
    // // READ METHODS
    // --------------------------------------------------------------------

    /**
     * 	CRUD method to handle reading a single record's data by its id
     *
     * 	@author	asmitha
     *
     * 	@param 	int		The primary key's $id
     * 	@return mixed	The array of data or False if no results found.
     */
    function read_data_by_field($field, $value) {
        $this->db->from($this->db_table);
        $this->db->where($field, $value);

        $query = $this->db->get();

        // For debugging.
        //$this->dbg->last_query($this->db);
        //$this->dbg->display($query->result_array()); exit;
        /**/
        //exit;
        if ($query->num_rows == 1) {
            $data = $query->result_array();
            return $data[0];
        } else {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------
    // UPDATE METHODS
    // --------------------------------------------------------------------

    /**
     * 	CRUD method to handle updating a single record's data
     *
     * 	@author	asmitha
     *
     * 	@param	array 	The assoc array of data to update
     * 	@param 	array	An array of name => value pairs for the where clause
     * 	@return boolean	True on success, False on failure
     */
    function update_data_where($data = array(), $where) {
        // update only valid columns
        $valid_data = array();
        foreach ($data as $key => $value) {
            if (in_array($key, $this->valid_columns)) {
                $valid_data[$key] = $value;
            }
        }

        if (!$this->db->update($this->db_table, $valid_data, $where)) {
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * 	CRUD method to handle updating a single record's data
     *
     * 	@author	asmitha
     *
     * 	@param	array 	The assoc array of data to update
     * 	@param 	int		The primary key's $id
     * 	@return boolean	True on success, False on failure
     */
    function update_data_by_id($data = array(), $id) {
        return $this->update_data_where($data, array($this->primary_key => (int) $id));
    }

    // --------------------------------------------------------------------
    // DELETE METHODS
    // --------------------------------------------------------------------

    /**
     * 	CRUD method to handle deleting a record
     *
     * 	@author	asmitha
     *
     * 	@param	array 	The assoc array of data to insert
     * 	@return mixed	The last insert id or False on failure
     */
    function delete_data_by_id($id) {
        return $this->db->delete($this->db_table, array($this->primary_key => $id));
    }

    // --------------------------------------------------------------------
}

/* End of file APP_Model.php */
/* Location: ./app/core/APP_Model.php */