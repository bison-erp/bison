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
        $this->load->model('quotes/mdl_quote_items');
        $this->load->model('item_lookups/mdl_item_lookups');
        $this->load->model('quotes/mdl_quote_item_amounts');
        $this->load->model('quotes/mdl_quote_amounts');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('activites/mdl_activites');
        $this->load->model('quotes/mdl_rappel');

        $this->load->model('quote_rappel/mdl_quote_rappel');
        $tax = $this->mdl_tax_rates->get()->result();

        $items_count = $this->input->post('items_count');
        $error_items_msg = "";
        $error_items = 0;
        if ($items_count == 0) {
            $error_items_msg = lang('error_nb_ligne');
            $error_items = 1;
        }
   $items = json_decode($this->mdl_quotes->form_values['items']);

        if ($this->mdl_quotes->run_validation() && ($error_items == 0)) {

            if ($this->mdl_quotes->form_values['quote_id']) {
                $tax_rates = $this->mdl_tax_rates->get()->result();
                $quote_id = $this->mdl_quotes->form_values['quote_id'];
                $quote_date_created = $this->mdl_quotes->form_values['quote_date_created'];
                if ($quote_date_created != '') {
                    $quote_date = explode('/', $quote_date_created);
                    $quote_dt = $quote_date[2] . '-' . $quote_date[1] . '-' . $quote_date[0];
                } else {
                    $quote_dt = '';
                }

                $quote_date_expires = @$this->mdl_quotes->form_values['quote_date_expires'];
                if ($quote_date_expires != '') {
                    $quote_date_ex = explode('/', $quote_date_expires);
                    $quote_dt_ex = $quote_date_ex[2] . '-' . $quote_date_ex[1] . '-' . $quote_date_ex[0];
                } else {
                    $quote_dt_ex = '';
                }

                $quote_date_accepte = $this->mdl_quotes->form_values['quote_date_accepte'];
                if ($quote_date_accepte != '') {
                    $date_d_acc = explode('/', $quote_date_accepte);
                    $date_d = $date_d_acc[2] . '-' . $date_d_acc[1] . '-' . $date_d_acc[0];

                } else {
                    $date_d = '';
                }
//modif table quote
                $data = array(
                    'invoice_id' => 0,
                    'invoice_group_id' => 0,
                    'quote_delai_paiement' => $this->mdl_quotes->form_values['quote_delai_paiement'],
                    'quote_nature' => $this->mdl_quotes->form_values['quote_nature'],
                    'quote_password' => $this->mdl_quotes->form_values['quote_password'],
                    'quote_date_created' => $quote_dt,
                    'quote_date_expires' => $quote_dt_ex,
                    'quote_date_accepte' => $date_d,
                    'quote_number' => $this->mdl_quotes->form_values['quote_number'],
                    'notes' => $this->mdl_quotes->form_values['notes'],
                    'quote_status_id' => $this->mdl_quotes->form_values['quote_status_id'],
                    'quote_date_modified' => date('Y-m-j H:i:s'),
                    'client_id' => $this->input->post('client_id'),
                    'document' => $this->input->post('document'),
                    'joindredevis' => $this->input->post('joindredevis'),
                    'signature' => $this->input->post('signature'),
                    'langue' => $this->input->post('langue'),
                );

                $this->db->where('quote_id', $this->mdl_quotes->form_values['quote_id']);
                $this->db->update('ip_quotes', $data);
//modif items
                $this->db->where('quote_id', $this->mdl_quotes->form_values['quote_id']);
                $this->db->delete('ip_quote_items');
                $items = json_decode($this->mdl_quotes->form_values['items']);
                foreach ($items as $item) {
                  //  if ($item->item_code != '') {
                        //insert ds quotes_items
                        $data_itm = array(
                            'quote_id' => $quote_id,
                            'family_id' => $item->family_id,
                            'item_tax_rate_id' => $item->item_tax_rate_id,
                            'item_date_added' => date('Y-m-j'),
                            'item_name' => $item->item_name,
                            'item_description' => $item->item_description,
                            'item_quantity' => $item->item_quantity,
                            'item_price' => $item->item_price,
                            'item_order' => $item->item_order,
                            'item_code' => $item->item_code,
                            'depot_quote' => $item->depot,
                            // 'etat_champ' => $item->etat_champ,
                        );
                        $this->db->insert('ip_quote_items', $data_itm);
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

                        $this->db->insert('ip_quote_item_amounts', $data_itm_am);
                    //}
                }
//modif quote_amounts
                $this->db->where('quote_id', $this->mdl_quotes->form_values['quote_id']);
                $this->db->delete('ip_quote_amounts');

                $data_amm = array(
                    'quote_id' => $quote_id,
                    'quote_item_subtotal' => $this->mdl_quotes->form_values['quote_item_subtotal_final'],
                    'quote_item_tax_total' => $this->mdl_quotes->form_values['quote_item_tax_total_final'],
                    'quote_tax_total' => $this->mdl_quotes->form_values['quote_item_tax_total_final'],
                    'timbre_fiscale' => $this->mdl_quotes->form_values['timbre_fiscale_span'],
                    'quote_total' => $this->mdl_quotes->form_values['total_quote'],
                    'quote_pourcent_remise' => $this->mdl_quotes->form_values['pourcent_remise_quote'],
                    'quote_montant_remise' => $this->mdl_quotes->form_values['montant_remise_quote'],
                    'quote_pourcent_acompte' => $this->mdl_quotes->form_values['pourcent_acompte_quote'],
                    'quote_montant_acompte' => $this->mdl_quotes->form_values['montant_acompte_quote'],
                    'quote_item_subtotal_final' => $this->mdl_quotes->form_values['quote_item_subtotal_final'],
                    'quote_item_tax_total_final' => $this->mdl_quotes->form_values['quote_item_tax_total_final'],
                    'quote_total_final' => $this->mdl_quotes->form_values['total_quote'],
                    'quote_total_a_payer' => $this->mdl_quotes->form_values['total_a_payer_quote'],
                );
                $this->db->insert('ip_quote_amounts', $data_amm);

                if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                    $data_log = array(
                        "log_action" => "edit_quote",
                        "log_date" => date('Y-m-d H:i:s'),
                        "log_ip" => $this->session->userdata['ip_address'],
                        "log_user_id" => $this->session->userdata['user_id'],
                        "log_field1" => $this->mdl_quotes->form_values['quote_id'],
                    );
                    $this->db->insert('ip_logs', $data_log);
                }

                $resdate = $this->mdl_quotes->form_values['date_relance'];
                //  return var_dump($resdate);
                $this->mdl_rappel->updateDateRelance($this->mdl_quotes->form_values['quote_id'], $resdate, 0);

                $arra = array('object_id' => $quote_id, 'typeobject' => 'quote');
                $this->db->delete('ip_document_rappel', $arra);

                $docselectionne = $this->mdl_quotes->form_values['listdocu'];

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
                $this->generate_quote_pdf($quote_id, false, null);
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

    public function save_quote_tax_rate()
    {
        $this->load->model('quotes/mdl_quote_tax_rates');

        if ($this->mdl_quote_tax_rates->run_validation()) {
            $this->mdl_quote_tax_rates->save($this->input->post('quote_id'));

            $response = array(
                'success' => 1,
            );
        } else {
            $response = array(
                'success' => 0,
                'validation_errors' => $this->mdl_quote_tax_rates->validation_errors,
            );
        }

        echo json_encode($response);
    }

    public function getNextCodeDevis($id)
    {
        $this->db->where('quote_number', $id);
        $quote = $this->db->get('ip_quotes')->result();
        if (!empty($quote)) {
            $id++;
            return $this->getNextCodeDevis($id);
        } else {
            return $id;
        }
    }

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
        /* $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/temprelance';
        if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777);
        }
        $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/documents';
        if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777);
        }   */
         if (rightsAddFacture()) {
            $this->load->model('tax_rates/mdl_tax_rates');

            $this->load->model('clients/mdl_clients');
            $this->load->model('payments/mdl_payments');
            $this->load->model('quotes/mdl_quote_items');
            $this->load->model('item_lookups/mdl_item_lookups');
            $this->load->model('quotes/mdl_quote_item_amounts');
            $this->load->model('quotes/mdl_quote_amounts');
            $this->load->model('quotes/mdl_quotes');
            $this->load->model('activites/mdl_activites');
            $this->load->model('quotes/mdl_rappel');

            $items_count = $this->input->post('items_count');
            $error_items_msg = "";
            $error_items = 0;
            if ($items_count == 0) {
                $error_items_msg = lang('error_nb_ligne');
                $error_items = 1;
            }

            if ($this->mdl_quotes->run_validation() && ($error_items == 0)) {

                $tax_rates = $this->mdl_tax_rates->get()->result();
                $quote_date_created = $this->mdl_quotes->form_values['quote_date_created'];
                if ($quote_date_created != '') {
                    $quote_date = explode('/', $quote_date_created);
                    $quote_dt = $quote_date[2] . '-' . $quote_date[1] . '-' . $quote_date[0];
                } else {
                    $quote_dt = '';
                }

                $quote_date_expires = $this->mdl_quotes->form_values['quote_date_expires'];
                if ($quote_date_expires != '') {
                    $quote_date_ex = explode('/', $quote_date_expires);
                    $quote_dt_ex = $quote_date_ex[2] . '-' . $quote_date_ex[1] . '-' . $quote_date_ex[0];
                } else {
                    $quote_dt_ex = '';
                }

                $quote_date_accepte = $this->mdl_quotes->form_values['quote_date_accepte'];
                if ($quote_date_accepte != '') {
                    $date_d_acc = explode('/', $quote_date_accepte);
                    $date_d = $date_d_acc[2] . '-' . $date_d_acc[1] . '-' . $date_d_acc[0];
                } else {
                    $date_d = '';
                }

//insertion ds table quotes
                $items = json_decode($this->mdl_quotes->form_values['items']);
                if ($this->mdl_quotes->form_values['quote_nature'] == '') {
                    $this->mdl_quotes->form_values['quote_nature'] = $items[0]->item_code;
                }
                $valCode_quote = $this->getNextCodeDevis($this->mdl_settings->setting('next_code_devis'));
                $resdate = $this->mdl_quotes->form_values['date_relance'];
                $data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'invoice_id' => 0,
                    'invoice_group_id' => 0,
                    'quote_delai_paiement' => $this->mdl_quotes->form_values['quote_delai_paiement'],
                    'client_id' => $this->mdl_quotes->form_values['client_id'],
                    'quote_nature' => $this->mdl_quotes->form_values['quote_nature'],
                    'quote_password' => $this->mdl_quotes->form_values['quote_password'],
                    'quote_date_created' => $quote_dt,
                    // 'quote_time_created' => date('H:i:s'),
                    'quote_date_expires' => $quote_dt_ex,
                    'quote_date_accepte' => $date_d,
                    'quote_number' => $valCode_quote,
                    'notes' => $this->mdl_quotes->form_values['notes'],
                    'quote_status_id' => $this->mdl_quotes->form_values['quote_status_id'],
                    'document' => $this->mdl_quotes->form_values['document'],
                    'joindredevis' => $this->mdl_quotes->form_values['joindredevis'],
                    'signature' => $this->mdl_quotes->form_values['signature'],
                    'langue' => $this->mdl_quotes->form_values['langue'],
                    'photo' => $this->mdl_quotes->form_values['photo'],
                );

                $this->db->insert('ip_quotes', $data);
                $quote_id = $this->db->insert_id();
                if ($resdate != "") {
                    $date_explode = explode(",", $resdate);
                    for ($i = 0; $i < count($date_explode); $i++) {
                        $data = array('daterappel' => $date_explode[$i], 'type' => 'quote', 'idobject' => $quote_id);
                        $this->db->insert('ip_rappelmail', $data);
                    }
                }

                $this->mdl_settings->save('next_code_devis', $valCode_quote + 1);
                if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                    $data_log = array(
                        "log_action" => "add_quote",
                        "log_date" => date('Y-m-d H:i:s'),
                        "log_ip" => $this->session->userdata['ip_address'],
                        "log_user_id" => $this->session->userdata['user_id'],
                        "log_field1" => $quote_id,
                    );
                    $this->db->insert('ip_logs', $data_log);
                }

//insertion ds quote_ammont

                $data_amm = array(
                    'quote_id' => $quote_id,
                    'quote_item_subtotal' => $this->mdl_quotes->form_values['quote_item_subtotal_final'],
                    'quote_item_tax_total' => $this->mdl_quotes->form_values['quote_item_tax_total_final'],
                    'quote_tax_total' => $this->mdl_quotes->form_values['quote_item_tax_total_final'],
                    'timbre_fiscale' => $this->mdl_quotes->form_values['timbre_fiscale_span'],
                    'quote_total' => $this->mdl_quotes->form_values['total_quote'],
                    'quote_pourcent_remise' => $this->mdl_quotes->form_values['pourcent_remise_quote'],
                    'quote_montant_remise' => $this->mdl_quotes->form_values['montant_remise_quote'],
                    'quote_pourcent_acompte' => $this->mdl_quotes->form_values['pourcent_acompte_quote'],
                    'quote_montant_acompte' => $this->mdl_quotes->form_values['montant_acompte_quote'],
                    'quote_item_subtotal_final' => $this->mdl_quotes->form_values['quote_item_subtotal_final'],
                    'quote_item_tax_total_final' => $this->mdl_quotes->form_values['quote_item_tax_total_final'],
                    'quote_total_final' => $this->mdl_quotes->form_values['total_quote'],
                    'quote_total_a_payer' => $this->mdl_quotes->form_values['total_a_payer_quote'],
                );
                $this->db->insert('ip_quote_amounts', $data_amm);

//insertion ds table itmes
                $items = json_decode($this->mdl_quotes->form_values['items']);
//return var_dump($items);
                foreach ($items as $item) {
                    //if ($item->item_code != '') {
                        //insert ds quotes_items
                        $data_itm = array(
                            'quote_id' => $quote_id,
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
                            'depot_quote' => $item->depot,
                        );
                        $this->db->insert('ip_quote_items', $data_itm);
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

                        $this->db->insert('ip_quote_item_amounts', $data_itm_am);
                  //  }
                }

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
                }
                $this->generate_quote_pdf($quote_id, false, null);
                $response = array(
                    'success' => 1,
                    'quote_id' => $quote_id,
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
    }

    public function createItemQuote()
    {
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('quotes/mdl_quote_items');
        $this->load->model('item_lookups/mdl_item_lookups');
        $quote_id = $this->input->post('quote_id');
        $items = json_decode($this->input->post('items'));
        foreach ($items as $item) {
         //if ($item->item_code) {
                $item->item_quantity = standardize_amount($item->item_quantity);
                $item->item_price = standardize_amount($item->item_price);

                $item_id = ($item->item_id) ?: null;

                $save_item_as_lookup = (isset($item->save_item_as_lookup)) ? $item->save_item_as_lookup : 0;

                unset($item->item_id, $item->save_item_as_lookup);

                $remise_accompte_data = array(
                    'pourcent_remise_quote' => $this->input->post('pourcent_remise_quote'),
                    'montant_remise_quote' => $this->input->post('montant_remise_quote'),
                    'pourcent_acompte_quote' => $this->input->post('pourcent_acompte_quote'),
                    'montant_acompte_quote' => $this->input->post('montant_acompte_quote'),
                    'total_quote_final' => $this->input->post('total_quote_final'),
                    'total_a_payer_quote' => $this->input->post('total_a_payer_quote'),
                    'quote_item_subtotal_final' => $this->input->post('quote_item_subtotal_final'),
                    'quote_item_tax_total_final' => $this->input->post('quote_item_tax_total_final'),
                );
                $arr = $this->mdl_quote_items->save($quote_id, $item_id, $item, $remise_accompte_data);

                if ($save_item_as_lookup) {
                    $db_array = array(
                        'item_name' => $item->item_name,
                        'item_code' => $item->item_code,
                        'item_description' => $item->item_description,
                        'item_price' => $item->item_price,
                        'quote_id' => $quote_id,
                    );

                    $this->mdl_item_lookups->save(null, $db_array);
                }
         //   }
        }

        $response = array(
            'success' => 1,
            'quote_id' => $quote_id,
        );

        echo json_encode($response);
    }

    public function modal_create_quote()
    {
        $this->load->module('layout');

        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');

        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'client_name' => $this->input->post('client_name'),
        );

        $this->layout->load_view('quotes/modal_create_quote', $data);
    }

    public function modal_copy_quote()
    {
        $this->load->module('layout');

        $this->load->model('quotes/mdl_quotes');
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');

        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'quote_id' => $this->input->post('quote_id'),
            'quote' => $this->mdl_quotes->where('ip_quotes.quote_id', $this->input->post('quote_id'))->get()->row(),
        );

        $this->layout->load_view('quotes/modal_copy_quote', $data);
    }

    public function copy_quote()
    {
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('quotes/mdl_quote_items');
        $this->load->model('quotes/mdl_quote_tax_rates');

        if ($this->mdl_quotes->run_validation()) {
            $target_id = $this->mdl_quotes->save();
            $source_id = $this->input->post('quote_id');

            $this->mdl_quotes->copy_quote($source_id, $target_id);

            $response = array(
                'success' => 1,
                'quote_id' => $target_id,
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

    public function modal_quote_to_invoice($quote_id)
    {
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('payment_methods/mdl_payment_methods');

        $result = $this->db->get('`ip_invoices`')->result_array();
        $last_id = @$result[0]['invoice_number'];
        $next_id = $this->getNextCodeFacture($this->mdl_settings->setting('next_code_invoice'));
        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'quote_id' => $quote_id,
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'last_id' => $last_id,
            'next_id' => $next_id,
            'quote' => $this->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->row(),
        );

        $this->load->view('quotes/modal_quote_to_invoice', $data);
    }

    public function quote_to_invoice()
    {
        if (rightsAddFacture()) {
            $this->load->model(
                array(
                    'invoices/mdl_invoices',
                    'invoices/mdl_items',
                    'quotes/mdl_quotes',
                    'quotes/mdl_quote_items',
                    'invoices/mdl_invoice_tax_rates',
                    'quotes/mdl_quote_tax_rates',
                    'quotes/mdl_quote_amounts',
                    'invoices/mdl_invoice_amounts',
                )
            );

            if ($this->mdl_invoices->run_validation()) {
                $dt = explode('/', $this->input->post('invoice_date_created'));
                $daat = $dt[2] . '-' . $dt[1] . '-' . $dt[0];
                $dt_d = $this->input->post('invoice_date_due');
                $dat_d = $dt_d[2] . '-' . $dt_d[1] . '-' . $dt_d[0];
                //$invoice_id = $this->mdl_invoices->create(NULL, FALSE); quote_number
                $db_fact = array(
                    'user_id' => $this->input->post('user_id'),
                    'invoice_delai_paiement' => $this->input->post('invoice_delai_paiement'),
                    'client_id' => $this->input->post('client_id'),
                    'invoice_group_id' => $this->input->post('invoice_group_id'),
                    'nature' => $this->input->post('nature'),
                    'invoice_status_id' => 1,
                    'invoice_password' => $this->input->post('invoice_password'),
                    'invoice_date_created' => $daat,
                    //'invoice_date_modified' => $this->input->post('invoice_date_created'),
                    'invoice_date_due' => $dt_d,
                    'invoice_number' => $this->getNextCodeFacture($this->input->post('invoice_number')),
                    'invoice_terms' => $this->input->post('invoice_terms'),
                    'langue' => $this->input->post('langue'),
                    'recursive' => 0,
                );

                //$this->mdl_invoices->save($db_fact);
                $this->db->insert('ip_invoices', $db_fact);
                $invoice_id = $this->db->insert_id();

                $this->db->where('quote_id', $this->input->post('quote_id'));
                $this->db->set('invoice_id', $invoice_id);
                $this->db->update('ip_quotes');

                //insert ds table invoice_ammont
                $db_fact_amm = array(
                    'invoice_id' => $invoice_id,
                    'invoice_item_subtotal' => $this->input->post('invoice_item_subtotal'),
                    'invoice_item_tax_total' => $this->input->post('invoice_item_tax_total'),
                    'invoice_tax_total' => $this->input->post('invoice_tax_total'),
                    'timbre_fiscale' => $this->input->post('timbre_fiscale'),
                    'invoice_total' => $this->input->post('invoice_total'),
                    'invoice_pourcent_remise' => $this->input->post('invoice_pourcent_remise'),
                    'invoice_montant_remise' => $this->input->post('invoice_montant_remise'),
                    'invoice_pourcent_acompte' => $this->input->post('invoice_pourcent_acompte'),
                    'invoice_montant_acompte' => $this->input->post('invoice_montant_acompte'),
                    'invoice_item_subtotal_final' => $this->input->post('invoice_item_subtotal_final'),
                    'invoice_item_tax_total_final' => $this->input->post('invoice_item_tax_total_final'),
                    //'invoice_total_final' => $this->input->post('invoice_total_final'),
                    'invoice_balance' => $this->input->post('invoice_total_a_payer'),
                );

                $this->db->insert('ip_invoice_amounts', $db_fact_amm);

                $quote_items = $this->mdl_quote_items->where('quote_id', $this->input->post('quote_id'))->get()->result();

                foreach ($quote_items as $quote_item) {
                    $db_array = array(
                        'invoice_id' => $invoice_id,
                        'item_tax_rate_id' => $quote_item->item_tax_rate_id,
                        'item_name' => $quote_item->item_name,
                        'item_code' => $quote_item->item_code,
                        'item_description' => $quote_item->item_description,
                        'item_quantity' => $quote_item->item_quantity,
                        'item_price' => $quote_item->item_price,
                        'item_order' => $quote_item->item_order,
                    );
                    $this->db->insert('ip_invoice_items', $db_array);
                    $id_item = $this->db->insert_id();
                    $db_array2 = array(
                        'item_id' => $id_item,
                        'item_subtotal' => $quote_item->item_subtotal,
                        'item_tax_total' => $quote_item->item_tax_total,
                        'item_total' => $quote_item->item_total,
                    );
                    $this->db->insert('ip_invoice_item_amounts', $db_array2);
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
                        "log_action" => "quote_to_invoice",
                        "log_date" => date('Y-m-d H:i:s'),
                        "log_ip" => $this->session->userdata['ip_address'],
                        "log_user_id" => $this->session->userdata['user_id'],
                        "log_field1" => $this->input->post('quote_id'),
                        "log_field2" => $invoice_id,
                    );
                    $this->db->insert('ip_logs', $data_log);
                }

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

            echo json_encode($response);
        }
    }

    public function getDateRappelQuote()
    {

        $id_object = $this->input->post('id_object');
        $this->db->where('rappel_object_id', $id_object);
        $this->db->where('rappel_type', 'quote');
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
        $this->db->where('rappel_type', 'quote');
        $this->db->delete('ip_rappel');

        foreach ($arrayDates as $date) {
            $arrayRappel = array(
                'rappel_status' => 0,
                'rappel_date' => date_to_mysql($date),
                'rappel_type' => 'quote',
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
        $this->db->where('rappel_type', 'quote');
        $this->db->delete('ip_rappel');
        $response = array(
            'success' => 1,
        );
        echo json_encode($response);
    }

    public function getItemsByQuote()
    {
        $this->load->model('quotes/mdl_quote_items');

        $id = $this->input->post('quote_id');
        $this->db->where('quote_id', $id);
        $items = $this->mdl_quote_items->get()->result();

        echo json_encode($items);
    }

    public function load_quotes_partial_filter()
    {
        $filter_quote = trim(strtolower(addslashes($this->input->post('filter_quote'))));
        $filter_user_id = $this->input->post('filter_user_id');
        $filter_date = $this->input->post('filter_date');
        $filter_statuts = $this->input->post('filter_statuts');
        $limit_par_page = $this->input->post('limit_par_page');
        $start_page = $this->input->post('start_page');
        $order_by = $this->input->post('order_by');
        $order_method = $this->input->post('order_method');
        $start_line = (int) ($start_page - 1) * (int) $limit_par_page;
        $where = "ip_quotes.delete <> 1 ";
        if ($filter_quote != "") {
            $where .= "AND ((LOWER(ip_quotes.quote_nature) LIKE '%" . $filter_quote . "%') ";

            $where .= " OR (LOWER(ip_quotes.quote_number) LIKE '%" . $filter_quote . "%' )";

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
            $where .= " AND (ip_quotes.quote_status_id = $filter_statuts)";
        }
        if ($filter_date != "all") {
            $date_deb = $filter_date . "-01-01";
            $date_fin = ($filter_date + 1) . "-01-01";
            $where .= " AND (ip_quotes.quote_date_created >= '" . $date_deb . "' AND ip_quotes.quote_date_created < '" . $date_fin . "')";
        }
        if ($filter_user_id != 0) {
            $where .= " AND (ip_quotes.user_id = $filter_user_id)";
        }

        $this->load->model('quotes/mdl_quotes');
        $this->load->model('quote_rappel/mdl_quote_rappel');

        // GET COUNT QUOTES FILTRED

        $this->db->WHERE("$where");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $nb_all_lines = $this->db->count_all_results('ip_quotes');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);

        // GET CALCUL TOTAL

        $this->db->WHERE("$where");
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->select("count(ip_quotes.quote_id) as count,ip_devises.devise_id,SUM(ip_quote_amounts.quote_item_subtotal) as quotes_sum_subtotal,SUM(ip_quote_amounts.quote_total_final) as quotes_sum_total");
        $this->db->group_by("ip_devises.devise_id");
        $quotes_total_amounts_db = $this->db->get("ip_quotes")->result();
        $quotes_total_amounts = array();
        if (!empty($quotes_total_amounts_db)) {
            foreach ($quotes_total_amounts_db as $amount) {
                $quotes_total_amounts[$amount->devise_id]["quotes_sum_subtotal"] = $amount->quotes_sum_subtotal;
                $quotes_total_amounts[$amount->devise_id]["quotes_sum_total"] = $amount->quotes_sum_total;
                $quotes_total_amounts[$amount->devise_id]["count"] = $amount->count;
            }
        }
        // GET ALL QUOTES FILTRES PAGINATE

        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_delai_paiement', 'ip_delai_paiement.delai_paiement_id = ip_quotes.quote_delai_paiement', 'left');
        $this->db->join('ip_users', 'ip_users.user_id = ip_quotes.user_id', 'left');
        $this->db->select("*,(case when trim(ip_clients.client_societe) = '' then ip_clients.client_name else ip_clients.client_societe end) as client_societe2");

        $this->db->WHERE("$where");
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by(TRIM($order_by), $order_method);
        $quotes = $this->db->get("ip_quotes")->result();

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
        $this->layout->load_view('quotes/partial_quote_table', $data);
    }

    public function getQuoteInfo()
    {
        $this->load->helper('country');
        $quote_id = $this->input->post('quote_id');
        $this->db->where("ip_quotes.quote_id", $quote_id);
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $this->db->join('ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');

        $country = get_country_list(lang('cldr'));

        $quotes = $this->db->get("ip_quotes")->result();

        $this->db->where("ip_quote_items.quote_id", $quote_id);
        $quote_items = $this->db->get("ip_quote_items")->result();
        $quotes[0]->quote_items = $quote_items;
        $quotes[0]->client_country = $country[$quotes[0]->client_country];

        echo json_encode($quotes);
    }

    public function export_excel()
    {
        echo "test";
    }

    public function modal_change_statut($type)
    {
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('invoices/mdl_invoices');
        $quote_id = $this->input->post('quote_id');
        if ($type == 0) {
            $this->db->where("quote_id", $quote_id);
            $quote = $this->db->get("ip_quotes")->result();
        } else {
            $this->db->where("invoice_id", $quote_id);
            $quote = $this->db->get("ip_invoices")->result();
        }       

        $data = array();
        if ($type == 0) {
            $data['quote_statuses'] = $this->mdl_quotes->statuses();          
        } else {
            $data['quote_statuses'] = $this->mdl_invoices->statuses();         
        }
        $data['quote'] = $quote[0];
        $data['type'] = $type;
        $this->load->view('quotes/modal_change_statut', $data);
    }

    public function updateStatutQuote()
    {
        $id_selected_statut = $this->input->post('id_selected_status');
        $quote_id = $this->input->post('id_quote');
        $type = $this->input->post('type');
        $data_accepte = $this->input->post('data_accepte');

        $this->db->select('client_id');
        $this->db->where('quote_id', $quote_id);
        $getclient = $this->db->get('ip_quotes')->result();

        // return die('hh'.$id_selected_statut.'hh'.$quote_id.'hh'.$type.'hh'.$data_accepte.'h'.$getclient[0]->client_id);
        if ($data_accepte) {
            $date_insert = date_to_mysql($data_accepte);
        }
        if ($type == 0) {
            if ($id_selected_statut == 4 && $data_accepte) {
                $data_client = array(
                    'client_type' => '1',
                    'date_creation_client' => date('Y-m-d'),
                );
                $this->db->where('client_id', $getclient[0]->client_id);
                $this->db->update('ip_clients', $data_client);

                $data_update = array(
                    'quote_date_accepte' => $date_insert,
                    'quote_status_id' => $id_selected_statut,
                );
            } else {
                $data_client = array(
                    'client_type' => '0',
                    'date_creation_client' => 'NULL',
                );
                $this->db->where('client_id', $getclient[0]->client_id);
                $this->db->update('ip_clients', $data_client);
                $data_update = array(
                    'quote_status_id' => $id_selected_statut,
                );
            }
            $this->db->where("quote_id", $quote_id);

            $this->db->update("ip_quotes", $data_update);
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

    public function getDateRelance()
    {

        $this->db->select(array('quote_id', 'date_relance'));
        $this->db->where('date_relance !=', 'NULL');
        $quote = $this->db->get('ip_quotes')->result();
        echo json_encode($quote);
    }

    public function updateDateRelanceinvoice($tab)
    {

        $this->db->select(array('quote_id', 'date_relance'));
        $this->db->where('date_relance !=', 'NULL');
        $quote = $this->db->get('ip_quotes')->result();
        echo json_encode($quote);
    }

    public function getAllquote()
    {
        $this->db->select(array('quote_id'));
        $quote = $this->db->get('ip_quotes')->result();
        echo json_encode($quote);
    }

    public function generate_quote_pdf($quote_id, $stream = true, $quote_template = null)
    {
        $CI = &get_instance();
        $CI->load->model('quotes/mdl_quotes');
        $CI->load->model('quotes/mdl_quote_items');
        $CI->load->model('quotes/mdl_quote_tax_rates');
        $CI->load->model('families/mdl_families');
        $CI->load->model('societes/mdl_societes');
        $CI->load->model('devises/mdl_devises');
        $CI->load->helper('country');
        $quote = $CI->mdl_quotes->get_by_id($quote_id);
        $societe = $CI->mdl_societes->get_by_id(1);

        $quote_template = "default";

        $item_familles = $CI->mdl_families->get()->result();
        $arrayItems = array();
        array_push($arrayItems, $CI->db
                ->where('quote_id', $quote_id)
                ->join('ip_quote_item_amounts', 'ip_quote_item_amounts.item_id = ip_quote_items.item_id')
                ->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_quote_items.item_tax_rate_id')
                ->order_by("ip_quote_items.item_order", "asc")
                ->get('ip_quote_items')
                ->result());
        $ite = $CI->db->select()->from('ip_quote_items')->where('quote_id', $quote_id)->order_by("ip_quote_items.item_order", "asc")->get()->result();
        $respdf = $CI->mdl_quotes->getTypepdf();
        $data = array(
            'typepdf' => $respdf,
            'quote' => $quote,
            'countries' => get_country_list(lang('cldr')),
            'societe' => $societe,
            'quote_tax_rates' => $CI->mdl_quote_tax_rates->where('quote_id', $quote_id)->get()->result(),
            'items' => $ite,
            'devises' => $CI->mdl_devises->get()->result(),
            'arrayItems' => $arrayItems,
            'output_type' => 'pdf',
        );
        $quote->notes = str_replace("\n", "<br>", $quote->notes);
        $quote->notes = str_replace("\r", "<br>", $quote->notes);
        $dir_path = './uploads/' . strtolower($this->session->userdata['licence']) . '/temprelance';
        if (!is_dir($dir_path)) {
            mkdir($dir_path, 0777);
        }
        $html = $CI->load->view('quote_templates/pdf/' . $quote_template, $data, true);
        $CI->load->helper('mpdf');
        return pdf_createrelance(0, $html, lang('quote') . ' ' . str_replace(array('\\', '/'), '_', $quote->quote_number), $stream, $quote->quote_password);

    }


    public function quote_to_bl()
    {
         if (rightsAddFacture()) {
            $this->load->model(
                array(
                    'bl/mdl_bl',
                    'bl/mdl_bl_items',
                    'quotes/mdl_quotes',
                    'quotes/mdl_quote_items',
                  //  'bl/mdl_invoice_tax_rates',
                    'quotes/mdl_quote_tax_rates',
                    'quotes/mdl_quote_amounts',
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

                $this->db->where('quote_id', $this->input->post('quote_id'));
                $this->db->set('bl_id', $bl_id);
                $this->db->update('ip_quotes');
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
                    'bl_total_a_payer' => $this->input->post('invoice_total_a_payer'),
                    'bl_balance' => $this->input->post('invoice_total_a_payer'),

                );

                $this->db->insert('ip_bl_ammont', $db_fact_amm);

                $quote_items = $this->mdl_quote_items->where('quote_id', $this->input->post('quote_id'))->get()->result();
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


    public function modal_quote_to_bl($quote_id)
    {
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('payment_methods/mdl_payment_methods');

        $result = $this->db->get('ip_bl')->result_array();
        $last_id = @$result[0]['bl_number'];
        $next_id = $this->getNextCodebl($this->mdl_settings->setting('next_code_bl'));
        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'quote_id' => $quote_id,
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'last_id' => $last_id,
            'next_id' => $next_id,
            'quote' => $this->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->row(),
        );

        $this->load->view('quotes/modal_quote_to_bl', $data);
    }

    public function modal_quote_to_fabrication($quote_id)
    {
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('payment_methods/mdl_payment_methods');

        $result = $this->db->get('`ip_fabrication`')->result_array();
        $last_id = @$result[0]['fabrication_number'];
        $valCode_quote = (int)$this->mdl_settings->setting('next_code_bf');
        $res=$valCode_quote+1;
        $next_id = $this->mdl_settings->save('next_code_bf',$res);        
        $data = array(
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'quote_id' => $quote_id,
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'last_id' => $last_id,
            'next_id' => $res,
            'quote' => $this->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->row(),
        );

        $this->load->view('quotes/modal_quote_to_fabrication', $data);
    }

    public function quote_to_fabrication()
    {
       
          if (rightsAddFacture()) {
            $this->load->model(
                array(
                    'bl/mdl_bl',
                    'bl/mdl_bl_items',
                    'quotes/mdl_quotes',
                    'quotes/mdl_quote_items',
                  //  'bl/mdl_invoice_tax_rates',
                    'quotes/mdl_quote_tax_rates',
                    'quotes/mdl_quote_amounts',
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
                    'fabrication_delai_paiement' => $this->input->post('invoice_delai_paiement'),
                    'client_id' => $this->input->post('client_id'),
                  //  'invoice_group_id' => $this->input->post('invoice_group_id'),
                    'fabrication_nature' => $this->input->post('nature'),
                    'fabrication_status_id' => 1,
                    'fabrication_password' => $this->input->post('invoice_password'),
                    'quote_date_created' => $daat,
                    //'invoice_date_modified' => $this->input->post('invoice_date_created'),
                    'quote_date_expires' => $dt_d,
                    'fabrication_number' =>  $this->input->post('invoice_number'),
                    'quote_id' => $this->input->post('quote_id'),
                    'quote_number' => $this->input->post('quote_number'),
                    'langue' => $this->input->post('langue'),
                );

                //$this->mdl_invoices->save($db_fact);
                $this->db->insert('ip_fabrication', $db_fact);
                $fabrication_id = $this->db->insert_id();

                $this->db->where('quote_id', $this->input->post('quote_id'));
                $this->db->set('fabrication_id', $fabrication_id);
                $this->db->update('ip_quotes');
                $this->mdl_settings->save('next_code_bf', $this->input->post('invoice_number'));
                //insert ds table bl_ammont
                $db_fact_amm = array(
                    'fabrication_id' => $fabrication_id,
                    'fabrication_item_subtotal' => $this->input->post('invoice_item_subtotal'),
                    'fabrication_item_tax_total' => $this->input->post('invoice_item_tax_total'),
                    'fabrication_tax_total' => $this->input->post('invoice_tax_total'),
                    'timbre_fiscale' => $this->input->post('timbre_fiscale'),
                    'fabrication_total' => $this->input->post('invoice_total'),
                    'fabrication_pourcent_remise' => $this->input->post('invoice_pourcent_remise'),
                    'fabrication_montant_remise' => $this->input->post('invoice_montant_remise'),
                    'fabrication_pourcent_acompte' => $this->input->post('invoice_pourcent_acompte'),
                    'fabrication_montant_acompte' => $this->input->post('invoice_montant_acompte'),
                    'fabrication_item_subtotal_final' => $this->input->post('invoice_item_subtotal_final'),
                    'fabrication_item_tax_total_final' => $this->input->post('invoice_item_tax_total_final'),
                    'fabrication_total_final' => $this->input->post('invoice_total_final'),
                    'fabrication_total_a_payer' => $this->input->post('invoice_total_a_payer'),

                );

                $this->db->insert('ip_fabrication_ammont', $db_fact_amm);

                $quote_items = $this->mdl_quote_items->where('quote_id', $this->input->post('quote_id'))->get()->result();
             //   return die('1');
                foreach ($quote_items as $quote_item) {
                    $db_array = array(
                        'fabrication_id' => $fabrication_id,
                        'item_tax_rate_id' => $quote_item->item_tax_rate_id,
                        'item_name' => $quote_item->item_name,
                        'item_code' => $quote_item->item_code,
                        'item_description' => $quote_item->item_description,
                        'item_quantity' => $quote_item->item_quantity,
                        'item_price' => $quote_item->item_price,
                        'item_order' => $quote_item->item_order,
                    );
                    $this->db->insert('ip_fabrication_items', $db_array);
                    $id_item = $this->db->insert_id();
                    $db_array2 = array(
                        'item_id' => $id_item,
                        'item_subtotal' => $quote_item->item_subtotal,
                        'item_tax_total' => $quote_item->item_tax_total,
                        'item_total' => $quote_item->item_total,
                    );
                    $this->db->insert('ip_fabrication_item_amounts', $db_array2);
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
                        "log_action" => "fabrication_to_bl",
                        "log_date" => date('Y-m-d H:i:s'),
                        "log_ip" => $this->session->userdata['ip_address'],
                        "log_user_id" => $this->session->userdata['user_id'],
                        "log_field1" => $this->input->post('quote_id'),
                        "log_field2" => $fabrication_id,
                    );
                    $this->db->insert('ip_logs', $data_log);
                }

                $response = array(
                    'success' => 1,
                    'invoice_id' => $fabrication_id,
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