<style>
.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    /* Safari */
    animation: spin 1s linear infinite;

}

/* Safari */
@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

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
</style>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
    rel="stylesheet" type="text/css">
<script type="text/javascript">
var tab = [];

function mydoc(x) {
    // alert();
    if ($('#doccheck' + x).prop("checked")) {
        tab.push($('#doccheck' + x).val());

    } else {
        for (var i = 0; i < tab.length; i++) {
            if (tab[i] == x) {
                tab.splice(i, 1);
            }
        }
    }
    $('#listdocument').val(tab);


}

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
    var languesel = $('#langue').val();
    if (!items) {
        var item_code_value = "";
        var item_description_value = "";
        var item_quantity_value = "1";
        var item_price_value = beautifyFormat(0, "float");
        var subtotal_value = beautifyFormat(0, "float");
        var item_tax_rate_id_value = 0;
        var item_total_value = beautifyFormat(0, "float");
        var depot_id = 0;
    } else {
        var item_code_value = items.product_sku;
         var item_description_value ="";
        
         if(languesel=="Arabic"){
              item_description_value += items.product_description_ar;
        }
        if(languesel=="English"){
              item_description_value += items.product_description_eng;
        }
        if(languesel=="French" ){
              item_description_value += items.product_description;
        }
        var item_quantity_value = items.product_quantite ? (items.product_quantite) : 1;
        var item_price_value = beautifyFormat(items.product_price_dev, "float");
        var subtotal_value = items.product_subtotal ? beautifyFormat(items.product_subtotal, "float") :
            beautifyFormat(
                items.product_price_dev, "float");
        var item_tax_rate_id_value = items.tax_rate_id_dev;
        var item_total_value = beautifyFormat(items.montantTVATotal, "float");
        var depot_id = items.depot;
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
            row_add += '<td align="center" style="width: 25px;"><i class="fa fa-arrows cursor-move"></i><input type="hidden" name="depot" value="'+depot_id+'"></td>';
            row_add += '<td style="width: 200px;"><input type="text" name="item_code" id="item_code_' +
                current_id +
                '" class="name_prod form-control" class="form-control" value="' + item_code_value +
                '" autocomplete="off" data-id="' + current_id + '"></td>';
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

            changeCalculDownTable();
            changedPercentRemise();
            changedPercentAcompte();
            changeTotalPaye();

        })
    } else {

        row_add_tax += '<option value="3"  selected = "selected" >0</option>';
        var current_id = $("#current_id_table_invoice").val();
        var row_add = '<tr class=" item ui-sortable-handle tr_prod_' + current_id + '">';
        row_add += '<td align="center" style="width: 25px;"><i class="fa fa-arrows cursor-move"></i><input type="hidden" name="depot" value="'+depot_id+'"></td>';
        row_add += '<td style="width: 200px;"><input type="text" name="item_code" id="item_code_' +
            current_id +
            '" class="name_prod form-control" class="form-control" value="' + item_code_value +
            '" autocomplete="off" data-id="' + current_id + '"></td>';
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
        var quantite = accepted_float_input($("#item_quantity_" + dataid).val());
        var item_tax_rate = $("#item_tax_rate_" + dataid + " option:selected").text();
        var subtotal = quantite * valeur;
        var itemtotal = subtotal * (1 + (item_tax_rate / 100));
        $("#subtotal_" + dataid).val(numberFormatFloat(subtotal));
        $("#item_total_" + dataid).val(numberFormatFloat(itemtotal));
    }
    break;
    case "subtotal": {
        var quantite = accepted_float_input($("#item_quantity_" + dataid).val());
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
        var quantite = accepted_float_input($("#item_quantity_" + dataid).val());
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
      //  total += Number(accepted_float_input($(this).find(".item_total").val()));
        total += Number(accepted_float_input($(this).find(".item_price").val()));

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
        total += Number(accepted_float_input($(this).find(".item_price").val()));
       // total += Number(accepted_float_input($(this).find(".item_total").val()));
    });
    var montant_remise = accepted_float_input($("#montant_remise_invoice").val());
    if (Number(montant_remise) > total) {
        montant_remise = total;
    }
    $("#montant_remise_invoice").val(beautifyFormat(montant_remise));
    var persent_remise = (Number(montant_remise) * 100) / total;
    //$("#pourcent_remise_invoice").val(beautifyFormat(persent_remise, "float2"));
    $("#pourcent_remise_invoice").val(beautifyFormat(persent_remise, "float5"));
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


