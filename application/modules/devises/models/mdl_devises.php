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

class Mdl_Devises extends Response_Model
{
    public $table = 'ip_devises';
    public $primary_key = 'ip_devises.devise_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_devises.devise_label');
    }

   

    public function by_devise($match)
    {
        $this->db->like('devise_label', $match);
    }

    public function validation_rules()
    {
        return array(
            
            'devise_label' => array(
                'field' => 'devise_label',
                'label' => lang('devise_label'),
                'rules' => 'required'
            ),
            'devise_symbole' => array(
                'field' => 'devise_symbole',
                'label' => lang('devise_symbole'),
                'rules' => 'required'
            ),
            'taux' => array(
                'field' => 'taux',
                'label' => lang('taux'),
                'rules' => 'required'
            ),
            'symbole_placement' => array(
                'field' => 'symbole_placement'
            ),
            'number_decimal' => array(
                'field' => 'number_decimal'
            ),
            'thousands_separator' => array(
                'field' => 'thousands_separator'
            ),
			
          

        );
    }

}
