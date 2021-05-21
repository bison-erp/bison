<?php
$sess_cont_add = $this->session->userdata['cont_add'];
$sess_cont_del = $this->session->userdata['cont_del'];
$sess_cont_index = $this->session->userdata['cont_index'];
$sess_devis_add = $this->session->userdata['devis_add'];
$sess_devis_index = $this->session->userdata['devis_index'];
$sess_facture_index = $this->session->userdata['product_index'];
$sess_payement_index = $this->session->userdata['payement_index'];

$sess_facture_add = $this->session->userdata['facture_add'];
?>
<script type="text/javascript">
// $('#relance_rappel').click(function () {
  
function f() {
   
    if (confirm('voulez vous vraiment envoyer ce(s) relance(s) ?'))

    {
        var valeurs = []; //valeurs.push('r');
        $('input:checked[name="Choix[]"]').each(function() {
            valeurs.push($(this).val());
        });
        for (i = 0; i < valeurs.length; i++) {
            vale = valeurs[i].split("//"); //alert(vale);
            id_quote = vale[0];
            dte_creat = vale[1];
            nat = vale[3];
            num = vale[2];
            mail_cli = vale[4];
            usr_name = vale[5];
            usr_mail = vale[6];
            cc = '<?php echo $this->session->userdata['user_mail']; ?>';
            $.post("<?php echo site_url('mailer/relance'); ?>", {
                id_quote: id_quote,
                dte_creat: dte_creat,
                nat: nat,
                num: num,
                mail_cli: mail_cli,
                usr_name: usr_name,
                usr_mail: usr_mail,
                cc: cc
            }, function(data) {
                window.location.reload(true);
            });
        }
    }
    //            });
}
$(function() {
    $('#save_client_note').click(function() {
        drr = document.getElementById('drap').checked;
        if (drr == true) {
            drp = 1;
        } else {
            drp = 0;
        }
        user = <?php echo $this->session->userdata['user_id']; ?>;
        ip = '<?php echo $this->session->userdata['ip_address']; ?>';
        $.post("<?php echo site_url('clients/ajax/save_client_note'); ?>", {
            user: user,
            ip: ip,
            client_id: $('#client_id').val(),
            client_note: $('#client_note').val(),
            adr_ip: $('#adr_ip').val(),
            usr: $('#usr').val(),
            id_usr: $('#id_usr').val(),
            drap: drp
        }, function(data) {
            var response = JSON.parse(data);
            if (response.success == '1') {
                // The validation was successful
                $('.control-group').removeClass('error');
                $('#client_note').val('');

                $('#notes_list').load(
                    "<?php echo site_url('clients/ajax/load_client_notes'); ?>", {
                        client_id: <?php echo $client->client_id; ?>
                    });
            } else {
                // The validation was not successful
                $('.control-group').removeClass('error');
                for (var key in response.validation_errors) {
                    $('#' + key).parent().parent().addClass('error');
                }
            }
        });
    });

    //$('.simpliest-usage').hide();



    // });
    $('#tab_clientQuotes').click(function() {
        $('#btn_relance_devis').show();
    });
    $('#tab_clientDetails,#tab_clientInvoices,#btn_relance_devis,#tab_clientPayments,#tab_clientNotes,#tab_clientDocuments')
        .click(function() {
            $('#btn_relance_devis').hide();
        });
    $('').click(function() {
        $('').hide();
    });
    $('').click(function() {
        $('#btn_relance_devis').hide();
    });
    $('').click(function() {
        $('#btn_relance_devis').hide();
    });

});

</script>

<style>
.draft {
    color: #999
}

.sent {
    color: #3A87AD
}

.viewed {
    color: #F89406
}

.paid,
.approved {
    color: #468847
}

.rejected,
.overdue {
    color: #B94A48
}

.label.negotiation {
    font-weight: normal;
    padding: .3em .6em;
    color: white !important;
    display: block;
    width: 100%;
    background-color: #a33cad
}

.canceled {
    color: #333
}

/*.label{font-weight:normal;padding:.3em .6em;color:white !important;display:block;width:100%;}*/
.label.label-inline {
    display: inline;
    width: auto
}

