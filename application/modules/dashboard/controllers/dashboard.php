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

class Dashboard extends Admin_Controller
{
    public function index()
    {
        $this->load->model(
            'invoices/mdl_invoice_amounts'
        );

        $this->load->model(
            'quotes/mdl_quote_amounts'
        );

        $this->load->model(
            'invoices/mdl_invoices'
        );

        $this->load->model(
            'quotes/mdl_quotes'
        );

        $this->load->model(
            'activites/mdl_activites'
        );

        // liste des devis recents
        $quote_overview_period = $this->mdl_settings->setting('quote_overview_period');

        switch ($quote_overview_period) {
            default:
            case 'this-month':
                $this->db->where(
                    "MONTH(ip_quotes.quote_date_created) = MONTH(NOW())AND YEAR(ip_quotes.quote_date_created) = YEAR(NOW())"
                );
                break;
            case 'last-month':
                $this->db->where(
                    "MONTH(ip_quotes.quote_date_created) = MONTH(NOW() - INTERVAL 1 MONTH) AND YEAR(ip_quotes.quote_date_created) = YEAR(NOW())"
                );
                break;
            case 'this-quarter':
                $this->db->where(
                    "QUARTER(ip_quotes.quote_date_created) = QUARTER(NOW())"
                );
                break;
            case 'last-quarter':
                $this->db->where(
                    "QUARTER(ip_quotes.quote_date_created) = QUARTER(NOW() - INTERVAL 1 QUARTER)"
                );
                break;
            case 'this-year':
                $this->db->where(
                    "YEAR(ip_quotes.quote_date_created) = YEAR(NOW())"
                );
                break;
            case 'last-year':
                $this->db->where(
                    "YEAR(ip_quotes.quote_date_created) = YEAR(NOW() - INTERVAL 1 YEAR)"
                );
                break;
        }

        $this->db->where(
            "ip_quotes.delete <> 1 "
        );

        $this->db->join(
            'ip_clients',
            'ip_clients.client_id = ip_quotes.client_id',
            'left'
        );

        $this->db->join(
            'ip_quote_amounts',
            'ip_quote_amounts.quote_id = ip_quotes.quote_id',
            'left'
        );

        $this->db->join(
            'ip_devises',
            'ip_clients.client_devise_id = ip_devises.devise_id',
            'left'
        );

        $this->db->join(
            'ip_delai_paiement',
            'ip_delai_paiement.delai_paiement_id = ip_quotes.quote_delai_paiement',
            'left'
        );

        $this->db->join(
            'ip_users',
            'ip_users.user_id = ip_quotes.user_id',
            'left'
        );

        $this->db->limit(10, 0);

        $this->db->order_by(
            'ip_quotes.quote_id',
            'desc'
        );

        $quotes = $this->db->get(
            "ip_quotes"
        )->result();

        // liste des factures recents
        $invoice_overview_period = $this->mdl_settings->setting('invoice_overview_period');

        switch ($quote_overview_period) {
            default:
            case 'this-month':
                $this->db->where(
                    "MONTH(ip_invoices.invoice_date_created) = MONTH(NOW()) AND YEAR(ip_invoices.invoice_date_created) = YEAR(NOW())"
                );
                break;
            case 'last-month':
                $this->db->where(
                    "MONTH(ip_invoices.invoice_date_created) = MONTH(NOW() - INTERVAL 1 MONTH) AND YEAR(ip_invoices.invoice_date_created) = YEAR(NOW())"
                );
                break;
            case 'this-quarter':
                $this->db->where(
                    "QUARTER(ip_invoices.invoice_date_created) = QUARTER(NOW())"
                );
                break;
            case 'last-quarter':
                $this->db->where(
                    "QUARTER(ip_invoices.invoice_date_created) = QUARTER(NOW() - INTERVAL 1 QUARTER)"
                );
                break;
            case 'this-year':
                $this->db->where(
                    "YEAR(ip_invoices.invoice_date_created) = YEAR(NOW())"
                );
                break;
            case 'last-year':
                $this->db->where(
                    "YEAR(ip_invoices.invoice_date_created) = YEAR(NOW() - INTERVAL 1 YEAR)"
                );
                break;
        }

        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');

        $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_invoices.invoice_delai_paiement', 'left');

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');

        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');

        $this->db->join('ip_users', 'ip_users.user_id = ip_invoices.user_id', 'left');

        $this->db->limit(10, 0);

        $this->db->order_by('ip_invoices.invoice_id', 'desc');

        $invoices = $this->db->get("ip_invoices")->result();

        // Liste des devises
        $devises = $this->db->get("ip_devises")->result();

        // Invoice amount
        $invoices_total_amounts = array();
        $all_statues_invoices = $this->mdl_invoices->statuses();
        foreach ($all_statues_invoices as $key => $status) {
            foreach ($devises as $devise) {
                $invoices_total_amounts[$key][$devise->devise_id]['amount'] = 0;
                $invoices_total_amounts[$key][$devise->devise_id]['class'] = $status['class'];
                $invoices_total_amounts[$key][$devise->devise_id]['label'] = $status['label'];
                $invoices_total_amounts[$key][$devise->devise_id]['href'] = $status['href'];
            }
        }

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->select("ip_invoices.invoice_status_id,ip_devises.devise_id as devise,ip_invoices.invoice_status_id, SUM(ip_invoice_amounts.invoice_total) as invoices_sum_total");
        $this->db->group_by(array("ip_devises.devise_id", "ip_invoices.invoice_status_id"));
        $invoices_total_amounts_db = $this->db->get("ip_invoices")->result();

        if (!empty($invoices_total_amounts_db)) {
            foreach ($invoices_total_amounts_db as $amount) {

                $invoices_total_amounts[$amount->invoice_status_id][$amount->devise]["amount"] = $amount->invoices_sum_total;
            }
        }

        // QUOTES AMOUNT
        $quotes_total_amounts = array();
        $all_statues_quotes = $this->mdl_quotes->statuses();
        foreach ($all_statues_quotes as $key => $status) {
            foreach ($devises as $devise) {
                $quotes_total_amounts[$key][$devise->devise_id]['amount'] = 0;
                $quotes_total_amounts[$key][$devise->devise_id]['class'] = $status['class'];
                $quotes_total_amounts[$key][$devise->devise_id]['label'] = $status['label'];
                $quotes_total_amounts[$key][$devise->devise_id]['href'] = $status['href'];
            }
        }
        $this->db->where("ip_quotes.delete <> 1 ");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->select("ip_quotes.quote_status_id,ip_devises.devise_id,count(ip_quotes.quote_id) as count,SUM(ip_quote_amounts.quote_item_subtotal) as quotes_sum_subtotal,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total");
        $this->db->group_by(array("ip_devises.devise_id", "ip_quotes.quote_status_id"));
        $quotes_total_amounts_db = $this->db->get("ip_quotes")->result();

        if (!empty($quotes_total_amounts_db)) {
            foreach ($quotes_total_amounts_db as $amount) {
                $quotes_total_amounts[$amount->quote_status_id][$amount->devise_id]["amount"] = $amount->quotes_sum_total;
            }
        }

//////////////////////////////////// GRAPH /////////////////////////////////////////////
        //
        //        QUOTES
        $this->db->where("ip_quotes.delete <> 1 ");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_quotes.quote_date_created) as month,YEAR(ip_quotes.quote_date_created) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total");
        $quote_groups = $this->db->get("ip_quotes")->result();

