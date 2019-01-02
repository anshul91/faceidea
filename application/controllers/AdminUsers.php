<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminUsers extends CI_Controller {

    public $sub_domain = "";

    public function __construct() {
        parent::__construct();
        $this->load->model('usersModel');
        $this->lang->load('users_lang');
    }

    public function index() {
        if (empty($this->session->userdata('firm_session'))) {
            $this->login_view();
        } else {
            $this->dashboard();
        }
    }

//    public function login() {
//        if ($this->session->get_userdata('firm_session')) {
//            $this->validate_login();
//        } else {
//            die("here");
//        }
//    }

    public function dashboard() {
        $data['firm_detail'] = $this->session->get_userdata('firm_session');
        $data['admin_template'] = 'dashboards/dashboard';
        $this->load->view('templates/adminTemplate', $data);

//        $this->load->view('', $data);
    }

    public function login_view() {
        $sub_domain = 'default';
        if (!empty($this->session->userdata('firm_session'))) {
            exit(redirect('dashboard'));
        }
        $this->sub_domain = $this->get_sub_domain();
        if (isset($this->sub_domain[0]) && strtolower($this->sub_domain[0]) == 'localhost') {
            $data['firm_name'] = APP_NAME;
        } else {
            $data['firm_name'] = $this->sub_domain[0];
            $sub_domain = $this->sub_domain[0];
        }

        $data['firm_detail'] = $this->usersModel->get_firm_details_by_domain($sub_domain);
//        $data['firm_detail'] = "";
//        $data['main_content'] = 'users/login';
        $this->load->view('users/login', $data);
    }

    public function get_user_detail_by_domain() {
        return isset($this->sub_domain[0]) ?
                $this->userModel->get_user_detail_by_domain($this->sub_domain[0]) :
                $this->get_sub_domain()[0];
    }

    /* API METHODS STARTS HERE */

    public function validate_login() {
        $resp_arr = array();
        if ($this->session->get_userdata('firm_session')) {
            $resp_arr = array(
                "msg_type" => "success",
                "status" => 1,
                "msg" => "Already Loggedin!",
                "resp" => ''
            );
        }
        if ($this->input->post() && $this->input->server("REQUEST_METHOD") === 'POST') {

            $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[40]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[40]');
            //$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><a class="close" data-dismiss="alert" aria-label="close" href="#">×</a><strong>', '</strong></div>');
            if (!$this->form_validation->run()) {
                $resp_arr = array("msg" => validation_errors(), "msg_type" => "error", "status" => 0);
            } else {
                $userArr = array(
                    'username' => rq('username'),
                    'password' => hash('sha512', rq('password'))
                );
                //calling model function to validate user

                if ($resp = $this->usersModel->validate($userArr)) {
					$this->session->set_userdata(array("firm_session" => $resp));
					$firm_id = $this->session->userdata("firm_session")['firm_detail']->firm_id;
					$resp_url = 'dashboard';
					
					$address_arr = getTableData("tbl_firm",array("firm_id"=>$firm_id))[0];
					
					if(empty($address_arr->address) || !isset($address_arr->address)){
						$resp_url = "edit-firm-detail";						
					}
                    $resp_arr = array(
                        "msg_type" => "success",
                        "status" => 1,
                        "msg" => "Login successfully!",
                        "resp_url" => $resp_url,
                    );
                    
					
                    #add session values in cache file for a user
                } else {
                    $resp_arr = array("msg" => 'Username or password do not matched!', 'msg_type' => 'error', 'status' => 0);
                }
            }
            exit(json_resp($resp_arr));
        }
    }

//
//    public function login() {
//        if ($this->session->get_userdata('firm_session')) {
//            $this->validate_login();
//        } else {
//            die("here");
//        }
//    }

    /* Register new firm code starts here */

    public function register_view() {
        $sub_domain = 'default';
        if (!empty($this->session->userdata('firm_session'))) {
            exit(redirect('index'));
        }
        $data = array();
        $data['subscription_pack'] = $this->usersModel->get_subscription_pack();
        $this->load->view('users/register', $data);
    }

    public function register_firm() {
        $this->load->library('faceset');
        $resp_arr = array();
        if ($this->input->post() && $this->input->server("REQUEST_METHOD") === 'POST') {
            $this->form_validation->set_rules('firm_name', 'Firm Name', 'trim|required|max_length[30]|alpha_numeric');
            $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|max_length[40]|is_unique[tbl_firm.email_id]|valid_email', array('is_unique' => "User already exists with this email"));
            $this->form_validation->set_rules('mobile_no', 'Mobile no.', 'trim|required|exact_length[10]|is_unique[tbl_firm.mobile_no]|numeric', array('is_unique' => "User already exists with this mobile no."));
            $this->form_validation->set_rules('domain', 'Domain', 'trim|required|max_length[10]|min_length[2]|is_unique[tbl_firm.domain]|alpha_numeric', array('is_unique' => "Firm already exists with the same domain name"));
            $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[20]|min_length[2]|is_unique[tbl_users.username]', array('is_unique' => "Username already exists!"));
            $this->form_validation->set_rules('password', 'passsword', 'trim|required|max_length[20]|min_length[9]');
            $this->form_validation->set_rules('re-password', 'Password Confirmation', 'trim|required|max_length[20]|min_length[9]|matches[password]');
            $this->form_validation->set_rules('subscription', 'Subscription', 'trim|required');
            if (!$this->form_validation->run()) {
                $resp_arr = array("msg" => validation_errors(), "msg_type" => "error", "status" => 0);
            } else {
                $verification_link = $this->generate_verification_link();

                $data_arr['firm_detail'] = array(
                    'firm_name' => rq('firm_name'),
                    'email_id' => rq('email_id'),
                    'mobile_no' => rq('mobile_no'),
                    'domain' => rq('domain'),
                    'verification_link' => $verification_link
                );
                $data_arr['user_detail'] = array(
                    'username' => rq('username'),
                    'password' => hash("sha512", rq('password')),
                    'user_type' => "f",
                    'created' => date("Y-m-d H:i:s"),
                );
                $subject = "Email Verification";
                $message = "Hello Anshul,<br/>Please visit this link to activate your account Click Here"
                        . "<br/>if you are unable to click on the above link. "
                        . "<br/><br/>Copy this and paste it in the url "
                        . "$verification_link<br/>"
                        . "<br/><br/> Warm Regards,<br/> Team <a href='gadgetprogrammers.online' target='_blank' rel='nofollow'>" . APP_NAME . "</a>";
                //calling model function to validate user
                if ($this->usersModel->register_firm($data_arr) &&
                        send_email($data_arr['firm_detail']['email_id'], $subject, $message)) {
                    /* Adding faceset on */
                   
                        $resp_arr = array(
                            "msg_type" => "success",
                            "status" => 1,
                            "msg" => "Registered Successfully! <BR/> We've sent you a varification email",
                        );
                    
                } else {
                    $resp_arr = array("msg" => 'Unable to register please try later', 'msg_type' => 'error', 'status' => 0);
                }
            }
            exit(json_resp($resp_arr));
        }
    }

    public function generate_verification_link() {
        return site_url() . "verify/" . substr(str_shuffle("asdfasdfasdlkjjwoieur234oiutwjlkdfjiwotu"), 0, 20) . strtotime(date("Y-m-d H:i:s"));
    }

    public function verify_link_view() {
        $data = array();
        $this->load->view('users/verify', $data);
    }

    public function verify_link() {
        $url = $_SERVER['HTTP_REFERER'];
        if ($this->usersModel->verify_link($url)) {
            echo json_resp(array(
                "msg" => " You have been verified Successfully!<br/>"
                . " Now! Please follow given link and fill your details in order to activate your portal!<br/><a href='" . site_url() . "firm_detail' class='btn btn-danger btn-xs'>Click Here</a>",
                "msg_type" => "success",
                "status" => 1,
                "redirect_url" => ""));
        } else {
            echo json_resp(array(
                "msg" => "Invalid or expired Link!",
                "msg_type" => "error",
                "redirect_url" => "",
                "status" => 0));
        }
    }

    public function get_sub_domain() {
        return explode(".", $_SERVER['HTTP_HOST'], 2);
    }

    public function logout() {
        session_destroy();
        redirect('login');
    }
	
	public function firm_detail_view(){
		$data = array();
		if(!empty($this->session->userdata('firm_session'))){
			$data['firm_data_arr'] = $this->session->userdata('firm_session');
		}else if(!empty($this->session->userdata('candidate_session'))){
			die("candidate_data");
		}
		$data['admin_template'] = 'users/view_firm_detail';
		$this->load->view('templates/adminTemplate', $data);
	}
	
	public function render_firm_detail_edit(){
		$data = array();
		if(!empty($this->session->userdata('firm_session'))){
			$data['subscription_pack'] = $this->usersModel->get_subscription_pack();
			$data_arr['firm_detail'] = getTableData("tbl_firm",array("firm_id"=>$this->session->userdata("firm_session")['firm_detail']->firm_id))[0];
			$data_arr['user_detail'] = getTableData("tbl_users",array("firm_id"=>$this->session->userdata("firm_session")['user_detail']->user_id))[0];
			$data_arr['subscription_detail'] = getTableData("tbl_firm_subscription_detail",array("firm_id"=>$this->session->userdata("firm_session")['user_detail']->firm_id))[0];			
			$data['firm_data_arr'] = $data_arr;			
		}else if(!empty($this->session->userdata('candidate_session'))){
			die("candidate_data");
		}
		$data['admin_template'] = 'users/firm_detail';
		$this->load->view('templates/adminTemplate', $data);
	}
	
	public function update_firm_detail() {
		
        $this->load->library('faceset');
        $resp_arr = array();
        if ($this->input->post() && $this->input->server("REQUEST_METHOD") === 'POST') {
            $this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[300]');
            $this->form_validation->set_rules('city', 'City', 'trim|max_length[30]');
            $this->form_validation->set_rules('country', 'country', 'trim|max_length[30]');
            $this->form_validation->set_rules('f_name', 'Contact Person First Name', 'trim|required|min_length[3]|max_length[30]|alpha_numeric');
            $this->form_validation->set_rules('l_name', 'Contact Person Last Name', 'trim|required|min_length[3]|max_length[30]|alpha_numeric');           
            $this->form_validation->set_rules('mobile_no', 'Mobile no.', 'trim|required|exact_length[10]|numeric');
            $this->form_validation->set_rules('subscription', 'Subscription', 'trim|required');
            if (!$this->form_validation->run()) {
                $resp_arr = array("msg" => validation_errors(), "msg_type" => "error", "status" => 0);
            } else {
				/*Uploading Logo file in img folder*/
				$old_logo = '';
				$old_logo_arr = getTableData("tbl_firm",array("firm_id"=>$this->session->userdata("firm_session")['firm_detail']->firm_id,'cols'=>array('logo')));				
				if(isset($old_logo_arr[0])){					
					$old_logo = $old_logo_arr[0]->logo;
				}
				if($_FILES['logo']['name'] != ''){
					$img_resp = $this->do_upload();
					if(isset($img_resp['error'])){					
						$resp_arr = array("msg" => $img_resp['error'], "msg_type" => "error", "status" => 0);
						exit(json_resp($resp_arr));
					}
					/*delete old logo*/
					
					if(file_exists(IMAGE_PATH.$old_logo)){
						unlink(IMAGE_PATH.$old_logo);
					}
					
					/*New encrypted name of logo file*/
					$new_logo = $img_resp['upload_data']['file_name'];
				}else{
					$new_logo = $old_logo;
				}
				
                $data_arr['firm_detail'] = array(
                    // 'firm_name' => rq('firm_name'),
                    'f_name' => rq('f_name'),
                    'l_name' => rq('l_name'),
                    'city' => rq('city'),
                    'country' => rq('country'),
                    'address' => rq('address'),
                    // 'email_id' => rq('email_id'),
                    'mobile_no' => rq('mobile_no'),
					'logo' => $new_logo,
					'modified' => date("Y-m-d H:i:s"),
					
                  
                );
                $data_arr['user_detail'] = array(
                   
                    'updated' => date("Y-m-d H:i:s"),
                );
               $firm_id = $this->session->userdata('firm_session')['firm_detail']->firm_id;
               $user_id = $this->session->userdata('firm_session')['user_detail']->user_id;
               // $subscription_id = $this->session->userdata('firm_session'))['subscription_detail']->subscription_id;
                if ($this->usersModel->update_firm($firm_id,$user_id,$data_arr)) {
                    $data_arr['firm_detail'] = getTableData("tbl_firm",array("firm_id"=>$this->session->userdata("firm_session")['firm_detail']->firm_id))[0];
						
                        $resp_arr = array(
                            "msg_type" => "success",
                            "status" => 1,
							"logo"=>$data_arr['firm_detail'] = getTableData("tbl_firm",array("firm_id"=>$this->session->userdata("firm_session")['firm_detail']->firm_id,'cols'=>array('logo')))[0]->logo,
                            "msg" => "Details has been Updated Successfully!",
                        );
						$this->session->userdata("firm_session")['firm_detail']->logo = $new_logo;
						// $this->session->set_userdata(array("firm_session"=>array("firm_detail"=>array("logo"=>$new_logo))));
                } else {
                    $resp_arr = array("msg" => 'Unable to Update Details please try later', 'msg_type' => 'error', 'status' => 0);
                }
            }
            exit(json_resp($resp_arr));
        }
    }
	
	 public function do_upload()
        {
                $config['upload_path']          = IMAGE_PATH;
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 5048;
				$config['encrypt_name'] = TRUE;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;
                $this->load->library('upload', $config);
				
                if ( ! $this->upload->do_upload('logo'))
                {
					return $error = array('error' => $this->upload->display_errors());
                }
                else
                {
					$data = array('upload_data' => $this->upload->data());
					return $data;
                }
        }


}
