

<?php
include "ini.php";
$dbh = db_connect();



// Lecture du formulaire
$datedeplacement  = isset($_POST['date']) ? $_POST['date'] : '';
$kilometrage = isset($_POST['kilometrage']) ? $_POST['kilometrage'] : '';
$libdeplacement = isset($_POST['deplacement']) ? $_POST['deplacement'] : '';
$FraisPeage = isset($_POST['FraisPeage']) ? $_POST['FraisPeage'] : '';
$FraisRepas = isset($_POST['FraisRepas']) ? $_POST['FraisRepas'] : '';
$FraisHeberge = isset($_POST['FraisHeberge']) ? $_POST['FraisHeberge'] : '';
$MontantTotal = isset($_POST['MontantTotal']) ? $_POST['MontantTotal'] : '';
$idnote = isset($_POST['id_note']) ? $_POST['id_note'] : '';
$id_motif = isset($_POST['Motif']) ? $_POST['Motif'] : '';
$id_note = isset($_GET['id_note']) ? $_GET['id_note'] : null;


$submit = isset($_POST['submit']);

// Ajout dans la base
if ($submit) {
    $sql = "INSERT INTO `lignefrais` ( `datedeplacement`, `libDeplacement`, `kilometrage`, `fraisPeage`, `fraisRepas`, `fraisHeberge`, `id_note`, `id_motif`) 
    VALUES ( :datedeplacement, :libdeplacement, :kilometrage, :FraisPeage , :FraisRepas, :FraisHeberge, :id_note, :id_motif);";
    
    $params = array(
   
        ":datedeplacement" => $datedeplacement,
        ":libdeplacement" =>$libdeplacement,
        ":kilometrage" => $kilometrage,
        ":FraisPeage" => $FraisPeage,
        ":FraisRepas" => $FraisRepas,
        ":FraisHeberge" => $FraisHeberge,
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

    header("Location: ListeNoteFrais.php?id_note=$idnote");
  
} 


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>Ajouter une note</h1>

<form action=<?php echo $_SERVER['PHP_SELF'];?> " method="post">
  <p>Date Deplacement<br /><input type="date" name="date" ></p>
  <p>Lib Deplacement<br /><input type="text" name="deplacement" ></p>
  <p>Kilometrage<br /><input type="text" name="kilometrage" ></p>
  <p>FraisPeage<br /><input type="text" name="FraisPeage" ></p>
  <p>FraisRepas<br /><input type="text" name="FraisRepas" ></p>
  <p>FraisHeberge<br /><input type="text" name="FraisHeberge" ></p>
  <p>Motif : <select name="Motif">
<option value="1" selected>Travail</option>
<option value="2" >Voiture</option>
</select>
</p>
  <br /><input type="hidden" name="id_note" value= "<?php echo  $id_note?>"></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>
<?php
echo '<p><a href="index.php">Retour </a>Acceuil</p>';
echo '<p><a href="ListeNoteFrais.php?id_note=' . $id_note . '">Retour </a>ListeNote</p>';
?>
</body>  
<html>

<?php

// Trigger pour calculer automatiquement le Montant Total 
/** 
 DELIMITER |
CREATE TRIGGER `calcul_montant_total` BEFORE INSERT ON `lignefrais`
 FOR EACH ROW 
 BEGIN
  SET NEW.MontantTot = NEW.FraisPeage + NEW.FraisRepas + NEW.FraisHeberge + NEW.FraisKilometre;
END |
DELIMITER ; 
*/
?>

