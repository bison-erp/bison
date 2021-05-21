<style>
.modal .modal-header {
    height: 79px;
}

.md-radio label {
    padding-left: 20px !important;
}

#clients_table {
    margin-top: 6px;
}
</style>
<script type="text/javascript">
$(function() {

    // Display the create invoice modal
    $('#modal-choose-items').modal('show');

    // Creates the invoice
    $('#select-items-confirmx').click(function() {

        var client_ids = $("input[name='client_ids[]']:checked").val();

        $.post("<?php echo site_url('clients/ajax/process_client_selection'); ?>", {
            client_ids: client_ids
        }, function(data) {
            var parsed = JSON.parse(data);
            var json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            client = json_response[0];
            documenttabl = json_response[2];
            //file_name
            //id_document
            //console.log(documenttabl);
            $("#documenttable  tbody tr").remove();
            $('#listdocument').val('');
            tab = [];
            for (var x in documenttabl) {
                var row_add = '<tr class="tr_docselect_' + documenttabl[x][
                        'id_document'
                    ] +
                    '">';
                row_add +=
                    '<td align="left"  onchange="mydoc(' + documenttabl[x][
                        "id_document"
                    ] + ')"  style="width: 25px;"><input type="checkbox" id="doccheck' +
                    documenttabl[x][
                        "id_document"
                    ] + '" value="' + documenttabl[x][
                        "id_document"
                    ] + '"></td>';
                row_add +=
                    '<td align="left"  class="attrValue" style="width: 25px;"><span>' +
                    documenttabl[x][
                        "file_name"
                    ] + '</span></td>';
                row_add += '</tr>';
                $("#documenttable tbody").append(row_add);
            }
            $("#documenttable").hide();
            $('#drap').val('0');
            $("#drap").prop('checked', false);
            $('#symbole_devise').val(client[0].devise_symbole);
            $('#tax_rate_decimal_places').val(client[0].number_decimal);
            $('#currency_symbol_placement').val(client[0].symbole_placement);
            $('#thousands_separator').val(client[0].thousands_separator);

            timbre = json_response[1];
            if (client[0].timbre_fiscale == 1) {
                $('#timbre_fiscale_span').html(beautifyFormat(timbre, "float"));
            } else {
                $('#timbre_fiscale_span').html(beautifyFormat(0, "float"));
            }
            $('#client_id').val(client[0].client_id);
            $('#devise').val(client[0].client_devise_id);
            $('#fact_prod .devise_view').each(function() {

                $(this).text(client[0].devise_symbole);

            });

            <?php
$this->load->model('settings/mdl_settings');
if ($this->mdl_settings->gettypetaxeinvoice() == 1) {?>
            if (client[0].symbole_placement == "before") {
                 $('#fact_prod .devise_view').each(function() {
                     if ($(this).hasClass("view_before")) {
                         $(this).show();
                     } else if ($(this).hasClass("view_after")) {
                         $(this).hide();
                     }
                 });
             } else {
                 $('#fact_prod .devise_view').each(function() {
                     if ($(this).hasClass("view_after")) {
                         $(this).show();
                     } else if ($(this).hasClass("view_before")) {
                         $(this).hide();
                     }
                 });
             }
            <?php }?>
            if ($("#action").val() != "edit") {
                $('#client_address').val(client[0].client_address_1 + ' ' + client[0]
                    .client_zip + ' ' + client[0].client_city);
                $('#client_pays').val(client[0].client_country);
                $('#client_societe').val(client[0].client_societe);
                $('#client_titre option[value=' + client[0].client_titre + ']').attr('selected',
                    'selected');
                t = client[0].client_titre;
                if (t == 0)
                    titr = 'M.';
                if (t == 1)
                    titr = 'Mme.';
                if (t == 2)
                    titr = 'Melle.';
                $('#tax_code').val(client[0].client_tax_code);
                $('#vat_id').val(client[0].client_vat_id);
                $('#client_name').val(titr + ' ' + client[0].client_name + ' ' + client[0]
                    .client_prenom);
                $('#modal-choose-items').modal('hide');


                $('#montant_remise_invoice').val(beautifyFormat(0, "float"));
                $('#montant_acompte_invoice').val(beautifyFormat(0, "float"));
                $('#montant_sous_tot_invoice').text(beautifyFormat(0, "float"));
                $('#tot_tva_invoice').text(beautifyFormat(0, "float"));
                $('#total_invoice').text(beautifyFormat(0, "float"));
                $('#total_a_payer_invoice').text(beautifyFormat(0, "float"));
            } else {
                $('client_id').val(client[0].client_id);
                t = client[0].client_titre;
                if (t == 0)
                    titr = 'M.';
                if (t == 1)
                    titr = 'Mme.';
                if (t == 2)
                    titr = 'Melle.';
                var client_fullname =
                    '<h4><b><a href="<?php echo base_url() . ' / clients / view / '; ?>' +
                    client[
                        0]
                    .client_id + '">' + titr + ' ' + client[0].client_name + ' ' + client[0]
                    .client_prenom + '</a></h4></b><br>';
                var client_address_1 = client[0].client_address_1;
                var client_address_2 = client[0].client_address_2;
                var client_city = client[0].client_city;
                var client_state = client[0].client_state;
                var client_zip = client[0].client_zip;
                var client_country = client[0].client_country;
                var client_phone = client[0].client_phone;
                var client_email = client[0].client_email;
                var client_societe = "<b>Sociéte:</b> " + client[0].client_societe;
                var adresse = "<br><b>Adresse: </b>" + client_address_1 + " " +
                    client_address_2 +
                    " " +
                    client_zip + "," +
                    client_country;
                var Code_tva = "<br><b>Code TVA:</b> " + client[0].client_mobile;
                $('#client_infos_edit').html(client_fullname + "<br>" + client_societe +
                    '<br>' + adresse +
                    "<br><br><b> N°Téléphone:</b> " +
                    client_phone + " - " + client[0].client_mobile +
                    "<br><br><b> Email :</b> " +
                    client_email + '<br><br><b> Code TVA </b>' + client[0].client_vat_id +
                    '<br><br><b>Registre de commerce </b>' + client[0].client_tax_code);

            }
            if ($("#type_doc").val() == "invoice" && $("#action").val() != "edit") {
                var client_id = client[0].client_id;
                updatePaymentList(client_id);


                if ($('#invoice_nature').attr('disabled') == 'disabled') {

                    $('#fact_prod').show();
                    $('#invoice_nature').attr('disabled', false);
                    $('#invoice_date_created').attr('disabled', false);
                    $('#invoice_date_expires').attr('disabled', false);
                    $('#invoice_delai_paiement').attr('disabled', false);
                    $('#invoice_password').attr('disabled', false);
                    $('#invoice_status_id').attr('disabled', false);
                    $('#payment_method').attr('disabled', false);
                    $('#btn_add_row').attr('disabled', false);
                    $('#btn_add_product').attr('disabled', false);

                    $('.name_prod').attr('disabled', false);
                    $('.desc_prod').attr('disabled', false);
                    $('.item_quantity').attr('disabled', false);
                    $('.item_price').attr('disabled', false);
                    $('.item_tax_rate_id').attr('disabled', false);
                    $('.subtotal').attr('disabled', false);
                    $('.item_tax_total').attr('disabled', false);
                    $('.item_total').attr('disabled', false);

                    $('#client_titre').attr('disabled', false);
                    $('#client_name').attr('disabled', false);
                    $('#client_societe').attr('disabled', false);
                    $('#client_address').attr('disabled', false);
                    $('#client_pays').attr('disabled', false);
                    $('#vat_id').attr('disabled', false);
                    $('#tax_code').attr('disabled', false);
                    // Liste du paiements du client




                }
            }
            if ($("#type_doc").val() == "quote") {
                if ($('#quote_nature').attr('disabled') == 'disabled') {
                    $('#fact_prod').show();
                    $('#quote_nature').attr('disabled', false);
                    $('#quote_date_created').attr('disabled', false);
                    $('#quote_date_expires').attr('disabled', false);
                    $('#quote_delai_paiement').attr('disabled', false);
                    $('#quote_password').attr('disabled', false);
                    $('#quote_status_id').attr('disabled', false);
                    $('#payment_method').attr('disabled', false);
                    $('#btn_add_row').attr('disabled', false);
                    $('#quote_date_accepte').attr('disabled', false);
                    $('#btn_add_product').attr('disabled', false);

                    $('.name_prod').attr('disabled', false);
                    $('.desc_prod').attr('disabled', false);
                    $('.item_quantity').attr('disabled', false);
                    $('.item_price').attr('disabled', false);
                    $('.item_tax_rate_id').attr('disabled', false);
                    $('.subtotal').attr('disabled', false);
                    $('.item_tax_total').attr('disabled', false);
                    $('.item_total').attr('disabled', false);

                    $('#client_titre').attr('disabled', false);
                    $('#client_name').attr('disabled', false);
                    $('#client_societe').attr('disabled', false);
                    $('#client_address').attr('disabled', false);
                    $('#client_pays').attr('disabled', false);
                    $('#vat_id').attr('disabled', false);
                    $('#tax_code').attr('disabled', false);


                }
            }



            $('#modal-choose-items').modal('hide');
        });
    });

    $('#filter_client').keyup(function() {
        clients_filter();
    });

    function clients_filter() {
        var filter_family = $('#filter_family').val();
        var filter_client = $('#filter_client').val();
        var lookup_url = "<?php echo site_url('clients/ajax/partial_modal_client_lookup'); ?>/";
        lookup_url += Math.floor(Math.random() * 1000) + '/?';
        if (filter_client) {
            lookup_url += "&filter_client=" + filter_client;
        }
        $("#clients_table tbody").load(lookup_url, {
            type_doc: $("#type_doc").val()
        });
    }

    $('#add_client_btn_modal').click(function() {
        $('#modal-choose-items').modal('hide');

        $('#modal-placeholder').load("<?php echo site_url('clients/ajax/modal_client_add'); ?>/" + Math
            .floor(Math.random() * 1000), {
                type_doc: $("#type_doc").val()
            });
    });

});
</script>
<input hidden type="checkbox" id="checkboxtest" value="">

