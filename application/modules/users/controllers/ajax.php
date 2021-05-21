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

    public function save_user_client()
    {

        $user_id = $this->input->post('user_id');
        $client_name = $this->input->post('client_name');

        $this->load->model('clients/mdl_clients');
        $this->load->model('users/mdl_user_clients');

        $client = $this->mdl_clients->where('client_name', $client_name)->get();

        if ($client->num_rows() == 1) {
            $client_id = $client->row()->client_id;

            // Is this a new user or an existing user?
            if ($user_id) {
                // Existing user - go ahead and save the entries

                $user_client = $this->mdl_user_clients->where('ip_user_clients.user_id', $user_id)->where('ip_user_clients.client_id', $client_id)->get();

                if (!$user_client->num_rows()) {
                    $this->mdl_user_clients->save(null, array('user_id' => $user_id, 'client_id' => $client_id));
                }
            } else {
                // New user - assign the entries to a session variable until user record is saved
                $user_clients = ($this->session->userdata('user_clients')) ? $this->session->userdata('user_clients') : array();

                $user_clients[$client_id] = $client_id;
                /* $user_clients[$user_email] = $user_email;
                $user_clients[$user_name] = $user_name; */

                $this->session->set_userdata('user_clients', $user_clients);
            }
        }
    }

    public function load_user_client_table()
    {
        if ($session_user_clients = $this->session->userdata('user_clients')) {
            $this->load->model('clients/mdl_clients');

            $data = array(
                'id' => null,
                'user_clients' => $this->mdl_clients->where_in('ip_clients.client_id', $session_user_clients)->get()->result(),
            );
        } else {
            $this->load->model('users/mdl_user_clients');

            $data = array(
                'id' => $this->input->post('user_id'),
                'user_clients' => $this->mdl_user_clients->where('ip_user_clients.user_id', $this->input->post('user_id'))->get()->result(),
            );
        }

        $this->layout->load_view('users/partial_user_client_table', $data);
    }

    public function modal_users_lookup()
    {
        $users_id = $this->input->post('users');
        $this->load->model('users/mdl_users'); 
        
        $users = $this->mdl_users->where_not_in('ip_users.user_id', $users_id)->get()->result();        
        
        $data['users']=$users;
        $data['id']=$users_id;
        $this->layout->load_view('users/modal_remove_user', $data);
    }

    public function delete()
    {
        $users_id = $this->input->post('users_id'); 
        $users_selectt_id = $this->input->post('users_selectt');     
       
        $data_update = array(
             
            'user_active' => 2,
        );
        $data_updateuser_id = array(             
            'user_id' => $users_selectt_id,
        );
        $data_update_dep = array(             
            'id_user' => $users_selectt_id,
        );
        $this->db->where("user_id", $users_id);
        $this->db->update("ip_users", $data_update);

        $this->db->where("user_id", $users_id);
        $this->db->update("ip_quotes", $data_updateuser_id);

        $this->db->where("user_id", $users_id);
        $this->db->update("ip_commande", $data_updateuser_id);

        $this->db->where("user_id", $users_id);
        $this->db->update("ip_bl", $data_updateuser_id);

        $this->db->where("id_user", $users_id);
        $this->db->update("ip_depense", $data_update_dep);

        $this->db->where("user_id", $users_id);
        $this->db->update("ip_invoices", $data_updateuser_id);

        $this->db->where("user_id", $users_id);
        $this->db->update("ip_clients", $data_updateuser_id);
             
        $data = array( 
            'id_users' => $users_id,
            'date_delete' => date('Y-m-d H:i:s'),
            'users_selectionne' => $users_selectt_id,
        );
        $this->db->insert('ip_users_delete', $data);
       
    }

}