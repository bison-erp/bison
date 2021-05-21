<style>
    //.form-group.form-md-line-input .form-control{    margin-top: -17px;    padding-left: 1px;}
    .datepicker table tr td.day:hover,.datepicker table tr td.day.focused{background:#eee;cursor:pointer;border-radius: 4px;}
    .datepicker .active{  background-color: #4B8DF8 !important;background-image: none !important;filter: none !important;border-radius: 4px;}
</style>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
// Created By Anis

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
    function addRow(items, init) {
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
            if (init != 0) {
                changeCalculDownTable();
                changedPercentRemise();
                changedPercentAcompte();
                changeTotalPaye();
            }
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


// FIn Created By Anis
    $(function () {
        var symbole_devise = $("#symbole_devise").val();
        $('#fact_prod .devise_view').each(function () {
            $(this).text(symbole_devise);
        });
        $('#btn_save_quote, #btn_save_quote1').click(function () {
            var items = [];
            var item_order = 1;
            $('table tr.item').each(function () {
                var row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        var valeur = $(this).val();
                        if ($(this).hasClass("item_price") || $(this).hasClass("subtotal") || $(this).hasClass("item_total")) {
                            valeur = Number(accepted_float_input(valeur));
                        }
                        row[$(this).attr('name')] = valeur;
                    }
                });
                row['item_order'] = item_order;
                item_order++;
                items.push(row);
            });
            var items_count = items.length;
            var montant_remise_quote = $('#montant_remise_invoice').val();
            montant_remise_quote = Number(montant_remise_quote.replace(/[^0-9\.]+/g, ""));

            var montant_acompte_quote = $('#montant_acompte_invoice').val();
            montant_acompte_quote = Number(montant_acompte_quote.replace(/[^0-9\.]+/g, ""));

            var total_quote_final = $('#total_invoice').html();
            total_quote_final = Number(total_quote_final.replace(/[^0-9\.]+/g, ""));

            var total_a_payer_quote = $('#total_a_payer_invoice').html();
            total_a_payer_quote = Number(total_a_payer_quote.replace(/[^0-9\.]+/g, ""));

            var quote_item_subtotal_final = $('#montant_sous_tot_invoice').html();
            quote_item_subtotal_final = Number(quote_item_subtotal_final.replace(/[^0-9\.]+/g, ""));

            var quote_item_tax_total_final = $('#tot_tva_invoice').html();
            quote_item_tax_total_final = Number(quote_item_tax_total_final.replace(/[^0-9\.]+/g, ""));

            var timbre_fiscale_span = $('#timbre_fiscale_span').html();
            timbre_fiscale_span = Number(timbre_fiscale_span.replace(/[^0-9\.]+/g, ""));

            var total_quote = $('#total_invoice').html();
            total_quote = Number(total_quote.replace(/[^0-9\.]+/g, ""));

            $.post("<?php echo site_url('quotes/ajax/save'); ?>", {
                quote_id: <?php echo $quote_id; ?>,
                client_id: $('#client').val(),
                timbre_fiscale_span: timbre_fiscale_span,
                client_name: $('#client_name').val(),
                quote_number: $('#quote_number').val(),
                quote_date_created: $('#quote_date_created').val(),
                quote_date_expires: $('#quote_date_expires').val(),
                quote_status_id: $('#quote_status_id').val(),
                quote_password: $('#quote_password').val(),
                quote_date_accepte: $('#quote_date_accepte').val(),
                quote_nature: $('#quote_nature').val(),
                quote_delai_paiement: $('#quote_delai_paiement').val(),
                items: JSON.stringify(items),
                items_count: items_count,
                notes: $('#notes').val(),
                custom: $('input[name^=custom]').serializeArray(),
                user_id: '<?php echo $this->session->userdata('user_id'); ?>',
                pourcent_remise_quote: $('#pourcent_remise_invoice').val(),
                montant_remise_quote: montant_remise_quote,
                pourcent_acompte_quote: $('#pourcent_acompte_invoice').val(),
                montant_acompte_quote: montant_acompte_quote,
                total_quote_final: total_quote_final,
                total_quote: total_quote,
                total_a_payer_quote: total_a_payer_quote,
                quote_item_subtotal_final: quote_item_subtotal_final,
                quote_item_tax_total_final: quote_item_tax_total_final,
            },
                    function (data) {
                        var response = JSON.parse(data);
                        console.log(response);
                        if (response.success == '1') {
                            // window.location = "<?php echo site_url('quotes/view'); ?>/" + <?php echo $quote_id; ?>;
                            window.location = "<?php echo site_url('quotes/index'); ?>";
                        }
                        else {
                            $("#div_err").empty();
                            var msg_err = response.validation_errors;
                            console.log(msg_err);
                            var ms_err = msg_err.split("<\/p>\n");
                            console.log(ms_err);
                            for (i = 0; i < ms_err.length; i++) {
                                a = ms_err[i].replace('<p>', '');

                                if (a != '') {
                                    $("#div_err").append("<div class='alert alert-danger msg_er'>" + a + ".</div>");
                                }
                            }
                            $('.control-group').removeClass('error');
                            for (var key in response.validation_errors) {
                                $('#' + key).parent().parent().addClass('error');
                            }
                        }
                    });
        });
        $('#btn_add_product').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('products/ajax/modal_product_lookup'); ?>/" + Math.floor(Math.random() * 1000), {
                devise: $('#devise').val(),
                type_doc: "invoice"
            });
        });
        $("#btn_add_row").click(function () {
            addRow();
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
        $('#btn_generate_pdf').click(function () {
            window.open('<?php echo site_url('quotes/generate_pdf/' . $quote_id); ?>', '_blank');
        });
        $('#quote_delai_paiement').change(function () {
            var optionSelected = $("option:selected", this);
            var valueSelected = optionSelected.html();
            $('#notes').val(valueSelected.trim());
        });
        $('#delete_quote').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('quotes/modal_delete_quote'); ?>");
        });

        // Recupération des ligne devis
        $.post("<?php echo site_url('quotes/ajax/getItemsByQuote'); ?>", {
            quote_id: <?php echo $quote->quote_id; ?>
        }, function (data) {

            items = JSON.parse(data);
            for (var key in items) {
                items[key].tax_rate_id_dev = items[key].item_tax_rate_id;
                items[key].product_sku = items[key].item_code;
                items[key].product_description = items[key].item_description;
                items[key].product_price_dev = items[key].item_price;
                items[key].product_subtotal = items[key].item_subtotal;
                items[key].montantTVATotal = items[key].item_total;
                items[key].product_quantite = items[key].item_quantity;
                addRow(items[key],0);
            }
            $('#modal-choose-items').modal('hide');
            $(".name_prod").focus();
            $('.name_prod').typeahead();

        });
        // FIN Recupération des ligne devis
        $("#pourcent_remise_invoice").val(beautifyFormat(<?php echo $quote->quote_pourcent_remise; ?>, "float2"));
        $("#montant_remise_invoice").val(beautifyFormat(<?php echo $quote->quote_montant_remise; ?>, "float"));
        $("#pourcent_acompte_invoice").val(beautifyFormat(<?php echo $quote->quote_pourcent_acompte; ?>, "float2"));
        $("#montant_acompte_invoice").val(beautifyFormat(<?php echo $quote->quote_montant_acompte; ?>, "float"));
        $("#timbre_fiscale_span").text(beautifyFormat(<?php echo $quote->timbre_fiscale; ?>, "float"));
        
        $("#montant_sous_tot_invoice").text(beautifyFormat(<?php echo $quote->quote_item_subtotal; ?>, "float"));
        $("#tot_tva_invoice").text(beautifyFormat(<?php echo $quote->quote_item_tax_total; ?>, "float"));
        $("#total_invoice").text(beautifyFormat(<?php echo $quote->quote_total; ?>, "float"));
        $("#total_a_payer_invoice").text(beautifyFormat(<?php echo $quote->quote_total_a_payer; ?>, "float"));
    });
