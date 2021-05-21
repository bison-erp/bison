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

class Groupes_users extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('mdl_groupes_users');
        $this->load->model('groupes_users/mdl_droits');
    }

    public function index($page = 0) {
        $this->mdl_groupes_users->paginate(site_url('groupes_users/index'), $page);
        $groupes_users = $this->mdl_groupes_users->result();

        $this->layout->set('groupes_users', $groupes_users);
        $this->layout->buffer('content', 'groupes_users/index');
        $this->layout->render();
    }

    public function form($id = NULL) {
        $this->load->model('mdl_droits');
        if ($this->input->post('btn_cancel')) {
            redirect('settings#settings-groupes_users');
        }

        if ($this->mdl_groupes_users->run_validation()) {
            $this->load->model('groupes_users/mdl_droits');

            $this->mdl_groupes_users->save($id);
            //vider la table droit
            $this->db->where('groupes_user_id', $id);
            $this->db->delete('ip_droits');
            //puis inserrer les droit d'accée modifier
            foreach ($this->mdl_groupes_users->form_values['droit'] as $key => $value) {
                foreach ($value as $k => $val) {
                    $data = array(
                        'groupes_user_id' => $id,
                        'nom' => $key,
                        'action' => $k
                    );
                    $this->db->insert('ip_droits', $data);
                }
            }
            redirect('settings#settings-groupes_users');
        }

        if ($id and ! $this->input->post('btn_submit')) {
            if (!$this->mdl_groupes_users->prep_form($id)) {
                show_404();
            }
        }

        $this->layout->set('droits', $this->mdl_droits->where('groupes_user_id', $id)->get()->result());

        $this->layout->buffer('content', 'groupes_users/form');
        $this->layout->render();
    }

    public function delete($id) {
        $this->mdl_groupes_users->delete($id);
        redirect('settings#settings-groupes_users');
    }

}
