<!DOCTYPE html>

<html lang="en" class="no-js">

<!-- BEGIN HEAD -->



<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/layout3/css/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/layout3/css/slick/slick-theme.css"/>
    <!-- Hotjar Tracking Code for https://erp.bison.tn -->
     <script>
    (function(h, o, t, j, a, r) {
        h.hj = h.hj || function() {
            (h.hj.q = h.hj.q || []).push(arguments)
        };
        h._hjSettings = {
            hjid: 1528219,
            hjsv: 6
        };
        a = o.getElementsByTagName('head')[0];
        r = o.createElement('script');
        r.async = 1;
        r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
        a.appendChild(r);
    })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
    </script>
 
    <style>
   /* #intelligentSearchResults .search-header {
    border-radius: 3px 3px 0 0;
    font-size: .85em;
    }*/

    .dropdown{
        margin-left: 30px;
    }

   #intelligentSearchResults{
    padding:20px;
    max-width: 100%;
  /*  max-height: 260px;
    overflow: auto; 
    */
    border: solid 1px rgba(0, 0, 0, 0.35);
    -moz-box-shadow: 1px 5px 10px rgba(0, 0, 0, 0.35);
    -webkit-box-shadow: 1px 5px 10px rgba(0, 0, 0, 0.35);
    -o-box-shadow: 1px 5px 10px rgba(0, 0, 0, 0.35);
    -ms-box-shadow: 1px 5px 10px rgba(0, 0, 0, 0.35);
    box-shadow: 1px 5px 10px rgba(0, 0, 0, 0.35); 
   }
    .aaa>a:focus,
    .aaa>a:hover {
        text-decoration: none;
        background-color: transparent;
    }

    .aaa>a:focus,
    .aaa>a:hover {
        text-decoration: none;
        background-color: transparent !important;
        border-radius: 25px !important;
        padding: 0px !important;
        color: transparent;
    }

    .aaa>a:focus,
    .aaa>a {
        text-decoration: none;
        background-color: transparent !important;
        border-radius: 25px !important;
        padding: 0px !important;
        color: transparent;
    }
    </style>
    <meta charset="utf-8">
    <title>
        <?php
if ($this->mdl_settings->setting('custom_title') != '') {
    echo $this->mdl_settings->setting('custom_title');
} else {
    echo ' Bison ERP';
}
$bl = 0;
$bc = 0;

if ($this->mdl_settings->setting('setting_gestion_bl') == 1) {
    $bl = 1;
}
if ($this->mdl_settings->setting('setting_gestion_bc') == 1) {
    $bc = 1;
}
 
?>
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">
	

    <!-- FEUILLES DE STYLES ET JS ANCIENS-->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/admin/layout3/img/favicon.png">
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript">
    $('a[href^="#"]').click(function() {
        var the_id = $(this).attr("href");
        $('html, body').animate({
            scrollTop: $(the_id).offset().top
        }, 'slow'); //return false;
    });
    </script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>



    <script type="text/javascript">
    $(function() {
        $('.nav-tabs').tab();
        $('.tip').tooltip();
        $('body').on('focus', ".datepicker", function() {
            $(this).datepicker({
                autoclose: true,
                format: '<?php echo date_format_datepicker(); ?>',
                language: '<?php echo lang('
                cldr '); ?>',
            });

        });
        $('.create-invoice').click(function() {
            $('#modal-placeholder').load(
                "<?php echo site_url('invoices/ajax/modal_create_invoice'); ?>");
        });
        $('.create-quote').click(function() {
            // $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_create_quote'); ?>");
        });
        $('#modif_photo').click(function() {
            user_id = $(this).data('user-id');
            $('#modal-placeholder').load("<?php echo site_url('users/file_view'); ?>/" + user_id);
        });
        $('#btn_quote_to_invoice').click(function() {
            quote_id = $(this).data('quote-id');
            $('#modal-placeholder').load(
                "<?php echo site_url('quotes/ajax/modal_quote_to_invoice'); ?>/" + quote_id);
        });

        $('a[id^="quote_to_invoice"]').click(function() {
            quote_id = $(this).data('quote-id');
            $('#modal-placeholder').load(
                "<?php echo site_url('quotes/ajax/modal_quote_to_invoice'); ?>/" + quote_id);
        });
        $('#btn_copy_invoice').click(function() {
            invoice_id = $(this).data('invoice-id');
            $('#modal-placeholder').load(
            "<?php echo site_url('invoices/ajax/modal_copy_invoice'); ?>", {
                invoice_id: invoice_id
            });
        });
        $('#btn_create_credit').click(function() {
            invoice_id = $(this).data('invoice-id');
            $('#modal-placeholder').load(
            "<?php echo site_url('invoices/ajax/modal_create_credit'); ?>", {
                invoice_id: invoice_id
            });
        });
        $('#btn_copy_quote').click(function() {
            quote_id = $(this).data('quote-id');
            $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_copy_quote'); ?>", {
                quote_id: quote_id
            });
        });
        $('.client-create-invoice').click(function() {
            $('#modal-placeholder').load(
                "<?php echo site_url('invoices/ajax/modal_create_invoice'); ?>", {
                    client_name: $(this).data('client-name')
                });
        });
        $('.client-create-quote').click(function() {
            $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_create_quote'); ?>", {
                client_name: $(this).data('client-name')
            });
        });

        $(document).on('click', '.invoice-add-payment', function() {
            client_id = $(this).data('client-id');
            invoice_id = $(this).data('invoice-id');
            invoice_balance = $(this).data('invoice-balance');
            invoice_payment_method = $(this).data('invoice-payment-method');
            $('#modal-placeholder').load("<?php echo site_url('payments/ajax/modal_add_payment'); ?>", {
                invoice_id: invoice_id,
                client_id: client_id,
                invoice_balance: invoice_balance,
                invoice_payment_method: invoice_payment_method
            });
        });
    });
    </script>
    <script type="text/javascript">
    $.noConflict();

    function date_heure(id) {
        date = new Date;
        annee = date.getFullYear();
        moi = date.getMonth();
        mois = new Array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t',
            'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
        j = date.getDate();
        jour = date.getDay();
        jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        h = date.getHours();
        if (h < 10) {
            h = "0" + h;
        }
        m = date.getMinutes();
        if (m < 10) {
            m = "0" + m;
        }
        s = date.getSeconds();
        if (s < 10) {
            s = "0" + s;
        }
        //resultat = 'Nous sommes le '+jours[jour]+' '+j+' '+mois[moi]+' '+annee+' il est '+h+':'+m+':'+s;
        resultat = jours[jour] + ' ,' + j + ' ' + mois[moi] + ' ' + annee + ' ,' + h + ':' + m;
        document.getElementById(id).innerHTML = resultat;
         setTimeout('date_heure("' + id + '");', '1000');
        return true;
    }
    </script>

    <!--<![endif]-->
	   <!-- Off canvas-->
<script type="text/javascript">
/// some script

// jquery ready start
$(document).ready(function() {
	// jQuery code

	  $("[data-trigger]").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        var offcanvas_id =  $(this).attr('data-trigger');
        $(offcanvas_id).toggleClass("show");
        $('body').toggleClass("offcanvas-active");
        $(".screen-overlay").toggleClass("show");

    }); 


   	// Close menu when pressing ESC
    $(document).on('keydown', function(event) {
        if(event.keyCode === 27) {
           $(".offcanvas").removeClass("show");
           $("body").removeClass("overlay-active");
        }
    });

    $(".closebtn, .screen-overlay").click(function(e){
    	$(".screen-overlay").removeClass("show");
        $(".offcanvas").removeClass("show");
        $("body").removeClass("offcanvas-active");


    }); 
	
}); // jquery end
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>
    <script src="<?php echo base_url(); ?>assets/js/global.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css"
        rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet"
        type="text/css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="<?php echo base_url(); ?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet"
        type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css">
    <!-- END PAGE LEVEL PLUGIN STYLES -->

    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css" />
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>assets/global/plugins/jquery-multi-select/css/multi-select.css" />

    <!-- BEGIN PAGE STYLES -->
    <link href="<?php echo base_url(); ?>assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE STYLES -->

    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
    <link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css" id="style_components"
        rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css"
        id="style_color">
    <link href="<?php echo base_url(); ?>assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/default/css/style_anis.css" rel="stylesheet" type="text/css">
	
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>assets/global/plugins/jquery-notific8/jquery.notific8.min.css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/ckeditor/ckeditor.js"></script>
	<!-- fonts new file -->
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/layout3/css/fonts/fonts.css" type="text/css" media="all">

    <?php //die; ?>

</head>

<body class="page-header-menu-fixed">
    <?php
