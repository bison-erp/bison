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

function mailer_configured()
{
    $CI = &get_instance();

    return (($CI->mdl_settings->setting('email_send_method') == 'phpmail') or ($CI->mdl_settings->setting('email_send_method') == 'sendmail') or (($CI->mdl_settings->setting('email_send_method') == 'smtp') and ($CI->mdl_settings->setting('smtp_server_address')))
    );
}

function email_invoice($invoice_id, $invoice_template, $from, $to, $subject, $body, $cc = null, $bcc = null)
{
    $CI = &get_instance();

    $CI->load->helper('mailer/phpmailer');
    $CI->load->helper('template');
    $CI->load->helper('invoice');
    $CI->load->helper('pdf');
    $CI->load->model('email_templates/mdl_email_templates');
    $CI->load->model('invoices/mdl_invoices');
    $CI->load->model('quotes/mdl_rappel');
    $invoiceobj = $CI->mdl_invoices->get_by_id($invoice_id);
    $db_model = $CI->mdl_email_templates->where('ip_email_templates.email_template_id', 3)->get()->row();

    $invoice = generate_invoice_pdf($invoice_id, false, $invoice_template);
    $db_invoice = $CI->mdl_invoices->where('ip_invoices.invoice_id', $invoice_id)->get()->row();

    $message = (parse_template($db_invoice, $body));
    $subject = parse_template($db_invoice, $subject);
    $cc = parse_template($db_invoice, $cc);
    $bcc = parse_template($db_invoice, $bcc);
    //$from = array(parse_template($db_invoice, $from[0]), parse_template($db_invoice, $from[1]));
    //    $from = $db_model->email_template_from_email;

    $CI->load->helper('superadmin');
    $settings = get_settings_superadmin();

    $CI->db->where("invoice_id", $invoice_id);
    $CI->db->join('ip_users', 'ip_users.user_id= ip_invoices.user_id', 'left');

    $invoices_idobj = $CI->db->get("ip_invoices")->result();
    //  $message = str_replace('<br />', '', $message);
    //   $cont = str_replace('<br />', '<p></p>', $invoices_idobj[0]->signature);
    $message .= "<span style='font-size: 15px; color: #008080;'>" . $invoices_idobj[0]->signature . "</span>";

    $from_email_def = array($invoiceobj->user_email, $invoices_idobj[0]->user_name);
    $from = $from_email_def;
    // array_push($files,);
    $arrayattach = array();
    $licence = explode('_', $CI->db->database);
    $CI->db->where("client_id", $invoiceobj->client_id);
    $CI->db->where('object_id', $invoice_id);
    $CI->db->where('typeobject', 'invoice');

    $documentrappel = $CI->db->get("ip_document_rappel")->result();
    if ($invoiceobj->joindredevis == 1) {
        array_push($arrayattach, $invoice);
    }
    if ($invoiceobj->document == 1) {
        foreach ($documentrappel as $kj) {
            array_push($arrayattach, './uploads/' . $licence[1] . '/documents/' . $kj->nomdocument);
        }
    }
    if ($invoiceobj->joindredevis == 1 || $invoiceobj->document == 1) {
        return phpmail_send($from, $to, $subject, $message, $arrayattach, $cc, $bcc);
    } else {
        return phpmail_send($from, $to, $subject, $message, null, $cc, $bcc);
    }
    //  return phpmail_send($from, $to, $subject, $message, $invoice, $cc, $bcc);
}

