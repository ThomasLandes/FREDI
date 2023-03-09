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

    $sql = "DELETE FROM lignefrais where idligne = :idligne ";

    $params = array(
        ":idligne" => $idligne,

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


<h1>Supprimer la Note</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette ligne de frais?');">
<p><input type="hidden" name="idnote" value="<?php echo $idnote; ?>"></p>
<p><input type="hidden" name="idligne" value="<?php echo $idligne; ?>"></p>
  <p>Date Deplacement<br /><input type="date" name="date" value = "<?php echo $date?>"  ></p>
  <p>Lib Deplacement<br /><input type="text" name="libdeplacement" value = "<?php echo $lib ?>"></p>
  <p>Kilometrage<br /><input type="text" name="kilometrage" value = "<?php echo $kilo ?>" ></p>
  <p>FraisPeage<br /><input type="text" name="FraisPeage" value = "<?php echo $FraisP  ?>" ></p>
  <p>FraisRepas<br /><input type="text" name="FraisRepas"  value = "<?php echo $FraisR  ?>" ></p>
  <p>FraisHeberge<br /><input type="text" name="FraisHeberge"  value = "<?php echo $FraisH ?>" ></p>
  <p>FraisKilometre<br /><input type="text" name="FraisKilometre"  value = "<?php echo $FraisK  ?>"></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>
<?php
echo '<p><a href="ListeNoteFrais.php?id_note=' . $idnote . '">Retour </a>ListeNote</p>';
?>
</body>
</html>