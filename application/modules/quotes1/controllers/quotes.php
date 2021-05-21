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

class Quotes extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_quotes');
    }

    public function index()
    {
        $sess_devis_index = $this->session->userdata['devis_index'];

        if ($sess_devis_index == 1) {
            // Display all quotes by default
            //$db = $this->load->database('default');
            $this->load->model('mdl_quotes');
            //echo 'ede';
            //$query = $this->db->query('select max(year(`quote_date_created`))from `ip_quotes` ')->get()->result();
            // $this->db->select('*');
            //$this->db->from('ip_quotes');
            //$val = $this->db->get();
            //echo '<pre>';
            // print_r ($val); echo '</pre>';
            //echo 'ddd';die;
            //$row = $query->row();

            redirect('quotes/status/all');
        } else {
            redirect('sessions/login');
        }
    }

    public function status($status = 'all', $page = 0)
    {
        $this->load->model('users/mdl_users');
        // Determine which group of quotes to load
        switch ($status) {
            case 'draft':
                $this->mdl_quotes->is_draft();
                break;
            case 'sent':
                $this->mdl_quotes->is_sent();
                break;
            case 'viewed':
                $this->mdl_quotes->is_viewed();
                break;
            case 'approved':
                $this->mdl_quotes->is_approved();
                break;
            case 'rejected':
                $this->mdl_quotes->is_rejected();
                break;
            case 'canceled':
                $this->mdl_quotes->is_canceled();
                break;
            case 'negotiation':
                $this->mdl_quotes->is_negotiation();
                break;
        }

        // $this->mdl_quotes->paginate(site_url('quotes/status/' . $status), $page);
        $date = date('Y');
        $this->db->where('ip_quotes.delete', 1);
        $this->db->where('YEAR(ip_quotes.quote_date_created)', $date);
        $quotes = $this->mdl_quotes->get()->result();
        $this->db->select_max('quote_date_created');
        $query_max_dat = $this->db->get('ip_quotes')->result();
        $this->db->select_min('quote_date_created');
        $query_min_dat = $this->db->get('ip_quotes')->result();

        $rappel_quotes = $this->mdl_quotes->get_date_rappel();
        $arrayHasDates = array();
        foreach ($quotes as $quote) {
            $has_dates = 0;
            foreach ($rappel_quotes as $rappel) {
                if ($rappel->rappel_qote_id && $rappel->rappel_qote_id == $quote->quote_id) {
                    $has_dates = 1;
                    break;
                }
            }
            array_push($arrayHasDates, $quote->quote_id . '//' . $has_dates);
        }

        //0 pdf avec entete;
        //1 pdf sans entete;

        $this->layout->set(
            array(
                'arrayHasDates' => $arrayHasDates,
                'rappel_quotes' => $rappel_quotes,
                'quotes' => $quotes,
                'query_max_dat' => $query_max_dat,
                'query_min_dat' => $query_min_dat,
                'status' => $status,
                'filter_display' => true,
                'filter_placeholder' => lang('filter_quotes'),
                'filter_method' => 'filter_quotes',
                'quote_statuses' => $this->mdl_quotes->statuses(),
                'users' => $this->mdl_users->get()->result(),
            )
        );

        $this->layout->buffer('content', 'quotes/index');
        $this->layout->render();
    }

    public function form($id_client = null)
    {

        if (($id_client == null || $id_client == 0) && !rightsAddDevis()) {

            redirect('quotes');
        }

        $sess_devis_add = $this->session->userdata['devis_add'];

        if ($sess_devis_add == 1) {
            $quote_client = null;

            if ($this->input->post('btn_cancel')) {
                redirect('quotes');
            }

            if ($id_client != null) {
                $this->load->model('clients/mdl_clients');
                $quote_client = $this->mdl_clients->get_by_id($id_client);
            }
            /* if ($this->mdl_quotes->run_validation()) {
            $id = $this->mdl_quotes->save($id);

            redirect('quotes/view/' . $id);
            } */

            if (!$this->input->post('btn_submit')) {
                /* if (!$this->mdl_quotes->prep_form($id)) {
            show_404();
            } */
            } elseif ($this->input->post('btn_submit')) {

            }
            $this->load->model('delai_paiement/mdl_delai');
            $this->load->model('tax_rates/mdl_tax_rates');
            $this->load->model('settings/mdl_settings');
            $this->layout->set(
                array(
                    'quote_statuses' => $this->mdl_quotes->statuses(),
                    'index' => 1,
                    'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'create' => 'create',
                    'clients' => $quote_client,
                ));
            $this->layout->buffer(
                array(
                    array('modal_delete_quote', 'quotes/modal_delete_quote'),
                    array('modal_add_quote_tax', 'quotes/modal_add_quote_tax'),
                    array('content', 'quotes/form'),
                )
            );
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function view($quote_id)
    {
        $sess_devis_add = $this->session->userdata['devis_add'];
        $this->load->model('quotes/mdl_rappel');

        if ($sess_devis_add == 1) {
            $this->load->model('mdl_quote_items');
            $this->load->model('tax_rates/mdl_tax_rates');
            $this->load->model('mdl_quote_tax_rates');
            $this->load->model('custom_fields/mdl_custom_fields');
            $this->load->model('custom_fields/mdl_quote_custom');
            $this->load->model('delai_paiement/mdl_delai');
            $this->load->library('encrypt');

            $quote_custom = $this->mdl_quote_custom->where('quote_id', $quote_id)->get();

            if ($quote_custom->num_rows()) {
                $quote_custom = $quote_custom->row();

                unset($quote_custom->quote_id, $quote_custom->quote_custom_id);

                foreach ($quote_custom as $key => $val) {
                    $this->mdl_quotes->set_form_value('custom[' . $key . ']', $val);
                }
            }

            $quote = $this->mdl_quotes->get_by_id($quote_id);

            if (!$quote) {
                show_404();
            }
            $items = $this->mdl_quote_items->where('quote_id', $quote_id)->get()->result();

            $qouteobj = $this->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->result();

            $this->db->select('file_name,doc_id as id_document');
            $this->db->where("id_client", $qouteobj[0]->client_id);
            $this->db->where("object_id", $quote_id);
            $this->db->like('typeobject', 'quote');
            $this->db->from('ip_client_documents');
            $this->db->join('ip_document_rappel', 'ip_client_documents.id_document = ip_document_rappel.doc_id', 'left');
            $atbtrouve = $this->db->get()->result();

            $docnontrouve = $this->db->query("  SELECT  id_document,file_name FROM ip_client_documents where ip_client_documents.id_client=" . $qouteobj[0]->client_id . " and id_document not in (SELECT doc_id as id_document FROM ip_document_rappel where typeobject='quote' and ip_document_rappel.object_id =" . $quote_id . ")");
            $reqdocnontrouve = $docnontrouve->result();

            $this->layout->set(
                array(
                    'quote' => $quote,
                    'items' => $items,
                    'quote_id' => $quote_id,
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'quote_tax_rates' => $this->mdl_quote_tax_rates->where('quote_id', $quote_id)->get()->result(),
                    'custom_fields' => $this->mdl_custom_fields->by_table('ip_quote_custom')->get()->result(),
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
                    array('modal_delete_quote', 'quotes/modal_delete_quote'),
                    array('modal_add_quote_tax', 'quotes/modal_add_quote_tax'),
                    array('content', 'quotes/view'),
                )
            );

            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($quote_id)
    {
        $sess_devis_del = $this->session->userdata['devis_del'];
        if ($sess_devis_del == 1) {

            ///activité
            // Delete the quote
            //$this->mdl_quotes->delete($quote_id);
            $data_del = array(
                'delete' => 1,
            );

            $this->db->where('quote_id', $quote_id);
            $this->db->update('ip_quotes', $data_del);
            // Redirect to quote index
            redirect('quotes/index');
        } else {
            redirect('sessions/login');
        }
    }

    public function delete_item($quote_id, $item_id)
    {
        // Delete quote item
        $this->load->model('mdl_quote_items');
        $this->mdl_quote_items->delete($item_id);
        $this->db->query("UPDATE `ip_quotes` SET  `quote_user_modif`=" . $this->session->userdata('user_id') . "
                     WHERE `quote_id` =  " . $quote_id);

        // Redirect to quote view
        //   redirect('quotes/view/' . $quote_id);
        // Redirect to quote index
        redirect('quotes/index');
    }

    public function generate_pdf($quote_id, $stream = true, $quote_template = null)
    {
        print_r($quote_id);
        $this->load->helper('pdf');

        /*  if ($this->mdl_settings->setting('mark_quotes_sent_pdf') == 1) {
        $this->mdl_quotes->mark_sent($quote_id);
        }*/

        generate_quote_pdf($quote_id, $stream, $quote_template);
    }

    public function delete_quote_tax($quote_id, $quote_tax_rate_id)
    {
        $this->load->model('mdl_quote_tax_rates');
        $this->mdl_quote_tax_rates->delete($quote_tax_rate_id);

        $this->load->model('mdl_quote_amounts');
        $this->mdl_quote_amounts->calculate($quote_id);

        redirect('quotes/view/' . $quote_id);
    }

    public function recalculate_all_quotes()
    {
        $this->db->select('quote_id');
        $quote_ids = $this->db->get('ip_quotes')->result();

        $this->load->model('mdl_quote_amounts');

        foreach ($quote_ids as $quote_id) {
            $this->mdl_quote_amounts->calculate($quote_id->quote_id);
        }
    }

    public function test()
    {

//        $this->db->select("coalesce(client_societe, client_id)");
        //            $this->db->select("CONCAT(ip_clients.client_name, ' ', ip_clients.client_prenom) AS name221", FALSE);
        $this->db->select("client_id,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe from ip_clients");
//        $this->db->select("CONCAT_WS(',',client_name,client_prenom) AS test from ip_clients");

        $quotes = $this->db->get()->result();
        print_r($quotes);
    }

    public function export_excel($ids = 0)
    {
        if (rightsExportExcel()) {
            $dir_path = './uploads/';
            $cnt = 0;
            $ids_array = explode("_", $ids);
            foreach ($ids_array as $quote_id) {
                if ($cnt == 0) {
                    $this->db->where('ip_quotes.quote_id', $quote_id);
                } else {
                    $this->db->or_where('ip_quotes.quote_id', $quote_id);
                }
                $cnt++;
            }

            $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
            $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
            $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_quotes.quote_delai_paiement', 'left');
            $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
            $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
            $quotes = $this->db->get("ip_quotes")->result();

            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()
                ->setCellValue('A1', 'N° Devis')
                ->setCellValue('B1', 'Créé')
                ->setCellValue('C1', 'Echéance')
                ->setCellValue('D1', 'Client')
                ->setCellValue('E1', 'Nature')
                ->setCellValue('F1', 'Total HT')
                ->setCellValue('G1', 'Total TTC')
                ->setCellValue('H1', 'MP')
                ->setCellValue('I1', 'Suivi');

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
            $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $this->excel->getActiveSheet()->setTitle("Liste des devis");

            $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            foreach ($quotes as $quote) {

                $delai_paiement = ($quote->delai_paiement_label != "") ? substr($quote->delai_paiement_label, 0, -14) : "";
                $this->excel->getActiveSheet()
                    ->setCellValue('A' . $cnt2, $quote->quote_number)
                    ->setCellValue('B' . $cnt2, date_from_mysql($quote->quote_date_created))
                    ->setCellValue('C' . $cnt2, date_from_mysql($quote->quote_date_expires))
                    ->setCellValue('D' . $cnt2, $quote->client_name . ' ' . $quote->client_prenom)
                    ->setCellValue('E' . $cnt2, $quote->quote_nature)
                    ->setCellValue('F' . $cnt2, format_devise($quote->quote_item_subtotal_final, $quote->devise_id))
                    ->setCellValue('G' . $cnt2, format_devise($quote->quote_total_final, $quote->devise_id))
                    ->setCellValue('H' . $cnt2, $delai_paiement)
                    ->setCellValue('I' . $cnt2, $quote->user_name);
                $this->excel->getActiveSheet()->getStyle('A' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('F' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $this->excel->getActiveSheet()->getStyle('G' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $this->excel->getActiveSheet()->getStyle('H' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('I' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $cnt2++;
            }

            $filename = 'Liste des devis.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }
    }



    public function export_excelall()
    {
        if (rightsExportExcel()) {
            $dir_path = './uploads/';
            $cnt = 0;
            $ids_array = explode("_", $ids);
            
            $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
            $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
            $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_quotes.quote_delai_paiement', 'left');
            $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
            $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
            $quotes = $this->db->get("ip_quotes")->result();

            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()
                ->setCellValue('A1', 'N° Devis')
                ->setCellValue('B1', 'Créé')
                ->setCellValue('C1', 'Echéance')
                ->setCellValue('D1', 'Client')
                ->setCellValue('E1', 'Nature')
                ->setCellValue('F1', 'Total HT')
                ->setCellValue('G1', 'Total TTC')
                ->setCellValue('H1', 'MP')
                ->setCellValue('I1', 'Suivi');

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
            $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $this->excel->getActiveSheet()->setTitle("Liste des devis");

            $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            foreach ($quotes as $quote) {

                $delai_paiement = ($quote->delai_paiement_label != "") ? substr($quote->delai_paiement_label, 0, -14) : "";
                $this->excel->getActiveSheet()
                    ->setCellValue('A' . $cnt2, $quote->quote_number)
                    ->setCellValue('B' . $cnt2, date_from_mysql($quote->quote_date_created))
                    ->setCellValue('C' . $cnt2, date_from_mysql($quote->quote_date_expires))
                    ->setCellValue('D' . $cnt2, $quote->client_name . ' ' . $quote->client_prenom)
                    ->setCellValue('E' . $cnt2, $quote->quote_nature)
                    ->setCellValue('F' . $cnt2, format_devise($quote->quote_item_subtotal_final, $quote->devise_id))
                    ->setCellValue('G' . $cnt2, format_devise($quote->quote_total_final, $quote->devise_id))
                    ->setCellValue('H' . $cnt2, $delai_paiement)
                    ->setCellValue('I' . $cnt2, $quote->user_name);
                $this->excel->getActiveSheet()->getStyle('A' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('F' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $this->excel->getActiveSheet()->getStyle('G' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $this->excel->getActiveSheet()->getStyle('H' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('I' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $cnt2++;
            }

            $filename = 'Liste des devis.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

}