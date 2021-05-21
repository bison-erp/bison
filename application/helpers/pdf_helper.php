<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * InvoicePlane
 *
 * A free and open source web based invoicing system
 *
 * @package        InvoicePlane
 * @author        Kovah (www.kovah.de)
 * @copyright    Copyright (c) 2012 - 2015 InvoicePlane.com
 * @license        https://invoiceplane.com/license.txt
 * @link        https://invoiceplane.com
 *
 */

function generate_invoice_pdf($invoice_id, $stream = true, $invoice_template = null)
{
    $CI = &get_instance();

    $CI->load->model('invoices/mdl_invoices');
    $CI->load->model('invoices/mdl_items');
    $CI->load->model('invoices/mdl_invoice_tax_rates');
    $CI->load->model('delai_paiement/mdl_delai');
    $CI->load->model('families/mdl_families');
    $CI->load->model('devises/mdl_devises');
    $CI->load->model('societes/mdl_societes');
    $CI->load->helper('country');
    $invoice = $CI->mdl_invoices->get_by_id($invoice_id);
    $respdf = $CI->mdl_invoices->getTypepdf();
    $invoice_template = "default";

    $item_familles = $CI->mdl_families->get()->result();
    $societe = $CI->mdl_societes->get_by_id(1);
    $arrayItems = array();
    // foreach ($item_familles as $famille) {
    // array_push($arrayItems, $CI->mdl_items->select('*')
    // ->join('ip_families', 'ip_families.family_id = ip_invoice_items.family_id')
    // ->where('invoice_id', $invoice_id)
    // ->where('ip_invoice_items.family_id', $famille->family_id)
    // ->get()->result());
    // }

    array_push($arrayItems, $CI->db
            ->where('invoice_id', $invoice_id)
            ->join('ip_invoice_item_amounts', 'ip_invoice_item_amounts.item_id = ip_invoice_items.item_id')
            ->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_invoice_items.item_tax_rate_id')
            ->order_by("ip_invoice_items.item_order", "asc")
            ->get('ip_invoice_items')
            ->result());

    $ite = $CI->db->select()->from('ip_invoice_items')->where('invoice_id', $invoice_id)->order_by("ip_invoice_items.item_order", "asc")->get()->result();

    $data = array(
        'typepdf' => $respdf,
        'invoice' => $invoice,
        'countries' => get_country_list(lang('cldr')),
        'societe' => $societe,
        'invoice_tax_rates' => $CI->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
        'items' => $ite,
        'delai' => $CI->mdl_delai->get()->result(),
        'devises' => $CI->mdl_devises->get()->result(),
        'arrayItems' => $arrayItems,
        'output_type' => 'pdf',
    );

    $html = $CI->load->view('invoice_templates/pdf/' . $invoice_template, $data, true);

    $CI->load->helper('mpdf');

    //return pdf_create($html, lang('invoice') . '_' . str_replace(array('\\', '/'), '_', $invoice->invoice_number), $stream, $invoice->invoice_password);
    if (trim($invoice->client_societe) == "") {
        return pdf_create(1, $html, lang('invoice') . ' ' . str_replace(array('\\', '/'), '_', $invoice->invoice_number) . ' ' . $invoice->client_name . '_' . $invoice->client_prenom, $stream);
    } else {
        return pdf_create(1, $html, lang('invoice') . ' ' . str_replace(array('\\', '/'), '_', $invoice->invoice_number) . ' ' . $invoice->client_societe . ' ', $stream);
    }
}

