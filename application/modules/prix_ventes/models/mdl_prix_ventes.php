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

class Mdl_Prix_ventes extends Response_Model
{
    public $table = 'ip_prix_ventes';
    public $primary_key = 'ip_prix_ventes.id_prix_ventes';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_prix_ventes.prix_vente');
    }

    public function default_join() {
        $this->db->join('ip_products', 'ip_products.product_id  = ip_prix_ventes.id_products','left');
        $this->db->join('ip_devises', 'ip_devises.devise_id  = ip_prix_ventes.id_devise','left');
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id  = ip_prix_ventes.id_tax','left');
    }
    public function by_piece($match)
    {
        $this->db->like('prix_vente', $match);
    }

    public function validation_rules()
    {
        return array(
            
            'prix_vente' => array(
                'field' => 'prix_vente',
                'label' => lang('prix_vente'),
                'rules' => ''
            ),
			
          

        );
    }

}
