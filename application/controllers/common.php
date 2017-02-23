<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *    File Name              : common
 *    Description            :     
 *    Created By             : Sathish
 *    Created Date           : 23rd Jan,2016
 *    Last Modified By       :
 *    Last Modified Date     :
 *    Change Log             :   
 *
 */
class Common extends APP_Controller {

    function __construct() {
        parent::__construct();
        
        /*if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }*/
        $this->load->helper('download');
    }

    // --------------------------------------------------------------------
    /**
      # Function      :   index
      # Purpose       :   index
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   26th jan,2016
     */
    function index() {

        $browserTitle = $this->config->item('browserTitle');
        $data['title'] = $browserTitle . ' - Common';
    }
    
    // --------------------------------------------------------------------
    /**
      # Function      :   downloadfile
      # Purpose       :   downloadfile
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   26th jan,2016
     */
    function downloadfile() {
        $downloadfilename = $this->input->post('downloadfilename', TRUE);
        $downloadfilenamepath = $this->input->post('downloadfilenamepath', TRUE);
         
        $data = file_get_contents(base_url()."assets/uploads/bug_track/".$downloadfilename); // Read the file's contents
        //echo base_url()."assets/uploads/bug_track/".$downloadfilename;
        force_download($downloadfilename, $data);
        exit;
        $file_path = base_url()."assets/uploads/bug_track/".$downloadfilename;
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=$downloadfilename");
    ob_clean();
    flush();
    readfile($file_path);
        exit;
        $this->path = "assets/";
        $this->file = $this->path . $downloadfilenamepath;
        force_download($downloadfilename, read_file($this->file));
    }
    
    
    // --------------------------------------------------------------------
    /**
      # Function      :   deletefile
      # Purpose       :   deletefile
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   26th jan,2016
     */
    function deletefile() {
        $deletefilename = $this->input->post('deletefilename', TRUE);
        $deletefilenamepath = $this->input->post('deletefilenamepath', TRUE);
        $file_attachments_id  = $this->input->post('file_attachments_id', TRUE);
        $file_path = base_url()."assets/uploads/bug_track/".$deletefilename;
        $this->file_attachments_model->delete_file_attachments_info_data_by_id($file_attachments_id);
        unlink($file_path);
        exit;
        $file_path = base_url()."assets/uploads/bug_track/".$downloadfilename;
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=$downloadfilename");
    ob_clean();
    flush();
    readfile($file_path);
        exit;
        $this->path = "assets/";
        $this->file = $this->path . $downloadfilenamepath;
        force_download($downloadfilename, read_file($this->file));
    }
    //End of common related management sql functions

    
}

?>