$id_user = $this->session->userdata['user_id'];
$name_user = $this->session->userdata['user_name'];
$group_user = $this->session->userdata['groupes_user_id'];
?>
<b class="screen-overlay"></b>
    <!-- BEGIN HEADER -->
    <div class="page-header">
        <!-- BEGIN HEADER TOP -->
        <div class="page-header-top">
            <div class="container-fluid">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
					<div class="logo-bar">
						<a href="<?php echo base_url(); ?>dashboard">
							<img src="<?php echo base_url(); ?>assets/admin/layout3/img/logo-bison-v2.png" alt="logo"
								class="logo-default"></a>
					</div>
					<div class="search-bar">
 
                  <!--   <form role="search" id="search-form" class="search-form">-->
                      <div class="search-rot"></div> 
							<div class="input-group search-form" id="search-form">
								<input type="text" autocomplete="off"  id="insearch" class="search-field" placeholder="<?php echo lang('search')?>..." >
								<button class="input-group-btn">
								<!--	<a class="btn submit"><i class="icon-magnifier"></i></a>-->
								</button>
							</div>
						 
                        <div class="result">
                    <!--</form>-->
							</div>
					</div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" onclick="togl_Function()" class="menu-toggler"></a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">

						 <!-- BEGIN CREATE BTN -->
							<li class="dropdown dropdown-extended dropdown-dark topbar-item dropdown-create"
								id="header_create_bar">
									<div class="dropdown-create-bar">
										<a href="javascript:;" class="dropdown-toggle dropbtn-create" data-toggle="dropdown" data-hover="dropdown"
										data-close-others="true" onclick="myFunction()">
											<?php echo lang('create'); ?>
										</a>
									</div>
									<div id="dropdown-create" class="dropdown-create-content">
										 <ul class="navi navi-hover">
											<li class="navi-item">
												<a href="<?php echo base_url(); ?>clients/form" class="navi-link">
												<span class="navi-icon"><i class="flaticon-add-friend"></i></span>
												<span class="navi-text"><?php echo lang('create_client'); ?></span>
												</a>
											</li>
											<li class="navi-item">
												<a href="<?php echo base_url(); ?>quotes/form" class="navi-link">
												<span class="navi-icon"><i class="flaticon-request"></i></span>
												<span class="navi-text"><?php echo lang('create_quote'); ?></span>
												</a>
											</li>
											<li class="navi-item">
												<a href="<?php echo base_url(); ?>invoices/form" class="navi-link">
												<span class="navi-icon"><i class="flaticon-bill"></i></span>
												<span class="navi-text"><?php echo lang('create_invoice'); ?></span>
												</a>
											</li>
											<li class="navi-item">
                                                <a href="<?php echo base_url(); ?>products/form" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon-buy"></i></span>        
                                                    <span class="navi-text"><?php echo lang('create_product'); ?></span>
												</a>
                                            </li>
											<li class="navi-item">
                                                <a href="<?php echo base_url(); ?>fournisseurs/form" class="navi-link">
                                                     <span class="navi-icon"><i class="flaticon-team"></i></span>  
                                                    <span class="navi-text"><?php echo lang('create_fournisseur'); ?></span>
												</a>
                                            </li>
											<li class="navi-item">
												<a href="<?php echo base_url(); ?>commande/form" class="navi-link">
												<span class="navi-icon"><i class="flaticon-product"></i></span>
												<span class="navi-text"><?php echo lang('create_cmd'); ?></span>
												</a>
											</li>
											<li class="navi-item">
												<a href="<?php echo base_url(); ?>bl/form" class="navi-link">
												<span class="navi-icon"><i class="flaticon-list"></i></span>
												<span class="navi-text"><?php echo lang('create_delivery_form'); ?></span>
												</a>
											</li>
											<li class="navi-item">
												<a href="<?php echo base_url(); ?>fabrication/form" class="navi-link">
												<span class="navi-icon"><i class="flaticon-data-warehouse"></i></span>
												<span class="navi-text"><?php echo lang('create_bf'); ?></span>
												</a>
											</li>
                                            <li class="navi-item">
												<a href="<?php echo base_url(); ?>mark/form" class="navi-link">
												<span class="navi-icon"><i class="flaticon-data-warehouse"></i></span>
												<span class="navi-text"><?php echo lang('create_mark'); ?></span>
												</a>
											</li>
										</ul>
									</div>
							</li>
<script type="text/javascript">
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("dropdown-create").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('dropbtn-create')) {
    var dropdowns = document.getElementsByClassName("dropdown-create-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
		  if (event.target == modal-create) {
    openDropdown.classList.remove('show');
  }
      }
    }
  }
}
</script>
		<!-- END CREATE BTN -->
			<!-- BEGIN HELP DROPDOWN -->
			<li class="dropdown dropdown-extended dropdown-dark topbar-item dropdown-help"
                            id="header_help_bar">
                <button class="dropdown-toggle" data-trigger="#quick_help" id="btn-offcanvas" type="button">
					<i class="icon-bar-help"></i>
                </button>
            </li>
				<aside id="quick_help" class="offcanvas">
					<button class="closebtn">&times;</button>
						<div class="content-bar panel-help sqr-menu">
							<?php $this->load->view('layout/sidenav-bar/tab-help') ?>
						</div>
				</aside>			
				<!-- END HELP DROPDOWN -->
				<!-- BEGIN Pack DROPDOWN -->
				
					<li class="dropdown dropdown-extended dropdown-dark topbar-item dropdown-pack"
                            id="header_pack_bar">
                        <button class="dropdown-toggle" data-trigger="#quick_pack"  id="btn-offcanvas" type="button">
                            <i class="icon-bar-pack"></i>
                        </button>
					</li>
						<aside class="offcanvas" id="quick_pack">
							<button class="closebtn">&times;</button>
							<div class="content-bar panel-pack">
								<?php $this->load->view('layout/sidenav-bar/tab-pack') ?>
							</div>
						</aside>
						
<!-- Begin Popup : Upgrade pack -->
			<div class="modal-pack" id="popup-pack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-content">
				<div class="modal-header">
				  <a href="javascript:;" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
				  <h5 class="font-weight-bold small-h5"><?php echo lang('upgrade_title'); ?></h5>
				</div>
				<div class="modal-body">
					<?php $this->load->view('layout/sidenav-bar/boxs-pack') ?>
				</div>
				<div class="modal-footer">
					<div class="modal-footer-btn">
						<a href="javascript:;" class="btn btn-md btn-light-primary font-weight-bolder btn-cancel" data-dismiss="modal" ><?php echo lang('cancel'); ?></a>
					</div>
				</div>
			  </div>
			</div>
<!-- End Popup : Upgrade pack -->
				<!-- END Pack DROPDOWN -->
				<!-- BEGIN notif DROPDOWN -->
				
					<li class="dropdown dropdown-extended dropdown-dark topbar-item dropdown-notif"
                            id="header_notif_bar">
                        <button class="dropdown-toggle" data-trigger="#quick_notif"  id="btn-offcanvas" type="button">
                            <i class="icon-bar-notif"></i>
                        </button>
					</li>
						<aside class="offcanvas" id="quick_notif">
							<button class="closebtn">&times;</button>
							<div class="content-bar panel-notif">
								<?php $this->load->view('layout/sidenav-bar/tab-notif') ?>
							</div>
						</aside>
				<!-- END notif DROPDOWN -->
			
				<!-- BEGIN Account DROPDOWN -->		
					<li class="dropdown dropdown-extended dropdown-dark topbar-item dropdown-account"
                            id="header_account_bar">
						<button class="dropdown-toggle" data-trigger="#quick_account"  id="btn-offcanvas" type="button">
                            <span class="account-user-name">
									<span class="text-muted font-weight-bold acc-font"><?php echo lang('hello_user'); ?></span>
									<span class="text-dark font-weight-bold acc-name"><?php echo $name_user; ?></span>
								</span>
								<span class="symbol-label font-weight-bold label-acc"><?php echo $name_user{0}; ?></span>
                        </button>
					</li>
						<aside class="offcanvas" id="quick_account">
							<button class="closebtn">&times;</button>
							<div class="content-bar panel-account">
								<?php $this->load->view('layout/sidenav-bar/tab-account') ?>
							</div>
						</aside>
						<!-- Begin Popup : Upgrade pack -->
			<div class="modal-account" id="popup-account"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-content account-modal-content">
				<div class="modal-header">
				  <a href="javascript:;" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
				  <h5 class="font-weight-bold small-h5"><?php echo lang('upgrade_title'); ?></h5>
				</div>
				<div class="modal-body">
					<?php $this->load->view('layout/sidenav-bar/boxs-pack') ?>
				</div>
				<div class="modal-footer">
					<div class="modal-footer-btn">
						<a href="javascript:;" class="btn btn-md btn-light-primary font-weight-bolder btn-cancel" data-dismiss="modal" ><?php echo lang('cancel'); ?></a>
					</div>
				</div>
			  </div>
			</div>

<!-- End Popup : Upgrade pack -->
					</ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- END HEADER TOP -->
        <!-- BEGIN HEADER MENU -->
        <div class="page-header-menu">
            <div class="container-fluid" style=" width: 100%">
                <!-- BEGIN HEADER SEARCH BOX -->
                <!--form class="search-form" action="extra_search.html" method="GET" style="display:none">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="query">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                        </span>
                    </div>
                </form-->
                <!-- END HEADER SEARCH BOX -->
                <!-- BEGIN MEGA MENU -->
                <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->

                <div class="hor-menu">
                    <ul class="nav navbar-nav">
					<button class="closebtn menu" onclick="Closemenu()">×</button>
                        <li class="menu-dropdown mega-menu-dropdown">
                        <a href="/dashboard"><?php echo lang('home'); ?></a>
						</li>
		<!--menu contact-->
                        <?php
$sess_cont_add = $this->session->userdata['cont_add'];
$sess_cont_del = $this->session->userdata['cont_del'];
$sess_cont_index = $this->session->userdata['cont_index'];
if (($sess_cont_add == 1) || ($sess_cont_del == 1) || ($sess_cont_index == 1)) {        
    ?>                        
						<li class="menu-dropdown mega-menu-dropdown">
                            <a href="<?php echo base_url(); ?>clients/index" class="dropdown-toggle"><?php echo lang('clients'); ?></a>
                        </li>
			
                        
                        <?php }
