<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cron
 *
 * @author Anis
 */
class cron extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function existDB($db)
    {
        $this->db->where("SCHEMA_NAME", $db);
        $this->db->select("SCHEMA_NAME, count(SCHEMA_NAME) as count");
        $db_selected = $this->db->get("INFORMATION_SCHEMA.SCHEMATA")->result();
        return $db_selected[0]->count == 0 ? false : true;
    }

    public function exportDb($dbname, $path)
    {

        $mysqlUserName = $this->db->username;
        $mysqlPassword = $this->db->password;
        $mysqlHostName = $this->db->hostname;
        $mysqlExportPath = $path;
        $command = 'mysqldump --opt -h' . $mysqlHostName . ' -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $dbname . ' > ' . $mysqlExportPath;

        exec($command, $output = array(), $worked);
        if ($worked == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function cron_dbs()
    {
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('superadmin');
        $abonnees = get_list_abonnees();
        $settings = get_settings_superadmin();
       
        //if ($_SERVER["REMOTE_ADDR"] == $settings['ip_serveur']) {
            if ($_SERVER["SERVER_ADDR"] == $settings['ip_serveur']) {
            //    return die('1');
            $list_clients = "";
            foreach ($abonnees as $abonnee) {
                if ($this->existDB($abonnee->database)) {
                    if (!is_dir("./uploads/" . strtolower($abonnee->licence_key))) {
                        mkdir("./uploads/" . strtolower($abonnee->licence_key), 0777);
                    }
                    if (!is_dir("./uploads/" . strtolower($abonnee->licence_key) . "/backup")) {
                        mkdir("./uploads/" . strtolower($abonnee->licence_key) . "/backup", 0777);
                    }
                    $dirname = "./uploads/" . strtolower($abonnee->licence_key) . "/backup/";
                    $sql_name = date("Ymd_His") . ".sql";
                    $this->exportDb($abonnee->database, $dirname . $sql_name);
                    $files_sql[$abonnee->licence_key] = $dirname . $sql_name;
                    $list_clients .= "- " . $abonnee->licence_key . " <br>";
                }
            }
            if (!is_dir("./uploads/backup_dbs")) {
                mkdir("./uploads/backup_dbs", 0777);
            }          
            $zip_name = "./uploads/backup_dbs/" . date("Y-m-d H-i-s") . ".zip";           
            create_zip_files($files_sql, $zip_name);
            
            $from = $settings['noreplay_mail'];
            $to = $settings['backup_mail'];

            $subject = "Liste des Bases de données " . date("d/m/Y");
            $message = "Liste des Bases de données pour les clients suivants : <br>" . $list_clients;
            $array[] = $zip_name;

            phpmail_send($from, 'oussema@novatis.tn', $subject, $message, $array);
        }
    }

    public function update_databases()
    {
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('superadmin');
        $abonnees = get_list_abonnees();
        foreach ($abonnees as $abonnee) {
            if ($this->existDB($abonnee->database)) {
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
                $config_db['database_orig'] = $this->db->database_orig;
                $old_database = $this->db->database;
                $config_db['database'] = $abonnee->database;
                $this->db = $this->load->database($config_db, true);
                $sql = "
CREATE TABLE IF NOT EXISTS `ip_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_action` varchar(255) NOT NULL,
  `log_date` datetime NOT NULL,
  `log_ip` varchar(255) NOT NULL,
  `log_user_id` int(11) NOT NULL,
  `log_field1` varchar(255) NOT NULL,
  `log_field2` varchar(255) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

                $this->db->query($sql);
                // LOAD DATABASE ORIGINE
                $config_db['database'] = $old_database;
                $this->db = $this->load->database($config_db, true);
            }
        }
    }

}