<?php
include 'ini.php';
$dbh = db_connect();
// Connexion à la base
//define('ROOT', __FILE__);
$root = "..";
$file2 = $root . DIRECTORY_SEPARATOR . "CSV\clubs.csv";
$file1 = $root . DIRECTORY_SEPARATOR . "CSV\ligues.csv";
$file3 = $root . DIRECTORY_SEPARATOR . "CSV\motifs.csv";
$data3 = [];
$data2 = [];
$data1 = [];
// Lecture du fichier CSV ligue
if (($handle = fopen($file1, "r")) !== false) {
  while (($data1 = fgetcsv($handle, 1000, ";")) !== false) {
    //requête sql pour remplir la table ligue de la base
    $sql1 = 'INSERT INTO ligues(idligue, nomligue) 
    VALUES ('.$data1[0].',"'.$data1[1].'");';
    try {
      $sth = $dbh->prepare($sql1);
      $sth->execute();
    } catch (PDOException $ex) {
      die("Erreur lors de la requête SQL 1: " . $ex->getMessage());
    }
  }
  fclose($handle);
}
// Lecture du fichier CSV club
if (($handle2 = fopen($file2, "r")) !== false) {
  while (($data2 = fgetcsv($handle2, 1000, ";")) !== false) {
    //requête sql pour remplir la table club de la base
    $sql2 = 'INSERT INTO club(idclub, nomclub, adresseclub, cpClub, villeClub, idligue) 
    VALUES ('.$data2[0].',"'.$data2[1].'","'.$data2[2].'",'.$data2[3].',"'.$data2[4].'",'.$data2[5].');';
    try {
      $sth = $dbh->prepare($sql2);
      $sth->execute();
    } catch (PDOException $ex) {
      die("Erreur lors de la requête SQL 2: " . $ex->getMessage());
    }
  }
  fclose($handle2);
}

// Lecture du fichier CSV motif
if (($handle3 = fopen($file3, "r")) !== false) {
  while (($data3 = fgetcsv($handle3, 1000, ";")) !== false) {
    //requête sql pour remplir la table club de la base
    $sql3 = 'INSERT INTO motif(id_motif, libmotif) 
    VALUES ('.$data3[0].',"'.$data3[1].'");';
    try {
      $sth = $dbh->prepare($sql3);
      $sth->execute();
    } catch (PDOException $ex) {
      die("Erreur lors de la requête SQL 3: " . $ex->getMessage());
    }
  }
  fclose($handle3);
}

$_SESSION['message']="les donnée CSV ont été chargé";

header('Location: administration.php');
?>
