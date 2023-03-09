<?php
include 'ini.php';
$disable = " ";
$util = verrif_util($conect);
if($util != ADMIN){
  redirect('index.php');
}
include 'menu.php';
$root = "..";
$file = $root . DIRECTORY_SEPARATOR . "CSV\\";

$filename2 = "clubs";
$filename1 = "ligues";
$filename3 = "motifs";

if(isset($_SESSION['message'])){
  $disable = "disabled";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>administration</title>
  <link rel="stylesheet" href="../CSS/main.css">
</head>

<body>
  <h1>Administration des données</h1>
  <h2>Chargement des fichiers</h2>
  <?php 
echo "<p>Met à jour les données des table Club, Ligue et Motif à partir des fichier CSV</p><input type=button onclick=window.location.href='charger.php'; value='Charger' $disable >";

$mess = isset($_SESSION['message'])?$_SESSION['message'] : ' ';
echo $mess;
?>
  <h3>Donée des Fichier CSV</h3>
  <?php
  parseCSV($file,$filename1,".csv");
  echo "<br><br>";
  parseCSV($file,$filename2,".csv");
  echo "<br><br>";
  parseCSV($file,$filename3,".csv");
  ?>
</body>
</html>