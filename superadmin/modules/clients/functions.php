<?php

function getClientsList()
{

    $query = "SELECT * FROM ab_abonnes ORDER BY abonne_id ASC";
    return dbExecuteArray($query);
}

function getClientInfo($id)
{

    $query = "SELECT * FROM ab_abonnes WHERE abonne_id = '$id'";
    return dbExecute($query);
}

function isClient($id)
{

    $query = "SELECT * FROM ab_abonnes WHERE abonne_id = '$id'";
    if (dbExecuteCountArray($query) != 0) {
        return true;
    } else {
        return false;
    }

}

function addClient($post)
{   
    $nom = $post['nom'];
    $prenom = $post['prenom'];
    $website = $post['website'];
    $email = $post['email'];
    $telephone = $post['telephone'];
    $mobile = $post['mobile'];
    $fax = $post['fax'];
    $ville = $post['ville'];
    $code_postal = $post['code_postal'];
    $pays = $post['pays'];
    $adresse = $post['adresse'];
    $societe = $post['societe'];
    $matricule_fiscale = $post['matricule_fiscale'];
    $registre_commerce = $post['registre_commerce'];
    $status = $post['status'];
    $pack_id = $post['pack_id'];
    $password = $post['password'];
    $created = date("Y-m-d H:i:s");

    $licence_key = $post['licence_key'];
    $database = "oussema_" . strtolower($licence_key);
    $query = "INSERT INTO `ab_abonnes`(`nom`, `prenom`, `societe`, `email`, `adresse`, `ville`, `code_postal`, `pays`, `telephone`, `mobile`, `fax`, `site_web`, `matricule_fiscale`, `registre_commerce`, `statut`, `created`, `database`, `licence_key`, `pack_id`)
	VALUES('$nom','$prenom','$societe','$email','$adresse','$ville','$code_postal','$pays','$telephone','$mobile','$fax','$website','$matricule_fiscale','$registre_commerce','$status','$created','$database','$licence_key','$pack_id')";
//echo $query;
    dbSimpleExecute($query);
    if (!existDB($database)) {
        insertDbFirstTime($database);
    }

    $user_psalt = salt();
    $user_password = generate_password($password, $user_psalt);

// AJOUTER LE COMPTE UTILISATEUR
    $fullname = $nom . " " . $prenom;
    $client_code = strtoupper(substr($nom, 0, 1) . substr($prenom, 0, 1));
    $query2 = "
INSERT INTO " . $database . ".`ip_users` (`user_id`, `groupes_user_id`, `user_type`, `user_active`, `user_date_created`, `user_date_modified`, `user_name`, `user_code`, `user_company`, `user_address_1`, `user_address_2`, `user_city`, `user_state`, `user_zip`, `user_country`, `user_phone`, `user_fax`, `user_mobile`, `user_email`, `user_password`, `user_web`, `user_vat_id`, `user_tax_code`, `user_psalt`, `user_passwordreset_token`) VALUES
(1, 1, 1, 1, '" . $created . "', '" . $created . "', '" . $fullname . "', '" . $client_code . "', '" . $societe . "', '" . $adresse . "', '', '" . $ville . "', '" . $pays . "', '" . $code_postal . "', 'TN', '" . $telephone . "', '" . $fax . "', '" . $mobile . "', '" . $email . "', '" . $user_password . "', '" . $website . "', '', '', '" . $user_psalt . "', '')
";
    dbSimpleExecute($query2);
// FIN AJOUTER LE COMPTE UTILISATEUR
    //
    // AJOUTER SOCIETE
    $query3 = "INSERT INTO " . $database . ".`ip_societes`(`raison_social_societes`, `code_tva_societes`, `tax_code`, `site_web_societes`, `mail_societes`, `fax_societes`, `note_societes`)
              VALUES ('" . $societe . "','" . $matricule_fiscale . "','" . $registre_commerce . "','" . $website . "','" . $email . "','" . $fax . "','')";
    dbSimpleExecute($query3);
    $id_societe = mysql_insert_id();
    $query4 = "INSERT INTO " . $database . ".`ip_societe_adresse`(`id_societe`, `adresse`, `code_postal`, `ville`, `pays`, `telephone`)
          VALUES ('" . $id_societe . "','" . $adresse . "','" . $code_postal . "','" . $ville . "','" . $pays . "','" . $telephone . "')";
    dbSimpleExecute($query4);
// FIN AJOUTER SOCIETE

    $footer_pdf_defaut = '<center>Adresse : ' . $adresse . '<br> T&eacute;l: ' . $telephone . ' / ' . $mobile . '<br>\nT.V.A.: ' . $matricule_fiscale . ' - Fax: ' . $fax . ' - Email : ' . $email . ' - Site: ' . $website . '</center>';
    $query5 = "UPDATE " . $database . ".`ip_settings` SET `setting_value`= '" . $footer_pdf_defaut . "' WHERE `setting_key`='pdf_invoice_footer'";
    dbSimpleExecute($query5);

    mkdir("../uploads/" . strtolower($licence_key), 0777);
    mkdir("../uploads/" . strtolower($licence_key) . "/temp", 0777);
    copy("files/your-logo-here.png", "../uploads/" . strtolower($licence_key) . "/your-logo-here.png");
    return true;
}

