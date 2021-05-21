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

class Commande extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_commande');
        $this->load->model('mdl_settings');
    }
    public function index()
    {
        $this->load->model('users/mdl_users');
        $usr = $this->mdl_users->get()->result();
        $this->layout->set(
            array(

                'filter_display' => true,
                'users' => $usr,                
            )
        );
        $this->layout->buffer(
            array(
                array('content', 'commande/index'),
            )
        );
        $this->layout->render();
    }
    public function form($id = null,$id_client=null)
    {
        $nextcode = $this->mdl_settings->setting('next_code_bc');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('delai_paiement/mdl_delai');
        $this->load->model('clients/mdl_clients');
        $this->layout->set(
            array(
                'client' => $this->mdl_clients->where('ip_clients.client_id', $id_client)->get()->result()[0],
                'nextcode' => (int)$nextcode,
                'quote_statuses' => $this->mdl_quotes->statuses(),
                'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
            )
        );
        $this->layout->buffer(
            array(
                array('content', 'commande/form'),
            )
        );
        $this->layout->render();
    }

    public function view($commande_id)
    {
        $sess_devis_add = $this->session->userdata['devis_add'];
        $this->load->model('mdl_commande');
        $this->load->model('quotes/mdl_quotes');

        if ($sess_devis_add == 1) {
            $this->load->model('commande/mdl_commande_items');
            $this->load->model('tax_rates/mdl_tax_rates');
            $this->load->model('commande/mdl_commande_tax_rates');
            $this->load->model('custom_fields/mdl_custom_fields');
            //  $this->load->model('custom_fields/mdl_commande_custom');
            $this->load->model('delai_paiement/mdl_delai');
            $this->load->library('encrypt');

            //   $commande_custom = $this->mdl_quote_custom->where('quote_id', $commande_id)->get();

            $commande = $this->mdl_commande->get_by_id($commande_id);

            if (!$commande) {
                show_404();
            }

            $items = $this->mdl_commande_items->where('commande_id', $commande_id)->get()->result();
            // $qouteobj = $this->mdl_commande->where('ip_commande.commande_id', $commande_id)->get()->result();

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
            
            $this->layout->set(
                array(
                    'quote' => $commande,
                    'items' => $items,
                    'quote_id' => $commande_id,
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'commande_tax_rates' => $this->mdl_commande_tax_rates->where('commande_id', $commande_id)->get()->result(),
                    'custom_fields' => $this->mdl_custom_fields->by_table('ip_commande_custom')->get()->result(),
                    'quote_statuses' => $this->mdl_quotes->statuses(),
                    'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
                    'index' => count($items) + 1,
                    'create' => 'edit',                   
                     
                )
            );

            $this->layout->buffer(
                array(
                    //   array('modal_delete_quote', 'quotes/modal_delete_quote'),
                    //   array('modal_add_quote_tax', 'quotes/modal_add_quote_tax'),
                    array('content', 'commande/view'),
                )
            );

            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($commande_id)
    {
        $sess_devis_del = $this->session->userdata['devis_del'];
        if ($sess_devis_del == 1) {
            $data_del = array(
                'delete' => 1,
            );

            $this->db->where('commande_id', $commande_id);
            $this->db->update('ip_commande', $data_del);
            redirect('commande/index');
        } else {
            redirect('sessions/login');
        }
    }

    public function generate_pdf($commande_id, $stream = true, $commande_template = null)
    {
        $this->load->helper('pdf');
        $this->generate_commande_pdf($commande_id, $stream, $commande_template);

    }

    public function generate_commande_pdf($commande_id, $stream = true, $commande_template = null)
    {
        $CI = &get_instance();
        $CI->load->model('commande/mdl_commande');
        $CI->load->model('commande/mdl_commande_items');
        $CI->load->model('commande/mdl_commande_tax_rates');
        $CI->load->model('families/mdl_families');
        $CI->load->model('societes/mdl_societes');
        $CI->load->model('devises/mdl_devises');
        $CI->load->helper('country');
        $commande = $CI->mdl_commande->get_by_id($commande_id);
        $societe = $CI->mdl_societes->get_by_id(1);

        $commande_template = "default";

        $item_familles = $CI->mdl_families->get()->result();
        $arrayItems = array();
        // foreach ($item_familles as $famille) {

        // }

        array_push($arrayItems, $CI->db
                ->where('commande_id', $commande_id)
                ->join('ip_commande_item_amounts', 'ip_commande_item_amounts.item_id = ip_commande_items.item_id')
                ->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_commande_items.item_tax_rate_id')
                ->order_by("ip_commande_items.item_order", "asc")
                ->get('ip_commande_items')
                ->result());
        $ite = $CI->db->select()->from('ip_commande_items')->where('commande_id', $commande_id)->order_by("ip_commande_items.item_order", "asc")->get()->result();
        $respdf = 0;
        if($this->mdl_settings->setting('pdf_commande_template')!="avec entête"){
            $respdf = $respdf+1;
        }
         
        $data = array(
            'typepdf' => $respdf,
            'commande' => $commande,
            'countries' => get_country_list(lang('cldr')),
            'societe' => $societe,
            'commande_tax_rates' => $CI->mdl_commande_tax_rates->where('commande_id', $commande_id)->get()->result(),
            'items' => $ite,
            'devises' => $CI->mdl_devises->get()->result(),
            'arrayItems' => $arrayItems,
            'output_type' => 'pdf',
        );
        $commande->notes = str_replace("\n", "<br>", $commande->notes);
        $commande->notes = str_replace("\r", "<br>", $commande->notes);
        $commande_template = "default";

        $html = $CI->load->view('commande_templates/pdf/' . $commande_template, $data, true);

        // echo "<pre>";
        // print_r($arrayItems);
        // echo "</pre>";

        $CI->load->helper('mpdf');
        if (trim($commande->client_societe) == "") {
            return pdf_create(4, $html, lang('commande') . ' ' . str_replace(array('\\', '/'), '_', $commande->commande_number) . ' ' . $commande->client_name . '_' . $commande->client_prenom, $stream, null);
        } else {
            return pdf_create(4, $html, lang('commande') . ' ' . str_replace(array('\\', '/'), '_', $commande->commande_number) . ' ' . $commande->client_societe . ' ', $stream, null);
        }
    }

}