        $OPP_this_year = "";
        $OPP_ALL = "";
        foreach ($quote_groups as $quote_group) {
            $year = date("Y");
            if ($quote_group->year == $year) {
                foreach ($devises as $devise) {

                    if ($devise->devise_id == $quote_group->devise_id) {

                        if (!isset($OPP_this_year[$quote_group->devise_id]["amount"])) {
                            $OPP_this_year[$quote_group->devise_id]["amount"] = 0;
                        }
                        $OPP_this_year[$quote_group->devise_id]["amount"] += $quote_group->quotes_sum_total;
                    }
                }
            }
            $OPP_ALL[$quote_group->devise_id][$quote_group->year][$quote_group->month]["amount"] = $quote_group->quotes_sum_total;
        }

        // INVOICES
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_invoices.invoice_date_created) as month,YEAR(ip_invoices.invoice_date_created) as year,SUM(ip_invoice_amounts.invoice_total) as invoices_sum_total");
        $invoice_groups = $this->db->get("ip_invoices")->result();

        $CA_this_year = "";
        $CA_ALL = "";
        foreach ($invoice_groups as $invoice_group) {
            $year = date("Y");
            if ($invoice_group->year == $year) {
                foreach ($devises as $devise) {

                    if ($devise->devise_id == $invoice_group->devise_id) {

                        if (!isset($CA_this_year[$invoice_group->devise_id]["amount"])) {
                            $CA_this_year[$invoice_group->devise_id]["amount"] = 0;
                        }
                        $CA_this_year[$invoice_group->devise_id]["amount"] += $invoice_group->invoices_sum_total;
                    }
                }
            }
            $CA_ALL[$invoice_group->devise_id][$invoice_group->year][$invoice_group->month]["amount"] = $invoice_group->invoices_sum_total;
        }

        // USER VENTE
        $this->db->where(
            "ip_quotes.delete <> 1 "
        );

        if (
            $this->session->userdata['groupes_user_id'] != 1
        ) {
            $this->db->where(
                "ip_users.user_id",
                $this->session->userdata['user_id']
            );
        }
        $this->db->where("ip_quotes.quote_status_id", 4);