function f_load() {
    pat = location.pathname;
    path = pat.split("/");
    if ((path[4])) {
        updatePaymentList(path[4]);

        $('#invoice_nature').val('');
        $('#invoice_delai_paiement').val('');
        $('#invoice_password').val('');
        $('#invoice_status_id').val('1');


        $('.name_prod').val('');
        $('.desc_prod').val('');
        $('.item_quantity').val('1');
        $('.item_price').val('');
        $('.item_tax_rate_id').val('1');
        $('.subtotal').val('');
        $('.item_tax_total').val('');
        $('.item_total').val('');

        $('#fact_prod').show();

        $('#invoice_nature').attr('disabled', false);
        $('#invoice_date_created').attr('disabled', false);
        $('#invoice_date_expires').attr('disabled', false);
        $('#invoice_delai_paiement').attr('disabled', false);
        $('#invoice_password').attr('disabled', false);
        $('#invoice_status_id').attr('disabled', false);

        $('#btn_add_row').attr('disabled', false);
        $('#btn_add_product').attr('disabled', false);

        $('.name_prod').attr('disabled', false);
        $('.desc_prod').attr('disabled', false);
        var devise_symbole = $('#symbole_devise').val();
        var tax_rate_decimal_places = $('#tax_rate_decimal_places').val();
        var currency_symbol_placement = $('#currency_symbol_placement').val();
        var thousands_separator = $('#thousands_separator').val();

        if (currency_symbol_placement == "before") {
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
        $('#montant_remise_invoice').val(beautifyFormat(0, "float"));
        $('#montant_acompte_invoice').val(beautifyFormat(0, "float"));
        $('#montant_sous_tot_invoice').text(beautifyFormat(0, "float"));
        $('#tot_tva_invoice').text(beautifyFormat(0, "float"));
        $('#total_invoice').text(beautifyFormat(0, "float"));
        $('#total_a_payer_invoice').text(beautifyFormat(0, "float"));
        $('#timbre_fiscale_span').text(beautifyFormat($('#timbre_fiscale_span').text(), "float"));
    } else {
        $('#client_titre').val('');
        $('#client_name').val('');
        $('#client_societe').val('');
        $('#client_address').val('');
        $('#client_pays').val('');
        $('#vat_id').val('');
        $('#tax_code').val('');
        $('#invoice_nature').val('');
        $('#invoice_delai_paiement').val('');
        $('#invoice_password').val('');
        $('#invoice_status_id').val('1');


        $('#fact_prod').hide();
        $('#client_titre').attr('disabled', true);
        $('#client_name').attr('disabled', true);
        $('#client_societe').attr('disabled', true);
        $('#client_address').attr('disabled', true);
        $('#client_pays').attr('disabled', true);
        $('#vat_id').attr('disabled', true);
        $('#tax_code').attr('disabled', true);

        $('#invoice_nature').attr('disabled', true);
        $('#invoice_date_created').attr('disabled', true);
        $('#invoice_date_expires').attr('disabled', true);
        $('#invoice_delai_paiement').attr('disabled', true);
        $('#invoice_password').attr('disabled', true);
        $('#invoice_status_id').attr('disabled', true);
        $('#btn_add_row').attr('disabled', true);
        $('#btn_add_product').attr('disabled', true);

        $('.name_prod').attr('disabled', true);
        $('.desc_prod').attr('disabled', true);
    }
}
$(function() {

    $("#client_name").focus();
    $('#client_name').typeahead();
    $('#client_name').keypress(function() {
        var self = $(this);

        $.post("<?php echo site_url('clients/ajax/name_query_id'); ?>", {
            query: self.val()
        }, function(data) {
            var parsed = JSON.parse(data);

            var json_response = [];

            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            $('#client_id').val(json_response[1]);
            self.data('typeahead').source = json_response;
        });
    });
    $('#client_name').change(function() {
        var self = $(this);
        $.post("<?php echo site_url('clients/ajax/load_client_details'); ?>", {
            query: $('#client_id').val(),
        }, function(data) {

            var parsed = JSON.parse(data);
            var json_response = [];
            for (var x in parsed) {
                json_response.push(parsed[x]);
            }
            $('#client_nomPrenom').val(json_response[0] + ' ' + json_response[1]);
            $('#client_address').val(json_response[2] + ' ' + json_response[4] + ' ' +
                json_response[3]);
            $('#client_pays').val(json_response[5]);
            $('#client_societe').val(json_response[6]);
            $('#client_titre option[value=' + json_response[7] + ']').attr('selected',
                'selected');
            $('#tax_code').val(json_response[10]);
            $('#vat_id').val(json_response[9]);
            $('#timbre_fiscale_span').html(json_response[13]);
            $('#symbole_devise').val(json_response[12]);
        });
    });

    $('#btn_add_product').click(function() {
        $('#modal-placeholder').load("<?php echo site_url('products/ajax/modal_product_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {
                devise: $('#devise').val(),
                type_doc: "invoice",
                langue: $('#langue').val(),
            });
    });
    $("#btn_add_row").click(function() {
        addRow();
    });
    $('#btn_save_invoice,#btn_save_invoice2').click(function() {
        var items = [];
        var item_order = 1;
        $('#btn_save_invoice2').attr("disabled", 'disabled');
        $('#btn_save_invoice').attr("disabled", 'disabled');
        $("div .loader").attr("hidden", false);

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
        var payments = [];
        $('.chk_payments:checked').each(function() {
            var idpay = $(this).attr('id');
            var id_pay = idpay.substr(12);
            payments.push(id_pay);
        });





        var items_count = items.length;
        var total_invoice_final = $('#total_invoice').html();
        total_invoice_final = Number(total_invoice_final.replace(/[^0-9\.]+/g, ""));

        var total_a_payer_invoice = $('#total_a_payer_invoice').html();
        total_a_payer_invoice = Number(total_a_payer_invoice.replace(/[^0-9\.]+/g, ""));

        var montant_sous_tot_invoice = $('#montant_sous_tot_invoice').html();
        montant_sous_tot_invoice = Number(montant_sous_tot_invoice.replace(/[^0-9\.]+/g, ""));

        var tot_tva_invoice = $('#tot_tva_invoice').html();
        tot_tva_invoice = Number(tot_tva_invoice.replace(/[^0-9\.]+/g, ""));

        var montant_remise_invoice = $('#montant_remise_invoice').val();
        montant_remise_invoice = Number(montant_remise_invoice.replace(/[^0-9\.]+/g, ""));

        var montant_acompte_invoice = $('#montant_acompte_invoice').val();
        montant_acompte_invoice = Number(montant_acompte_invoice.replace(/[^0-9\.]+/g, ""));

        var montant_sous_tot_invoice = $('#montant_sous_tot_invoice').html();
        montant_sous_tot_invoice = Number(montant_sous_tot_invoice.replace(/[^0-9\.]+/g, ""));

        var tot_tva_invoice = $('#tot_tva_invoice').html();
        tot_tva_invoice = Number(tot_tva_invoice.replace(/[^0-9\.]+/g, ""));

        var timbre_fiscale_span = $('#timbre_fiscale_span').html();
        timbre_fiscale_span = Number(timbre_fiscale_span.replace(/[^0-9\.]+/g, ""));

        var total_invoice = $('#total_invoice').html();
        total_invoice = Number(total_invoice.replace(/[^0-9\.]+/g, ""));

        var total_a_payer_invoice = $('#total_a_payer_invoice').html();
        total_a_payer_invoice = Number(total_a_payer_invoice.replace(/[^0-9\.]+/g, ""));
        $.post("<?php echo site_url('invoices/ajax/create'); ?>", {

                client_name: $('#client_name').val(),
                client_id: $('#client_id').val(),
                invoice_number: $('#invoice_number').val(),
                invoice_date_created: $('#invoice_date_created').val(),
                invoice_date_expires: $('#invoice_date_expires').val(),
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
                montant_sous_tot_invoice: montant_sous_tot_invoice,
                tot_tva_invoice: tot_tva_invoice,
                timbre_fiscale_span: timbre_fiscale_span,
                total_invoice: total_invoice,
                total_a_payer_invoice: total_a_payer_invoice,
                custom: $('input[name^=custom]').serializeArray(),
                user_id: $('#userconnecte').val(),
                items: JSON.stringify(items),
                items_count: items_count,
                invoice_item_subtotal_final: montant_sous_tot_invoice,
                invoice_item_tax_total_final: tot_tva_invoice,
                total_invoice_final: total_invoice_final,
                payments: payments,
                date_relance: $('#date_relance').val(),
                document: $('#drap').val(),
                listdocu: $('#listdocument').val(),
                joindredevis: $('#Joint').val(),
                recursive: $('#recursive').val(),
                recursive_id: $('#recursive_id').val(),
                signature: $('#signature').val(),
                langue:  $('#langue').val(),
                photo:  $('#photo').val(),
            },
            function(data) {
                var response = JSON.parse(data);
                if (response.success == '1') {
                    window.location = "<?php echo site_url('invoices/index'); ?>";
                } else {
                    $('#btn_save_invoice2').attr("disabled", false);
                    $('#btn_save_invoice').attr("disabled", false);
                    $("div .loader").attr("hidden", true);

                    $("#div_err").empty();
                    var msg_err = response.validation_errors;
                    //console.log(msg_err);
                    var ms_err = msg_err.split("<\/p>\n");
                    // console.log(ms_err);
                    for (i = 0; i < ms_err.length; i++) {
                        a = ms_err[i].replace('<p>', '');

                        if (a != '') {
                            $("#div_err").append("<div class='alert alert-danger msg_er' style='margin-left: 15px;margin-right: 15px;'>" +
                                a + "<button class='close' data-close='alert'></button></div>");
                        }
                    }
                    $('.control-group').removeClass('error');
                    for (var key in response.validation_errors) {
                        $('#' + key).parent().parent().addClass('error');
                    }
                }
            });
    });
    $('#search_client').click(function() {
        if($('#langue').val()){
        $('#modal-placeholder').load("<?php echo site_url('clients/ajax/modal_client_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {
                type_doc: "invoice"
            });
        }else{
            alert($('#langmsg').val())
        }
    });
    $('#invoice_delai_paiement').change(function() {
        var optionSelected = $("option:selected", this);
        var valueSelected = optionSelected.html();
        $('#notes').val(valueSelected.trim());
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

});

function updatePaymentList(client_id) {
    $("#display_latest_payments").show();
    $("#invoice-add-payment").attr('data-client-id', client_id);
    $.post("<?php echo site_url('payments/ajax/get_payments_without_invoices'); ?>", {
        client_id: client_id
    }, function(data) {
        var parsed = JSON.parse(data);
        var json_response = [];
        for (var x in parsed) {
            json_response.push(parsed[x]);
        }
        var payment = json_response[0];
        if (payment.length != 0) {
            var list_payments = "";
            $.each(payment, function(key, value) {
                //                                alert(value.payment_date);
                var date_pay_array = value.payment_date.split("-");
                var date_pay = date_pay_array[2] + "/" + date_pay_array[1] + "/" + date_pay_array[0];
                list_payments +=
                    "<tr><td align='center'><input type='checkbox' class='chk_payments' id='chk_payment_" +
                    value.payment_id + "'></td><td align='center'>" + date_pay +
                    "</td><td align='center'>" + value.payment_method_name +
                    "</td><td align='center'>" + beautifyFormatWithDevice(value.payment_amount) +
                    "</td></tr>";
            });

            $("#latest_payments").html(list_payments);
        } else {
            //                            $("#display_latest_payments").hide();
            $("#latest_payments").html("");

        }

    });
}
</script>
 <div style="position: absolute;top: 0;bottom: 0;left: 0;right: 0;margin: auto;z-index: 6" hidden
                        class="loader"></div>
<input type="hidden" id="etat_montant_acccont" value="0">
<input type="hidden" id="userconnecte" value="<?php echo $this->session->userdata('user_id'); ?>">
<input type="hidden" id="listdocument" value="">
<input type="hidden" id="current_id_table_invoice" value="0">
<input type="hidden" id="assigite_tva" value="<?php echo $setting ?>">
<input type="hidden" id="langmsg" value="<?php echo lang('msg_lang') ?>">

<body onload="f_load()">
    <input type="hidden" name="devise" id="devise">
    <div id="headerbar-index">
		<?php $this->layout->load_view('layout/alerts');?>
    </div>
  <div id="div_err"></div>
 <div id="content">
        <form id="invoice_form">
			<div class="portlet light profile no-shabow bg-light-blue">
				<div class="portlet-header">
					<div class="portlet-title align-items-start flex-column">
						<div class="caption font-dark-sunglo">
							<span class="caption-subject bold med-caption dark"><?php echo lang('invoice'); ?></span><br />
							<span class="caption-subject text-bold small-caption muted"><?php echo lang('add_invoice'); ?></span>
						</div>
					</div>
					<div class="portlet-toolbar">
						<div class="pull-right btn-group">
							<a class="btn btn-success btn-sm blue bg-success text-success" id="btn_save_invoice">
								<?php echo lang('save'); ?>
							</a>
						</div>	
					</div>
				</div>
			<div class="portlet-body stock">
				<div class="row">
                <div class="col-md-6">
                <!-- AJOUT CONTACT-->					
				<div class="portlet light formulaire no-padding first">
						<div class="content-heading">
							<div class="portlet-title left-title">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold med-caption dark"><?php echo lang('client'); ?></span>
								</div>
							</div>
						</div>
                        <!-- info client-->

                        <?php
$clie_id = $this->uri->segment('4');
$tt = '';
if ($this->uri->segment('4')) {
    $icli = $this->db->select()->where('client_id', $clie_id);
    $icli = $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
    $icli = $this->db->get('ip_clients')->result();
    if (empty($icli)) {
        ?>
                        <script>
                        window.location.href = "<?php echo base_url(); ?>invoices/form/";
                        </script>

                        <?php
}
    $timbre_f_client = ($icli[0]->timbre_fiscale == 1) ? $this->mdl_settings->setting('default_item_timbre') : "0.000";
    ?>
                        <script>
                        $(function() {
                            $('#fact_prod .devise_view').each(function() {
                                $(this).text("<?php echo $icli[0]->devise_symbole; ?>");
                            });
                            $('#timbre_fiscale_span').html("<?php echo $timbre_f_client; ?>");
                        });
                        </script>
                        <?php
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
                        <?php if ($icli == '') {?>
                        <input type="hidden" id="symbole_devise" value="DT">
                        <input type="hidden" id="tax_rate_decimal_places" value="3">
                        <input type="hidden" id="currency_symbol_placement" value="after">
                        <input type="hidden" id="thousands_separator" value=" ">
                        <input type="hidden" id="decimal_point" value=".">
                        <?php } else {?>
                        <input type="hidden" id="symbole_devise" value="<?php echo $icli[0]->devise_symbole; ?>">
                        <input type="hidden" id="tax_rate_decimal_places"
                            value="<?php echo $icli[0]->number_decimal; ?>">
                        <input type="hidden" id="currency_symbol_placement"
                            value="<?php echo $icli[0]->symbole_placement; ?>">
                        <input type="hidden" id="thousands_separator"
                            value="<?php echo $icli[0]->thousands_separator; ?>">
                        <input type="hidden" id="decimal_point" value=".">
                        <?php }?>
					<div class="row card-row form-row">
                            <div class="col-lg-12 col-sm-12 col-xl-12 col-langue">
                               <div class="form-group select-search-input has-info col-input-before-langue">
							   <label for="form_control_1"><?php echo lang('client_name'); ?><span class="text-danger">*</span></label>
                                    <input  style="width: 100%;"  type="text" name="client_name" id="client_name"
                                        class="form-control form-control-lg form-control-light form-width-input client_name" readonly="readonly" value="<?php
if ($clients) {
    echo $clients->client_titre . " " . $clients->client_name . " " . $clients->client_prenom;
}

if (($icli != '') && ($icli[0])) {
    echo $tt . " " . $icli[0]->client_name . " " . $icli[0]->client_prenom;
}

?>" autocomplete="off">
                                    
                                <button id="search_client" type="button" class="btn btn-success btn-select-client">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                                    <div class="form-control-focus"></div>
                                    <input type="hidden" value="<?php
if ($clients) {
    echo $clients->client_id;
}

if (($icli != '') && ($icli[0])) {
    echo $icli[0]->client_id;
}

?>" id="client_id" name="client_id" />
                                </div>
							<?php
							 $tabs =explode(',',$this->mdl_settings->setting('default_language_document'));                          
						   ?>
                                <div class="form-group lang-groupe">
									<label class="lang-flag-label"></label>
									<!--label><!?php echo lang('language'); ?><span class="text-danger"> *</span></label-->                                  
                                    <select class="form-control form-control-lg form-control-light language-input" name="langue" id="langue">
										<option value="<?php echo $this->mdl_settings->setting('default_language'); ?>">  
											<?php echo substr($this->mdl_settings->setting('default_language'), 0, 2); ?>												
										</option>
                                        <?php foreach (array_filter($tabs) as  $key => $value) {?>
										<?php if( $value != $this->mdl_settings->setting('default_language') ){ ?>
                                        <option value="<?php echo $value; ?>">
                                            <?php echo substr($value, 0, 2); ?>
                                        </option>
                                        <?php }?>
                                        <?php }?>
                                    </select>
                                </div>
									   
                            </div>
                        </div>
                        <div class="row card-row form-row">
                        <div class="col-lg-12 col-sm-12 col-xl-12">
                                <div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('client_societe'); ?></label>
                                    <input type="text" id="client_societe" readonly="readonly" value="<?php
if ($clients) {
    echo $clients->client_societe;
}

if (($icli != '') && ($icli[0])) {
    echo $icli[0]->client_societe;
}

?>" class="form-control form-control-md form-control-light" />
                                    <div class="form-control-focus"></div>

                                </div>
                            </div>
                        </div>
                    <div class="row card-row form-row">
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('client_address'); ?></label>
                                    <input type="text" id="client_address" readonly="readonly" value="<?php
if ($clients) {
    echo $clients->client_address_1;
}

if (($icli != '') && ($icli[0])) {
    echo $icli[0]->client_address_1;
}

?>" class="form-control form-control-md form-control-light" />
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('client_pays'); ?></label>
                                    <input type="text" id="client_pays" readonly="readonly" value="<?php
if ($clients) {
    echo $clients->client_country;
}

if (($icli != '') && ($icli[0])) {
    echo $icli[0]->client_country;
}

?>" class="form-control form-control-md form-control-light" />
                                    <div class="form-control-focus"></div>
                                </div>
                            </div>
                        </div>
                    <div class="row card-row form-row">
                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('vat_id'); ?></label>
                                    <input type="text" id="vat_id" readonly="readonly" value="<?php
if ($clients) {
    echo $clients->client_vat_id;
}

if (($icli != '') && ($icli[0])) {
    echo $icli[0]->client_vat_id;
}

?>" class="form-control form-control-md form-control-light" />
                                    <div class="form-control-focus"></div>
                                </div>
                         </div>
                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('tax_code'); ?></label>
                                    <input type="text" id="tax_code" readonly="readonly" value="<?php
if ($clients) {
    echo $clients->client_tax_code;
}

if (($icli != '') && ($icli[0])) {
    echo $icli[0]->client_tax_code;
}

?>" class="form-control form-control-md form-control-light" />
                                    <div class="form-control-focus"></div>

                                </div>
                            </div>
						</div>
						<div class="row card-row form-row">
							<div class="col-lg-6 col-sm-6 col-xs-12" style="padding-right: 0;"><div class="separateur" style="margin-top: 23px;"></div>
								<div class="md-checkbox">                                    
									<input type="checkbox" value="0" name="signature" id="signature" class="md-check">
									<label for="signature">
										<span></span>
										<span class="check"></span>
										<span class="box"></span>                                     
										<?php echo lang('invoice'); ?> <?php echo lang('signature'); ?>
									</label><a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_cachet_signature'); ?>"></a>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6 col-xs-12"><div class="separateur" style="margin-top: 23px;"></div>
								<div class="md-checkbox">                                    
									<input type="checkbox" value="0" name="photo" id="photo" class="md-check">
									<label for="photo">
										<span></span>
										<span class="check"></span>
										<span class="box"></span>                                     
										<?php echo lang('photo_joint') ?>
									</label><a href="javascript:;" href="#" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_photo_joint'); ?>"></a>
                            
								</div>
							</div>
                        </div>
                        
                    <?php
                    if (count(explode('/', uri_string())) < 4) {?>
                    <div class="row" id="display_latest_payments" style="display:none;">
                        <?php } else {?>
                        <div class="row" id="display_latest_payments">
                            <?php } ?>
                            <div class=" col-md-12">
                                <div id="panel-quote-overview" class="panel panel-default overview">
                                    <div class="panel-heading">
                                        <b><i class="fa fa-bar-chart fa-margin"></i> <?php echo lang('view_payments_without_invoice'); ?></b>
                                        <span class="pull-right text-muted">
                                            <a href="#" class="invoice-add-payment" id="invoice-add-payment"
                                                data-invoice-id="0" data-invoice-balance="0" data-client-id="0"
                                                data-invoice-payment-method="">
                                                <i class="fa fa-credit-card fa-margin"></i>
                                                <?php echo lang('enter_payment'); ?>
                                            </a>
                                        </span>
                                    </div>

                                    <table class="table table-bordered table-condensed no-margin">
                                        <thead>
                                            <tr style="font-weight: bold;">
                                                <td align="center">#</td>
                                                <td align="center"><?php echo lang('date'); ?></td>
                                                <td align="center"><?php echo lang('payment_method'); ?></td>
                                                <td align="center"><?php echo lang('montant'); ?></td>

                                            </tr>
                                        </thead>
                                        <tbody id="latest_payments">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						</div>
                    </div>
                    <!--    FIN AJOUT CONTACT-->
                   

                    <!-- AJOUT FACTURE-->
                    <div class="col-md-6">
						<div class="portlet light formulaire no-padding">
							<div class="content-heading">
								<div class="portlet-title left-title">
									<div class="caption font-dark-sunglo">
										<span class="caption-subject bold med-caption dark"><?php echo lang('invoice'); ?></span>
									</div>
								</div>
							</div>
						
						<!--  facture devis -->
						<div class="row card-row form-row">
								<div class="col-lg-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-info">
                                        <label for="form_control_1"><?php echo lang('invoice'); ?>#</label>
                                        <input type="text" readonly="readonly" id="invoice_number"
                                            class="form-control form-control-md form-control-light" value="<?php echo $next_id; ?>">
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
								<div class="col-lg-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-info">
                                        <label for="form_control_1"><?php echo lang('quote_nature'); ?></label><a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php echo lang('info_nature'); ?>"></a>
									
                                        <?php if (count(explode('/', uri_string())) < 4) {?>
                                        <input type="text" id="invoice_nature" disabled="disabled" class="form-control form-control-md form-control-light" value="">
                                        <?php } else {?>
                                        <input type="text" id="invoice_nature" class="form-control form-control-md form-control-light" value="">
                                        <?php }?>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>
						<div class="row card-row form-row">
                                <div class="col-lg-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-info">
                                           <label for="form_control_1"><?php echo lang('date'); ?></label>
                                        <div class="quote-properties has-feedback">
                                            <div class="input-group">
                                                <?php if (count(explode('/', uri_string())) < 4) {?>
                                                <input name="invoice_date_created" id="invoice_date_created"
                                                    disabled="disabled" class="form-control form-control-md form-control-light datepicker"
                                                    value="<?php echo date('d/m/Y'); ?>">
                                                <?php } else {?>
                                                <input name="invoice_date_created" id="invoice_date_created"
                                                    class="form-control form-control-md form-control-light datepicker"
                                                    value="<?php echo date('d/m/Y'); ?>">
                                                <?php }?>
                                                <div class="form-control-focus"></div>
                                                <div class="form-control-focus"></div>
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar fa-fw"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-info">
                                        <div class="quote-properties has-feedback">
											<label for="form_control_1"><?php echo lang('due_date'); ?></label>
                                            <div class="input-group">
                                                <?php if (count(explode('/', uri_string())) < 4) {?>

                                                <input name="invoice_date_expires" id="invoice_date_expires"
                                                    disabled="disabled" class="form-control form-control-md form-control-light datepicker" value="<?php
$i = $this->mdl_settings->setting('invoices_due_after');
//echo (date('d/m/Y', strtotime(date('d/m/Y') . " +1 day")));

    echo date('d/m/Y', strtotime(date("Y-m-d") . " +" . $i . " day"));
    ?>">
                                                <?php } else {?>
                                                <input name="invoice_date_expires" id="invoice_date_expires"
                                                    class="form-control form-control-md form-control-light datepicker" value="<?php
$i = $this->mdl_settings->setting('invoices_due_after');
//echo (date('d/m/Y', strtotime(date('d/m/Y') . " +1 day")));

    echo date('d/m/Y', strtotime(date("Y-m-d") . " +" . $i . " day"));
    ?>">
                                                <?php }?>
                                                <div class="form-control-focus"></div>
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar fa-fw"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
						<div class="row card-row form-row">  
                                <div class="col-lg-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-info">
                                        <label for="form_control_1"><?php echo lang('type_facture'); ?></label>
                                        <select name="recursive" 
                                            id="recursive" class="form-control form-control-md form-control-light">                                          
                                            <option value="0"> 
                                            <?php echo lang('invoice_normal'); ?>                                              
                                            </option>
                                            <option value="1"> 
                                             <?php echo lang('invoice_recurrent'); ?>                                                        
                                            </option>          
                                         </select>
                                    </div>
								</div>
                                <div class="col-lg-6 col-sm-6 col-xs-12 recursivestat">
                                    <div class="form-group has-info">
                                        <label for="form_control_1"><?php echo lang('period'); ?></label>
                                        <select name="recursive_id"
                                            id="recursive_id" class="form-control form-control-md form-control-light">                                             
												<option value="0">                                                    
                                                </option>
                                                <option value="1">
                                                <?php echo lang('monthly'); ?>      
                                                </option>
                                                <option value="2">
                                                <?php echo lang('quarterly'); ?>  
                                                </option>
                                                <option value="3">
                                                <?php echo lang('annually'); ?>  
                                                </option>
                                        </select>
                                   </div>
                                </div>   
                            </div>    
						<div class="row card-row form-row"> 
                                <div class="col-lg-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-info">
                                        <div class="invoice-properties has-feedback">
                                                 <label for="form_control_1"><?php echo lang('quote_delai_paiement'); ?></label>
                                            <div class="">
                                                <?php if (count(explode('/', uri_string())) < 4) {?>
                                                <select name="invoice_delai_paiement"
                                                    disabled="disabled" id="invoice_delai_paiement"
                                                    class="form-control form-control-md form-control-light">
                                                    <?php } else {?>
                                                    <select name="invoice_delai_paiement"
                                                        id="invoice_delai_paiement" class="form-control form-control-md form-control-light">
                                                        <?php }?>
                                                        <option value="0"></option>
                                                        <?php foreach ($delaiPaiement as $delaiPaim) {?>
                                                        <option value="<?php echo $delaiPaim->delai_paiement_id; ?>">
                                                            <?php echo $delaiPaim->delai_paiement_label; ?></option>
                                                        <?php }?>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="invoice_password" class="form-control input-sm" value="">
                                <div class="col-lg-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-info">
                                            <label for="form_control_1"><?php echo lang('status'); ?></label>
                                        <?php if (count(explode('/', uri_string())) < 4) {?>

                                        <select name="invoice_status_id" disabled="disabled"
                                            id="invoice_status_id" class="form-control form-control-md form-control-light">
                                            <?php } else {?>
                                            <select name="invoice_status_id"
                                                id="invoice_status_id" class="form-control form-control-md form-control-light">
                                                <?php }?>
                                                <?php foreach ($invoice_statuses as $key => $status) {?>
                                                <option value="<?php echo $key; ?>">
                                                    <?php echo $status['label']; ?>
                                                </option>
                                                <?php }?>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <?php
if ($relvar == 0) {
    ?>
							<div class="row card-row form-row"> 
                                <div class="col-lg-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-info">
                                        <label for="form_control_1"><?php echo lang('schedule_automatic_reminders'); ?></label><a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_relances_automatique'); ?>"></a>
									
                                        <input type="text" name="date_relance" id="date_relance"
                                            class="form-control form-control-md form-control-light date" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-xs-12">                                  
                                   <div class="sup offline" style="margin-top: 32px;"></div>
                                        <div class="md-checkbox left-notis">
                                            <input type="checkbox" value="0" name="Joint" id="Joint" class="md-check">
                                            <label for="Joint">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                
                                                <?php echo lang('attach_invoice'); ?>
                                            </label><a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover"  data-content="<?php echo lang('info_envoi_mail'); ?>"></a>
								
                                        </div>
									</div>
                                </div>
							<div class="row card-row form-row"> 
                                <div class="col-lg-6 col-sm-6 col-xs-12">
									<div class="col-md-12">
                                        <div class="md-checkbox">
                                            <input type="checkbox" value="0" name="drap" id="drap" class="md-check">
                                            <label for="drap">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                <?php echo lang('attach_documents'); ?>
                                            </label><a href="javascript:;" class="btn btn-secondary btn-light-dark btn-popover" data-container="body" data-toggle="popover" data-content="<?php echo lang('info_doc_joint'); ?>"></a>
								
                                        </div>
                                    </div>                                                            
                                </div>
                            </div>
                            <div class="row card-row form-row">
                                <div class="col-md-12">
                                    <table name="documenttable" id="documenttable"
                                        class="table table-striped table-responsive-md btn-table">
                                        <thead>
                                            <tr>
                                                <th style="width:5%">#</th>
                                                <th align="center"> <?php echo lang('listing_documents'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <!--Fin Ajout Facture-->
                </div>
			</div>
		</div>
		</div>

                <!--AJOUT PRODUIT-->
                    <?php if (count(explode('/', uri_string())) < 4) {?>

                    <div id="fact_prod" style=" display:none">
                        <?php } else {?>
                        <div id="fact_prod">
                            <?php }?>
							<div class="portlet light profile no-shabow bg-light-blue">
									<div class="portlet-header">
										<div class="portlet-title align-items-start flex-column">
											<div class="caption font-dark-sunglo">
												<span class="caption-subject bold med-caption dark"><?php echo lang('products_bloc'); ?></span>
											</div>			
										</div>
										<div class="portlet-toolbar">
											<div class="pull-right btn-group">
													<?php if (count(explode('/', uri_string())) < 4) {?>

											<div class="btn_add_prod" style=" text-align: right">

												<a class="btn btn-sm btn-default" disabled="disabled" id="btn_add_row">
													<i class="fa fa-plus"></i>
													<?php echo lang('add_new_row'); ?>
												</a>

												<a class="btn btn-sm btn-default" disabled="disabled" id="btn_add_product">
													<i class="fa fa-database"></i>
													<?php echo lang('add_product'); ?>
												</a>
											</div>
											<?php } else {?>
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
											<?php }?>
											</div>
										</div>
									</div>				
						<div class="portlet-body">
                                    <?php
$this->layout->load_view('invoices/partial_item_table');
?>
                                    <div style="clear:both"></div>
                                    <br>
                                    <div class="form-group has-info">
                                        <label for="form_control_1"><?php echo lang('notes'); ?></label>
                                       
                            <textarea height="40" name="notes" id="notes"
                                style="width: 100%;padding: 5px 10px;height:80px;" class="form-control"></textarea>
                                        <div class="form-control-focus"></div>
                                    </div>
                           </div>
						<div class="portlet-footer">
							<div class="portlet-tool-btn">
									<div class="pull-right btn-group">
										<a href="#" class="btn btn-success btn-sm blue bg-success text-success" id="btn_save_invoice2">
											<?php echo lang('save'); ?>
										</a>
									</div>
							</div>
						</div>
                        </div>
                    </div>
                    <!-- FIN AJOUT PRODUIT-->
        </form>
</div>
		</div>
    <script>
    $('#Joint').change(function() {
        if ($(this).prop("checked")) {
            $('#Joint').val('1');

        } else {
            $('#Joint').val('0');
        }

    });
    $(document).ready(function() {
        $("#documenttable").hide();
        $('.date').datepicker({
            multidate: true,
            format: 'dd/mm/yyyy'
        });
     $(".recursivestat").hide();
        
    })
    $('#drap').change(function() {
        if ($(this).prop("checked")) {
            $("#documenttable").show();
            $('#drap').val('1');

        } else {
            $("#documenttable").hide();
            $('#drap').val('0');
        }

    });
     $('#recursive').change(function() {   
         
        if ($('#recursive').val()==1) {
          $(".recursivestat").show();
           // $('#recursive').val('1');

        } else {
            $(".recursivestat").hide();
          //  $('#recursive').val('0');
        }

    }); 
    $('#signature').change(function() {
        if ($(this).prop("checked")) {
            $('#signature').val('1');

        } else {
            $('#signature').val('0');
        }

    });
    $('#photo').change(function() {
        if ($(this).prop("checked")) {
            $('#photo').val('1');

        } else {
            $('#photo').val('0');
        }

    });
    </script>

</body>