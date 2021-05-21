<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function get_list_abonnees() {
    $ci = get_instance();
    $config_db['hostname'] = $ci->db->hostname;
    $config_db['username'] = $ci->db->username;
    $config_db['password'] = $ci->db->password;
    $config_db['dbdriver'] = $ci->db->dbdriver;
    $config_db['dbprefix'] = $ci->db->dbprefix;
    $config_db['pconnect'] = $ci->db->pconnect;
    $config_db['db_debug'] = $ci->db->db_debug;
    $config_db['cache_on'] = $ci->db->cache_on;
    $config_db['cachedir'] = $ci->db->cachedir;
    $config_db['char_set'] = $ci->db->char_set;
    $config_db['dbcollat'] = $ci->db->dbcollat;
    $config_db['swap_pre'] = $ci->db->swap_pre;
    $config_db['autoinit'] = $ci->db->autoinit;
    $config_db['stricton'] = $ci->db->stricton;

    $old_database = $ci->db->database;

    // LOAD DATABASE DES ABONNEES
    $config_db['database'] = $ci->db->database_orig;
    $config_db['database_orig'] = $ci->db->database_orig;
    $ci->db = $ci->load->database($config_db, TRUE);

    $abonnees = $ci->db->get("ab_abonnes")->result();


    // LOAD DATABASE ORIGINE
    $config_db['database'] = $old_database;
    $ci->db = $ci->load->database($config_db, TRUE);
    return $abonnees;
}

function get_settings_superadmin(){
        $ci = get_instance();
    $config_db['hostname'] = $ci->db->hostname;
    $config_db['username'] = $ci->db->username;
    $config_db['password'] = $ci->db->password;
    $config_db['dbdriver'] = $ci->db->dbdriver;
    $config_db['dbprefix'] = $ci->db->dbprefix;
    $config_db['pconnect'] = $ci->db->pconnect;
    $config_db['db_debug'] = $ci->db->db_debug;
    $config_db['cache_on'] = $ci->db->cache_on;
    $config_db['cachedir'] = $ci->db->cachedir;
    $config_db['char_set'] = $ci->db->char_set;
    $config_db['dbcollat'] = $ci->db->dbcollat;
    $config_db['swap_pre'] = $ci->db->swap_pre;
    $config_db['autoinit'] = $ci->db->autoinit;
    $config_db['stricton'] = $ci->db->stricton;

    $old_database = $ci->db->database;

    // LOAD DATABASE DES ABONNEES
    $config_db['database'] = $ci->db->database_orig;
    $config_db['database_orig'] = $ci->db->database_orig;
    $ci->db = $ci->load->database($config_db, TRUE);
//    $ci->mdl_settings->load_settings();
    $settings = array();
    $settings_all = $ci->db->get('ip_settings')->result();
    if(!empty($settings_all)){
        foreach($settings_all as $set){
            $settings[$set->setting_key] = $set->setting_value;
        }
    }
    
//    
//    $settings['noreplay_mail'] = $ci->mdl_settings->setting('noreplay_mail');
//    $settings['backup_mail'] = $ci->mdl_settings->setting('backup_mail');


    // LOAD DATABASE ORIGINE
    $config_db['database'] = $old_database;
    $ci->db = $ci->load->database($config_db, TRUE);
    return $settings;
}

function create_zip_files($files = array(), $zipFileName) {

    if (!empty($files)) {
        $zip = new ZipArchive();
        $zip_archive = $zip->open($zipFileName, ZIPARCHIVE::CREATE);
        if ($zip_archive === true) {
            foreach ($files as $key => $file) {
                @$zip->addFile(realpath($file), $key."_".basename($file));
            }
        }
        $zip->close();
    }


}

?>