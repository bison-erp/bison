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

class Mdl_Groupes_users extends Response_Model {

    public $table = 'ip_groupes_users';
    public $primary_key = 'ip_groupes_users.groupes_user_id';

    public function default_select() {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by() {
        $this->db->order_by('ip_groupes_users.groupes_user_id');
    }



    public function by_fournisseur($match) {
        $this->db->like('designation', $match);
    }

    public function validation_rules() {
        return array(
            'designation' => array(
                'field' => 'designation',
                'label' => lang('designation'),
                'rules' => 'required'
            ),
            'etat' => array(
                'field' => 'etat',
                //'label' => lang('adresse_fournisseur'),
                'rules' => ''
            ),
        );
    }

}
