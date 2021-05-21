<?php
$sess_devis_add = $this->session->userdata['devis_add'];
$sess_devis_del = $this->session->userdata['devis_del'];
$sess_devis_index = $this->session->userdata['devis_index'];

foreach ($quotes as $quote) {
    $nb_rap = 0;
    $nb_ra = 0;
    $i = 0;
    $quote_id = $quote->quote_id;
    $a = explode('//', @$arrayHasDates[$i]);

//    if (@$rappels) {
    //
    //        foreach ($rappels as $rappel) {
    //            if (($quote->quote_id == $rappel->rappel_object_id) && ($rappel->rappel_status == 1)) {
    //                $nb_rap+=1;
    //            }
    //        }
    //        foreach ($rappels as $rappel) {
    //            if ($quote->quote_id == $rappel->rappel_object_id) {
    //                $nb_ra+=1;
    //            }
    //        }
    //    }
    ?>
<tr id="line_<?php echo $quote->quote_id; ?>">
    <td>
        <a href="<?php echo site_url('quotes/view/' . $quote->quote_id); ?>" title="<?php echo lang('edit'); ?>">
            <?php echo $quote->quote_number; ?>
        </a>
    </td>
    <td style="text-align:center;">

        <span style="  font-size: 10px;margin-left: -12px; margin-top: 20px; color: #940c6c">
            <?php if (false && ($nb_ra > 0) && ($quote_statuses[$quote->quote_status_id]['label'][0] == 'E')) {?>
            <b><?php echo $nb_rap; ?>/<?php echo $nb_ra; ?></b>
            <?php }?>
        </span>
        <?php
$mot = 'rappel_devis';
    $this->db->like(trim("ip_tracking.action"), $mot);
    $this->db->where("ip_tracking.id_action", $quote->quote_id);
    $restrack = $this->db->get("ip_tracking")->result();
    ?>
        <span style=" margin-top: -20px;width: 75% !important;margin-left: 7px; cursor:pointer;"
            data-quote-id="<?php echo $quote->quote_id; ?>" title="<?php
if (count($restrack) == 1) {
        echo 'une relance';
    } elseif (count($restrack) == 0) {
        echo 'pas de relance';
    } else {
        echo count($restrack) . ' relances';
    }?> "

            class="change_quote_statuses label <?php echo $quote_statuses[$quote->quote_status_id]['class']; ?>"
            >
            <?php echo $quote_statuses[$quote->quote_status_id]['label'][0] ?>
        </span>
    </td>
    <td><?php echo date_from_mysql($quote->quote_date_created); ?></td>
    <td><?php echo date_from_mysql($quote->quote_date_expires); ?></td>

    <td style="width:100px;">
        <a href="<?php echo site_url('clients/view/' . $quote->client_id); ?>"
            title="<?php echo $quote->client_societe . " (" . $quote->client_name . ' ' . $quote->client_prenom . ")"; ?>">
            <?php
if ($quote->client_societe != '') {
        $client_name = $quote->client_societe;
    } else {
        $client_name = $quote->client_name . ' ' . $quote->client_prenom;
    }

    echo substr($client_name, 0, 20);
    if (strlen($client_name) > 20) {
        echo '<b style="color:#27871e">&nbsp;...</b>';
    }

    ?>

        </a>
    </td>

    <td><?php echo $quote->client_country; ?></td>
    <td style="width:100px;">
        <span title="<?php echo $quote->quote_nature; ?>">
            <?php
$nat = $quote->quote_nature;
    echo substr($nat, 0, 20);
    if (strlen($nat) > 20) {
        echo '<b style="color:#27871e">...</b>';
    }

    ?>
        </span>
    </td>
    <td><?php
echo format_devise($quote->quote_item_subtotal_final, $quote->devise_id);
    ?></td>
    <td><?php
echo format_devise($quote->quote_total_final, $quote->devise_id);
    ?></td>
    <td><?php echo substr($quote->delai_paiement_label, 0, -14); ?></td>
    <td><?php echo $quote->user_name; ?></td>
    <td><?php if (($quote->quote_status_id != 5) && ($quote->quote_status_id != 4)) {
        $data_send_mail = 1;
    } else {
        $data_send_mail = 0;
    }?>
        <div class="md-checkbox">
            <input type="checkbox" name="Choix[]" data-send_mail="<?php echo $data_send_mail; ?>"
                value="<?php echo $quote->quote_id; ?>" id="checkbox30_<?php echo $quote->quote_id; ?>" class="md-check"
                onchange="myFunctionchech(<?php echo $quote->quote_id; ?>)">
            <label for="checkbox30_<?php echo $quote->quote_id; ?>" <?php if ($data_send_mail == 0) {
        echo "style='color:red;' title='Pas de relance' class='tooltips' data-placement='left'";
    }
    ?>>
                <span></span>
                <span class="check"></span>
                <span class="box"></span>
            </label>
        </div>
    </td>
    <td>
        <div class="options btn-group">
            <a class="btn btn-sm btn-default dropdown-toggle option_btn" data-toggle="dropdown"
                data-id="<?php echo $quote->quote_id; ?>" href="#">
                <i class="fa fa-cog"></i> <?php //echo lang('options');      ?>
            </a>
            <ul class="dropdown-menu dropdown-btngroup-menu">
                <?php if ($sess_devis_add == 1) {?> <li>
                    <a href="<?php echo site_url('quotes/view/' . $quote->quote_id); ?>">
                        <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                    </a>
                </li>
                <?php }?>
                <li>
                    <a href="<?php echo site_url('quotes/generate_pdf/' . $quote->quote_id); ?>" target="_blank">
                        <i class="fa fa-file-pdf-o  fa-margin"></i> <?php echo lang('download_pdf'); ?>
                    </a>
                </li>
                <?php if (($quote->quote_status_id != 5) && ($quote->quote_status_id != 4)) {?>
                <li>
                    <a href="<?php echo site_url('mailer/quote/' . $quote->quote_id); ?>">
                        <i class="fa fa-send fa-margin"></i> <?php echo lang('send_email'); ?>
                    </a>
                </li>
                <?php if ($quote->invoice_id == 0 && rightsAddFacture()) {?>
                <li>
                    <a href="#" id="quote_to_invoice_<?php echo $quote_id; ?>" quote-id="<?php echo $quote_id; ?>"
                        data-quote-id="<?php echo $quote_id; ?>" class="quote_to_invoice">
                        <i class="fa fa-refresh fa-margin"></i>
                        <?php echo lang('quote_invoice'); ?>
                    </a>
                </li><?php }?>
                <?php if ($quote->bl_id == 0 && rightsAddFacture()) {?>
                <li>
                    <a href="#" id="quote_to_bl_<?php echo $quote_id; ?>" quote-id="<?php echo $quote_id; ?>"
                        data-quote-id="<?php echo $quote_id; ?>" class="quote_to_bl">
                        <i class="fa fa-refresh fa-margin"></i>
                        <?php echo lang('quote_bl'); ?>
                    </a>
                </li><?php }?>
                <?php if ($quote->fabrication_id == 0 && rightsAddFacture()) {?>
                <li>
                    <a href="#" id="fabrication_to_bl_<?php echo $quote_id; ?>" quote-id="<?php echo $quote_id; ?>"
                        data-quote-id="<?php echo $quote_id; ?>" class="fabrication_to_bl">
                        <i class="fa fa-refresh fa-margin"></i>
                        <?php echo lang('fabrication_bl'); ?>
                    </a>
                </li><?php }?>
                <?php if (false) {?>
                <li><a style="cursor: pointer;">
                        <input type="text" style="width: 100%;position: absolute;opacity: 0;cursor: pointer;"
                            class="simpliest-usage" id="multi_date_pick_<?php echo $quote->quote_id; ?>" />
                        <span class="calendar_a" id="span_pick_<?php echo $quote->quote_id; ?>">
                            <i class="fa fa-calendar fa-margin"
                                <?php if (@$arrayHasDates[$count] >= 1) {?>style=" cursor: pointer;color:red"
                                <?php } else {?>style=" cursor: pointer;color:#888" <?php }?>></i>
                            <?php echo lang('date_rappel'); ?></span>
                    </a>
                </li>
                <li>
                    <a class="calendar_a supp_rappel" id="supp_rappel_<?php echo $quote->quote_id; ?>" style="<?php ?>"
                        data-id="<?php echo $quote->quote_id; ?>"><i class="fa fa-trash-o fa-margin"></i>
                        <?php echo lang('delete_date_rappel'); ?></a>
                </li>
                <?php }?>
                <?php }?>
                <?php if ($sess_devis_del == 1) {?>
                <li>
                    <a href="<?php echo site_url('quotes/delete/' . $quote->quote_id); ?>"
                        onclick="return confirm('<?php echo lang('delete_quote_warning'); ?>');">
                        <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                    </a>
                </li>
                <?php }?>
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
        $quotes_total_amounts[$devise->devise_id]["quotes_sum_subtotal"] = isset($quotes_total_amounts[$devise->devise_id]["quotes_sum_subtotal"]) ? $quotes_total_amounts[$devise->devise_id]["quotes_sum_subtotal"] : 0;
        $quotes_total_amounts[$devise->devise_id]["quotes_sum_total"] = isset($quotes_total_amounts[$devise->devise_id]["quotes_sum_total"]) ? $quotes_total_amounts[$devise->devise_id]["quotes_sum_total"] : 0;
        $quotes_total_amounts[$devise->devise_id]["count"] = isset($quotes_total_amounts[$devise->devise_id]["count"]) ? $quotes_total_amounts[$devise->devise_id]["count"] : "0";
        ?>

<tr style="background: #E1F0FF; font-weight:bold;">
    <td colspan="6" style=" border:none; padding: 12px 8px;">
        <?php echo (int) $quotes_total_amounts[$devise->devise_id]["count"] . " (" . $devise->devise_symbole . ")"; ?>
    </td>
    <td colspan="2" style=" border:none; padding: 12px 15px; text-align: right;">
        <?php echo format_devise($quotes_total_amounts[$devise->devise_id]["quotes_sum_subtotal"], $devise->devise_id); ?>
    </td>
    <td colspan="2" style=" border:none; padding: 12px 15px;">
        <?php echo format_devise($quotes_total_amounts[$devise->devise_id]["quotes_sum_total"], $devise->devise_id); ?>
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
$start_line = isset($start_line) ? $start_line : 1;?>
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

        $('.change_quote_statuses').click(function() {
            //alert('hh');
            $('#modal-placeholder').load(
                "<?php echo site_url('quotes/ajax/modal_change_statut/0'); ?>", {
                    quote_id: $(this).data('quote-id')
                });
        });

        $('.quote_to_invoice').click(function() {
            quote_id = $(this).data('quote-id');
            $('#modal-placeholder').load(
                "<?php echo site_url('quotes/ajax/modal_quote_to_invoice'); ?>/" + quote_id);
        });
        $('.quote_to_bl').click(function() {
            quote_id = $(this).data('quote-id');
            $('#modal-placeholder').load(
                "<?php echo site_url('quotes/ajax/modal_quote_to_bl'); ?>/" + quote_id);
        });
        $('.fabrication_to_bl').click(function() {
            quote_id = $(this).data('quote-id');
            $('#modal-placeholder').load(
                "<?php echo site_url('quotes/ajax/modal_quote_to_fabrication'); ?>/" + quote_id);
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
                        $.post("<?php echo site_url('quotes/ajax/save_date_rappel'); ?>", {
                            dates: dates,
                            id_object: id_object,
                            type: 'quote'


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
            $.post("<?php echo site_url('quotes/ajax/getDateRappelQuote'); ?>", {
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
                $.post("<?php echo site_url('quotes/ajax/delete_rappel'); ?>", {
                    id_object: id_object

                }, function(data) {
                    var json_response = eval('(' + data + ')');
                    if (json_response.success == 1) {
                        window.location = "<?php echo site_url('quotes'); ?>/";
                    }
                });
            }
        });
    });
    var myInteger = 0;

    function myFunctionchech(e) {

        if ($("#checkbox30_" + e).is(':checked')) {
            myInteger = myInteger + 1;
        } else {
            myInteger = myInteger - 1;
        }
        if ($("#check_all").is(':checked')) {
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
        /* if (myInteger > 0) {
             $('#relance_rappel').prop("disabled", false);
             $('#export_excel').prop("disabled", false);
         } else {
             $('#relance_rappel').prop("disabled", true);
             $('#export_excel').prop("disabled", true);
         }*/
    };
    </script>

</tr>
<script>
</script>