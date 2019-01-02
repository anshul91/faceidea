<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminDepartments extends CI_Controller {

    public $sub_domain = "";
    public $firm_id = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('departmentsModel');
        $this->lang->load('departments_lang');
        if ($this->session->userdata('firm_session')['firm_detail']) {
            $this->firm_id = $this->session->userdata('firm_session')['firm_detail']->firm_id;
        }else{
			redirect("login");
		}
    }

    public function index() {

        $data['admin_template'] = 'departments/index';
        $this->load->view('templates/adminTemplate', $data);
    }
	
	public function render_edit_department(){
		$department_id = rq('department_id');
		$dpt_arr = getTableData('tbl_department',array("department_id"=>$department_id,"cols"=>array('department_id','title','sub_title')))[0];
		
		echo exit(json_encode(array("resp"=>$dpt_arr,"msg_type"=>"success","status"=>1)));
	}
    
    public function get_department_list() {
        $output = $this->departmentsModel->get_department_list();
        //output to json format
        echo json_encode($output);
    }
    
    public function add_department() {
        
        $this->load->library('faceset');
        $resp_arr = array();
        if ($this->input->post() && $this->input->server("REQUEST_METHOD") === 'POST') {
            $this->form_validation->set_rules('title', 'Department Title', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('sub_title', 'Department Sub-title', 'trim|required|max_length[40]');
            if (!$this->form_validation->run()) {
                $resp_arr = array("msg" => validation_errors(), "msg_type" => "error", "status" => 0);
            } else {

                $data_arr['department_detail'] = array(
                    'title' => rq('title'),
                    'sub_title' => rq('sub_title'),
                    'firm_id' => $this->firm_id,
                    'created' => date("Y-m-d H:i:s"),
                );
                if ($faceset_outer_id = $this->departmentsModel->add_department($data_arr)){                        
                     if (!$faceset = $this->faceset->add_faceset(rq('title'), $faceset_outer_id)) {
                        $resp_arr = array(
                            "msg_type" => "info",
                            "status" => 2,
                            "msg" => "Department Added Successfully! But not for faceset!",
                        );
                    } else {
                        $resp_arr = array(
                            "msg_type" => "info",
                            "status" => 2,
                            "msg" => "Department Added Successfully!",
                        );
					}
                } else {
                    $resp_arr = array("msg" => 'Unable to Add Department please try later', 'msg_type' => 'error', 'status' => 0);
                }
            }
            exit(json_resp($resp_arr));
        }
    }
    
	public function edit_department() {   
		
        $this->load->library('faceset');
        $resp_arr = array();
        if ($this->input->post() && $this->input->server("REQUEST_METHOD") === 'POST') {
            $this->form_validation->set_rules('department_id', 'Department Id', 'trim|required');
            $this->form_validation->set_rules('title', 'Department Title', 'trim|required|max_length[30]|callback_check_duplicateDepartment');
            $this->form_validation->set_rules('sub_title', 'Department Sub-title', 'trim|required|max_length[40]');
            if (!$this->form_validation->run()) {
                $resp_arr = array("msg" => validation_errors(), "msg_type" => "error", "status" => 0);
            } else {

                $data_arr['department_detail'] = array(
                    'title' => rq('title'),
                    'sub_title' => rq('sub_title'),
                    'modified' => date("Y-m-d H:i:s"),
                );
                if ($this->departmentsModel->edit_department($data_arr,rq('department_id'))){
						$department_arr = getTableData("tbl_department",array("department_id"=>rq("department_id")));
                     if (!$d = $this->faceset->update_faceset(rq('title'), rq('department_id'))) {
						 
                        $resp_arr = array(
                            "msg_type" => "info",
                            "status" => 2,
                            "msg" => "Department Updated Successfully! But not for faceset!",
							"faceset"=>$d
                        );
                    } else {
						
                        $resp_arr = array(
                            "msg_type" => "info",
                            "status" => 2,
                            "msg" => "Department Updated Successfully!",
							"faceset_resp"=>$d
                        );
					}
                } else {
                    $resp_arr = array("msg" => 'Unable to Update Department please try later', 'msg_type' => 'error', 'status' => 0);
                }
            }
            exit(json_resp($resp_arr));
        }
    }
	
	 public function check_duplicateDepartment($title) {
        //$department_arr = getTableData("tbl_department",array("title"=>$title,"firm_id!="=>$this->firm_id,"cols"=>array("department_id")));
		$ret_flag = $this->departmentsModel->check_duplicate_department($title,$this->firm_id);
		// var_dump($ret_flag);die;
        if ($ret_flag) {
            $this->form_validation->set_message('check_duplicateDepartment', "Duplicate Department Title Found");
            return false;
        } else {
            return true;
        }
    }
	
	public function delete_department(){
		$this->load->library('faceset');
		$faceset_outer_id = $department_id = rq('department_id');
		if($this->departmentsModel->delete_department($department_id)){
			if($d = $this->faceset->delete_faceset($faceset_outer_id)){
				$resp_arr = array("msg" => 'Department Deleted Successfully!', 'msg_type' => 'success', 'status' => 1,"resp"=>$d);
            }else{
				$resp_arr = array("msg" => 'Unable to Delete Department please try later', 'msg_type' => 'error', 'status' => 0);
			}
		}else{
			$resp_arr = array("msg" => 'Unable to Delete Department please try later', 'msg_type' => 'error', 'status' => 0);
		}
		exit(json_resp($resp_arr));
	}
	
	
}

?>   