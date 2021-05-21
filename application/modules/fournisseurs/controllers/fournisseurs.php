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

class Fournisseurs extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_fournisseurs');
    }

    public function index($page = 0)
    {
        $sess_fournisseur_index = $this->session->userdata['fournisseur_index'];
        if ($sess_fournisseur_index) {
            $this->mdl_fournisseurs->paginate(site_url('fournisseurs/index'), $page);
            $fournisseurs = $this->mdl_fournisseurs->result();
            $this->load->model('categorie_fournisseur/mdl_categorie_fournisseur');

            $this->layout->set(array(
                'fournisseurs' => $fournisseurs,
                'mdl_categorie_fournisseur' => $this->mdl_categorie_fournisseur->get()->result(),
            ));
            $this->layout->buffer('content', 'fournisseurs/index');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function form($id = null)
    {
        $sess_fournisseur_add = $this->session->userdata['fournisseur_add'];
        if ($sess_fournisseur_add == 1) {
            if ($this->input->post('btn_cancel')) {
                redirect('fournisseurs');
            }

            if ($this->mdl_fournisseurs->run_validation()) {
                $this->mdl_fournisseurs->save($id);
                if ($id) {
                    $fournisseur_id = $id;
                } else {
                    $fournisseur_id = $this->db->insert_id();
                }
                if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                    if (!$id) {
                        $data_log = array(
                            "log_action" => "add_fournisseur",
                            "log_date" => date('Y-m-d H:i:s'),
                            "log_ip" => $this->session->userdata['ip_address'],
                            "log_user_id" => $this->session->userdata['user_id'],
                            "log_field1" => $fournisseur_id,
                            "log_field2" => $fournisseur_id,
                        );
                    } else {
                        $data_log = array(
                            "log_action" => "edit_fournisseur",
                            "log_date" => date('Y-m-d H:i:s'),
                            "log_ip" => $this->session->userdata['ip_address'],
                            "log_user_id" => $this->session->userdata['user_id'],
                            "log_field1" => $fournisseur_id,
                            "log_field2" => $fournisseur_id,
                        );
                    }

                    $this->db->insert('ip_logs', $data_log);
                }
                redirect('fournisseurs');
            }

            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_fournisseurs->prep_form($id)) {
                    show_404();
                }
            }

            $this->load->model('families/mdl_families');
            $this->load->model('tax_rates/mdl_tax_rates');
            $this->load->model('devises/mdl_devises');
            $this->load->model('categorie_fournisseur/mdl_categorie_fournisseur');

            $this->layout->set(
                array(
                    'families' => $this->mdl_families->get()->result(),
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'categorie' => $this->mdl_categorie_fournisseur->get()->result(),
                    'devises' => $this->mdl_devises->get()->result(),
                )
            );

            $this->layout->buffer('content', 'fournisseurs/form');
            $this->layout->render();

        } else {
            redirect('sessions/login');
        }
    }

    public function delete($id)
    {
        $sess_fournisseur_del = $this->session->userdata['fournisseur_del'];
        if ($sess_fournisseur_del == 1) {
            $this->mdl_fournisseurs->delete($id);
            redirect('fournisseurs');
        } else {
            redirect('sessions/login');
        }
    }

}