<?php 
session_start();
include "fonctions/fonction.php"; //ajout de toute les fonctions
$conect = isset($_SESSION['mail']);
define('DEFAULT_USER',1);
define('ADMIN',2);
define('CONTROLER',3);
$util = DEFAULT_USER;
?>