<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ajax extends Admin_Controller
{

    public $ajax_controller = true;
    public function load_bl_partial_filter()
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
        $where = "ip_bl.delete <> 1 ";
        if ($filter_quote != "") {
            $where .= "AND ((LOWER(ip_bl.bl_nature) LIKE '%" . $filter_quote . "%') ";

            $where .= " OR (LOWER(ip_bl.bl_number) LIKE '%" . $filter_quote . "%' )";

            $where .= " OR (LOWER(ip_clients.client_societe) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_name) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_prenom) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_web) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_phone) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_fax) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_mobile) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_email) LIKE '%" . $filter_quote . "%' )";
            $where .= " )";
        }
        if ($filter_statuts != "all") {
            $where .= " AND (ip_bl.bl_status_id = $filter_statuts)";
        }
        if ($filter_date != "all") {
            $date_deb = $filter_date . "-01-01";
            $date_fin = ($filter_date + 1) . "-01-01";
            $where .= " AND (ip_bl.quote_date_created >= '" . $date_deb . "' AND ip_bl.quote_date_created < '" . $date_fin . "')";
        }
        if ($filter_user_id != 0) {
            $where .= " AND (ip_bl.user_id = $filter_user_id)";
        }

        $this->load->model('bl/mdl_bl');
        // $this->load->model('quote_rappel/mdl_quote_rappel');

        // GET COUNT QUOTES FILTRED

        $this->db->WHERE("$where");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_bl.client_id', 'left');
        $this->db->join('ip_bl_ammont', 'ip_bl_ammont.bl_id = ip_bl.bl_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $nb_all_lines = $this->db->count_all_results('ip_bl');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);

        // GET CALCUL TOTAL

        $this->db->WHERE("$where");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_bl.client_id', 'left');
        $this->db->join('ip_bl_ammont', 'ip_bl_ammont.bl_id = ip_bl.bl_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->select("count(ip_bl.bl_id) as count,ip_devises.devise_id,SUM(ip_bl_ammont.bl_item_subtotal) as quotes_sum_subtotal,SUM(ip_bl_ammont.bl_total_final) as quotes_sum_total");
        $this->db->group_by("ip_devises.devise_id");
        $quotes_total_amounts_db = $this->db->get("ip_bl")->result();
        $quotes_total_amounts = array();
        if (!empty($quotes_total_amounts_db)) {
            foreach ($quotes_total_amounts_db as $amount) {
                $quotes_total_amounts[$amount->devise_id]["quotes_sum_subtotal"] = $amount->quotes_sum_subtotal;
                $quotes_total_amounts[$amount->devise_id]["quotes_sum_total"] = $amount->quotes_sum_total;
                $quotes_total_amounts[$amount->devise_id]["count"] = $amount->count;
            }
        }
        // GET ALL QUOTES FILTRES PAGINATE
       
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_bl.client_id', 'left');
        $this->db->join('ip_bl_ammont', 'ip_bl_ammont.bl_id = ip_bl.bl_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_bl.bl_delai_paiement', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_bl.user_id', 'left');
        $this->db->select("*,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe2");

        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $quotes = $this->db->get("ip_bl")->result();

        $this->db->where('rappel_type', 'quote');
        $rappels = $this->db->get('ip_rappel')->result();
        $data = array(
            'quotes' => $quotes,
            'quote_statuses' => $this->mdl_quotes->statuses(),
            'rappel_quotes' => $this->mdl_quotes->get_date_rappel(),
            'devises' => $this->db->get("ip_devises")->result(),
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
            'quotes_total_amounts' => $quotes_total_amounts,
            'rappels' => $rappels,
        );

        $this->layout->load_view('bl/partial_bl_table', $data);
    }
    public function create()
    {

        $this->load->model('tax_rates/mdl_tax_rates');

        $this->load->model('clients/mdl_clients');
        $this->load->model('payments/mdl_payments');
        $this->load->model('item_lookups/mdl_item_lookups');
        $this->load->model('activites/mdl_activites');
        $this->load->model('quotes/mdl_rappel');
        $this->load->model('fabrication/mdl_fabrication');
         
        $items_count = $this->input->post('items_count');
       /* $items = json_decode($this->input->post('items'));
        return var_dump($items);*/
        $error_items_msg = "";
        $error_items = 0;
        if ($items_count == 0) {
            $error_items_msg = lang('error_nb_ligne');
            $error_items = 1;
        }

        if ($this->mdl_fabrication->run_validation() && ($error_items == 0)) {
            $tax_rates = $this->mdl_tax_rates->get()->result();
            $quote_date_created = $this->input->post('quote_date_created');
            if ($quote_date_created != '') {
                $quote_date = explode('/', $quote_date_created);
                $quote_dt = $quote_date[2] . '-' . $quote_date[1] . '-' . $quote_date[0];
            } else {
                $quote_dt = '';
            }

            $quote_date_expires = $this->input->post('quote_date_expires');
            if ($quote_date_expires != '') {
                $quote_date_ex = explode('/', $quote_date_expires);
                $quote_dt_ex = $quote_date_ex[2] . '-' . $quote_date_ex[1] . '-' . $quote_date_ex[0];
            } else {
                $quote_dt_ex = '';
            }

            $quote_date_accepte = $this->input->post('fabrication_date_accepte');
            if ($quote_date_accepte != '') {
                $date_d_acc = explode('/', $quote_date_accepte);
                $date_d = $date_d_acc[2] . '-' . $date_d_acc[1] . '-' . $date_d_acc[0];
            } else {
                $date_d = '';
            }

//insertion ds table quotes
           // $items = json_decode($this->mdl_fabrication->form_values['items']);
        
          /* if ($this->input->post('quote_nature') == '') {
            $this->input->post('quote_nature') = $items[0]->item_code;
            }*/
            $valCode_quote = $this->mdl_settings->setting('next_code_bf');
            $this->mdl_settings->save('next_code_bf',(int)$valCode_quote+1);
            //  $resdate = $this->mdl_quotes->form_values['date_relance'];
            $data = array(
                'user_id' => $this->session->userdata('user_id'),
                'client_id' => $this->input->post('client_id'),
                'fabrication_nature' =>$this->input->post('quote_nature'),
                'fabrication_password' => $this->input->post('quote_password'),
                'quote_date_created' => $quote_dt,
                // 'quote_time_created' => date('H:i:s'),
                'quote_date_expires' => $quote_dt_ex,
                'fabrication_date_accepte' => $date_d,
                'fabrication_number' => $valCode_quote,
                'notes' => $this->input->post('notes'),
                'fabrication_status_id' => $this->input->post('quote_status_id'),
                //'document' => $this->mdl_quotes->form_values['document'],
                //'joindredevis' => $this->mdl_quotes->form_values['joindredevis'],
                'fabrication_delai_paiement' => $this->input->post('quote_delai_paiement'),
                'signature' => $this->input->post('signature'),    
                'langue' => $this->input->post('langue'),             
            );

            $this->db->insert('ip_fabrication', $data);
            $fabrication_id = $this->db->insert_id();
           // return var_dump('hh'. $fabrication_id );
            /*   if ($resdate != "") {
            $date_explode = explode(",", $resdate);
            for ($i = 0; $i < count($date_explode); $i++) {
            $data = array('daterappel' => $date_explode[$i], 'type' => 'quote', 'idobject' => $quote_id);
            $this->db->insert('ip_rappelmail', $data);
            }
            }*/
            $this->db->select('fabrication_number');
            $this->db->where("fabrication_id", $fabrication_id);
            $numcomm = $this->db->get('ip_fabrication')->result();

            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "add_bf",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $fabrication_id,
                    "log_field2" => $numcomm[0]->fabrication_number,
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

//insertion ds fabrication_ammont

            $data_amm = array(
                'fabrication_id' => $fabrication_id,
                'fabrication_item_subtotal' => $this->input->post('quote_item_subtotal_final'),
                'fabrication_item_tax_total' => $this->input->post('quote_item_tax_total_final'),
                'fabrication_tax_total' => $this->input->post('quote_item_tax_total_final'),
                'timbre_fiscale' => $this->input->post('timbre_fiscale_span'),
                'fabrication_total' => $this->input->post('total_quote'),
                'fabrication_pourcent_remise' => $this->input->post('pourcent_remise_quote'),
                'fabrication_montant_remise' => $this->input->post('montant_remise_quote'),
                'fabrication_pourcent_acompte' =>$this->input->post('pourcent_acompte_quote'),
                'fabrication_montant_acompte' => $this->input->post('montant_acompte_quote'),
                'fabrication_item_subtotal_final' => $this->input->post('quote_item_subtotal_final'),
                'fabrication_item_tax_total_final' => $this->input->post('quote_item_tax_total_final'),
                'fabrication_total_final' => $this->input->post('total_quote'),
                'fabrication_total_a_payer' => $this->input->post('total_a_payer_quote'),
            );
            $this->db->insert('ip_fabrication_ammont', $data_amm);

//insertion ds table itmes
          //  $items = json_decode($this->mdl_fabrication->form_values['items']);
            $items = json_decode($this->input->post('items'));
         //   return var_dump($items[0]->item_code);
            foreach ($items as $item) {
             //   if ($item->item_code != '') {
              
                    $data_itm = array(
                        'fabrication_id' => $fabrication_id,
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
                //    return var_dump($data_itm);
                    $this->db->insert('ip_fabrication_items', $data_itm);
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

                    $this->db->insert('ip_fabrication_item_amounts', $data_itm_am);
                //}
            }

/*
if ($this->mdl_quotes->form_values['document'] == 1 && $resdate != "") {
$tabledoc = $this->mdl_quotes->form_values['listdocu'];
$tabledocexp = explode(',', $tabledoc);

for ($i = 0; $i < count($tabledocexp); $i++) {
$this->db->select('file_name,id_client');
$this->db->where("id_document", $tabledocexp[$i]);
$getclientdoc = $this->db->get('ip_client_documents')->result();
if ($getclientdoc[0]->file_name != "") {
$data_doc_client = array(
'typeobject' => 'quote',
'object_id' => $quote_id,
'doc_id' => $tabledocexp[$i],
'nomdocument' => $getclientdoc[0]->file_name,
'client_id' => $getclientdoc[0]->id_client,
);
$this->db->insert('ip_document_rappel', $data_doc_client);
}
}
}*/
            // $this->generate_quote_pdf($quote_id, false, null);
            $response = array(
                'success' => 1,
                'quote_id' => $fabrication_id,
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

    public function getItemsByfabrication()
    {
        $this->load->model('fabrication/mdl_fabrication_items');

        $id = $this->input->post('quote_id');
        $this->db->where('fabrication_id', $id);
        $items = $this->mdl_fabrication_items->get()->result();

        echo json_encode($items);
    }
    public function getAllfabrication()
    {
        $this->db->select(array('fabrication_id'));
        $fabrication = $this->db->get('ip_fabrication')->result();
        echo json_encode($fabrication);
    }
    public function load_fabrication_partial_filter()
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
        $where = "ip_fabrication.delete <> 1 ";
       if ($filter_quote != "") {
            $where .= "AND ((LOWER(ip_fabrication.fabrication_nature) LIKE '%" . $filter_quote . "%') ";

            $where .= " OR (LOWER(ip_fabrication.fabrication_number) LIKE '%" . $filter_quote . "%' )";

            $where .= " OR (LOWER(ip_clients.client_societe) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_name) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_prenom) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_web) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_phone) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_fax) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_mobile) LIKE '%" . $filter_quote . "%' )";
            $where .= " OR (LOWER(ip_clients.client_email) LIKE '%" . $filter_quote . "%' )";
            $where .= " )";
        }
      /*  if ($filter_statuts != "all") {
            $where .= " AND (ip_fabrication.fabrication_status_id = $filter_statuts)";
        }*/
        if ($filter_date != "all") {
            $date_deb = $filter_date . "-01-01";
            $date_fin = ($filter_date + 1) . "-01-01";
            $where .= " AND (ip_fabrication.quote_date_created >= '" . $date_deb . "' AND ip_fabrication.quote_date_created < '" . $date_fin . "')";
        } 
         if ($filter_user_id != 0) {
            $where .= " AND (ip_fabrication.user_id = $filter_user_id)";
        } 

        $this->load->model('fabrication/mdl_fabrication');
        // $this->load->model('quote_rappel/mdl_quote_rappel');

        // GET COUNT QUOTES FILTRED

        $this->db->WHERE("$where");
      /*  $this->db->join('ip_clients', 'ip_clients.client_id = ip_fabrication.client_id', 'left');
        $this->db->join('ip_fabrication_ammont', 'ip_fabrication_ammont.fabrication_id = ip_fabrication.fabrication_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $nb_all_lines = $this->db->count_all_results('ip_fabrication');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);
*/
        // GET CALCUL TOTAL

        

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_fabrication.client_id', 'left');
      //  $this->db->join('ip_fabrication_ammont', 'ip_fabrication_ammont.fabrication_id = ip_fabrication.fabrication_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_fabrication.fabrication_delai_paiement', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_fabrication.user_id', 'left');
        $this->db->select("*,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe2");

        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $quotes = $this->db->get("ip_fabrication")->result();

        $this->db->where('rappel_type', 'quote');
        $rappels = $this->db->get('ip_rappel')->result();
        // return var_dump('1');die('1');
        $data = array(
            'quotes' => $quotes,
            'quote_statuses' => $this->mdl_quotes->statuses(),
            'rappel_quotes' => $this->mdl_quotes->get_date_rappel(),
            'devises' => $this->db->get("ip_devises")->result(),
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
            'quotes_total_amounts' => $quotes_total_amounts,
            'rappels' => $rappels,
        );

        $this->layout->load_view('fabrication/partial_fabrication_table', $data);
    }

    public function save()
    {
        /*   $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/temprelance';
        if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777);
        }
        $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/documents';
        if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777);
        }*/
        $this->load->model('tax_rates/mdl_tax_rates');

        $this->load->model('clients/mdl_clients');
        $this->load->model('payments/mdl_payments');
        $this->load->model('fabrication/mdl_fabrication_items');
        $this->load->model('item_lookups/mdl_item_lookups');
        //  $this->load->model('fabrication/mdl_fabrication_item_amounts');
        // $this->load->model('fabrication/mdl_fabrication_amounts');
        $this->load->model('fabrication/mdl_fabrication');
        $this->load->model('activites/mdl_activites');

        $tax = $this->mdl_tax_rates->get()->result();

        $items_count = $this->input->post('items_count');
        $error_items_msg = "";
        $error_items = 0;
        if ($items_count == 0) {
            $error_items_msg = lang('error_nb_ligne');
            $error_items = 1;
        }
        if ($this->mdl_fabrication->run_validation() && ($error_items == 0)) {

            $tax_rates = $this->mdl_tax_rates->get()->result();
            $quote_id = $this->input->post('quote_id');
            $quote_date_created = $this->input->post('quote_date_created');
            if ($quote_date_created != '') {
                $quote_date = explode('/', $quote_date_created);
                $quote_dt = $quote_date[2] . '-' . $quote_date[1] . '-' . $quote_date[0];
            } else {
                $quote_dt = '';
            }

            $quote_date_expires = $this->input->post('quote_date_expires');
            if ($quote_date_expires != '') {
                $quote_date_ex = explode('/', $quote_date_expires);
                $quote_dt_ex = $quote_date_ex[2] . '-' . $quote_date_ex[1] . '-' . $quote_date_ex[0];
            } else {
                $quote_dt_ex = '';
            }

            $quote_date_accepte = $this->input->post('quote_date_accepte');
            if ($quote_date_accepte != '') {
                $date_d_acc = explode('/', $quote_date_accepte);
                $date_d = $date_d_acc[2] . '-' . $date_d_acc[1] . '-' . $date_d_acc[0];

            } else {
                $date_d = '';
            }
//modif table quote
            $data = array(
                'user_id' => $this->session->userdata('user_id'),
                'client_id' => $this->input->post('client_id'),
                'fabrication_nature' => $this->input->post('quote_nature'),
                'fabrication_password' => $this->input->post('quote_password'),
                'quote_date_created' => $quote_dt,
                'quote_date_expires' => $quote_dt_ex,
                'fabrication_date_accepte' => $date_d,
                'notes' => $this->input->post('notes'),
                'fabrication_status_id' => $this->input->post('quote_status_id'),
                'fabrication_date_modified' => date('Y-m-j H:i:s'),
                
                'fabrication_delai_paiement' => $this->input->post('quote_delai_paiement'),
                'signature' => $this->input->post('signature'),
                'langue' => $this->input->post('langue'),
            );

            $this->db->where('fabrication_id', $this->input->post('quote_id'));
            $this->db->update('ip_fabrication', $data);
//modif items

            $this->db->where('fabrication_id', $this->input->post('quote_id'));
            $this->db->delete('ip_fabrication_items');
            $items = json_decode($this->input->post('items'));
            foreach ($items as $item) {
                if ($item->item_code != '') {
                    //insert ds quotes_items
                    $data_itm = array(
                        'fabrication_id' => $quote_id,
                        'family_id' => $item->family_id,
                        'item_tax_rate_id' => $item->item_tax_rate_id,
                        'item_date_added' => date('Y-m-j'),
                        'item_name' => $item->item_name,
                        'item_description' => $item->item_description,
                        'item_quantity' => $item->item_quantity,
                        'item_price' => $item->item_price,
                        'item_order' => $item->item_order,
                        'item_code' => $item->item_code,
                        // 'etat_champ' => $item->etat_champ,
                    );
                    $this->db->insert('ip_fabrication_items', $data_itm);
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

                    $this->db->insert('ip_fabrication_item_amounts', $data_itm_am);
                }
            }
//modif quote_amounts
            $this->db->where('fabrication_id', $this->input->post('quote_id'));
            $this->db->delete('ip_fabrication_ammont');

            $data_amm = array(
                'fabrication_id' => $quote_id,
                'fabrication_item_subtotal' => $this->input->post('quote_item_subtotal_final'),
                'fabrication_item_tax_total' => $this->input->post('quote_item_tax_total_final'),
                'fabrication_tax_total' => $this->input->post('quote_item_tax_total_final'),
                'timbre_fiscale' => $this->input->post('timbre_fiscale_span'),
                'fabrication_total' => $this->input->post('total_quote'),
                'fabrication_pourcent_remise' => $this->input->post('pourcent_remise_quote'),
                'fabrication_montant_remise' => $this->input->post('montant_remise_quote'),
                'fabrication_pourcent_acompte' => $this->input->post('pourcent_acompte_quote'),
                'fabrication_montant_acompte' => $this->input->post('montant_acompte_quote'),
                'fabrication_item_subtotal_final' => $this->input->post('quote_item_subtotal_final'),
                'fabrication_item_tax_total_final' => $this->input->post('quote_item_tax_total_final'),
                'fabrication_total_final' => $this->input->post('total_quote'),
                'fabrication_total_a_payer' => $this->input->post('total_a_payer_quote'),
            );

            $this->db->insert('ip_fabrication_ammont', $data_amm);

            $this->db->select('fabrication_number');
            $this->db->where("fabrication_id", $quote_id);
            $numcomm = $this->db->get('ip_fabrication')->result();

            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "edit_bf",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field2" => $numcomm[0]->fabrication_number,
                    "log_field1" => $this->input->post('quote_id'),
                );
                $this->db->insert('ip_logs', $data_log);
            }

            //  return var_dump($data_amm);
            /*
            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
            $data_log = array(
            "log_action" => "edit_quote",
            "log_date" => date('Y-m-d H:i:s'),
            "log_ip" => $this->session->userdata['ip_address'],
            "log_user_id" => $this->session->userdata['user_id'],
            "log_field1" => $this->mdl_fabrication->form_values['quote_id'],
            );
            $this->db->insert('ip_logs', $data_log);
            }
             */
            /* $resdate = $this->mdl_fabrication->form_values['date_relance'];
            //  return var_dump($resdate);
            $this->mdl_rappel->updateDateRelance($this->mdl_fabrication->form_values['quote_id'], $resdate, 0);

            $arra = array('object_id' => $quote_id, 'typeobject' => 'quote');
            $this->db->delete('ip_document_rappel', $arra);

            $docselectionne = $this->mdl_fabrication->form_values['listdocu'];

            $docselectionneid = explode(',', $docselectionne);

            for ($i = 0; $i < count($docselectionneid); $i++) {
            if ($docselectionneid[$i] != '') {
            $this->db->select('file_name,id_client');
            $this->db->where("id_document", $docselectionneid[$i]);
            $getclientdoc = $this->db->get('ip_client_documents')->result();

            $data_doc_client = array(
            'typeobject' => 'quote',
            'object_id' => $quote_id,
            'doc_id' => $docselectionneid[$i],
            'nomdocument' => $getclientdoc[0]->file_name,
            'client_id' => $getclientdoc[0]->id_client,
            );
            $this->db->insert('ip_document_rappel', $data_doc_client);
            }
            }
            $this->generate_quote_pdf($quote_id, false, null);*/

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
/*
if ($this->input->post('custom')) {
$db_array = array();

foreach ($this->input->post('custom') as $custom) {
// I hate myself for this...
$db_array[str_replace(']', '', str_replace('custom[', '', $custom['name']))] = $custom['value'];
}

$this->load->model('custom_fields/mdl_invoice_custom');
$this->mdl_invoice_custom->save_custom($invoice_id, $db_array);
}*/

        echo json_encode($response);
    }

    public function getfabricationInfo()
    {
        $this->load->helper('country');
        $fabrication_id = $this->input->post('fabrication_id');
        var_dump($fabrication_id);
        $this->db->where("ip_fabrication.fabrication_id", $fabrication_id);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_fabrication.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_fabrication_ammont', 'ip_fabrication_ammont.fabrication_id = ip_fabrication.fabrication_id', 'left');

        $country = get_country_list(lang('cldr'));

        $fabrication = $this->db->get("ip_fabrication")->result();

        $this->db->where("ip_fabrication_items.fabrication_id", $fabrication_id);
        $fabrication_items = $this->db->get("ip_fabrication_items")->result();
        $fabrication[0]->fabrication_items = $fabrication_items;
        $fabrication[0]->client_country = $country[$fabrication[0]->client_country];

        echo json_encode($fabrication);
    }

    public function modal_change_statut($type)
    {
        $this->load->model('fabrication/mdl_fabrication');
        $this->load->model('quotes/mdl_quotes');

        $fabrication_id = $this->input->post('fabrication_id');
        if ($type == 0) {
            $this->db->where("fabrication_id", $fabrication_id);
            $result = $this->db->get("ip_fabrication")->result();
        } else {
            $this->load->model('bl/mdl_bl');
            $this->db->where("bl_id", $fabrication_id);
            $result = $this->db->get("ip_bl")->result();
        }

        $data = array();
        if ($type == 0) {
            $data['quote_statuses'] = $this->mdl_quotes->statuses();
        } else {
            $data['quote_statuses'] = $this->mdl_invoices->statuses();
        }
        $data['fabrication'] = $result[0];
        $data['type'] = $type;
        $this->load->view('fabrication/modal_change_statut', $data);
    }

    public function updateStatutfabrication()
    {
        $id_selected_statut = $this->input->post('id_selected_status');
        $fabrication_id = $this->input->post('id_fabrication');
        $type = $this->input->post('type');
        $data_accepte = $this->input->post('data_accepte');
        if ($data_accepte) {
            $date_insert = date_to_mysql($data_accepte);
        }
        if ($type == 0) {

            $data_update = array(
                'fabrication_status_id' => $id_selected_statut,
            );
            $this->db->where("fabrication_id", $fabrication_id);

            $this->db->update("ip_fabrication", $data_update);
        } else {
            if ($id_selected_statut == 4) {
                $data_update = array(

                    'quote_date_accepte' => $date_insert,
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

    public function fabrication_to_bl()
    {
         if (rightsAddFacture()) {
            $this->load->model(
                array(
                    'bl/mdl_bl',
                    'bl/mdl_bl_items',
                    'fabrication/mdl_fabrication',
                    'fabrication/mdl_fabrication_items',
                  //  'bl/mdl_invoice_tax_rates',
                    'fabrication/mdl_fabrication_tax_rates',
                  //  'quotes/mdl_quote_amounts',
                   // 'bl/mdl_invoice_amounts',
                )
            );
          //  var_dump($this->mdl_bl->run_validation())
          // if ($this->mdl_bl->run_validation()) {
         //   return die('1');
                $dt = explode('/', $this->input->post('invoice_date_created'));
                $daat = $dt[2] . '-' . $dt[1] . '-' . $dt[0];
                $dt_d = $this->input->post('invoice_date_due');
                $dat_d = $dt_d[2] . '-' . $dt_d[1] . '-' . $dt_d[0];

                $dtt = explode('/', $this->input->post('fabrication_date_accepte'));
                $daatacc = $dtt[2] . '-' . $dtt[1] . '-' . $dtt[0];

                $dttquoteaccepte = explode('/', $this->input->post('quote_date_accepte'));
                $daatuote_accepte = $dttquoteaccepte[2] . '-' . $dttquoteaccepte[1] . '-' . $dttquoteaccepte[0];
                //$invoice_id = $this->mdl_invoices->create(NULL, FALSE); quote_number
                $db_fact = array(
                    'user_id' =>  $this->session->userdata['user_id'],
                    'bl_delai_paiement' => $this->input->post('invoice_delai_paiement'),
                    'client_id' => $this->input->post('client_id'),
                //  'fabrication_status_id' => 
                    'bl_nature' => $this->input->post('nature'),
                    'bl_status_id' => $this->input->post('invoice_status_id'),
                    'bl_password' => $this->input->post('invoice_password'),
                    'bl_date_accepte' => $daatacc,
                    'quote_date_created' => $daat,
                    //'invoice_date_modified' => $this->input->post('invoice_date_created'),
                    'quote_date_expires' => $dt_d,
                    'bl_number' => $this->input->post('invoice_number'),
                    'bl_terms' => $this->input->post('invoice_terms'),
                    'bl_date_accepte' =>$daatuote_accepte,
                    'bl_pdf' => $this->input->post('bl_pdf'),
                    'signature' => $this->input->post('signature'),
                );

                //$this->mdl_invoices->save($db_fact);
                $this->db->insert('ip_bl', $db_fact);
                $bl_id = $this->db->insert_id();

                $this->db->where('fabrication_id', $this->input->post('quote_id'));
                $this->db->set('bl_id', $bl_id);
                $this->db->update('ip_fabrication');
                $this->mdl_settings->save('next_code_bf', $this->input->post('invoice_number'));
                //insert ds table bl_ammont
                $db_fact_amm = array(
                    'bl_id' => $bl_id,
                    'bl_item_subtotal' => $this->input->post('invoice_item_subtotal'),
                    'bl_item_tax_total' => $this->input->post('invoice_item_tax_total'),
                    'bl_tax_total' => $this->input->post('invoice_tax_total'),
                    'timbre_fiscale' => $this->input->post('timbre_fiscale'),
                    'bl_total' => $this->input->post('invoice_total'),
                    'bl_pourcent_remise' => $this->input->post('invoice_pourcent_remise'),
                    'bl_montant_remise' => $this->input->post('invoice_montant_remise'),
                    'bl_pourcent_acompte' => $this->input->post('invoice_pourcent_acompte'),
                    'bl_montant_acompte' => $this->input->post('invoice_montant_acompte'),
                    'bl_item_subtotal_final' => $this->input->post('invoice_item_subtotal_final'),
                    'bl_item_tax_total_final' => $this->input->post('invoice_item_tax_total_final'),
                    'bl_total_final' => $this->input->post('invoice_total_final'),
                    'bl_total_a_payer' => $this->input->post('invoice_total_a_payer'),
                    'bl_balance' => $this->input->post('invoice_total_a_payer'),
                );
                
                $this->db->insert('ip_bl_ammont', $db_fact_amm);
               
                $quote_items = $this->mdl_fabrication_items->where('fabrication_id', $this->input->post('quote_id'))->get()->result();
            
                foreach ($quote_items as $quote_item) {
                    $db_array = array(
                        'bl_id' => $bl_id,
                        'item_tax_rate_id' => $quote_item->item_tax_rate_id,
                        'item_name' => $quote_item->item_name,
                        'item_code' => $quote_item->item_code,
                        'item_description' => $quote_item->item_description,
                        'item_quantity' => $quote_item->item_quantity,
                        'item_price' => $quote_item->item_price,
                        'item_order' => $quote_item->item_order,
                    );
                    $this->db->insert('ip_bl_items', $db_array);
                    $id_item = $this->db->insert_id();
                    $db_array2 = array(
                        'item_id' => $id_item,
                        'item_subtotal' => $quote_item->item_subtotal,
                        'item_tax_total' => $quote_item->item_tax_total,
                        'item_total' => $quote_item->item_total,
                    );
                    $this->db->insert('ip_bl_item_amounts', $db_array2);
//                $this->mdl_items->save($invoice_id, NULL, $db_array);
                }

//            $quote_tax_rates = $this->mdl_quote_tax_rates->where('quote_id', $this->input->post('quote_id'))->get()->result();
                //
                //            foreach ($quote_tax_rates as $quote_tax_rate) {
                //                $db_array = array(
                //                    'invoice_id' => $invoice_id,
                //                    'tax_rate_id' => $quote_tax_rate->tax_rate_id,
                //                    'include_item_tax' => $quote_tax_rate->include_item_tax,
                //                    'invoice_tax_rate_amount' => $quote_tax_rate->quote_tax_rate_amount
                //                );
                //
                //                $this->mdl_invoice_tax_rates->save($invoice_id, NULL, $db_array);
                //            }
                //                $data_acc_n = array(
                //                    'descrip' => $this->session->userdata['user_code'] . ' à transformé le devie ' . $this->input->post('quote_number') . ' en facture : ' . $this->input->post('invoice_number') . '//' . $this->input->post('quote_id') . '//' . $invoice_id,
                //                    'activites_date_created' => date('Y-m-d H:i:s'),
                //                    'etat' => 5,
                //                    'user_id' => $this->session->userdata['user_id'],
                //                    'client_id' => $this->input->post('client_id'),
                //                    'adresse_ip' => $this->session->userdata['ip_address'],
                //                );
                ////            echo '<pre>';
                ////            print_r($data_acc_n);
                ////            echo '</pre>';
                ////            die;
                //                $this->db->insert('ip_activites', $data_acc_n);

                if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                    $data_log = array(
                        "log_action" => "quote_to_bl",
                        "log_date" => date('Y-m-d H:i:s'),
                        "log_ip" => $this->session->userdata['ip_address'],
                        "log_user_id" => $this->session->userdata['user_id'],
                        "log_field1" => $this->input->post('quote_id'),
                        "log_field2" => $bl_id,
                    );
                    $this->db->insert('ip_logs', $data_log);
                }

                $response = array(
                    'success' => 1,
                    'invoice_id' => $bl_id,
                );
           } /*else {
            
                $this->load->helper('json_error');
                $response = array(
                    'success' => 0,
                    'validation_errors' => json_errors(),
                );
            } */

            echo json_encode($response);
        // }
    }


    public function modal_fabrication_to_bl($fabrication_id)
    {
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('fabrication/mdl_fabrication');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('payment_methods/mdl_payment_methods');

        $result = $this->db->get('ip_fabrication')->result_array();
        $last_id = @$result[0]['fabrication_number'];
        $next_id = $this->getNextCodebl($this->mdl_settings->setting('next_code_bl'));
        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'fabrication_id' => $fabrication_id,
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'last_id' => $last_id,
            'next_id' => $next_id,
            'quote' => $this->mdl_fabrication->where('ip_fabrication.fabrication_id', $fabrication_id)->get()->row(),
        );

        $this->load->view('fabrication/modal_fabrication_to_bl', $data);
    }
 
    public function getNextCodefabrication($id)
    {
        $this->db->where('fabrication_number', $id);
        $fabrication = $this->db->get('ip_fabrication')->result();
        if (!empty($fabrication)) {
            $id++;
            return $this->getNextCodefabrication($id);
        } else {
            return $id;
        }
    }

    public function getNextCodebl($id)
    {
        $this->db->where('bl_number', $id);
        $bl = $this->db->get('ip_bl')->result();
        if (!empty($bl)) {
            $id++;
            return $this->getNextCodebl($id);
        } else {
            return $id;
        }
    }
    
}