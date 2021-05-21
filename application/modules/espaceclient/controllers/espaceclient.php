<?php
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

class Espaceclient extends Base_Controller 
{ 
   
    public function __construct()
    {   
        parent::__construct();
    }

    public function commande()
    {   //$id = $this->input->post('id_forms');
      /*  if(!$id){
            show_404();
        }    */ 
        $data=array();
        
        $data['query'] = $this->get_list_ab_packs();     
        $this->load->view('espaceclient/form', $data);
    }

    public function detailcommande()
    { 
      //   $this->load->helper('cookie');
       //
        $data=array();
      //  $data = ['nb_collaborateurs_3'=>$this->input->post('nb_collaborateurs_3')];
     //return var_dump($this->input->post('nb_collaborateurs_3'));die('1');
     //setcookie('data',$data, time() + 365*24*3600, null, null, false, true);
    
     if($_COOKIE['mail']){
         $this->sendmailcontact($_COOKIE['mail']);
     }
     $data['query'] = $this->get_list_ab_packs()[count($this->get_list_ab_packs())-1];     
     $this->load->view('espaceclient/detail',$data);
 
    }

    public function get_list_ab_packs()
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

        // LOAD DATABASE DES ab_packs
        $config_db['database'] = $ci->db->database_orig;
        $config_db['database_orig'] = $ci->db->database_orig;
        $ci->db = $ci->load->database($config_db, true);

        $ab_packs = $ci->db->get("ab_packs")->result();
        
