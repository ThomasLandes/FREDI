<?php
include "ini.php";
<<<<<<< HEAD

$util = verrif_util($conect) ;
=======
$util = verrif_util($conect);
>>>>>>> f5fb2d406dba1ef4fefc2f4571c0a0d3048bb8f7
include "menu.php";
// Connexion à la base
$dbh=db_connect();




if($util == CONTROLER){


    $sql = '  SELECT * from notefrais,periodef where notefrais.idperiode = periodef.idperiode and periodef.is_actif = 1';
$params = array();
} 

 if($util == DEFAULT_USER){
      
  $sql = ' SELECT * from notefrais , utilisateur,periodef where utilisateur.idutil = notefrais.idutil AND periodef.idperiode = notefrais.idperiode and utilisateur.idutil = :idutil;';

  $params = array(
      ":idutil" =>  $_SESSION['id'],
  );

 }
  if($util == ADMIN){
 
    redirect('error/error.php');
  
} 


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
    echo '<tr><th>Ordre</th><th>Montant</th><th>Date</th><th>Validite</th><th>Voir ligne Frais</th></tr>';
    
   
    foreach ($rows as $row)
    {
       
      echo '<tr>';
      echo '<td>'.$row['numOrdre'].'</td>';
      echo "<td>".$row['montantTot']."</td>";
      echo '<td>'.$row['dateNote'].'</td>';
      echo '<td>'.$row['validite'].'</td>';

      if ($row['is_actif'] == 1 && $util == DEFAULT_USER ) {
        echo '<td>[<a href="ListeNoteFrais.php?id_note=' . $row['id_note'] . '">Voir liste note de frais</a>]';
      }

      if ($row['is_actif'] == 0 && $util == DEFAULT_USER ) {
        echo '<td>Periode Non active</td>';
      }

      if ($util == CONTROLER ) {
        echo '<td>Acces Interdit</td>';
      }
        }
      echo "</tr>";
    echo "</table>";
    echo '<p><a href="index.php">Retour </a>Acceuil</p>';
    


?>

</html>
