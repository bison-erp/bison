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

class Mdl_Commande_Achat extends Response_Model
{
    public $table = 'ip_commande_achat';
    public $primary_key = 'ip_commande_achat.commande_achat_id';
    public $date_created_field = 'commande_achats_date_created';
    public $date_modified_field = 'commande_achats_date_modified';

    public function default_join()
    {
        $this->db->join('ip_fournisseurs', 'ip_fournisseurs.id_fournisseur = ip_commande_achat.fournisseur_id', 'left');
        $this->db->join('ip_devises', 'ip_fournisseurs.id_devise = ip_devises.devise_id', 'left');
        $this->db->join('ip_delai_paiement', 'ip_commande_achat.commande_achat_delai_paiement = ip_delai_paiement.delai_paiement_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_commande_achat.user_id');
        $this->db->join('ip_users as user_modif', 'user_modif.user_id = ip_commande_achat.commande_achat_user_modif', 'left');
        $this->db->join('ip_commande_achats_ammont', 'ip_commande_achats_ammont.commande_achats_id = ip_commande_achat.commande_achat_id', 'left');
        $this->db->join('ip_user_custom', 'ip_user_custom.user_id = ip_users.user_id', 'left');
        // $this->db->join('ip_quote_custom', 'ip_quote_custom.quote_id = ip_quotes.quote_id', 'left');
        $this->db->join('ip_commande_achat_items', 'ip_commande_achat_items.commande_achat_id = ip_commande_achat.commande_achat_id', 'left');
    }

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS 
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
			ip_fournisseurs.*,
			ip_devises.*,
			IFNULL(user_modif.user_id, '0') AS user_id_modif,
			IFNULL(user_modif.user_name, ' ') AS user_name_modif,
			IFNULL(ip_delai_paiement.delai_paiement_label, ' ') AS delai_paiement_label,
			ip_commande_achats_ammont.commande_achats_amount_id,
			IFNULL(ip_commande_achats_ammont.commande_achats_item_subtotal, '0.000') AS commande_achats_item_subtotal,
			IFNULL(ip_commande_achats_ammont.commande_achats_item_tax_total, '0.000') AS commande_achats_item_tax_total,
			IFNULL(ip_commande_achats_ammont.commande_achats_tax_total, '0.000') AS commande_achats_tax_total,
			IFNULL(ip_commande_achats_ammont.commande_achats_total, '0.000') AS commande_achats_total,
			IFNULL(ip_commande_achats_ammont.timbre_fiscale, '0.000') AS timbre_fiscale,

			IFNULL(ip_commande_achats_ammont.commande_achats_pourcent_remise, '0.000') AS commande_achats_pourcent_remise,
			IFNULL(ip_commande_achats_ammont.commande_achats_montant_remise, '0.000') AS commande_achats_montant_remise,
			IFNULL(ip_commande_achats_ammont.commande_achats_pourcent_acompte, '0.000') AS commande_achats_pourcent_acompte,
			IFNULL(ip_commande_achats_ammont.commande_achats_montant_acompte, '0.000') AS commande_achats_montant_acompte,
			IFNULL(ip_commande_achats_ammont.commande_achats_total_final, '0.000') AS commande_achats_total_final,
			IFNULL(ip_commande_achats_ammont.commande_achats_total_a_payer, '0.000') AS commande_achats_total_a_payer,
			IFNULL(ip_commande_achats_ammont.commande_achats_item_subtotal_final, '0.000') AS commande_achats_item_subtotal_final,
			IFNULL(ip_commande_achats_ammont.commande_achats_item_tax_total_final, '0.000') AS commande_achats_item_tax_total_final,

			Date(ip_commande_achat.commande_achat_date_modified) as commande_achats_date_modif,
			ip_commande_achat.*", false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_commande_achat.commande_achat_id DESC');
    }

    public function validation_rules()
    {
        return array( 
            'fournisseur_id' => array(
                'field' => 'fournisseur_id',
                'label' => lang('Fournisseur'),
                'rule' => 'required',
            ),
            'commande_achat_date_created' => array(
                'field' => 'commande_achat_date_created',
                'label' => lang('quote_date'),
                'rules' => 'required',
            ),
            'commande_achat_status_id' => array(
                'field' => 'commande_achat_status_id',
                'label' => lang('status'),
                'rules' => 'required',
            ),
            'commande_achat_password' => array(
                'field' => 'commande_achat_password',
                'label' => lang('quote_password'),
            ),
            'user_id' => array(
                'field' => 'user_id',
                'label' => lang('user'),
                'rule' => 'required',
            ),
            'commande_achat_nature' => array(
                'field' => 'commande_achat_nature',
                'label' => lang('quote_nature'),
                'rules' => '',
            ),
            'commande_achat_delai_paiement' => array(
                'field' => 'quote_delai_paiement',
                'label' => lang('quote_delai_paiement'),
            ),
            'commande_achat_date_accepte' => array(
                'field' => 'commande_achat_date_accepte',
                'label' => lang('quote_date_accepte'),
            ),
            'commande_achat_date_expires' => array(
                'field' => 'commande_achat_date_expires',
                'label' => lang('expires'),
                'rules' => 'required',
            ),
            'langue' => array(
                'field' => 'langue',
                'label' => lang('langue'),
                'rules' => 'required',
            ),
            'commande_achat_number' => array(
                'field' => 'commande_achat_number', 
                'rules' => '',
            ),
            'note' => array(
                'field' => 'note', 
                'rules' => '',
            ),
        );
    } 

}