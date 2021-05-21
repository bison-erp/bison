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

class Mdl_Groupe_Option extends Response_Model
{

    public $table = 'ip_groupe_option';
    public $primary_key = 'ip_groupe_option.group_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
    public function default_join()
    {
        $this->db->join('ip_type_groupe', 'ip_type_groupe.type_id = ip_groupe_option.id_type_groupe');
    }
    public function validation_rules()
    {   

        return array(
            'name' => array(
                'field' => 'name',
              //  'label' => lang('product_sku'),
              //  'rules' => $product_sku,
            ),
            'type' => array(
                'field' => 'type',
            //    'label' => lang('marge'),
            //    'rules' => '',
            ),         
        );
    }

    public function create($db_array = null)
    { 
        $groupe_option = parent::save(null, $db_array);
  
        return $groupe_option;
    }
 
}