?>
        <!--fin menu contact-->
						<!-- menu Vente -->
						    <li class="menu-dropdown mega-menu-dropdown ">
								<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown"
									href="javascript:;" class="dropdown-toggle">
									<?php echo lang('sales'); ?> <i class="fa fa-angle-down"></i>
								</a>
								<ul class="dropdown-menu">
									<li>
										<div class="mega-menu-content">
											<div class="row">
												<div class="col-md-4">
													<ul class="mega-menu-submenu" style=" width:210px">
														<li>
															<a href="<?php echo base_url(); ?>quotes/index" class="iconify">
																<!--i class="icon-list icon-devis"></i-->
																<i class="fas fa-comment-dollar"></i>
																<?php echo lang('quotes'); ?> </a>
														</li>
														<li>
															<a href="<?php echo base_url(); ?>invoices/index"
																class="iconify">
																<!--i class="icon-list icon-facture"></i-->
																<i class="fas fa-file-alt"></i>
																<?php echo lang('invoices'); ?> </a>
														</li>
                                                        <?php if ($bl == 0) {?>
														<li>
															<a href="<?php echo base_url(); ?>bl"
																class="iconify">
																<!--i class="icon-list icon-bl"></i-->
																<i class="fas fa-envelope-open-text"></i>
																<?php echo lang('bon_livraison') ?> </a>
														</li>
                                                        <?php }?>
												<?php if ($bc == 0) {?>
														<li>
															<a href="<?php echo base_url(); ?>commande"
																class="iconify">
															   <i class="fas fa-shopping-cart"></i>
																<?php echo lang('bons_commande') ?> </a>
														</li>
												<?php }?>
														<li>
                                                        <a href="<?php echo base_url(); ?>invoices/avoir"
                                                            class="iconify">
                                                            <!--i class="icon-list icon-avoir"></i-->
															<i class="fas fa-credit-card"></i>
                                                            <?php echo lang('avoirs'); ?> </a>
														</li>
                                                        <li>
                                                        <a href="<?php echo base_url(); ?>mark/index"
                                                            class="iconify">
                                                            <!--i class="icon-list icon-avoir"></i-->
															<i class="fas fa-bookmark"></i>
                                                            <?php echo lang('mark'); ?> </a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</li>
						
						                        <?php
//rebrique devi: selon les droit données
$sess_devis_add = $this->session->userdata['devis_add'];
$sess_devis_del = $this->session->userdata['devis_del'];
$sess_devis_index = $this->session->userdata['devis_index'];
if (($sess_devis_add == 1) || ($sess_devis_del == 1) || ($sess_devis_index == 1)) {
    ?>
	<?php }?>
                        <!-- end Menu Vente -->
                     <!-- Menu Achat -->
                        <?php if ($bc == 0) {?>
                        <li class="menu-dropdown mega-menu-dropdown ">
                            <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown"
                                href="javascript:;" class="dropdown-toggle">
                                <?php echo lang('purchase') ?> <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="mega-menu-content">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <ul class="mega-menu-submenu" style=" width:210px">
                                              
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>commandeachat/form"
                                                            class="iconify">
                                                           <i class="fas fa-shopping-cart"></i>
                                                            <?php echo 'Ajouter commande achats'?> </a>
													</li>
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>commandeachat"
                                                            class="iconify">
                                                           <i class="fas fa-shopping-cart"></i>
                                                            <?php echo lang('bons_commande') ?> </a>
													</li>
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>fournisseurs"
                                                            class="iconify">
                                                            <i class="fas fa-chart-pie"></i>
                                                            <?php echo lang('Fournisseurs'); ?> </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <?php }?>
						<!-- end menu Achat -->
						<!-- Menu stock -->
							<li class="menu-dropdown mega-menu-dropdown ">
								<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown"
									href="javascript:;" class="dropdown-toggle">
									<?php echo lang('stock-management'); ?> <i class="fa fa-angle-down"></i>
								</a>
								<ul class="dropdown-menu">
									<li>
										<div class="mega-menu-content">
											<div class="row">
												<div class="col-md-4">
													<ul class="mega-menu-submenu" style=" width:220px">
                                                      <!--  <li>
                                                                <a href="<?php // echo base_url(); ?>depot"
                                                                    class="iconify">
                                                                    <i class="fas fa-th-list"></i>
                                                                    <?php //echo 'Dépôt' ?> </a>
                                                        </li>
                                                        <li>
                                                                <a href="<?php //echo base_url(); ?>group_option"
                                                                    class="iconify">
                                                                    <i class="fas fa-th-list"></i>
                                                                    <?php //echo 'Group option' ?> </a>
                                                        </li>
                                                        <li>
                                                                <a href="<?php // echo base_url(); ?>attributs"
                                                                    class="iconify">
                                                                    <i class="fas fa-th-list"></i>
                                                                    <?php //echo 'Attributs' ?> </a>
                                                        </li>-->
														<li>
															<a href="<?php echo base_url(); ?>products" class="iconify">
																<i class="fas fa-inbox"></i>
																<?php echo lang('products'); ?> </a>
														</li>														
													<!--	<li>
															<a href="<?php echo base_url(); ?>fournisseurs"
																class="iconify">
																<i class="fas fa-chart-pie"></i>
																<?php echo lang('Fournisseurs'); ?> </a>
														</li>-->
														<li>
                                                        <a href="<?php echo base_url(); ?>fabrication"
                                                            class="iconify">
                                                           <i class="fas fa-boxes"></i>
                                                            <?php echo lang('bf_order') ?> </a>
													    </li>
                                                        <li>
                                                        <a href="<?php echo base_url(); ?>categorie_fournisseur"
                                                            class="iconify">
                                                           <i class="fa fa-list"></i>
                                                            <?php echo lang('list_category') ?> </a>
													    </li>
													</ul>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</li>
                        <?php
//rebrique produit: selon les droit données
$sess_product_add = $this->session->userdata['product_add'];
$sess_product_del = $this->session->userdata['product_del'];
$sess_product_index = $this->session->userdata['product_index'];
if (($sess_product_add == 1) || ($sess_product_del == 1) || ($sess_product_index == 1)) {
    ?>
            <?php }?>
                        <?php
//rebrique facture: selon les droit données
$sess_facture_add = $this->session->userdata['facture_add'];
$sess_facture_del = $this->session->userdata['facture_del'];
$sess_facture_index = $this->session->userdata['facture_index'];
if (($sess_facture_add == 1) || ($sess_facture_del == 1) || ($sess_facture_index == 1)) {
    ?>
 <?php }?>

					<!-- menu RH -->
					<li class="menu-dropdown mega-menu-dropdown ">
                            <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown"
                                href="javascript:;" class="dropdown-toggle">
                                <?php echo lang('rh'); ?> <i class="fa fa-angle-down"></i>
                            </a>
							<!--span class="label label-outline-secondar"><!--?php echo lang('bientot'); ?></span-->
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="mega-menu-content">
                                        <div class="row">
                                            <div class="col-md-4">
                                                 <ul class="mega-menu-submenu max-width-soon" style=" width:275px">
                                                    <li class="disabled">
                                                        <a href="javascript:;" class="iconify">
                                                             <i class="fas fa-users-cog"></i>
                                                            <?php echo lang('gestion_employe'); ?>
															<span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                    <li class="disabled">
                                                        <a href="javascript:;" class="iconify">
                                                            <i class="fas fa-calendar-check"></i>
                                                            <?php echo lang('demandes_conges'); ?>
															<span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                    <li class="disabled">
                                                        <a href="javascript:;" class="iconify">
                                                            <i class="fas fa-file-invoice-dollar"></i>
                                                            <?php echo lang('note_frais'); ?>
															<span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                    <li class="disabled">
                                                       <a href="javascript:;" class="iconify">
                                                           <i class="fas fa-money-check"></i>
                                                            <?php echo lang('fiches_paie'); ?>
															<span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
					<!-- end menu RH -->
					
					<!-- menu Comptabilite -->
					<li class="menu-dropdown mega-menu-dropdown ">
                            <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown"
                                href="javascript:;" class="dropdown-toggle">
                                <?php echo lang('account_state'); ?> <i class="fa fa-angle-down"></i>
                            </a>
							<!--span class="label label-outline-secondar"><!--?php echo lang('bientot'); ?></span-->
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="mega-menu-content">
                                        <div class="row">
                                            <div class="col-md-4">
                                                 <ul class="mega-menu-submenu max-width-soon" style=" width:325px">
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>depenses" class="iconify">
                                                             <i class="fas fa-pen-square"></i>
                                                            <?php echo lang('depenses'); ?>
															</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>payments" class="iconify">
                                                            <i class="fas fa-money-check-alt"></i>
                                                            <?php echo lang('cashing'); ?>
															</a>
                                                    </li>
                                                    <li class="disabled">
                                                        <a href="javascript:;" class="iconify">
                                                            <i class="fas fa-coins"></i>
                                                            <?php echo lang('bank_statement'); ?>
															<span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                    <li class="disabled">
                                                        <a href="javascript:;" class="iconify">
                                                            <i class="fas fa-receipt"></i>
                                                            <?php echo lang('bank_report'); ?>
															<span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                    <li class="disabled">
                                                        <a href="javascript:;" class="iconify">
                                                            <i class="fas fa-chart-line"></i>
                                                            <?php echo lang('exports_accounting'); ?>
															<span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                    <li class="disabled">
                                                        <a href="javascript:;" class="iconify">
                                                            <i class="fas fa-calendar-alt"></i>
                                                            <?php echo lang('month_statement'); ?>
															<span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
					<!-- end menu Comptabilite -->
					<!-- fournisseur-->
                        <?php
