<style>
    .form-group.form-md-line-input .form-control{  padding-left: 1px;}
    .datepicker table tr td.day:hover,.datepicker table tr td.day.focused{background:#eee;cursor:pointer;border-radius: 4px;}
    .datepicker .active{  background-color: #4B8DF8 !important;background-image: none !important;filter: none !important;border-radius: 4px;}
</style>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

    function changeCalculDownTable() {
        var subtotal = 0;
        var item_total = 0;
        var item_tax_rate = 0;
        $('#item_table tr.item').each(function () {
            subtotal += Number(accepted_float_input($(this).find(".subtotal").val()));
            item_total += Number(accepted_float_input($(this).find(".item_total").val()));
            item_tax_rate += Number(accepted_float_input($(this).find(".subtotal").val())) * Number(accepted_float_input($(this).find(".item_tax_rate_id option:selected").text()) / 100);

        });
        var montant_remise = accepted_float_input($("#montant_remise_invoice").val());
        var persent_remise = accepted_float_input($("#pourcent_remise_invoice").val());
        var timbre_fiscale = accepted_float_input($("#timbre_fiscale_span").text());
        subtotal = subtotal * (1 - (Number(persent_remise) / 100));
        item_tax_rate = item_tax_rate * (1 - (Number(persent_remise) / 100));
        item_total = subtotal + item_tax_rate + Number(timbre_fiscale);
        
        $("#montant_sous_tot_invoice").text(numberFormatFloat(subtotal));
        $("#tot_tva_invoice").text(numberFormatFloat(item_tax_rate));
        $("#total_invoice").text(numberFormatFloat(item_total));
    }
    function changeTotalPaye() {
        var total = accepted_float_input($("#total_invoice").text());
        var montant_acompte = accepted_float_input($("#montant_acompte_invoice").val());
        

        var total_paye = Number(total) - Number(montant_acompte);
        if (total_paye < 0)
            $("#total_a_payer_invoice").parent().addClass("error_value");
        else
            $("#total_a_payer_invoice").parent().removeClass("error_value");
        $("#total_a_payer_invoice").text(beautifyFormat(total_paye, "float"));
    }
    function addRow(items) {
        if (!items) {
            var item_code_value = "";
            var item_description_value = "";
            var item_quantity_value = "1";
            var item_price_value = "0.000";
            var subtotal_value = "0.000";
            var item_tax_rate_id_value = 0;
            var item_total_value = "0.000";
        }
        else {
            var item_code_value = items.product_sku;
            var item_description_value = items.product_description;

            var item_quantity_value = items.product_quantite ? parseInt(items.product_quantite) : 1;
            var item_price_value = beautifyFormat(items.product_price_dev, "float");
            var subtotal_value = items.product_subtotal ? beautifyFormat(items.product_subtotal, "float") : beautifyFormat(items.product_price_dev, "float");
            var item_tax_rate_id_value = items.tax_rate_id_dev;
            var item_total_value = beautifyFormat(items.montantTVATotal, "float");
        }
        // import tax Rate
        var row_add_tax = "";
        $.post("<?php echo site_url('tax_rates/ajax/getTaxRate'); ?>", function (data) {
            var tax_rates_all = JSON.parse(data);
            $.each(tax_rates_all, function (k, v) {
                row_add_tax += '<option value="' + v.tax_rate_id + '"';
                if (item_tax_rate_id_value == v.tax_rate_id) {
                    row_add_tax += ' selected = "selected" ';
                }
                row_add_tax += '>' + v.tax_rate_percent + '</option>';
            });
            var current_id = $("#current_id_table_invoice").val();
            var row_add = '<tr class=" item ui-sortable-handle tr_prod_' + current_id + '">';
            row_add += '<td align="center" style="width: 25px;"><i class="fa fa-arrows cursor-move"></i></td>';
            row_add += '<td style="width: 200px;"><input type="text" name="item_code" id="item_code_' + current_id + '" class="name_prod form-control" class="form-control" value="' + item_code_value + '" autocomplete="off" data-id="' + current_id + '"></td>';
            row_add += '<td><textarea id="item_description_' + current_id + '" name="item_description" class="form-control desc_prod">' + item_description_value + '</textarea></td>';
            row_add += '<td><input type="number" class="input-sm form-control item_quantity" data-id="' + current_id + '" name="item_quantity" id="item_quantity_' + current_id + '" value="' + item_quantity_value + '"></td>';
            row_add += '<td><input type="text" class="input-sm form-control item_price" name="item_price" value="' + item_price_value + '" data-id="' + current_id + '" id="item_price_' + current_id + '"></td>';
            row_add += '<td style="width: 120px;"> <input name="subtotal" class="subtotal input-sm form-control" data-id="' + current_id + '" id="subtotal_' + current_id + '" value="' + subtotal_value + '"></td>';
            row_add += '<td style="width: 110px;"><select  name="item_tax_rate_id" class="input-sm form-control item_tax_rate_id"  data-id="' + current_id + '" id="item_tax_rate_' + current_id + '"> ' + row_add_tax + ' </select></td>';
            row_add += '<td style="width: 120px;"><input name="item_total" class="item_total input-sm form-control" data-id="' + current_id + '" id="item_total_' + current_id + '" value="' + item_total_value + '"></td>';
            row_add += '<td style="width:40px;" class="td-icon" align="center"> <a class="delete_row" title="Supprimer" data-id="' + current_id + '" id="delete_row_' + current_id + '"><i class="fa fa-trash-o text-danger"></i></a>';
            row_add += '<input type="hidden" name="family_id" value="0">';
            row_add += '<input type="hidden" name="item_name" value="' + item_code_value + '">';
            row_add += '<input type="hidden" name="etat_champ" value="1">';
            row_add += "</td>";
            row_add += "/<tr>";

            $("#item_table tbody").append(row_add);
            $("#current_id_table_invoice").val(parseInt(current_id) + 1);
            $('#item_table').find('tr.item').find('#delete_row_' + current_id).click(function () {
                $(".tr_prod_" + current_id).remove();
                changeCalculDownTable();
                changedPercentRemise();
                changedPercentAcompte();
                changeTotalPaye();
            });
            $('#item_table').find('tr.item').find('#item_quantity_' + current_id).keyup(function () {
                changedItemTable($(this), "quantite", "int");
                $(this).focusout(function () {
                    $(this).val(beautifyFormat($(this).val(), "int"));
                });
            });
            $('#item_table').find('tr.item').find('#item_quantity_' + current_id).change(function () {
                changedItemTable($(this), "quantite", "int");
                $(this).focusout(function () {
                    $(this).val(beautifyFormat($(this).val(), "int"));
                });
            });
            $('#item_table').find('tr.item').find('#item_price_' + current_id).keyup(function () {
                changedItemTable($(this), "prix_unitaire", "float");
                $(this).focusout(function () {
                    $(this).val(beautifyFormat($(this).val(), "float"));

                });
            });
            $('#item_table').find('tr.item').find('#subtotal_' + current_id).keyup(function () {
                changedItemTable($(this), "subtotal", "float");
                $(this).focusout(function () {
                    $(this).val(beautifyFormat($(this).val(), "float"));
                });
            });
            $('#item_table').find('tr.item').find('#item_tax_rate_' + current_id).change(function () {
                changedItemTable($(this), "tax_rate", "float");
            });
            $('#item_table').find('tr.item').find('#item_total_' + current_id).keyup(function () {
                changedItemTable($(this), "total", "float");
                $(this).focusout(function () {
                    $(this).val(beautifyFormat($(this).val(), "float"));
                });
            });

            $(".name_prod").focus();
            $('.name_prod').typeahead();

            changeCalculDownTable();
            changedPercentRemise();
            changedPercentAcompte();
            changeTotalPaye();
        });

    }
    function changedItemTable(curr, item, type) {
        var dataid = curr.data('id');
        var id = curr.attr('id');
        var valeur = curr.val();

        if (type == "int")
        {
            if (accepted_integer_input(valeur) != valeur)
            {
                $("#" + id).val(accepted_integer_input(valeur));
                valeur = accepted_integer_input(valeur);
            }
        }
        else if (type == "float")
        {
            if (accepted_float_input(valeur) != valeur)
            {
                $("#" + id).val(accepted_float_input(valeur));
                valeur = accepted_float_input(valeur);
            }
        }

        switch (item) {
            case "quantite":
                {
                    var item_price = accepted_float_input($("#item_price_" + dataid).val());
                    var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
                    var subtotal = item_price * valeur;
                    var itemtotal = subtotal * (1 + (item_tax_rate / 100));
                    $("#subtotal_" + dataid).val(numberFormatFloat(subtotal));
                    $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
                }
                break;
            case "prix_unitaire":
                {
                    var quantite = accepted_integer_input($("#item_quantity_" + dataid).val());
                    var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
                    var subtotal = quantite * valeur;
                    var itemtotal = subtotal * (1 + (item_tax_rate / 100));
                    $("#subtotal_" + dataid).val(numberFormatFloat(subtotal));
                    $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
                }
                break;
            case "subtotal":
                {
                    var quantite = accepted_integer_input($("#item_quantity_" + dataid).val());
                    if (Number(quantite) == 0) {
                        $("#item_quantity_" + dataid).val(1);
                        quantite = 1;
                    }
                    var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
                    var subtotal = valeur;
                    var item_price = subtotal / quantite;
                    var itemtotal = subtotal * (1 + (item_tax_rate / 100));
                    $("#item_price_" + dataid).val(numberFormatFloat(item_price));
                    $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
                }
                break;
            case "tax_rate":
                {
                    var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
                    var subtotal = accepted_float_input($("#subtotal_" + dataid).val());
                    var itemtotal = subtotal * (1 + (item_tax_rate / 100));
                    $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
                }
                break;
            case "total":
                {
                    var quantite = accepted_integer_input($("#item_quantity_" + dataid).val());
                    if (Number(quantite) == 0) {
                        $("#item_quantity_" + dataid).val(1);
                        quantite = 1;
                    }
                    var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
                    var item_total = accepted_float_input($("#item_total_" + dataid).val());
                    var subtotal = item_total / (1 + (item_tax_rate / 100));
                    var item_price = subtotal / quantite;
                    $("#subtotal_" + dataid).val(numberFormatFloat(subtotal));
                    $("#item_price_" + dataid).val(numberFormatFloat(item_price));
                }
                break;
            default:
            {
                //    alert("autre");
            }
        }
        changeCalculDownTable();
        changedPercentRemise();
        changedPercentAcompte();
        changeTotalPaye();
    }
    function changedPercentRemise() {
        var total = 0;
        $('#item_table tr.item').each(function () {
            total += Number(accepted_float_input($(this).find(".item_total").val()));
        });
        var persent_remise = accepted_float_input($("#pourcent_remise_invoice").val());
        if (Number(persent_remise) > 100)
            persent_remise = 100;
        $("#pourcent_remise_invoice").val(persent_remise);
        var montant_remise = total * Number(persent_remise) / 100;
        $("#montant_remise_invoice").val(beautifyFormat(montant_remise, "float"));
    }
    function changedMontantRemise() {
        var total = 0;
        $('#item_table tr.item').each(function () {
            total += Number(accepted_float_input($(this).find(".item_total").val()));
        });
        var montant_remise = accepted_float_input($("#montant_remise_invoice").val());
        if (Number(montant_remise) > total) {
            montant_remise = total;
        }
        $("#montant_remise_invoice").val(beautifyFormat(montant_remise));
        var persent_remise = (Number(montant_remise) * 100) / total;
        $("#pourcent_remise_invoice").val(beautifyFormat(persent_remise, "float2"));
    }
    function changedPercentAcompte() {
        var total = $("#total_invoice").text();
        var persent_acompte = accepted_float_input($("#pourcent_acompte_invoice").val());
        $("#pourcent_acompte_invoice").val(persent_acompte);
        var montant_acompte = Number(accepted_float_input(total)) * Number(persent_acompte) / 100;
        $("#montant_acompte_invoice").val(beautifyFormat(montant_acompte, "float"));
    }
    function changedMontantAcompte() {
        var total = $("#total_invoice").text();
        var montant_acompte = accepted_float_input($("#montant_acompte_invoice").val());
        $("#montant_acompte_invoice").val(montant_acompte);
        var persent_acompte = (Number(montant_acompte) * 100) / Number(accepted_float_input(total));
        $("#pourcent_acompte_invoice").val(beautifyFormat(persent_acompte, "float2"));
    }


    function f_load() {
        pat = location.pathname;
        path = pat.split("/");
        if ((path[4]))
        {

            $('#quote_nature').val('');
            $('#quote_delai_paiement').val('');
            $('#quote_password').val('');
            $('#quote_status_id').val('1');
            $('#payment_method').val('');

            $('.name_prod').val('');
            $('.desc_prod').val('');
            $('.item_quantity').val('1');
            $('.item_price').val('');
            $('.item_tax_rate_id').val('1');
            $('.subtotal').val('');
            $('.item_tax_total').val('');
            $('.item_total').val('');

            $('#fact_prod').show();
            $('#client_titre').attr('disabled', false);
            $('#client_name').attr('disabled', false);
            $('#client_societe').attr('disabled', false);
            $('#client_address').attr('disabled', false);
            $('#client_pays').attr('disabled', false);
            $('#vat_id').attr('disabled', false);
            $('#tax_code').attr('disabled', false);

            $('#quote_nature').attr('disabled', false);
            $('#quote_date_accepte').attr('disabled', false);
            $('#quote_date_created').attr('disabled', false);
            $('#quote_date_expires').attr('disabled', false);
            $('#quote_delai_paiement').attr('disabled', false);
            $('#quote_password').attr('disabled', false);
            $('#quote_status_id').attr('disabled', false);
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
        }
        else {

            $('#devise').val('');
            $('#client_titre').val('');
            $('#client_name').val('');
            $('#client_societe').val('');
            $('#client_address').val('');
            $('#client_pays').val('');
            $('#vat_id').val('');
            $('#tax_code').val('');
            $('#quote_nature').val('');
            // $('#quote_date_created').val('');
            //$('#quote_date_expires').val('');
            $('#quote_delai_paiement').val('');
            $('#quote_password').val('');
            $('#quote_status_id').val('1');
            $('#payment_method').val('');

            $('.name_prod').val('');
            $('.desc_prod').val('');
            $('.item_quantity').val('1');
            $('.item_price').val('');
            $('.item_tax_rate_id').val('1');
            $('.subtotal').val('');
            $('.item_tax_total').val('');
            $('.item_total').val('');

            $('#fact_prod').hide();
            $('#client_titre').attr('disabled', true);
            $('#client_name').attr('disabled', true);
            $('#client_societe').attr('disabled', true);
            $('#client_address').attr('disabled', true);
            $('#client_pays').attr('disabled', true);
            $('#vat_id').attr('disabled', true);
            $('#tax_code').attr('disabled', true);

            $('#quote_nature').attr('disabled', true);
            $('#quote_date_accepte').attr('disabled', true);
            $('#quote_date_created').attr('disabled', true);
            $('#quote_date_expires').attr('disabled', true);
            $('#quote_delai_paiement').attr('disabled', true);
            $('#quote_password').attr('disabled', true);
            $('#quote_status_id').attr('disabled', true);
            $('#payment_method').attr('disabled', true);
            $('#btn_add_row').attr('disabled', true);
            $('#btn_add_product').attr('disabled', true);

            $('.name_prod').attr('disabled', true);
            $('.desc_prod').attr('disabled', true);
            $('.item_quantity').attr('disabled', true);
            $('.item_price').attr('disabled', true);
            $('.item_tax_rate_id').attr('disabled', true);
            $('.subtotal').attr('disabled', true);
            $('.item_tax_total').attr('disabled', true);
            $('.item_total').attr('disabled', true);
        }
    }
    $(function () {
        $("#client_name").focus();
        $('#client_name').typeahead();
        $('#client_name').keypress(function () {
            var self = $(this);

            $.post("<?php echo site_url('clients/ajax/name_query_id'); ?>", {
                query: self.val()
            }, function (data) {
                var parsed = JSON.parse(data);

                var json_response = [];

                for (var x in parsed) {
                    json_response.push(parsed[x]);
                }
                $('#client_id').val(json_response[1]);
                self.data('typeahead').source = json_response;
            });
        });
        $('#client_name').change(function () {
            var self = $(this);
            $.post("<?php echo site_url('clients/ajax/load_client_details'); ?>", {
                query: $('#client_id').val(),
            }, function (data) {

                var parsed = JSON.parse(data);
                var json_response = [];
                for (var x in parsed) {
                    json_response.push(parsed[x]);
                }
                $('#client_nomPrenom').val(json_response[0] + ' ' + json_response[1]);
                $('#client_address').val(json_response[2] + ' ' + json_response[4] + ' ' + json_response[3]);
                $('#client_pays').val(json_response[5]);
                $('#client_societe').val(json_response[6]);
                $('#client_titre option[value=' + json_response[7] + ']').attr('selected', 'selected');
                $('#tax_code').val(json_response[10]);
                $('#vat_id').val(json_response[9]);
                $('#timbre_fiscale_span').html(json_response[13]);
                $('#symbole_devise').val(json_response[12]);
            });
        });
        $('#btn_add_product').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('products/ajax/modal_product_lookup'); ?>/" + Math.floor(Math.random() * 1000), {
                devise: $('#devise').val(),
                type_doc: "quote"
            });
        });

        $("#btn_add_row").click(function () {
            addRow();
        });
        $('#btn_save_quote, #btn_save_quote2').click(function () {
            var items = [];
            var item_order = 1;
            $('table tr.item').each(function () {
                var row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        var valeur = $(this).val();
                        if($(this).hasClass("item_price") || $(this).hasClass("subtotal")  || $(this).hasClass("item_total") ){ valeur = Number(accepted_float_input(valeur)); }
                        row[$(this).attr('name')] = valeur;
                    }
                });
                row['item_order'] = item_order;

                item_order++;
                items.push(row);
            });
            var items_count = items.length;
            var total_quote_final = $('#total_invoice').html();
            total_quote_final = Number(total_quote_final.replace(/[^0-9\.]+/g, ""));

            var total_a_payer_quote = $('#total_a_payer_invoice').html();
            total_a_payer_quote = Number(total_a_payer_quote.replace(/[^0-9\.]+/g, ""));

            var montant_sous_tot_quote = $('#montant_sous_tot_invoice').html();
            montant_sous_tot_quote = Number(montant_sous_tot_quote.replace(/[^0-9\.]+/g, ""));

            var tot_tva_quote = $('#tot_tva_invoice').html();
            tot_tva_quote = Number(tot_tva_quote.replace(/[^0-9\.]+/g, ""));
            prop = '';
            montant_cheq = '';
            banq = '';
            ref = '';
            if ($('#payment_method').val() == 1) {
                prop = $('#proprietaire_c').val();
                var montant_cheq = $('#montant_cheq').val();
                montant_cheq = Number(montant_cheq.replace(/[^0-9\.]+/g, ""));
                banq = $('#banque_c').val();
                ref = $('#num_cheq').val();
            }
            if ($('#payment_method').val() == 3) {

                var montant_cheq = $('#montant_esp').val();
                montant_cheq = Number(montant_cheq.replace(/[^0-9\.]+/g, ""));
                prop = '';
                banq = '';
                ref = '';
            }
            if (($('#payment_method').val() == 2) || ($('#payment_method').val() == 4)) {
                prop = $('#proprietaire_v').val();
                banq = $('#banque_v').val();
                var montant_cheq = $('#montant_c').val();
                montant_cheq = Number(montant_cheq.replace(/[^0-9\.]+/g, ""));
                ref = $('#reference').val();
            }
            var montant_remise_quote = $('#montant_remise_invoice').val();
            montant_remise_quote = Number(montant_remise_quote.replace(/[^0-9\.]+/g, ""));

            var montant_acompte_quote = $('#montant_acompte_invoice').val();
            montant_acompte_quote = Number(montant_acompte_quote.replace(/[^0-9\.]+/g, ""));

            var montant_sous_tot_quote = $('#montant_sous_tot_invoice').html();
            montant_sous_tot_quote = Number(montant_sous_tot_quote.replace(/[^0-9\.]+/g, ""));

            var tot_tva_quote = $('#tot_tva_invoice').html();
            tot_tva_quote = Number(tot_tva_quote.replace(/[^0-9\.]+/g, ""));

            var timbre_fiscale_span = $('#timbre_fiscale_span').html();
            timbre_fiscale_span = Number(timbre_fiscale_span.replace(/[^0-9\.]+/g, ""));

            var total_quote = $('#total_invoice').html();
            total_quote = Number(total_quote.replace(/[^0-9\.]+/g, ""));

            var total_a_payer_quote = $('#total_a_payer_invoice').html();
            total_a_payer_quote = Number(total_a_payer_quote.replace(/[^0-9\.]+/g, ""));

            $.post("<?php echo site_url('quotes/ajax/create'); ?>", {
                client_name: $('#client_name').val(),
                client_id: $('#client_id').val(),
                quote_number: $('#quote_number').val(),
                quote_date_created: $('#quote_date_created').val(),
                quote_date_expires: $('#quote_date_expires').val(),
                quote_status_id: $('#quote_status_id').val(),
                quote_password: $('#quote_password').val(),
                quote_date_accepte: $('#quote_date_accepte').val(),
                quote_nature: $('#quote_nature').val(),
                quote_delai_paiement: $('#quote_delai_paiement').val(),
                notes: $('#notes').val(),
                montant_cheq: montant_cheq,
                date_cheq: $('#date_cheq').val(),
                proprietaire: prop,
                banque: banq,
                reference: ref,
                pourcent_remise_quote: $('#pourcent_remise_invoice').val(),
                montant_remise_quote: montant_remise_quote,
                pourcent_acompte_quote: $('#pourcent_acompte_invoice').val(),
                montant_acompte_quote: montant_acompte_quote,
                montant_sous_tot_quote: montant_sous_tot_quote,
                tot_tva_quote: tot_tva_quote,
                timbre_fiscale_span: timbre_fiscale_span,
                total_quote: total_quote,
                total_a_payer_quote: total_a_payer_quote,
                payment_method: $('#payment_method').val(),
                custom: $('input[name^=custom]').serializeArray(),
                user_id: '<?php echo $this->session->userdata('user_id'); ?>',
                items: JSON.stringify(items),
                items_count: items_count,
                quote_item_subtotal_final: montant_sous_tot_quote,
                quote_item_tax_total_final: tot_tva_quote,
                total_quote_final: total_quote_final,
            },
                    function (data) {

                        var response = JSON.parse(data);
                        if (response.success == '1') {
                            window.location = "<?php echo site_url('quotes/index'); ?>";
                        }
                        else {
                            $("#div_err").empty();
                            var msg_err = response.validation_errors;
                            var ms_err = msg_err.split("<\/p>\n");
                            for (i = 0; i < ms_err.length; i++) {
                                a = ms_err[i].replace('<p>', '');
                                if (a != '') {
                                    $("#div_err").append("<div class='alert alert-danger msg_er' style='margin-left: 15px;margin-right: 15px;'>" + a + "<button class='close' data-close='alert'></button></div>");
                                }
                            }
                            $('.control-group').removeClass('error');
                            for (var key in response.validation_errors) {
                                $('#' + key).parent().parent().addClass('error');
                            }
                        }
                    });
        });

        $('#search_client').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('clients/ajax/modal_client_lookup'); ?>/" + Math.floor(Math.random() * 1000), {
                type_doc: "quote"
            });
        });
        $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        $('#quote_delai_paiement').change(function () {
            var optionSelected = $("option:selected", this);
            var valueSelected = optionSelected.html();
            $('#notes').val(valueSelected.trim());
        });
        $('#pourcent_remise_invoice').keyup(function () {
            changedPercentRemise();
            changeCalculDownTable();
            changeTotalPaye();
            $(this).focusout(function () {
                $(this).val(beautifyFormat($(this).val(), "float2"));
                changedPercentRemise();
                changeCalculDownTable();
                changeTotalPaye();
            });
        });
        $('#montant_remise_invoice').keyup(function () {
            changedMontantRemise();
            changeCalculDownTable();
            changeTotalPaye();
            $(this).focusout(function () {
                $(this).val(beautifyFormat($(this).val(), "float"));
                changedMontantRemise();
                changeCalculDownTable();
                changeTotalPaye();
            });
        });
        $('#pourcent_acompte_invoice').keyup(function () {
            changedPercentAcompte();
            changeTotalPaye();
            $(this).focusout(function () {
                $(this).val(beautifyFormat($(this).val(), "float2"));
                changeTotalPaye();
            });
        });
        $('#montant_acompte_invoice').keyup(function () {
            changedMontantAcompte();
            changeTotalPaye();
            $(this).focusout(function () {
                $(this).val(beautifyFormat($(this).val(), "float"));
                changeTotalPaye();
            });
        });
    });
