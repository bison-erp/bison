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

class Mdl_commande_achat_Items extends Response_Model
{
    public $table = 'ip_commande_achat_items';
    public $primary_key = 'ip_commande_achat_items.item_id';
    public $date_created_field = 'item_date_added';

    public function default_select()
    {
        $this->db->select('ip_commande_achat_item_amounts.*, ip_commande_achat_items.*, item_tax_rates.tax_rate_percent AS item_tax_rate_percent');
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_commande_achat_items.item_order');
    }

    public function default_join()
    {
        $this->db->join('ip_commande_achat_item_amounts', 'ip_commande_achat_item_amounts.item_id = ip_commande_achat_items.item_id', 'left');
        $this->db->join('ip_tax_rates AS item_tax_rates', 'item_tax_rates.tax_rate_id = ip_commande_achat_items.item_tax_rate_id', 'left');
    }

    public function validation_rules()
    {
        return array(
            'commande_achat_id' => array(
                'field' => 'commande_achat_id',
                'label' => lang('quote'),
                'rules' => 'required',
            ),
            'item_code' => array(
                'field' => 'item_code',
                'label' => lang('item_code'),
                'rules' => 'required',
            ),
            'item_name' => array(
                'field' => 'item_name',
                'label' => lang('item_name'),
                'rules' => '',
            ),
            'item_description' => array(
                'field' => 'item_description',
                'label' => lang('description'),
            ),
            'item_quantity' => array(
                'field' => 'item_quantity',
                'label' => lang('quantity'),
                'rules' => 'required',
            ),
            'item_price' => array(
                'field' => 'item_price',
                'label' => lang('price'),
                'rules' => 'required',
            ),
            'item_tax_rate_id' => array(
                'field' => 'item_tax_rate_id',
                'label' => lang('item_tax_rate'),
            ),
            'etat_champ' => array('field' => 'etat_champ'),
        );
    }
}