<?php


if(isset($_GET['action']) && $_GET['action'] == "add"){

$title = "Nouveau client";
$main = "modules/clients/add.php";
	
}
else
if(isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) && isClient($_GET['id'])){
$client = getClientInfo($_GET['id']);
$title = "Modification client";
$main = "modules/clients/edit.php";
	
}
else{
$clients = getClientsList();
$title = "Liste des clients";
$main = "modules/clients/list.php";
}