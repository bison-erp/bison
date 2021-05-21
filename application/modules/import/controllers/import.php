<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Import extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->types = array(
            1 => "Contact",
            2 => "Factures",
            3 => "Produits",
            4 => "Caisse",
            5 => "Bon de commande",
            6 => "Bon de livraison",
            7 => "fournisseur",
            8 => "depense"             
        );

        $this->statuses = array(
            0 => "En attente",
            1 => "Import&eacute;",
        );

        $this->path = './uploads/' . strtolower(
          $this->session->userdata('licence')
        ) . '/import/';

        if (!is_dir($this->path)) {
            mkdir($this->path, 0777);
        }
    }

    public function index() {
        $files = $this->db->get(
          "ip_files_import"
        )->result();

        $this->layout->set(
                array(
                    'files' => $files,
                    'statuses' => $this->statuses,
                    'types' => $this->types
                )
        );

        $this->layout->buffer(
          'content',
          'import/index'
        );

        $this->layout->render();
    }

    public function form($id = NULL) {
        if ($this->input->post('type') && isset($_FILES['file_import']['name']) && ($_FILES['file_import']['name'] != '')) {
//            print_r($_FILES);
            $file_type = $this->input->post(
              'type'
            );

            $file_name = $_FILES['file_import']['name'];

            $upload_config = array(
                'upload_path' => $this->path,
                'allowed_types' => '*',
                'max_size' => '9999',
                'max_width' => '9999',
                'max_height' => '9999',
            );


            $this->load->library(
              'upload',
              $upload_config
            );

            if (!$this->upload->do_upload('file_import')) {
                $this->session->set_flashdata(
                  'alert_error',
                  $this->upload->display_errors()
                );

                redirect('import/form');
            } else {
                $upload_data = $this->upload->data();
                $data_file = array(
                    "file_name" => $upload_data["file_name"],
                    "file_date" => date("Y-m-d H:i:s"),
                    "file_type" => $file_type,
                    "file_status" => 0,
                    "file_user_id" => $this->session->userdata['user_id'],
                );

                $this->db->insert(
                  "ip_files_import",
                  $data_file
                );

                redirect('import');
            }
        }

        $this->layout->set(
                array(
                    'types' => $this->types
                )
        );

        $this->layout->buffer(
          'content',
          'import/form'
        );

        $this->layout->render();
    }

    public function importClient($id = NULL) {
        $this->db->where("file_id", $id);
        $file = $this->db->get(
          "ip_files_import"
        )->result();

        if (!empty($file)) {
            $this->load->library('excel');

            $objPHPExcel = PHPExcel_IOFactory::load(
              $this->path
              . $file[0]->file_name
            );

            $this->layout->set(
                    array(
                        'file_id' => $id,
                        'objPHPExcel' => $objPHPExcel,
                        'devises' => $this->db->get(' ip_devises')->result()
                    )
            );

            $this->layout->buffer(
              'content',
              'import/importClient'
            );

            $this->layout->render();
        }
    }

    public function importFactures($id = NULL) {
        $this->db->where("file_id", $id);
        $file = $this->db->get(
          "ip_files_import"
        )->result();

        if (!empty($file)) {
            $this->load->library('excel');

            $objPHPExcel = PHPExcel_IOFactory::load(
              $this->path
              . $file[0]->file_name
            );

            $this->db->select(
              "client_id,client_name,client_prenom,client_societe"
            );

            $this->db->order_by(
              'client_societe asc, client_name asc'
            );

            $clients = $this->db->get(
              'ip_clients'
            )->result();

            $this->layout->set(
                    array(
                        'file_id' => $id,
                        'objPHPExcel' => $objPHPExcel,
                        'clients' => $clients
                    )
            );

            $this->layout->buffer(
              'content',
              'import/importFactures'
            );

            $this->layout->render();
        }
    }

    public function importProducts($id = NULL) {
        $this->db->where("file_id", $id);

        $file = $this->db->get(
          "ip_files_import"
        )->result();

        if (!empty($file)) {
            $this->load->library('excel');

            $objPHPExcel = PHPExcel_IOFactory::load(
              $this->path
              . $file[0]->file_name
            );

            $this->layout->set(
                    array(
                        'file_id' => $id,
                        'objPHPExcel' => $objPHPExcel,
                        'devises' => $this->db->get('ip_devises')->result(),
                        'families' => $this->db->get('ip_families')->result(),
                    )
            );

            $this->layout->buffer(
              'content',
              'import/importProducts'
            );

            $this->layout->render();
        }
    }

    public function delete($id = NULL) {
        if($id != NULL) {
          $this->db->where("file_id", $id);

          $file = $this->db->get(
            "ip_files_import"
          )->result();

          if(isset($file[0]->file_name) && is_file($this->path . $file[0]->file_name)) {
              unlink(
                $this->path
                . $file[0]->file_name
              );
          }

          $this->db->where("file_id", $id);
          $this->db->delete("ip_files_import");
        }

        redirect('import');
    }
}
