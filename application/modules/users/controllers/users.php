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

class Users extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_users');
        $this->path = './uploads/' . strtolower($this->session->userdata('licence')) . '/photos_users/';
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777);
        }
    }

    public function index($page = 0)
    {
        $this->mdl_users->paginate(site_url('users/index'), $page);
        $this->load->model('groupes_users/mdl_groupes_users');

        $users = $this->mdl_users->result();

        $this->layout->set('users', $users);
        $this->layout->set('groupes_users', $this->mdl_groupes_users->where('etat', 1)->get()->result());
        $this->layout->set('user_types', $this->mdl_users->user_types());
        $this->layout->buffer('content', 'users/index');
        $this->layout->render();
    }

    public function form($id = null)
    {

        if (($id == null || $id == 0) && !rightsAddCollaborateur()) {

            redirect('settings#settings-groupes_users');
        }

        if ($this->input->post('btn_cancel')) {
            redirect('settings#settings-groupes_users');
        }
        $this->load->model('groupes_users/mdl_groupes_users');

        if ($this->mdl_users->run_validation(($id) ? 'validation_rules_existing' : 'validation_rules')) {
            //print_r($this->mdl_users);
            $id = $this->mdl_users->save($id);

            $upload_config = array(
                'upload_path' => $this->path,
                'allowed_types' => 'gif|jpg|png|svg',
                'max_size' => '1024000',
                'max_width' => '500',
                'max_height' => '500',
            );

            // Check for invoice logo upload
            if ($_FILES['user_avatar']['name']) {
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('user_avatar')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect(current_url());
                }

                $upload_data = $this->upload->data();

                //$this->mdl_settings->save('user_avatar', $upload_data['file_name']);
                $this->db->where('user_id', $id);
                $data_file_upload = array('user_avatar' => $upload_data['file_name']);
                $this->db->update('ip_users', $data_file_upload);
            }

//if($this->mdl_users->save($id))echo '<br>'.$id;die();
            $this->load->model('custom_fields/mdl_user_custom');

            $this->mdl_user_custom->save_custom($id, $this->input->post('custom'));

            redirect('settings#settings-groupes_users');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_users->prep_form($id)) {
                show_404();
            }

            $this->load->model('custom_fields/mdl_user_custom');

            $user_custom = $this->mdl_user_custom->where('user_id', $id)->get();

            if ($user_custom->num_rows()) {
                $user_custom = $user_custom->row();

                unset($user_custom->user_id, $user_custom->user_custom_id);

                foreach ($user_custom as $key => $val) {
                    $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                }
            }
        } elseif ($this->input->post('btn_submit')) {
            if ($this->input->post('custom')) {
                foreach ($this->input->post('custom') as $key => $val) {
                    $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                }
            }
        }

        $this->load->model('users/mdl_user_clients');
        $this->load->model('clients/mdl_clients');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->helper('country');

        $this->layout->set(
            array(
                'id' => $id,
                'groupes_users' => $this->mdl_groupes_users->where('etat', 1)->get()->result(),
                'user_types' => $this->mdl_users->user_types(),
                'user_clients' => $this->mdl_user_clients->where('ip_user_clients.user_id', $id)->get()->result(),
                'custom_fields' => $this->mdl_custom_fields->by_table('ip_user_custom')->get()->result(),
                'countries' => get_country_list(lang('cldr')),
                'selected_country' => $this->mdl_users->form_value('user_country') ?:
                $this->mdl_settings->setting('default_country'),
            )
        );

        $this->layout->buffer('user_client_table', 'users/partial_user_client_table');
        $this->layout->buffer('modal_user_client', 'users/modal_user_client');
        $this->layout->buffer('content', 'users/form');
        $this->layout->render();
    }

    public function view($id)
    {
        if (($this->input->post('btn_cancel')) || ($id == null)) {
            redirect(base_url());
        }
        $this->load->model('groupes_users/mdl_groupes_users');

        if ($this->mdl_users->run_validation(($id) ? 'validation_rules_existing' : 'validation_rules')) {
            //print_r($this->mdl_users);
            $id = $this->mdl_users->save($id);
//if($this->mdl_users->save($id))echo '<br>'.$id;die();
            $this->load->model('custom_fields/mdl_user_custom');

            $this->mdl_user_custom->save_custom($id, $this->input->post('custom'));

            redirect('users');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_users->prep_form($id)) {
                show_404();
            }

            $this->load->model('custom_fields/mdl_user_custom');

            $user_custom = $this->mdl_user_custom->where('user_id', $id)->get();

            if ($user_custom->num_rows()) {
                $user_custom = $user_custom->row();

                unset($user_custom->user_id, $user_custom->user_custom_id);

                foreach ($user_custom as $key => $val) {
                    $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                }
            }
        } elseif ($this->input->post('btn_submit')) {
            if ($this->input->post('custom')) {
                foreach ($this->input->post('custom') as $key => $val) {
                    $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                }
            }
        }

        $this->load->model('users/mdl_user_clients');
        $this->load->model('clients/mdl_clients');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->helper('country');

        $this->layout->set(
            array(
                'id' => $id,
                'groupes_users' => $this->mdl_groupes_users->where('etat', 1)->get()->result(),
                'user_types' => $this->mdl_users->user_types(),
                'user_clients' => $this->mdl_user_clients->where('ip_user_clients.user_id', $id)->get()->result(),
                'custom_fields' => $this->mdl_custom_fields->by_table('ip_user_custom')->get()->result(),
                'countries' => get_country_list(lang('cldr')),
                'selected_country' => $this->mdl_users->form_value('user_country') ?:
                $this->mdl_settings->setting('default_country'),
            )
        );

        $this->layout->buffer('user_client_table', 'users/partial_user_client_table');
        $this->layout->buffer('modal_user_client', 'users/modal_user_client');
        $this->layout->buffer('content', 'users/form');
        $this->layout->render();
    }

    public function profil($id)
    {
        if (($this->input->post('btn_cancel')) || ($id == null)) {
            redirect(base_url());
        }

        if ($this->input->post('del_user_avatar')) {
            if ($id) {
                $this->db->select('user_avatar');
                $this->db->where('user_id', $id);
                $user_avatar = $this->db->get('ip_users')->result();
                $folder = './uploads/' . strtolower($this->session->userdata('licence')) . '/photos_users/' . $user_avatar[0]->user_avatar;
                if ($folder) {
                    unlink($folder);
                }
                $this->db->where('user_id', $id);
                $data_file_upload = array('user_avatar' => '');
                $this->db->update('ip_users', $data_file_upload);

            }
        }
        $this->load->model('groupes_users/mdl_groupes_users');
        $this->load->model('users/mdl_users');
        if (($id == $this->session->userdata['user_id']) || ($this->session->userdata['groupes_user_id'] == 1)) {

            if ($this->mdl_users->run_validation(($id) ? 'validation_rules_existing' : 'validation_rules')) {

                $upload_config = array(
                    'upload_path' => $this->path,
                    'allowed_types' => 'gif|jpg|png|svg',
                    'max_size' => '1024000',
                    'max_width' => '500',
                    'max_height' => '500',
                );

                // Check for invoice logo upload
                if ($_FILES['user_avatar']['name']) {
                    $this->load->library('upload', $upload_config);

                    if (!$this->upload->do_upload('user_avatar')) {
                        $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                        redirect(current_url());
                    }

                    $upload_data = $this->upload->data();

                    //$this->mdl_settings->save('user_avatar', $upload_data['file_name']);
                    $this->db->where('user_id', $id);
                    $data_file_upload = array('user_avatar' => $upload_data['file_name']);
                    $this->db->update('ip_users', $data_file_upload);
                }

                $id = $this->mdl_users->save($id);
                $this->load->model('custom_fields/mdl_user_custom');
                $this->mdl_user_custom->save_custom($id, $this->input->post('custom'));
                redirect(current_url());
            }

            if ($id and !$this->input->post('btn_submit')) {
                if (!$this->mdl_users->prep_form($id)) {
                    show_404();
                }

                $this->load->model('custom_fields/mdl_user_custom');

                $user_custom = $this->mdl_user_custom->where('user_id', $id)->get();

                if ($user_custom->num_rows()) {
                    $user_custom = $user_custom->row();

                    unset($user_custom->user_id, $user_custom->user_custom_id);

                    foreach ($user_custom as $key => $val) {
                        $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                    }
                }
            } elseif ($this->input->post('btn_submit')) {
                if ($this->input->post('custom')) {
                    foreach ($this->input->post('custom') as $key => $val) {
                        $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                    }
                }
            }
        } else {
            show_404();
        }

        $this->load->model('users/mdl_user_clients');
        $this->load->model('clients/mdl_clients');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->helper('country');

        $this->layout->set(
            array(
                'id' => $id,
                'groupes_users' => $this->mdl_groupes_users->where('etat', 1)->get()->result(),
                'user_types' => $this->mdl_users->user_types(),
                'user_clients' => $this->mdl_user_clients->where('ip_user_clients.user_id', $id)->get()->result(),
                'custom_fields' => $this->mdl_custom_fields->by_table('ip_user_custom')->get()->result(),
                'countries' => get_country_list(lang('cldr')),
                'selected_country' => $this->mdl_users->form_value('user_country') ?:
                $this->mdl_settings->setting('default_country'),
            )
        );

//        $this->layout->buffer('user_client_table', 'users/partial_user_client_table');
        //        $this->layout->buffer('modal_user_client', 'users/modal_user_client');
        $this->layout->buffer('content', 'users/form');
        $this->layout->render();
    }

    public function change_password($user_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('users');
        }

        if ($this->mdl_users->run_validation('validation_rules_change_password')) {
            $this->mdl_users->save_change_password($user_id, $this->input->post('user_password'));
            redirect('users/form/' . $user_id);
        }

        $this->layout->buffer('content', 'users/form_change_password');
        $this->layout->render();
    }

    public function delete($id)
    {
        if ($id != 1) {
            $this->mdl_users->delete($id);
        }
        redirect('users');
    }

   
    public function deactivate($id)
    {
        $data_user = array('user_active' => 0);
        $this->db->where('user_id', $id);

        $this->db->update('ip_users', $data_user);

        redirect('settings#settings-groupes_users');
    }

    public function activate($id)
    {
        $data_user = array('user_active' => 1);
        $this->db->where('user_id', $id);

        $this->db->update('ip_users', $data_user);

        redirect('settings#settings-groupes_users');
    }

    public function delete_user_client($user_id, $user_client_id)
    {
        $this->load->model('mdl_user_clients');

        $this->mdl_user_clients->delete($user_client_id);

        redirect('users/form/' . $user_id);
    }

    public function file_view()
    {
        $this->load->view('file_view', array('error' => ' '));
    }

    public function do_upload()
    {
        //echo base_url() . "uploads/";die;
        $config = array(
            'upload_path' => "./uploads/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => true,
            'max_size' => "2048000", // Can be set to particular file size
            'max_height' => "768",
            'max_width' => "1024",
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload()) {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('upload_success', $data);
        } else {
            $error = array('error' => $this->upload->display_errors());
            //$this->load->view('file_view', $error);
        }
    }

}