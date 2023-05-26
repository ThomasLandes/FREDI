

<?php include "ini.php";
$dbh = db_connect(); 
$submit = isset($_POST['submit']);

// insertion d'une ligne de frais dans une nouvelle note 

if ($submit){
    
    $date = isset($_POST['date']) ? $_POST['date'] : '2023-03-02';
    echo $date ;
  
    $kilometrage = isset($_POST['kilometrage']) ? $_POST['kilometrage'] : '';
    $libdeplacement = isset($_POST['deplacement']) ? $_POST['deplacement'] : '';
    $fraisPeage = isset($_POST['fraisPeage']) ? $_POST['fraisPeage'] : '';
    $fraisRepas = isset($_POST['fraisRepas']) ? $_POST['fraisRepas'] : '';
    $fraisHeberge = isset($_POST['fraisHeberge']) ? $_POST['fraisHeberge'] : '';
    $id_motif = isset($_POST['Motif']) ? $_POST['Motif'] : '';
  

    try {

    $sql= "SELECT idperiode, montant FROM periodef WHERE is_actif = 1";
    $result = $dbh -> prepare($sql);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL ligne 18 : " . $ex->getMessage());
}
    $prixKm = $row['montant'];
    $id_periode = $row['idperiode'];

    $mt_km =     $kilometrage* $prixKm;
    $mt_total =  $kilometrage + $fraisPeage + $fraisRepas +   $fraisHeberge;

    try {
    $sql= "INSERT INTO notefrais( montantTot, dateNote, idperiode, idutil) VALUES( :mt_total, :date_remis, :id_periode, :id_utilisateur)";
    $result = $dbh -> prepare($sql);
    $result->execute(array(":mt_total" => $mt_total, ":date_remis" => $date, ":id_periode" => $id_periode, ":id_utilisateur" => $_SESSION['id']));
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL ligne 30: " . $ex->getMessage());
}
try {
    $sql= " SELECT id_note FROM notefrais WHERE idutil = :id_user AND dateNote = :dat ";
    $result = $dbh -> prepare($sql);
    $result->execute(array(":id_user" => $_SESSION['id'], ":dat" => $date));
    $row = $result->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL Ligne 38: " . $ex->getMessage());
}
try {
    $sql = "INSERT INTO `lignefrais` ( `datedeplacement`, `libDeplacement`, `kilometrage`, `fraisPeage`, `fraisRepas`, `fraisHeberge`, `id_note`, `id_motif`) 
    VALUES ( :datedeplacement, :libdeplacement, :kilometrage, :fraisPeage , :fraisRepas, :fraisHeberge, :id_note, :id_motif);";
    
    $params = array(
        ":datedeplacement" => $date,
        ":libdeplacement" =>$libdeplacement,
        ":kilometrage" => $kilometrage,
        ":fraisPeage" => $fraisPeage,
        ":fraisRepas" => $fraisRepas,
        ":fraisHeberge" => $fraisHeberge,
        ":id_note" => $row['id_note'],
        ":id_motif" => $id_motif
    );
    
    $sth = $dbh->prepare($sql);
    $sth->execute($params);
    $nb = $sth->rowcount();
    
    header("Location: ListeNotefrais.php?id_note=" . urlencode($row['id_note']));
} catch (PDOException $e) {
    die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}
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

<h1>Ajouter une Ligne de frais</h1>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  <p>Date Deplacement<br /><input type="date" name="date" ></p>
  <p>Lib Deplacement<br /><input type="text" name="deplacement" ></p>
  <p>Kilometrage<br /><input type="text" name="kilometrage" ></p>
  <p>fraisPeage<br /><input type="text" name="fraisPeage" ></p>
  <p>fraisRepas<br /><input type="text" name="fraisRepas" ></p>
  <p>fraisHeberge<br /><input type="text" name="fraisHeberge" ></p>
  <p>Motif : <select name="Motif">
<option value="1" selected>Réunion</option>
<option value="2" >Compétition régionale</option>
<option value="3" > Compétition nationale</option>
<option value="4" >Compétition internationnale</option>
<option value="5" >Stage</option>
<option value="6" >Visite médicale</option>
<option value="7" >Oxygénation</option>
<option value="8" >Convocation</option>
<option value="9" >Formation</option>

</select>
</p>
  <br /><input type="hidden" name="id_note" value= "<?php echo  $id_note?>"></p>
  <p><input type="submit" name="submit" value="OK"></p>
</form>
<?php
echo '<p><a href="index.php">Retour </a>Acceuil</p>';

?>
</body>  
<html>

