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
class Ajax extends Admin_Controller
{
    public $ajax_controller = true;
    public function modal_banque_lookup()
    {
        $banque = $this->db->get("ip_banque")->result();
        $data = array(
            'banques' => $banque,
        );

        $this->layout->load_view('banque/modal_banque_lookup', $data);

    }

    public function modal_banque_add()
    {
        $this->load->model('mdl_banque');

        $banque = $this->db->get("ip_banque")->result();
        //  $this->load->model('banque/ip_banque');

        if ($this->input->post('btn_cancel')) {
            redirect('banque');
        }
        $data = array(
            'banque' => $this->mdl_banque->get()->result(),
        );
        $this->layout->load_view('banque/modal_banque_add', $data);
    }

    public function create()
    {
        $data = array(
            'nom_banque' => $this->input->post('nom_banque'),
        );

        //$fournisseurs = $this->db->get("ip_fournisseurs")->result();

        if (!empty($this->input->post('nom_banque'))) {

            $this->db->insert('ip_banque', $data);
            $id = $this->db->insert_id();
            $response = array(
                'success' => 1,
                'banque_id' => $id,
                'nom_banque' => $this->input->post('nom_banque'),
                'id_payement' => $this->input->post('payment_method_id'),
            );
        }
        echo json_encode($response);
    }

    public function partial_modal_banque_lookup()
    {
        $filter_banque = $this->input->get('filter_banque');
        $this->load->model('mdl_banque');

        if (!empty($filter_banque)) {
            $banque = $this->mdl_banque->by_banque($filter_banque);
        }
        $banque = $this->mdl_banque->get();
        $banque = $this->mdl_banque->result();

        $data = array(
            'fournisseurs' => $banque,
            'filter_banque' => $filter_banque,
        );
        $this->layout->load_view('banque/partial_modal_banque_lookup', $data);
    }
}