function generate_quote_pdf($quote_id, $stream = true, $quote_template = null)
{
    $CI = &get_instance();

    $CI->load->model('quotes/mdl_quotes');
    $CI->load->model('quotes/mdl_quote_items');
    $CI->load->model('quotes/mdl_quote_tax_rates');
    $CI->load->model('families/mdl_families');
    $CI->load->model('societes/mdl_societes');
    $CI->load->model('devises/mdl_devises');
    $CI->load->helper('country');
    $quote = $CI->mdl_quotes->get_by_id($quote_id);
    $societe = $CI->mdl_societes->get_by_id(1);

    $quote_template = "default";

    $item_familles = $CI->mdl_families->get()->result();
    $arrayItems = array();
    // foreach ($item_familles as $famille) {

    // }
    array_push($arrayItems, $CI->db
            ->where('quote_id', $quote_id)
            ->join('ip_quote_item_amounts', 'ip_quote_item_amounts.item_id = ip_quote_items.item_id')
            ->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_quote_items.item_tax_rate_id')
            ->order_by("ip_quote_items.item_order", "asc")
            ->get('ip_quote_items')
            ->result());
    $ite = $CI->db->select()->from('ip_quote_items')->where('quote_id', $quote_id)->order_by("ip_quote_items.item_order", "asc")->get()->result();
    $respdf = $CI->mdl_quotes->getTypepdf();
    $data = array(
        'typepdf' => $respdf,
        'quote' => $quote,
        'countries' => get_country_list(lang('cldr')),
        'societe' => $societe,
        'quote_tax_rates' => $CI->mdl_quote_tax_rates->where('quote_id', $quote_id)->get()->result(),
        'items' => $ite,
        'devises' => $CI->mdl_devises->get()->result(),
        'arrayItems' => $arrayItems,
        'output_type' => 'pdf',
    );
    $quote->notes = str_replace("\n", "<br>", $quote->notes);
    $quote->notes = str_replace("\r", "<br>", $quote->notes);
    $html = $CI->load->view('quote_templates/pdf/' . $quote_template, $data, true);

    // echo "<pre>";
    // print_r($arrayItems);
    // echo "</pre>";

    $CI->load->helper('mpdf');
    if (trim($quote->client_societe) == "") {
        return pdf_create(0, $html, lang('quote') . ' ' . str_replace(array('\\', '/'), '_', $quote->quote_number) . ' ' . $quote->client_name . '_' . $quote->client_prenom, $stream, $quote->quote_password);
    } else {
        return pdf_create(0, $html, lang('quote') . ' ' . str_replace(array('\\', '/'), '_', $quote->quote_number) . ' ' . $quote->client_societe . ' ', $stream, $quote->quote_password);
    }
}

function generate_avoir_pdf($avoir_id, $stream = true, $avoir_template = null)
{
    $CI = &get_instance();

    $CI->load->model('invoices/mdl_invoices_avoir');
    $CI->load->model('invoices/mdl_invoices');

    $CI->load->model('invoices/mdl_items_avoir');
    $CI->load->model('delai_paiement/mdl_delai');
    $CI->load->model('families/mdl_families');
    $CI->load->model('devises/mdl_devises');
    $CI->load->model('societes/mdl_societes');
    $CI->load->helper('country');
    $avoir = $CI->mdl_invoices_avoir->get_by_id($avoir_id);
    $respdf = $CI->mdl_invoices->getTypepdf();
    $avoir_template = "default";

    $item_familles = $CI->mdl_families->get()->result();
    $societe = $CI->mdl_societes->get_by_id(1);
    $arrayItems = array();
    // foreach ($item_familles as $famille) {
    // array_push($arrayItems, $CI->mdl_items->select('*')
    // ->join('ip_families', 'ip_families.family_id = ip_invoice_items.family_id')
    // ->where('invoice_id', $invoice_id)
    // ->where('ip_invoice_items.family_id', $famille->family_id)
    // ->get()->result());
    // }
    array_push($arrayItems, $CI->db
            ->where('haveinvoice_id', $avoir_id)
            ->join('ip_haveinvoice_item_amounts', 'ip_haveinvoice_item_amounts.item_id = ip_haveinvoice_items.item_id')
            ->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_haveinvoice_items.item_tax_rate_id')
            ->order_by("ip_haveinvoice_items.item_order", "asc")
            ->get('ip_haveinvoice_items')
            ->result());

    $ite = $CI->db->select()->from('ip_haveinvoice_items')->where('haveinvoice_id', $avoir_id)->order_by("ip_haveinvoice_items.item_order", "asc")->get()->result();
    $data = array(
        'typepdf' => $respdf,
        'invoice' => $avoir,
        'countries' => get_country_list(lang('cldr')),
        'societe' => $societe,
        'items' => $ite,
        'delai' => $CI->mdl_delai->get()->result(),
        'devises' => $CI->mdl_devises->get()->result(),
        'arrayItems' => $arrayItems,
        'output_type' => 'pdf',
    );

    $html = $CI->load->view('avoir_templates/pdf/' . $avoir_template, $data, true);

    $CI->load->helper('mpdf');

    //return pdf_create($html, lang('invoice') . '_' . str_replace(array('\\', '/'), '_', $invoice->invoice_number), $stream, $invoice->invoice_password);
    if (trim($avoir->client_societe) == "") {
        return pdf_create(1, $html, lang('avoir') . ' ' . str_replace(array('\\', '/'), '_', $avoir->invoice_number) . ' ' . $avoir->client_name . '_' . $avoir->client_prenom, $stream);
    } else {
        return pdf_create(1, $html, lang('avoir') . ' ' . str_replace(array('\\', '/'), '_', $avoir->invoice_number) . ' ' . $avoir->client_societe . ' ', $stream);
    }
}

