<?php
include "ini.php";
$util = verrif_util($conect);
include "menu.php";

// Connexion à la base
$dbh=db_connect();
$submit2 = isset($_POST['submit']);
$idnote  = isset($_POST['id_note']) ? $_POST['id_note'] : '';
$periode = isset($_GET['periode']) ? $_GET['periode']:'';
$actif = 0;
$lien = 0;









  if ($util == DEFAULT_USER) {
    $sql = 'SELECT COUNT(*) from notefrais where idutil = :idutil and idperiode = (SELECT idperiode from periodef where is_actif = 1)';
    $params = array(

      ":idutil" =>  $_SESSION['id'],
    );
  
    try {
      $sth = $dbh->prepare($sql);
      $sth->execute($params); 
      $periodesql = $sth->fetchAll(PDO::FETCH_ASSOC);
      
      if ($periodesql[0]['COUNT(*)'] == 0) {
        $lien = 1;
      }
    } catch (PDOException $e) {
      die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }
  }




if($util == CONTROLER){


    $sql = '  SELECT * from notefrais,periodef where notefrais.idperiode = periodef.idperiode and periodef.is_actif = 1';
$params = array();
$sql_periode = ' SELECT * from periodef';
try {
  $sth = $dbh->prepare($sql_periode);
  $sth->execute($params); 
  $periodefs = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}
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

if($submit2){
  $sql ='UPDATE notefrais SET validite = 1 WHERE id_note = :id_note';
 
 
  $params = array(
  
    ":id_note" => $idnote
);

header("Location: ListeNote.php");
}

?>
<?php
if($util == CONTROLER){
$sql_actif = "UPDATE periodef SET is_actif = 0 ;
                UPDATE periodef SET is_actif = 1 WHERE libelleperiode = ".$periode;  
try {
  $sth = $dbh->prepare($sql_actif);
  $sth->execute($params); 
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}

}


try {
  $sth = $dbh->prepare($sql);
  $sth->execute($params);
  $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
  $nb = count($rows);
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


<?php

    echo '<table>';
    if( $util == DEFAULT_USER){
    echo '<tr><th>Ordre</th><th>Montant</th><th>Date</th><th>Voir ligne frais</th>';
    }
    if ($util == CONTROLER ) {
      echo "<div style='padding: 15px;''>";
      echo "<h1>Liste des periodes</h1>";
      echo "<table>";
echo "<tr><th>libellé periode</th><th>Montant</th></tr>";
foreach($periodefs as $periodef){
  echo "<tr>";
  echo "<td>".$periodef['libelleperiode']."</td>";
  echo "<td>".$periodef['montant']."</td></tr>";
}
 echo "</table>";

?>
<br><br>
<libel for="periode">Choix periode active</label><br><br>
<form>
<select style="float: left;" name="periode" id="periode" onchange="this.form.submit()">
<?php

  foreach (range('2019', '2023') as $char) {
    if ($char == $periode) {
      $selected = "selected";
    } else {
      $selected = "";
    }
    echo '<option value="' . $char . '" ' . $selected . ' >' . $char . '</option>' . PHP_EOL;
  }
    }
?>
</select>
</form><br><br>

<h1>Liste des notes</h1><br>
<?php
  if ($util == CONTROLER ) {
echo "<table>";
    echo"<tr><th>Ordre</th><th>Montant</th><th>Date</th><th>Valide</th>";
    }
echo"</tr>";
    foreach ($rows as $row)
    {
       $id = "id_note".$row['id_note'];
      echo '<tr>';
      echo '<td>'.$row['numOrdre'].'</td>';
      echo "<td>".$row['montantTot']."</td>";
      echo '<td>'.$row['dateNote'].'</td>';

      if ($row['is_actif'] == 1 && $util == DEFAULT_USER ) {
        echo '<td>[<a href="ListeNotefrais.php?id_note=' . $row['id_note'] . '">Voir liste note de frais</a>]</td>';
      }

      if ($row['is_actif'] == 0 && $util == DEFAULT_USER ) {
        echo '<td>Periode Non active</td>';
      }


      // si periode est active et util = controleur
      if ($row['is_actif'] == 1 && $util == CONTROLER ) {
        ?>
    <td>
    <!--<form action="<?php //echo $_SERVER['PHP_SELF']; ?>" method="post">-->
        <?php
        if($row['validite'] == 1 ){
          $valide = "checked";
          $disabled = "disabled";
        }else{
          $disabled = "";
          $valide = "";
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="text" id="id_note" name="id_note" value="<?php echo $row['id_note']; ?>" hidden>
        <input type="submit"  <?php /*echo $valide." ";*/ echo $disabled ?>>
        </form>
    </td></tr>
  
      <?php 
        }
//$actif = $row['is_actif'];
        }
    echo "</table>";
    if( $actif == 1 && $util == CONTROLER ){
    //echo "<p style='padding:2px;background-color:gray;float:left;margin-left:500px'><input type='submit' name='submit2' value='Valider notes'></form></p>";
  //  echo "<br><br>";
    }
if($lien == 1 ){
    echo '<p>Ajouter une <a href="addfrais.php">note de frais</a></p>';
}
  echo '<p>Retour à l\'<a href="index.php">Acceuil</a></p>';
  
  if( $util == CONTROLER ){
    echo'<p>Obtenir le pdf <a href=" cumul_des_frais_pdf.php">du cumul des frais</a></p>';
  }
  if( $util == DEFAULT_USER){
  echo'<p>Obtenir le pdf <a href="bordereau_pdf.php">bordereaux</a></p>';
  }


?>
</div>
</html>
