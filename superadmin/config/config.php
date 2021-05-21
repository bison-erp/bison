<?php
session_start();
//parametres base de donnees
$host = "localhost";
$user = "root";
$pass = "";
$db = "oussema_erpbison"; 
/*$host = "localhost";
$user = "admin_erp_bison";
$pass = "7ebLj7@08Gb10l%j";
$db = "admin_erp_bison";*/
/*$host = "localhost";
$user = "admin_erp_bison";
$pass = "FCw]XC#V2i2PH28D";
$db = "erp_bison";*/
$config_database['host'] = $host;
$config_database['username'] = $user;
$config_database['password'] = $pass;
$config_database['database'] = $db;

//connexion base de donnees
$dbConnect = @mysql_connect($host, $user, $pass) or die("erreur de connexion au serveur");

mysql_select_db($db) or die("erreur d'acces à la base");

//appel de fichier de configuration  de base de donne
include 'config/db.php';
$session_name = "app_erp";

include 'config/users.php';
include "config/functions.php";
include "config/tools.php";
include "modules/clients/functions.php";
include "modules/packs/functions.php";
include "modules/updates/functions.php";