<?php
include "ini.php";
$util = verrif_util($conect);
include "menu.php";

// Connexion à la base
$dbh=db_connect();
$submit = isset($_POST['submit']);
$idnote  = isset($_POST['id_note']) ? $_POST['id_note'] : '';




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
if($submit){
  $sql ='UPDATE notefrais SET validite = 1 WHERE id_note = :id_note';
 
 
  $params = array(
  
    ":id_note" => $idnote
);

header("Location: ListeNote.php");
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
    <link rel="stylesheet" href="../CSS/main.css">
</head>
<body>
  <br>
<h1>Liste des notes</h1>
<br>

<?php

    echo '<table>';
    if( $util == DEFAULT_USER){
    echo '<tr><th>Ordre</th><th>Montant</th><th>Date</th><th>Voir ligne Frais</th>';
    }
    if ($util == CONTROLER ) {
    echo"<tr><th>Ordre</th><th>Montant</th><th>Date</th><th>Valide</th>";
    }
echo"</tr>";
    foreach ($rows as $row)
    {
       
      echo '<tr>';
      echo '<td>'.$row['numOrdre'].'</td>';
      echo "<td>".$row['montantTot']."</td>";
      echo '<td>'.$row['dateNote'].'</td>';

      if ($row['is_actif'] == 1 && $util == DEFAULT_USER ) {
        echo '<td>[<a href="ListeNoteFrais.php?id_note=' . $row['id_note'] . '">Voir liste note de frais</a>]</td>';
      }

      if ($row['is_actif'] == 0 && $util == DEFAULT_USER ) {
        echo '<td>Periode Non active</td>';
      }


      // si periode est active et util = controleur
      if ($row['is_actif'] == 1 && $util == CONTROLER ) {
        ?><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <td>
        <?php
        echo $row['validite'];
        ?>
        <input type="checkbox" id="validite" name="id_note" value="<?php echo $row['id_note']; ?>">
    </td></tr>
    <p style="padding:2px;background-color:gray;float:left;margin-left:500px"><input type="submit" name="submit" value="Submit"></p>
    <br><br>
</form>
      <?php 
        }

        }
    echo "</table>";
    echo '<p>Retour à l\'<a href="index.php">Acceuil</a></p>';
    


?>

</html>