.label.draft {
    font-weight: normal;
    padding: .3em .6em;
    color: white !important;
    display: block;
    width: 100%;
    background-color: #b3b3b3
}

.label.sent {
    font-weight: normal;
    padding: .3em .6em;
    color: white !important;
    display: block;
    width: 100%;
    background-color: #54a0c6
}

.label.viewed {
    font-weight: normal;
    padding: .3em .6em;
    color: white !important;
    display: block;
    width: 100%;
    background-color: #faa937
}

.label.paid,
.label.approved {
    font-weight: normal;
    padding: .3em .6em;
    color: white !important;
    display: block;
    width: 100%;
    background-color: #58a959
}

.label.rejected,
.label.overdue {
    font-weight: normal;
    padding: .3em .6em;
    color: white !important;
    display: block;
    width: 100%;
    background-color: #c76e6d
}

.label.canceled {
    font-weight: normal;
    padding: .3em .6em;
    color: white !important;
    display: block;
    width: 100%;
    background-color: #4d4d4d
}

.annuler {
    font-weight: normal;
    color: #F0FFFF;
    background-color: #80ced6;
    display: block;
    color: white !important; 
}
.unpaid {
    color: #DC143C
}
.refunded {
    color: #000def
}
.label.unpaid {
    font-weight: normal;
    padding: .3em .6em;
    color: white !important;
    display: block;
    width: 100%;
    background-color: #DC143C
}
.label.refunded {
    font-weight: normal;
    padding: .3em .6em;
    color: white !important;
    display: block;
    width: 100%;
    background-color: #000def
}
</style>
     <div id="headerbar-index" style=" margin-top:0;margin-bottom:0;">
	 
                        <?php $this->layout->load_view('layout/alerts');?>
    </div>
    <div id="content">
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">


            <div id="headerbarbtn">
                <div class="pull-right btn-group">
                    <?php if ($sess_devis_add == 1) {?>
                    <a href="<?php echo base_url(); ?>quotes/form/0/<?php echo $client->client_id; ?>"
                        class="btn btn-sm btn-default " data-client-name="<?php echo $client->client_name; ?>">
                       <i class="fas fa-comment-dollar" aria-hidden="true"></i>  <?php echo lang('create_quote'); ?>
                    </a><?php
}
if ($sess_facture_add == 1) {
    ?>
                     <button style="padding: 3px 10px 5px; background-color: #2EB2E6; color: #fff;" id="group_bl_invoice"
                         class="btn btn-sm btn">
                         <i class="fas fa-check-square"></i><?php echo lang('group_bl_invoice'); ?>
                     </button> 
                    <a href="<?php echo base_url(); ?>invoices/form/0/<?php echo $client->client_id; ?>"
                        class="btn btn-sm btn-default" data-client-name="<?php echo $client->client_name; ?>">
						<i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>  <?php echo lang('create_invoice'); ?>
                    </a>
                    <a href="<?php echo base_url(); ?>bl/form/0/<?php echo $client->client_id; ?>"
                        class="btn btn-sm btn-default" data-client-name="<?php echo $client->client_name; ?>">
						<i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>  <?php echo lang('create_delivery_form'); ?>
                    </a>
                    <a href="<?php echo base_url(); ?>commande/form/0/<?php echo $client->client_id; ?>"
                        class="btn btn-sm btn-default" data-client-name="<?php echo $client->client_name; ?>">
						<i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>  <?php echo lang('create_cmd'); ?>
                    </a>
                    
                    <?php
}
if ($sess_cont_add) {
    ?>
                    <a href="<?php echo site_url('clients/form/' . $client->client_id); ?>"
                        class="btn btn-sm btn-default">
                        <i class="fa fa-edit"></i> <?php echo lang('edit'); ?>
                    </a>
                    <?php }
?>
                    <a href="#" id="btn_relance_devis" class="btn btn-sm  blue" style="height: 30px; display:none">
                        <button class="blue btn btn-sm" style="height: 25px;" type="submit" id="relance_rappel"
                            name="relance_rappel" class=" btn btn-sm btn" onclick="f()">
                            <i class="fa fa-send"></i> <?php echo lang('relance'); ?>
                        </button></a>
                    <?php
