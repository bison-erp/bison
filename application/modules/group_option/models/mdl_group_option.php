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

class Mdl_Group_Option extends Response_Model
{

    public $table = 'ip_groupe_option';
    public $primary_key = 'ip_groupe_option.group_id';
    public $validation_rules = 'validation_rules';
    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
    public function default_order_by()
    {
        $this->db->order_by('ip_groupe_option.group_id');
    }
    public function default_join()
    {  
        $this->db->join('ip_type_groupe', 'ip_type_groupe.type_id = ip_groupe_option.id_type_groupe', 'left');
       // $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_products.tax_rate_id', 'left');       
    }
    public function validation_rules()
    {   

        return array(           
            'id_type_groupe' => array(
                'field' => 'id_type_groupe',
            //    'label' => lang('marge'),
                'rules' => 'required',
            ),   
           'name' => array(
                'field' => 'name',
              //  'label' => lang('product_sku'),
              'rules' => 'required',
            ),      
        );
    } 

    public function create($db_array = null)
    { 
        $id = parent::save(null, $db_array);

        return $id;
    }

    public function getAttribut($id)
    {       
        return $this->mdl_option_attribut->where('id_group_option', $id)->get()->result();
    }  
}