<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 * 
 * A free and open source web based invoicing system
 *
 * @package		InvoicePlane
 * @author		Kovah (www.kovah.de)
 * @copyright	Copyright (c) 2012 - 2015 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 * 
 */

class Ajax extends Admin_Controller {

    public function getClientDatabaseFields() {

        // required => (0, "non"),(1,"oui")

        $database_fields = array(
            0 => array("name" => "client_name", "title" => "Nom", "required" => 1, "unique" => 1),
            1 => array("name" => "client_prenom", "title" => "Prénom", "required" => 1, "unique" => 1),
            2 => array("name" => "client_societe", "title" => "Société", "required" => 1, "unique" => 1),
            3 => array("name" => "client_titre", "title" => "Civ", "list_values" => array(0 => "M.", 1 => "Mme.", 2 => "Melle."), "default" => "0", "required" => 0),
            4 => array("name" => "client_address_1", "title" => "Adresse 1", "required" => 0),
            5 => array("name" => "client_address_2", "title" => "Adresse 2", "required" => 0),
            6 => array("name" => "client_state", "title" => "Ville", "required" => 0),
            7 => array("name" => "client_zip", "title" => "Code postal", "required" => 0),
            8 => array("name" => "client_country", "title" => "Pays", "required" => 0),
            9 => array("name" => "client_phone", "title" => "Téléphone", "required" => 0),
            10 => array("name" => "client_fax", "title" => "Fax", "required" => 0),
            11 => array("name" => "client_mobile", "title" => "Portable", "required" => 0),
            12 => array("name" => "client_email", "title" => "Email", "required" => 0),
            13 => array("name" => "client_web", "title" => "Site Web", "required" => 0),
            14 => array("name" => "client_vat_id", "title" => "Matricule fiscal", "required" => 0),
            15 => array("name" => "client_tax_code", "title" => "Registre de commerce", "required" => 0),
            16 => array("name" => "client_type", "title" => "Type Client", "list_values" => array(0 => "Prospect", 1 => "Client"), "default" => "0", "required" => 0),
        );
        return $database_fields;
    }

    public function getFactureDatabaseFields() {

        // required => (0, "non"),(1,"oui")

        $database_fields = array(
            0 => array("name" => "invoice_number", "title" => "Numéro facture", "required" => 1),
            1 => array("name" => "client_id", "title" => "Client", "required" => 1),
            2 => array("name" => "invoice_date_created", "title" => "Date création", "required" => 1),
            3 => array("name" => "invoice_date_modified", "title" => "Date modification", "required" => 1),
            4 => array("name" => "invoice_date_due", "title" => "Date écheance", "required" => 1),
            5 => array("name" => "nature", "title" => "Nature Facture", "required" => 1),
            6 => array("name" => "total_ht", "title" => "Total HT", "required" => 1),
            7 => array("name" => "total_ttc", "title" => "Total TTC", "required" => 1),
            7 => array("name" => "tva", "title" => "TVA"),
        );
        return $database_fields;
    }

    public function getProductsDatabaseFields() {

        // required => (0, "non"),(1,"oui")

        $database_fields = array(
            array("name" => "family_name", "title" => "Nom de famille", "required" => 1),
            array("name" => "product_sku", "title" => "Référence", "required" => 1),
            array("name" => "product_name", "title" => "Nom du produit", "required" => 1),
            array("name" => "product_description", "title" => "Description du produit", "required" => 1),
            array("name" => "purchase_price", "title" => "Prix d'achat", "required" => 1),
            array("name" => "product_price", "title" => "Prix de vente", "required" => 1),
        );
        return $database_fields;
    }

    public function verifClients() {
        $errors = array();
        $errors2 = array();
        $database_fields = $this->getClientDatabaseFields();
        $all_lines = $this->input->post('import_fields');

        if (!empty($all_lines)) {

            foreach ($all_lines as $line1) {
                break;
            }


            foreach ($database_fields as $field) {
                if (isset($field["required"]) && $field["required"] == 1 && !isset($line1[$field["name"]])) {
                    $errors[] = $field["title"];
                }
            }

            foreach ($all_lines as $key1 => $line) {
                foreach ($line as $key => $value) {
                    foreach ($database_fields as $field) {
                        if (isset($field["unique"]) && $field["unique"] && $field["name"] == $key) {
                            $this->db->where($key, $value);
                        }
                    }
                }
                $this->db->select("client_id");
                $clients = $this->db->get("ip_clients")->result();
                if (!empty($clients)) {
                    foreach ($clients as $client) {
                        $errors2[] = $client->client_id . "_" . $key1;
                    }
                }
            }
        } else {
            foreach ($database_fields as $field) {
                if ($field["required"] == 1) {
                    $errors[] = $field["title"];
                }
            }
        }
        $response = array(
            "errors" => $errors,
            "errors2" => $errors2,
            "date" => date("d/m/Y H:i:s"),
        );
        echo json_encode($response);
    }

