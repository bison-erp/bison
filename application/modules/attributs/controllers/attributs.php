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

class Attributs extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_option_attribut');
        $this->load->model('products/mdl_groupe_option');
    } 

    public function index($page = 0)
    {
        $sess_product_index = $this->session->userdata['product_index'];
        if ($sess_product_index == 1) {
           
            $this->mdl_option_attribut->paginate(site_url('attributs/index'), $page);
            
            $mdl_option_attribut = $this->mdl_option_attribut->result();
            $this->layout->set('mdl_option_attribut', $mdl_option_attribut);
            $this->layout->buffer('content', 'attributs/index');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }    

    public function form($id = null)
    {
        $sess_product_add = $this->session->userdata['product_add'];
         
        if ($sess_product_add == 1) {
            if ($this->input->post('btn_cancel')) {
                redirect('attributs');
            }
         
            if ($this->mdl_option_attribut->run_validation()) {
              //   return var_dump($this->mdl_option_attribut->form_values);die();  
                $this->mdl_option_attribut->create($id);
                redirect('settings#settings-stock');
            }

            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_option_attribut->prep_form($id)) {
                    show_404();
                }
            }
            $this->layout->set(
                array(
                    'groupe_option' => $this->mdl_groupe_option->get()->result(),                    
                )
            );
            $this->layout->buffer('content', 'attributs/form');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($id)
    {
        $sess_product_del = $this->session->userdata['product_del'];
        if ($sess_product_del == 1) {
            $this->mdl_categorie_fournisseur->delete($id);
            redirect('categorie_fournisseur');
        } else {
            redirect('sessions/login');
        }
    }

    public function modal_categorie_lookup()
    {
        $categories = $this->mdl_categorie_fournisseur->get()->result();
        
        $data = array(
            'categories' => $categories,
        );
        $this->layout->load_view('categorie_fournisseur/modal_categorie_fournisseur', $data);
    }

    public function partial_modal_categorie_lookup()
    {
        $filter_fournisseur = $this->input->get('filter_fournisseur');
 
        if (!empty($filter_fournisseur)) {
            $categories = $this->mdl_categorie_fournisseur->by_categorie($filter_fournisseur);
        }
        $categories = $this->mdl_categorie_fournisseur->get();
        $categories = $this->mdl_categorie_fournisseur->result();
        $data = array(
            'categories' => $categories,
           // 'filter_client' => $filter_client,
        );
        $this->layout->load_view('categorie_fournisseur/partial_modal_categorie_lookup', $data);
    }
 
    public function modal_categorie_add()
    {
        $categories = $this->mdl_categorie_fournisseur->get()->result();  
        $data = array(
            'categories' => $categories,  
        );
        $this->layout->load_view('categorie_fournisseur/modal_categorie_add', $data);
    }

    public function create()
    {         
        if ($this->mdl_categorie_fournisseur->run_validation()) {

            $categories = $this->mdl_categorie_fournisseur->save();
            $fournisseursname = $this->mdl_categorie_fournisseur->by_id_categorie($categories);
            $response = array(
                'success' => 1,
                'fournisseurs_id' => $categories,
                'nomfournisseur' => $fournisseursname->form_values['designation'],
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => validation_errors(),
            );
        }
        echo json_encode($response);
    }     
}