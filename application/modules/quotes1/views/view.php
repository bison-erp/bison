<input type="hidden" value="<?php echo $quote->quote_pourcent_remise; ?>" id="quote_pourcent_remise">
<input type="hidden" value="<?php echo $quote->quote_montant_remise; ?>" id="quote_montant_remise">
<input type="hidden" value="<?php echo $quote->quote_pourcent_acompte; ?>" id="quote_pourcent_acompte">
<input type="hidden" value="<?php echo $quote->quote_montant_acompte; ?>" id="quote_montant_acompte">
<input type="hidden" value="<?php echo $quote->timbre_fiscale; ?>" id="timbre_fiscale">
<input type="hidden" value="<?php echo $quote->quote_item_subtotal; ?>" id="quote_item_subtotal">
<input type="hidden" value="<?php echo $quote->quote_item_tax_total; ?>" id="quote_item_tax_total">
<input type="hidden" value="<?php echo $quote->quote_total; ?>" id="quote_total">
<input type="hidden" value="<?php echo $quote->quote_total_a_payer; ?>" id="quote_total_a_payer">
<input type="hidden" value="<?php echo $quote->langue; ?>" id="langue">


<style>
//.form-group.form-md-line-input .form-control{    margin-top: -17px;    padding-left: 1px;}
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
   // console.log($("#pourcent_remise_invoice").val());
    var montant_remise = accepted_float_input($("#montant_remise_invoice").val());
    var persent_remise = accepted_float_input($("#pourcent_remise_invoice").val());
    var timbre_fiscale = accepted_float_input($("#timbre_fiscale_span").text());
    subtotal = subtotal * (1 - (Number(persent_remise) / 100));
    //console.log(accepted_float_input($("#montant_sous_tot_invoice").text()))
  //  subtotal = accepted_float_input($("#montant_sous_tot_invoice").text()) - montant_remise;
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
    } else {
        var item_code_value = items.product_sku;
      //  var item_description_value = items.product_description;
        var item_description_value ="";
        
        if(items.langue=="Arabic"){
              item_description_value += items.product_description_ar;
        }
        if(items.langue=="English"){
              item_description_value += items.product_description_eng;
        }
        if(!items.langue || items.langue=="French" ){
              item_description_value += items.product_description;
        }
        var item_quantity_value = items.product_quantite ? (items.product_quantite) : 1;
        var item_price_value = beautifyFormat(items.product_price_dev, "float");
        var subtotal_value = items.product_subtotal ? beautifyFormat(items.product_subtotal, "float") : beautifyFormat(
            items.product_price_dev, "float");
        var item_tax_rate_id_value = items.tax_rate_id_dev;
        var item_total_value = beautifyFormat(items.montantTVATotal, "float");
    }
        var depot_id = items.depot_quote;
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
            current_id + '" id="item_total_' + current_id + '" value="' + subtotal_value + '"></td>';
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
    }else if (type == "float2") {
       if (accepted_float_input(valeur) != valeur) {
            $("#" + id).val(accepted_float_input(valeur));
            valeur = numberFormatFloat(valeur, "2");
        } 
       // valeur =   
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
        //total += Number(accepted_float_input($(this).find(".item_total").val()));
      //  total += Number(accepted_float_input($(this).find(".item_price").val()));
      total += Number(accepted_float_input($(this).find(".subtotal").val()));
      
    });
    var persent_remise = accepted_float_input($("#pourcent_remise_invoice").val());
    if (Number(persent_remise) > 100)
        persent_remise = 100;
    $("#pourcent_remise_invoice").val(persent_remise);
    var montant_remise = total * Number(persent_remise) / 100;
    $("#montant_remise_invoice").val(beautifyFormat(montant_remise, "float2")); 
}

