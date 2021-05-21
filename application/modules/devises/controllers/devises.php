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

class Devises extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_devises');
    }

    public function index($page = 0)
    {
        $this->mdl_devises->paginate(site_url('devises/index'), $page);
        $devises = $this->mdl_devises->result();

        $this->layout->set('devises', $devises);
        $this->layout->buffer('content', 'devises/index');
        $this->layout->render();
    }

    public function form($id = NULL)
    {
        if($id == NULL && !rightsMultiDevises()){
          
            redirect('settings#settings-devise');
        }
        if ($this->input->post('btn_cancel')) {
            redirect('settings#settings-devise');
        }

        if ($this->mdl_devises->run_validation()) {
            $this->mdl_devises->save($id);
            redirect('settings#settings-devise');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_devises->prep_form($id)) {
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

        $this->layout->buffer('content', 'devises/form');
        $this->layout->render();
    }

    public function delete($id)
    {
        $this->mdl_devises->delete($id);
        redirect('settings#settings-devise');
    }

}
