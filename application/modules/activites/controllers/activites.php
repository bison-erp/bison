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

class Activites extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('mdl_activites');
    }

    public function index($page = 0) {
            $this->mdl_activites->paginate(site_url('activites/index'), $page);
            $activites = $this->mdl_activites->result();

            $this->layout->set('activites', $activites);
            $this->layout->buffer('content', 'activites/index');
            $this->layout->render();
    }

    public function form($id = NULL) {
       
            if ($this->input->post('btn_cancel')) {
                redirect('activites');
            }

            if ($this->mdl_activites->run_validation()) {
                $this->mdl_activites->save($id);
                redirect('activites');
            }

            if ($id and ! $this->input->post('btn_submit')) {
                if (!$this->mdl_activites->prep_form($id)) {
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

            $this->layout->buffer('content', 'activites/form');
      
    }

    public function delete($id) {

            $this->mdl_activites->delete($id);
            redirect('activites');
  
    }

}
