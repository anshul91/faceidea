<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL ?>favicon.png">
        <title>Register - Attendance Portal</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL ?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL ?>font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL ?>style.css">
        <!--[if lt IE 9]>
                <script src="assets/js/html5shiv.min.js"></script>
                <script src="assets/js/respond.min.js"></script>
        <![endif]-->


        <script type="text/javascript" src="<?php echo JS_URL; ?>common.js"></script>
        <script type="text/javascript" src="<?php echo JS_URL; ?>adminUsers/adminUsers.js"></script>
    </head>
    <div class="loader"><img src="<?php echo IMAGE_URL; ?>loading.gif" width="100px"></div>
    <body>
        <div class="main-wrapper">
            <div class="account-page">
                <div class="container">
                    <h5 class="account-title"> Register For Face Read App</h5>
                    <div class="account-box">
                        <div id="validation_msg">
                            <!--validation messages-->
                        </div>
                        <div class="account-wrapper">
                            <div class="account-logo">
                                <a href="<?php echo site_url()."register-view"?>"><img src="<?php echo IMAGE_URL ?>logo.png" alt="<?php echo APP_NAME;?>"></a>
                            </div>
                            <?php echo form_open('', array('id' => 'frm_register', 'method' => 'post', 'name' => 'register')); ?>
                            <!--                            <div class="form-group form-focus">
                                                            <label class="control-label">First Name</label>
                                                            <input class="form-control floating" type="text" id="f_name" name='f_name'>
                                                        </div>
                            
                                                        <div class="form-group form-focus">
                                                            <label class="control-label">Last Name</label>
                                                            <input class="form-control floating" type="text" id="l_name" name='l_name'>
                                                        </div>
                            -->
                            <div class="form-group form-focus">
                                <label class="control-label">Firm Name For Registration</label>
                                <input class="form-control floating" type="text" id="firm_name" name='firm_name'>
                            </div>
                            <div class="form-group form-focus">
                                <label class="control-label">Your Domain</label>
                                <input class="form-control floating" type="text" id="domain" name='domain'>
                                <p style="color:white;padding-top: 18px; margin-right: 5px;padding-right: 10px;padding-left: 10px;background-color: darkgray;padding-bottom: 10px;height: 50px;font-size:11px;"><b>.gadgetprogrammers.online</b></p>
                            </div>
                            <div class="form-group form-focus">
                                <label class="control-label">Email</label>
                                <input class="form-control floating" type="text" id="email_id" name="email_id">
                            </div>
                            <div class="form-group form-focus">
                                <label class="control-label">Mobile No.</label>
                                <input class="form-control floating" type="text" id="mobile_no" name="mobile_no">
                            </div>
                            <div class="form-group form-focus">
                                <label class="control-label">Username</label>
                                <input class="form-control floating" type="text" id="username" name="username">
                            </div>
                            <div class="form-group form-focus">
                                <label class="control-label">Password</label>
                                <input class="form-control floating" type="password" id="password" name="password">
                            </div>                            
                            <div class="form-group form-focus">
                                <label class="control-label">Confirm Password</label>
                                <input class="form-control floating" type="password" id="re-password" name="re-password">
                            </div>
                            <div class="form-group form-focus">
                                <label class="control-label">Choose Plan</label>
                                <select name="subscription" id="subscription" class="form-control floating">
                                    
                                    <?php foreach ($subscription_pack as $subscription => $subscriptions) { ?>
                                        <option value="<?php echo encryptMyData($subscriptions->pack_id); ?>"><?php echo $subscriptions->pack_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary btn-block account-btn" type="button" onclick="register_firm_ajx()">Register</button>
                            </div>
                            <div class="text-center">
                                <a href="<?php echo site_url(); ?>login">Login ?</a>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-overlay" data-reff="#sidebar"></div>
        <script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>app.js"></script>
        <script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>jquery.validationEngine"></script>
    </body>
</html>