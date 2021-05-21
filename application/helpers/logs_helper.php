<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function getLogs($params = null)
{
    $data_log = array();
    $ci = get_instance();

    $methodes_clients = array(
        "add_client",
        "edit_client",
        "delete_client",
        "add_client_note",
        "delete_client_note",
        "rappel_facture",
        "rappel_devis",
    );

    if ($params != null) {
        if (isset($params["client_id"])) {
            $ci->db->where_in(
                'log_action',
                $methodes_clients
            );

            $ci->db->where(
                'log_field1',
                $params["client_id"]
            );
        }
    }

    $ci->db->join(
        'ip_users',
        'ip_users.user_id = ip_logs.log_user_id',
        'left'
    );

    $ci->db->order_by(
        "ip_logs.log_date",
        "DESC"
    );
    $ci->db->limit(30);
    $logs = $ci->db->get(
        'ip_logs'
    )->result();

    $group_id = $ci->session->userdata['groupes_user_id'];

    /* if (count($logs) >= 500) {

    $logs = $ci->db->get(
    $ci->session->userdata['database']
    . '.ip_logs'
    )->result();

    $logs = array_reverse($logs, true);

    }*/
    //return var_dump($logs);
    //$logs = array_reverse($logs, true);
    /*  $logs = $ci->db->get(
    $ci->session->userdata['database']
    . '.ip_logs'
    )->result();*/

    if (!empty($logs)) {
        foreach ($logs as $log) {
            if ($group_id == 1) {
                $link_profile = "<a title='"
                . $log->user_name
                . "' href='"
                . base_url()
                . "users/profil/"
                . $log->user_id
                . "'>"
                . $log->user_code
                    . "</a>";
            } else {
                $link_profile = "<span title='" . $log->user_name . "'>" . $log->user_code . "</span>";
            }
            switch ($log->log_action) { // element $foo[1] doesn't defined
                case "login":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile ."  ".lang('notif_connect'),
                            'message2' => $link_profile ."  ".lang('notif_connect'),
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "logout":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile ."  ".lang('notif_deconnect'),
                            'message2' => $link_profile ."  ".lang('notif_deconnect'),
                            'class' => 'log_warning',
                        );
                        break;
                    }
                case "add_quote":{
                        $ci->db->where('quote_id', $log->log_field1);
                        $quote = $ci->db->get('ip_quotes')->result();

                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à ajouté le devis #" . $quote[0]->quote_number,
                            'message2' => $link_profile . " à ajouté le devis #" . $quote[0]->quote_number,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "edit_quote":{
                        $ci->db->where('quote_id', $log->log_field1);
                        $quote = $ci->db->get('ip_quotes')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à modifié le devis #" . $quote[0]->quote_number,
                            'message2' => $link_profile . " à modifié le devis #" . $quote[0]->quote_number,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "delete_quote":{
                        $ci->db->where('quote_id', $log->log_field1);
                        $quote = $ci->db->get('ip_quotes')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à supprimer le devis #" . $quote[0]->quote_number,
                            'message2' => $link_profile . " à supprimer le devis #" . $quote[0]->quote_number,
                            'class' => 'log_danger',
                        );
                        break;
                    }

                case "add_invoice":{
                        $ci->db->where('invoice_id', $log->log_field1);
                        $invoice = $ci->db->get('ip_invoices')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à ajouté la facture <a href='" . base_url() . "invoices/view/" . $log->log_field1 . "'>#" . $invoice[0]->invoice_number . "</a>",
                            'message2' => $link_profile . " à ajouté la facture <a href='" . base_url() . "invoices/view/" . $log->log_field1 . "'>#" . $invoice[0]->invoice_number . "</a>",
                            'class' => 'log_success',
                        );

                        break;
                    }
                case "edit_invoice":{
                        $ci->db->where('invoice_id', $log->log_field1);
                        $invoice = $ci->db->get('ip_invoices')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à modifié la facture <a href='" . base_url() . "invoices/view/" . $log->log_field1 . "'>#" . $invoice[0]->invoice_number . "</a>",
                            'message2' => $link_profile . " à modifié la facture <a href='" . base_url() . "invoices/view/" . $log->log_field1 . "'>#" . $invoice[0]->invoice_number . "</a>",
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "delete_invoice":{
                        $ci->db->where('invoice_id', $log->log_field1);
                        $invoice = $ci->db->get('ip_invoices')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à supprimer la facture <a href='" . base_url() . "invoices/view/" . $log->log_field1 . "'>#" . $invoice[0]->invoice_number . "</a>",
                            'message2' => $link_profile . " à supprimer la facture <a href='" . base_url() . "invoices/view/" . $log->log_field1 . "'>#" . $invoice[0]->invoice_number . "</a>",
                            'class' => 'log_danger',
                        );
                        break;
                    }

                case "add_client":{
                        $ci->db->where('client_id', $log->log_field1);
                        $client = $ci->db->get('ip_clients')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à ajouté le client " . $client[0]->client_name . " " . $client[0]->client_prenom,
                            'message2' => $link_profile . " à ajouté le client " . $client[0]->client_name . " " . $client[0]->client_prenom,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "edit_client":{
                        $ci->db->where('client_id', $log->log_field1);
                        $client = $ci->db->get('ip_clients')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à modifié le client " . $client[0]->client_name . " " . $client[0]->client_prenom,
                            'message2' => $link_profile . " à modifié le client " . $client[0]->client_name . " " . $client[0]->client_prenom,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "delete_client":{
                        $ci->db->where('client_id', $log->log_field1);
                        $client = $ci->db->get('ip_clients')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à supprimé le client " . $client[0]->client_name . " " . $client[0]->client_prenom,
                            'message2' => $link_profile . " à supprimé le client " . $client[0]->client_name . " " . $client[0]->client_prenom,
                            'class' => 'log_danger',
                        );
                        break;
                    }
                case "add_client_note":{
                        $ci->db->where('client_id', $log->log_field1);
                        $client = $ci->db->get('ip_clients')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à créé une note pour le client " . $client[0]->client_name . " " . $client[0]->client_prenom,
                            'message2' => $link_profile . " à créé une note pour le client " . $client[0]->client_name . " " . $client[0]->client_prenom . "<br>Note : " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "delete_client_note":{
                        $ci->db->where('client_id', $log->log_field1);
                        $client = $ci->db->get('ip_clients')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à supprimer la note du client " . $client[0]->client_name . " " . $client[0]->client_prenom,
                            'message2' => $link_profile . " à supprimer la note du client " . $client[0]->client_name . " " . $client[0]->client_prenom . "<br>Note : " . $log->log_field2,
                            'class' => 'log_danger',
                        );
                        break;
                    }
                case "add_payment":{
//                        $ci->db->join('ip_clients', 'ip_clients.client_id = ip_payments.client_id', 'left');
                        //                        $ci->db->where('payment_id', $log->log_field1);
                        //                        $payment = $ci->db->get('ip_payments')->result();
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à créé un paiement",
                            'message2' => $link_profile . " à créé un paiement<br>" . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "edit_payment":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à modifié un paiement",
                            'message2' => $link_profile . " à modifié un paiement<br>" . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "delete_payment":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à supprimé un paiement",
                            'message2' => $link_profile . " à supprimé un paiement<br>" . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "rappel_devis":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à envoyé un rappel devis N°" . $log->log_field1,
                            'message2' => $link_profile . " à envoyé un rappel devis N°" . $log->log_field1,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "rappel_facture":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à envoyé un rappel facture N°" . $log->log_field2,
                            'message2' => $link_profile . " à envoyé un rappel facture N°" . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "add_product":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à créé un produit",
                            'message2' => $link_profile . " à créé un produit<br>" . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;

                    }
                case "edit_product":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à modifié la produit",
                            'message2' => $link_profile . " à modifié la produit " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "add_fournisseur":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à créé un fournisseur",
                            'message2' => $link_profile . " à créé un fournisseur " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;

                    }
                case "edit_fournisseur":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à modifié la fournisseur",
                            'message2' => $link_profile . " à modifié la fournisseur " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }

                case "add_depense":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à créé un depense",
                            'message2' => $link_profile . " à créé un depense " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;

                    }

                case "add_bc":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à créé un bc",
                            'message2' => $link_profile . " à créé un bc " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;

                    }

                case "add_bl":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à créé un bl",
                            'message2' => $link_profile . " à créé un bl " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;

                    }
                case "edit_depense":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à modifié la depense N° " . $log->log_field2,
                            'message2' => $link_profile . " à modifié la depense " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "edit_bl":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à modifié la bl N° " . $log->log_field2,
                            'message2' => $link_profile . " à modifié la bl " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }
                case "edit_bc":{
                        $data_log[] = array(
                            'infos' => $log,
                            'message' => $link_profile . " à modifié la bc N° " . $log->log_field2,
                            'message2' => $link_profile . " à modifié la bc " . $log->log_field2,
                            'class' => 'log_success',
                        );
                        break;
                    }
            }
        }
    }
//                print_r($logs);
    return $data_log;
}