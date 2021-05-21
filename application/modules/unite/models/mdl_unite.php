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

class Mdl_unite extends Response_Model
{

    public $table = 'ip_unite';
    public $primary_key = 'ip_unite.id_unite';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_unite.designation');
    }

    public function by_unite($match)
    {
        $this->db->like('designation', $match);
    }

    public function validation_rules()
    {
        return array(
            'designation' => array(
                'field' => 'designation',
                'label' => 'Désignation', //,
                //'rules' => 'required'
            ),
        );
    }

}