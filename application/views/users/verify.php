
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
        <H1>Please enable "JAVASCRIPT" in order to use this portal.</h1>
    </div>
    </noscript>
</head>
<body>
    <div class="main-wrapper">
        <div class="account-page">
            
                <div class="account-logo">
                    <a href="#"><img src="<?php echo IMAGE_URL ?>logo.png" alt="<?php echo APP_NAME;?>"></a>
                </div>
            <div class="container">
                <h3 class="account-title"><?php echo APP_NAME . " Verification" ?></h3>
            </div>

            <?php // echo $url;?>
                <div class="account-box">
                    <input type="hidden" id="csrf_token_name" name="csrf_token_name" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div id="response_div"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-overlay" data-reff="#sidebar"></div>
    <script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?PHP echo JS_COMMON_URL; ?>bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_COMMON_URL; ?>app.js"></script>
    <script>
        $(document).ready(function () {
            verify_link_ajx();
        });
    </script>
</body>
</html>