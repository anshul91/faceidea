<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminCandidates extends CI_Controller {

    public $sub_domain = "";
    public $firm_id = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('candidatesModel');
        // $this->lang->load('candidates_lang');
        if ($this->session->userdata('firm_session')['firm_detail']) {
            $this->firm_id = $this->session->userdata('firm_session')['firm_detail']->firm_id;
        }else{
			redirect("login");
		}
    }

    public function index() {
        $data['admin_template'] = 'candidates/index';
		$data['candidate_detail'] = getTableData('tbl_candidate',array('firm_id'=>$this->firm_id));
		$data['department_detail'] = getTableData('tbl_department',array('firm_id'=>$this->firm_id));
		$data['designation_detail'] = getTableData('tbl_designation',array('firm_id'=>$this->firm_id));
        $this->load->view('templates/adminTemplate', $data);
    }
	
	 public function get_candidates_list() {
        $output = $this->candidatesModel->get_candidates_list();
        //output to json format
        echo json_encode($output);
    }
	
	public function get_candidates() {
        return $output = getTableData('tbl_candidate',array('firm_id'=>$this->firm_id));		        
    }
	public function render_edit_candidate(){
		$candidate_id = rq('candidate_id');
		$dpt_arr = getTableData('tbl_candidate',array("candidate_id"=>$candidate_id,"cols"=>array('candidate_id','title')))[0];		
		echo exit(json_encode(array("resp"=>$dpt_arr,"msg_type"=>"success","status"=>1)));
	}
    
  
    
    public function add_candidate() {
        
        $this->load->library('faceset');
        $resp_arr = array();
        if ($this->input->post() && $this->input->server("REQUEST_METHOD") === 'POST') {
            $this->form_validation->set_rules('f_name', 'First Name', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('l_name', 'Last name', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('email_id', 'Email', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('password', 'password', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('candidate_code', 'Candidate Code', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|max_length[30]|numeric');
            $this->form_validation->set_rules('department_id', 'Department', 'trim|required');
            $this->form_validation->set_rules('designation_id', 'Designation', 'trim|required');
            if (!$this->form_validation->run()) {
                $resp_arr = array("msg" => validation_errors(), "msg_type" => "error", "status" => 0);
            } else {
                $data_arr['candidate_detail'] = array(
                    'f_name' => rq('f_name'),
                    'l_name' => rq('l_name'),
                    'username' => rq('username'),
                    'email_id' => rq('email_id'),
                    'password' => rq('password'),
                    'candidate_code' => rq('candidate_code'),
                    'mobile_no' => rq('mobile_no'),
                    'start_date' => rq('start_date'),
                    'city' => rq('city'),
                    'address' => rq('address'),
                    'department_id' => rqs('department_id'),
                    'designation_id' => rqs('designation_id'),
                    'firm_id' => $this->firm_id,
                    'created' => date("Y-m-d H:i:s"),
                );
                if ($this->candidatesModel->add_candidate($data_arr)){                        
                    
                        $resp_arr = array(
                            "msg_type" => "info",
                            "status" => 2,
                            "msg" => "Candidate Added Successfully!",
                        );
                } else {
                    $resp_arr = array("msg" => 'Unable to Add Candidate please try later', 'msg_type' => 'error', 'status' => 0);
                }
            }
            exit(json_resp($resp_arr));
        }
    }
	
	public function upload_candidate_pic(){
		
		$config['upload_path']          = IMAGE_PATH."/candidate_pic";
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 5048;
		$config['encrypt_name'] = TRUE;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
		$this->load->library('upload', $config);
		// prd($_FILES);
		if ( ! $this->upload->do_upload('file'))
		{
			
			$error = array('error' => $this->upload->display_errors());
			prd($error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			
			return $data;
		}
	}
	
	public function edit_candidate() {   
		
        $this->load->library('faceset');
        $resp_arr = array();
        if ($this->input->post() && $this->input->server("REQUEST_METHOD") === 'POST') {
            $this->form_validation->set_rules('candidate_id', 'Candidate Id', 'trim|required');
            $this->form_validation->set_rules('title', 'Candidate Title', 'trim|required|max_length[30]|callback_check_duplicateCandidate');
           
            if (!$this->form_validation->run()) {
                $resp_arr = array("msg" => validation_errors(), "msg_type" => "error", "status" => 0);
            } else {
                $data_arr['candidate_detail'] = array(
                    'title' => rq('title'),                    
                    'modified' => date("Y-m-d H:i:s"),
                );
                if ($this->candidatesModel->edit_candidate($data_arr,rq('candidate_id'))){                        
                    
                        $resp_arr = array(
                            "msg_type" => "info",
                            "status" => 2,
                            "msg" => "Candidate Updated Successfully!",
                        );
                } else {
                    $resp_arr = array("msg" => 'Unable to Update Candidate please try later', 'msg_type' => 'error', 'status' => 0);
                }
            }
			
            exit(json_resp($resp_arr));
        }
    }
	
	 public function check_duplicateCandidate($title) {
        //$candidate_arr = getTableData("tbl_candidate",array("title"=>$title,"firm_id!="=>$this->firm_id,"cols"=>array("candidate_id")));
		$ret_flag = $this->candidatesModel->check_duplicate_candidate($title,$this->firm_id);
        if ($ret_flag) {
            $this->form_validation->set_message('check_duplicateCandidate', "Duplicate Candidate Title Found");
            return false;
        } else {
            return true;
        }
    }
	
	public function delete_candidate(){
		$candidate_id = rq('candidate_id');
		if($this->candidatesModel->delete_candidate($candidate_id)){
			
				$resp_arr = array("msg" => 'Candidate Deleted Successfully!', 'msg_type' => 'success', 'status' => 1);
           
		}else{
			$resp_arr = array("msg" => 'Unable to Delete Candidate please try later', 'msg_type' => 'error', 'status' => 0);
		}
		exit(json_resp($resp_arr));
	}
}

?>   