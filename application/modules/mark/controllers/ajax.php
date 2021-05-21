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
    //public $ajax_controller = TRUE;
    public function modal_product_lookups()
    {
        //$filter_family  = $this->input->get('filter_family');
        $filter_product = $this->input->get('filter_product');

        $this->load->model('mdl_services');
        $this->load->model('families/mdl_families');

        // Apply filters
        /*
        if((int)$filter_family) {
        $services = $this->mdl_services->by_family($filter_family);
        }
         */

        if (!empty($filter_product)) {
            $services = $this->mdl_services->by_product($filter_product);
        }
        $services = $this->mdl_services->get();
        $services = $this->mdl_services->result();

        $families = $this->mdl_families->get()->result();

        $data = array(
            'services' => $services,
            'families' => $families,
            'filter_product' => $filter_product,
            //'filter_family'  => $filter_family,
        );

        $this->layout->load_view('services/modal_product_lookups', $data);
    }
    public function load_mark_partial_filter()
    {
	    $this->load->model('mark/mdl_mark');
	    $filter_mark = $this->input->post('filter_mark');
	    $limit_par_page = $this->input->post('limit_par_page');
        $start_page = $this->input->post('start_page');
        $order_by = $this->input->post('order_by');
        $order_method = $this->input->post('order_method');
        $start_line = (int) ($start_page - 1) * (int) $limit_par_page;
		if (!empty($filter_mark)) 
		{
		 $filter_mark = $this->mdl_mark->by_name($filter_mark);
		}
		 $this->db->limit($limit_par_page, $start_line);
       $this->db->order_by(TRIM($order_by), $order_method);
		 $filter_mark = $this->mdl_mark->get();
         $filter_mark = $this->mdl_mark->result();
		$nb_all_lines = $this->db->count_all_results('ip_mark');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);
      
        $data = array(
		'filter_mark' => $filter_mark, 
	    'nb_pages' => $nb_pages,
        'start_page' => $start_page,
        'nb_all_lines' => $nb_all_lines,
        'start_line' => $start_line,	
		);
        $this->layout->load_view('mark/partial_modal_mark_lookup', $data);
    }
    public function create()
    {
        $this->load->model('fournisseurs/mdl_fournisseurs');
        //  $fournisseurs = $this->db->get("ip_fournisseurs")->result();

        if ($this->mdl_fournisseurs->run_validation()) {

            $fournisseurs = $this->mdl_fournisseurs->save();
            $fournisseursname = $this->mdl_fournisseurs->by_nom_fournisseur($fournisseurs);
            $response = array(
                'success' => 1,
                'fournisseurs_id' => $fournisseurs,
                'nomfournisseur' => $fournisseursname->form_values['raison_social_fournisseur'],
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