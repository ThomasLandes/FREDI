<?php
include 'ini.php';
$dbh = db_connect();
// Connexion à la base
//define('ROOT', __FILE__);
$root = "..";
$file2 = $root . DIRECTORY_SEPARATOR . "CSV\clubs.csv";
$file1 = $root . DIRECTORY_SEPARATOR . "CSV\ligues.csv";
$data2 = [];
$data1 = [];
//Supression des données des tables pour éviter une erreur de violation de contrainte
$sqldefault = 'DELETE FROM club; DELETE FROM ligues;';
try {
  $sth = $dbh->prepare($sqldefault);
  $sth->execute();
} catch (PDOException $ex) {
  die("Erreur lors de la requête SQL 1: " . $ex->getMessage());
}
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
      die("Erreur lors de la requête SQL 2: " . $ex->getMessage());
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
      echo "salur";
      die("Erreur lors de la requête SQL 3: " . $ex->getMessage());
    }
  }
  fclose($handle2);
}


header('Location: administration.php');
?>
