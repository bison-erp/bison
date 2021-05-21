<!DOCTYPE html>

<html lang="en" class="no-js">

    <!-- BEGIN HEAD -->
    <head>

        <style>
            .aaa > a:focus, .aaa > a:hover{text-decoration: none;background-color: transparent;}
            .aaa  > a:focus, .aaa > a:hover{text-decoration: none;background-color: transparent !important;border-radius: 25px !important;padding: 0px !important;color: transparent;}
            .aaa  > a:focus, .aaa > a{text-decoration: none;background-color: transparent !important;border-radius: 25px !important;padding: 0px !important;color: transparent;}

        </style>
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
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="" name="description">
        <meta content="" name="author">


        <!-- FEUILLES DE STYLES ET JS ANCIENS-->
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/admin/layout3/img/favicon.png">
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script  type="text/javascript">
            $('a[href^="#"]').click(function () {
                var the_id = $(this).attr("href");
                $('html, body').animate({scrollTop: $(the_id).offset().top}, 'slow'); //return false;
            });
        </script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript">
            $(function () {
                $('.nav-tabs').tab();
                $('.tip').tooltip();
                $('body').on('focus', ".datepicker", function () {
                    $(this).datepicker({
                        autoclose: true,
                        format: '<?php echo date_format_datepicker(); ?>',
                        language: '<?php echo lang('cldr'); ?>',
                    });

                });
                $('.create-invoice').click(function () {
                    $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_create_invoice'); ?>");
                });
                $('.create-quote').click(function () {
                    // $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_create_quote'); ?>");
                });
                $('#modif_photo').click(function () {
                    user_id = $(this).data('user-id');
                    $('#modal-placeholder').load("<?php echo site_url('users/file_view'); ?>/" + user_id);
                });
                $('#btn_quote_to_invoice').click(function () {
                    quote_id = $(this).data('quote-id');
                    $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_quote_to_invoice'); ?>/" + quote_id);
                });

                $('a[id^="quote_to_invoice"]').click(function () {
                    quote_id = $(this).data('quote-id');
                    $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_quote_to_invoice'); ?>/" + quote_id);
                });
                $('#btn_copy_invoice').click(function () {
                    invoice_id = $(this).data('invoice-id');
                    $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_copy_invoice'); ?>", {invoice_id: invoice_id});
                });
                $('#btn_create_credit').click(function () {
                    invoice_id = $(this).data('invoice-id');
                    $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_create_credit'); ?>", {invoice_id: invoice_id});
                });
                $('#btn_copy_quote').click(function () {
                    quote_id = $(this).data('quote-id');
                    $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_copy_quote'); ?>", {quote_id: quote_id});
                });
                $('.client-create-invoice').click(function () {
                    $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_create_invoice'); ?>", {
                        client_name: $(this).data('client-name')
                    });
                });
                $('.client-create-quote').click(function () {
                    $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_create_quote'); ?>", {
                        client_name: $(this).data('client-name')
                    });
                });

                $(document).on('click', '.invoice-add-payment', function () {
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
            });</script>
        <script  type="text/javascript">
            $.noConflict();

            function date_heure(id)
            {
                date = new Date;
                annee = date.getFullYear();
                moi = date.getMonth();
                mois = new Array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
                j = date.getDate();
                jour = date.getDay();
                jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
                h = date.getHours();
                if (h < 10)
                {
                    h = "0" + h;
                }
                m = date.getMinutes();
                if (m < 10)
                {
                    m = "0" + m;
                }
                s = date.getSeconds();
                if (s < 10)
                {
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
        <script src="<?php echo base_url(); ?>assets/js/global.js"></script>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <link href="<?php echo base_url(); ?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css">
        <!-- END PAGE LEVEL PLUGIN STYLES -->

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/jquery-multi-select/css/multi-select.css"/>

        <!-- BEGIN PAGE STYLES -->
        <link href="<?php echo base_url(); ?>assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE STYLES -->

        <!-- BEGIN THEME STYLES -->
        <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
        <link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
        <link href="<?php echo base_url(); ?>assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/default/css/style_anis.css" rel="stylesheet" type="text/css">
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/jquery-notific8/jquery.notific8.min.css"/>


        <?php //die; ?>

    </head>

    <body  class="page-header-menu-fixed">
        <?php
        $id_user = $this->session->userdata['user_id'];
        $name_user = $this->session->userdata['user_name'];
        $group_user = $this->session->userdata['groupes_user_id'];
        ?>
        <!-- BEGIN HEADER -->
        <div class="page-header">
            <!-- BEGIN HEADER TOP -->
            <div class="page-header-top">
                <div class="container-fluid">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo" >
                        <a href="<?php echo base_url(); ?>dashboard">
                            <img style="margin-top: 19px; height: 35px;" src="<?php echo base_url(); ?>assets/admin/layout3/img/logo_erp.png" alt="logo" class="logo-default"></a>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler"></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu" >
                        <ul class="nav navbar-nav pull-right">

                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <li   class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar" style=" display:none">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-default">7</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>You have <strong>12 pending</strong> tasks</h3>
                                        <a href="javascript:;">view all</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">just now</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="fa fa-plus"></i>
                                                            -+                              </span>
                                                        New user registered. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">3 mins</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span>
                                                        Server #12 overloaded. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">10 mins</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-warning">
                                                            <i class="fa fa-bell-o"></i>
                                                        </span>
                                                        Server #2 not responding. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">14 hrs</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-info">
                                                            <i class="fa fa-bullhorn"></i>
                                                        </span>
                                                        Application error. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">2 days</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span>
                                                        Database overloaded 68%. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">3 days</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span>
                                                        A user IP blocked. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">4 days</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-warning">
                                                            <i class="fa fa-bell-o"></i>
                                                        </span>
                                                        Storage Server #4 not responding dfdfdfd. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">5 days</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-info">
                                                            <i class="fa fa-bullhorn"></i>
                                                        </span>
                                                        System Error. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">9 days</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span>
                                                        Storage server failed. </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- END NOTIFICATION DROPDOWN -->

                            <?php
                            $abonnement = abonnement();
                            $max_collaborateurs_number = isset($abonnement->nb_collaborateurs) ? $abonnement->nb_collaborateurs : 0;
                            $max_collaborateurs = $max_collaborateurs_number == "-1" ? "Illimité" : $max_collaborateurs_number;

                            $actual_collaborateurs = getNumberCollaborateur();

                            if ($max_collaborateurs_number == "-1") {
                                $ratio_collaborateurs = 1;
                                $color_collaborateurs = "#4db3a4";
                            } else if ($max_collaborateurs_number == 0) {
                                $ratio_collaborateurs = 100;
                                $color_collaborateurs = "#d9534f";
                            } else {
                                $ratio_collaborateurs = ((int) $actual_collaborateurs / (int) $max_collaborateurs) * 100;
                                if ($ratio_collaborateurs >= 50 && $ratio_collaborateurs < 80) {
                                    $color_collaborateurs = "#f0ad4e";
                                } else if ($ratio_collaborateurs >= 80) {
                                    $color_collaborateurs = "#d9534f";
                                } else {
                                    $color_collaborateurs = "#4db3a4";
                                }
                            }

                            $max_nb_factures_mois_number = isset($abonnement->nb_factures_mois) ? $abonnement->nb_factures_mois : 0;
                            $max_nb_factures_mois = $max_nb_factures_mois_number == "-1" ? "Illimité" : $max_nb_factures_mois_number;
                            $actual_nb_factures_mois = getNumberFacturesThisMonth();
                            if ($max_nb_factures_mois_number == "-1") {
                                $ratio_nb_factures_mois = 1;
                                $color_nb_factures_mois = "#4db3a4";
                            } else if ($max_nb_factures_mois_number == 0) {
                                $ratio_nb_factures_mois = 100;
                                $color_nb_factures_mois = "#d9534f";
                            } else {
                                $ratio_nb_factures_mois = ((int) $actual_nb_factures_mois / (int) $max_nb_factures_mois) * 100;
                                if ($ratio_nb_factures_mois >= 50 && $ratio_nb_factures_mois < 80) {
                                    $color_nb_factures_mois = "#f0ad4e";
                                } else if ($ratio_nb_factures_mois >= 80) {
                                    $color_nb_factures_mois = "#d9534f";
                                } else {
                                    $color_nb_factures_mois = "#4db3a4";
                                }
                            }

                            $max_nb_devis_mois_number = isset($abonnement->nb_devis_mois) ? $abonnement->nb_devis_mois : 0;
                            $max_nb_devis_mois = $max_nb_devis_mois_number == "-1" ? "Illimité" : $max_nb_devis_mois_number;
                            $actual_nb_devis_mois = getNumberDevisThisMonth();
                            if ($max_nb_devis_mois_number == "-1") {
                                $ratio_nb_devis_mois = 1;
                                $color_nb_devis_mois = "#4db3a4";
                            } else if ($max_nb_devis_mois_number == 0) {
                                $ratio_nb_devis_mois = 100;
                                $color_nb_devis_mois = "#d9534f";
                            } else {
                                $ratio_nb_devis_mois = ((int) $actual_nb_devis_mois / (int) $max_nb_devis_mois) * 100;
                                if ($ratio_nb_devis_mois >= 50 && $ratio_nb_devis_mois < 80) {
                                    $color_nb_devis_mois = "#f0ad4e";
                                } else if ($ratio_nb_devis_mois >= 80) {
                                    $color_nb_devis_mois = "#d9534f";
                                } else {
                                    $color_nb_devis_mois = "#4db3a4";
                                }
                            }
                            ?>




                            <li class="dropdown dropdown-extended dropdown-dark dropdown-tasks" id="header_task_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
<!--                                    <span class="badge badge-default">3</span>-->
                                </a>
                                <ul class="dropdown-menu extended tasks">
                                    <li class="external">
                                        <h3>Votre pack est <strong><?php echo $abonnement->pack_name; ?></strong></h3>

                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 380px;" data-handle-color="#637283">
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Nombre de collaborateurs </span>
                                                        <span class="percent" style="color:<?php echo $color_collaborateurs; ?>"><?php echo $actual_collaborateurs . "/" . $max_collaborateurs; ?></span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: <?php echo $ratio_collaborateurs; ?>%;  background-color:<?php echo $color_collaborateurs; ?>" class="progress-bar progress-bar-success" aria-valuenow="<?php echo $ratio_collaborateurs; ?>" aria-valuemin="0" aria-valuemax="100"><span class="sr-only"></span></span>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Nombre de factures par mois</span>
                                                        <span class="percent" style="color:<?php echo $color_nb_factures_mois; ?>"><?php echo $actual_nb_factures_mois . "/" . $max_nb_factures_mois; ?></span>
                                                    </span>
                                                    <span class="progress alert-danger">
                                                        <span style="width: <?php echo $ratio_nb_factures_mois; ?>%;  background-color:<?php echo $color_nb_factures_mois; ?>" class="progress-bar progress-bar-success" aria-valuenow="<?php echo $ratio_nb_factures_mois; ?>" aria-valuemin="0" aria-valuemax="100"><span class="sr-only"></span></span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Nombre de devis par mois</span>
                                                        <span class="percent" style="color:<?php echo $color_nb_devis_mois; ?>"><?php echo $actual_nb_devis_mois . "/" . $max_nb_devis_mois; ?></span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: <?php echo $ratio_nb_devis_mois; ?>%;  background-color:<?php echo $color_nb_devis_mois; ?>" class="progress-bar progress-bar-success" aria-valuenow="<?php echo $ratio_nb_devis_mois; ?>" aria-valuemin="0" aria-valuemax="100"><span class="sr-only"></span></span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Documents multi-devises</span>
                                                        <span class="percent"><?php echo $abonnement->multi_devises ? 'Oui' : '<color style="color:#c23f44">Non</color>'; ?></span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Export PDF par lot</span>
                                                        <span class="percent"><?php echo $abonnement->export_lot_pdf ? 'Oui' : '<color style="color:#c23f44">Non</color>'; ?></span>
                                                    </span>
                                                </a>
                                            </li>                                            
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Export de données (Excel)</span>
                                                        <span class="percent"><?php echo $abonnement->export_excel ? 'Oui' : '<color style="color:#c23f44">Non</color>'; ?></span>
                                                    </span>
                                                </a>
                                            </li>


                                        </ul>
                                    </li>
                                </ul>
                            </li>














                            <!-- BEGIN setting PANEL -->
                            <?php //print_r($this->session->userdata['groupes_user_id']);      ?>
                            <li class="dropdown dropdown-extended dropdown-dark dropdown-inbox" id="header_inbox_bar" style="    margin-left: -19px;
    margin-right: 12px;">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="fa fa-cogs"></i>

                                </a>
                                <ul class="dropdown-menu dropdown-menu-default" style="width: 180px;">
                                    <li class="external">
                                        <h3><?php echo lang('settings'); ?></h3>

                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 115px;" data-handle-color="#637283">
                                            <?php if ($this->session->userdata['groupes_user_id'] == 1) { ?>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>settings" style="padding: 8px 14px !important">
                                                        <i class="icon-settings"></i>
                                                        <span class="from">Param&egrave;tres g&eacute;n&eacute;raux</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>import" style="padding: 8px 14px !important">
                                                        <i class="icon-settings"></i>
                                                        <span class="from">Importer des données</span>
                                                    </a>
                                                </li>
                                            <?php } ?>

                                            <li>
                                                <a href="<?php echo base_url(); ?>email_templates/index" style="padding: 8px 14px  !important">
                                                    <i class="fa fa-send-o"></i>
                                                    <span class="from">Mod&egrave;les des emails</span>
                                                </a>
                                            </li> 
                                            <?php if ($this->session->userdata['groupes_user_id'] == 1 && 1 == 0) { ?>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>users/index" style="padding: 8px 14px  !important">
                                                        <i class="fa fa-users "></i>
                                                        <span class="from">
                                                            <?php echo lang('user_accounts'); ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li style=" display:none">
                                                <a href="<?php echo base_url(); ?>tax_rates/index" style="padding: 8px 14px  !important">
                                                    <i class="fa fa-money "></i>
                                                    <span class="from">
                                                        <?php echo lang('tax_rates'); ?></span>
                                                </a>
                                            </li>


                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="droddown dropdown-separator">
                                <span class="separator" style="margin-right: 10px;"></span>
                            </li>
                            <!-- END setting PANEL -->
                            <!-- BEGIN INBOX DROPDOWN -->

<?php 
$this->db->where('user_id',$id_user);
$curr_user = $this->db->get('ip_users')->result();
$img_avatar = $curr_user[0]->user_avatar;
$img_show = NULL;
$path = base_url() . 'uploads/' . strtolower($this->session->userdata('licence')) . '/photos_users/';

    if ($img_avatar != "") {
        $statut = getHTTPStatus($path . $img_avatar);
        if ($statut['http_code'] == 200) {
            $img_show = $path . $img_avatar;
        }
    }




?>

                            <!-- END INBOX DROPDOWN -->
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="dropdown dropdown-user dropdown-dark" style="margin-top:12px">
                                <?php if($img_show == NULL){ ?>
                                <div align="center"  class="img-circle" style="width: 25px; height:25px;line-height:25px;background:#596572;padding: 0px; "><i class="fa fa-user" style="color:#C1CCD1; "></i> </div>
                                <?php }else{ ?>
                                  <img class="img-circle"  src="<?php echo $img_show; ?>" style="width: 25px; height:25px;line-height:25px;  padding: 0px;  background-color: #fff;  border: 1px solid #ddd;">

                                <?php } ?>
 <!--<img  style="width: 25px;  margin:4px; border:#DDD solid 1px;"alt="" class="img-circle" src="<?php echo $img_show; ?>">-->
                            </li>
                            <li class="dropdown dropdown-user dropdown-dark">

                                <a href="<?php echo base_url(); ?>users/profil/<?php echo $id_user; ?>" class="dropdown-toggle"  data-hover="dropdown" data-close-others="true">

                                    <div class="col-md-3 col-sm-4" style="color: #A0A7AA; width: 100%; padding: 2px 10px 1px 0px;">
                                        <!--i class="glyphicon glyphicon-user" style="color: #A0A7AA; padding: 0px 21px 0px 6px; "></i--> <?php echo $name_user; ?>
                                    </div>
                                </a>

                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="aaa dropdown dropdown-extended quick-sidebar-toggler" >
                                <a href="<?php echo site_url('sessions/logout'); ?>">
                                    <i style="color: #C1CCD1;font-size: 19px;" class="icon-logout"></i></a>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
            </div>
            <!-- END HEADER TOP -->
            <!-- BEGIN HEADER MENU -->
            <div class="page-header-menu" >
                <div class="container-fluid" style=" width: 100%">
                    <!-- BEGIN HEADER SEARCH BOX -->
                    <form class="search-form" action="extra_search.html" method="GET" style="display:none">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="query">
                            <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                            </span>
                        </div>
                    </form>
                    <!-- END HEADER SEARCH BOX -->
                    <!-- BEGIN MEGA MENU -->
                    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                    <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                    <div class="hor-menu ">
                        <ul class="nav navbar-nav">
                            <li><?php echo anchor('dashboard', lang('dashboard'), 'class="hidden-sm"') ?>
                                <?php echo anchor('dashboard', '<i> class="fa fa-dashboard"></i>', 'class="visible-sm-inline-block"') ?>
                            </li>

                            <!--menu contact-->
                            <!-- rebrique client: selon les droit données -->
                            <?php
                            $sess_cont_add = $this->session->userdata['cont_add'];
                            $sess_cont_del = $this->session->userdata['cont_del'];
                            $sess_cont_index = $this->session->userdata['cont_index'];
                            if (($sess_cont_add == 1) || ($sess_cont_del == 1) || ($sess_cont_index == 1)) {
                                ?>
                                <li class="menu-dropdown mega-menu-dropdown ">
                                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                                        <?php echo lang('clients'); ?> <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" >
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <ul class="mega-menu-submenu" style=" width:180px">
                                                            <?php if ($sess_cont_add == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>clients/form" class="iconify">
                                                                        <i class="icon-pencil"></i>
                                                                        <?php echo lang('add_client'); ?> </a>
                                                                </li><?php } ?> 
                                                            <?php if ($sess_cont_index == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>clients/index" class="iconify">
                                                                        <i class="icon-list"></i>
                                                                        <?php echo lang('view_clients'); ?> </a>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php }
                            ?>
                            <!--fin menu contact-->

                            <!--menu devis-->
                            <?php
//rebrique devi: selon les droit données
                            $sess_devis_add = $this->session->userdata['devis_add'];
                            $sess_devis_del = $this->session->userdata['devis_del'];
                            $sess_devis_index = $this->session->userdata['devis_index'];
                            if (($sess_devis_add == 1) || ($sess_devis_del == 1) || ($sess_devis_index == 1)) {
                                ?>                                
                                <li class="menu-dropdown mega-menu-dropdown ">
                                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                                        <?php echo lang('quotes'); ?> <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" >
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <ul class="mega-menu-submenu" style=" width:180px">
                                                            <?php if ($sess_devis_add == 1) { ?>
                                                                <li>
                                                                    <a <?php if (!rightsAddDevis()) echo "style='pointer-events: none;  cursor: default;'"; ?> href="<?php echo base_url(); ?>quotes/form"  class="iconify">
                                                                        <i class="icon-pencil"></i>
                                                                        <?php echo lang('create_quote'); ?> </a>
                                                                </li><?php } ?> 
                                                            <?php if ($sess_devis_index == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>quotes/index" class="iconify">
                                                                        <i class="icon-list"></i>
                                                                        <?php echo lang('view_quotes'); ?> </a>
                                                                </li>
                                                            <?php } ?>
                                                            <li style=" display:none">
                                                                <a href="<?php echo base_url(); ?>quote_rappel/corn" class="iconify">
                                                                    <i class="icon-envelope"></i>
                                                                    <?php echo lang('rappel_auj'); ?> </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!-- finmenu devis-->

                            <!--menu facture-->
                            <?php
//rebrique facture: selon les droit données
                            $sess_facture_add = $this->session->userdata['facture_add'];
                            $sess_facture_del = $this->session->userdata['facture_del'];
                            $sess_facture_index = $this->session->userdata['facture_index'];
                            if (($sess_facture_add == 1) || ($sess_facture_del == 1) || ($sess_facture_index == 1)) {
                                ?>
                                <li class="menu-dropdown mega-menu-dropdown ">
                                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                                        <?php echo lang('invoices'); ?> <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" >
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <ul class="mega-menu-submenu" style=" width:180px">
                                                            <?php if ($sess_facture_add == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>invoices/form" class="iconify" <?php
                                                                    if (rightsAddFacture())
                                                                        echo "";
                                                                    else
                                                                        echo "style='pointer-events: none;  cursor: default;'";
                                                                    ?>>
                                                                        <i class="icon-pencil"></i>
                                                                        <?php echo lang('create_invoice'); ?>  
                                                                    </a>
                                                                </li><?php } ?> 
                                                            <?php if ($sess_facture_index == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>invoices/index" class="iconify">
                                                                        <i class="icon-list"></i>
                                                                        <?php echo lang('view_invoices'); ?> </a>
                                                                </li>
                                                            <?php } ?>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!-- finmenu facture-->



                            <!--menu produit-->
                            <?php
//rebrique produit: selon les droit données
                            $sess_product_add = $this->session->userdata['product_add'];
                            $sess_product_del = $this->session->userdata['product_del'];
                            $sess_product_index = $this->session->userdata['product_index'];
                            if (($sess_product_add == 1) || ($sess_product_del == 1) || ($sess_product_index == 1)) {
                                ?>
                                <li class="menu-dropdown mega-menu-dropdown ">
                                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                                        <?php echo lang('products'); ?> <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" >
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <ul class="mega-menu-submenu" style=" width:180px">
                                                            <?php if ($sess_product_add == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>products/form" class="iconify">
                                                                        <i class="icon-pencil"></i>
                                                                        <?php echo lang('create_product'); ?> </a>
                                                                </li><?php } ?> 
                                                            <?php if ($sess_product_index == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>products/index" class="iconify">
                                                                        <i class="icon-list"></i>
                                                                        <?php echo lang('view_products'); ?> </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($sess_product_add == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>families/index" class="iconify">
                                                                        <i class="icon-list"></i>
                                                                        <?php echo lang('product_families'); ?> </a>
                                                                </li><?php } ?>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                       
                                    </ul>
                                    
                           
                                </li>
                                
                            <?php } ?>
                            <!-- fin menu produit-->  


                            <!--menu fournisseur-->
                            <?php
//rebrique fournisseur: selon les droit données
                            $sess_fournisseur_add = $this->session->userdata['fournisseur_add'];
                            $sess_fournisseur_del = $this->session->userdata['fournisseur_del'];
                            $sess_fournisseur_index = $this->session->userdata['fournisseur_index'];
                            if ((($sess_fournisseur_add == 1) || ($sess_fournisseur_del == 1) || ($sess_fournisseur_index == 1))) {
                                ?>
                                <li class="menu-dropdown mega-menu-dropdown ">
                                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                                        <?php echo lang('Fournisseurs'); ?> <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" >
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <ul class="mega-menu-submenu" style=" width:180px">
                                                            <?php if ($sess_fournisseur_add == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>fournisseurs/form" class="iconify">
                                                                        <i class="icon-pencil"></i>
                                                                        <?php echo lang('create_fournisseur'); ?> </a>
                                                                </li><?php } ?> 
                                                            <?php if ($sess_fournisseur_index == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>fournisseurs/index" class="iconify">
                                                                        <i class="icon-list"></i>
                                                                        <?php echo lang('view_fournisseurs'); ?> </a>
                                                                </li>
                                                            <?php } ?>
                                                            <li>
                                                                    <a href="<?php echo base_url(); ?>categorie_fournisseur/index" class="iconify">
                                                                        <i class="icon-list"></i>
                                                                        <?php echo lang('view_categorie'); ?> </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!-- fin menu fournisseur-->  


                            <!--menu payement-->
                            <?php
//rebrique payement: selon les droit données
                            $sess_payement_add = $this->session->userdata['payement_add'];
                            $sess_payement_del = $this->session->userdata['payement_del'];
                            $sess_payement_index = $this->session->userdata['payement_index'];
                            if (($sess_payement_add == 1) || ($sess_payement_del == 1) || ($sess_payement_index == 1)) {
                                ?>
                                <li class="menu-dropdown mega-menu-dropdown ">
                                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                                        <?php echo lang('payments'); ?> <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" >
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <ul class="mega-menu-submenu" style=" width:200px">
                                                            <?php if ($sess_payement_add == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>payments/form" class="iconify">
                                                                        <i class="icon-pencil"></i>
                                                                        <?php echo lang('enter_payment'); ?> </a>
                                                                </li><?php } ?> 
                                                            <?php if ($sess_payement_index == 1) { ?>
                                                                <li>
                                                                    <a href="<?php echo base_url(); ?>payments/index" class="iconify">
                                                                        <i class="icon-list"></i>
                                                                        <?php echo lang('view_payments'); ?> </a>
                                                                </li>
                                                            <?php } ?>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!-- fin menu payement--> 


                            <!--menu report-->
                            <?php
//rebrique report: selon les droit données
                            $sess_report_add = $this->session->userdata['report_add'];
                            $sess_report_del = $this->session->userdata['report_del'];
                            $sess_report_index = $this->session->userdata['report_index'];
                            if (($sess_report_add == 1) || ($sess_report_del == 1) || ($sess_report_index == 1)) {
                                ?>
                                <li class="menu-dropdown mega-menu-dropdown ">
                                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                                        <?php echo lang('reports'); ?> <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" >
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <ul class="mega-menu-submenu" style=" width:220px">
                                                            <li>
                                                                <a href="<?php echo base_url(); ?>reports/rapport_annuel" class="iconify">
                                                                    <i class="icon-bar-chart"></i> Rapports Annuel</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url(); ?>reports/rapport_mensuel" class="iconify">
                                                                    <i class="icon-speedometer"></i> Rapports Mensuel</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url(); ?>reports/rapport_clients" class="iconify">
                                                                    <i class="fa fa-user"></i> Rapports Clients</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url(); ?>reports/rapport_products" class="iconify">
                                                                    <i class="icon-credit-card"></i> Rapports Produits</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url(); ?>reports/rapport_commercials" class="iconify">
                                                                    <i class="icon-users"></i> Rapports Commercials</a>
                                                            </li>
                                                            <?php if(relanceautomatique()){?>
                                                            <li>
                                                                <a href="<?php echo base_url(); ?>tracking" class="iconify">
                                                                    <i class="glyphicon glyphicon-envelope"></i> Statistiques des Relances</a>
                                                            </li>   
                                                            <?php }?>                                                       
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!--fin menu rapport-->                            
                        </ul>
                    </div>
                    <!-- END MEGA MENU -->
                    <!-- Menu date-->
                    <br><div style=" color: #bcc2cb; text-align: right;margin-top: -2px;" >
                        <span id="date_heure" style="text-align: right; width: 100%" ></span>
                        <script type="text/javascript">window.onload = date_heure('date_heure');</script>
                        <!-- fin menu date-->
                    </div></div>

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
                                <a href="<?php echo base_url(); ?>dashboard"><?php echo lang('home'); ?></a><i class="fa fa-circle"></i>
                            </li>
                            <?php if (( $this->router->fetch_method() != 'index') && ($this->router->fetch_method() != 'status' ) && ( $this->router->fetch_method() != '')) { ?>
                                <li class="active">
                                    <?php if ($this->router->fetch_class() == 'dashboard') echo lang('dashboard'); ?>
                                    <?php if ($this->router->fetch_class() == 'versions') echo lang('versions'); ?>
                                    <?php if ($this->router->fetch_class() == 'clients') { ?><a href="<?php echo base_url(); ?>clients"><?php echo lang('clients'); ?></a><?php } ?>
                                    <?php if ($this->router->fetch_class() == 'settings') echo lang('settings'); ?>
                                    <?php if ($this->router->fetch_class() == 'tax_rates') {
                                        ?><a href="<?php echo base_url(); ?>settings"> <?php echo lang('settings'); ?></a><?php } ?>
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
                                    if ($this->router->fetch_class() == 'email_templates'){
                                         ?><a href="<?php echo base_url(); ?>email_templates"> Modèles des emails</a><?php
                                    }
                                    if ($this->router->fetch_class() == 'quotes') {
                                        ?><a href="<?php echo base_url(); ?>quotes"> <?php echo lang('quotes'); ?></a><?php
                                    }
                                  

                                    if ($this->router->fetch_class() == 'devises') {
                                        ?><a href="<?php echo base_url(); ?>settings"> <?php echo lang('settings'); ?></a> <?php
                                    }

                                    if ($this->router->fetch_class() == 'invoices') {
                                        ?><a href="<?php echo base_url(); ?>invoices"> <?php echo lang('invoices'); ?></a><?php
                                    }

                                    if ($this->router->fetch_class() == 'products') {
                                        ?><a href="<?php echo base_url(); ?>products"> <?php echo lang('products'); ?></a><?php
                                    }

                                    if ($this->router->fetch_class() == 'families') {
                                        ?><a href="<?php echo base_url(); ?>families"> <?php echo lang('product_families'); ?></a><?php
                                    }
                                    if ($this->router->fetch_class() == 'categorie_fournisseur') {
                                        ?><a href="<?php echo base_url(); ?>categorie_fournisseur"> <?php echo lang('view_categorie'); ?></a><?php
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
                                    if ($this->router->fetch_class() == 'groupes_users')
                                        echo lang('groupes_users');


                                    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_annuel'))
                                        echo "Rapports Annuel";
                                    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_mensuel'))
                                        echo "Rapports Mensuel";
                                    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_clients'))
                                        echo "Rapports Clients";
                                    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_products'))
                                        echo "Rapports Produits";
                                    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'rapport_commercials'))
                                        echo "Rapports Commercials";

                                    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'importClient'))
                                        echo "<i class='fa fa-circle'></i>&nbsp;Importer clients";


                                    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'importFactures'))
                                        echo "<i class='fa fa-circle'></i>&nbsp;Importer Factures";

                                    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'importProducts'))
                                        echo "<i class='fa fa-circle'></i>&nbsp;Importer Products";

//                                    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'form'))
//                                        echo lang('import')."AAA";
                                    if (($this->router->fetch_class() == 'import') && ($this->router->fetch_method() == 'view'))
                                        echo "Modifier fichier";
                                    ?>
                                </li>                    
                            <?php } else { ?>
                                <li class="active">
                                    <?php if ($this->router->fetch_class() == 'dashboard') echo lang('dashboard'); ?>
                                    <?php if ($this->router->fetch_class() == 'versions') echo 'Versions'; ?>
                                    <?php if ($this->router->fetch_class() == 'clients') echo lang('clients'); ?>
                                    <?php if ($this->router->fetch_class() == 'settings') echo lang('settings'); ?>
                                    <?php if ($this->router->fetch_class() == 'tax_rates') echo lang('settings'); ?>
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
                                    if ($this->router->fetch_class() == 'email_templates')
                                        echo "Mod&egrave;les des emails";
                                    if ($this->router->fetch_class() == 'quotes')
                                        echo lang('quotes');                                       
                                    if ($this->router->fetch_class() == 'tracking')  
                                        echo 'tracking'; 
                                   if ($this->router->fetch_class() == 'categorie_fournisseur')  
                                        echo 'catégorie';                                      
                                    if ($this->router->fetch_class() == 'devises')
                                        echo lang('devise');
                                    if ($this->router->fetch_class() == 'invoices')
                                        echo lang('invoices');
                                    if ($this->router->fetch_class() == 'products')
                                        echo lang('products');
                                    if ($this->router->fetch_class() == 'families')
                                        echo lang('product_families');                                        
                                    if ($this->router->fetch_class() == 'fournisseurs')
                                        echo lang('Fournisseurs');
                                    if ($this->router->fetch_class() == 'payments')
                                        echo lang('payments');
                                    if ($this->router->fetch_class() == 'societes')
                                        echo lang('societes');
                                    if ($this->router->fetch_class() == 'groupes_users')
                                        echo lang('groupes_users');
                                    if ($this->router->fetch_class() == 'import')
                                        echo 'Import des données';


                                    if (($this->router->fetch_class() == 'quote_rappel') && ($this->router->fetch_method() == 'corn'))
                                        echo lang('rappel_auj');
                                    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'invoice_aging'))
                                        echo lang('invoice_aging');
                                    if (($this->router->fetch_class() == 'quote_rappel') && ($this->router->fetch_method() == 'historique_relances'))
                                        echo lang('historique_relances');
                                    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'payment_history'))
                                        echo lang('payment_history');
                                    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'sales_by_client'))
                                        echo lang('sales_by_client');
                                    if (($this->router->fetch_class() == 'reports') && ($this->router->fetch_method() == 'sales_by_year'))
                                        echo lang('sales_by_date');
                                    ?>
                                </li>
                            <?php } ?>
                            <li class="active">

                                <?php if ($this->router->fetch_method() == 'view') {
                                    ?><i class="fa fa-circle"></i>&nbsp;&nbsp;<?php
                                    if ($this->router->fetch_class() == 'quotes')
                                        echo lang('edit_quote');
                                    if ($this->router->fetch_class() == 'invoices')
                                        echo lang('modif-facture');
                                }

                                if (($this->router->fetch_method() == 'quote') && ($this->router->fetch_class() == 'mailer')) {
                                    echo lang('email_quote');
                                }

                                if (($this->router->fetch_method() == 'invoice') && ($this->router->fetch_class() == 'mailer')) {
                                    echo lang('email_invoice');
                                }
                                if (($this->router->fetch_class() == 'clients') && ($this->router->fetch_method() == 'view')) {
                                    echo lang('view_clien');
                                }

                                if ($this->router->fetch_method() == 'form') {
                                    ?><i class="fa fa-circle"></i>&nbsp;&nbsp;<?php
                                    if ($this->router->fetch_class() == 'clients')
                                        echo lang('add_clients');
                                    if ($this->router->fetch_class() == 'groupes_users')
                                        echo lang('add_groupe_user');
                                    if ($this->router->fetch_class() == 'quotes')
                                        echo lang('create_quote');

                                    if ($this->router->fetch_class() == 'devises')
                                        echo lang('add_devise');

                                    if ($this->router->fetch_class() == 'invoices')
                                        echo lang('create_invoice');

                                    if ($this->router->fetch_class() == 'families')
                                        echo lang('add_product_families');
                                    if ($this->router->fetch_class() == 'categorie_fournisseur')
                                        echo lang('add_categorie_fournisseur');
                                    if ($this->router->fetch_class() == 'products')
                                        echo lang('create_product');


                                    if ($this->router->fetch_class() == 'fournisseurs')
                                        echo lang('create_fournisseur');


                                    if ($this->router->fetch_class() == 'payments')
                                        echo lang('enter_payment');

                                    if ($this->router->fetch_class() == 'societes')
                                        echo lang('societes_settings');


                                    if ($this->router->fetch_class() == 'email_templates')
                                        echo lang('email_template_form');
                                    if ($this->router->fetch_class() == 'users')
                                        echo lang('user_form');

                                    if ($this->router->fetch_class() == 'tax_rates')
                                        echo lang('tax_rate_form');

                                    if ($this->router->fetch_class() == 'import')
                                        echo "Ajouter Fichiers";
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
                        if (($this->router->fetch_class() == 'users') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view') && ($this->router->fetch_method() != 'change_password') && ($this->router->fetch_method() != 'profil')) {
                            $this->load->view('users/index');
                        }
                        if (($this->router->fetch_class() == 'users') && ($this->router->fetch_method() == 'form') && ($this->router->fetch_method() != 'view')) {
                            $this->load->view('users/form');
                        }
                        if (($this->router->fetch_class() == 'users') && ($this->router->fetch_method() == 'view') && ($this->router->fetch_method() != 'form')) {
                            $this->load->view('users/view');
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

                        if (($this->router->fetch_class() == 'devises') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
                            $this->load->view('devises/index');
                        }
                        if (($this->router->fetch_class() == 'devises') && ($this->router->fetch_method() == 'form')) {
                            $this->load->view('devises/form');
                        }
                        if (($this->router->fetch_class() == 'devises') && ($this->router->fetch_method() == 'view')) {
                            $this->load->view('devises/view');
                        }

                        if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() != 'form') && ($this->router->fetch_method() != 'view')) {
                            $this->load->view('invoices/index');
                        }
                        if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() == 'form')) {
                            $this->load->view('invoices/form');
                        }
                        if (($this->router->fetch_class() == 'invoices') && ($this->router->fetch_method() == 'view')) {
                            $this->load->view('invoices/view');
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
                <div class="container" style="margin-left: 16px;">
<?php $versions = getVersionsApp(); ?>
                    &copy; Copyright <?php echo date("Y"); ?> - Bison ERP (<a href="<?php echo base_url(); ?>versions">Version <?php echo $versions[0]->version; ?></a>).
                    
                    <a href="#"><div class="scroll-to-top" style="display: none;">
                            <i class="icon-arrow-up"></i>
                        </div></a> </div>

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


            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js"></script>
            <script type="text/javascript"  src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
            <script type="text/javascript"  src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" ></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" ></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" ></script>

            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/morris/raphael-min.js" ></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery.sparkline.min.js"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->

            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>

            <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-notific8/jquery.notific8.min.js"></script>
            
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" ></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout3/scripts/layout.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout2/scripts/quick-sidebar.js" ></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/layout3/scripts/demo.js" ></script>

            <script type="text/javascript" src="<?php echo base_url(); ?>assets/default/js/libs/bootstrap-typeahead.js"></script>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/default/css/jquery.datepick.css"> 
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/default/js/jquery.plugin.js"></script> 
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/default/js/jquery.datepick.js"></script>
            <script src="<?php echo base_url(); ?>assets/default/js/libs/bootstrap-datepicker.js"></script>
            <?php if (lang('cldr') != 'en') { ?>
                <script
                src="<?php echo base_url(); ?>assets/default/js/locales/bootstrap-datepicker.<?php echo lang('cldr'); ?>.js"></script>
            <?php } ?>
            <!--       FIN  DATEPIKER-->
            <!-- END PAGE LEVEL SCRIPTS -->


            <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core componets
                Layout.init(); // init layout
                Demo.init(); // init demo(theme settings page)
                QuickSidebar.init(); // init quick sidebar
//                                Index.init(); // init index page
//                                Tasks.initDashboardWidget(); // init tash dashboard widget
            });           
            </script>
            <!-- END JAVASCRIPTS -->

    </body>
    <!-- END BODY -->