<input type="hidden" id="type_doc" value="<?php echo $type_doc; ?>">
<input type="hidden" id="action" value="<?php echo $action; ?>">
<div id="modal-choose-items" class="modal devis-client col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true"
    style="display: block;width: 65%;height: 85%;overflow:hidden !important;z-index: 99999;background-color: #Fffff;margin-top: 22px;border-radius: 6px;">
    <div class="modal-content" style=" width: 100%">
        <div class="modal-header devis-client"
            style=" width: 64%;position: fixed; z-index: 999 ;border-bottom: 0px;height: 100xp;  background-color: rgb(255, 255, 255) !important; ">
            <div class="form-inline" style="border-bottom: 1px solid #e5e5e5; width: 100%">
                <div class="row">
                    <div class="col-md-3" style="font-weight: 600;font-size: 18px;margin-bottom: 14px;">
                        <?php echo lang('add_client'); ?> </div>
                    <div class=" col-md-3">
                        <input type="text" class="form-control" name="filter_client" id="filter_client"
                            placeholder="<?php echo lang('client_name'); ?>" value="<?php echo $filter_client ?>"
                            autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="add_client_btn_modal"
                            class="btn btn-default"><?php echo lang('create_client'); ?></button>
                    </div>
                    <div class=" col-md-3" id="mod_footer" style=" white-space: nowrap;width: 250px;display: none">
                        <div class="btn-group">
                            <button class="btn default" type="button" data-dismiss="modal">
                                <i class="fa fa-times"></i>
                                <?php echo lang('cancel'); ?>
                            </button>
                            <button class="btn btn-success" id="select-items-confirmx" type="button">
                                <i class="fa fa-check"></i>
                                <?php echo lang('submit'); ?>
                            </button>
                        </div>
                    </div>
                    <button data-dismiss="modal" type="button" class="close btn blue btn-success"
                        style="width: 22px; height: 20px; color: #FFF !important; background-image: none !important; background-color: rgb(220, 53, 88) !important; text-align: center; position: absolute; text-indent: 0px; opacity: 1; top: 10px; right: 0px;">
                        <i class="fa fa-close"></i></button>
                </div>
            </div>

        </div>
        <div class="modal-body" style="  z-index: 888; margin-top: 94px;  ">
            <div class="table-responsive">
                <table id="clients_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style=" width: 20px">&nbsp;</th>
                            <th><?php echo lang('client_name_tab'); ?></th>
                            <th><?php echo lang('client_raison_tab'); ?></th>
                            <th><?php echo lang('client_email_tab'); ?></th>
                            <th><?php echo lang('client_telFix_tab'); ?></th>
                            <th><?php echo lang('client_telmobile_tab'); ?></th>
                            <th style=" display: none"><?php echo lang('active'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client) {?>
                        <tr>
                            <td style=" width: 30px">
                                <div class="md-radio">
                                    <input type="radio" id="radio1<?php echo $client->client_id; ?>" name="client_ids[]"
                                        onclick="myFunction()" class="md-radiobtn"
                                        value="<?php echo $client->client_id; ?>">
                                    <label for="radio1<?php echo $client->client_id; ?>">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </td>
                            <td nowrap class="text-left">
                                <b><?php echo $client->client_name . ' ' . $client->client_prenom; ?></b>
                            </td>
                            <td>
                                <b><?php echo $client->client_societe; ?></b>
                            </td>
                            <td>
                                <?php echo $client->client_email; ?>
                            </td>
                            <td>
                                <?php echo $client->client_phone; ?>
                            </td>
                            <td>
                                <?php echo $client->client_mobile; ?>
                            </td>
                            <td style=" display: none">
                                <?php echo ($client->client_active) ? lang('yes') : lang('no'); ?>
                            </td>
                        </tr>

                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
        function myFunction() {
            $("#mod_footer").show();
        }
        </script>
    </div>

</div>