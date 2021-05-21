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

class Mdl_Invoices_avoir extends Response_Model
{

    public $table = 'ip_haveinvoices';
    public $primary_key = 'ip_haveinvoices.haveinvoice_id';
    public $date_modified_field = 'invoice_date_modified';

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS ip_invoice_custom.*,
            ip_client_custom.*,
            ip_user_custom.*,
            ip_users.user_name,
			ip_users.user_company,
			ip_users.user_address_1,
			ip_users.user_address_2,
			ip_users.user_city,
			ip_users.user_code,
			ip_users.user_state,
			ip_users.user_zip,
			ip_users.user_country,
			ip_users.user_phone,
			ip_users.user_fax,
			ip_users.user_mobile,
			ip_users.user_email,
			ip_users.user_web,
			ip_users.user_vat_id,
			ip_users.user_tax_code,
			ip_clients.*,
			ip_devises.*,
			ip_have_invoice_amounts.invoice_amount_id,
			IFNULL(ip_have_invoice_amounts.invoice_item_subtotal, '0.00') AS invoice_item_subtotal,
			IFNULL(ip_delai_paiement.delai_paiement_label, ' ') AS delai_paiement_label,

			IFNULL(ip_have_invoice_amounts.invoice_item_tax_total, '0.00') AS invoice_item_tax_total,
			IFNULL(ip_have_invoice_amounts.invoice_tax_total, '0.00') AS invoice_tax_total,
			IFNULL(ip_have_invoice_amounts.invoice_total, '0.00') AS invoice_total,
			IFNULL(ip_have_invoice_amounts.timbre_fiscale, '0.00') AS timbre_fiscale,
			IFNULL(ip_have_invoice_amounts.invoice_paid, '0.00') AS invoice_paid,
			IFNULL(ip_have_invoice_amounts.invoice_balance, '0.00') AS invoice_balance,

                        IFNULL(ip_have_invoice_amounts.invoice_pourcent_remise, '0') AS invoice_pourcent_remise,
                        IFNULL(ip_have_invoice_amounts.invoice_montant_remise, '0.00') AS invoice_montant_remise,
                        IFNULL(ip_have_invoice_amounts.invoice_pourcent_acompte, '0') AS invoice_pourcent_acompte,
                        IFNULL(ip_have_invoice_amounts.invoice_montant_acompte, '0.00') AS invoice_montant_acompte,
                        IFNULL(ip_have_invoice_amounts.invoice_item_subtotal_final, '0.00') AS invoice_item_subtotal_final,
                        IFNULL(ip_have_invoice_amounts.invoice_item_tax_total_final, '0.00') AS invoice_item_tax_total_final,



                        ip_have_invoice_amounts.invoice_sign AS invoice_sign,
            (CASE WHEN ip_haveinvoices.invoice_status_id NOT IN (1,4) AND DATEDIFF(NOW(), invoice_date_due) > 0 THEN 1 ELSE 0 END) is_overdue,
			DATEDIFF(NOW(), invoice_date_due) AS days_overdue,
            (CASE (SELECT COUNT(*) FROM ip_haveinvoices WHERE ip_haveinvoices.invoice_id = ip_haveinvoices.invoice_id ) WHEN 0 THEN 0 ELSE 1 END) AS invoice_is_recurring,
			ip_haveinvoices.*", false);
    }

    public function default_order_by()
    {
        //$this->db->order_by('ip_invoices.invoice_id DESC');
        $this->db->order_by('ip_haveinvoices.invoice_number DESC');
    }

    public function default_join()
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_haveinvoices.client_id');
        $this->db->join('ip_users', 'ip_users.user_id = ip_haveinvoices.user_id');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_delai_paiement', 'ip_haveinvoices.invoice_delai_paiement = ip_delai_paiement.delai_paiement_id', 'left');
        // $this->db->join('ip_payments', 'ip_invoices.invoice_id = ip_payments.invoice_id');

        $this->db->join('ip_have_invoice_amounts', 'ip_have_invoice_amounts.invoice_id = ip_haveinvoices.invoice_id', 'left');
        $this->db->join('ip_client_custom', 'ip_client_custom.client_id = ip_clients.client_id', 'left');
        $this->db->join('ip_user_custom', 'ip_user_custom.user_id = ip_users.user_id', 'left');
        $this->db->join('ip_invoice_custom', 'ip_invoice_custom.invoice_id = ip_haveinvoices.invoice_id', 'left');
    }

    public function validation_rules()
    {
        return array(
            'client_id' => array(
                'field' => 'client_id',
                'label' => lang('client'),
                'rules' => 'required',
            ),
            'invoice_nature' => array(
                'field' => 'invoice_nature',
                'label' => lang('quote_nature'),
                'rules' => '',
            ),
            'invoice_delai_paiement' => array(
                'field' => 'invoice_delai_paiement',
                'label' => lang('CdtsReglement'),
                'rules' => '',
            ),
            'invoice_date_created' => array(
                'field' => 'invoice_date_created',
                'label' => lang('invoice_date'),
                'rules' => 'required',
            ),
            'invoice_time_created' => array(
                'rules' => '',
            ),
//            'invoice_group_id' => array(
            //                'field' => 'invoice_group_id',
            //                'label' => lang('invoice_group'),
            //                'rules' => ''
            //            ),
            'invoice_password' => array(
                'field' => 'invoice_password',
                'label' => lang('invoice_password'),
            ),
            'user_id' => array(
                'field' => 'user_id',
                'label' => lang('user'),
                'rule' => 'required',
            ),
        );
    }

    public function validation_rules_save_invoice()
    {
        return array(
            'invoice_number' => array(
                'field' => 'invoice_number',
                'label' => lang('invoice_number'),
                //   'rules' => 'required|is_unique[ip_invoices.invoice_number' . (($this->id) ? '.invoice_id.' . $this->id : '') . ']'
                'rules' => '',
            ),
            'invoice_date_created' => array(
                'field' => 'invoice_date_created',
                'label' => lang('date'),
                'rules' => 'required',
            ),
            'invoice_date_due' => array(
                'field' => 'invoice_date_due',
                'label' => lang('due_date'),
                'rules' => '',
            ),
            'invoice_time_created' => array(
                'rules' => '',
            ),
            'invoice_password' => array(
                'field' => 'invoice_password',
                'label' => lang('invoice_password'),
            ),
        );
    }

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }

    public function delete($invoice_id)
    {
//        parent::delete($invoice_id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    public function get_date_due($invoice_date_created)
    {
        $invoice_date_expires = new DateTime($invoice_date_created);
        $invoice_date_expires->add(new DateInterval('P' . $this->mdl_settings->setting('invoices_due_after') . 'D'));
        return $invoice_date_expires->format('Y-m-d');
    }

    public function get_date_due_format($invoice_date_created)
    {
        $invoice_date_expires = new DateTime($invoice_date_created);
        $invoice_date_expires->add(new DateInterval('P' . $this->mdl_settings->setting('invoices_due_after') . 'D'));
        return $invoice_date_expires->format('d/m/Y');
    }

}