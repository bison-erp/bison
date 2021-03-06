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

class Email_Templates extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_email_templates');
    }

    public function index($page = 0)
    {
        $this->mdl_email_templates->paginate(site_url('email_templates/index'), $page);
        $email_templates = $this->mdl_email_templates->result();

        $this->layout->set('email_templates', $email_templates);
        $this->layout->buffer('content', 'email_templates/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('email_templates');
        }

        if ($this->mdl_email_templates->run_validation()) { /*echo '<pre>';
        print_r($this->mdl_email_templates);
        echo '</pre>';die;*/

            $this->mdl_email_templates->save($id);

            redirect('email_templates');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_email_templates->prep_form($id)) {
                show_404();
            }
        }

        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('invoices/mdl_templates');

        foreach (array_keys($this->mdl_custom_fields->custom_tables()) as $table) {
            $custom_fields[$table] = $this->mdl_custom_fields->by_table($table)->get()->result();
        }
        $this->load->model('email_templates/mdl_email_templates');
        $this->layout->set('custom_fields', $custom_fields);
        $this->layout->set('invoice_templates', $this->mdl_templates->get_invoice_templates());
        $this->layout->set('quote_templates', $this->mdl_templates->get_quote_templates());
        $this->layout->set('selected_pdf_template', $this->mdl_email_templates->form_value('email_template_pdf_template'));
        $this->layout->buffer('content', 'email_templates/form');
        $this->layout->render();
    }

    public function delete($id)
    {
        $this->mdl_email_templates->delete($id);
        redirect('email_templates');
    }

}