if ($sess_cont_del == 1) {
    ?>
                    <a class="btn btn-sm btn-danger"
                        href="<?php echo site_url('clients/delete/' . $client->client_id); ?>"
                        onclick="return confirm('<?php echo lang('delete_client_warning'); ?>');">
                        <i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?>
                    </a><?php }?>
                </div>

            </div>
            <ul id="settings-tabs" class="nav nav-tabs nav-tabs-noborder">
                <li class="active"><a data-toggle="tab" href="#clientDetails" id="tab_clientDetails">
                        <?php echo lang('details'); ?></a></li>

                <?php if ($sess_devis_index == 1) {?><li><a data-toggle="tab" href="#clientQuotes"
                        id="tab_clientQuotes">
                        <?php echo lang('quotes'); ?></a></li><?php }?>

                <?php if ($sess_facture_index == 1) {?><li><a data-toggle="tab" href="#clientInvoices"
                        id="tab_clientInvoices">
                        <?php echo lang('invoices'); ?></a></li><?php }?>

                <?php if ($sess_payement_index == 1) {?><li><a data-toggle="tab" href="#clientPayments"
                        id="tab_clientPayments">
                        <?php echo ucfirst(lang('payments')); ?></a></li><?php }?>
                <?php if ($sess_payement_index == 1) {?><li><a data-toggle="tab" href="#bon_livraison"
                        id="tab_bon_livraison">
                        <?php echo ucfirst(lang('bon_livraison')); ?></a></li><?php }?>        
                <?php if ($sess_payement_index == 1) {?><li><a data-toggle="tab" href="#bons_commande"
                        id="tab_bons_commande">
                        <?php echo ucfirst(lang('bons_commande')); ?></a></li><?php }?>          
                <li><a data-toggle="tab" href="#clientDocuments" id="tab_clientDocuments">Documents</a></li>
                <li><a data-toggle="tab" href="#clientNotes" id="tab_clientNotes"><?php echo lang('notes'); ?></a></li>
                <li><a data-toggle="tab" href="#clientLogs" id="tab_clientLogs">Log</a></li>

            </ul>

            <div class="tabbable tabs-below">

                <div class="tab-content">

                    <div id="clientDetails" class="tab-pane tab-info active">


                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <h2><?php echo $client->client_societe; ?></h2>
                                <div style="font-size: 15px;margin-top: -10px;color: #1C6A84;">
                                    <?php echo $client->client_name; ?> <?php echo $client->client_prenom; ?>
                                    (<?php echo '#' . $client->client_id; ?>)

                                </div>
                            </div>
                            <?php
$devise_symbole = '';
foreach ($devises as $devise) {
    if ($devise->devise_id == $client->client_devise_id) {
        $devise_symbole = $devise->devise_symbole;
    }
}
?>
                            <?php
$total_credit = 0;
$total_debit = 0;
if (!empty($payments)) {
    foreach ($payments as $payment) {
        if ($payment["type"] == "credit" ) {
            $total_credit += $payment["amount"];
        } else if ($payment["type"] == "debit" ) {
            $total_debit += $payment["amount"];
        }
    }
}
?>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                                <table class="table table-condensed table-bordered">
                                    <tr>
                                        <td>
                                            <b><?php echo lang('total_billed'); ?></b>
                                        </td>
                                        <td class="td-amount">

                                            <?php echo format_devise($total_debit, $client->client_devise_id); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b><?php echo lang('total_paid'); ?></b>
                                        </td>
                                        <td class="td-amount">
                                            <?php echo format_devise($total_credit, $client->client_devise_id); ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <b>Solde du client</b>
                                        </td>
                                        <td class="td-amount" style="font-weight:bold;">
                                            <?php $solde_credit = $total_credit - $total_debit;?>
                                            <span <?php
if ($solde_credit < 0) {
    echo 'style="color:#F00"';
} else {
    echo 'style="color:#090"';
}