//rebrique fournisseur: selon les droit données
$sess_fournisseur_add = $this->session->userdata['fournisseur_add'];
$sess_fournisseur_del = $this->session->userdata['fournisseur_del'];
$sess_fournisseur_index = $this->session->userdata['fournisseur_index'];
if ((($sess_fournisseur_add == 1) || ($sess_fournisseur_del == 1) || ($sess_fournisseur_index == 1))) {
    ?>
                   <?php }?>
                       
                        <!-- payement-->
                        <?php
//rebrique payement: selon les droit données
$sess_payement_add = $this->session->userdata['payement_add'];
$sess_payement_del = $this->session->userdata['payement_del'];
$sess_payement_index = $this->session->userdata['payement_index'];
if (($sess_payement_add == 1) || ($sess_payement_del == 1) || ($sess_payement_index == 1)) {
    ?>
			<?php }?>
                        <!-- fin payement-->


                        <!--menu report-->
                        <?php
//rebrique report: selon les droit données
$sess_report_add = $this->session->userdata['report_add'];
$sess_report_del = $this->session->userdata['report_del'];
$sess_report_index = $this->session->userdata['report_index'];
if (($sess_report_add == 1) || ($sess_report_del == 1) || ($sess_report_index == 1)) {
    ?>
                        <?php }?>
	
						<li class="menu-dropdown mega-menu-dropdown ">
                            <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown"
                                href="javascript:;" class="dropdown-toggle">
                                <?php echo lang('report_statistic'); ?> <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="mega-menu-content">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <ul class="mega-menu-submenu max-width-soon" style=" width:290px">
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>reports/rapport_clients" class="iconify">
                                                            <i class="fas fa-handshake"></i> <?php echo lang('best_client') ?>
															<!--span class="label label-outline-secondar sub"><!--?php echo lang('bientot'); ?></span--></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>reports/rapport_commercials" class="iconify">
                                                            <i class="fas fa-hand-holding-usd"></i> <?php echo lang('best_commercial') ?>
															<!--span class="label label-outline-secondar sub"><!--?php echo lang('bientot'); ?></span--></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>reports/rapport_products" class="iconify">
                                                            <i class="fas fa-donate"></i><?php echo lang('best_sales') ?>
															<!--span class="label label-outline-secondar sub"><!--?php echo lang('bientot'); ?></span--></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>reports/rapport_mensuel" class="iconify">
                                                            <i class="fas fa-tasks"></i> <?php echo lang('report_mensuel') ?>
															<!--span class="label label-outline-secondar sub"><!--?php echo lang('bientot'); ?></span--></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>reports/rapport_annuel" class="iconify">
                                                            <i class="fas fa-chart-area"></i> <?php echo lang('report_annuel') ?>
															<!--span class="label label-outline-secondar sub"><!--?php echo lang('bientot'); ?></span--></a>
                                                    </li>
                                                    <?php if (relanceautomatique()) {?>
                                                    <li>
                                                        <a href="<?php echo base_url(); ?>tracking" class="iconify">
                                                           <i class="fas fa-chart-line"></i><?php echo lang('report_relance') ?>
															<!--span class="label label-outline-secondar sub"><!--?php echo lang('bientot'); ?></span--></a>
                                                    </li>
                                                    <?php }?>
                                                    <li class="disabled">
                                                        <a href="javascript:;" class="iconify">
                                                             <i class="fas fa-chart-bar"></i><?php echo lang('report_sales') ?>
															 <span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                    <li class="disabled">
                                                        <a href="javascript:;" class="iconify">
                                                            <i class="fas fa-credit-card"></i><?php echo lang('report_purchases') ?>
															<span class="label label-outline-secondar sub"><?php echo lang('bientot'); ?></span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
						

                    </ul>
                </div>
                <!-- END MEGA MENU -->
                <!-- Menu date-->
                <br>
               <!--  <div style=" color: #bcc2cb; text-align: right;margin-top: -2px;">
                   <span id="date_heure" style="text-align: right; width: 100%"></span>-->
                    <script type="text/javascript">
                   // window.onload = date_heure('date_heure');
                    </script>
                    <!-- fin menu date-->
              <!--  </div>-->
            </div>

        </div>
        <!-- END HEADER MENU -->

    </div>
    <!-- END HEADER -->
    <!-- BEGIN PAGE CONTAINER -->

    <div class="page-container">
        <!-- BEGIN PAGE HEAD -->

        <div class="page-head">
            <div id="main-area">
                <div id="modal-placeholder"></div>
                <div id="modal-placeholder2"></div>
                <?php //echo @$modal_delete_quote;          ?>
            </div>
            <div class="container">

            </div>
            <!-- END PAGE HEAD -->
            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="container-fluid">
                    <!--<pre><?php //print_r($this->router);                      ?></pre>-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>dashboard"><?php echo lang('home'); ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <?php if (($this->router->fetch_method() != 'index') && ($this->router->fetch_method() != 'status') && ($this->router->fetch_method() != '')) {?>
                        <li class="active">
                            <?php if ($this->router->fetch_class() == 'dashboard') {
    echo lang('dashboard');
}
    ?>
                            <?php if ($this->router->fetch_class() == 'versions') {
        echo lang('versions');
    }
    ?>
                            <?php if ($this->router->fetch_class() == 'clients') {?><a
                                href="<?php echo base_url(); ?>clients"><?php echo lang('clients'); ?></a><?php }?>
                            <?php if ($this->router->fetch_class() == 'settings') {
        echo lang('settings');
    }
    ?>
                            <?php if ($this->router->fetch_class() == 'tax_rates') {
        ?><a href="<?php echo base_url(); ?>settings"> <?php echo lang('settings'); ?></a><?php }?>
                            <?php
//echo $this->router->fetch_class().'//'.$this->router->fetch_method();
    if ($this->router->fetch_class() == 'users') {
        echo lang('user_accounts');
        if ($this->router->fetch_method() === 'profil') {
            echo '<i class="fa fa-circle"></i>&nbsp;&nbsp;';
            echo lang('profil');
        }
        if (($this->router->fetch_method() == 'change_password')) {
            echo '<i class="fa fa-circle"></i>&nbsp;&nbsp;';
            echo lang('change_password');
        }
    }
    if ($this->router->fetch_class() == 'email_templates') {
        ?><a href="<?php echo base_url(); ?>email_templates"> <?php echo lang('madel_mail') ?></a><?php
}
    if ($this->router->fetch_class() == 'quotes') {
        ?><a href="<?php echo base_url(); ?>quotes"> <?php echo lang('quotes'); ?></a><?php
}

    if ($this->router->fetch_class() == 'devises') {
        ?><a href="<?php echo base_url(); ?>settings"> <?php echo lang('settings'); ?></a> <?php
}
    if ($this->router->fetch_class() == 'invoices' && $this->router->fetch_method() != 'avoir') {
        ?><a href="<?php echo base_url(); ?>invoices"> <?php echo lang('invoices'); ?></a><?php
}

    if ($this->router->fetch_class() == 'products') {
        ?><a href="<?php echo base_url(); ?>products"> <?php echo lang('products'); ?></a><?php
}
    if (($this->router->fetch_class() == 'commande')) {
        echo 'Commande';
    }
    if (($this->router->fetch_class() == 'fabrication')) {
        echo 'fabrication';
    }
    
    if (($this->router->fetch_class() == 'bl')) {
        echo 'Bl';
    }
    if ($this->router->fetch_class() == 'depenses') {
        ?><a href="<?php echo base_url(); ?>depenses"> <?php echo lang('depenses') ?></a><?php
}

    if ($this->router->fetch_class() == 'families') {
        ?><a href="<?php echo base_url(); ?>families"> <?php echo lang('product_families'); ?></a><?php
}
    if ($this->router->fetch_class() == 'categorie_fournisseur') {
        ?><a href="<?php echo base_url(); ?>categorie_fournisseur"> <?php echo lang('view_categorie'); ?></a><?php
}
 if ($this->router->fetch_class() == 'mark') {
        ?><a href="<?php echo base_url(); ?>mark"> <?php echo lang('mark'); ?></a><?php
}																		   
    if ($this->router->fetch_class() == 'banque') {
        ?><a href="<?php echo base_url(); ?>banque"> <?php echo lang('banque') ?></a><?php
}

    if ($this->router->fetch_class() == 'fournisseurs') {
        ?><a href="<?php echo base_url(); ?>fournisseurs"> <?php echo lang('Fournisseurs'); ?></a><?php
}
    if ($this->router->fetch_class() == 'payments') {
        ?><a href="<?php echo base_url(); ?>payments"> <?php echo lang('payments'); ?></a><?php
}
    if ($this->router->fetch_class() == 'societes') {
        ?><a href="<?php echo base_url(); ?>settings"> <?php echo lang('settings'); ?></a><?php
}
    if ($this->router->fetch_class() == 'import') {
        ?><a href="<?php echo base_url(); ?>import"> <?php echo 'Import des données'; ?></a><?php
}
    if ($this->router->fetch_class() == 'groupes_users') {
        echo lang('groupes_users');
    }

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_annuel')) {
        echo "Rapports Annuel";
    }

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_mensuel')) {
        echo "Rapports Mensuel";
    }

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_clients')) {
        echo "Rapports Clients";
    }

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_products')) {
        echo "Rapports Produits";
    }

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_commercials')) {
        echo "Rapports Commercials";
    }
    if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() == 'avoir')) {
        echo "Avoir";
    }

    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'importClient')) {
        echo "<i class='fa fa-circle'></i>&nbsp;Importer clients";
    }

    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'importFactures')) {
        echo "<i class='fa fa-circle'></i>&nbsp;Importer Factures";
    }

    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'importProducts')) {
        echo "<i class='fa fa-circle'></i>&nbsp;Importer Products";
    }

