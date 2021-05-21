<?php

/**
 * @author       Oussema
 * @date     28th Mars, 2019
 * Description of cronrappelautomatique
 */
class cronrappelautomatique extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function savevu($type, $db, $id)
    {
        $idobj = $this->getidobj($db, $id);
       if ($type == 0) {
            $sqlquote = "UPDATE `$db`.`ip_quotes` SET `quote_status_id` = '3' WHERE `ip_quotes`.`quote_id` =$idobj";
            
            $this->db->query($sqlquote) ;
 
        }
        if ($type == 1) {
            $sqlinvoice = "UPDATE `$db`.`ip_invoices` SET `invoice_status_id` = '3' WHERE `ip_invoices`.`invoice_id` =$idobj";
            $this->db->query($sqlinvoice) ;
        } 
        $sql = "UPDATE `$db`.`ip_tracking` SET `vu` = '1' WHERE `ip_tracking`.`log_id` =$id";
        $this->db->query($sql)->result();

    }
    public function savevuinvoice($db, $id)
    {
        $sql = "UPDATE `$db`.`ip_tracking` SET `vu` = '1' WHERE `ip_tracking`.`id_action` ='rappel_facture' and `ip_invoices`.`invoice_id` =$id";
        $resulinvoice = $this->db->query($sql)->result();
    }
    public function rappelAllDateBase()
    {
        for ($i = 0; $i < count($this->get_list_abonnees()); $i++) {
            //  $this->setupdate($this->get_list_abonnees()[$i]->database);            
                $this->getAllrappel($this->get_list_abonnees()[$i]->database);           
        }
    }
    public function getAllrappel($db)
    {
        $datenow = date('d/m/Y');
        $sql = "SELECT ip_rappelmail.ip_rappelmail_id,ip_quotes.quote_id,ip_quotes.quote_number,ip_rappelmail.daterappel,ip_quotes.client_id,ip_quotes.joindredevis,ip_quotes.document FROM " . $db . ".ip_rappelmail," . $db . ".ip_quotes   WHERE ip_quotes.quote_id = ip_rappelmail.idobject AND ip_rappelmail.type ='quote' AND (ip_quotes.quote_status_id = '3' or ip_quotes.quote_status_id ='2') ";
        $resultquote = $this->db->query($sql)->result();
        
        $sql1 = "SELECT ip_rappelmail.ip_rappelmail_id,ip_invoices.invoice_id,ip_invoices.invoice_number as in_number,ip_rappelmail.daterappel,ip_invoices.client_id,ip_invoices.joindredevis,ip_invoices.document FROM " . $db . ".ip_rappelmail," . $db . ".ip_invoices   WHERE ip_invoices.invoice_id = ip_rappelmail.idobject AND ip_rappelmail.type ='invoice' AND (ip_invoices.invoice_status_id = '3' or ip_invoices.invoice_status_id ='2') ";
        $resultinvoice = $this->db->query($sql1)->result();
     //   return var_dump($resultinvoice);
        $array = array();
        if (count($resultquote) > 0) {
            foreach ($resultquote as $key) {
                if ($key->daterappel == $datenow) {
                    if ($key->quote_id) {
                        $bc = ['type' => 'q', 'id' => $key->quote_id, 'quote_number' => $key->quote_number, 'client' => $key->client_id, 'ip_rappelmail_id' => $key->ip_rappelmail_id, 'joindredevis' => $key->joindredevis, 'document' => $key->document];
                        array_push($array, $bc);
                    }
                }

            }

        }
        if (count($resultinvoice) > 0) {
            foreach ($resultinvoice as $key) {
                if ($key->daterappel == $datenow) {
                    $bc = ['type' => 'i', 'id' => $key->invoice_id, 'in_number' => $key->in_number, 'client' => $key->client_id, 'ip_rappelmail_id' => $key->ip_rappelmail_id, 'joindredevis' => $key->joindredevis, 'document' => $key->document];
                    array_push($array, $bc);
                }

            }
        }
         // return var_dump($array);
        $this->send_mail1($db, $array, sizeof($array));
      //  return 'true';
      
    }

    public function send_mail1($db, $tab, $taille)
    {

        $CI = &get_instance();
        $licence = explode('_', $db);
        //  $usermail = "SELECT ip_users.user_email,ip_users.user_name FROM " . $db . ".ip_users";
        //  $usermailconnect = $this->db->query($usermail)->result();
        //  $full_nameuser = $usermailconnect[0]->user_name;
        $files = array();
        $CI->load->helper('date');
        $from = "";
        if ($taille > 0) {

            $fullname = "";
            $message = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body>';
            $subject = "";
            $to = "";
            $civilite[0] = "M.";
            $civilite[1] = "Mme.";
            $civilite[2] = "Melle.";

            if ($tab[$taille - 1]['type'] == 'i') {
                $usermail = "SELECT ip_users.user_email,ip_users.user_name,ip_users.signature FROM " . $db . ".ip_users," . $db . ".ip_invoices where ip_invoices.user_id=ip_users.user_id and ip_invoices.invoice_id= " . $tab[$taille - 1]['id'];
                $usermailconnect = $this->db->query($usermail)->result();
                //  $full_nameuser = $usermailconnect[0]->user_name;
                // $fromm = $usermailconnect[0]->user_email;

                $CI->db->where("invoice_id", $tab[$taille - 1]['id']);
                $CI->db->join($db . '.ip_users', 'ip_users.user_id= ip_invoices.user_id', 'left');

                $invoices_idobj = $CI->db->get($db . ".ip_invoices")->result();

                // $from .= $invoices_idobj[0]->user_name . '<' . $invoices_idobj[0]->user_email . '>';
                $from .= $invoices_idobj[0]->user_email;
                $this->db->where("client_id", $tab[$taille - 1]['client']);
                $client = $this->db->get($db . ".ip_clients")->result();
                $to .= $client[0]->client_email;
                $aa = $this->getcontenumessage($db, 0);

                $invoice = $this->get_invoice_info_mail($db, $tab[$taille - 1]['id']);
                // $subject .= $aa[0]->email_template_title." ". $tab[$taille - 1]['id'] . ": " . $invoice[0]->nature;
                $charray1 = array("{number}", "{nature}");
                $charrayreplace1 = array($invoice[0]->invoice_number, $invoice[0]->nature);
                $newphrasesubj = str_replace($charray1, $charrayreplace1, $aa[0]->email_template_subject);
                $subject .= $newphrasesubj;
                $fullname .= $civilite[$invoice[0]->client_titre] . $client[0]->client_name . ' ' . $client[0]->client_prenom;
                $charray = array("{client_fullname}", "{number}", "{nature}", "{date_created}", "{total_final}", "{signature}");
                $charrayreplace = array($fullname, $invoice[0]->invoice_number, $invoice[0]->nature, date('d/m/Y', strtotime($invoice[0]->invoice_date_created)), $invoice[0]->invoice_total, '');
                $newphrase = str_replace($charray, $charrayreplace, $aa[0]->email_template_body);
                $serv = $_SERVER['REMOTE_ADDR'];
                $insertlog = "INSERT INTO " . $db . ".ip_logs (`log_action`, `log_date`, `log_ip`, `log_user_id`, `log_field1`, `log_field2`) VALUES ('rappel_facture', '" . date('Y-m-d H:i:s') . "','" . $serv . "' , '1', '" . $client[0]->client_id . "', '" . $tab[$taille - 1]['id'] . "')";
                $this->db->query($insertlog);

                $ip_tracking = "INSERT INTO " . $db . ".ip_tracking (`action`, `date`, `ip`, `id_from`, `id_to`,`number`, `id_action`,`vu`) VALUES ('rappel_facture', '" . date('Y-m-d H:i:s') . "','" . $serv . "' , '" . $invoices_idobj[0]->user_id . "','" . $client[0]->client_id . "','" . $invoice[0]->invoice_number . "','" . $tab[$taille - 1]['id'] . "','0')";
                $this->db->query($ip_tracking);
                $idinsert = $this->db->insert_id();

                   $url="erp.bison.tn/cron/cronrappelautomatique/savevu/1/bi_".$licence[1]."/". $idinsert;

              //$url = "erp-bison.novatis.org/cron/cronrappelautomatique/savevu/1/" . $db . "/" . $idinsert;

                 $message .=  "<img src='$url' style='display:none' >";

                  $message .= $newphrase;
                $message .= "\r\n" . "<span style='font-size: 15px; color: #008080;'>" . $usermailconnect[0]->signature . "</span>";

                $this->db->where("client_id", $tab[$taille - 1]['client']);
                $this->db->where('object_id', $tab[$taille - 1]['id']);
                $this->db->where('typeobject', 'invoice');
                $documentrappel = $this->db->get($db . ".ip_document_rappel")->result();
                //  return var_dump($documentrappel);die();
                if ($tab[$taille - 1]['document'] == 1) {
                    foreach ($documentrappel as $kj) {
                        array_push($files, './uploads/' . $licence[1] . '/documents/' . $kj->nomdocument);
                    }
                }
                if ($tab[$taille - 1]['joindredevis'] == 1) {
                    /* $this->generate_invoice_pdf($db, $tab[$taille - 1]['id'], false, null);

                    $dernier = $this->listdir_by_date('./uploads/' . $licence[1] . '/temprelance');*/
                    $dernier = "Facture " . $tab[$taille - 1]['in_number'] . ".pdf";
                    array_push($files, './uploads/' . $licence[1] . '/temprelance/' . $dernier);
                }
                $this->delrappel($db, $tab[$taille - 1]['ip_rappelmail_id']);

            } else {
                $usermail = "SELECT ip_users.user_email,ip_users.user_name,ip_users.signature FROM " . $db . ".ip_users," . $db . ".ip_quotes where ip_quotes.user_id=ip_users.user_id and ip_quotes.quote_id= " . $tab[$taille - 1]['id'];
                $usermailconnect = $this->db->query($usermail)->result();
                $CI->db->where("quote_id", $tab[$taille - 1]['id']);
                $CI->db->join($db . '.ip_users', 'ip_users.user_id= ip_quotes.user_id', 'left');
                $ip_quotes = $CI->db->get($db . ".ip_quotes")->result();
                //        $from .= $ip_quotes[0]->user_name . '<' . $ip_quotes[0]->user_email . '>';
                $from .= $ip_quotes[0]->user_email;
                //   $from .= $full_nameuser . '<' . $fromm . '>';
                $this->db->where("client_id", $tab[$taille - 1]['client']);
                $client = $this->db->get($db . ".ip_clients")->result();
                $to .= $client[0]->client_email;
                $quote = $this->get_quote_info_mail($db, $tab[$taille - 1]['id']);
                $aa = $this->getcontenumessage($db, 1);
                //  $subject .= $aa[0]->email_template_title ." ". $tab[$taille - 1]['id'] . ": " . $quote[0]->quote_nature;
                //  $subject.=$aa[0]->email_template_subject;
                $charray1 = array("{number}", "{nature}");
                $charrayreplace1 = array($quote[0]->quote_number, $quote[0]->quote_nature);
                $newphrasesubj = str_replace($charray1, $charrayreplace1, $aa[0]->email_template_subject);
                $subject .= $newphrasesubj;

                $fullname .= $civilite[$quote[0]->client_titre] . $client[0]->client_name . ' ' . $client[0]->client_prenom;
                $charray = array("{client_fullname}", "{number}", "{nature}", "{date_created}", "{signature}");
                $charrayreplace = array($fullname, $quote[0]->quote_number, $quote[0]->quote_nature, date('d/m/Y', strtotime($quote[0]->quote_date_created)), '');

                $serv = $_SERVER['REMOTE_ADDR'];
                $insertlog = "INSERT INTO " . $db . ".ip_logs (`log_action`, `log_date`, `log_ip`, `log_user_id`, `log_field1`, `log_field2`) VALUES ('rappel_devis',  '" . date('Y-m-d H:i:s') . "','" . $serv . "' , '1', '" . $client[0]->client_id . "', '" . $tab[$taille - 1]['id'] . "')";
                $this->db->query($insertlog);

                $ip_tracking = "INSERT INTO " . $db . ".ip_tracking (`action`, `date`, `ip`,`id_from`, `id_to`,`number`, `id_action`,`vu`) VALUES ('rappel_devis', '" . date('Y-m-d H:i:s') . "','" . $serv . "' , '" . $ip_quotes[0]->user_id . "','" . $client[0]->client_id . "', '" . $quote[0]->quote_number . "','" . $tab[$taille - 1]['id'] . "','0')";
                $this->db->query($ip_tracking);
                $idinsert = $this->db->insert_id();
                $newphrase = str_replace($charray, $charrayreplace, $aa[0]->email_template_body);
                $url="erp.bison.tn/cron/cronrappelautomatique/savevu/0/bi_".$licence[1]."/". $idinsert;
              //  $url = "erp-bison.novatis.org/cron/cronrappelautomatique/savevu/0/" . $db . "/" . $idinsert;
             

                $message .= "<img src='$url'  style='display:none'   >";
                $message .= $newphrase;
                $message .= "\r\n" . "<span style='font-size: 15px; color: #008080;'>" . $usermailconnect[0]->signature . "</span>";

                if ($tab[$taille - 1]['document'] == 1) {
                    $this->db->where("client_id", $tab[$taille - 1]['client']);
                    $this->db->where('object_id', $tab[$taille - 1]['id']);
                    $this->db->where('typeobject', 'quote');
                    $documentrappel = $this->db->get($db . ".ip_document_rappel")->result();

                    foreach ($documentrappel as $kj) {
                        array_push($files, './uploads/' . $licence[1] . '/documents/' . $kj->nomdocument);
                    }
                }
                if ($tab[$taille - 1]['joindredevis'] == 1) {
                    /*  $this->generate_quote_pdf($db, $tab[$taille - 1]['id'], false, null);

                    $dernier = $this->listdir_by_date('./uploads/' . $licence[1] . '/temprelance');

                    array_push($files, './uploads/' . $licence[1] . '/temprelance/' . $dernier);*/
                    $dernier = "Devis " . $tab[$taille - 1]['quote_number'] . ".pdf";
                    array_push($files, './uploads/' . $licence[1] . '/temprelance/' . $dernier);

                }
                $this->delrappel($db, $tab[$taille - 1]['ip_rappelmail_id']);
            }
            $message .= "</body></html>";
            $this->mailenvoisendphpmailer($db, $from, $to, $subject, $message, $licence[1], $files);
            unset($tab[$taille - 1]);
            return $this->send_mail1($db, $tab, ($taille - 1));
        }
        return true;
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

    public function get_invoice_info_mail($db, $invoice_id)
    {
        $CI = &get_instance();
        $CI->load->helper('country');
        $CI->db->where("ip_invoices.invoice_id", $invoice_id);
        $CI->db->join($db . '.ip_clients', 'ip_clients.client_id = ip_invoices.client_id', 'left');
        $CI->db->join($db . '.ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $CI->db->join($db . '.ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');

        $country = get_country_list($this->lang('cldr'));

        $invoices = $CI->db->get($db . ".ip_invoices")->result();
        $CI->db->where("ip_invoice_items.invoice_id", $invoice_id);
        $invoice_items = $CI->db->get($db . ".ip_invoice_items")->result();
        $invoices[0]->invoice_items = $invoice_items;
        $invoices[0]->client_country = $country[$invoices[0]->client_country];
        return $invoices;
    }

    public function get_quote_info_mail($db, $quote_id)
    {
        $CI = &get_instance();
        $CI->load->helper('country');
        $CI->db->where("ip_quotes.quote_id", $quote_id);
        $CI->db->join($db . '.ip_clients', 'ip_clients.client_id = ip_quotes.client_id', 'left');
        $CI->db->join($db . '.ip_devises', 'ip_clients.client_devise_id = ip_devises.devise_id', 'left');
        $CI->db->join($db . '.ip_quote_amounts', 'ip_quote_amounts.quote_id = ip_quotes.quote_id', 'left');

        $country = get_country_list($this->lang('cldr'));

        $quotes = $CI->db->get($db . ".ip_quotes")->result();

        $CI->db->where("ip_quote_items.quote_id", $quote_id);
        $quote_items = $CI->db->get($db . ".ip_quote_items")->result();
        $quotes[0]->quote_items = $quote_items;
        $quotes[0]->client_country = $country[$quotes[0]->client_country];
        return $quotes;
    }

    public function getcontenumessage($db, $type)
    {
        $CI = &get_instance();
        if ($type == 0) {
            // pour facture
            //$this->db->like('title', 'match');
            //  $CI->db->where("ip_email_templates.email_template_id", 3);
            $c = 'Relance automatique facture';
            $CI->db->like(trim("ip_email_templates.email_template_title"), $c);

        } else {
            // pour devis
            // $CI->db->where("ip_email_templates.email_template_id", 4);
            $c = 'Relance automatique devis';
            $CI->db->like(trim("ip_email_templates.email_template_title"), $c);
        }
        $email = $CI->db->get($db . ".ip_email_templates")->result();
        return ($email);
    }
    public function delrappel($db, $id)
    {
        $delidrappel = "DELETE FROM " . $db . ".ip_rappelmail where ip_rappelmail.ip_rappelmail_id=" . $id;
        $this->db->query($delidrappel);
    }

    public function mailenvoisendphpmailer($db, $from, $to, $subject, $message, $licence, $attachment_path)
    {
        //require_once APPPATH . 'modules/mailer/helpers/phpmailer_helper.php';
        $CI = &get_instance();
        $CI->load->helper('mailer/phpmailerhelperrelance');
        $bcc = $this->getuser($db);
        // $CI->load->library('encrypt');

        //$CI->db->select("*");
        // $ip_settingsvaltt = "SELECT ip_settings.setting_value from ip_settings ";

        $ip_settingsval = $this->db->get($db . '.ip_settings')->result();
        //  $ip_settingsval=$this->db->query($ip_settingsvaltt);
        // $CI->load->library('encrypt');

        //  return (var_dump($CI->encrypt->decode($ip_settingsval[58]->setting_value)));die();

        /*SELECT *
        FROM `ip_settings`
        WHERE `setting_key` LIKE 'smtp_server_address'
        $CI->db->select("ip_settings.setting_key,ip_settings.setting_key");*/

        // $ip_settingsval = $this->db->get($db .".ip_settings")->result();

        /* $CI->db->where('setting_key', 'smtp_server_address');
        $CI->db->where('setting_key', 'smtp_port');
        $CI->db->where('setting_key', 'email_send_method');
        $CI->db->where('setting_key', 'smtp_authentication');
        $CI->db->where('setting_key', 'smtp_username');
        $CI->db->where('setting_key', 'smtp_password');
        $CI->db->where('setting_key', 'smtp_security');)*/

        phpmail_send($from, $to, $ip_settingsval, $subject, $message, $attachment_path, $cc = null, $bcc);

    }

    public function listdir_by_date($path)
    {
        $dir = opendir($path);
        $list = array();
        while ($file = readdir($dir)) {
            if ($file != '.' and $file != '..') {
                // add the filename, to be sure not to
                // overwrite a array key
                $ctime = filectime($data_path . $file) . ',' . $file;
                $list[$ctime] = $file;
            }
        }
        closedir($dir);
        krsort($list);
        $firstKey = array_shift(array_keys($list));

        return $list[$firstKey];
    }

    public function lang()
    {
        return array(
            'connect' => 'Connecté en tant que',
            'next_code_invoice' => 'Code facture suivant',
            'next_code_devis' => 'Code devis suivant',
            'activities' => 'Activités',
            'system' => 'Système',
            'select' => 'Choisir',
            'feeds' => 'Flux',
            'proprietaire' => 'Propriétaire',
            'banque' => 'Banque',
            'remove' => 'Supprimer',
            'change' => 'Changer',
            'choi_img' => 'Sélectionner une image',
            'photo' => 'Photo de profil',
            'profil' => 'Consulter mon profil',
            'code' => 'Code',
            'account_information' => 'Informations du compte',
            'active' => 'Actif',
            'num_cheq' => 'N° Chèque',
            'montant_cheq' => 'Montant',
            'reference' => 'Référence',
            'active_client' => 'Actif',
            'revenus' => 'Revenus',
            'semaine' => 'Semaine',
            'mois' => 'Ce mois',
            'annee' => 'cet année',
            'mes_contact' => 'Mes contacts',
            'opportunite' => 'Opportunité',
            'mes_vent' => 'Mes ventes',
            'ca_entrep' => 'CA entreprise',
            //'num_devis' => 'N° devis',
            'home' => 'Accueil',
            'fich_contact' => 'Fiche contact',
            'num_devis' => 'N°',
            'filter_user' => 'Utilisateurs',
            'add_client' => 'Ajouter un contact',
            'add_clients' => 'Ajouter/Modifier un contact',
            'create_client' => 'Créer contact',
            'products_bloc' => 'Produits',
            'add_invoice_tax' => 'Ajouter un taux de TVA',
            'add_new_row' => 'Ajouter une ligne',
            'add_notes' => 'Ajouter une note',
            'add_product' => 'Ajouter un produit',
            'create_product' => 'Créer produit',
            'attention_pdf' => "À l'attention de",
            'CdtsReglement' => 'Cdts règlement',
            'item_pdf' => 'Réf. article',
            'qte_pdf' => 'Qté',
            'price_pdf' => 'PU HT',
            'total_pdf' => 'HT',
            'tva_pdf' => '%TVA',
            'tva_pdf2' => 'TVA',
            'msg_merci' => 'Merci de votre confiance.',
            'quote_par' => 'par',
            'remise_pdf' => 'Remise',
            'total_pdf' => 'Total',
            'total_ht_pdf' => 'Total HT',
            'ht_pdf' => 'HT',
            'total_tva_pdf' => 'Total TVA',
            'total_ttc_pdf' => 'Total TTC',
            'ttc' => 'TTC',
            'timbre_pdf' => 'Droit de timbre',
            'acompte_pdf' => 'Acompte',
            //'total_a_payer_pdf' => 'Total TTC',
            'total_a_payer_pdf' => 'Net à payer',
            'solde_credit' => 'Solde de cr&eacute;dit',
            'signature_pdf' => 'Nom, qualité et signature ou cachet du client',
            'bon_accord_pdf' => 'Bon pour accord le ________________',
            'import_from_xsl' => 'Importer au format XSL',
            'exploite_champs' => 'Explore champs',
            'add_quote_tax' => 'Ajouter une taxe pour les devis',
            'address' => 'Adresse',
            'administrator' => 'Administrateur',
            'after_amount' => 'Après le montant',
            'all' => 'Tous',
            'amount' => 'Montant ',
            'amount_due' => 'Montant dû',
            //'any_family' => 'n\'importe quelle famille',
            'any_family' => 'Tous Familles',
            'apply_after_item_tax' => 'Appliquer après la taxe de l\'article',
            'apply_before_item_tax' => 'Appliquer avant la taxe de l\'article',
            'approve' => 'Approuver',
            'approve_this_quote' => 'Valider ce devis',
            'approved' => 'Validé',
            'automatic_email_on_recur' => 'Envoyer les factures récurrentes automatiquement',
            'balance' => 'Solde',
            'base_invoice' => 'Facture de base',
            'bcc' => 'BCC',
            'before_amount' => 'Avant le montant',
            'bill_to' => 'Facturé à ',
            'quote_Devis' => 'N/Ref : Devis',
            'num/ref' => 'N/Ref',
            'quote_expire_le' => 'Limite de validité',
            'quote_Du' => 'du',
            'body' => 'Corps du message',
            'calendar_month' => 'Mois',
            'calendar_week' => 'Hebdomadaire',
            'cancel' => 'Annuler',
            'canceled' => 'Annulé',
            'cannot_connect_database_server' => 'Impossible de se connecter au serveur de base de données',
            'cannot_select_specified_database' => 'Impossible de sélectionner la base de données renseignée',
            'can_be_changed' => 'Peut être modifié',
            'cc' => 'CC',
            'change_password' => 'Modifier le mot de passe',
            'checking_for_updates' => 'Vérification des mises à jour...',
            'city' => 'Ville ',
            'cldr' => 'fr',
            'client' => 'Contact',
            'client_access' => 'Accès client',
            'client_form' => 'Formulaire contact',
            'client_type' => 'Type',
            'client_prenom' => 'Prénom du contact ',
            'client_date_naiss' => 'Date de naissance',
            'client_societe' => 'Societé',
            'client_fix' => 'Fix',
            'prospect_filter' => 'Prospect',
            'client_filter' => 'Client',
            'client_fax' => 'Fax',
            'client_zip' => 'Code postal',
            'client_ville' => 'Ville',
            'client_pays' => 'Pays',
            'client_mobile' => 'Mobile',
            'client_attention' => "A l'attention de",
            'client_tel2' => 'Autre téléphone',
            'client_address2' => 'Adresse 2',
            'client_devise_id' => 'Devise du contact ',
            'client_titre' => 'Titre ',
            'client_name' => 'Nom du contact ',
            'client_name_quote' => 'Contact ',
            'suivi' => 'Suivi',
            'date_modified' => 'Modif le',
            'user_modified' => 'Par',
            //    'all_date' => 'Toutes les dates',
            'all_date' => 'Tout',
            'all_statue' => 'Statuts',
            'client_pays' => 'Pays',
            'amount_ht' => 'Total HT',
            'amount_ttc' => 'Total TTC',
            'accepte_le' => 'Accepté',
            // 'mode_pmt' => 'Mode pmt',
            'mode_pmt' => 'MP',
            'clients' => 'Contacts',
            'client_site' => 'Site web',
            'client_email' => 'Adresse E-mail',
            'client_address' => 'Adresse',
            'client_name_tab' => 'Nom & prénom',
            'client_raison_tab' => 'Societé',
            'client_adresse_tab' => 'Adresse',
            'client_email_tab' => 'Email',
            'client_telFix_tab' => 'Fix',
            'client_telmobile_tab' => 'Portable',
            'client_webSite_tab' => 'Site web',
            'new_client_devis' => 'Contact',
            'close' => 'Fermer',
            'closed' => 'Fermé',
            'column' => 'Colonne',
            'company' => 'Entreprise',
            'confirm' => 'Confirmer',
            'confirm_deletion' => 'Confirmer la suppression',
            //'contact_information' => 'Coordonnées de contact',
            'contact_information' => 'Coordonnées',
            'continue' => 'Continuer',
            'copy_invoice' => 'Copier la facture',
            'copy_quote' => 'Copier le devis',
            'country' => 'Pays ',
            'create_credit_invoice' => 'Créer une note de crédit',
            'create_credit_invoice_alert' => 'Créer une note de crédit verrouillera cette facture en <em>lecture seule</em>, ce qui signifie que vous ne pourrez plus la modifier. La note de crédit reprendra l\'ensemble des détails de la facture mais avec les montant et soldes négatifs.',
            'create_invoice' => 'Créer une facture',
            'create_product' => 'Créer un produit',
            'create_fournisseur' => 'Créer un fournisseur',
            'create_quote' => 'Créer un devis',
            'edit_quote' => 'Modifier un devis',
            'create_recurring' => 'Créer une récurrence',
            'created' => 'Créé',
            'credit_invoice' => 'Note de crédit',
            'credit_invoice_date' => 'Date de la note de crédit',
            'credit_invoice_details' => 'Détails de la note de crédit',
            'credit_invoice_for_invoice' => 'Note de crédit pour cette facture',
            'cron_key' => 'Clé CRON ',
            'currency_symbol' => 'Symbole monétaire ',
            'currency_symbol_placement' => 'Position du symbole monétaire',
            'current_day' => 'Date courante',
            'current_month' => 'Mois courant',
            'current_version' => 'Version ',
            'current_year' => 'Année courante',
            'custom_field_form' => 'Éditeur de champ personnalisé',
            'custom_fields' => 'Champs personnalisés',
            'custom_title' => 'Titre personnalisé',
            'dashboard' => 'Tableau de bord',
            'database' => 'Base de données ',
            'database_properly_configured' => 'La base de données est correctement configurée',
            'date' => 'Date ',
            'date_applied' => 'Date appliquée',
            'date_format' => 'Format de date ',
            'days' => 'Jours',
            'decimal_point' => 'Séparateur décimal ',
            'default_country' => 'Pays par défaut',
            'default_email_template' => 'Modèle d\'Email par défaut',
            'default_invoice_group' => 'Groupe de factures par défaut',
            'default_invoice_tax_rate' => 'Taxe par défaut sur une facture',
            'default_invoice_tax_rate_placement' => 'Position par défaut de la taxe sur une facture',
            'default_item_tax_rate' => 'Taux de TVA d\'article par défaut',
            'default_item_timbre' => 'Timbre fiscal',
            'default_list_limit' => 'Nombre d\'éléments dans les listes',
            'default_pdf_template' => 'Modèle PDF par défaut',
            'default_public_template' => 'Modèle public par défaut',
            'default_quote_group' => 'Groupe Devis par défaut',
            'default_terms' => 'C. G. V. par défaut ',
            'delete' => 'Supprimer',
            'delete_client' => 'Supprimer le client',
            'delete_client_warning' => 'Si vous supprimez ce client, vous supprimerez toutes les factures, devis et paiements associées à ce client. Êtes-vous sûr de vouloir supprimer définitivement ce client ?',
            'delete_invoice' => 'Supprimer facture',
            'delete_invoice_warning' => 'Si vous supprimez cette facture, il vous sera impossible de la restaurer ultérieurement. Êtes-vous sûr de vouloir supprimer définitivement cette facture ?',
            'delete_quote' => 'Supprimer le devis',
            'delete_quote_warning' => 'Si vous supprimez ce devis, il vous sera impossible de le restaurer ultérieurement. Êtes-vous sûr de vouloir supprimer définitivement ce devis ?',
            'delete_record_warning' => 'Êtes-vous sûr de vouloir supprimer cet enregistrement ?',
            'description' => 'Libellé ',
            'details' => 'Détails',
            'disable_quickactions' => 'Désactiver les Quickactions',
            'disable_sidebar' => 'Désactiver la barre latérale',
            'documentation' => 'Documentation',
            'download_pdf' => 'Télécharger le PDF',
            'draft' => 'Brouillon',
            'due_date' => 'Échéance',
            'edit' => 'Editer',
            'email' => 'Email ',
            'email_address' => 'Adresse Email ',
            'email_invoice' => 'Envoyer la facture par Email',
            'email_not_configured' => 'Avant d\'envoyer des courriels, vous devez configurer vos paramètres e-mail dans la page des Paramètres Systèmes.',
            'email_quote' => 'Envoyer devis par Email',
            'email_send_method' => 'Envoi des emails par ',
            'email_send_method_phpmail' => 'PHP Mail',
            'email_send_method_sendmail' => 'Sendmail',
            'email_send_method_smtp' => 'SMTP',
            'email_successfully_sent' => 'Email envoyé avec succès',
            'email_template' => 'Modèle de courriel',
            'email_template_form' => 'Éditeur de modèle d\'Email',
            'email_template_overdue' => 'Modèle courriel d\'un paiement en retard',
            'email_template_paid' => 'Modèle courriel d\'une facture payée',
            'email_template_tags' => 'Modèles de balises pour Email',
            'email_template_tags_instructions' => 'Sélectionnez d\'abord une zone de texte, puis cliquez sur un modèle de balise ci-dessous pour l\'y insérer.',
            'email_templates' => 'Modèles d\'Email',
            'end_date' => 'Date de fin',
            'enter_payment' => 'Saisir un paiement',
            'errors' => 'Erreurs',
            'every' => 'Fréquence ',
            'example' => 'Exemple',
            'expired' => 'Expiré',
            'expires' => 'Expire le',
            'extra_information' => 'Informations complémentaires',
            'failure' => 'Échec',
            'families' => 'Familles',
            'family' => 'Famille',
            'family_name' => 'Nom de famille',
            'fax' => 'Fax ',
            'fax_abbr' => 'Fax',
            'fax_number' => 'N° de Fax ',
            'filter_clients' => 'Filtrer les contacts',
            'filter_invoices' => 'Filtrer les factures',
            'filter_payments' => 'Filtrer les paiements',
            'filter_quotes' => 'Filtrer les devis',
            'first' => 'Premier',
            'first_day_of_week' => 'Premier jour de la semaine',
            'footer' => 'Pied de page',
            'forgot_your_password' => 'Mot de passe oublié?',
            'from_date' => 'Date de début',
            'from_email' => 'Email expéditeur',
            'from_name' => 'Nom expéditeur',
            'general' => 'Général',
            'generate' => 'Générer',
            'guest_account_denied' => 'Ce compte n\'est pas configuré, merci de contacter l\'administrateur du système.',
            'guest_read_only' => 'Invité (en lecture seule)',
            'guest_url' => 'URL de consultation ',
            'hostname' => 'Hôte ',
            'id' => 'ID ',
            'identifier_format' => 'Format de l\'identifiant',
            'identifier_format_template_tags' => 'Balises de template pour le format d\'identifiant',
            'identifier_format_template_tags_instructions' => 'Sélectionnez d\'abord le champ "format de l\'identifiant", cliquez ensuite sur une balise de template ci-dessous pour l\'insérer dans le champ.',
            'import' => 'Importer',
            'import_data' => 'Importer des données',
            'import_from_csv' => 'Importer au format CSV',
            'inactive' => 'Inactif',
            'interface' => 'Interface',
            'invoice' => 'Facture',
            //'invoice_aging' => 'Historisation facture',
            'invoice_aging' => ' Historique des factures',
            'invoice_aging_16_30' => '16 - 30 jours',
            'invoice_aging_1_15' => '1 - 15 jours',
            'invoice_aging_above_30' => 'Plus de 30 jours',
            'invoice_count' => 'Nombre de factures',
            'invoice_date' => 'Date de facture ',
            'invoice_deletion_forbidden' => 'La suppression de factures n\'est pas autorisée. Contactez l\'administrateur ou consultez la documentation.',
            'invoice_group' => 'Groupe Facture',
            'invoice_group_form' => 'Modification d\'un modèle de factures',
            'invoice_groups' => 'Groupes de factures',
            'invoice_items' => 'Articles facturés',
            'invoice_logo' => 'Logo des factures ',
            'pdf_logo' => 'Logo des pdf ',
            'invoice_overview' => 'Aperçu des factures',
            'invoice_overview_period' => 'Synthèse des factures',
            'invoice_password' => 'Mot de passe PDF (facultatif)',
            'invoice_pre_password' => 'Facture standard PDF avec mot de passe (facultatif)',
            'invoice_tax' => 'TVA globale',
            'invoice_tax_rate' => 'Taux de TVA ',
            'taux' => 'Taux de Changement ',
            'invoice_template' => 'Modèle de facture',
            'invoice_terms' => 'Conditions de facturation',
            'invoiced' => 'Facturé',
            'invoiceplane_news' => 'Les dernières nouvelles de InvoicePlane',
            'invoices' => 'Factures',
            'invoices_due_after' => 'Échéance de facturation (en jours)',
            'is_not_writable' => 'n\'est pas accessible en écriture',
            'is_writable' => 'est accessible en écriture',
            'item' => 'Code',
            'item_lookup_form' => 'Ajout ou modification d\'un article générique',
            'item_lookups' => 'Liste d\'articles génériques',
            'item_name' => 'Nom de l\'article',
            'item_tax' => 'TVA',
            'item_tax_rate' => 'Taux de TVA de l\'article',
            'label' => 'Intitulé ',
            'language' => 'Langue ',
            'last' => 'Dernier',
            'last_month' => 'Mois dernier',
            'last_quarter' => 'Dernier trimestre',
            'last_year' => 'L\'année dernière',
            'left_pad' => 'Nombre de zéros non-significatifs',
            'login' => 'Connexion',
            'loginalert_credentials_incorrect' => 'Email ou mot de passe incorrect.',
            'loginalert_no_password' => 'Veuillez saisir un mot de passe.',
            'loginalert_user_inactive' => 'Cet utilisateur est marqué comme inactif. Merci de contacte l\'administrateur.',
            'loginalert_user_not_found' => 'Il n\'y a aucun compte enregistré avec cette adresse e-mail.',
            'logout' => 'Déconnexion',
            'mark_invoices_sent_pdf' => 'Marquer les factures comme envoyées quand le PDF est généré',
            'mark_quotes_sent_pdf' => 'Marquer les devis comme envoyés quand le PDF est généré',
            'max_quantity' => 'Quantité maximale',
            'menu' => 'Menu',
            'merchant_account' => 'Compte marchand ',
            'merchant_currency_code' => 'Code de devise',
            'merchant_driver' => 'Protocole marchand ',
            'merchant_enable' => 'Activer les règlements en ligne',
            'merchant_payment_cancel' => 'Votre paiement a été annulé.',
            'merchant_payment_fail' => 'Désolé, mais un problème est survenu lors de votre paiement..',
            'merchant_payment_success' => 'Votre paiement a été effectué.',
            'merchant_signature' => 'Signature ',
            'merchant_test_mode' => 'Mode test ',
            'min_quantity' => 'Quantité minimale',
            'mobile' => 'Téléphone mobile',
            'mobile_number' => 'N° de portable ',
            'monday' => 'Lundi',
            'monospaced_font_for_amounts' => 'Utilisez une police de taille fixe pour les montants',
            'month' => 'Mois',
            'month_prefix' => 'Préfixe du mois ',
            'name' => 'Nom ',
            'new' => 'Nouveau',
            'new_password' => 'Nouveau mot de passe',
            'new_product' => 'Nouveau produit',
            'new_fournisseur' => 'Nouveau fournisseur',
            'next' => 'Suivant',
            'next_date' => 'Date suivante',
            'next_id' => 'ID suivant ',
            'no' => 'Non',
            'no_overdue_invoices' => 'Aucune facture en retard',
            'no_quotes_requiring_approval' => 'Il n\'y a pas de devis en attente de validation.',
            'no_updates_available' => 'Aucune mise à jour n’est actuellement disponible.',
            'none' => 'Aucun',
            'note' => 'Note ',
            'notes' => 'Note',
            'online_payment_method' => 'Méthode de paiement en ligne',
            'open' => 'Edité',
            'open_invoices' => 'Facturations en cours',
            'open_quotes' => 'Ouvir le devis',
            'optional' => 'Optionnel',
            'options' => 'Options',
            'overdue' => 'Impayé',
            'overdue_invoices' => 'Factures impayées',
            'paid' => 'Payé',
            'password' => 'Mot&nbsp;de&nbsp;passe',
            'password_changed' => 'Mot de passe modifié avec succès',
            'password_reset' => 'Réinitialiser le mot de passe',
            //'password_reset_email' => 'Vous avez demandé un nouveau mot de passe pour votre Installation d\'InvoicePlane. Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :',
            'password_reset_email' => 'Vous avez demandé un nouveau mot de passe pour votre utilisation du Bison ERP. Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :',
            'password_reset_info' => 'Vous recevrez un E-mail avec un lien pour réinitialiser votre mot de passe.',
            'pay_now' => 'Payer maintenant',
            'payment' => 'Paiement',
            'payment_cannot_exceed_balance' => 'Le montant du paiement ne peux pas excéder le solde de la facture.',
            'payment_date' => 'Date de paiement',
            'payment_form' => 'Édition d\'un paiement',
            'payment_history' => 'Historique de paiements',
            'payment_method' => 'Moyen de paiement ',
            'payment_method_form' => 'Édition d\'un moyen de paiement',
            'payment_methods' => 'Moyens de paiements',
            'payments' => 'Paiements',
            'pdf' => 'PDF',
            'pdf_invoice_footer' => 'Pied de page PDF',
            'pdf_footer_hint' => 'Vous pouvez entrer ici des éléments HTML qui s\'afficheront au bas de vos PDF.',
            'pdf_template' => 'Modèle de PDF',
            'pdf_template_overdue' => 'Modèle PDF d\'un paiement en retard',
            'pdf_template_paid' => 'Modèle PDF d\'une facture payée',
            'period' => 'Période',
            'personal_information' => 'Informations personnelles',
            'phone' => 'Tél. ',
            'phone_abbr' => 'Téléphone',
            'phone_number' => 'N° de téléphone ',
            'php_timezone_fail' => 'Le paramétrage du fuseau horaire ne semble pas avoir été fait, veuillez contrôler ce point dans votre configuration de php. À défaut <strong>%s</strong> sera utilisé.',
            'php_timezone_success' => 'Le fuseau horaire a bien été configuré.',
            'php_version_fail' => 'La version PHP %s est installée mais InvoicePlane requiert la version PHP %s ou supérieure',
            'php_version_success' => 'PHP semble répondre aux besoins de l\'installation',
            'please_enable_js' => 'Merci de rendre possible l\'exécution de code javascript pour le bon fonctionnement d\'InvoicePlane',
            'prefix' => 'Prefixe ',
            'prev' => 'Préc',
            'price' => 'Prix unitaire HT',
            'product' => 'Produit',
            'product_description' => 'Description du produit',
            'product_families' => 'Familles de produits',
            'add_product_families' => 'Ajouter Familles de produit',
            'product_name' => 'Nom du produit',
            'product_price' => 'Prix de vente',
            'product_description2' => 'Description',
            'product_name2' => 'Produit',
            'product_price2' => 'Prix',
            'product_sku2' => 'Réf.',
            'family_name2' => 'Famille',
            'quote_nature' => 'Nature',
            'quote_delai_paiement' => 'Modalité de paiement',
            'quote_date_accepte' => 'Accepté le',
            'delai_paiement_label' => 'Label',
            'remise_tab' => 'Remise',
            'acompte_tab' => 'Acompte',
            'pourcentage_remise' => 'Remise (%) ',
            'accompte_remise' => 'Acompte(%) ',
            'montant' => 'Montant ',
            'total_a_payer' => 'Solde à payer',
            'default_devis_code' => 'Code devis par défaut',
            'product_sku' => 'Référence (SKU)',
            'products' => 'Produits',
            'Fournisseurs' => 'Fournisseurs',
            'raison_social_fournisseur' => 'Raison social',
            'adresse_fournisseur' => 'Adresse',
            'adresse2_fournisseur' => 'Adresse 2',
            'code_postal_fournisseur' => 'Code postal',
            'ville_fournisseur' => 'Ville',
            'pays_fournisseur' => 'Pays',
            'mail_fournisseur' => 'Email',
            'tel_fournisseur' => 'Téléphone',
            'tel2_fournisseur' => 'Téléphone 2',
            'fax_fournisseur' => 'Fax',
            'note_fournisseur' => 'Note',
            'site_web_fournisseur' => 'Site web',
            'purchase_price' => 'Prix ??d\'achat',
            'Q1' => 'Trimestre 1',
            'Q2' => 'Trimestre 2',
            'Q3' => 'Trimestre 3',
            'Q4' => 'Trimestre 4',
            'qty' => 'Qté',
            'quantity' => 'Quantité',
            'quarter' => 'Trimestrielle',
            'quick_actions' => 'Actions rapides',
            'quote' => 'Devis',
            'quote_approved' => 'Ce devis a été accepté',
            'quote_date' => 'Date du devis ',
            'quote_group' => 'Groupe de devis ',
            'quote_overview' => 'Aperçu des devis',
            'quote_overview_period' => 'Synthèse des devis',
            'quote_password' => 'Devis PDF avec mot de passe',
            'quote_pre_password' => 'Devis standard PDF avec mot de passe (facultatif)',
            'quote_rejected' => 'Ce devis n\'a pas été approuvé',
            'quote_status_email_body' => 'Le client %1$s a %2$s le devis %3$s.

        Lien vers le devis: %4$s',
            'quote_status_email_subject' => 'Client %1$s %2$s devis %3$s',
            'quote_tax' => 'Taxes des devis',
            'quote_template' => 'Modèle du devis',
            'quote_to_invoice' => 'Transférer le devis en facture',
            'quote_invoice' => 'Devis- Facture',
            'quotes' => 'Devis',
            'quotes_expire_after' => 'Expiration (en jours) ',
            'quotes_requiring_approval' => 'Devis en attente de validation',
            'read_only' => 'Lecture seule',
            'recent_clients' => 'Derniers Clients',
            'recent_invoices' => 'Dernières factures',
            'recent_payments' => 'Derniers Règlements',
            'recent_quotes' => 'Devis récents',
            'record_successfully_created' => 'Enregistrement correctement effectué',
            'record_successfully_deleted' => 'Enregistrement correctement supprimé',
            'record_successfully_updated' => 'Enregistrement correctement mis à jour',
            'recurring' => 'Recurrente',
            'recurring_invoices' => 'Factures récurrentes ',
            'reject' => 'Rejeter',
            'reject_this_quote' => 'Rejeter ce devis',
            'rejected' => 'Rejeté',
            'remove' => 'Supprimer',
            'remove_logo' => 'Supprimer le logo',
            'report_options' => 'Options du rapport',
            'reports' => 'Rapports',
            'reset_password' => 'Réinitialiser le mot de passe',
            'run_report' => 'Générer le rapport',
            'search_product' => 'Rechercher un produit',
            'search_client' => 'Rechercher un contact',
            'sales' => 'Ventes',
            'sales_by_client' => 'Chiffre d\'affaires par Client',
            'sales_by_date' => 'Ventes par Date',
            'sales_with_tax' => 'Ventes taxées',
            'save' => 'Enregistrer',
            'save_item_as_lookup' => 'Sauvegarder comme article générique',
            'select_family' => 'Sélectionnez la famille',
            'select_payment_method' => 'Sélectionnez le mode de paiement',
            'send' => 'Envoyer',
            'send_email' => 'Envoyer par Email',
            'date_rappel' => 'Planification',
            'delete_date_rappel' => 'Supprimer planification',
            'msg_confirmation_delete_rappel' => 'Êtes-vous sûr de vouloir supprimer définitivement la planification de ce devis?',
            'sent' => 'Envoyé',
            'set_new_password' => 'Définir un nouveau mot de passe',
            'settings' => 'Paramètres',
            'settings_successfully_saved' => 'Paramètres correctement enregistrés',
            'setup_choose_language' => 'Choisissez la langue',
            'setup_choose_language_message' => 'Choisissez la langue avant de poursuivre l\'installation.',
            'setup_complete' => 'Installation terminée !',
            'setup_complete_message' => 'InvoicePlane est bien installé. Vous pouvez dés à présent vous connecter.',
            'setup_complete_secure_setup' => 'Afin de sécuriser votre site Internet veuillez modifier le fichier .htacces de votre domaine en y insérant le code suivant entre les balises <code></code> :',
            'setup_complete_support_note' => 'Si vous rencontrez un problème ou avez besoin d\'aide, consultez le <a href="https://wiki.invoiceplane.com">wiki officiel</a> ou le <a href="https://community.invoiceplane.com/">forum de la communauté</a>.',
            'setup_create_user' => 'Création d\'un compte utilisateur',
            'setup_create_user_message' => 'Voici les informations nécessaires pour vous connecter à InvoicePlane.',
            'setup_database_configured_message' => 'La base de données a été correctement configurée.',
            'setup_database_details' => 'Détails de la base de données',
            'setup_database_message' => 'Renseignez les informations suivantes afin d\'établir une connexion à votre base de données.',
            'setup_db_database_info' => 'Le nom de votre base de données pour InvoicePlane.',
            'setup_db_hostname_info' => 'L\'hôte de votre base de données.',
            'setup_db_password_info' => 'Le mot de passe de votre base de données.',
            'setup_db_username_info' => 'Le nom d\'utilisateur de votre base de données.',
            'setup_install_tables' => 'Installation des tables',
            'setup_other_contact' => 'Contact',
            'setup_prerequisites' => 'Pré-requis',
            'setup_prerequisites_message' => 'Bienvenue dans InvoicePlane ! Tous les points suivants doivent être résolus afin de pouvoir poursuivre le programme d\'installation.',
            'setup_tables_errors' => 'Les erreurs listées ci-dessous doivent être corrigées avant de poursuivre l\'installation.',
            'setup_tables_success' => 'Les tables ont été correctement installées.',
            'setup_upgrade_message' => 'Les erreurs listées ci-dessous doivent être corrigées pour pouvoir terminer l\'installation.',
            'setup_upgrade_success' => 'La base de données a été correctement mise à jour.',
            'setup_upgrade_tables' => 'Mise à jour des tables',
            'setup_user_address_info' => 'L\'adresse visible dans vos factures.',
            'setup_user_contact_info' => 'Informations de contact visibles dans vos factures.',
            'setup_user_email_info' => 'Votre adresse de courriel servira pour se connecter à InvoicePlane.',
            'setup_user_name_info' => 'Votre raison sociale ou vos prénom et nom.',
            'setup_user_password_info' => 'Veuillez utiliser un mot de passe suffisamment complexe. Une combinaison de lettres majuscules et de minuscules, ainsi que des chiffres et symboles est fortement recommandée.',
            'setup_user_password_verify_info' => 'Confirmez votre mot de passe en le saisissant de nouveau.',
            'setup_v120_alert' => '<b>Attention!</b> <br/>Il est extrêmement recommandé que vous lisiez <a href="https://go.invoiceplane.com/v120update" target="_blank">cet avis de mise à jour</a> concernant certains changements importants dans l\'application InvoicePlane.',
            'set_to_read_only' => 'Marquer la facture en lecture seule',
            'six_months' => 'Semestrielle',
            'smtp_password' => 'Mot de passe SMTP ',
            'smtp_port' => 'Port SMTP ',
            'smtp_requires_authentication' => 'Nécessite une authentification ',
            'smtp_security' => 'Sécurité ',
            'smtp_server_address' => 'Adresse du serveur SMTP ',
            'smtp_ssl' => 'SSL ',
            'smtp_tls' => 'TLS',
            'smtp_username' => 'Utilisateur SMTP ',
            'sql_file' => 'Fichier SQL',
            'start_date' => 'Date début ',
            'state' => 'État',
            'status_tab' => 'St',
            'status' => 'Statut',
            'stop' => 'Suspendre',
            'important' => 'Important',
            'street_address' => 'Adresse ',
            'street_address_2' => 'Complément ',
            'subject' => 'Objet',
            'submenu' => 'Sous-menu',
            'submit' => 'Soumettre',
            'subtotal' => 'Sous-total HT',
            'success' => 'Réussi',
            'sunday' => 'Dimanche',
            'system_settings' => 'Paramètres systèmes',
            'societes_settings' => 'Sociétés',
            'table' => 'Table ',
            'tax' => 'TVA ',
            'tax_code' => 'Registre de commerce',
            'matricule_fisc' => 'Matricule fiscal',
            'registre_commerce_pdf' => 'RC',
            'matricule_fisc_pdf' => 'MF',
            //'tax_code_short' => 'Code taxe',
            'tax_code_short' => 'Code TVA',
            'mail_admin' => 'E-mail Administrateur',
            'tax_information' => 'Note sur les Taxes',
            'tax_rate' => '% TVA',
            'tax_rate_decimal_places' => 'Nombre de décimales ',
            'tax_rate_form' => 'Édition d\'un taux de TVA',
            'tax_rate_name' => 'Intitulé',
            'tax_rate_percent' => 'Pourcentage de TVA',
            'tax_rate_placement' => 'Positionnement',
            'tax_rates' => 'Taux de TVA',
            'taxes' => 'TVA ',
            'terms' => 'Conditions générales de vente',
            'this_month' => 'Ce mois',
            'this_quarter' => 'Ce trimestre',
            'this_year' => 'Cette année',
            'thousands_separator' => 'Séparateur de milliers ',
            'title' => 'Titre',
            'to_date' => 'En date du ',
            'to_email' => 'Email du destinataire',
            'total' => 'Total TTC',
            'total_balance' => 'Solde total ',
            'total_billed' => 'Total facturé ',
            'total_paid' => 'Total payé ',
            'try_again' => 'Essayez à nouveau',
            'type' => 'Type',
            'unknown' => 'Inconnu',
            'updatecheck' => 'Contrôle des mises à jour',
            'updatecheck_failed' => 'Le contrôle de mise à jour a échoué ! Vérifier votre connexion réseau.',
            'updates' => 'Mises à jour',
            'updates_available' => 'Des Mises à jour sont disponibles!',
            'user' => 'Utilisateur',
            'user_accounts' => 'Comptes utilisateurs',
            'company_accounts' => 'Paramètres société',
            'user_form' => 'Édition d\'un utilisateur',
            'user_type' => 'Type d\'utilisateur ',
            'username' => 'Nom d\'utilisateur ',
            'users' => 'Utilisateurs',
            'values_with_taxes' => 'Valeurs avec taxes',
            'vat_id' => 'Code TVA',
            'vat_id_short' => 'TVA',
            'verify_password' => 'Confirmation ',
            'version_history' => 'Historique des versions',
            'view' => 'Voir',
            'view_all' => 'Voir toute la liste',
            'view_client' => 'Voir ce Client',
            'view_clien' => 'Consulter un Client',
            'view_clients' => 'Liste des contacts',
            'view_invoices' => 'Liste des factures',
            'view_payments' => 'Liste des paiements',
            'view_products' => 'Liste des produits',
            'view_fournisseurs' => 'Liste des fournisseurs',
            'view_quotes' => 'Liste des devis',
            'rappel_auj' => "Voir rappel aujourd'hui",
            'view_recurring_invoices' => 'Voir les factures récurrentes',
            'viewed' => 'Consulté',
            'warning' => 'Avertissement',
            'web' => 'Web ',
            'web_address' => 'Site Web ',
            'welcome' => 'Bienvenue',
            'year' => 'Année',
            'year_prefix' => 'Prefixe de l\'année ',
            'years' => 'Années',
            'yes' => 'Oui',
            'zip_code' => 'Code postal ',
            'msg_arret' => 'Arrété le pr&eacute;sent devis à la somme de ',
            'msg_arret_fact' => 'Arrété la pr&eacute;sente facture à la somme de ',
            'societes' => 'Entreprise ',
            'raison_social_societes' => 'Raison social ',
            'adresse_societes' => 'Adresse Sfax',
            'tel_societes' => 'Tél. ',
            'adresse2_societes' => '2ème Adresse ',
            'tel2_societes' => 'Tél. ',
            'site_web_societes' => 'Site web  ',
            'mail_societes' => 'Email ',
            'fax_societes' => 'Fax ',
            'note_societes' => 'Notes ',
            'new_societes' => 'Contact de l\'entrprise',
            'code_tva_societes' => 'T.V.A. ',
            'matricule_fiscale_societes' => 'Matricule Fiscal ',
            'mf_societes' => 'M.F. ',
            'devise' => 'Devise',
            'add_devise' => 'Ajouter / Modifier Devise',
            'devise_label' => 'Désignation Devise',
            'devise_symbole' => 'Symbole',
            'historique_relances' => 'Historique des relances ',
            'date_Rappel' => 'Date Rappel ',
            'etat_relance' => 'Etat du relance ',
            'relance' => 'Relancer ',
            'bon_commande' => 'Bon de commande ',
            'designation' => 'D&eacute;signation ',
            'etat' => '&Eacute;tat ',
            'groupes_users' => 'Utilisateurs ',
            'groupe_user' => 'Groupe utilisateur ',
            'droit_accees' => 'Droit d\'accés',
            'ajout-modif' => 'Ajouter- Modifier',
            'modif-facture' => 'Modifier Facture',
            'sup' => 'Supprimer',
            'index' => 'Consulter',
            'fourniss' => 'Fournisseur',
            'msg_acc' => 'Droits d\'accès insuffisants ',
            'paye_pdf' => 'Somme payé ',
            'rest_pdf' => 'Reste à payer  ',
            'craint' => 'Pas de soucis, cliquez   ',
            'here' => 'Ici  ',
            'resett' => 'pour réinitialiser votre mot de passe  ',
            'logginn' => 'Connectez-vous à votre compte  ',
            'enter' => 'Entrez Votre E-mail et votre mot de passe  ',
            'logginn' => 'Connectez-vous à votre compte  ',
            'logginn' => 'Connectez-vous à votre compte  ',
            'logginn' => 'Connectez-vous à votre compte  ',
            'error_nb_ligne' => "Ins&eacute;rer au moins une ligne.</p>\n",
        );
    }

    public function getuser($db)
    {
        /*  $this->db->join($db . '.ip_groupes_users', 'ip_groupes_users.groupes_user_id = ip_users.groupes_user_id', 'left');
        $this->db->where("ip_users.groupes_user_id", 1);
        $users = $this->db->get($db . ".ip_users")->result();
        $array = '';
        $this->db->where("setting_key", 'relance_cci');
        $result = $this->db->get($db . ".ip_settings")->result();
        $res = 0;
        if ($result[0]->setting_value == 1) {
        $res = $res + 1;
        }
        if ($res > 0) {
        foreach ($users as $user) {
        $array .= $user->user_email . ',';
        }
        }

         */
        //$this->db->select("ip_settings.mail_admin");
        $array = '';
        $this->db->where("setting_key", 'relance_cci');
        $result = $this->db->get($db . ".ip_settings")->result();
        $res = 0;
        if ($result[0]->setting_value == 1) {
            $res = $res + 1;
        }

        if ($res > 0) {
            $this->db->where("setting_key", "mail_admin");
            $ip_settings = $this->db->get($db . ".ip_settings")->result();
            $array .= $ip_settings[0]->setting_value . ',';
        }
        return $array;

    }

    public function getidobj($db, $id)
    {
        $this->db->select("ip_tracking.id_action");
        $this->db->where("ip_tracking.log_id", $id);
        $obj = $this->db->get($db . ".ip_tracking")->result();
        return $obj[0]->id_action;
    }
 /*   public function creeimg()
    {

        $string = "aaa";
        $my_img = imagecreate( 200, 80 );
        $background = imagecolorallocate( $my_img, 0, 0, 255 );
        $text_colour = imagecolorallocate( $my_img, 255, 255, 0 );
        $line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
        imagestring( $my_img, 4, 30, 25, $string , $text_colour );
        imagesetthickness ( $my_img, 5 );
        imageline( $my_img, 30, 45, 165, 45, $line_colour );

        header( "Content-type: image/png" );
        imagepng( $my_img );
        imagecolordeallocate( $line_color );
        imagecolordeallocate( $text_color );
        imagecolordeallocate( $background ); 
        //   imagedestroy( $my_img );

        $string = "aaa";

        $source = imagecreatefromjpeg("'./uploads/4888/imgcree.png'"); // La photo est la source
        $destination = imagecreatetruecolor(200, 150); // On crée la miniature vide

        // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        $largeur_destination = imagesx($destination);
        $hauteur_destination = imagesy($destination);

        $orange = imagecolorallocate($im, 220, 210, 60);
        $px = (imagesx($source) - 7.5 * strlen($string)) / 2;
        imagestring($source, 3, $px, 9, $string, $orange);
        // On crée la miniature
       // imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
   
        imagejpeg($destination, './uploads/4888/imgcree.png');

    }*/

}