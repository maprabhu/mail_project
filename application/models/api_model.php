<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * 	Model class to manage the database table :  api_model
 *
 * 	@author	Sathish
 *
 */
Class Api_model extends APP_Model {

    /**
     * Holds an array of tables used
     *
     * @var array
     * */
    public $tables = array();

    /**
     * activation code
     *
     * @var string
     * */
    public $activation_code;

    /**
     * forgotten password key
     *
     * @var string
     * */
    public $forgotten_password_code;

    /**
     * new password
     *
     * @var string
     * */
    public $new_password;

    /**
     * Identity
     *
     * @var string
     * */
    public $identity;

    /**
     * Where
     *
     * @var array
     * */
    public $_ion_where = array();

    /**
     * Select
     *
     * @var array
     * */
    public $_ion_select = array();

    /**
     * Like
     *
     * @var array
     * */
    public $_ion_like = array();

    /**
     * Limit
     *
     * @var string
     * */
    public $_ion_limit = NULL;

    /**
     * Offset
     *
     * @var string
     * */
    public $_ion_offset = NULL;

    /**
     * Order By
     *
     * @var string
     * */
    public $_ion_order_by = NULL;

    /**
     * Order
     *
     * @var string
     * */
    public $_ion_order = NULL;

    /**
     * Hooks
     *
     * @var object
     * */
    protected $_ion_hooks;

    /**
     * Response
     *
     * @var string
     * */
    protected $response = NULL;

    /**
     * message (uses lang file)
     *
     * @var string
     * */
    protected $messages;

    /**
     * error message (uses lang file)
     *
     * @var string
     * */
    protected $errors;

    /**
     * error start delimiter
     *
     * @var string
     * */
    protected $error_start_delimiter;

    /**
     * error end delimiter
     *
     * @var string
     * */
    protected $error_end_delimiter;

    /**
     * caching of users and their groups
     *
     * @var array
     * */
    public $_cache_user_in_group = array();

    /**
     * caching of groups
     *
     * @var array
     * */
    protected $_cache_groups = array();

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->config('ion_auth', TRUE);
        $this->load->helper('cookie');
        $this->load->helper('date');
        $this->lang->load('ion_auth');
        //define('SITE_API_URL',str_replace("admin/", "", base_url()));
        // initialize db tables data
        $this->tables = $this->config->item('tables', 'ion_auth');

        //initialize data
        $this->identity_column = $this->config->item('identity', 'ion_auth');
        $this->store_salt = $this->config->item('store_salt', 'ion_auth');
        $this->salt_length = $this->config->item('salt_length', 'ion_auth');
        $this->join = $this->config->item('join', 'ion_auth');


        // initialize hash method options (Bcrypt)
        $this->hash_method = $this->config->item('hash_method', 'ion_auth');
        $this->default_rounds = $this->config->item('default_rounds', 'ion_auth');
        $this->random_rounds = $this->config->item('random_rounds', 'ion_auth');
        $this->min_rounds = $this->config->item('min_rounds', 'ion_auth');
        $this->max_rounds = $this->config->item('max_rounds', 'ion_auth');


        // initialize messages and error
        $this->messages = array();
        $this->errors = array();
        $delimiters_source = $this->config->item('delimiters_source', 'ion_auth');

        // load the error delimeters either from the config file or use what's been supplied to form validation
        if ($delimiters_source === 'form_validation') {
            // load in delimiters from form_validation
            // to keep this simple we'll load the value using reflection since these properties are protected
            $this->load->library('form_validation');
            $form_validation_class = new ReflectionClass("CI_Form_validation");

            $error_prefix = $form_validation_class->getProperty("_error_prefix");
            $error_prefix->setAccessible(TRUE);
            $this->error_start_delimiter = $error_prefix->getValue($this->form_validation);
            $this->message_start_delimiter = $this->error_start_delimiter;

            $error_suffix = $form_validation_class->getProperty("_error_suffix");
            $error_suffix->setAccessible(TRUE);
            $this->error_end_delimiter = $error_suffix->getValue($this->form_validation);
            $this->message_end_delimiter = $this->error_end_delimiter;
        } else {
            // use delimiters from config
            $this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
            $this->message_end_delimiter = $this->config->item('message_end_delimiter', 'ion_auth');
            $this->error_start_delimiter = $this->config->item('error_start_delimiter', 'ion_auth');
            $this->error_end_delimiter = $this->config->item('error_end_delimiter', 'ion_auth');
        }


        // initialize our hooks object
        $this->_ion_hooks = new stdClass;

        // load the bcrypt class if needed
        if ($this->hash_method == 'bcrypt') {
            if ($this->random_rounds) {
                $rand = rand($this->min_rounds, $this->max_rounds);
                $params = array('rounds' => $rand);
            } else {
                $params = array('rounds' => $this->default_rounds);
            }

            $params['salt_prefix'] = $this->config->item('salt_prefix', 'ion_auth');
            $this->load->library('bcrypt', $params);
        }

        $this->trigger_events('model_constructor');
    }

    /**
     * 	method to check the user email existence
     * 	
     * 	@param	array	An assoc array of data
     * 	@return boolean	True on success, false on failure
     */
    // --------------------------------------------------------------------
    function check_email($data = array()) {
        $email = $data['email'];
        $active = $data['active'];
        $this->db->select("users.*");
        if ($email) {
            $this->db->where("users.email", $email);
        }
        if ($active) {
            $this->db->where("users.active", $active);
        }

        $this->db->from('users');
        $queryOrg = $this->db->get();
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return array('result' => '', 'count' => 0);
        }
    }

    /**
     *  method to check the user user id existence
     *  
     *  @param  array   An assoc array of data
     *  @return boolean True on success, false on failure
     */
    // --------------------------------------------------------------------
    function get_all_active_users($data = array()) {
        $active = $data['active'];
        $this->db->select("users.*");

        //$this->db->where("users.id != 1");
        $this->db->where("users.active = 1");
        $this->db->where("users_groups.group_id != 1");
        if ($active) {
            $this->db->where("users.active", $active);
        }
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        $this->db->from('users');

        $queryOrg = $this->db->get();
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return array('result' => '', 'count' => 0);
        }
    }

    /**
     *  method to check the user user id existence
     *  
     *  @param  array   An assoc array of data
     *  @return boolean True on success, false on failure
     */
    // --------------------------------------------------------------------
    function get_all_active_users_upon_user_type($data = array()) {
        $active = $data['active'];
        $user_id_session = $data['user_id_session'];
        $this->db->select("users.*");

        //$this->db->where("users.id != 1");
        $this->db->where("users.active = 1");
        $this->db->where("users_groups.group_id != 1");
        if ($active) {
            $this->db->where("users.active", $active);
        }
        if ($user_id_session) {
            $this->db->where("(users.created_by = '$user_id_session' OR users.id = '$user_id_session')");
        }
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        $this->db->from('users');

        $queryOrg = $this->db->get();
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return array('result' => '', 'count' => 0);
        }
    }

    /**
     * 	method to check the user user id existence
     * 	
     * 	@param	array	An assoc array of data
     * 	@return boolean	True on success, false on failure
     */
    // --------------------------------------------------------------------
    function get_user_details_by_id($data = array()) {
        $id = $data['id'];
        $this->db->select("users.*");
        $this->db->select("users_groups.group_id AS group_id",FALSE);

        if ($id) {
            $this->db->where("users.id", $id);
        }
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        $this->db->from('users');
        $queryOrg = $this->db->get();
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return array('result' => '', 'count' => 0);
        }
    }
 

    /**
     * 	method to check the update forgot pass code
     * 	
     * 	@param	array	An assoc array of data
     * 	@return boolean	True on success, false on failure
     */
    // --------------------------------------------------------------------
    function update_forgotten_password_code($update_code_array, $sms_users_id) {
        $this->db->where('id', $sms_users_id);
        $this->db->update('users', $update_code_array);
    }

    /**
     * login
     *
     * @return bool
     * @author Mathew
     * */
    public function login($email, $password) {
        // $mobile_auth_key_post = $data['mobile_auth_key_post'];

        $this->identity_column = "username";
        $query = $this->db->select($this->identity_column . ', email, id, password, active, last_login, first_name, last_name,is_logged_in')
                ->where($this->identity_column, $email)
                ->limit(1)
                ->order_by('id', 'desc')
                ->get('users');

                // echo $this->db->last_query();exit;

        if ($query->num_rows() === 1) {
            $user = $query->row();

            $password = $this->hash_password_db($user->id, $password);
            //$arr = array('response' => $password);
            //return (json_encode($arr));exit;
            if ($password === TRUE) {
                if ($user->active == 0) {
                    //return "2";
                    $arr = array('response' => "2", "result" => '');
                    return $arr;
                    //exit;
                } else {

                    $user_result = $query->result();
                    /*
                      if(($user_result[0]->is_logged_in == 1) && ($mobile_auth_key_post != $user_result[0]->mobile_auth_key)){
                      $arr = array('response' => "3", "result" => '', "message" => "Mobile authentication key error.");
                      return $arr;
                      } */
                    foreach ($user_result as $user_result_value) {
                        $check[] = array(
                            "email" => $user_result_value->email,
                            "user_id" => $user_result_value->id,
                            "first_name" => $user_result_value->first_name,
                            "last_name" => $user_result_value->last_name,
                            // "mobile_auth_key" => $mobile_auth_key_post,
                        );
                    }

                    $update_logged_in_array = array(
                        "is_logged_in" => 1
                        // "mobile_auth_key" => $mobile_auth_key_post,
                    );
                    $this->db->where('id', $user_result[0]->id);
                    $this->db->update('users', $update_logged_in_array);

                    //return "1";
                    $arr = array('response' => "1", "result" => $check);
                    return $arr;
                    //exit;
                }
            } else {
                //return "0";
                $arr = array('response' => "0", "result" => 'Login credentials are mismatching');
                return $arr;
                //exit;
            }
        } else {
            //return "0";
            $arr = array('response' => "0", "result" => 'User not existing');
            return $arr;
            //exit;
        }
    }
 

    /**
     *  method to check the user username existence
     *  
     *  @param  array   An assoc array of data
     *  @return boolean True on success, false on failure
     */
    // --------------------------------------------------------------------
    function check_username($data = array()) {
        $username = $data['username'];
        $active = $data['active'];
        $this->db->select("users.*",FALSE);
        $this->db->select("users_groups.id AS users_groups_id,users_groups.user_id AS user_id,users_groups.group_id AS group_id",FALSE);
        $this->db->select("groups.id AS grpid,groups.name AS name,groups.description AS description",FALSE);
        if ($username) {
            $this->db->where("users.username", $username);
        }
        if ($active) {
            $this->db->where("users.active", $active);
        }
        
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        $this->db->join('groups', 'groups.id = users_groups.group_id', 'LEFT');
        $this->db->from('users');
        $queryOrg = $this->db->get();
        //echo $this->db->last_query();
        if ($queryOrg->num_rows() > 0) {
            $rowcount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array('result' => $result, 'count' => $rowcount);
        } else {
            return array('result' => '', 'count' => 0);
        }
    }

       
    /**
     * This function takes a password and validates it
     * against an entry in the users table.
     *
     * @return void
     * @author Mathew
     * */
    public function hash_password_db($id, $password, $use_sha1_override = FALSE) {
        if (empty($id) || empty($password)) {
            return FALSE;
        }

        $this->trigger_events('extra_where');

        $query = $this->db->select('password, salt')
                ->where('id', $id)
                ->limit(1)
                ->order_by('id', 'desc')
                ->get($this->tables['users']);

        $hash_password_db = $query->row();

        if ($query->num_rows() !== 1) {
            return FALSE;
        }

        // bcrypt
        if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt') {
            if ($this->bcrypt->verify($password, $hash_password_db->password)) {
                return TRUE;
            }

            return FALSE;
        }

        // sha1
        if ($this->store_salt) {
            $db_password = sha1($password . $hash_password_db->salt);
        } else {
            $salt = substr($hash_password_db->password, 0, $this->salt_length);

            $db_password = $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
        }

        if ($db_password == $hash_password_db->password) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function trigger_events($events) {
        if (is_array($events) && !empty($events)) {
            foreach ($events as $event) {
                $this->trigger_events($event);
            }
        } else {
            if (isset($this->_ion_hooks->$events) && !empty($this->_ion_hooks->$events)) {
                foreach ($this->_ion_hooks->$events as $name => $hook) {
                    $this->_call_hook($events, $name);
                }
            }
        }
    }

    function get_users_info($data = array()) {
        $id = $data['user_id'];
        $this->db->select('*');
        $this->db->where("users_groups.group_id != $id");
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        $this->db->from('users');
        $queryOrg = $this->db->get();
        if($queryOrg->num_rows > 0) {
            $rowCount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array("result" => $result, 'count' => $rowCount);
        } else {
            return array("result" => '', "count" => '0');
        }
    }

    function get_users() {
        // $id = $data['user_id'];
        $this->db->select('*');
        // $this->db->where("users_groups.group_id != $id");
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'LEFT');
        $this->db->from('users');
        $queryOrg = $this->db->get();
        if($queryOrg->num_rows > 0) {
            $rowCount = $queryOrg->num_rows();
            $result = $queryOrg->result();
            return array("result" => $result, 'count' => $rowCount);
        } else {
            return array("result" => '', "count" => '0');
        }
    }


    function send_mail($data =array()) {
     // print_r($data);
       return $this->db->insert('message', $data);
    }
 
    function get_message($data = array()) {
        $user_id = $data['id'];
        $this->db->select("*");
        $this->db->where("receiverID", $user_id);
        $this->db->where("status", "0");
        $this->db->from("message");
        $queryOrg = $this->db->get();
         // echo $this->db->last_query();exit;
        if($queryOrg->num_rows > 0) {
           $rowCount = $queryOrg->num_rows();
           $result = $queryOrg->result();
           return array("result" => $result, 'count' => $rowCount);
        } else {
           return array("result" => '', "count" => '0');
        }
    }
 
    function get_sender_id($data) {
        // echo $data;exit;
        $this->db->select("*");
        $this->db->where("id", $data);
        $this->db->from("users");
        $queryOrg = $this->db->get();
        // echo $this->db->last_query();exit;
        $rowCount = $queryOrg->num_rows();
        $result = $queryOrg->result();
        return $result[0];
    }

    function get_sent_message($data= array()) {
        $user_id = $data['id'];
        $this->db->select("*");
        $this->db->where("userID", $user_id);
        $this->db->where("status", "0");
        $this->db->from("message");
        $queryOrg = $this->db->get();
        // echo $this->db->last_query();exit;
        if($queryOrg->num_rows > 0) {
           $rowCount = $queryOrg->num_rows();
           $result = $queryOrg->result();
           return array("result" => $result, 'count' => $rowCount);
        } else {
           return array("result" => '', "count" => '0');
        }
    }

    function update_trash_mail() {

       $select_trash = $this->db->select("*")->from('message')->where('status', "1")->get();
        if($select_trash->num_rows > 0) {
           $rowCount = $select_trash->num_rows();
           $result = $select_trash->result();
            return array("result" => $result, 'count' => $rowCount);
        } else {
           return array("result" => '', 'count' => '0');
        }    
    }

    function get_attach_id($data) {

        $user_id = $data;
        $this->db->select("*");
        $this->db->where("messageID", $user_id);
        $this->db->where("status", "0");
        $this->db->from("message");
        $queryOrg = $this->db->get();
        // echo $this->db->last_query();exit;
        if($queryOrg->num_rows > 0) {
           $rowCount = $queryOrg->num_rows();
           $result = $queryOrg->result();
           return array("result" => $result[0], 'count' => $rowCount);
        } else {
           return array("result" => '', "count" => '0');
        }

    }
    
    function get_sender_mail($data) {
        echo $data;exit;
    }

}

?>