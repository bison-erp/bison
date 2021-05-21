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

class Bl extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_bl');
        $this->load->model('mdl_settings');
    }
    public function index()
    {
        $this->load->model('users/mdl_users');
        $this->layout->set(
            array(
                'users' => $this->mdl_users->get()->result(),
                'filter_display' => true,

            )
        );
        $this->layout->buffer(
            array(
                array('content', 'bl/index'),
            )
        );
        $this->layout->render();
    }
    public function form($id = null,$id_client=null)
    {        
        $nextcode = $this->mdl_settings->setting('next_code_bl');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('clients/mdl_clients');
        $this->load->model('delai_paiement/mdl_delai');

        $this->layout->set(
            array(
                'client' => $this->mdl_clients->where('ip_clients.client_id', $id_client)->get()->result()[0],
                'nextcode' => $nextcode,
                'quote_statuses' => $this->mdl_quotes->statuses(),
                'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
            )
        );
        $this->layout->buffer(
            array(
                array('content', 'bl/form'),
            )
        );
        $this->layout->render();
    }

    public function view($bl_id)
    {
        $sess_devis_add = $this->session->userdata['devis_add'];
        $this->load->model('mdl_bl');
        $this->load->model('quotes/mdl_quotes');

        if ($sess_devis_add == 1) {
            $this->load->model('bl/mdl_bl_items');
            $this->load->model('tax_rates/mdl_tax_rates');
            $this->load->model('bl/mdl_bl_tax_rates');
            $this->load->model('custom_fields/mdl_custom_fields');
            //  $this->load->model('custom_fields/mdl_bl_custom');
            $this->load->model('delai_paiement/mdl_delai');
            $this->load->library('encrypt');

            //   $bl_custom = $this->mdl_quote_custom->where('quote_id', $bl_id)->get();

            $bl = $this->mdl_bl->get_by_id($bl_id);

            if (!$bl) {
                show_404();
            }

            $items = $this->mdl_bl_items->where('bl_id', $bl_id)->get()->result();
            // $qouteobj = $this->mdl_bl->where('ip_bl.bl_id', $bl_id)->get()->result();

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
                    'quote' => $bl,
                    'items' => $items,
                    'quote_id' => $bl_id,
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'bl_tax_rates' => $this->mdl_bl_tax_rates->where('bl_id', $bl_id)->get()->result(),
                    'custom_fields' => $this->mdl_custom_fields->by_table('ip_bl_custom')->get()->result(),
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
                    array('content', 'bl/view'),
                )
            );

            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($bl_id)
    {
        $sess_devis_del = $this->session->userdata['devis_del'];
        if ($sess_devis_del == 1) {
            $data_del = array(
                'delete' => 1,
            );

            $this->db->where('bl_id', $bl_id);
            $this->db->update('ip_bl', $data_del);
            // Redirect to quote index
            redirect('bl/index');
        } else {
            redirect('sessions/login');
        }
    }

    public function generate_pdf($bl_id, $stream = true, $bl_template = null)
    {
        $this->load->helper('pdf');
        $this->generate_bl_pdf($bl_id, $stream, $bl_template);

    }
    
    public function generate_bl_pdf($bl_id, $stream = true, $bl_template = null)
    {
        $CI = &get_instance();
        $CI->load->model('bl/mdl_bl');
        $CI->load->model('bl/mdl_bl_items');
        $CI->load->model('bl/mdl_bl_tax_rates');
        $CI->load->model('families/mdl_families');
        $CI->load->model('societes/mdl_societes');
        $CI->load->model('devises/mdl_devises');
        $CI->load->helper('country');
        $bl = $CI->mdl_bl->get_by_id($bl_id);
        $societe = $CI->mdl_societes->get_by_id(1);

        $bl_template = "default";

        $item_familles = $CI->mdl_families->get()->result();
        $arrayItems = array();
        // foreach ($item_familles as $famille) {

        // }

        array_push($arrayItems, $CI->db
                ->where('bl_id', $bl_id)
                ->join('ip_bl_item_amounts', 'ip_bl_item_amounts.item_id = ip_bl_items.item_id')
                ->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_bl_items.item_tax_rate_id')
                ->order_by("ip_bl_items.item_order", "asc")
                ->get('ip_bl_items')
                ->result());
        $ite = $CI->db->select()->from('ip_bl_items')->where('bl_id', $bl_id)->order_by("ip_bl_items.item_order", "asc")->get()->result();
        $respdf = 0;
        if($this->mdl_settings->setting('pdf_bl_template')!="avec entête"){
            $respdf = $respdf+1;
        }
     
        $data = array(
            'typepdf' => $respdf,
            'bl' => $bl,
            'countries' => get_country_list(lang('cldr')),
            'societe' => $societe,
            'bl_tax_rates' => $CI->mdl_bl_tax_rates->where('bl_id', $bl_id)->get()->result(),
            'items' => $ite,
            'devises' => $CI->mdl_devises->get()->result(),
            'arrayItems' => $arrayItems,
            'output_type' => 'pdf',
        );
        $bl->notes = str_replace("\n", "<br>", $bl->notes);
        $bl->notes = str_replace("\r", "<br>", $bl->notes);
        $bl_template = "default";

        $html = $CI->load->view('bl_templates/pdf/' . $bl_template, $data, true);

        // echo "<pre>";
        // print_r($arrayItems);
        // echo "</pre>";

        $CI->load->helper('mpdf');
        if (trim($bl->client_societe) == "") {
            return pdf_create(3, $html, lang('bl') . ' ' . str_replace(array('\\', '/'), '_', $bl->bl_number) . ' ' . $bl->client_name . '_' . $bl->client_prenom, $stream, null);
        } else {
            return pdf_create(3, $html, lang('bl') . ' ' . str_replace(array('\\', '/'), '_', $bl->bl_number) . ' ' . $bl->client_societe . ' ', $stream, null);
        }
    }

    public function export_excel($ids = 0)
    {  
        if (rightsExportExcel()) {
            $dir_path = './uploads/';
            $cnt = 0;
            $ids_array = explode("_", $ids);
            foreach ($ids_array as $quote_id) {
                if ($cnt == 0) {
                    $this->db->where('ip_bl.bl_id', $quote_id);
                } else {
                    $this->db->or_where('ip_bl.bl_id', $quote_id);
                }
                $cnt++;
            }

            $this->db->join('ip_clients', 'ip_clients.client_id = ip_bl.client_id', 'left');
            $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
            $this->db->join('ip_users', 'ip_users.user_id = ip_bl.user_id', 'left');
            $this->db->join('ip_bl_ammont', 'ip_bl_ammont.bl_id = ip_bl.bl_id', 'left');
            $quotes = $this->db->get("ip_bl")->result();
         //   return var_dump($quotes );
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()
                ->setCellValue('A1', 'N°')
                ->setCellValue('B1', 'Créé')
                ->setCellValue('C1', 'Echéance')
                ->setCellValue('D1', 'Client')
                ->setCellValue('E1', 'Nature')
                ->setCellValue('F1', 'Total HT')
                ->setCellValue('G1', 'Total TTC')
              //  ->setCellValue('H1', 'MP')
                ->setCellValue('H1', 'Suivi');

            $cnt2 = 2;

            $this->excel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->excel->getActiveSheet()->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('FFDDDDDD');
//        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->applyFromArray(array('rgb' => '808080'));
            $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
          //  $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $this->excel->getActiveSheet()->setTitle("Liste des bl");

            $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            foreach ($quotes as $quote) {
                $this->excel->getActiveSheet()
                    ->setCellValue('A' . $cnt2, $quote->bl_number)
                    ->setCellValue('B' . $cnt2, date_from_mysql($quote->quote_date_created))
                    ->setCellValue('C' . $cnt2, date_from_mysql($quote->quote_date_expires))
                    ->setCellValue('D' . $cnt2, $quote->client_name . ' ' . $quote->client_prenom)
                    ->setCellValue('E' . $cnt2, $quote->bl_nature)
                    ->setCellValue('F' . $cnt2, format_devise($quote->bl_item_subtotal_final, $quote->devise_id))
                    ->setCellValue('G' . $cnt2, format_devise($quote->bl_total_final, $quote->devise_id))
                  //  ->setCellValue('H' . $cnt2, $delai_paiement)
                    ->setCellValue('H' . $cnt2, $quote->user_name);
                $this->excel->getActiveSheet()->getStyle('A' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('F' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $this->excel->getActiveSheet()->getStyle('G' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $this->excel->getActiveSheet()->getStyle('H' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              //  $this->excel->getActiveSheet()->getStyle('I' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $cnt2++;
            }

            $filename = 'Liste des bl.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

}