function editClient($post)
{

    $id_client = $post['id_client'];
    $nom = $post['nom'];
    $prenom = $post['prenom'];
    $website = $post['website'];
    $email = $post['email'];
    $telephone = $post['telephone'];
    $mobile = $post['mobile'];
    $fax = $post['fax'];
    $ville = $post['ville'];
    $code_postal = $post['code_postal'];
    $pays = $post['pays'];
    $adresse = $post['adresse'];
    $societe = $post['societe'];
    $matricule_fiscale = $post['matricule_fiscale'];
    $registre_commerce = $post['registre_commerce'];
    $status = $post['status'];
    $created = date("Y-m-d H:i:s");
    $database = "db_" . date("YmdHis");
    $pack_id = $post['pack_id'];
    $licence_key = $post['licence_key'];

    $query = "UPDATE `ab_abonnes`SET
            `nom` = '$nom',
            `prenom` = '$prenom',
            `societe` = '$societe',
            `email` = '$email',
            `adresse` = '$adresse',
            `ville` = '$ville',
            `code_postal` = '$code_postal',
            `pays` = '$pays',
            `telephone` = '$telephone',
            `mobile` = '$mobile',
            `fax` = '$fax',
            `site_web` = '$website',
            `matricule_fiscale` = '$matricule_fiscale',
            `registre_commerce` = '$registre_commerce',
            `statut` = '$status',
            `pack_id` = '$pack_id',
            `licence_key` = '$licence_key'
             WHERE abonne_id = '$id_client'";
//echo $query;
    dbSimpleExecute($query);
    return true;
}

function deleteClient($post)
{

    $id_client = $post['id_client'];
    $client = getClientInfo($id_client);

    // $archives_folder = 'archives/';

    // $folder = $archives_folder . strtolower($client['licence_key']);

    // if (!is_dir($folder))
    // mkdir($folder, 0777);

    // if(existDB($client['database'])){

    // if (exportDb($client['database'], $folder . "/" . date("YmdHis") . ".sql")) {
    // deleteDb($client['database']);

    // recurse_copy("../uploads/" . strtolower($client['licence_key']), $folder . "/" . date("YmdHis"));

    // recursiveDelete("../uploads/" . strtolower($client['licence_key']));

    // $query = "DELETE FROM `ab_abonnes` WHERE abonne_id = '$id_client'";
    // dbSimpleExecute($query);
    // }
    // }
    // else{
    // recursiveDelete("../uploads/" . strtolower($client['licence_key']));

    // $query = "DELETE FROM `ab_abonnes` WHERE abonne_id = '$id_client'";
    // dbSimpleExecute($query);
    // }
    deleteDb($client['database']);
    recursiveDelete("../uploads/" . strtolower($client['licence_key']));
    $query = "DELETE FROM `ab_abonnes` WHERE abonne_id = '$id_client'";
    dbSimpleExecute($query);

}