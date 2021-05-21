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

class Mdl_Sessions extends CI_Model {

    public function auth($email, $password) {
           // $this->load->model('settings/mdl_settings');

        $this->db->where('user_email', $email);

        $query = $this->db->get('ip_users');

        if ($query->num_rows()) {
            $user = $query->row();

            $this->load->library('crypt');

            /**
             * Password hashing changed after 1.2.0
             * Check to see if user has logged in since the password change
             */
            if (!$user->user_psalt) {
                /**
                 * The user has not logged in, so we're going to attempt to
                 * update their record with the updated hash
                 */
                if (md5($password) == $user->user_password) {
                    /**
                     * The md5 login validated - let's update this user
                     * to the new hash
                     */
                    $salt = $this->crypt->salt();
                    $hash = $this->crypt->generate_password($password, $salt);

                    $db_array = array(
                        'user_psalt' => $salt,
                        'user_password' => $hash
                    );

                    $this->db->where('user_id', $user->user_id);
                    $this->db->update('ip_users', $db_array);

                    $this->db->where('user_email', $email);
                    $user = $this->db->get('ip_users')->row();
                } else {
                    /**
                     * The password didn't verify against original md5
                     */
                    return FALSE;
                }
            }
            // echo '<br>';
            // echo '<pre>';print_r($user); echo '</pre>';

            if ($this->crypt->check_password($user->user_password, $password)) {
                //model de récupération des droits d'accés
                $this->load->model('groupes_users/mdl_droits');
                $this->load->model('groupes_users/mdl_groupes_users');
                $this->load->model('societes/mdl_societes');
                //récupération des droits pour le groupes_users de l'utilisateur
                $droits = $this->mdl_droits->where('groupes_user_id', $user->groupes_user_id)->get()->result();
                //récupération données de la société:
                $societe = $this->mdl_societes->get_by_id(1);
                //création du signature de la sté:
//                $foot = '<div >' . $societe->adresse_societes . ' ' . $societe->code_postal_societes . ' ' . $societe->ville_societes . '- Tél: ' . $societe->tel_societes;
//                if ((strcmp($societe->adresse2_societes, '') != 1) || (strcmp($societe->code_postal2_societes, '') != 1) || (strcmp($societe->ville2_societes, '') != 1)) {
//                    $foot = $foot . ' <br> ' . $societe->adresse2_societes . ' ' . $societe->code_postal2_societes . ' ' . $societe->ville2_societes;
//                    if ((strcmp($societe->tel2_societes, '') != 1))
//                        $foot = $foot . '- Tél: ' . $societe->tel2_societes;
//                }
//                $foot = $foot . '<br>';
//                if ((strcmp($societe->code_tva_societes, '') != 1))
//                    $foot = $foot . ' T.V.A.: ' . $societe->code_tva_societes;
//                if ((strcmp($societe->fax_societes, '') != 1))
//                    $foot = $foot . ' -Fax: ' . $societe->fax_societes;
//                if ((strcmp($societe->mail_societes, '') != 1))
//                    $foot = $foot . ' - Email : ' . $societe->mail_societes;
//                if ((strcmp($societe->site_web_societes, '') != 1))
//                    $foot = $foot . ' - Site: ' . $societe->site_web_societes;
//
//                $foot = $foot . '</div>';
//                $foot = '<div >' . $societe->adresse_societes . ' ' . $societe->code_postal_societes . ' ' . $societe->ville_societes . '- Tél: ' . $societe->tel_societes;
//                if ((strcmp($societe->adresse2_societes, '') != 1) || (strcmp($societe->code_postal2_societes, '') != 1) || (strcmp($societe->ville2_societes, '') != 1)) {
//                    $foot = $foot . ' <br> ' . $societe->adresse2_societes . ' ' . $societe->code_postal2_societes . ' ' . $societe->ville2_societes;
//                    if ((strcmp($societe->tel2_societes, '') != 1))
//                        $foot = $foot . '- Tél: ' . $societe->tel2_societes;
//                }
//                $foot = $foot . '<br>';
//                if ((strcmp($societe->code_tva_societes, '') != 1))
//                    $foot = $foot . ' T.V.A.: ' . $societe->code_tva_societes;
//                if ((strcmp($societe->fax_societes, '') != 1))
//                    $foot = $foot . ' -Fax: ' . $societe->fax_societes;
//                if ((strcmp($societe->mail_societes, '') != 1))
//                    $foot = $foot . ' - Email : ' . $societe->mail_societes;
//                if ((strcmp($societe->site_web_societes, '') != 1))
//                    $foot = $foot . ' - Site: ' . $societe->site_web_societes;
////         $a=base_url("uploads/".$this->mdl_settings->setting('invoice_logo')); 
////         $immg="<img style='width:19%;' src='".$a."'>";
//      $foot=$foot.'</div>'  ; 
   
//$immg="<img style='width:19%;' src='".$a."'>";
//                $foot = $foot . '</div>';
//$foot='<table style="width: 100%; "> <tr><td style="width: 30%;">aa</td>';
//$foot='<td>'.$foot.'</td> </tr>  </table>';

                $cont_add = 0;
                $cont_del = 0;
                $cont_index = 0;
                $devis_add = 0;
                $devis_del = 0;
                $devis_index = 0;
                $facture_add = 0;
                $facture_del = 0;
                $facture_index = 0;
                $product_add = 0;
                $product_del = 0;
                $product_index = 0;
                $fournisseur_add = 0;
                $fournisseur_del = 0;
                $fournisseur_index = 0;
                $payement_add = 0;
                $payement_del = 0;
                $payement_index = 0;
                $report_add = 0;
                $report_del = 0;
                $report_index = 0;
                $setting_add = 0;
                $setting_del = 0;
                $setting_index = 0;
                $group = $this->mdl_groupes_users->get()->result();
                $desig = '';
                foreach ($group as $val) {
                    if ($val->groupes_user_id == $user->groupes_user_id) {
                        $desig = $val->designation;
                    }
                }

                foreach ($droits as $value) {
                    //contact
                    if ((strcmp($value->nom, 'contact') == 0) && (strcmp($value->action, 'add') == 0)) {
                        $cont_add = 1;
                    }
                    if ((strcmp($value->nom, 'contact') == 0) && (strcmp($value->action, 'del') == 0)) {
                        $cont_del = 1;
                    }
                    if ((strcmp($value->nom, 'contact') == 0) && (strcmp($value->action, 'index') == 0)) {
                        $cont_index = 1;
                    }

                    //devis
                    if ((strcmp($value->nom, 'devis') == 0) && (strcmp($value->action, 'add') == 0)) {
                        $devis_add = 1;
                    }
                    if ((strcmp($value->nom, 'devis') == 0) && (strcmp($value->action, 'del') == 0)) {
                        $devis_del = 1;
                    }
                    if ((strcmp($value->nom, 'devis') == 0) && (strcmp($value->action, 'index') == 0)) {
                        $devis_index = 1;
                    }

                    //facture
                    if ((strcmp($value->nom, 'facture') == 0) && (strcmp($value->action, 'add') == 0)) {
                        $facture_add = 1;
                    }
                    if ((strcmp($value->nom, 'facture') == 0) && (strcmp($value->action, 'del') == 0)) {
                        $facture_del = 1;
                    }
                    if ((strcmp($value->nom, 'facture') == 0) && (strcmp($value->action, 'index') == 0)) {
                        $facture_index = 1;
                    }

                    //product
                    if ((strcmp($value->nom, 'product') == 0) && (strcmp($value->action, 'add') == 0)) {
                        $product_add = 1;
                    }
                    if ((strcmp($value->nom, 'product') == 0) && (strcmp($value->action, 'del') == 0)) {
                        $product_del = 1;
                    }
                    if ((strcmp($value->nom, 'product') == 0) && (strcmp($value->action, 'index') == 0)) {
                        $product_index = 1;
                    }

                    //fournisseur
                    if ((strcmp($value->nom, 'fournisseur') == 0) && (strcmp($value->action, 'add') == 0)) {
                        $fournisseur_add = 1;
                    }
                    if ((strcmp($value->nom, 'fournisseur') == 0) && (strcmp($value->action, 'del') == 0)) {
                        $fournisseur_del = 1;
                    }
                    if ((strcmp($value->nom, 'fournisseur') == 0) && (strcmp($value->action, 'index') == 0)) {
                        $fournisseur_index = 1;
                    }

                    //payement
                    if ((strcmp($value->nom, 'payement') == 0) && (strcmp($value->action, 'add') == 0)) {
                        $payement_add = 1;
                    }
                    if ((strcmp($value->nom, 'payement') == 0) && (strcmp($value->action, 'del') == 0)) {
                        $payement_del = 1;
                    }
                    if ((strcmp($value->nom, 'payement') == 0) && (strcmp($value->action, 'index') == 0)) {
                        $payement_index = 1;
                    }

                    //report
                    if ((strcmp($value->nom, 'report') == 0) && (strcmp($value->action, 'add') == 0)) {
                        $report_add = 1;
                    }
                    if ((strcmp($value->nom, 'report') == 0) && (strcmp($value->action, 'del') == 0)) {
                        $report_del = 1;
                    }
                    if ((strcmp($value->nom, 'report') == 0) && (strcmp($value->action, 'index') == 0)) {
                        $report_index = 1;
                    }

                    //setting
                    if ((strcmp($value->nom, 'setting') == 0) && (strcmp($value->action, 'add') == 0)) {
                        $setting_add = 1;
                    }
                    if ((strcmp($value->nom, 'setting') == 0) && (strcmp($value->action, 'del') == 0)) {
                        $setting_del = 1;
                    }
                    if ((strcmp($value->nom, 'setting') == 0) && (strcmp($value->action, 'index') == 0)) {
                        $setting_index = 1;
                    }
                }

                $session_data = array(
                    'user_type' => $user->user_type,
                    'user_id' => $user->user_id,
                    'user_name' => $user->user_name,
                    'user_mail' => $email,
                    'user_code' => $user->user_code,
                    'groupes_user_id' => $user->groupes_user_id,
                    'groupes_user_name' => $desig,
                    'cont_add' => $cont_add,
                    'cont_del' => $cont_del,
                    'cont_index' => $cont_index,
                    'devis_add' => $devis_add,
                    'devis_del' => $devis_del,
                    'devis_index' => $devis_index,
                    'facture_add' => $facture_add,
                    'facture_del' => $facture_del,
                    'facture_index' => $facture_index,
                    'product_add' => $product_add,
                    'product_del' => $product_del,
                    'product_index' => $product_index,
                    'fournisseur_add' => $fournisseur_add,
                    'fournisseur_del' => $fournisseur_del,
                    'fournisseur_index' => $fournisseur_index,
                    'payement_add' => $payement_add,
                    'payement_del' => $payement_del,
                    'payement_index' => $payement_index,
                    'report_add' => $report_add,
                    'report_del' => $report_del,
                    'report_index' => $report_index,
                    'setting_add' => $setting_add,
                    'setting_del' => $setting_del,
                    'setting_index' => $setting_index,
                   // 'foot' => $foot
                );
                $this->session->set_userdata($session_data);

                return TRUE;
            }
        }

        return FALSE;
    }
    
    
    

}
