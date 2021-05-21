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

class Categorie_fournisseur extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_categorie_fournisseur');
    }

    public function index($page = 0)
    {
        $sess_product_index = $this->session->userdata['product_index'];
        if ($sess_product_index == 1) {
            $this->mdl_categorie_fournisseur->paginate(site_url('categorie_fournisseur/index'), $page);
            $mdl_categorie_fournisseur = $this->mdl_categorie_fournisseur->result();
            $this->layout->set('mdl_categorie_fournisseur', $mdl_categorie_fournisseur);
            $this->layout->buffer('content', 'categorie_fournisseur/index');
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
                redirect('categorie_fournisseur');
            }

            if ($this->mdl_categorie_fournisseur->run_validation()) {
                
                $this->mdl_categorie_fournisseur->save($id);
                redirect('categorie_fournisseur');
            }

            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_categorie_fournisseur->prep_form($id)) {
                    show_404();
                }
            }

            $this->layout->buffer('content', 'categorie_fournisseur/form');
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