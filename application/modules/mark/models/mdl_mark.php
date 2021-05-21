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

class Mdl_mark extends Response_Model
{

    public $table = 'ip_mark';
    public $primary_key = 'ip_mark.id_mark ';
    //public $ip_product = 'id_poduct';
    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
    public function default_order_by()
    {
        $this->db->order_by('ip_mark.id_mark');
    }

    public function validation_rules()
    {
        return array(
            'name_mark' => array(
                'field' => 'name_mark',
                'label' => 'designation',
                'rules' => 'required',
        
            ),
        );
    }

    public function by_mark($match)
    {
        $this->db->like('name_mark', $match);
        $this->db->or_like('id_mark', $match);		
    } 
    public function by_id_mark($id)
    {
        $this->filter_where('id_mark', $id);
        return $this;
    }
    public function by_name($id)
    {
        $this->filter_where('name_mark', $id);
        return $this;
    }


}