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

class Mark extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_mark');
    }
    public function index($page = 0)
    {
	    $sess_devis_index = $this->session->userdata['devis_index'];
        if ($sess_devis_index == 1) 
		{
            $this->mdl_mark->paginate(site_url('mark/index'), $page);	
            $mark = $this->mdl_mark->get()->result();
			//print_r($mdl_mark);
			//echo $mdl_mark;
            $this->layout->set('mark', $mark);
				
            $this->layout->buffer('content', 'mark/index');
			  
            $this->layout->render();
		
       }
		else 
		{
            redirect('sessions/login');
        }
    }
    public function form($id = null)
    {
		$sess_devis_add = $this->session->userdata['devis_add'];
        if ($sess_devis_add == 1) {
            if ($this->input->post('btn_cancel')) 
			{
                redirect('mark');
            }
            if ($this->mdl_mark->run_validation())
			{
                
                $this->mdl_mark->save($id);
                redirect('mark');
            }
            if ($id and !$this->input->post('btn_submit')) 
			{
                if (!$this->mdl_mark->prep_form($id)) {
                    show_404();
                }
            }
            $this->layout->buffer('content', 'mark/form');
            $this->layout->render();
        }
		else 
		{
            redirect('sessions/login');
        }
    }
    public function delete($id)
    {    
		$sess_devis_del = $this->session->userdata['devis_del'];
        if ($sess_devis_del == 1) {
            $this->mdl_mark->delete($id);
            redirect('mark');
        } else {
            redirect('sessions/login');
        }
    }
    public function modal_mark()
    {
        $mark = $this->mdl_mark->get()->result(); 
        $data = array(
            'mark' => $mark
        );
        $this->layout->load_view('mark/modal_mark', $data);
    }
    public function partial_modal_mark_lookup()
    {
        $filter_fournisseur = $this->input->get('filter_fournisseur');
        if (!empty($filter_fournisseur)) 
		{
            $marks = $this->mdl_mark->by_name($filter_fournisseur);
        }
        $marks = $this->mdl_mark->get();
        $marks = $this->mdl_mark->result();
        $data = array(
            'marks' => $marks,
        );
        $this->layout->load_view('mark/partial_modal_mark_lookup', $data);
    }
    public function modal_mark_add()
    {
        $marks = $this->mdl_mark->get()->result();  
        $data = array(
            'marks' => $marks,  
        );
        $this->layout->load_view('mark/modal_mark_add', $data);
    }
    public function create()
    {         
        if ($this->mdl_mark->run_validation()) {
            $marks = $this->mdl_mark->save();
            $markname = $this->mdl_mark->by_id_mark($marks);
            $response = array(
                'success' => 1,
                'id_mark' => $marks,
                'name_mark' => $markname->form_values['name_mark'],
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => validation_errors(),
            );
        }
        echo json_encode($response);
    }     
}