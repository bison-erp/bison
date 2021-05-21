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
    public function modal_families_lookup()
    {   $this->load->model('mdl_families');
        $families = $this->mdl_families->get()->result();
        $data = array(
            'families' => $families,
        );
        $this->layout->load_view('families/modal_families_lookup', $data);
    }

    public function partial_modal_familie_lookup()
    {
        $filter_families = $this->input->get('filter_families');

        $this->load->model('mdl_families');

        if (!empty($filter_families)) {
            $families = $this->mdl_families->by_families($filter_families);
        }
        $families = $this->mdl_families->get();
        $families = $this->mdl_families->result();
        $data = array(
            'families' => $families,
        );
        $this->layout->load_view('families/partial_modal_familie_lookup', $data);
    }

    public function modal_familie_add()
    {        
        $this->layout->load_view('families/modal_familie_add', $data);
    }

    public function create()
    {
        $this->load->model('families/mdl_families');
        if ($this->mdl_families->run_validation()) {

            $families = $this->mdl_families->save();
            $family_name = $this->mdl_families->by_id_familie($families); 
            $response = array(
                'success' => 1,
                'family_id' => $families,
                'family_name' => $family_name->form_values['family_name'],
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