<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 * 
 * A free and open source web based invoicing system
 *
 * @package		InvoicePlane
 * @author		Kovah (www.kovah.de)
 * @copyright	Copyright (c) 2012 - 2015 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 * 
 */

class Delai_Paiement extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_delai');
    }

    public function index($page = 0)
    {
        $this->mdl_delai->paginate(site_url('delaiPaiement/index'), $page);
        $delaiPaiement = $this->mdl_delai->result();

        $this->layout->set('delaiPaiement', $delaiPaiement);
        $this->layout->buffer('content', 'delaiPaiement/index');
        $this->layout->render();
    }

    public function form($id = NULL)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('delaiPaiement');
        }

        if ($this->mdl_delai->run_validation()) {
            $this->mdl_delai->save($id);
            redirect('delaiPaiement');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_delai->prep_form($id)) {
                show_404();
            }
        }

        $this->load->model('families/mdl_families');
        $this->load->model('tax_rates/mdl_tax_rates');

        $this->layout->set(
            array(
                'families' => $this->mdl_families->get()->result(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
            )
        );

        $this->layout->buffer('content', 'delaiPaiement/form');
        $this->layout->render();
    }

    public function delete($id)
    {
        $this->mdl_delai->delete($id);
        redirect('mdl_delai');
    }

}
