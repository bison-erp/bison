<?php

function getPacksList()
{

    $query = "SELECT * FROM ab_packs";
    return dbExecuteArray($query);
}

function getPackInfo($id)
{
    $query = "SELECT * FROM ab_packs WHERE pack_id = '$id'";
    return dbExecute($query);
}

function isPack($id)
{
    $query = "SELECT * FROM ab_packs WHERE pack_id = '$id'";
    if (dbExecuteCountArray($query) != 0) {
        return true;
    } else {
        return false;
    }

}

function addPack($post)
{
    $pack_name = $post["pack_name"];
    $nb_collaborateurs = $post["nb_collaborateurs"];
    $nb_factures_mois = $post["nb_factures_mois"];
    $nb_devis_mois = $post["nb_devis_mois"];
    $multi_devises = $post["multi_devises"];
    $export_lot_pdf = $post["export_lot_pdf"];
    $multi_societes = $post["multi_societes"];
    $export_excel = $post["export_excel"];
    $relance = $post["relance"];
    $export_contact = $post["export_contact"];
    $signature = $post["signature"];
    $gestionstock = $post["gestionstock"];
    $add_pack = $post["packs_id"];
    $montant_collaborateur = $post["montant_collaborateur"];
    $montant_factures_mois = $post["montant_factures_mois"];
    $montant_devis_mois = $post["montant_devis_mois"];
    $montant_multi_devises = $post["montant_multi_devises"];
    $montant_export_lot_pdf = $post["montant_export_lot_pdf"];
    $montant_export_excel = $post["montant_export_excel"];
    $montant_relance = $post["montant_relance"];
    $montant_export_contact = $post["montant_export_contact"];
    $montant_gestionstock = $post["montant_gestionstock"];
    $montant_contacts = $post["montant_contacts"];
    $query = "INSERT INTO `ab_packs`(`pack_name`, `nb_collaborateurs`, `nb_factures_mois`, `nb_devis_mois`, `multi_devises`, `export_lot_pdf`, `multi_societes`, `export_excel`,`relance`,`export_contact`,`signature`,`gestionstock`,`model_email`,
    `montant_collaborateur`,`montant_factures_mois`,`montant_devis_mois`,`montant_multi_devises`,`montant_export_lot_pdf`,
    `montant_export_excel`,`montant_relance`,`montant_export_contact`,`montant_gestionstock`,`montant_contacts`) VALUES ('$pack_name','$nb_collaborateurs','$nb_factures_mois','$nb_devis_mois','$multi_devises','$export_lot_pdf','$multi_societes','$export_excel','$relance','$export_contact','$signature','$gestionstock','$add_pack'
    ,'$montant_collaborateur','$montant_factures_mois','$montant_devis_mois','$montant_multi_devises','$montant_export_lot_pdf','$montant_export_excel',
    '$montant_relance','$montant_export_contact','$montant_gestionstock','$montant_contacts')";
    dbSimpleExecute($query);
}

function editPack($post)
{
    $pack_id = $post["pack_id"];
    $pack_name = $post["pack_name"];
    $nb_collaborateurs = $post["nb_collaborateurs"];
    $nb_factures_mois = $post["nb_factures_mois"];
    $nb_devis_mois = $post["nb_devis_mois"];
    $multi_devises = $post["multi_devises"];
    $export_lot_pdf = $post["export_lot_pdf"];
    $multi_societes = $post["multi_societes"];
    $export_excel = $post["export_excel"];
    $relance = $post["relance"];
    $export_contact = $post["export_contact"];
    $signature = $post["signature"];
    $gestionstock = $post["gestionstock"];
    $montant_collaborateur = $post["montant_collaborateur"];
    $montant_factures_mois = $post["montant_factures_mois"];
    $montant_devis_mois = $post["montant_devis_mois"];
    $montant_multi_devises = $post["montant_multi_devises"];
    $montant_export_lot_pdf = $post["montant_export_lot_pdf"];
    $montant_export_excel = $post["montant_export_excel"];
    $montant_relance = $post["montant_relance"];
    $montant_export_contact = $post["montant_export_contact"];
    $montant_gestionstock = $post["montant_gestionstock"];
    $montant_contacts = $post["montant_contacts"];
    $query = "UPDATE `ab_packs` SET `pack_name`='$pack_name',`nb_collaborateurs`='$nb_collaborateurs',`nb_factures_mois`='$nb_factures_mois',`nb_devis_mois`='$nb_devis_mois',`multi_devises`='$multi_devises',`export_lot_pdf`='$export_lot_pdf',`multi_societes`='$multi_societes',`export_excel`='$export_excel',`relance`=' $relance',`export_contact`=' $export_contact',`signature`=' $signature',
    `gestionstock`='$gestionstock',`montant_collaborateur`='$montant_collaborateur',
    `montant_factures_mois`='$montant_factures_mois',`montant_devis_mois`='$montant_devis_mois',
    `montant_multi_devises`='$montant_multi_devises',`montant_export_lot_pdf`='$montant_export_lot_pdf',
    `montant_export_excel`='$montant_export_excel',`montant_relance`='$montant_relance',
    `montant_export_contact`='$montant_export_contact',`montant_gestionstock`='$montant_gestionstock',`montant_contacts`='$montant_contacts' WHERE `pack_id` = $pack_id";
    echo $query;
    dbSimpleExecute($query);
}

function deletePack($post)
{
    $id_pack = $post['pack_id'];
    $query = "DELETE FROM `ab_packs` WHERE pack_id = '$id_pack'";
    dbSimpleExecute($query);
}

function addmodele_mail($post)
{

    $title_name = $post["title_name"];
    $email_template_body = $post["email_template_body"];
    $query = "INSERT INTO `ab_email`(`model_body`, `model_title`) VALUES ('$email_template_body','$title_name')";
    dbSimpleExecute($query);
}

function getListmodele()
{
    $query = "SELECT * FROM  ab_email";
    return dbExecuteArray($query);
}

function deletemodele($post)
{ 
 
    $id_pack = $post['id_model'];
    $query = "DELETE FROM `ab_email` WHERE id_model = '$id_pack'";
    dbSimpleExecute($query);
}

function editmodele($post)
{
    $title_name = $post["title_name"];
    $id_pack = $post['id_model'];
    $body = $post["email_template_body"];

    $query = "UPDATE `ab_email` SET `model_body`='$body',`model_title`='$title_name' WHERE `id_model` = $id_pack";
    dbSimpleExecute($query);
}

function getModele($id)
{
    $query = "SELECT * FROM ab_email WHERE id_model = '$id'";
    return dbExecute($query);
}

function getmodeleInfo($id)
{
    $query = "SELECT * FROM ab_email WHERE id_model = '$id'";
    return dbExecute($query);
}

function getselectmodele($id)
{
    $query = "SELECT count(id_model) as css,model_title,id_model,model_email FROM ab_email,ab_packs WHERE  model_email=id_model and ab_packs.pack_id = '$id'";
    return dbExecute($query);
}