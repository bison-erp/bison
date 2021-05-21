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

class Mdl_Payments extends Response_Model {

    public $table = 'ip_payments';
    public $primary_key = 'ip_payments.payment_id';
    public $validation_rules = 'validation_rules';

    public function default_select() {
        $this->db->select("
            SQL_CALC_FOUND_ROWS ip_payment_custom.*,
            ip_payment_methods.*,
            ip_invoice_amounts.*,
            ip_clients.client_name,
            ip_clients.client_id,
            ip_invoices.invoice_number,
            ip_invoices.invoice_date_created,
            ip_payments.*", FALSE);
    }

    public function default_order_by() {
        $this->db->order_by('ip_payments.payment_date DESC');
    }

    public function default_join() {
        $this->db->join('ip_invoices', 'ip_invoices.invoice_id = ip_payments.invoice_id');
        $this->db->join('ip_pieces', 'ip_pieces.payment_id = ip_payments.payment_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id');
        $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
        $this->db->join('ip_payment_custom', 'ip_payment_custom.payment_id = ip_payments.payment_id', 'left');
    }

    public function validation_rules() {
        $this->form_validation->set_message('is_natural_no_zero', 'Le champ Client est obligatoire');
        return array(
            'invoice_id' => array(
                'field' => 'invoice_id',
                'label' => lang('invoice'),
                'rules' => 'required'
            ),
            'payment_date' => array(
                'field' => 'payment_date',
                'label' => lang('date'),
                'rules' => 'required'
            ),
//            'payment_amount' => array(
//                'field' => 'payment_amount',
//                'label' => lang('payment'),
//                'rules' => 'required|callback_validate_payment_amount'
//            ),
            'payment_method_id' => array(
                'field' => 'payment_method_id',
                'label' => lang('payment_method'),
                'rules' => 'required'
            ),
            'client_id' => array(
                'field' => 'client_id',
                'label' => lang('client'),
                'rules' => 'is_natural_no_zero'
            ),
            'payment_note' => array(
                'field' => 'payment_note',
                'label' => lang('note'),
//                'rules' => 'required'
            )
        );
        
    }
    

    public function save($id = NULL, $db_array = NULL) {
        $db_array = ($db_array) ? $db_array : $this->db_array();

        // Save the payment
        $id = parent::save($id, $db_array);

        // Recalculate invoice amounts
        $this->load->model('invoices/mdl_invoice_amounts');
        $this->mdl_invoice_amounts->calculate($db_array['invoice_id']);

        return $id;
    }

    public function delete($id = NULL) {
        // Get the invoice id before deleting payment
        $this->db->select('invoice_id');
        $this->db->where('payment_id', $id);
        $invoice_id = $this->db->get('ip_payments')->row()->invoice_id;

        // Delete the payment
        parent::delete($id);

        // Recalculate invoice amounts
        $this->load->model('invoices/mdl_invoice_amounts');
        $this->mdl_invoice_amounts->calculate($invoice_id);

        // Change invoice status back to sent
        $this->db->select('invoice_status_id');
        $this->db->where('invoice_id', $invoice_id);
        $invoice = $this->db->get('ip_invoices')->row();

        if ($invoice->invoice_status_id == 4) {
            $this->db->where('invoice_id', $invoice_id);
            $this->db->set('invoice_status_id', 2);
            $this->db->update('ip_invoices');
        }

        $this->load->helper('orphan');
        delete_orphans();
    }

    public function db_array() {
        $db_array = parent::db_array();

        $db_array['payment_date'] = date_to_mysql($db_array['payment_date']);


        return $db_array;
    }

    public function prep_form($id = NULL) {
        if (!parent::prep_form($id)) {
            return FALSE;
        }

        if (!$id) {
            parent::set_form_value('payment_date', date('Y-m-d'));
        }

        return TRUE;
    }

    public function by_client($client_id) {
        $this->filter_where('ip_clients.client_id', $client_id);
        return $this;
    }

}
