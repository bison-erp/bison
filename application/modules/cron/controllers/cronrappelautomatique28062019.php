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
    public function savevu($db, $id)
    {
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
        $sql = "SELECT ip_rappelmail.ip_rappelmail_id,ip_quotes.quote_id,ip_rappelmail.daterappel,ip_quotes.client_id,ip_quotes.joindredevis,ip_quotes.document FROM " . $db . ".ip_rappelmail," . $db . ".ip_quotes   WHERE ip_quotes.quote_id = ip_rappelmail.idobject AND ip_rappelmail.type ='quote' AND (ip_quotes.quote_status_id = '3' or ip_quotes.quote_status_id ='2') ";
        $resultquote = $this->db->query($sql)->result();

        $sql1 = "SELECT ip_rappelmail.ip_rappelmail_id,ip_invoices.invoice_id,ip_rappelmail.daterappel,ip_invoices.client_id,ip_invoices.joindredevis,ip_invoices.document FROM " . $db . ".ip_rappelmail," . $db . ".ip_invoices   WHERE ip_invoices.invoice_id = ip_rappelmail.idobject AND ip_rappelmail.type ='invoice' AND (ip_invoices.invoice_status_id = '3' or ip_invoices.invoice_status_id ='2') ";
        $resultinvoice = $this->db->query($sql1)->result();
        $array = array();
        if (count($resultquote) > 0) {
            foreach ($resultquote as $key) {
                if ($key->daterappel == $datenow) {
                    if ($key->quote_id) {
                        $bc = ['type' => 'q', 'id' => $key->quote_id, 'client' => $key->client_id, 'ip_rappelmail_id' => $key->ip_rappelmail_id, 'joindredevis' => $key->joindredevis, 'document' => $key->document];
                        array_push($array, $bc);
                    }
                }

            }

        }
        if (count($resultinvoice) > 0) {
            foreach ($resultinvoice as $key) {
                if ($key->daterappel == $datenow) {
                    $bc = ['type' => 'i', 'id' => $key->invoice_id, 'client' => $key->client_id, 'ip_rappelmail_id' => $key->ip_rappelmail_id, 'joindredevis' => $key->joindredevis, 'document' => $key->document];
                    array_push($array, $bc);
                }

            }
        }
        $this->send_mail1($db, $array, sizeof($array));
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

                $ip_tracking = "INSERT INTO " . $db . ".ip_tracking (`action`, `date`, `ip`, `id_from`, `id_to`,`number`, `id_action`,`vu`) VALUES ('rappel_facture', '" . date('Y-m-d H:i:s') . "','" . $serv . "' , '" . $invoices_idobj[0]->user_id . "','" . $client[0]->client_id . "','".$invoice[0]->invoice_number."','" . $tab[$taille - 1]['id'] . "','0')";
                $this->db->query($ip_tracking);
                $idinsert=$this->db->insert_id();    

                $url="https://erp.bison.tn/cron/cronrappelautomatique/savevu/bi_".$licence[1]."/". $idinsert;

          //   $url="http://erp-bison.novatis.org/cron/cronrappelautomatique/savevu/".$db."/". $idinsert;

                $message.="<img src='$url' height='0.0001px' width='0.0001'>";         
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
                    $dernier = "Facture " . $tab[$taille - 1]['id'] . ".pdf";
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
                $idinsert=$this->db->insert_id();               
                $newphrase = str_replace($charray, $charrayreplace, $aa[0]->email_template_body);
                 $url="https://erp.bison.tn/cron/cronrappelautomatique/savevu/bi_".$licence[1]."/". $idinsert;
               //  $url="http://erp-bison.novatis.org/cron/cronrappelautomatique/savevu/".$db."/". $idinsert;

   
                  $message.="<img src='$url'  height='0.0001px' width='0.0001' >"; 
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
                    $dernier = "Devis " . $tab[$taille - 1]['id'] . ".pdf";
                    array_push($files, './uploads/' . $licence[1] . '/temprelance/' . $dernier);

                }
                $this->delrappel($db, $tab[$taille - 1]['ip_rappelmail_id']);
            }
            $message .= "</body></html>";
            $this->mailenvoisendphpmailer($db, $from, $to, $subject, $message, $licence[1], $files);
            unset($tab[$taille - 1]);
            return $this->send_mail1($db, $tab, ($taille - 1));
        }

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
        require_once APPPATH . 'modules/mailer/helpers/phpmailer_helper.php';
        $bcc = $this->getuser($db);
        phpmail_send($from, $to, $subject, $message, $attachment_path, $cc = null, $bcc);

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
            'connect' => 'Connect?? en tant que',
            'next_code_invoice' => 'Code facture suivant',
            'next_code_devis' => 'Code devis suivant',
            'activities' => 'Activit??s',
            'system' => 'Syst??me',
            'select' => 'Choisir',
            'feeds' => 'Flux',
            'proprietaire' => 'Propri??taire',
            'banque' => 'Banque',
            'remove' => 'Supprimer',
            'change' => 'Changer',
            'choi_img' => 'S??lectionner une image',
            'photo' => 'Photo de profil',
            'profil' => 'Consulter mon profil',
            'code' => 'Code',
            'account_information' => 'Informations du compte',
            'active' => 'Actif',
            'num_cheq' => 'N?? Ch??que',
            'montant_cheq' => 'Montant',
            'reference' => 'R??f??rence',
            'active_client' => 'Actif',
            'revenus' => 'Revenus',
            'semaine' => 'Semaine',
            'mois' => 'Ce mois',
            'annee' => 'cet ann??e',
            'mes_contact' => 'Mes contacts',
            'opportunite' => 'Opportunit??',
            'mes_vent' => 'Mes ventes',
            'ca_entrep' => 'CA entreprise',
            //'num_devis' => 'N?? devis',
            'home' => 'Accueil',
            'fich_contact' => 'Fiche contact',
            'num_devis' => 'N??',
            'filter_user' => 'Utilisateurs',
            'add_client' => 'Ajouter un contact',
            'add_clients' => 'Ajouter/Modifier un contact',
            'create_client' => 'Cr??er contact',
            'products_bloc' => 'Produits',
            'add_invoice_tax' => 'Ajouter un taux de TVA',
            'add_new_row' => 'Ajouter une ligne',
            'add_notes' => 'Ajouter une note',
            'add_product' => 'Ajouter un produit',
            'create_product' => 'Cr??er produit',
            'attention_pdf' => "?? l'attention de",
            'CdtsReglement' => 'Cdts r??glement',
            'item_pdf' => 'R??f. article',
            'qte_pdf' => 'Qt??',
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
            'total_a_payer_pdf' => 'Net ?? payer',
            'solde_credit' => 'Solde de cr&eacute;dit',
            'signature_pdf' => 'Nom, qualit?? et signature ou cachet du client',
            'bon_accord_pdf' => 'Bon pour accord le ________________',
            'import_from_xsl' => 'Importer au format XSL',
            'exploite_champs' => 'Explore champs',
            'add_quote_tax' => 'Ajouter une taxe pour les devis',
            'address' => 'Adresse',
            'administrator' => 'Administrateur',
            'after_amount' => 'Apr??s le montant',
            'all' => 'Tous',
            'amount' => 'Montant ',
            'amount_due' => 'Montant d??',
            //'any_family' => 'n\'importe quelle famille',
            'any_family' => 'Tous Familles',
            'apply_after_item_tax' => 'Appliquer apr??s la taxe de l\'article',
            'apply_before_item_tax' => 'Appliquer avant la taxe de l\'article',
            'approve' => 'Approuver',
            'approve_this_quote' => 'Valider ce devis',
            'approved' => 'Valid??',
            'automatic_email_on_recur' => 'Envoyer les factures r??currentes automatiquement',
            'balance' => 'Solde',
            'base_invoice' => 'Facture de base',
            'bcc' => 'BCC',
            'before_amount' => 'Avant le montant',
            'bill_to' => 'Factur?? ?? ',
            'quote_Devis' => 'N/Ref : Devis',
            'num/ref' => 'N/Ref',
            'quote_expire_le' => 'Limite de validit??',
            'quote_Du' => 'du',
            'body' => 'Corps du message',
            'calendar_month' => 'Mois',
            'calendar_week' => 'Hebdomadaire',
            'cancel' => 'Annuler',
            'canceled' => 'Annul??',
            'cannot_connect_database_server' => 'Impossible de se connecter au serveur de base de donn??es',
            'cannot_select_specified_database' => 'Impossible de s??lectionner la base de donn??es renseign??e',
            'can_be_changed' => 'Peut ??tre modifi??',
            'cc' => 'CC',
            'change_password' => 'Modifier le mot de passe',
            'checking_for_updates' => 'V??rification des mises ?? jour...',
            'city' => 'Ville ',
            'cldr' => 'fr',
            'client' => 'Contact',
            'client_access' => 'Acc??s client',
            'client_form' => 'Formulaire contact',
            'client_type' => 'Type',
            'client_prenom' => 'Pr??nom du contact ',
            'client_date_naiss' => 'Date de naissance',
            'client_societe' => 'Societ??',
            'client_fix' => 'Fix',
            'prospect_filter' => 'Prospect',
            'client_filter' => 'Client',
            'client_fax' => 'Fax',
            'client_zip' => 'Code postal',
            'client_ville' => 'Ville',
            'client_pays' => 'Pays',
            'client_mobile' => 'Mobile',
            'client_attention' => "A l'attention de",
            'client_tel2' => 'Autre t??l??phone',
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
            'accepte_le' => 'Accept??',
            // 'mode_pmt' => 'Mode pmt',
            'mode_pmt' => 'MP',
            'clients' => 'Contacts',
            'client_site' => 'Site web',
            'client_email' => 'Adresse E-mail',
            'client_address' => 'Adresse',
            'client_name_tab' => 'Nom & pr??nom',
            'client_raison_tab' => 'Societ??',
            'client_adresse_tab' => 'Adresse',
            'client_email_tab' => 'Email',
            'client_telFix_tab' => 'Fix',
            'client_telmobile_tab' => 'Portable',
            'client_webSite_tab' => 'Site web',
            'new_client_devis' => 'Contact',
            'close' => 'Fermer',
            'closed' => 'Ferm??',
            'column' => 'Colonne',
            'company' => 'Entreprise',
            'confirm' => 'Confirmer',
            'confirm_deletion' => 'Confirmer la suppression',
            //'contact_information' => 'Coordonn??es de contact',
            'contact_information' => 'Coordonn??es',
            'continue' => 'Continuer',
            'copy_invoice' => 'Copier la facture',
            'copy_quote' => 'Copier le devis',
            'country' => 'Pays ',
            'create_credit_invoice' => 'Cr??er une note de cr??dit',
            'create_credit_invoice_alert' => 'Cr??er une note de cr??dit verrouillera cette facture en <em>lecture seule</em>, ce qui signifie que vous ne pourrez plus la modifier. La note de cr??dit reprendra l\'ensemble des d??tails de la facture mais avec les montant et soldes n??gatifs.',
            'create_invoice' => 'Cr??er une facture',
            'create_product' => 'Cr??er un produit',
            'create_fournisseur' => 'Cr??er un fournisseur',
            'create_quote' => 'Cr??er un devis',
            'edit_quote' => 'Modifier un devis',
            'create_recurring' => 'Cr??er une r??currence',
            'created' => 'Cr????',
            'credit_invoice' => 'Note de cr??dit',
            'credit_invoice_date' => 'Date de la note de cr??dit',
            'credit_invoice_details' => 'D??tails de la note de cr??dit',
            'credit_invoice_for_invoice' => 'Note de cr??dit pour cette facture',
            'cron_key' => 'Cl?? CRON ',
            'currency_symbol' => 'Symbole mon??taire ',
            'currency_symbol_placement' => 'Position du symbole mon??taire',
            'current_day' => 'Date courante',
            'current_month' => 'Mois courant',
            'current_version' => 'Version ',
            'current_year' => 'Ann??e courante',
            'custom_field_form' => '??diteur de champ personnalis??',
            'custom_fields' => 'Champs personnalis??s',
            'custom_title' => 'Titre personnalis??',
            'dashboard' => 'Tableau de bord',
            'database' => 'Base de donn??es ',
            'database_properly_configured' => 'La base de donn??es est correctement configur??e',
            'date' => 'Date ',
            'date_applied' => 'Date appliqu??e',
            'date_format' => 'Format de date ',
            'days' => 'Jours',
            'decimal_point' => 'S??parateur d??cimal ',
            'default_country' => 'Pays par d??faut',
            'default_email_template' => 'Mod??le d\'Email par d??faut',
            'default_invoice_group' => 'Groupe de factures par d??faut',
            'default_invoice_tax_rate' => 'Taxe par d??faut sur une facture',
            'default_invoice_tax_rate_placement' => 'Position par d??faut de la taxe sur une facture',
            'default_item_tax_rate' => 'Taux de TVA d\'article par d??faut',
            'default_item_timbre' => 'Timbre fiscal',
            'default_list_limit' => 'Nombre d\'??l??ments dans les listes',
            'default_pdf_template' => 'Mod??le PDF par d??faut',
            'default_public_template' => 'Mod??le public par d??faut',
            'default_quote_group' => 'Groupe Devis par d??faut',
            'default_terms' => 'C. G. V. par d??faut ',
            'delete' => 'Supprimer',
            'delete_client' => 'Supprimer le client',
            'delete_client_warning' => 'Si vous supprimez ce client, vous supprimerez toutes les factures, devis et paiements associ??es ?? ce client. ??tes-vous s??r de vouloir supprimer d??finitivement ce client ?',
            'delete_invoice' => 'Supprimer facture',
            'delete_invoice_warning' => 'Si vous supprimez cette facture, il vous sera impossible de la restaurer ult??rieurement. ??tes-vous s??r de vouloir supprimer d??finitivement cette facture ?',
            'delete_quote' => 'Supprimer le devis',
            'delete_quote_warning' => 'Si vous supprimez ce devis, il vous sera impossible de le restaurer ult??rieurement. ??tes-vous s??r de vouloir supprimer d??finitivement ce devis ?',
            'delete_record_warning' => '??tes-vous s??r de vouloir supprimer cet enregistrement ?',
            'description' => 'Libell?? ',
            'details' => 'D??tails',
            'disable_quickactions' => 'D??sactiver les Quickactions',
            'disable_sidebar' => 'D??sactiver la barre lat??rale',
            'documentation' => 'Documentation',
            'download_pdf' => 'T??l??charger le PDF',
            'draft' => 'Brouillon',
            'due_date' => '??ch??ance',
            'edit' => 'Editer',
            'email' => 'Email ',
            'email_address' => 'Adresse Email ',
            'email_invoice' => 'Envoyer la facture par Email',
            'email_not_configured' => 'Avant d\'envoyer des courriels, vous devez configurer vos param??tres e-mail dans la page des Param??tres Syst??mes.',
            'email_quote' => 'Envoyer devis par Email',
            'email_send_method' => 'Envoi des emails par ',
            'email_send_method_phpmail' => 'PHP Mail',
            'email_send_method_sendmail' => 'Sendmail',
            'email_send_method_smtp' => 'SMTP',
            'email_successfully_sent' => 'Email envoy?? avec succ??s',
            'email_template' => 'Mod??le de courriel',
            'email_template_form' => '??diteur de mod??le d\'Email',
            'email_template_overdue' => 'Mod??le courriel d\'un paiement en retard',
            'email_template_paid' => 'Mod??le courriel d\'une facture pay??e',
            'email_template_tags' => 'Mod??les de balises pour Email',
            'email_template_tags_instructions' => 'S??lectionnez d\'abord une zone de texte, puis cliquez sur un mod??le de balise ci-dessous pour l\'y ins??rer.',
            'email_templates' => 'Mod??les d\'Email',
            'end_date' => 'Date de fin',
            'enter_payment' => 'Saisir un paiement',
            'errors' => 'Erreurs',
            'every' => 'Fr??quence ',
            'example' => 'Exemple',
            'expired' => 'Expir??',
            'expires' => 'Expire le',
            'extra_information' => 'Informations compl??mentaires',
            'failure' => '??chec',
            'families' => 'Familles',
            'family' => 'Famille',
            'family_name' => 'Nom de famille',
            'fax' => 'Fax ',
            'fax_abbr' => 'Fax',
            'fax_number' => 'N?? de Fax ',
            'filter_clients' => 'Filtrer les contacts',
            'filter_invoices' => 'Filtrer les factures',
            'filter_payments' => 'Filtrer les paiements',
            'filter_quotes' => 'Filtrer les devis',
            'first' => 'Premier',
            'first_day_of_week' => 'Premier jour de la semaine',
            'footer' => 'Pied de page',
            'forgot_your_password' => 'Mot de passe oubli???',
            'from_date' => 'Date de d??but',
            'from_email' => 'Email exp??diteur',
            'from_name' => 'Nom exp??diteur',
            'general' => 'G??n??ral',
            'generate' => 'G??n??rer',
            'guest_account_denied' => 'Ce compte n\'est pas configur??, merci de contacter l\'administrateur du syst??me.',
            'guest_read_only' => 'Invit?? (en lecture seule)',
            'guest_url' => 'URL de consultation ',
            'hostname' => 'H??te ',
            'id' => 'ID ',
            'identifier_format' => 'Format de l\'identifiant',
            'identifier_format_template_tags' => 'Balises de template pour le format d\'identifiant',
            'identifier_format_template_tags_instructions' => 'S??lectionnez d\'abord le champ "format de l\'identifiant", cliquez ensuite sur une balise de template ci-dessous pour l\'ins??rer dans le champ.',
            'import' => 'Importer',
            'import_data' => 'Importer des donn??es',
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
            'invoice_deletion_forbidden' => 'La suppression de factures n\'est pas autoris??e. Contactez l\'administrateur ou consultez la documentation.',
            'invoice_group' => 'Groupe Facture',
            'invoice_group_form' => 'Modification d\'un mod??le de factures',
            'invoice_groups' => 'Groupes de factures',
            'invoice_items' => 'Articles factur??s',
            'invoice_logo' => 'Logo des factures ',
            'pdf_logo' => 'Logo des pdf ',
            'invoice_overview' => 'Aper??u des factures',
            'invoice_overview_period' => 'Synth??se des factures',
            'invoice_password' => 'Mot de passe PDF (facultatif)',
            'invoice_pre_password' => 'Facture standard PDF avec mot de passe (facultatif)',
            'invoice_tax' => 'TVA globale',
            'invoice_tax_rate' => 'Taux de TVA ',
            'taux' => 'Taux de Changement ',
            'invoice_template' => 'Mod??le de facture',
            'invoice_terms' => 'Conditions de facturation',
            'invoiced' => 'Factur??',
            'invoiceplane_news' => 'Les derni??res nouvelles de InvoicePlane',
            'invoices' => 'Factures',
            'invoices_due_after' => '??ch??ance de facturation (en jours)',
            'is_not_writable' => 'n\'est pas accessible en ??criture',
            'is_writable' => 'est accessible en ??criture',
            'item' => 'Code',
            'item_lookup_form' => 'Ajout ou modification d\'un article g??n??rique',
            'item_lookups' => 'Liste d\'articles g??n??riques',
            'item_name' => 'Nom de l\'article',
            'item_tax' => 'TVA',
            'item_tax_rate' => 'Taux de TVA de l\'article',
            'label' => 'Intitul?? ',
            'language' => 'Langue ',
            'last' => 'Dernier',
            'last_month' => 'Mois dernier',
            'last_quarter' => 'Dernier trimestre',
            'last_year' => 'L\'ann??e derni??re',
            'left_pad' => 'Nombre de z??ros non-significatifs',
            'login' => 'Connexion',
            'loginalert_credentials_incorrect' => 'Email ou mot de passe incorrect.',
            'loginalert_no_password' => 'Veuillez saisir un mot de passe.',
            'loginalert_user_inactive' => 'Cet utilisateur est marqu?? comme inactif. Merci de contacte l\'administrateur.',
            'loginalert_user_not_found' => 'Il n\'y a aucun compte enregistr?? avec cette adresse e-mail.',
            'logout' => 'D??connexion',
            'mark_invoices_sent_pdf' => 'Marquer les factures comme envoy??es quand le PDF est g??n??r??',
            'mark_quotes_sent_pdf' => 'Marquer les devis comme envoy??s quand le PDF est g??n??r??',
            'max_quantity' => 'Quantit?? maximale',
            'menu' => 'Menu',
            'merchant_account' => 'Compte marchand ',
            'merchant_currency_code' => 'Code de devise',
            'merchant_driver' => 'Protocole marchand ',
            'merchant_enable' => 'Activer les r??glements en ligne',
            'merchant_payment_cancel' => 'Votre paiement a ??t?? annul??.',
            'merchant_payment_fail' => 'D??sol??, mais un probl??me est survenu lors de votre paiement..',
            'merchant_payment_success' => 'Votre paiement a ??t?? effectu??.',
            'merchant_signature' => 'Signature ',
            'merchant_test_mode' => 'Mode test ',
            'min_quantity' => 'Quantit?? minimale',
            'mobile' => 'T??l??phone mobile',
            'mobile_number' => 'N?? de portable ',
            'monday' => 'Lundi',
            'monospaced_font_for_amounts' => 'Utilisez une police de taille fixe pour les montants',
            'month' => 'Mois',
            'month_prefix' => 'Pr??fixe du mois ',
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
            'no_updates_available' => 'Aucune mise ?? jour n???est actuellement disponible.',
            'none' => 'Aucun',
            'note' => 'Note ',
            'notes' => 'Note',
            'online_payment_method' => 'M??thode de paiement en ligne',
            'open' => 'Edit??',
            'open_invoices' => 'Facturations en cours',
            'open_quotes' => 'Ouvir le devis',
            'optional' => 'Optionnel',
            'options' => 'Options',
            'overdue' => 'Impay??',
            'overdue_invoices' => 'Factures impay??es',
            'paid' => 'Pay??',
            'password' => 'Mot&nbsp;de&nbsp;passe',
            'password_changed' => 'Mot de passe modifi?? avec succ??s',
            'password_reset' => 'R??initialiser le mot de passe',
            //'password_reset_email' => 'Vous avez demand?? un nouveau mot de passe pour votre Installation d\'InvoicePlane. Veuillez cliquer sur le lien ci-dessous pour r??initialiser votre mot de passe :',
            'password_reset_email' => 'Vous avez demand?? un nouveau mot de passe pour votre utilisation du Bison ERP. Veuillez cliquer sur le lien ci-dessous pour r??initialiser votre mot de passe :',
            'password_reset_info' => 'Vous recevrez un E-mail avec un lien pour r??initialiser votre mot de passe.',
            'pay_now' => 'Payer maintenant',
            'payment' => 'Paiement',
            'payment_cannot_exceed_balance' => 'Le montant du paiement ne peux pas exc??der le solde de la facture.',
            'payment_date' => 'Date de paiement',
            'payment_form' => '??dition d\'un paiement',
            'payment_history' => 'Historique de paiements',
            'payment_method' => 'Moyen de paiement ',
            'payment_method_form' => '??dition d\'un moyen de paiement',
            'payment_methods' => 'Moyens de paiements',
            'payments' => 'Paiements',
            'pdf' => 'PDF',
            'pdf_invoice_footer' => 'Pied de page PDF',
            'pdf_footer_hint' => 'Vous pouvez entrer ici des ??l??ments HTML qui s\'afficheront au bas de vos PDF.',
            'pdf_template' => 'Mod??le de PDF',
            'pdf_template_overdue' => 'Mod??le PDF d\'un paiement en retard',
            'pdf_template_paid' => 'Mod??le PDF d\'une facture pay??e',
            'period' => 'P??riode',
            'personal_information' => 'Informations personnelles',
            'phone' => 'T??l. ',
            'phone_abbr' => 'T??l??phone',
            'phone_number' => 'N?? de t??l??phone ',
            'php_timezone_fail' => 'Le param??trage du fuseau horaire ne semble pas avoir ??t?? fait, veuillez contr??ler ce point dans votre configuration de php. ?? d??faut <strong>%s</strong> sera utilis??.',
            'php_timezone_success' => 'Le fuseau horaire a bien ??t?? configur??.',
            'php_version_fail' => 'La version PHP %s est install??e mais InvoicePlane requiert la version PHP %s ou sup??rieure',
            'php_version_success' => 'PHP semble r??pondre aux besoins de l\'installation',
            'please_enable_js' => 'Merci de rendre possible l\'ex??cution de code javascript pour le bon fonctionnement d\'InvoicePlane',
            'prefix' => 'Prefixe ',
            'prev' => 'Pr??c',
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
            'product_sku2' => 'R??f.',
            'family_name2' => 'Famille',
            'quote_nature' => 'Nature',
            'quote_delai_paiement' => 'Modalit?? de paiement',
            'quote_date_accepte' => 'Accept?? le',
            'delai_paiement_label' => 'Label',
            'remise_tab' => 'Remise',
            'acompte_tab' => 'Acompte',
            'pourcentage_remise' => 'Remise (%) ',
            'accompte_remise' => 'Acompte(%) ',
            'montant' => 'Montant ',
            'total_a_payer' => 'Solde ?? payer',
            'default_devis_code' => 'Code devis par d??faut',
            'product_sku' => 'R??f??rence (SKU)',
            'products' => 'Produits',
            'Fournisseurs' => 'Fournisseurs',
            'raison_social_fournisseur' => 'Raison social',
            'adresse_fournisseur' => 'Adresse',
            'adresse2_fournisseur' => 'Adresse 2',
            'code_postal_fournisseur' => 'Code postal',
            'ville_fournisseur' => 'Ville',
            'pays_fournisseur' => 'Pays',
            'mail_fournisseur' => 'Email',
            'tel_fournisseur' => 'T??l??phone',
            'tel2_fournisseur' => 'T??l??phone 2',
            'fax_fournisseur' => 'Fax',
            'note_fournisseur' => 'Note',
            'site_web_fournisseur' => 'Site web',
            'purchase_price' => 'Prix ??d\'achat',
            'Q1' => 'Trimestre 1',
            'Q2' => 'Trimestre 2',
            'Q3' => 'Trimestre 3',
            'Q4' => 'Trimestre 4',
            'qty' => 'Qt??',
            'quantity' => 'Quantit??',
            'quarter' => 'Trimestrielle',
            'quick_actions' => 'Actions rapides',
            'quote' => 'Devis',
            'quote_approved' => 'Ce devis a ??t?? accept??',
            'quote_date' => 'Date du devis ',
            'quote_group' => 'Groupe de devis ',
            'quote_overview' => 'Aper??u des devis',
            'quote_overview_period' => 'Synth??se des devis',
            'quote_password' => 'Devis PDF avec mot de passe',
            'quote_pre_password' => 'Devis standard PDF avec mot de passe (facultatif)',
            'quote_rejected' => 'Ce devis n\'a pas ??t?? approuv??',
            'quote_status_email_body' => 'Le client %1$s a %2$s le devis %3$s.

        Lien vers le devis: %4$s',
            'quote_status_email_subject' => 'Client %1$s %2$s devis %3$s',
            'quote_tax' => 'Taxes des devis',
            'quote_template' => 'Mod??le du devis',
            'quote_to_invoice' => 'Transf??rer le devis en facture',
            'quote_invoice' => 'Devis- Facture',
            'quotes' => 'Devis',
            'quotes_expire_after' => 'Expiration (en jours) ',
            'quotes_requiring_approval' => 'Devis en attente de validation',
            'read_only' => 'Lecture seule',
            'recent_clients' => 'Derniers Clients',
            'recent_invoices' => 'Derni??res factures',
            'recent_payments' => 'Derniers R??glements',
            'recent_quotes' => 'Devis r??cents',
            'record_successfully_created' => 'Enregistrement correctement effectu??',
            'record_successfully_deleted' => 'Enregistrement correctement supprim??',
            'record_successfully_updated' => 'Enregistrement correctement mis ?? jour',
            'recurring' => 'Recurrente',
            'recurring_invoices' => 'Factures r??currentes ',
            'reject' => 'Rejeter',
            'reject_this_quote' => 'Rejeter ce devis',
            'rejected' => 'Rejet??',
            'remove' => 'Supprimer',
            'remove_logo' => 'Supprimer le logo',
            'report_options' => 'Options du rapport',
            'reports' => 'Rapports',
            'reset_password' => 'R??initialiser le mot de passe',
            'run_report' => 'G??n??rer le rapport',
            'search_product' => 'Rechercher un produit',
            'search_client' => 'Rechercher un contact',
            'sales' => 'Ventes',
            'sales_by_client' => 'Chiffre d\'affaires par Client',
            'sales_by_date' => 'Ventes par Date',
            'sales_with_tax' => 'Ventes tax??es',
            'save' => 'Enregistrer',
            'save_item_as_lookup' => 'Sauvegarder comme article g??n??rique',
            'select_family' => 'S??lectionnez la famille',
            'select_payment_method' => 'S??lectionnez le mode de paiement',
            'send' => 'Envoyer',
            'send_email' => 'Envoyer par Email',
            'date_rappel' => 'Planification',
            'delete_date_rappel' => 'Supprimer planification',
            'msg_confirmation_delete_rappel' => '??tes-vous s??r de vouloir supprimer d??finitivement la planification de ce devis?',
            'sent' => 'Envoy??',
            'set_new_password' => 'D??finir un nouveau mot de passe',
            'settings' => 'Param??tres',
            'settings_successfully_saved' => 'Param??tres correctement enregistr??s',
            'setup_choose_language' => 'Choisissez la langue',
            'setup_choose_language_message' => 'Choisissez la langue avant de poursuivre l\'installation.',
            'setup_complete' => 'Installation termin??e !',
            'setup_complete_message' => 'InvoicePlane est bien install??. Vous pouvez d??s ?? pr??sent vous connecter.',
            'setup_complete_secure_setup' => 'Afin de s??curiser votre site Internet veuillez modifier le fichier .htacces de votre domaine en y ins??rant le code suivant entre les balises <code></code> :',
            'setup_complete_support_note' => 'Si vous rencontrez un probl??me ou avez besoin d\'aide, consultez le <a href="https://wiki.invoiceplane.com">wiki officiel</a> ou le <a href="https://community.invoiceplane.com/">forum de la communaut??</a>.',
            'setup_create_user' => 'Cr??ation d\'un compte utilisateur',
            'setup_create_user_message' => 'Voici les informations n??cessaires pour vous connecter ?? InvoicePlane.',
            'setup_database_configured_message' => 'La base de donn??es a ??t?? correctement configur??e.',
            'setup_database_details' => 'D??tails de la base de donn??es',
            'setup_database_message' => 'Renseignez les informations suivantes afin d\'??tablir une connexion ?? votre base de donn??es.',
            'setup_db_database_info' => 'Le nom de votre base de donn??es pour InvoicePlane.',
            'setup_db_hostname_info' => 'L\'h??te de votre base de donn??es.',
            'setup_db_password_info' => 'Le mot de passe de votre base de donn??es.',
            'setup_db_username_info' => 'Le nom d\'utilisateur de votre base de donn??es.',
            'setup_install_tables' => 'Installation des tables',
            'setup_other_contact' => 'Contact',
            'setup_prerequisites' => 'Pr??-requis',
            'setup_prerequisites_message' => 'Bienvenue dans InvoicePlane ! Tous les points suivants doivent ??tre r??solus afin de pouvoir poursuivre le programme d\'installation.',
            'setup_tables_errors' => 'Les erreurs list??es ci-dessous doivent ??tre corrig??es avant de poursuivre l\'installation.',
            'setup_tables_success' => 'Les tables ont ??t?? correctement install??es.',
            'setup_upgrade_message' => 'Les erreurs list??es ci-dessous doivent ??tre corrig??es pour pouvoir terminer l\'installation.',
            'setup_upgrade_success' => 'La base de donn??es a ??t?? correctement mise ?? jour.',
            'setup_upgrade_tables' => 'Mise ?? jour des tables',
            'setup_user_address_info' => 'L\'adresse visible dans vos factures.',
            'setup_user_contact_info' => 'Informations de contact visibles dans vos factures.',
            'setup_user_email_info' => 'Votre adresse de courriel servira pour se connecter ?? InvoicePlane.',
            'setup_user_name_info' => 'Votre raison sociale ou vos pr??nom et nom.',
            'setup_user_password_info' => 'Veuillez utiliser un mot de passe suffisamment complexe. Une combinaison de lettres majuscules et de minuscules, ainsi que des chiffres et symboles est fortement recommand??e.',
            'setup_user_password_verify_info' => 'Confirmez votre mot de passe en le saisissant de nouveau.',
            'setup_v120_alert' => '<b>Attention!</b> <br/>Il est extr??mement recommand?? que vous lisiez <a href="https://go.invoiceplane.com/v120update" target="_blank">cet avis de mise ?? jour</a> concernant certains changements importants dans l\'application InvoicePlane.',
            'set_to_read_only' => 'Marquer la facture en lecture seule',
            'six_months' => 'Semestrielle',
            'smtp_password' => 'Mot de passe SMTP ',
            'smtp_port' => 'Port SMTP ',
            'smtp_requires_authentication' => 'N??cessite une authentification ',
            'smtp_security' => 'S??curit?? ',
            'smtp_server_address' => 'Adresse du serveur SMTP ',
            'smtp_ssl' => 'SSL ',
            'smtp_tls' => 'TLS',
            'smtp_username' => 'Utilisateur SMTP ',
            'sql_file' => 'Fichier SQL',
            'start_date' => 'Date d??but ',
            'state' => '??tat',
            'status_tab' => 'St',
            'status' => 'Statut',
            'stop' => 'Suspendre',
            'important' => 'Important',
            'street_address' => 'Adresse ',
            'street_address_2' => 'Compl??ment ',
            'subject' => 'Objet',
            'submenu' => 'Sous-menu',
            'submit' => 'Soumettre',
            'subtotal' => 'Sous-total HT',
            'success' => 'R??ussi',
            'sunday' => 'Dimanche',
            'system_settings' => 'Param??tres syst??mes',
            'societes_settings' => 'Soci??t??s',
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
            'tax_rate_decimal_places' => 'Nombre de d??cimales ',
            'tax_rate_form' => '??dition d\'un taux de TVA',
            'tax_rate_name' => 'Intitul??',
            'tax_rate_percent' => 'Pourcentage de TVA',
            'tax_rate_placement' => 'Positionnement',
            'tax_rates' => 'Taux de TVA',
            'taxes' => 'TVA ',
            'terms' => 'Conditions g??n??rales de vente',
            'this_month' => 'Ce mois',
            'this_quarter' => 'Ce trimestre',
            'this_year' => 'Cette ann??e',
            'thousands_separator' => 'S??parateur de milliers ',
            'title' => 'Titre',
            'to_date' => 'En date du ',
            'to_email' => 'Email du destinataire',
            'total' => 'Total TTC',
            'total_balance' => 'Solde total ',
            'total_billed' => 'Total factur?? ',
            'total_paid' => 'Total pay?? ',
            'try_again' => 'Essayez ?? nouveau',
            'type' => 'Type',
            'unknown' => 'Inconnu',
            'updatecheck' => 'Contr??le des mises ?? jour',
            'updatecheck_failed' => 'Le contr??le de mise ?? jour a ??chou?? ! V??rifier votre connexion r??seau.',
            'updates' => 'Mises ?? jour',
            'updates_available' => 'Des Mises ?? jour sont disponibles!',
            'user' => 'Utilisateur',
            'user_accounts' => 'Comptes utilisateurs',
            'company_accounts' => 'Param??tres soci??t??',
            'user_form' => '??dition d\'un utilisateur',
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
            'view_recurring_invoices' => 'Voir les factures r??currentes',
            'viewed' => 'Consult??',
            'warning' => 'Avertissement',
            'web' => 'Web ',
            'web_address' => 'Site Web ',
            'welcome' => 'Bienvenue',
            'year' => 'Ann??e',
            'year_prefix' => 'Prefixe de l\'ann??e ',
            'years' => 'Ann??es',
            'yes' => 'Oui',
            'zip_code' => 'Code postal ',
            'msg_arret' => 'Arr??t?? le pr&eacute;sent devis ?? la somme de ',
            'msg_arret_fact' => 'Arr??t?? la pr&eacute;sente facture ?? la somme de ',
            'societes' => 'Entreprise ',
            'raison_social_societes' => 'Raison social ',
            'adresse_societes' => 'Adresse Sfax',
            'tel_societes' => 'T??l. ',
            'adresse2_societes' => '2??me Adresse ',
            'tel2_societes' => 'T??l. ',
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
            'devise_label' => 'D??signation Devise',
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
            'droit_accees' => 'Droit d\'acc??s',
            'ajout-modif' => 'Ajouter- Modifier',
            'modif-facture' => 'Modifier Facture',
            'sup' => 'Supprimer',
            'index' => 'Consulter',
            'fourniss' => 'Fournisseur',
            'msg_acc' => 'Droits d\'acc??s insuffisants ',
            'paye_pdf' => 'Somme pay?? ',
            'rest_pdf' => 'Reste ?? payer  ',
            'craint' => 'Pas de soucis, cliquez   ',
            'here' => 'Ici  ',
            'resett' => 'pour r??initialiser votre mot de passe  ',
            'logginn' => 'Connectez-vous ?? votre compte  ',
            'enter' => 'Entrez Votre E-mail et votre mot de passe  ',
            'logginn' => 'Connectez-vous ?? votre compte  ',
            'logginn' => 'Connectez-vous ?? votre compte  ',
            'logginn' => 'Connectez-vous ?? votre compte  ',
            'error_nb_ligne' => "Ins&eacute;rer au moins une ligne.</p>\n",
        );
    }

    public function getuser($db)
    {

        $this->db->join($db . '.ip_groupes_users', 'ip_groupes_users.groupes_user_id = ip_users.groupes_user_id', 'left');
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
        return $array;
    } 
 
}