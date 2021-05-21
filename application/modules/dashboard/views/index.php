<style>

    .font-lg {
        font-size: 16px;
    }
    .absolute{
        position:absolute;
    }
    .log_success{color:#468847}
    .log_warning{color:#F89406}
    .log_danger{color:#B94A48}
    .feeds li:hover{
        background:#F5F5FE;
    }
</style>

<!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/global/plugins/morris/examples/lib/example.css">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/global/plugins/morris/morris.css">
<div id="headerbar-index"></div>
<div id="content">
    <?php //echo $this->layout->load_view('layout/alerts'); ?>
<?php  
    // echo phpinfo();
$db = $this->load->database('default');
$this->load->model('groupes_users/mdl_groupes_users');
$this->load->model('users/mdl_users');
?>
    <div class="row <?php
    if ($this->mdl_settings->setting('disable_quickactions') == 1) {
        echo 'hidden';
    }
    ?>">
             <?php //echo '<pre>';print_r(('BASEPATH'));echo '</pre>';?>

        <div class="col-xs-12">
            <?php
            $sess_cont_add = $this->session->userdata['cont_add'];
            $sess_cont_del = $this->session->userdata['cont_del'];
            $sess_cont_index = $this->session->userdata['cont_index'];

            $sess_devis_add = $this->session->userdata['devis_add'];
            $sess_devis_del = $this->session->userdata['devis_del'];
            $sess_devis_index = $this->session->userdata['devis_index'];

            $sess_facture_add = $this->session->userdata['facture_add'];
            $sess_facture_del = $this->session->userdata['facture_del'];
            $sess_facture_index = $this->session->userdata['facture_index'];

            $sess_payement_add = $this->session->userdata['payement_add'];
            $sess_payement_del = $this->session->userdata['payement_del'];
            $sess_payement_index = $this->session->userdata['payement_index'];
            ?>

        </div>
    </div>
    <div class="row">

        <div class="col-lg-6 col-sm-12">
            <!-- BEGIN PORTLET-->
			<div class=" table-responsive">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption caption-md">
                        <i class="icon-bar-chart theme-font hide"></i>
                        <span class="caption-subject theme-font bold uppercase"><?php echo lang('revenus'); ?></span>
                        <span class="caption-helper hide">weekly stats...</span>
                    </div>

                </div>
                <div class ="tabs-nav" style="margin-top: -45px;height: 45px;display: inline-block;float: right;position: relative;z-index: 2;" >
                    <ul class="nav nav-pills tab_dat">
                        <li class="active">
                            <a href="#mois" data-toggle="tab"><?php echo lang('mois'); ?></a>
                        </li>
                        <li>
                            <a href="#annee" data-toggle="tab"><?php echo lang('this_year'); ?></a>
                        </li> 
                        <li>
                            <select class="form-control input-sm" id="selected_devise">
                                <?php foreach ($devises as $devise) { ?>
                                    <option value="<?php echo $devise->devise_id; ?>"><?php echo $devise->devise_symbole; ?></option>
                                <?php } ?>
                            </select>
                        </li>
                    </ul>
                </div>


                <div class="tab-content" style="margin-top: 17px;">
                    <div class="tab-pane fade active in" id="mois">
                        <div class="portlet-body">
                            <div class="row list-separated ">
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="font-grey-mint font-sm">
                                        <?php
                                        if ($this->session->userdata['groupes_user_id'] != 1) {
                                            echo lang('mes_contact');
                                        } else {
                                            echo "Contacts";
                                        }
                                        ?>
                                    </div>
                                    <div class="uppercase font-hg font-red-flamingo" style="font-size: 18px;">

                                        <?php echo $num_rows ?>

                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="font-grey-mint font-sm">
                                        <?php echo lang('opportunite'); ?>
                                    </div>
                                    <div class="uppercase font-hg theme-font" style="font-size: 18px;">

                                        <?php
                                        foreach ($devises as $devise) {
                                            $opp = isset($OPP_ALL[$devise->devise_id][date("Y")][date("n")]["amount"]) ? $OPP_ALL[$devise->devise_id][date("Y")][date("n")]["amount"] : 0;
                                            echo ' <span class="font-lg font-grey-mint absolute">' . format_devise($opp, $devise->devise_id) . '</span><br>';
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="font-grey-mint font-sm">
                                        <?php echo lang('mes_vent'); ?>
                                    </div>
                                    <div class="uppercase font-hg font-purple" style="font-size: 18px;">
                                        <?php
                                        foreach ($devises as $devise) {
                                            $uv = isset($UV_ALL[$devise->devise_id][date("Y")][date("n")]["amount"]) ? $UV_ALL[$devise->devise_id][date("Y")][date("n")]["amount"] : 0;
                                            echo ' <span class="font-lg font-grey-mint absolute">' . format_devise($uv, $devise->devise_id) . '</span><br>';
                                        }
                                        ?>
                                    </div>                                
                                </div>
                                <?php if ($sess_facture_index == 1) { ?>  
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <div class="font-grey-mint font-sm">
                                            <?php echo lang('ca_entrep'); ?>
                                        </div>
                                        <div class="uppercase font-hg font-blue-sharp" style="font-size: 18px;">
                                            <?php
                                            foreach ($devises as $devise) {
                                                $ca = isset($CA_ALL[$devise->devise_id][date("Y")][date("n")]["amount"]) ? $CA_ALL[$devise->devise_id][date("Y")][date("n")]["amount"] : 0;
                                                echo ' <span class="font-lg font-grey-mint absolute">' . format_devise($ca, $devise->devise_id) . '</span><br>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>


                        </div>
                        </p>
                        <div id="sales_statistics" class="portlet-body-morris-fit morris-chart" style="height: 440px"></div>
                    </div>
                    <div class="tab-pane fade" id="annee">
                        <div class="portlet-body">
                            <div class="row list-separated">
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="font-grey-mint font-sm">
                                        <?php
                                        if ($this->session->userdata['groupes_user_id'] != 1) {
                                            echo lang('mes_contact');
                                        } else {
                                            echo "Contacts";
                                        }
                                        ?>
                                    </div>
                                    <div class="uppercase font-hg font-red-flamingo" style="font-size: 18px;">
                                        <?php echo $num_rows ?>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="font-grey-mint font-sm">
                                        <?php echo lang('opportunite'); ?>
                                    </div>

                                    <div class="uppercase font-hg theme-font" style="font-size: 18px;">
                                        <?php
                                        foreach ($devises as $devise) {
                                            $opp = isset($OPP_this_year[$devise->devise_id]["amount"]) ? $OPP_this_year[$devise->devise_id]["amount"] : 0;
                                            echo ' <span class="font-lg font-grey-mint absolute">' . format_devise($opp, $devise->devise_id) . '</span><br>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="font-grey-mint font-sm">
                                        <?php echo lang('mes_vent'); ?>
                                    </div>
                                    <div class="uppercase font-hg font-purple" style="font-size: 18px;">
                                        <?php
                                        foreach ($devises as $devise) {
                                            $uv = isset($UV_this_year[$devise->devise_id]["amount"]) ? $UV_this_year[$devise->devise_id]["amount"] : 0;
                                            echo ' <span class="font-lg font-grey-mint absolute">' . format_devise($uv, $devise->devise_id) . '</span><br>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php if ($sess_facture_index == 1) { ?>    
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <div class="font-grey-mint font-sm">
                                            <?php echo lang('ca_entrep'); ?>
                                        </div>
                                        <div class="uppercase font-hg font-blue-sharp" style="font-size: 18px;">
                                            <?php
                                            foreach ($devises as $devise) {
                                                $ca = isset($CA_this_year[$devise->devise_id]["amount"]) ? $CA_this_year[$devise->devise_id]["amount"] : 0;
                                                echo ' <span class="font-lg font-grey-mint absolute">' . format_devise($ca, $devise->devise_id) . '</span><br>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        </p>
                        <div id="sales_statistics2" class="portlet-body-morris-fit morris-chart" style="height: 440px"></div>
                    </div>
                </div>
                <!-- END PORTLET-->


            </div>  </div>

        </div>
        <div class="col-lg-6 col-sm-12">
			 <!-- start feedwind code --> 
				<!--script type="text/javascript" src="https://feed.mikle.com/js/fw-loader.js" preloader-text="Loading" data-fw-param="133847/"></script--> 
				<div class="feed-dashboard">

					<?php
include_once('class.rss.php');
 
$feedlist = new rss('http://feeds.feedburner.com/erpbison');
echo $feedlist->displayFlux(15, lang('bison_events_news'));

?> 
				</div>
			 <!-- end feedwind code -->
            <!-- BEGIN PORTLET-->
			<?php if ($abonnement->pack_name == 'FREE') {?>
			<div class="portlet light bg-light-success actus-bg">
                <div class="portlet-title tabbable-line" style="border-bottom: none;min-height: auto;margin-bottom: 5px;">
                    <div class="caption caption-md">
						<span class="caption-subject theme-font normal text-bg-success"><?php echo lang('pack_free_dashboard'); ?></span>	
                    </div>
					<button type="button" class="btn btn-sm btn-warning bg-warning" data-toggle="modal" data-target="#popup-account"><?php echo lang('upgrade_pack'); ?></button>	
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_2">
                            <div class="boxs-pack" style="position: relative;">
								<div class="col-row-grid align-items-center bg-light-disabled rounded disable-box">
									<span class="btn-icon-disabled"><i class="fas fa-user-plus"></i></span>
									<div class="txt-block flex-column-txt">
										<span class="text-disabled font-size-sm"><?php echo lang('contacts_illimites'); ?></span>
									</div>
								</div>	
								<div class="col-row-grid align-items-center bg-light-disabled rounded disable-box">
									<span class="btn-icon-disabled"><i class="fas fa-boxes"></i></span>
									<div class="txt-block flex-column-txt">
										<span class="text-disabled font-size-sm"><?php echo lang('gestion_stocks_illimite'); ?></span>
									</div>
								</div>			
								<div type="button" class="col-row-grid align-items-center bg-light-disabled rounded disable-box">
									<span class="btn-icon-disabled"><i class="fas fa-layer-group"></i></span>
									<div class="txt-block flex-column-txt">
										<span class="text-disabled font-size-sm"><?php echo lang('facture_devis_illimite'); ?></span>
									</div>
								</div>
								<div type="button" class="col-row-grid align-items-center bg-light-disabled rounded disable-box">
									<span class="btn-icon-disabled"><i class="fas fa-life-ring"></i></span>
									<div class="txt-block flex-column-txt">
										<span class="text-disabled font-size-sm"><?php echo lang('multilangues_multi_devises'); ?></span>
									</div>
								</div>	
                            </div>
                        </div> 
                    </div>
                    <!--END TABS-->
                </div>
            </div>
            <!-- END PORTLET free-->
			<?php } else { ?>
            <div class="portlet light bg-light-success actus-bg">
                <div class="portlet-title tabbable-line" style="border-bottom: none;min-height: auto;margin-bottom: 5px;">
                    <div class="caption caption-md">
									<span class="caption-subject theme-font normal text-bg-success"><?php echo lang('pack_prem_dashboard'); ?></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_2">
                            <div class="boxs-pack" style="position: relative;">
								<div class="col-row-grid align-items-center bg-light-warning rounded">
									<span class="btn-icon-warning"><i class="fas fa-user-plus"></i></span>
									<div class="txt-block flex-column-txt">
										<span class="text-warning font-size-sm"><?php echo lang('contacts_illimites'); ?></span>
									</div>
								</div>	
								<div class="col-row-grid align-items-center bg-light-primary rounded">
									<span class="btn-icon-primary"><i class="fas fa-boxes"></i></span>
									<div class="txt-block flex-column-txt">
										<span class="text-primary font-size-sm"><?php echo lang('gestion_stocks_illimite'); ?></span>
									</div>
								</div>			
								<div class="col-row-grid align-items-center bg-light-shadow rounded">
									<span class="btn-icon-shadow"><i class="fas fa-layer-group"></i></span>
									<div class="txt-block flex-column-txt">
										<span class="text-shadow font-size-sm"><?php echo lang('facture_devis_illimite'); ?></span>
									</div>
								</div>
								<div class="col-row-grid align-items-center bg-light-success rounded">
									<span class="btn-icon-success"><i class="fas fa-life-ring"></i></span>
									<div class="txt-block flex-column-txt">
										<span class="text-success font-size-sm"><?php echo lang('multilangues_multi_devises'); ?></span>
									</div>
								</div>	
                            </div>
                        </div> 
                    </div>
                    <!--END TABS-->
                </div>
            </div>
			<?php }?>
        </div>
    </div>
			<!-- modal warning -->

<!-- end modal -->
    <div class="row">

        <?php if ($sess_devis_index == 1) { ?>
            <div class="col-xs-12 col-md-6"><!-- style="height:370px;"-->
			
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase"><b><!--i class="fa fa-bar-chart fa-margin"></i--> <?php echo lang('quote_overview'); ?></b></span>
                            <span class="caption-helper hide">weekly stats...</span>
                        </div>
                        <div class="tools">
                            <?php echo lang($quote_status_period); ?>
                        </div>
                    </div>
                    <div class="portlet-body">
					<div class=" table-responsive">
                        <table  class="table table-bordered table-condensed no-margin" >
                            <tr style="font-weight: bold;">
                                <td>

                                </td>
                                <?php foreach ($devises as $devise) { ?>
                                    <td class="amount">
                                        <span>
                                            <?php echo $devise->devise_label . " (" . $devise->devise_symbole . ")"; ?>
                                        </span>
                                    </td>
                                <?php } ?>

                            </tr>
                            <?php foreach ($quote_statuses as $key => $value) { ?>
                                <tr style="font-weight: bold;">
                                    <td>
                                        <a href="<?php echo site_url($value['href']); ?>">
                                            <?php echo $value['label']; ?>
                                        </a>
                                    </td>
                                    <?php foreach ($devises as $devise) { ?>
                                        <td class="amount">
                                            <span class="<?php echo $quotes_total_amounts[$key][$devise->devise_id]['class']; ?>">
                                                <?php echo format_devise($quotes_total_amounts[$key][$devise->devise_id]['amount'], $devise->devise_id); ?>
                                            </span>
                                        </td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>
                        </table>

                    </div></div>


                </div>
				
            </div>
        <?php } ?>
        <?php if ($sess_facture_index == 1) { ?>        
            <div class="col-xs-12 col-md-6"> <!--style="height:370px;"-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase"><b><!--i class="fa fa-bar-chart fa-margin"></i--> <?php echo lang('invoice_overview'); ?></b></span>
                            <span class="caption-helper hide">weekly stats...</span>
                        </div>
                        <div class="tools">
                            <?php echo lang($invoice_status_period); ?>
                        </div>
                    </div>
                    <div class="portlet-body">
					<div class=" table-responsive">
                        <table class="table table-bordered table-condensed no-margin">
                            <tr style="font-weight: bold;">
                                <td>

                                </td>
                                <?php foreach ($devises as $devise) { ?>
                                    <td class="amount">
                                        <span>
                                            <?php echo $devise->devise_label . " (" . $devise->devise_symbole . ")"; ?>
                                        </span>
                                    </td>
                                <?php } ?>

                            </tr>
                            <?php foreach ($invoice_statuses as $key => $value) { ?>
                                <tr style="font-weight: bold;">
                                    <td>
                                        <a href="<?php echo site_url($value['href']); ?>">
                                            <?php echo $value['label']; ?>
                                        </a>
                                    </td>
                                    <?php foreach ($devises as $devise) { ?>
                                        <td class="amount">
                                            <span class="<?php echo $invoices_total_amounts[$key][$devise->devise_id]['class']; ?>">
                                                <?php echo format_devise($invoices_total_amounts[$key][$devise->devise_id]['amount'], $devise->devise_id); ?>
                                            </span>
                                        </td> 
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </table>

                    </div></div>
                </div>
            </div>
        <?php } ?>

        <?php if ($sess_devis_index == 1) { ?>
            <div class="col-xs-12 col-md-6">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase"><b><!--i class="fa fa-bar-chart fa-margin"></i--> <?php echo lang('recent_quotes'); ?></b></span>
                            <span class="caption-helper hide">weekly stats...</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-condensed no-margin">
                                <thead>
                                    <tr >
                                        <th style="font-weight: bold;"><?php echo lang('status'); ?></th>
                                        <th style="min-width: 15%; font-weight: bold;"><?php echo lang('date'); ?></th>
                                        <th style="min-width: 15%; font-weight: bold;"><?php echo lang('quote'); ?></th>
                                        <th style="min-width: 35%; font-weight: bold;"><?php echo lang('client'); ?></th>
                                        <th style="text-align: right; font-weight: bold;"><?php echo lang('balance'); ?></th>
                                        <th style="font-weight: bold;"><?php echo lang('pdf'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($quotes as $quote) { ?>
                                        <tr>
                                            <td>
                                                <span class="label
                                                      <?php echo $quote_statuses[$quote->quote_status_id]['class']; ?>">
                                                          <?php echo $quote_statuses[$quote->quote_status_id]['label']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo date_from_mysql($quote->quote_date_created); ?>
                                            </td>
                                            <td>
                                                <?php echo anchor('quotes/view/' . $quote->quote_id, $quote->quote_number); ?>
                                            </td>
                                            <td>
                                                <?php echo anchor('clients/view/' . $quote->client_id, $quote->client_name); ?>
                                            </td>
                                            <td style="text-align: right;" class="amount">

                                                <?php echo format_devise($quote->quote_total, $quote->devise_id); ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="<?php echo site_url('quotes/generate_pdf/' . $quote->quote_id); ?>"
                                                   title="<?php echo lang('download_pdf'); ?>" target="_blank">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="6" class="text-right small">
                                            <?php echo anchor('quotes/status/all', lang('view_all')); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($sess_facture_index == 1) { ?>      

            <div class="col-xs-12 col-md-6">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase"><b><!--i class="fa fa-bar-chart fa-margin"></i--> <?php echo lang('recent_invoices'); ?></b></span>
                            <span class="caption-helper hide">weekly stats...</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-condensed no-margin">
                                <thead>
                                    <tr>
                                        <th style="font-weight: bold;"><?php echo lang('status'); ?></th>
                                        <th style="min-width: 15%;font-weight: bold;"><?php echo lang('due_date'); ?></th>
                                        <th style="min-width: 15%;font-weight: bold;"><?php echo lang('invoice'); ?></th>
                                        <th style="min-width: 35%;font-weight: bold;"><?php echo lang('client'); ?></th>
                                        <th style="text-align: right;font-weight: bold;"><?php echo lang('balance'); ?></th>
                                        <th style="font-weight: bold;"> PDF</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($invoices as $invoice) {
                                        if ($this->config->item('disable_read_only') == TRUE) {
                                            $invoice->is_read_only = 0;
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <span
                                                    class="label <?php echo $invoice_statuses[$invoice->invoice_status_id]['class']; ?>">
                                                        <?php
                                                        echo $invoice_statuses[$invoice->invoice_status_id]['label'];
                                                        if ($invoice->invoice_sign == '-1') {
                                                            ?>
                                                        &nbsp;<i class="fa fa-credit-invoice"
                                                                 title="<?php echo lang('credit_invoice') ?>"></i>
                                                                 <?php
                                                             }
                                                             if ($invoice->is_read_only == 1) {
                                                                 ?>
                                                        &nbsp;<i class="fa fa-read-only"
                                                                 title="<?php echo lang('read_only') ?>"></i>
                                                             <?php }; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <?php echo date_from_mysql($invoice->invoice_date_due); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo anchor('invoices/view/' . $invoice->invoice_id, $invoice->invoice_number); ?>
                                            </td>
                                            <td>
                                                <?php echo anchor('clients/view/' . $invoice->client_id, $invoice->client_name); ?>
                                            </td>
                                            <td style="text-align: right;" class="amount">
                                                <?php echo format_devise($invoice->invoice_balance, $invoice->devise_id); ?>
                                            </td>
                                            <td  style="text-align: center;">
                                                <a href="<?php echo site_url('invoices/generate_pdf/' . $invoice->invoice_id); ?>"
                                                   title="<?php echo lang('download_pdf'); ?>" target="_blank">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="6" class="text-right small">
                                            <?php echo anchor('invoices/status/all', lang('view_all')); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<input type="hidden" id="langinv" value="<?php echo lang('invoice'); ?>">
<input type="hidden" id="langquote" value="<?php echo lang('quotes'); ?>">
<input type="hidden" id="devisaccepte" value="<?php echo lang('devis_accepte'); ?>">

<input type="hidden" id="symbole_devise" value="DT">
<input type="hidden" id="tax_rate_decimal_places" value="3">
<input type="hidden" id="currency_symbol_placement" value="after">
<input type="hidden" id="thousands_separator" value=" ">
<input type="hidden" id="decimal_point" value=".">

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>






<!-- END PAGE LEVEL PLUGINS -->

<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/charts-amcharts.js"></script>
<?php
if ($this->session->userdata['groupes_user_id'] != 1) {
    $user_id_stat = $this->session->userdata['user_id'];
} else {
    $user_id_stat = 0;
}
//$user_id_stat = 12;
?>

<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-notific8/jquery.notific8.min.js"></script>

<script>

            function updateChart() {

            $.post("<?php echo site_url('dashboard/ajax/update_chart_mensuel'); ?>", {
            current_year: 2016,
                    current_devise: current_devise,
                    user_id_stat: <?php echo $user_id_stat; ?>
            }, function (data) {
//            alert(data);
            var parsed = JSON.parse(data);
                    json_response = [];
                    for (var x in parsed) {
            json_response.push(parsed[x]);
            }
            table_stat = "";
                    devise_info = json_response[1];
                    $("#symbole_devise").val(devise_info[0]["devise_symbole"]);
                    $("#currency_symbol_placement").val(devise_info[0]["symbole_placement"]);
                    $("#tax_rate_decimal_places").val(devise_info[0]["number_decimal"]);
                    $("#thousands_separator").val(devise_info[0]["thousands_separator"]);
                    initChart();
            });
                    var initChart = function () {

                    var datachartss = json_response[0];
                            var chart = AmCharts.makeChart("sales_statistics", {
                            "type": "serial",
                                    "theme": "light",
                                    "fontFamily": 'Open Sans',
                                    "color": '#888888',
                                    "legend": {
                                    "equalWidths": false,
                                            "useGraphSettings": false,
                                            "valueAlign": "left",
                                            "valueWidth": 40,
                                            "valueText": ""
                                    },
                                    "dataProvider": datachartss,
                                    "valueAxes": [{
                                    "id": "devisAxis",
                                            "axisAlpha": 0,
                                            "gridAlpha": 0,
                                            "position": "left",
                                            "title": "",
                                            "labelFunction": function (value, valueString, axis) {
                                            return beautifyFormatWithDevice(valueString);
                                            }
                                    }, {
                                    "id": "clientsAxis",
                                            "axisAlpha": 0,
                                            "gridAlpha": 0,
                                            "labelsEnabled": false,
                                            "position": "right"
                                    }],
                                    "graphs": [
<?php if ($user_id_stat == 0) { ?>
                                        {
                                        "alphaField": "alpha",
                                                "balloonText":  $('#langinv').val()+": [[value]]",
                                                "dashLengthField": "dashLength",
                                                "fillAlphas": 0.7,
                                                //                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_invoices),
                                                //                        "legendValueText": "[[value]]",
                                                "title":  $('#langinv').val(),
                                                "type": "column",
                                                "valueField": "facture",
                                                "valueAxis": "factureAxis",
                                                "balloonFunction": function (graphDataItem, graph) {
                                                var value = graphDataItem.values.value;
                                                        return "Factures<br>" + beautifyFormatWithDevice(value);
                                                },
                                                "lineColor": "#2D59A9"
                                        },
<?php } ?>
                                    {
                                    "balloonText": "[[value]] clients",
                                            "bullet": "round",
                                            "bulletBorderAlpha": 1,
                                            "useLineColorForBulletBorder": true,
                                            "bulletColor": "#FFFFFF",
                                            "dashLengthField": "dashLength",
                                            "labelPosition": "right",
//                        "legendPeriodValueText": "Total: [[value.sum]]",
//                        "legendValueText": "[[value]] ",
                                            "title": "Clients",
                                            "fillAlphas": 0,
                                            "valueField": "clients",
                                            "valueAxis": "clientsAxis",
                                            "lineColor": "#FF9E01"
                                    },
                                    {
                                    "balloonText": $('#langquote').val()+": [[value]]",
                                            "fillAlphas": 0.8,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_quotes),
//                        "legendValueText": "[[value]]",
                                            "id": "AmGraph-2",
                                            "lineAlpha": 0.2,
                                            "title": $('#langquote').val(),
                                            "type": "column",
                                            "valueField": "devis",
                                            "valueAxis": "devisAxis",
                                            "balloonFunction": function (graphDataItem, graph) {
                                            var value = graphDataItem.values.value;
                                                    return "Devis<br>" + beautifyFormatWithDevice(value);
                                            },
                                            "lineColor": "#5BC0DE"
                                    },
                                    {
                                    "balloonText": $('#devisaccepte').val()+": [[value]]",
                                            "fillAlphas": 0.8,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_quotes),
//                        "legendValueText": "[[value]]",
                                            "id": "AmGraph-3",
                                            "lineAlpha": 0.2,
                                            "title": $('#devisaccepte').val(),
                                            "type": "column",
                                            "valueField": "devis_acc",
                                            "valueAxis": "factureAxis",
                                            "balloonFunction": function (graphDataItem, graph) {
                                            var value = graphDataItem.values.value;
                                                    return $('#devisaccepte').val()+"<br>" + beautifyFormatWithDevice(value);
                                            },
                                            "lineColor": "#84B761"
                                    },
                                    ],
                                    "chartCursor": {
                                    "categoryBalloonDateFormat": "MMM YYYY",
                                            "cursorAlpha": 0.1,
                                            "cursorColor": "#000000",
                                            "fullWidth": true,
                                            "valueBalloonsEnabled": false,
                                            "zoomable": false
                                    },
                                    "dataDateFormat": "YYYY-MM",
                                    "categoryField": "date",
                                    "categoryAxis": {
                                    "dateFormats": [{
                                    "period": "DD",
                                            "format": "DD"
                                    }, {
                                    "period": "MM",
                                            "format": "MMM"
                                    }, {
                                    "period": "YYYY",
                                            "format": "YYYY"
                                    }],
                                            "parseDates": false,
                                            "autoGridCount": true,
                                            "axisColor": "#555555",
                                            "gridAlpha": 0.1,
                                            "gridColor": "#FFFFFF",
                                            "minPeriod": "MM",
                                            "gridCount": 50
                                    },
                                    "exportConfig": {
                                    "menuBottom": "20px",
                                            "menuRight": "22px",
                                            "menuItems": [{
                                            "icon": Metronic.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
                                                    "format": 'png'
                                            }]
                                    }
                            });
                            $('#sales_statistics').closest('.portlet').find('.fullscreen').click(function () {
                    chart.invalidateSize();
                    });
                    }

            }

            function updateChart2() {

            $.post("<?php echo site_url('dashboard/ajax/update_chart_annuel'); ?>", {
            current_year: 2016,
                    current_devise: current_devise,
                    user_id_stat: <?php echo $user_id_stat; ?>
            }, function (data) {
//            alert(data);
            var parsed = JSON.parse(data);
                    json_response = [];
                    for (var x in parsed) {
            json_response.push(parsed[x]);
            }
            table_stat = "";
                    devise_info = json_response[1];
                    $("#symbole_devise").val(devise_info[0]["devise_symbole"]);
                    $("#currency_symbol_placement").val(devise_info[0]["symbole_placement"]);
                    $("#tax_rate_decimal_places").val(devise_info[0]["number_decimal"]);
                    $("#thousands_separator").val(devise_info[0]["thousands_separator"]);
                    initChart();
            });
                    var initChart = function () {

                    var datachartss = json_response[0];
                            var chart = AmCharts.makeChart("sales_statistics2", {
                            "type": "serial",
                                    "theme": "light",
                                    "fontFamily": 'Open Sans',
                                    "color": '#888888',
                                    "legend": {
                                    "equalWidths": false,
                                            "useGraphSettings": false,
                                            "valueAlign": "left",
                                            "valueWidth": 40,
                                            "valueText": ""
                                    },
                                    "dataProvider": datachartss,
                                    "valueAxes": [{
                                    "id": "devisAxis",
                                            "axisAlpha": 0,
                                            "gridAlpha": 0,
                                            "position": "left",
                                            "title": "",
                                            "labelFunction": function (value, valueString, axis) {
                                            return beautifyFormatWithDevice(valueString);
                                            }
                                    }, {
                                    "id": "clientsAxis",
                                            "axisAlpha": 0,
                                            "gridAlpha": 0,
                                            "labelsEnabled": false,
                                            "position": "right"
                                    }],
                                    "graphs": [
<?php if ($user_id_stat == 0) { ?>
                                        {
                                        "alphaField": "alpha",
                                                "balloonText": "Factures: [[value]]",
                                                "dashLengthField": "dashLength",
                                                "fillAlphas": 0.7,
                                                //                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_invoices),
                                                //                        "legendValueText": "[[value]]",
                                                "title": "Factures",
                                                "type": "column",
                                                "valueField": "facture",
                                                "valueAxis": "factureAxis",
                                                "balloonFunction": function (graphDataItem, graph) {
                                                var value = graphDataItem.values.value;
                                                        return "Factures<br>" + beautifyFormatWithDevice(value);
                                                },
                                                "lineColor": "#2D59A9"
                                        },
<?php } ?>
                                    {
                                    "balloonText": "[[value]] clients",
                                            "bullet": "round",
                                            "bulletBorderAlpha": 1,
                                            "useLineColorForBulletBorder": true,
                                            "bulletColor": "#FFFFFF",
                                            "dashLengthField": "dashLength",
                                            "labelPosition": "right",
//                        "legendPeriodValueText": "Total: [[value.sum]]",
//                        "legendValueText": "[[value]] ",
                                            "title": "Clients",
                                            "fillAlphas": 0,
                                            "valueField": "clients",
                                            "valueAxis": "clientsAxis",
                                            "lineColor": "#FF9E01"
                                    },
                                    {
                                    "balloonText": "Devis: [[value]]",
                                            "fillAlphas": 0.8,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_quotes),
//                        "legendValueText": "[[value]]",
                                            "id": "AmGraph-2",
                                            "lineAlpha": 0.2,
                                            "title": "Devis",
                                            "type": "column",
                                            "valueField": "devis",
                                            "valueAxis": "devisAxis",
                                            "balloonFunction": function (graphDataItem, graph) {
                                            var value = graphDataItem.values.value;
                                                    return "Devis<br>" + beautifyFormatWithDevice(value);
                                            },
                                            "lineColor": "#5BC0DE"
                                    },
                                    {
                                    "balloonText": "Devis Acceptés: [[value]]",
                                            "fillAlphas": 0.8,
//                        "legendPeriodValueText": "Total: "+beautifyFormatWithDevice(total_quotes),
//                        "legendValueText": "[[value]]",
                                            "id": "AmGraph-3",
                                            "lineAlpha": 0.2,
                                            "title": "Devis Acceptés",
                                            "type": "column",
                                            "valueField": "devis_acc",
                                            "valueAxis": "factureAxis",
                                            "balloonFunction": function (graphDataItem, graph) {
                                            var value = graphDataItem.values.value;
                                                    return "Devis acceptés<br>" + beautifyFormatWithDevice(value);
                                            },
                                            "lineColor": "#84B761"
                                    },
                                    ],
                                    "chartCursor": {
                                    "categoryBalloonDateFormat": "MMM YYYY",
                                            "cursorAlpha": 0.1,
                                            "cursorColor": "#000000",
                                            "fullWidth": true,
                                            "valueBalloonsEnabled": false,
                                            "zoomable": false
                                    },
                                    "dataDateFormat": "YYYY-MM",
                                    "categoryField": "date",
                                    "categoryAxis": {
                                    "dateFormats": [{
                                    "period": "DD",
                                            "format": "DD"
                                    }, {
                                    "period": "MM",
                                            "format": "MMM"
                                    }, {
                                    "period": "YYYY",
                                            "format": "YYYY"
                                    }],
                                            "parseDates": false,
                                            "autoGridCount": true,
                                            "axisColor": "#555555",
                                            "gridAlpha": 0.1,
                                            "gridColor": "#FFFFFF",
                                            "minPeriod": "MM",
                                            "gridCount": 50
                                    },
                                    "exportConfig": {
                                    "menuBottom": "20px",
                                            "menuRight": "22px",
                                            "menuItems": [{
                                            "icon": Metronic.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
                                                    "format": 'png'
                                            }]
                                    }
                            });
                            $('#sales_statistics2').closest('.portlet').find('.fullscreen').click(function () {
                    chart.invalidateSize();
                    });
                    }

            }

    $("#selected_date").change(function () {
    current_year = $(this).val();
            updateChart();
            updateChart2();
    });
            $("#selected_devise").change(function () {
    current_devise = $(this).val();
            updateChart();
            updateChart2();
    });
            jQuery(document).ready(function () {

    if (typeof (current_devise) == 'undefined')
    {
    current_devise = $("#selected_devise").val();
    }

    updateChart();
    updateChart2();
    });
            jQuery(document).ready(function() {
    $('.log_infos').click(function(event) {
    var image = $(this).find(".image_user").html();
            var title = $(this).data('title');
            var description = $(this).data('description');
            var class1 = $(this).data('class');
            var class_not = 'teal';
            if (class1 == 'log_success'){
    class_not = 'lime';
    } else if (class1 == 'log_warning'){
    class_not = 'tangerine';
    } else if (class1 == 'log_danger'){
    class_not = 'ruby';
    }
    class_not = 'teal';
            // Themes ruby:danger // lime:success  // tangerine : warning
            var settings = {
            theme: 'teal',
                    sticky: false,
                    horizontalEdge: 'top',
                    verticalEdge: 'right'
            },
            $button = $(this);
            settings.heading = image + title;
            if (!settings.sticky) {
    settings.life = 10000;
    }

    $.notific8('zindex', 11500);
            $.notific8(description, settings);
            $button.attr('disabled', 'disabled');
            setTimeout(function() {
            $button.removeAttr('disabled');
            }, 1000);
    });
    });
</script>