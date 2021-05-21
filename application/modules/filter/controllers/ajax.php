<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 * 
 * A free and open source web based invoicing system
 *
 * @package		InvoicePlane
 * @author		Kovah (www.kovah.de)
 * @copyright	Copyright (c) 2012 - 2015 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 * 
 */

class Ajax extends Admin_Controller {

    public $ajax_controller = TRUE;

    public function filter_invoices() {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('users/mdl_users');

        $query = $this->input->post('filter_query');

        $keywords = explode(' ', $query);
        $params = array();

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_invoices->like("CONCAT_WS('^',LOWER(invoice_number),invoice_date_created,invoice_date_due,LOWER(client_name),invoice_total,invoice_balance)", $keyword);
            }
        }

        $data = array(
            'invoices' => $this->mdl_invoices->get()->result(),
            'users' => $this->mdl_users->get()->result(),
            'invoice_statuses' => $this->mdl_invoices->statuses()
        );

        $this->layout->load_view('invoices/partial_invoice_table', $data);
    }

    public function filter_quotes() {
        $this->load->model('quotes/mdl_quotes');

        $query = $this->input->post('filter_query');

        $keywords = explode(' ', $query);
        $params = array();

        $rappel_quotes = $this->mdl_quotes->get_date_rappel();
        $arrayHasDates = array();
        $quotes = $this->mdl_quotes->get()->result();
        foreach ($quotes as $quote) {
            $has_dates = 0;
            foreach ($rappel_quotes as $rappel) {
                if ($rappel->rappel_qote_id && $rappel->rappel_qote_id == $quote->quote_id) {
                    $has_dates = 1;
                    break;
                }
            }
            array_push($arrayHasDates, $has_dates);
        }

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_quotes->like("CONCAT_WS('^',LOWER(quote_number),quote_date_created,quote_date_expires,LOWER(client_name),quote_total)", $keyword);
            }
        }

        $data = array(
            'rappel_quotes' => $rappel_quotes,
            'quotes' => $this->mdl_quotes->get()->result(),
            'arrayHasDates' => $arrayHasDates,
            'quote_statuses' => $this->mdl_quotes->statuses()
        );

        $this->layout->load_view('quotes/partial_quote_table', $data);
    }
    
        public function filter_product() {
        $this->load->model('products/mdl_products');

        $query = $this->input->post('filter_query');

        $keywords = explode(' ', $query);
        $params = array();

//        $rappel_quotes = $this->mdl_quotes->get_date_rappel();
//        $arrayHasDates = array();
//        $quotes = $this->mdl_quotes->get()->result();
//        foreach ($quotes as $quote) {
//            $has_dates = 0;
//            foreach ($rappel_quotes as $rappel) {
//                if ($rappel->rappel_qote_id && $rappel->rappel_qote_id == $quote->quote_id) {
//                    $has_dates = 1;
//                    break;
//                }
//            }
//            array_push($arrayHasDates, $has_dates);
//        }

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_products->like("CONCAT_WS('^',LOWER(product_sku),LOWER(product_name),LOWER(product_description),product_price,purchase_price,LOWER(family_name))", $keyword);
            }
        }

        $data = array(
            'products' => $this->mdl_products->get()->result(),
        );

        $this->layout->load_view('products/index', $data);
    }

    public function filter_clients() {
        $this->load->model('clients/mdl_clients');

        $query = $this->input->post('filter_query');

        $keywords = explode(' ', $query);
        $params = array();

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_clients->like("CONCAT_WS('^',LOWER(client_name),LOWER(ip_clients.client_id),LOWER(client_prenom),LOWER(client_societe),LOWER(client_zip),LOWER(client_city),LOWER(client_country),LOWER(client_email),LOWER(client_web),client_mobile,client_phone,client_active)", $keyword);
            }
        }

        $data = array(
            'records' => $this->mdl_clients->with_total_balance()->get()->result()
        );

        $this->layout->load_view('clients/partial_client_table', $data);
    }

    public function filter_payments() {
        $this->load->model('payments/mdl_payments');

        $query = $this->input->post('filter_query');

        $keywords = explode(' ', $query);
        $params = array();

        foreach ($keywords as $keyword) {
            if ($keyword) {
                $keyword = strtolower($keyword);
                $this->mdl_payments->like("CONCAT_WS('^',payment_date,LOWER(invoice_number),LOWER(client_name),payment_amount,LOWER(payment_method_name),LOWER(payment_note))", $keyword);
            }
        }

        $data = array(
            'payments' => $this->mdl_payments->get()->result()
        );

        $this->layout->load_view('payments/partial_payment_table', $data);
    }

    public function filter_invoices_user() {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('users/mdl_users');

        $user_id = $this->input->post('user_id');
        $date = $this->input->post('date');
        $statue = $this->input->post('statue');

        $this->db->select_max('invoice_date_created');
        $query_max_dat = $this->db->get('ip_invoices')->result();
        $this->db->select_min('invoice_date_created');
        $query_min_dat = $this->db->get('ip_invoices')->result();

        $params = array();

        if ($user_id != 0) {
            $this->mdl_invoices->where('ip_invoices.user_id', $user_id);
        }
        if ($date != 'all') {
            $this->mdl_invoices->where('YEAR(ip_invoices.invoice_date_created)', $date);
        }
        if ($statue != 'all') {
            $this->mdl_invoices->where('ip_invoices.invoice_status_id', $statue);
        }

        $invoices = $this->mdl_invoices->get()->result();

        $rappel_invoices = $this->mdl_invoices->get_date_rappel();
        //print_r($rappel_invoices); die;
        $arrayHasDates = array();
        foreach ($invoices as $invoice) {
            $has_dates = 0;
            foreach ($rappel_invoices as $rappel) {
                if ($rappel->rappel_qote_id && $rappel->rappel_qote_id == $invoice->invoice_id) {
                    $has_dates = 1;
                    break;
                }
            }
            array_push($arrayHasDates, $has_dates);
        }
        $data = array(
            'query_max_dat' => $query_max_dat,
            'query_min_dats' => $query_min_dat,
            'rappel_quotes' => $rappel_invoices,
            'invoices' => $invoices,
            'arrayHasDates' => $arrayHasDates,
            'users' => $this->mdl_users->get()->result(),
            'invoice_statuses' => $this->mdl_invoices->statuses()
        );

        $this->layout->load_view('invoices/partial_invoice_table', $data);
    }

    public function filter_quotes_user() {
        $this->load->model('quotes/mdl_quotes');

        $user_id = $this->input->post('user_id');
        $date = $this->input->post('date');
        $statue = $this->input->post('statue');

        $this->db->select_max('quote_date_created');
        $query_max_dat = $this->db->get('ip_quotes')->result();
        $this->db->select_min('quote_date_created');
        $query_min_dat = $this->db->get('ip_quotes')->result();

        $params = array();

        if ($user_id != 0) {
            $this->mdl_quotes->where('ip_quotes.user_id', $user_id);
        }
        if ($date != 'all') {
            $this->mdl_quotes->where('YEAR(ip_quotes.quote_date_created)', $date);
        }
        if ($statue != 'all') {
            $this->mdl_quotes->where('ip_quotes.quote_status_id', $statue);
        }

        $quotes = $this->mdl_quotes->get()->result();

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
            array_push($arrayHasDates, $has_dates);
        }
        $data = array(
            'query_max_dat' => $query_max_dat,
            'query_min_dats' => $query_min_dat,
            'rappel_quotes' => $rappel_quotes,
            'quotes' => $quotes,
            'arrayHasDates' => $arrayHasDates,
            'quote_statuses' => $this->mdl_quotes->statuses()
        );

        $this->layout->load_view('quotes/partial_quote_table', $data);
    }
    
      public function filter_families() {
        $this->load->model('products/mdl_products');

        $family_id = $this->input->post('family_id');
//        $date = $this->input->post('date');
//        $statue = $this->input->post('statue');



        $params = array();

        if ($family_id != 0) {
            $this->mdl_products->where('ip_products.family_id', $family_id);
        }
//        if ($date != 'all') {
//            $this->mdl_quotes->where('YEAR(ip_quotes.quote_date_created)', $date);
//        }


        $products = $this->mdl_products->get()->result();

        $data = array(
            'products' => $products,
        );

        $this->layout->load_view('products/partial_product_table', $data);
    }

    public function filter_quotes_date() {
        $this->load->model('quotes/mdl_quotes');

        $date = $this->input->post('date');
        $user_id = $this->input->post('user_id');
        $statue = $this->input->post('statue');

        $params = array();



        if ($date != 'all') {
            $this->mdl_quotes->where('YEAR(ip_quotes.quote_date_created)', $date);
        }
        if ($user_id != 0) {
            $this->mdl_quotes->where('ip_quotes.user_id', $user_id);
        }
        if ($statue != 'all') {
            $this->mdl_quotes->where('ip_quotes.quote_status_id', $statue);
        }


        $quotes = $this->mdl_quotes->get()->result();
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
            array_push($arrayHasDates, $has_dates);
        }
        $data = array(
            'rappel_quotes' => $rappel_quotes,
            'quotes' => $quotes,
            'arrayHasDates' => $arrayHasDates,
            'quote_statuses' => $this->mdl_quotes->statuses()
        );

        $this->layout->load_view('quotes/partial_quote_table', $data);
    }

    public function filter_invoices_date() {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('quote_rappel/mdl_quote_rappel');
        $this->load->model('users/mdl_users');


        $date = $this->input->post('date');
        $user_id = $this->input->post('user_id');
        $statue = $this->input->post('statue');

        $params = array();



        if ($date != 'all') {
            $this->mdl_invoices->where('YEAR(ip_invoices.invoice_date_created)', $date);
        } else {
            $this->mdl_invoices;
        }
        if ($user_id != 0) {
            $this->mdl_invoices->where('ip_invoices.user_id', $user_id);
        }
        if ($statue != 'all') {
            $this->mdl_quotes->where('ip_invoices.invoice_status_id', $statue);
        }


        $invoices = $this->mdl_invoices->get()->result();
        $rappel_invoices = $this->mdl_invoices->get_date_rappel();
        $arrayHasDates = array();

        foreach ($invoices as $invoice) {
            $has_dates = 0;
            foreach ($rappel_invoices as $rappel) {
                if ($rappel->rappel_qote_id && $rappel->rappel_qote_id == $invoice->invoice_id) {
                    $has_dates = 1;
                    break;
                }
            }
            array_push($arrayHasDates, $has_dates);
        }
        $data = array(
            'rappel_invoices' => $rappel_invoices,
            'invoices' => $invoices,
            'arrayHasDates' => $arrayHasDates,
            'users' => $this->mdl_users->get()->result(),
            'invoice_statuses' => $this->mdl_invoices->statuses()
        );

        $this->layout->load_view('invoices/partial_invoice_table', $data);
    }

    public function select_filter_statue() {
        $this->load->model('quotes/mdl_quotes');

        $statue = $this->input->post('statue');
        $date = $this->input->post('date');
        $user_id = $this->input->post('user_id');

        $params = array();

        if ($statue != 'all') {
            $this->mdl_quotes->where('ip_quotes.quote_status_id', $statue);
        }
        if ($user_id != 0) {
            $this->mdl_quotes->where('ip_quotes.user_id', $user_id);
        }
        if ($date != 'all') {
            $this->mdl_quotes->where('YEAR(ip_quotes.quote_date_created)', $date);
        }




        $quotes = $this->mdl_quotes->get()->result();

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
            array_push($arrayHasDates, $has_dates);
        }

        $data = array(
            'rappel_quotes' => $rappel_quotes,
            'quotes' => $quotes,
            'arrayHasDates' => $arrayHasDates,
            'quote_statuses' => $this->mdl_quotes->statuses()
        );

        $this->layout->load_view('quotes/partial_quote_table', $data);
    }

    public function select_filter_statue_invoice() {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('users/mdl_users');

        $statue = $this->input->post('statue');
        $date = $this->input->post('date');
        $user_id = $this->input->post('user_id');

        $params = array();

        if ($statue != 'all') {
            $this->mdl_invoices->where('ip_invoices.invoice_status_id', $statue);
        }
        if ($user_id != 0) {
            $this->mdl_invoices->where('ip_invoices.user_id', $user_id);
        }
        if ($date != 'all') {
            $this->mdl_invoices->where('YEAR(ip_invoices.invoice_date_created)', $date);
        }




        $invoices = $this->mdl_invoices->get()->result();

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

        $data = array(
            'rappel_invoices' => $rappel_quotes,
            'invoices' => $invoices,
            'arrayHasDates' => $arrayHasDates,
            'users' => $this->mdl_users->get()->result(),
            'invoice_statuses' => $this->mdl_invoices->statuses()
        );

        $this->layout->load_view('invoices/partial_invoice_table', $data);
    }

}
