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

        $this->load->model('clients/mdl_clients');
        $this->load->model('payments/mdl_payments');
        $this->load->model('item_lookups/mdl_item_lookups');
        $this->load->model('activites/mdl_activites');
        $this->load->model('quotes/mdl_rappel');
        $this->load->model('bl/mdl_bl');
        $this->load->model('products/mdl_products');
        $items_count = $this->input->post('items_count');
        $error_items_msg = "";
        $error_items = 0;
        if ($items_count == 0) {
            $error_items_msg = lang('error_nb_ligne');
            $error_items = 1;
        }

        if ($this->mdl_bl->run_validation() && ($error_items == 0)) {
            $tax_rates = $this->mdl_tax_rates->get()->result();
            $quote_date_created = $this->mdl_bl->form_values['quote_date_created'];
            if ($quote_date_created != '') {
                $quote_date = explode('/', $quote_date_created);
                $quote_dt = $quote_date[2] . '-' . $quote_date[1] . '-' . $quote_date[0];
            } else {
                $quote_dt = '';
            }

            $quote_date_expires = $this->mdl_bl->form_values['quote_date_expires'];
            if ($quote_date_expires != '') {
                $quote_date_ex = explode('/', $quote_date_expires);
                $quote_dt_ex = $quote_date_ex[2] . '-' . $quote_date_ex[1] . '-' . $quote_date_ex[0];
            } else {
                $quote_dt_ex = '';
            }

            $quote_date_accepte = $this->mdl_bl->form_values['bl_date_accepte'];
            if ($quote_date_accepte != '') {
                $date_d_acc = explode('/', $quote_date_accepte);
                $date_d = $date_d_acc[2] . '-' . $date_d_acc[1] . '-' . $date_d_acc[0];
            } else {
                $date_d = '';
            }

//insertion ds table quotes
            $items = json_decode($this->mdl_bl->form_values['items']);
            if ($this->mdl_bl->form_values['quote_nature'] == '') {
                $this->mdl_bl->form_values['quote_nature'] = $items[0]->item_code;
            }
            $valCode_quote = $this->mdl_settings->setting('next_code_bl') + 1;
            //  $resdate = $this->mdl_quotes->form_values['date_relance'];
           
            $data = array(
                'user_id' => $this->session->userdata('user_id'),
                'client_id' => $this->mdl_bl->form_values['client_id'],
                'bl_nature' => $this->mdl_bl->form_values['quote_nature'],
                'bl_password' => $this->mdl_bl->form_values['quote_password'],
                'quote_date_created' => $quote_dt,
                // 'quote_time_created' => date('H:i:s'),
                'quote_date_expires' => $quote_dt_ex,
                'bl_date_accepte' => $date_d,
                'bl_number' => $valCode_quote,
                'notes' => $this->mdl_bl->form_values['notes'],
                'bl_status_id' => $this->mdl_bl->form_values['quote_status_id'],
                //'document' => $this->mdl_quotes->form_values['document'],
                //'joindredevis' => $this->mdl_quotes->form_values['joindredevis'],
                'bl_delai_paiement' => $this->mdl_bl->form_values['quote_delai_paiement'],
                'signature' => $this->mdl_bl->form_values['signature'],
                'langue' => $this->mdl_bl->form_values['langue'], 
                'display_amount' => $this->mdl_bl->form_values['display_amount'],   
                'photo' => $this->mdl_bl->form_values['photo'],   
                            
            );

            $this->db->insert('ip_bl', $data);
            $bl_id = $this->db->insert_id();
            /*   if ($resdate != "") {
            $date_explode = explode(",", $resdate);
            for ($i = 0; $i < count($date_explode); $i++) {
            $data = array('daterappel' => $date_explode[$i], 'type' => 'quote', 'idobject' => $quote_id);
            $this->db->insert('ip_rappelmail', $data);
            }
            }*/

            $this->mdl_settings->save('next_code_bl', $valCode_quote);
            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "add_bl",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $bl_id,
                );
                $this->db->insert('ip_logs', $data_log);
            }