//        $this->db->where("ip_users.user_id", 12);
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_quotes.quote_date_accepte) as month,YEAR(ip_quotes.quote_date_accepte) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total");
        $quote_groups = $this->db->get("ip_quotes")->result();

        $UV_this_year = "";
        $UV_ALL = "";
        foreach ($quote_groups as $quote_group) {
            $year = date("Y");
            if ($quote_group->year == $year) {
                foreach ($devises as $devise) {

                    if ($devise->devise_id == $quote_group->devise_id) {

                        if (!isset($UV_this_year[$quote_group->devise_id]["amount"])) {
                            $UV_this_year[$quote_group->devise_id]["amount"] = 0;
                        }
                        $UV_this_year[$quote_group->devise_id]["amount"] += $quote_group->quotes_sum_total;
                    }
                }
            }
            $UV_ALL[$quote_group->devise_id][$quote_group->year][$quote_group->month]["amount"] = $quote_group->quotes_sum_total;
        }

//
        ////////////////////////////////////////////////////////////////////////////////////////

        $this->load->model('clients/mdl_clients');
        $this->load->model('activites/mdl_activites');
        $this->db->order_by("activites_date_created", "desc");
        $activites = $this->mdl_activites->get()->result();
        $userid = $this->session->userdata['user_id'];
        $contacts = $this->mdl_clients->get()->result();

        if ($this->session->userdata['groupes_user_id'] == 1) {
            $num_rows = $this->db->count_all_results('ip_clients');
        } else {
            $this->db->where('ip_clients.user_id', $userid);
            $num_rows = $this->db->count_all_results('ip_clients');
        }

        $this->load->helper('logs');
        $logs = getLogs();

        //return var_dump($logs);
        $this->layout->set(
            array(
                'invoices_total_amounts' => $invoices_total_amounts,
                'quotes_total_amounts' => $quotes_total_amounts,
                'invoice_status_period' => str_replace('-', '_', $invoice_overview_period),
                'quote_status_period' => str_replace('-', '_', $quote_overview_period),
                'invoices' => $invoices,
                'quotes' => $quotes,
                'invoice_statuses' => $this->mdl_invoices->statuses(),
                'quote_statuses' => $this->mdl_quotes->statuses(),
                'overdue_invoices' => $this->mdl_invoices->is_overdue()->limit(10)->get()->result(),
                'contacts' => $contacts,
                'num_rows' => $num_rows,
                'activites' => $activites,
                'devises' => $devises,
                'CA_this_year' => $CA_this_year,
                'OPP_this_year' => $OPP_this_year,
                'UV_this_year' => $UV_this_year,
                'OPP_ALL' => $OPP_ALL,
                'CA_ALL' => $CA_ALL,
                'UV_ALL' => $UV_ALL,
                'logs' => $logs,
                'abonnement' => abonnement(),
            )
        );

        $this->layout->buffer('content', 'dashboard/index');
        $this->layout->render();
    }

    public function get_requiredfield() {
        $this->load->model('settings/mdl_settings');
      //  $this->mdl_settings->load_settings();
      //  echo $this->mdl_settings->setting('signature');
      $this->load->model('societes/mdl_societes');
      if($this->session->userdata['groupes_user_id']==1){
      //$query = $this->db->query('SELECT * FROM  `ip_devises` ')->get()->result();
      $this->db->where('id_societes', 1);
      $societes = $this->mdl_societes->get()->result();
      $data=array('societes'=>$societes );
     // return var_dump($societes[0]->tax_code);die('h');
       //$this->layout->load_view('clients/modal_client_lookup', $data);

       if(!$societes[0]->raison_social_societes       
       || !$societes[0]->code_tva_societes || !$societes[0]->tax_code
       || !$societes[0]->mail_societes || !$societes[0]->tel_societes
       || !$this->mdl_settings->setting('invoice_logo')     
       ){
        $this->layout->load_view('settings/first', $data);
       }
    }
    }

    public function getrequiredfield() {
        $this->load->model('settings/mdl_settings');
      //  $this->mdl_settings->load_settings();
      //  echo $this->mdl_settings->setting('signature');
      $this->load->model('societes/mdl_societes');

      //$query = $this->db->query('SELECT * FROM  `ip_devises` ')->get()->result();
      $this->db->where('id_societes', 1);
      $societes = $this->mdl_societes->get()->result();
	  $data=array('societes'=>$societes );
       //$this->layout->load_view('clients/modal_client_lookup', $data); 
        $this->layout->load_view('settings/first', $data); 
    }
    
}