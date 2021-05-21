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

    public $ajax_controller = true;

    public function add()
    {
        $this->load->model('payments/mdl_payments');

        if ($this->input->post('payment_method_id') == 1) {
            $ref = $this->input->post('num_cheq');
            $mnt = $this->input->post('montant_cheq');
            $bq = $this->input->post('banque_c');
            $prop = $this->input->post('proprietaire_c');
            $dt_che = $this->input->post('date_cheq');
            $dt_ch = explode('/', $dt_che);
            $dtc = $dt_ch[2] . '-' . $dt_ch[1] . '-' . $dt_ch[0];
        }
        if ($this->input->post('payment_method_id') == 3) {
            $ref = '';
            $mnt = $this->input->post('montant_esp');
            $bq = '';
            $prop = '';
            $dtc = '';
        }
        if ($this->input->post('payment_method_id') == 6) {
            $ref = '';
            $mnt = $this->input->post('montant_esp');
            $bq = '';
            $prop = '';
            $dtc = '';
        }
        if (($this->input->post('payment_method_id') == 2) || ($this->input->post('payment_method_id') == 4) || ($this->input->post('payment_method_id') == 5)) {
            $ref = $this->input->post('reference');
            $mnt = $this->input->post('montant_c');
            $bq = $this->input->post('banque_v');
            $prop = $this->input->post('proprietaire_v');
            $dtc = '';
        }
        $mnt = str_replace(" ", "", $mnt);
        $date_pay = $this->input->post('payment_date'); //02/07/2015  a-m-j
        $dt_pay = explode('/', $date_pay);
        $dt_paym = $dt_pay[2] . '-' . $dt_pay[1] . '-' . $dt_pay[0];
        $data = array(
            'invoice_id' => $this->input->post('invoice_id'),
            'client_id' => $this->input->post('client_id'),
            'payment_method_id' => $this->input->post('payment_method_id'),
            'payment_date' => $dt_paym,
            'payment_amount' => $mnt,
            'payment_ref' => $ref,
            'payment_dat_eche' => $dtc,
            'payment_note' => $this->input->post('payment_note'),
        );

        $this->db->insert('ip_payments', $data);
        $id = $this->db->insert_id();
        $this->db->select('client_type');
        $this->db->where('client_id', $this->input->post('client_id'));
        $getclient = $this->db->get('ip_clients')->result();
        if ($getclient[0]->client_type == 0) {
            $data_client = array(
                'client_type' => 1,
                'date_creation_client' => date('Y-m-d'),
            );
            $this->db->where('client_id', $this->input->post('client_id'));
            $this->db->update('ip_clients', $data_client);
        }
        $payement_id = $id;

        $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
        $this->db->where('payment_id', $payement_id);
        $payment = $this->db->get('ip_payments')->result();
        $data_log = array(
            "log_action" => "add_payment",
            "log_date" => date('Y-m-d H:i:s'),
            "log_ip" => $this->session->userdata['ip_address'],
            "log_user_id" => $this->session->userdata['user_id'],
            "log_field1" => $payement_id,
            "log_field2" => "Client : " . $payment[0]->client_name . " " . $payment[0]->client_prenom . "<br>Date : " . date_from_mysql($payment[0]->payment_date) . "<br>Montant : " . format_devise($payment[0]->payment_amount, $payment[0]->client_devise_id) . "<br>Méthode de paiement : " . $payment[0]->payment_method_name . "<br>Note : " . $payment[0]->payment_note,
        );
        $this->db->insert('ip_logs', $data_log);

        $data_pieces = array(
            'payment_id' => $payement_id,
            'num_piece' => $ref,
            'montant' => $mnt,
            'echeance' => $dtc,
            'proprietaire' => $prop,
            'banque' => $bq,
        );

        $this->db->insert('ip_pieces', $data_pieces);

        $response = array(
            'success' => 1,
        );

        echo json_encode($response);
    }

    public function modal_add_payment()
    {
        $this->load->module('layout');
        $this->load->model('payments/mdl_payments');
        $this->load->model('payment_methods/mdl_payment_methods');
        $this->load->model('banque/mdl_banque');
        $invoice_id = $this->input->post('invoice_id');
        $client_id = $this->input->post('client_id');
        $invoice_amount_restant = "";
        if ($invoice_id == 0) {
            $this->db->where("client_id", $client_id);
            $invoices_select = $this->db->get("ip_invoices")->result();
        } else {
            $invoices_select = array();
        }

        $data = array(
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'invoice_id' => $invoice_id,
            'client_id' => $client_id,
            'invoice_payment_method' => $this->input->post('invoice_payment_method'),
            'invoice_amount_restant' => $invoice_amount_restant,
            'invoices_select' => $invoices_select,
            'banque' => $this->mdl_banque->get()->result(),
        );

        $this->layout->load_view('payments/modal_add_payment', $data);
    }

    public function load_payments_partial_filter()
    {

        $filter_payment_input = trim(strtolower(addslashes($this->input->post('filter_payment_input'))));

        $filter_payment_method = $this->input->post('filter_payment_method');
        $filter_month = $this->input->post('filter_month');
        $filter_year = $this->input->post('filter_year');

        $limit_par_page = $this->input->post('limit_par_page');
        $start_page = $this->input->post('start_page');
        $order_by = $this->input->post('order_by');
        $order_method = $this->input->post('order_method');
        $start_line = (int) ($start_page - 1) * (int) $limit_par_page;

        // GET COUNT QUOTES FILTRED

        if ($filter_payment_input != "") {
            $where = "((LOWER(ip_clients.client_name) LIKE '%" . $filter_payment_input . "%') ";

            $where .= " OR (LOWER(ip_clients.client_prenom) LIKE '%" . $filter_payment_input . "%' )";
            $where .= " OR (LOWER(ip_clients.client_societe) LIKE '%" . $filter_payment_input . "%' )";
            $where .= " OR (LOWER(ip_payments.payment_note) LIKE '%" . $filter_payment_input . "%' )";

            $where .= " )";
        } else {
            $where = "ip_payments.payment_id <> 0";
        }
        if ($filter_payment_method != "all") {
            $where .= " AND (ip_payments.payment_method_id = $filter_payment_method)";
        }
        if ($filter_year != "all") {

            $where .= " AND (YEAR(ip_payments.payment_date) = $filter_year)";
        }
        if ($filter_month != "all") {

            $where .= " AND (MONTH(ip_payments.payment_date) = $filter_month)";
        }

        $this->db->WHERE("$where");

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
        $nb_all_lines = $this->db->count_all_results('ip_payments');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);

        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
        $this->db->join('ip_invoices', 'ip_invoices.invoice_id = ip_payments.invoice_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->select("*,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe2");

        $payments = $this->db->get('ip_payments')->result();
        $payment_total_amounts = array();
        if (!empty($payments)) {
            foreach ($payments as $amount) {
                if (!isset($payment_total_amounts[$amount->client_devise_id]["total"])) {
                    $payment_total_amounts[$amount->client_devise_id]["total"] = 0;
                }
                if (!isset($payment_total_amounts[$amount->client_devise_id]["count"])) {
                    $payment_total_amounts[$amount->client_devise_id]["count"] = 0;
                }
                $payment_total_amounts[$amount->client_devise_id]["total"] += $amount->payment_amount;
                $payment_total_amounts[$amount->client_devise_id]["count"]++;
            }
        }

        $data = array(
            'payments' => $payments,
            'devises' => $this->db->get("ip_devises")->result(),
            'payment_total_amounts' => $payment_total_amounts,
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
        );
        $this->layout->load_view('payments/partial_payment_table', $data);
//        echo "<tr><td colspan='7' style='white-space: initial;'>";
        //
        //        print_r($_POST);
        //
        //        echo "</td></tr>";
    }

    public function getClientFactures()
    {
        $client_id = $this->input->post('client_id');
        $this->db->where("ip_invoices.client_id", $client_id);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_payments', 'ip_payments.invoice_id = ip_invoices.invoice_id', 'left');

        $this->db->group_by("ip_invoices.invoice_id");
        $this->db->select("ip_invoices.client_id,ip_invoices.invoice_id,ip_invoice_amounts.invoice_total, SUM(ip_payments.payment_amount) as montant_recu");
        $invoices = $this->db->get('ip_invoices')->result();

        $this->db->where("ip_clients.client_id", $client_id);
        $this->db->join('ip_clients', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $devise_info = $this->db->get("ip_devises")->result();
        $response = array(
            'invoices' => array_values($invoices),
            'devise_info' => $devise_info,
        );

        echo json_encode($response);
    }

    public function get_payments_without_invoices()
    {
        $client_id = $this->input->post('client_id');
        $this->db->where("ip_payments.client_id", $client_id);
        $this->db->where("ip_payments.invoice_id", 0);
        $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_payments.payment_method_id', 'left');
        $payments = $this->db->get("ip_payments")->result();
        $response = array(
            'payments' => $payments,
        );
        echo json_encode($response);
    }

}