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

class Mdl_Fabrication extends Response_Model
{

    public $table = 'ip_fabrication';
    public $primary_key = 'ip_fabrication.fabrication_id';
    public $date_created_field = 'fabrication_date_created';
    public $date_modified_field = 'fabrication_date_modified';

    public function default_join()
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_fabrication.client_id');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_delai_paiement', 'ip_fabrication.fabrication_delai_paiement = ip_delai_paiement.delai_paiement_id', 'left');

        $this->db->join('ip_users', 'ip_users.user_id = ip_fabrication.user_id');
        $this->db->join('ip_users as user_modif', 'user_modif.user_id = ip_fabrication.fabrication_user_modif', 'left');
        $this->db->join('ip_fabrication_ammont', 'ip_fabrication_ammont.fabrication_id = ip_fabrication.fabrication_id', 'left');
        $this->db->join('ip_client_custom', 'ip_client_custom.client_id = ip_clients.client_id', 'left');
        $this->db->join('ip_user_custom', 'ip_user_custom.user_id = ip_users.user_id', 'left');
        // $this->db->join('ip_quote_custom', 'ip_quote_custom.quote_id = ip_quotes.quote_id', 'left');
        $this->db->join('ip_fabrication_items', 'ip_fabrication_items.fabrication_id = ip_fabrication.fabrication_id', 'left');
    }

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS
            ip_client_custom.*,
            ip_user_custom.*,
            ip_users.user_name,
			ip_users.user_company,
			ip_users.user_address_1,
			ip_users.user_address_2,
			ip_users.user_city,
			ip_users.user_state,
			ip_users.user_zip,
			ip_users.user_country,
			ip_users.user_phone,
			ip_users.user_fax,
			ip_users.user_code,
			ip_users.user_mobile,
			ip_users.user_email,
			ip_users.user_web,
			ip_users.user_vat_id,
			ip_users.user_tax_code,
			ip_clients.*,
			ip_devises.*,
			IFNULL(user_modif.user_id, '0') AS user_id_modif,
			IFNULL(user_modif.user_name, ' ') AS user_name_modif,
			IFNULL(ip_delai_paiement.delai_paiement_label, ' ') AS delai_paiement_label,
			ip_fabrication_ammont.fabrication_amount_id,
			IFNULL(ip_fabrication_ammont.fabrication_item_subtotal, '0.000') AS fabrication_item_subtotal,
			IFNULL(ip_fabrication_ammont.fabrication_item_tax_total, '0.000') AS fabrication_item_tax_total,
			IFNULL(ip_fabrication_ammont.fabrication_tax_total, '0.000') AS fabrication_tax_total,
			IFNULL(ip_fabrication_ammont.fabrication_total, '0.000') AS fabrication_total,
			IFNULL(ip_fabrication_ammont.timbre_fiscale, '0.000') AS timbre_fiscale,

			IFNULL(ip_fabrication_ammont.fabrication_pourcent_remise, '0.000') AS fabrication_pourcent_remise,
			IFNULL(ip_fabrication_ammont.fabrication_montant_remise, '0.000') AS fabrication_montant_remise,
			IFNULL(ip_fabrication_ammont.fabrication_pourcent_acompte, '0.000') AS fabrication_pourcent_acompte,
			IFNULL(ip_fabrication_ammont.fabrication_montant_acompte, '0.000') AS fabrication_montant_acompte,
			IFNULL(ip_fabrication_ammont.fabrication_total_final, '0.000') AS fabrication_total_final,
			IFNULL(ip_fabrication_ammont.fabrication_total_a_payer, '0.000') AS fabrication_total_a_payer,
			IFNULL(ip_fabrication_ammont.fabrication_item_subtotal_final, '0.000') AS fabrication_item_subtotal_final,
			IFNULL(ip_fabrication_ammont.fabrication_item_tax_total_final, '0.000') AS fabrication_item_tax_total_final,

			Date(ip_fabrication.fabrication_date_modified) as fabrication_date_modif,
			ip_fabrication.*", false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_fabrication.fabrication_id DESC');
    }

    public function validation_rules()
    {
        return array(
            'client_name' => array(
                'field' => 'client_name',
                'label' => lang('client'),
                'rules' => 'required',
            ),
            'quote_date_created' => array(
                'field' => 'quote_date_created',
                'label' => lang('quote_date'),
                'rules' => 'required',
            ),
            'fabrication_password' => array(
                'field' => 'quote_password',
                'label' => lang('quote_password'),
            ),
            'user_id' => array(
                'field' => 'user_id',
                'label' => lang('user'),
                'rule' => 'required',
            ),
            'fabrication_nature' => array(
                'field' => 'quote_nature',
                'label' => lang('quote_nature'),
                'rules' => '',
            ),
            'fabrication_delai_paiement' => array(
                'field' => 'quote_delai_paiement',
                'label' => lang('quote_delai_paiement'),
            ),
            'fabrication_date_accepte' => array(
                'field' => 'fabrication_date_accepte',
                'label' => lang('quote_date_accepte'),
            ),
            'quote_date_expires' => array(
                'field' => 'quote_date_expires',
                'label' => lang('expires'),
                'rules' => 'required',
            ),
            'langue' => array(
                'field' => 'langue',
                'label' => lang('langue'),
                'rules' => 'required',
            ),
        );
    }

    public function getTypepdf()
    {
        $query = $this->db->query("SELECT *  FROM `ip_settings`
        WHERE `setting_key` LIKE 'pdf_commande_template' AND `setting_value` LIKE 'avec entête'");
        $result = $query->result();
        $var = 0;
        if ($result) {
            return $var;
        } else {
            $var = $var + 1;
            return $var;
        };
    }

}