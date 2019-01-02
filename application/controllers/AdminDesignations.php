<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminDesignations extends CI_Controller {

    public $sub_domain = "";
    public $firm_id = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('designationsModel');
        $this->lang->load('designations_lang');
        if ($this->session->userdata('firm_session')['firm_detail']) {
            $this->firm_id = $this->session->userdata('firm_session')['firm_detail']->firm_id;
        }else{
			redirect("login");
		}
    }

    public function index() {

        $data['admin_template'] = 'designations/index';
        $this->load->view('templates/adminTemplate', $data);
    }
	
	public function render_edit_designation(){
		$designation_id = rq('designation_id');
		$dpt_arr = getTableData('tbl_designation',array("designation_id"=>$designation_id,"cols"=>array('designation_id','title')))[0];		
		echo exit(json_encode(array("resp"=>$dpt_arr,"msg_type"=>"success","status"=>1)));
	}
    
    public function get_designations_list() {
        $output = $this->designationsModel->get_designations_list();
        //output to json format
        echo json_encode($output);
    }
    
    public function add_designation() {
        
        $this->load->library('faceset');
        $resp_arr = array();
        if ($this->input->post() && $this->input->server("REQUEST_METHOD") === 'POST') {
            $this->form_validation->set_rules('title', 'Designation Title', 'trim|required|max_length[30]|callback_check_duplicateDesignation');
            if (!$this->form_validation->run()) {
                $resp_arr = array("msg" => validation_errors(), "msg_type" => "error", "status" => 0);
            } else {
                $data_arr['designation_detail'] = array(
                    'title' => rq('title'),
                    'firm_id' => $this->firm_id,
                    'created' => date("Y-m-d H:i:s"),
                );
                if ($this->designationsModel->add_designation($data_arr)){                        
                    
                        $resp_arr = array(
                            "msg_type" => "info",
                            "status" => 2,
                            "msg" => "Designation Added Successfully!",
                        );
                } else {
                    $resp_arr = array("msg" => 'Unable to Add Designation please try later', 'msg_type' => 'error', 'status' => 0);
                }
            }
            exit(json_resp($resp_arr));
        }
    }
    
	public function edit_designation() {   
		
        $this->load->library('faceset');
        $resp_arr = array();
        if ($this->input->post() && $this->input->server("REQUEST_METHOD") === 'POST') {
            $this->form_validation->set_rules('designation_id', 'Designation Id', 'trim|required');
            $this->form_validation->set_rules('title', 'Designation Title', 'trim|required|max_length[30]|callback_check_duplicateDesignation');
           
            if (!$this->form_validation->run()) {
                $resp_arr = array("msg" => validation_errors(), "msg_type" => "error", "status" => 0);
            } else {
                $data_arr['designation_detail'] = array(
                    'title' => rq('title'),                    
                    'modified' => date("Y-m-d H:i:s"),
                );
                if ($this->designationsModel->edit_designation($data_arr,rq('designation_id'))){                        
                    
                        $resp_arr = array(
                            "msg_type" => "info",
                            "status" => 2,
                            "msg" => "Designation Updated Successfully!",
                        );
                } else {
                    $resp_arr = array("msg" => 'Unable to Update Designation please try later', 'msg_type' => 'error', 'status' => 0);
                }
            }
			
            exit(json_resp($resp_arr));
        }
    }
	
	 public function check_duplicateDesignation($title) {
        //$designation_arr = getTableData("tbl_designation",array("title"=>$title,"firm_id!="=>$this->firm_id,"cols"=>array("designation_id")));
		$ret_flag = $this->designationsModel->check_duplicate_designation($title,$this->firm_id);
        if ($ret_flag) {
            $this->form_validation->set_message('check_duplicateDesignation', "Duplicate Designation Title Found");
            return false;
        } else {
            return true;
        }
    }
	
	public function delete_designation(){
		$designation_id = rq('designation_id');
		if($this->designationsModel->delete_designation($designation_id)){
			
				$resp_arr = array("msg" => 'Designation Deleted Successfully!', 'msg_type' => 'success', 'status' => 1);
           
		}else{
			$resp_arr = array("msg" => 'Unable to Delete Designation please try later', 'msg_type' => 'error', 'status' => 0);
		}
		exit(json_resp($resp_arr));
	}
}

?>   