    public function importClients() {
        $database_fields = $this->getClientDatabaseFields();
        $all_lines = $this->input->post('import_fields');
        foreach ($all_lines as $key1 => $line) {
            $data_insert = array();
            foreach ($line as $key => $value) {

                foreach ($database_fields as $field) {

                    if (isset($field["list_values"]) && $field["name"] == $key) {

                        if (in_array($value, $field["list_values"])) {


                            foreach ($field["list_values"] as $k => $v) {
                                if ($value == $v) {
//                                    $value = $k;
                                    $value = $k;
                                    break;
                                }
//                                $value .= "_".$k;
                            }
                        } else {
                            $value = $field["default"];
                        }
                    }
                }
                $data_insert[$key] = $value;
                $data_insert["client_date_created"] = date("Y-m-d H:i:s");
                $data_insert["client_date_modified"] = $data_insert["client_date_created"];
                $data_insert["client_devise_id"] = 1;
            }

            $clients = $this->db->insert("ip_clients", $data_insert);
            $id_insert = $this->db->insert_id();
            $data_custom = array(
                "client_id" => $id_insert
            );
            $clients = $this->db->insert("ip_client_custom", $data_custom);
        }

        $data_file = array(
            'file_status' => 1
        );

        $this->db->where('file_id', $this->input->post('file_id'));
        $this->db->update('ip_files_import', $data_file);
    }

    public function updateClientsFactures() {
        $equiv = array();
        $all_lines = $this->input->post('import_fields');




        if (!empty($all_lines)) {
            foreach ($all_lines as $key => $line) {

                $client_name = strtolower($line['client_name']);
                $this->db->where('lower(client_societe)', $client_name);
                $result = $this->db->get('ip_clients')->result();
                if (empty($result)) {
                    $client_names = explode(" ", $client_name);
                    $this->db->where_in('lower(client_name)', $client_names);
                    $this->db->where_in('lower(client_prenom)', $client_names);
                    $result = $this->db->get('ip_clients')->result();
                }

                if (empty($result)) {
                    $client_id = 0;
                } else {
                    $client_id = $result[0]->client_id;
                }

                $equiv[] = $key . "_" . $client_id;
            }
        }
        $response = array(
            "equiv" => $equiv,
            "date" => date("d/m/Y H:i:s"),
        );
        echo json_encode($response);
    }

    public function verifFactures() {
        $errors_fields = array();
        $errors = array();
        $all_lines = $this->input->post('import_fields');
        $database_fields = $this->getFactureDatabaseFields();

        // Verifier les champs requis
        if (!empty($all_lines)) {

            foreach ($all_lines as $line1) {
                break;
            }


            foreach ($database_fields as $field) {
                if (isset($field["required"]) && $field["required"] == 1 && !isset($line1[$field["name"]])) {
                    $errors_fields[] = $field["name"];
                }
            }




            foreach ($all_lines as $key1 => $line) {
                foreach ($line as $key => $value) {
                    if ($key == "invoice_number") {
                        $this->db->where($key, $value);
                        $num_facture = $value;
                    }
                }
                $this->db->select("invoice_id");
                $invoices = $this->db->get("ip_invoices")->result();
                if (!empty($invoices)) {
                    $errors[] = $key1 . "_" . $invoices[0]->invoice_id . "_" . $num_facture;
                }
            }
        } else {
            foreach ($database_fields as $field) {
                if (isset($field["required"]) && $field["required"] == 1) {
                    $errors_fields[] = $field["name"];
                }
            }
        }

        $response = array(
            "date" => date("d/m/Y H:i:s"),
            "errors" => $errors,
            "errors_fields" => $errors_fields,
        );
        echo json_encode($response);
    }

