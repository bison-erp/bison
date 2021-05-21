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

class Mdl_Stockmvt extends Response_Model
{

    public $table = 'ip_products_mvtstock';
    public $primary_key = 'ip_products_mvtstock.products_mvtstock_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *,SUM(ip_products_mvtstock.stock_actuelle) as sumstckactuel,SUM(ip_products_mvtstock.stock_virtuelle) as sumstckvirt', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_products_mvtstock.products_mvtstock_id');
    }

    public function default_join()
    {  
       
        $this->db->join('ip_stock', 'ip_stock.ref_stock = ip_products_mvtstock.reference_stock', 'left');    
        $this->db->join('ip_products', 'ip_products.product_id = ip_stock.produit_id  ', 'left');    
      
    }
 
    public function create($db_array = null)
    {

        $stock_id = parent::save(null, $db_array); 

        return $stock_id;
    } 

  }