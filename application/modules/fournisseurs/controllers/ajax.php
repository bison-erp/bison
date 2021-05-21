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

        $services = $this->mdl_services->select('product_name')->like('product_name', $query)->order_by('product_name')->get(array(), false)->result();

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

        $services = $this->mdl_services->select('product_id, product_name, product_description, product_price, tax_rate_id')->like('product_name', $query)->order_by('product_name')->get(array(), false)->result();

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

    public function load_fournissuer_partial_filter()
    {
        $filter_fournisseurs = trim(strtolower($this->input->post('filter_fournisseur')));
        $filter_categorie = $this->input->post('filter_categorie');
        $limit_par_page = $this->input->post('limit_par_page');
        $start_page = $this->input->post('start_page');
        $order_by = $this->input->post('order_by');
        $order_method = $this->input->post('order_method');
        $where = "";
        $start_line = (int) ($start_page - 1) * (int) $limit_par_page;
        if ((!($filter_categorie) && !$filter_fournisseurs) or (($filter_categorie == "-1") && !$filter_fournisseurs)) {

            $where .= "ip_fournisseurs.id_fournisseur <> 0";
        } elseif ((!($filter_categorie) or $filter_categorie == "-1") && ($filter_fournisseurs)) {

            $where .= "((LOWER(ip_fournisseurs.raison_social_fournisseur) LIKE '%" . $filter_fournisseurs . "%') ";

            $where .= " OR (LOWER(ip_fournisseurs.ville_fournisseur) LIKE '%" . $filter_fournisseurs . "%' ))";

        } elseif (!$filter_fournisseurs && (!($filter_categorie) or ($filter_categorie != "-1"))) {

            $where .= "(ip_fournisseurs.ip_categorie_fournisseur=$filter_categorie)";
        } else {
            $where .= "((LOWER(ip_fournisseurs.raison_social_fournisseur) LIKE '%" . $filter_fournisseurs . "%') ";
            $where .= " OR (LOWER(ip_fournisseurs.ville_fournisseur) LIKE '%" . $filter_fournisseurs . "%' ))";
            $where .= "OR(ip_fournisseurs.ip_categorie_fournisseur=$filter_categorie)";
        }

        $this->db->WHERE("$where");
        $nb_all_lines = $this->db->count_all_results('ip_fournisseurs');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);
        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $fournisseurs = $this->db->get("ip_fournisseurs")->result();
        $data = array(
            'fournisseurs' => $fournisseurs,
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
        );
        $this->layout->load_view('fournisseurs/partial_fournisseur_table', $data);
    }

    public function modal_fournisseur_lookup()
    {
        $fournisseurs = $this->db->get("ip_fournisseurs")->result();
        $data = array(
            'fournisseurs' => $fournisseurs,
        );
        $this->layout->load_view('fournisseurs/modal_fournisseur_lookup', $data);
    }

    public function modal_fournisseur_add()
    {
        $fournisseurs = $this->db->get("ip_fournisseurs")->result();
        $this->load->model('fournisseurs/mdl_fournisseurs');
        $this->load->model('categorie_fournisseur/mdl_categorie_fournisseur');

        if ($this->input->post('btn_cancel')) {
            redirect('fournisseurs');
        }
        $this->load->model('devises/mdl_devises');
        $this->load->helper('country');
        $data = array(
            'categorie' => $this->mdl_categorie_fournisseur->get()->result(),

            'devises' => $this->mdl_devises->get()->result(),
            'countries' => get_country_list(lang('cldr')),

        );
        $this->layout->load_view('fournisseurs/modal_fournisseur_add', $data);
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

    public function partial_modal_fournisseur_lookup()
    {
        $filter_fournisseur = $this->input->get('filter_fournisseur');

        $this->load->model('mdl_fournisseurs');

        if (!empty($filter_fournisseur)) {
            $fournisseur = $this->mdl_fournisseurs->by_fournisseur($filter_fournisseur);
        }
        $fournisseur = $this->mdl_fournisseurs->get();
        $fournisseur = $this->mdl_fournisseurs->result();
        $data = array(
            'fournisseurs' => $fournisseur,
            'filter_client' => $filter_client,
        );
        $this->layout->load_view('fournisseurs/partial_modal_fournisseur_lookup', $data);
    }

}