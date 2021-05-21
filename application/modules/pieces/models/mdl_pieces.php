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

class Mdl_Pieces extends Response_Model
{
    public $table = 'ip_pieces';
    public $primary_key = 'ip_pieces.id_piece';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_pieces.num_piece');
    }

    public function default_join() {
        $this->db->join('ip_payments', 'ip_payments.payment_id = ip_pieces.payment_id','left');
    }
    public function by_piece($match)
    {
        $this->db->like('num_piece', $match);
    }

    public function validation_rules()
    {
        return array(
            
            'num_piece' => array(
                'field' => 'num_piece',
                'label' => lang('reference'),
                'rules' => 'required'
            ),
            'montant' => array(
                'field' => 'montant',
                'label' => lang('montant_cheq'),
                'rules' => ''
            ),
            'echeance' => array(
                'field' => 'echeance',
                'label' => lang('due_date'),
                'rules' => 'required'
            ),
            ' proprietaire' => array(
                'field' => 'proprietaire',
                'label' => lang('proprietaire'),
                'rules' => ''
            ),
            'banque' => array(
                'field' => 'banque',
                'label' => lang('banque'),
                'rules' => 'required'
            ),
			
          

        );
    }

}
