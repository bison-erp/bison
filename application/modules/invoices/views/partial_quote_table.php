<script type="text/javascript">

    $(function () {
        $('.option_btn').click(function () {
            id_quote = $(this).data('id');

            $('#multi_date_pick_' + id_quote).datepick({
                prevText: 'Préc', nextText: 'Suiv', closeText: 'Valider', todayText: "Ajourd'hui",
                multiSelect: 1000, monthsToShow: 1, monthsToStep: 12,
                onSelect: function (dates) {
                    var datesCh = "" + $.datepick.formatDate('dd/mm/yyyy', dates[0]);
                    for (var i = 1; i < dates.length; i++) {
                        datesCh = datesCh + "," + $.datepick.formatDate('dd/mm/yyyy', dates[i]);
                    }
                    $('#selected_dates').val(datesCh);
                },
                onClose: function () {
                    var dates = $('#selected_dates').val();
                    if (dates != '') {
                        $.post("<?php echo site_url('quotes/ajax/save_date_rappel'); ?>", {
                            dates: dates,
                            id_quote: id_quote

                        }, function (data) {
                            var json_response = eval('(' + data + ')');
                            if (json_response.success == 1) {
                                $('#selected_dates').val('');
                                $('#span_pick_' + id_quote + ' i').css({'color': 'red'});
                                $('#supp_rappel_' + id_quote).css({'display': 'block'});
                                $('#supp_rappel_' + id_quote).css({'color': 'red'});


                            }
                        });
                    }

                },
                dateFormat: 'yyyy-mm-dd',
                selectDefaultDate: true
            });
            $.post("<?php echo site_url('quotes/ajax/getDateRappelQuote'); ?>", {
                quote_id: id_quote

            }, function (data) {
                var json_response = eval('(' + data + ')');
                var dates = json_response.dates;
                datesArray = dates.split(',');

                $('#multi_date_pick_' + id_quote).datepick('setDate', datesArray);
            });



        });


        $('.supp_rappel').click(function () {
            var quote_id = $(this).data('id');

            var r = confirm('<?php echo lang('msg_confirmation_delete_rappel'); ?>');
            if (r == true) {
                $.post("<?php echo site_url('quotes/ajax/delete_rappel'); ?>", {
                    id_quote: id_quote

                }, function (data) {
                    var json_response = eval('(' + data + ')');
                    if (json_response.success == 1) {
                        window.location = "<?php echo site_url('quotes'); ?>/";
                    }
                });
            }
        });


    });
</script>

