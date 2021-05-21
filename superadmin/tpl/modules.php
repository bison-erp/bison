<?php
$modules = array(
	"home" => "modules/home/config.php",
	"clients" => "modules/clients/config.php",
	"profil" => "modules/profil/config.php",
	"packs" => "modules/packs/config.php",
	"updates" => "modules/updates/config.php",
);
if(isset($_GET['module']) && isset($modules[$_GET['module']]))
	include($modules[$_GET['module']]);
else
include($modules['clients']);

?>