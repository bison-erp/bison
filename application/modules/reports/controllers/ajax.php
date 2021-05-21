<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ajax extends Admin_Controller
{

    public $ajax_controller = true;
    public $maxtop = 5;
    public $users = array();
    public $idusers = array();
    public function update_chart_annuel()
    {
        $current_devise = $this->input->post('current_devise');

        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_invoices.invoice_date_created) as month,YEAR(ip_invoices.invoice_date_created) as year,SUM(ip_invoice_amounts.invoice_total) as invoices_sum_total,count(ip_invoices.invoice_id) as count_invoices");
        $invoice_groups = $this->db->get("ip_invoices")->result();

        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_quotes.quote_date_created) as month,YEAR(ip_quotes.quote_date_created) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total, count(ip_quotes.quote_id) as count_quotes");
        $quote_groups = $this->db->get("ip_quotes")->result();

        $current_year = date("Y");
        for ($i = 1; $i <= 12; $i++) {
            $chart[$i]['date'] = date("Y-m-d", mktime(0, 0, 0, $i, 1, $current_year));
            $chart[$i]['facture'] = 0;
            $chart[$i]['facture_1'] = 0;
            $chart[$i]['facture_2'] = 0;
            $chart[$i]['count_factures'] = 0;
            $chart[$i]['count_factures_1'] = 0;
            $chart[$i]['count_factures_2'] = 0;

            $chart2[$i]['date'] = date("Y-m-d", mktime(0, 0, 0, $i, 1, $current_year));
            $chart2[$i]['devis'] = 0;
            $chart2[$i]['devis_1'] = 0;
            $chart2[$i]['devis_2'] = 0;
            $chart2[$i]['count_devis'] = 0;
            $chart2[$i]['count_devis_1'] = 0;
            $chart2[$i]['count_devis_2'] = 0;
        }

        foreach ($invoice_groups as $invoice) {
            if ($invoice->year == $current_year) {
                $chart[$invoice->month]['facture'] = $invoice->invoices_sum_total;
                $chart[$invoice->month]['count_factures'] = $invoice->count_invoices;
            } else
            if ($invoice->year == $current_year - 1) {
                $chart[$invoice->month]['facture_1'] = $invoice->invoices_sum_total;
                $chart[$invoice->month]['count_factures_1'] = $invoice->count_invoices;
            } else
            if ($invoice->year == $current_year - 2) {
                $chart[$invoice->month]['facture_2'] = $invoice->invoices_sum_total;
                $chart[$invoice->month]['count_factures_2'] = $invoice->count_invoices;
            }
        }

        foreach ($quote_groups as $quote) {
            if ($quote->year == $current_year) {
                $chart2[$quote->month]['devis'] = $quote->quotes_sum_total;
                $chart2[$quote->month]['count_devis'] = $quote->count_quotes;
            } else
            if ($quote->year == $current_year - 1) {
                $chart2[$quote->month]['facture_1'] = $quote->quotes_sum_total;
                $chart2[$quote->month]['count_factures_1'] = $quote->count_quotes;
            } else
            if ($quote->year == $current_year - 2) {
                $chart2[$quote->month]['facture_2'] = $quote->quotes_sum_total;
                $chart2[$quote->month]['count_factures_2'] = $quote->count_quotes;
            }
        }

        $this->db->where("ip_devises.devise_id", $current_devise);
        $devise_info = $this->db->get("ip_devises")->result();

        $response = array(
            'chart' => array_values($chart),
            'devise_info' => $devise_info,
            'chart2' => array_values($chart2),
        );

        echo json_encode($response);
    }

    public function update_chart_mensuel()
    {
        $current_year = $this->input->post('current_year');
        $current_devise = $this->input->post('current_devise');

        $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_quotes.quote_date_created) as month,YEAR(ip_quotes.quote_date_created) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total, count(ip_quotes.quote_id) as count_quotes");
        $quote_groups = $this->db->get("ip_quotes")->result();

        $this->db->where("YEAR(ip_invoices.invoice_date_created)", $current_year);
        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_invoices.invoice_date_created) as month,YEAR(ip_invoices.invoice_date_created) as year,SUM(ip_invoice_amounts.invoice_total) as invoices_sum_total,count(ip_invoices.invoice_id) as count_invoices");
        $invoice_groups = $this->db->get("ip_invoices")->result();

        $this->db->where("YEAR(ip_clients.client_date_created)", $current_year);
        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_clients.client_date_created) as month,YEAR(ip_clients.client_date_created) as year,count(ip_clients.client_id) as count_clients");

        $client_groups = $this->db->get("ip_clients")->result();

        $this->db->where("ip_devises.devise_id", $current_devise);
        $devise_info = $this->db->get("ip_devises")->result();

        for ($i = 1; $i <= 12; $i++) {
            $chart[$i]['date'] = date("Y-m-d", mktime(0, 0, 0, $i, 1, $current_year));
            $chart[$i]['facture'] = 0;
            $chart[$i]['devis'] = 0;
            $chart[$i]['clients'] = 0;
            $chart[$i]['count_factures'] = 0;
            $chart[$i]['count_devis'] = 0;
        }

        foreach ($quote_groups as $quote) {
            $chart[$quote->month]['devis'] = $quote->quotes_sum_total;
            $chart[$quote->month]['count_devis'] = $quote->count_quotes;
        }
        foreach ($invoice_groups as $invoice) {
            $chart[$invoice->month]['facture'] = $invoice->invoices_sum_total;
            $chart[$invoice->month]['count_factures'] = $invoice->count_invoices;
        }
        foreach ($client_groups as $client) {
            $chart[$client->month]['clients'] = $client->count_clients;
        }

        $response = array(
            'chart' => array_values($chart),
            'devise_info' => $devise_info,
        );

        echo json_encode($response);
    }

    public function update_chart_clients()
    {
        $current_year = $this->input->post('current_year');
        $current_devise = $this->input->post('current_devise');

        $this->db->where("ip_devises.devise_id", $current_devise);
        $devise_info = $this->db->get("ip_devises")->result();

        $this->db->where("YEAR(ip_invoices.invoice_date_created)", $current_year);
        $this->db->where("ip_devises.devise_id", $current_devise);

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');

        $this->db->order_by("invoices_sum_total", "DESC");
        $this->db->group_by(array("ip_clients.client_id", "year"));
        $this->db->select("ip_clients.*,YEAR(ip_invoices.invoice_date_created) as year,SUM(ip_invoice_amounts.invoice_total) as invoices_sum_total,count(ip_invoices.invoice_id) as count_invoices");
        $invoice_groups = $this->db->get("ip_invoices")->result();
        $chart = array();
        $invoices_sum_total_others = 0;
        $invoices_count_total_others = 0;
        $cnt = 0;
        $maxtop = $this->maxtop;
        foreach ($invoice_groups as $invoice) {
            if ($cnt < $maxtop) {
                $chart[$invoice->client_id]['client_id'] = $invoice->client_id;
                $chart[$invoice->client_id]['client'] = $invoice->client_name . " " . $invoice->client_prenom;
                $chart[$invoice->client_id]['invoices'] = $invoice->invoices_sum_total;
                $chart[$invoice->client_id]['count_invoices'] = $invoice->count_invoices;
            } else {
                $invoices_sum_total_others += $invoice->invoices_sum_total;
                $invoices_count_total_others += $invoice->count_invoices;
            }
            $cnt++;
        }
        if ($cnt > $maxtop) {
            $chart[0]['client_id'] = 0;
            $chart[0]['client'] = "Autres";
            $chart[0]['invoices'] = $invoices_sum_total_others;
            $chart[0]['count_invoices'] = $invoices_count_total_others;
        }

        $response = array(
            'chart' => array_values($chart),
            'devise_info' => $devise_info,
        );

        echo json_encode($response);
    }

    public function update_chart_products()
    {

        $current_year = $this->input->post('current_year');
        $current_devise = $this->input->post('current_devise');

        $this->db->where("YEAR(ip_invoice_items.item_date_added)", $current_year);
        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_invoices', 'ip_invoices.invoice_id = ip_invoice_items.invoice_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_products', 'ip_products.product_sku = ip_invoice_items.item_code', 'left');
        $this->db->order_by("sum_total_products", "DESC");
        $this->db->group_by(array("ip_invoice_items.item_code"));

        $this->db->select("ip_products.product_name,ip_invoice_items.item_code,ip_products.*,SUM(ip_invoice_items.item_price*ip_invoice_items.item_quantity) as sum_total_products,SUM(ip_invoice_items.item_quantity) as count_products");

        $products_groups = $this->db->get("ip_invoice_items")->result();

        $chart1[0]['product_id'] = 0;
        $chart1[0]['sum_total_products'] = 0;
        $chart1[0]['count_products'] = 0;
        $chart1[0]['item_code'] = "Autres";
        $chart1[0]['product_name'] = "-";

        $i = 0;
        $maxtop = $this->maxtop;
        foreach ($products_groups as $product) {
            if ($product->product_id != "" && $i < $maxtop) {
                $chart[$product->product_id]['product_id'] = $product->product_id;
                $chart[$product->product_id]['sum_total_products'] = $product->sum_total_products;
                $chart[$product->product_id]['count_products'] = (int) $product->count_products;
                $chart[$product->product_id]['item_code'] = $product->item_code;
                $chart[$product->product_id]['product_name'] = $product->product_name;
                $i++;
            } else {
                $chart1[0]['product_id'] = 0;
                $chart1[0]['sum_total_products'] += $product->sum_total_products;
                $chart1[0]['count_products'] += (int) $product->count_products;
            }
        }
        $chart[0] = $chart1[0];
        $this->db->where("ip_devises.devise_id", $current_devise);
        $devise_info = $this->db->get("ip_devises")->result();

        $response = array(
            'chart' => array_values($chart),
            'devise_info' => $devise_info,
        );
        echo json_encode($response);
    }

    public function update_chart_commercials()
    {
        $current_year = $this->input->post('current_year');
        $current_devise = $this->input->post('current_devise');
        $current_group = $this->input->post('current_group');
        $first_date = $this->input->post('first_date');
        $end_date = $this->input->post('end_date');
        $monthfirst = $this->input->post('monthfirst');
        $monthend = $this->input->post('monthend');
         /*  $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_clients.user_id', 'left');
        $this->db->join('ip_groupes_users', 'ip_groupes_users.groupes_user_id = ip_users.groupes_user_id', 'left');

        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
         */
        //$this->db->where("ip_quotes.quote_status_id", '4');
        //  $this->db->having('ip_quotes.quote_status_id', '4');
        // $this->db->group_by("ip_quotes.user_id");
        //  $this->db->select("ip_quotes.quote_status_id,ip_users.user_id ,ip_devises.devise_id,YEAR(ip_quotes.quote_date_created) as year, (ip_quote_amounts.quote_total_final) as quote_total_final, count(ip_quotes.quote_id) as count_quotes,ip_quotes.quote_status_id as statut");
        // $this->db->order_by("ip_quotes.user_id", "DESC");
        if ($current_group != 0) {
            $this->db->where("ip_users.groupes_user_id", $current_group);
        }
        //  echo $first_date;
        if ($first_date != "" && $end_date != "") {
            //  echo '1';
            $this->db->where("ip_quotes.quote_date_created >=", date($first_date));
            $this->db->where("ip_quotes.quote_date_created <=", date($end_date));
        } else {
            //   echo '2';
            $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        }
        $this->db->where("ip_devises.devise_id", $current_devise);

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_clients.user_id', 'left');

        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');

        $this->db->distinct();
        $this->db->select("ip_quotes.user_id");
        $quote_groupstest = $this->db->get("ip_quotes")->result();

        $somm = 0;
        $countuser = 1;
        $array = [];
        foreach ($quote_groupstest as $aa) {
            $array[$aa->user_id]['countuser'] = $countuser;
            $array[$aa->user_id]['username'] = $this->getnameuser($aa->user_id);
            $array[$aa->user_id]['count_devis_valide'] = (float) $this->countqoutevalide($aa->user_id, $first_date, $end_date, $current_year)->counsquote_id;
            $array[$aa->user_id]['count_devis'] = (float) $this->countquote($aa->user_id, $first_date, $end_date, $current_year);
            $array[$aa->user_id]['devis'] = (float) $this->chiffreaffaire($aa->user_id, $first_date, $end_date, $current_year);
            $array[$aa->user_id]['quotes_sum_total'] = (float) $this->countqoutevalide($aa->user_id, $first_date, $end_date, $current_year)->quotes_sum_total;
            $array[$aa->user_id]['montantencaisser'] = (float) $this->countmontantencaisse($aa->user_id, $current_year, $first_date, $end_date);
            $array[$aa->user_id]['count_clients'] = (float) $this->countclient($aa->user_id, $first_date, $end_date, $current_year);
            $array[$aa->user_id]['count_prospect'] = (float) $this->countprospect($aa->user_id, $first_date, $end_date, $current_year);

            $countuser++;
        }

        //  return var_dump($array);die();

        //  return die('hh' . $first_date);

        /*    if ($first_date != "" && $end_date != "") {

        $this->db->where("ip_quotes.quote_date_created >=", $first_date);
        $this->db->where("ip_quotes.quote_date_created <=", $end_date);
        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->join('ip_groupes_users', 'ip_groupes_users.groupes_user_id = ip_users.groupes_user_id', 'left');

        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_quotes.user_id"));
        $this->db->select("ip_users.user_id,ip_devises.devise_id,YEAR(ip_quotes.quote_date_created) as year,ip_quote_amounts.quote_total_final as quote_total_final, count(ip_quotes.quote_id) as count_quotes,ip_quotes.quote_status_id as statut");
        } else {
        $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->join('ip_groupes_users', 'ip_groupes_users.groupes_user_id = ip_users.groupes_user_id', 'left');

        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_quotes.user_id"));
        $this->db->select("ip_users.user_id,ip_devises.devise_id,YEAR(ip_quotes.quote_date_created) as year,ip_quote_amounts.quote_total_final as quote_total_final, count(ip_quotes.quote_id) as count_quotes,ip_quotes.quote_status_id as statut");

        }
        $quote_groups = $this->db->get("ip_quotes")->result();*/

        /*  $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->join('ip_groupes_users', 'ip_groupes_users.groupes_user_id = ip_users.groupes_user_id', 'left');

        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_quotes.user_id", "ip_quotes.quote_status_id"));
        $this->db->order_by("quotes_sum_total");
        $this->db->select("ip_users.*,ip_devises.devise_id,YEAR(ip_quotes.quote_date_created) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total, count(ip_quotes.quote_id) as count_quotes,ip_quotes.quote_status_id");

        $quote_groups = $this->db->get("ip_quotes")->result();*/

        /*   $chart = array();

        $this->db->where("ip_clients.client_devise_id", $current_devise);
        $this->db->join('ip_clients', 'ip_clients.user_id = ip_users.user_id', 'left');
        $this->db->group_by("ip_users.user_id");
        $this->db->select("ip_users.user_id,count(ip_clients.client_id) as count_clients");
        $clients_groups = $this->db->get("ip_users")->result();

        $sommeqoutevalide = 0;
        // var_dump($quote_groups);
        foreach ($quote_groups as $quote) {
        $users[] = $this->getnameuser($quote->user_id);
        $idusers[] = $quote->user_id;
        $chart[$quote->user_id]['devis'] = $quote->quotes_sum_total;
        $chart[$quote->user_id]['count_devis'] = $quote->count_quotes;
        $chart[$quote->user_id]['username'] = $quote->user_name;

        //  $chart[$quote->user_id]['count_clients'] = 0;
        $chart[$quote->user_id]['count_devis_valide'] = $this->countqoutevalide($quote->user_id)->counsquote_id;
        $chart[$quote->user_id]['quotes_sum_total'] = $this->countqoutevalide($quote->user_id)->quotes_sum_total;
        $chart[$quote->user_id]['count_clients'] = $this->countclient($quote->user_id);
        $chart[$quote->user_id]['count_prospect'] = $this->countprospect($quote->user_id);
        $chart[$quote->user_id]['montant_encaisse'] = $this->countmontantencaisse($quote->user_id, $current_devise, $current_year, $first_date, $end_date);
        $chart[$quote->user_id]['countmontantencaissetotal'] = $this->countmontantencaissetotal($quote->user_id, $current_devise, $current_year, $first_date, $end_date);
        if ($quote->statut == '4') {
        $sommeqoutevalide = $sommeqoutevalide + $quote->quotes_sum_total;
        }
        $chart[$quote->user_id]['sommeqoutevalide'] = $sommeqoutevalide;

        //$chart[$quote->user_id]['sommeqoutevalide'] = $sommeqoutevalide + $quote->quotes_sum_total;
        /*  foreach ($clients_groups as $client) {
        if ($client->user_id == $quote->user_id) {
        $chart[$quote->user_id]['count_clients'] = $client->count_clients;
        }
        }*/
        // }
        //$sommeqoutevalide = $sommeqoutevalide + $this->sommeqoutevalide()[0]->quotes_sum_total;
        $this->db->where("ip_devises.devise_id", $current_devise);
        $devise_info = $this->db->get("ip_devises")->result();

        $this->db->join('ip_users', 'ip_quotes.user_id = ip_users.user_id', 'left');

        if ($first_date != "" && $end_date != "") {
            $this->db->where("ip_quotes.quote_date_created >=", $first_date);
            $this->db->where("ip_quotes.quote_date_created <=", $end_date);
        } else {
             $this->db->where("MONTH(ip_quotes.quote_date_created) <=", date('m'));
            $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        }

        $this->db->group_by(array("user_id"));
        $this->db->select("ip_quotes.user_id");
        $quote_groups = $this->db->get("ip_quotes")->result();
        $arraycourbe = array();
        $usercourbe = array();

        $labels = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet",
        "Août", "Septembre", "Octobre",
        "Novembre", "Décembre");
        $labelarray = array();
        /*foreach ($labelarray as $j) {

        $labelarray[$j]=
        } */
        //array_reverse($labels);
        //return var_dump(array_reverse($labels));

        //$diff = $date$date2;
        //    $dates = $this->getDatesBetween('2008-01-01', '2009-01-15');
        //  return var_dump($dates);
        /*  if ($monthend - $monthfirst > 0) {
        return var_dump(array_slice($labels, $monthfirst - 1, abs($monthend - $monthfirst) + 1));

        } else {
        return var_dump(array_slice(array_reverse($labels), abs($monthend - $monthfirst) + 1, $monthfirst - 1));

        }*/
        foreach ($quote_groups as $key) {

            $arraycourbe[] = $this->countqoutevalidemonth($key->user_id, $first_date, $end_date, $monthfirst, $monthend,$current_year);
            $usercourbe[] = $this->getnameuser($key->user_id);

        };
        $labelsres = array();
        if ($first_date != "" && $end_date != "") {
            $labelsres[] = $this->getDatesBetween($first_date, $end_date);
        } else {
            $labelsres[] = $this->getDatesBetween("$current_year-01-01", date('Y-m-d'));
        };
        $response = array(
            'chart' => array_values($array),
            'devise_info' => $devise_info,
            'countvalide' => $this->sommeqoutevalide()[0]->countvalide,
            'users' => $users,
            'countarray' => count($array),
            'arraycourbe' => $arraycourbe,
            'usercourbe' => $usercourbe,
            'datediff' => $labelsres[0],
        );

        echo json_encode($response);
    }

    public function countqoutevalide($user_id, $first_date = "", $end_date = "", $current_year = "")
    {
        if ($first_date != "" && $end_date != "") {
            $this->db->where("ip_quotes.quote_date_created >=", $first_date);
            $this->db->where("ip_quotes.quote_date_created <=", $end_date);
        } else {
            $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        }

        $this->db->where("ip_quotes.user_id", $user_id);
        $this->db->where("ip_quotes.quote_status_id", '4');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->order_by("quotes_sum_total", "DESC");
        //  $this->db->select("ip_users.*,ip_devises.devise_id,YEAR(ip_quotes.quote_date_created) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total, count(ip_quotes.quote_id) as count_quotes");
        $this->db->select("SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total,count(ip_quotes.quote_id) as counsquote_id");

        $ip_quotes = $this->db->get("ip_quotes")->result();
        return $ip_quotes[0];
    }
    public function sommeqoutevalide($user_id, $current_devise, $current_year, $first_date = "", $end_date = "")
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        if ($first_date != "" && $end_date != "") {
            $this->db->where("ip_quotes.quote_date_accepte >=", $first_date);
            $this->db->where("ip_quotes.quote_date_accepte <=", $end_date);
        } else {
            $this->db->where("YEAR(ip_quotes.quote_date_accepte)", $current_year);
        }
        $this->db->where("ip_clients.client_devise_id", $current_devise);
        $this->db->where("ip_clients.user_id", $user_id);
        $this->db->where("ip_quotes.quote_status_id", '4');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        //  $this->db->select("ip_users.*,ip_devises.devise_id,YEAR(ip_quotes.quote_date_created) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total, count(ip_quotes.quote_id) as count_quotes");
        // $this->db->group_by("ip_clients.user_id");
        $this->db->select("SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total,count(ip_quotes.quote_id) as countvalide");

        $ip_quotes = $this->db->get("ip_quotes")->result();
        return $ip_quotes;
    }
    public function countclient($user_id, $first_date = "", $end_date = "", $current_year = "")
    {
        $this->db->join('ip_quotes', 'ip_quotes.client_id = ip_clients.client_id', 'left');

        if ($first_date != "" && $end_date != "") {
            $this->db->where("ip_quotes.quote_date_created >=", $first_date);
            $this->db->where("ip_quotes.quote_date_created <=", $end_date);
        } else {
            $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        }

        $this->db->where("ip_clients.user_id", $user_id);
        $this->db->where("ip_clients.client_type", '1');
        $this->db->group_by('ip_clients.client_id');
        $ip_clients = $this->db->get("ip_clients")->result();
        return count($ip_clients);
    }

    public function countprospect($user_id, $first_date = "", $end_date = "", $current_year = "")
    {
        $this->db->join('ip_quotes', 'ip_quotes.client_id = ip_clients.client_id', 'left');

        if ($first_date != "" && $end_date != "") {
            $this->db->where("ip_quotes.quote_date_created >=", $first_date);
            $this->db->where("ip_quotes.quote_date_created <=", $end_date);
        } else {
            $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        }

        $this->db->group_by('ip_clients.client_id');
        $this->db->where("ip_clients.user_id", $user_id);
        $this->db->where("ip_clients.client_type", '0');
        $ip_clients = $this->db->get("ip_clients")->result();
        return count($ip_clients);
    }

    public function countmontantencaisse($user_id, $current_year, $first_date = "", $end_date = "")
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
        if ($first_date != "" && $end_date != "") {
            $this->db->where("ip_payments.payment_date >=", $first_date);
            $this->db->where("ip_payments.payment_date <=", $end_date);
        } else {
            $this->db->where("YEAR(ip_payments.payment_date)", $current_year);
        }

        $this->db->where("ip_clients.user_id", $user_id);
        $this->db->select("SUM(ip_payments.payment_amount) as payment_amount_total");
        $ip_payments = $this->db->get("ip_payments")->result();

        if ($ip_payments[0]->payment_amount_total) {
            return $ip_payments[0]->payment_amount_total;
        } else {
            return 0;
        }
    }

    public function countmontantencaissetotal($user_id, $current_devise, $current_year, $first_date = "", $end_date = "")
    {

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
        $this->db->where("ip_clients.user_id", $user_id);

        $this->db->where("ip_clients.client_devise_id", $current_devise);
        if ($first_date != "" && $end_date != "") {
            $this->db->where("ip_payments.payment_date >=", $first_date);
            $this->db->where("ip_payments.payment_date <=", $end_date);
        } else {
            $this->db->where("YEAR(ip_payments.payment_date)", $current_year);
        }
        $this->db->select("SUM(ip_payments.payment_amount) as payment_amount_total");
        $ip_payments = $this->db->get("ip_payments")->result();
        if ($ip_payments[0]->payment_amount_total) {
            return $ip_payments[0]->payment_amount_total;
        } else {
            return 0;
        }
    }

    public function getnameuser($id)
    {
        $this->db->where("ip_users.user_id", $id);

        $this->db->select("ip_users.user_name as user_name");
        $ip_users = $this->db->get("ip_users")->result();
        return $ip_users[0]->user_name;
    }
    public function statcourbe()
    { //return var_dump('1');die();
        // $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->group_by(array("user_id"));
        $this->db->select("ip_quotes.user_id");
        $quote_groups = $this->db->get("ip_quotes")->result();

        $array = array();
        foreach ($quote_groups as $key) {

            $array[] = $this->countqoutevalidemonth($key->user_id);

        };
        $response = array(
            'data' => $array,
        );
        //  json_encode
        //  return var_dump($array);die();
        echo ((json_encode($response)));
    }

    public function countqoutevalidemonth($user_id, $first_date = "", $end_date = "", $monthfirst = "", $monthend = "",$current_year="")
    {

        /*   if ($first_date != "" && $end_date != "") {
        $this->db->where("ip_quotes.quote_date_created >=", $first_date);
        $this->db->where("ip_quotes.quote_date_created <=", $end_date);
        } else {
        $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        }*/

        $array = array();
        //   return die('hh' . $end_date);
      //  if ($first_date != "" && $end_date != "") {
         /*return var_dump('1'.$end_date); die();
          if(isset($end_date)&&isset($first_date)){

          }*/
          //  for ($i = 1; $i <= date('m'); $i++) {
           /*   $bc=0;
             if(date('m')=='01'){
                 $bc=1;
               
            }else{
                $bc=12;
               var_dump($bc);
            }*/
            $aaa=0;
            // $this->db->where("MONTH(ip_quotes.quote_date_created) <=", date('m'));
            if ($current_year!=date('Y')) {
               
            
                for ($i = 1; $i <=12; $i++) {
             //   if($i<=date("m") && $current_year=date("Y")){
                 
                $this->db->where("ip_quotes.user_id", $user_id);
                $this->db->where("ip_quotes.quote_status_id", '4');
                $this->db->where("MONTH(ip_quotes.quote_date_created) >=", $i);
                $this->db->where("MONTH(ip_quotes.quote_date_created) <=", $i);
                $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
                //  $this->db->select("MONTH(ip_quotes.quote_date_created) as month");
                $ip_quotesvalide = $this->db->get("ip_quotes")->result();

                $this->db->where("ip_quotes.user_id", $user_id);
                $this->db->where("MONTH(ip_quotes.quote_date_created) >=", $i);
                $this->db->where("MONTH(ip_quotes.quote_date_created) <=", $i);
                $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
                // $this->db->where("ip_quotes.quote_status_id !=", 4, false);

                //  $this->db->select("MONTH(ip_quotes.quote_date_created) as month");
                $ip_quotes = $this->db->get("ip_quotes")->result();
                if (count($ip_quotes) > 0) {
                    $array[] = round(((count($ip_quotesvalide) * 100) / count($ip_quotes)), 0);
                } else {
                    $array[] = 0;

                }
           /* }elseif($current_year != date("Y")){
                
                    $this->db->where("ip_quotes.user_id", $user_id);
                    $this->db->where("ip_quotes.quote_status_id", '4');
                    $this->db->where("MONTH(ip_quotes.quote_date_created) >=", $i);
                    $this->db->where("MONTH(ip_quotes.quote_date_created) <=", $i);
                    $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
                    //  $this->db->select("MONTH(ip_quotes.quote_date_created) as month");
                    $ip_quotesvalide = $this->db->get("ip_quotes")->result();
    
                    $this->db->where("ip_quotes.user_id", $user_id);
                    $this->db->where("MONTH(ip_quotes.quote_date_created) >=", $i);
                    $this->db->where("MONTH(ip_quotes.quote_date_created) <=", $i);
                    $this->db->where("YEAR(ip_quotes.quote_date_created) >=", $current_year);
                    $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
                    // $this->db->where("ip_quotes.quote_status_id !=", 4, false);
    
                    //  $this->db->select("MONTH(ip_quotes.quote_date_created) as month");
                    $ip_quotes = $this->db->get("ip_quotes")->result();
                    if (count($ip_quotes) > 0) {
                        $array[] = round(((count($ip_quotesvalide) * 100) / count($ip_quotes)), 0);
                    } else {
                        $array[] = 0;
                    }
               
            }*/
             }
        }  else {
             for ($i = 1; $i <= date('m'); $i++) {
                $this->db->where("ip_quotes.user_id", $user_id);
                $this->db->where("ip_quotes.quote_status_id ", '4');
                $this->db->like("MONTH(ip_quotes.quote_date_created)", $i);
                $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);

                //  $this->db->select("MONTH(ip_quotes.quote_date_created) as month");
                $ip_quotesvalide = $this->db->get("ip_quotes")->result();
                 $this->db->where("ip_quotes.user_id", $user_id);
                // $this->db->where("ip_quotes.quote_status_id !=", 4, false);

                $this->db->like("MONTH(ip_quotes.quote_date_created)", $i);
                $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);

                //  $this->db->select("MONTH(ip_quotes.quote_date_created) as month");
                $ip_quotes = $this->db->get("ip_quotes")->result();
                 if (count($ip_quotes) > 0) {
                    $array[] = round(((count($ip_quotesvalide) * 100) / count($ip_quotes)), 0);
                } else {
                    $array[] = 0;

                }

            }
      
    }
        return $array;
    }

    public function countquote($user_id, $first_date = "", $end_date = "", $current_year = "")
    {
        if ($first_date != "" && $end_date != "") {
            $this->db->where("ip_quotes.quote_date_created >=", $first_date);
            $this->db->where("ip_quotes.quote_date_created <=", $end_date);
        } else {
            $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        }
        $this->db->select('count(ip_quotes.quote_id) as count');
        $this->db->where("ip_quotes.user_id", $user_id);
        $ip_quotes = $this->db->get("ip_quotes")->result();
        return $ip_quotes[0]->count;
    }

    public function chiffreaffaire($user_id, $first_date = "", $end_date = "", $current_year = "")
    {
        if ($first_date != "" && $end_date != "") {
            $this->db->where("ip_quotes.quote_date_created >=", $first_date);
            $this->db->where("ip_quotes.quote_date_created <=", $end_date);
        } else {
            $this->db->where("YEAR(ip_quotes.quote_date_created)", $current_year);
        }

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->join('ip_groupes_users', 'ip_groupes_users.groupes_user_id = ip_users.groupes_user_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->where("ip_quotes.user_id", $user_id);
        $this->db->select("sum(ip_quote_amounts.quote_total_final) as quote_total_final");
        $ip_quotes = $this->db->get("ip_quotes")->result();
        return $ip_quotes[0]->quote_total_final;
    }

    public function countmontantencaissetot($user_id)
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
        $this->db->where("ip_clients.user_id", $user_id);
        $this->db->select("SUM(ip_payments.payment_amount) as payment_amount_total");
        $ip_payments = $this->db->get("ip_payments")->result();

        return $ip_payments[0]->payment_amount_total;

    }

    public function getDatesBetween($start = "", $end = "")
    {
      
        $valmois = ["01" => "Janvier", "02" => "Février", "03" => "Mars", "04" => "Avril", "05" => "Mai", "06" => "Juin",
            "07" => "Juillet", "08" => "Août", "09" => "Septembre", "10" => "Octobre",
            "11" => "Novembre", "12" => "Décembre",
        ];
        if ($start > $end) {
            return false;
        }
        $sdate = strtotime("$start +1 day");
        $edate = strtotime($end);
        $dates = array();

        for ($i = $sdate; $i < $edate; $i += strtotime('+1 day', 0)) {
            $dates[] = date('m', $i);
        }
        $items_thread = array_unique($dates, SORT_REGULAR);
        $array = array();
        foreach ($items_thread as $key => $value) {
            $array[] = $valmois[$value];
        }
        return $array;
    }
}