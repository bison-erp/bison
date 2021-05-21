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

class Mdl_Quote_Rappel extends Response_Model {

    public $table = 'ip_quote_date_rappel';
    public $primary_key = 'ip_quote_date_rappel.rappel_id';

    public function default_select() {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by() {
        $this->db->order_by('ip_quote_date_rappel.rappel_date');
    }

    public function by_quote($match) {
        $this->db->like('rappel_qote_id', $match);
    }

    public function create($db_array = NULL) {

        $rappel_id = parent::save(NULL, $db_array);
        return $rappel_id;
    }

    public function deleteDateQuote($id_quote) {


        $this->db->where('rappel_qote_id', $id_quote);
        $this->db->delete('ip_quote_date_rappel');
    }

    public function selectRappelAujourdui() {

        $this->db->select('quote_id,client_email');
        $this->db->from('ip_quote_date_rappel');
        $this->db->join('ip_quotes', 'ip_quotes.quote_id = ip_quote_date_rappel.rappel_qote_id');
        $this->db->join('ip_clients', 'ip_quotes.client_id = ip_clients.client_id');
        $this->db->where('rappel_status', 0);
        $toDayArray = getdate();
        $toDay = $toDayArray['mday'] . '/' . $toDayArray['mon'] . '/' . $toDayArray['year'];
        $this->db->where('rappel_date', date_to_mysql($toDay));
        $this->db->where_in('quote_status_id', array(1, 2, 3));

        return $this->db->get()->result();
    }

    public function selectRappel() {

        $this->db->select('*');
        $this->db->from('ip_quote_date_rappel');
        $this->db->join('ip_quotes', 'ip_quotes.quote_id = ip_quote_date_rappel.rappel_qote_id');
        $this->db->join('ip_clients', 'ip_quotes.client_id = ip_clients.client_id');
        // $this->db->where('rappel_status', 0);
        $this->db->order_by('ip_quote_date_rappel.rappel_date', 'desc');

        $toDayArray = getdate();
        $toDay = $toDayArray['mday'] . '/' . $toDayArray['mon'] . '/' . $toDayArray['year'];
        //$this->db->where('rappel_date', date_to_mysql($toDay));
        //$this->db->where_in('quote_status_id', array(1, 2, 3));

        return $this->db->get()->result();
    }

    public function getRappelQuote($quote_id) {
        $this->db->select('*');
        $this->db->from('ip_quote_date_rappel');
        $this->db->where('rappel_qote_id', $quote_id);
        $this->db->where('rappel_type', 'quote');
        return $this->db->get()->result();
    }

    public function getRappelInvoice($quote_id) {
        $this->db->select('*');
        $this->db->from('ip_quote_date_rappel');
        $this->db->where('rappel_qote_id', $quote_id);
        $this->db->where('rappel_type', 'invoice');
        return $this->db->get()->result();
    }

    public function validation_rules() {
        return array(
            'rappel_qote_id' => array(
                'field' => 'rappel_qote_id',
                'label' => lang('rappel_qote_id'),
                'rules' => 'required'
            ),
            'rappel_date' => array(
                'field' => 'rappel_date',
                'label' => lang('rappel_date'),
                'rules' => ''
            ),
            'rappel_status' => array(
                'field' => 'rappel_status',
                'label' => lang('rappel_status'),
                'rules' => 'required'
            ),
        );
    }

}