//                                    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'form'))
    //                                        echo lang('import')."AAA";
    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'view')) {
        echo "Modifier fichier";
    }

    ?>
                        </li>
                        <?php } else {?>
                        <li class="active">
                            <?php if ($this->router->fetch_class() == 'dashboard') {
    echo lang('dashboard');
}
    ?>
                            <?php if ($this->router->fetch_class() == 'versions') {
        echo 'Versions';
    }
    ?>
                            <?php if ($this->router->fetch_class() == 'clients') {
        echo lang('clients');
    }
    ?>
                            <?php if ($this->router->fetch_class() == 'settings') {
        echo lang('settings');
    }
    ?>
                            <?php if ($this->router->fetch_class() == 'tax_rates') {
        echo lang('settings');
    }
    ?>
                            <?php
//echo $this->router->fetch_class().'//'.$this->router->fetch_method();
    if ($this->router->fetch_class() == 'users') {
        echo lang('user_accounts');
        if ($this->router->fetch_method() === 'profil') {
            echo '<i class="fa fa-circle"></i>&nbsp;&nbsp;';
            echo lang('profil');
        }
        if (($this->router->fetch_method() == 'change_password')) {
            echo '<i class="fa fa-circle"></i>&nbsp;&nbsp;';
            echo lang('change_password');
        }
    }
    if ($this->router->fetch_class() == 'email_templates') {
        echo "Mod&egrave;les des emails";
    }

    if ($this->router->fetch_class() == 'quotes') {
        echo lang('quotes');
    }
    if ($this->router->fetch_class() == 'commande') {
        echo 'Commande';
    }
		if ($this->router->fetch_class() == 'mark') {
        echo lang('mark');
    }				  
    if ($this->router->fetch_class() == 'fabrication') {
        echo 'fabrication';
    }
    
    if ($this->router->fetch_class() == 'bl') {
        echo 'Bl';
    }
    if ($this->router->fetch_class() == 'tracking') {
        echo 'tracking';
    }

    if ($this->router->fetch_class() == 'categorie_fournisseur') {
        echo 'catégorie';
    }
		 if ($this->router->fetch_class() == 'mark') {
        echo lang('mark');
    }				  
    if ($this->router->fetch_class() == 'attributs') {
        echo 'attributs';
    }
    if ($this->router->fetch_class() == 'depot') {
        echo 'Dépôt';
    }
    if ($this->router->fetch_class() == 'group_option') {
        echo 'groupe option';
    }
    
    if ($this->router->fetch_class() == 'banque') {
        echo 'banque';
    }

    if ($this->router->fetch_class() == 'devises') {
        echo lang('devise');
    }

    if ($this->router->fetch_class() == 'invoices') {
        echo lang('invoices');
    }

    if ($this->router->fetch_class() == 'products') {
        echo lang('products');
    }

    if ($this->router->fetch_class() == 'depenses') {
        echo lang('depenses');
    }

    if ($this->router->fetch_class() == 'families') {
        echo lang('product_families');
    }

    if ($this->router->fetch_class() == 'fournisseurs') {
        echo lang('Fournisseurs');
    }

    if ($this->router->fetch_class() == 'payments') {
        echo lang('payments');
    }

    if ($this->router->fetch_class() == 'societes') {
        echo lang('societes');
    }

    if ($this->router->fetch_class() == 'groupes_users') {
        echo lang('groupes_users');
    }

    if ($this->router->fetch_class() == 'import') {
        echo 'Import des données';
    }

    if (($this->router->fetch_class() == 'quote_rappel') && ($this->router->fetch_method() == 'corn')) {
        echo lang('rappel_auj');
    }

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'invoice_aging')) {
        echo lang('invoice_aging');
    }
 
    if (($this->router->fetch_class() == 'quote_rappel') && ($this->router->fetch_method() == 'historique_relances')) {
        echo lang('historique_relances');
    }

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'payment_history')) {
        echo lang('payment_history');
    }

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'sales_by_client')) {
        echo lang('sales_by_client');
    }

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'sales_by_year')) {
        echo lang('sales_by_date');
    }

    if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() == 'avoir')) {
        echo 'Avoir';
    }

    if ($this->router->fetch_class() == 'agenda') {
        echo lang('agenda');
    }

    ?>
                        </li>
                        <?php }?>

                        <li class="active">

                            <?php if ($this->router->fetch_method() == 'view') {
    ?><i class="fa fa-circle"></i>&nbsp;&nbsp;<?php
if ($this->router->fetch_class() == 'quotes') {
        echo lang('edit_quote');
    }
		if ($this->router->fetch_class() == 'mark') {
          echo lang('edit_mark');
    }						 

    if ($this->router->fetch_class() == 'invoices') {
        echo lang('modif-facture');
    }
    if ($this->router->fetch_class() == 'commande') {
        echo 'Modifier commande';
    }
    if ($this->router->fetch_class() == 'fabrication') {
        echo 'Modifier fabrication';
    }
    
    if ($this->router->fetch_class() == 'bl') {
        echo 'Modifier bl';
    }

}

if (($this->router->fetch_method() == 'quote') && ($this->router->fetch_class() == 'mailer')) {
    echo lang('email_quote');
}
if (($this->router->fetch_method() == 'commande') && ($this->router->fetch_class() == 'mailer')) {
    echo lang('email_commande');
}
if (($this->router->fetch_method() == 'fabrication') && ($this->router->fetch_class() == 'mailer')) {
    echo lang('email_fabrication');
}

if (($this->router->fetch_method() == 'bl') && ($this->router->fetch_class() == 'mailer')) {
    echo lang('email_bl');
}

if (($this->router->fetch_method() == 'avoir') && ($this->router->fetch_class() == 'mailer')) {
    echo lang('email_avoir');
}

if (($this->router->fetch_method() == 'invoice') && ($this->router->fetch_class() == 'mailer')) {
    echo lang('email_invoice');
}
if (($this->router->fetch_class() == 'clients') && ($this->router->fetch_method() == 'view')) {
    echo lang('view_clien');
}

if (($this->router->fetch_class() == 'commande') && ($this->router->fetch_method() == 'mailer')) {
    echo lang('view_clien');
}
if (($this->router->fetch_class() == 'fabrication') && ($this->router->fetch_method() == 'mailer')) {
    echo lang('view_clien');
}

if (($this->router->fetch_class() == 'avoir') && ($this->router->fetch_method() == 'mailer')) {
    echo lang('view_clien');
}

if (($this->router->fetch_class() == 'bl') && ($this->router->fetch_method() == 'mailer')) {
    echo lang('view_clien');
}
 

if ($this->router->fetch_method() == 'form') {
    ?><i class="fa fa-circle"></i>&nbsp;&nbsp;<?php
if ($this->router->fetch_class() == 'clients') {
        echo lang('add_clients');
    }

    if ($this->router->fetch_class() == 'groupes_users') {
        echo lang('add_groupe_user');
    }

    if ($this->router->fetch_class() == 'quotes') {
        echo lang('create_quote');
    }

    if ($this->router->fetch_class() == 'commande') {
        echo 'Crée une commande';
    }
	
    if ($this->router->fetch_class() == 'fabrication') {
        echo 'Crée une fabrication';
    }
    if ($this->router->fetch_class() == 'bl') {
        echo 'Crée un bl';
    }
    if ($this->router->fetch_class() == 'devises') {
        echo lang('add_devise');
    }

    if ($this->router->fetch_class() == 'invoices') {
        echo lang('create_invoice');
    }

    if ($this->router->fetch_class() == 'families') {
        echo lang('add_product_families');
    }

    if ($this->router->fetch_class() == 'categorie_fournisseur') {
        echo lang('add_categorie_fournisseur');
    }

		if ($this->router->fetch_class() == 'mark') {
         echo lang('ajout_mark');
    }						 
    if ($this->router->fetch_class() == 'banque') {
        echo 'ajout banque';
    }

    if ($this->router->fetch_class() == 'products') {
        echo lang('create_product');
    }

    if ($this->router->fetch_class() == 'depenses') {
        echo lang('depenses');
    }

    if ($this->router->fetch_class() == 'fournisseurs') {
        echo lang('create_fournisseur');
    }

    if ($this->router->fetch_class() == 'payments') {
        echo lang('enter_payment');
    }

    if ($this->router->fetch_class() == 'societes') {
        echo lang('societes_settings');
    }

    if ($this->router->fetch_class() == 'email_templates') {
        echo lang('email_template_form');
    }

    if ($this->router->fetch_class() == 'users') {
        echo lang('user_form');
    }

    if ($this->router->fetch_class() == 'tax_rates') {
        echo lang('tax_rate_form');
    }

    if ($this->router->fetch_class() == 'import') {
        echo "Ajouter Fichiers";
    }

}
//                                 if ((($this->router->fetch_class()==='users') ) && (($this->router->fetch_method()=== 'profil') ))
//                                   echo '<i class="fa fa-circle"></i>&nbsp;&nbsp;'; echo lang('profil');
?>
                        </li>

                    </ul>
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE CONTENT INNER -->
                    <?php
//if(current_url()=='erp-v0.novatis.org/clients/form') echo 1;
$this->router->fetch_class(); //controlleur
$this->router->fetch_method(); //methode

