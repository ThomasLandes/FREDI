<?php 
include "ini.php";
$page="deconnexion.php";
logToDisk($page,$_SESSION['pseudo'],$_SESSION['mdp']);
session_unset();
session_destroy(); 
header('Location: accueil.php');
?>