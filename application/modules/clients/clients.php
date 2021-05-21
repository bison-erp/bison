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

class Clients extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_clients');
        $this->path = './uploads/' . strtolower($this->session->userdata('licence')) . '/documents/';
    }

    public function index()
    {
        $sess_cont_index = $this->session->userdata['cont_index'];
        if ($sess_cont_index == 1) { // Display active clients by default
            redirect('clients/status/active');
        } else {
            redirect('sessions/login');
        }
    }

    public function status($status = 'active', $page = 0)
    {
        $this->db->select('SUM(client_type<2 ) as somme,SUM(client_type=0) as somme0,SUM(client_type=1) as somme1');
        $data = $this->db->get('ip_clients')->result();
        //   return var_dump($data[0]->somme0);
        $this->layout->set('data', $data[0]);
        $this->layout->set(
            array(
                'filter_display' => true,
                'filter_placeholder' => lang('filter_clients'),
                'filter_method' => 'filter_clients',
            )
        );

        $this->layout->buffer('content', 'clients/index');
        $this->layout->render();
    }

    public function form($id = null)
    {

        $sess_cont_add = $this->session->userdata['cont_add'];
        //print_r($this->session->userdata);
        if ($id == null) {
            $vrb = ' a créé';
            $mail_subject = "Nouveau contact";
            $add = 1;
        } else {
            $vrb = ' a modifié';
            $mail_subject = "Modification contact";
            $add = 0;
        }

        if ($sess_cont_add == 1) {
            if ($this->input->post('btn_cancel')) {
                redirect('clients');
            }

            if ($this->mdl_clients->run_validation()) {

                $id = $this->mdl_clients->save($id);

                $user_id = $this->session->userdata['user_id'];
                $data = array(
                    'user_id' => $user_id,
                );

                $this->db->where('client_id', $id);
                $this->db->update('ip_clients', $data);

                if ($add == 1) {
                    $action_log = "add_client";
                } else {
                    $action_log = "edit_client";
                }
                if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                    $data_log = array(
                        "log_action" => $action_log,
                        "log_date" => date('Y-m-d H:i:s'),
                        "log_ip" => $this->session->userdata['ip_address'],
                        "log_user_id" => $this->session->userdata['user_id'],
                        "log_field1" => $id,
                    );
                    $this->db->insert('ip_logs', $data_log);
                }

                $this->load->model('custom_fields/mdl_client_custom');

                $this->mdl_client_custom->save_custom($id, $this->input->post('custom'));
                if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                    $this->load->helper('mailer');
                    email_clients($mail_subject, $_POST, $id);
                }
                if ($add == 1 && trim($this->input->post('client_note')) != '') {
                    $data_note = array(
                        'client_id' => $id,
                        'client_note_date' => date('Y-m-d H:i:s'),
                        'adr_ip' => $this->input->post('adr_ip'),
                        'usr' => $this->input->post('usr'),
                        'id_usr' => $this->input->post('id_usr'),
                        'drap' => $this->input->post('drap'),
                        'client_note' => $this->input->post('client_note'),
                    );

                    $this->db->insert('ip_client_notes', $data_note);
                }
                redirect('clients/view/' . $id);
            }

            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_clients->prep_form($id)) {
                    show_404();
                }

                $this->load->model('custom_fields/mdl_client_custom');
                //$this->load->library('form_validation');
                $client_custom = $this->mdl_client_custom->where('client_id', $id)->get();

                //controle des champs
                //$this->form_validation->set_rules('client_date_naiss', 'DDate', 'required');

                if ($client_custom->num_rows()) {
                    $client_custom = $client_custom->row();

                    unset($client_custom->client_id, $client_custom->client_custom_id);

                    foreach ($client_custom as $key => $val) {
                        $this->mdl_clients->set_form_value('custom[' . $key . ']', $val);
                    }
                }
            } elseif ($this->input->post('btn_submit')) {

                if ($this->input->post('custom')) {
                    foreach ($this->input->post('custom') as $key => $val) {
                        $this->mdl_clients->set_form_value('custom[' . $key . ']', $val);
                    }
                }
            }

            $this->load->model('custom_fields/mdl_custom_fields');
            $this->load->model('devises/mdl_devises');
            $this->load->helper('country');

            $this->layout->set('records', $this->mdl_clients->get()->result());
            $this->layout->set('custom_fields', $this->mdl_custom_fields->by_table('ip_client_custom')->get()->result());
            $this->layout->set('countries', get_country_list(lang('cldr')));
            $this->layout->set('devises', $this->mdl_devises->get()->result());
            $this->layout->set('selected_country', $this->mdl_clients->form_value('client_country') ?:
                $this->mdl_settings->setting('default_country'));
            $this->layout->set('selected_devise', $this->mdl_clients->form_value('client_devise_id') ?: 1);
            $this->layout->set('selected_titre', $this->mdl_clients->form_value('client_titre') ?: '');
            $this->layout->set('selected_type', $this->mdl_clients->form_value('client_type') ?: 0);
            $this->layout->set('id', $id ? $id : 0);

            $this->layout->buffer('content', 'clients/form');
            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function download_document($id)
    {

        $this->db->where("id_document", $id);
        $document = $this->db->get("ip_client_documents")->result();
        if (empty($document)) {
            exit;
        } else {

            $file = $this->path . $document[0]->file_name;
            if (is_file($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                @ob_clean();
                @flush();
                readfile($file);
                exit;
            }
        }
    }

    public function delete_document($id)
    {

        $this->db->where("id_document", $id);
        $document = $this->db->get("ip_client_documents")->result();
        if (!empty($document)) {
            $file = $this->path . $document[0]->file_name;
            if (is_file($file)) {
                unlink($file);
            }
            $this->db->where("id_document", $id);
            $this->db->delete('ip_client_documents');
            redirect('clients/view/' . $document[0]->id_client . '#clientDocuments');
        } else {
            redirect('clients');
        }
    }

    public function view($client_id)
    {
        $sess_cont_add = $this->session->userdata['cont_add'];
        if ($sess_cont_add == 1) {

            if ($this->input->post('add_document')) {
                if (isset($_FILES['document_import']['name']) && ($_FILES['document_import']['name'] != '')) {
                    $file_desc = $this->input->post('document_desc');
                    $client_id = $this->input->post('client_id');
                    $file_name = $_FILES['document_import']['name'];
                    if (!is_dir($this->path)) {

                        mkdir($this->path, 0777);
                    }
                    $upload_config = array(
                        'upload_path' => $this->path,
                        'allowed_types' => '*',
                        'max_size' => '9999',
                        'max_width' => '9999',
                        'max_height' => '9999',
                    );

                    $this->load->library('upload', $upload_config);
                    if ($this->upload->do_upload('document_import')) {

                        $upload_data = $this->upload->data();
                        $data_file = array(
                            "file_name" => $upload_data["file_name"],
                            "created" => date("Y-m-d"),
                            "id_client" => $client_id,
                            "description" => $file_desc,
                            "size" => $_FILES['document_import']["size"],
                            "user_id" => $this->session->userdata['user_id'],
                        );
                        $this->db->insert("ip_client_documents", $data_file);
                    }
                }
                redirect('clients/view/' . $client_id . '#clientDocuments');
            }

            if ($this->input->post('btn_cancel')) {
                redirect('clients');
            }
            $this->load->model('activites/mdl_activites');
            $this->load->model('devises/mdl_devises');
            $this->load->model('clients/mdl_client_notes');
            $this->load->model('invoices/mdl_invoices');
            $this->load->model('quotes/mdl_quotes');
            $this->load->model('payments/mdl_payments');
            $this->load->model('payment_methods/mdl_payment_methods');
            $this->load->model('custom_fields/mdl_custom_fields');
            $this->load->model('quotes/mdl_quotes');
            $this->load->model('users/mdl_users');
            $client = $this->mdl_clients->with_total()->with_total_balance()->with_total_paid()->where('ip_clients.client_id', $client_id)->get()->row();

            if (!$client) {
                show_404();
            }

            // GET CALCUL TOTAL QUOTES
            $where = "ip_clients.client_id = $client_id";
            $this->db->WHERE("$where");
            $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
            $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
            $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
            $this->db->select("count(ip_quotes.quote_id) as count,ip_devises.devise_id,SUM(ip_quote_amounts.quote_item_subtotal) as quotes_sum_subtotal,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total");
            $this->db->group_by("ip_devises.devise_id");
            $quotes_total_amounts_db = $this->db->get("ip_quotes")->result();
            $quotes_total_amounts = array();
            if (!empty($quotes_total_amounts_db)) {
                foreach ($quotes_total_amounts_db as $amount) {
                    $quotes_total_amounts[$amount->devise_id]["quotes_sum_subtotal"] = $amount->quotes_sum_subtotal;
                    $quotes_total_amounts[$amount->devise_id]["quotes_sum_total"] = $amount->quotes_sum_total;
                    $quotes_total_amounts[$amount->devise_id]["count"] = $amount->count;
                }
            }

            // GET ALL QUOTES CLIENT

            $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
            $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
            $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
            $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_quotes.quote_delai_paiement', 'left');
            $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
            $this->db->select("*,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe2");

            $where = "ip_clients.client_id = $client_id";
            $this->db->WHERE("$where");
            $quotes = $this->db->get("ip_quotes")->result();

            // GET CALCUL TOTAL INVOICES

            $this->db->WHERE("$where");
            $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
            $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
            $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
            $this->db->select("count(ip_invoices.invoice_id) as count,ip_devises.devise_id,SUM(ip_invoice_amounts.invoice_item_subtotal) as invoices_sum_subtotal,SUM(ip_invoice_amounts.invoice_total) as invoices_sum_total");
            $this->db->group_by("ip_devises.devise_id");
            $invoices_total_amounts_db = $this->db->get("ip_invoices")->result();
            $invoices_total_amounts = array();
            if (!empty($invoices_total_amounts_db)) {
                foreach ($invoices_total_amounts_db as $amount) {
                    $invoices_total_amounts[$amount->devise_id]["invoices_sum_subtotal"] = $amount->invoices_sum_subtotal;
                    $invoices_total_amounts[$amount->devise_id]["invoices_sum_total"] = $amount->invoices_sum_total;
                    $invoices_total_amounts[$amount->devise_id]["count"] = $amount->count;
                }
            }

            // GET ALL INVOICES CLIENT
            $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
            $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_invoices.invoice_delai_paiement', 'left');
            $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
            $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
            $this->db->join('ip_users', 'ip_users.user_id = ip_invoices.user_id', 'left');
            $this->db->select("*,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe2");

            $where = "ip_clients.client_id = $client_id";
            $this->db->WHERE("$where");
            $invoices = $this->db->get("ip_invoices")->result();

            // GET PAYMENT
            $this->db->WHERE("ip_clients.client_id", $client_id);
            $this->db->WHERE("ip_payments.payment_id <> ''");
            $this->db->join('ip_payments', 'ip_payments.client_id = ip_clients.client_id', 'left');
            $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
            $this->db->join('ip_pieces', 'ip_pieces.payment_id = ip_payments.payment_id', 'left');
            $this->db->join('ip_invoices', 'ip_invoices.invoice_id = ip_payments.invoice_id', 'left');
            $this->db->group_by("ip_payments.payment_id");
            $this->db->select("ip_clients.client_id,ip_payments.*,ip_pieces.*,ip_payment_methods.*");
            $result_credit = $this->db->get('ip_clients')->result();

            $this->db->WHERE("ip_clients.client_id", $client_id);
            $this->db->WHERE("ip_invoices.invoice_id <> ''");
            $this->db->join('ip_invoices', 'ip_invoices.client_id = ip_clients.client_id', 'left');
            $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
            $this->db->select("ip_clients.client_id,ip_invoices.invoice_date_created,ip_invoice_amounts.*");
            $result_debit = $this->db->get('ip_clients')->result();

            $data_payment = array();
            $data_payment2 = array();
            if (!empty($result_credit)) {
                foreach ($result_credit as $credit) {
                    $data_payment["type"] = "credit";
                    $data_payment["amount"] = $credit->payment_amount;
                    $data_payment["date"] = $credit->payment_date;
                    $data_payment["invoice"] = $credit->invoice_id;
                    $data_payment["note"] = $credit->payment_note;
                    $data_payment["payment_method_id"] = $credit->payment_method_id;
                    $data_payment["payment_method_name"] = $credit->payment_method_name;
                    $data_payment["num_piece"] = $credit->num_piece;
                    $data_payment["echeance"] = $credit->echeance;
                    $data_payment["proprietaire"] = $credit->proprietaire;
                    $data_payment["banque"] = $credit->banque;
                    $data_payment2[] = $data_payment;
                }
            }
            if (!empty($result_debit)) {
                foreach ($result_debit as $debit) {
                    $data_payment["type"] = "debit";
                    $data_payment["amount"] = $debit->invoice_total;
                    $data_payment["date"] = $debit->invoice_date_created;
                    $data_payment["invoice"] = $debit->invoice_id;
                    $data_payment["note"] = "";
                    $data_payment2[] = $data_payment;
                }
            }
            foreach ($data_payment2 as $k => $v) {
                $date_payment[$k] = $v['date'];
            }
            if (!empty($data_payment2)) {
                array_multisort($date_payment, SORT_ASC, $data_payment2);
            }

            $this->db->where("id_client", $client_id);
            $this->db->join('ip_users', 'ip_users.user_id = ip_client_documents.user_id', 'left');
            $documents = $this->db->get("ip_client_documents")->result();

            $this->load->helper('logs');
            $params["client_id"] = $client_id;
            $logs = getLogs($params);
            $this->layout->set(
                array(

                    'client' => $client,
//                        'logs' => $this->mdl_activites->order_by("activites_date_created", "desc")->where('client_id', $client_id)->get()->result(),
                    'logs' => $logs,
                    'client_notes' => $this->mdl_client_notes->where('client_id', $client_id)->get()->result(),
                    'invoices' => $invoices,
                    'quotes' => $quotes,
                    'payments' => $data_payment2,
                    'custom_fields' => $this->mdl_custom_fields->by_table('ip_client_custom')->get()->result(),
                    'quote_statuses' => $this->mdl_quotes->statuses(),
                    'rappel_quotes' => $this->mdl_quotes->get_date_rappel(),
                    'invoice_statuses' => $this->mdl_invoices->statuses(),
                    'users' => $this->mdl_users->get()->result(),
                    'devises' => $this->mdl_devises->get()->result(),
                    'quotes_total_amounts' => $quotes_total_amounts,
                    'invoices_total_amounts' => $invoices_total_amounts,
                    'documents' => $documents,
                )
            );

            $this->layout->buffer(
                array(
                    array('invoice_table', 'invoices/partial_invoice_table'),
                    array('quote_table', 'quotes/partial_quote_table'),
//                        array('payment_table', 'payments/partial_payment_table'),
                    array('partial_notes', 'clients/partial_notes'),
                    array('partial_logs', 'clients/partial_logs'),
                    array('partial_documents', 'clients/partial_documents'),
                    array('content', 'clients/view'),
                )
            );

            $this->layout->render();
        } else {
            redirect('sessions/login');
        }
    }

    public function delete($client_id)
    {
        $sess_cont_del = $this->session->userdata['cont_del'];
        if ($sess_cont_del == 1) {
            if ($this->input->post('btn_cancel')) {
                redirect('clients');
            }
//            $cl = $this->mdl_clients->where('ip_clients.client_id', $client_id)->get()->result();
            //           echo '<pre>'; print_r($this->session->userdata);echo '</pre>';
            //           echo '<pre>'; print_r($cl);echo '</pre>';
            ////           die;
            //            $data_acc_n = array(
            //                'descrip' => $this->session->userdata['user_code'] . ' à supprimer le client ' .
            //                $cl[0]->client_name . ' ' .
            //                $cl[0]->client_prenom,
            //                'activites_date_created' => date('Y-m-d H:i:s'),
            //                'etat' => 2,
            //                'user_id' => $this->session->userdata['user_id'],
            //                'client_id' => $cl[0]->client_id,
            //                'adresse_ip' => $this->session->userdata['ip_address'],
            //            );
            ////            echo '<pre>';
            ////            print_r($data_acc_n);
            ////            echo '</pre>';
            ////            die;
            //            $this->db->insert('ip_activites', $data_acc_n);

            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "delete_client",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $client_id,
                );
                $this->db->insert('ip_logs', $data_log);
            }

            //delete==>maj delete=0
            $data_del = array(
                'delete' => 1,
            );

            $this->db->where('client_id', $client_id);
            $this->db->update('ip_clients', $data_del);

            redirect('clients');
        } else {
            redirect('sessions/login');
        }
    }

    public function export_excel($ids = 0)
    {

        $cnt = 0;
        $ids_array = explode("_", $ids);
        foreach ($ids_array as $client_id) {
            if ($cnt == 0) {
                $this->db->where('ip_clients.client_id', $client_id);
            } else {
                $this->db->or_where('ip_clients.client_id', $client_id);
            }
            $cnt++;
        }

        $this->db->select("ip_clients.*,SUM(ip_invoice_amounts.invoice_balance) as 'solde',ip_devises.*");
        $this->db->group_by('ip_clients.client_id');
        $this->db->join('ip_invoices', 'ip_invoices.client_id = ip_clients.client_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $clients = $this->db->get("ip_clients")->result();

        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);

        $this->excel->getActiveSheet()
            ->setCellValue('A1', 'Code')
            ->setCellValue('B1', 'Titre')
            ->setCellValue('C1', 'Nom')
            ->setCellValue('D1', 'Prénom')
            ->setCellValue('E1', 'Type')
            ->setCellValue('F1', 'Société')
            ->setCellValue('G1', 'Devise')
            ->setCellValue('H1', 'Adresse')
            ->setCellValue('I1', 'Complement')
            ->setCellValue('J1', 'Ville')
            ->setCellValue('K1', 'Code postal')
            ->setCellValue('L1', 'Pays')
            ->setCellValue('M1', 'Téléphone')
            ->setCellValue('N1', 'Portable')
            ->setCellValue('O1', 'Fax')
            ->setCellValue('P1', 'Email')
            ->setCellValue('Q1', 'Site web')
            ->setCellValue('R1', 'Matricule fiscale')
            ->setCellValue('S1', 'Registre de commerce')
            ->setCellValue('T1', 'Timbre fiscale')
            ->setCellValue('U1', 'Solde');

        $cnt2 = 2;
        $this->excel->getActiveSheet()->setTitle("Liste des clients");
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
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);

        $this->excel->getActiveSheet()->getStyle('A1:U1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:U1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $civilite[0] = "M.";
        $civilite[1] = "Mme.";
        $civilite[2] = "Melle.";
        foreach ($clients as $client) {

            if ($client->client_type == 0) {
                $client_type = lang('prospect_filter');
            } else {
                $client_type = lang('client_filter');
            }

            if ($client->timbre_fiscale == 1) {
                $timbre_fiscale = 'Oui';
            } else {
                $timbre_fiscale = 'Non';
            }

            $this->excel->getActiveSheet()
                ->setCellValue('A' . $cnt2, '#' . $client->client_id)
                ->setCellValue('B' . $cnt2, $civilite[$client->client_titre])
                ->setCellValue('C' . $cnt2, $client->client_name)
                ->setCellValue('D' . $cnt2, $client->client_prenom)
                ->setCellValue('E' . $cnt2, $client_type)
                ->setCellValue('F' . $cnt2, $client->client_societe)
                ->setCellValue('G' . $cnt2, $client->devise_label)
                ->setCellValue('H' . $cnt2, $client->client_address_1)
                ->setCellValue('I' . $cnt2, $client->client_address_2)
                ->setCellValue('J' . $cnt2, $client->client_state)
                ->setCellValue('K' . $cnt2, $client->client_zip)
                ->setCellValue('K' . $cnt2, $client->client_country)
                ->setCellValue('M' . $cnt2, $client->client_phone)
                ->setCellValue('N' . $cnt2, $client->client_mobile)
                ->setCellValue('O' . $cnt2, $client->client_fax)
                ->setCellValue('P' . $cnt2, $client->client_email)
                ->setCellValue('Q' . $cnt2, $client->client_web)
                ->setCellValue('R' . $cnt2, $client->client_vat_id)
                ->setCellValue('S' . $cnt2, $client->client_tax_code)
                ->setCellValue('T' . $cnt2, $timbre_fiscale)
                ->setCellValue('U' . $cnt2, format_devise($client->solde, $client->devise_id))
            ;
            $this->excel->getActiveSheet()->getStyle('A' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('H' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('I' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('J' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('K' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('L' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('M' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('N' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('O' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('P' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('Q' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('R' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('S' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('T' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('U' . $cnt2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $cnt2++;
        }

        $filename = 'Liste des clients.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }
}