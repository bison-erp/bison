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

class Mdl_Depot extends Response_Model
{

    public $table = 'ip_depot';
    public $primary_key = 'ip_depot.id_depot';
    public $validation_rules = 'validation_rules';
    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
 
    public function validation_rules()
    {   

        $rule = 'required';
        $libelle = trim($this->input->post('libelle'));
        $this->db->where("trim(libelle)", $libelle); 
        $ip_depots = $this->db->get("ip_depot")->result();
//        print_r($clients);
        if (!empty($ip_depots)) {
            foreach ($ip_depots as $ip_depot) {
              //  if (trim($ip_depot->libelle) == $libelle && $ip_depot->client_id != $id_client) {
                if (trim($ip_depot->libelle) == $libelle) {
                    $rule = 'required|is_unique[ip_depot.libelle]';
                } 
            }
        }
        $this->form_validation->set_message('is_unique', 'Le champ %s existe déjà');

        return array(           
            'libelle' => array(
                'field' => 'libelle',
            //    'label' => lang('marge'),
                'rules' => $rule,
            ),   
        );
    } 

    public function create($db_array = null)
    { 
        $id = parent::save(null, $db_array);

        return $id;
    }

    public function trouve($idstock,$ip_deopt_id)
    {
        $depot=  $this->db
            ->from('ip_deopt_stock')
            ->where('ip_deopt_stock.stock_id',$idstock)
            ->Where('ip_deopt_stock.depot_id',$ip_deopt_id) 
        ->get()->num_rows();     
        return $depot ;          
    }
}