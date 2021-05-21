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

    public function load_depenses_partial_filter()
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
            $where = "((LOWER(ip_fournisseurs.raison_social_fournisseur) LIKE '%" . $filter_payment_input . "%') ";

            $where .= " OR (LOWER(ip_fournisseurs.nom) LIKE '%" . $filter_payment_input . "%' )";
            $where .= " OR (LOWER(ip_fournisseurs.prenom) LIKE '%" . $filter_payment_input . "%' )";
            $where .= " OR (LOWER(ip_depense.note) LIKE '%" . $filter_payment_input . "%' )";

            $where .= " )";
        } else {
            $where = "ip_depense.id_depense <> 0";
        }
        if ($filter_payment_method != "all") {
            $where .= " AND (ip_depense.id_moyenpayement = $filter_payment_method)";
        }
        if ($filter_year != "all") {

            $where .= " AND (YEAR(ip_depense.date_paiement) = $filter_year)";
        }
        if ($filter_month != "all") {

            $where .= " AND (MONTH(ip_depense.date_paiement) = $filter_month)";
        }

        $this->db->WHERE("$where");

        $this->db->join('ip_fournisseurs', 'ip_fournisseurs.id_fournisseur = ip_depense.id_fournisseur', 'left');
        $nb_all_lines = $this->db->count_all_results('ip_depense');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);

        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = ip_depense.id_moyenpayement', 'left');
        $this->db->join('ip_fournisseurs', 'ip_fournisseurs.id_fournisseur = ip_depense.id_fournisseur', 'left');

        //  $this->db->join('ip_invoices', 'ip_invoices.invoice_id = ip_payments.invoice_id', 'left');
        //  $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
        //  $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        // $this->db->select("*,(case when trim(ip_fournisseurs.raison_social_fournisseur) = '' then ip_fournisseurs.nom else ip_fournisseurs.prenom end) as prenom");
        $this->db->select("*");

        $depense = $this->db->get('ip_depense')->result();

        $depense_total_amounts = array();
        $data = array(
            'depense' => $depense,
            'countdepense' => count($depense),
            'devises' => $this->db->get("ip_devises")->result(),
            'payment_total_amounts' => $payment_total_amounts,
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
        );
        $this->layout->load_view('depenses/partial_depense_table', $data);
//        echo "<tr><td colspan='7' style='white-space: initial;'>";
        //
        //        print_r($_POST);
        //
        //        echo "</td></tr>";
    }

    public function jsoncalender()
    {
        $this->load->model('mdl_depensemontant');
        $this->load->model('mdl_depenses');

        $data = array();
       
       //return var_dump($ip_depense_montant);die('hh');
       foreach ($this->mdl_depenses->get()->result() as $val) {      
           if($val->diffusion < 1){

            $data[] = ['title' => $val->nom . ' ' . $val->net_payer_depense, 'allDay' => false, 'text' => 'text', 'start' => $this->datetransform($val->date_paiement)];

        }else{          
           // return var_dump($this->mdl_depensemontant->getDepenseagenda(2));die('hh');
                foreach ($this->mdl_depensemontant->getDepenseagenda($val->id_depense) as $vall) {
                        $data[] = ['title' => $vall->nom . ' ' . $vall->montant, 'allDay' => false, 'text' => 'text', 'start' => $this->datetransform($vall->date_encaissement)];
                }
           }
        };
       // return var_dump($data);
        echo json_encode($data);
    }

    public function datetransform($date)
    {
        $months1 = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
        //  $ounths2 = array('Nov', 'Dec');
        $explode = explode("-", $date);
        $res = "";
        $res .= $explode[2] . " " . $months1[$explode[1]] . " " . $explode[0];
        return $res;
    }

}