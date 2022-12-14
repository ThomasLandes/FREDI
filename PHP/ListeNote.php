<?php
include "ini.php";
include "menu.php";

// Connexion à la base
$dbh=db_connect();

  $sql = ' SELECT id_note,montanttot,dateNote,validite,numordre from notefrais , utilisateur where utilisateur.idutil = notefrais.idutil and utilisateur.idutil = :idutil;';

  $params = array(
      ":idutil" =>  $_SESSION['id'],
  );

  

  try {
      $sth = $dbh->prepare($sql);
      $sth->execute($params);
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
  }




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste note </title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h1>Liste des notes</h1>


<?php

    echo '<table>';
    echo '<tr><th>Ordre</th><th>Montant</th><th>Date</th><th>Validite</th></tr>';
    
   
    foreach ($rows as $row)
    {
       
      echo '<tr>';
      echo '<td>'.$row['numordre'].'</td>';
      echo "<td>".$row['montanttot']."</td>";
      echo '<td>'.$row['dateNote'].'</td>';
      echo '<td>'.$row['validite'].'</td>';
      echo '<td>[<a href="ListeNoteFrais.php?id_note=' . $row['id_note'] . '">Voir liste note de frais</a>]';
      echo "</tr>";
    }
    echo "</table>";
    echo '<p><a href="index.php">Retour </a>Acceuil</p>';


?>

</html>
