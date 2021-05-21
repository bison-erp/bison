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

class Mdl_Depot_Stock extends Response_Model
{

    public $table = 'ip_deopt_stock';
    public $primary_key = 'ip_deopt_stock.deopt_stock_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_deopt_stock.deopt_stock_id');
    }

    public function default_join()
    {
        $this->db->join('ip_stock', 'ip_deopt_stock.stock_id = ip_stock.stock_id', 'left');     
        $this->db->join('ip_depot', 'ip_deopt_stock.depot_id = ip_depot.id_depot', 'left');     
    }
     
    public function create($db_array = null)
    {

        $stock_id = parent::save(null, $db_array);

        // Create an quote amount record

        return $stock_id;
    } 
}