<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cronsuperadmin
 *
 * @author Oussema
 */
class cronsuperadmin extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function existDB($db)
    {
        //  return die($this->db->database_orig);
        $this->db->where("SCHEMA_NAME", $db);
        $this->db->select("SCHEMA_NAME, count(SCHEMA_NAME) as count");
        $db_selected = $this->db->get("INFORMATION_SCHEMA.SCHEMATA")->result();

        $db_selected[0]->count == 0 ? 'false' : 'true';
    }

    public function searchclientwhmcs()
    {
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('superadmin');
        $abonnees = get_list_abonnees();
        $settings = get_settings_superadmin();
        $from = $settings['noreplay_mail'];

    /*    $mysql_username = 'bison_erp';
        
        // MySQL password
     //  $mysql_password = 'EkD7c4tIL';
     $mysql_password = 'uZzf29@20g3hUl$7';*/
        $array = [];
        // $CI = &get_instance();
        $config_db['hostname'] = $this->db->hostname;
        $config_db['username'] = 'bison_erp';
        $config_db['password'] = 'uZzf29@20g3hUl$7';
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
        $config_db['database'] = "bison_erp";
      //  $config_db['database'] = "bison_erp";
        $CI = $this->load->database($config_db, true);
        $ites = $CI->select("*")->from('tblclients')->get()->result();
        //var_dump($this->salt());
        /* nom: nom,
        prenom: prenom,
        // website: website,
        email: email,
        telephone: telephone,
        mobile: mobile,
        // fax: fax,
        ville: ville,
        code_postal: code_postal,
        pays: pays,
        adresse: adresse,
        //  societe: societe,
        // matricule_fiscale: matricule_fiscale,
        // registre_commerce: registre_commerce,
        licence_key: licence_key,
        status: status,
        password: password,
        pack_id: pack_id,
         */
        $ignore = array('Unpaid', 'Overdue');
        foreach ($ites as $ite) {
            $CI->select('*');
            $CI->from('tblinvoices');
            $CI->where('userid', $ite->id);
            // $this->db->like('title', 'match');
            $CI->where_not_in('status', $ignore);
            $querytblinvoices = $CI->get()->result();
            //  return var_dump($querytblinvoices);
            // $ites = $CI->select("*")->from('tblinvoices')->get()->result();
            /* $query = "SELECT * FROM whmcs.tblinvoices WHERE userid = '$client' and (status  NOT IN (
            'Unpaid', 'Overdue'
            ))   ";*/

            //  $res = $this->db->query($query)->result();
            /*   if (count($querytblinvoices) > 0) {
            return false;
            }*/
            if (!$this->existmail(trim($ite->email))) {

                $nom = trim($ite->firstname);
                $prenom = trim($ite->lastname);
                $email = trim($ite->email);
                $telephone = trim($ite->phonenumber);
                $mobile = trim($ite->phonenumber);
                $ville = trim($ite->city);
                $postcode = trim($ite->postcode);
                $pays = trim($ite->country);
                $societe = trim($ite->companyname);
                $adresse = trim($ite->address1);
                $status = 0;
                if (count($querytblinvoices) > 0) {
                    $status = 1;
                }

                $code_postal = trim($ite->postcode);
                //   $password = trim($ite->password);
                $fax = '';
                $website = '';
                $matricule_fiscale = '';
                $registre_commerce = '';
                $pack_id = 1;
                $created = date("Y-m-d H:i:s");
                $subject = "Accès Compte bison";
                $to = trim($ite->email);

                $client_code = strtoupper(substr($nom, 0, 1) . substr($prenom, 0, 1));

                $licence_key = $this->generateLicenceKey();

                //$database = "oussema_" . strtolower($licence_key);
                $database = "bi_" . strtolower($licence_key);
                if (!$this->existDB($database)) {

                    $this->insertDbFirstTime($database);
                }

                $query = "INSERT INTO `ab_abonnes`(`nom`, `prenom`, `societe`, `email`, `adresse`, `ville`, `code_postal`, `pays`, `telephone`, `mobile`, `fax`, `site_web`, `matricule_fiscale`, `registre_commerce`, `statut`, `created`, `database`, `licence_key`, `pack_id`)
                VALUES('$nom','$prenom','$societe','$email','$adresse','$ville','$code_postal','$pays','$telephone','$mobile','$fax','$website','$matricule_fiscale','$registre_commerce','$status','$created','$database','$licence_key','$pack_id')";
                //echo $query;
                $this->db->query($query);
                $fullname = $nom . " " . $prenom;
                $user_psalt = $this->salt();
                $password = 'bison' . $client_code;
                $message = "
                <div style='width:95%;margin:20px auto;' align:center;>
                <div style='font-size:12px;float:right'></div>
                <div style='clear:both'></div>
                <div style='font-size:12px;font-family:arial;'
                Madame, Monsieur,<br>

                Nous vous envoyons cet email à la suite d'une connexion réussie à votre interface de gestion BisonERP (https://erp.bison.tn).
                <br><br>
                <div style='margin-left:20px;'>
                    Licence   : " . $licence_key . "<br>
                    Email de connexion: " . $email . "<br>
                    Mot de passe  : " . $password . "<br>
                </div>
                <br><br>
                Cet email est destiné à vous sensibiliser à la sécurité des services que vous avez chez BISON  et à mieux les protéger.
                <br>
                Pour modifier le mot de passe , rendez-vous dans votre espace client : https://erp.bison.tn/users/change_password/1

                    <br><br>
                    Nous vous remercions pour la confiance que vous accordez à BisonERP et restons à votre disposition.
                    <br><br>
                    Cordialement,<br>
                    Support Client BisonERP<br><br>

                    Support Commercial et Technique :   70 032 292 <br>
                    Email:support@bison.tn	 <br>
                    </div>
";
                // Bonjour,votre licence est " . $licence_key . " est login : " . $email . " et ////mot de passe: " . $password;
                $user_password = $this->generate_password($password, $user_psalt);
                //  return die('1'.$password.'3'.$user_password);
                // AJOUTER LE COMPTE UTILISATEUR

                $query2 = "
            INSERT INTO " . $database . ".`ip_users` (`user_id`, `groupes_user_id`, `user_type`, `user_active`, `user_date_created`, `user_date_modified`, `user_name`, `user_code`, `user_company`, `user_address_1`, `user_address_2`, `user_city`, `user_state`, `user_zip`, `user_country`, `user_phone`, `user_fax`, `user_mobile`, `user_email`, `user_password`, `user_web`, `user_vat_id`, `user_tax_code`, `user_psalt`, `user_passwordreset_token`) VALUES
            (1, 1, 1, 1, '" . $created . "', '" . $created . "', '" . $fullname . "', '" . $client_code . "', '" . $societe . "', '" . $adresse . "', '', '" . $ville . "', '" . $pays . "', '" . $code_postal . "', 'TN', '" . $telephone . "', '" . $fax . "', '" . $mobile . "', '" . $email . "', '" . $user_password . "', '" . $website . "', '', '', '" . $user_psalt . "', '')
            ";
                $this->db->query($query2);
                // FIN AJOUTER LE COMPTE UTILISATEUR
                //
                // AJOUTER SOCIETE
                $query3 = "INSERT INTO " . $database . ".`ip_societes`(`raison_social_societes`, `code_tva_societes`, `tax_code`, `site_web_societes`, `mail_societes`, `fax_societes`, `note_societes`)
                          VALUES ('" . $societe . "','" . $matricule_fiscale . "','" . $registre_commerce . "','" . $website . "','" . $email . "','" . $fax . "','')";
                $this->db->query($query3);
                $id_societe = mysql_insert_id();
                $query4 = "INSERT INTO " . $database . ".`ip_societe_adresse`(`id_societe`, `adresse`, `code_postal`, `ville`, `pays`, `telephone`)
                      VALUES ('" . $id_societe . "','" . $adresse . "','" . $code_postal . "','" . $ville . "','" . $pays . "','" . $telephone . "')";
                $this->db->query($query4);
                // FIN AJOUTER SOCIETE

                $footer_pdf_defaut = '<center>Adresse : ' . $adresse . '<br> T&eacute;l: ' . $telephone . ' / ' . $mobile . '<br>\nT.V.A.: ' . $matricule_fiscale . ' - Fax: ' . $fax . ' - Email : ' . $email . ' - Site: ' . $website . '</center>';
                $query5 = "UPDATE " . $database . ".`ip_settings` SET `setting_value`= '" . $footer_pdf_defaut . "' WHERE `setting_key`='pdf_invoice_footer'";
                $this->db->query($query5);

                mkdir("./uploads/" . strtolower($licence_key), 0777);
                mkdir("./uploads/" . strtolower($licence_key) . "/temp", 0777);
                mkdir("./uploads/" . strtolower($licence_key) . "/temprelance", 0777);
                copy("./superadmin/files/your-logo-here.png", "./uploads/" . strtolower($licence_key) . "/your-logo-here.png");
                // echo ('1' . $to);

                phpmail_send($from, $to, $subject, $message, $array);

            } else {

                $status = 0;
                if (count($querytblinvoices) > 0) {
                    $status = 1;
                }
                $email = trim($ite->email);
                //  return die('1' . var_dump(count($querytblinvoices)));
                $sqlquote1 = "UPDATE  `ab_abonnes` SET `statut` = '$status' WHERE `email`  LIKE  '$email'";
                $this->db->query($sqlquote1);

            }

        }

        // return die(var_dump($abonnees));
    }

    public function existmail($email = "")
    {
        // $email = "oussema@novatis.tn";
        //  return die($email);
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('superadmin');
        $abonnees = get_list_abonnees();
        // return 'false';
        //  var_dump($abonnees);
        foreach ($abonnees as $abonnee) {
            if (trim($abonnee->email) == $email) {
                return true;
            }
        }
        return false;
    }

    public function salt()
    {
        return substr(sha1(mt_rand()), 0, 22);
    }

    public function generate_password($password, $salt)
    {
        return crypt($password, '$2a$10$' . $salt);
    }

    public function insertDbFirstTime($dbname)
    {
        $this->createDb($dbname);
        global $config_database;
        //  return var_dump($config_database);
       // $mysqlUserName = 'oussema';
        $mysqlUserName = 'bison_erp';
        // $mysqlImportFilename = 'sql/default_erp.sql';
        $mysqlImportFilename = './superadmin/sql/default_erp.sql';
        // exec("mysql -u oussema  ' -p' Rqmm28%Z8Knhvsfn oussema_0010 < './superadmin////sql/default_erp.sql'");

        $filename = './superadmin/sql/default_erp.sql';
        // MySQL host
     // $mysql_host = '37.59.25.185';
        $mysql_host = 'localhost';
        // MySQL username
        $mysql_username = 'admin_erp_bison';
        
        // MySQL password
     //  $mysql_password = 'EkD7c4tIL';
     $mysql_password = 'FCw]XC#V2i2PH28D';
        // Database name
        $mysql_database = $dbname;
//return die('12'.$dbname);
        // Connect to MySQL server
        mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
        // Select database
        mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

        $templine = '';
        // Read in entire file
        $lines = file($filename);
// Loop through each line
        foreach ($lines as $line) {
// Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

// Add this line to the current segment
            $templine .= $line;
// If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                // Reset temp variable to empty
                $templine = '';
            }
        }
        return true;
    }
    public function createDb($dbname)
    {
        $query = "CREATE DATABASE IF NOT EXISTS $dbname ";
        $this->db->query($query);
    }

    public function existLicenceKey($licence)
    {

        $query = "SELECT * FROM ab_abonnes WHERE licence_key = '$licence'";
        $res = $this->db->query($query)->result();
        if (count($res) != 0) {
            return true;
        } else {
            return false;
        }

    }

    public function generateLicenceKey()
    {
        $serial = $this->getRandLicence();

        if ($this->existLicenceKey($serial)) {

            return generateLicenceKey();
        } else {
            return $serial;
        }
    }

    public function getRandLicence()
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

    /*  public function updatstateclient($client)
    {
    $mysql_host = 'localhost';
    // MySQL username
    $mysql_username = 'oussema';
    // MySQL password
    $mysql_password = 'Rqmm28%Z8Knhvsfn';
    // Database name
    $dbname = "whmcs";
    $mysql_database = $dbname;

    // Connect to MySQL server
    mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
    // Select database
    mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

    $query = "SELECT * FROM whmcs.tblinvoices WHERE userid = '$client' and (status  NOT IN (
    'Unpaid', 'Overdue'
    ))   ";

    $res = $this->db->query($query)->result();
    if (count($res) > 0) {
    return false;
    }
    return true;
    }
     */
    public function updateclientbison($email)
    {
        $sqlquote = "UPDATE  `ab_abonnes` SET `statut` = '0' WHERE `email`  LIKE  '$email'";
        $this->db->query($sqlquote);
    }

    /*   public function updateclientbisonopen($email)
{
$sqlquote = "UPDATE  `ab_abonnes` SET `statut` = '1' WHERE `email`  LIKE  '$email'";
$this->db->query($sqlquote);
}*/

}