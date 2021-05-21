<?php
 
 $link = mysql_connect('37.59.25.185', 'bison_erp', 'EkD7c4tIL');
if (!$link) {
    die('Connexion impossible : ' . mysql_error());
}
echo 'Connecté correctement';
mysql_close($link);
 
 
 ?>