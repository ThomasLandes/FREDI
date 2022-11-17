<?php
include "ini.php";

// Connexion à la base
$dbh=db_connect();

  $sql = 'select datenote , montanttot from notefrais where idutil = :idutil;';

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
    echo '<tr><th>Montant</th><th>Date</th><th>Validite</th></tr>';
    
   
    foreach ($rows as $row)
    {
       
      echo '<tr>';
      echo "<td>".$row['montantTot']."</td>";
      echo '<td>'.$row['dateNote'].'</td>';
      echo "</tr>";
    }
    echo "</table>";

print_r( $_SESSION);
?>

</html>
