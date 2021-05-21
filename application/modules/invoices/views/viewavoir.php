<style>
.form-group.form-md-line-input .form-control {
    padding-left: 1px;
}

.datepicker table tr td.day:hover,
.datepicker table tr td.day.focused {
    background: #eee;
    cursor: pointer;
    border-radius: 4px;
}

.datepicker .active {
    background-color: #4B8DF8 !important;
    background-image: none !important;
    filter: none !important;
    border-radius: 4px;
}

.table-wrapper {
    overflow-x: scroll;
    overflow-y: visible;
    width: 35%;
}
</style>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
    rel="stylesheet" type="text/css">
<script type="text/javascript">
// Created By Anis
function changeCalculDownTable() {
    var subtotal = 0;
    var item_total = 0;
    var item_tax_rate = 0;
    $('#item_table tr.item').each(function() {
        subtotal += Number(accepted_float_input($(this).find(".subtotal").val()));
        item_total += Number(accepted_float_input($(this).find(".item_total").val()));
        item_tax_rate += Number(accepted_float_input($(this).find(".subtotal").val())) * Number(
            accepted_float_input($(this).find(".item_tax_rate_id option:selected").text()) / 100);

    });
    var montant_remise = accepted_float_input($("#montant_remise_invoice").val());
    var persent_remise = accepted_float_input($("#pourcent_remise_invoice").val());
    var timbre_fiscale = -accepted_float_input($("#timbre_fiscale_span").text());
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
        var item_price_value = beautifyFormat(0, "float");
        var subtotal_value = beautifyFormat(0, "float");
        var item_tax_rate_id_value = 0;
        var item_total_value = beautifyFormat(0, "float");
    } else {
        var item_code_value = items.product_sku;
        var item_description_value = items.product_description;

        var item_quantity_value = items.product_quantite ? parseInt(items.product_quantite) : 1;
        var item_price_value = beautifyFormat(items.product_price_dev, "float");
        var subtotal_value = items.product_subtotal ? beautifyFormat(items.product_subtotal, "float") : beautifyFormat(
            items.product_price_dev, "float");
        var item_tax_rate_id_value = items.tax_rate_id_dev;
        var item_total_value = beautifyFormat(items.montantTVATotal, "float");
    }
    // import tax Rate
    var row_add_tax = "";
    if ($('#assigite_tva').val() == 1) {
        $.post("<?php echo site_url('tax_rates/ajax/getTaxRate'); ?>", function(data) {
            var tax_rates_all = JSON.parse(data);
            $.each(tax_rates_all, function(k, v) {
                row_add_tax += '<option value="' + v.tax_rate_id + '"';
                if (item_tax_rate_id_value == v.tax_rate_id) {
                    row_add_tax += ' selected = "selected" ';
                }
                row_add_tax += '>' + v.tax_rate_percent + '</option>';
            });
            var current_id = $("#current_id_table_invoice").val();
            var row_add = '<tr class=" item ui-sortable-handle tr_prod_' + current_id + '">';
            row_add += '<td align="center" style="width: 25px;"><i class="fa fa-arrows cursor-move"></i></td>';
            if ($('#addrowid').val() == 0) {
                row_add +=
                    '<td style="width: 200px;"><input type="text" readonly="readonly" name="item_code" id="item_code_' +
                    current_id +
                    '" class="name_prod form-control "  class="form-control" value="' +
                    item_code_value +
                    '" autocomplete="off" data-id="' + current_id + '"></td>';
            } else {
                row_add +=
                    '<td style="width: 200px;"><input type="text"   name="item_code" id="item_code_' +
                    current_id +
                    '" class="name_prod form-control "  class="form-control" value="' +
                    item_code_value +
                    '" autocomplete="off" data-id="' + current_id + '"></td>';
            }

            row_add += '<td><textarea id="item_description_' + current_id +
                '" name="item_description" class="form-control desc_prod">' + item_description_value +
                '</textarea></td>';
            row_add += '<td><input type="number" class="input-sm form-control item_quantity" data-id="' +
                current_id + '" name="item_quantity" id="item_quantity_' + current_id + '" value="' +
                item_quantity_value + '"></td>';
            row_add +=
                '<td><input type="text" class="input-sm form-control item_price" name="item_price" value="' +
                item_price_value + '" data-id="' + current_id + '" id="item_price_' + current_id + '"></td>';
            row_add +=
                '<td style="width: 120px;"> <input name="subtotal" class="subtotal input-sm form-control" data-id="' +
                current_id + '" id="subtotal_' + current_id + '" value="' + subtotal_value + '"></td>';
            row_add +=
                '<td style="width: 110px;"><select  name="item_tax_rate_id" class="input-sm form-control item_tax_rate_id"  data-id="' +
                current_id + '" id="item_tax_rate_' + current_id + '"> ' + row_add_tax + ' </select></td>';
            row_add +=
                '<td style="width: 120px;"><input name="item_total" class="item_total input-sm form-control" data-id="' +
                current_id + '" id="item_total_' + current_id + '" value="' + item_total_value + '"></td>';
            row_add +=
                '<td style="width:40px;" class="td-icon" align="center"> <a class="delete_row" title="Supprimer" data-id="' +
                current_id + '" id="delete_row_' + current_id +
                '"><i class="fa fa-trash-o text-danger"></i></a>';
            row_add += '<input type="hidden" name="family_id" value="0">';
            row_add += '<input type="hidden" name="item_name" value="' + item_code_value + '">';
            row_add += '<input type="hidden" name="etat_champ" value="1">';
            row_add += "</td>";
            row_add += "/<tr>";

            $("#item_table tbody").append(row_add);
            $("#current_id_table_invoice").val(parseInt(current_id) + 1);
            $('#item_table').find('tr.item').find('#delete_row_' + current_id).click(function() {
                $(".tr_prod_" + current_id).remove();
                changeCalculDownTable();
                changedPercentRemise();
                changedPercentAcompte();
                changeTotalPaye();
            });
            $('#item_table').find('tr.item').find('#item_quantity_' + current_id).keyup(function() {
                changedItemTable($(this), "quantite", "int");
                $(this).focusout(function() {
                    $(this).val(beautifyFormat($(this).val(), "int"));
                });
            });
            $('#item_table').find('tr.item').find('#item_quantity_' + current_id).change(function() {
                changedItemTable($(this), "quantite", "int");
                $(this).focusout(function() {
                    $(this).val(beautifyFormat($(this).val(), "int"));
                });
            });
            $('#item_table').find('tr.item').find('#item_price_' + current_id).keyup(function() {
                changedItemTable($(this), "prix_unitaire", "float");
                $(this).focusout(function() {
                    $(this).val(beautifyFormat($(this).val(), "float"));

                });
            });
            $('#item_table').find('tr.item').find('#subtotal_' + current_id).keyup(function() {
                changedItemTable($(this), "subtotal", "float");
                $(this).focusout(function() {
                    $(this).val(beautifyFormat($(this).val(), "float"));
                });
            });
            $('#item_table').find('tr.item').find('#item_tax_rate_' + current_id).change(function() {
                changedItemTable($(this), "tax_rate", "float");
            });
            $('#item_table').find('tr.item').find('#item_total_' + current_id).keyup(function() {
                changedItemTable($(this), "total", "float");
                $(this).focusout(function() {
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
    } else {
        row_add_tax += '<option value="3"  selected = "selected" >0</option>';
        var current_id = $("#current_id_table_invoice").val();
        var row_add = '<tr class=" item ui-sortable-handle tr_prod_' + current_id + '">';
        row_add += '<td align="center" style="width: 25px;"><i class="fa fa-arrows cursor-move"></i></td>';
        if ($('#addrowid').val() == 0) {
            row_add +=
                '<td style="width: 200px;"><input type="text" readonly="readonly"   name="item_code" id="item_code_' +
                current_id +
                '" class="name_prod form-control " class="form-control" value="' + item_code_value +
                '" autocomplete="off" data-id="' + current_id + '"></td>';
        } else {
            row_add +=
                '<td style="width: 200px;"><input type="text"  name="item_code" id="item_code_' +
                current_id +
                '" class="name_prod form-control " class="form-control" value="' + item_code_value +
                '" autocomplete="off" data-id="' + current_id + '"></td>';
        }
        row_add += '<td><textarea id="item_description_' + current_id +
            '" name="item_description" class="form-control desc_prod">' + item_description_value +
            '</textarea></td>';
        row_add += '<td><input type="number" class="input-sm form-control item_quantity" data-id="' +
            current_id + '" name="item_quantity" id="item_quantity_' + current_id + '" value="' +
            item_quantity_value + '"></td>';
        row_add +=
            '<td><input type="text" class="input-sm form-control item_price" name="item_price" value="' +
            item_price_value + '" data-id="' + current_id + '" id="item_price_' + current_id + '"></td>';
        row_add +=
            '<td  style="display:none;width: 120px;"> <input name="subtotal" class="subtotal input-sm form-control" data-id="' +
            current_id + '" id="subtotal_' + current_id + '" value="' + subtotal_value + '"></td>';
        row_add +=
            '<td style="display:none;width: 110px;"><select  name="item_tax_rate_id" class="input-sm form-control item_tax_rate_id"  data-id="' +
            current_id + '" id="item_tax_rate_' + current_id + '"> ' + row_add_tax + ' </select></td>';
        row_add +=
            '<td style="width: 120px;"><input name="item_total" class="item_total input-sm form-control" data-id="' +
            current_id + '" id="item_total_' + current_id + '" value="' + item_total_value + '"></td>';
        row_add +=
            '<td style="width:40px;" class="td-icon" align="center"> <a class="delete_row" title="Supprimer" data-id="' +
            current_id + '" id="delete_row_' + current_id +
            '"><i class="fa fa-trash-o text-danger"></i></a>';
        row_add += '<input type="hidden" name="family_id" value="0">';
        row_add += '<input type="hidden" name="item_name" value="' + item_code_value + '">';
        row_add += '<input type="hidden" name="etat_champ" value="1">';
        row_add += "</td>";
        row_add += "/<tr>";

        $("#item_table tbody").append(row_add);
        $("#current_id_table_invoice").val(parseInt(current_id) + 1);
        $('#item_table').find('tr.item').find('#delete_row_' + current_id).click(function() {
            $(".tr_prod_" + current_id).remove();
            changeCalculDownTable();
            changedPercentRemise();
            changedPercentAcompte();
            changeTotalPaye();
        });
        $('#item_table').find('tr.item').find('#item_quantity_' + current_id).keyup(function() {
            changedItemTable($(this), "quantite", "int");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "int"));
            });
        });
        $('#item_table').find('tr.item').find('#item_quantity_' + current_id).change(function() {
            changedItemTable($(this), "quantite", "int");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "int"));
            });
        });
        $('#item_table').find('tr.item').find('#item_price_' + current_id).keyup(function() {
            changedItemTable($(this), "prix_unitaire", "float");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "float"));

            });
        });
        $('#item_table').find('tr.item').find('#subtotal_' + current_id).keyup(function() {
            changedItemTable($(this), "subtotal", "float");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "float"));
            });
        });
        $('#item_table').find('tr.item').find('#item_tax_rate_' + current_id).change(function() {
            changedItemTable($(this), "tax_rate", "float");
        });
        $('#item_table').find('tr.item').find('#item_total_' + current_id).keyup(function() {
            changedItemTable($(this), "total", "float");
            $(this).focusout(function() {
                $(this).val(beautifyFormat($(this).val(), "float"));
            });
        });

        $(".name_prod").focus();
        $('.name_prod').typeahead();

        changeCalculDownTable();
        changedPercentRemise();
        changedPercentAcompte();
        changeTotalPaye();
    }
}

