<!DOCTYPE html>
<html>
<?php $logo = $this->session->userdata("firm_session")['firm_detail']->logo;

?>
    <!-- Mirrored from dreamguys.co.in/smarthr/blue/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Aug 2018 12:35:54 GMT -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL; ?>favicon.png">
        <title>Gadget Programmers | Attendance App</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL; ?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL; ?>font-awesome.min.css">
        <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="same">-->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL; ?>plugins/morris/morris.css">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL; ?>style.css">
        <script defer src="https://use.fontawesome.com/releases/v5.4.1/js/all.js" integrity="sha384-L469/ELG4Bg9sDQbl0hvjMq8pOcqFgkSpwhwnslzvVVGpDjYJ6wJJyYjvG3u8XW7" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL;?>dataTables.bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL; ?>select2.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL; ?>bootstrap-datetimepicker.min.css">
		

		<!--[if lt IE 9]>
                <script src="assets/js/html5shiv.min.js"></script>
                <script src="assets/js/respond.min.js"></script>
        <![endif]-->
		<script type="text/javascript" src="<?php echo JS_URL; ?>common.js"></script>
    </head>
    <body>
        <div class="main-wrapper">
            <div class="header" id="header">
                <div class="header-left">
                    <a href="<?php echo site_url() . "dashboard"; ?>" class="logo">
                        <img src="<?php echo !empty($logo)?IMAGE_URL.$logo:IMAGE_URL."logo.png";?>" class='logo_div' width="40" height="40" alt="">
                    </a>
                </div>
                <div class="page-title-box pull-left">
                    <h3><?php echo isset($firm_name) ? $firm_name : APP_NAME; ?></h3>
                </div>
                <a id="mobile_btn" class="mobile_btn pull-left" href="#sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
                <ul class="nav navbar-nav navbar-right user-menu pull-right">
                    <!--<li class="dropdown hidden-xs">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge bg-purple pull-right">3</span></a>
                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span>Notifications</span>
                            </div>
                            <div class="drop-scroll">
                                <ul class="media-list">
                                    <li class="media notification-message">
                                        <a href="activities.html">
                                            <div class="media-left">
                                                <span class="avatar">
                                                    <img alt="John Doe" src="assets/img/user.jpg" class="img-responsive img-circle">
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <p class="m-0 noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
                                                <p class="m-0"><span class="notification-time">4 mins ago</span></p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="media notification-message">
                                        <a href="activities.html">
                                            <div class="media-left">
                                                <span class="avatar">V</span>
                                            </div>
                                            <div class="media-body">
                                                <p class="m-0 noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
                                                <p class="m-0"><span class="notification-time">6 mins ago</span></p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="media notification-message">
                                        <a href="activities.html">
                                            <div class="media-left">
                                                <span class="avatar">L</span>
                                            </div>
                                            <div class="media-body">
                                                <p class="m-0 noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
                                                <p class="m-0"><span class="notification-time">8 mins ago</span></p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="media notification-message">
                                        <a href="activities.html">
                                            <div class="media-left">
                                                <span class="avatar">G</span>
                                            </div>
                                            <div class="media-body">
                                                <p class="m-0 noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
                                                <p class="m-0"><span class="notification-time">12 mins ago</span></p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="media notification-message">
                                        <a href="activities.html">
                                            <div class="media-left">
                                                <span class="avatar">V</span>
                                            </div>
                                            <div class="media-body">
                                                <p class="m-0 noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
                                                <p class="m-0"><span class="notification-time">2 days ago</span></p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="activities.html">View all Notifications</a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown hidden-xs">
                        <a href="javascript:;" id="open_msg_box" class="hasnotifications"><i class="fa fa-comment-o"></i> <span class="badge bg-purple pull-right">8</span></a>
                    </li>	-->
                    <li class="dropdown">
                        <a href="profile.html" class="dropdown-toggle user-link" data-toggle="dropdown" title="Admin">
                            <span class="user-img"><img class="img-circle" src="assets/img/user.jpg" width="40" alt="Admin">
                                <span class="status online"></span></span>
                            <span>Admin</span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url()."view-firm-detail";?>">My Firm Profile</a></li>
                            <li><a href="<?php echo site_url()."edit-firm-detail";?>">Edit Firm Profile</a></li>
                            <li><a href="<?php echo site_url() . "logout"; ?>">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="dropdown mobile-user-menu pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="profile.html">My Profile</a></li>
                        <li><a href="edit-profile.html">Edit Profile</a></li>
                        <li><a href="settings.html">Settings</a></li>
                        <li><a href="<?php echo site_url() . "logout"; ?>">Logout</a></li>
                    </ul>
                </div>
            </div>
