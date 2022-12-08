

<?php
include "ini.php";
$dbh = db_connect();



// Lecture du formulaire
$date = isset($_POST['date']) ? $_POST['date'] : '';
$kilometrage = isset($_POST['Kilometrage']) ? $_POST['Kilometrage'] : '';
$libdeplacement = isset($_POST['deplacement']) ? $_POST['deplacement'] : '';
$fraispeage = isset($_POST['Fraispeage']) ? $_POST['Fraispeage'] : '';
$fraisrepas = isset($_POST['FraisRepas']) ? $_POST['FraisRepas'] : '';
$fraisheberge = isset($_POST['FraisHeberge']) ? $_POST['FraisHeberge'] : '';
$MontantTotal = isset($_POST['FraisHeberge']) ? $_POST['FraisHeberge'] : '';

$submit = isset($_POST['submit']);

// Ajout dans la base
if ($submit) {
    $sql = "INSERT INTO `lignefrais` (`idligne`, `datedeplacement`, `libDeplacement`, `kilometrage`, `fraisPeage`, `fraisRepas`, `fraisHeberge`, `montantTot`, `id_note`, `id_motif`) VALUES ('2', '2022-12-15', 'voiture', '60', '30', '30', '30', '90', '1', '1');";
    $params = array(
        ":question" => $question,
        ":idutilisateur" => $id,
    );
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute($params);
        $nb = $sth->rowcount();
    } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }
    header("Location: historique.php");
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
<form action="ListeNoteFrais.php" method="post">
  <p>Date Deplacement<br /><input type="date" name="date" value=""></p>
  <p>Lib Deplacement<br /><input type="text" name="deplacement" value=""></p>
  <p>Kilometrage<br /><input type="text" name="Kilometrage" value=""></p>
  <p>FraisPeage<br /><input type="text" name="FraisPeage" value=""></p>
  <p>FraisRepas<br /><input type="text" name="FraisRepas" value=""></p>
  <p>FraisHeberge<br /><input type="text" name="FraisHeberge" value=""></p>
  <p>MontantTotal<br /><input type="text" name="MontantTotal" value=""></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>
</body>
</html>