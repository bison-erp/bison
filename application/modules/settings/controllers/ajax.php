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

    public $ajax_controller = TRUE;

    public function get_signature() {
        $this->load->model('settings/mdl_settings');
        $this->mdl_settings->load_settings();
        echo $this->mdl_settings->setting('signature');
    } 

    public function set_fieldrequired() {
        $this->load->model('settings/mdl_settings');
       // $timbre=$this->input->post('with_timbre');
       // $default_item_timbre=$this->input->post('default_item_timbre');
       // $this->mdl_settings->save('with_timbre',$timbre);
       // $this->mdl_settings->save('default_item_timbre',$default_item_timbre);
        $data = array(
            'raison_social_societes' => $this->input->post('raison'), 
            'code_tva_societes' =>  $this->input->post('matricule'), 
            'tax_code' => $this->input->post('tax_code'), 
            'mail_societes' => $this->input->post('mail'), 
            'tel_societes' =>  $this->input->post('tel'), 
        );     
        $this->db->where('id_societes', 1);
        $this->db->update('ip_societes', $data);                     
      //  redirect('settings');
         return die('1');
    }


    public function set_fieldrequiredinvoicelogo() {
        $this->load->model('settings/mdl_settings');
       
        $upload_config = array(
            'upload_path' => './uploads/' . strtolower($this->session->userdata('licence')) . '/',
            'allowed_types' => 'gif|jpg|png|svg',
            'max_size' => '9999',
            'max_width' => '9999',
            'max_height' => '9999',
        );
        if ($_FILES['invoice_logo']['name']) {
            $this->load->library('upload', $upload_config);

           if (!$this->upload->do_upload('invoice_logo')) {
                 $this->session->set_flashdata('alert_error', $this->upload->display_errors());
              //  redirect('settings');
            }

            $upload_data = $this->upload->data();

            $this->mdl_settings->save('invoice_logo', $upload_data['file_name']);           
        }       
    }

    public function set_fieldrequiredinvoicesignature() {
        $this->load->model('settings/mdl_settings');
       
        $upload_config = array(
            'upload_path' => './uploads/' . strtolower($this->session->userdata('licence')) . '/',
            'allowed_types' => 'gif|jpg|png|svg',
            'max_size' => '9999',
            'max_width' => '9999',
            'max_height' => '9999',
        ); 
        if ($_FILES['signature_logo']['name']) {
            $this->load->library('upload', $upload_config);

           if (!$this->upload->do_upload('signature_logo')) {
                $this->session->set_flashdata('alert_error', $this->upload->display_errors());             
              }

            $upload_data = $this->upload->data();

            $this->mdl_settings->save('signature_logo', $upload_data['file_name']);
        }
        
    }
}
