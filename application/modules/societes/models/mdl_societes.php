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

class Mdl_Societes extends Response_Model {

    public $table = 'ip_societes';
    public $primary_key = 'ip_societes.id_societes';

    public function default_select() {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by() {
        $this->db->order_by('ip_societes.raison_social_societes');
    }

    public function by_societes($match) {
        $this->db->like('raison_social_societes', $match);
    }

    public function validation_rules() {
        return array(
            'raison_social_societes' => array(
                'field' => 'raison_social_societes',
                'label' => lang('raison_social_societes'),
                'rules' => 'required'
            ),
            'code_tva_societes' => array(
                'field' => 'code_tva_societes',
                'label' => lang('code_tva_societes'),
                'rules' => 'required'
            ),
            'tax_code' => array(
                'field' => 'tax_code',
                'label' => lang('tax_code'),
                'rules' => ''
            ),
            'site_web_societes' => array(
                'field' => 'site_web_societes',
                'label' => lang('site_web_societes'),
                'rules' => ''
            ),
            'mail_societes' => array(
                'field' => 'mail_societes',
                'label' => lang('mail_societes'),
                'rules' => 'required'
            ),
            'fax_societes' => array(
                'field' => 'fax_societes',
                'label' => lang('fax_societes'),
                'rules' => ''
            ),
            'note_societes' => array(
                'field' => 'note_societes',
                'label' => lang('note_societes')//,
            //'rules' => 'required'
            ),
            'adresse_societes' => array(
                'field' => 'adresse[0]',
                'label' => "Adresse",
                'rules' => 'required'
            ),
        );
    }

}
