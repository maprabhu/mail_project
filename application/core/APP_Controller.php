<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 	Extend CI's Controller class to add system-wide application specific logic
 *
 * 	@author		gotphp.com
 * 	@version	1.0.0
 */
class APP_Controller extends CI_Controller {

    /**
     * 	Init & set defaults
     */
    var $tpl_data = array();
    var $uri_data = array();
    var $current_dts = 0;

    // --------------------------------------------------------------------

    /**
     * 	class constructor
     *
     * 	@author	gotphp.com
     */
    public function __construct() {
        parent::__construct();

        // Enable the profiler.
        //$this->output->enable_profiler(TRUE);
        $this->output->enable_profiler(FALSE);

        // Load config/version.php
        $this->config->load('version');

        // Init: current_dts	
        $this->current_dts = date('Y-m-d H:i:s');

        // Init: The URI data as an assoc array.
        $this->uri_data = $this->uri->ruri_to_assoc();

        // Init: Template data
        $this->tpl_data = array
            (
            'js_path' => base_url() . 'assets/js',
            'css_path' => base_url() . 'assets/css',
            'img_path' => base_url() . 'assets/images',
            'assets_path' => base_url() . 'assets',
            'version' => $this->config->item('app_version')
        );
		/*
        //Remember me 
        $cookie_user = $this->rememberme->verifyCookie();
        if ($cookie_user) {
            // find user id of cookie_user stored in application database
            $user_details = $this->login_model->rememberme_user_login($cookie_user);

            if ($user_details) {
                foreach ($user_details as $row) {
                    $this->session->set_userdata('user_id', $row->user_id);
                    $this->session->set_userdata('phc_id', $row->phc_id);
                    $this->session->set_userdata('taluk_id', $row->taluk_id);
                    $this->session->set_userdata('is_loggedin', 1);
                    $this->session->set_userdata('registered_role_flag', strtolower($row->user_type));
                }
            }
        }
        */
        //set session data
        /*
		$this->Registered_Role_Flag = $this->session->userdata('registered_role_flag');
        $this->User_Id = $this->session->userdata('user_id');
        $this->User_Specific_Id = $this->session->userdata('user_specific_id');
        $this->school_id = $this->session->userdata('school_id');
		*/
    }
 

    // --------------------------------------------------------------------

    /**
     * 	Method to load the "view" and add private template variables to the 
     * 	public template variables.
     *
     * 	@author	gotphp.com
     *
     * 	@param	string	Path to the template file.
     * 	@param	array	Array of private template variables.
     * 	@param	bool	True or False to enable this template to be cached.
     * 	@param	int		The number of minutes to cache this template.
     */
    function _tpl_super_admin($tpl_name, $private_tpl_data = array(), $cache_enabled = FALSE, $cache_time = 1) {
        if ($cache_enabled) {
            $this->output->cache((int) $cache_time);
        }
        $this->load->vars($this->tpl_data + $private_tpl_data);

        $this->load->view("common/app_header");
        $this->load->view("common/app_sidebar");
        $this->load->view($tpl_name);
        $this->load->view("common/app_footer");
        //}
    }
    
    // --------------------------------------------------------------------

    /**
     *  Method to load the "view" and add private template variables to the 
     *  public template variables.
     *
     *  @author gotphp.com
     *
     *  @param  string  Path to the template file.
     *  @param  array   Array of private template variables.
     *  @param  bool    True or False to enable this template to be cached.
     *  @param  int     The number of minutes to cache this template.
     */
    function _tpl_user($tpl_name, $private_tpl_data = array(), $cache_enabled = FALSE, $cache_time = 1) {
        if ($cache_enabled) {
            $this->output->cache((int) $cache_time);
        }
        $this->load->vars($this->tpl_data + $private_tpl_data);

        $this->load->view("common/app_header");
        $this->load->view("common/app_sidebar_user");
        $this->load->view($tpl_name);
        $this->load->view("common/app_footer");
        //}
    }

      
    // --------------------------------------------------------------------
}

/* End of file APP_Controller.php */
/* Location: ./app/core/APP_Controller.php */