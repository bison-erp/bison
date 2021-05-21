<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ajax extends Admin_Controller
{

    public $ajax_controller = true;

    public function name_query()
    {
        // Load the model
        $this->load->model('clients/mdl_clients');

        // Get the post input
        $query = $this->input->post('query');

        $clients = $this->mdl_clients->select('client_name, client_prenom')->like('client_name', $query)->or_like('client_prenom', $query)->order_by('client_name')->get(array(), false)->result();

        $response = array();

        foreach ($clients as $client) {
            $response[] = $client->client_name . ' ' . $client->client_prenom;
        }

        echo json_encode($response);
    }

    public function name_query_id()
    {
        // Load the model
        $this->load->model('clients/mdl_clients');

        // Get the post input
        $query = $this->input->post('query');

        $clients = $this->mdl_clients->select('client_id, client_name, client_prenom')->like('client_name', $query)->or_like('client_prenom', $query)->order_by('client_name')->get(array(), false)->result();

        $response = array();

        foreach ($clients as $client) {
            $response['nom'] = $client->client_name . ' ' . $client->client_prenom;
            $response['id'] = $client->client_id;
        }

        echo json_encode($response);
    }

    public function save_client_note()
    {
        $this->load->model('clients/mdl_client_notes');
        $this->load->model('activites/mdl_activites');
        $this->load->model('clients/mdl_clients');

        if ($this->mdl_client_notes->run_validation()) {
            $client = $this->mdl_clients->where('ip_clients.client_id', $this->input->post('client_id'))->get()->result();

            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
                $data_log = array(
                    "log_action" => "add_client_note",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                    "log_field1" => $this->input->post('client_id'),
                    "log_field2" => $this->input->post('client_note'),
                );
                $this->db->insert('ip_logs', $data_log);
            }
            $data_note = array(
                'client_id' => $this->input->post('client_id'),
                'client_note_date' => date('Y-m-d H:i:s'),
                'adr_ip' => $this->input->post('adr_ip'),
                'usr' => $this->input->post('usr'),
                'id_usr' => $this->input->post('id_usr'),
                'drap' => $this->input->post('drap'),
                'client_note' => $this->input->post('client_note'),
            );

            $this->db->insert('ip_client_notes', $data_note);
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

    public function load_client_notes()
    {
        $this->load->model('clients/mdl_client_notes');

        $data = array(
            'client_notes' => $this->mdl_client_notes->where('client_id', $this->input->post('client_id'))->get()->result(),
        );

        $this->layout->load_view('clients/partial_notes', $data);
    }

    public function load_client_details()
    {
        $this->load->model('clients/mdl_clients');

        // Get the post input
        $query = $this->input->post('query');
        $devise_symbole = $this->input->post('devise_symbole');

        $clients = $this->mdl_clients->select('client_name, client_prenom, client_address_1, client_city, client_zip, client_country, client_societe, client_titre, client_id, client_tax_code, client_vat_id, devise_symbole')->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left')->where('client_id', intval($query))->get(array(), false)->result();

        $response = array();

        foreach ($clients as $client) {
            $response['client_name'] = $client->client_name;
            $response['client_prenom'] = $client->client_prenom;
            $response['client_address_1'] = $client->client_address_1;
            $response['client_city'] = $client->client_city;
            $response['client_zip'] = $client->client_zip;
            $response['client_country'] = $client->client_country;

            $response['client_societe'] = $client->client_societe;
            $response['client_titre'] = $client->client_titre;
            $response['client_id'] = $client->client_id;
            $response['client_vat_id'] = $client->client_vat_id;
            $response['client_tax_code'] = $client->client_tax_code;
            $response['montant_zero'] = format_devise(0, $client->client_devise_id);
            $response['devise_symbole'] = $client->devise_symbole;
            $response['montant_timbre'] = format_devise($this->mdl_settings->setting('default_item_timbre'), $client->client_devise_id);
        }

        echo json_encode($response);
    }

    public function modal_client_lookup()
    {
        $filter_client = $this->input->get('filter_client');
        $type_doc = $this->input->post('type_doc');
        $action = $this->input->post('action');
        $this->load->model('mdl_clients');

        if (!empty($filter_client)) {
            $clients = $this->mdl_clients->by_client($filter_client);
        }
        $clients = $this->mdl_clients->get();
        $clients = $this->mdl_clients->result();

        $data = array(
            'clients' => $clients,
            'filter_client' => $filter_client,
            'type_doc' => $type_doc,
            'action' => $action,
        );

        $this->layout->load_view('clients/modal_client_lookup', $data);
    }

    public function partial_modal_client_lookup()
    {
        $filter_client = $this->input->get('filter_client');

        $this->load->model('mdl_clients');

        if (!empty($filter_client)) {
            $clients = $this->mdl_clients->by_client($filter_client);
        }
        $clients = $this->mdl_clients->get();
        $clients = $this->mdl_clients->result();

        $data = array(
            'clients' => $clients,
            'filter_client' => $filter_client,
        );
        $this->layout->load_view('clients/partial_modal_client_lookup', $data);
    }

    public function process_client_selection()
    {
        $this->load->model('mdl_clients');
        $this->load->model('mdl_settings');

        $query = $this->input->post('client_ids');

        $clients = $this->mdl_clients->select('*')->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left')->where('client_id', intval($query))->get(array(), false)->result();

        $clients[0]->client_state = format_devise($this->mdl_settings->setting('default_item_timbre'), $clients[0]->client_devise_id);
        if ($clients[0]->timbre_fiscale == 1) {
            $timbre = $this->mdl_settings->setting('default_item_timbre');
        } else {
            $timbre = 0;
        }
        $this->db->where("id_client", $clients[0]->client_id);
        $this->db->join('ip_users', 'ip_users.user_id = ip_client_documents.user_id', 'left');
        $documents = $this->db->get("ip_client_documents")->result();
        $response = array(
            'clients' => $clients,
            'timbre' => $timbre,
            'documents' => $documents,
        );
        //echo json_encode($clients);
        echo json_encode($response);
    }

    public function modal_client_add()
    {
        $this->load->model('mdl_clients');

        if ($this->input->post('btn_cancel')) {
            redirect('clients');
        }
        $type_doc = $this->input->post('type_doc');
        $this->load->model('devises/mdl_devises');
        $this->load->helper('country');

        $data = array(
            'devises' => $this->mdl_devises->get()->result(),
            'countries' => get_country_list(lang('cldr')),
            'type_doc' => $type_doc,
        );
        $this->layout->load_view('clients/modal_client_add', $data);
    }

    public function create()
    {
        $this->load->model('clients/mdl_clients');

        if ($this->mdl_clients->run_validation()) {

            $client_id = $this->mdl_clients->save();

            $response = array(
                'success' => 1,
                'client_id' => $client_id,
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

    public function supp_note()
    {
        $this->load->model('clients/mdl_client_notes');
        $this->load->model('activites/mdl_activites');
        $this->load->model('clients/mdl_clients');
        $id_n = $this->input->post('id');
        $client_notes = $this->mdl_client_notes->where('client_note_id', $id_n)->get()->result();
        $id_cl = $client_notes[0]->client_id;
        $client = $this->mdl_clients->where('ip_clients.client_id', $id_cl)->get()->result();
        if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == false) {
            $data_log = array(
                "log_action" => "delete_client_note",
                "log_date" => date('Y-m-d H:i:s'),
                "log_ip" => $this->session->userdata['ip_address'],
                "log_user_id" => $this->session->userdata['user_id'],
                "log_field1" => $client_notes[0]->client_id,
                "log_field2" => $client_notes[0]->client_note,
            );
            $this->db->insert('ip_logs', $data_log);
        }

        $this->db->where('client_note_id', $id_n);
        $this->db->delete('ip_client_notes');
        $response = array(
            'success' => 1,
        );
        echo json_encode($response);
    }

    public function getClientSolde($client_id = null)
    {
        if ($client_id) {

            $this->db->WHERE("ip_clients.client_id", $client_id);
            $this->db->WHERE("ip_payments.payment_id <> ''");

            $this->db->join('ip_payments', 'ip_payments.client_id = ip_clients.client_id', 'left');
            $this->db->join('ip_invoices', 'ip_invoices.invoice_id = ip_payments.invoice_id', 'left');
            $this->db->group_by("ip_payments.payment_id");
            $this->db->select("ip_clients.client_id,ip_payments.*");
            $result_credit = $this->db->get('ip_clients')->result();

            $this->db->WHERE("ip_clients.client_id", $client_id);
            $this->db->WHERE("ip_invoices.invoice_id <> ''");
            $this->db->join('ip_invoices', 'ip_invoices.client_id = ip_clients.client_id', 'left');
            $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
            $this->db->select("ip_clients.client_id,ip_invoices.invoice_date_created,ip_invoice_amounts.*");
            $result_debit = $this->db->get('ip_clients')->result();

            $total_debit = 0;
            $total_credit = 0;

            if (!empty($result_debit)) {
                foreach ($result_debit as $debit) {
                    $total_debit += $debit->invoice_total;
                }
            }
            if (!empty($result_credit)) {
                foreach ($result_credit as $credit) {

                    $total_credit += $credit->payment_amount;
                }
            }
            $solde_client = $total_credit - $total_debit;
            return $solde_client;
        } else {
            return 0;
        }
    }

    public function load_clients_partial_filter()
    {
        $filter_client = $this->input->post('filter_client');
        $filter_client = trim(strtolower(addslashes($this->input->post('filter_client'))));
        $filter_statut = $this->input->post('filter_statut');

        $limit_par_page = $this->input->post('limit_par_page');
        $start_page = $this->input->post('start_page');
        $order_by = $this->input->post('order_by');
        $order_method = $this->input->post('order_method');
        $start_line = (int) ($start_page - 1) * (int) $limit_par_page;
        if ($filter_client != "") {
            $where = "(LOWER(ip_clients.client_name) LIKE '%" . $filter_client . "%' "
                . "OR LOWER(ip_clients.client_prenom) LIKE '%" . $filter_client . "%' "
                . "OR LOWER(ip_clients.client_web) LIKE '%" . $filter_client . "%' "
                . "OR LOWER(ip_clients.client_societe) LIKE '%" . $filter_client . "%' "
                . "OR LOWER(ip_clients.client_phone) LIKE '%" . $filter_client . "%' "
                . "OR LOWER(ip_clients.client_fax) LIKE '%" . $filter_client . "%' "
                . "OR LOWER(ip_clients.client_mobile) LIKE '%" . $filter_client . "%' "
                . "OR LOWER(ip_clients.client_email) LIKE '%" . $filter_client . "%' "
                . ")";
        } else {
            $where = "ip_clients.client_id <> 0";
        }

        $where .= " AND (ip_clients.delete = 0)";

        if ($filter_statut != "a") {
            $where .= " AND (ip_clients.client_type = $filter_statut)";
        }
        $this->db->WHERE("$where");

        $nb_all_lines = $this->db->count_all_results('ip_clients');
        $nb_pages = ceil($nb_all_lines / $limit_par_page);

        $this->db->select("ip_clients.*,ip_devises.*");
        $this->db->from('ip_clients');
        $this->db->limit($limit_par_page, $start_line);
        $this->db->order_by($order_by, $order_method);
        $this->db->WHERE("$where");
        $this->db->group_by('ip_clients.client_id');
        $this->db->join('ip_invoices', 'ip_invoices.client_id = ip_clients.client_id', 'left');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');

        $clients = $this->db->get()->result();
        $clients_f = array();
        foreach ($clients as $client) {
            $client->solde = $this->getClientSolde($client->client_id);
            array_push($clients_f, $client);
        }
//print_r($clients);

        $data = array(
            'records' => $clients,
            'nb_pages' => $nb_pages,
            'start_page' => $start_page,
            'nb_all_lines' => $nb_all_lines,
            'start_line' => $start_line,
        );

        $this->layout->load_view('clients/partial_client_table', $data);
    }

    public function getContact()
    {
        $this->db->select(array('client_id'));
        $contactlist = $this->db->get('ip_clients')->result();
        echo json_encode($contactlist);
    }
}
