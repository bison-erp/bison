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

class Mdl_Activites extends Response_Model {

    public $table = 'ip_activites';
    public $primary_key = 'ip_activites.activite_id';

    public function default_select() {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by() {
        $this->db->order_by('ip_activites.descrip');
    }

    public function by_activite($match) {
        $this->db->like('descri', $match);
    }

    public function validation_rules() {
        return array(
            'descrip' => array(
                'field' => 'descri',
                'label' => lang('product_description2'),
                'rules' => 'required'
            )
        );
    }

}
