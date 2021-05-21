<?php


if(isset($_GET['action']) && $_GET['action'] == "add"){
    $packs = getListmodele();
    $title = "Nouveau pack";
    $main = "modules/packs/add.php";
	
}
else
if(isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) && isPack($_GET['id'])){
$pack = getPackInfo($_GET['id']);
$packs = getselectmodele($_GET['id']);
$listpacks = getListmodele();
$title = "Modification pack";
$main = "modules/packs/edit.php";
	
}
else{
$packs = getPacksList();
$title = "Liste des packs";
$main = "modules/packs/list.php";
}
if(isset($_GET['action']) && $_GET['action'] == "addmodele"){
   
    $title = "Ajouter modéle pack";
    $titre = "Titre pack";
    $main = "modules/packs/addmodele.php";
        
}
if(isset($_GET['action']) && $_GET['action'] == "listmodele"){
    $packs = getListmodele();
    $title = "Liste modéle pack";
    $titre = "Titre pack";
    $main = "modules/packs/listmodele.php";
        
}
if(isset($_GET['action']) && $_GET['action'] == "editmodele" && isset($_GET['id']) ){
    $pack = getmodeleInfo($_GET['id']);
    $title = "Modification modéle mail";
    $titre = "Modification titre pack";
    $main = "modules/packs/editmodele.php";
        
    }