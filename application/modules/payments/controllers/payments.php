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

class Payments extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_payments');
    }

    public function index()
    {
        $sess_payement_index = $this->session->userdata['payement_index'];
        if ($sess_payement_index == 1) {

            $this->load->model('payment_methods/mdl_payment_methods');

            $this->layout->set(
                array(
                    'filter_placeholder' => lang('filter_payments'),
                    'payment_methods' => $this->mdl_payment_methods->get()->result(),
                )
            );

            $this->layout->buffer('content', 'payments/index');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function form($id = null)
    {
        $sess_payement_add = $this->session->userdata['payement_add'];
        if ($sess_payement_add == 1) {

            if ($this->input->post('btn_cancel')) {
                redirect('payments');
            }
            if ($this->mdl_payments->run_validation()) {
                if ($this->mdl_payments->form_values['payment_method_id'] == 1) {
                    $ref = $this->mdl_payments->form_values['num_cheq'];
                    $mnt = $this->mdl_payments->form_values['montant_cheq'];
                    $bq = $this->mdl_payments->form_values['banque_c'];
                    $prop = $this->mdl_payments->form_values['proprietaire_c'];
                    $dt_che = $this->mdl_payments->form_values['date_cheq'];
                    $dt_ch = explode('/', $dt_che);
                    $dtc = $dt_ch[2] . '-' . $dt_ch[1] . '-' . $dt_ch[0];
                }
                if ($this->mdl_payments->form_values['payment_method_id'] == 3) {
                    $ref = '';
                    $mnt = $this->mdl_payments->form_values['montant_esp'];
                    $bq = '';
                    $prop = '';
                    $dtc = '';
                }
                if ($this->mdl_payments->form_values['payment_method_id'] == 6) {
                    $ref = '';
                    $mnt = $this->mdl_payments->form_values['montant_esp'];
                    $bq = '';
                    $prop = '';
                    $dtc = '';
                }
                if (($this->mdl_payments->form_values['payment_method_id'] == 2) || ($this->mdl_payments->form_values['payment_method_id'] == 4)) {
                    $ref = $this->mdl_payments->form_values['reference'];
                    $mnt = $this->mdl_payments->form_values['montant_c'];
                    $bq = $this->mdl_payments->form_values['banque_v'];
                    $prop = $this->mdl_payments->form_values['proprietaire_v'];
                    $dtc = '';
                }
                if ($this->mdl_payments->form_values['payment_method_id'] == 5) {
                    $ref = $this->mdl_payments->form_values['reference'];
                    $mnt = $this->mdl_payments->form_values['montant_c'];
                    $bq = $this->mdl_payments->form_values['banque_v'];
                    $prop = $this->mdl_payments->form_values['proprietaire_v'];
                    $dtc = '';
                }
                $date_pay = $this->mdl_payments->form_values['payment_date']; //02/07/2015  a-m-j
                $dt_pay = explode('/', $date_pay);
                $mnt = str_replace(" ", "", $mnt);
                $dt_paym = $dt_pay[2] . '-' . $dt_pay[1] . '-' . $dt_pay[0];
                $data = array(
                    'invoice_id' => $this->mdl_payments->form_values['invoice_id'],
                    'client_id' => $this->mdl_payments->form_values['client_id'],
                    'payment_method_id' => $this->mdl_payments->form_values['payment_method_id'],
                    'payment_date' => $dt_paym,
                    'payment_amount' => $mnt,
                    'payment_ref' => $ref,
                    'payment_dat_eche' => $dtc,
                    'payment_note' => $this->mdl_payments->form_values['payment_note'],
                );

                $this->db->where('payment_id', $id);
                if ($id) {
                    $this->db->update('ip_payments', $data);
                    $payement_id = $id;

                    $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
                    $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
                    $this->db->where('payment_id', $payement_id);
                    $payment = $this->db->get('ip_payments')->result();
                    if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                        $data_log = array(
                            "log_action" => "edit_payment",
                            "log_date" => date('Y-m-d H:i:s'),
                            "log_ip" => $this->session->userdata['ip_address'],
                            "log_user_id" => $this->session->userdata['user_id'],
                            "log_field1" => $payement_id,
                            "log_field2" => "Client : " . $payment[0]->client_name . " " . $payment[0]->client_prenom . "<br>Date : " . date_from_mysql($payment[0]->payment_date) . "<br>Montant : " . format_devise($payment[0]->payment_amount, $payment[0]->client_devise_id) . "<br>Méthode de paiement : " . $payment[0]->payment_method_name . "<br>Note : " . $payment[0]->payment_note,
                        );
                        $this->db->insert('ip_logs', $data_log);
                    }
                } else {
                    $this->db->insert('ip_payments', $data);
                    $id = $this->db->insert_id();
                    $this->db->select('client_type');
                    $this->db->where('client_id', $this->mdl_payments->form_values['client_id']);
                    $getclient = $this->db->get('ip_clients')->result();
                    if ($getclient[0]->client_type == 0) {
                        $data_client = array(
                            'client_type' => 1,
                            'date_creation_client' => date('Y-m-d'),
                        );
                        $this->db->where('client_id', $this->mdl_payments->form_values['client_id']);
                        $this->db->update('ip_clients', $data_client);
                    }
                    $payement_id = $id;

                    $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
                    $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
                    $this->db->where('payment_id', $payement_id);
                    $payment = $this->db->get('ip_payments')->result();

                    if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {

                        $data_log = array(
                            "log_action" => "add_payment",
                            "log_date" => date('Y-m-d H:i:s'),
                            "log_ip" => $this->session->userdata['ip_address'],
                            "log_user_id" => $this->session->userdata['user_id'],
                            "log_field1" => $payement_id,
                            "log_field2" => "Client : " . $payment[0]->client_name . " " . $payment[0]->client_prenom . "<br>Date : " . date_from_mysql($payment[0]->payment_date) . "<br>Montant : " . format_devise($payment[0]->payment_amount, $payment[0]->client_devise_id) . "<br>Méthode de paiement : " . $payment[0]->payment_method_name . "<br>Note : " . $payment[0]->payment_note,
                        );
                        $this->db->insert('ip_logs', $data_log);
                    }
                }

                //insertion ds table pieces
                $this->db->where('payment_id', $id);
                $this->db->delete('ip_pieces');

                $data_pieces = array(
                    'payment_id' => $payement_id,
                    'num_piece' => $ref,
                    'montant' => $mnt,
                    'echeance' => $dtc,
                    'proprietaire' => $prop,
                    'banque' => $bq,
                );

                $this->db->insert('ip_pieces', $data_pieces);

                redirect('payments');
            }

            $this->db->where('payment_id', $id);

            $payment = $this->db->get('ip_payments');
            $this->load->model('payment_methods/mdl_payment_methods');
            $amounts = array();
            $invoice_payment_methods = array();
            $pieces = array();
            if (!$id) {
                $this->db->where('ip_invoice_amounts.invoice_balance > 0');
            }
            $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
            $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
            $invoices = $this->db->get('ip_invoices')->result();
            if (!empty($invoices)) {
                foreach ($invoices as $invoice) {
                    $amounts['invoice' . $invoice->invoice_id] = format_amount($invoice->invoice_balance);
                    $invoice_payment_methods['invoice' . $invoice->invoice_id] = $invoice->payment_method;
                }
            }

            if ($id) {
                $this->db->where('payment_id', $id);

                $this->db->join('ip_invoices', 'ip_invoices.invoice_id = ip_payments.invoice_id', 'left');
                $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
                $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
                $payment_info_all = $this->db->get('ip_payments')->result();

                $this->db->where('payment_id', $id);
                $pieces_info_all = $this->db->get('ip_pieces')->result();
                $pieces_info = !empty($pieces_info_all) ? $pieces_info_all[0] : array();
                $payment_info = !empty($payment_info_all) ? $payment_info_all[0] : array();
            } else {
                $payment_info = array();
                $pieces_info = array();
            }
            $clients = $this->db->get('ip_clients')->result();
            $this->load->model('banque/mdl_banque');
            $this->layout->set(
                array(
                    'clients' => $clients,
                    'payment_id' => $id,
                    'payment_methods' => $this->mdl_payment_methods->get()->result(),
                    'amounts' => json_encode($amounts),
                    'invoices' => $invoices,
                    'payment' => $payment_info,
                    'invoice_payment_methods' => json_encode($invoice_payment_methods),
                    'pieces_info' => $pieces_info,
                    'banque' => $this->mdl_banque->get()->result(),
                )
            );
            $this->layout->buffer('content', 'payments/form');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function form2($id = null)
    {
        $sess_payement_add = $this->session->userdata['payement_add'];
        if ($sess_payement_add == 1) {

            if ($this->input->post('btn_cancel')) {
                redirect('payments');
            }

            if ($this->mdl_payments->run_validation()) {

                if ($this->mdl_payments->form_values['payment_method_id'] == 1) {
                    $ref = $this->mdl_payments->form_values['num_cheq'];
                    $mnt = $this->mdl_payments->form_values['montant_cheq'];
                    $bq = $this->mdl_payments->form_values['banque_c'];
                    $prop = $this->mdl_payments->form_values['proprietaire_c'];
                    $dt_che = $this->mdl_payments->form_values['date_cheq'];
                    $dt_ch = explode('/', $dt_che);
                    $dtc = $dt_ch[2] . '-' . $dt_ch[1] . '-' . $dt_ch[0];
                }
                if ($this->mdl_payments->form_values['payment_method_id'] == 3) {
                    $ref = '';
                    $mnt = $this->mdl_payments->form_values['montant_esp'];
                    $bq = '';
                    $prop = '';
                    $dtc = '';
                }
                if (($this->mdl_payments->form_values['payment_method_id'] == 2) || ($this->mdl_payments->form_values['payment_method_id'] == 4)) {
                    $ref = $this->mdl_payments->form_values['reference'];
                    //$mnt= $this->mdl_payments->form_values['montant_c'];
                    $bq = $this->mdl_payments->form_values['banque_v'];
                    $prop = $this->mdl_payments->form_values['proprietaire_v'];
                    $dtc = '';
                }
                $date_pay = $this->mdl_payments->form_values['payment_date']; //02/07/2015  a-m-j
                $dt_pay = explode('/', $date_pay);
                $dt_paym = $dt_pay[2] . '-' . $dt_pay[1] . '-' . $dt_pay[0];

                $date_cheq = $this->mdl_payments->form_values['payment_dat_eche']; //02/07/2015  a-m-j
                $dt_cheq = explode('/', $date_cheq);
                $dte_cheq = $dt_cheq[2] . '-' . $dt_cheq[1] . '-' . $dt_cheq[0];
                $data = array(
                    'client_id' => $this->mdl_payments->form_values['client_id'],
                    'payment_method_id' => $this->mdl_payments->form_values['payment_method_id'],
                    'payment_date' => $dt_paym,
                    'payment_amount' => $this->mdl_payments->form_values['payment_amount'],
                    'payment_ref' => $ref,
                    'payment_dat_eche' => $dtc,
                    'payment_note' => $this->mdl_payments->form_values['payment_note'],
                );
                $this->db->where('payment_id', $id);
                $this->db->update('ip_payments', $data);
                $id = $this->mdl_payments->save($id);
                $payement_id = $this->db->insert_id();

//insertion ds table pieces
                $this->db->where('payment_id', $id);
                $this->db->delete('ip_pieces');

                $data_pieces = array(
                    'payment_id' => $payement_id,
                    'num_piece' => $ref,
                    'montant' => $this->mdl_payments->form_values['payment_amount'],
                    'echeance' => $dtc,
                    'proprietaire' => $prop,
                    'banque' => $bq,
                );

                $this->db->insert('ip_pieces', $data_pieces);

                $this->load->model('custom_fields/mdl_payment_custom');

                $this->mdl_payment_custom->save_custom($id, $this->input->post('custom'));

                redirect('payments');
            }

            if (!$this->input->post('btn_submit')) {
                $prep_form = $this->mdl_payments->prep_form($id);

                if ($id and !$prep_form) {
                    show_404();
                }

                $this->load->model('custom_fields/mdl_payment_custom');

                $payment_custom = $this->mdl_payment_custom->where('payment_id', $id)->get();

                if ($payment_custom->num_rows()) {
                    $payment_custom = $payment_custom->row();

                    unset($payment_custom->payment_id, $payment_custom->payment_custom_id);

                    foreach ($payment_custom as $key => $val) {
                        $this->mdl_payments->set_form_value('custom[' . $key . ']', $val);
                    }
                }
            } else {
                if ($this->input->post('custom')) {
                    foreach ($this->input->post('custom') as $key => $val) {
                        $this->mdl_payments->set_form_value('custom[' . $key . ']', $val);
                    }
                }
            }

            $this->load->model('payment_methods/mdl_payment_methods');
            $this->load->model('custom_fields/mdl_custom_fields');

            $this->layout->set(
                array(
                    'payment_id' => $id,
                    'payment_methods' => $this->mdl_payment_methods->get()->result(),
                    'clients' => $this->db->get('ip_clients')->result(),
                    'custom_fields' => $this->mdl_custom_fields->by_table('ip_payment_custom')->get()->result(),
                )
            );

            if ($id) {
                $this->layout->set('payment', $this->mdl_payments->where('ip_payments.payment_id', $id)->get()->row());
            }

            $this->layout->buffer('content', 'payments/form');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($id)
    {
        $sess_payement_del = $this->session->userdata['payement_del'];
        if ($sess_payement_del == 1) {

            $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
            $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
            $this->db->where('payment_id', $id);
            $payment = $this->db->get('ip_payments')->result();

            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {

                $data_log = array(
                    "log_action" => "delete_payment",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $id,
                    "log_field2" => "Client : " . $payment[0]->client_name . " " . $payment[0]->client_prenom . "<br>Date : " . date_from_mysql($payment[0]->payment_date) . "<br>Montant : " . format_devise($payment[0]->payment_amount, $payment[0]->client_devise_id) . "<br>Méthode de paiement : " . $payment[0]->payment_method_name . "<br>Note : " . $payment[0]->payment_note,
                );
                $this->db->insert('ip_logs', $data_log);
            }

            $this->mdl_payments->delete($id);
            redirect('payments');
        } else {
            redirect('sessions/login');
        }
    }

    public function export_excel($ids = 0)
    {  $cnt = 0;       
       if($ids!='all'){
        $ids_array = explode("_", $ids);
        foreach ($ids_array as $client_id) {
            if ($cnt == 0) {
                $this->db->where('ip_payments.payment_id', $client_id);
            } else {
                $this->db->or_where('ip_payments.payment_id', $client_id);
            }
            $cnt++;
        }
        } 
       // $this->db->select("ip_payments.*,SUM(ip_invoice_amounts.invoice_balance) as 'solde',ip_devises.*");
        $this->db->group_by('ip_payments.payment_id');
        $this->db->join('ip_invoices', 'ip_invoices.client_id = ip_payments.client_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
        $payments = $this->db->get("ip_payments")->result();
        
     //   return var_dump($payments);die('1');


        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);

        $this->excel->getActiveSheet()
            ->setCellValue('A1', lang('payment_date'))
            ->setCellValue('B1', lang('date_facture'))
            ->setCellValue('C1', lang('invoice'))
            ->setCellValue('D1', lang('nom'))
            ->setCellValue('E1', lang('prenom'))
            ->setCellValue('F1', lang('amount'))
            ->setCellValue('G1', lang('payment_method'))
            ->setCellValue('H1', lang('reference'));      
        $cnt2 = 2;
       // $this->excel->getActiveSheet()->setTitle("Liste des payments");
        $this->excel->getActiveSheet()->getStyle('A1:U1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $this->excel->getActiveSheet()->getStyle('A1:U1')->getFill()->getStartColor()->setARGB('FFDDDDDD');
//        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->applyFromArray(array('rgb' => '808080'));
        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

        $this->excel->getActiveSheet()->getStyle('A1:U1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:U1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $civilite[0] = "M.";
        $civilite[1] = "Mme.";
        $civilite[2] = "Melle.";
        foreach ($payments as $payment) {
  

            $this->excel->getActiveSheet()
                ->setCellValue('A' . $cnt2, $payment->payment_date)
                ->setCellValue('B' . $cnt2, $payment->invoice_date_created)
                ->setCellValue('C' . $cnt2, $payment->invoice_number)
                ->setCellValue('D' . $cnt2, $payment->client_name)
                ->setCellValue('E' . $cnt2, $payment->client_prenom)
                ->setCellValue('F' . $cnt2, format_devise($payment->payment_amount,$payment->client_devise_id))
                ->setCellValue('G' . $cnt2, $payment->payment_method_name)
               // ->setCellValue('H' . $cnt2, $payment->payment_method_name)
           //     ->setCellValue('E' . $cnt2, format_devise($payment->reference, $payment->devise_id))           
           ->setCellValue('H' . $cnt2,  $payment->payment_ref)               
           
            ;
            $this->excel->getActiveSheet()->getStyle('A' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('H' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $cnt2++;
        }

        $filename =lang('payment_list'); //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

}