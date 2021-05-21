<?php
$sess_facture_add = $this->session->userdata['facture_add'];
$sess_facture_del = $this->session->userdata['product_del'];
$sess_facture_index = $this->session->userdata['product_index'];
$sess_payement_add = $this->session->userdata['payement_add'];
?>
<?php
foreach ($invoices as $invoice) {

    $nb_rap = 0;
    $nb_ra = 0;

    if (@$rappels) {
        foreach ($rappels as $rappel) {
            if (($invoice->invoice_id == $rappel->rappel_object_id) && ($rappel->rappel_status == 1)) {
                $nb_rap += 1;
            }
        }
        foreach ($rappels as $rappel) {
            if ($invoice->invoice_id == $rappel->rappel_object_id) {
                $nb_ra += 1;
            }
        }
    }
    ?>


<tr id="line_<?php echo $invoice->invoice_id ?>">
    <td>
        <input type="hidden" value="<?php echo $invoice->invoice_id; ?>"
            id="id_invoice_<?php echo $invoice->invoice_id; ?>" />
        <a href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>" title="<?php echo lang('edit'); ?>">
            <?php echo $invoice->invoice_number; ?>
        </a>
    </td>
    <td style="text-align:center;">
        <span style=" font-size: 10px; margin-left: -20px; margin-top: 20px; color: #940c6c">
            <?php
if (($nb_ra > 0) && false) {
        ?>
            <b><?php echo $nb_rap; ?>/<?php echo $nb_ra; ?></b>
            <?php }?>
        </span>
        <?php if ($invoice->invoice_status_id == 7) {?>
        <span style=" margin-top: -20px;width: 75% !important;margin-left: 7px;cursor:pointer;"
            data-invoice-id="<?php echo $invoice->invoice_id; ?>" class="label annuler">
            <?php echo "Av"; ?>
        </span>
        <?php } else {?>
        <?php
$mot = 'rappel_facture';
        $this->db->like(trim("ip_tracking.action"), $mot);
        $this->db->where("ip_tracking.id_action", $invoice->invoice_id);
        $restrack = $this->db->get("ip_tracking")->result();
        ?>
        <span style=" margin-top: -20px;width: 75% !important;margin-left: 7px;cursor:pointer;"
            data-invoice-id="<?php echo $invoice->invoice_id; ?>" title="<?php
if (count($restrack) == 1) {
            echo 'une relance';
        } elseif (count($restrack) == 0) {
            echo 'pas de relance';
        } else {
            echo count($restrack) . ' relances';
        }?>"
            class="change_quote_statuses1 label <?php echo $invoice_statuses[$invoice->invoice_status_id]['class']; ?>">
            <?php echo $invoice_statuses[$invoice->invoice_status_id]['label'][0] ?>
        </span>
        <?php }?>
    </td>
    <td>
        <?php
$dat = explode('-', $invoice->invoice_date_created);
    echo $dat[2] . '/' . $dat[1] . '/' . $dat[0];
    ?>
    </td>

    <td>
        <?php
if ($invoice->invoice_date_due == '0001-00-02') {
        echo '';
    } else {
        $dat1 = explode('-', $invoice->invoice_date_due);
        echo $dat1[2] . '/' . $dat1[1] . '/' . $dat1[0];
    }
    ?>
    </td>

    <td>
        <a href="<?php echo site_url('clients/view/' . $invoice->client_id); ?>"
            title="<?php echo $invoice->client_societe . " (" . $invoice->client_name . ' ' . $invoice->client_prenom . ")"; ?>">
            <?php
if ($invoice->client_societe != '') {
        $client_name = $invoice->client_societe;
    } else {
        $client_name = $invoice->client_name . ' ' . $invoice->client_prenom;
    }

    echo substr($client_name, 0, 20);
    if (strlen($client_name) > 20) {
        echo '<b style="color:#27871e">&nbsp;...</b>';
    }

    ?>
        </a>
    </td>

    <td>
        <?php echo $invoice->client_country; ?>
    </td>

    <td>
        <span title="<?php echo $invoice->nature; ?>">
            <?php
$nat = $invoice->nature;
    echo substr($nat, 0, 20);
    if (strlen($nat) > 20) {
        echo '<b style="color:#27871e">&nbsp;...</b>';
    }

    ?>
        </span>
    </td>

    <td>
        <?php echo format_devise($invoice->invoice_item_subtotal, $invoice->devise_id); ?>

    </td>

    <td>

        <?php echo format_devise($invoice->invoice_total, $invoice->devise_id); ?>

    </td>

    <td>
        <?php echo substr($invoice->delai_paiement_label, 0, -14); ?>
    </td>

    <td><span title="<?php echo $invoice->user_name; ?>">
            <?php
echo substr($invoice->user_name, 0, 10);
    if (strlen($invoice->user_name) > 10) {
        echo '<b style="color:#27871e">&nbsp;...</b>';
    }

    ?>
        </span>
    </td>

    <?php
$invoice_date_modif = $invoice->invoice_date_modified;
    $invoice_date = explode(' ', $invoice_date_modif);
    if ($invoice_date[0] == '') {
        $invoice_dat = date_from_mysql('0000-00-00');
    } else {
        $invoice_dat = date_from_mysql($invoice_date[0]);
    }
    ?>

    <td>
        <div class="md-checkbox">
            <input type="checkbox" name="Choix[]" value="<?php echo $invoice->invoice_id ?>"
                id="checkbox3_<?php echo $invoice->invoice_id; ?>" class="md-check"
                onchange="myFunctionchech(<?php echo $invoice->invoice_id; ?>)">
            <label for="checkbox3_<?php echo $invoice->invoice_id; ?>">
                <span></span>
                <span class="check"
                    style="border-color: -moz-use-text-color #0AC877 #09B07B -moz-use-text-color;"></span>
                <span class="box"></span>
            </label>
        </div>
    </td>
    <td>

        <div class="options btn-group">
            <a class="btn btn-sm btn-default dropdown-toggle option_btn" data-toggle="dropdown"
                data-id="<?php echo $invoice->invoice_id; ?>" href="#">
                <i class="fa fa-cog"></i> <?php //echo lang('options');                           ?>
            </a>
            <ul class="dropdown-menu dropdown-btngroup-menu">

                <?php if ($sess_facture_add == 1) {?> <li>
                    <a href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>">
                        <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                    </a>
                </li><?php }?>
                <li>
                    <a href="<?php echo site_url('invoices/generate_pdf/' . $invoice->invoice_id); ?>" target="_blank">
                        <i class="fa fa-print fa-margin"></i> <?php echo lang('download_pdf'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('mailer/invoice/' . $invoice->invoice_id); ?>">
                        <i class="fa fa-send fa-margin"></i> <?php echo lang('send_email'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('invoices/avoirajax/' . $invoice->invoice_id); ?>">
                        <i class="fa fa-remove fa-margin"></i> <?php echo lang('facture_avoir'); ?>
                    </a>
                </li>
                <?php   if ($invoice->bl_id == 0 && rightsAddFacture()) {?>
                <li>
                    <a href="#" id="invoice_to_bl_<?php echo $invoice->invoice_id; ?>" invoice-id="<?php echo $invoice->invoice_id; ?>"
                        data-invoice-id="<?php echo $invoice->invoice_id; ?>" class="invoice_to_bl">
                        <i class="fa fa-refresh fa-margin"></i>
                        <?php echo lang('invoice_bl'); ?>
                    </a>
                </li><?php  }?>
                <?php if (false) {?>
                <li style="position:relative!important;">
                    <a style="color: #847575;"> <input type="text" class="simpliest-usage"
                            style="width: 100%;position: absolute;opacity: 0;"
                            id="multi_date_pick_<?php echo $invoice->invoice_id; ?>" />
                        <span class="calendar_a" id="span_pick_<?php echo $invoice->invoice_id; ?>">

                            <i class="fa fa-calendar fa-margin"></i><?php echo lang('date_rappel'); ?></span></a>
                </li>

                <li>
                    <a class="calendar_a supp_rappel" id="supp_rappel_<?php echo $invoice->invoice_id; ?>"
                        style="<?php ?>" data-id="<?php echo $invoice->invoice_id; ?>"><i
                            class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete_date_rappel'); ?></a>
                </li>
                <?php }?>
                <?php if ($sess_payement_add == 1) {?> <li>
                    <a href="#" class="invoice-add-payment" data-invoice-id="<?php echo $invoice->invoice_id; ?>"
                        data-client-id="<?php echo $invoice->client_id; ?>"
                        data-invoice-balance="<?php echo $invoice->invoice_balance; ?>">
                        <i class="fa fa-money fa-margin"></i>
                        <?php echo lang('enter_payment'); ?>
                    </a>
                </li><?php }?>

            </ul>
        </div>
    </td>
</tr>
<?php
}
?>
<?php
if (count($devises) != 0) {
    ?>
<tr style="background:transparent;">
    <td colspan="13" style="white-space: initial;"></td>
</tr>
<?php
foreach ($devises as $devise) {
        $invoices_total_amounts[$devise->devise_id]["invoices_sum_subtotal"] = isset($invoices_total_amounts[$devise->devise_id]["invoices_sum_subtotal"]) ? $invoices_total_amounts[$devise->devise_id]["invoices_sum_subtotal"] : 0;
        $invoices_total_amounts[$devise->devise_id]["invoices_sum_total"] = isset($invoices_total_amounts[$devise->devise_id]["invoices_sum_total"]) ? $invoices_total_amounts[$devise->devise_id]["invoices_sum_total"] : 0;
        $invoices_total_amounts[$devise->devise_id]["count"] = isset($invoices_total_amounts[$devise->devise_id]["count"]) ? $invoices_total_amounts[$devise->devise_id]["count"] : "0";
        ?>

<tr style="background: #E1F0FF; font-weight:bold;">
    <td colspan="6" style=" border:none; padding: 12px 8px;">
        <?php echo (int) $invoices_total_amounts[$devise->devise_id]["count"] . " (" . $devise->devise_symbole . ")"; ?>
    </td>
    <td colspan="2" style=" border:none; padding: 12px 15px; text-align: right;">
        <?php echo format_devise($invoices_total_amounts[$devise->devise_id]["invoices_sum_subtotal"], $devise->devise_id); ?>
    </td>
    <td colspan="2" style=" border:none; padding: 12px 15px;">
        <?php echo format_devise($invoices_total_amounts[$devise->devise_id]["invoices_sum_total"], $devise->devise_id); ?>
    </td>
    <td colspan="3" style="border:none; padding: 12px 8px;"></td>
</tr>

<?php
}
}
?>
<tr style="display:none">
    <script>
    <?php
    $nb_pages = isset($nb_pages) ? $nb_pages : 1;
    $start_page = isset($start_page) ? $start_page : 1;
    $nb_all_lines = isset($nb_all_lines) ? $nb_all_lines : 1;
    $start_line = isset($start_line) ? $start_line : 1; ?>
    nb_pages = <?php echo $nb_pages; ?> ;
    start_page = <?php echo $start_page; ?> ;
    nb_all_lines = <?php echo $nb_all_lines; ?> ;
    start_line = <?php echo $start_line; ?> ;
    if (nb_pages == 0)
        nb_pages = 1;
    $("#number_current_page").text(start_page + '/' + nb_pages);
    if (start_page == 1 || start_page == 0) {
        $("#btn_fast_backward").addClass("disabled");
        $("#btn_fa_backward").addClass("disabled");
    } else {
        $("#btn_fast_backward").removeClass("disabled");
        $("#btn_fa_backward").removeClass("disabled");
    }
    if (start_page == nb_pages) {
        $("#btn_fast_forward").addClass("disabled");
        $("#btn_fa_forward").addClass("disabled");
    } else {
        $("#btn_fast_forward").removeClass("disabled");
        $("#btn_fa_forward").removeClass("disabled");
    }


    $(function() {
        $('.tooltips').tooltip();
        $('.change_quote_statuses1').click(function() {
            $('#modal-placeholder').load(
                "<?php echo site_url('quotes/ajax/modal_change_statut/1'); ?>", {
                    quote_id: $(this).data('invoice-id')
                });
        });



        $('.option_btn').click(function() {
            id_object = $(this).data('id');

            $('#multi_date_pick_' + id_object).datepick({
                prevText: 'Préc',
                nextText: 'Suiv',
                closeText: 'Valider',
                todayText: "Ajourd'hui",
                multiSelect: 1000,
                monthsToShow: 1,
                monthsToStep: 12,
                onSelect: function(dates) {
                    var datesCh = "" + $.datepick.formatDate('dd/mm/yyyy', dates[0]);
                    for (var i = 1; i < dates.length; i++) {
                        datesCh = datesCh + "," + $.datepick.formatDate('dd/mm/yyyy', dates[
                            i]);
                    }
                    $('#selected_dates').val(datesCh);
                },
                onClose: function() {
                    var dates = $('#selected_dates').val();
                    if (dates != '') {
                        $.post("<?php echo site_url('invoices/ajax/save_date_rappel'); ?>", {
                            dates: dates,
                            id_object: id_object,
                            type: 'invoice'


                        }, function(data) {
                            var json_response = eval('(' + data + ')');
                            if (json_response.success == 1) {
                                //                            $('#selected_dates').val('');
                                //                            $('#span_pick_' + id_object + ' i').css({'color': 'red'});
                                //                            $('#supp_rappel_' + id_object).css({'display': 'block'});
                                //                            $('#supp_rappel_' + id_object).css({'color': 'red'});
                                location.reload(true);
                            }
                        });
                    }

                },
                dateFormat: 'yyyy-mm-dd',
                selectDefaultDate: true
            });
            $.post("<?php echo site_url('invoices/ajax/getDateRappelInvoice'); ?>", {
                id_object: id_object

            }, function(data) {
                var json_response = eval('(' + data + ')');
                var dates = json_response.dates;
                datesArray = dates.split(',');

                $('#multi_date_pick_' + id_object).datepick('setDate', datesArray);
            });
        });




        $('.supp_rappel').click(function() {
            var id_object = $(this).data('id');

            var r = confirm('<?php echo lang('
                msg_confirmation_delete_rappel '); ?>');
            if (r == true) {
                $.post("<?php echo site_url('invoices/ajax/delete_rappel'); ?>", {
                    id_object: id_object

                }, function(data) {
                    var json_response = eval('(' + data + ')');
                    if (json_response.success == 1) {
                        window.location = "<?php echo site_url('invoices'); ?>/";
                    }
                });
            }
        });
    });

      $('.invoice_to_bl').click(function() {        
        invoice_id = $(this).data('invoice-id');
            $('#modal-placeholder').load(
                "<?php echo site_url('invoices/ajax/modal_invoice_to_bl'); ?>/" + invoice_id);
        });

    var myInteger = 0;

    function myFunctionchech(e) {

        if ($("#checkbox3_" + e).is(':checked')) {
            myInteger = myInteger + 1;
        } else {
            myInteger = myInteger - 1;
        }
        if ($("#check_all").is(':checked')) {
            //  alert('h');
            if (myInteger > 0) {
                $('#relance_rappel').prop("disabled", false);
                $('#export_excel').prop("disabled", false);
            }
        } else {
            if (myInteger > 0) {
                $('#relance_rappel').prop("disabled", false);
                $('#export_excel').prop("disabled", false);
            } else {
                $('#relance_rappel').prop("disabled", true);
                $('#export_excel').prop("disabled", true);
            }
        }
    };
    </script>
</tr>