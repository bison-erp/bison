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
	

    public function process_product_selections()
    {
        $this->load->model('mdl_services');

        $services = $this->mdl_services->where_in('product_id', $this->input->post('product_ids'))->get()->result();

        foreach ($services as $product) {
            $product->product_price = format_amount($product->product_price);
        }

        echo json_encode($services);
    }
	public function name_product_query()
    {
        // Load the model
        $this->load->model('mdl_services');

        // Get the post input
        $query = $this->input->post('query');
		

        $services = $this->mdl_services->select('product_name')->like('product_name', $query)->order_by('product_name')->get(array(), FALSE)->result();

        $response = array();

        foreach ($services as $product) {
            $response[] = $product->product_name;
        }

        echo json_encode($response);
    }
	public function product_detail_query()
    {
        // Load the model
        $this->load->model('mdl_services');

        // Get the post input
        $query = $this->input->post('query');
		

        $services = $this->mdl_services->select('product_id, product_name, product_description, product_price, tax_rate_id')->like('product_name', $query)->order_by('product_name')->get(array(), FALSE)->result();

        $response = array();

        foreach ($services as $product) {
            $response['product_id'] = $product->product_id;
			$response['product_name'] = $product->product_name;
			$response['product_description'] = $product->product_description;
			$response['product_price'] = $product->product_price;
			$response['tax_rate_id'] = $product->tax_rate_id;
			
        }

        echo json_encode($response);
    }

}
