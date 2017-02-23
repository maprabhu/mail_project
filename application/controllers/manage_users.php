<?php

class Manage_users extends APP_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('excel');
    }

    // redirect if needed, otherwise display the user list
    function index() {
        $data = array();
        if ($this->ion_auth->is_admin()) {

            $this->_tpl_super_admin('manage_other_users/manage_other_users_view', $data);
        } else {
            redirect('auth/login');
        }
    }
 
////////////other users starts    
    // ---------------------------------------------------------------------
    /**
      # Function      :   manage_other_users
      # Purpose       :   Load manage_other_users
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   11th Dec,2015
     */
    function manage_other_users() {
        $data = array();
        $data['title'] = "Manage Users";
        $data_user['id'] = $this->session->userdata('user_id');
        $data_user['active'] = '1';
        //print_r($data_user);exit;

        $data['grouplist'] = $this->ion_auth_model->grouplist();
        if ($this->ion_auth->is_admin()) {
            $this->_tpl_super_admin('manage_other_users/manage_other_users_view', $data);
        }else if($this->ion_auth->get_users_groups()->row()->name == 'reseller'){
            $this->_tpl_reseller('manage_other_users/manage_other_users_view', $data);
        }
         else {
            redirect('auth/login');
        }
    }

    // ---------------------------------------------------------------------
    /**
      # Function      :   list_all_other_users
      # Purpose       :   Load list_all_other_users
      # params        :   none
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   11th Dec,2015
     */
    function list_all_other_users() {
        $start = $limit = $value = $search_post_val = $recordsTotal = $recordsFiltered = $sort_column = $sort_order = "";
        $data = array();
        $response = array();
        $this->form_validation->set_rules('start', 'start', 'trim|required');
        $this->form_validation->set_rules('length', 'limit', 'trim|required');
        $this->form_validation->set_rules('draw', 'draw', 'trim|required');
        $this->form_validation->set_rules('order', 'order', 'required');
        if ($this->form_validation->run() == FALSE) {
            $response['draw'] = 0;
            $response['recordsTotal'] = 0;
            $response['recordsFiltered'] = 0;
            $response['data'] = $data;
            echo json_encode($response);
        } else {
            $start = $this->input->post('start');
            $limit = $this->input->post('length');
            $draw = $this->input->post('draw');
            $search_post = $this->input->post('search');
            $search_post_val = $search_post['value'];
            $sort_config = $this->input->post('order');

            if ($sort_config[0]['column'] == 0) {
                $sort_column = 'first_name';
            }
            if ($sort_config[0]['column'] == 1) {
                $sort_column = 'phone';
            }
            if ($sort_config[0]['column'] == 2) {
                $sort_column = 'email';
            }
            if ($sort_config[0]['column'] == 3) {
                $sort_column = 'active';
            }
            if ($sort_config[0]['column'] == 4) {
                $sort_column = 'username';
            }
            
            $sort_order = $sort_config[0]['dir'];
            $searchdata['first_name'] = $this->input->post('search_first_name');
            if($this->ion_auth->get_users_groups()->row()->name == 'admin'){
                $searchdata['logged_users_id'] = "";
            }else if($this->ion_auth->get_users_groups()->row()->name == 'reseller'){
                $searchdata['logged_users_id'] = $this->session->userdata('user_id');
            }

            if (!empty($search_post_val) || !empty($searchdata)) {
                $profileList = $this->manage_users_model->manage_other_users_live_search($searchdata, $search_post_val, $sort_column, $sort_order, $start, $limit);
                $searchCount = $this->manage_users_model->manage_other_users_live_search_count($searchdata, $search_post_val);
                $recordsTotal = $recordsFiltered = $searchCount->count;
            } else {
                $profileList = $this->manage_users_model->list_manage_other_users_limit($sort_column, $sort_order, $start, $limit);
                $recordsTotal = $recordsFiltered = $this->manage_users_model->manage_other_users_tbl_count();
            }
            for ($i = 0; $i < $profileList['count']; $i++) {
                $id = $profileList['result'][$i]->id;
                $data_send['id'] = $profileList['result'][$i]->id;

                $action = '';
                $action .= '<div class="btn-group width_col pull-left">
                      <button type="button" class="btn btn-xs btn-warning">Manage</button>
                      <button type="button" class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                      ';


                $action .= '<li><a href="#"  data-toggle="modal" data-tooltip="Activate/Deactivate" data-target="#actDecUsersModal" onclick="javascript:activate_deactivate_user(\'' . $profileList['result'][$i]->id . '\');">Activate/Deactivate</a></li>
                              <li class="divider"></li>';
                $action .= '<li><a href="#"  data-toggle="modal" data-tooltip="Edit" data-target="#editOtherUsersModal" onclick="javascript:edit_other_user(\'' . $profileList['result'][$i]->id . '\');">Edit</a></li>
                              <li class="divider"></li>';

                $action .= '<li><a href="#" data-toggle="modal" data-tooltip="Delete"
                                onclick="javascript:del_other_user(\'' . $profileList['result'][$i]->id . '\');"
                                data-target="#deleteOtherUserModal">Delete</a></li>
                                ';
                                               
                 
                $action .= '</ul>
                    </div>';


                
                //print_r($chk_payment_details);
                $todaysdate = date('Y-m-d');
                $displink = "default";
                $status = "";
                $subscrip_status="";
                 
                 
                
                $data[] = array('slno' => $i + 1, 'id' => $profileList['result'][$i]->id, 'username' => $profileList['result'][$i]->username, 
                    //'first_name' => $profileList['result'][$i]->first_name, 
                    'phone' => $profileList['result'][$i]->phone, 
                    'email' => $profileList['result'][$i]->email, 
                    'created_on_date' => $profileList['result'][$i]->created_on_date,
                    'action' => $action);
            }
            $response['draw'] = $draw;
            $response['recordsTotal'] = $recordsTotal;
            $response['recordsFiltered'] = $recordsFiltered;
            $response['data'] = $data;
            echo json_encode($response);
        }
    }

    /**
      # Function  :   del_other_user
      # Purpose   :   Delete a registered profile from DB
      # params    :   none
      # Return    :   success/error
     */
    function del_other_user() {
        $delResponse = array();
        $this->form_validation->set_rules('delete_other_user_id', 'User Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $delResponse['error'] = 'User ID Missing.';
            echo json_encode($delResponse);
        } else {
            $delete_other_user_id = $this->input->post('delete_other_user_id');
            $data['id'] = $this->input->post('delete_other_user_id');
            //$profileDel = $this->manage_users_model->delete_users_info_data_by_id($delete_other_user_id);
            $profileDel = $this->ion_auth->delete_user($delete_other_user_id);
            

            if ($this->db->_error_number() == 1451) {
                $delResponse['error_no'] = "1451";
                $delResponse['status'] = "Sorry cannot delete visitor, related items exist in other tables.";
                echo json_encode($delResponse);
            } else {
                if ($profileDel) {
                    $delResponse['eventlist'] = "Success";
                    $delResponse['status'] = "User Deleted Successfully";
                    echo json_encode($delResponse);
                } else {
                    $delResponse['error'] = 'Failed to Delete user.';
                    echo json_encode($delResponse);
                }
            }
        }
    }

    // --------------------------------------------------------------------
    /**
      # Function      :   get_other_user_details
      # Purpose       :   load the the details related to the get_other_user_details
      # params        :   dist id
      # Return        :   none
      # Created_by    :   Sathish
      # Created_date  :   20 Sept 2015
     */
    function get_other_user_details() {
        $data['id'] = $this->input->post('other_user_id');
        //print_r($data['id']);exit;
        $data['active'] = '1';
        //$get_other_user_details = $this->api_model->get_other_user_details($data);
        $get_user_details_by_id = $this->api_model->get_user_details_by_id($data);
        // print_r($get_user_details_by_id);exit;
        echo json_encode($get_user_details_by_id['result'][0]);
    }
  

    function script_excel($data, $query) {
        //activate worksheet number 1
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
       /* $this->excel->getActiveSheet()->setTitle('Visitors list');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Name');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Phone');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Email');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Event Name');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Event Place');
        $this->excel->getActiveSheet()->setCellValue('F1', 'School name');
 */
        // get all users in array formate
        //$users = $this->userModel->get_users();
 
        // read data to active sheet
        $fields = array('first_name', 'phone', 'email','event_details','event_place','school_name','event_date');
        $col = 0;
        foreach ($fields as $field)
        {
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
        
        // Fetching the table data
        $row = 2;
        foreach($query as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
 
            $row++;
        }
 
        $this->excel->setActiveSheetIndex(0);
        //$this->excel->getActiveSheet()->fromArray($query);
 
        $filename='visitor_data.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }

}
