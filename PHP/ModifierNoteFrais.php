<?php include "ini.php" ;
$dbh = db_connect();









// Lecture du formulaire
$datedeplacement  = isset($_POST['date']) ? $_POST['date'] : '';
$kilometrage = isset($_POST['kilometrage']) ? $_POST['kilometrage'] : '';
$libdeplacement = isset($_POST['libdeplacement']) ? $_POST['libdeplacement'] : '';
$FraisPeage = isset($_POST['FraisPeage']) ? $_POST['FraisPeage'] : '';
$FraisRepas = isset($_POST['FraisRepas']) ? $_POST['FraisRepas'] : '';
$FraisHeberge = isset($_POST['FraisHeberge']) ? $_POST['FraisHeberge'] : '';
$FraisKilometre = isset($_POST['FraisKilometre']) ? $_POST['FraisKilometre'] : '';
$idligne = isset($_GET['idligne']) ? $_GET['idligne'] : 2 ;


$submit = isset($_POST['submit']);


if ($submit) {
    $sql = "UPDATE lignefrais SET datedeplacement = :datedeplacement, libDeplacement = :libdeplacement  , kilometrage = :kilometrage , fraisPeage = :FraisPeage , fraisRepas = :FraisRepas , fraisHeberge = :FraisHeberge , FraisKilometre = :FraisKilometre  where idligne = :idligne;";

    $params = array(
   
        ":datedeplacement" => $datedeplacement,
        ":libdeplacement" =>$libdeplacement,
        ":kilometrage" => $kilometrage,
        ":FraisPeage" => $FraisPeage,
        ":FraisRepas" => $FraisRepas,
        ":FraisHeberge" => $FraisHeberge,
        ":FraisKilometre" => $FraisKilometre,
        ":idligne" => $idligne


    );
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute($params);
        $nb = $sth->rowcount();
    } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }
    header("Location: ListeNoteFrais.php?id_note=2");
} else {
   
    try {
        // Récupération des données de la ligne de frais
        $sql = "SELECT * FROM lignefrais WHERE idligne = :idligne";
        $params = array(":idligne" => $idligne);
        $sth = $dbh->prepare($sql);
        $sth->execute($params);
        $row = $sth->fetch(PDO::FETCH_ASSOC);

        // Remplissage des champs du formulaire avec les données de la ligne de frais
        $date = $row['datedeplacement'];
        $lib = $row['libDeplacement'];
        $kilo = $row['kilometrage'];
        $FraisP = $row['fraisPeage'];
        $FraisR= $row['fraisRepas'];
        $FraisH = $row['fraisHeberge'];
        $FraisK= $row['FraisKilometre'];
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
  <p>Date Deplacement<br /><input type="date" name="date" value = "<?php echo $date?>"  ></p>
  <p>Lib Deplacement<br /><input type="text" name="libdeplacement" value = "<?php echo $lib ?>"></p>
  <p>Kilometrage<br /><input type="text" name="kilometrage" value = "<?php echo $kilo ?>" ></p>
  <p>FraisPeage<br /><input type="text" name="FraisPeage" value = "<?php echo $FraisP  ?>" ></p>
  <p>FraisRepas<br /><input type="text" name="FraisRepas"  value = "<?php echo $FraisR  ?>" ></p>
  <p>FraisHeberge<br /><input type="text" name="FraisHeberge"  value = "<?php echo $FraisH ?>" ></p>
  <p>FraisKilometre<br /><input type="text" name="FraisKilometre"  value = "<?php echo $FraisK  ?>"></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>


    
</body>
</html>