</script>
<input type="hidden" id="current_id_table_invoice" value="0">
<input type="hidden" id="devise" value="<?php echo $quote->devise_id; ?>">
<input type="hidden" id="symbole_devise" value="<?php echo $quote->devise_symbole; ?>">
<?php
if (($quote->quote_status_id == 4) || ($quote->quote_status_id == 5) || ($quote->quote_status_id == 6)) {
    $ett = 'disabled';
} else {
    $ett = '';
}
?>

<div id="headerbar">
    <div class="row" style="margin:0;">

        <div class="col-md-12">
            <div class="portlet light">   
                <b><big><?php echo lang('quote'); ?> #<?php echo $quote->quote_number; ?></big></b>

                <div class="pull-right  btn-group">

                    <div class="options btn-group pull-left">
                        <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo lang('options'); ?> <i class="fa fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li style=" display: none">
                                <a href="#add-quote-tax" data-toggle="modal">
                                    <i class="fa fa-plus fa-margin"></i>
                                    <?php echo lang('add_quote_tax'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="btn_generate_pdf"
                                   data-quote-id="<?php echo $quote_id; ?>">
                                    <i class="fa fa-print fa-margin"></i>
                                    <?php echo lang('download_pdf'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('mailer/quote/' . $quote->quote_id); ?>">
                                    <i class="fa fa-send fa-margin"></i>
                                    <?php echo lang('send_email'); ?>
                                </a>
                            </li>
                            <?php if ($quote->invoice_id == 0) { ?><li>
                                    <a href="#" id="btn_quote_to_invoice"
                                       data-quote-id="<?php echo $quote_id; ?>">
                                        <i class="fa fa-refresh fa-margin"></i>
                                        <?php echo lang('quote_to_invoice'); ?>
                                    </a>
                                </li><?php } ?>
                            <li style=" display: none">
                                <a href="#" id="btn_copy_quote"
                                   data-quote-id="<?php echo $quote_id; ?>">
                                    <i class="fa fa-copy fa-margin"></i>
                                    <?php echo lang('copy_quote'); ?>
                                </a>
                            </li>
                            <?php
                            if ($this->session->userdata["groupes_user_id"] == 1) {
                                if (($quote->quote_status_id != 4) && ($quote->quote_status_id != 5) && ($quote->quote_status_id != 6)) {
                                    ?>
                                    <li id="delete_quote" >
                                        <a href="#delete-quote" id="delete_quote" data-quote-id="<?php echo $quote_id; ?>" data-toggle="modal">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                        </a>
                                    </li><?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <a href="#" class="btn btn-sm btn-success blue" id="btn_save_quote">
                        <i class="fa fa-check"></i>
                        <?php echo lang('save'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="div_err"></div>
<div id="content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <form id="quote_form">
        <div class="row" style="margin:0;">
            <div class="col-md-6">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> <?php echo lang('client'); ?></span>
                        </div>
                    </div>


                    <?php
                    if ($quote->client_titre == 0) {
                        $client_titre = 'M.';
                    } elseif ($quote->client_titre == 1) {
                        $client_titre = 'Mme.';
                    } elseif ($quote->client_titre == 2) {
                        $client_titre = 'Melle.';
                    }
                    ?>
                    <label><?php echo lang('client_attention'); ?>: </label>
                    <input type="hidden" name="client" id="client" value="<?php echo $quote->client_id; ?>">
                    <input type="hidden" name="client_name" id="client_name" value="<?php echo $quote->client_name; ?>">
                    <a href="<?php echo site_url('clients/view/' . $quote->client_id); ?>"><?php echo $client_titre . ' ' . $quote->client_name . ' ' . $quote->client_prenom; ?></a>
                    <br>
                    <span><input type="hidden" name="devise" id="devise" value="<?php echo $quote->devise_id; ?>">
                        <label><?php echo lang('client_societe'); ?>: </label><?php echo ($quote->client_address_1) ? $quote->client_address_1 : ''; ?>
                        <?php echo ($quote->client_city) ? $quote->client_city : ''; ?>
                        <?php echo ($quote->client_zip) ? $quote->client_zip : ''; ?>
                        <?php echo ($quote->client_country) ? ',' . $quote->client_country : ''; ?>
                    </span>
                    <br><br>
                    <label><?php echo lang('vat_id'); ?>: </label><?php echo $quote->client_vat_id; ?>
                    <br>
                    <label><?php echo lang('tax_code'); ?>: </label><?php echo $quote->client_tax_code; ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> <?php echo lang('quote'); ?></span>
                        </div>
                    </div>
                    <br>
                    <div  class="row" style=" width: 100%">
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <input readonly="readonly" id="quote_number" class="form-control input-sm" value="<?php echo $quote->quote_number; ?>"   >
                                <div class="form-control-focus" ></div>
                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('quote'); ?></label>
                            </div></div>
                        <div  class="col-md-6" >
                            <div class="form-group form-md-line-input has-info">
                                <input style="padding:0px" id="quote_nature" class="form-control input-sm"<?php echo $ett; ?> value="<?php echo $quote->quote_nature; ?>" >
                                <div class="form-control-focus" > </div>
                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('quote_nature'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div  class="row" style=" width: 100%">
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <div class="quote-properties has-feedback">

                                    <div class="input-group">
                                        <input name="quote_date_created" style="z-index: 1 !important;"<?php echo $ett; ?> id="quote_date_created" class="form-control input-sm datepicker" value="<?php echo date_from_mysql($quote->quote_date_created); ?>">
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

                                <div class="input-group">
                                    <input name="quote_date_expires" <?php echo $ett; ?> style="z-index: 1 !important;"id="quote_date_expires" class="form-control input-sm datepicker" value="<?php echo date_from_mysql($quote->quote_date_expires); ?>">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar fa-fw"></i>
                                    </span>
                                    <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('expires'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="row" style=" width: 100%">
                        <div class="col-md-6">        
                            <?php
                            $dateAccepte = $quote->quote_date_accepte;
                            if ($dateAccepte == '') {
                                $dateAccepte = date_from_mysql('0000-00-00');
                            } else {
                                $dateAccepte = date_from_mysql($quote->quote_date_accepte);
                            }
                            ?>
                            <div class="form-group form-md-line-input has-info">
                                <div class="quote-properties has-feedback">
                                    <div class="input-group">
                                        <input name="quote_date_accepte" <?php echo $ett; ?> style="z-index: 1 !important;" id="quote_date_accepte" class="form-control input-sm datepicker" value="<?php echo $dateAccepte; ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                        <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('quote_date_accepte'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <div class="quote-properties has-feedback">
                                    <div class="">
                                        <select name="quote_delai_paiement"  <?php echo $ett; ?> style="padding: 0px 0px;"id="quote_delai_paiement" class="form-control input-sm">
                                            <option value="0"></option>
                                            <?php foreach ($delaiPaiement as $delaiPaim) { ?>
                                                <option value="<?php echo $delaiPaim->delai_paiement_id; ?>" <?php if ($delaiPaim->delai_paiement_id == $quote->quote_delai_paiement) { ?>selected="selected"<?php } ?>><?php echo $delaiPaim->delai_paiement_label; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="form_control_1"  style="font-size: 13px; color: #899a9a;margin-top: -19px;" ><?php echo lang('quote_delai_paiement'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div  class="row" style=" width: 100%">
                        <div class="col-md-6">     
                            <div class="form-group form-md-line-input has-info">

                                <input  id="quote_password" <?php echo $ett; ?> class="form-control input-sm" value="<?php echo $quote->quote_password; ?>"  >
                                <div class="form-control-focus" ></div>
                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('quote_password'); ?></label>
                            </div></div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input has-info">
                                <select name="quote_status_id"  id="quote_status_id"  style="padding: 0px 0px;" class="form-control input-sm">
                                    <?php foreach ($quote_statuses as $key => $status) { ?>
                                        <option value="<?php echo $key; ?>" <?php if ($key == $quote->quote_status_id) { ?>selected="selected"<?php } ?>><?php echo $status['label']; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="form_control_1"  style="font-size: 13px; color: #899a9a;" ><?php echo lang('status'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin:0;">
            <div id="fact_prod">
                <!--    BLOC PRODUITS-->
                <div class="col-md-12">
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
                            <input type="text"name="notes" id="notes" class="form-control input-sm" value="<?php echo $quote->notes; ?>" >
                            <div class="form-control-focus" ></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>