</script>
<input type="hidden" id="current_id_table_invoice" value="0">
<body onload="f_load()">
    <div id="headerbar" style=" margin-top: -3%;margin-right: 1%;">
        <div class="pull-right btn-group">
            <a href="#" class="btn blue btn-sm btn-success" id="btn_save_quote">
                <i class="fa fa-check"></i>
                <?php echo lang('save'); ?>
            </a>
        </div>

    </div></div>
<div id="div_err"></div>
<div id="content"  >


    <div class="row" style="margin-top: 15px;margin-right: 15px;margin-left: 0px;">
        <!--    AJOUT CONTACT-->
        <div class="col-md-6">
            <div class="portlet light">

                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"> <?php echo lang('client'); ?></span>
                    </div>

                </div>
                <br>
                <?php
                $clie_id = $this->uri->segment('4');
                $tt = '';
                if ($this->uri->segment('4')) {
                    $icli = $this->db->select()->from('ip_clients')->where('client_id', $clie_id)->get()->result();
//                              echo '<pre>'; print_r($icli[0]);echo '</pre>'; 
                    if (($icli != '') && ($icli[0]->client_titre == 0)) {
                        $tt = 'M.';
                    }
                    if (($icli != '') && ($icli[0]->client_titre == 1)) {
                        $tt = 'Mme.';
                    }
                    if (($icli != '') && ($icli[0]->client_titre == 2)) {
                        $tt = 'Melle.';
                    }
                } else {
                    $icli = '';
                }
                ?>
                <div  class="row" style=" width: 105%">
                    <div class="col-md-5" style="display:none">
                        <div  class="form-group form-md-line-input has-info">
                            <select class="bs-select form-control" id="client_titre" readonly > 
                                <!--<option></option>-->
                                <option  <?php
                                if ($clients && ($clients->client_titre == 0)) {
                                    echo ("selected");
                                }
                                ?> value="0"> M.</option>
                                <option <?php
                                if ($clients && ($clients->client_titre == 1)) {
                                    echo ("selected");
                                }
                                ?> value="1">Mme.</option>
                                <option <?php
                                if ($clients && ($clients->client_titre == 2)) {
                                    echo ("selected");
                                }
                                ?> value="2">Melle.</option>
                            </select>
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('client_attention'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group form-md-line-input has-info">
                            <input readonly value="<?php
                            if ($clients)
                                echo $clients->client_titre . " " . $clients->client_name . " " . $clients->client_prenom;
                            if (($icli != '') && ($icli[0]))
                                echo $tt . " " . $icli[0]->client_name . " " . $icli[0]->client_prenom;
                            ?>"  
                                   autocomplete="off" type="text" class="form-control" name="client_name" id="client_name" >
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('client_name'); ?><span style="color: #F60922; margin-left: 5px;">*</span></label>

                            <div class="form-control-focus" ></div>
                            <input type="hidden" value="<?php
                            if ($clients) {
                                echo $clients->client_id;
                            }
                            if (($icli != '') && ($icli[0])) {
                                echo $icli[0]->client_id;
                            }
                            ?>" id="client_id" name="client_id"/>
                        </div>
                    </div>
                    <input type="hidden" name="devise" id="devise" value="
                    <?php
                    if ($clients) {
                        echo $clients->client_devise_id;
                    }
                    if (($icli != '') && ($icli[0])) {
                        echo $icli[0]->client_devise_id;
                    }
                    ?>">
                    <div class="col-md-2">

                        <a id="search_client" ><i style=" margin-left: 20px; font-size: 18px;margin-top: 13px;" class="fa fa-search-plus fa-4"></i></a></td>
                    </div>
                </div>

                <div  class="row" style=" width: 100%">
                    <div class="col-md-12" >

                        <div class="form-group form-md-line-input has-info" >

                            <input readonly value="<?php
                            if ($clients) {
                                echo $clients->client_societe;
                            }
                            if (($icli != '') && ($icli[0])) {
                                echo $icli[0]->client_societe;
                            }
                            ?>
                                   "  autocomplete="off" type="text" 
                                   class="form-control" id="client_societe" >
                            <div class="form-control-focus"  ></div>
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('client_societe'); ?></label>

                        </div>
                    </div>
                </div>

                <div  class="row" style=" width: 100%">
                    <div class="col-md-8">

                        <div class="form-group form-md-line-input has-info">

                            <input readonly id="client_address" value="<?php
                            if ($clients) {
                                echo $clients->client_address_1;
                            }
                            if (($icli != '') && ($icli[0])) {
                                echo $icli[0]->client_address_1;
                            }
                            ?>"  
                                   autocomplete="off" type="text" class="form-control"  >
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('client_address'); ?></label>

                            <div class="form-control-focus" ></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div  class="form-group form-md-line-input has-info" >
                            <input readonly id="client_pays" value="<?php
                            if ($clients) {
                                echo $clients->client_country;
                            }
                            if (($icli != '') && ($icli[0])) {
                                echo $icli[0]->client_country;
                            }
                            ?>"   autocomplete="off" 
                                   type="text" class="form-control"  >
                            <div class="form-control-focus" ></div>
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('client_pays'); ?></label>
                        </div>  
                    </div>
                </div>


                <div  class="row" style=" width: 100%">     
                    <div  class="col-md-6">

                        <div class="form-group form-md-line-input has-info">

                            <input readonly id="vat_id" value="<?php
                            if ($clients) {
                                echo $clients->client_vat_id;
                            }
                            if (($icli != '') && ($icli[0])) {
                                echo $icli[0]->client_vat_id;
                            }
                            ?>"  autocomplete="off" 
                                   type="text" class="form-control" >
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('vat_id'); ?></label>

                        </div>    
                    </div>
                    <div class="col-md-6">
                        <div  class="form-group form-md-line-input has-info" >
                            <input readonly id="tax_code" value="<?php
                            if ($clients) {
                                echo $clients->client_tax_code;
                            }
                            if (($icli != '') && ($icli[0])) {
                                echo $icli[0]->client_tax_code;
                            }
                            ?>"  autocomplete="off" 
                                   type="text" class="form-control"  >
                            <div class="form-control-focus" ></div>
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('tax_code'); ?></label>

                        </div>   
                    </div>





                </div> </div>
        </div>
        <!--    FIN AJOUT CONTACT-->  

        <!--    detail devis-->

        <div class="col-md-6">

            <?php
            $valCode = $this->mdl_settings->setting('code_devis_fin') + 1;
            ?>
            <div class="portlet light"> 
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"> <?php echo lang('quote'); ?></span>
                    </div>
                </div>
                <br>
                <div  class="row" style=" width: 100%">     
                    <div  class="col-md-6">

                        <div class="form-group form-md-line-input has-info">
                            <input readonly="readonly" id="quote_number" class="form-control input-sm" value="<?php echo $valCode; ?>"   
                                   title="<?php echo lang('quote'); ?> ">
                            <div class="form-control-focus" ></div>
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('quote'); ?>#</label>

                        </div></div>
                    <div  class="col-md-6" >
                        <div class="form-group form-md-line-input has-info">
                            <input  id="quote_nature" class="form-control input-sm" value="" >
                            <div class="form-control-focus" ></div>
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('quote_nature'); ?></label>
                        </div></div>
                </div>

                <div  class="row" style=" width: 100%">     
                    <div  class="col-md-6">

                        <div class="form-group form-md-line-input has-info">
                            <div class="quote-properties has-feedback">

                                <div class="input-group">
                                    <input name="quote_date_created" id="quote_date_created" class="form-control input-sm datepicker" value="<?php echo date('d/m/Y'); ?>">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar fa-fw"></i>
                                    </span>
                                    <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('date'); ?></label>
                                </div>
                            </div>                    
                        </div>
                    </div>

                    <div  class="col-md-6" >
                        <div class="form-group form-md-line-input has-info"> 
                            <div class="quote-properties has-feedback">
                                <div class="input-group">
                                    <input name="quote_date_expires" id="quote_date_expires" class="form-control input-sm datepicker" value="<?php echo $this->mdl_quotes->get_date_due_format(date_to_mysql(date('d/m/Y'))); ?>">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar fa-fw"></i>
                                    </span>
                                    <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('expires'); ?></label>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>

                <div  class="row" style=" width: 100%">     
                    <div class="col-md-6">
                        <div class="form-group form-md-line-input has-info">

                            <div class="quote-properties has-feedback">
                                <div class="input-group">
                                    <input name="quote_date_accepte" id="quote_date_accepte"  title="<?php echo lang('quote_date_accepte'); ?>"
                                           class="form-control input-sm datepicker" value="">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar fa-fw"></i>
                                    </span>
                                    <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('quote_date_accepte'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group form-md-line-input has-info">
                            <select name="quote_delai_paiement"  style="padding: 0px 0px;"id="quote_delai_paiement" class="form-control input-sm">
                                <?php foreach ($delaiPaiement as $delaiPaim) { ?>
                                    <option value="<?php echo $delaiPaim->delai_paiement_id; ?>">
                                        <?php echo $delaiPaim->delai_paiement_label; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('quote_delai_paiement'); ?></label>

                        </div>
                    </div>
                </div>
                <div  class="row" style=" width: 100%">     
                    <div class="col-md-6">
                        <div class="form-group form-md-line-input has-info">
                            <input  id="quote_password" class="form-control input-sm" value=""  title="<?php echo lang('quote_password'); ?>" >
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('quote_password'); ?></label>
                            <div class="form-control-focus" ></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-md-line-input has-info">
                            <select name="quote_status_id" id="quote_status_id" title="<?php echo lang('status'); ?>" style="padding: 0px 0px;" class="form-control input-sm">
                                <?php foreach ($quote_statuses as $key => $status) { ?>
                                    <option value="<?php echo $key; ?>">
                                        <?php echo $status['label']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('status'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--    fin detail devis-->
    </div>
    <div class="row" style="margin-right: 0px;" >
        <div id="fact_prod">
            <!--    BLOC PRODUITS-->
            <div class="col-md-12" style="margin-left: 15px; width: 98%;">
                <div class="portlet light">

                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> <?php echo lang('products_bloc'); ?></span>
                        </div>

                    </div>
                    <div class="btn_add_prod" style=" text-align: right">
                        <a class="btn btn-sm btn-default" id="btn_add_row">
                            <i class="fa fa-plus"></i>
                            <?php echo lang('add_new_row'); ?>
                        </a>
                        <a class="btn btn-sm btn-default" id="btn_add_product">
                            <i class="fa fa-database"></i>
                            <?php echo lang('add_product'); ?>
                        </a>
                    </div>
                    <br>
                    <br>
                    <?php $this->layout->load_view('quotes/partial_item_table'); ?>
                    <div style="clear:both"></div>
                    <br>
                    <div class="form-group form-md-line-input has-info">
                        <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('notes'); ?></label>
                        <input type="text"name="notes" id="notes" class="form-control input-sm" >
                        <div class="form-control-focus" ></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="pull-right btn-group" style="margin-top: -1%;margin-right: 26px;">
        <a href="#" class="btn blue btn-sm btn-success" id="btn_save_quote2">
            <i class="fa fa-check"></i>
            <?php echo lang('save'); ?>
        </a>
    </div><br>
</div>
</body>

