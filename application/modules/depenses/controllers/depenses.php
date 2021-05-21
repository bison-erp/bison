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

class Depenses extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_depenses');
        $this->load->model('categorie_fournisseur/mdl_categorie_fournisseur');
    }
    public function form($id = null)
    {
        $sess_product_add = $this->session->userdata['product_add'];
        // $this->
        if ($sess_product_add == 1) {
            if ($this->input->post('btn_cancel')) {
                redirect('depenses');
            }
            if ($this->mdl_depenses->run_validation()) {
              //  return var_dump($this->mdl_depenses->form_values);die('44');
                $date_facture = $this->mdl_depenses->form_values['date_facture'];
                $validdufusion = $this->mdl_depenses->form_values['valdifussuion'];
                $moyenpayement = $this->mdl_depenses->form_values['moyenpayement'];
                $date_encaissement = $this->mdl_depenses->form_values['date_encaissement'];   
                $num_cheque = $this->mdl_depenses->form_values['num_cheque'];   
                $validdufusion_n = $this->mdl_depenses->form_values['divussion_ch'];
              
                $date_facture = explode('/', $date_facture);
                $date_facturee = $date_facture[2] . '-' . $date_facture[1] . '-' . $date_facture[0];

                $date_paiement = $this->mdl_depenses->form_values['date_paiement'];
                $date_paiement = explode('/', $date_paiement);
                $date_paiemment = $date_paiement[2] . '-' . $date_paiement[1] . '-' . $date_paiement[0];

              //  return  var_dump($this->mdl_depenses->form_values['date_due']);die('hh');
                $date_due = $this->mdl_depenses->form_values['date_due'];
                $date_due = explode('/', $date_due);
                $date_duee = $date_due[2] . '-' . $date_due[1] . '-' . $date_due[0];

                $config = array();
                $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/fileproduct';
                if (!is_dir($dir_path)) {
                    mkdir($dir_path, 0777);
                }
           //  return  var_dump($this->mdl_depenses->form_values['status_id']);die('hh');
                if ($id) {
                    $this->mdl_depenses->save($id);
                
                   $data = array(
                        'date_facture' => $date_facturee,
                        'date_paiement' => $date_paiemment,
                        'date_due' => $date_duee,
                        
                    );

                    $this->db->where('id_depense', $id);
                    $this->db->update('ip_depense', $data);

                    $this->db->where('id_depense', $id);
                    $this->db->delete('ip_depense_montant');
                    $depenses = $id;
                    if($this->mdl_depenses->form_values['status_id']==0){
                        if($validdufusion_n==1){
                            for ($i = 0; $i < count($validdufusion); $i++) {
                                $date_encaissemen = explode('/', $date_encaissement[$i]);
                                $date_encaissemen = $date_encaissemen[2] . '-' . $date_encaissemen[1] . '-' . $date_encaissemen[0];
                            
                                if ($validdufusion[$i] != "") {
                                    $data = array(
                                        'id_depense' => $id,
                                        'montant' => $validdufusion[$i],
                                        'moyenpayement'  => $moyenpayement[$i],
                                        'date_encaissement'  => $date_encaissemen,
                                        'num_cheque'  => $num_cheque[$i],
                                    );                          
                                    $this->db->insert('ip_depense_montant', $data);
                                }
                            }
                        }         
                    }
                } else {
                  
                    $this->mdl_depenses->create($id);
                    $depenses = $this->db->insert_id();
                    $data = array(
                        'date_facture' => $date_facturee,
                        'date_paiement' => $date_paiemment,
                        'date_due' => $date_duee,
                        
                    );

                    $this->db->where('id_depense', $depenses);
                    $this->db->update('ip_depense', $data);
                   /* $data = array(
                        'id_retained_source' => $this->mdl_depenses->form_values['id_retained_source'],
                        'retained_source' => $this->mdl_depenses->form_values['retained_source'],
                        'date_facture' => $date_facturee,
                        'date_paiement' => $date_paiemment,
                        'net_payer_depense' => $this->mdl_depenses->form_values['net_payer_depense'],
                        'diffusion' => count($validdufusion),
                        'divussion_ch' => $this->mdl_depenses->form_values['divussion_ch'],
                    );
                    $this->db->where('id_depense', $depenses);
                    $this->db->update('ip_depense', $data);*/
                    if($this->mdl_depenses->form_values['status_id']==0){
                            if($validdufusion_n==1){
                                for ($i = 0; $i < count($validdufusion); $i++) {
                                    if ($validdufusion[$i] != "") {
                                        $date_encaissemen = explode('/', $date_encaissement[$i]);
                                        $date_encaissemen = $date_encaissemen[2] . '-' . $date_encaissemen[1] . '-' . $date_encaissemen[0];
                                    
                                        $data = array(
                                            'id_depense' => $depenses,
                                            'montant' => $validdufusion[$i],
                                            'moyenpayement'  => $moyenpayement[$i],
                                            'date_encaissement'  => $date_encaissemen,
                                            'num_cheque'  => $num_cheque[$i],
                                        );
                                        $this->db->insert('ip_depense_montant', $data);
                                    }
                                }
                            }
                    }
                }
                if (count($_FILES['images']['name']) > 0 && strlen($_FILES['images']['name'][0])) {
                    for ($i = 0; $i < count($_FILES['images']['name']); $i++) {

                        $_FILES['file']['name'] = $_FILES['images']['name'][$i];

                        $_FILES['file']['type'] = $_FILES['images']['type'][$i];

                        $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];

                        $_FILES['file']['error'] = $_FILES['images']['error'][$i];

                        $_FILES['file']['size'] = $_FILES['images']['size'][$i];

                        $config['upload_path'] = $dir_path;

                        $config['allowed_types'] = 'jpg|jpeg|png|gif';

                        $config['max_size'] = '1024000';

                        $config['overwrite'] = true;
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('file')) {
                            $this->upload->data();
                        }
                        $data = array(
                            'id_depense' => $depenses,
                            'name_file' => $_FILES['images']['name'][$i],
                        );
                        $this->db->insert('ip_file_depense', $data);
                    }}
                // $config = array();
                if ($id) {
                    $depenses_id = $id;
                } else {
                    $depenses_id = $depenses;
                }
                if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                    if (!$id) {
                        $data_log = array(
                            "log_action" => "add_depense",
                            "log_date" => date('Y-m-d H:i:s'),
                            "log_ip" => $this->session->userdata['ip_address'],
                            "log_user_id" => $this->session->userdata['user_id'],
                            "log_field1" => $depenses_id,
                            "log_field2" => $depenses_id,
                        );
                    } else {
                        $data_log = array(
                            "log_action" => "edit_depense",
                            "log_date" => date('Y-m-d H:i:s'),
                            "log_ip" => $this->session->userdata['ip_address'],
                            "log_user_id" => $this->session->userdata['user_id'],
                            "log_field1" => $depenses_id,
                            "log_field2" => $depenses_id,
                        );
                    }

                    $this->db->insert('ip_logs', $data_log);
                }
                redirect('depenses');
            }
            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_depenses->prep_form($id)) {
                    show_404();
                }
            }
            $this->load->model('fournisseurs/mdl_fournisseurs');
            $this->load->model('payment_methods/mdl_payment_methods');
            $this->load->model('settings/mdl_settings');
            $this->load->model('depenses/mdl_depensemontant');
            $this->load->model('tax_rates/mdl_tax_rates');