//insertion ds bl_ammont

            $data_amm = array(
                'bl_id' => $bl_id,
                'bl_item_subtotal' => $this->mdl_bl->form_values['quote_item_subtotal_final'],
                'bl_item_tax_total' => $this->mdl_bl->form_values['quote_item_tax_total_final'],
                'bl_tax_total' => $this->mdl_bl->form_values['quote_item_tax_total_final'],
                'timbre_fiscale' => $this->mdl_bl->form_values['timbre_fiscale_span'],
                'bl_total' => $this->mdl_bl->form_values['total_quote'],
                'bl_pourcent_remise' => $this->mdl_bl->form_values['pourcent_remise_quote'],
                'bl_montant_remise' => $this->mdl_bl->form_values['montant_remise_quote'],
                'bl_pourcent_acompte' => $this->mdl_bl->form_values['pourcent_acompte_quote'],
                'bl_montant_acompte' => $this->mdl_bl->form_values['montant_acompte_quote'],
                'bl_item_subtotal_final' => $this->mdl_bl->form_values['quote_item_subtotal_final'],
                'bl_item_tax_total_final' => $this->mdl_bl->form_values['quote_item_tax_total_final'],
                'bl_total_final' => $this->mdl_bl->form_values['total_quote'],
                'bl_total_a_payer' => $this->mdl_bl->form_values['total_a_payer_quote'],
            );
            $this->db->insert('ip_bl_ammont', $data_amm);

