
<?php

// 2 :admin 1 :
include "ini.php";
include "menu.php";
$util = verrif_util($conect) ;

$id_note = isset($_GET['id_note']) ? $_GET['id_note'] : null;


// Connexion à la base
$dbh=db_connect();

  $sql = ' SELECT * from lignefrais where id_note = :id_note ;';

  $params = array(
    ":id_note" =>  $id_note,
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
<html lang="en">
<head>
  <link rel="stylesheet" href="../CSS/main.css"> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php

    echo '<table>';
    echo '<tr><th>DateDeplacement</th><th>libDeplacement</th><th>Kilometrage</th><th>FraisPeage</th><th>FraisRepas</th><th>FraisHeberge</th><th>FraisKilometre</th><th>MontantTot</th></tr>';
    
   
    foreach ($rows as $row)
    {
       
      echo '<tr>';
      echo '<td>'.$row['datedeplacement'].'</td>';
      echo "<td>".$row['libDeplacement']."</td>";
      echo '<td>'.$row['kilometrage'].'</td>';
      echo '<td>'.$row['fraisPeage'].'</td>';
      echo '<td>'.$row['fraisRepas'].'</td>';
      echo '<td>'.$row['fraisHeberge'].'</td>';
      echo '<td>'.$row['FraisKilometre'].'</td>';
      echo '<td>'.$row['montantTot'].'</td>';
      echo '<td><a href="ModifierNoteFrais.php?idligne='.$row['idligne'].'&idnote=' . $id_note . '">Modifier </a></td>';
      echo '<td><a href="SupprimerNoteFrais.php?idligne='.$row['idligne'].'&idnote=' . $id_note . '">Supprimer </a></td>';
    }
    echo "</table>";
    echo '<p><a href="AjouterNoteFrais.php?id_note=' . $id_note. '">Ajouter </a>une liste de notes</p>';
    echo '<p><a href="index.php">Retour </a>Acceuil</p>';


?>
</body>
</html>