function email_quote($quote_id, $quote_template, $from, $to, $subject, $body, $cc = null, $bcc = null)
{
    $CI = &get_instance();
    $CI->load->helper('mailer/phpmailer');
    $CI->load->helper('template');
    $CI->load->helper('pdf');
    $CI->load->model('email_templates/mdl_email_templates');
    $CI->load->model('quotes/mdl_quotes');
    $CI->load->model('quotes/mdl_rappel');
    $quoteobj = $CI->mdl_quotes->get_by_id($quote_id);
    $quote = generate_quote_pdf($quote_id, false, $quote_template);

    $db_quote = $CI->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->row();

    $db_model = $CI->mdl_email_templates->where('ip_email_templates.email_template_id', 3)->get()->row();
    //print_r($db_model);die;
    $message = (parse_template($db_quote, $body));
    $subject = parse_template($db_quote, $subject);
    $cc = parse_template($db_quote, $cc);
    $bcc = parse_template($db_quote, $bcc);
    //$from = array(parse_template($db_quote, $from[0]), parse_template($db_quote, $from[1]));
    //    $from = $db_model->email_template_from_email; //'ayda@novatis.org';// array(parse_template($db_quote, $from[0]), parse_template($db_quote, $from[1]));
    $CI->load->helper('superadmin');
    $settings = get_settings_superadmin();

    $CI->db->where("quote_id", $quote_id);
    $CI->db->join('ip_users', 'ip_users.user_id= ip_quotes.user_id', 'left');

    $quote_idobj = $CI->db->get("ip_quotes")->result();
    //   $message = str_replace('<br />', '', $message);
    //   $cont = str_replace('<br />', '<p></p>', $quote_idobj[0]->signature);

    $message .= "<span style='font-size: 15px; color: #008080;'>" . $quote_idobj[0]->signature . "</span>";

    $from_email_def = array($quoteobj->user_email, $quote_idobj[0]->user_name);

    $from = $from_email_def;
    // array_push($files,);
    $arrayattach = array();
    $licence = explode('_', $CI->db->database);
    $CI->db->where("client_id", $quoteobj->client_id);
    $CI->db->where('object_id', $quote_id);
    $CI->db->where('typeobject', 'quote');

    $documentrappel = $CI->db->get("ip_document_rappel")->result();
    if ($quoteobj->joindredevis == 1) {
        array_push($arrayattach, $quote);
    }
    if ($quoteobj->document == 1) {
        foreach ($documentrappel as $kj) {
            array_push($arrayattach, './uploads/' . $licence[1] . '/documents/' . $kj->nomdocument);
        }
    }

    if ($quoteobj->joindredevis == 1 || $quoteobj->document == 1) {
        return phpmail_send($from, $to, $subject, $message, $arrayattach, $cc, $bcc);
    } else {
        return phpmail_send($from, $to, $subject, $message, null, $cc, $bcc);
    }

}

//default email sending

function email_quote_default($quote_id, $quote_template, $from, $to, $subject, $body, $cc = null, $bcc = null)
{
    $CI = &get_instance();

    $CI->load->helper('mailer/phpmailer');
    $CI->load->helper('template');
    $CI->load->helper('pdf');
    $CI->load->model('quotes/mdl_quotes');
    $CI->load->model('email_templates/mdl_email_templates');

    $quote = generate_quote_pdf($quote_id, false, $quote_template);

    $db_quote = $CI->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->row();

    $db_model = $CI->mdl_email_templates->where('ip_email_templates.email_template_id', 3)->get()->row();
    //print_r($db_model);die;
    //  $message = nl2br(parse_template($db_quote, $body));
    $message = (parse_template($db_quote, $body));
    $subject = parse_template($db_quote, $subject);
    $cc = parse_template($db_quote, $cc);
    $bcc = parse_template($db_quote, $bcc);

//    $from = $db_model->email_template_from_email;

    $CI->load->helper('superadmin');
    $settings = get_settings_superadmin();
    $from_email_def = array($settings['noreplay_mail'], $settings['from_name']);
    $from = $from_email_def;
    return phpmail_send($from, $to, $subject, $message, $quote, $cc, $bcc);
    $tob = $this->session->userdata['user_mail'];
    return phpmail_send($from, $tob, $subject, $message, $quote, $cc, $bcc);
}

/**
 * @param $quote_id
 * @param $status string "accepted" or "rejected"
 * @return bool if the email was sent
 */
function email_quote_status($quote_id, $status)
{
    ini_set("display_errors", "on");
    error_reporting(E_ALL);

    if (!mailer_configured()) {
        return false;
    }

    $CI = &get_instance();
    $CI->load->helper('mailer/phpmailer');

    $quote = $CI->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->row();
    $base_url = base_url('/quotes/view/' . $quote_id);

    $user_email = $quote->user_email;
    $CI->load->helper('superadmin');
    $settings = get_settings_superadmin();
    $from_email_def = array($settings['noreplay_mail'], $settings['from_name']);
    $from = $from_email_def;
    $subject = sprintf(lang('quote_status_email_subject'), $quote->client_name, strtolower(lang($status)), $quote->quote_number
    );
    $body = sprintf(nl2br(lang('quote_status_email_body')), $quote->client_name, strtolower(lang($status)), $quote->quote_number, '<a href="' . $base_url . '">' . $base_url . '</a>'
    );

    return phpmail_send($from, $user_email, $subject, $body);
}

