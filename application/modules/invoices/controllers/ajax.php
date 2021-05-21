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

    public function getNextCodeFacture($id)
    {
        $this->db->where('invoice_number', $id);
        $invoice = $this->db->get('ip_invoices')->result();
        if (!empty($invoice)) {
            $id++;
            return $this->getNextCodeFacture($id);
        } else {
            return $id;
        }
    }

    public function create()
    {
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('clients/mdl_clients');
        $this->load->model('pieces/mdl_pieces');
        $this->load->model('payments/mdl_payments');
        $this->load->model('invoices/mdl_items');
        $this->load->model('item_lookups/mdl_item_lookups');
        $this->load->model('invoices/mdl_item_amounts');
        $this->load->model('invoices/mdl_invoice_amounts');
        $this->load->model('products/mdl_products');
        $this->load->model('products/mdl_stock');
        $this->load->model('invoices/mdl_invoices_recur');
        /*   $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/temprelance';
        if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777);
        }
        $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/documents';
        if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777);
        }*/
        $items_count = $this->input->post('items_count');
        $error_items_msg = "";
        $error_items = 0;
        if ($items_count == 0) {
            $error_items_msg = lang('error_nb_ligne');
            $error_items = 1;
        }

        if ($this->mdl_invoices->run_validation() && ($error_items == 0)) {

            //le champ nature prend nom_item s'il n'est pas introduit
            $items = json_decode($this->mdl_invoices->form_values['items']);
            if ($this->mdl_invoices->form_values['invoice_nature'] == '') {
                $this->mdl_invoices->form_values['invoice_nature'] = $items[0]->item_code;
            }
            $tax_rates = $this->mdl_tax_rates->get()->result();
            $mnt = 0;
            $invoice_date_created = $this->mdl_invoices->form_values['invoice_date_created'];
            if ($invoice_date_created != '') {
                $invoice_date = explode('/', $invoice_date_created);
                $invoice_dt = $invoice_date[2] . '-' . $invoice_date[1] . '-' . $invoice_date[0];
            } else {
                $invoice_dt = '';
            }

            $invoice_date_expires = $this->mdl_invoices->form_values['invoice_date_expires'];
            if ($invoice_date_expires != '') {
                $invoice_date_ex = explode('/', $invoice_date_expires);
                $invoice_dt_ex = $invoice_date_ex[2] . '-' . $invoice_date_ex[1] . '-' . $invoice_date_ex[0];
            } else {
                $invoice_dt_ex = '';
            }   
            $valCode_invoice = 0;         
            if($this->input->post('recursive')==0){
                $valCode_invoice += (int)$this->getNextCodeFacture($this->mdl_settings->setting('next_code_invoice'));
                $this->mdl_settings->save('next_code_invoice', $valCode_invoice);
            }
           // $valCode_invoice = $this->getNextCodeFacture($this->mdl_settings->setting('next_code_invoice'));
            $resdate = $this->mdl_invoices->form_values['date_relance'];
            $data = array(
                'user_id' => $this->mdl_invoices->form_values['user_id'],
                'invoice_delai_paiement' => $this->mdl_invoices->form_values['invoice_delai_paiement'],
                'client_id' => $this->mdl_invoices->form_values['client_id'],
                'nature' => $this->mdl_invoices->form_values['invoice_nature'],
                'invoice_password' => $this->mdl_invoices->form_values['invoice_password'],
                'invoice_date_created' => $invoice_dt,
                'invoice_time_created' => date('H:i:s'),
                'invoice_date_due' => $invoice_dt_ex,
                'invoice_number' => $valCode_invoice,
                'invoice_terms' => $this->mdl_invoices->form_values['notes'],
                'invoice_status_id' => $this->mdl_invoices->form_values['invoice_status_id'],
                'document' => $this->input->post('document'),
                'joindredevis' => $this->input->post('joindredevis'),
                'recursive' => $this->input->post('recursive'),
                'recursive_id' => $this->input->post('recursive_id'),
                'signature' => $this->input->post('signature'),
                'langue' => $this->mdl_invoices->form_values['langue'],
                'photo' => $this->mdl_invoices->form_values['photo'],
            );
            $this->db->insert('ip_invoices', $data);
            $invoice_id = $this->db->insert_id();
            if ($resdate != "") {
                $date_explode = explode(",", $resdate);
                for ($i = 0; $i < count($date_explode); $i++) {
                    $data = array('daterappel' => $date_explode[$i], 'type' => 'invoice', 'idobject' => $invoice_id);
                    $this->db->insert('ip_rappelmail', $data);
                }
            }
            if($this->input->post('recursive')!=0 && $this->input->post('recursive_id')!=0){
                $datareccur=array('id_invoice'=>$invoice_id,'date_creation'=>$invoice_dt,'id_user'=>$this->mdl_invoices->form_values['user_id'],'date_next' =>$this->mdl_invoices_recur->nextdate($invoice_dt,$this->input->post('recursive_id')) );
                $this->mdl_invoices_recur->save($datareccur);
            }
           
           
           // $this->db->insert('ip_invoice_amounts', (int) $this->mdl_invoices->form_values['invoice_number'] + 1);
            //prospect becomes customer if invoice create
            $this->db->select('client_type');
            $this->db->where('client_id', $this->mdl_invoices->form_values['client_id']);
            $getclient = $this->db->get('ip_clients')->result();
            if ($getclient[0]->client_type == 0) {

                $data_client = array(
                    'client_type' => 1,
                    'date_creation_client' => date('Y-m-d'),
                );
                $this->db->where('client_id', $this->mdl_invoices->form_values['client_id']);
                $this->db->update('ip_clients', $data_client);
            }

//insertion ds invoice_ammont

            $data_amm = array(
                'invoice_id' => $invoice_id,
                'invoice_item_subtotal' => $this->mdl_invoices->form_values['invoice_item_subtotal_final'],
                'invoice_item_tax_total' => $this->mdl_invoices->form_values['invoice_item_tax_total_final'],
                'invoice_tax_total' => $this->mdl_invoices->form_values['invoice_item_tax_total_final'],
                'timbre_fiscale' => $this->mdl_invoices->form_values['timbre_fiscale_span'],
                'invoice_total' => $this->mdl_invoices->form_values['total_invoice_final'],
                'invoice_paid' => $mnt,
                'invoice_balance' => $this->mdl_invoices->form_values['total_a_payer_invoice'],
                'invoice_pourcent_remise' => $this->mdl_invoices->form_values['pourcent_remise_invoice'],
                'invoice_montant_remise' => $this->mdl_invoices->form_values['montant_remise_invoice'],
                'invoice_pourcent_acompte' => $this->mdl_invoices->form_values['pourcent_acompte_invoice'],
                'invoice_montant_acompte' => $this->mdl_invoices->form_values['montant_acompte_invoice'],
                'invoice_item_subtotal_final' => $this->mdl_invoices->form_values['invoice_item_subtotal_final'],
                'invoice_item_tax_total_final' => $this->mdl_invoices->form_values['invoice_item_tax_total_final'],
            );
            $this->db->insert('ip_invoice_amounts', $data_amm);
            if($this->input->post('recursive')==0){
            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "add_invoice",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $invoice_id,
                );
                $this->db->insert('ip_logs', $data_log);
            }
        }
            $payments = $this->input->post('payments');
            if (!empty($payments)) {
                foreach ($payments as $pay) {
                    $data_up_pay = array(
                        'invoice_id' => $invoice_id,
                    );
                    $this->db->where("payment_id", $pay);
                    $this->db->update('ip_payments', $data_up_pay);
                }
            }

            $items = json_decode($this->mdl_invoices->form_values['items']);
            if (count($items) != 0) {
                foreach ($items as $item) {
                   // if ($item->item_code != '') {

                        //insert ds invoices_items
                        $data_itm = array(
                            'invoice_id' => $invoice_id,
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
                            'depot' => $item->depot,
                        );
                        $this->db->insert('ip_invoice_items', $data_itm);
                        $item_id = $this->db->insert_id();
                        $this->mdl_stock->stockdeclinaison($item->item_code,$item->item_quantity,$invoice_id,0);
                       // $this->mdl_products->calculstockalert($item->item_code);
                        $tax = 0;
                        foreach ($tax_rates as $tvalue) {

                            if ($tvalue->tax_rate_id == $item->item_tax_rate_id) {
                                $tax = $tvalue->tax_rate_percent;
                            }
                        }

                        //insert ds invoice_item_amounts  ,
                        $item_subtotal = $item->item_price * $item->item_quantity;
                        $item_tax_total = $tax * ($item->item_price * $item->item_quantity) / 100;
                        $item_total = ($item->item_price * $item->item_quantity) + ($tax * ($item->item_price * $item->item_quantity) / 100);
                        $data_itm_am = array(
                            'item_id' => $item_id,
                            'item_subtotal' => $item_subtotal,
                            'item_tax_total' => $item_tax_total,
                            'item_total' => $item_total,
                        );

                        $this->db->insert('ip_invoice_item_amounts', $data_itm_am);
                  //  }
                }
            }
            // var_dump($this->mdl_invoices->form_values['document']);
            // var_dump($resdate);
            if ($this->mdl_invoices->form_values['document'] == 1 && $resdate != "") {
                $tabledoc = $this->mdl_invoices->form_values['listdocu'];
                $tabledocexp = explode(',', $tabledoc);
                for ($i = 0; $i < count($tabledocexp); $i++) {
                    $this->db->select('file_name,id_client');
                    $this->db->where("id_document", $tabledocexp[$i]);
                    $getclientdoc = $this->db->get('ip_client_documents')->result();
                    if ($getclientdoc[0]->file_name != "") {

                        $data_doc_client = array(
                            'typeobject' => 'invoice',
                            'object_id' => $invoice_id,
                            'doc_id' => $tabledocexp[$i],
                            'nomdocument' => $getclientdoc[0]->file_name,
                            'client_id' => $getclientdoc[0]->id_client,
                        );
                        $this->db->insert('ip_document_rappel', $data_doc_client);
                    }
                }
            }

            $response = array(
                'success' => 1,
                'invoice_id' => $invoice_id,
            );
            $this->generate_invoice_pdf($invoice_id, false, null);
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => validation_errors() . $error_items_msg,
            );
        }

        echo json_encode($response);

        //  print_r($_POST);
    }

    public function save()
    { 
        /* $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/temprelance';
        if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777);
        }
        $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/documents';
        if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777);
        }*/
        $this->load->model('clients/mdl_clients');
        $this->load->model('pieces/mdl_pieces');
        $this->load->model('payments/mdl_payments');
        $this->load->model('invoices/mdl_item_amounts');
        $this->load->model('invoices/mdl_invoice_amounts');

        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('item_lookups/mdl_item_lookups');
        $this->load->library('encrypt');
        $this->load->model('quotes/mdl_rappel');
        $this->load->model('quote_rappel/mdl_quote_rappel');
        $this->load->model('products/mdl_products');
        $this->load->model('invoices/mdl_invoices_recur');
        $this->load->model('products/mdl_stock');
        $tax = $this->mdl_tax_rates->get()->result();

        $items_count = $this->input->post('items_count');
        $error_items_msg = "";
        $error_items = 0;
        if ($items_count == 0) {
            $error_items_msg = lang('error_nb_ligne');
            $error_items = 1;
        }

        if ($this->mdl_invoices->run_validation() && ($error_items == 0)) {               
            if ($this->mdl_invoices->form_values['invoice_id']) {
                $invoice_id = $this->mdl_invoices->form_values['invoice_id'];
                $mnt = 0;
                $invoice_date_created = $this->mdl_invoices->form_values['invoice_date_created'];
                if ($invoice_date_created != '') {
                    $invoice_date = explode('/', $invoice_date_created);
                    $invoice_dt = $invoice_date[2] . '-' . $invoice_date[1] . '-' . $invoice_date[0];
                } else {
                    $invoice_dt = '';
                }

                $invoice_date_expires = @$this->mdl_invoices->form_values['invoice_date_expires'];
                if ($invoice_date_expires != '') {
                    $invoice_date_ex = explode('/', $invoice_date_expires);
                    $invoice_dt_ex = $invoice_date_ex[2] . '-' . $invoice_date_ex[1] . '-' . $invoice_date_ex[0];
                } else {
                    $invoice_dt_ex = '';
                }

//modif table invoice
                $data = array(
                    'client_id' => $this->mdl_invoices->form_values['client_id'],
                    'user_id_modif' => $this->mdl_invoices->form_values['user_id'],
                    'invoice_date_created' => $invoice_dt,
                    'invoice_date_modified' => date('Y-m-j H:i:s'),
                    'invoice_time_created' => date('H:i:s'),
                    'invoice_date_due' => $invoice_dt_ex,
                    'invoice_password' => $this->mdl_invoices->form_values['invoice_password'],
                    'invoice_status_id' => $this->mdl_invoices->form_values['invoice_status_id'],
                    'invoice_number' => $this->mdl_invoices->form_values['invoice_number'],
                    'invoice_delai_paiement' => $this->mdl_invoices->form_values['invoice_delai_paiement'],
                    'invoice_terms' => $this->mdl_invoices->form_values['notes'],
                    'nature' => $this->mdl_invoices->form_values['invoice_nature'],
                    'document' => $this->mdl_invoices->form_values['document'],
                    'joindredevis' => $this->mdl_invoices->form_values['piece'],
                    'recursive' =>$this->mdl_invoices->form_values['recursive'], 
                    'recursive_id' => $this->mdl_invoices->form_values['recursive_id'],  
                    'signature' => $this->mdl_invoices->form_values['signature'], 
                    'langue' => $this->mdl_invoices->form_values['langue'],  
                );

                $this->db->where('invoice_id', $this->mdl_invoices->form_values['invoice_id']);
                $this->db->update('ip_invoices', $data);
//modif items

                //get invoice items          
                $items_result = $this->mdl_items->where('invoice_id', $invoice_id)->get()->result();
                $this->db->where('invoice_id', $this->mdl_invoices->form_values['invoice_id']);
                $this->db->delete('ip_invoice_items');

                $items = json_decode($this->mdl_invoices->form_values['items']);

                if (count($items) != 0) {
                    foreach ($items as $item) {
                       // if ($item->item_code != '') {
                            //insert ds invoices_items
                            $data_itm = array(
                                'invoice_id' => $invoice_id,
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
                                'depot' => $item->depot,
                            );
                            $this->db->insert('ip_invoice_items', $data_itm);
                            $item_id = $this->db->insert_id();
// DEBUT CALCUL STOCK
                          //  $this->mdl_items->where('item_name', trim($item->item_name));
                            $trouve=0;
                            foreach($items_result as $val){
                                    if(trim($val->item_name)==trim($item->item_name)){
                                        breack;   
                                        $trouve=1; 
                                        $rest=$item->item_quantity-$val->item_quantity;             
                                        $this->mdl_stock->stockdeclinaison($item->item_code,$rest, $invoice_id,0);                         
                                    }
                            }
                            if($trouve==0){
                                $this->mdl_stock->stockdeclinaison($item->item_code,$item->item_quantity, $invoice_id,0);
                            }
// FIN CALCUL STOCK
                           
                            $tax = 0;
                            $tax_rates = $this->mdl_tax_rates->get()->result();
                            foreach ($tax_rates as $tvalue) {

                                if ($tvalue->tax_rate_id == $item->item_tax_rate_id) {
                                    $tax = $tvalue->tax_rate_percent;
                                }
                            }

                            //insert ds invoice_item_amounts  ,
                            $item_subtotal = $item->item_price * $item->item_quantity;
                            $item_tax_total = $tax * ($item->item_price * $item->item_quantity) / 100;
                            $item_total = ($item->item_price * $item->item_quantity) + ($tax * ($item->item_price * $item->item_quantity) / 100);
                            $data_itm_am = array(
                                'item_id' => $item_id,
                                'item_subtotal' => $item_subtotal,
                                'item_tax_total' => $item_tax_total,
                                'item_total' => $item_total,
                            );
                            $this->db->insert('ip_invoice_item_amounts', $data_itm_am);
                        }
                      //  $this->mdl_products->calculstockalert($item->item_code);

                   // }
                }

//modif invoice_amounts
                $this->db->where('invoice_id', $this->mdl_invoices->form_values['invoice_id']);
                $this->db->delete('ip_invoice_amounts');
                if($this->mdl_invoices->form_values['recursive']!=0){
                    $this->mdl_invoices_recur->deleterecur($this->mdl_invoices->form_values['invoice_id']);
                    $datareccur=array('id_invoice'=> $this->mdl_invoices->form_values['invoice_id'],'date_creation'=>date('Y-m-d'),'id_user'=> $this->session->userdata['user_id'] , 'date_next' =>$this->mdl_invoices_recur->nextdate($invoice_dt,$this->mdl_invoices->form_values['recursive_id']) );
                    $this->mdl_invoices_recur->save($datareccur);
                }else{
                     $this->mdl_invoices_recur->deleterecur($this->mdl_invoices->form_values['invoice_id']);
                }
                $data_invoice_amounts = array(
                    'invoice_id' => $this->mdl_invoices->form_values['invoice_id'],
                    'invoice_item_subtotal' => $this->mdl_invoices->form_values['invoice_item_subtotal_final'],
                    'invoice_item_tax_total' => $this->mdl_invoices->form_values['invoice_item_tax_total_final'],
                    'invoice_tax_total' => $this->mdl_invoices->form_values['invoice_id'],
                    'timbre_fiscale' => $this->mdl_invoices->form_values['timbre_fiscale_span'],
                    'invoice_total' => $this->mdl_invoices->form_values['total_invoice_final'],
                    'invoice_paid' => $mnt,
                    'invoice_balance' => $this->mdl_invoices->form_values['total_a_payer_invoice'],
                    'invoice_pourcent_remise' => $this->mdl_invoices->form_values['pourcent_remise_invoice'],
                    'invoice_pourcent_acompte' => $this->mdl_invoices->form_values['pourcent_acompte_invoice'],
                    'invoice_montant_acompte' => $this->mdl_invoices->form_values['montant_acompte_invoice'],
                    'invoice_item_subtotal_final' => $this->mdl_invoices->form_values['invoice_item_subtotal_final'],
                    'invoice_item_tax_total_final' => $this->mdl_invoices->form_values['invoice_item_tax_total_final'],
                    'invoice_montant_remise' => $this->mdl_invoices->form_values['montant_remise_invoice'],
                );

                $this->db->insert('ip_invoice_amounts', $data_invoice_amounts);
            }
            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "edit_invoice",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $this->mdl_invoices->form_values['invoice_id'],
                );
                $this->db->insert('ip_logs', $data_log);
            }
            $resdate = $this->mdl_invoices->form_values['date_relance'];
            $this->mdl_rappel->updateDateRelance($this->mdl_invoices->form_values['invoice_id'], $resdate, 1);

            $arra = array('object_id' => $invoice_id, 'typeobject' => 'invoice');
            $this->db->delete('ip_document_rappel', $arra);

            $docselectionne = $this->mdl_invoices->form_values['listdocu'];

            $docselectionneid = explode(',', $docselectionne);

            for ($i = 0; $i < count($docselectionneid); $i++) {
                if ($docselectionneid[$i] != '') {
                    $this->db->select('file_name,id_client');
                    $this->db->where("id_document", $docselectionneid[$i]);
                    $getclientdoc = $this->db->get('ip_client_documents')->result();

                    $data_doc_client = array(
                        'typeobject' => 'invoice',
                        'object_id' => $invoice_id,
                        'doc_id' => $docselectionneid[$i],
                        'nomdocument' => $getclientdoc[0]->file_name,
                        'client_id' => $getclientdoc[0]->id_client,
                    );
                    $this->db->insert('ip_document_rappel', $data_doc_client);
                }
            }

            $this->generate_invoice_pdf($invoice_id, false, null);
            $response = array(
                'success' => 1,
                'invoice_id' => $invoice_id,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );
        }

        if ($this->input->post('custom')) {
            $db_array = array();

            foreach ($this->input->post('custom') as $custom) {
// I hate myself for this...
                $db_array[str_replace(']', '', str_replace('custom[', '', $custom['name']))] = $custom['value'];
            }

            $this->load->model('custom_fields/mdl_invoice_custom');
            $this->mdl_invoice_custom->save_custom($invoice_id, $db_array);
        }

        echo json_encode($response);
    }

    public function save_invoice_tax_rate()
    {
        $this->load->model('invoices/mdl_invoice_tax_rates');

        if ($this->mdl_invoice_tax_rates->run_validation()) {
            $this->mdl_invoice_tax_rates->save($this->input->post('invoice_id'));

            $response = array(
                'success' => 1,
            );
        } else {
            $response = array(
                'success' => 0,
                'validation_errors' => $this->mdl_invoice_tax_rates->validation_errors,
            );
        }

        echo json_encode($response);
    }

    public function create_recurring()
    {
        $this->load->model('invoices/mdl_invoices_recurring');

        if ($this->mdl_invoices_recurring->run_validation()) {
            $this->mdl_invoices_recurring->save();

            $response = array(
                'success' => 1,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );
        }

        echo json_encode($response);
    }

    public function modal_create_invoice()
    {
        $this->load->module('layout');

        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');

        $data = array(
//'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'client_id' => $this->input->post('client_id'),
        );

        $this->layout->load_view('invoices/modal_create_invoice', $data);
    }

    public function modal_create_recurring()
    {
        $this->load->module('layout');

        $this->load->model('mdl_invoices_recurring');

        $data = array(
            'invoice_id' => $this->input->post('invoice_id'),
            'recur_frequencies' => $this->mdl_invoices_recurring->recur_frequencies,
        );

        $this->layout->load_view('invoices/modal_create_recurring', $data);
    }

    public function get_recur_start_date()
    {
        $invoice_date = $this->input->post('invoice_date');
        $recur_frequency = $this->input->post('recur_frequency');

        echo increment_user_date($invoice_date, $recur_frequency);
    }

    public function modal_copy_invoice()
    {
        $this->load->module('layout');

        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');

        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'invoice_id' => $this->input->post('invoice_id'),
            'invoice' => $this->mdl_invoices->where('ip_invoices.invoice_id', $this->input->post('invoice_id'))->get()->row(),
        );

        $this->layout->load_view('invoices/modal_copy_invoice', $data);
    }

    public function copy_invoice()
    {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');

        if ($this->mdl_invoices->run_validation()) {
            $target_id = $this->mdl_invoices->save();
            $source_id = $this->input->post('invoice_id');

            $this->mdl_invoices->copy_invoice($source_id, $target_id);

            $response = array(
                'success' => 1,
                'invoice_id' => $target_id,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );
        }

        echo json_encode($response);
    }

    public function modal_create_credit()
    {
        $this->load->module('layout');

        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');

        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'invoice_id' => $this->input->post('invoice_id'),
            'invoice' => $this->mdl_invoices->where('ip_invoices.invoice_id', $this->input->post('invoice_id'))->get()->row(),
        );

        $this->layout->load_view('invoices/modal_create_credit', $data);
    }

    public function create_credit()
    {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');

        if ($this->mdl_invoices->run_validation()) {
            $target_id = $this->mdl_invoices->save();
            $source_id = $this->input->post('invoice_id');

            $this->mdl_invoices->copy_credit_invoice($source_id, $target_id);

// Set source invoice to read-only
            if ($this->config->item('disable_read_only') == false) {
                $this->mdl_invoices->where('invoice_id', $source_id);
                $this->mdl_invoices->update('ip_invoices', array('is_read_only' => '1'));
            }

// Set target invoice to credit invoice
            $this->mdl_invoices->where('invoice_id', $target_id);
            $this->mdl_invoices->update('ip_invoices', array('creditinvoice_parent_id' => $source_id));

            $this->mdl_invoices->where('invoice_id', $target_id);
            $this->mdl_invoices->update('ip_invoice_amounts', array('invoice_sign' => '-1'));

            $response = array(
                'success' => 1,
                'invoice_id' => $target_id,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );
        }

        echo json_encode($response);
    }

    public function modal_client_lookups()
    {
        $filter_client = $this->input->get('filter_client');

        $this->load->model('clients/mdl_clients');

        if (!empty($filter_client)) {
            $clients = $this->mdl_clients->by_client($filter_client);
        }
        $clients = $this->mdl_clients->get();
        $clients = $this->mdl_clients->result();

        $data = array(
            'clients' => $clients,
            'filter_client' => $filter_client,
        );

        $this->layout->load_view('invoices/modal_client_lookups', $data);
    }

    public function process_client_selections()
    {
        $this->load->model('clients/mdl_clients');

        $query = $this->input->post('client_ids');

        $clients = $this->mdl_clients->select('*')->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left')->where('client_id', intval($query))->get(array(), false)->result();

        $clients[0]->client_state = format_currency_with_symbol($this->mdl_settings->setting('default_item_timbre'), $clients[0]->devise_symbole);

        echo json_encode($clients);
    }

    public function getDateRappelInvoice()
    {

        $id_object = $this->input->post('id_object');
        $this->db->where('rappel_object_id', $id_object);
        $this->db->where('rappel_type', 'invoice');
        $rappels = $this->db->get('ip_rappel')->result();
        $dates = '';
        $i = 0;
        foreach ($rappels as $rappel) {
            if ($i == 0) {
                $dates = $rappel->rappel_date;
                $i++;
            } else {
                $dates = $dates . "," . $rappel->rappel_date;
            }
        }
        $response = array(
            'dates' => $dates,
        );
        echo json_encode($response);
    }

    public function save_date_rappel()
    {
        $dates = $this->input->post('dates');
        $id_object = $this->input->post('id_object');

        $arrayDates = explode(",", $dates);

        $this->db->where('rappel_object_id', $id_object);
        $this->db->where('rappel_type', 'invoice');
        $this->db->delete('ip_rappel');

        foreach ($arrayDates as $date) {
            $arrayRappel = array(
                'rappel_status' => 0,
                'rappel_date' => date_to_mysql($date),
                'rappel_type' => 'invoice',
                'rappel_object_id' => $id_object,
            );

            $this->db->insert('ip_rappel', $arrayRappel);
        }

        $response = array(
            'success' => 1,
        );
        echo json_encode($response);
    }

    public function delete_rappel()
    {

        $id_object = $this->input->post('id_object');
        $this->db->where('rappel_object_id', $id_object);
        $this->db->where('rappel_type', 'invoice');
        $this->db->delete('ip_rappel');
        $response = array(
            'success' => 1,
        );
        echo json_encode($response);
    }

    public function getItemsByInvoice()
    {
        $this->load->model('invoices/mdl_items');

        $id = $this->input->post('invoice_id');
        $this->db->where('invoice_id', $id);
        $items = $this->mdl_items->get()->result();

        echo json_encode($items);
    }

    public function load_invoices_partial_filter()
    {

        $this->load->model('invoices/mdl_invoices');

        $filter_invoice = trim(strtolower(addslashes($this->input->post('filter_invoice'))));
        $filter_user_id = $this->input->post('filter_user_id');
        $filter_date = $this->input->post('filter_date');
        $filter_statuts = $this->input->post('filter_statuts');
        $limit_par_page = $this->input->post('limit_par_page');
        $start_page = $this->input->post('start_page');
        $order_by = $this->input->post('order_by');
        $order_method = $this->input->post('order_method');
        $start_line = (int) ($start_page - 1) * (int) $limit_par_page;

        if ($filter_invoice != "") {
            $where = "((LOWER(ip_invoices.nature) LIKE '%" . $filter_invoice . "%')   ";

            $where .= " OR (LOWER(ip_invoices.invoice_number) LIKE '%" . $filter_invoice . "%' )";

            $where .= " OR (LOWER(ip_clients.client_societe) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_name) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_prenom) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_web) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_phone) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_fax) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_mobile) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_email) LIKE '%" . $filter_invoice . "%' )";
            $where .= " )";
        } else {
            $where = "ip_invoices.invoice_id <> 0 ";
        }
         $where .= " AND (ip_invoices.recursive <> 1)";
        if ($filter_statuts != "all") {
            $where .= " AND (ip_invoices.invoice_status_id = $filter_statuts)";
        }
        if ($filter_date != "all") {
            $date_deb = $filter_date . "-01-01";
            $date_fin = ($filter_date + 1) . "-01-01";
            $where .= " AND (ip_invoices.invoice_date_created >= '" . $date_deb . "' AND ip_invoices.invoice_date_created < '" . $date_fin . "')";
        }
        if ($filter_user_id != 0) {
            $where .= " AND (ip_invoices.user_id = $filter_user_id)";
        }

        // GET COUNT QUOTES FILTRED

        $this->db->WHERE("$where");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $nb_all_lines = $this->db->count_all_results('ip_invoices');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);

        // GET CALCUL TOTAL

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
        // GET ALL INVOICES FILTRES PAGINATE

        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_invoices.invoice_delai_paiement', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_invoices.user_id', 'left');
        
        $this->db->select("*,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe2");

        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $invoices = $this->db->get("ip_invoices")->result();

        $this->db->where('rappel_type', 'invoice');
        $rappels = $this->db->get('ip_rappel')->result();

        $data = array(
            'invoices' => $invoices,
            'invoice_statuses' => $this->mdl_invoices->statuses(),
            'devises' => $this->db->get("ip_devises")->result(),
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
            'invoices_total_amounts' => $invoices_total_amounts,
            'rappels' => $rappels,
        );
        $this->layout->load_view('invoices/partial_invoice_table', $data);
    }

    public function getInvoiceInfo()
    {
        $this->load->helper('country');
        $invoice_id = $this->input->post('invoice_id');
        $this->db->where("ip_invoices.invoice_id", $invoice_id);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');

        $country = get_country_list(lang('cldr'));

        $invoices = $this->db->get("ip_invoices")->result();

        $this->db->where("invoice_id", $invoice_id);
        $invoice_items = $this->db->get("ip_invoice_items")->result();
        $invoices[0]->invoice_items = $invoice_items;
        $invoices[0]->client_country = $country[$invoices[0]->client_country];
        echo json_encode($invoices);
    }

    public function downloadInvoices()
    {
        $this->load->helper('pdf');
        $invoice_id = $this->input->post('invoice_id');
        $foldername = $this->input->post('folder');
        $folder_app = strtolower($this->session->userdata['licence']);

        generate_invoice_pdf_folder($invoice_id, $foldername);
    }

    public function createZip()
    {
        sleep(3);
        $this->load->helper('pdf');
        $folder_app = strtolower($this->session->userdata['licence']);
        $foldername = $this->input->post('folder');

        $dir_path = './uploads/' . $folder_app . '/temp/' . $foldername;
        if (is_dir($dir_path)) {
            create_zip($dir_path, $dir_path);
            echo $foldername . ".zip";
        }
    }

    public function getDateRelanceinvoice()
    {
        $this->db->select(array('invoice_id', 'date_relance'));
        $this->db->where('date_relance !=', 'NULL');
        $invoice = $this->db->get('ip_invoices')->result();
        echo json_encode($invoice);
    }

    public function getInvoice()
    {
        $this->db->select(array('invoice_id'));
        $invoice = $this->db->get('ip_invoices')->result();
        echo json_encode($invoice);
    }

    public function generate_invoice_pdf($invoice_id, $stream = true, $invoice_template = null)
    {
        $CI = &get_instance();

        $CI->load->model('invoices/mdl_invoices');
        $CI->load->model('invoices/mdl_items');
        $CI->load->model('invoices/mdl_invoice_tax_rates');
        $CI->load->model('delai_paiement/mdl_delai');
        $CI->load->model('families/mdl_families');
        $CI->load->model('devises/mdl_devises');
        $CI->load->model('societes/mdl_societes');
        $CI->load->helper('country');
        $invoice = $CI->mdl_invoices->get_by_id($invoice_id);
        $respdf = $CI->mdl_invoices->getTypepdf();
        $invoice_template = "default";

        $item_familles = $CI->mdl_families->get()->result();
        $societe = $CI->mdl_societes->get_by_id(1);
        $arrayItems = array();
        // foreach ($item_familles as $famille) {
        // array_push($arrayItems, $CI->mdl_items->select('*')
        // ->join('ip_families', 'ip_families.family_id = ip_invoice_items.family_id')
        // ->where('invoice_id', $invoice_id)
        // ->where('ip_invoice_items.family_id', $famille->family_id)
        // ->get()->result());
        // }

        array_push($arrayItems, $CI->db
                ->where('invoice_id', $invoice_id)
                ->join('ip_invoice_item_amounts', 'ip_invoice_item_amounts.item_id = ip_invoice_items.item_id')
                ->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_invoice_items.item_tax_rate_id')
                ->order_by("ip_invoice_items.item_order", "asc")
                ->get('ip_invoice_items')
                ->result());

        $ite = $CI->db->select()->from('ip_invoice_items')->where('invoice_id', $invoice_id)->order_by("ip_invoice_items.item_order", "asc")->get()->result();

        $data = array(
            'typepdf' => $respdf,
            'invoice' => $invoice,
            'countries' => get_country_list(lang('cldr')),
            'societe' => $societe,
            'invoice_tax_rates' => $CI->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
            'items' => $ite,
            'delai' => $CI->mdl_delai->get()->result(),
            'devises' => $CI->mdl_devises->get()->result(),
            'arrayItems' => $arrayItems,
            'output_type' => 'pdf',
        );
        $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/temprelance';
        if (!is_dir($dir_path)) {
            mkdir($dir_path, 0777);
        }

        $html = $CI->load->view('invoice_templates/pdf/' . $invoice_template, $data, true);

        $CI->load->helper('mpdf');
        //return pdf_create($html, lang('invoice') . '_' . str_replace(array('\\', '/'), '_', $invoice->invoice_number), $stream, $invoice->invoice_password);
        return pdf_createrelance(1, $html, lang('invoice') . ' ' . str_replace(array('\\', '/'), '_', $invoice->invoice_number), $stream);

    }

    public function haveinvoice_partial_filter()
    {
        // $this->load->model('invoices/mdl_invoices_avoir');

        $filter_invoice = trim(strtolower(addslashes($this->input->post('filter_invoice'))));
        $filter_user_id = $this->input->post('filter_user_id');
        $filter_date = $this->input->post('filter_date');
        $filter_statuts = $this->input->post('filter_statuts');
        $limit_par_page = $this->input->post('limit_par_page');
        $start_page = $this->input->post('start_page');
        $order_by = $this->input->post('order_by');
        $order_method = $this->input->post('order_method');
        $start_line = (int) ($start_page - 1) * (int) $limit_par_page;

        if ($filter_invoice != "") {
            $where = "((LOWER(ip_haveinvoices.nature) LIKE '%" . $filter_invoice . "%')   ";

            $where .= " OR (LOWER(ip_haveinvoices.invoice_number) LIKE '%" . $filter_invoice . "%' )";

            $where .= " OR (LOWER(ip_clients.client_societe) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_name) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_prenom) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_web) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_phone) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_fax) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_mobile) LIKE '%" . $filter_invoice . "%' )";
            $where .= " OR (LOWER(ip_clients.client_email) LIKE '%" . $filter_invoice . "%' )";
            $where .= " )";
        } else {
            $where = "ip_haveinvoices.invoice_id <> 0 ";
        }
        if ($filter_statuts != "all") {
            $where .= " AND (ip_haveinvoices.invoice_status_id = $filter_statuts)";
        }
        if ($filter_date != "all") {
            $date_deb = $filter_date . "-01-01";
            $date_fin = ($filter_date + 1) . "-01-01";
            $where .= " AND (ip_haveinvoices.invoice_date_created >= '" . $date_deb . "' AND ip_haveinvoices.invoice_date_created < '" . $date_fin . "')";
        }
        if ($filter_user_id != 0) {
            $where .= " AND (ip_haveinvoices.user_id = $filter_user_id)";
        }

        // GET COUNT QUOTES FILTRED

        $this->db->WHERE("$where");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_haveinvoices.client_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_haveinvoices.invoice_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $nb_all_lines = $this->db->count_all_results('ip_haveinvoices');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);

        // GET CALCUL TOTAL

        $this->db->WHERE("$where");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_haveinvoices.client_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_haveinvoices.invoice_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->select("count(ip_haveinvoices.invoice_id) as count,ip_devises.devise_id,SUM(ip_invoice_amounts.invoice_item_subtotal) as invoices_sum_subtotal,SUM(ip_invoice_amounts.invoice_total) as invoices_sum_total");
        $this->db->group_by("ip_devises.devise_id");
        $invoices_total_amounts_db = $this->db->get("ip_haveinvoices")->result();
        $invoices_total_amounts = array();
        if (!empty($invoices_total_amounts_db)) {
            foreach ($invoices_total_amounts_db as $amount) {
                $invoices_total_amounts[$amount->devise_id]["invoices_sum_subtotal"] = $amount->invoices_sum_subtotal;
                $invoices_total_amounts[$amount->devise_id]["invoices_sum_total"] = $amount->invoices_sum_total;
                $invoices_total_amounts[$amount->devise_id]["count"] = $amount->count;
            }
        }
        // Get ALL INVOICES FILTRES PAGINATE

        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_haveinvoices.invoice_id', 'left');
        $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_haveinvoices.invoice_delai_paiement', 'left');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_haveinvoices.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_haveinvoices.user_id', 'left');
       // $this->db->join('ip_haveinvoice_items', 'ip_haveinvoice_items.invoice_id = ip_haveinvoices.invoice_id', 'left');
       // $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_haveinvoice_items.item_tax_rate_id', 'left');

        $this->db->select("*,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe2");
        
        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $invoices = $this->db->get("ip_haveinvoices")->result();
        $this->db->where('rappel_type', 'invoice');
        $rappels = $this->db->get('ip_rappel')->result();

        $data = array(
            'invoices' => $invoices,
            'devises' => $this->db->get("ip_devises")->result(),
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
            'invoices_total_amounts' => $invoices_total_amounts,
            'rappels' => $rappels,
        );

        $this->layout->load_view('invoices/partial_have_invoice_table', $data);

        //        echo "<tr><td colspan='7' style='white-space: initial;'>";
        //
        //        print_r($_POST);
        //
        //        echo "</td></tr>";
    }

    public function saveavoir()
    {
        $this->load->model('clients/mdl_clients');
        $this->load->model('pieces/mdl_pieces');
        $this->load->model('payments/mdl_payments');
        $this->load->model('invoices/mdl_item_amounts');
        $this->load->model('invoices/mdl_invoice_amounts');

        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoices_avoir');
        $this->load->model('item_lookups/mdl_item_lookups');
        $this->load->library('encrypt');
        $this->load->model('products/mdl_products');

        $tax = $this->mdl_tax_rates->get()->result();
        //modif items
        $this->db->where('haveinvoice_id', trim($this->input->post('invoice_id')));
        $this->db->delete('ip_haveinvoice_items');

        $items = json_decode($this->input->post('items'));
        $invoice_id = trim($this->input->post('invoice_idd'));
        //  return var_dump( trim($this->input->post('invoice_idd')));die();
        $data = array( 
            'signature' => $this->input->post('signature'),              
        );

        $this->db->where('haveinvoice_id', trim($this->input->post('invoice_id')));
        $this->db->update('ip_haveinvoices', $data);
        if (count($items) != 0) {
            foreach ($items as $item) {
              //  if ($item->item_code != '') {
                    //insert ds invoices_items
                    $data_itm = array(
                        'invoice_id' => $invoice_id,
                        'haveinvoice_id' => trim($this->input->post('invoice_id')),
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
                    $this->db->insert('ip_haveinvoice_items', $data_itm);
                    $item_id = $this->db->insert_id();
                    $tax = 0;
                    $tax_rates = $this->mdl_tax_rates->get()->result();
                    foreach ($tax_rates as $tvalue) {

                        if ($tvalue->tax_rate_id == $item->item_tax_rate_id) {
                            $tax = $tvalue->tax_rate_percent;
                        }
                    }

                    //insert ds invoice_item_amounts  ,
                    $item_subtotal = $item->item_price * $item->item_quantity;
                    $item_tax_total = $tax * ($item->item_price * $item->item_quantity) / 100;
                    $item_total = ($item->item_price * $item->item_quantity) + ($tax * ($item->item_price * $item->item_quantity) / 100);
                    $data_itm_am = array(
                        'item_id' => $item_id,
                        'item_subtotal' => $item_subtotal,
                        'item_tax_total' => $item_tax_total,
                        'item_total' => $item_total,
                    );
                    $this->db->insert('ip_haveinvoice_item_amounts', $data_itm_am);
              //  }

            }
        }
//modif invoice_amounts
        $this->db->where('haveinvoice_id', trim($this->input->post('invoice_id')));
        $this->db->delete('ip_have_invoice_amounts');
        //  return var_dump(json_decode($this->input->post('items')));die();

        $data_invoice_amounts = array(
            'invoice_id' => $invoice_id,
            'haveinvoice_id' => trim($this->input->post('invoice_id')),
            'invoice_item_subtotal' => $this->input->post('invoice_item_subtotal_final'),
            'invoice_item_tax_total' => $this->input->post('invoice_item_tax_total_final'),
            'invoice_tax_total' => $this->input->post('invoice_item_tax_total_final'),
            'timbre_fiscale' => $this->input->post('timbre_fiscale_span'),
            'invoice_total' => $this->input->post('total_invoice_final'),
            //  'invoice_paid' => $mnt,
            'invoice_balance' => $this->input->post('total_a_payer_invoice'),
            'invoice_pourcent_remise' => $this->input->post('pourcent_remise_invoice'),
            'invoice_pourcent_acompte' => $this->input->post('pourcent_acompte_invoice'),
            'invoice_montant_acompte' => $this->input->post('montant_acompte_invoice'),
            'invoice_item_subtotal_final' => $this->input->post('invoice_item_subtotal_final'),
            'invoice_item_tax_total_final' => $this->input->post('invoice_item_tax_total_final'),
            'invoice_montant_remise' => $this->input->post('montant_remise_invoice'),
        );

        $this->db->insert('ip_have_invoice_amounts', $data_invoice_amounts);

        if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
            $data_log = array(
                "log_action" => "edit_avoir",
                "log_date" => date('Y-m-d H:i:s'),
                "log_ip" => $this->session->userdata['ip_address'],
                "log_user_id" => $this->session->userdata['user_id'],
                "log_field1" => trim($this->input->post('invoice_id')),
            );
            $this->db->insert('ip_logs', $data_log);
        }

        //$this->generate_invoice_pdf($invoice_id, false, null);
        $response = array(
            'success' => 1,
            'invoice_id' => $invoice_id,
        );

        echo json_encode($response);
    }

    public function getItemsByInvoiceavoir()
    {
        $this->load->model('invoices/mdl_items_avoir');

        $id = $this->input->post('invoice_id');
        $this->db->where('haveinvoice_id', $id);
        $items = $this->mdl_items_avoir->get()->result();

        echo json_encode($items);
    }

    public function invoices_to_bl()
    {  
        $this->load->model('products/mdl_stock');
         if (rightsAddFacture()) {
            $this->load->model(
                array(
                    'bl/mdl_bl',
                    'bl/mdl_bl_items',
                    'invoices/mdl_invoices',
                    'invoices/mdl_items',
                  //  'bl/mdl_invoice_tax_rates',
                    'invoices/mdl_invoice_tax_rates',
                    'invoices/mdl_invoice_amounts',
                   // 'bl/mdl_invoice_amounts',
                )
            );
          //  var_dump($this->mdl_bl->run_validation())
          // if ($this->mdl_bl->run_validation()) {
              
                $dt = explode('/', $this->input->post('invoice_date_created'));
                $daat = $dt[2] . '-' . $dt[1] . '-' . $dt[0];
                $dt_d = $this->input->post('invoice_date_due');
                $dat_d = $dt_d[2] . '-' . $dt_d[1] . '-' . $dt_d[0];
                //$invoice_id = $this->mdl_invoices->create(NULL, FALSE); quote_number
                $db_fact = array(
                    'user_id' => $this->input->post('user_id'),
                    'bl_delai_paiement' => $this->input->post('invoice_delai_paiement'),
                    'client_id' => $this->input->post('client_id'),
                  //  'invoice_group_id' => $this->input->post('invoice_group_id'),
                    'bl_nature' => $this->input->post('nature'),
                    'bl_status_id' => 1,
                    'bl_password' => $this->input->post('invoice_password'),
                    'quote_date_created' => $daat,
                    //'invoice_date_modified' => $this->input->post('invoice_date_created'),
                    'quote_date_expires' => $dt_d,
                    'bl_number' =>  $this->input->post('invoice_number'),
                    'bl_terms' => $this->input->post('invoice_terms'),
                    'bl_pdf' => $this->input->post('bl_pdf'),      
                    'langue' => $this->input->post('langue'),                    
                );

                //$this->mdl_invoices->save($db_fact);
                $this->db->insert('ip_bl', $db_fact);
                $bl_id = $this->db->insert_id();
               
                $this->db->where('invoice_id', $this->input->post('invoice_id'));
                $this->db->set('bl_id', $bl_id);
                $this->db->update('ip_invoices');
                $this->mdl_settings->save('next_code_bl', $this->input->post('invoice_number'));
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
                    'bl_total_a_payer' => $this->input->post('bl_balance'),
                    'bl_balance' => $this->input->post('bl_balance'),
                );
              
                $this->db->insert('ip_bl_ammont', $db_fact_amm);

                $quote_items = $this->mdl_items->where('invoice_id', $this->input->post('invoice_id'))->get()->result();
             //   return die('1');
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
                    $this->mdl_stock->stockdeclinaison($quote_item->item_code,$quote_item->item_quantity,$bl_id,1);
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


    public function modal_invoice_to_bl($invoice_id)
    {
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('payment_methods/mdl_payment_methods');

        $result = $this->db->get('ip_bl')->result_array();
        $last_id = @$result[0]['bl_number'];
        $next_id = $this->getNextCodebl($this->mdl_settings->setting('next_code_bl'));
        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'quote_id' => $invoice_id,
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'last_id' => $last_id,
            'next_id' => $next_id,
            'quote' => $this->mdl_invoices->where('ip_invoices.invoice_id', $invoice_id)->get()->row(),
        );

        $this->load->view('invoices/modal_invoice_to_bl', $data);
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
