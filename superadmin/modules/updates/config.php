<?php


if(isset($_GET['action']) && $_GET['action'] == "add"){

$title = "Ajouter mise à jour";
$main = "modules/updates/add.php";
	
}
else
if(isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) && isUpdate($_GET['id'])){
$update = getUpdateInfo($_GET['id']);

$title = "Modification mise à jour";
$main = "modules/updates/edit.php";


}
else{
$updates = getUpdatesList();
$title = "Mise à jour";
$main = "modules/updates/content.php";
}