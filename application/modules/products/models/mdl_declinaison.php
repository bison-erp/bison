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

class Mdl_Declinaison extends Response_Model
{

    public $table = 'ip_declinaison';
    public $primary_key = 'ip_declinaison.id_declinaisonproduit';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_declinaison.id_declinaisonproduit');
    }

    public function default_join()
    {
        $this->db->join('ip_products', 'ip_declinaison.id_produit = ip_products.product_id', 'left');     
		$this->db->join('ip_groupe_option', 'ip_declinaison.id_group_option = ip_groupe_option.group_id', 'left');     
		$this->db->join('ip_option_attribut', 'ip_declinaison.id_attributs = ip_option_attribut.id_option_attribut', 'left');     
   }
 
    public function create($db_array = null)
    {

        $id_declinaisonproduit = parent::save(null, $db_array);
        return $id_declinaisonproduit;
    } 

    public function trouve($id,$attributs,$option)
    {
        $decl=  $this->db
            ->from('ip_declinaison')
            ->where('ip_declinaison.id_group_option',$option)
            ->Where('id_attributs',$attributs)
            ->Where('dec_stock_id', $id)
        ->get()->num_rows();     
        return $decl ;          
    }
   
}