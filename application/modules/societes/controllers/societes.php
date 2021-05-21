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

class Societes extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('mdl_societes');
    }

    public function index($page = 0) {
        $this->load->model('mdl_societes');
        $this->mdl_societes->paginate(site_url('societes/index'), $page);
        $societes = $this->mdl_societes->result();

        $this->layout->set('societes', $societes);
        $this->layout->buffer('content', 'societes/index');
        $this->layout->render();
    }

    public function form($id = NULL) {



        if ($id == NULL && !rightsMultiSocietes()) {

            redirect('settings#settings-societe');

        }

        if ($this->input->post('btn_cancel')) {

            redirect('settings#partial_settings_societe');
            //header('Location:'. base_url().'settings/index#settings-societe');  
        }

        if ($this->mdl_societes->run_validation()) {
//            $this->mdl_societes->save($id);

            $data = array(
                'raison_social_societes' => $this->input->post('raison_social_societes'),
                'code_tva_societes' => $this->input->post('code_tva_societes'),
                'tax_code' => $this->input->post('tax_code'),
                'site_web_societes' => $this->input->post('site_web_societes'),
                'mail_societes' => $this->input->post('mail_societes'),
                'fax_societes' => $this->input->post('fax_societes'),
                'note_societes' => $this->input->post('note_societes')
            );
            if ($id) {
                $this->db->where('id_societes', $id);
                $this->db->update('ip_societes', $data);
            } else {
                $this->db->insert('ip_societes', $data);
                $id = $this->db->insert_id();
            }

            $adresse = $this->input->post('adresse');
            $pays = $this->input->post('pays');
            $ville = $this->input->post('ville');
            $adresse = $this->input->post('adresse');
            $code_postal = $this->input->post('code_postal');
            $telephone = $this->input->post('telephone');
            $this->db->where('id_societe', $id);
            $this->db->delete('ip_societe_adresse');
            if (!empty($adresse)) {
                foreach ($adresse as $key => $val) {
                    $data_adr = array(
                        'adresse' => $adresse[$key],
                        'code_postal' => $code_postal[$key],
                        'ville' => $ville[$key],
                        'pays' => $pays[$key],
                        'telephone' => $telephone[$key],
                        'id_societe' => $id
                    );
                    $this->db->insert('ip_societe_adresse', $data_adr);
                }
            }
            redirect('settings#settings-societe');
        }

        if ($id and ! $this->input->post('btn_submit')) {
            if (!$this->mdl_societes->prep_form($id)) {
                show_404();
            }
        }
        $this->db->where('id_societe', $id);
        $societe_adresses = $this->db->get('ip_societe_adresse')->result();

        $this->load->model('families/mdl_families');
        $this->load->model('tax_rates/mdl_tax_rates');

        $this->layout->set(
                array(
                    'families' => $this->mdl_families->get()->result(),
                    'tax_rates' => $this->mdl_tax_rates->get()->result(),
                    'id_current_societe' => $id
                )
        );

        $this->layout->buffer('content', 'societes/form');
        $this->layout->render();
    }

    public function delete($id) {
        $this->mdl_societes->delete($id);
        redirect('settings#settings-societe');
    }

}
