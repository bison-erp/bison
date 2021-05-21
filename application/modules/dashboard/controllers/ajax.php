<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends Admin_Controller {

    public $ajax_controller = TRUE;
    public $maxtop = 5;

    public function update_chart_mensuel() {
        $current_year = date('Y');
        $current_devise = $this->input->post('current_devise');
        $user_id_stat = $this->input->post('user_id_stat');


        $this->db->where("ip_quotes.delete <> 1 ");
        if ($user_id_stat != 0) {

            $this->db->where("ip_users.user_id", $user_id_stat);
        }

        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_quotes.quote_date_created) as month,YEAR(ip_quotes.quote_date_created) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total, count(ip_quotes.quote_id) as count_quotes");
        $quote_groups = $this->db->get("ip_quotes")->result();



        $this->db->where("ip_quotes.delete <> 1 ");
        if ($user_id_stat != 0) {

            $this->db->where("ip_clients.user_id", $user_id_stat);
        }

        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->where("ip_quotes.quote_status_id", 4);
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_quotes.quote_date_accepte) as month,YEAR(ip_quotes.quote_date_accepte) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total, count(ip_quotes.quote_id) as count_quotes");
        $quote_accepted = $this->db->get("ip_quotes")->result();


        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_users', 'ip_users.user_id = ip_invoices.user_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_invoices.invoice_date_created) as month,YEAR(ip_invoices.invoice_date_created) as year,SUM(ip_invoice_amounts.invoice_total) as invoices_sum_total,count(ip_invoices.invoice_id) as count_invoices");
        $invoice_groups = $this->db->get("ip_invoices")->result();

        if ($user_id_stat != 0) {

            $this->db->where("ip_clients.user_id", $user_id_stat);
        }

        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "month", "year"));
        $this->db->select("ip_devises.devise_id,MONTH(ip_clients.client_date_created) as month,YEAR(ip_clients.client_date_created) as year,count(ip_clients.client_id) as count_clients");

        $client_groups = $this->db->get("ip_clients")->result();

        $this->db->where("ip_devises.devise_id", $current_devise);
        $devise_info = $this->db->get("ip_devises")->result();
        $curr_month = (int) date("m");
        for ($i = 1; $i <= 12; $i++) {
            $month_selected = date("m", mktime(0, 0, 0, $curr_month + $i - 12, 1, $current_year));
            $year_selected = date("Y", mktime(0, 0, 0, $curr_month + $i - 12, 1, $current_year));

            $chart[$year_selected . $month_selected]['date'] = date("m\nY", mktime(0, 0, 0, $curr_month + $i - 12, 1, $current_year));
            $chart[$year_selected . $month_selected]['facture'] = 0;
            $chart[$year_selected . $month_selected]['devis'] = 0;
            $chart[$year_selected . $month_selected]['devis_acc'] = 0;
            $chart[$year_selected . $month_selected]['clients'] = 0;
            $chart[$year_selected . $month_selected]['count_factures'] = 0;
            $chart[$year_selected . $month_selected]['count_devis'] = 0;
            $chart[$year_selected . $month_selected]['count_devis_acc'] = 0;
        }

        foreach ($quote_groups as $quote) {
            $quote->month = str_pad($quote->month, 2, "0", STR_PAD_LEFT);
            if (isset($chart[$quote->year . $quote->month])) {

                $chart[$quote->year . $quote->month]['devis'] = $quote->quotes_sum_total;
                $chart[$quote->year . $quote->month]['count_devis'] = $quote->count_quotes;
            }
        }

        foreach ($quote_accepted as $quote_acc) {
            $quote_acc->month = str_pad($quote_acc->month, 2, "0", STR_PAD_LEFT);
            if (isset($chart[$quote_acc->year . $quote_acc->month])) {

                $chart[$quote_acc->year . $quote_acc->month]['devis_acc'] = $quote_acc->quotes_sum_total;
                $chart[$quote_acc->year . $quote_acc->month]['count_devis_acc'] = $quote_acc->count_quotes;
            }
        }
        foreach ($invoice_groups as $invoice) {
            $invoice->month = str_pad($invoice->month, 2, "0", STR_PAD_LEFT);
            if (isset($chart[$invoice->year . $invoice->month])) {
                $chart[$invoice->year . $invoice->month]['facture'] = $invoice->invoices_sum_total;
                $chart[$invoice->year . $invoice->month]['count_factures'] = $invoice->count_invoices;
            }
        }
        foreach ($client_groups as $client) {
            $client->month = str_pad($client->month, 2, "0", STR_PAD_LEFT);
            if (isset($chart[$client->year . $client->month])) {
                $chart[$client->year . $client->month]['clients'] = $client->count_clients;
            }
        }

        $response = array(
            'chart' => array_values($chart),
            'devise_info' => $devise_info,
        );