        // LOAD DATABASE ORIGINE
        $config_db['database'] = $old_database;
        $ci->db = $ci->load->database($config_db, true);
        return $ab_packs;
    }

    
    function sendmailcontact(){     

        $mail=$this->input->post('mail'); 
        $CI = get_instance();
        $CI->load->helper('mailer/phpmailerhelperrelance');
        $from= $this->getmailfrom();      
        $subject="confirmation mail";      
        $attachment_path = array();  
        $created = date("Y-m-d H:i:s");           
      //  return var_dump($datefin);die('1');
        $var=sha1($mail);
         if($this->existemail($var)){
           setcookie('periode_abonnement', $this->input->post('periode_abonnement'), time() + 365*24*3600, null, null, false, true); 
           setcookie('delaisexpiration', $this->input->post('delaisexpiration'), time() + 365*24*3600, null, null, false, true); 
           setcookie('nbcoll', $this->input->post('nbcoll'), time() + 365*24*3600, null, null, false, true); 
           setcookie('nb_collaborateurs_3', $this->input->post('nb_collaborateurs_3'), time() + 365*24*3600, '/', null, false, true); 
           setcookie('nb_contacts_rad', $this->input->post('nb_contacts_rad'), time() + 365*24*3600, null, null, false, true);  
           setcookie('nb_factures_mois_3', $this->input->post('nb_factures_mois_3'), time() + 365*24*3600, null, null, false, true);  
           setcookie('nb_devis_mois_3', $this->input->post('nb_devis_mois_3'), time() + 365*24*3600, null, null, false, true);  
           setcookie('multi_devises', $this->input->post('multi_devises'), time() +365*24*3600, null, null, false, true);  
           setcookie('export_lot_pdf', $this->input->post('export_lot_pdf'), time() + 365*24*3600, null, null, false, true);  
           setcookie('export_excel', $this->input->post('export_excel'), time() +365*24*3600, null, null, false, true);  
           setcookie('relance', $this->input->post('relance'), time() + 365*24*3600, null, null, false, true);  
           setcookie('gestionstock', $this->input->post('gestionstock'), time() + 365*24*3600, null, null, false, true);  
           setcookie('sgstock', $this->input->post('sgstock'), time() +365*24*3600, null, null, false, true);  
           setcookie('nbfact', $this->input->post('nbfact'), time() +365*24*3600, null, null, false, true);  
           setcookie('nbcontact', $this->input->post('nbcontact'), time() + 365*24*3600, null, null, false, true);  
           setcookie('nbdevis', $this->input->post('nbdevis'), time() + 365*24*3600, null, null, false, true);  
           setcookie('nbdocuments', $this->input->post('nbdocuments'), time() + 365*24*3600, null, null, false, true);  
           setcookie('exportpdf', $this->input->post('exportpdf'), time() + 365*24*3600, null, null, false, true);  
           setcookie('etabplus', $this->input->post('etabplus'), time() +365*24*3600, null, null, false, true);  
           setcookie('expodonn', $this->input->post('expodonn'), time() +365*24*3600, null, null, false, true);  
           setcookie('txtrelance', $this->input->post('txtrelance'), time() + 365*24*3600, null, null, false, true);  
           setcookie('expocontact', $this->input->post('expocontact'), time() + 365*24*3600, null, null, false, true);  
           setcookie('mail', $this->input->post('mail'), time() +365*24*3600, null, null, false, true);       
        $message = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body>';
        $message.='<a target="_blank" href="'.base_url().'./espaceclient/activationcompte/'.$var.'">Please click this link to activate your account!</a>';
        $message.='</body></html>';
   
        $sqlquote = "INSERT INTO `oussema_erpbison`.`ab_pres_compte` ( `email` , `user_psalt`,`active`,`date`)  VALUES (
        '$mail', '$var','0','$created')";
         
     $this->db->query($sqlquote) ;

     phpmail_send($from, $mail, $ip_settingsval= null, $subject, $message, $attachment_path , $cc = null, $bcc=null);
     return die('1');
    }
} 
 

    function activationcompte($shlmail){ 
         $date_expiration=date('Y-m-d', strtotime(date("Y-m-d") . " +" . $_COOKIE['delaisexpiration'] . " month"));
      
         if(!$shlmail){
            show_404();
        }else{
            $sql1 = "SELECT * FROM `oussema_erpbison`.`ab_pres_compte` where  `user_psalt`='$shlmail'";
            $resul1 = $this->db->query($sql1)->result();    
            if(count($resul1)==0){
                show_404();
            }else{       
               
        $sql = "SELECT * FROM `oussema_erpbison`.`ab_pres_compte` where `active` = '0' and `user_psalt`='$shlmail'";
        $resul = $this->db->query($sql)->result();    
        if(count($resul)>0){
        $periode_abonnement= $_COOKIE["periode_abonnement"];
        $sqlquote = " UPDATE `oussema_erpbison`.`ab_pres_compte` SET  `active` = '1',`date_expiration` = '$date_expiration',`periode_abonnement`='$periode_abonnement' WHERE `ab_pres_compte`.`user_psalt` ='$shlmail'";
        $this->db->query($sqlquote) ;     
        } 
    }     redirect('espaceclient/createclient');
    }
}
    function getmailfrom(){
        $sql = "SELECT * FROM `oussema_erpbison`.`ip_settings` where  `setting_key` = 'noreplay_mail'";
        $result = $this->db->query($sql)->result();
        return ($result[0]->setting_value);       
    }

    function existemail($shlmail){
        
        $sql = "SELECT * FROM `oussema_erpbison`.`ab_pres_compte` where `user_psalt`='$shlmail'";
        $resul = $this->db->query($sql)->result();    
         
         if(count($resul)>0 && ($resul[0]->active=1)){
            return false ;
            $data=array();       
            redirect('espaceclient/createclient');
           
        } 
        return true;      
    }   
    function addClient()
    { 
      
        $nom=$this->input->post('nom'); 
        $prenom=$this->input->post('prenom'); 
        $website=$this->input->post('website'); 
        $email=$this->input->post('email'); 
        $telephone=$this->input->post('telephone'); 
        $mobile=$this->input->post('mobile'); 
        $fax=$this->input->post('fax'); 
        $ville=$this->input->post('ville'); 
        $code_postal=$this->input->post('code_postal'); 
        $pays=$this->input->post('pays'); 
        $adresse=$this->input->post('adresse'); 
        $societe=$this->input->post('societe'); 
        $matricule_fiscale=$this->input->post('matricule_fiscale'); 
        $registre_commerce=$this->input->post('registre_commerce'); 
        $password=$this->input->post('password'); 
        $password2=$this->input->post('password2');   
        $pack_id=$this->get_list_ab_packs()[count($this->get_list_ab_packs())-1]->pack_id;
        $status=1;   
        $created = date("Y-m-d H:i:s"); 
        $licence_key = $this->generateLicenceKey();
        $database = "oussema_" . strtolower($licence_key);
        $nb_collaborateurs_3=$_COOKIE['nb_collaborateurs_3'];
        $nb_factures_mois_3=$_COOKIE['nb_factures_mois_3'];
        $nb_devis_mois_3=$_COOKIE['nb_devis_mois_3'];
        $nb_contacts_rad =$_COOKIE['nb_contacts_rad'];
        $multi_devises=$_COOKIE['multi_devises'];
        $export_lot_pdf=$_COOKIE['export_lot_pdf'];
        $export_excel  = $_COOKIE['export_excel'];
        $relance = $_COOKIE['relance'];
        $gestionstock = $_COOKIE['gestionstock'];
        $query = "INSERT INTO `oussema_erpbison`.`ab_abonnes`(`nom`, `prenom`, `societe`, `email`, `adresse`, `complement`,`ville`, `code_postal`, `pays`, `telephone`, `mobile`, `fax`, `site_web`, `matricule_fiscale`, `registre_commerce`, `statut`, `created`, `database`, `licence_key`, `pack_id`,
         `relance`, `gestionstock`, `export_lot_pdf`,          
         `nb_collaborateurs`, `nb_contacts`, `nb_facture`,
         `nb_devis`, `doc_multidevises`, `export_excel`)
        VALUES('$nom','$prenom','$societe','$email','$adresse','','$ville','$code_postal','$pays','$telephone','$mobile','$fax','$website','$matricule_fiscale','$registre_commerce','$status','$created','$database','$licence_key','$pack_id',
        '$relance','$gestionstock','$export_lot_pdf','$nb_collaborateurs_3',
        '$nb_contacts_rad','$nb_factures_mois_3','$nb_devis_mois_3','$multi_devises','$export_excel')";
    //echo $query;
   
    $this->db->query($query) ;
    // dbSimpleExecute($query);
    
        if (!$this->existDB($database)) {
            $this->insertDbFirstTime($database);
        }
    
        $user_psalt = $this->salt();
        $user_password = $this->generate_password($password, $user_psalt);
    
    // AJOUTER LE COMPTE UTILISATEUR

        $fullname = $nom . " " . $prenom;
        $client_code = strtoupper(substr($nom, 0, 1) . substr($prenom, 0, 1));
        $query2 = "
    INSERT INTO " . $database . ".`ip_users` (`user_id`, `groupes_user_id`, `user_type`, `user_active`, `user_date_created`, `user_date_modified`, `user_name`, `user_code`, `user_company`, `user_address_1`, `user_address_2`, `user_city`, `user_state`, `user_zip`, `user_country`, `user_phone`, `user_fax`, `user_mobile`, `user_email`, `user_password`, `user_web`, `user_vat_id`, `user_tax_code`, `user_psalt`, `user_passwordreset_token`) VALUES
    (1, 1, 1, 1, '" . $created . "', '" . $created . "', '" . $fullname . "', '" . $client_code . "', '" . $societe . "', '" . $adresse . "', '', '" . $ville . "', '" . $pays . "', '" . $code_postal . "', 'TN', '" . $telephone . "', '" . $fax . "', '" . $mobile . "', '" . $email . "', '" . $user_password . "', '" . $website . "', '', '', '" . $user_psalt . "', '')
    ";

    $this->db->query($query2) ;// FIN AJOUTER LE COMPTE UTILISATEUR
        //
        // AJOUTER SOCIETE
        $query3 = "INSERT INTO " . $database . ".`ip_societes`(`raison_social_societes`, `code_tva_societes`, `tax_code`, `site_web_societes`, `mail_societes`, `fax_societes`, `note_societes`)
                VALUES ('" . $societe . "','" . $matricule_fiscale . "','" . $registre_commerce . "','" . $website . "','" . $email . "','" . $fax . "','')";
                $this->db->query($query3) ;
        $id_societe = mysql_insert_id();
        $query4 = "INSERT INTO " . $database . ".`ip_societe_adresse`(`id_societe`, `adresse`, `code_postal`, `ville`, `pays`, `telephone`)
            VALUES ('" . $id_societe . "','" . $adresse . "','" . $code_postal . "','" . $ville . "','" . $pays . "','" . $telephone . "')";
            $this->db->query($query4) ;
    // FIN AJOUTER SOCIETE

        $footer_pdf_defaut = '<center>Adresse : ' . $adresse . '<br> T&eacute;l: ' . $telephone . ' / ' . $mobile . '<br>\nT.V.A.: ' . $matricule_fiscale . ' - Fax: ' . $fax . ' - Email : ' . $email . ' - Site: ' . $website . '</center>';
        $query5 = "UPDATE " . $database . ".`ip_settings` SET `setting_value`= '" . $footer_pdf_defaut . "' WHERE `setting_key`='pdf_invoice_footer'";
        $this->db->query($query5) ;
        //'../superadmin/sql/default_erp.sql';
        mkdir("./uploads/" . strtolower($licence_key), 0777);
        mkdir("./uploads/" . strtolower($licence_key) . "/temp", 0777);
        copy("files/your-logo-here.png", "./uploads/" . strtolower($licence_key) . "/your-logo-here.png");
    //  return true;    
    /*$sqlquote = " UPDATE `oussema_erpbison`.`ab_pres_compte` SET  `active` = '0' WHERE `ab_pres_compte`.`user_psalt` ='$shlmail'";
        $this->db->query($sqlquote) ;   */
    return die('1'); 
    }