function prep_pdf($orientation = 'portrait')
{
    $CI = &get_instance();

    $CI->cezpdf->selectFont(base_url() . '/fonts');

    $all = $CI->cezpdf->openObject();
    $CI->cezpdf->saveState();
    $CI->cezpdf->setStrokeColor(0, 0, 0, 1);
    if ($orientation == 'portrait') {
        $CI->cezpdf->ezSetMargins(50, 70, 50, 50);
        $CI->cezpdf->ezStartPageNumbers(500, 28, 8, '', '{PAGENUM}', 1);
        $CI->cezpdf->line(20, 40, 578, 40);
        $CI->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $CI->cezpdf->addText(50, 22, 8, 'CI PDF Tutorial - http://chris.dev');
    } else {
        $CI->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $CI->cezpdf->line(20, 40, 800, 40);
        $CI->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $CI->cezpdf->addText(50, 22, 8, 'CI PDF Tutorial - http://chris.dev');
    }
    $CI->cezpdf->restoreState();
    $CI->cezpdf->closeObject();
    $CI->cezpdf->addObject($all, 'all');
}

function generate_invoice_pdf_folder($invoice_id, $folder)
{
    $CI = &get_instance();
    $CI->load->model('invoices/mdl_invoices');
    $CI->load->model('invoices/mdl_items');
    $CI->load->model('invoices/mdl_invoice_tax_rates');
    $CI->load->model('delai_paiement/mdl_delai');
    $CI->load->model('families/mdl_families');
    $CI->load->model('devises/mdl_devises');
    $CI->load->model('societes/mdl_societes');
    $CI->load->helper('country');
    $invoice = $CI->mdl_invoices->get_by_id($invoice_id);

    $invoice_template = "default";

    $item_familles = $CI->mdl_families->get()->result();
    $societe = $CI->mdl_societes->get_by_id(1);
    $arrayItems = array();
    foreach ($item_familles as $famille) {
        array_push($arrayItems, $CI->mdl_items->select('*')->join('ip_families', 'ip_families.family_id = ip_invoice_items.family_id')->where('invoice_id', $invoice_id)->where('ip_invoice_items.family_id', $famille->family_id)->get()->result());
    }
    $ite = $CI->db->select()->from('ip_invoice_items')->where('invoice_id', $invoice_id)->order_by("ip_invoice_items.item_order", "asc")->get()->result();

    $data = array(
        'invoice' => $invoice,
        'countries' => get_country_list(lang('cldr')),
        'societe' => $societe,
        'invoice_tax_rates' => $CI->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
        'items' => $ite,
        'delai' => $CI->mdl_delai->get()->result(),
        'devises' => $CI->mdl_devises->get()->result(),
        'arrayItems' => $arrayItems,
        'output_type' => 'pdf',
    );

    $html = $CI->load->view('invoice_templates/pdf/' . $invoice_template, $data, true);

    $CI->load->helper('mpdf');

    //return pdf_create($html, lang('invoice') . '_' . str_replace(array('\\', '/'), '_', $invoice->invoice_number), $stream, $invoice->invoice_password);
    if (trim($invoice->client_societe) == "") {
        return pdf_create_in_folder($html, $folder, lang('invoice') . ' ' . str_replace(array('\\', '/'), '_', $invoice->invoice_number) . ' ' . $invoice->client_name . '_' . $invoice->client_prenom);
    } else {
        return pdf_create_in_folder($html, $folder, lang('invoice') . ' ' . str_replace(array('\\', '/'), '_', $invoice->invoice_number) . ' ' . $invoice->client_societe);
    }
}

function create_zip($folderName, $zipFileName)
{
    $zip = new ZipArchive();

    if (is_dir($folderName)) {
        $zip_archive = $zip->open($zipFileName . ".zip", ZIPARCHIVE::CREATE);
        if ($zip_archive === true) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderName));
            foreach ($iterator as $key => $value) {
                $check = substr($key, -2);
                if ($check != ".." and $check != "/.") {
                    $_key = str_replace("../", "", $key);
                    $_key = str_replace("./", "", $_key);
                    @$zip->addFile(realpath($key), basename($_key));
                }
            }
            $zip->close();

            if (file_exists($zipFileName . ".zip")) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }

}
