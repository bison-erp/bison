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

class Mdl_Clients extends Response_Model
{

    public $table = 'ip_clients';
    public $primary_key = 'ip_clients.client_id';
    public $date_created_field = 'client_date_created';
    public $date_modified_field = 'client_date_modified';
    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS ip_client_custom.*, ip_clients.*', false);
    }

    public function default_join()
    {
        $this->db->join('ip_client_custom', 'ip_client_custom.client_id = ip_clients.client_id', 'left');
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_clients.client_name');
    }

    public function validation_rules()
    {
        $client_societe = $this->input->post('client_societe');
        $client_devise_id = $this->input->post('client_devise_id');
//if(trim($client_societe) == '' || $client_devise_id != 1){ $ste1 = ''; } else{ $ste1='required'; }
        //if(trim($client_societe) == ''){ $ste2 = ''; } else{ $ste2='required'; }

        $client_phone = $this->input->post('client_phone');
        $client_mobile = $this->input->post('client_mobile');
        $client_email = trim($this->input->post('client_email'));
        $client_societe = trim($this->input->post('client_societe'));
        $contact_type = trim($this->input->post('contact_type'));
        $id_client = $this->input->post('id_client');

        if (trim($client_societe) == '' && trim($client_mobile) == '') {
            $required_tel = 'required';
        } else {
            $required_tel = 'required';
        }         
        $rule_email = 'required';
        $rule_societe = '';
        $required_contact_type = '';
      //  return var_dump($contact_type);die('hh');
//        $where = "(client_id <> '$id_client') AND(trim(client_email) = '".$client_email."' OR trim(client_societe) = '".$client_societe."')";
        //        $this->db->where($where);
        $this->db->where("trim(client_email)", $client_email);
        $this->db->or_where("trim(client_societe)", $client_societe);
        $clients = $this->db->get("ip_clients")->result();
//        print_r($clients);
        if (!empty($clients)) {
            foreach ($clients as $client) {
                if (trim($client->client_email) == $client_email && $client->client_id != $id_client) {
                    $rule_email = 'required|is_unique[ip_clients.client_email]';
                }
                if (trim($client->client_societe) == $client_societe && $client->client_id != $id_client) {
                    $rule_societe = 'is_unique[ip_clients.client_societe]';
                }
            }
        }

        if($contact_type==0){
            $rule_societe = 'required|'.$rule_societe;
        } 
         
        $rule_req='';
        if($contact_type==0){
            $rule_req = 'required';
        } 
        $rule_part='';
        if($contact_type==1){
            $rule_part = 'required';
        } 
//        $rule_email = "";
        //        $rule_societe = "";

        $this->form_validation->set_message('is_unique', 'Le champ %s existe déjà');

        return array(
            'client_type' => array(
                'field' => 'client_type',
                'label' => lang('client_type'),
                'rules' => '',
            ),
            'timbre_fiscale' => array(
                'field' => 'timbre_fiscale',
                'label' => lang('default_item_timbre'),
                'rules' => '',
            ),
            'client_titre' => array(
                'field' => 'client_titre',
                'label' => lang('client_titre'),
                'rules' => 'required',
            ),
            'client_name' => array(
                'field' => 'client_name',
                'label' => lang('client_name'),
                'rules' => $rule_part,
            ),
            'client_prenom' => array(
                'field' => 'client_prenom',
                'label' => lang('client_prenom'),
                'rules' => $rule_part,
            ),
            'client_date_naiss' => array(
                'field' => 'client_date_naiss',
                'label' => lang('client_date_naiss'),
            ),
            'client_societe' => array(
                'field' => 'client_societe',
                'label' => lang('client_societe'),
                'rules' => $rule_societe,
            ),
            'client_active' => array(
                'field' => 'client_active',
            ),
            'client_address_1' => array(
                'field' => 'client_address_1',
                'label' => lang('street_address'),
                'rules' => 'required',
            ),
            'client_city' => array(
                'field' => 'client_city',
            ),
            'client_state' => array(
                'field' => 'client_state',
                'label' => lang('city'),
                'rules' => 'required',
            ),
            'client_zip' => array(
                'field' => 'client_zip',
            ),
            'client_country' => array(
                'field' => 'client_country',
            ),
            'client_devise_id' => array(
                'field' => 'client_devise_id',
                'label' => lang('client_devise_id'),
                'rules' => 'required',
            ),
            'client_phone' => array(
                'field' => 'client_phone',
                'label' => lang('phone_number'),
                'rules' => $required_tel,
            ),
            'client_fax' => array(
                'field' => 'client_fax',
            ),
            'client_mobile' => array(
                'field' => 'client_mobile',
            ),
            'client_email' => array(
                'field' => 'client_email',
                'rules' => $rule_email,
                'label' => lang('client_email'),
            ),
            'client_web' => array(
                'field' => 'client_web',
                'label' => lang('web_address'),
            ),
            'client_vat_id' => array(
                'field' => 'client_vat_id',
//                'rules' => $ste1,
                'label' => lang('matricule_fisc'),
              //  'rules' => $rule_req,
            ),
            'client_tax_code' => array(
                'field' => 'client_tax_code',
//                'rules' => $ste2,
                'label' => lang('tax_code'),
                //'rules' => $rule_req,
            ),
            'client_mat_fiscal' => array(
                'field' => 'user_mat_fiscal',
            ),
            'contact_type' => array(
                'field' => 'contact_type',
                'label' => '',
                'rules' => '',
            ),
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        if (!isset($db_array['client_active'])) {
            $db_array['client_active'] = 0;
        }
        if (isset($db_array['client_date_naiss']) && $db_array['client_date_naiss'] != '') {
            $db_array['client_date_naiss'] = date_to_mysql($db_array['client_date_naiss']);
        }

        return $db_array;
    }

    public function delete($id)
    {
//        parent::delete($id);
        //
        //        $this->load->helper('orphan');
        //        delete_orphans();
    }

    /**
     * Returns client_id of existing or new record
     */
    public function client_lookup($client_name)
    {
        $client = $this->mdl_clients->where('client_name', $client_name)->get();

        if ($client->num_rows()) {
            $client_id = $client->row()->client_id;
        } else {
            $db_array = array(
                'client_name' => $client_name,
            );

            $client_id = parent::save(null, $db_array);
        }

        return $client_id;
    }

    public function with_total()
    {
        $this->filter_select("IFNULL((SELECT SUM(invoice_total) FROM ip_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ip_invoices WHERE ip_invoices.client_id = ip_clients.client_id)), 0) AS client_invoice_total", false);
        return $this;
    }

    public function with_total_paid()
    {
        $this->filter_select("IFNULL((SELECT SUM(invoice_paid) FROM ip_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ip_invoices WHERE ip_invoices.client_id = ip_clients.client_id)), 0) AS client_invoice_paid", false);
        return $this;
    }

    public function with_total_balance()
    {
        $this->filter_select("IFNULL((SELECT SUM(invoice_balance) FROM ip_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM ip_invoices WHERE ip_invoices.client_id = ip_clients.client_id)), 0) AS client_invoice_balance", false);
        return $this;
    }

    public function is_active()
    {
        $this->filter_where('client_active', 1);
        return $this;
    }

    public function is_inactive()
    {
        $this->filter_where('client_active', 0);
        return $this;
    }

    public function is_prospect()
    {
        $this->filter_where('client_type', 0);
        return $this;
    }

    public function is_client()
    {
        $this->filter_where('client_type', 1);
        return $this;
    }

    public function by_client($match)
    {
        $this->db->like('client_name', $match);
        $this->db->or_like('client_prenom', $match);
        $this->db->or_like('client_societe', $match);
    }

}
