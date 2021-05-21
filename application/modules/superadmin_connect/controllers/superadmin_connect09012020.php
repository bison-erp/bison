<?php

class superadmin_connect extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function existDB($db) {
        $this->db->where("SCHEMA_NAME", $db);
        $this->db->select("SCHEMA_NAME, count(SCHEMA_NAME) as count");
        $db_selected = $this->db->get("INFORMATION_SCHEMA.SCHEMATA")->result();
        return $db_selected[0]->count == 0 ? false : true;
    }

    public function index($licence = NULL) {
        $licences_denied = array("lvfi", "0007");
      /*  if (in_array($licence, $licences_denied)) {
            exit();
        }*/
        session_start();
        if (isset($_SESSION['app_erp']) && isset($_SESSION['app_erp']['superadmin_id']) && isset($_SESSION['app_erp']['logged']) && $_SESSION['app_erp']['superadmin_id'] == 1) {





            $config_db['hostname'] = $this->db->hostname;
            $config_db['username'] = $this->db->username;
            $config_db['password'] = $this->db->password;
            $config_db['dbdriver'] = $this->db->dbdriver;
            $config_db['dbprefix'] = $this->db->dbprefix;
            $config_db['pconnect'] = $this->db->pconnect;
            $config_db['db_debug'] = $this->db->db_debug;
            $config_db['cache_on'] = $this->db->cache_on;
            $config_db['cachedir'] = $this->db->cachedir;
            $config_db['char_set'] = $this->db->char_set;
            $config_db['dbcollat'] = $this->db->dbcollat;
            $config_db['swap_pre'] = $this->db->swap_pre;
            $config_db['autoinit'] = $this->db->autoinit;
            $config_db['stricton'] = $this->db->stricton;

            $old_database = $this->db->database;


            $config_db['database'] = $this->db->database_orig;
            $config_db['database_orig'] = $this->db->database_orig;
            $this->db = $this->load->database($config_db, TRUE);


            $this->db->where("ab_abonnes.licence_key", $licence);
            $this->db->select("*");

            $abonnee = $this->db->get("ab_abonnes")->result();

            if (!empty($abonnee)) {

                if ($this->existDB($abonnee[0]->database)) {

                    $config_db['database'] = $abonnee[0]->database;
                    $this->db = $this->load->database($config_db, TRUE);

                    echo $this->db->database;

                    $this->db->order_by("user_id", "asc");
                    $users = $this->db->get("ip_users")->result();
                    $user = $users[0];

//                    $this->session->sess_destroy();

                    $licencedata = array(
                        'licence' => $licence,
                        'database' => $abonnee[0]->database,
                        'logged_in_licence' => TRUE,
                        'superadmin' => TRUE,
                    );
                    $this->session->set_userdata($licencedata);




                    $session_data = array(
                        'user_type' => $user->user_type,
                        'user_id' => $user->user_id,
                        'user_name' => $user->user_name,
                        'user_mail' => $user->user_email,
                        'user_code' => $user->user_code,
                        'groupes_user_id' => $user->groupes_user_id,
                        'groupes_user_name' => '',
                        'cont_add' => 1,
                        'cont_del' => 1,
                        'cont_index' => 1,
                        'devis_add' => 1,
                        'devis_del' => 1,
                        'devis_index' => 1,
                        'facture_add' => 1,
                        'facture_del' => 1,
                        'facture_index' => 1,
                        'product_add' => 1,
                        'product_del' => 1,
                        'product_index' => 1,
                        'fournisseur_add' => 1,
                        'fournisseur_del' => 1,
                        'fournisseur_index' => 1,
                        'payement_add' => 1,
                        'payement_del' => 1,
                        'payement_index' => 1,
                        'report_add' => 1,
                        'report_del' => 1,
                        'report_index' => 1,
                        'setting_add' => 1,
                        'setting_del' => 1,
                        'setting_index' => 1,
                    );
                    $this->session->set_userdata($session_data);
                }
            } else {
                // LOAD DATABASE ORIGINE
                $config_db['database'] = $old_database;
                $this->db = $this->load->database($config_db, TRUE);
            }
        } else {
//            echo "Not connected";
        }
        redirect();
    }

    public function getLicenceConnected() {
        session_start();

        if (isset($_SESSION['app_erp']) && isset($_SESSION['app_erp']['superadmin_id']) && isset($_SESSION['app_erp']['logged']) && $_SESSION['app_erp']['superadmin_id'] == 1) {
            $data_array = array(
                'connected' => FALSE,
                'licence_connected' => ''
            );
            if (isset($this->session->userdata['superadmin']) && $this->session->userdata['superadmin'] == TRUE && isset($this->session->userdata['logged_in_licence']) && $this->session->userdata['logged_in_licence'] == TRUE && isset($this->session->userdata['user_id'])) {
                $data_array = array(
                    'connected' => TRUE,
                    'licence_connected' => $this->session->userdata['licence']
                );
            }
            echo json_encode($data_array);
        }
    }

    public function updateDatabases() {
        session_start();
        $final_results = array();
        $id = $this->input->post('id');
        if ($id != NULL && isset($_SESSION['app_erp']) && isset($_SESSION['app_erp']['superadmin_id']) && isset($_SESSION['app_erp']['logged']) && $_SESSION['app_erp']['superadmin_id'] == 1) {

            $this->load->helper('superadmin');
            $abonnees = get_list_abonnees();
            $config_db['hostname'] = $this->db->hostname;
            $config_db['username'] = $this->db->username;
            $config_db['password'] = $this->db->password;
            $config_db['dbdriver'] = $this->db->dbdriver;
            $config_db['dbprefix'] = $this->db->dbprefix;
            $config_db['pconnect'] = $this->db->pconnect;
            $config_db['db_debug'] = $this->db->db_debug;
            $config_db['cache_on'] = $this->db->cache_on;
            $config_db['cachedir'] = $this->db->cachedir;
            $config_db['char_set'] = $this->db->char_set;
            $config_db['dbcollat'] = $this->db->dbcollat;
            $config_db['swap_pre'] = $this->db->swap_pre;
            $config_db['autoinit'] = $this->db->autoinit;
            $config_db['stricton'] = $this->db->stricton;
            $old_database = $this->db->database;

            $config_db['database'] = $this->db->database_orig;
            $config_db['database_orig'] = $this->db->database_orig;
            $this->db = $this->load->database($config_db, TRUE);

            $this->db->where("id", $id);

            $updates = $this->db->get("ab_updates")->result();
            if (!empty($updates)) {
                $query_db = $updates[0]->database_query;


                foreach ($abonnees as $abonnee) {
                    $config_db['database'] = $abonnee->database;
                    $this->db = $this->load->database($config_db, TRUE);
                    if ($this->db->query($query_db)) {
                        $final_results[$abonnee->licence_key] = true;
                    } else {
                        $final_results[$abonnee->licence_key] = false;
                    }
                }
            }
            echo json_encode($final_results);
        } else {
            redirect();
        }
    }

}
