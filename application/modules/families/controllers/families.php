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

class Families extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('mdl_families');
    }

    public function index($page = 0) {
        $sess_product_index = $this->session->userdata['product_index'];
        if ($sess_product_index == 1) {
            $this->mdl_families->paginate(site_url('families/index'), $page);
            $families = $this->mdl_families->result();

            $this->layout->set('families', $families);
            $this->layout->buffer('content', 'families/index');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function form($id = NULL) {
        $sess_product_add = $this->session->userdata['product_add'];
        if ($sess_product_add == 1) {
            if ($this->input->post('btn_cancel')) {
                redirect('families');
            }

            if ($this->mdl_families->run_validation()) {
                $this->mdl_families->save($id);
                redirect('families');
            }

            if ($id and ! $this->input->post('btn_submit')) {
                if (!$this->mdl_families->prep_form($id)) {
                    show_404();
                }
            }

            $this->layout->buffer('content', 'families/form');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($id) {
        $sess_product_del = $this->session->userdata['product_del'];
        if ($sess_product_del == 1) {
            $this->mdl_families->delete($id);
            redirect('families');
        } else {
            redirect('sessions/login');
        }
    }

}
