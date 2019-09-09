<?php
$firm_name = isset($firm_name) ? $firm_name : APP_NAME;
if (is_array($firm_detail) && isset($firm_detail[0])) {
    $firm_detail = $firm_detail[0];
}
?>
<!DOCTYPE html>
<html>

    <!-- Mirrored from dreamguys.co.in/smarthr/blue/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Aug 2018 12:36:13 GMT -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo IMAGE_URL; ?>favicon.ico">
        <title><?php echo "Gadgetprogrammers | " . APP_NAME; ?></title>

        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL; ?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL; ?>font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_COMMON_URL; ?>style.css">
        <!--[if lt IE 9]>
                <script src="assets/js/html5shiv.min.js"></script>
                <script src="assets/js/respond.min.js"></script>
        <![endif]-->

        <script type="text/javascript" src="<?php echo JS_URL; ?>common.js"></script>
        <script type="text/javascript" src="<?php echo JS_URL; ?>adminUsers/adminUsers.js"></script>
        <noscript>
    <div>
        <H1>Please enable "JAVASCRIPT" in order to use this portal. this is user is this asdf asdf</h1>
    </div>
    </noscript>
</head>
<body>
    <div class="main-wrapper">
        <div class="account-page">
            <div class="container">
                <h3 class="account-title"><?php echo isset($firm_detail->firm_name) ? $firm_detail->firm_name : APP_NAME; ?> Login</h3>
                
                <div class="account-box">
                    <div id="validation_msg">
                    <!--validation messages-->
                </div>
                    <div class="account-wrapper">
                        <div class="account-logo">
                            <a href="#"><img src="<?php echo IMAGE_URL; ?><?php echo isset($firm_detail->logo) ? $firm_detail->logo : "logo.png"; ?>" alt="<?php APP_NAME;?>"></a>
                        </div>
                        <?php echo form_open('', array('name' => "frm_login", "method" => 'post', 'id' => 'frm_login')); ?>
                        <div class="form-group form-focus">
                            <label class="control-label"><?php echo $this->lang->line('lbl_uname'); ?></label>
                            <input class="form-control floating" type="text" autocomplete="off" id="username" name="username">
                        </div>
                        <div class="form-group form-focus">
                            <label class="control-label"><?php echo $this->lang->line('lbl_pass'); ?></label>
                            <input class="form-control floating" type="password" autocomplete="off" id='password' name="password">
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-block account-btn" type="button" onclick="validate_user_ajx()"><?php echo $this->lang->line('btn_login'); ?></button>
                        </div>
                        <div class="text-center">
                            <a href="<?php echo site_url() . 'forgot-password'; ?>"><?php echo $this->lang->line('lbl_forget_pass'); ?></a>
                        </div>
                        <br/>
                        <div class="text-center">
                            <a href="<?php echo site_url() . 'register-view'; ?>"><?php echo $this->lang->line('lbl_register'); ?></a>
                        </div>
                        <input type="hidden" value="web_app" name="is_web" id="is_web">
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-overlay" data-reff="#sidebar"></div>
    <script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?PHP echo JS_COMMON_URL; ?>bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>app.js"></script>

</body>
</html>