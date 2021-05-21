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

class Mailer extends Admin_Controller
{

    private $mailer_configured;

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('mailer');

        $this->mailer_configured = mailer_configured();

        if ($this->mailer_configured == false) {
            $this->layout->buffer('content', 'mailer/not_configured');
            $this->layout->render();
        }
    }

    public function invoice($invoice_id)
    {
        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('invoices/mdl_templates');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoices/mdl_items');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');

        $invoice = $this->mdl_invoices->where('ip_invoices.invoice_id', $invoice_id)->get()->row();
        $itemss = $this->mdl_items->where('ip_invoice_items.invoice_id', $invoice_id)->get()->row();
        $sqlll = "SELECT `ip_invoice_item_amounts` . * , `ip_invoice_items` . * , `item_tax_rates`.`tax_rate_percent` AS `item_tax_rate_percent`
FROM (
`ip_invoice_items`
)
LEFT JOIN `ip_invoice_item_amounts` ON `ip_invoice_item_amounts`.`item_id` = `ip_invoice_items`.`item_id`
LEFT JOIN `ip_tax_rates` AS `item_tax_rates` ON `item_tax_rates`.`tax_rate_id` = `ip_invoice_items`.`item_tax_rate_id`
WHERE `ip_invoice_items`.`invoice_id` = '" . $invoice_id . "'
ORDER BY `ip_invoice_items`.`item_order`
LIMIT 0 , 30";
        $query = $this->db->query($sqlll);
        $qq = $query->result();

        $email_template_id = select_email_invoice_template($invoice);

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->where('email_template_id', $email_template_id)->get();

            $this->layout->set('email_template', json_encode($email_template->row()));
        } else {
            $this->layout->set('email_template', '{}');
        }

        $this->layout->set('selected_pdf_template', select_pdf_invoice_template($invoice));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'invoice')->get()->result());
        $this->layout->set('invoice', $invoice);
        $this->layout->set('item', $qq); ///$itemss);
        $this->layout->set('pdf_templates', $this->mdl_templates->get_invoice_templates());
        $this->layout->buffer('content', 'mailer/invoice');
        $this->layout->render();
    }

    public function quote($quote_id)
    {
        if (!$this->mailer_configured) {
            return;
        }
        $this->load->model('invoices/mdl_templates');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('quotes/mdl_quote_items');
        $this->load->model('email_templates/mdl_email_templates');

        $email_template_id = $this->mdl_settings->setting('email_quote_template');

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->where('email_template_id', $email_template_id)->get();

            $this->layout->set('email_template', json_encode($email_template->row()));
        } else {
            $this->layout->set('email_template', '{}');
        }

        $this->layout->set('selected_pdf_template', $this->mdl_settings->setting('pdf_quote_template'));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'quote')->get()->result());
        $this->layout->set('quote', $this->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->row());
        $this->layout->set('quote_item', $this->mdl_quote_items->where('ip_quote_items.quote_id', $quote_id)->get()->result());
        $this->layout->set('pdf_templates', $this->mdl_templates->get_quote_templates());
        $this->layout->buffer('content', 'mailer/quote');
        $this->layout->render();
    }

    public function send_invoice($invoice_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('invoices');
        }

        if (!$this->mailer_configured) {
            return;
        }
        $this->load->model('quotes/mdl_rappel');
        $from = array($this->input->post('from_email'),
            $this->input->post('from_name'));
        $pdf_template = $this->input->post('pdf_template');
        $to = $this->input->post('to_email');
        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        $resdate = $this->input->post('date_relance');
        $docselectionne = $this->input->post('listdocument');
        $data = array(
            'document' => $this->input->post('drap'),
            'joindredevis' => $this->input->post('joint'),
        );

        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('ip_invoices', $data);
        if (email_invoice($invoice_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc)) {

            $this->mdl_invoices->mark_sent($invoice_id);
            $this->mdl_rappel->updateDateRelance($invoice_id, $resdate, 1);

            $arra = array('object_id' => $invoice_id, 'typeobject' => 'invoice');
            $this->db->delete('ip_document_rappel', $arra);

            $docselectionneid = explode(',', $docselectionne);
            //   return die('hh' . var_dump($docselectionneid));
            for ($i = 0; $i < count($docselectionneid); $i++) {
                if ($docselectionneid[$i] != '') {
                    $this->db->select('file_name,id_client');
                    $this->db->where("id_document", $docselectionneid[$i]);
                    $getclientdoc = $this->db->get('ip_client_documents')->result();
                    if ($getclientdoc[0]->file_name != "") {

                        $data_doc_client = array(
                            'typeobject' => 'invoice',
                            'object_id' => $invoice_id,
                            'doc_id' => $docselectionneid[$i],
                            'nomdocument' => $getclientdoc[0]->file_name,
                            'client_id' => $getclientdoc[0]->id_client,
                        );
                        $this->db->insert('ip_document_rappel', $data_doc_client);
                    }
                }
            }
            $this->session->set_flashdata('alert_success', lang('email_successfully_sent'));

            redirect('invoices');
        } else {
            redirect('mailer/invoice/' . $invoice_id);
        }
    }

    public function send_quote($quote_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('quotes');
        }

        if (!$this->mailer_configured) {
            return;
        }
        $this->load->model('quotes/mdl_rappel');
        $from = array($this->input->post('from_email'),
            $this->input->post('from_name'));
        $pdf_template = $this->input->post('pdf_template');
        $to = $this->input->post('to_email');
        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        $resdate = $this->input->post('date_relance');
        $docselectionne = $this->input->post('listdocument');
        $data = array(
            'document' => $this->input->post('drap'),
            'joindredevis' => $this->input->post('joint'),
        );

        $this->db->where('quote_id', $quote_id);
        $this->db->update('ip_quotes', $data);
        $arra = array('object_id' => $quote_id, 'typeobject' => 'quote');
        $this->db->delete('ip_document_rappel', $arra);
        $this->mdl_rappel->updateDateRelance($quote_id, $resdate, 0);

        $docselectionneid = explode(',', $docselectionne);
        for ($i = 0; $i < count($docselectionneid); $i++) {
            if ($docselectionneid[$i] != '') {
                $this->db->select('file_name,id_client');
                $this->db->where("id_document", $docselectionneid[$i]);
                $getclientdoc = $this->db->get('ip_client_documents')->result();
                if ($getclientdoc[0]->file_name != "") {

                    $data_doc_client = array(
                        'typeobject' => 'quote',
                        'object_id' => $quote_id,
                        'doc_id' => $docselectionneid[$i],
                        'nomdocument' => $getclientdoc[0]->file_name,
                        'client_id' => $getclientdoc[0]->id_client,
                    );
                    $this->db->insert('ip_document_rappel', $data_doc_client);
                }
            }}
