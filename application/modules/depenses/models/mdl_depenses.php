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

class Mdl_depenses extends Response_Model
{

    public $table = 'ip_depense';
    public $primary_key = 'ip_depense.id_depense';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
    public function default_join()
    {
        $this->db->join('ip_fournisseurs', 'ip_fournisseurs.id_fournisseur = ip_depense.id_fournisseur', 'left');
    }

    public function validation_rules()
    {
        return array(
            'id_fournisseur' => array(
                'field' => 'id_fournisseur',
                'label' => 'Fournisseur',
                'rules' => 'required',
            ),
            'num_facture' => array(
                'field' => 'num_facture',
               // 'label' => 'numéro facture',
                'rules' => 'required',
            ),
            'date_paiement' => array(
                'field' => 'date_paiement',
                'label' => 'Date paiement',
                'rules' => 'required',
            ),
           'date_due' => array(
                'field' => 'date_due',                 
            ),
            'montant_facture' => array(
                'field' => 'montant_facture',
                'label' => 'Montant facture',
                'rules' => 'required',
            ),
            'date_facture' => array(
                //'field' => 'date_facture',
                //'label' => 'Date facture',
                'rules' => '',
            ),
            'id_moyenpayement' => array(
                'field' => 'id_moyenpayement',
                'label' => 'Moyen de payement',
                'rules' => 'required',
            ),
            'note' => array(
                'field' => 'note',
                'label' => 'Note',
                'rules' => ' ',
            ),
            'id_user' => array(
                'field' => 'id_user',
                'label' => 'id_user',
                'rules' => ' ',
            ),
            'numero_cheque' => array(
                'field' => 'numero_cheque',
                'label' => 'Numéro chéque',
                'rules' => ' ',
            ),
            'montant_tva' => array(
                'field' => 'montant_tva',
                'label' => 'Montant tva',
                //  'rules' => 'required',
            ),
            'droit_timbre' => array(
                'field' => 'droit_timbre',
                'label' => 'Montant facture',
                //  'rules' => 'required',
            ),
            'net_payer' => array(
                'field' => 'net_payer',
                'label' => 'Net payer',
                'rules' => 'required',
            ),
            'retained_source' => array(
                'field' => 'retained_source',
                'label' => '',
                'rules' => '',
            ),
            'id_retained_source' => array(
                'field' => 'id_retained_source',
                'label' => '',
               
            ),
            'id_rate' => array(
                'field' => '',
                'label' => '',
              
            ),
            'mnt_rs' => array(
                'field' => '',
                'label' => '',
              
            ),
            'diffusion' => array(
                'field' => '',
                'label' => '',
                
            ),
            'divussion_ch' => array(
                'field' => '',
                'label' => '',
                
            ),
            'net_payer_depense' => array(
                'field' => '',
                'label' => '',
                
            ),
            'rest' => array(
                'field' => '',
                'label' => '',
                
            ),
            'categorie_id' => array(
                'field' => '',
                'rules' => 'required',
                
            ),
            'status_id' => array(
                'field' => '',
                'label' => '',
                
            ),
            'ret_source' => array(
                'field' => '',
                'label' => '',
                
            ),
        );
    }

    public function create($db_array = null)
    { 
        $id = parent::save(null, $db_array);

        return $id;
    }

}