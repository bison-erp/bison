<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends Admin_Controller {

    public function getRappelAujourdui() {
        $arrayResp = array();
        $this->load->model('mdl_quote_rappel');
        $response = $this->mdl_quote_rappel->selectRappelAujourdui();
        foreach ($response as $resp) {
            array_push($arrayResp, $resp);
        }

        echo json_encode($arrayResp);
    }

    public function send_quote() {
        $response = array();
        $this->load->helper('mailer');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->model('quote_rappel/mdl_quote_rappel');
        $this->load->model('quotes/mdl_quote_items');

        $this->mailer_configured = mailer_configured();

        if (!$this->mailer_configured)
            return;

        $nature = $this->input->post('nature');
        $date_created = $this->input->post('date_created');
        $company = $this->input->post('company');
        $adresse = $this->input->post('adresse');
        $phone = $this->input->post('phone');
        $quote_num = $this->input->post('quote_num');
        $quote_id = $this->input->post('quote_id');
        $to = $this->input->post('to');
        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        //$from ='ayda@novatis.org';// $this->input->post('from_email');

        $pdf_template = $this->input->post('pdf_template');
        $email_temp = $this->mdl_email_templates->where('email_template_id', 3)->get()->result(); //recupere l'objet du Modèle de courriel choisi
        $product = $this->mdl_quote_items->where('quote_id', $quote_id)->get()->result(); //recupere liste dus produit appartenant à ce devis
        $produit = '';
        //print_r($email_temp[0]);die();
        foreach ($product as $prod) {
            if ($produit == '') {
                $produit = $prod->item_code;
            } else {
                $produit = $produit . ' , ' . $prod->item_code;
            }
        }//echo ($produit);die();
       // $subject = 'Devis #' . $quote_num . ' Produits ' . $produit . ' de ma société du ' . $date_created;
        $subject = 'Devis #' . $quote_num ;
        //récupération du bodu du mail + modification quote_num
        $body = $email_temp[0]->email_template_body;
        $nom_com = $email_temp[0]->email_template_from_name;
        $mail_com = $email_temp[0]->email_template_from_email;
        $nm = $nom_com . '<br>' . $mail_com;
        $adr = $company . '<br>'.$adresse.'<br>' . $phone;
        $body = str_replace('{nature}', $nature, $body);
        $body = str_replace('{date}', $date_created, $body);
        $body = str_replace('{num}', $quote_num, $body);
       // $body = str_replace('{liste_produit}', $produit, $body);
        $body = str_replace('{nom}', $nm, $body);
        $body = str_replace('{contact_societe}', $adr, $body);
        $body = str_replace('{societe}', $company, $body);

        $email_pdf_template = $email_templates[0]->email_template_pdf_template; //quel pdf envoyer avec message
        //$from = 'ayda@novatis.org';//$email_temp[0]->email_template_from_email;

        if (email_quote($quote_id, $email_pdf_template, $from, $to, $subject, $body, $cc, $bcc)) {
            $this->mdl_quotes->mark_sent($quote_id);

            $this->session->set_flashdata('alert_success', lang('email_successfully_sent'));
            //

            $this->db->query("UPDATE `ip_quote_date_rappel` SET  `rappel_status`=1
                     WHERE `rappel_qote_id` =  " . $quote_id . "
                    AND `rappel_date`='" . date('Y-m-d') . "'");




            $response = array('success' => 1);
        } else {
            $response = array('success' => 0);
        }
        echo json_encode($response);
    }

}
