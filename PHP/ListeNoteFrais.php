
<?php

// 2 :admin 1 :
include "ini.php";
$util = verrif_util($conect) ;

$id_note = isset($_GET['id_note']) ? $_GET['id_note'] : null;


// Connexion à la base
$dbh=db_connect();

  $sql = ' SELECT idligne,datedeplacement,libDeplacement,kilometrage,fraisPeage,fraisRepas,fraisHeberge,montantTot from lignefrais where id_note = :id_note ;';

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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php

    echo '<table>';
    echo '<tr><th>DateDeplacement</th><th>libDeplacement</th><th>Kilometrage</th><th>FraisPeage</th><th>FraisRepas</th><th>FraisHeberge</th><th>MontantTot</th></tr>';
    
   
    foreach ($rows as $row)
    {
       
      echo '<tr>';
      echo '<td>'.$row['datedeplacement'].'</td>';
      echo "<td>".$row['libDeplacement']."</td>";
      echo '<td>'.$row['kilometrage'].'</td>';
      echo '<td>'.$row['fraisPeage'].'</td>';
      echo '<td>'.$row['fraisRepas'].'</td>';
      echo '<td>'.$row['fraisHeberge'].'</td>';
      echo '<td>'.$row['montantTot'].'</td>';
      echo '<td><a href="ModifierNoteFrais.php?idligne='.$row['idligne'].'">Modifier </a></td>';
      echo "</tr>";
    }
    echo "</table>";
    echo '<p><a href="AjouterNoteFrais.php?id_note=' . $id_note. '">Ajouter </a>une liste de notes</p>';
    echo '<p><a href="index.php">Retour </a>Acceuil</p>';


/* Trigger pour que utilisateur rentre le bon montant total 


     DELIMITER |
CREATE OR REPLACE TRIGGER before_insert_lignefrais BEFORE INSERT
ON lignefrais FOR EACH ROW
BEGIN

DECLARE v_frais int ;

 SET v_frais = NEW.fraisHeberge + NEW.fraisPeage + NEW.fraisRepas ;

 if(new.montanttot != v_frais ) THEN 

SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Montant total incorrect' ;

END IF;

END |
DELIMITER ;
  
*/

?>
</body>
</html>