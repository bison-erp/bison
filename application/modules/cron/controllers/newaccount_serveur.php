<?php

/**
 * @author       Oussema
 * @date    08th April, 2019
 * Description of newaccount
 */
class newaccount extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
  
    public function synchrowhmcs()
    {
        $created = date("Y-m-d H:i:s");    
       
      /*  define("DB_SERVER", "91.121.154.159");
        define("DB_USERNAME", "bison_whmcs");
        define("DB_PASSWORD", "Uvhc33!7f4cIk87*");
        define("DB_DATABASE", "bison_whmcs"); */
        define("DB_SERVER", "188.165.196.226");
        define("DB_USERNAME", "bison_whmcs");
        define("DB_PASSWORD", "Uvhc33!7f4cIk87*");
        define("DB_DATABASE", "bison_whmcs");  


      /*  define("DB_SERVER", "server.nov03.net");
        define("DB_USERNAME", "bison_erp");
        define("DB_PASSWORD", "EkD7c4tIL");
        define("DB_DATABASE", "bison_erp"); */
        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);      
       
        if ($link->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        if($link){
            
            return die('connecte');
        }else{ 
            
            return die('non connecte');
        }      
        $sqluser_upd = " SELECT  tblclients.securityqans,tblinvoices.id as idinvoice, tblinvoices.userid,tblclients.city,tblclients.id,tblclients.country,tblinvoiceitems.description,COUNT(IF(tblinvoices.status='Cancelled',1, NULL)) 'Cancelled', COUNT(IF(tblinvoices.status='Unpaid',1, NULL)) 'Unpaid', COUNT(IF(tblinvoices.status='Paid',1, NULL)) 'Paid',COUNT(IF(tblinvoices.status='Collections',1, NULL)) 'Collections',COUNT(IF(tblinvoices.status='Refunded',1, NULL)) 'Refunded',COUNT(IF(tblinvoices.status='Draft',1, NULL)) 'Draft',firstname,lastname,email,tblclients.companyname,state,postcode,phonenumber,tblclients.password,tblclients.address1,tblclients.country,tblinvoices.status FROM `tblinvoices`,`tblclients`,`tblinvoiceitems` WHERE tblinvoices.userid=tblclients.id and tblinvoices.id=tblinvoiceitems.invoiceid GROUP BY tblinvoices.id ASC ORDER BY `idinvoice` ASC";

        $sqluser_order = "SELECT tblclients.securityqans,tblclients.city,tblclients.id,tblclients.country,tblproducts.name, COUNT(IF(tblorders.status='Pending',1, NULL)) 'Pending', tblorders.userid,firstname,lastname,email,tblclients.companyname,state,postcode,phonenumber,tblclients.password,tblclients.address1 FROM tblproducts,`tblhosting`,`tblorders`,`tblclients` WHERE tblhosting.orderid=tblorders.id and  tblclients.id=tblorders.userid and tblproducts.id=tblhosting.packageid and (tblorders.status='Active' or tblorders.status='Paid') GROUP BY tblorders.id DESC";
        $result_upd = mysqli_query($link, $sqluser_upd);
        $result_order = mysqli_query($link, $sqluser_order);
      //  $result_order_up = mysqli_query($link, $sqluser_order_upd);
        mysqli_close($link);
        
        //  var_dump( mysqli_fetch_array($result_upd)); var_dump( mysqli_fetch_array($result_order)); return die('hh');
        $pack_ch_fr = 'gratuit';
        $pack_ch_en = 'free';
                // si non existe et  active donc création
        $xj=0;
              if ($result_order->num_rows > 0) {
                    while($row = mysqli_fetch_array($result_order)){      
                        $statut_order = 1;
                        $resexist_ord = $this->existdb($row['id']);                                 
                      /*  if ($row['Pending'] > 0) {
                            $statut_order = 1;
                        }*/ 
                        if ((int) $resexist_ord < 1) {  
                            $pack_id = 3;
                      //  $row['country']='Tunis' ;                          
                        $strs= explode(" ",strtolower($row['name']));
                        for($i=0;$i<count($strs);$i++){
                            if($pack_ch_fr == $strs[$i]){
                                $pack_id = 4 ;
                            }
                        }  
                        for($i=0;$i<count($strs);$i++){
                            if($pack_ch_en == $strs[$i]){
                                $pack_id = 4 ;
                            }
                        }  
                  $this->createaccount($row['securityqans'],$row['lastname'], $row['firstname'], $row['email'], $row['phonenumber'], $row['state'], $row['postcode'], $row['country'], $row['address1'], $row['phonenumber'], $row['companyname'], '', '', '',$this->rand_pass(), $created, $statut_order,$pack_id,$row['id']);
                  sleep(2);
                    }
                    if ($result_order->num_rows == $xj){
                    break;
                    }  
                    $xj++;
                  }           
             }   
        $xl=0;
        if ($result_upd->num_rows > 0) {
            while($row = mysqli_fetch_array($result_upd)){   
                $resexist = $this->existdb($row['id']);  
               
                if ((int) $resexist > 0) { 
                    
                    if($row['status']=="Overdue"){                    
                        $this->updatedb($resexist, 0);
                    }else{
                        $this->updatedb($resexist, 1);      
                    } 
                }
                if ($result_upd->num_rows == $xl){
                break;
                }  
                $xl++;
             }
          }     
          return true;
    }
   
    public function createaccount($salt_pass = null, $lastname = null, $firstname = null, $email = null, $phone = null, $state = null, $postcode = null, $country = null, $adress1 = null, $phonenumber = null, $companyname = null, $matriculefiscale = null, $registercommerce = null, $status = null, $password = null, $created = null, $user_active = null,$pack_id,$id= null,$city= null)
    {  
       
        $ci = get_instance();  
        if($country){  
        $ci->load->helper('country');
        }
        $licence_key = $this->generateLicenceKey();
        $created = date("Y-m-d H:i:s");      
        $database = "bi_" . $licence_key;
        $fax = "";
        $website = "";
        $lastnamee = htmlspecialchars($lastname);
        $firstnamee = htmlspecialchars($firstname);
        $emaill = htmlspecialchars($email);
        $adress11 = htmlspecialchars($adress1);
        $companynamee = htmlspecialchars($companyname);
        if($country){ 
        $country=get_country_list('fr')[$country];
        }
        $query="
        INSERT INTO `erp_bison`.`ab_abonnes` (`nom`, `prenom`, `societe`, `email`, `adresse`, `complement`, `ville`, `code_postal`, `pays`, `telephone`, `mobile`, `fax`, `site_web`, `matricule_fiscale`, `registre_commerce`, `statut`, `created`, `database`, `licence_key`, `pack_id`,`id_userwhmcs`)
        VALUES ('$lastnamee', '$firstnamee','$companynamee', '$emaill', '$adress11', '$city','', '$postcode', '$country', '$phonenumber', '$phonenumber', '', '', '', '', '1', '$created', '$database', '$licence_key', '$pack_id', '$id'); 
        ";
        $this->db->query($query);      
        $this->insertDbFirstTime($database);
        // AJOUTER LE COMPTE UTILISATEUR
        $fullname = $lastnamee . " " . $firstnamee;
        $client_code = strtoupper(substr($lastname, 0, 1) . substr($firstname, 0, 1));
        $user_psalt = $this->salt();
        
       $passwordtocken = $this->generate_password($password, $user_psalt);
     
        $query2 = "
        INSERT INTO  `$database`.`ip_users` (`user_id`, `groupes_user_id`, `user_type`, `user_active`, `user_date_created`, `user_date_modified`, `user_name`, `user_code`, `user_company`, `user_address_1`, `user_address_2`, `user_city`, `user_state`, `user_zip`, `user_country`, `user_phone`, `user_fax`, `user_mobile`, `user_email`, `user_password`, `user_web`, `user_vat_id`, `user_tax_code`, `user_psalt`, `user_passwordreset_token`) VALUES
        (1, 1, 1, 1, '" . $created . "', '" . $created . "', '" . $fullname . "', '" . $client_code . "', '" . $companynamee . "', '" . $adress11 . "', '', '" . $state . "', '" . $country . "', '" . $postcode . "', 'TN', '" . $phonenumber . "', '" . $fax . "', '" . $phonenumber . "', '".$emaill."', '" . $passwordtocken . "', '" . $website . "', '', '', '" . $salt_pass . "', '.$passwordtocken.')
        ";
        $this->db->query($query2);
     
        // FIN AJOUTER LE COMPTE UTILISATEUR
        //
        // AJOUTER SOCIETE
        $query3 = "INSERT INTO `$database`.`ip_societes`(`raison_social_societes`, `code_tva_societes`, `tax_code`, `site_web_societes`, `mail_societes`, `fax_societes`, `note_societes`)
        VALUES ('" . $companyname . "','" . $matriculefiscale . "','" . $registercommerce . "','" . $website . "','" . $email . "','" . $fax . "','')";
        $this->db->query($query3);
        $id_societe =$this->db->insert_id();
      
        $query4 = "INSERT INTO   `$database`.`ip_societe_adresse`(`id_societe`, `adresse`, `code_postal`, `ville`, `pays`, `telephone`)
        VALUES ('" . $id_societe . "','" . $adress1 . "','" . $postcode . "','" . $state . "','" . $country . "','" . $phonenumber . "')";
        $this->db->query($query4);
        // FIN AJOUTER SOCIETE
        $mobile = "";
        $website = "";
        $footer_pdf_defaut = '<center>Adresse : ' . $adress1 . '<br> T&eacute;l: ' . $phonenumber . ' / ' . $mobile . '<br>\nT.V.A.: ' . $matriculefiscale . ' - Fax: ' . $fax . ' - Email : ' . $email . ' - Site: ' . $website . '</center>';
        $query5 = "UPDATE  `erp_bison`.`ip_settings` SET `setting_value`= '" . $footer_pdf_defaut . "' WHERE `setting_key`='pdf_invoice_footer'";
        $this->db->query($query5);
        
        mkdir("uploads/" . strtolower($licence_key), 0777);
        mkdir("uploads/" . strtolower($licence_key) . "/temp", 0777);
        copy("superadmin/files/your-logo-here.png", "uploads/" . strtolower($licence_key) . "/your-logo-here.png");
        $this->load->helper('superadmin');
        $this->load->helper('mailer/phpmailer');  
        $settings = get_settings_superadmin();
      //  $from_email_def = array($settings['noreplay_mail'], $settings['from_name']);             
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

        $from_email_def = array($settings['noreplay_mail'], $settings['from_name']);
      //  $to =   "oussema@novatis.tn";
        $to = $emaill;
        $subject = "Notification de connexion à votre compte: [" . $licence_key . "]";
        $message = "
            <div style='width:95%;margin:20px auto; align:center;'>
            <div style='font-size:12px;float:right'>Le ".date('d-m-Y H:i:s')."</div>
            <div style='clear:both'></div>
            <div style='font-size:12px;font-family:arial;'>          
            Bonjour ".$lastname." ".$firstname.",<br> <br>

            Vous venez de souscrire à Bison ERP, solution de facturation et gestion entreprise en ligne et nous vous <br>
            remercions de la confiance que vous nous accordez.
            <br> <br> <br>
            Veuillez trouver ci-joint les paramètres de connexion à votre compte.
            <br> <br> <br>
            <b>PARAMÈTRES COMPTE:</b><br>            
            https://erp.bison.tn<br>
            <b> Code Client: </b> " . $licence_key . " <br>  
            <b> Email de connexion: </b> " . $emaill . "<br>  
            <b> Mot de passe: </b> " . $password. "<br>  <br><br>

            <b>Guide d'utilisation</b> <br><br><br>

            http://client.bison.tn/knowledgebase.php  <br><br><br>

            Cordialement,<br>
            -- <br>
            Administrateur <br>
            BisonERP <br>
            Solution de facturation en ligne<br>

           </div></div>
            ";
         phpmail_send_cron($from_email_def, $to, $subject, $message);
     //  phpmail_send($from_email_def, 'ad@bison.tn', $subject, $message);
     //  return die('true');

    }
   
    public function insertDbFirstTime($dbname)
    {
        $this->createDb($dbname);
    }
    public function updatedb($id, $statut)
    {
        $query5 = "UPDATE `erp_bison`.`ab_abonnes` SET `statut` = '" . $statut . "' WHERE `ab_abonnes`.`abonne_id` =" . $id;
        $this->db->query($query5);    
    }
    public function get_list_abonnees()
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

        $abonnees = $ci->db->get("ab_abonnes")->result();

        // LOAD DATABASE ORIGINE
        $config_db['database'] = $old_database;
        $ci->db = $ci->load->database($config_db, true);

        return $abonnees;
    }  
    public function existdb($idwhmcs)
    {
        $abonnees = $this->get_list_abonnees();
        $id = 0;
        foreach ($abonnees as $key) {   
            if ($key->id_userwhmcs == $idwhmcs){
                $id = $id + $key->abonne_id;               
                return $id;
            }
        }

        return $id;
    }

    public function generateLicenceKey()
    {
        $serial = $this->getRandLicence();
        if ($this->existLicenceKey($serial) == 1) {
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
    public function createDb($dbname)
    {
        $ci = get_instance();
        $mysqlImportFilename = file('superadmin/cron/defaulterp.sql');     
        $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
        $this->db->query($sql);
        $conn = new mysqli($ci->db->hostname, $ci->db->username, $ci->db->password, $dbname);
        $query ='';
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
    }

    public function generate_password($password, $salt)
    {
        return crypt($password, '$2a$10$' . $salt);
    }

    public function salt()
    {
        return substr(sha1(mt_rand()), 0, 22);
    }
    public function existLicenceKey($licence)
    {

        $query = "SELECT * FROM `erp_bison`.`ab_abonnes` WHERE licence_key = '$licence'";
        
        //var_dump(count($this->db->query($query)));
        if ((count($this->db->query($query)->result()))>0) {
            return 1;
        } else {
            return 0;
        }

    }

    public function convch($str)
    {
        $ret = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
        $p2 = -1;
        for (;;) {
            $p = strpos($ret, '&#', $p2 + 1);
            if ($p === false) {
                break;
            }

            $p2 = strpos($ret, ';', $p);
            if ($p2 === false) {
                break;
            }

            if (substr($ret, $p + 2, 1) == 'x') {
                $char = hexdec(substr($ret, $p + 3, $p2 - $p - 3));
            } else {
                $char = intval(substr($ret, $p + 2, $p2 - $p - 2));
            }

           
            $newchar = iconv(
                'UCS-4', 'UTF-8',
                chr(($char >> 24) & 0xFF) . chr(($char >> 16) & 0xFF) . chr(($char >> 8) & 0xFF) . chr($char & 0xFF)
            );
            //echo "$newchar<$p<$p2<<\n";
            $ret = substr_replace($ret, $newchar, $p, 1 + $p2 - $p);
            $p2 = $p + strlen($newchar);
        }
     //   echo $ret;
    }


    public function getmailfrom(){
        $sql = "SELECT * FROM `erp_bison`.`ip_settings` where  `setting_key` = 'noreplay_mail'";
        $result = $this->db->query($sql)->result();       
        return ($result[0]->setting_value);       
    }

    public function rand_pass(){
        $letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        return substr(str_shuffle($letters), 0, 5);
    }
}