if (($this->router->fetch_class() == 'groupes_users') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('groupes_users/form');
}
if (($this->router->fetch_class() == 'tax_rates') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('tax_rates/form');
}
if (($this->router->fetch_class() == 'tax_rates') && ($this->router->fetch_method() != 'form')) {
    $this->load->view('tax_rates/index');
}
if (($this->router->fetch_class() == 'users') && ($this->router->fetch_method() == 'change_password')) {
    $this->load->view('users/change_password');
}
if (($this->router->fetch_class() == 'societes') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('societes/form');
}
if (($this->router->fetch_class() == 'users') && ($this->router->fetch_method() == 'profil')) {
    $this->load->view('users/profil');
}
if (($this->router->fetch_class() == 'mailer') && ($this->router->fetch_method() == 'invoice')) {
    $this->load->view('mailer/invoice');
}
if (($this->router->fetch_class() == 'mailer') && ($this->router->fetch_method() == 'commande')) {
    $this->load->view('mailer/commande');
}
if (($this->router->fetch_class() == 'mailer') && ($this->router->fetch_method() == 'fabrication')) {
    $this->load->view('mailer/fabrication');
}
if (($this->router->fetch_class() == 'mailer') && ($this->router->fetch_method() == 'bl')) {
    $this->load->view('mailer/bl');
}
if (($this->router->fetch_class() == 'mailer') && ($this->router->fetch_method() == 'avoir')) {
    $this->load->view('mailer/avoir');
}
if (($this->router->fetch_class() == 'users') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view') && ($this->router->fetch_method() != 'change_password') && ($this->router->fetch_method() != 'profil')) {
    $this->load->view('users/index');
}
if (($this->router->fetch_class() == 'users') && ($this->router->fetch_method() == 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('users/form');
}
if (($this->router->fetch_class() == 'users') && ($this->router->fetch_method() == 'view') && ($this->router->fetch_method() != 'form')) {
    $this->load->view('users/view');
}
if (($this->router->fetch_class() == 'commande') && ($this->router->fetch_method() == 'view') && ($this->router->fetch_method() != 'form')) {
    $this->load->view('commande/view');
}
if (($this->router->fetch_class() == 'commandeachat') && ($this->router->fetch_method() == 'view') && ($this->router->fetch_method() != 'form')) {
    $this->load->view('commandeachat/view');
}

if (($this->router->fetch_class() == 'fabrication') && ($this->router->fetch_method() == 'view') && ($this->router->fetch_method() != 'form')) {
    $this->load->view('fabrication/view');
}
if (($this->router->fetch_class() == 'bl') && ($this->router->fetch_method() == 'view') && ($this->router->fetch_method() != 'form')) {
    $this->load->view('bl/view');
}

if ($this->router->fetch_class() == 'dashboard') {
    $this->load->view('dashboard/index');
}

if ($this->router->fetch_class() == 'versions') {
    $this->load->view('versions/index');
}

if ($this->router->fetch_class() == 'activites') {
    $this->load->view('activites/index');
}
if ($this->router->fetch_class() == 'settings') {
    $this->load->view('settings/index');
}

if (($this->router->fetch_class() == 'clients') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('clients/index');
}
if (($this->router->fetch_class() == 'clients') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('clients/form');
}
if (($this->router->fetch_class() == 'clients') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('clients/view');
}

if (($this->router->fetch_class() == 'email_templates') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('email_templates/index');
}
if (($this->router->fetch_class() == 'email_templates') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('email_templates/form');
}

if (($this->router->fetch_class() == 'quotes') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('quotes/index');
}
if (($this->router->fetch_class() == 'commandeachat') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('commandeachat/index');
}
if (($this->router->fetch_class() == 'commande') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('commande/index');
}
if (($this->router->fetch_class() == 'fabrication') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('fabrication/index');
}
if (($this->router->fetch_class() == 'bl') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('bl/index');
}

if (($this->router->fetch_class() == 'tracking')) {
    $this->load->view('tracking/index');
}

if (($this->router->fetch_class() == 'quotes') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('quotes/form');
}
if (($this->router->fetch_class() == 'mailer') && ($this->router->fetch_method() == 'quote')) {
    $this->load->view('mailer/quote');
}

if (($this->router->fetch_class() == 'quotes') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('quotes/view');
}

if (($this->router->fetch_class() == 'commande') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('commande/form');
} 

if (($this->router->fetch_class() == 'commandeachat') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('commandeachat/form');
}

if (($this->router->fetch_class() == 'fabrication') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('fabrication/form');
}

if (($this->router->fetch_class() == 'bl') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('bl/form');
}

if (($this->router->fetch_class() == 'devises') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('devises/index');
}
if (($this->router->fetch_class() == 'devises') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('devises/form');

}
if (($this->router->fetch_class() == 'agenda') && ($this->router->fetch_method() == 'index')) {
    $this->load->view('depenses/agenda');
}

if (($this->router->fetch_class() == 'devises') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('devises/view');
}

if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view') && ($this->router->fetch_method() != 'avoir') && ($this->router->fetch_method() != 'indexavoir') && ($this->router->fetch_method() == 'status')) {
    $this->load->view('invoices/index');
}
if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('invoices/form');
}
if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('invoices/view');
}

if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() != 'view') && ($this->router->fetch_method() == 'viewavoir')) {
    $this->load->view('invoices/viewavoir');
}

if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'viewavoir') && ($this->router->fetch_method() == 'avoir')) {
    $this->load->view('invoices/indexavoir');
}

if (($this->router->fetch_class() == 'products') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('products/index');
}
if (($this->router->fetch_class() == 'products') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('products/form');
}
if (($this->router->fetch_class() == 'products') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('products/view');
}

if (($this->router->fetch_class() == 'depenses') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('depenses/index');
}
if (($this->router->fetch_class() == 'depenses') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('depenses/form');
}
if (($this->router->fetch_class() == 'depenses') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('depenses/view');
}

if (($this->router->fetch_class() == 'families') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('families/index');
}
if (($this->router->fetch_class() == 'families') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('families/form');
}
if (($this->router->fetch_class() == 'families') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('families/view');
}

if (($this->router->fetch_class() == 'categorie_fournisseur') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('categorie_fournisseur/index');
}
if (($this->router->fetch_class() == 'categorie_fournisseur') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('categorie_fournisseur/form');
}

if (($this->router->fetch_class() == 'categorie_fournisseur') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('categorie_fournisseur/view');
}
if (($this->router->fetch_class() == 'mark') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('mark/index');
}
if (($this->router->fetch_class() == 'mark') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('mark/form');
}
if (($this->router->fetch_class() == 'mark') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('mark/view');
}																																		 

if (($this->router->fetch_class() == 'attributs') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('attributs/index');
}
if (($this->router->fetch_class() == 'attributs') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('attributs/form');
}

if (($this->router->fetch_class() == 'attributs') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('attributs/view');
}


if (($this->router->fetch_class() == 'depot') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
     $this->load->view('depot/index');
  //  $this->load->view('settings/index');
}
if (($this->router->fetch_class() == 'depot') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('depot/form');
}

if (($this->router->fetch_class() == 'depot') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('depot/view');
}



if (($this->router->fetch_class() == 'group_option') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('group_option/index');
 // $this->load->view('settings/index');
}
if (($this->router->fetch_class() == 'group_option') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('group_option/form');
}

if (($this->router->fetch_class() == 'group_option') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('group_option/view');
}


if (($this->router->fetch_class() == 'banque') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('banque/index');
}
if (($this->router->fetch_class() == 'banque') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('banque/form');
}
if (($this->router->fetch_class() == 'banque') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('banque/view');
}

if (($this->router->fetch_class() == 'fournisseurs') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('fournisseurs/index');
}
if (($this->router->fetch_class() == 'fournisseurs') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('fournisseurs/form');
}
if (($this->router->fetch_class() == 'fournisseurs') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('fournisseurs/view');
}

if (($this->router->fetch_class() == 'payments') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
    $this->load->view('payments/index');
}
if (($this->router->fetch_class() == 'payments') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('payments/form');
}
if (($this->router->fetch_class() == 'payments') && ($this->router->fetch_method() == 'view')) {
    $this->load->view('payments/view');
}

if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'index')) {
    $this->load->view('import/index');
}
if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'form')) {
    $this->load->view('import/form');
}

if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'importClient')) {
    $this->load->view('import/importClient');
}
if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'importFactures')) {
    $this->load->view('import/importFactures');
}
if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'importProducts')) {
    $this->load->view('import/importProducts');
}

if (($this->router->fetch_class() == 'quote_rappel') && ($this->router->fetch_method() == 'corn')) {
    $this->load->view('quote_rappel/corn');
}