//ip_file_depense
            $this->load->model('categorie_fournisseur/mdl_categorie_fournisseur');
            $this->db->where("id_depense", $id);
            $file = $this->db->get("ip_file_depense")->result(); 
            $this->layout->set(
                array(
                    'fournisseurs' => $this->mdl_fournisseurs->get()->result(),
                    'id_moyenpayements' => $this->mdl_payment_methods->get()->result(),
                    'montant_depense' => $this->mdl_depensemontant->getMontantdepense($id),
                    'depenses' => $id,
                    'file' => $file,
                    'ip_retenu_source' =>  $this->db->get("ip_retenu_source")->result(),
                    'mdl_tax_ratess' =>  $this->mdl_tax_rates->get()->result(),
                    'mdl_categorie_fournisseurs' => $this->mdl_categorie_fournisseur->get()->result(),
                    'by_categorie'=>$this->mdl_categorie_fournisseur->by_designation($this->mdl_depenses->form_value('categorie_id'))->get()->result(),
                    'by_fournisseur'=>$this->mdl_fournisseurs->by_nom_fournisseur($this->mdl_depenses->form_value('id_fournisseur'))->get()->result(),

                    )
            );
            $this->layout->buffer('content', 'depenses/form');
            $this->layout->render();

        } else {
            redirect('sessions/login');
        }
    }

    public function index()
    {
        $sess_payement_index = $this->session->userdata['payement_index'];
        if ($sess_payement_index == 1) {

            $this->load->model('payment_methods/mdl_payment_methods');

            $this->layout->set(
                array(
                    'filter_placeholder' => lang('filter_depense'),
                    'payment_methods' => $this->mdl_payment_methods->get()->result(),
                )
            );

            $this->layout->buffer('content', 'depenses/index');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function deletefildepense($id)
    {

        $this->db->where('id_file_depense', $id);
        $this->db->delete('ip_file_depense');

    }

}