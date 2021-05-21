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

class Banque extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('banque/mdl_banque');
    }

    public function index($page = 0)
    {
        $sess_product_index = $this->session->userdata['product_index'];
        if ($sess_product_index == 1) {
            $this->mdl_banque->paginate(site_url('banque/index'), $page);
            $mdl_banque = $this->mdl_banque->result();
            $this->layout->set('mdl_banque', $mdl_banque);
            $this->layout->buffer('content', 'banque/index');
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
                redirect('banque');
            }

            if ($this->mdl_banque->run_validation()) {
                $data = array(
                    "nom_banque" => $this->input->post('nom_banque'),
                );
                if ($id) {
                    $this->db->where('id_banque', $id);
                    $this->db->update('ip_banque', $data);

                } else {
                    $this->db->insert('ip_banque', $data);
                }

                redirect('banque');
            }

            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_banque->prep_form($id)) {
                    show_404();
                }
            }

            $this->layout->buffer('content', 'banque/form');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($id)
    {
        $sess_product_del = $this->session->userdata['product_del'];
        if ($sess_product_del == 1) {
            $this->mdl_banque->delete($id);
            redirect('banque');
        } else {
            redirect('sessions/login');
        }
    }

}