<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 * 
 * A free and open source web based invoicing system
 *
 * @package		InvoicePlane
 * @author		Kovah (www.kovah.de)
 * @copyright	Copyright (c) 2012 - 2015 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 * 
 */

function format_currency($amount) {
    global $CI;
    $currency_symbol = $CI->mdl_settings->setting('currency_symbol');
    $nb_decimal = $CI->mdl_settings->setting('tax_rate_decimal_places');
    $currency_symbol_placement = $CI->mdl_settings->setting('currency_symbol_placement');
    $thousands_separator = $CI->mdl_settings->setting('thousands_separator');
    $decimal_point = $CI->mdl_settings->setting('decimal_point');

    if ($currency_symbol_placement == 'before') {
        return $currency_symbol . number_format($amount, ($decimal_point) ? $nb_decimal : 0, $decimal_point, $thousands_separator);
    } else {
        return number_format($amount, ($decimal_point) ? $nb_decimal : 0, $decimal_point, $thousands_separator) . $currency_symbol;
    }
}

function format_devise($amount, $devise_id, $display_symbol = 1) {
    $CI = get_instance();
    $amount = (float) $amount;
    $CI->db->where("devise_id", $devise_id);
    $devise = $CI->db->get('ip_devises')->result();
    if (!empty($devise)) {
        $devise_symbole = $devise[0]->devise_symbole;
        $symbole_placement = $devise[0]->symbole_placement;
        $number_decimal = (int) $devise[0]->number_decimal;
        $thousands_separator = $devise[0]->thousands_separator;

        $export = number_format($amount, $number_decimal, '.', $thousands_separator);
        if ($display_symbol == 1) {
            if ($symbole_placement == "before") {
                return $devise_symbole . ' ' . $export;
            } else {
                return $export . ' ' . $devise_symbole;
            }
        } else {
            return $export;
        }
    } else {
        return $amount;
    }
}

//echo format_devise("123456789", 1);

function format_currency_without_symbol($amount) {
    global $CI;
    $currency_symbol = $CI->mdl_settings->setting('currency_symbol');
    $nb_decimal = $CI->mdl_settings->setting('tax_rate_decimal_places');
    $currency_symbol_placement = $CI->mdl_settings->setting('currency_symbol_placement');
    $thousands_separator = $CI->mdl_settings->setting('thousands_separator');
    $decimal_point = $CI->mdl_settings->setting('decimal_point');

    if ($currency_symbol_placement == 'before') {
        return number_format($amount, ($decimal_point) ? $nb_decimal : 0, $decimal_point, $thousands_separator);
    } else {
        return number_format($amount, ($decimal_point) ? $nb_decimal : 0, $decimal_point, $thousands_separator);
    }
}

function format_currency_with_symbol($amount, $currency_symbol) {
    global $CI;

    $nb_decimal = $CI->mdl_settings->setting('tax_rate_decimal_places');
    $currency_symbol_placement = $CI->mdl_settings->setting('currency_symbol_placement');
    $thousands_separator = $CI->mdl_settings->setting('thousands_separator');
    $decimal_point = $CI->mdl_settings->setting('decimal_point');

    if ($currency_symbol_placement == 'before') {
        return $currency_symbol . " " . number_format($amount, ($decimal_point) ? $nb_decimal : 0, $decimal_point, $thousands_separator);
    } else {
        return number_format($amount, ($decimal_point) ? $nb_decimal : 0, $decimal_point, $thousands_separator) . " " . $currency_symbol;
    }
}

function format_amount($amount = NULL, $nb_decimal = NULL) {
    if ($amount) {
        global $CI;
        $thousands_separator = $CI->mdl_settings->setting('thousands_separator');
        if ($nb_decimal == NULL)
            $nb_decimal = $CI->mdl_settings->setting('tax_rate_decimal_places');
        $decimal_point = $CI->mdl_settings->setting('decimal_point');

        return number_format($amount, ($decimal_point) ? $nb_decimal : 0, $decimal_point, $thousands_separator);
    }
    return NULL;
}

function standardize_amount($amount) {
    global $CI;
    $thousands_separator = $CI->mdl_settings->setting('thousands_separator');
    $decimal_point = $CI->mdl_settings->setting('decimal_point');

    $amount = str_replace($thousands_separator, '', $amount);
    $amount = str_replace($decimal_point, '.', $amount);

    return $amount;
}

function beautifyFormat($amount, $type) {

    if ($amount && $amount == "") {
        $amount = 0;
    }

    if ($type == "float") {
        return format_amount($amount);
    } else if ($type == "float2") {
        return format_amount($amount, "2");
    } else {
        return $amount;
    }
}

function convertOctet($bytes) {

        $unit = intval(log($bytes, 1024));
        $units = array('Octets', 'Ko', 'Mo', 'Go');

        if (array_key_exists($unit, $units) === true) {
            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
        }


}
