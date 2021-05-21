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

class Sessions extends Base_Controller {

    public function index() {
        redirect('sessions/licence');
    }

    public function licence() {

        $this->load->helper('cookie');
        $view_data = array();
        if ($this->isConnectedLicence()) {
            redirect('sessions/login');
        }

        if ($this->input->post('btn_licence')) {
            $licence = $this->input->post('licence');
            $this->db->where('licence_key', $licence);
            $query = $this->db->get('ab_abonnes')->result();
            if (!empty($query)) {
                $this->db->where('SCHEMA_NAME', $query[0]->database);
                $this->db->select('SCHEMA_NAME');
                $query2 = $this->db->get('INFORMATION_SCHEMA.SCHEMATA')->result();
                if (!empty($query2)) {

                    if ($query[0]->statut == 1) {
                        $licencedata = array(
                            'licence' => $licence,
                            'database' => $query[0]->database,
                            'logged_in_licence' => TRUE
                        );
                        $this->session->set_userdata($licencedata);
                        redirect('sessions/login');
                    } else {
                        $view_data = array(
                            'error_message' => "Votre Compte est bloqu&eacute;"
                        );
                    }
                } else {
                    $view_data = array(
                        'error_message' => "Erreur Connexion config"
                    );
                }
            } else {
                $view_data = array(
                    'error_message' => "Erreur Code client"
                );
            }
        }

        $this->load->view('session_licence', $view_data);
    }

    public function isConnectedLicence() {
        return $this->session->userdata('logged_in_licence');
    }