if ($this->session->userdata['groupes_user_id'] == 1) {

    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_annuel')) {
        $this->load->view('reports/rapport_annuel');
    }
    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_mensuel')) {
        $this->load->view('reports/rapport_mensuel');
    }
    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_clients')) {
        $this->load->view('reports/rapport_clients');
    }
    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_products')) {
        $this->load->view('reports/rapport_products');
    }
    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_commercials')) {
        $this->load->view('reports/rapport_commercials');
    }
}
?>
                    <!-- END PAGE CONTENT INNER -->
					
                </div>


            </div>
            <!-- END PAGE CONTENT -->
        </div>

        <!-- END PAGE CONTAINER -->

        <!-- BEGIN FOOTER -->
        <div class="page-footer">
			<div class="footer-wrap">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-xs-12">
							<div class="footer-links">
								<h6 class="footer-title"><?php echo lang('resources_link'); ?> :</h6>
								<ul class="link">
									<li>
										<a class="light-link" href="https://client.bison.tn/affiliates.php" target="_blank">
											<?php echo lang('affiliate_program'); ?>
										</a>
									</li>
									<li>
										<a class="light-link" href="https://client.bison.tn/knowledgebase/" target="_blank">
											<?php echo lang('learn_bison'); ?>
										</a>
									</li>
									<li>
										<a class="light-link" href="https://www.bison.tn/trouver-un-expert-comptable/" target="_blank">
											<?php echo lang('certified_accountant'); ?>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="footer-coord">
								<h2 class="title-tel"><?php echo lang('call_us'); ?></h2>
								<a class="tel-link" href="tel:00 216 74 402 493">+216 74 402 493</a>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="copy-right">
				<div class="container">
					<div style="margin-left: 0px;">
					<?php $versions = getVersionsApp();?>
					&copy; Copyright <?php echo date("Y"); ?> - Bison

					<a href="#">
						<div class="scroll-to-top" style="display: none;">
							<!--i class="icon-arrow-up"></i-->
							<span class="arrow-top">
								<i class="fas fa-chevron-up"></i>
							</span>
						</div>
					</a>
					<span id="date_heure" style="float: right;"></span>
					</div>
				<script type="text/javascript">
					window.onload = date_heure('date_heure');
				</script>
				</div>
			</div>
        </div>

        <!-- END FOOTER -->
        <!-- BEGIN JAVASCRIPTS (Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
            <script src="<?php echo base_url(); ?>assets/global/plugins/respond.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/global/plugins/excanvas.min.js"></script>
            <![endif]-->
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>-->
        <!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
        <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>-->


        <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js">
        </script>
        <script type="text/javascript"
            src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript"
            src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js">
        </script>
        <script type="text/javascript"
            src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js">
        </script>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/morris/raphael-min.js">
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery.sparkline.min.js">
        </script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->

        <script type="text/javascript"
            src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js">
        </script>
        <script type="text/javascript"
            src="<?php echo base_url(); ?>assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>

        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-notific8/jquery.notific8.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/scripts/metronic.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout3/scripts/layout.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout2/scripts/quick-sidebar.js">
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout3/scripts/demo.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout3/scripts/fontawesome-all.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/default/js/libs/bootstrap-typeahead.js">
        </script>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/default/css/jquery.datepick.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/layout3/css/flaticon-icon/font/flaticon.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/default/js/jquery.plugin.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/default/js/jquery.datepick.js"></script>
        <script src="<?php echo base_url(); ?>assets/default/js/libs/bootstrap-datepicker.js"></script>
		
        <?php if (lang('cldr') != 'en') {?>
        <script
            src="<?php echo base_url(); ?>assets/default/js/locales/bootstrap-datepicker.<?php echo lang('cldr'); ?>.js">
        </script>
        <?php }?>
        <!--       FIN  DATEPIKER-->
        <!-- END PAGE LEVEL SCRIPTS -->


<!--script type="text/javascript" src="<?php echo base_url(); ?>global/plugins/ckeditor/config.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/ckeditor/skins/moono/editor.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/ckeditor/styles.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/ckeditor/lang/fr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/ckeditor/ckeditor.js"></script-->
        <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            Demo.init(); // init demo(theme settings page)
            QuickSidebar.init(); // init quick sidebar
            //                                Index.init(); // init index page
            //                                Tasks.initDashboardWidget(); // init tash dashboard widget
			$('.close.search-span').click(function() {
   $('.search-result').hide();
     $("#insearch").val('');
});
        });
        $("#insearch").change(function(event) { 
           
        if($("#insearch").val()){
            $('.search-rot').show();
            $.post("<?php echo site_url('dashboard/ajax/getAll'); ?>", {
                selectval: $("#insearch").val(),   
            },  function(data) {
                        $(".result").find('div').css('display','none');
                        $(".result").find('br').css('display','none');
                        var response = JSON.parse(data);                         
                        $( ".result" ).append(response);
                        $('.search-rot').css('display','none');
                    /*  var response = JSON.parse(data);
                        if (response.success == '1') {

                        }*/
            });
        }else{
                $(".result").find('div').css('display','none');
                $(".result").find('br').css('display','none');
        } 
        })  
		



$('.close.search-span').click(function() {
   $('.search-result').hide();
     $("#insearch").val('');
});
$("li.dropdown.search-body").addClass("open");
  
$(document).ready(function() {
  $('.close.search-span').click(function () {
	$('.search-result').hide();
	event.stopPropagation();
     $("#insearch").val('');
});

});
        </script>
        <!-- END JAVASCRIPTS -->

        <script type="text/javascript">
						$(document).ready(function() {
							
                            $.each($('.hor-menu .nav').find('li'), function() {
                                $(this).toggleClass('active', 
                                    window.location.pathname.indexOf($(this).find('a').attr('href')) > -1);
                            });
                            $('.hor-menu .nav li a').filter(function(){
                                return this.href == location.href;
                            }).addClass('active');
				        });
				
	</script>

  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout3/css/slick/slick.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
		$('.autoplay').slick({
		  slidesToShow: 2,
		  slidesToScroll: 1,
		  autoplay: true,
		  autoplaySpeed: 2000,
		vertical: true,
		});
    });
    $('.quick_setup').click(function() {      
        $('#modal-placeholder').load('<?php echo base_url(); ?>dashboard/getrequiredfield/' +
                  Math.floor(Math.random() * 1000), {
            });
    })
    $('#modal-placeholder').load('<?php echo base_url(); ?>dashboard/get_requiredfield/' +
                  Math.floor(Math.random() * 1000), {
            });
    function closeWin() {   
        $('.search-result').hide();
        $("#insearch").val('');
    } 
	
	function hidWin1() {   
        $('.search1 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more1').hide();
    } 
	function hidWin2() {   
        $('.search2 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more2').hide();
    } 
	function hidWin3() {   
        $('.search3 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more3').hide();
    } 
	function hidWin4() {   
        $('.search4 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more4').hide();
    } 
	function hidWin5() {   
        $('.search5 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more5').hide();
    } 
	function hidWin6() {   
        $('.search6 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more6').hide();
    } 
	function hidWin7() {   
        $('.search7 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more7').hide();
    } 
	function hidWin8() {   
        $('.search8 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more8').hide();
    } 
	function hidWin9() {   
        $('.search9 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more9').hide();
    } 
	function hidWin10() {   
        $('.search10 ul.dropdown-menu.list-search li:nth-child(n+10)').css('display','block');
		$('.load-more10').hide();
    } 
	function showWin1() {   
         $('ul.dropdown-menu.list-search.list1').show();
		 $('ul.dropdown-menu.list-search.list2').hide();
		 $('ul.dropdown-menu.list-search.list3').hide();
		 $('ul.dropdown-menu.list-search.list4').hide();
		 $('ul.dropdown-menu.list-search.list5').hide();
		 $('ul.dropdown-menu.list-search.list6').hide();
		 $('ul.dropdown-menu.list-search.list7').hide();
		 $('ul.dropdown-menu.list-search.list8').hide();
		 $('ul.dropdown-menu.list-search.list9').hide();
		 $('ul.dropdown-menu.list-search.list10').hide();
		 
    } 
	function showWin2() {   
         $('ul.dropdown-menu.list-search.list2').show();
		 $('ul.dropdown-menu.list-search.list1').hide();
		 $('ul.dropdown-menu.list-search.list3').hide();
		 $('ul.dropdown-menu.list-search.list4').hide();
		 $('ul.dropdown-menu.list-search.list5').hide();
		 $('ul.dropdown-menu.list-search.list6').hide();
		 $('ul.dropdown-menu.list-search.list7').hide();
		 $('ul.dropdown-menu.list-search.list8').hide();
		 $('ul.dropdown-menu.list-search.list9').hide();
		 $('ul.dropdown-menu.list-search.list10').hide();
		 
    } 
	function showWin3() {   
          $('ul.dropdown-menu.list-search.list3').show();
		 $('ul.dropdown-menu.list-search.list2').hide();
		 $('ul.dropdown-menu.list-search.list1').hide();
		 $('ul.dropdown-menu.list-search.list4').hide();
		 $('ul.dropdown-menu.list-search.list5').hide();
		 $('ul.dropdown-menu.list-search.list6').hide();
		 $('ul.dropdown-menu.list-search.list7').hide();
		 $('ul.dropdown-menu.list-search.list8').hide();
		 $('ul.dropdown-menu.list-search.list9').hide();
		 $('ul.dropdown-menu.list-search.list10').hide();
		 
    } 
	function showWin4() {   
          $('ul.dropdown-menu.list-search.list4').show();
		 $('ul.dropdown-menu.list-search.list2').hide();
		 $('ul.dropdown-menu.list-search.list3').hide();
		 $('ul.dropdown-menu.list-search.list1').hide();
		 $('ul.dropdown-menu.list-search.list5').hide();
		 $('ul.dropdown-menu.list-search.list6').hide();
		 $('ul.dropdown-menu.list-search.list7').hide();
		 $('ul.dropdown-menu.list-search.list8').hide();
		 $('ul.dropdown-menu.list-search.list9').hide();
		 $('ul.dropdown-menu.list-search.list10').hide();
		 
    } 
	function showWin5() {   
          $('ul.dropdown-menu.list-search.list5').show();
		 $('ul.dropdown-menu.list-search.list2').hide();
		 $('ul.dropdown-menu.list-search.list3').hide();
		 $('ul.dropdown-menu.list-search.list4').hide();
		 $('ul.dropdown-menu.list-search.list1').hide();
		 $('ul.dropdown-menu.list-search.list6').hide();
		 $('ul.dropdown-menu.list-search.list7').hide();
		 $('ul.dropdown-menu.list-search.list8').hide();
		 $('ul.dropdown-menu.list-search.list9').hide();
		 $('ul.dropdown-menu.list-search.list10').hide();
		 
    } 
	function showWin6() {   
          $('ul.dropdown-menu.list-search.list6').show();
		 $('ul.dropdown-menu.list-search.list2').hide();
		 $('ul.dropdown-menu.list-search.list3').hide();
		 $('ul.dropdown-menu.list-search.list4').hide();
		 $('ul.dropdown-menu.list-search.list5').hide();
		 $('ul.dropdown-menu.list-search.list1').hide();
		 $('ul.dropdown-menu.list-search.list7').hide();
		 $('ul.dropdown-menu.list-search.list8').hide();
		 $('ul.dropdown-menu.list-search.list9').hide();
		 $('ul.dropdown-menu.list-search.list10').hide();
		 
    } 
	function showWin7() {   
          $('ul.dropdown-menu.list-search.list7').show();
		 $('ul.dropdown-menu.list-search.list2').hide();
		 $('ul.dropdown-menu.list-search.list3').hide();
		 $('ul.dropdown-menu.list-search.list4').hide();
		 $('ul.dropdown-menu.list-search.list5').hide();
		 $('ul.dropdown-menu.list-search.list6').hide();
		 $('ul.dropdown-menu.list-search.list1').hide();
		 $('ul.dropdown-menu.list-search.list8').hide();
		 $('ul.dropdown-menu.list-search.list9').hide();
		 $('ul.dropdown-menu.list-search.list10').hide();
		 
    } 
	function showWin8() {   
          $('ul.dropdown-menu.list-search.list8').show();
		 $('ul.dropdown-menu.list-search.list2').hide();
		 $('ul.dropdown-menu.list-search.list3').hide();
		 $('ul.dropdown-menu.list-search.list4').hide();
		 $('ul.dropdown-menu.list-search.list5').hide();
		 $('ul.dropdown-menu.list-search.list6').hide();
		 $('ul.dropdown-menu.list-search.list7').hide();
		 $('ul.dropdown-menu.list-search.list1').hide();
		 $('ul.dropdown-menu.list-search.list9').hide();
		 $('ul.dropdown-menu.list-search.list10').hide();
		 
    }
