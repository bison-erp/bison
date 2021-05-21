<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ajax extends Admin_Controller
{

    public $ajax_controller = true;
  
    public function create()
    {

        $this->load->model('tax_rates/mdl_tax_rates');

        $this->load->model('fournisseurs/mdl_fournisseurs');
        $this->load->model('payments/mdl_payments');
        $this->load->model('item_lookups/mdl_item_lookups');         
        $this->load->model('commandeachat/mdl_commande_achat');

        $items_count = $this->input->post('items_count');
        $error_items_msg = "";
        $error_items = 0;
        if ($items_count == 0) {
            $error_items_msg = lang('error_nb_ligne');
            $error_items = 1;
        }

        if ($this->mdl_commande_achat->run_validation() && ($error_items == 0)) {
            $tax_rates = $this->mdl_tax_rates->get()->result();
            $commande_achat_date_created = $this->mdl_commande_achat->form_values['commande_achat_date_created'];
            if ($commande_achat_date_created != '') {
                $commande_date = explode('/', $commande_achat_date_created);
                $commande_dt = $commande_date[2] . '-' . $commande_date[1] . '-' . $commande_date[0];
            } else {
                $commande_dt = '';
            }

            $commande_achat_date_expires = $this->mdl_commande_achat->form_values['commande_achat_date_expires'];
            if ($commande_achat_date_expires != '') {
                $commande_date_ex = explode('/', $commande_achat_date_expires);
                $commande_dt_ex = $commande_date_ex[2] . '-' . $commande_date_ex[1] . '-' . $commande_date_ex[0];
            } else {
                $commande_dt_ex = '';
            }

           /* $commande_achat_date_accepte = $this->mdl_commande_achat->form_values['commande_achat_date_accepte'];
            if ($commande_achat_date_accepte != '') {
                $date_d_acc = explode('/', $commande_achat_date_accepte);
                $date_d = $date_d_acc[2] . '-' . $date_d_acc[1] . '-' . $date_d_acc[0];
            } else {
                $date_d = '';
            }*/

//insertion ds table commande_achat
            $items = json_decode($this->mdl_commande_achat->form_values['items']);
            if ($this->mdl_commande_achat->form_values['commande_achat_nature'] == '') {
                $this->mdl_commande_achat->form_values['commande_achat_nature'] = $items[0]->item_code;
            }
            $valCode_quote = $this->mdl_settings->setting('next_code_bc_achat') + 1;
            $this->mdl_settings->save('next_code_bc_achat', $valCode_quote);
            //  $resdate = $this->mdl_quotes->form_values['date_relance'];
            $data = array(
                'user_id' => $this->session->userdata('user_id'),
                'fournisseur_id' => $this->mdl_commande_achat->form_values['fournisseur_id'],
                'commande_achat_nature' => $this->mdl_commande_achat->form_values['commande_achat_nature'],
              //  'commande_achat_password' => $this->mdl_commande_achat->form_values['commande_achat_password'],
                'commande_achat_date_created' => $commande_dt,
                // 'quote_time_created' => date('H:i:s'),
                'commande_achat_date_expires' => $commande_dt_ex,
               // 'commande_achat_date_accepte' => $date_d,
                'commande_achat_number' => $this->mdl_commande_achat->form_values['commande_achat_number'],
                'notes' => $this->mdl_commande_achat->form_values['notes'],
                'commande_achat_status_id' => $this->mdl_commande_achat->form_values['commande_achat_status_id'],
                //'document' => $this->mdl_quotes->form_values['document'],
                //'joindredevis' => $this->mdl_quotes->form_values['joindredevis'],
                //'commande_achat_delai_paiement' => $this->mdl_commande_achat->form_values['commande_achat_delai_paiement'],
                'signature' => $this->mdl_commande_achat->form_values['signature'],
                'langue' => $this->mdl_commande_achat->form_values['langue'],
                'photo' => $this->mdl_commande_achat->form_values['photo'],
            );

            $this->db->insert('ip_commande_achat', $data);
            $commanded_id = $this->db->insert_id();  
            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "add_bc_achat",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $commanded_id,
                    "log_field2" => $this->mdl_commande_achat->form_values['commande_achat_number'],
                );
                $this->db->insert('ip_logs', $data_log);
            }
          
            /* if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
            $data_log = array(
            "log_action" => "add_quote",
            "log_date" => date('Y-m-d H:i:s'),
            "log_ip" => $this->session->userdata['ip_address'],
            "log_user_id" => $this->session->userdata['user_id'],
            "log_field1" => $quote_id,
            );
            $this->db->insert('ip_logs', $data_log);
            }*/

//insertion ds commande_ammont

            $data_amm = array(
                'commande_achats_id' => $commanded_id,
                'commande_achats_item_subtotal' => $this->mdl_commande_achat->form_values['quote_item_subtotal_final'],
                'commande_achats_item_tax_total' => $this->mdl_commande_achat->form_values['quote_item_tax_total_final'],
                'commande_achats_tax_total' => $this->mdl_commande_achat->form_values['quote_item_tax_total_final'],
                'timbre_fiscale' => $this->mdl_commande_achat->form_values['timbre_fiscale_span'],
                'commande_achats_total' => $this->mdl_commande_achat->form_values['total_quote'],
                'commande_achats_pourcent_remise' => $this->mdl_commande_achat->form_values['pourcent_remise_quote'],
                'commande_achats_montant_remise' => $this->mdl_commande_achat->form_values['montant_remise_quote'],
                'commande_achats_pourcent_acompte' => $this->mdl_commande_achat->form_values['pourcent_acompte_quote'],
                'commande_achats_montant_acompte' => $this->mdl_commande_achat->form_values['montant_acompte_quote'],
                'commande_achats_item_subtotal_final' => $this->mdl_commande_achat->form_values['quote_item_subtotal_final'],
                'commande_achats_item_tax_total_final' => $this->mdl_commande_achat->form_values['quote_item_tax_total_final'],
                'commande_achats_total_final' => $this->mdl_commande_achat->form_values['total_quote'],
                'commande_achats_total_a_payer' => $this->mdl_commande_achat->form_values['total_a_payer_quote'],
            );
            $this->db->insert('ip_commande_achats_ammont', $data_amm);

            $items = json_decode($this->mdl_commande_achat->form_values['items']);
            foreach ($items as $item) {              
                    $data_itm = array(
                        'commande_achat_id' => $commanded_id,
                        'family_id' => $item->family_id,
                        'item_tax_rate_id' => $item->item_tax_rate_id,
                        'item_date_added' => date('Y-m-j'),
                        'item_name' => $item->item_name,
                        'item_description' => $item->item_description,
                        'item_quantity' => $item->item_quantity,
                        'item_price' => $item->item_price,
                        'item_order' => $item->item_order,
                        'item_code' => $item->item_code,
                        'etat_champ' => $item->etat_champ,
                    );
                    $this->db->insert('ip_commande_achat_items', $data_itm);
                    $item_id = $this->db->insert_id();
                    $tax = 0;
                    foreach ($tax_rates as $tvalue) {

                        if ($tvalue->tax_rate_id == $item->item_tax_rate_id) {
                            $tax = $tvalue->tax_rate_percent;
                        }
                    }

                   
                    $item_subtotal = $item->item_price * $item->item_quantity;
                    $item_tax_total = $tax * ($item->item_price * $item->item_quantity) / 100;
                    $item_total = ($item->item_price * $item->item_quantity) + ($tax * ($item->item_price * $item->item_quantity) / 100);
                    $data_itm_am = array(
                        'item_id' => $item_id,
                        'item_subtotal' => $item_subtotal,
                        'item_tax_total' => $item_tax_total,
                        'item_total' => $item_total,
                    );

                    $this->db->insert('ip_commande_achat_item_amounts', $data_itm_am);
              
            }
            $response = array(
                'success' => 1,
                'commande_achat_id' => $commanded_id,
            );
        } else {
            $this->load->helper('json_error');

            $response = array(
                'success' => 0,
                'validation_errors' => validation_errors() . $error_items_msg,
            );
        }

        echo json_encode($response);

    }

    public function getItemsByCommande()
    {
        $this->load->model('commandeachat/mdl_commande_achat_items');

        $id = $this->input->post('commanded_id');
        $this->db->where('commande_achat_id', $id);
        $items = $this->mdl_commande_achat_items->get()->result();

        echo json_encode($items);
    }
    public function getAllcommande()
    {
        $this->db->select(array('commande_achat_id'));
        $commande = $this->db->get('ip_commande_achat')->result();
        echo json_encode($commande);
    }
    public function load_commande_partial_filter()
    {
        $this->load->model('quotes/mdl_quotes');
        $filter_quote = trim(strtolower(addslashes($this->input->post('filter_quote'))));
        $filter_user_id = $this->input->post('filter_user_id');
        $filter_date = $this->input->post('filter_date');
        $filter_statuts = $this->input->post('filter_statuts');       
        $limit_par_page = $this->input->post('limit_par_page');
        $start_page = $this->input->post('start_page');
        $order_by = $this->input->post('order_by');
        $order_method = $this->input->post('order_method');
        $start_line = (int) ($start_page - 1) * (int) $limit_par_page;
        $where = "ip_commande.delete <> 1 ";
        if ($filter_statuts != "all") {
            $where .= " AND (ip_commande.commande_status_id = $filter_statuts)";
        }
        if ($filter_user_id != 0) {
            $where .= " AND (ip_commande.user_id = $filter_user_id)";
        } 

        $this->load->model('commande/mdl_commande');     

        // GET COUNT QUOTES FILTRED

        $this->db->WHERE("$where");
      /*  $this->db->join('ip_clients', 'ip_clients.client_id = ip_commande.client_id', 'left');
        $this->db->join('ip_commande_ammont', 'ip_commande_ammont.commande_achat_id = ip_commande.commande_achat_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $nb_all_lines = $this->db->count_all_results('ip_commande');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);
*/
        // GET CALCUL TOTAL

        $this->db->WHERE("$where");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_commande.client_id', 'left');
        $this->db->join('ip_commande_ammont', 'ip_commande_ammont.commande_achat_id = ip_commande.commande_achat_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->select("count(ip_commande.commande_achat_id) as count,ip_devises.devise_id,SUM(ip_commande_ammont.commande_item_subtotal) as quotes_sum_subtotal,SUM(ip_commande_ammont.commande_total_final) as quotes_sum_total");
        $this->db->group_by("ip_devises.devise_id");
        $quotes_total_amounts_db = $this->db->get("ip_commande")->result();
        $quotes_total_amounts = array();
        if (!empty($quotes_total_amounts_db)) {
            foreach ($quotes_total_amounts_db as $amount) {
                $quotes_total_amounts[$amount->devise_id]["quotes_sum_subtotal"] = $amount->quotes_sum_subtotal;
                $quotes_total_amounts[$amount->devise_id]["quotes_sum_total"] = $amount->quotes_sum_total;
                $quotes_total_amounts[$amount->devise_id]["count"] = $amount->count;
            }
        }

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_commande.client_id', 'left');
        $this->db->join('ip_commande_ammont', 'ip_commande_ammont.commande_achat_id = ip_commande.commande_achat_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_commande.commande_delai_paiement', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_commande.user_id', 'left');
        $this->db->select("*,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe2");

        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $quotes = $this->db->get("ip_commande")->result();

        $this->db->where('rappel_type', 'quote');
        $rappels = $this->db->get('ip_rappel')->result();
        // return var_dump('1');die('1');
        $data = array(
            'commandes' => $quotes,
            'quote_statuses' => $this->mdl_quotes->statuses(),
            'rappel_quotes' => $this->mdl_quotes->get_date_rappel(),
            'devises' => $this->db->get("ip_devises")->result(),
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
            'commandes_total_amounts' => $quotes_total_amounts,
            'rappels' => $rappels,
        );

        $this->layout->load_view('commande/partial_commande_table', $data);
    }

    public function save()
    {       
        $this->load->model('tax_rates/mdl_tax_rates');

        $this->load->model('fournisseurs/mdl_fournisseurs');
        $this->load->model('payments/mdl_payments');
														  
        $this->load->model('item_lookups/mdl_item_lookups');         
        $this->load->model('commandeachat/mdl_commande_achat');
		
        $tax = $this->mdl_tax_rates->get()->result();

        $items_count = $this->input->post('items_count');
        $error_items_msg = "";
        $error_items = 0;
        if ($items_count == 0) {
            $error_items_msg = lang('error_nb_ligne');
            $error_items = 1;
        }
       
        if ($this->mdl_commande_achat->run_validation() && ($error_items == 0)) {

            $tax_rates = $this->mdl_tax_rates->get()->result();
            $commanded_id = $this->input->post('commanded_id');
            
			$commande_achat_date_created = $this->input->post('commande_achat_date_created');
            if ($commande_achat_date_created != '') {
                $commande_date = explode('/', $commande_achat_date_created);
                $commande_dt = $commande_date[2] . '-' . $commande_date[1] . '-' . $commande_date[0];
            } else {
                $commande_dt = '';
            }

            $commande_achat_date_expires = $this->input->post('commande_achat_date_expires');
            if ($commande_achat_date_expires != '') {
                $commande_date_ex = explode('/', $commande_achat_date_expires);
                $commande_dt_ex = $commande_date_ex[2] . '-' . $commande_date_ex[1] . '-' . $commande_date_ex[0];
            } else {
                $commande_dt_ex = '';
            }
//modif table quote
			 $data = array(
                'user_id' => $this->session->userdata('user_id'),
                'fournisseur_id' =>$this->input->post('fournisseur_id'),
                'commande_achat_nature' => $this->input->post('commande_achat_nature'),
              //  'commande_achat_password' => $this->mdl_commande_achat->form_values['commande_achat_password'],
                'commande_achat_date_created' => $commande_dt,
                // 'quote_time_created' => date('H:i:s'),
                'commande_achat_date_expires' => $commande_dt_ex,
               // 'commande_achat_date_accepte' => $date_d,
               // 'commande_achat_number' => $this->input->post('commande_achat_number'),
                'notes' => $this->input->post('notes'),
                'commande_achat_status_id' => $this->input->post('commande_achat_status_id'),
                //'document' => $this->mdl_quotes->form_values['document'],
                //'joindredevis' => $this->mdl_quotes->form_values['joindredevis'],
                //'commande_achat_delai_paiement' => $this->mdl_commande_achat->form_values['commande_achat_delai_paiement'],
                'signature' =>$this->input->post('signature'),
                'langue' => $this->input->post('langue'),
                'photo' => $this->input->post('photo'),
            );           
             						
            $this->db->where('commande_achat_id', $this->input->post('commanded_id'));
            $this->db->delete('ip_commande_achat_items');	
            $this->db->where('commande_achats_id', $this->input->post('commanded_id'));
            $this->db->delete('ip_commande_achats_ammont'); 
            $this->db->where('commande_achat_id', $this->input->post('commanded_id'));
            $this->db->update('ip_commande_achat', $data);
//modif items
           
            $items = json_decode($this->input->post('items'));
            foreach ($items as $item) {
               // if ($item->item_code != '') {
                    //insert ds quotes_items
                    $data_itm = array(
                        'commande_achat_id' => $commanded_id,
                        'family_id' => $item->family_id,
                        'item_tax_rate_id' => $item->item_tax_rate_id,
                        'item_date_added' => date('Y-m-j'),
                        'item_name' => $item->item_name,
                        'item_description' => $item->item_description,
                        'item_quantity' => $item->item_quantity,
                        'item_price' => $item->item_price,
                        'item_order' => $item->item_order,
                        'item_code' => $item->item_code,
                        'etat_champ' => 0,
                    );
                    $this->db->insert('ip_commande_achat_items', $data_itm);
                    $item_id = $this->db->insert_id();
                    $tax = 0;
                    foreach ($tax_rates as $tvalue) {

                        if ($tvalue->tax_rate_id == $item->item_tax_rate_id) {
                            $tax = $tvalue->tax_rate_percent;
                        }
                    }

                    //insert ds quote_item_amounts  ,
                    $item_subtotal = $item->item_price * $item->item_quantity;
                    $item_tax_total = $tax * ($item->item_price * $item->item_quantity) / 100;
                    $item_total = ($item->item_price * $item->item_quantity) + ($tax * ($item->item_price * $item->item_quantity) / 100);
                    $data_itm_am = array(
                        'item_id' => $item_id,
                        'item_subtotal' => $item_subtotal,
                        'item_tax_total' => $item_tax_total,
                        'item_total' => $item_total,
                    );

                    $this->db->insert('ip_commande_achat_item_amounts', $data_itm_am);
                //}
            }
//modif quote_amounts
          

            $data_amm = array(
                'commande_achats_id' => $commanded_id,
                'commande_achats_item_subtotal' => $this->input->post('quote_item_subtotal_final'),
                'commande_achats_item_tax_total' => $this->input->post('quote_item_tax_total_final'),
                'commande_achats_tax_total' => $this->input->post('quote_item_tax_total_final'),
                'timbre_fiscale' => $this->input->post('timbre_fiscale_span'),
                'commande_achats_total' => $this->input->post('total_quote'),
                'commande_achats_pourcent_remise' => $this->input->post('pourcent_remise_quote'),
                'commande_achats_montant_remise' => $this->input->post('montant_remise_quote'),
                'commande_achats_pourcent_acompte' => $this->input->post('pourcent_acompte_quote'),
                'commande_achats_montant_acompte' => $this->input->post('montant_acompte_quote'),
                'commande_achats_item_subtotal_final' => $this->input->post('quote_item_subtotal_final'),
                'commande_achats_item_tax_total_final' => $this->input->post('quote_item_tax_total_final'),
                'commande_achats_total_final' => $this->input->post('total_quote'),
                'commande_achats_total_a_payer' => $this->input->post('total_a_payer_quote'),
            );

            $this->db->insert('ip_commande_achats_ammont', $data_amm);

            $this->db->select('commande_achat_number');
            $this->db->where("commande_achat_id", $commanded_id);
            $numcomm = $this->db->get('ip_commande_achat')->result();

            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "edit_bc_achat",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $commanded_id,
                    "log_field2" => $this->input->post('commande_achat_number'),
                );
                $this->db->insert('ip_logs', $data_log);
            }    
            $response = array(
                'success' => 1,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => validation_errors(),
            );
        }
        echo json_encode($response);
    }

    public function getCommandeInfo()
    {
        $this->load->helper('country');
        $commanded_id = $this->input->post('commande_achat_id');
        var_dump($commanded_id);
        $this->db->where("ip_commande.commande_achat_id", $commanded_id);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_commande.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_commande_ammont', 'ip_commande_ammont.commande_achat_id = ip_commande.commande_achat_id', 'left');

        $country = get_country_list(lang('cldr'));

        $commande = $this->db->get("ip_commande")->result();

        $this->db->where("ip_commande_items.commande_achat_id", $commanded_id);
        $commande_items = $this->db->get("ip_commande_items")->result();
        $commande[0]->commande_items = $commande_items;
        $commande[0]->client_country = $country[$commande[0]->client_country];

        echo json_encode($commande);
    }

    public function modal_change_statut($type)
    {
        $this->load->model('commande/mdl_commande');
        $this->load->model('quotes/mdl_quotes');

        $commanded_id = $this->input->post('commande_achat_id');
        if ($type == 0) {
            $this->db->where("commande_achat_id", $commanded_id);
            $result = $this->db->get("ip_commande")->result();
        } else {
            $this->load->model('bl/mdl_bl');
            $this->db->where("bl_id", $commanded_id);
            $result = $this->db->get("ip_bl")->result();
        }

        $data = array();
        if ($type == 0) {
            $data['quote_statuses'] = $this->mdl_quotes->statuses();
        } else {
            $data['quote_statuses'] = $this->mdl_invoices->statuses();
        }
        $data['commande'] = $result[0];
        $data['type'] = $type;
        $this->load->view('commande/modal_change_statut', $data);
    }

    public function updateStatutCommande()
    {
        $id_selected_statut = $this->input->post('id_selected_status');
        $commanded_id = $this->input->post('id_commande');
        $type = $this->input->post('type');
        $data_accepte = $this->input->post('data_accepte');
        if ($data_accepte) {
            $date_insert = date_to_mysql($data_accepte);
        }
        if ($type == 0) {

            $data_update = array(
                'commande_status_id' => $id_selected_statut,
            );
            $this->db->where("commande_achat_id", $commanded_id);

            $this->db->update("ip_commande", $data_update);
        } else {
            if ($id_selected_statut == 4) {
                $data_update = array(

                    'commande_achat_date_accepte' => $date_insert,
                    'invoice_status_id' => $id_selected_statut,
                );
            } else {
                $data_update = array(
                    'invoice_status_id' => $id_selected_statut,
                );

            }
            $this->db->where("invoice_id", $quote_id);

            $this->db->update("ip_invoices", $data_update);
        }
    }
    
}