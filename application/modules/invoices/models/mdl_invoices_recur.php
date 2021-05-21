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

class Mdl_Invoices_Recur extends Response_Model
{
    public $table = 'ip_invoice_recur';
    public $primary_key = 'ip_invoice_recur.invoice_recur_id'; 

    public function default_join()
    {
        $this->db->join('ip_invoices', 'ip_invoices.invoice_id = ip_invoice_recur.invoice_id');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id');
    }

    public function save($data)
    {
        $this->db->insert('ip_invoice_recur', $data);
    }

    public function deleterecur($id)
    {  
        $this->db->where('id_invoice', $id);
        $this->db->delete('ip_invoice_recur');
    }

    public function nextdate($date,$i){
        $arr=array(1=>'+1 month',2=>'+3 month',3=>'+1 year');      
       // $date='2020-01-30';
        $date_result=date('Y-m-d', strtotime($arr[$i], strtotime($date)));
        return $date_result;
    }

}
