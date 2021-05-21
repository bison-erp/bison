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

class Mdl_Tarif extends Response_Model
{

    public $table = 'ip_tarif';
    public $primary_key = 'ip_tarif.tarif_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_tarif.tarif_id');
    }

    public function default_join()
    {
        $this->db->join('ip_products', 'ip_products.product_id = ip_tarif.product_id', 'left');     
    }
 
    public function create($db_array = null)
    {

        $tarif_id = parent::save(null, $db_array);

        // Create an quote amount record

        return $tarif_id;
    } 
}