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

class Mdl_categorie_fournisseur extends Response_Model
{

    public $table = 'ip_categorie_fournisseur';
    public $primary_key = 'ip_categorie_fournisseur.id_categorie_fournisseur ';
    //public $ip_product = 'id_poduct';
    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
    public function default_order_by()
    {
        $this->db->order_by('ip_categorie_fournisseur.designation');
    }

    public function validation_rules()
    {
        return array(
            'designation' => array(
                'field' => 'designation',
                'label' => 'designation',
                'rules' => 'required',
            ),
            'ret_source' => array(
                'field' => 'ret_source',
                'label' => lang('ret_source'),
                'rules' => 'required',
            ),
        );
    }

    public function by_categorie($match)
    {
        $this->db->like('designation', $match);
        $this->db->or_like('ret_source', $match);
    } 

    public function by_id_categorie($id)
    {
        $this->filter_where('id_fournisseur', $id);
        return $this;
    }

    public function by_designation($id)
    {
        $this->filter_where('id_categorie_fournisseur', $id);
        return $this;
    }


}