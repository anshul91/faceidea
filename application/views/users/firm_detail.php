 
        <script type="text/javascript" src="<?php echo JS_URL; ?>adminUsers/adminUsers.js"></script>
 <?php 
	if(isset($firm_data_arr)){
		$user_detail_arr = $firm_data_arr['user_detail'];	
		$subscription_arr = $firm_data_arr['subscription_detail'];
		$firm_detail = $firm_data_arr['firm_detail'];
		
		$username = isset($user_detail_arr->username)?$user_detail_arr->username:null;
		$usertype = isset($user_detail_arr->usertype)&& $user_detail_arr->usertype == 'f'?"Firm":"Candidate";
		
		/*Firm Details*/
		$country = isset($firm_detail->country)?$firm_detail->country:null;
		$city = !empty($firm_detail->city)?$firm_detail->city:null;
		$address = !empty($firm_detail->address)?$firm_detail->address:null;
		
		$domain = !empty($firm_detail->domain)?$firm_detail->domain:null;
		$firm_name = !empty($firm_detail->firm_name)?$firm_detail->firm_name:APP_NAME;
		$email_id = !empty($firm_detail->email_id)?$firm_detail->email_id:null;
		$f_name = !empty($firm_detail->f_name)?$firm_detail->f_name:null;
		$l_name = !empty($firm_detail->l_name)?$firm_detail->l_name:null;
		
		$logo = !empty($firm_detail->logo)?$firm_detail->logo:"user.jpg";
		
		$mobile_no = isset($firm_detail->mobile_no)?$firm_detail->mobile_no:null;
		$firm_created = isset($firm_detail->created)?$firm_detail->created:null;
		$firm_modified = isset($firm_detail->modified)?$firm_detail->modified:null;
		
		/*Subscription details*/
		$subscription_pack_detail = getTableData("tbl_subscription_pack",array("pack_id"=>$subscription_arr->pack_id));
		$subscription_start_from = isset($subscription_detail->subscription_start_from)?$subscription_detail->subscription_start_from:null;
		$subscription_end_date = isset($subscription_detail->subscription_end_date)?$subscription_detail->subscription_end_date:null;
		$max_candidate_limit = isset($subscription_detail->max_candidate_limit)?$subscription_detail->max_candidate_limit:null;
		$subscription_created = isset($subscription_detail->created)?$subscription_detail->created:null;
		$subscription_modified = isset($subscription_detail->modified)?$subscription_detail->modified:null;
	}
	
	
?>
<?php echo form_open('', array('name' => "frm_firm_detail", "method" => 'post', 'id' => 'frm_firm_detail',"enctype"=>"multipart/formdata")); ?>
 <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-8" id='response_div'>
							
						</div>
						<div class="col-sm-8">
							<h4 class="page-title">Edit Profile</h4>
						</div>
					</div>
					<form>
						<div class="card-box">
							<h3 class="card-title">Basic Informations</h3>
							<div class="row">
								<div class="col-md-12">
									<div class="profile-img-wrap">
										<img class="inline-block logo_div" src="<?php echo IMAGE_URL;?><?php echo $logo;?>" alt="Firm Logo" id='firm_logo_div' class=''>
										<div class="fileupload btn btn-default">
											<span class="btn-text">Edit Logo</span>
											<input class="upload" type="file" name='logo' id='logo'>
										</div>
									</div>
									<div class="profile-basic">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group form-focus">
													<label class="control-label">Firm Name</label>
													<input disabled='true' type="text" name='firm_name' class="form-control floating" value="<?php if(!is_null($firm_name))echo $firm_name;?>" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-focus">
													<label class="control-label">Sub-Domain Name</label>
													<input disabled='true' type="text" name='domain' id='domain' class="form-control floating" value="<?php if(!is_null($domain))echo $domain;?>" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-focus">
													<label class="control-label">Username</label>
													<div class="cal-icon">
													<input disabled='true' name='username' id='username' class="form-control floating" 
													value="<?php if(!is_null($username)) echo $username;?>" type="text"></div>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-box">
							<h3 class="card-title">Contact Informations</h3>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-focus">
										<label class="control-label">Address</label>
										<input type="text" name='address' class="form-control floating" 
										value="<?php if(!is_null($address))echo $address;?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">City</label>
										<input type="text" name='city' class="form-control floating" value="<?php if(!is_null($city))echo $city;?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Country</label>
										<input type="text" name='country' class="form-control floating" value="<?php if(!is_null($country))echo $country;?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Email-id</label>
										<input type="text" disabled='true' name='email_id' class="form-control floating" value="<?php if(!is_null($email_id))echo $email_id;?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Mobile Number</label>
										<input type="text" name='mobile_no' class="form-control floating" value="<?php if(!is_null($mobile_no))echo $mobile_no;?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Contact Person first name</label>
										<input type="text" name='f_name' class="form-control floating" value="<?php if(!is_null($f_name))echo $f_name;?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Contact Person Last name</label>
										<input type="text" name='l_name' class="form-control floating" value="<?php if(!is_null($l_name))echo $l_name;?>" />
									</div>
								</div>
							</div>
						</div>
						<div class="card-box">
							<h3 class="card-title">Subscription Informations</h3>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-focus">
										<label class="control-label">Choose Plan</label>
										<select name="subscription" id="subscription" class="form-control floating">                                    
											<?php foreach ($subscription_pack as $subscription => $subscriptions) { ?>
												<option value="<?php echo encryptMyData($subscriptions->pack_id); ?>" <?php if($subscriptions->pack_id == $subscription_arr->pack_id) echo "selected";?>><?php echo $subscriptions->pack_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
							</div>
							
						</div>
						
						<div class="text-center m-t-20">
							<button class="btn btn-primary btn-lg" type="button" onclick="update_firm_detail()">Save &amp; update</button>
						</div>
					</form>
				</div>
					
				</div>
			</div>
			<?php echo form_close();?>