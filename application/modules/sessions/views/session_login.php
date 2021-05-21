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
        <meta charset="utf-8">
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
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/pages/css/login3.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/default/js/jquery-1.11.1.js"></script>
	<!-- fonts new file -->
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/layout3/css/fonts/fonts.css" type="text/css" media="all">
        <!-- END THEME STYLES -->
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/admin/layout3/img/favicon.png">
        <!-- Bootstrap core CSS -->
        <!--link href="<?php echo base_url(); ?>assets/global/plugins/flag/css/flag-icon.min.css" rel="stylesheet"-->
		
        <script type="text/javascript">
            $(function () {
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
        <div class="logo">
            <!--a href="">
                <img  style="margin-top: -18px;"src="<!--?php echo base_url(); ?>assets/admin/layout3/img/logo-login-bison.png" alt=""/>
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
<div class="h6-title"><span class="big-font"><?php echo lang('welcome'); ?></span><span class="normal-font"><?php echo lang('logginn'); ?></span></div>
 <form class="login-form" id="login-form" action="<?php echo site_url($this->uri->uri_string()); ?>" method="post">
<!--div  style="font-weight: 900;text-align: center;font-size: 16px;"class="form-title"></div-->                     
<div class="row"><?php     //$this->layout->load_view('layout/alerts'); 
$this->session->flashdata('alert_error');?>
</div>
<!--££££-->
<?php
if($this->session->flashdata('flashSuccess')):?>
<p class='flashMsg flashSuccess '> <?php echo $this->session->flashdata('flashSuccess')?> </p>

<?php endif?>
 
<?php if($this->session->flashdata('flashError')):?>
<div  class=" alert alert-danger " style='color: #E14545;'><button class="close" data-close="alert"></button>
    <p class='flashMsg flashError' style='color: #E14545;'> <?php echo $this->session->flashdata('flashError')?> </p>
    </div>
<?php endif?>
 
<?php if($this->session->flashdata('flashInfo')):?>
<p class='flashMsg flashInfo'> <?php echo $this->session->flashdata('flashInfo')?> </p>
<?php endif?>
 
<?php if($this->session->flashdata('flashWarning')):?>
<p class='flashMsg flashWarning'> <?php echo $this->session->flashdata('flashWarning')?> </p>
<?php endif?>
<!--£££££-->

                <div class="alert alert-danger display-hide ">
                    <button class="close" data-close="alert"></button>
                    <span>
<?php echo lang('enter'); ?> </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label label-connexion"><?php echo lang('email_address'); ?></label>
                    <div class="input-icon">
                        <!--i class="fa fa-user"></i-->
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off"
                               placeholder="<?php echo lang('email'); ?>" name="email" id="email" onKeyPress="if (event.keyCode == 13) {
                                   $( '#login-form .btn_login' ).trigger( 'click' );}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label label-connexion"><?php echo lang('password'); ?></label>
                    <div class="input-icon"">
                        <!--i class="fa fa-lock"></i-->
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" 
                               name="password" id="password" class="form-control"
                               placeholder="<?php echo lang('password'); ?>" 
                               onKeyPress="if (event.keyCode == 13) {
                                   $( '#login-form .btn_login' ).trigger( 'click' );}"
                                   />
                    </div>
                </div>
				<!-- code HTML -->
				<div class="form-group flag-lang">
					<label class="control-label label-connexion"><?php echo lang('language'); ?></label>
					<ul class="prod-gram">
						<li onclick="selectlanguage('French')" class="init"><img src='<?php echo base_url(); ?>assets/admin/layout3/img/flag-france.png' /><span class="txt-flag"><?php echo lang('french'); ?></span></li>
						<li onclick="selectlanguage('French')"><img src='<?php echo base_url(); ?>assets/admin/layout3/img/flag-france.png' /><span class="txt-flag"><?php echo lang('french'); ?></span></li>
						<li onclick="selectlanguage('English')"><img src='<?php echo base_url(); ?>assets/admin/layout3/img/flag-usa.png'/><span class="txt-flag"><?php echo lang('english'); ?></span></li>
					</ul>
				</div>
<!-- end -->
                <div class="text-left">
					<small><a href="<?php echo base_url(); ?>sessions/passwordreset" class="text-blue">
							<?php echo lang('forgot_your_password'); ?>
						</a></small><br>
					<small><a href="<?php echo base_url(); ?>sessions/logout" class="text-blue">
							<?php echo 'Connecter avec un autre licence'; ?>
						</a></small>
				</div>
                <input type='hidden' id='languageselected'  name='languageselected' value="French" >
                <div class="form-actions" style="border-width: 0px 0px 0px;">
                    <!--			<label class="checkbox">
                                            <input type="checkbox" name="remember" value="1"/> Remember me </label><!--?php //echo lang('login'); ?>-->
                    <input type="submit" name="btn_login" class="btn btn-block btn-primary btn_login"
                           value="<?php echo lang('connect_submit'); ?>" ><!--i style="margin-top: -8%; margin-left: 90%;" class="m-icon-swapright m-icon-white"></i--> 
                </div>

            </form>
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
			</a>        
		</div>
        <!-- END COPYRIGHT -->

        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/pages/scripts/login.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                Login.init();
                Demo.init();
            });
        </script>
		
			<script>
            function selectlanguage(v){ 
                $('#languageselected').val(v);
            }
			$(document).ready(function() {
			  $(document).on("click", "ul.prod-gram .init", function() {
				$(this).parent().find('li:not(.init)').toggle();
			  });
			  var allOptions = $("ul.prod-gram").children('li:not(.init)');
			  $("ul.prod-gram").on("click", "li:not(.init)", function() {
				allOptions.removeClass('selected');
				$(this).addClass('selected');
				$(this).parent().children('.init').html($(this).html());
				$(this).parent().find('li:not(.init)').toggle();
			  });
			});
			</script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>