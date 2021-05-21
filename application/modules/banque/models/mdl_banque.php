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

class Mdl_banque extends Response_Model
{
    public $table = 'ip_banque';
    public $primary_key = 'ip_banque.id_banque';
    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
    public function default_order_by()
    {
        $this->db->order_by('ip_banque.nom_banque');
    }

    public function validation_rules()
    {
        return array(
            'designation' => array(
                'field' => 'nom_banque',
                'label' => 'Nom banque',
                'rules' => 'required',
            ),
        );
    }

    public function by_banque($match)
    {
        $this->db->like('nom_banque', $match);
    }

}