    public function importFactures() {
        $user_id = $this->session->userdata['user_id'];
        $database_fields = $this->getFactureDatabaseFields();
        $all_lines = $this->input->post('import_fields');
        if (!empty($all_lines)) {
            foreach ($all_lines as $key1 => $line) {
                $data_insert = array();
                foreach ($line as $key => $value) {

                    foreach ($database_fields as $field) {

                        if (isset($field["list_values"]) && $field["name"] == $key) {

                            if (in_array($value, $field["list_values"])) {


                                foreach ($field["list_values"] as $k => $v) {
                                    if ($value == $v) {
//                                    $value = $k;
                                        $value = $k;
                                        break;
                                    }
//                                $value .= "_".$k;
                                }
                            } else {
                                $value = $field["default"];
                            }
                        }
                    }
                    $data_insert[$key] = $value;
                }

                // Insertion dans la table ip_invoices
                $data_insert_inv = array(
                    'user_id' => $user_id,
                    'client_id' => $data_insert['client_id'],
                    'nature' => $data_insert['nature'],
                    'invoice_status_id' => 4,
                    'invoice_date_created' => $data_insert['invoice_date_created'],
                    'invoice_date_modified' => $data_insert['invoice_date_modified'],
                    'invoice_date_due' => $data_insert['invoice_date_due'],
                    'invoice_number' => $data_insert['invoice_number'],
                );
                $this->db->insert("ip_invoices", $data_insert_inv);


                $id_insert = $this->db->insert_id();

                // Insertion dans la table ip_invoice_custom
                $data_custom = array(
                    "invoice_id" => $id_insert
                );
                $this->db->insert("ip_invoice_custom", $data_custom);

                // Insertion dans la table ip_invoice_items
                $data_items = array(
                    "invoice_id" => $id_insert,
                    "item_code" => $data_insert['nature'],
                    "item_description" => $data_insert['nature'],
                    "item_price" => $data_insert['total_ht'],
                    "item_tax_rate_id" => 1,
                    "item_quantity" => 1,
                );

                $this->db->insert("ip_invoice_items", $data_items);

                $id_item_insert = $this->db->insert_id();


                // Insertion dans la table ip_invoice_item_amounts
                $data_items_amounts = array(
                    "item_id" => $id_item_insert,
                    "item_subtotal" => $data_insert['total_ht'],
                    "item_total" => $data_insert['total_ttc'],
                );
                $this->db->insert("ip_invoice_item_amounts", $data_items_amounts);


                $data_invoice_amounts = array(
                    "invoice_id" => $id_insert,
                    "invoice_item_subtotal" => $data_insert['total_ht'],
                    "invoice_total" => $data_insert['total_ttc'],
                    "invoice_balance" => $data_insert['total_ttc'],
                );
                $this->db->insert("ip_invoice_amounts", $data_invoice_amounts);
            }

            $data_file = array(
                'file_status' => 1
            );

            $this->db->where('file_id', $this->input->post('file_id'));
            $this->db->update('ip_files_import', $data_file);
        }
    }

    public function verifProducts() {
        $errors_fields = array();
        $errors = array();
        $all_lines = $this->input->post('import_fields');
        $database_fields = $this->getProductsDatabaseFields();

        // Verifier les champs requis
        if (!empty($all_lines)) {

            foreach ($all_lines as $line1) {
                break;
            }

            foreach ($database_fields as $field) {
                if (isset($field["required"]) && $field["required"] == 1 && !isset($line1[$field["name"]])) {
                    $errors_fields[] = $field["title"];
                }
            }


            foreach ($all_lines as $key1 => $line) {
                $exist_key = 0;
                foreach ($line as $key => $value) {

                    if ($key == "product_sku") {
                        $this->db->where($key, $value);
                        $exist_key = 1;
                    }
                    if ($key == "product_name") {
                        if ($exist_key == 0)
                            $this->db->where($key, $value);
                        if ($exist_key == 1)
                            $this->db->or_where($key, $value);
                        $exist_key = 1;
                    }
                }

                $this->db->select("product_id,product_name");
                $products = $this->db->get("ip_products")->result();
                if (!empty($products)) {
                    $errors[] = $key1 . "_" . $products[0]->product_id . "_" . $products[0]->product_name;
                }
            }
        } else {
            foreach ($database_fields as $field) {
                if (isset($field["required"]) && $field["required"] == 1) {
                    $errors_fields[] = $field["title"];
                }
            }
        }

        $response = array(
            "date" => date("d/m/Y H:i:s"),
            "errors" => $errors,
            "errors_fields" => $errors_fields,
        );
        echo json_encode($response);
    }

