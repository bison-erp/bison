<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 4.0.1
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
    <title>
        <?php
if ($this->mdl_settings->setting('custom_title') != '') {
    echo $this->mdl_settings->setting('custom_title');
} else {
    echo ' Bison ERP';
}
?>
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/pages/css/login3.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css" id="style_components"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"
        id="style_color" />
    <link href="<?php echo base_url(); ?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/default/js/jquery-1.11.1.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout3/scripts/fontawesome-all.js"></script>
	<!-- fonts new file -->
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/layout3/css/fonts/fonts.css" type="text/css" media="all">
    <!-- END THEME STYLES -->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/admin/layout3/img/favicon.png">
    <script type="text/javascript">
    $(function() {
        $('#email').focus();
    });

    //            function f_disp() {
    //                $('.alert').attr('style', 'display:');
    //            }
    </script>
</head>
<?php
$this->load->helper('cookie');
//    session_destroy();
//    setcookie('ci_session', '', time() - 864000, '/');
//    setcookie('ci_session', '', time() - 864000, base_url() . '/');
//    echo '<pre>';
//    print_r($this->router);
//    echo '</pre>';
?>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="login">
    <!-- BEGIN LOGO -->
    <div class="logo" style="margin-bottom: -3px;">
        <!--a href="">
            <img style="margin-top: -18px;" src="<!--?php echo base_url(); ?>assets/admin/layout3/img/logo-login-bison.png"
                alt="" />
        </a-->
    </div>
    <!--<pre><?php //print_r($this->router);  ?></pre>-->
    <!-- END LOGO -->
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="menu-toggler sidebar-toggler">
    </div>
    <!-- END SIDEBAR TOGGLER BUTTON -->
    <!-- BEGIN LOGIN -->
    <div class="content">
		<!-- img-left -->
		<div class="img-content-session">
		</div>
	<!-- end img-left -->
        <!-- BEGIN LOGIN FORM -->


        <div id="login">

				<div class="logo-icon-sess">
					<img src="<?php echo base_url(); ?>assets/admin/layout3/img/logo-icon-login.png" alt=""/>
				</div>
				
				<div class="h6-title">
				<span class="big-font text-center"><center>Update in progress</center></span>
				</div>
            <!-- END LOGIN FORM -->


        </div>
    </div>
    <!-- END LOGIN -->
    <!-- BEGIN COPYRIGHT -->
    <div class="copyright">
			&copy; Copyright <?php echo date("Y"); ?> - Bison
        <a href="#">
            <div class="scroll-to-top" style="display: none;">
                <i class="icon-arrow-up"></i>
            </div>
        </a> </div>
    <!-- END COPYRIGHT -->

    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript">
    </script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript">
    </script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
        type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/pages/scripts/login.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Login.init();
        Demo.init();
    });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>