//        echo "<pre>";
//        print_r($response);
//        echo "</pre>";
        echo json_encode($response);
    }
    public function update_chart_annuel() {
        $current_year = date('Y');
        $current_devise = $this->input->post('current_devise');
        $user_id_stat = $this->input->post('user_id_stat');


        $this->db->where("ip_quotes.delete <> 1 ");
        if ($user_id_stat != 0) {

            $this->db->where("ip_users.user_id", $user_id_stat);
        }

        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id",  "year"));
        $this->db->select("ip_devises.devise_id,YEAR(ip_quotes.quote_date_created) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total, count(ip_quotes.quote_id) as count_quotes");
        $quote_groups = $this->db->get("ip_quotes")->result();



        $this->db->where("ip_quotes.delete <> 1 ");
        if ($user_id_stat != 0) {

            $this->db->where("ip_clients.user_id", $user_id_stat);
        }

        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->where("ip_quotes.quote_status_id", 4);
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "year"));
        $this->db->select("ip_devises.devise_id,YEAR(ip_quotes.quote_date_accepte) as year,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total, count(ip_quotes.quote_id) as count_quotes");
        $quote_accepted = $this->db->get("ip_quotes")->result();


        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_users', 'ip_users.user_id = ip_invoices.user_id', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "year"));
        $this->db->select("ip_devises.devise_id,YEAR(ip_invoices.invoice_date_created) as year,SUM(ip_invoice_amounts.invoice_total) as invoices_sum_total,count(ip_invoices.invoice_id) as count_invoices");
        $invoice_groups = $this->db->get("ip_invoices")->result();

        if ($user_id_stat != 0) {

            $this->db->where("ip_clients.user_id", $user_id_stat);
        }

        $this->db->where("ip_devises.devise_id", $current_devise);
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->group_by(array("ip_devises.devise_id", "year"));
        $this->db->select("ip_devises.devise_id,YEAR(ip_clients.client_date_created) as year,count(ip_clients.client_id) as count_clients");

        $client_groups = $this->db->get("ip_clients")->result();

        $this->db->where("ip_devises.devise_id", $current_devise);
        $devise_info = $this->db->get("ip_devises")->result();

        for ($i = 3; $i >= 0; $i--) {

            $year_selected = date("Y", mktime(0, 0, 0, 1, 1, $current_year-$i));

            $chart[$year_selected]['date'] = date("Y", mktime(0, 0, 0, 1, 1, $year_selected));
            $chart[$year_selected]['facture'] = 0;
            $chart[$year_selected]['devis'] = 0;
            $chart[$year_selected]['devis_acc'] = 0;
            $chart[$year_selected]['clients'] = 0;
            $chart[$year_selected]['count_factures'] = 0;
            $chart[$year_selected]['count_devis'] = 0;
            $chart[$year_selected]['count_devis_acc'] = 0;
        }

        foreach ($quote_groups as $quote) {
            if (isset($chart[$quote->year])) {

                $chart[$quote->year]['devis'] = $quote->quotes_sum_total;
                $chart[$quote->year]['count_devis'] = $quote->count_quotes;
            }
        }

        foreach ($quote_accepted as $quote_acc) {
            if (isset($chart[$quote_acc->year])) {

                $chart[$quote_acc->year]['devis_acc'] = $quote_acc->quotes_sum_total;
                $chart[$quote_acc->year]['count_devis_acc'] = $quote_acc->count_quotes;
            }
        }
        foreach ($invoice_groups as $invoice) {
            if (isset($chart[$invoice->year])) {
                $chart[$invoice->year]['facture'] = $invoice->invoices_sum_total;
                $chart[$invoice->year]['count_factures'] = $invoice->count_invoices;
            }
        }
        foreach ($client_groups as $client) {

            if (isset($chart[$client->year])) {
                $chart[$client->year]['clients'] = $client->count_clients;
            }
        }

        $response = array(
            'chart' => array_values($chart),
            'devise_info' => $devise_info,
        );
