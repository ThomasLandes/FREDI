<?php 
include "ini.php";
$page="deconnexion.php";
logToDisk($page);
session_unset();
session_destroy(); 
header('Location: connexion.php');
?>