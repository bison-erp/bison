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

class Mdl_Fournisseurs extends Response_Model
{

    public $table = 'ip_fournisseurs';
    public $primary_key = 'ip_fournisseurs.id_fournisseur';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_fournisseurs.raison_social_fournisseur');
    }

    public function validation_rules()
    {
        return array(
            'raison_social_fournisseur' => array(
                'field' => 'raison_social_fournisseur',
                'label' => lang('raison_social_fournisseur'),
                'rules' => 'required',
            ),
            'adresse_fournisseur' => array(
                'field' => 'adresse_fournisseur',
                'label' => lang('adresse_fournisseur'),
                'rules' => '',
            ),
            'adresse2_fournisseur' => array(
                'field' => 'adresse2_fournisseur',
                'label' => lang('adresse2_fournisseur'),
                'rules' => '',
            ),
            'code_postal_fournisseur' => array(
                'field' => 'code_postal_fournisseur',
                'label' => lang('code_postal_fournisseur'),
                //   'rules' => 'required',
            ),
            'code_postal2_fournisseur' => array(
                'field' => 'code_postal2_fournisseur',
                'label' => lang('code_postal_fournisseur'),
            ),
            'ville_fournisseur' => array(
                'field' => 'ville_fournisseur',
                'label' => lang('ville_fournisseur'),
                // 'rules' => 'required',
            ),
            'ville2_fournisseur' => array(
                'field' => 'ville2_fournisseur',
                'label' => lang('ville_fournisseur'),
            ),
            'pays_fournisseur' => array(
                'field' => 'pays_fournisseur',
                'label' => lang('pays_fournisseur'),
                'rules' => 'required',
            ),
            'pays2_fournisseur' => array(
                'field' => 'pays2_fournisseur',
                'label' => lang('pays_fournisseur'),
            ),
            'site_web_fournisseur' => array(
                'field' => 'site_web_fournisseur',
                'label' => lang('site_web_fournisseur'),
                // 'rules' => 'required',
            ),
            'mail_fournisseur' => array(
                'field' => 'mail_fournisseur',
                'label' => lang('mail_fournisseur'),
                'rules' => 'required',
            ),
            'tel_fournisseur' => array(
                'field' => 'tel_fournisseur',
                'label' => lang('tel_fournisseur'),
                // 'rules' => 'required',
            ),
            'tel2_fournisseur' => array(
                'field' => 'tel2_fournisseur',
                'label' => lang('tel2_fournisseur'), //,
                //'rules' => 'required'
            ),
            'fax_fournisseur' => array(
                'field' => 'fax_fournisseur',
                'label' => lang('fax_fournisseur'),
                // 'rules' => 'required',
            ),
            'note_fournisseur' => array(
                'field' => 'note_fournisseur',
                'label' => lang('note_fournisseur'), //,
                //'rules' => 'required'
            ),
            'ip_categorie_fournisseur' => array(
                'field' => 'ip_categorie_fournisseur',
                'label' => 'ip_categorie_fournisseur', //,
                //'rules' => 'required'
            ),
            'nom' => array(
                'field' => 'nom',
                'label' => lang('nom'), //,
                //'rules' => 'required'
            ),
            'prenom' => array(
                'field' => 'prenom',
                'label' => lang('prenom'), //,
                //'rules' => 'required'
            ),
            'id_devise' => array(
                'field' => 'id_devise',
                'label' => lang('id_devise'), //,
                //'rules' => 'required'
            ),
            'mobile' => array(
                'field' => 'mobile',
                'label' => lang('mobile_fournisseur'), //,
                //'rules' => 'required'
            ),
            'refence' => array(
                'field' => 'refence',
                'label' => lang('reference_fournisseur'), //,
                //'rules' => 'required'
            ),
            'matricule' => array(
                'field' => 'matricule',
                'label' => lang('matricule_fournisseur'), //,
                //'rules' => 'required'
            ),
            'id_user' => array(
                'field' => 'id_user',
                'label' => '', //,
                //'rules' => 'required'
            ),
        );
    }

    public function by_nom_fournisseur($id)
    {
        $this->filter_where('id_fournisseur', $id);
        return $this;
    }

    public function by_fournisseur($match)
    {
        $this->db->like('raison_social_fournisseur', $match);
        $this->db->or_like('prenom', $match);
        $this->db->or_like('nom', $match);
    }

}