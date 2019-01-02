<?php 
	if(isset($firm_data_arr)){
		$user_detail_arr = $firm_data_arr['user_detail'];	
		$subscription_arr = $firm_data_arr['subscription_detail'];
		$firm_detail = $firm_data_arr['firm_detail'];
		
		$username = isset($user_detail_arr->username)?$user_detail_arr->username:"NA";
		$usertype = isset($user_detail_arr->usertype)&& $user_detail_arr->usertype == 'f'?"Firm":"Candidate";
		
		/*Firm Details*/
		$country = isset($firm_detail->country)?$firm_detail->country:"NA";
		$city = !empty($firm_detail->city)?$firm_detail->city:"NA";
		$address = !empty($firm_detail->address)?$firm_detail->address:"NA";
		$domain = !empty($firm_detail->domain)?$firm_detail->domain:"NA";
		$firm_name = !empty($firm_detail->firm_name)?$firm_detail->firm_name:APP_NAME;
		$email_id = !empty($firm_detail->email_id)?$firm_detail->email_id:"NA";
		
		$logo = !empty($firm_detail->logo)?$firm_detail->logo:"user.jpg";
		
		$mobile_no = isset($firm_detail->mobile_no)?$firm_detail->mobile_no:"NA";
		$firm_created = isset($firm_detail->created)?$firm_detail->created:"NA";
		$firm_modified = isset($firm_detail->modified)?$firm_detail->modified:"NA";
		
		/*Subscription details*/
		$subscription_pack_detail = getTableData("tbl_subscription_pack",array("pack_id"=>$subscription_arr->pack_id));
		$subscription_start_from = isset($subscription_detail->subscription_start_from)?$subscription_detail->subscription_start_from:"NA";
		$subscription_end_date = isset($subscription_detail->subscription_end_date)?$subscription_detail->subscription_end_date:"NA";
		$max_candidate_limit = isset($subscription_detail->max_candidate_limit)?$subscription_detail->max_candidate_limit:"NA";
		$subscription_created = isset($subscription_detail->created)?$subscription_detail->created:"NA";
		$subscription_modified = isset($subscription_detail->modified)?$subscription_detail->modified:"NA";
	}
	
	
?>
<div class="page-wrapper">
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-8">
							<h4 class="page-title">My Profile</h4>
						</div>
						
						<div class="col-sm-4 text-right m-b-30">
							<a href="<?php echo site_url();?>edit-firm-detail" class="btn btn-primary rounded"><i class="fa fa-plus"></i> Edit Profile</a>
						</div>
					</div>
					<div class="card-box">
						<div class="row">
							<div class="col-md-12">
								<div class="profile-view">
									<div class="profile-img-wrap">
										<div class="profile-img">
											<a href="#"><img class="avatar" src="<?php echo IMAGE_URL;?><?php echo $logo;?>" alt=""></a>
										</div>
									</div>
									<div class="profile-basic">
										<div class="row">
											<div class="col-md-5">
												<div class="profile-info-left">
													<h3 class="user-name m-t-0 m-b-0"><?php echo ucfirst($username); ?></h3>
													<small class="text-muted"><?php echo ucfirst($firm_name);?></small>
													<div class="staff-id"></div>
													
													<div class="staff-msg"><span class="label label-danger-border">Firm Details</span></div>
													<div class="staff-msg">&nbsp;</div>
													<p >&nbsp;</p>
												</div>
											</div>
											<div class="col-md-7">
												<ul class="personal-info">
													<li>
														<span class="title">Mobile:</span>
														<span class="text"><a href="#"><?php echo $mobile_no;?></a></span>
													</li>
													<li>
														<span class="title">Email:</span>
														<span class="text"><a href="#"><?php echo $email_id;?></a></span>
													</li>
													<li>
														<span class="title">Firm Registration Date:</span>
														<span class="text"><?php echo $firm_created;?></span>
													</li>
													<li>
														<span class="title">Address:</span>
														<span class="text"><?php echo ucfirst($address);?></span>
													</li>
													<li>
														<span class="title">City:</span>
														<span class="text"><?php echo $city;?></span>
													</li>
													<li>
														<span class="title">Country:</span>
														<span class="text"><?php echo $country;?></span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="row">
						<div class="col-md-3">
							<div class="card-box m-b-0">
								<h3 class="card-title">Skills</h3>
								<div class="skills">
									<span>IOS</span>
									<span>Android</span> 
									<span>Html</span>
									<span>CSS</span>
									<span>Codignitor</span>
									<span>Php</span>
									<span>Javascript</span>
									<span>Wordpress</span>
									<span>Jquery</span>
								</div>
							</div>
						</div>-->
						
						<div class="col-md-12">
							<div class="card-box">
								<h3 class="card-title">Subscription Information</h3>
								<div class="experience-box">
									<ul class="experience-list">
									<?php foreach($subscription_pack_detail as $k=>$v){?>
										<li>
											<div class="experience-user">
												<div class="before-circle"></div>
											</div>
											<div class="experience-content">
												<div class="timeline-content">
													<a href="#/" class="name"><?php echo $v->pack_name;?></a>
													<div><?php echo $v->desc;?></div>
													<span class="time">User Limit: <?php echo $v->max_candidate;?></span>
													<span class="time"> <?php echo $subscription_start_from;?>-<?php echo $subscription_end_date;?></span>
													
												</div>
											</div>
										</li>
									<?php }?>
										
									</ul>
								</div>
							</div>
							
						</div>
					</div>
                </div>
				<div class="notification-box">
					<div class="msg-sidebar notifications msg-noti">
						<div class="topnav-dropdown-header">
							<span>Messages</span>
						</div>
						<div class="drop-scroll msg-list-scroll">
							<ul class="list-box">
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">R</span>
											</div>
											<div class="list-body">
												<span class="message-author">Richard Miles </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item new-message">
											<div class="list-left">
												<span class="avatar">J</span>
											</div>
											<div class="list-body">
												<span class="message-author">John Doe</span>
												<span class="message-time">1 Aug</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">T</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Tarah Shropshire </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">M</span>
											</div>
											<div class="list-body">
												<span class="message-author">Mike Litorus</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">C</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Catherine Manseau </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">D</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Domenic Houston </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">B</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Buster Wigton </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">R</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Rolland Webber </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">C</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Claire Mapes </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">M</span>
											</div>
											<div class="list-body">
												<span class="message-author">Melita Faucher</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">J</span>
											</div>
											<div class="list-body">
												<span class="message-author">Jeffery Lalor</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">L</span>
											</div>
											<div class="list-body">
												<span class="message-author">Loren Gatlin</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">T</span>
											</div>
											<div class="list-body">
												<span class="message-author">Tarah Shropshire</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						