function email_clients($subject = "", $data, $id)
{

    $CI = &get_instance();
    $CI->load->helper('mailer/phpmailer');
    $CI->load->helper('template');
    $CI->load->model('email_templates/mdl_email_templates');

    $CI->mdl_settings->load_settings();

//    $smtp_username = $CI->mdl_settings->setting('smtp_username');
    $mail_admin = $CI->mdl_settings->setting('mail_admin');

    $CI->load->helper('superadmin');
    $settings = get_settings_superadmin();

    $from_email_def = array($settings['noreplay_mail'], $settings['from_name']);

    $from = $from_email_def;
    $to = $mail_admin;
    $user_connected = $CI->session->userdata['user_mail'] . "<br>";
    $message = "User connected : " . $user_connected;
    $message .= "ID : #" . $id . "<br>";
    $message .= "Nom & Pr&eacute;nom : " . $data['client_name'] . " " . $data['client_prenom'] . "<br>";
    $message .= "Soci&eacute;t&eacute; : " . $data['client_societe'] . "<br>";
    $message .= "Adresse : " . $data['client_address_1'] . "<br>";
    $message .= "Ville : " . $data['client_state'] . "<br>";
    $message .= "Code postal : " . $data['client_zip'] . "<br>";
    $message .= "Pays : " . $data['client_country'] . "<br>";
    $message .= "T&eacute;l&eacute;phone : " . $data['client_phone'] . "<br>";
    $message .= "Portable : " . $data['client_mobile'] . "<br>";
    $message .= "Fax : " . $data['client_fax'] . "<br>";
    $message .= "Email : " . $data['client_email'] . "<br>";
    $message .= "Site web : " . $data['client_web'] . "<br>";
    $message .= "Matricule fiscale : " . $data['client_vat_id'] . "<br>";
    $message .= "Registre de commerce : " . $data['client_tax_code'] . "<br>";
    $message .= "Lien vers le client : <a href='http://" . $_SERVER['SERVER_NAME'] . "/clients/view/" . $id . "'>http://" . $_SERVER['SERVER_NAME'] . "/clients/view/" . $id . "</a><br>";
//    $message = "message Test smtp username : ".$smtp_username."  - mail admin : ".$mail_admin;
    return phpmail_send($from, $to, $subject, $message);
}

function generate_template_email($id_quote, $template_email)
{
    $CI = &get_instance();
    $CI->db->where("email_template_id", $template_email);
    $template_email = $CI->db->get("ip_email_templates")->result();
    if (!empty($template_email)) {
        $template['subject'] = $template_email[0]->email_template_subject;
        $template['message'] = $template_email[0]->email_template_body;
        return $template;
    } else {
        return "spas de template";
    }

}

function get_quote_info_mail($quote_id)
{
    $CI = &get_instance();
    $CI->load->helper('country');
    $CI->db->where("ip_quotes.quote_id", $quote_id);
    $CI->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
    $CI->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
    $CI->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');

    $country = get_country_list(lang('cldr'));

    $quotes = $CI->db->get("ip_quotes")->result();

    $CI->db->where("ip_quote_items.quote_id", $quote_id);
    $quote_items = $CI->db->get("ip_quote_items")->result();
    $quotes[0]->quote_items = $quote_items;
    $quotes[0]->client_country = $country[$quotes[0]->client_country];
    return $quotes;
}

function get_invoice_info_mail($invoice_id)
{
    $CI = &get_instance();
    $CI->load->helper('country');
    $CI->db->where("ip_invoices.invoice_id", $invoice_id);
    $CI->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
    $CI->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
    $CI->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');

    $country = get_country_list(lang('cldr'));

    $invoices = $CI->db->get("ip_invoices")->result();

    $CI->db->where("ip_invoice_items.invoice_id", $invoice_id);
    $invoice_items = $CI->db->get("ip_invoice_items")->result();
    $invoices[0]->invoice_items = $invoice_items;
    $invoices[0]->client_country = $country[$invoices[0]->client_country];
    return $invoices;
}

