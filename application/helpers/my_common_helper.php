<?php

if (!function_exists('json_resp')) {

    function json_resp($ret_resp, $msg_type = 'success', $status = 1) {
        $ci = &get_instance();
        $msg_type_arr = array(0 => 'error', 1 => 'success', 2 => 'warning', 3 => 'info');
        if (array_key_exists('status', $ret_resp) && !array_key_exists('msg_type', $ret_resp)) {
            $msg_type = $msg_type_arr[$ret_resp['status']];
        } else if (array_key_exists('msg_type', $ret_resp) && !array_key_exists('status', $ret_resp)) {
            $status = array_keys($msg_type_arr, $ret_resp['msg_type']);
//                        array_keys($msg_type_arr, $ci)
        }else if(array_key_exists('msg_type', $ret_resp) && array_key_exists('status', $ret_resp)){
            $msg_type = $ret_resp['msg_type'];
            $status = $ret_resp['status'];;
        }
        
        return is_array($ret_resp) ?
                json_encode(array_merge($ret_resp, array("msg_type" => $msg_type, "status" => $status, 'csrf_token_name' => $ci->security->get_csrf_hash()))) :
                false;
    }

}


if (!function_exists("getTableData")) {

    function getTableData($tablename = null, $filter = array()) {
        if ($tablename == null)
            return false;
        $ci = &get_instance();
        $table = $tablename;
        $cols = " * ";
        $cond = " WHERE 1=1 ";
        $query = "SELECT ";
        $orderby = "";
        $limit = "";
        $groupby = "";
        
        if (isset($filter)) {
            $fields = $ci->db->list_fields($tablename);
            foreach ($fields as $field) {
                if (isset($filter[$field]) && array_key_exists($field, $filter)) {
                    $cond .= " and $field='" . $ci->db->escape_like_str($filter[$field]) . "' ";
                }
            }
            if ((array_key_exists("cols", $filter))) {
                if (is_array($filter['cols'])) {
                    $cols = rtrim(implode(",", $filter['cols']), ",");
                }
            }
            if (array_key_exists("orderasc", $filter) && is_array($filter['orderasc'])) {
                $orderby .= "ORDER BY " . rtrim(implode(",", $filter['orderasc']), ",") . " ASC ";
            }
            if (array_key_exists("orderdsc", $filter) && is_array($filter['orderdsc'])) {
                $orderby .= "ORDER BY " . rtrim(implode(",", $filter['orderdsc']), ",") . " DESC ";
            }
            if (array_key_exists("group_by", $filter) && is_array($filter['group_by'])) {
                $groupby .= "GROUP BY " . rtrim(implode(",", $filter['group_by']), ",");
            }
             if ((array_key_exists("cols", $filter))) {
                if (is_array($filter['cols']) && count($filter['cols'])) {
                    $cols = rtrim(implode(",", $filter['cols']), ",");
                }
            }
            if (array_key_exists("limit", $filter)) {
                $limit .= " LIMIT " . $filter['limit'];
            }
            $query = $query . $cols . " from $table $cond $groupby $orderby $limit";
            $res = $ci->db->query($query);
           
            if ($res && $res->num_rows() > 0) {
                return $data = $res->result();
            } else {
                return false;
            }
        }
    }

}
if (!function_exists("prd")) {

    function prd($arr) {
        echo "<pre><strong>PRD:</strong><br/>";
        print_r($arr);
        die;
    }

}
if (!function_exists("pr")) {

    function pr($arr) {
        echo "<pre><strong>PR:</strong><br/>";
        print_r($arr);
        echo "</pre>";
    }

}
if (!function_exists("prsessd")) {

    function prsessd() {
        $ci = & get_instance();
        echo "<pre><strong>PRINT-SESSION:</strong><br/>";
        print_r($ci->session->all_userdata());
        echo "</pre>";
        die;
    }

}
if (!function_exists("prsess")) {

    function prsess() {
        $ci = & get_instance();
        echo "<pre><strong>PRINT-SESSION:</strong><br/>";
        print_r($ci->session->all_userdata());
        echo "</pre>";
    }

}
if (!function_exists("rq")) {

    function rq($param = '', $escape_str = 1) {
        $ci = & get_instance();
        if ($escape_str == 0)
            $param = $ci->db->escape($param);
        else if ($escape_str == 1)
            $param = $ci->db->escape_str($param);
        else
            $param_ = $ci->db->escape_like_str($param);
//        array_walk_recursive($param, array($ci->db, 'escape_like_str'));
        if (trim($param) != '' && isset($param)) {

            return $ci->input->post($param, TRUE);
        } else {

            if ($post_data = $ci->input->post(NULL, TRUE)) {
                $post_data = array_map(array($ci->db, 'escape_like_str'), $post_data);
                return $post_data;
            } else {
                return false;
            }
//            return $ci->input->post(NULL, TRUE);
        }
        die;
    }

}
if (!function_exists("rqs")) {

    function rqs($param = '', $escape_str = 1) {
        $ci = & get_instance();
        if ($escape_str == 0)
            $param = $ci->db->escape($param);
        else if ($escape_str == 1)
            $param = $ci->db->escape_str($param);
        else
            $param_ = $ci->db->escape_like_str($param);

        if (trim($param) !== '' && isset($param)) {
            return decryptMyData($ci->input->post($param, true));
        }
    }

}
/*
 *  Message type: success/warning/error/info
 *  */
if (!function_exists("setFlashMessage")) {

    function setFlashMessage($msg, $type = 'success', $name = 'flash_message', $heading = "message") {
        $msgtypearr = array("success", "warning", "error", "info");
        $type = strtolower($type);
        $ci = & get_instance();
        $ci->load->library("session");

//        $flashmsg = "<div class='alert alert-" . $msgtypearr[$type] . " alert-dismissable'><strong>" .
//                ucfirst($type) . ": </strong><a href='#' class=\"close\" data-dismiss=\"alert\" "
//                . "aria-label=\"close\">&times;</a>" . ucfirst($msg) . "</div>";
        $flashmsg = "<script> fancyAlert('" . ucfirst($msg) . "','" . $type . "');</script>";
        $ci->session->set_flashdata($name, $flashmsg);
    }

}

    function send_email($to,$subject,$message) {
        $ci = &get_instance();
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mx1.hostinger.in',
            'smtp_port' => 587,
            'smtp_user' => 'sales@gadgetprogrammers.online', // change it to yours
            'smtp_pass' => 'sales@123', // change it to yours
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );

        
        $ci->load->library('email', $config);
        $ci->email->set_newline("\r\n");
        $ci->email->from('sales@gadgetprogrammers.online'); // change it to yours
        $ci->email->to($to); // change it to yours
        $ci->email->subject($subject);
        $ci->email->message($message);
        if ($ci->email->send()) {
            return true;
        } else {
            return false;
            show_error($ci->email->print_debugger());
        }
    }
?>