function showWin9() {   
          $('ul.dropdown-menu.list-search.list9').show();
		 $('ul.dropdown-menu.list-search.list2').hide();
		 $('ul.dropdown-menu.list-search.list3').hide();
		 $('ul.dropdown-menu.list-search.list4').hide();
		 $('ul.dropdown-menu.list-search.list5').hide();
		 $('ul.dropdown-menu.list-search.list6').hide();
		 $('ul.dropdown-menu.list-search.list7').hide();
		 $('ul.dropdown-menu.list-search.list8').hide();
		 $('ul.dropdown-menu.list-search.list1').hide();
		 $('ul.dropdown-menu.list-search.list10').hide();
		 
    }
function showWin10() {   
          $('ul.dropdown-menu.list-search.list10').show();
		 $('ul.dropdown-menu.list-search.list2').hide();
		 $('ul.dropdown-menu.list-search.list3').hide();
		 $('ul.dropdown-menu.list-search.list4').hide();
		 $('ul.dropdown-menu.list-search.list5').hide();
		 $('ul.dropdown-menu.list-search.list6').hide();
		 $('ul.dropdown-menu.list-search.list7').hide();
		 $('ul.dropdown-menu.list-search.list8').hide();
		 $('ul.dropdown-menu.list-search.list9').hide();
		 $('ul.dropdown-menu.list-search.list1').hide();
		 
    } 	

function togl_Function(){
	$('.nav.navbar-nav').css('display', 'block');
}
function Closemenu(){   
        $('.nav.navbar-nav').css('display', 'none');
} 	
	
  </script>
  <!--
  <button id="un-button" rel="usernoise"  type="button" class="un-left un-visible"><i class="un-button-icon-bell"></i>Feedback</button>
  -->
  <style>
  .has-error .form-control{
    border-color: #d52541;
  }
*{box-sizing:border-box;}
body{font-family: 'Open Sans', sans-serif; color:#333; font-size:14px; background-color:#dadada; padding:100px;}
.form_box{width:400px; padding:10px; background-color:white;}
input{padding:5px;  margin-bottom:5px;}
input[type="submit"]{border:none; outlin:none; background-color:#679f1b; color:white;}
.heading{background-color:#ac1219; color:white; height:40px; width:100%; line-height:40px; text-align:center;}
.shadow{
  -webkit-box-shadow: 0px 0px 17px 1px rgba(0,0,0,0.43);
-moz-box-shadow: 0px 0px 17px 1px rgba(0,0,0,0.43);
box-shadow: 0px 0px 17px 1px rgba(0,0,0,0.43);}
.pic{text-align:left; width:33%; float:left;}
.feddback{
position: fixed;
  top: 50%;
  transform: translate(-50%, -50%);
  z-index:999;
 
   
}
</style>
 
 <div class="form_box feddback" style='display:none'>
 <button class="closebtn close-feed"  type="button">×</button>
 <div class="top-feed">
  <div class="d-flex align-items-left col-row">
					<div class="bloc-photo">
						<div class="symbol-photo">
                            <?php if ($img_show == null) {?>
								<img class="img-square" src="<?php echo base_url(); ?>assets/admin/layout3/img/anonyme-user.png" >
                            <?php } else {?>
								<img class="img-square" src="<?php echo $img_show; ?>" >
                            <?php }?>
							<i class="symbol-badge bg-success"></i>
						</div>
					</div>
					<div class="bloc-text">				 
						<a href="<?php echo base_url(); ?>users/profil/<?php echo $id_user; ?>" class="link-user-item">
							<span class="symbol-text text-dark font-weight-bold"><?php echo $name_user; ?></span>
						</a>
						 <a href="<?php echo site_url('sessions/logout'); ?>" class="btn btn-md btn-light-primary font-weight-bolder deconnect-btn"><?php echo lang('deconnect'); ?>
						 </a>
					</div>
				</div>
 </div>
 <br/>
 <p class="feed-title"><?php echo lang('feed-back'); ?></p>
<div id="exTab2" class="exTab2">	
<ul class="nav nav-tabs">
			<li class="active">
        <a href="#1" data-toggle="tab"><?php echo lang('idea'); ?></a>
			</li>
			<li><a href="#2" data-toggle="tab"><?php echo lang('question'); ?></a>
			</li>
			<li><a href="#3" data-toggle="tab"><?php echo lang('probleme'); ?></a>
			</li>
		</ul>

			<div class="tab-content ">
			  <div class="tab-pane active" id="1">
          <textarea placeholder="<?php echo lang('idea'); ?>..." name="idea" class="form-control no-margin"></textarea>
				</div>
				<div class="tab-pane" id="2">
          <textarea placeholder="<?php echo lang('question'); ?>..." name="question" class="form-control no-margin"></textarea>
				</div>
        <div class="tab-pane" id="3">
         <textarea name="problem" placeholder="<?php echo lang('probleme'); ?>..." class="form-control no-margin"></textarea>
				</div>
			</div>
  </div>
  
  <input type="button" id="feed_send" value="<?php echo lang('send'); ?>">
<div id="exTab1" class="exTab1">
<div class="done-interface">
<div class="feedback-succes">
<h3><?php echo lang('succes-send');?></h3>
<i class="fa fa-check" aria-hidden="true"></i>
</div>
</div>
<input type="button" id="feed_succes" value="<?php echo lang('done'); ?>">
</div>
 </div>
</body>
<script>
$('#un-button').click(function(){
    $('.feddback').css("left", "0");
    $('#un-button').css("display", "none");
	$('#exTab1').hide();
	$('#exTab2').show();
	$('#feed_send').show();
})
$('.close-feed').click(function(){
    $('.feddback').css("left", "-400px");
    $('#un-button').css("display", "block");
})

$('#feed_send').click(function(){ 
    var idea = $("textarea[name=idea]").val();
    var question = $("textarea[name=question]").val();
    var problem = $("textarea[name=problem]").val();
            if(problem || question  || idea){
                $('#modal-placeholder').load(
                "<?php echo site_url('superadmin_connect/feedback'); ?>", {
                    idea: idea,
                    question: question,
                    problem: problem,
                }, function(data) {
                    $('#exTab1').show();
                    $('#feed_send').hide();
                    $('#exTab2').hide();
                    $("textarea[name=idea]").val('');
                    $("textarea[name=question]").val('');
                    $("textarea[name=problem]").val('');
                    $("textarea[name=idea]").parent().removeClass('has-error');
                    $("textarea[name=question]").parent().removeClass('has-error');
                    $("textarea[name=problem]").parent().removeClass('has-error');
                }
                );
            }else{
                $("textarea[name=idea]").parent().addClass('has-error');
                $("textarea[name=question]").parent().addClass('has-error');
                $("textarea[name=problem]").parent().addClass('has-error');
             
             //   $("textarea[name=idea]").css("background-color", "#FFF"); 
            }
})
$('#feed_succes').click(function(){
    $('.feddback').css("left", "-400px");
    $('#un-button').css("display", "block");
})
</script>

<!-- END BODY -->