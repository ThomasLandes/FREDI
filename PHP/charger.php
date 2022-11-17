<?php
include 'ini.php';
// Connexion à la base
define('ROOT', __FILE__);
$file1 = ROOT . DIRECTORY_SEPARATOR . "clubs.csv";
$data = [];
// Lecture du fichier CSV généré depuis le .ods
$row = 1;
if (($handle = fopen($file1, "r")) !== false) {
  while (($data = fgetcsv($handle, 1000, ";")) !== false) {
    $num = count($data);
    $sql1 = "INSERT INTO club('idclub', 'nomclub', 'adresseclub', 'cpClub', 'villeClub', 'idligue') VALUES ('" . $valeur[0] . "','" . $valeur[1] . "','" . $valeur[2] . "','" . $valeur[3] . "','" . $valeur[4] . "','" . $valeur[5] . "');";
  }
  fclose($handle);
}

try {
  $sth = $dbh->prepare($sql1);
  $sth->execute();
} catch (PDOException $ex) {
  die("Erreur lors de la requête SQL : " . $ex->getMessage());
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
  $file = ROOT.DIRECTORY_SEPARATOR."clubs.csv";
  parseCSV($file);
  ?>
</body>

</html>