<?php
$sess_devis_add = $this->session->userdata['devis_add'];
$sess_devis_del = $this->session->userdata['devis_del'];
$sess_devis_index = $this->session->userdata['devis_index'];
?>
<div class="table-responsive">
    <table class="table table-striped" id="quote_all" >

        <thead>
            <tr>
                <th ><?php echo lang('num_devis'); ?></th>
                <th ><?php echo lang('status_tab'); ?></th>
                <th><?php echo lang('created'); ?></th>
                <th><?php echo lang('due_date'); ?></th>
                <th style=" width: 100px "><?php echo lang('client_name'); ?></th>
                <th><?php echo lang('client_pays'); ?></th>
                <th style=" width: 250px "><?php echo lang('quote_nature'); ?></th>
                <th style=" width: 150px"><?php echo lang('amount_ht'); ?></th>
                <th style=" width: 150px"><?php echo lang('amount_ttc'); ?></th>
                <th><?php echo lang('mode_pmt'); ?></th>
                <th><?php echo lang('suivi'); ?></th>
                <th><?php echo lang('date_modified'); ?></th>
                <th><?php echo lang('user_modified'); ?></th>
                <th><?php echo lang('options'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $mont_tot_ht_dt = 0;
            $mont_tot_ttc_dt = 0;
            $count_dt = 0;

            $mont_tot_ht_dol = 0;
            $mont_tot_ttc_dol = 0;
            $count_dol = 0;

            $mont_tot_ht_eur = 0;
            $mont_tot_ttc_eur = 0;
            $count_eur = 0;
            $dev1 = 'DT';
            $dev2 = '$';
            $dev3 = '€';
            ?>
        <!--<pre>
            <?php print_r($quotes); ?>
        </pre>-->
            <?php
            foreach ($quotes as $quote) {
                $nb_rap = 0;
                $nb_ra = 0;

                if (@$rappel_quotes) {
                    foreach ($rappel_quotes as $rappel) {
                        if (($quote->quote_id == $rappel->rappel_qote_id) && ($rappel->rappel_status == 1)) {
                            $nb_rap+=1;
                        }
                    }
                    foreach ($rappel_quotes as $rappel) {
                        if ($quote->quote_id == $rappel->rappel_qote_id) {
                            $nb_ra+=1;
                        }
                    }
                }
                ?>
                <?php
                if ($quote->client_devise_id == 1) {
                    $dev1 = $quote->devise_symbole;
                }
                if ($quote->client_devise_id == 2) {
                    $dev2 = $quote->devise_symbole;
                }
                if ($quote->client_devise_id == 7) {
                    $dev3 = $quote->devise_symbole;
                }
                ?>
                <tr>

                    <td >
                        <!--<input type="hidden" value="<?php echo $quote->quote_id; ?>" id="id_quote_<?php echo $count; ?>"/>-->
                        <input type="hidden" value="<?php echo $quote->quote_id; ?>" id="id_quote_<?php echo $quote->quote_id; ?>"/>
                        <a href="<?php echo site_url('quotes/view/' . $quote->quote_id); ?>"
                           title="<?php echo lang('edit'); ?>">
                               <?php echo $quote->quote_number; ?>
                        </a>
                    </td>
                    <td>            
                       <!-- <pre>
                        <?php print_r($quote_statuses); ?><br><?php echo $quote_statuses[$quote->quote_status_id]['class']; ?>
                        </pre>-->

                        <span  style=" font-size: 10px; margin-left: -20px; margin-top: 20px; color: #940c6c">
                            <?php if (($nb_ra > 0) && ($quote_statuses[$quote->quote_status_id]['label'][0] == 'E')) { ?>
                                <b><?php echo $nb_rap; ?>/<?php echo $nb_ra; ?></b>
                            <?php } ?>
                        </span>
                        <span style=" margin-top: -20px"class="label <?php echo $quote_statuses[$quote->quote_status_id]['class']; ?>">
                            <?php echo $quote_statuses[$quote->quote_status_id]['label'][0] ?>  
                        </span>

                    </td>
                    <td>
                        <?php
                        //echo date_from_mysql($quote->quote_date_created);
                        $dat0 = explode('-', $quote->quote_date_created);
                        echo $dat0[2] . '/' . $dat0[1] . '/' . $dat0[0];
                        ?>
                    </td>
                    <td>
    <?php //echo date_from_mysql($quote->quote_date_expires);
                            $dat11 = explode('-', $quote->quote_date_expires);
    echo $dat11[2] . '/' . $dat11[1] . '/' . $dat11[0];
    ?>
                    </td>
                    <td style=" width: 200px">
                        <a href="<?php echo site_url('clients/view/' . $quote->client_id); ?>"
                           title="<?php echo lang('view_client'); ?>">
    <?php echo $quote->client_name . ' ' . $quote->client_prenom; ?>
                        </a>
                    </td>
                    <td>
    <?php echo $quote->client_country; ?>
                    </td>
                    <td>
    <?php echo $quote->quote_nature; ?>
                    </td>
                    <td>
                        <?php echo format_currency_without_symbol($quote->quote_item_subtotal_final); ?>
                        <?php
                        if ($quote->client_devise_id == 1) {
                            echo ' ' . $dev1;
                            $mont_tot_ht_dt += $quote->quote_item_subtotal_final;
                        }
                        if ($quote->client_devise_id == 2) {
                            echo ' ' . $dev2;
                            $mont_tot_ht_dol += $quote->quote_item_subtotal_final;
                        }
                        if ($quote->client_devise_id == 7) {
                            echo ' ' . $dev3;
                            $mont_tot_ht_eur += $quote->quote_item_subtotal_final;
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo format_currency_without_symbol($quote->quote_total_final); ?>
                        <?php
                        if ($quote->client_devise_id == 1) {
                            echo ' ' . $dev1;
                            $mont_tot_ttc_dt += $quote->quote_total_final;
                        }
                        if ($quote->client_devise_id == 2) {
                            echo ' ' . $dev2;
                            $mont_tot_ttc_dol += $quote->quote_total_final;
                        }
                        if ($quote->client_devise_id == 7) {
                            echo ' ' . $dev3;
                            $mont_tot_ttc_eur += $quote->quote_total_final;
                        }
                        ?>
                    </td>
                    <?php
                    $quote_date_accepte = $quote->quote_date_accepte;
                    if ($quote_date_accepte == '') {
                        $quote_date_accepte = date_from_mysql('0000-00-00');
                    } else {
                        $quote_date_accepte = date_from_mysql($quote->quote_date_accepte);
                    }
                    ?>
                    <td style=" display: none">
    <?php //echo $quote_date_accepte;
                                $dat12 = explode('-', $quote->quote_date_accepte);
                        echo $dat12[2] . '/' . $dat12[1] . '/' . $dat12[0];
    ?>
                    </td>
                    <td>
    <?php echo substr($quote->delai_paiement_label, 0, -14); ?>
                    </td>
                    <td>
                    <?php echo $quote->user_name; ?>
                    </td>
                    <?php
                    $quote_date_modif = $quote->quote_date_modif;
                    if ($quote_date_modif == '') {
                        $quote_date_modif = date_from_mysql('0000-00-00');
                    } else {
                        $quote_date_modif = date_from_mysql($quote->quote_date_modif);
                    }
                    ?>
                    <td>
    <?php //echo $quote_date_modif;
                                    $dat13 = explode('-', $quote->quote_date_modif);
                        echo $dat13[2] . '/' . $dat13[1] . '/' . $dat13[0];?>
                    </td>

                    <td>
    <?php echo $quote->user_name_modif; ?>
                    </td>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-sm btn-default dropdown-toggle option_btn" data-toggle="dropdown" data-id="<?php echo $quote->quote_id; ?>"
                               href="#">
                                <i class="fa fa-cog"></i> <?php //echo lang('options');         ?>
                            </a>
                            <ul class="dropdown-menu" >
    <?php if ($sess_devis_add == 1) { ?> <li>
                                        <a href="<?php echo site_url('quotes/view/' . $quote->quote_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php echo lang('edit'); ?>
                                        </a>
                                    </li><?php } ?>
                                <li>
                                    <a href="<?php echo site_url('quotes/generate_pdf/' . $quote->quote_id); ?>"
                                       target="_blank">
                                        <i class="fa fa-print fa-margin"></i> <?php echo lang('download_pdf'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('mailer/quote/' . $quote->quote_id); ?>">
                                        <i class="fa fa-send fa-margin"></i> <?php echo lang('send_email'); ?>
                                    </a>
                                </li>

                                <li>
                                    <input type="text" class="simpliest-usage" id="multi_date_pick_<?php echo $quote->quote_id; ?>" />
                                    <span class="calendar_a" id="span_pick_<?php echo $quote->quote_id; ?>"><i class="fa fa-calendar fa-margin" <?php if (@$arrayHasDates[$count] == 1) { ?>style="color:red"<?php } ?>></i> <?php echo lang('date_rappel'); ?></span>

                                </li>

                                <li>

                                    <a class="calendar_a supp_rappel" id="supp_rappel_<?php echo $quote->quote_id; ?>" style="<?php
                                    if (@$arrayHasDates[$count] == 1) {
                                        echo 'color:red';
                                    } else {
                                        echo 'display:none';
                                    }
                                    ?>" data-id="<?php echo $quote->quote_id; ?>"><i class="fa icon-calendar-empty fa-margin" ></i> <?php echo lang('delete_date_rappel'); ?></a>

                                </li>

    <?php if ($sess_devis_del == 1) { ?> <li>
                                        <a href="<?php echo site_url('quotes/delete/' . $quote->quote_id); ?>"
                                           onclick="return confirm('<?php echo lang('delete_quote_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                        </a>
                                    </li><?php } ?>
                            </ul>
                        </div>
                    </td>
                    <td>


                    </td>
                </tr>
                <?php
                if ($quote->client_devise_id == 1) {
                    $count_dt++;
                }
                if ($quote->client_devise_id == 2) {
                    $count_dol++;
                }
                if ($quote->client_devise_id == 7) {
                    $count_eur++;
                }
            }
            ?>
            <tr id="total_quotes" border="1">
                <td colspan="3"><b>TOTAL: <?php echo $count_dt . ' (' . $dev1 . ')'; ?><br><?php echo $count_dol . ' (' . $dev2 . ')'; ?><br><?php echo $count_eur . ' (' . $dev3 . ')'; ?></b></td>
                <td colspan="4"></td>
                <td><?php echo format_currency_without_symbol($mont_tot_ht_dt) . $dev1; ?><br><?php echo format_currency_without_symbol($mont_tot_ht_dol) . $dev2; ?>
                    <br><?php echo format_currency_without_symbol($mont_tot_ht_eur) . $dev3; ?></td>
                <td><?php echo format_currency_without_symbol($mont_tot_ttc_dt) . $dev1; ?><br><?php echo format_currency_without_symbol($mont_tot_ttc_dol) . $dev2; ?>
                    <br><?php echo format_currency_without_symbol($mont_tot_ttc_eur) . $dev3; ?></td>
                <td colspan="6"></td>
            </tr>
        </tbody>

    </table>
    <input type="hidden" id="selected_dates" value=""/>
    <input type="hidden" id="selected_dates_bool" value=""/>
</div>