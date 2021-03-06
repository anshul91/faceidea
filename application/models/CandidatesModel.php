<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * CREATED BY: ANSHUL PAREEK
 * CREATED DATE:
 * MODIFIED DATE:  
 */

class CandidatesModel extends CI_Model {

    /**
     * Validate the login's data with the database
     * @param string $user_name
     * @param string $password
     * @return void
     */
    function __construct() {
        parent::__construct();
    }

    function get_candidate_list($filter = array()) {

        $columns = array(
// datatable column index  => database column name
            0 => 'candidate_id',
            1 => 'title',
            2 => 'title',
            3 => 'title',
            4=> 'title',
            5 => 'title',
            6 => 'title',
            7 => 'title',
            8 => 'title',
            9 => 'title',
        );
        $requestData = rq();
        $cols = " *";
//  getting total number records without any search
        $cond = ' Where 1=1 ';
        $fields = $this->db->list_fields('tbl_candidate');
        if (sizeof($filter) > 0 && is_array($filter)) {
            foreach ($fields as $field) {
                if (isset($filter[$field]) && array_key_exists($field, $filter)) {
                    $cond .= " and $field=" . $this->db->escape($filter[$field]);
                }
            }
        }
        $sql = "SELECT $cols ";
        $sql .= " from tbl_candidate " .
                " $cond ";

        $query = $this->db->query($sql);
//        echo $this->db->last_query();
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql .= " AND ( title LIKE '" . $requestData['search']['value'] . "%' )";            
        }

        $query = $this->db->query($sql);
        $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
//        $totalFiltered = $totalData;
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['length'] . " OFFSET " . $requestData['start'] . "   ";
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
        $resArr = $this->db->query($sql);
        $data = array();
        $cnt = $requestData['start'] ? $requestData['start'] + 1 : 1;
        foreach ($resArr->result_array()as $rk => $row) {  // preparing an array
            $nestedData = array();
            $nestedData[] = $cnt++;
            $nestedData[] = $row["f_name"].' '.$row['l_name'];
            $nestedData[] = $row["father_name"];
            $nestedData[] = $row["mobile_no"];
            $nestedData[] = $row["email_id"];
            $nestedData[] = $row["city"];
            $nestedData[] = $row["address"];
			
            $nestedData[] = '<td class="text-right"><div class="dropdown">'
                    . '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'
                    . '<i class="fa fa-ellipsis-v"></i></a><ul class="dropdown-menu pull-right">'
                    . '<li><a href="#" data-toggle="modal" data-target="#edit_candidate" title="Edit" id="edit_candidate_btn" onclick="render_edit_candidate('.trim($enc_candidate_id).')">'
                    . '<i class="fa fa-pencil m-r-5"></i> Edit</a></li>'
                    . '<li><a href="#" data-toggle="modal" data-target="#delete_candidate" title="Delete" onclick="delete_candidate('.$enc_candidate_id.')">'
                    . '<i class="fa fa-trash-o m-r-5"></i> Delete</a></li></ul></div>'
                    . '</td>';

            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );
        array_walk_recursive($json_data, array($this->security, 'xss_clean'));
        return $json_data;
    }

    function add_candidate($dataArr) {
        $firmArr = $this->security->xss_clean($dataArr);
        $sub_flag = true;
        $this->db->trans_start();
        $this->db->insert("tbl_candidate", $dataArr['candidate_detail']);
//        if (!$this->faceset->add_faceset($this->firm_id, rq('title'))) {
//            $sub_flag = false;
//        }
	// echo $this->db->last_query();die;
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
	function edit_candidate($dataArr,$dept_id) {
        $firmArr = $this->security->xss_clean($dataArr);
        $sub_flag = true;
        $this->db->trans_start();
		$this->db->where(array("candidate_id"=>$dept_id));
        $this->db->update("tbl_candidate", $dataArr['candidate_detail']);
//        if (!$this->faceset->add_faceset($this->firm_id, rq('title'))) {
//            $sub_flag = false;
//        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
	
	function check_duplicate_candidate($title,$candidate_id){
		$firm_id = $this->firm_id;		
		$candidate_id = rq('candidate_id');
		$query = "Select COUNT(*)as tot_desig from tbl_candidate where "
                . "title='$title' and "
                . "firm_id='$firm_id' and candidate_id!=$candidate_id";				
        if ($res = $this->db->query($query)) {			
            $data = $res->result();
            return ($data[0]->tot_desig > 0) ? true : false;
        }
	}

	function delete_candidate($candidate_id){
		$this->db->where(array("candidate_id"=>$candidate_id));
		if($this->db->delete('tbl_candidate')){
			
			return true;
		}
		else
			return false;
		
	}
}
