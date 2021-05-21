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

class Fabrication extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_fabrication');
        $this->load->model('mdl_settings');
    }
    public function index()
    {
        $this->layout->set(
            array(

                'filter_display' => true,

            )
        );
        $this->layout->buffer(
            array(
                array('content', 'fabrication/index'),
            )
        );
        $this->layout->render();
    }
    public function form($id = null)
    {
        $nextcode = $this->mdl_settings->setting('next_code_bf');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('delai_paiement/mdl_delai');

        $this->layout->set(
            array(
                'nextcode' => $nextcode,
                'quote_statuses' => $this->mdl_quotes->statuses(),
                'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
            )
        );
        $this->layout->buffer(
            array(
                array('content', 'fabrication/form'),
            )
        );
        $this->layout->render();
    }

    public function view($fabrication_id)
    {
        $sess_devis_add = $this->session->userdata['devis_add'];
        $this->load->model('mdl_fabrication');
        $this->load->model('quotes/mdl_quotes');

        if ($sess_devis_add == 1) {
            $this->load->model('fabrication/mdl_fabrication_items');
            $this->load->model('tax_rates/mdl_tax_rates');
            $this->load->model('fabrication/mdl_fabrication_tax_rates');
            $this->load->model('custom_fields/mdl_custom_fields');
            //  $this->load->model('custom_fields/mdl_fabrication_custom');
            $this->load->model('delai_paiement/mdl_delai');
            $this->load->library('encrypt');

            //   $fabrication_custom = $this->mdl_quote_custom->where('quote_id', $fabrication_id)->get();

            $fabrication = $this->mdl_fabrication->get_by_id($fabrication_id);

            if (!$fabrication) {
                show_404();
            }

            $items = $this->mdl_fabrication_items->where('fabrication_id', $fabrication_id)->get()->result();
            // $qouteobj = $this->mdl_fabrication->where('ip_fabrication.fabrication_id', $fabrication_id)->get()->result();

            /*  $this->db->select('file_name,doc_id as id_document');
            $this->db->where("id_client", $qouteobj[0]->client_id);
            $this->db->where("object_id", $quote_id);
            $this->db->like('typeobject', 'quote');
            $this->db->from('ip_client_documents');
            $this->db->join('ip_document_rappel', 'ip_client_documents.id_document = ip_document_rappel.doc_id', 'left');
            $atbtrouve = $this->db->get()->result();

            $docnontrouve = $this->db->query("  SELECT  id_document,file_name FROM ip_client_documents where ip_client_documents.id_client=" . $qouteobj[0]->client_id . " and id_document not in (SELECT doc_id as id_document FROM ip_document_rappel where typeobject='quote' and ip_document_rappel.object_id =" . $quote_id . ")");
            $reqdocnontrouve = $docnontrouve->result();
             */
         //   return var_dump($items);
            $this->layout->set(
                array(
                    'quote' => $fabrication,
                    'items' => $items,
                    'quote_id' => $fabrication_id,
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'fabrication_tax_rates' => $this->mdl_fabrication_tax_rates->where('fabrication_id', $fabrication_id)->get()->result(),
                    'custom_fields' => $this->mdl_custom_fields->by_table('ip_fabrication_custom')->get()->result(),
                    'quote_statuses' => $this->mdl_quotes->statuses(),
                    'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
                    'index' => count($items) + 1,
                    'create' => 'edit',
                    'atbtrouve' => $atbtrouve,
                    'atbnontrouve' => $reqdocnontrouve,
                )
            );

            $this->layout->buffer(
                array(
                    //   array('modal_delete_quote', 'quotes/modal_delete_quote'),
                    //   array('modal_add_quote_tax', 'quotes/modal_add_quote_tax'),
                    array('content', 'fabrication/view'),
                )
            );

            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($fabrication_id)
    {
        $sess_devis_del = $this->session->userdata['devis_del'];
        if ($sess_devis_del == 1) {
            $data_del = array(
                'delete' => 1,
            );

            $this->db->where('fabrication_id', $fabrication_id);
            $this->db->update('ip_fabrication', $data_del);
            redirect('fabrication/index');
        } else {
            redirect('sessions/login');
        }
    }

    public function generate_pdf($fabrication_id, $stream = true, $fabrication_template = null)
    {
        $this->load->helper('pdf');
        $this->generate_fabrication_pdf($fabrication_id, $stream, $fabrication_template);

    }

    public function generate_fabrication_pdf($fabrication_id, $stream = true, $fabrication_template = null)
    {
        $CI = &get_instance();
        $CI->load->model('fabrication/mdl_fabrication');
        $CI->load->model('fabrication/mdl_fabrication_items');
        $CI->load->model('fabrication/mdl_fabrication_tax_rates');
        $CI->load->model('families/mdl_families');
        $CI->load->model('societes/mdl_societes');
        $CI->load->model('devises/mdl_devises');
        $CI->load->model('products/mdl_products');
        $CI->load->helper('country');
        $fabrication = $CI->mdl_fabrication->get_by_id($fabrication_id);
        $societe = $CI->mdl_societes->get_by_id(1);

        $fabrication_template = "default";

        $item_familles = $CI->mdl_families->get()->result();
        $arrayItems = array();
        // foreach ($item_familles as $famille) {

        // }

        array_push($arrayItems, $CI->db
                ->where('fabrication_id', $fabrication_id)
                ->join('ip_fabrication_item_amounts', 'ip_fabrication_item_amounts.item_id = ip_fabrication_items.item_id')
             //   ->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_fabrication_items.item_tax_rate_id')
                ->order_by("ip_fabrication_items.item_order", "asc")
                ->get('ip_fabrication_items')
                ->result());
        $ite = $CI->db->select()->from('ip_fabrication_items')->where('fabrication_id', $fabrication_id)->order_by("ip_fabrication_items.item_order", "asc")->get()->result();
        $respdf = 0;
        if($this->mdl_settings->setting('pdf_fabrication_template')!="avec entête"){
            $respdf = $respdf+1;
        }
    //  return var_dump($arrayItems);
        $data = array(
            'typepdf' => $respdf,
            'fabrication' => $fabrication,
            'countries' => get_country_list(lang('cldr')),
            'societe' => $societe,
            'fabrication_tax_rates' => $CI->mdl_fabrication_tax_rates->where('fabrication_id', $fabrication_id)->get()->result(),
            'items' => $ite,
            'devises' => $CI->mdl_devises->get()->result(),
            'arrayItems' => $arrayItems,
            'output_type' => 'pdf',
        );
        $fabrication->notes = str_replace("\n", "<br>", $fabrication->notes);
        $fabrication->notes = str_replace("\r", "<br>", $fabrication->notes);
        $fabrication_template = "default";

        $html = $CI->load->view('fabrication_templates/pdf/' . $fabrication_template, $data, true);

        // echo "<pre>";
        // print_r($arrayItems);
        // echo "</pre>";

        $CI->load->helper('mpdf');
        if (trim($fabrication->client_societe) == "") {
            return pdf_create(5, $html, lang('fabrication') . ' ' . str_replace(array('\\', '/'), '_', $fabrication->fabrication_number) . ' ' . $fabrication->client_name . '_' . $fabrication->client_prenom, $stream, null);
        } else {
            return pdf_create(5, $html, lang('fabrication') . ' ' . str_replace(array('\\', '/'), '_', $fabrication->fabrication_number) . ' ' . $fabrication->client_societe . ' ', $stream, null);
        }
    }

}
