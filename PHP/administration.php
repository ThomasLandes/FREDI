<?php
include 'ini.php';
$root = "D:xampp\htdocs\projet\AP FREDI\FREDI";
$file2 = $root . DIRECTORY_SEPARATOR . "CSV\clubs.csv";
$file1 = $root . DIRECTORY_SEPARATOR . "CSV\ligues.csv";
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
 <p>Met à jour les données des table Club et Ligue à partir des fichier CSV</p><a href="charger.php">Charger</a>
  <?php
  parseCSV($file1);
  parseCSV($file2);
  ?>
</body>

</html>