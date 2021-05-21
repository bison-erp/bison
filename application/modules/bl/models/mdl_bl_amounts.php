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

class Mdl_Bl_Amounts extends Response_Model
{

    public $table = 'ip_bl_ammont';
    public $primary_key = 'ip_bl_ammont.bl_amount_id'; 
    public function default_join()
    {
       // $this->db->join('ip_bl_item_amounts', 'ip_bl_item_amounts.item_id = ip_bl_ammont.client_id'); 
    }
 
    public function default_order_by()
    {
        $this->db->order_by('ip_bl_ammont.bl_amount_id DESC');
    }
 

}
