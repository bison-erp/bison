/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function accepted_float_input(val) {
    val = val.replace(",", ".");
    val = val.replace(/[^0-9\.]+/g, "");
    if ((val.split(".").length - 1) > 1) {
        val = val.substring(0, val.length - 1);
        if ((val.split(".").length - 1) > 1) {
            val = accepted_float_input(val);
        }
    }
    return val;
}
function accepted_integer_input(val) {

    val = val.replace(/[^0-9]+/g, "");
    return val;
}

function numberFormatDefault(number, decimals, dec_point, thousands_sep) {

    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec)
            {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3)
    {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec)
    {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
function  numberFormatFloat(amount, nb_decimal) {
    if (!nb_decimal) {
        var nb_decimal = $('#tax_rate_decimal_places').val();
    }
    var currency_symbol_placement = $('#currency_symbol_placement').val();
    var thousands_separator = $('#thousands_separator').val();
    var decimal_point = $('#decimal_point').val();
//alert(decimal_point);
    return numberFormatDefault(amount, nb_decimal, decimal_point, thousands_separator);

}

function beautifyFormat(amount, type) {
    
    if (amount == "") {
        amount = 0;
    }

    if (type == "float") {
        return numberFormatFloat(amount);
    }else if (type == "float2") {
        return numberFormatFloat(amount, "2");
    }else if (type == "float5") {     
        return  numberFormatFloat(amount, "5");
    }else {
        return amount;
    }
}

function format_devise(amount) {

//     return numberFormatDefault(amount, decimals, dec_point, thousands_sep);
}

function dateSlashes(date) {
    var res = date.split("-");
    return res[2] + "/" + res[1] + "/" + res[0];
}

function strReplaceAll(string, Find, Replace) {
    try {
        return string.replace(new RegExp(Find, "gi"), Replace);
    } catch (ex) {
        return string;
    }
}

function beautifyFormatWithDevice(amount) {

    var nb_decimal = $('#tax_rate_decimal_places').val();
    var symbole_devise = $('#symbole_devise').val();

    var currency_symbol_placement = $('#currency_symbol_placement').val();
    var thousands_separator = $('#thousands_separator').val();
    var decimal_point = $('#decimal_point').val();
    if (currency_symbol_placement == "before") {
        return symbole_devise+" "+numberFormatDefault(amount, nb_decimal, decimal_point, thousands_separator);

    } else {
        return numberFormatDefault(amount, nb_decimal, decimal_point, thousands_separator)+" "+symbole_devise;
    }

}
