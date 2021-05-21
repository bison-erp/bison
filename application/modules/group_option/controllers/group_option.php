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

class Group_option extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct(); 
        $this->load->model('group_option/mdl_group_option');
    } 

    public function index($page = 0)
    {
        $sess_product_index = $this->session->userdata['product_index'];
        if ($sess_product_index == 1) {
           
            $this->mdl_group_option->paginate(site_url('group_option/index'), $page);
            
            $mdl_group_option = $this->mdl_group_option->result();
            $this->layout->set('mdl_group_option', $mdl_group_option);
            $this->layout->buffer('content', 'group_option/index');
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
                redirect('group_option');
            }
         
            if ($this->mdl_group_option->run_validation()) {
              //   return var_dump($this->mdl_group_option->form_values);die();  
                $this->mdl_group_option->create($id);
                redirect('settings#settings-stock');
            }

            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_group_option->prep_form($id)) {
                    show_404();
                }
            }
            $this->layout->set(
                array(
                    'groupe_option' => $this->mdl_group_option->get()->result(),                    
                )
            );
            $this->layout->buffer('content', 'group_option/form');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }
   
}