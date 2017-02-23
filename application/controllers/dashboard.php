<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *    File Name              : dashboard
 *    Description            :     
 *    Created By             : Sathish
 *    Created Date           : 18th Jan,2016
 *    Last Modified By       :
 *    Last Modified Date     :
 *    Change Log             :   
 *
 */
class Dashboard extends APP_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }

    }

    // --------------------------------------------------------------------
    /**
      # Function      :   index
      # Purpose       :   index
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   11th Dec,2015
     */
    function index() {

        $browserTitle = $this->config->item('browserTitle');
        $data['title'] = $browserTitle . ' - Dashboard';
        if($this->ion_auth->get_users_groups()->row()->id == 1) {
            $this->_tpl_super_admin('dashboard/dashboard', $data);
        }else {
            $this->_tpl_user('dashboard/dashboard_user', $data);
        }
        
    }

    //End of company related management sql functions

    
}

?>