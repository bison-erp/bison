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

class Mdl_depensemontant extends Response_Model
{

    public $table = 'ip_depense_montant';
    public $primary_key = 'ip_depense_montant.id_depense_montant';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    } 
    public function getMontantdepense($id)
    {        
        $this->db->where('id_depense', $id);
        return $this->db->get('ip_depense_montant')->result();
    }  
    public function getDepenseagenda($id)
    {
        $this->db->where('ip_depense_montant.id_depense', $id);
        $this->db->join('ip_depense', 'ip_depense_montant.id_depense = ip_depense.id_depense', 'left');
        $this->db->join('ip_fournisseurs', 'ip_fournisseurs.id_fournisseur = ip_depense.id_fournisseur', 'left');
        return $this->db->get('ip_depense_montant')->result();
    }
}