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

class Mdl_Droits extends Response_Model {

    public $table = 'ip_droits';
    public $primary_key = 'ip_droits.id_droit';

    public function default_select() {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by() {
        $this->db->order_by('ip_droits.id_droit');
    }

    

    public function validation_rules() {
        return array(
            'nom' => array(
                'field' => 'nom',
               // 'label' => lang('designation'),
                'rules' => ''
            ),
            'action' => array(
                'field' => 'action',
                //'label' => lang('adresse_fournisseur'),
                'rules' => ''
            ),
            'groupes_user_id' => array(
                'field' => 'groupes_user_id',
                //'label' => lang('adresse_fournisseur'),
                'rules' => ''
            ),
        );
    }

}
