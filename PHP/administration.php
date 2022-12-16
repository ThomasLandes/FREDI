<?php
include 'ini.php';
$disable = " ";
$util = verrif_util($conect);
if($util != ADMIN){
  redirect('index.php');
}
$root = "..";
$file2 = $root . DIRECTORY_SEPARATOR . "CSV\\";
$filename2 = "clubs";
$file1 = $root . DIRECTORY_SEPARATOR . "CSV\\";
$filename1 = "ligues";
$file3 = $root . DIRECTORY_SEPARATOR . "CSV\\";
$filename3 = "motifs";

if(isset($_GET['message'])){
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
  <link rel="stylesheet" href="../CSS/styles.css">
</head>

<body>
  <h1>Administration des données</h1>
  <h2>Chargement des fichiers</h2>
  <?php 
echo "<p>Met à jour les données des table Club, Ligue et Motif à partir des fichier CSV</p><input type=button onclick=window.location.href='charger.php'; value='Charger' $disable >";

$mess = isset($_GET['message'])?$_GET['message'] : ' ';
echo $mess;
?>
  <h3>Donée des Fichier CSV</h3>
  <?php
  parseCSV($file1,$filename1,".csv");
  parseCSV($file2,$filename2,".csv");
  parseCSV($file3,$filename3,".csv");
  ?>
</body>
</html>