public function createclient(){
    $shlmail =  sha1($_COOKIE['mail']);
    $sql = "SELECT * FROM `oussema_erpbison`.`ab_pres_compte` where `active` = '1' and `user_psalt`='$shlmail'";
    $resul = $this->db->query($sql)->result();    
    if(count($resul)>0){   
    $data['query'] = $this->get_list_ab_packs()[count($this->get_list_ab_packs())-1];     
    $this->load->view('espaceclient/create', $data);
    }else{
        show_404();
    }
}

function generatePassword()
{
    $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwxyZ0123456789';

    $serial = '';

    for ($i = 0; $i < 2; $i++) {
        for ($j = 0; $j < 5; $j++) {
            $serial .= $tokens[rand(0, 61)];
        }

//        if ($i < 4) {
        //            $serial .= '-';
        //        }
    }
    return $serial;
    if ($this->existLicenceKey($serial)) {
        return 0;
    } else {
        return $serial;
    }
}

function generateLicenceKey2()
{
    $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $serial = '';

    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            $serial .= $tokens[rand(0, 35)];
        }

        if ($i < 4) {
            $serial .= '-';
        }
    }
    return $serial;
    if ($this->existLicenceKey($serial)) {
        return 0;
    } else {
        return $serial;
    }
}

function generateLicenceKey()
{
    $serial = $this->getRandLicence();
    if ($this->existLicenceKey($serial)) {
        return $this->generateLicenceKey();
    } else {
        return $serial;
    }
}

