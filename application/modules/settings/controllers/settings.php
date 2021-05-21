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

class Settings extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_settings');
       
    }

    public function index()
    {   
        if ($this->input->post('settings')) {          
            $settings = $this->input->post('settings');
            $this->load->model('societes/mdl_societes');
            if ($this->mdl_societes->run_validation()) {
                $this->load->model('mdl_settings');
          
            // Save the submitted settings
            foreach ($settings as $key => $value) {
                // Don't save empty passwords
                if ($key == 'smtp_password' or $key == 'merchant_password') {
                    if ($value != '') {
                        $this->load->library('encrypt');
                        $this->mdl_settings->save($key, $this->encrypt->encode($value));
                    }
                } else {
                    $this->mdl_settings->save($key, $value);
                }
            }

            $upload_config = array(
                'upload_path' => './uploads/' . strtolower($this->session->userdata('licence')) . '/',
                'allowed_types' => 'gif|jpg|png|svg',
                'max_size' => '9999',
                'max_width' => '9999',
                'max_height' => '9999',
            );

            // Check for invoice logo upload
            if ($_FILES['invoice_logo']['name']) {
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('invoice_logo')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect('settings');
                }

                $upload_data = $this->upload->data();

                $this->mdl_settings->save('invoice_logo', $upload_data['file_name']);
            }

            if ($_FILES['signature_logo']['name']) {
                $this->load->library('upload', $upload_config);

                if (!$this->upload->do_upload('signature_logo')) {
                    $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                    redirect('settings');
                }

                $upload_data = $this->upload->data();

                $this->mdl_settings->save('signature_logo', $upload_data['file_name']);
            }
           // $this->load->model('societes/mdl_societes');
     
                //            $this->mdl_societes->save($id);
               // return var_dump($this->input->post('raison_social_societes'));
            //   var_dump($this);
          /*     $this->load->model('societes/mdl_societes');
               var_dump($this->mdl_societes);
               if ($this->mdl_societes->run_validation()) {

               }*/
               // if(empty(trim($this->input->post('raison_social_societes')))){
                //  return die('h');
                //  $this->session->set_flashdata('alert_success', lang('settings_successfully_saved'));
               // $this->form_validation->set_rules('text_field', 'Text Field One', 'required');
                  //  $this->mdl_societes->form_validation->set_message('required', 'Le champ raison_social_societes est obligatoire');
               /*   $this->layout->set(
                    array(
                        'tessssst' => '111',
                    )
                    );*/
                   //  $this->layout->buffer('content', 'settings/index');
               //   $this->layout->buffer('content', 'settings/partial_settings_societe');
               //     $this->layout->render();
                  
               // }    
                
                            $data = array(
                                'raison_social_societes' => $this->input->post('raison_social_societes'),
                                'code_tva_societes' => $this->input->post('code_tva_societes'),
                                'tax_code' => $this->input->post('tax_code'),
                                'site_web_societes' => $this->input->post('site_web_societes'),
                                'mail_societes' => $this->input->post('mail_societes'),
                                'fax_societes' => $this->input->post('fax_societes'),
                                'note_societes' => $this->input->post('note_societes'),
                                'tel_societes' => $this->input->post('tel_societes'),
                                'manager_firstname' => $this->input->post('manager_firstname'),
                                'manager_lastname' => $this->input->post('manager_lastname'),
                                'manager_mobile' => $this->input->post('manager_mobile'),
                                'activity_area' => $this->input->post('activity_area'),
                                'number_employees' => $this->input->post('number_employees'),
                                'subject_vat' => $this->input->post('subject_vat'),                                
                            );
                           // return var_dump($data);die('1');
                          /*  if ($id) {
                                $this->db->where('id_societes', $id);
                                $this->db->update('ip_societes', $data);
                            } else {
                                $this->db->insert('ip_societes', $data);
                                $id = $this->db->insert_id();
                            }*/
                            $this->db->where('id_societes', 1);
                            $this->db->update('ip_societes', $data);

                            $adresse = $this->input->post('adresse');
                            $pays = $this->input->post('pays');
                            $ville = $this->input->post('ville');
                            $adresse = $this->input->post('adresse');
                            $code_postal = $this->input->post('code_postal');
                            $telephone = $this->input->post('telephone');
                          //  $this->db->where('id_societe', $id);
                            $this->db->where('id_societe',1);
                            $this->db->delete('ip_societe_adresse');
                            if (!empty($adresse)) {
                                foreach ($adresse as $key => $val) {
                                    $data_adr = array(
                                        'adresse' => $adresse[$key],
                                        'code_postal' => $code_postal[$key],
                                        'ville' => $ville[$key],
                                        'pays' => $pays[$key],
                                        'telephone' => $telephone[$key],
                                        'id_societe' => 1
                                    );
                                    $this->db->insert('ip_societe_adresse', $data_adr);
                                }
                            }
                           
             //  }

            $this->session->set_flashdata('alert_success', lang('settings_successfully_saved'));

            redirect('settings');
        }
    }
        // Load required resources
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->model('settings/mdl_versions');
        $this->load->model('payment_methods/mdl_payment_methods');
        $this->load->model('invoices/mdl_templates');
        $this->load->model('societes/mdl_societes');
        $this->load->helper('directory');
        $this->load->helper('country');

        $this->load->library('merchant');

        // Collect the list of templates
        $pdf_invoice_templates = $this->mdl_templates->get_invoice_templates('pdf');
        $public_invoice_templates = $this->mdl_templates->get_invoice_templates('public');
        $pdf_quote_templates = $this->mdl_templates->get_quote_templates('pdf');
        $public_quote_templates = $this->mdl_templates->get_quote_templates('public');

        // Collect the list of languages
        $languages = directory_map(APPPATH . 'language', true);
        sort($languages);
        
        // Get the current version
        $current_version = $this->mdl_versions->limit(1)->where('version_sql_errors', 0)->get()->row()->version_file;
        $current_version = str_replace('.sql', '', substr($current_version, strpos($current_version, '_') + 1));

        //  $this->db->select('tbl_user.username,tbl_user.userid,tbl_usercategory.typee');

        $this->db->like('log_action', 'rappel_devis');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_logs.log_field1');
        $this->db->join('ip_quotes', 'ip_quotes.quote_id = ip_logs.log_field2');
        $this->db->join('ip_users', 'ip_clients.user_id = ip_users.user_id');
        $this->db->order_by('log_date', 'DESC'); //ip_tracking
        //  $this->db->limit(100);
        $traking = $this->db->get("ip_logs")->result();

        // Collect the list of languagedocument
        $languagedocument = directory_map(APPPATH . 'languagedocument', true);
        sort($languagedocument);
        $this->db->where('id_societe', 1);
        $societe_adresses = $this->db->get('ip_societe_adresse')->result();

        $this->db->where('id_societes', 1);
        $societe = $this->db->get('ip_societes')->result();
        $this->load->model('depot/mdl_depot');
        $this->load->model('group_option/mdl_group_option');
        $this->load->model('attributs/mdl_option_attribut');
     //   $this->load->model('products/mdl_groupe_option');
        // Set data in the layout
        $this->layout->set(
            array(
                'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
                'payment_methods' => $this->mdl_payment_methods->get()->result(),
                'public_invoice_templates' => $public_invoice_templates,
                'pdf_invoice_templates' => $pdf_invoice_templates,
                'public_quote_templates' => $public_quote_templates,
                'pdf_quote_templates' => $pdf_quote_templates,
                'languages' => $languages,
                'languagedocuments' => $languagedocument,
                'countries' => get_country_list(lang('cldr')),
                'date_formats' => date_formats(),
                'current_date' => new DateTime(),
                //'pdf_invoice_templates'=>
                'email_templates_bc' => $this->mdl_email_templates->where('email_template_type', 'commande')->get()->result(),
 
                'email_templates_bl' => $this->mdl_email_templates->where('email_template_type', 'bl')->get()->result(),
                'email_templates_quote' => $this->mdl_email_templates->where('email_template_type', 'quote')->get()->result(),
                'email_templates_invoice' => $this->mdl_email_templates->where('email_template_type', 'invoice')->get()->result(),
                'current_version' => $current_version,
                'first_days_of_weeks' => array("0" => lang("sunday"), "1" => lang("monday")),
                'tracking' => $traking,
                'societe_adresses'=>$societe_adresses,   
                'societe'=>$societe,
                'mdl_depot'=> $this->mdl_depot->get()->result(),        
                'group_options'=> $this->mdl_group_option->get()->result(),   
                'mdl_option_attribut'=> $this->mdl_option_attribut->get()->result(),        
            )
        );

        $this->layout->buffer('content', 'settings/index');
        $this->layout->render();
    }

    public function remove_logo($type)
    {
        unlink('./uploads/' . strtolower($this->session->userdata('licence')) . '/' . $this->mdl_settings->setting($type . '_logo'));

        $this->mdl_settings->save($type . '_logo', '');

        $this->session->set_flashdata('alert_success', lang($type . '_logo_removed'));

        redirect('settings');
    }
    //affiche des devise
    public function partial_settings_devise()
    {
        //load model devise
        $this->load->model('devises/mdl_devises');
        //requete sql
        // $this->layout->set(
        //        array(
        //'client_notes' => $this->mdl_client_notes->where('client_id', $client_id)->get()->result(),
        //            'devises' => $this->mdl_devises->get()->result(),
        //         )
        // );
        $devises = $this->mdl_devises->get()->result();
        // print_r()
        //envoyer donner au view dédié
        $this->layout->buffer(
            array(
                //array('invoice_table', 'invoices/partial_invoice_table'),
                array('content', 'settings/partial_settings_devise'),
            )
        );
        $this->layout->render();
    }

    public function trackingajax()
    {
        $num = $this->input->post('num');
        $this->db->like('log_action', 'rappel_devis');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_logs.log_field1');
        $this->db->join('ip_quotes', 'ip_quotes.quote_id = ip_logs.log_field2');
        $this->db->join('ip_users', 'ip_clients.user_id = ip_users.user_id');
        $this->db->order_by('log_date', 'DESC'); //ip_tracking

        //$this->db->limit(($num * 10) + 1, 10);
        //echo $num;
        $traking1 = $this->db->get("ip_logs")->result();
        $traking = $this->db->get("ip_logs", 10, $num * 10)->result();
        //header('Content-Type: application/json');
        $res = "";
        foreach ($traking as $i) {
            /* $res .= "<td>" . $i->id_from . "</td>";
            $res .= "<td>" . $i->id_to . "</td>";
            $res .= "<td>" . $i->date . "</td>";
            $res .= "<td></td>";
            $res .= "<td>" . $i->vu . "</td>";*/
            $res .= "<tr>";
            $res .= "<td>" . $i->user_email . "</td>";
            $res .= "<td>" . $i->client_email . "</td>";
            $res .= "<td>" . $i->log_date . "</td>";
            $res .= "<td>" . $i->log_id . "</td>";
            $res .= "<td></td>";
            $res .= "</tr>";
        }
        /*  if (count($traking1 > $traking)) {

        }*/
        // echo json_encode($res);
        echo $res;
    }

}