?>>
                                                <?php echo format_devise($solde_credit, $client->client_devise_id); ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr/>

                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <div
                                    style="color: #333;font-family: Open Sans,sans-serif;font-size: 16px;font-weight: 700;">
                                    <?php echo lang('contact_information'); ?></div>
                                <br />
                                <table class="table table-condensed table-striped">

                                    <?php if ($client->client_email) {?>
                                    <tr>
                                        <td><?php echo lang('email'); ?></td>
                                        <td><?php echo auto_link($client->client_email, 'email'); ?></td>
                                    </tr>
                                    <?php }?>
                                    <?php if ($client->client_phone) {?>
                                    <tr>
                                        <td><?php echo lang('phone'); ?></td>
                                        <td><?php echo $client->client_phone; ?></td>
                                    </tr>
                                    <?php }?>
                                    <?php if ($client->client_mobile) {?>
                                    <tr>
                                        <td><?php echo lang('mobile'); ?></td>
                                        <td><?php echo $client->client_mobile; ?></td>
                                    </tr>
                                    <?php }?>
                                    <?php if ($client->client_address_1) {?>
                                    <tr>
                                        <td>Adresse</td>
                                        <td>
                                            <?php echo ($client->client_address_1) ? $client->client_address_1 . '<br>' : ''; ?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php if ($client->client_state) {?>
                                    <tr>
                                        <td>Région</td>
                                        <td>
                                            <?php echo ($client->client_state) ? $client->client_state : ''; ?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php if ($client->client_zip) {?>
                                    <tr>
                                        <td>Code postal</td>
                                        <td>
                                            <?php echo ($client->client_zip) ? $client->client_zip : ''; ?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td>Pays</td>
                                        <td>

                                            <?php
$this->load->helper('country');
echo ($client->client_country) ? get_country_list(lang('cldr'))[$client->client_country] : '';
?>
                                        <td>
                                    </tr>
                                    <?php if ($client->client_fax) {?>
                                    <tr>
                                        <td><?php echo lang('fax'); ?></td>
                                        <td><?php echo $client->client_fax; ?></td>
                                    </tr>
                                    <?php }?>
                                    <?php if ($client->client_web) {?>
                                    <tr>
                                        <td><?php echo lang('web'); ?></td>
                                        <td><?php echo auto_link($client->client_web, 'url', true); ?></td>
                                    </tr>
                                    <?php }?>
                                </table>
                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div
                                    style="color: #333;font-family: Open Sans,sans-serif;font-size: 16px;font-weight: 700;">
                                    <?php echo lang('tax_information'); ?>
                                </div>
                                <br />
                                <table class="table table-condensed table-striped">
                                    <?php if ($client->client_vat_id) {?>
                                    <tr>
                                        <td><?php echo lang('vat_id'); ?></td>
                                        <td><?php echo $client->client_vat_id; ?></td>
                                    </tr>
                                    <?php }?>
                                    <?php if ($client->client_tax_code) {?>
                                    <tr>
                                        <td><?php echo lang('tax_code'); ?></td>
                                        <td><?php echo $client->client_tax_code; ?></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td><?php echo lang('devise'); ?></td>
                                        <td>
                                            <?php
$dv = '';
foreach ($devises as $devise) {
    if ($devise->devise_id == $client->client_devise_id) {
        $dv = $devise->devise_label;
    }
}
echo $dv;
?>
                                        </td>
                                    </tr>
                                    <?php if ($client->client_mat_fiscal) {?>
                                    <tr>
                                        <td><?php echo lang('matricule_fisc'); ?></td>
                                        <td><?php echo $client->client_mat_fiscal; ?></td>
                                    </tr>
                                    <?php }?>
                                    <?php if($this->mdl_settings->setting('with_timbre') == 1){ ?>
                                    <tr>
                                        <td><?php echo lang('default_item_timbre'); ?></td>
                                        <td><?php //echo $client->timbre_fiscale;                              ?>
                                            <div class="md-checkbox">
                                                <input type="checkbox" disabled name="timbre_fiscale" <?php if ($client->timbre_fiscale == 1) {
                                                    echo "checked";
                                                }
                                                ?> id="checkbox0" value="1">
                                                <label for="checkbox0">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php  } ?>
                                </table>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div
                                    style="color: #333;font-family: Open Sans,sans-serif;font-size: 16px;font-weight: 700;">
                                    Autres informations</div><br>
                                <table class="table table-condensed table-striped">

                                    <tr>
                                        <td>Etat</td>
                                        <td>
                                            <?php
if ($client->client_active == '1') {
    echo 'Actif';
} else {
    echo 'Non Actif';
}
?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Statut</td>
                                        <td><?php if ($client->client_type == 0) {?>
                                            Prospect
                                            <?php } else {?>Client <?php }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>client / prospect depuis le:</td>
                                        <td>
                                            <?php
$datenow = new DateTime("now");

if ($client->client_type == 1) {
    $datecreation = $client->date_creation_client;
    $date_ancienne = new DateTime($datecreation);
    $difference = $date_ancienne->diff($datenow);
    $jours = $difference->format('%a');

    if ($jours > 1) {
        echo $jours . ' jours';

    } else {
        echo $jours . ' jour';

    }
} else {
    $datecreation = $client->client_date_created;
    $date_ancienne = new DateTime($datecreation);
    $difference = $date_ancienne->diff($datenow);
    $jours = $difference->format('%a');

    if ($jours > 0) {
        echo $jours . ' jours';

    } else {
        echo $jours . ' jour';

    }
}

?>
                                        </td>
                                    </tr>
                                </table>

                            </div>


                        </div>


                        <hr />

                        <div>

                        </div>

                    </div>
                    <?php if ($sess_devis_index == 1) {?>

                    <div id="clientQuotes" class="tab-pane table-content" style=" height: 100%">
                        <?php // btn relance   ?>


                        <div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="quote_all">
                                    <thead>
                                        <tr>
                                            <th width="50" order="ip_quotes.quote_id"><?php echo lang('num_devis'); ?>
                                            </th>
                                            <th width="50" order="ip_quotes.quote_status_id">
                                                <?php echo lang('status_tab'); ?></th>
                                            <th width="100" order="ip_quotes.quote_date_created">
                                                <?php echo lang('created'); ?></th>
                                            <th width="100" order="ip_quotes.quote_date_expires">
                                                <?php echo lang('due_date'); ?></th>
                                            <th width="180"><?php echo lang('client_filter'); ?></th>
                                            <th order="client_country"><?php echo lang('client_pays'); ?></th>
                                            <th width="180" order="ip_quotes.quote_nature">
                                                <?php echo lang('quote_nature'); ?></th>
                                            <th width="100" order="quote_item_subtotal_final">
                                                <?php echo lang('amount_ht'); ?></th>
                                            <th width="100" order="quote_total_final"><?php echo lang('amount_ttc'); ?>
                                            </th>
                                            <th order="delai_paiement_label"><?php echo lang('mode_pmt'); ?></th>
                                            <th width="120" order="user_name"><?php echo lang('suivi'); ?></th>
                                            <th width="50">

                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="check_all" class="md-check">
                                                    <label for="check_all">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th style="white-space:nowrap;" align="right"></th>
                                        </tr>
                                    </thead>

                                    <tbody id="filter_results">
                                        <?php echo $quote_table; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>





                    </div>
                    <?php }if ($sess_facture_index == 1) {?>
                    <div id="clientInvoices" class="tab-pane table-content">

                        <div class="table-content">
                            <?php // $this->layout->load_view('layout/alerts');   ?>

                            <div class="table-responsive">
                                <table class="table table-striped" id="invoice_all">
                                    <thead>
                                        <tr>
                                            <th width="50" order="ip_invoices.invoice_id">
                                                <?php echo lang('num_devis'); ?></th>
                                            <th width="50" order="ip_invoices.invoice_status_id">
                                                <?php echo lang('status_tab'); ?></th>
                                            <th width="100" order="ip_invoices.invoice_date_created">
                                                <?php echo lang('created'); ?></th>
                                            <th width="100" order="ip_invoices.invoice_date_due">
                                                <?php echo lang('due_date'); ?></th>
                                            <th width="180" order="client_societe2"><?php echo lang('client_filter'); ?>
                                            </th>
                                            <th order="client_country"><?php echo lang('client_pays'); ?></th>
                                            <th width="180" order="ip_invoices.nature">
                                                <?php echo lang('quote_nature'); ?></th>
                                            <th width="150" order="invoice_item_subtotal_final">
                                                <?php echo lang('amount_ht'); ?></th>
                                            <th width="150" order="invoice_total"><?php echo lang('amount_ttc'); ?></th>
                                            <th width="50" order="delai_paiement_label"><?php echo lang('mode_pmt'); ?>
                                            </th>
                                            <th width="120" order="user_name"><?php echo lang('suivi'); ?></th>
                                            <th width="50">

                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="check_all" class="md-check">
                                                    <label for="check_all">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th style="white-space:nowrap;" align="right"></th>
                                        </tr>
                                    </thead>

                                    <tbody id="filter_results"><?php echo $invoice_table; ?>
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--debut bon commande-->
                    <div id="bons_commande" class="tab-pane table-content">
                        <div class="table-content">                           
                            <div class="table-responsive">
                                <table class="table table-striped" id="invoice_all">
                                    <thead>
                                        <tr>
                                            <th width="50" order="ip_invoices.invoice_id">
                                                <?php echo lang('num_devis'); ?></th>
                                            <th width="50" order="ip_invoices.invoice_status_id">
                                                <?php echo lang('status_tab'); ?></th>
                                            <th width="100" order="ip_invoices.invoice_date_created">
                                                <?php echo lang('created'); ?></th>
                                            <th width="100" order="ip_invoices.invoice_date_due">
                                                <?php echo lang('due_date'); ?></th>
                                            <th width="180" order="client_societe2"><?php echo lang('client_filter'); ?>
                                            </th>
                                            <th order="client_country"><?php echo lang('client_pays'); ?></th>
                                            <th width="180" order="ip_invoices.nature">
                                                <?php echo lang('quote_nature'); ?></th>
                                            <th width="150" order="invoice_item_subtotal_final">
                                                <?php echo lang('amount_ht'); ?></th>
                                            <th width="150" order="invoice_total"><?php echo lang('amount_ttc'); ?></th>
                                            <th width="50" order="delai_paiement_label"><?php echo lang('mode_pmt'); ?>
                                            </th>
                                            <th width="120" order="user_name"><?php echo lang('suivi'); ?></th>
                                            <th width="50">

                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="check_all" class="md-check">
                                                    <label for="check_all">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th style="white-space:nowrap;" align="right"></th>
                                        </tr>
                                    </thead>

                                    <tbody id="filter_results"><?php echo $commande_table;?>
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>    
                    
                    <!-- fin bon de commande-->



                    <!-- debut bon de livraison-->    
                    <div id="bon_livraison" class="tab-pane table-content">
                        <div class="table-content">                           
                            <div class="table-responsive">
                                <table class="table table-striped" id="invoice_all">
                                    <thead>
                                        <tr>
                                            <th width="50" order="ip_invoices.invoice_id">
                                                <?php echo lang('num_devis'); ?></th>
                                            <th width="50" order="ip_invoices.invoice_status_id">
                                                <?php echo lang('status_tab'); ?></th>
                                            <th width="100" order="ip_invoices.invoice_date_created">
                                                <?php echo lang('created'); ?></th>
                                            <th width="100" order="ip_invoices.invoice_date_due">
                                                <?php echo lang('due_date'); ?></th>
                                            <th width="180" order="client_societe2"><?php echo lang('client_filter'); ?>
                                            </th>
                                            <th order="client_country"><?php echo lang('client_pays'); ?></th>
                                            <th width="180" order="ip_invoices.nature">
                                                <?php echo lang('quote_nature'); ?></th>
                                            <th width="150" order="invoice_item_subtotal_final">
                                                <?php echo lang('amount_ht'); ?></th>
                                            <th width="150" order="invoice_total"><?php echo lang('amount_ttc'); ?></th>
                                            <th width="50" order="delai_paiement_label"><?php echo lang('mode_pmt'); ?>
                                            </th>
                                            <th width="120" order="user_name"><?php echo lang('suivi'); ?></th>
                                            <th width="50">

                                                <div class="md-checkbox">
                                                    <input type="checkbox" id="check_all" class="md-check">
                                                    <label for="check_all">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th style="white-space:nowrap;" align="right"></th>
                                        </tr>
                                    </thead>

                                    <tbody id="filter_results"><?php echo $livraison_table; ?>
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>    
                    <!-- fin bon de livraison-->    
                    
                    <?php }if ($sess_payement_index == 1) {?>
                    <div id="clientPayments" class="tab-pane table-content">
                        <div class="table-content">
                            <?php // $this->layout->load_view('layout/alerts');    ?>
                            <div class="pull-right" style="margin: 5px 0 15px;">
                                <a href="#" class="btn btn-md btn-light-primary invoice-add-payment" data-invoice-id="" data-invoice-balance="0"
                                    data-client-id="<?php echo $client->client_id; ?>" data-invoice-payment-method="">
                                    <i class="fa fa-credit-card fa-margin"></i>
                                    <?php echo lang('enter_payment'); ?>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover no-footer"
                                    id="payment_all">
                                    <thead>
                                        <tr>

                                            <th style=""><?php echo lang('date'); ?></th>
                                            <th>Libellé</th>

                                            <th style="text-align:center;">Facture</th>
                                            <th style="text-align:right;">D&eacute;bit</th>
                                            <th style="text-align:right;">Crédit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="filter_results">
                                        <?php
$total_debit = 0;
    $total_credit = 0;
    $total_avoir=0;
    if (!empty($payments)) {       
        ?>
                                        <?php foreach ($payments as $payment) {?>
                                        <tr>
                                            <td style="width: 100px;"><?php echo date_from_mysql($payment["date"]); ?>
                                            </td>
                                            <td>
                                            <?php
if ($payment["type"] == "credit" ) {

            echo "<b>Méthode de paiement :</b> " . $payment["payment_method_name"];
            echo "<br>";
            if ($payment["payment_method_id"] != 3) {
                echo "<b>Référence :</b> " . $payment["num_piece"] . "<br>";
                echo "<b>Banque :</b> " . $payment["num_piece"] . "<br>";
                echo "<b>Propriétaire :</b> " . $payment["proprietaire"] . "<br>";
                if ($payment["payment_method_id"] == 1) {
                    echo "<b>Date écheance :</b> " . $payment["echeance"] . "<br>";
                }
            }

            echo "Note : " . $payment["note"];
        } else {
            echo "<a href='" . base_url() . "invoices/view/" . $payment["invoice"] . "'>Facture " . $payment["invoice"] . "</a>";
        }

            ?></td>

                                            <td style="width: 100px; text-align:center;">
                                                <?php echo ($payment["invoice"] != 0) ? "<a href='" . base_url() . "invoices/view/" . $payment["invoice"] . "'>Facture " . $payment["invoice"] . "</a>" : "-"; ?>
                                            </td>

                                            <td style="width: 200px;text-align:right;">
                                                <?php
if ($payment["type"] == "debit") {
                echo format_devise($payment["amount"], $client->client_devise_id);
                $total_debit += $payment["amount"];
             }
            if ($payment["type"] == "debit" ) {
                //echo format_devise($payment["amount"], $client->client_devise_id);
                   // $total_avoir += $payment["amount"];
            }
          /*  if ($payment["type"] == "debit") {
              
                    $total_avoir += $payment["amount"];
            }*/
            ?>
                                            </td>
                                            <td style="width: 200px;text-align:right;">
                                                <?php
if ($payment["type"] == "credit" ) {
                echo format_devise($payment["amount"], $client->client_devise_id);
                $total_credit += $payment["amount"];
            }
          /*  if ($payment["type"] == "credit") {
                $total_avoir  += $payment["amount"];
                
            }*/
          
            ?>
                                            </td>

                                        </tr>
                                        <?php }?>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-grey" style="font-weight: bold;">
                                            <td>TOTAL</td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:right;">
                                                <?php echo format_devise($total_debit, $client->client_devise_id); ?>
                                            </td>
                                            <td style="text-align:right;">
                                                <?php echo format_devise($total_credit, $client->client_devise_id); ?>
                                            </td>
                                        </tr>

                                    </tfoot>
                                </table>
                                <?php $solde_client = $total_credit - $total_debit;?>
                                <table align="right" class="table table-striped table-bordered no-footer"
                                    style="width:400px;">

                                    <tr style="font-weight:bold;">

                                        <td style="text-align:right;width: 200px; ">Solde du client :</td>
                                        <td style="<?php
if ($solde_client < 0) {
        echo 'color:#EE2D41;';
    } else {
        echo 'color:#1BC5BD;';
    }

    ?> width: 200px;text-align:right;">
                                            <?php echo format_devise($solde_client, $client->client_devise_id); ?> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>


                    </div>
                    <?php }?>
                    <!--tab notes-->
                    <div id="clientNotes" class="tab-pane table-content ">
						<div class="panel panel-default panel-body" style="border: 0px ;">
							<form>
								<div class="row card-row form-row">
										<div class="col-lg-6 col-md-8 col-sm-12">
										<div class="bg-light-grey-card border-radius-small">
											<input type="hidden" name="client_id" id="client_id" value="<?php echo $client->client_id; ?>">
											<!--<textarea id="client_note" class="form-control" rows="1"></textarea>-->
											<div class="form-group has-info">
												<label for="form_control_1"><?php echo lang('add'); ?> <?php echo lang('notes'); ?></label>
												<textarea id="client_note" class="form-control" rows="1" style="height: 60px;"></textarea>
												<input type="hidden" name="adr_ip" id="adr_ip"
													value="<?php echo $this->session->userdata['ip_address']; ?>">
												<input type="hidden" name="usr" id="usr"
													value="<?php echo $this->session->userdata['user_name']; ?> (<?php echo $this->session->userdata['user_mail']; ?>)">
												<input type="hidden" name="id_usr" id="id_usr"
													value="<?php echo $this->session->userdata['user_id']; ?> ">
											</div>
											<div class="md-checkbox">
												<input type="checkbox" name="drap" id="drap" class="md-check">
												<label for="drap">
													<span></span>
													<span class="check"></span>
													<span class="box"></span>
													<?php echo lang('important'); ?> 
												</label>
											</div>
											<input type="button" id="save_client_note" class="btn blue btn-default btn-block" value="<?php echo lang('add_notes'); ?>">
										</div>
									</div>
								</div>
							</form>
                            </div>
                            <div id="notes_list" class="col-xs-12 col-md-12">
                                <?php echo $partial_notes; ?>
                            </div>
                    </div>
                    <div id="clientLogs" class="tab-pane table-content table-responsive">
                        <?php echo $partial_logs; ?>


                    </div>
                    <div id="clientDocuments" class="tab-pane table-content ">
                        <?php echo $partial_documents; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</div>

<script>
$('#group_bl_invoice').prop("disabled", true);
$('#group_bl_invoice').click(function() {
    long = $('input:checked[name="Choix[]"]');
    var cnt = 0;
    var ids_group = "";
    $('input:checked[name="Choix[]"]').each(function() {
            if (cnt != 0) {
                ids_group += "_";
            }
            ids_group += $(this).val();
           // ids_quote.push(parseInt($(this).val()));
            cnt++;
    }); 
    var jqxhr = $.post( "<?php echo site_url('bl/ajax/convert_bl_invoice'); ?>",  { ids_group: ids_group }, function(data) {
    })
    .done(function(data) {
        response=JSON.parse(data)
        var idres= 'invoices/view/'+response.invoice_id;
        if (response.success == '1') {
                 
                   alert("la facture crée avec succés");
                   window.location = "<?php echo site_url('invoices/index'); ?>";
                  // window.location = "<?php // echo site_url('bl/index'); ?>";
            } else {
                alert(response.validation_errors);
               
        }
       // $('#group_bl_invoice').prop("disabled", true);
        //alert( "second success" );
    }) 

    $('input:checked[name="Choixtou[]"]').prop('checked', false);
    $('input:checked[name="Choix[]"]').prop('checked', false);     
})
</script>