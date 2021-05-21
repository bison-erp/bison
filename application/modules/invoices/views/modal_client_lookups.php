<script type="text/javascript">
$(function() {

    function numberFormat(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    function format_currency_javascript(amount, currency_symbol) {

        var nb_decimal = $('#tax_rate_decimal_places').val();
        var currency_symbol_placement = $('#currency_symbol_placement').val();
        var thousands_separator = $('#thousands_separator').val();
        var decimal_point = $('#decimal_point').val();




        if (currency_symbol_placement == 'before') {
            return currency_symbol + numberFormat(amount, nb_decimal, decimal_point, thousands_separator);
        } else {
            return numberFormat(amount, nb_decimal, decimal_point, thousands_separator) + currency_symbol;
        }
    }

    // Display the create invoice modal
    $('#modal-choose-items').modal('show');

    // Creates the invoice
    $('#select-items-confirm').click(function() {

        var client_ids = $("input[name='client_ids[]']:checked").val();

        $.post("<?php echo site_url('invoices/ajax/process_client_selections'); ?>", {
            client_ids: client_ids
        }, function(data) {

            console.log(data);

            var parsed = JSON.parse(data);
            var json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            client = json_response[0];
            console.log(client);

            $('#client_id').val(client.client_id);
            $('#client_address').val(client.client_address_1 + ' ' + client.client_zip + ' ' +
                client.client_city);
            $('#client_pays').val(client.client_country);
            $('#client_societe').val(client.client_societe);
            $('#client_titre option[value=' + client.client_titre + ']').attr('selected',
                'selected');

            $('#tax_code').val(client.client_tax_code);
            $('#vat_id').val(client.client_vat_id);
            $('#client_name').val(client.client_name + ' ' + client.client_prenom);
            $('#modal-choose-items').modal('hide');
            montant_remise = $('#montant_remise_quote').val();
            montant_remise = Number(montant_remise.replace(/[^0-9\.]+/g, ""));
            $('#montant_remise_quote').val(format_currency_javascript(montant_remise, client
                .devise_symbole));

            montant_acompte = $('#montant_acompte_quote').val();
            montant_acompte = Number(montant_acompte.replace(/[^0-9\.]+/g, ""));
            $('#montant_acompte_quote').val(format_currency_javascript(montant_acompte, client
                .devise_symbole));

            montant_sous_tot = $('#montant_sous_tot_quote').html();
            montant_sous_tot = Number(montant_sous_tot.replace(/[^0-9\.]+/g, ""));
            $('#montant_sous_tot_quote').html(format_currency_javascript(montant_sous_tot,
                client.devise_symbole));

            montant_sous_tot_hidden = $('#montant_sous_tot_quote_hidden').html();
            montant_sous_tot_hidden = Number(montant_sous_tot_hidden.replace(/[^0-9\.]+/g, ""));
            $('#montant_sous_tot_quote_hidden').html(format_currency_javascript(
                montant_sous_tot_hidden, client.devise_symbole));

            tot_tva = $('#tot_tva_quote').html();
            tot_tva = Number(tot_tva.replace(/[^0-9\.]+/g, ""));
            $('#tot_tva_quote').html(format_currency_javascript(tot_tva, client
            .devise_symbole));

            tot_tva_hidden = $('#tot_tva_quote_hidden').html();
            tot_tva_hidden = Number(tot_tva_hidden.replace(/[^0-9\.]+/g, ""));
            $('#tot_tva_quote_hidden').html(format_currency_javascript(tot_tva_hidden, client
                .devise_symbole));

            total = $('#total_quote').html();
            total = Number(total.replace(/[^0-9\.]+/g, ""));
            $('#total_quote').html(format_currency_javascript(total, client.devise_symbole));

            total_hidden = $('#total_quote_hidden').html();
            total_hidden = Number(total_hidden.replace(/[^0-9\.]+/g, ""));
            $('#total_quote_hidden').html(format_currency_javascript(total_hidden, client
                .devise_symbole));

            total_a_payer = $('#total_a_payer_quote').html();
            total_a_payer = Number(total_a_payer.replace(/[^0-9\.]+/g, ""));
            $('#total_a_payer_quote').html(format_currency_javascript(total_a_payer, client
                .devise_symbole));

            total_a_payer_hidden = $('#total_a_payer_quote_hidden').html();
            total_a_payer_hidden = Number(total_a_payer_hidden.replace(/[^0-9\.]+/g, ""));
            $('#total_a_payer_quote_hidden').html(format_currency_javascript(
                total_a_payer_hidden, client.devise_symbole));

            $('#timbre_fiscale_span').html(client.client_state);

            $('#symbole_devise').val(client.devise_symbole);

            $('#item_table tr.item').each(function() {
                subtotal = $(this).find(".subtotal").html();
                subtotal = Number(subtotal.replace(/[^0-9\.]+/g, ""));
                $(this).find(".subtotal").html(format_currency_javascript(subtotal,
                    client.devise_symbole));

                item_tax_total = $(this).find(".item_tax_total").html();
                item_tax_total = Number(item_tax_total.replace(/[^0-9\.]+/g, ""));
                $(this).find(".item_tax_total").html(format_currency_javascript(
                    item_tax_total, client.devise_symbole));

                item_total = $(this).find(".item_total").html();
                item_total = Number(item_total.replace(/[^0-9\.]+/g, ""));
                $(this).find(".item_total").html(format_currency_javascript(item_total,
                    client.devise_symbole));

            });

            $('#modal-choose-items').modal('hide');

        });

    });

    // Toggle checkbox when click on row
    $('#clients_table tr').click(function(event) {


        // $(':radio', '.modal-content').removeAttr('checked');

        //$(':radio', this).attr('checked', 'checked');
    });

    // Filter on search button click
    $('#filter-button').click(function() {
        clients_filter();
    });



    // Filter clients
    function clients_filter() {
        var filter_family = $('#filter_family').val();
        var filter_client = $('#filter_client').val();
        var lookup_url = "<?php echo site_url('invoices/ajax/modal_client_lookups'); ?>/";
        lookup_url += Math.floor(Math.random() * 1000) + '/?';



        if (filter_client) {
            lookup_url += "&filter_client=" + filter_client;
        }

        // refresh modal
        $('#modal-choose-items').modal('hide');
        $('#modal-placeholder').load(lookup_url);
    }

    $('#add_client_btn_modal').click(function() {
        $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_client_add'); ?>/" + Math
            .floor(Math.random() * 1000));
    });

});
</script>

