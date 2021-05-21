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

class Mdl_productfile extends Response_Model
{

    public $table = 'ip_file_product';
    public $primary_key = 'ip_file_product.id_file_product';
    //public $ip_product = 'id_poduct';
    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function getfile($id){
        $this->db->select('name_file');
        $this->db->where('ip_products.product_id',$id);
        $this->db->join('ip_products', 'ip_products.product_id = ip_file_product.id_poduct', 'left');
        $ip_file_product = $this->db->get("ip_file_product")->result();
        return $ip_file_product;
    }

}