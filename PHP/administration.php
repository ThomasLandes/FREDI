<?php
include 'ini.php';
$util = verrif_util($conect);
if($util != ADMIN){
  redirect('index.php');
}
$root = "..";
$file2 = $root . DIRECTORY_SEPARATOR . "CSV\\";
$filename2 = "clubs";
$file1 = $root . DIRECTORY_SEPARATOR . "CSV\\";
$filename1 = "ligues";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>administration</title>
  <link rel="stylesheet" href="../css/main.css">
</head>

<body>
  <h1>Administration des données</h1>
  <h2>Chargement des fichiers</h2>
 <p>Met à jour les données des table Club et Ligue à partir des fichier CSV</p><a href="charger.php">Charger</a>
  <?php
  parseCSV($file1,$filename1,".csv");
  parseCSV($file2,$filename2,".csv");
  ?>
</body>

</html>