<div id="modal-choose-items" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" role="dialog"
    aria-labelledby="modal-choose-items" aria-hidden="true">
    <form class="modal-content">
        <div class="modal-header" style=" border-bottom: 0px">



            <div class="form-inline">



                <!-- ToDo
                                <button type="button" id="reset-button" class="btn btn-default"><?php echo lang('reset'); ?></button>
                -->
            </div>
            <table style=" width: 100%">
                <tr>
                    <td ALIGN="center" VALIGN="MIDDLE" style=" width: 250px">
                        <h3><?php echo lang('add_client'); ?></h3> <br>
                    </td>
                    <td VALIGN="MIDDLE" style=" width: 400px">
                        <div class="form-group">
                            <div style=" width: 150px; margin-top: 30px; margin-left: 10px"><input type="text"
                                    class="form-control" name="filter_client" id="filter_client"
                                    placeholder="<?php echo lang('client_name'); ?>"
                                    value="<?php echo $filter_client ?>"></div>
                        </div>
                        <button style=" margin-top: -85px; margin-left: 180px" type="button" id="filter-button"
                            class="btn btn-default"><?php echo lang('search_client'); ?>
                        </button>
                    </td>
                    <td ALIGN="center" VALIGN="MIDDLE" style=" width: 200px">
                        <button type="button" id="add_client_btn_modal"
                            class="btn btn-default"><?php echo lang('create_client'); ?>
                        </button>
                    </td>
                    <td ALIGN="center" VALIGN="MIDDLE" style=" width: 10px"><a data-dismiss="modal" class="close"><i
                                class="fa fa-close"></i></a></td>
                </tr>
            </table>
        </div>
        <div class="modal-body" style="  margin-top: -40px;  border-top: 1px solid #e5e5e5;">


            <div class="table-responsive">
                <table id="clients_table" class="table table-bordered table-striped">
                    <tr>
                        <th style=" width: 30px">&nbsp;</th>
                        <th><?php echo lang('client_name_tab'); ?></th>
                        <th><?php echo lang('client_raison_tab'); ?></th>
                        <th><?php echo lang('client_email_tab'); ?></th>
                        <th><?php echo lang('client_telFix_tab'); ?></th>
                        <th><?php echo lang('client_telmobile_tab'); ?></th>
                        <th style=" display: none"><?php echo lang('active'); ?></th>
                    </tr>
                    <?php foreach ($clients as $client) {?>
                    <tr>
                        <td style=" width: 30px">
                            <input type="radio" name="client_ids[]" onclick="myFunction()"
                                value="<?php echo $client->client_id; ?>">
                        </td>
                        <td nowrap class="text-left">
                            <b><?php echo $client->client_name . ' ' . $client->client_prenom; ?></b>
                        </td>
                        <td>
                            <b><?php echo $client->client_societe; ?></b>
                        </td>
                        <td>
                            <b><?php echo $client->client_email; ?></b>
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
                </table>
            </div>
        </div>

        <div class="modal-footer" id="mod_footer" style=" display: none">
            <div class="btn-group">
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                    <?php echo lang('cancel'); ?>
                </button>
                <button class="btn btn-success" id="select-items-confirm" type="button">
                    <i class="fa fa-check"></i>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <script>
        function myFunction() {
            $("#mod_footer").show();
        }
        </script>
    </form>

</div>