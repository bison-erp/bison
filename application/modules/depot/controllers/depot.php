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

class Depot extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model('mdl_depot');
    } 
     
    public function index($page = 0)
    {
        $sess_product_index = $this->session->userdata['product_index'];
        if ($sess_product_index == 1) {
           
            $this->mdl_depot->paginate(site_url('depot/index'), $page);
            
            $mdl_depot = $this->mdl_depot->result();
            $this->layout->set('mdl_depot', $mdl_depot);
            $this->layout->buffer('content', 'depot/index');
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
                redirect('depot');
            }
         
            if ($this->mdl_depot->run_validation()) {
              //   return var_dump($this->mdl_option_attribut->form_values);die();  
                $this->mdl_depot->create($id);
                redirect('settings#settings-stock');
            }

            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_depot->prep_form($id)) {
                    show_404();
                }
            }
            $this->layout->set(
                array(
                    'mdl_depot' => $this->mdl_depot->get()->result(),                    
                )
            );
            $this->layout->buffer('content', 'depot/form');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

}