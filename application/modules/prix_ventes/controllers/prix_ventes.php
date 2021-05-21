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

class Prix_ventes extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_prix_ventes');
    }

    public function index($page = 0)
    {
        $this->mdl_prix_ventes->paginate(site_url('prix_ventes/index'), $page);
        $prix_ventes = $this->mdl_prix_ventes->result();

        $this->layout->set('prix_ventes', $prix_ventes);
        $this->layout->buffer('content', 'prix_ventes/index');
        $this->layout->render();
    }

    public function form($id = NULL)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('settings#partial_settings_devise');
        }

        if ($this->mdl_prix_ventes->run_validation()) {
            $this->mdl_prix_ventes->save($id);
            redirect('settings#partial_settings_devise');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_prix_ventes->prep_form($id)) {
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

        $this->layout->buffer('content', 'prix_ventes/form');
        $this->layout->render();
    }

    public function delete($id)
    {
        $this->mdl_prix_ventes->delete($id);
        redirect('settings#partial_settings_piece');
    }

}