//echo email_quote($quote_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc);die;
        if (email_quote($quote_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc)) {
            $this->mdl_quotes->mark_sent($quote_id);

            $this->session->set_flashdata('alert_success', lang('email_successfully_sent'));

            redirect('quotes');
        } else {
            redirect('mailer/quote/' . $quote_id);
        }
    }

    public function relance()
    {
        $this->load->helper('mailer');
        $type = $this->input->post('type');

        if ($type == 'quote') {
            $quote_email_template = $this->mdl_settings->setting('email_quote_template_relance');
            $quote_id = $this->input->post('id_quote');
            sendMail($quote_id, $quote_email_template, 'quote');
        }
        if ($type == 'invoice') {
            $invoice_email_template = $this->mdl_settings->setting('email_invoice_template_relance');
            $invoice_id = $this->input->post('id_invoice');

            sendMail($invoice_id, $invoice_email_template, 'invoice');
        }

        if ($type == 'commande') {
            $this->load->model('email_templates/mdl_email_templates');

         //   $commande_email_template = $this->mdl_email_templates->where('ip_email_templates.email_template_id', 10)->get()->row();
         $commande_email_template = $this->mdl_settings->setting('email_bc_template_relance');
             $commande_id = $this->input->post('id_commande');
            sendMail($commande_id, $commande_email_template, 'commande');
        }

        if ($type == 'bl') {
            $this->load->model('email_templates/mdl_email_templates');

          //  $bl_email_template = $this->mdl_email_templates->where('ip_email_templates.email_template_id', 11)->get()->row();
            $bl_email_template = $this->mdl_settings->setting('email_bl_template_relance');

            $bl_id = $this->input->post('id_bl');
            sendMail($bl_id, $bl_email_template, 'bl');
        }
    }

    public function commande($commande_id)
    {

        if (!$this->mailer_configured) {

            return;
        }

        $this->load->model('invoices/mdl_templates');
        $this->load->model('commande/mdl_commande');
        $this->load->model('commande/mdl_commande_items');
        $this->load->model('email_templates/mdl_email_templates');

        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'commande')->get()->result());
        $this->layout->set('commande', $this->mdl_commande->where('ip_commande.commande_id', $commande_id)->get()->row());
        $this->layout->set('commande_item', $this->mdl_commande_items->where('ip_commande_items.commande_id', $commande_id)->get()->result());
        $this->layout->set('pdf_templates', $this->mdl_templates->get_quote_templates());
        $this->layout->buffer('content', 'mailer/commande');
        $this->layout->render();
    }

    public function send_commande($commande_id)
    { 
        if ($this->input->post('btn_cancel')) {
            redirect('commande');
        }

        if (!$this->mailer_configured) {
            return;
        }
       
        //    $this->load->model('quotes/mdl_rappel');
        $from = array($this->input->post('from_email'),
            $this->input->post('from_name'));
        $pdf_template = $this->input->post('pdf_template');
        $to = $this->input->post('to_email');
        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        //  $resdate = $this->input->post('date_relance');
        //   $docselectionne = $this->input->post('listdocument');
        /*  $data = array(
        'document' => $this->input->post('drap'),
        'joindredevis' => $this->input->post('joint'),
        );
         */
        /*  $this->db->where('quote_id', $quote_id);
        $this->db->update('ip_quotes', $data);
        $arra = array('object_id' => $quote_id, 'typeobject' => 'quote');
        $this->db->delete('ip_document_rappel', $arra);
        // $this->mdl_rappel->updateDateRelance($quote_id, $resdate, 0);*/

        //   $docselectionneid = explode(',', $docselectionne);
        /*for ($i = 0; $i < count($docselectionneid); $i++) {
        if ($docselectionneid[$i] != '') {
        $this->db->select('file_name,id_client');
        $this->db->where("id_document", $docselectionneid[$i]);
        $getclientdoc = $this->db->get('ip_client_documents')->result();
        if ($getclientdoc[0]->file_name != "") {

        $data_doc_client = array(
        'typeobject' => 'quote',
        'object_id' => $quote_id,
        'doc_id' => $docselectionneid[$i],
        'nomdocument' => $getclientdoc[0]->file_name,
        'client_id' => $getclientdoc[0]->id_client,
        );
        $this->db->insert('ip_document_rappel', $data_doc_client);
        }
        }}*/
//echo email_quote($quote_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc);die;
        if (email_commande($commande_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc)) {
            // $this->mdl_quotes->mark_sent($quote_id);
           
            $data = array(
                'commande_status_id' => 2,
            );

            $this->db->where('commande_id', $commande_id);

            $this->db->update('ip_commande', $data);

            $this->session->set_flashdata('alert_success', lang('email_successfully_sent'));

            redirect('commande');
        } else {
            redirect('mailer/commande/' . $commande_id);
        }
    }

    public function bl($bl_id)
    {
        if (!$this->mailer_configured) {
            return;
        }

        $this->load->model('invoices/mdl_templates');
        $this->load->model('bl/mdl_bl');
        $this->load->model('bl/mdl_bl_items');
        $this->load->model('email_templates/mdl_email_templates');

        $email_template_id = $this->mdl_settings->setting('email_quote_template');

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->where('email_template_id', $email_template_id)->get();

            $this->layout->set('email_template', json_encode($email_template->row()));
        } else {
            $this->layout->set('email_template', '{}');
        }

        $this->layout->set('selected_pdf_template', $this->mdl_settings->setting('pdf_quote_template'));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'bl')->get()->result());
        $this->layout->set('bl', $this->mdl_bl->where('ip_bl.bl_id', $bl_id)->get()->row());
        $this->layout->set('bl_item', $this->mdl_bl_items->where('ip_bl_items.bl_id', $bl_id)->get()->result());
        $this->layout->set('pdf_templates', $this->mdl_templates->get_quote_templates());
        $this->layout->buffer('content', 'mailer/bl');
        $this->layout->render();
    }

    public function send_bl($bl_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('bl');
        }

        if (!$this->mailer_configured) {
            return;
        }

        //    $this->load->model('quotes/mdl_rappel');
        $from = array($this->input->post('from_email'),
            $this->input->post('from_name'));
        $pdf_template = $this->input->post('pdf_template');
        $to = $this->input->post('to_email');
        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        //  $resdate = $this->input->post('date_relance');
        //   $docselectionne = $this->input->post('listdocument');
        /*  $data = array(
        'document' => $this->input->post('drap'),
        'joindredevis' => $this->input->post('joint'),
        );
         */
        /*  $this->db->where('quote_id', $quote_id);
        $this->db->update('ip_quotes', $data);
        $arra = array('object_id' => $quote_id, 'typeobject' => 'quote');
        $this->db->delete('ip_document_rappel', $arra);
        // $this->mdl_rappel->updateDateRelance($quote_id, $resdate, 0);*/

        //   $docselectionneid = explode(',', $docselectionne);
        /*for ($i = 0; $i < count($docselectionneid); $i++) {
        if ($docselectionneid[$i] != '') {
        $this->db->select('file_name,id_client');
        $this->db->where("id_document", $docselectionneid[$i]);
        $getclientdoc = $this->db->get('ip_client_documents')->result();
        if ($getclientdoc[0]->file_name != "") {

        $data_doc_client = array(
        'typeobject' => 'quote',
        'object_id' => $quote_id,
        'doc_id' => $docselectionneid[$i],
        'nomdocument' => $getclientdoc[0]->file_name,
        'client_id' => $getclientdoc[0]->id_client,
        );
        $this->db->insert('ip_document_rappel', $data_doc_client);
        }
        }}*/
