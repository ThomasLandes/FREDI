<?php
include "ini.php"; //ajout de toute les fonctions + session start
//print_r($_SESSION);
$page="index.php";
logToDisk($page);
$util = verrif_util($conect);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>FREDI</title>
</head>

<body>
 <?php  include 'menu.php'; ?>
</body>

</html>