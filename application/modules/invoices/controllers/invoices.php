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

class Invoices extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_invoices');
    }

    public function index()
    {
        $sess_facture_index = $this->session->userdata['facture_index'];
        if ($sess_facture_index == 1) {
            $this->load->model('mdl_invoices');
            // Display all invoices by default
            redirect('invoices/status/all');
        } else {
            redirect('sessions/login');
        }
    }

    public function download($invoice)
    {
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $invoice . '"');
        readfile('./uploads/archive/' . $invoice);
    }

    public function status($status = 'all', $page = 0)
    {

        $sess_facture_index = $this->session->userdata['facture_index'];
        $this->load->model('users/mdl_users');
        if ($sess_facture_index == 1) {
            // Determine which group of invoices to load
            switch ($status) {
                case 'draft':
                    $this->mdl_invoices->is_draft();
                    break;
                case 'sent':
                    $this->mdl_invoices->is_sent();
                    break;
                case 'viewed':
                    $this->mdl_invoices->is_viewed();
                    break;
                case 'paid':
                    $this->mdl_invoices->is_paid();
                    break;
            }
            $usr = $this->mdl_users->get()->result();
            $this->db->select_max('invoice_date_created');
            $query_max_dat = $this->db->get('ip_invoices')->result();
            $this->db->select_min('invoice_date_created');
            $query_min_dat = $this->db->get('ip_invoices')->result();

            $date = date('Y');
            $this->mdl_invoices->paginate(site_url('invoices/status/' . $status), $page);
            $invoices = $this->mdl_invoices->where('YEAR(ip_invoices.invoice_date_created)', $date)->get()->result();
            $rappel_quotes = $this->mdl_invoices->get_date_rappel();
            $arrayHasDates = array();
            foreach ($invoices as $invoice) {
                $has_dates = 0;
                foreach ($rappel_quotes as $rappel) {
                    if ($rappel->rappel_qote_id && $rappel->rappel_qote_id == $invoice->invoice_id) {
                        $has_dates = 1;
                        break;
                    }
                }
                array_push($arrayHasDates, $has_dates);
            }
            $this->layout->set(
                array(
                    'arrayHasDates' => $arrayHasDates,
                    'rappel_quotes' => $rappel_quotes,
                    'invoices' => $invoices,
                    'status' => $status,
                    'query_max_dat' => $query_max_dat,
                    'query_min_dat' => $query_min_dat,
                    'filter_display' => true,
                    'filter_placeholder' => lang('filter_invoices'),
                    'filter_method' => 'filter_invoices',
                    'users' => $this->mdl_users->get()->result(),
                    'invoice_statuses' => $this->mdl_invoices->statuses(),
                )
            );

            $this->layout->buffer('content', 'invoices/index');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function form($id_client = null)
    {

        if (($id_client == null || $id_client == 0) && !rightsAddFacture()) {

            redirect('invoices');
        }

        $relvar = 0;

        if (relanceautomatique() == false) {
            $relvar = $relvar + 1;

        } else {
            $relvar = 0;
        }
        $sess_facture_add = $this->session->userdata['facture_add'];
        if ($sess_facture_add == 1) {
            $invoice_client = null;

            if ($this->input->post('btn_cancel')) {
                redirect('invoices');
            }
            // var_dump($id_client);
            if ($id_client != null) {

                $this->load->model('clients/mdl_clients');
                $invoice_client = $this->mdl_clients->get_by_id($id_client);
            }

            if (!$this->input->post('btn_submit')) {

            } elseif ($this->input->post('btn_submit')) {

            }
            $this->load->model('delai_paiement/mdl_delai');
            $this->load->model('payment_methods/mdl_payment_methods');
            $this->load->model('tax_rates/mdl_tax_rates');
            //récup last id in table ip_invoices
            $this->db->select_max('invoice_number');
            $result = $this->db->get('ip_invoices')->result_array();
            $next_id = $this->mdl_settings->setting('next_code_invoice');

            $setting = 0;

            $settings = $this->mdl_tax_rates->get()->result();
            foreach ($settings as $val) {
                if ($this->mdl_settings->setting('default_invoice_tax_rate') == $val->tax_rate_id) {
                    $setting = 1;
                }
            }
            $this->layout->set(
                array(
                    'invoice_statuses' => $this->mdl_invoices->statuses(),
                    'index' => 1,
                    'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
                    'payment_methods' => $this->mdl_payment_methods->get()->result(),
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'create' => 'create',
                    'clients' => $invoice_client,
                    'next_id' => $next_id,
                    'setting' => $setting,
                    'relvar' => $relvar,
                ));
            $this->layout->buffer(
                array(
                    array('modal_delete_invoice', 'invoices/modal_delete_invoice'),
                    array('modal_add_invoice_tax', 'invoices/modal_add_invoice_tax'),
                    array('content', 'invoices/form'),
                )
            );
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function view($invoice_id)
    {
        $sess_facture_add = $this->session->userdata['facture_add'];
        $this->load->model('quotes/mdl_rappel');
        if ($sess_facture_add == 1) {
            $this->load->model(
                array(
                    'mdl_items',
                    'tax_rates/mdl_tax_rates',
                    'payment_methods/mdl_payment_methods',
                    'mdl_invoice_tax_rates',
                    'custom_fields/mdl_custom_fields',
                    'invoices/mdl_item_amounts',
                    'item_lookups/mdl_item_lookups',
                    'payments/mdl_payments',
                    'pieces/mdl_pieces',
                    'invoices/mdl_item_amounts',
                    'settings/mdl_settings',
                )
            );

            $this->load->module('payments');

            $this->load->model('custom_fields/mdl_invoice_custom');

            $invoice_custom = $this->mdl_invoice_custom->where('invoice_id', $invoice_id)->get();

            if ($invoice_custom->num_rows()) {
                $invoice_custom = $invoice_custom->row();

                unset($invoice_custom->invoice_id, $invoice_custom->invoice_custom_id);

                foreach ($invoice_custom as $key => $val) {
                    $this->mdl_invoices->set_form_value('custom[' . $key . ']', $val);
                }
            }

            $invoice = $this->mdl_invoices->get_by_id($invoice_id);

            if (!$invoice) {
                show_404();
            }

            $this->load->model('delai_paiement/mdl_delai');
            $items = $this->mdl_items->where('invoice_id', $invoice_id)->get()->result();

            $this->db->where("ip_payments.invoice_id", $invoice_id);
            $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
            $this->db->order_by("ip_payments.payment_date", "ASC");
            $this->db->order_by("ip_payments.payment_id", "ASC");
            $payments = $this->db->get("ip_payments")->result();

            $invoiceidd = $this->mdl_invoices->where('ip_invoices.invoice_id', $invoice_id)->get()->result();

            $this->db->select('file_name,doc_id as id_document');
            $this->db->where("id_client", $invoiceidd[0]->client_id);
            $this->db->where("object_id", $invoice_id);
            $this->db->like('typeobject', 'invoice');
            $this->db->from('ip_client_documents');
            $this->db->join('ip_document_rappel', 'ip_client_documents.id_document = ip_document_rappel.doc_id', 'left');
            $atbtrouve = $this->db->get()->result();

            $docnontrouve = $this->db->query("  SELECT  id_document,file_name FROM ip_client_documents where ip_client_documents.id_client=" . $invoiceidd[0]->client_id . " and id_document not in (SELECT doc_id as id_document FROM ip_document_rappel where typeobject='invoice' and ip_document_rappel.object_id =" . $invoice_id . ")");
            $reqdocnontrouve = $docnontrouve->result();

            $this->layout->set(
                array(
                    'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
                    'invoice' => $invoice,
//'item_amm' =>$items_amm,
                    'items' => $items,
                    'invoice_id' => $invoice_id,
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
                    'payments' => $payments,
                    'payment_methods' => $this->mdl_payment_methods->get()->result(),
                    'pieces' => $this->mdl_pieces->get()->result(),
                    'custom_fields' => $this->mdl_custom_fields->by_table('ip_invoice_custom')->get()->result(),
                    'item_lookups' => $this->mdl_item_lookups->get()->result(),
                    'invoice_statuses' => $this->mdl_invoices->statuses(),
                    'settingstva' => $this->mdl_settings->gettypetaxeinvoice(),
                    'index' => count($items) + 1,
                    'create' => 'edit',
                    'atbtrouve' => $atbtrouve,
                    'atbnontrouve' => $reqdocnontrouve,
                )
            );

            $this->layout->buffer(
                array(
                    array('modal_delete_invoice', 'invoices/modal_delete_invoice'),
                    array('modal_add_invoice_tax', 'invoices/modal_add_invoice_tax'),
                    array('modal_add_payment', 'payments/modal_add_payment'),
                    array('content', 'invoices/view'),
                )
            );

            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function detail($invoice_id)
    {
        $sess_facture_add = $this->session->userdata['facture_add'];
        if ($sess_facture_add == 1) {
            $this->load->model(
                array(
                    'mdl_items',
                    'tax_rates/mdl_tax_rates',
                    'payment_methods/mdl_payment_methods',
                    'mdl_invoice_tax_rates',
                    'custom_fields/mdl_custom_fields',
                    'item_lookups/mdl_item_lookups',
                )
            );

            $this->load->module('payments');

            $this->load->model('custom_fields/mdl_invoice_custom');

            $invoice_custom = $this->mdl_invoice_custom->where('invoice_id', $invoice_id)->get();

            if ($invoice_custom->num_rows()) {
                $invoice_custom = $invoice_custom->row();

                unset($invoice_custom->invoice_id, $invoice_custom->invoice_custom_id);

                foreach ($invoice_custom as $key => $val) {
                    $this->mdl_invoices->set_form_value('custom[' . $key . ']', $val);
                }
            }

            $invoice = $this->mdl_invoices->get_by_id($invoice_id);

            if (!$invoice) {
                show_404();
            }
            $this->load->model('delai_paiement/mdl_delai');
            $items = $this->mdl_items->where('invoice_id', $invoice_id)->get()->result();
            $this->layout->set(
                array(
                    'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
                    'invoice' => $invoice,
                    'items' => $items,
                    'invoice_id' => $invoice_id,
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
                    'payment_methods' => $this->mdl_payment_methods->get()->result(),
                    'custom_fields' => $this->mdl_custom_fields->by_table('ip_invoice_custom')->get()->result(),
                    'item_lookups' => $this->mdl_item_lookups->get()->result(),
                    'invoice_statuses' => $this->mdl_invoices->statuses(),
                    'index' => count($items) + 1,
                )
            );

            $this->layout->buffer(
                array(
                    array('modal_delete_invoice', 'invoices/modal_delete_invoice'),
                    array('modal_add_invoice_tax', 'invoices/modal_add_invoice_tax'),
                    array('modal_add_payment', 'payments/modal_add_payment'),
                    array('content', 'invoices/view'),
                )
            );

            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($invoice_id)
    {
        $sess_facture_del = $this->session->userdata['product_del'];
        if ($sess_facture_del == 1) {
// Get the status of the invoice
            $invoice = $this->mdl_invoices->get_by_id($invoice_id);
            $invoice_status = $invoice->invoice_status_id;

            if ($invoice_status == 1 || $this->config->item('enable_invoice_deletion') === true) {
// Delete the invoice
                $this->mdl_invoices->delete($invoice_id);
            } else {
// Add alert that invoices can't be deleted
                $this->session->set_flashdata('alert_error', lang('invoice_deletion_forbidden'));
            }

// Redirect to invoice index
            redirect('invoices/index');
        } else {
            redirect('sessions/login');
        }
    }

    public function delete_item($invoice_id, $item_id)
    {
// Delete invoice item
        $this->load->model('mdl_items');
        $this->mdl_items->delete($item_id);

// Redirect to invoice view
        redirect('invoices/view/' . $invoice_id);
    }

    public function generate_pdf($invoice_id, $stream = true, $invoice_template = null)
    {

        $this->load->helper('pdf');

        if ($this->mdl_settings->setting('mark_invoices_sent_pdf') == 1) {
            $this->mdl_invoices->mark_sent($invoice_id);
        }
        generate_invoice_pdf($invoice_id, $stream, $invoice_template);

    }

    public function generate_pdfs($stream = true, $invoice_template = null)
    {
        $this->load->helper('pdf');
        $invoice = $this->input->post('id_invoice');

        if ($this->mdl_settings->setting('mark_invoices_sent_pdf') == 1) {
            $this->mdl_invoices->mark_sent($invoice);
        }

        generate_invoice_pdf($invoice, $stream, $invoice_template);
    }

    public function delete_invoice_tax($invoice_id, $invoice_tax_rate_id)
    {
        $this->load->model('mdl_invoice_tax_rates');
        $this->mdl_invoice_tax_rates->delete($invoice_tax_rate_id);

        $this->load->model('mdl_invoice_amounts');
        $this->mdl_invoice_amounts->calculate($invoice_id);

        redirect('invoices/view/' . $invoice_id);
    }

    public function recalculate_all_invoices()
    {
        $this->db->select('invoice_id');
        $invoice_ids = $this->db->get('ip_invoices')->result();

        $this->load->model('mdl_invoice_amounts');

        foreach ($invoice_ids as $invoice_id) {
            $this->mdl_invoice_amounts->calculate($invoice_id->invoice_id);
        }
    }

    public function download_zip($t = null)
    {

        $folder_app = strtolower($this->session->userdata['licence']);
        $file = './uploads/' . $folder_app . '/temp/' . $t;

        if (is_file($file) && rightsExportLotPdf()) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Disposition: attachment; filename=factures.zip');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            @ob_clean();
            @flush();
            readfile($file);
            exit;
        } else {
            ?>
<script>
window.self.close();
</script>
<?php

        }
    }

    public function export_excel($ids = 0)
    {
        if (rightsExportExcel()) {
            $dir_path = './uploads/';
            $cnt = 0;
            $ids_array = explode("_", $ids);
            foreach ($ids_array as $invoice_id) {
                if ($cnt == 0) {
                    $this->db->where('ip_invoices.invoice_id', $invoice_id);
                } else {
                    $this->db->or_where('ip_invoices.invoice_id', $invoice_id);
                }
                $cnt++;
            }

            $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
            $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_invoices.invoice_delai_paiement', 'left');
            $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
            $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
            $this->db->join('ip_users', 'ip_users.user_id = ip_invoices.user_id', 'left');
            $invoices = $this->db->get("ip_invoices")->result();

            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()
                ->setCellValue('A1', 'N° Facture')
                ->setCellValue('B1', 'Créé')
                ->setCellValue('C1', 'Echéance')
                ->setCellValue('D1', 'Client')
                ->setCellValue('E1', 'Nature')
                ->setCellValue('F1', 'Total HT')
                ->setCellValue('G1', 'Total TTC')
                ->setCellValue('H1', 'MP')
                ->setCellValue('I1', 'Suivi');

            $cnt2 = 2;

            $this->excel->getActiveSheet()->setTitle("Liste des factures");

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

            $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            foreach ($invoices as $invoice) {

                $delai_paiement = ($invoice->delai_paiement_label != "") ? substr($invoice->delai_paiement_label, 0, -14) : "";
                $this->excel->getActiveSheet()
                    ->setCellValue('A' . $cnt2, $invoice->invoice_number)
                    ->setCellValue('B' . $cnt2, date_from_mysql($invoice->invoice_date_created))
                    ->setCellValue('C' . $cnt2, date_from_mysql($invoice->invoice_date_due))
                    ->setCellValue('D' . $cnt2, $invoice->client_name . ' ' . $invoice->client_prenom)
                    ->setCellValue('E' . $cnt2, $invoice->nature)
                    ->setCellValue('F' . $cnt2, format_devise($invoice->invoice_item_subtotal, $invoice->devise_id))
                    ->setCellValue('G' . $cnt2, format_devise($invoice->invoice_total, $invoice->devise_id))
                    ->setCellValue('H' . $cnt2, $delai_paiement)
                    ->setCellValue('I' . $cnt2, $invoice->user_name);
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

            $filename = 'Liste des factures.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_end_clean();
            ob_start();
            $objWriter->save('php://output');
        }
    }

    public function avoirajax($id)
    {
        if (rightsAddFacture()) {
            $this->load->model(
                array(
                    'invoices/mdl_invoices',
                    'invoices/mdl_items',
                    'settings/mdl_settings',
                )
            );
            // $invoice_client = $this->mdl_invoices->get_by_id($id);
            $invoice_client = $this->mdl_invoices->where('ip_invoices.invoice_id', $id)->get()->row();
            //   $invoice_client->invoice_id
            //   return var_dump($invoice_client);
            $valCode = $this->mdl_settings->setting('next_code_invoice_avoir') + 1;

            $this->mdl_settings->save('next_code_invoice_avoir', $valCode);

            $data = array(
                'user_id' => $this->session->userdata['user_id'],
                'date_create_avoir_invoice' => date('Y-m-d'),
                'invoice_id' => $invoice_client->invoice_id,
                'invoice_delai_paiement' => $invoice_client->invoice_delai_paiement,
                'client_id' => $invoice_client->client_id,
                'invoice_group_id' => $invoice_client->invoice_group_id,
                'nature' => $invoice_client->nature,
                'invoice_status_id' => $invoice_client->invoice_status_id,
                'is_read_only' => $invoice_client->is_read_only,
                'invoice_password' => $invoice_client->invoice_password,
                'invoice_date_created' => $invoice_client->invoice_date_created,
                'invoice_time_created' => date('H:i:s'),
                'invoice_date_modified' => $invoice_client->invoice_date_modified,
                'user_id_modif' => $invoice_client->user_id_modif,
                'invoice_date_due' => $invoice_client->invoice_date_due,
                'invoice_number' => $valCode,
                'invoice_terms' => $invoice_client->invoice_terms,
                'invoice_url_key' => $invoice_client->invoice_url_key,
                'payment_method' => $invoice_client->payment_method,
                'creditinvoice_parent_id' => $invoice_client->creditinvoice_parent_id,
                'quote_date_accepte' => $invoice_client->quote_date_accepte,
                'document' => $invoice_client->document,
                'joindredevis' => $invoice_client->joindredevis,
                'vu' => $invoice_client->vu,
                'avoir' => $invoice_client->avoir,
                'invoice_number_origin' => $invoice_client->invoice_number,
                'langue' => $invoice_client->langue,
            );

            $this->db->insert('ip_haveinvoices', $data);
            $haveinvoices_id = $this->db->insert_id();

            $this->db->where('invoice_id', $id);
            $data_stat_avoir = array(
                'avoir' => 1,
                'invoice_status_id' => 7,
            );
            $this->db->update('ip_invoices', $data_stat_avoir);

            $db_fact_amm = array(
                'invoice_id' => $id,
                'haveinvoice_id' => $haveinvoices_id,
                'invoice_item_subtotal' => $invoice_client->invoice_item_subtotal,
                'invoice_item_tax_total' => $invoice_client->invoice_item_tax_total,
                'invoice_tax_total' => $invoice_client->invoice_tax_total,
                'timbre_fiscale' => -(format_currency_with_symbol($this->mdl_settings->setting('default_item_timbre'))),
                //  'timbre_fiscale' => -0.600,
                'invoice_total' => $invoice_client->invoice_total - (format_currency_with_symbol($this->mdl_settings->setting('default_item_timbre')) + $invoice_client->timbre_fiscale),
                'invoice_pourcent_remise' => $invoice_client->invoice_pourcent_remise,
                'invoice_montant_remise' => $invoice_client->invoice_montant_remise,
                'invoice_pourcent_acompte' => $invoice_client->invoice_pourcent_acompte,
                'invoice_montant_acompte' => $invoice_client->invoice_montant_acompte,
                'invoice_item_subtotal_final' => $invoice_client->invoice_item_subtotal_final,
                'invoice_item_tax_total_final' => $invoice_client->invoice_item_tax_total_final,
                //'invoice_total_final' => $this->input->post('invoice_total_final'),
                'invoice_balance' => $invoice_client->invoice_total - (format_currency_with_symbol($this->mdl_settings->setting('default_item_timbre')) + $invoice_client->timbre_fiscale),
            );

            $this->db->insert('ip_have_invoice_amounts', $db_fact_amm);

            $invoice_items = $this->mdl_items->where('invoice_id', $id)->get()->result();

            foreach ($invoice_items as $invoice_item) {
                $db_array = array(
                    'invoice_id' => $id,
                    'haveinvoice_id' => $haveinvoices_id,
                    'item_tax_rate_id' => $invoice_item->item_tax_rate_id,
                    'item_name' => $invoice_item->item_name,
                    'item_code' => $invoice_item->item_code,
                    'item_description' => $invoice_item->item_description,
                    'item_quantity' => $invoice_item->item_quantity,
                    'item_price' => $invoice_item->item_price,
                    'item_order' => $invoice_item->item_order,
                );
                $this->db->insert('ip_haveinvoice_items', $db_array);
                $id_item = $this->db->insert_id();
                $db_array2 = array(
                    'item_id' => $id_item,
                    'item_subtotal' => $invoice_item->item_subtotal,
                    'item_tax_total' => $invoice_item->item_tax_total,
                    'item_total' => $invoice_item->item_total,
                );
                $this->db->insert('ip_haveinvoice_item_amounts', $db_array2);
                //                $this->mdl_items->save($invoice_id, NULL, $db_array);
            }

            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "invoice_to_haveinvoice",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $id,
                    "log_field2" => $haveinvoices_id,
                );
                $this->db->insert('ip_logs', $data_log);
            }

            redirect('invoices/avoir');
        }
    }

    public function avoir()
    {

        $sess_facture_index = $this->session->userdata['facture_index'];

        if ($sess_facture_index == 1) {
            $this->db->select_max('invoice_date_created');
            $query_max_dat = $this->db->get('ip_haveinvoices')->result();
            $this->load->model('users/mdl_users');

            $usr = $this->mdl_users->get()->result();
            // $this->load->model('payment_methods/mdl_payment_methods');

            $this->layout->set(
                array(
                    'filter_placeholder' => lang('filter_avoir'),
                    'query_max_dat' => $query_max_dat,
                    'users' => $usr,
                    //  'payment_methods' => $this->mdl_payment_methods->get()->result(),
                )
            );

            $this->layout->buffer('content', 'invoices/indexavoir');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function viewavoir($invoice_id)
    {
        $sess_facture_add = $this->session->userdata['facture_add'];
        $this->load->model('quotes/mdl_rappel');
        $this->load->model('invoices/mdl_invoices_avoir');

        if ($sess_facture_add == 1) {
            $this->load->model(
                array(
                    'mdl_items',
                    'tax_rates/mdl_tax_rates',
                    'payment_methods/mdl_payment_methods',
                    'mdl_invoice_tax_rates',
                    'custom_fields/mdl_custom_fields',
                    'invoices/mdl_item_amounts',
                    'item_lookups/mdl_item_lookups',
                    'payments/mdl_payments',
                    'pieces/mdl_pieces',
                    'invoices/mdl_item_amounts',
                    'settings/mdl_settings',
                )
            );

            $this->load->module('payments');

            $invoice = $this->mdl_invoices_avoir->get_by_id($invoice_id);
            //  VAR_dump($invoice);
            if (!$invoice) {
                show_404();
            }

            $this->load->model('delai_paiement/mdl_delai');
            $items = $this->mdl_items->where('invoice_id', $invoice_id)->get()->result();

            $this->db->where("ip_payments.invoice_id", $invoice_id);
            $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
            $this->db->order_by("ip_payments.payment_date", "ASC");
            $this->db->order_by("ip_payments.payment_id", "ASC");
            $payments = $this->db->get("ip_payments")->result();

            $invoiceidd = $this->mdl_invoices_avoir->where('ip_haveinvoices.haveinvoice_id', $invoice_id)->get()->result();

            $this->layout->set(
                array(
                    'delaiPaiement' => $this->mdl_delai->order_by('delai_paiement_id', 'asc')->get()->result(),
                    'invoice' => $invoice,
//'item_amm' =>$items_amm,
                    'items' => $items,
                    'invoice_id' => $invoice_id,
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
                    'payments' => $payments,
                    'payment_methods' => $this->mdl_payment_methods->get()->result(),
                    'pieces' => $this->mdl_pieces->get()->result(),
                    'custom_fields' => $this->mdl_custom_fields->by_table('ip_invoice_custom')->get()->result(),
                    'item_lookups' => $this->mdl_item_lookups->get()->result(),
                    'settingstva' => $this->mdl_settings->gettypetaxeinvoice(),
                    'index' => count($items) + 1,
                    'create' => 'edit',
                )
            );

            $this->layout->buffer(
                array(
                    array('modal_delete_invoice', 'invoices/modal_delete_invoice'),
                    array('modal_add_invoice_tax', 'invoices/modal_add_invoice_tax'),
                    array('modal_add_payment', 'payments/modal_add_payment'),
                    array('content', 'invoices/viewavoir'),
                )
            );

            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function generate_pdf_avoir($invoice_id, $stream = true, $invoice_template = null)
    {
        $this->load->model(
            array(
                'invoices/mdl_invoices_avoir',
                'settings/mdl_settings',
            ));
        $this->load->helper('pdf');

        /*  if ($this->mdl_settings->setting('mark_invoices_sent_pdf') == 1) {
        $this->mdl_invoices_avoir->mark_sent($invoice_id);
        }*/
        generate_avoir_pdf($invoice_id, $stream, $invoice_template);

    }


    public function export_excelall($ids = 0)
    {
        if (rightsExportExcel()) {
            $dir_path = './uploads/';
            $cnt = 0;
            $ids_array = explode("_", $ids);
          

            $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
            $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_invoices.invoice_delai_paiement', 'left');
            $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
            $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
            $this->db->join('ip_users', 'ip_users.user_id = ip_invoices.user_id', 'left');
            $invoices = $this->db->get("ip_invoices")->result();

            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()
                ->setCellValue('A1', 'N° Facture')
                ->setCellValue('B1', 'Créé')
                ->setCellValue('C1', 'Echéance')
                ->setCellValue('D1', 'Client')
                ->setCellValue('E1', 'Nature')
                ->setCellValue('F1', 'Total HT')
                ->setCellValue('G1', 'Total TTC')
                ->setCellValue('H1', 'MP')
                ->setCellValue('I1', 'Suivi');

            $cnt2 = 2;

            $this->excel->getActiveSheet()->setTitle("Liste des factures");

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

            $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            foreach ($invoices as $invoice) {

                $delai_paiement = ($invoice->delai_paiement_label != "") ? substr($invoice->delai_paiement_label, 0, -14) : "";
                $this->excel->getActiveSheet()
                    ->setCellValue('A' . $cnt2, $invoice->invoice_number)
                    ->setCellValue('B' . $cnt2, date_from_mysql($invoice->invoice_date_created))
                    ->setCellValue('C' . $cnt2, date_from_mysql($invoice->invoice_date_due))
                    ->setCellValue('D' . $cnt2, $invoice->client_name . ' ' . $invoice->client_prenom)
                    ->setCellValue('E' . $cnt2, $invoice->nature)
                    ->setCellValue('F' . $cnt2, format_devise($invoice->invoice_item_subtotal, $invoice->devise_id))
                    ->setCellValue('G' . $cnt2, format_devise($invoice->invoice_total, $invoice->devise_id))
                    ->setCellValue('H' . $cnt2, $delai_paiement)
                    ->setCellValue('I' . $cnt2, $invoice->user_name);
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

            $filename = 'Liste des factures.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

}