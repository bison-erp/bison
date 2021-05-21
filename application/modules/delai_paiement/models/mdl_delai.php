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

class Mdl_Delai extends Response_Model
{
    public $table = 'ip_delai_paiement';
    public $primary_key = ' ip_delai_paiement.delai_paiement_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_delai_paiement.delai_paiement_label');
    }

   

    public function by_delai_paiement($match)
    {
        $this->db->like('delai_paiement_label', $match);
    }

    public function validation_rules()
    {
        return array(
            
            'delai_paiement_label' => array(
                'field' => 'delai_paiement_label',
                'label' => lang('delai_paiement_label'),
                'rules' => 'required'
            ),
            
			
          

        );
    }

}
