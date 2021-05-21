<?php

if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != "" && $_POST['password'] != "") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isUserByUsernameAndPassword($username, $password)) {
        $user = getUserInfoByUsernameAndPassword($username, $password);
        connectUser($user['id']);
        redirect('index.php');
    } else { $erreur_login = "Invalid username ou password !";}
}

?>
<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Login Superadmin</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css" />
    <link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"
        type="text/css" />
    <link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="../../assets/admin/pages/css/login.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="../../assets/global/css/components-rounded.css" id="style_components" rel="stylesheet"
        type="text/css" />
    <link href="../../assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="../../assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="login">
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="menu-toggler sidebar-toggler">
    </div>
    <!-- END SIDEBAR TOGGLER BUTTON -->
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="index.html">
            <img src="../../assets/admin/layout3/img/logo_erp_index.png" alt="" />
        </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" action="" method="post">
            <h3 class="form-title">Se connecter</h3>
            <?php
if (isset($erreur_login) && $erreur_login != "") {?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span>
                    Username ou mot de passe incorrectes. </span>
            </div>
            <?php }?>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
                    placeholder="Username" name="username" />
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                    placeholder="Password" name="password" />
            </div>
            <div class="form-actions" style="text-align:right">
                <button type="submit" class="btn btn-success uppercase">Login</button>
            </div>


        </form>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
        <form class="forget-form" action="index.html" method="post">
            <h3>Forget Password ?</h3>
            <p>
                Enter your e-mail address below to reset your password.
            </p>
            <div class="form-group">
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
                    name="email" />
            </div>
            <div class="form-actions">
                <button type="button" id="back-btn" class="btn btn-default">Back</button>
                <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->

    </div>
    <div class="copyright">
        &copy; Copyright 2015 - Bison ERP.
    </div>
    <!-- END LOGIN -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
    <script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="../../assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="../../assets/admin/layout/scripts/layout.js" type="text/javascript"></script>

    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout

    });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>