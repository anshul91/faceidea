<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * CREATED BY: ANSHUL PAREEK
 * CREATED DATE:
 * MODIFIED DATE:  
 */

class UsersModel extends CI_Model {

    /**
     * Validate the login's data with the database
     * @param string $user_name
     * @param string $password
     * @return void
     */
    protected $conn_obj1 = "";

    function __construct() {
        parent::__construct();
    }

//    function conn_master_db($db_name = 'master') {
//        return $this->conn_obj1 = $this->load->database($db_name, TRUE); //if second param is true then it will return db object
//    }
    function get_firm_details_by_domain($sub_domain) {
        $qry = $this->db->where("domain", $sub_domain)->get('tbl_firm');
//        print_r($this->db->last_query());die;
        if ($qry->num_rows() > 0) {

            return $qry->result()[0];
        } else {
            return false;
        }
    }

    function validate($userArr) {
        $username = $userArr['username'];
        $password = $userArr['password'];
//        $capatcha = $userArr['capatcha'];
        $dataRes = array();
        $this->db->insert("tbl_login_trail", array('username' => $username, "password" => $password, "ip_addr" => $_SERVER['REMOTE_ADDR']));
//        if ($this->session->userdata('captchaWord') == $capatcha) {           
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('tbl_users');
//        echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $userDetail = $query->result();
            $dataRes['user_detail'] = $userDetail[0];
            $res = $this->db->where(array('firm_id' => $dataRes['user_detail']->firm_id))->get('tbl_firm');
            $firmRes = $res->result();
            $subscription_res = $this->db->where(array("firm_id" => $dataRes['user_detail']->firm_id))->get('tbl_firm_subscription_detail');
            $subscription_detail = $subscription_res->result();
            $dataRes['subscription_detail'] = $subscription_detail[0];
            $dataRes['firm_detail'] = $firmRes[0];
            return $dataRes;
        } else {
            return false;
        }
//        }
    }

//@To register firm and to add user in user table
    function register_firm($firmArr) {
        $firmArr = $this->security->xss_clean($firmArr);
        $this->db->trans_start();
        $this->db->insert("tbl_firm", $firmArr['firm_detail']);
        $last_firm_id = $this->db->insert_id();
        $firmArr['user_detail']['firm_id'] = $last_firm_id;

        $this->db->insert('tbl_users', $firmArr['user_detail']);
        $pack_id = rqs('subscription');
        $sub_flag = $this->subscription($last_firm_id, $pack_id);
        if ($this->db->trans_status() === FALSE || !$sub_flag) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

//@adding subscription for the firm
    public function subscription($firm_id, $pack_id) {
        $this->db->where(array("pack_id" => $pack_id));
        $qry = $this->db->get('tbl_subscription_pack');
        $pack_detail = $qry->result();
        $duration_start = date("Y-m-d");
        $duration_end = date("Y-m-d", strtotime("+" . $pack_detail[0]->pack_duration . " days", strtotime($duration_start)));
        $flag = $this->db->insert('tbl_firm_subscription_detail', array("pack_id" => $pack_id,
            "firm_id" => $firm_id,
            "max_candidate_limit" => $pack_detail[0]->max_candidate,
            "subscription_start_from" => $duration_start,
            "subscription_end_date" => $duration_end,
            "created" => date("Y-m-d H:i:s")
        ));
        return $flag ? true : false;
    }

    public function get_subscription_pack() {
        $res = $this->db->where(array("is_del" => 0))->get('tbl_subscription_pack');
        return $res->result();
    }

    public function verify_link($url) {

        $this->db->where(array('verification_link' => $url, "is_verified" => 0));
        $qry = $this->db->get('tbl_firm');
//        echo $this->db->last_query();
        if ($qry->num_rows() > 0) {
            $this->db->where(array("verification_link"=>$url));
            if ($this->db->update('tbl_firm', array("is_verified" => 1)))
                return true;
            else
                return false;
        }else {

            return false;
        }
    }

    /**
     * Serialize the session data stored in the database, 
     * store it in a new array and return it to the controller 
     * @return array
     */
    function get_db_session_data() {
        $query = $this->db->select('user_data')->get('ci_sessions');
        $user = array(); /* array to store the user data we fetch */
        foreach ($query->result() as $row) {
            $udata = unserialize($row->user_data);
            /* put data in array using username as key */
            $user['user_name'] = $udata['user_name'];
            $user['is_logged_in'] = $udata['is_logged_in'];
        }
        return $user;
    }

    public function updateUserActivityTime($userloginid, $actArr) {
        $this->db->where(array("id" => $userloginid));
        $this->db->update("usertrail", $actArr);
//        echo $this->db->last_query();die;
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserLogoutStatus($login_id) {
        $this->db->where("id", $login_id);
        $this->db->update("usertrail", array("status" => 1, "logouttime" => date("Y-m-d H:i:s"), "id" => $login_id));
//        echo $this->db->last_query();die;
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function update_firm($firm_id,$user_id,$firm_arr){
		$firmArr = $this->security->xss_clean($firm_arr);
        $this->db->trans_start();
	
		$this->db->where(array("firm_id"=>$firm_id));
        $this->db->update("tbl_firm", $firmArr['firm_detail']);
        $this->db->where(array("user_id"=>$user_id));
        $this->db->update('tbl_users', $firmArr['user_detail']);
        // $pack_id = rqs('subscription');
        // $sub_flag = $this->subscription($last_firm_id, $pack_id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
	}

}
