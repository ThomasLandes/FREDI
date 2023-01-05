<?php include "ini.php" ;
$dbh = db_connect();


$id_note = isset($_GET['id_note']) ? $_GET['id_note'] : 3;
$idligne = isset($_GET['idligne']) ? $_GET['idligne'] : null;





// Lecture du formulaire
$datedeplacement  = isset($_POST['date']) ? $_POST['date'] : '';
$kilometrage = isset($_POST['kilometrage']) ? $_POST['kilometrage'] : '';
$libdeplacement = isset($_POST['deplacement']) ? $_POST['deplacement'] : '';
$FraisPeage = isset($_POST['FraisPeage']) ? $_POST['FraisPeage'] : '';
$FraisRepas = isset($_POST['FraisRepas']) ? $_POST['FraisRepas'] : '';
$FraisHeberge = isset($_POST['FraisHeberge']) ? $_POST['FraisHeberge'] : '';
$FraisKilometre = isset($_POST['FraisKilometre']) ? $_POST['FraisKilometre'] : '';
$MontantTotal = isset($_POST['MontantTotal']) ? $_POST['MontantTotal'] : '';
$idnote = isset($_POST['id_note']) ? $_POST['id_note'] : '';
$id_motif = isset($_POST['Motif']) ? $_POST['Motif'] : '';
$id_note = isset($_GET['id_note']) ? $_GET['id_note'] : null;

$submit = isset($_POST['submit']);


if ($submit) {
    $sql = "UPDATE lignefrais SET datedeplacement = :datedeplacement, libdeplacement = :libdeplacement  , kilometrage = :kilometrage , fraisPeage = :FraisPeage , fraisRepas = :FraisRepas , fraisHeberge = :FraisHeberge , FraisKilometre = :FraisKilometre , montantTot = MontantTotal where idligne = :idligne;";

    $params = array(
   
        ":datedeplacement" => $datedeplacement,
        ":libdeplacement" =>$libdeplacement,
        ":kilometrage" => $kilometrage,
        ":FraisPeage" => $FraisPeage,
        ":FraisRepas" => $FraisRepas,
        ":FraisHeberge" => $FraisHeberge,
        ":FraisKilometre" => $FraisKilometre,
        ":MontantTotal" => $MontantTotal,
        ":id_note" => $idnote,
        ":id_motif" => $id_motif


    );
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute($params);
        $nb = $sth->rowcount();
    } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }
    header("Location: ListeNoteFrais.php?id_note=".$idnote."");
} else {
    // Formulaire non encore validé : on affiche l'enregistrement
    $sql = ' SELECT datedeplacement,libDeplacement,kilometrage,fraisPeage,fraisRepas,fraisHeberge,FraisKilometre,montantTot from lignefrais where idligne = :idligne ;';

  $params = array(
    ":idligne" =>  $idligne,
    );
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute($params);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }
    
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



<form action=<?php echo $_SERVER['PHP_SELF'];?> " method="post">
  <p>Date Deplacement<br /><input type="date" name="date" value = "<?php echo $datedeplacement ?>"  ></p>
  <p>Lib Deplacement<br /><input type="text" name="deplacement" value = "<?php echo $libdeplacement ?>"></p>
  <p>Kilometrage<br /><input type="text" name="kilometrage" value = "<?php echo $kilometrage ?>" ></p>
  <p>FraisPeage<br /><input type="text" name="FraisPeage" value = "<?php echo $FraisPeage  ?>" ></p>
  <p>FraisRepas<br /><input type="text" name="FraisRepas"  value = "<?php echo $FraisRepas  ?>" ></p>
  <p>FraisHeberge<br /><input type="text" name="FraisHeberge"  value = "<?php echo $FraisHeberge  ?>" ></p>
  <p>FraisKilometre<br /><input type="text" name="FraisKilometre"  value = "<?php echo $FraisKilometre  ?>"></p>
  <p>MontantTotal<br /><input type="text" name="MontantTotal" value = "<?php echo $MontantTotal ?>" ></p>

  <p><input type="submit" name="submit" value="OK"></p>
</form>



    
</body>
</html>