function changedItemTable(curr, item, type) {
    var dataid = curr.data('id');
    var id = curr.attr('id');
    var valeur = curr.val();

    if (type == "int") {
        if (accepted_integer_input(valeur) != valeur) {
            $("#" + id).val(accepted_integer_input(valeur));
            valeur = accepted_integer_input(valeur);
        }
    } else if (type == "float") {
        if (accepted_float_input(valeur) != valeur) {
            $("#" + id).val(accepted_float_input(valeur));
            valeur = accepted_float_input(valeur);
        }
    }

    switch (item) {
        case "quantite": {
            var item_price = accepted_float_input($("#item_price_" + dataid).val());
            var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
            var subtotal = item_price * valeur;
            var itemtotal = subtotal * (1 + (item_tax_rate / 100));
            $("#subtotal_" + dataid).val(numberFormatFloat(subtotal));
            $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
        }
        break;
    case "prix_unitaire": {
        var quantite = accepted_integer_input($("#item_quantity_" + dataid).val());
        var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
        var subtotal = quantite * valeur;
        var itemtotal = subtotal * (1 + (item_tax_rate / 100));
        $("#subtotal_" + dataid).val(numberFormatFloat(subtotal));
        $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
    }
    break;
    case "subtotal": {
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
    case "tax_rate": {
        var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
        var subtotal = accepted_float_input($("#subtotal_" + dataid).val());
        var itemtotal = subtotal * (1 + (item_tax_rate / 100));
        $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
    }
    break;
    case "total": {
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
    default: {
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
    $('#item_table tr.item').each(function() {
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
    $('#item_table tr.item').each(function() {
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
    if ($('#etat_montant_acccont').val() == 0) {
        $("#montant_acompte_invoice").val(beautifyFormat(montant_acompte, "float"));

    }
}

function changedMontantAcompte() {
    var total = $("#total_invoice").text();
    var montant_acompte = accepted_float_input($("#montant_acompte_invoice").val());
    $("#montant_acompte_invoice").val(montant_acompte);
    var persent_acompte = (Number(montant_acompte) * 100) / Number(accepted_float_input(total));
    $("#pourcent_acompte_invoice").val(beautifyFormat(persent_acompte, "float2"));
    $('#etat_montant_acccont').val(1);

}


// FIn Created By Anis
$(function() {
    var symbole_devise = $("#symbole_devise").val();
    $('#fact_prod .devise_view').each(function() {
        $(this).text(symbole_devise);
    });

    $('#btn_save_invoice, #btn_save_invoice1').click(function() {
        var items = [];
        var item_order = 1;
        $('table tr.item').each(function() {
            var row = {};
            $(this).find('input,select,textarea').each(function() {
                if ($(this).is(':checkbox')) {
                    row[$(this).attr('name')] = $(this).is(':checked');
                } else {
                    var valeur = $(this).val();
                    if ($(this).hasClass("item_price") || $(this).hasClass(
                            "subtotal") || $(this).hasClass("item_total")) {
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
        var total_invoice_final = $('#total_invoice').html();
        total_invoice_final = accepted_float_input(total_invoice_final);

        var total_a_payer_invoice = $('#total_a_payer_invoice').html();
        total_a_payer_invoice = accepted_float_input(total_a_payer_invoice);

        var montant_sous_tot_invoice = $('#montant_sous_tot_invoice').html();
        montant_sous_tot_invoice = accepted_float_input(montant_sous_tot_invoice);

        var tot_tva_invoice = $('#tot_tva_invoice').html();
        tot_tva_invoice = accepted_float_input(tot_tva_invoice);

        var montant_remise_invoice = $('#montant_remise_invoice').val();
        montant_remise_invoice = accepted_float_input(montant_remise_invoice);

        var montant_acompte_invoice = $('#montant_acompte_invoice').val();
        montant_acompte_invoice = accepted_float_input(montant_acompte_invoice);
        // console.log(items);
        if (items_count > 0) {
            $.post("<?php echo site_url('invoices/ajax/saveavoir'); ?>", {
                    invoice_id: $('#invoice_id').val(),
                    invoice_idd: $('#invoiceidd').val(),
                    piece_id: $('#piece_id').val(),
                    payement_id: $('#payement_id').val(),
                    client_name: $('#client_name').val(),
                    client_id: $('#client_id').val(),
                    invoice_number: $('#invoice_number').val(),
                    invoice_date_created: $('#invoice_date_created').val(),
                    invoice_date_expires: $('#invoice_date_due').val(),
                    invoice_status_id: $('#invoice_status_id').val(),
                    invoice_password: $('#invoice_password').val(),
                    invoice_date_accepte: $('#invoice_date_accepte').val(),
                    invoice_nature: $('#invoice_nature').val(),
                    invoice_delai_paiement: $('#invoice_delai_paiement').val(),
                    notes: $('#notes').val(),
                    pourcent_remise_invoice: $('#pourcent_remise_invoice').val(),
                    montant_remise_invoice: montant_remise_invoice,
                    pourcent_acompte_invoice: $('#pourcent_acompte_invoice').val(),
                    montant_acompte_invoice: montant_acompte_invoice,
                    montant_sous_tot_invoice: $('#montant_sous_tot_invoice').html(),
                    tot_tva_invoice: $('#tot_tva_invoice').html(),
                    timbre_fiscale_span: $('#timbre_fiscale_span').html(),
                    total_invoice: $('#total_invoice').html(),
                    total_a_payer_invoice: total_a_payer_invoice,
                    custom: $('input[name^=custom]').serializeArray(),
                    user_id: '<?php echo $this->session->userdata('
                    user_id '); ?>',
                    items: JSON.stringify(items),
                    items_count: items_count,
                    invoice_item_subtotal_final: montant_sous_tot_invoice,
                    invoice_item_tax_total_final: tot_tva_invoice,
                    total_invoice_final: total_invoice_final,
                    date_relance: $('#date_relance').val(),
                    document: $('#drap').val(),
                    listdocu: $('#listdocument').val(),
                    piece: $('#joint').val(),
                    signature: $('#signature').val()
                },
                function(data) {
                    var response = JSON.parse(data);
                    if (response.success == '1') {
                        window.location = "<?php echo site_url('invoices/avoir'); ?>";
                    } else {

                        $("#div_err").empty();
                        var msg_err = response.validation_errors;
                        //console.log(msg_err);
                        var ms_err = msg_err.split("<\/p>\n");
                        //  console.log(ms_err);
                        for (i = 0; i < ms_err.length; i++) {
                            a = ms_err[i].replace('<p>', '');

                            if (a != '') {
                                $("#div_err").append("<div class='alert alert-danger msg_er'>" + a +
                                    ".</div>");
                            }
                        }
                        $('.control-group').removeClass('error');
                        for (var key in response.validation_errors) {
                            $('#' + key).parent().parent().addClass('error');
                        }

                    }
                });
        } else {
            $("#div_err").empty();
            $("#div_err").append(
                "<div class='alert alert-danger msg_er'>Insérer au moins une ligne.</div>");
        }
    });
    $('#btn_add_product').click(function() {
        $('#addrowid').val('0');
        $('#modal-placeholder').load(
            "<?php echo site_url('products/ajax/modal_product_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {
                devise: $('#devise').val(),
                type_doc: "invoice"
            });
    });
    $("#btn_add_row").click(function() {
        $('#addrowid').val(1);
        addRow();
    });
    $('#pourcent_remise_invoice').keyup(function() {
        changedPercentRemise();
        changeCalculDownTable();
        changeTotalPaye();
        $(this).focusout(function() {
            $(this).val(beautifyFormat($(this).val(), "float2"));
            changedPercentRemise();
            changeCalculDownTable();
            changeTotalPaye();
        });
    });
    $('#montant_remise_invoice').keyup(function() {
        changedMontantRemise();
        changeCalculDownTable();
        changeTotalPaye();
        $(this).focusout(function() {
            $(this).val(beautifyFormat($(this).val(), "float"));
            changedMontantRemise();
            changeCalculDownTable();
            changeTotalPaye();
        });
    });
    $('#pourcent_acompte_invoice').keyup(function() {
        changedPercentAcompte();
        changeTotalPaye();
        $(this).focusout(function() {
            $(this).val(beautifyFormat($(this).val(), "float2"));
            changeTotalPaye();
        });
    });
    $('#montant_acompte_invoice').keyup(function() {
        changedMontantAcompte();
        changeTotalPaye();
        $(this).focusout(function() {
            $(this).val(beautifyFormat($(this).val(), "float"));
            changeTotalPaye();
        });
    });

    $('#payment_method').change(function() {
        var meth = $(this).val(); //alert(meth);
        if (meth == 1) {
            $('#div_cheq').show();
            $('#div_vir').hide();
            $('#div_esp').hide();
        }
        if (meth == 3) {
            $('#div_esp').show();
            $('#div_cheq').hide();
            $('#div_vir').hide();
        }
        if ((meth == 2) || (meth == 4)) {
            $('#div_cheq').hide();
            $('#div_esp').hide();
            $('#div_vir').show();
        }
        if ((meth != 1) && (meth != 3) && (meth != 2) && (meth != 4)) {
            $('#div_cheq').hide();
            $('#div_esp').hide();
            $('#div_vir').hide();
        }
    });

    $('#invoice_delai_paiement').change(function() {
        var optionSelected = $("option:selected", this);
        var valueSelected = optionSelected.html();
        $('#notes').val(valueSelected.trim());
    });
    // Recupération des ligne facture
    $.post("<?php echo site_url('invoices/ajax/getItemsByInvoiceavoir'); ?>", {
        invoice_id: $('#invoiceid').val()
    }, function(data) {
        items = JSON.parse(data);
        for (var key in items) {
            items[key].tax_rate_id_dev = items[key].item_tax_rate_id;
            items[key].product_sku = items[key].item_code;
            items[key].product_description = items[key].item_description;
            items[key].product_price_dev = items[key].item_price;
            items[key].product_subtotal = items[key].item_subtotal;
            items[key].montantTVATotal = items[key].item_total;
            items[key].product_quantite = items[key].item_quantity;
            addRow(items[key], 0);
        }
        $('#modal-choose-items').modal('hide');
        $(".name_prod").focus();
        $('.name_prod').typeahead();
    });
    // FIN Recupération des ligne facture
    $("#pourcent_remise_invoice").val(beautifyFormat($('#invoice_pourcent_remise').val(),
        "float2"));
    $("#montant_remise_invoice").val(beautifyFormat($('#invoice_montant_remise').val(),
        "float"));
    $("#pourcent_acompte_invoice").val(beautifyFormat($('#invoice_pourcent_acompte').val(),
        "float2"));
    $("#montant_acompte_invoice").val(beautifyFormat($('#invoice_montant_acompte').val(),
        "float"));
    $("#timbre_fiscale_span").text(beautifyFormat($('#timbre_fiscale').val(), "float"));

    $("#montant_sous_tot_invoice").text(beautifyFormat($('#invoice_item_subtotal').val(),
        "float"));
    $("#tot_tva_invoice").text(beautifyFormat($('#invoice_item_tax_total').val(),
        "float"));
    $("#total_invoice").text(beautifyFormat($('#invoice_total').val(), "float"));
    $("#total_a_payer_invoice").text(beautifyFormat($('#invoice_balance').val(), "float"));



});
</script>

<input type="hidden" id="addrowid" value="0">
<input type="hidden" id="pourcent_remise_invoice" value="<?php echo $invoice->invoice_pourcent_remise; ?>">
<input type="hidden" id="invoice_montant_remise" value="<?php echo $invoice->invoice_montant_remise; ?>">
<input type="hidden" id="invoice_pourcent_acompte" value="<?php echo $invoice->invoice_pourcent_acompte; ?>">
<input type="hidden" id="invoice_montant_acompte" value="<?php echo $invoice->invoice_montant_acompte; ?>">
<input type="hidden" id="timbre_fiscale" value="<?php echo $invoice->timbre_fiscale; ?>">
<input type="hidden" id="invoice_item_subtotal" value="<?php echo $invoice->invoice_item_subtotal; ?>">
<input type="hidden" id="invoice_item_tax_total" value="<?php echo $invoice->invoice_item_tax_total; ?>">
<input type="hidden" id="invoice_total" value="<?php echo $invoice->invoice_total; ?>">
<input type="hidden" id="invoice_balance" value="<?php echo $invoice->invoice_balance; ?>">

<input type="hidden" id="invoiceid" value="<?php echo $invoice->haveinvoice_id; ?>">
<input type="hidden" id="invoiceidd" value="<?php echo $invoice->invoice_id; ?>">

<input type="hidden" id="current_id_table_invoice" value="0">
<input type="hidden" id="devise" value="<?php echo $invoice->devise_id; ?>">
<input type="hidden" id="symbole_devise" value="<?php echo $invoice->devise_symbole; ?>">


<input type="hidden" id="tax_rate_decimal_places" value="<?php echo $invoice->number_decimal; ?>">
<input type="hidden" id="currency_symbol_placement" value="<?php echo $invoice->symbole_placement; ?>">
<input type="hidden" id="thousands_separator" value="<?php echo $invoice->thousands_separator; ?>">
<input type="hidden" id="decimal_point" value="." />
<?php
if ($this->config->item('disable_read_only') == true) {
    $invoice->is_read_only = 0;
}

?>
<input type='hidden' id='assigite_tva' value="<?php echo $settingstva ?>">
<input type="hidden" id="etat_montant_acccont" value="0">
<div id="headerbar-index">
<?php $this->layout->load_view('layout/alerts');?>
</div>
<div id="div_err"></div>
<div id="content">
		<div class="portlet light profile no-shabow bg-light-blue">
			<div class="portlet-header">
				<div class="portlet-title align-items-start flex-column">
					<div class="caption font-dark-sunglo">
						<span class="caption-subject bold med-caption dark"><?php echo lang('avoir'); ?> #<?php echo $invoice->invoice_number; ?> <?php echo lang('sur'); ?>  <?php echo lang('invoice'); ?> #<?php echo $invoice->invoice_number_origin; ?></span>
					</div>
				</div>
				<div class="portlet-toolbar">
					                <div class="pull-right <?php if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) {?>btn-group<?php }?>">
                    <div class="options btn-group pull-left">
                        <a class="btn btn-sm default dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo lang('options'); ?> <i class="fa fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu" style="margin-left: -100%;">
                            <?php if ($invoice->is_read_only != 1) {?>
                            <li style=" display: none">
                                <a href="#add-invoice-tax" data-toggle="modal">
                                    <i class="fa fa-plus fa-margin"></i> <?php echo lang('add_invoice_tax'); ?>
                                </a>
                            </li>
                            <?php }?>
                            <li style=" display: none">
                                <a href="#" id="btn_create_credit" data-invoice-id="<?php echo $invoice_id; ?>">
                                    <i class="fa fa-minus fa-margin"></i> <?php echo lang('create_credit_invoice'); ?>
                                </a>
                            </li>

                            <li style=" display:none">

                                <a href="<?php echo site_url('invoices/download/' . $invoice->invoice_id); ?>"
                                    target="_blank">
                                    <i class="fa fa-file-pdf-o  fa-margin"></i>
                                    <?php echo lang('pdf'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/invoices/generate_pdf_avoir/' . $invoice->haveinvoice_id); ?>"
                                    target="_blank">
                                    <i class="fa fa-print fa-margin"></i> <?php echo lang('download_pdf'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/mailer/avoir/' . $invoice->haveinvoice_id); ?>">
                                    <i class="fa fa-send fa-margin"></i>
                                    <?php echo lang('send_email'); ?>
                                </a>
                            </li>

                            <li style=" display: none">
                                <a href="#" id="btn_create_recurring" data-invoice-id="<?php echo $invoice_id; ?>">
                                    <i class="fa fa-repeat fa-margin"></i>
                                    <?php echo lang('create_recurring'); ?>
                                </a>
                            </li>
                            <li style=" display: none">
                                <a href="#" id="btn_copy_invoice" data-invoice-id="<?php echo $invoice_id; ?>">
                                    <i class="fa fa-copy fa-margin"></i>
                                    <?php echo lang('copy_invoice'); ?>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <?php if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) {?>
                    <a href="#" class="btn btn-sm btn-success" id="btn_save_invoice">
                        <!--i class="fa fa-check"></i--><?php echo lang('save'); ?>
                    </a>
                    <?php }?>
                </div>
				<div class="invoice-labels pull-right" style=" display: none">
                    <?php if ($invoice->invoice_is_recurring) {?>
                    <span class="label label-info"><?php echo lang('recurring'); ?></span>
                    <?php }?>
                    <?php if ($invoice->is_read_only == 1) {?>
                    <span class="label label-danger">
                        <i class="fa fa-read-only"></i> <?php echo lang('read_only'); ?>
                    </span>
                    <?php }?>
                </div>
				</div>
			</div>
			<div class="portlet-body">
    <form id="invoice_form" class="">
        <div class="row">
            <!-- AJOUT CONTACT-->
            <div class="col-md-5">
				<div class="portlet light formulaire no-padding first">
						<div class="content-heading">
							<div class="portlet-title left-title">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold med-caption dark"><?php echo lang('client'); ?></span>
								</div>
							</div>
						</div>
						<div class="row card-row form-row bg-light-blue-card">
						<div class="col-md-12">						
                        <?php
if ($invoice->client_titre == 0) {
    $client_titre = lang('mister');
} elseif ($invoice->client_titre == 1) {
    $client_titre = lang('mistress');
} elseif ($invoice->client_titre == 2) {
    $client_titre = lang('mistress');
}
?>
							<input type="hidden" id="client_id" name="client_id" value="<?php echo $invoice->client_id; ?>">
							<input type="hidden" name="client_name" id="client_name" value="<?php echo $invoice->client_name ?>">
							<span id="client_infos_edit" style="line-height: 20px;">
								<h4 class="clt_name">
									<a
										href="<?php echo site_url('clients/view/' . $invoice->client_id); ?>"><?php echo $client_titre . ' ' . $invoice->client_name . ' ' . $invoice->client_prenom; ?></a>
								</h4><br>
								<span><span><b style="font-size: 12px;font-weight: 600;"><?php echo lang('address'); ?> :&nbsp;</b></span>
									<?php echo ($invoice->client_address_1) ? $invoice->client_address_1 . ' ' : ''; ?>
									<?php echo ($invoice->client_address_2) ? $invoice->client_address_2 . ' ' : ''; ?>
									<?php echo ($invoice->client_city) ? $invoice->client_city : ''; ?>
									<?php echo ($invoice->client_state) ? $invoice->client_state : ''; ?>
									<?php echo ($invoice->client_zip) ? $invoice->client_zip : ''; ?>
									<?php echo ($invoice->client_country) ? ' ' . $invoice->client_country : ''; ?>
								</span>
                            <br>
								<?php if ($invoice->client_phone) {?>
								<span><b style="font-size: 12px;font-weight: 600;"><?php echo lang('phone'); ?>:&nbsp;</b>
									<?php echo $invoice->client_phone; ?></span><br>
								<?php }?>
								<?php if ($invoice->client_email) {?>
								<span><b style="font-size: 12px;font-weight: 600;"><?php echo lang('email'); ?>:&nbsp;</b>
									<?php echo $invoice->client_email; ?></span>
								<?php }?>
							</span>
						</div>
						<!--div class="col-md-2">
							<button disabled id="search_client" type="button" class="btn btn-success">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</div-->
						<div class="clearfix"></div>
					</div>
            </div>
            </div>
            <div class="col-md-7">
				<div class="portlet light formulaire no-padding">
                   <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice->haveinvoice_id; ?> ">
					<div class="content-heading">
						<div class="portlet-title left-title">
							<div class="caption font-dark-sunglo">
								<span class="caption-subject bold med-caption dark"><?php echo lang('avoir'); ?></span>
							</div>
						</div>
					</div>
                    <?php if ($invoice->invoice_sign == -1) {?>
                    <div class="invoice-properties">
                        <span class="label label-warning">
                            <i class="fa fa-credit-invoice"></i>&nbsp;
                            <?php
echo lang('credit_invoice_for_invoice') . ' ';
    echo anchor('/invoices/view/' . $invoice->creditinvoice_parent_id, $invoice->creditinvoice_parent_id)
    ?>
                        </span>
                    </div>
                    <?php }?>
					<div class="row card-row form-row">
                        <div class="col-sm-6">
                            <div class="form-grouphas-info">
                                <label for="form_control_1"><?php echo lang('invoice'); ?> #</label>
                                <input type="text" id="invoice_number" readonly="readonly" class="form-control form-control-lg form-control-light"
                                    value="<?php echo $invoice->invoice_number; ?>" <?php
if ($invoice->is_read_only == 1) {
    echo 'disabled="disabled"';
}
?>>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('quote_nature'); ?><span class="text-danger">*</span></label>
                                <input disabled="disabled" type="text" id="invoice_nature" class="form-control form-control-lg form-control-light"
                                    value="<?php echo $invoice->nature; ?>" <?php
if ($invoice->is_read_only == 1) {
    echo 'disabled="disabled"';
}
?>>
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </div>
					<div class="row card-row form-row">
                        <div class="col-sm-6">
                            <div class="form-group has-info">
                                <div class="quote-properties has-feedback">
                                        <label for="form_control_1"><?php echo lang('date'); ?></label>
                                    <div class="input-group">
                                        <input disabled name="invoice_date_created" id="invoice_date_created"
                                            class="form-control form-control-lg form-control-light datepicker" title="<?php echo lang('date'); ?>"
                                            value="<?php echo date_from_mysql($invoice->date_create_avoir_invoice); ?>" <?php
if ($invoice->is_read_only == 1) {
    echo 'disabled="disabled"';
}
?>>
                                        <div class="form-control-focus"> </div>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group has-info">
                                <div class="quote-properties has-feedback">
                                    <label for="form_control_1"><?php echo lang('due_date'); ?></label>
                                    <div class="input-group">
                                        <input disabled name="invoice_date_due" id="invoice_date_due"
                                            class="form-control form-control-lg form-control-light datepicker"
                                            value="<?php echo date_from_mysql($invoice->invoice_date_due); ?>" <?php
if ($invoice->is_read_only == 1) {
    echo 'disabled="disabled"';
}
?>>
                                        <div class="form-control-focus"> </div>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row card-row form-row">
                        <div class="col-sm-6">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('quote_delai_paiement'); ?></label>
                                <select disabled name="invoice_delai_paiement" id="invoice_delai_paiement"
                                    class="form-control form-control-lg form-control-light">
                                    <option value="0">

                                    </option>
                                    <?php foreach ($delaiPaiement as $delaiPaim) {?>
                                    <option <?php
if ($invoice->invoice_delai_paiement == $delaiPaim->delai_paiement_id) {
    echo "selected='selected'";
}
    ?> value="<?php echo $delaiPaim->delai_paiement_id; ?>">
                                        <?php echo $delaiPaim->delai_paiement_label; ?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                     <div class="sup offline" style="margin-top: 34px;"> </div>
                            <div class="md-checkbox">
                            <?php if($invoice->signature==1){ ?>
                                <input type="checkbox" checked value="1" name="signature" id="signature" class="md-check">
                            <?php }else{ ?>
                                <input type="checkbox" value="0" name="signature" id="signature" class="md-check">
                                <?php }?>
                                <label for="signature">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>                                     
                                    <?php echo lang('credit_invoice'); ?> <?php echo lang('signature'); ?>
                                </label>
                            </div>
                            <!---  <div>
                                <input type="checkbox" id="drap" value="0" name="drap" class="md-check">
                                <label for="drap"> Joindre documents</label>
                            </div>-->
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </form>
	</div>
 </div>
    <!--AJOUT PRODUIT-->
	<div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark"><?php echo lang('products'); ?></span>
				</div>			
			</div>
			<div class="portlet-toolbar">
				<div class="pull-right btn-group">
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
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<div id="fact_prod">
				<div class="row card-row form-row">
					<div class="col-md-12">
                    <?php $this->layout->load_view('invoices/partial_item_table');?>
                    <div style="clear:both"></div>
                    <br>
                    <div class="form-group has-info">
                        <label for="form_control_1"><?php echo lang('notes'); ?></label>
							<textarea height="40" name="notes" id="notes" style="width: 100%;padding: 5px 10px;height:80px;" class="form-control" value="<?php echo $invoice->invoice_terms; ?>"></textarea>
                        <div class="form-control-focus"></div>
                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>

        <!-- FIN AJOUT PRODUIT-->
    </div>
    <script>
    $(document).ready(function() {
        str = $('#timbre_fiscale_span').text();
        if (str < 0) {
            $("#timbre_fiscale_span").text(str.substr(1, str.length));
        }
    })
    $('#signature').change(function() {
        if ($(this).prop("checked")) {
            $('#signature').val('1');
        } else {
            $('#signature').val('0');
        }
    });
    </script>