    public function login() {
//noreply@erp.bison.tn
//notification@erp.bison.tn
//        $from_email_def = "noreply@erp.bison.tn";

        $code_client = $this->session->userdata['licence'];
        ;
        $this->load->helper('superadmin');
        $settings = get_settings_superadmin();

        $from_email_def = array($settings['noreplay_mail'], $settings['from_name']);
        if (!$this->isConnectedLicence()) {
            redirect('sessions/licence');
        }

        $this->load->helper('cookie');
        $this->load->helper('mailer/phpmailer');
        $this->load->model('activites/mdl_activites');

        $view_data = array(
            'login_logo' => $this->mdl_settings->setting('login_logo')
        );

        if ($this->input->post('btn_login')) {

            $this->db->where('user_email', $this->input->post('email'));
            $query = $this->db->get('ip_users');
            $user = $query->row();
            $pat = $this->router->uri->config->config;

//            echo '<pre>';print_r($user);echo '</pre>';
            // die();
            // Check if the user exists
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if (getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if (getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if (getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if (getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
            else if (getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';


            if (empty($user)) {
                $from = $from_email_def;
                $to = $this->mdl_settings->setting('mail_admin');
                $message = $this->input->post('email') . " cherche a se connecter à :" . $pat['base_url'] . " de l'adresse IP :" . $ipaddress . " avec la remarque: " . lang('loginalert_user_not_found');
                phpmail_send($from, $to, 'Tentative de connexion', $message);
                $this->session->set_flashdata('flashError', lang('loginalert_user_not_found'));
                $this->session->set_flashdata('alert_error', lang('loginalert_user_not_found'));
                $this->session->keep_flashdata('alert_error', lang('loginalert_user_not_found'));
                header("Refresh:0");
            } else {

                // Check if the user is marked as active
                if ($user->user_active == 0) {
                    $from = $from_email_def;
                    $to = $this->mdl_settings->setting('mail_admin');
                    $message = $this->input->post('email') . " cherche a se connecter à :" . $pat['base_url'] . " de l'adresse IP :" . $ipaddress . " avec la remarque: " . lang('loginalert_user_inactive');
                    phpmail_send($from, $to, 'Tentative de connexion', $message);
                    $this->session->set_flashdata('flashError', lang('loginalert_user_inactive'));
                    $this->session->set_flashdata('alert_error', lang('loginalert_user_inactive'));
                    $this->session->keep_flashdata('alert_error', lang('loginalert_user_inactive'));
                    header("Refresh:0");
                } else {

                    if ($this->authenticate($this->input->post('email'), $this->input->post('password'))) {
                        $this->db->where('user_email', $this->input->post('email'));
                        $query = $this->db->get('ip_users')->result();
                        session_destroy();
                        setcookie('ci_session', '', time() - 864000, '/');
                        setcookie('ci_session', '', time() - 864000, base_url() . '/');
                        $from = $from_email_def;
                        $to = $this->mdl_settings->setting('mail_admin');
//                        $message = $this->input->post('email') . " cherche a se connecter à :" . $pat['base_url'] . " de l'adresse IP :" . $ipaddress . " avec succée. ";
                        $subject = "Notification de connexion à votre compte: [" . $code_client . "]";
                        $message = "
                            <div style='width:95%;margin:20px auto;' align:center;>
                            <div style='font-size:12px;float:right'>Le 2016-05-20 11:16:04</div>
                            <div style='clear:both'></div>
                            <div style='font-size:12px;font-family:arial;'
                            Madame, Monsieur,<br>

                            Nous vous envoyons cet email à la suite d'une connexion réussie à votre interface de gestion BisonERP.
                            <br><br>
                            <div style='margin-left:20px;'>
                                Identifiant client  : [" . $code_client . "]<br>
                                Email de connexion: " . $this->input->post('email') . "<br>
                                Ip de connexion     : " . $ipaddress . "<br>
                                Heure de connexion  : " . date("Y-m-d H:i:s") . "<br>
                            </div>
                            <br><br>
                            Cet email est destiné à vous sensibiliser à la sécurité des services que vous avez chez BISON  et à mieux les protéger.
                            <br>
                            Pour modifier les réglages de ces alertes, rendez-vous dans votre espace client : https://erp.bison.tn/settings
                            <br><br>


                            Nous vous remercions pour la confiance que vous accordez à BisonERP et restons à votre disposition.
                            <br><br>
                            Cordialement,<br>
                            Support Client BisonERP<br><br>

                            Support Commercial et Technique : 70 737 903 | 74 402 494<br>
                            Email:support@bison.tn	 <br>
                            Du lundi au vendredi : 8h - 17h<br>
                            Le samedi : 8h - 14h</div></div>
                            ";
                        phpmail_send($from, $to, $subject, $message);

                        //insertion ds log
                        if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == FALSE) {
                            $data_log = array(
                                "log_action" => "login",
                                "log_date" => date('Y-m-d H:i:s'),
                                "log_ip" => $this->session->userdata['ip_address'],
                                "log_user_id" => $query[0]->user_id,
                            );
                            $this->db->insert('ip_logs', $data_log);
                        }
                        $this->session->set_flashdata('flashSuccess', 'This is a success message.');

                        redirect('dashboard');
                    } else {
                        $from = $from_email_def;
                        $to = $this->mdl_settings->setting('mail_admin');
                        $message = $this->input->post('email') . " cherche a se connecter avec la remarque: " . lang('loginalert_credentials_incorrect');
                        phpmail_send($from, $to, 'Tentative de connexion', $message);
                        $this->session->set_flashdata('flashError', lang('loginalert_credentials_incorrect'));
                        $this->session->set_flashdata('alert_error', lang('loginalert_credentials_incorrect'));
                        $this->session->keep_flashdata('alert_error', lang('loginalert_credentials_incorrect'));
                        header("Refresh:0");
                    }
                }
            }
        }

        $this->load->view('session_login', $view_data);
    }

    public function logout() {
        $this->load->helper('cookie');
        // print_r($this->session->userdata);die;
        if ($this->session->userdata['user_code']) {
            if (!isset($this->session->userdata['superadmin']) || $this->session->userdata['superadmin'] == FALSE) {
                $data_log = array(
                    "log_action" => "logout",
                    "log_date" => date('Y-m-d H:i:s'),
                    "log_ip" => $this->session->userdata['ip_address'],
                    "log_user_id" => $this->session->userdata['user_id'],
                );
                $this->db->insert('ip_logs', $data_log);
            }
        }
        $this->session->sess_destroy();

        session_destroy();
        setcookie('ci_session', '', time() - 864000, '/');
        setcookie('ci_session', '', time() - 864000, base_url() . '/');

        redirect('sessions/login');
    }

    public function authenticate($email_address, $password) {
        $this->load->model('mdl_sessions');

        if ($this->mdl_sessions->auth($email_address, $password)) {
            return TRUE;
        }

        return FALSE;
    }

    public function passwordreset($token = NULL) {
        // Check if a token was provided
        if ($token) {
            $this->db->where('user_passwordreset_token', $token);
            $user = $this->db->get('ip_users');
            $user = $user->row();

            if (empty($user)) {
                // Redirect back to the login screen with an alert
                $this->session->set_flashdata('alert_success', lang('wrong_passwordreset_token'));
                redirect('sessions/login');
            }

            $formdata = array(
                'user_id' => $user->user_id
            );

            return $this->load->view('session_new_password', $formdata);
        }

        // Check if the form for a new password was used
        if ($this->input->post('btn_new_password')) {
            $new_password = $this->input->post('new_password');
            $user_id = $this->input->post('user_id');

            if (empty($user_id) || empty($new_password)) {
                $this->session->set_flashdata('alert_error', lang('loginalert_no_password'));
                redirect($_SERVER['HTTP_REFERER']);
            }

            // Call the save_change_password() function from users model
            $this->load->model('users/mdl_users');
            $this->mdl_users->save_change_password(
                    $user_id, $new_password
            );

            // Update the user and set him active again
            $db_array = array(
                'user_passwordreset_token' => '',
            );

            $this->db->where('user_id', $user_id);
            $this->db->update('ip_users', $db_array);

            // Redirect back to the login form
            redirect('sessions/login');
        }

        // Check if the password reset form was used
        if ($this->input->post('btn_reset')) {
            $email = $this->input->post('email');
            if (empty($email)) {
                $this->session->set_flashdata('alert_error', lang('loginalert_user_not_found'));
                redirect($_SERVER['HTTP_REFERER']);
            }

            // Test if a user with this email exists
            if ($this->db->where('user_email', $email)) {
                // Create a passwordreset token
                $email = $this->input->post('email');
                $token = md5(time() . $email);
                $session_data = array(
                    'user_mail' => $email
                );

                $this->session->set_userdata($session_data);
                // Save the token to the database and set the user to inactive
                $db_array = array(
                    'user_passwordreset_token' => $token,
                );

                $this->db->where('user_email', $email);
                $this->db->update('ip_users', $db_array);

                // Send the email with reset link
                $this->load->library('email');

                // Preprare some variables for the email
                $email_resetlink = base_url() . 'sessions/passwordreset/' . $token;
                $email_message = $this->load->view('emails/passwordreset', array(
                    'resetlink' => $email_resetlink
                        ), TRUE);
                $email_from = 'system@' . preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", "$1", base_url());

                // Set email configuration
                $config['mailtype'] = 'html';
                $this->email->initialize($config);

                // Set the email params
                $this->email->from($email_from);
                $this->email->to($email);
                $this->email->subject(lang('password_reset'));
                $this->email->message($email_message);

                // Send the reset email
                $this->email->send();

                // Redirect back to the login screen with an alert
                $this->session->set_flashdata('alert_success', lang('email_successfully_sent'));
                redirect('sessions/login');
            }
        }

        return $this->load->view('session_passwordreset');
    }

}