//        echo "<pre>";
//        print_r($response);
//        echo "</pre>";
        echo json_encode($response);
    }

    public function getAll() {
        $selectval = trim($this->input->post('selectval'));

        $this->db
        ->where("ip_clients.delete <> 1 ")
        ->like("trim(ip_clients.client_name)", $selectval)   
        ->or_like("trim(ip_clients.client_prenom)", $selectval)     
        ->or_like("trim(ip_clients.client_email)", $selectval)     
        ->or_like("trim(ip_clients.client_mobile)", $selectval)     
        ->or_like("trim(ip_clients.client_phone)", $selectval)
        ->or_like("trim(ip_clients.client_societe)", $selectval);
        //$this->db->select("ip_clients");    
        $ip_clients = $this->db->get("ip_clients")->result();
        
        $this->db       
        ->like("trim(ip_invoices.invoice_number)", $selectval)
        ->or_like("trim(ip_clients.client_prenom)", $selectval)     
        ->or_like("trim(ip_clients.client_email)", $selectval)     
        ->or_like("trim(ip_clients.client_mobile)", $selectval)     
        ->or_like("trim(ip_clients.client_phone)", $selectval)
        ->or_like("trim(ip_clients.client_societe)", $selectval)
        ->where("ip_invoices.avoir <> 1 ")
        ->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $ip_invoices = $this->db->get("ip_invoices")->result();

        $this->db  
        ->where("ip_quotes.delete <> 1 ")     
        ->like("trim(ip_quotes.quote_number)", $selectval)
        ->or_like("trim(ip_clients.client_prenom)", $selectval)     
        ->or_like("trim(ip_clients.client_email)", $selectval)     
        ->or_like("trim(ip_clients.client_mobile)", $selectval)     
        ->or_like("trim(ip_clients.client_phone)", $selectval)
        ->or_like("trim(ip_clients.client_societe)", $selectval)
        ->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $ip_quotes = $this->db->get("ip_quotes")->result();

        $this->db  
        ->where("ip_bl.delete <> 1 ")     
        ->like("trim(ip_bl.bl_number)", $selectval)
        ->or_like("trim(ip_clients.client_prenom)", $selectval)     
        ->or_like("trim(ip_clients.client_email)", $selectval)     
        ->or_like("trim(ip_clients.client_mobile)", $selectval)     
        ->or_like("trim(ip_clients.client_phone)", $selectval)
        ->or_like("trim(ip_clients.client_societe)", $selectval)
        ->join('ip_clients', 'ip_clients.client_id = ip_bl.client_id', 'left');
        $ip_bl = $this->db->get("ip_bl")->result();

        $this->db         
        ->like("trim(ip_products.product_sku)", $selectval)
        ->or_like("trim(ip_products.product_name)", $selectval)   
        ->or_like("trim(ip_products.product_description)", $selectval)   
        ->or_like("trim(ip_products.product_description_eng)", $selectval)   
        ->or_like("trim(ip_products.product_description_ar)", $selectval)   
        ->or_like("trim(ip_products.product_name_en)", $selectval)  
        ->or_like("trim(ip_products.product_name_ar)", $selectval)   
        ->or_like("trim(ip_products.product_price)", $selectval)  
        ->or_like("trim(ip_products.purchase_price)", $selectval)
        ->join('ip_fournisseurs', 'ip_fournisseurs.id_fournisseur = ip_products.fournisseur_id', 'left')
        ->join('ip_families', 'ip_families.family_id = ip_products.family_id', 'left'); 
        $ip_products = $this->db->get("ip_products")->result();

        $this->db         
        ->like("trim(ip_payments.payment_id)", $selectval)
        ->or_like("trim(ip_clients.client_prenom)", $selectval)     
        ->or_like("trim(ip_clients.client_email)", $selectval)     
        ->or_like("trim(ip_clients.client_mobile)", $selectval)     
        ->or_like("trim(ip_clients.client_phone)", $selectval)
        ->or_like("trim(ip_clients.client_societe)", $selectval)
        ->or_like("trim(ip_invoices.invoice_number)", $selectval)    
        ->join('ip_invoices', 'ip_invoices.invoice_id = ip_payments.invoice_id', 'left')
        ->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
        $ip_payments = $this->db->get("ip_payments")->result();

        $this->db  
        ->where("ip_fabrication.delete <> 1 ")     
        ->like("trim(ip_fabrication.fabrication_id)", $selectval)
        ->or_like("trim(ip_clients.client_prenom)", $selectval)     
        ->or_like("trim(ip_clients.client_email)", $selectval)     
        ->or_like("trim(ip_clients.client_mobile)", $selectval)    
        ->or_like("trim(ip_clients.client_societe)", $selectval) 
        ->or_like("trim(ip_clients.client_phone)", $selectval)
        ->join('ip_clients', 'ip_clients.client_id = ip_fabrication.client_id', 'left');
        $ip_fabrication = $this->db->get("ip_fabrication")->result();

        $this->db  
        ->like("trim(ip_commande.commande_number)", $selectval)
        ->or_like("trim(ip_clients.client_prenom)", $selectval)     
        ->or_like("trim(ip_clients.client_email)", $selectval)     
        ->or_like("trim(ip_clients.client_mobile)", $selectval)     
        ->or_like("trim(ip_clients.client_phone)", $selectval)
        ->or_like("trim(ip_clients.client_societe)", $selectval)
        ->or_like("trim(ip_commande.commande_number)", $selectval)
        ->join('ip_clients', 'ip_clients.client_id = ip_commande.client_id', 'left');
        $ip_commande = $this->db->get("ip_commande")->result();

        $this->db         
        ->or_like("trim(ip_clients.client_prenom)", $selectval)     
        ->or_like("trim(ip_clients.client_email)", $selectval)     
        ->or_like("trim(ip_clients.client_mobile)", $selectval)     
        ->or_like("trim(ip_clients.client_phone)", $selectval)
        ->or_like("trim(ip_clients.client_societe)", $selectval)
        ->or_like("trim(ip_haveinvoices.invoice_number)", $selectval)    
        ->join('ip_invoices', 'ip_invoices.invoice_id = ip_haveinvoices.invoice_id', 'left')
        ->join('ip_clients', 'ip_clients.client_id = ip_haveinvoices.client_id', 'left');
        $ip_haveinvoices = $this->db->get("ip_haveinvoices")->result();

        $this->db  
        ->like("trim(ip_fournisseurs.raison_social_fournisseur)", $selectval)
        ->or_like("trim(ip_fournisseurs.code_postal_fournisseur)", $selectval)     
        ->or_like("trim(ip_fournisseurs.mail_fournisseur)", $selectval)     
        ->or_like("trim(ip_fournisseurs.prenom)", $selectval)     
        ->or_like("trim(ip_fournisseurs.nom)", $selectval)
        ->or_like("trim(ip_fournisseurs.pays_fournisseur)", $selectval)
        ->or_like("trim(ip_fournisseurs.mobile)", $selectval); 
        $fournisseurs = $this->db->get("ip_fournisseurs")->result();

        $html='';    

        $result_tot=  count($ip_commande) + count($fournisseurs) + count($ip_haveinvoices) + count($ip_payments) + count($ip_fabrication) + count($ip_products) + count($ip_invoices) + count($ip_clients) +count($ip_quotes)+count($ip_bl);
        $html.='<div class="search-result"><div class="search-header">';
		if( $result_tot > 0 ){ 
		$html.= $result_tot.' '.lang('search-result');
		} else {
		$html.=lang('no-search-result');
		}
		$html.=' <a href="javascript:void(0)" onclick="closeWin()" class="close search-span"><span aria-hidden="true">&times;</span></a></div>';
        $html.='<div class="search-body-box"><ul class="all-search-body"><li class="dropdown search-body search1">';
		if( $result_tot > 0 ){ 
		
		} else {
		$html.='<div class="message-error-body">';
		$html.='<span class="icon-not-found"><i class="fas fa-exclamation-triangle"></i></span><span class="message-error">' ;	
		$html.= lang('no-search-result-message-l1');
		$html.= '<span class="message-error-l2">';
		$html.= lang('no-search-result-message-l2');
		$html.= '</span></span>';
		$html.= '</div>';
		}
        $html.='<button class="btn btn-primary dropdown-toggle title-search" type="button" onclick="showWin1()" style="width: 200px;">';
       if($ip_clients){
        $html.=lang('clients');
        $html.=' ('.count($ip_clients).')
        <span class="caret"></span></button>
        <ul class="dropdown-menu list-search list1">';
        if(count($ip_clients)>0){  
            foreach($ip_clients as $key){ 
            $statuts= '';
              if ($key->client_type == 0) { 
                $statuts.= 'Prospect';
                 } else {
                    $statuts.= 'Client';
                } 
				if ($key->client_societe != ''){
            $html.=  '<li><a class="link search" href="/clients/view/'.$key->client_id.'"><span class="search-icon"><i class="fas fa-user"></i></span>
			<span class="line-search-1">'.$key->client_name.' '.$key->client_prenom.'<span class="soc"> ('.$key->client_societe.') </span><span class="code">#'.$key->client_id.'</span></span><font>'.$key->client_email.'</font><label class="btn-statut '.$statuts.'"><em>'.$statuts.'</em></label></a></li> ';
				} else {
			$html.=  '<li><a class="link search" href="/clients/view/'.$key->client_id.'"><span class="search-icon"><i class="fas fa-user"></i></span>
			<span class="line-search-1">'.$key->client_name.' '.$key->client_prenom.' <span class="code">#'.$key->client_id.'</span></span><font>'.$key->client_email.'</font><label class="btn-statut '.$statuts.'"><em>'.$statuts.'</em></label></a></li> ';	
				}
            }
            if(count($ip_clients)>10){ 
            $html.=  '<div onclick="hidWin1()" class="load-more1">'.lang('load-more').'</div> ';
            }
        } 
							
            $html.='   </ul></li>';
			
        }
        if($ip_invoices){
       $html.='<li class="dropdown search-body search2">
        <button class="btn btn-primary dropdown-toggle title-search" type="button" onclick="showWin2()" style="width: 200px;">';
        $html.=lang('invoices');
        $html.=' ('.count($ip_invoices).')
        <span class="caret"></span></button>
        <ul class="dropdown-menu list-search list2">';
        if(count($ip_invoices)>0){  
            foreach($ip_invoices as $key){  
			$statutsinv= '';
			$statclass='';
				   if ($key->invoice_status_id == 7) { 
                $statutsinv.= lang('unpaid'); $statclass='unpaid';
                 } else if ($key->invoice_status_id == 6) { 
                    $statutsinv.= lang('canceled'); $statclass='canceled';
                } else if ($key->invoice_status_id == 5) {
                    $statutsinv.= lang('rejected'); $statclass='rejected';
				} else if ($key->invoice_status_id == 8) {
                    $statutsinv.= lang('refunded'); $statclass='refunded';
				} else if ($key->invoice_status_id == 4) {
                    $statutsinv.= lang('paid'); $statclass='paid';
				}else if ($key->invoice_status_id == 3) {
                    $statutsinv.= lang('viewed'); $statclass='viewed';
				} else if ($key->invoice_status_id == 2) {
                    $statutsinv.= lang('sent'); $statclass='sent';
				} else if ($key->invoice_status_id == 1) {
                    $statutsinv.= lang('draft'); $statclass='draft';
				}		
			$client_soc ='';
			if ($key->client_societe != ''){ $client_soc ='('.$key->client_societe.')';}
			else { $client_soc = $key->client_societe;}
            $html.=  '<li><a class="link search" href="/invoices/view/'.$key->invoice_id.'"><span class="search-icon"><i class="fas fa-file"></i></span>
			<span class="line-search-1">'.lang('invoice').' N° '.$key->invoice_number .'<span class="soc"> '.$client_soc.' </span></span><em>'.$key->client_name.' '.$key->client_prenom.'  #'.$key->client_id.' </em><label class="btn-statut label '.$statclass.' solid"><em>'.$statutsinv.'</em></label></a></li> ';
            }
            if(count($ip_invoices)>10){ 
            $html.=  '<div onclick="hidWin2()" class="load-more2">'.lang('load-more').'</div> ';
            }
        } 
			
            $html.='   </ul></li>';
        }

        if($ip_haveinvoices){
            $html.='<li class="dropdown search-body search3">
             <button class="btn btn-primary dropdown-toggle title-search" type="button" onclick="showWin3()" style="width: 200px;">';
             $html.=lang('view_invoices_avoir');
             $html.=' ('.count($ip_haveinvoices).')
             <span class="caret"></span></button>
             <ul class="dropdown-menu list-search list3">';
             if(count($ip_haveinvoices)>0){  
                 foreach($ip_haveinvoices as $key){   
			$client_soc ='';
			if ($key->client_societe != ''){ $client_soc ='('.$key->client_societe.')';}
			else { $client_soc = $key->client_societe;} 
                 $html.=  '<li><a class="link search" href="/invoices/viewavoir/'.$key->haveinvoice_id.'"><span class="search-icon"><i class="fas fa-file"></i></span>
				 <span class="line-search-1">'.lang('avoir').' N° '.$key->invoice_number .'<span class="soc"> '.$client_soc.' </span></span><em>'.$key->client_name.' '.$key->client_prenom.' #'.$key->client_id.' </em></a></li> ';
                 }
                 if(count($ip_haveinvoices)>10){ 
                 $html.=  '<div onclick="hidWin3()" class="load-more3">'.lang('load-more').'</div> ';
                 }
                }  
                 $html.=' </ul></li>';
             }

        if($fournisseurs){
                $html.='<li class="dropdown search-body search4">
                 <button class="btn btn-primary dropdown-toggle title-search" type="button" onclick="showWin4()" style="width: 200px;">';
                 $html.=lang('Fournisseurs');
                 $html.=' ('.count($fournisseurs).')
                 <span class="caret"></span></button>
                 <ul class="dropdown-menu list-search list4">';
                 if(count($fournisseurs)>0){  
                     foreach($fournisseurs as $key){    
                     $html.=  '<li><a class="link search" href="/fournisseurs/form/'.$key->id_fournisseur.'"><span class="search-icon"><i class="fas fa-user-tag"></i></span>
					 <span class="line-search-1">'.$key->nom .' '.$key->prenom.' #'.$key->id_fournisseur.' ('.$key->raison_social_fournisseur.') </span><em>'.$key->mail_fournisseur.'</em></a></li> ';
                     }
                     if(count($fournisseurs)>10){ 
                     $html.=  '<div onclick="hidWin4()" class="load-more4">'.lang('load-more').'</div> ';
                     }
                    }  
                     $html.='   </ul></li>';
           }
           
        if($ip_quotes){
        $html.='<li class="dropdown search-body search5">
            <button class="btn btn-primary dropdown-toggle title-search" type="button" onclick="showWin5()" style="width: 200px;">';
            $html.=lang('quotes');
            $html.=' ('.count($ip_quotes).')
            <span class="caret"></span></button>
            <ul class="dropdown-menu list-search list5">';
            if(count($ip_quotes)>0){  
                foreach($ip_quotes as $key){   
			$statutsqt= '';
			$statclass='';
				   if ($key->quote_status_id == 7) { 
                $statutsqt.= lang('negociation'); $statclass='negociation';
                 } else if ($key->quote_status_id == 6) { 
                    $statutsqt.= lang('canceled'); $statclass='canceled';
                } else if ($key->quote_status_id == 5) {
                    $statutsqt.= lang('rejectedquote'); $statclass='rejected';
				} else if ($key->quote_status_id == 4) {
                    $statutsqt.= lang('approved'); $statclass='approved';
				} else if ($key->quote_status_id == 3) {
                    $statutsqt.= lang('viewed'); $statclass='viewed';
				} else if ($key->quote_status_id == 2) {
                    $statutsqt.= lang('sent'); $statclass='sent';
				} else if ($key->quote_status_id == 1) {
                    $statutsqt.= lang('draft'); $statclass='draft';
				}		
			$client_soc ='';
			if ($key->client_societe != ''){ $client_soc ='('.$key->client_societe.')';}
			else { $client_soc = $key->client_societe;} 
                $html.=  '<li><a class="link search" href="/quotes/view/'.$key->quote_id.'"><span class="search-icon"><i class="fas fa-file"></i></span>
				<span class="line-search-1">'.lang('quotes').' N° '.$key->quote_number .'<span class="soc"> '.$client_soc.' </span></span><em>'.$key->client_name.' '.$key->client_prenom.' #'.$key->client_id.' </em><label class="btn-statut label '.$statclass.' solid"><em>'.$statutsqt.'</em></label></a></li> ';
                }
                if(count($ip_quotes)>10){ 
                $html.=  '<div onclick="hidWin5()" class="load-more5">'.lang('load-more').'</div> ';
                }
            }  
        $html.='   </ul></li>';
            }
            if($ip_bl){
         $html.='<li class="dropdown search-body search6">
                <button class="btn btn-primary dropdown-toggle title-search" type="button"onclick="showWin6()" style="width: 200px;">';
                $html.=lang('bon_livraison');
                $html.=' ('.count($ip_bl).')
                <span class="caret"></span></button>
                <ul class="dropdown-menu list-search list6">';
                if(count($ip_bl)>0){  
                    foreach($ip_bl as $key){    
			$statutsbl= '';
			$statclass='';
				   if ($key->bl_status_id == 7) { 
                $statutsbl.= lang('canceled'); $statclass='canceled';
                 } else if ($key->bl_status_id == 6) { 
                    $statutsbl.= lang('rejectedquote'); $statclass='rejected';
                } else if ($key->bl_status_id == 5) {
                    $statutsbl.= lang('approved'); $statclass='approved';
				} else if ($key->bl_status_id == 4) {
                    $statutsbl.= lang('negociation'); $statclass='negociation';
				} else if ($key->bl_status_id == 3) {
                    $statutsbl.= lang('viewed'); $statclass='viewed';
				} else if ($key->bl_status_id == 2) {
                    $statutsbl.= lang('sent'); $statclass='sent';
				} else if ($key->bl_status_id == 1) {
                    $statutsbl.= lang('draft'); $statclass='draft';
				}		
			$client_soc ='';
			if ($key->client_societe != ''){ $client_soc ='('.$key->client_societe.')';}
			else { $client_soc = $key->client_societe;} 
                    $html.=  '<li><a class="link search" href="/bl/view/'.$key->bl_id.'"><span class="search-icon"><i class="fas fa-file"></i></span>
					<span class="line-search-1">'.lang('bon_livraison').' N° '.$key->bl_number .'<span class="soc"> '.$client_soc.' </span></span><em>'.$key->client_name.' '.$key->client_prenom.' #'.$key->client_id.'</em><label class="btn-statut label '.$statclass.' solid"><em>'.$statutsbl.'</em></label></a></li> ';
                    }
                    if(count($ip_bl)>10){ 
                    $html.=  '<div onclick="hidWin6()" class="load-more6">'.lang('load-more').'</div> ';
                    }
                }  
        $html.='   </ul></li>';    
                }
        if($ip_commande){
        $html.='<li class="dropdown search-body search7">
            <button class="btn btn-primary dropdown-toggle title-search" type="button" onclick="showWin7()" style="width: 200px;">';
            $html.=lang('commande');
            $html.=' ('.count($ip_commande).')
            <span class="caret"></span></button>
            <ul class="dropdown-menu list-search list7">';
            if(count($ip_commande)>0){  
                foreach($ip_commande as $key){    
			$statutscmd= '';
			$statclass='';
				   if ($key->commande_status_id == 7) { 
                $statutscmd.= lang('canceled'); $statclass='canceled';
                 } else if ($key->commande_status_id == 6) { 
                    $statutscmd.= lang('rejectedquote'); $statclass='rejected';
                } else if ($key->commande_status_id == 5) {
                    $statutscmd.= lang('approved'); $statclass='approved';
				} else if ($key->commande_status_id == 4) {
                    $statutscmd.= lang('negociation'); $statclass='negociation';
				} else if ($key->commande_status_id == 3) {
                    $statutscmd.= lang('viewed'); $statclass='viewed';
				} else if ($key->commande_status_id == 2) {
                    $statutscmd.= lang('sent'); $statclass='sent';
				} else if ($key->commande_status_id == 1) {
                    $statutscmd.= lang('draft'); $statclass='draft';
				}		
			$client_soc ='';
			if ($key->client_societe != ''){ $client_soc ='('.$key->client_societe.')';}
			else { $client_soc = $key->client_societe;} 
                $html.=  '<li><a class="link search" href="/commande/view/'.$key->commande_id.'"><span class="search-icon"><i class="fas fa-file"></i></span>
				<span class="line-search-1">'.lang('bons_commande').' N° '.$key->commande_number .'<span class="soc"> '.$client_soc.' </span></span><em>'.$key->client_name.' '.$key->client_prenom.' #'.$key->client_id.'</em><label class="btn-statut label '.$statclass.' solid"><em>'.$statutscmd.'</em></label></a></li> ';
                }
                if(count($ip_commande)>10){ 
                $html.=  '<div onclick="hidWin7()" class="load-more7">'.lang('load-more').'</div> ';
                }
            }  
        $html.='   </ul></li>';            
        }

        if($ip_products){
            $html.='<li class="dropdown search-body search8">
                <button class="btn btn-primary dropdown-toggle title-search" type="button" onclick="showWin8()" style="width: 200px;">';
                $html.=lang('products');
                $html.=' ('.count($ip_products).')
                <span class="caret"></span></button>
                <ul class="dropdown-menu list-search list8">';
                if(count($ip_products)>0){  
                    foreach($ip_products as $key){ 
            $typeprod= '';
              if ($key->prod_service == 0) { 
                $typeprod.= 'Produit';
                 } else {
                    $typeprod.= 'Service';
                } 
			$supplier_rs ='';
			if ($key->raison_social_fournisseur != ''){ $supplier_rs ='('.$key->raison_social_fournisseur.')';}
			else { $supplier_rs = $key->raison_social_fournisseur;} 
                    $html.=  '<li><a class="link search" href="/products/form/'.$key->product_id.'"><span class="search-icon"><i class="fas fa-cube"></i></span>
					<span class="line-search-1">'.$key->product_name.' #'.$key->product_id .' - '.lang('product_price2').': '.$key->purchase_price.' </span></span><em>'.$key->family_name.' '.$supplier_rs.' </em><label class="btn-statut '.$typeprod.'"><em>'.$typeprod.'</em></label></a></li> ';
                    }
                    if(count($ip_products)>10){ 
                    $html.=  '<div onclick="hidWin8()" class="load-more8">'.lang('load-more').'</div> ';
                    }
                }  
            $html.='   </ul></li>';            
            }

            if($ip_fabrication){
                $html.='<li class="dropdown search-body search9">
                    <button class="btn btn-primary dropdown-toggle title-search" type="button" onclick="showWin9()" style="width: 200px;">';
                    $html.=lang('bf_order');
                    $html.=' ('.count($ip_fabrication).')
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu list-search list9">';
                    if(count($ip_fabrication)>0){  
                        foreach($ip_fabrication as $key){    
			$client_soc ='';
			if ($key->client_societe != ''){ $client_soc ='('.$key->client_societe.')';}
			else { $client_soc = $key->client_societe;} 
			$fab_nature ='';
			if ($key->fabrication_nature != ''){ $fab_nature ='- '.$key->fabrication_nature.'';}
			else { $fab_nature = $key->fabrication_nature;} 
                        $html.=  '<li><a class="link search" href="/fabrication/view/'.$key->fabrication_id.'"><span class="search-icon"><i class="fas fa-file"></i></span>
						<span class="line-search-1">'.lang('bf').' N° '.$key->fabrication_number .' '.$client_soc.' </span><em>'.$key->client_name.' '.$key->client_prenom.' '.$fab_nature.'</em></a></li> ';
                        }
                        if(count($ip_fabrication)>10){ 
                        $html.=  '<div onclick="hidWin9()" class="load-more9">'.lang('load-more').'</div> ';
                        }
                    }  
                $html.='   </ul></li>';            
                }

                if($ip_payments){
                    $html.='<li class="dropdown search-body search10">
                        <button class="btn btn-primary dropdown-toggle title-search " type="button" onclick="showWin10()" style="width: 200px;">';
                        $html.=lang('payment');
                        $html.=' ('.count($ip_payments).')
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu list-search list10">';
                        if(count($ip_payments)>0){  
                            foreach($ip_payments as $key){  
			$client_soc ='';
			if ($key->client_societe != ''){ $client_soc ='('.$key->client_societe.')';}
			else { $client_soc = $key->client_societe;}    
                            $html.=  '<li><a class="link search" href="/payments/form/'.$key->payment_id.'"><span class="search-icon"><i class="fas fa-money-check"></i></span>
							<span class="line-search-1">'.lang('payment').' #'.$key->payment_id.' '.$payment->payment_date.'</span><em>'.$key->client_name.' '.$key->client_prenom.' '.$client_soc.' </em></a></li> ';
                            }
                            if(count($ip_payments)>10){ 
                            $html.=  '<div onclick="hidWin10()" class="load-more10">'.lang('load-more').'</div> ';
                            }
                        }  
                    $html.='   </ul></li>';            
                }

                    
         $html.=' </ul></div></div> </div></div>';
        echo json_encode($html);
    }
}