//insertion ds table itmes
            $items = json_decode($this->mdl_bl->form_values['items']);
            foreach ($items as $item) {
              //  if ($item->item_code != '') {
                    //insert ds quotes_items
                    $data_itm = array(
                        'bl_id' => $bl_id,
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
                    $this->db->insert('ip_bl_items', $data_itm);
                    $item_id = $this->db->insert_id();
                    $this->mdl_products->calculstockalert($item->item_code);
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

                    $this->db->insert('ip_bl_item_amounts', $data_itm_am);
              //  }
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
                'quote_id' => $bl_id,
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

    public function getItemsBybl()
    {
        $this->load->model('bl/mdl_bl_items');

        $id = $this->input->post('quote_id');
        $this->db->where('bl_id', $id);
        $items = $this->mdl_bl_items->get()->result();

        echo json_encode($items);
    }
    public function getAllbl()
    {
        $this->db->select(array('bl_id'));
        $bl = $this->db->get('ip_bl')->result();
        echo json_encode($bl);
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
        $this->load->model('bl/mdl_bl_items');
        $this->load->model('item_lookups/mdl_item_lookups');
        //  $this->load->model('bl/mdl_bl_item_amounts');
        // $this->load->model('bl/mdl_bl_amounts');
        $this->load->model('bl/mdl_bl');
        $this->load->model('activites/mdl_activites');
        $this->load->model('products/mdl_products');
        $tax = $this->mdl_tax_rates->get()->result();

        $items_count = $this->input->post('items_count');
        $error_items_msg = "";
        $error_items = 0;
        if ($items_count == 0) {
            $error_items_msg = lang('error_nb_ligne');
            $error_items = 1;
        }
        if ($this->mdl_bl->run_validation() && ($error_items == 0)) {

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
                'bl_nature' => $this->input->post('quote_nature'),
                'bl_password' => $this->input->post('quote_password'),
                'quote_date_created' => $quote_dt,
                'quote_date_expires' => $quote_dt_ex,
                'bl_date_accepte' => $date_d,
                'notes' => $this->input->post('notes'),
                'bl_status_id' => $this->input->post('quote_status_id'),
                'bl_date_modified' => date('Y-m-j H:i:s'),
                'bl_delai_paiement' => $this->input->post('quote_delai_paiement'),
                'signature' => $this->input->post('signature'),
                'langue' => $this->input->post('langue'),
                'display_amount' => $this->input->post('display_amount'),
            );

            $this->db->where('bl_id', $this->input->post('quote_id'));
            $this->db->update('ip_bl', $data);
//modif items

            $this->db->where('bl_id', $this->input->post('quote_id'));
            $this->db->delete('ip_bl_items');
            $items = json_decode($this->input->post('items'));
            foreach ($items as $item) {
                if ($item->item_code != '') {
                    //insert ds quotes_items
                    $data_itm = array(
                        'bl_id' => $quote_id,
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
                    $this->db->insert('ip_bl_items', $data_itm);
                    $item_id = $this->db->insert_id();
                    $this->mdl_products->calculstockalert($item->item_code);
                   
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
                    $this->db->insert('ip_bl_item_amounts', $data_itm_am);
                }
            }
//modif quote_amounts
            $this->db->where('bl_id', $this->input->post('quote_id'));
            $this->db->delete('ip_bl_ammont');

            $data_amm = array(
                'bl_id' => $quote_id,
                'bl_item_subtotal' => $this->input->post('quote_item_subtotal_final'),
                'bl_item_tax_total' => $this->input->post('quote_item_tax_total_final'),
                'bl_tax_total' => $this->input->post('quote_item_tax_total_final'),
                'timbre_fiscale' => $this->input->post('timbre_fiscale_span'),
                'bl_total' => $this->input->post('total_quote'),
                'bl_pourcent_remise' => $this->input->post('pourcent_remise_quote'),
                'bl_montant_remise' => $this->input->post('montant_remise_quote'),
                'bl_pourcent_acompte' => $this->input->post('pourcent_acompte_quote'),
                'bl_montant_acompte' => $this->input->post('montant_acompte_quote'),
                'bl_item_subtotal_final' => $this->input->post('quote_item_subtotal_final'),
                'bl_item_tax_total_final' => $this->input->post('quote_item_tax_total_final'),
                'bl_total_final' => $this->input->post('total_quote'),
                'bl_total_a_payer' => $this->input->post('total_a_payer_quote'),
            );

            $this->db->insert('ip_bl_ammont', $data_amm);
            $this->db->select('bl_number');
            $this->db->where("bl_id", $quote_id);
            $numbl = $this->db->get('ip_bl')->result();
            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "edit_bl",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $this->input->post('quote_id'),
                    "log_field2" => $numbl[0]->bl_number,

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
            "log_field1" => $this->mdl_bl->form_values['quote_id'],
            );
            $this->db->insert('ip_logs', $data_log);
            }
             */
            /* $resdate = $this->mdl_bl->form_values['date_relance'];
            //  return var_dump($resdate);
            $this->mdl_rappel->updateDateRelance($this->mdl_bl->form_values['quote_id'], $resdate, 0);

            $arra = array('object_id' => $quote_id, 'typeobject' => 'quote');
            $this->db->delete('ip_document_rappel', $arra);

            $docselectionne = $this->mdl_bl->form_values['listdocu'];

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

    public function getblInfo()
    {
        $this->load->helper('country');
        $bl_id = $this->input->post('bl_id');
        var_dump($bl_id);
        $this->db->where("ip_bl.bl_id", $bl_id);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_bl.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_bl_ammont', 'ip_bl_ammont.bl_id = ip_bl.bl_id', 'left');

        $country = get_country_list(lang('cldr'));

        $bl = $this->db->get("ip_bl")->result();

        $this->db->where("ip_bl_items.bl_id", $bl_id);
        $bl_items = $this->db->get("ip_bl_items")->result();
        $bl[0]->bl_items = $bl_items;
        $bl[0]->client_country = $country[$bl[0]->client_country];

        echo json_encode($bl);
    }

    public function modal_change_statut($type)
    {
        $this->load->model('bl/mdl_bl');
        $this->load->model('quotes/mdl_quotes');

        $bl_id = $this->input->post('bl_id');
        if ($type == 0) {
            $this->db->where("bl_id", $bl_id);
            $result = $this->db->get("ip_bl")->result();
        } else {
             $this->db->where("bl_id", $bl_id);
            $result = $this->db->get("ip_bl")->result();
        }

        $data = array();
        if ($type == 0) {
            $data['quote_statuses'] = $this->mdl_quotes->statuses();
        } else {
            $data['quote_statuses'] = $this->mdl_invoices->statuses();
        }
        $data['bl'] = $result[0];
        $data['type'] = $type;

         $this->load->view('bl/modal_change_statut', $data);
    }

    public function updateStatutbl()
    {
        $id_selected_statut = $this->input->post('id_selected_status');
        $bl_id = $this->input->post('id_bl');
        $type = $this->input->post('type');
        $data_accepte = $this->input->post('data_accepte');
        if ($data_accepte) {
            $date_insert = date_to_mysql($data_accepte);
        }
         if ($type == 0) {

            $data_update = array(
                'bl_status_id' => $id_selected_statut,
                'bl_date_accepte' => $date_insert,
            );
            $this->db->where("bl_id", $bl_id);

            $this->db->update("ip_bl", $data_update);
         }        
    }

}