function sendMail($id, $template_email, $type)
{
    $CI = &get_instance();
    $CI->load->helper('mailer/phpmailer');
    $CI->load->helper('template');
    $CI->load->helper('pdf');
    $from = $CI->session->userdata['user_mail'];
    if ($type == "quote") {
        $quote = get_quote_info_mail($id);

        $fields['nature'] = $quote[0]->quote_nature;
        $fields['date_created'] = $quote[0]->quote_date_created;
        $fields['date_expires'] = $quote[0]->quote_date_expires;
        $fields['number'] = $quote[0]->quote_number;

        $civilite[0] = "M.";
        $civilite[1] = "Mme.";
        $civilite[2] = "Melle.";
        $client_fullname = $civilite[$quote[0]->client_titre] . " " . $quote[0]->client_name . " " . $quote[0]->client_prenom;
        $fields['client_fullname'] = $client_fullname;
        $fields['client_societe'] = $quote[0]->client_societe;
        $fields['client_address_1'] = $quote[0]->client_address_1;
        $fields['client_address_2'] = $quote[0]->client_address_2;
        $fields['client_city'] = $quote[0]->client_state;
        $fields['client_country'] = $quote[0]->client_country;
        $fields['client_phone'] = $quote[0]->client_phone;
        $fields['client_fax'] = $quote[0]->client_fax;
        $fields['client_mobile'] = $quote[0]->client_mobile;
        $fields['client_email'] = $quote[0]->client_email;
        $fields['client_web'] = $quote[0]->client_web;
        $fields['matricule_fiscale'] = $quote[0]->client_vat_id;
        $fields['registre_commerce'] = $quote[0]->client_tax_code;
        //    $fields['items_table'] = $quote[0]->quote_date_created;
        //    $fields['items_codes'] = $quote[0]->quote_date_created;
        //    $fields['item_subtotal'] = $quote[0]->quote_date_created;
        //   $fields['total_a_payer'] = $quote[0]->quote_date_created;
        //    $fields['total_final'] = $quote[0]->quote_date_created;
        $template = generate_template_email($id, $template_email);
        $message = $template['message'];
        $subject = $template['subject'];
        $to = $quote[0]->client_email;
        $attachment_path = generate_quote_pdf($id, false, null);
    } else if ($type == "invoice") {

        $invoice = get_invoice_info_mail($id);

        $fields['nature'] = $invoice[0]->nature;
        $fields['date_created'] = $invoice[0]->invoice_date_created;
        $fields['date_expires'] = $invoice[0]->invoice_date_due;
        $fields['number'] = $invoice[0]->invoice_number;

        $civilite[0] = "M.";
        $civilite[1] = "Mme.";
        $civilite[2] = "Melle.";
        $client_fullname = $civilite[$invoice[0]->client_titre] . " " . $invoice[0]->client_name . " " . $invoice[0]->client_prenom;
        $fields['client_fullname'] = $client_fullname;
        $fields['client_societe'] = $invoice[0]->client_societe;
        $fields['client_address_1'] = $invoice[0]->client_address_1;
        $fields['client_address_2'] = $invoice[0]->client_address_2;
        $fields['client_city'] = $invoice[0]->client_state;
        $fields['client_country'] = $invoice[0]->client_country;
        $fields['client_phone'] = $invoice[0]->client_phone;
        $fields['client_fax'] = $invoice[0]->client_fax;
        $fields['client_mobile'] = $invoice[0]->client_mobile;
        $fields['client_email'] = $invoice[0]->client_email;
        $fields['client_web'] = $invoice[0]->client_web;
        $fields['matricule_fiscale'] = $invoice[0]->client_vat_id;
        $fields['registre_commerce'] = $invoice[0]->client_tax_code;
        $fields['total_a_payer'] = $invoice[0]->invoice_balance;
        $template = generate_template_email($id, $template_email);
        $message = $template['message'];
        $subject = $template['subject'];
        $to = $invoice[0]->client_email;
        $attachment_path = generate_invoice_pdf($id, false, null);
    }

    $message = replace_dynamic_fields($message, $fields);
    $subject = replace_dynamic_fields($subject, $fields);
    $cc = null;
    $bcc = null;

    return phpmail_send($from, $to, $subject, $message, $attachment_path, $cc, $bcc);
}

function cron($abonnee, $config_db)
{
    $CI = &get_instance();
    $config_db['database'] = $abonnee->database;
    $CI->db = $CI->load->database($config_db, true);
    echo $CI->db->database;
}