//echo email_quote($quote_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc);die;
        if (email_bl($bl_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc)) {
            $data = array(
                'bl_status_id' => 2,
            );

            $this->db->where('bl_id', $bl_id);

            $this->db->update('ip_bl', $data);
            // $this->mdl_quotes->mark_sent($quote_id);

            $this->session->set_flashdata('alert_success', lang('email_successfully_sent'));

            redirect('bl');
        } else {
            redirect('mailer/bl/' . $bl_id);
        }
    }

    public function send_avoir($avoir_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('invoices/avoir');
        }

        if (!$this->mailer_configured) {
            return;
        }

        //    $this->load->model('quotes/mdl_rappel');
        $from = array($this->input->post('from_email'),
            $this->input->post('from_name'));
        $pdf_template = $this->input->post('pdf_template');
        $to = $this->input->post('to_email');
        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');

        if ($this->email_avoir($avoir_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc)) {
            // $this->mdl_quotes->mark_sent($quote_id);
            $this->session->set_flashdata('alert_success', lang('email_successfully_sent'));

            redirect('invoices/avoir');
        } else {
            redirect('mailer/avoir/' . $avoir_id);
        }
    }
    public function email_avoir($avoir_id, $avoir_template, $from, $to, $subject, $body, $cc = null, $bcc = null)
    {
        $CI = &get_instance();

        $CI->load->helper('mailer/phpmailer');
        $CI->load->helper('template');
        $CI->load->helper('pdf');
        $CI->load->model('email_templates/mdl_email_templates');
        $CI->load->model('invoices/mdl_invoices_avoir');
        $invoices = $CI->mdl_invoices_avoir->get_by_id($avoir_id);

        $invoices = generate_avoir_pdf($avoir_id, false, 0);
        $db_avoir = $CI->mdl_invoices_avoir->where('ip_haveinvoices.haveinvoice_id', $avoir_id)->get()->row();

        // $db_model = $CI->mdl_email_templates->where('ip_email_templates.email_template_id', 3)->get()->row();
        //print_r($db_model);die;
        $message = (parse_template($db_avoir, $body));
        $subject = parse_template($db_avoir, $subject);
        $cc = parse_template($db_avoir, $cc);
        $bcc = parse_template($db_avoir, $bcc);
        //$from = array(parse_template($db_quote, $from[0]), parse_template($db_quote, $from[1]));
        //    $from = $db_model->email_template_from_email; //'ayda@novatis.org';// array(parse_template($db_quote, $from[0]), parse_template($db_quote, $from[1]));
        $CI->load->helper('superadmin');
        $settings = get_settings_superadmin();

        $CI->db->where("haveinvoice_id", $avoir_id);
        $CI->db->join('ip_users', 'ip_users.user_id= ip_haveinvoices.user_id', 'left');

        $avoir_idobj = $CI->db->get("ip_haveinvoices")->result();

        //   $message = str_replace('<br />', '', $message);
        //   $cont = str_replace('<br />', '<p></p>', $quote_idobj[0]->signature);
        $from_email_def = array($avoir_idobj[0]->user_email, $avoir_idobj[0]->user_name);

        $message .= "<span style='font-size: 15px; color: #008080;'>" . $avoir_idobj[0]->signature . "</span>";

        $from = $from_email_def;
        // array_push($files,);
        $arrayattach = array();
        array_push($arrayattach, $invoices);
        return phpmail_send($from, $to, $subject, $message, $arrayattach, $cc, $bcc);
    }

    public function avoir($avoir)
    {
        if (!$this->mailer_configured) {
            return;
        }
        $this->load->model('invoices/mdl_templates');
        $this->load->model('invoices/mdl_invoices_avoir');
        $this->load->model('invoices/mdl_items_avoir');
        $this->load->model('email_templates/mdl_email_templates');

        $email_template_id = $this->mdl_settings->setting('email_quote_template');

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->where('email_template_id', $email_template_id)->get();

            $this->layout->set('email_template', json_encode($email_template->row()));
        } else {
            $this->layout->set('email_template', '{}');
        }

        $this->layout->set('selected_pdf_template', $this->mdl_settings->setting('pdf_quote_template'));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'avoir')->get()->result());
        $this->layout->set('invoice', $this->mdl_invoices_avoir->where('ip_haveinvoices.haveinvoice_id', $avoir)->get()->row());
        // $this->layout->set('quote_item', $this->mdl_quote_items->where('ip_quote_items.quote_id', $quote_id)->get()->result());
        $this->layout->set('pdf_templates', $this->mdl_templates->get_quote_templates());
        $this->layout->buffer('content', 'mailer/avoir');
        $this->layout->render();
    }
}