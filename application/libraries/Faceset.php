<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FaceSet {
    /* API URL FOR FACEPLUS PLUS */

    private $add_faceset = "https://api-us.faceplusplus.com/facepp/v3/faceset/create";
    private $update_faceset = "https://api-us.faceplusplus.com/facepp/v3/faceset/update";
    private $delete_faceset = "https://api-us.faceplusplus.com/facepp/v3/faceset/delete";

    public function __construct() {
        
    }

    /* param is a type of array and can contain:
      @display_name: string (req)
      @outer_id: string (req) (unique_id)
      @tags: string (optional)
      @face_tokens: string (optional)
      @user_data: string (optional)
     */

    public function add_faceSet($display_name, $outer_id, $tags = '', $face_tokens = '', $user_data = '') {

        if ($display_name == '' || $outer_id == '') {
            return false;
        }
        $param = array(
            "api_key" => FACEPLUS_API_KEY,
            "api_secret" => FACEPLUS_SECRET,
            "display_name" => $display_name,
            "outer_id" => $outer_id,
            "tags" => $tags,
            "face_token" => $face_tokens,
            "user_data" => $user_data
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, $this->add_faceset);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($curl);
        $info = curl_getinfo($curl);

        curl_close($curl);
        return json_decode($result);
        die;
    }

    public function update_faceSet($new_display_name,$old_outer_id, $new_outer_id='', $user_data = '', $tags = '') {
		
        if ($new_display_name == '' || $old_outer_id == '') {
            return false;
        }
        $param = array(
            "api_key" => FACEPLUS_API_KEY,
            "api_secret" => FACEPLUS_SECRET,
            "outer_id" => $old_outer_id,
            "display_name" => $new_display_name,
            "user_data" => $user_data,
            "tags" => $tags,
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, $this->update_faceset);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($curl);
        $info = curl_getinfo($curl);

        curl_close($curl);
        return json_decode($result);
        die;
    }
	
	public function delete_faceSet($outer_id) {

        if ($outer_id == '') {
            return false;
        }
        $param = array(
            "api_key" => FACEPLUS_API_KEY,
            "api_secret" => FACEPLUS_SECRET,
            "outer_id" => $outer_id,
           
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, $this->delete_faceset);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($curl);
        $info = curl_getinfo($curl);

        curl_close($curl);
        return json_decode($result);
        die;
    }

}
