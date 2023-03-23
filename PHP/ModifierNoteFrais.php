<?php 
include "ini.php";
include "menu.php";
$dbh = db_connect();









// Lecture du formulaire
$idnote = isset($_GET['idnote']) ? $_GET['idnote'] : null;
$idligne = isset($_GET['idligne']) ? $_GET['idligne'] : null;
$submit = isset($_POST['submit']);


if ($submit) {
    
    $idnote = isset($_POST['idnote'])? $_POST['idnote'] : null;
    $idligne = isset($_POST['idligne'])? $_POST['idligne'] : null;
 $datedeplacement  = isset($_POST['date']) ? $_POST['date'] : null;
$kilometrage = isset($_POST['kilometrage']) ? $_POST['kilometrage'] : null;
$libdeplacement = isset($_POST['libdeplacement']) ? $_POST['libdeplacement'] : null;
$FraisPeage = isset($_POST['FraisPeage']) ? $_POST['FraisPeage'] : null;
$FraisRepas = isset($_POST['FraisRepas']) ? $_POST['FraisRepas'] : null;
$FraisHeberge = isset($_POST['FraisHeberge']) ? $_POST['FraisHeberge'] : null;



echo $idnote;
    $sql = "UPDATE lignefrais SET datedeplacement = :datedeplacement, libDeplacement = :libdeplacement  , kilometrage = :kilometrage , fraisPeage = :FraisPeage , fraisRepas = :FraisRepas , fraisHeberge = :FraisHeberge  where idligne = :idligne";

    $params = array(
        ":idligne" => $idligne,
        ":datedeplacement" => $datedeplacement,
        ":libdeplacement" =>$libdeplacement,
        ":kilometrage" => $kilometrage,
        ":FraisPeage" => $FraisPeage,
        ":FraisRepas" => $FraisRepas,
        ":FraisHeberge" => $FraisHeberge,
   
     


    );
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute($params);
    } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }
    header("Location: ListeNoteFrais.php?id_note=$idnote");
     
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

<h1>Modifier la note</h1>

<form action=<?php echo $_SERVER['PHP_SELF'];?> " method="post">
<p><input type="hidden" name="idnote" value="<?php echo $idnote; ?>"></p>
<p><input type="hidden" name="idligne" value="<?php echo $idligne; ?>"></p>
  <p>Date Deplacement<br /><input type="date" name="date" value = "<?php echo $date?>"  ></p>
  <p>Lib Deplacement<br /><input type="text" name="libdeplacement" value = "<?php echo $lib ?>"></p>
  <p>Kilometrage<br /><input type="text" name="kilometrage" value = "<?php echo $kilo ?>" ></p>
  <p>FraisPeage<br /><input type="text" name="FraisPeage" value = "<?php echo $FraisP  ?>" ></p>
  <p>FraisRepas<br /><input type="text" name="FraisRepas"  value = "<?php echo $FraisR  ?>" ></p>
  <p>FraisHeberge<br /><input type="text" name="FraisHeberge"  value = "<?php echo $FraisH ?>" ></p>

  <p><input type="submit" name="submit" value="OK"></p>
</form>
<?php
echo '<p><a href="ListeNoteFrais.php?id_note=' . $idnote . '">Retour </a>ListeNote</p>';
?>
</body>
</html>