function getRandLicence()
{

    $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $tokens = '0123456789';

    $serial = '';

    for ($i = 0; $i < 1; $i++) {
        for ($j = 0; $j < 4; $j++) {
            $serial .= $tokens[rand(0, 9)];
        }

        if ($i < 0) {
            $serial .= '-';
        }
    }
    return $serial;
}

function existLicenceKey($licence)
{
     $query = "SELECT * FROM `oussema_erpbison`.`ab_abonnes` WHERE licence_key = '$licence'";
    $resul = $this->db->query($query)->result();    
         
    if(count($resul)!=0){
   
        return true;
    } else {
        return false;
    }

}

function cryptPassword($password)
{
    return sha1($password);
}

// FUNCTIONS DB
function existDB($dbname)
{
    $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . $dbname . "'";
    $resul = $this->db->query($query)->result();    
         
    if(count($resul)!=0){
         return true;
    } else {
        return false;
    }

}
function insertDbFirstTime($dbname)
{
    $this->createDb($dbname);
    global $config_database;

    $mysqlUserName = $config_database['username'];
    $mysqlPassword = $config_database['password'];
    $mysqlImportFilename = '../superadmin/sql/default_erp.sql';

//DO NOT EDIT BELOW THIS LINE
    $mysqlHostName = 'localhost';
//Export the database and output the status to the page
    $command = 'mysql -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $dbname . ' < ' . $mysqlImportFilename;
    exec($command, $output = array(), $worked);
    if ($worked == 0) {
        return true;
    } else {
        return false;
    }
}

function salt()
{
    return substr(sha1(mt_rand()), 0, 22);
}

function generate_password($password, $salt)
{
    return crypt($password, '$2a$10$' . $salt);
}
public function createDb($dbname)
{
    $ci = get_instance();
    $mysqlImportFilename = file('superadmin/sql/default_erp.sql');
    // Create database
    // return die('hh' . $ci->db->database);
    //hhoussema_erpbison

    $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
    $this->db->query($sql);
    $conn = new mysqli($ci->db->hostname, $ci->db->username, $ci->db->password, $dbname);

    if ($conn->query($sql) === true) {
        foreach ($mysqlImportFilename as $line) {

            $startWith = substr(trim($line), 0, 2);
            $endWith = substr(trim($line), -1, 1);

            if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
                continue;
            }

            $query = $query . $line;
            if ($endWith == ';') {
                $conn->query($query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query . '</b></div>');
                $query = '';
            }
        }

        return true;

    } else {
        echo "Error creating database: ";
    }
    return true;

}
 
}