<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function abonnement()
{
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
    $ci->db = $ci->load->database($config_db, true);
    $licence = $ci->session->userdata['licence'];

    $ci->db->where("ab_abonnes.licence_key", $licence);
    $ci->db->join('ab_packs', 'ab_packs.pack_id = ab_abonnes.pack_id', 'left');
    $ci->db->select("ab_packs.*");
    $abonnee = $ci->db->get("ab_abonnes")->result();

    // LOAD DATABASE ORIGINE
    $config_db['database'] = $old_database;
    $ci->db = $ci->load->database($config_db, true);

    return $abonnee[0];
}

function getNumberCollaborateur()
{
    $ci = get_instance();
    $ci->db->select("count(user_id) as nb_users");
    $nb_users = $ci->db->get("ip_users")->result();
    return !empty($nb_users) ? $nb_users[0]->nb_users : 0;
}
function rightsAddnbcollaborateurs()
{
    $max_col = abonnement()->nb_collaborateurs_3;
    if ($max_col == "-1") {
        return true;
    } else {
        $nb_coll = rightsAddnbcollaborateurs();
        if ($nb_coll >= $max_col) {
            return false;
        } else {
            return true;
        }
    }
}
function rightsAddCollaborateur()
{
    $max_col = abonnement()->nb_collaborateurs;
    if ($max_col == "-1") {
        return true;
    } else {
        $nb_coll = getNumberCollaborateur();
        if ($nb_coll >= $max_col) {
            return false;
        } else {
            return true;
        }
    }
}

function getNumbercontacts()
{
    $ci = get_instance();
    $max_col = abonnement()->nb_contacts_rad;
    if ($max_col == "-1") {
        return true;
    } else {
        $nb_coll = getNumbercontacts();
        if ($nb_coll >= $max_col) {
            return false;
        } else {
            return true;
        }
    }
}

function getNumberFacturesThisMonth()
{
    $ci = get_instance();
    $ci->db->where("MONTH(ip_invoices.invoice_date_created) = MONTH(NOW()) AND YEAR(ip_invoices.invoice_date_created) = YEAR(NOW())");
    $ci->db->select("count(invoice_id) as count_factures");
    $invoices = $ci->db->get("ip_invoices")->result();
    return !empty($invoices) ? $invoices[0]->count_factures : 0;
}

function rightsAddFacture()
{

    $max_factures = abonnement()->nb_factures_mois;
    if ($max_factures == "-1") {
        return true;
    } else {
        $count = getNumberFacturesThisMonth();
        if ($count >= $max_factures) {
            return false;
        } else {
            return true;
        }

    }
}

function getNumberDevisThisMonth()
{
    $ci = get_instance();
    $ci->db->where("MONTH(ip_quotes.quote_date_created) = MONTH(NOW())AND YEAR(ip_quotes.quote_date_created) = YEAR(NOW())");
    $ci->db->select("count(quote_id) as count_devis");
    $quotes = $ci->db->get("ip_quotes")->result();
    return !empty($quotes) ? $quotes[0]->count_devis : 0;
}

function rightsAddDevis()
{

    $max_devis = abonnement()->nb_devis_mois;
    if ($max_devis == "-1") {
        return true;
    } else {
        $count = getNumberDevisThisMonth();
        if ($count >= $max_devis) {
            return false;
        } else {
            return true;
        }

    }
}
function rightsAddfacturemois()
{

    $nb_factures_mois_3 = abonnement()->nb_factures_mois_3;
    if ($nb_factures_mois_3 == "-1") {
        return true;
    } else {
        $count = rightsAddfacturemois();
        if ($count >= $nb_factures_mois_3) {
            return false;
        } else {
            return true;
        }

    }
}
function rightsAddDevismois()
{

    $nb_devis_mois_3 = abonnement()->nb_devis_mois_3;
    if ($nb_devis_mois_3 == "-1") {
        return true;
    } else {
        $count = rightsAddDevismois();
        if ($count >= $nb_devis_mois_3) {
            return false;
        } else {
            return true;
        }

    }
}
function rightsMultiDevises()
{
    $ci = get_instance();
    return abonnement()->multi_devises == 1 ? true : false;
}
 
function rightsExportLotPdf()
{
    $ci = get_instance();
    return abonnement()->export_lot_pdf == 1 ? true : false;
}

function rightsMultiSocietes()
{
    $ci = get_instance();
    return abonnement()->multi_societes == 1 ? true : false;
}

function rightsExportExcel()
{
    $ci = get_instance();
    return abonnement()->export_excel == 1 ? true : false;
}

function rightsExportcontact()
{
    $ci = get_instance();
    return abonnement()->export_contact == 1 ? true : false;
}

function relanceautomatique()
{
    $ci = get_instance();
    return abonnement()->relance == 1 ? true : false;
}

function signature()
{
    $ci = get_instance();
    return abonnement()->signature == 1 ? 1 : 0;
}

function gestionstock()
{
    $ci = get_instance();
    return abonnement()->gestionstock == 1 ? true : false;
}

// Verif si un fichier existe
function getHTTPStatus($url)
{
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_VERBOSE => false,
    ));
    curl_exec($ch);
    $http_status = curl_getinfo($ch);
    return $http_status;
}

function getGroupuser($id)
{
    $ci = get_instance();
    $ci->db->where("user_id", $id);

    $ci->db->select("groupes_user_id");
    $ip_users = $ci->db->get("ip_users")->result();
    return $ip_users[0]->groupes_user_id == 1 ? 0 : 1;
}

function getVersionsApp()
{
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
    $ci->db = $ci->load->database($config_db, true);

    $ci->db->order_by("id", "DESC");
    $updates = $ci->db->get("ab_updates")->result();

    // LOAD DATABASE ORIGINE
    $config_db['database'] = $old_database;
    $ci->db = $ci->load->database($config_db, true);

    return $updates;
}