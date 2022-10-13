<?php
// Connexion
include 'fonctions/fonction.php';
// Connexion à la base
$dbh=db_connect();

// Lecture du fichier CSV
//
// Séparateur : ";"
// Encodage : utf-8

define('ROOT',__FILE__);

$csvFile = file('files/club.csv');
$data = [];
$i=1; //Compteur de lignes
// Lecture du fichier CSV généré depuis le .ods
foreach ($csvFile as $line) {
    // On ne prend que les data utiles (pas d'entête ou de commentaire)
    if ($i>=4 && $i<=22) {
        $data[] = str_getcsv($line, ';', '"');
    }
    $i++;
}

// Création des ordres SQL


    // Génère l'ordre SQL et le concatène avec les autres
    $sql ="INSERT INTO avion ('idclub', 'nomclub', 'adresseclub', 'cpCLub', 'villeClub', 'idligue') VALUES ('".$valeur[0]."','".$valeur[1]."','".$valeur[2]."','".$valeur[3]."','".$valeur[4]."','".$valeur[5].");";

// Exécution des ordres SQL
try {
    $sth = $dbh->prepare($sql);
    $sth->execute();
    } catch (PDOException $ex) {
        die("Erreur lors de la requête SQL : ".$ex->getMessage());
    } 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ph140 - B737</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <h1>ph140 - B737</h1>
    <p>Base chargée</p>
    <p><?php echo $sql; ?>
    </p>
</body>
