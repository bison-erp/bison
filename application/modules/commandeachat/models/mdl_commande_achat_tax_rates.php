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

class Mdl_Commande_Achat_Tax_Rates extends Response_Model
{
    public $table = 'ip_commande_achat_tax_rates';
    public $primary_key = 'ip_commande_achat_tax_rates.commande_tax_rate_id';

    public function default_select()
    {
        $this->db->select('ip_tax_rates.tax_rate_name AS quote_tax_rate_name');
        $this->db->select('ip_tax_rates.tax_rate_percent AS quote_tax_rate_percent');
        $this->db->select('ip_commande_achat_tax_rates.*');
    }

    public function default_join()
    {
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_commande_achat_tax_rates.tax_rate_id');
    } 

    public function validation_rules()
    {
        return array(
            'commande_achat_id' => array(
                'field' => 'commande_achat_id',
                'label' => lang('quote'),
                'rules' => 'required',
            ),
            'tax_rate_id' => array(
                'field' => 'tax_rate_id',
                'label' => lang('tax_rate'),
                'rules' => 'required',
            ),
            'include_item_tax' => array(
                'field' => 'include_item_tax',
                'label' => lang('tax_rate_placement'),
                'rules' => 'required',
            ),
        );
    }

}