    public function updateProductsFamilyValue() {
        $equiv = array();
        $all_lines = $this->input->post('import_fields');
        $type = $this->input->post('type');




        if (!empty($all_lines)) {
            foreach ($all_lines as $key => $line) {

                $family_name = strtolower($line['family_name']);
                $this->db->where('lower(family_name)', $family_name);
                $result = $this->db->get('ip_families')->result();

                if (empty($result)) {
                    if ($type == 0) {
                        $family_id = "-1";
                    } else {
                        $data_insert = array('family_name' => $line['family_name']);
                        $this->db->insert("ip_families", $data_insert);
                        $family_id = $this->db->insert_id();
                    }
                } else {
                    $family_id = $result[0]->family_id;
                }

                $equiv[] = $key . "_" . $family_id;
            }
        }
        $response = array(
            "equiv" => $equiv,
            "date" => date("d/m/Y H:i:s"),
        );
        echo json_encode($response);
    }

    public function updateFamilies() {
        $response = array(
            "families" => $this->db->get('ip_families')->result(),
        );
        echo json_encode($response);
    }

    public function importProducts() {
        $tva_list = $this->db->get('ip_tax_rates')->result();
        $errors_fields = array();
        $errors = array();
        $errors2 = array();
        $all_lines = $this->input->post('import_fields');
        $database_fields = $this->getProductsDatabaseFields();

        // Verifier les champs requis
        if (!empty($all_lines)) {

            foreach ($all_lines as $line1) {
                break;
            }

            foreach ($database_fields as $field) {
                if (isset($field["required"]) && $field["required"] == 1 && !isset($line1[$field["name"]])) {
                    $errors_fields[] = $field["title"];
                }
            }


            foreach ($all_lines as $key1 => $line) {
                $exist_key = 0;
                foreach ($line as $key => $value) {
                    
                    if ($key == "product_sku") {
                        $this->db->where($key, $value);
                        $exist_key = 1;
                    }
                    if ($key == "family_id") {
                        if($value == "-1"){
                            $errors2[] = 'Veuillez Sélectionner la famille de produit dans la ligne '.$key1;
                                                    

                        }
                    }
                    if ($key == "product_name") {
                        if ($exist_key == 0)
                            $this->db->where($key, $value);
                        if ($exist_key == 1)
                            $this->db->or_where($key, $value);
                        $exist_key = 1;
                    }
                    
                }

                $this->db->select("product_id,product_name");
                $products = $this->db->get("ip_products")->result();
                if (!empty($products)) {
                    $errors[] = $key1 . "_" . $products[0]->product_id . "_" . $products[0]->product_name;
                }
            }
        } else {
            foreach ($database_fields as $field) {
                if (isset($field["required"]) && $field["required"] == 1) {
                    $errors_fields[] = $field["title"];
                }
            }
        }



        if (empty($errors_fields) && empty($errors)&& empty($errors2)) {
            foreach ($all_lines as $key1 => $line) {
                $data_insert = array();
                foreach ($line as $key => $value) {

                    $data_insert[$key] = $value;
                }


                $taxrate = $tva_list[0]->tax_rate_id;
                foreach ($tva_list as $cur_tva) {
                    if ((float) $data_insert['tva'] == (float) $cur_tva->tax_rate_percent) {
                        $taxrate = $cur_tva->tax_rate_id;
                    }
                }

                // Insertion dans la table ip_invoices
                $data_insert_inv = array(
                    'family_id' => $data_insert['family_id'],
                    'product_sku' => $data_insert['product_sku'],
                    'product_name' => $data_insert['product_name'],
                    'product_description' => $data_insert['product_description'],
                    'purchase_price' => $data_insert['purchase_price'],
                    'product_price' => $data_insert['product_price'],
                    'tax_rate_id' => $taxrate,
                );
                $this->db->insert("ip_products", $data_insert_inv);
            }


            $data_file = array(
                'file_status' => 1
            );

            $this->db->where('file_id', $this->input->post('file_id'));
            $this->db->update('ip_files_import', $data_file);
            $response = array(
                "date" => date("d/m/Y H:i:s"),
                "errors" => $errors,
                "errors_fields" => $errors_fields,
                "success" => 1,
            );
        } else {
            $response = array(
                "date" => date("d/m/Y H:i:s"),
                "errors" => $errors,
                "errors_fields" => $errors_fields,
                "success" => 0,
                "errors2" => $errors2,
            );
        }
        echo json_encode($response);
    }

}
