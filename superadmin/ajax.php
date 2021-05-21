<?php

include('config/config.php');


if (isset($_POST['action'])) {
    $action = $_POST['action'];
	foreach ($_POST as $key => $value)
	{
           $_POST[$key] = cleanInput($value);
	}

     switch ($action) {


        case "add_client":
            addClient($_POST);
            break;

        case "edit_client":
            editClient($_POST);
            break;

        case "delete_client":
            deleteClient($_POST);
            break;

        case "regenerer_licence_key":
            echo generateLicenceKey();
            break;

        case "generatePassword":
            echo generatePassword();
            break;

        case "logout_user":
            logoutUser();
            break;
        
        case "update_profil":
            updateProfil($_POST);
            break;
        
        case "add_pack":
            addPack($_POST);
            break;
        
        case "edit_pack":
            editPack($_POST);
            break;
        
        case "delete_pack":
            deletePack($_POST);
            break;
        
        case "add_update":
            addUpdate($_POST);
            break;
        
        case "edit_update":
            editUpdate($_POST);
            break;
        case "add_modele_mail":
            addmodele_mail($_POST);
            break;          
        case "delete_modele":
            deletemodele($_POST);
            break;    
        case "edit_modele":
            editmodele($_POST);
            break;                
    }
}
?>