function changedMontantRemise() {
    var total = 0;
    $('#item_table tr.item').each(function() {
     //   total += Number(accepted_float_input($(this).find(".item_total").val()));
      //  total += Number(accepted_float_input($(this).find(".item_price").val()));
        total += Number(accepted_float_input($(this).find(".subtotal").val()));
    });
   // console.log(total); 
    var montant_remise = accepted_float_input($("#montant_remise_invoice").val());
    if (Number(montant_remise) > total) {
        montant_remise = total;
    }
    $("#montant_remise_invoice").val(beautifyFormat(montant_remise));   
    var persent_remise = (Number(montant_remise) * 100) / total;
    $("#pourcent_remise_invoice").val(beautifyFormat(persent_remise, "float5"));
   // $("#pourcent_remise_invoice").val(beautifyFormat(persent_remise, "float"));
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
    $('#btn_save_quote, #btn_save_quote1').click(function() {
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
        if (items_count > 0) {
            $.post("<?php echo site_url('quotes/ajax/save'); ?>", {
                    quote_id: $('#quoteidd').val(),
                    client_id: $('#client_id').val(),
                    timbre_fiscale_span: timbre_fiscale_span,
                    client_name: $('#client_name').val(),
                    client_type: $('#client_type').val(),
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
                    user_id: '<?php echo $this->session->userdata('
                    user_id '); ?>',
                    pourcent_remise_quote: $('#pourcent_remise_invoice').val(),
                    montant_remise_quote: montant_remise_quote,
                    pourcent_acompte_quote: $('#pourcent_acompte_invoice').val(),
                    montant_acompte_quote: montant_acompte_quote,
                    total_quote_final: total_quote_final,
                    total_quote: total_quote,
                    total_a_payer_quote: total_a_payer_quote,
                    quote_item_subtotal_final: quote_item_subtotal_final,
                    quote_item_tax_total_final: quote_item_tax_total_final,
                    date_relance: $('#date_relance').val(),
                    document: $('#drap').val(),
                    listdocu: $('#listdocument').val(),
                    joindredevis: $('#joint').val(),
                    signature: $('#signature').val(),
                    langue: $('#langue').val(),
                },

                function(data) {
                    var response = JSON.parse(data);
                    if (response.success == '1') {
                        // window.location = "<?php echo site_url('quotes/view'); ?>/" + <?php echo $quote_id; ?>;
                        window.location = "<?php echo site_url('quotes/index'); ?>";
                    } else {
                        $("#div_err").empty();
                        var msg_err = response.validation_errors;
                        var ms_err = msg_err.split("<\/p>\n");
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
        $('#modal-placeholder').load("<?php echo site_url('products/ajax/modal_product_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {
                devise: $('#devise').val(),
                type_doc: "invoice"
            });
    });
    $("#btn_add_row").click(function() {
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
    $('#btn_generate_pdf').click(function() {
        link = "/quotes/generate_pdf/" + $('#quoteidd').val();

        window.open(link, '_blank');
    });
    $('#quote_delai_paiement').change(function() {
        var optionSelected = $("option:selected", this);
        var valueSelected = optionSelected.html();
        $('#notes').val(valueSelected.trim());
    });
    $('#delete_quote').click(function() {
        $('#modal-placeholder').load("<?php echo site_url('quotes/modal_delete_quote'); ?>");
    });

    // Recupération des ligne devis
    $.post("<?php echo site_url('quotes/ajax/getItemsByQuote'); ?>", {
        quote_id: $('#quoteidd').val()

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
    // FIN Recupération des ligne devis
    $("#pourcent_remise_invoice").val(beautifyFormat($('#quote_pourcent_remise').val(), "float5"));
    $("#montant_remise_invoice").val(beautifyFormat($('#quote_montant_remise').val(), "float"));
    $("#pourcent_acompte_invoice").val(beautifyFormat($('#quote_pourcent_acompte').val(), "float2"));
    $("#montant_acompte_invoice").val(beautifyFormat($('#quote_montant_acompte').val(), "float"));
    $("#timbre_fiscale_span").text(beautifyFormat($('#timbre_fiscale').val(), "float"));

    $("#montant_sous_tot_invoice").text(beautifyFormat($('#quote_item_subtotal').val(),
        "float"));
    $("#tot_tva_invoice").text(beautifyFormat($('#quote_item_tax_total').val(), "float"));
    $("#total_invoice").text(beautifyFormat($('#quote_total').val(), "float"));
    $("#total_a_payer_invoice").text(
        beautifyFormat($('#quote_total_a_payer').val(),
            "float"));

    $('#search_client').click(function() {
        $('#modal-placeholder').load(
            "<?php echo site_url('clients/ajax/modal_client_lookup'); ?>/" +
            Math.floor(Math.random() * 1000), {
                type_doc: "quote",
                "action": "edit"
            });
    });

});
</script>
<input type="hidden" id="etat_montant_acccont" value="0">

<input type="hidden" id="current_id_table_invoice" value="0">
<input type="hidden" id="devise" value="<?php echo $quote->devise_id; ?>">
<input type="hidden" id="symbole_devise" value="<?php echo $quote->devise_symbole; ?>">

<input type="hidden" id="tax_rate_decimal_places" value="<?php echo $quote->number_decimal; ?>">
<input type="hidden" id="currency_symbol_placement" value="<?php echo $quote->symbole_placement; ?>">
<input type="hidden" id="thousands_separator" value="<?php echo $quote->thousands_separator; ?>">
<input type="hidden" id="decimal_point" value="." />
<?php
if (($quote->quote_status_id == 4) || ($quote->quote_status_id == 5) || ($quote->quote_status_id == 6)) {
    $ett = 'disabled';
} else {
    $ett = '';
}
?>
<div id="headerbar-index">
 <?php $this->layout->load_view('layout/alerts');?>
</div>
<div id="div_err"></div>
<div id="content">
	<div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column">
				<div class="caption font-dark-sunglo">
				<input type="hidden" id="quoteidd" value="<?php echo $quote_id; ?>">
					<span class="caption-subject bold med-caption dark"><?php echo lang('quote'); ?> #<?php echo $quote->quote_number; ?></span>
				</div>
			</div>
			<div class="portlet-toolbar">
				<div class="pull-right btn-group">
                    <div class="options btn-group pull-left">
                        <a class="btn btn-sm default dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo lang('options'); ?> <i class="fa fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu" style="margin-left: -150px;">
                            <li style=" display: none">
                                <a href="#add-quote-tax" data-toggle="modal">
                                    <i class="fa fa-plus fa-margin"></i>
                                    <?php echo lang('add_quote_tax'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="btn_generate_pdf" data-quote-id="<?php echo $quote_id; ?>">
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
                            <?php if ($quote->invoice_id == 0) {?><li>
                                <a href="#" id="btn_quote_to_invoice" data-quote-id="<?php echo $quote_id; ?>">
                                    <i class="fa fa-refresh fa-margin"></i>
                                    <?php echo lang('quote_to_invoice'); ?>
                                </a>
                            </li><?php }?>
                            <li style=" display: none">
                                <a href="#" id="btn_copy_quote" data-quote-id="<?php echo $quote_id; ?>">
                                    <i class="fa fa-copy fa-margin"></i>
                                    <?php echo lang('copy_quote'); ?>
                                </a>
                            </li>
                            <?php
if ($this->session->userdata["groupes_user_id"] == 1) {
    if (($quote->quote_status_id != 4) && ($quote->quote_status_id != 5) && ($quote->quote_status_id != 6)) {
        ?>
                            <li id="delete_quote">
                                <a href="#delete-quote" id="delete_quote" data-quote-id="<?php echo $quote_id; ?>"
                                    data-toggle="modal">
                                    <i class="fa fa-trash-o fa-margin"></i> <?php echo lang('delete'); ?>
                                </a>
                            </li><?php
}
}
?>
                        </ul>
                    </div>
                    <a href="#" class="btn btn-sm btn-success" id="btn_save_quote">
                        <!--i class="fa fa-check"></i-->
                        <?php echo lang('save'); ?>
                    </a>
				</div>
			</div>
		</div>
	<div class="portlet-body">
    <form id="quote_form">
        <div class="row">
            <div class="col-md-4">
					<!-- contact - Info -->   
					<div class="portlet light formulaire no-padding">
						<div class="content-heading">
							<div class="portlet-title left-title">
								<div class="caption font-dark-sunglo">
									<span class="caption-subject bold med-caption dark"><?php echo lang('client'); ?></span>
								</div>
							</div>
						</div>
						<div class="row card-row form-row bg-light-blue-card">
						<div class="col-md-10">

                        <?php
                       
                        if((int)$quote->client_type == 0){
if ($quote->client_titre == 0) {
    $client_titre = 'M.';
} elseif ($quote->client_titre == 1) {
    $client_titre = 'Mme.';
} elseif ($quote->client_titre == 2) {
    $client_titre = 'Melle.';
}
                        }
?>

                        <input type="hidden" name="client" id="client_id" value="<?php echo $quote->client_id; ?>">
                        <input type="hidden" name="client_name" id="client_name"
                            value="<?php echo $quote->client_name; ?>">
                            <input type="hidden" name="client_type" id="client_type"
                            value="<?php echo $quote->client_type; ?>">
                        <input type="hidden" name="devise" id="devise" value="<?php echo $quote->devise_id; ?>">
                        <span id="client_infos_edit" style="line-height: 20px;">
							<h4 class="clt_name">
                            <a
                                href="<?php echo site_url('clients/view/' . $quote->client_id); ?>"><?php echo $client_titre . ' ' . $quote->client_name . ' ' . $quote->client_prenom; ?></a>
                            </h4>
							<br>
                            <span><b style="font-size: 12px;font-weight: 600;"><?php echo lang('ste'); ?>: &nbsp;</b><?php echo $quote->client_societe ?></span> <br>
                            <span>
                                <span><b style="font-size: 12px;font-weight: 600;"><?php echo lang('address'); ?>: &nbsp;</b>
                                </span><?php echo ($quote->client_address_1) ? $quote->client_address_1 : ''; ?>
                                <?php echo ($quote->client_city) ? $quote->client_city : ''; ?>
                                <?php echo ($quote->client_zip) ? $quote->client_zip : ''; ?>
                                <?php echo ($quote->client_country) ? ',' . $quote->client_country : ''; ?>
                            </span>
                            <br>
                            <span><b style="font-size: 12px;font-weight: 600;"><?php echo lang('n_telephone'); ?>: &nbsp;</b>
                                <?php echo $quote->client_phone ?>

                                <?php
if (strlen($quote->client_mobile) > 0) {?>
                                - <?php echo $quote->client_mobile ?>
                                <?php }?></span>
                            <br>
                            <span><b style="font-size: 12px;font-weight: 600;"><?php echo lang('vat_id'); ?>: &nbsp;</b></span><?php echo $quote->client_vat_id; ?>
                            <br>
                            <span><b style="font-size: 12px;font-weight: 600;"><?php echo lang('tax_code'); ?>: &nbsp;</b></span><?php echo $quote->client_tax_code; ?>
                        </span>
                    </div>
                    <div class="col-md-2">
                        <button id="search_client" type="button" class="btn btn-success">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            </div>
            <div class="col-md-8">
				<div class="portlet light formulaire no-padding">
					<div class="content-heading">
						<div class="portlet-title left-title">
							<div class="caption font-dark-sunglo">
								<span class="caption-subject bold med-caption dark"><?php echo lang('quote'); ?></span>
							</div>
						</div>
					</div>
                    <div class="row card-row form-row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('quote'); ?></label>
                                <input readonly="readonly" id="quote_number" class="form-control form-control-lg form-control-light"
                                    value="<?php echo $quote->quote_number; ?>">
                                <div class="form-control-focus"></div>
                            </div>
							<div class="separateur" style="margin-bottom: 25px;"></div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('quote_nature'); ?></label>
                                <input id="quote_nature" class="form-control form-control-lg form-control-light"
                                    <?php echo $ett; ?> value="<?php echo $quote->quote_nature; ?>">
                                <div class="form-control-focus"> </div>
                            </div>
							<div class="separateur" style="margin-bottom: 25px;"></div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('status'); ?></label>
                                <select name="quote_status_id" id="quote_status_id" 
                                    class="form-control form-control-lg form-control-light">
                                    <?php foreach ($quote_statuses as $key => $status) {?>
                                    <option value="<?php echo $key; ?>"
                                        <?php if ($key == $quote->quote_status_id) {?>selected="selected" <?php }?>>
                                        <?php echo $status['label']; ?></option>
                                    <?php }?>
                                </select>
                            </div>
							<div class="separateur" style="margin-bottom: 25px;"></div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group has-info">
                                <div class="quote-properties has-feedback">
                                        <label for="form_control_1"><?php echo lang('date'); ?></label>
                                    <div class="input-group">
                                        <input name="quote_date_created" style="z-index: 1 !important;"
                                            <?php echo $ett; ?> id="quote_date_created"
                                            class="form-control form-control-lg form-control-light datepicker"
                                            value="<?php echo date_from_mysql($quote->quote_date_created); ?>" disabled>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
							<div class="separateur" style="margin-bottom: 25px;"></div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group has-info">
                                    <label for="form_control_1"><?php echo lang('expires'); ?></label>
                                <div class="input-group">
                                    <input name="quote_date_expires" <?php echo $ett; ?> style="z-index: 1 !important;"
                                        id="quote_date_expires" class="form-control form-control-lg form-control-light datepicker"
                                        value="<?php echo date_from_mysql($quote->quote_date_expires); ?>">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar fa-fw"></i>
                                    </span>
                                </div>
                            </div>
							<div class="separateur" style="margin-bottom: 25px;"></div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <?php
$dateAccepte = $quote->quote_date_accepte;
if ($dateAccepte == '') {
    $dateAccepte = date_from_mysql('0000-00-00');
} else {
    $dateAccepte = date_from_mysql($quote->quote_date_accepte);
}

$dateselectrappel = $this->mdl_rappel->getRappel($quote->quote_id, 0);
$valdaterappek = "";
if ($dateselectrappel) {
    for ($i = 0; $i < count($dateselectrappel); $i++) {
        if ((count($dateselectrappel) - 1) == $i) {
            $valdaterappek = $valdaterappek . $dateselectrappel[$i]->daterappel;
        } else {
            $valdaterappek = $valdaterappek . $dateselectrappel[$i]->daterappel . ',';
        }
    }
}

$relvar = 0;

if (relanceautomatique() == false) {
    $relvar = $relvar + 1;

} else {
    $relvar = 0;
}
?>
                            <div class="form-group has-info">
                                <div class="quote-properties has-feedback">
                                        <label for="form_control_1"><?php echo lang('quote_date_accepte'); ?></label>
                                    <div class="input-group">
                                        <input name="quote_date_accepte" <?php echo $ett; ?>
                                            style="z-index: 1 !important;" id="quote_date_accepte"
                                            class="form-control form-control-lg form-control-light datepicker"
                                            value="<?php echo $dateAccepte; ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
							<div class="separateur" style="margin-bottom: 25px;"></div>
                        </div>

                    </div>
                    <input type="hidden" id="quote_password" <?php echo $ett; ?> class="form-control form-control-lg form-control-light"
                        value="<?php echo $quote->quote_password; ?>">

                    <?php

if ($relvar == 0) {

    ?>

                    <div class="row card-row form-row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-info">
                                <div class="quote-properties has-feedback">
                                    <div class="">
                                        <label for="form_control_1"><?php echo lang('quote_delai_paiement'); ?></label>
                                        <select name="quote_delai_paiement" <?php echo $ett; ?>
                                            id="quote_delai_paiement"
                                            class="form-control form-control-lg form-control-light">
                                            <option value="0"></option>
                                            <?php foreach ($delaiPaiement as $delaiPaim) {?>
                                            <option value="<?php echo $delaiPaim->delai_paiement_id; ?>"
                                                <?php if ($delaiPaim->delai_paiement_id == $quote->quote_delai_paiement) {?>selected="selected"
                                                <?php }?>><?php echo $delaiPaim->delai_paiement_label; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-info">
                                <label for="form_control_1"> <?php echo lang('planrel') ?></label>
                                <input type="text" name="date_relance" id="date_relance" class="form-control form-control-lg form-control-light date"
                                    value='<?php echo $valdaterappek ?>' placeholder="">
                            </div>
                        </div>
                    </div>                   
                   <div class="row card-row form-row">
                        <div class="md-checkbox col-sm-3 text-left">
                            <?php if ($quote->document == 1) {?>
                            <input type="checkbox" value="1" name="drap" id="drap" checked="checked" class=" md-check">
                            <?php } else {?>
                            <input type="checkbox" value="0" name="drap" id="drap" class=" md-check">
                            <?php }?>
                            <label for="drap">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>                                 
                                <?php echo lang('jointdocument') ?>
                            </label>
                        </div>
                        <div class="md-checkbox col-sm-4 text-left">
                            <?php if ($quote->joindredevis == 1) {?>
                            <input type="checkbox" value="1" name="joint" id="joint" checked="checked" class="md-check">
                            <?php } else {?>
                            <input type="checkbox" value="0" name="joint" id="joint" class="md-check">
                            <?php }?>
                            <label for="joint">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                <?php echo lang('jointdevis') ?>
                            </label>
                        </div>
                            <div class="md-checkbox col-sm-5 text-left">
                            <?php if($quote->signature==1){ ?>
                                <input type="checkbox" checked value="1" name="signature" id="signature" class="md-check">
                            <?php }else{ ?>
                                <input type="checkbox" value="0" name="signature" id="signature" class="md-check">
                                <?php }?>
                                <label for="signature">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>                                     
                                     <?php echo lang('quote'); ?> <?php echo lang('signature') ?>
                                </label>
                            </div>

                    </div>
                    <script>
                    $(document).ready(function() {
                        $('.date').datepicker({
                            multidate: true,
                            format: 'dd/mm/yyyy'
                        });
                    })
                    </script>

                    <div class="row">
                        <div class="col-sm-6 table-wrapper">
                            <table name="documenttable" id="documenttable"
                                class="table table-striped table-responsive-md btn-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">#</th>
                                        <th align="center"><?php echo lang('listing_documents'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
$val = "";
    foreach ($atbtrouve as $doc) {
        if (count($atbtrouve) > 0) {
            $val .= $doc->id_document . ",";
        }

        ?>
                                    <tr class="tr_docselect_<?php echo $doc->id_document ?>">
                                        <td onchange="mydoc(<?php echo $doc->id_document ?>)" style="width: 25px;"
                                            align="left">
                                            <input type="checkbox" id="doccheck<?php echo $doc->id_document ?>" checked
                                                value="<?php echo $doc->id_document ?>">
                                        </td>
                                        <td class="attrValue" style="width: 25px;" align="left">
                                            <span><?php echo $doc->file_name ?></span></td>
                                        <?php }?>
                                    </tr>
                                    <?php
foreach ($atbnontrouve as $doc) {?>
                                    <tr class="tr_docselect_<?php echo $doc->id_document ?>">
                                        <td onchange="mydoc(<?php echo $doc->id_document ?>)" style="width: 25px;"
                                            align="left">
                                            <input type="checkbox" id="doccheck<?php echo $doc->id_document ?>"
                                                value="<?php echo $doc->id_document ?>">
                                        </td>
                                        <td class="attrValue" style="width: 25px;" align="left">
                                            <span><?php echo $doc->file_name ?></span></td>
                                        <?php }?>
                                    </tr>
                                </tbody>
                                <input type="hidden" id="listdocument" value="<?php echo $val ?>">
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"><?php echo lang('calendar_of_reminders') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
if ($dateselectrappel) {
        for ($i = 0; $i < count($dateselectrappel); $i++) {?>
                                    <tr>
                                        <td><?php echo $i + 1 ?></td>
                                        <td><?php echo $dateselectrappel[$i]->daterappel ?>
                                        </td>
                                        </td>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="row" style=" width: 100%">
                        <div class="col-sm-6">
                            <div class="form-group has-info">
                                <label for="form_control_1"><?php echo lang('status'); ?></label>
                                <select name="quote_status_id" id="quote_status_id" style="padding: 0px 0px;"
                                    class="form-control form-control-lg form-control-light">
                                    <?php foreach ($quote_statuses as $key => $status) {?>
                                    <option value="<?php echo $key; ?>"
                                        <?php if ($key == $quote->quote_status_id) {?>selected="selected" <?php }?>>
                                        <?php echo $status['label']; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>

            </div>
        </div>
</div>
</div>
 <div class="portlet light profile no-shabow bg-light-blue">
		<div class="portlet-header">
			<div class="portlet-title align-items-start flex-column">
				<div class="caption font-dark-sunglo">
					<span class="caption-subject bold med-caption dark"><?php echo lang('products_bloc'); ?></span>
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
        <!--    BLOC PRODUITS-->
			<div class="row card-row form-row">
				<div class="col-md-12">
						<div class="portlet light formulaire">
							<?php $this->layout->load_view('quotes/partial_item_table');?>
							<div style="clear:both"></div>
							<br>
							<div class="form-group has-info">
								<label for="form_control_1"><?php echo lang('notes'); ?></label>
									<textarea height="40" name="notes" id="notes" style="width: 100%;padding: 5px 10px;height:80px;" class="form-control"><?php echo $quote->notes; ?></textarea>
								<div class="form-control-focus"></div>
							</div>
							<div style="clear:both"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<input type='hidden' value='0' id='count'>

<input type="hidden" id="assigite_tva" value="<?php echo $this->mdl_settings->gettypetaxeinvoice() ?>">
<script>
$('#drap').change(function() {
    if ($(this).prop("checked")) {
        $("#documenttable").show();
        $('#drap').val('1');

    } else {
        $("#documenttable").hide();
        $('#drap').val('0');
    }

});

var tab = [];


function mydoc(x) {
    var ch = "" + $('#listdocument').val();
    if ($('#doccheck' + x).prop("checked")) {
        if (ch.length > 0) {
            ch = ch + ',' + x;
        } else {
            ch = x;
        }

        $('#listdocument').val(ch);
    } else {
        var res = ch.split(",");
        for (var i = 0; i < res.length; i++) {
            if (res[i] == x) {
                res.splice(i, 1);
            }
        }

        $('#listdocument').val(res);

    }
}

$('#joint').change(function() {
    if ($(this).prop("checked")) {
        $('#joint').val('1');

    } else {
        $('#joint').val('0');
    }

});
$('#signature').change(function() {
        if ($(this).prop("checked")) {
            $('#signature').val('1');
        } else {
            $('#signature').val('0');
        }
});
</script>