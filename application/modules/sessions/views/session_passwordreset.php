<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
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
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
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
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout3/scripts/fontawesome-all.js"></script>
	<!-- fonts new file -->
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/layout3/css/fonts/fonts.css" type="text/css" media="all">
        <!-- END THEME STYLES -->
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/admin/layout3/img/favicon.png">
    <body class="login">
        <div class="logo" style="margin-bottom: -3px;">
            <!--a href="">
                <img  style="margin-top: -18px;"src="<!--?php echo base_url(); ?>assets/admin/layout3/img/logo-login-bison.png" alt=""/>
            </a-->
        </div>
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
		            <!-- BEGIN LOGIN FORM -->
		<div id="login">
				<div class="logo-icon-sess">
					<img src="<?php echo base_url(); ?>assets/admin/layout3/img/logo-icon-login.png" alt=""/>
				</div>
            <div id="password_reset" >

                <div class="row"><?php $this->layout->load_view('layout/alerts'); ?></div>
				<div class="h6-title">
				<span class="big-font"><?php echo lang('password_reset'); ?></span><br />
				<span class="small-font" style="line-height: 20px;"><?php echo lang('password_reset_info'); ?></span>
				</div>
                <form class="form-horizontal" method="post"
                      action="<?php echo site_url($this->uri->uri_string()); ?>">

                    <div class="form-group">
                            <label for="email" class="control-label label-connexion" style="display: block; text-align: left;"><?php echo lang('email_address'); ?></label>
						<div class="input-icon">
                            <input type="text" name="email" id="email" class="form-control"
                                   placeholder="<?php echo lang('email'); ?>">
						</div>
                    </div>
                    <div class="form-actions">
                          <input type="submit" name="btn_reset" class="btn btn-block blue btn_login"
                                           value="<?php echo lang('reset_password'); ?>">  
                          <button type="button" id="back-btn" class="btn" onclick="history.go(-1)" style="margin: 15px 0 0;" >
                                       <i class="fas fa-arrow-alt-circle-left"></i> Retour </button>
                    </div>
                </form>

            </div>
        </div>
</div>

    </body>

</html>