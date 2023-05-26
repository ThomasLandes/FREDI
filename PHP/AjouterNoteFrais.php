

<?php
include "ini.php";
$dbh = db_connect();



// Lecture du formulaire
$datedeplacement  = isset($_POST['date']) ? $_POST['date'] : '';
$kilometrage = isset($_POST['kilometrage']) ? $_POST['kilometrage'] : '';
$libdeplacement = isset($_POST['deplacement']) ? $_POST['deplacement'] : '';
$fraisPeage = isset($_POST['fraisPeage']) ? $_POST['fraisPeage'] : '';
$fraisRepas = isset($_POST['fraisRepas']) ? $_POST['fraisRepas'] : '';
$fraisHeberge = isset($_POST['fraisHeberge']) ? $_POST['fraisHeberge'] : '';
$MontantTotal = isset($_POST['MontantTotal']) ? $_POST['MontantTotal'] : '';
$idnote = isset($_POST['id_note']) ? $_POST['id_note'] : '';
$id_motif = isset($_POST['Motif']) ? $_POST['Motif'] : '';
$id_note = isset($_GET['id_note']) ? $_GET['id_note'] : null;


$submit = isset($_POST['submit']);

// Ajout dans la base
if ($submit) {
    $sql = "INSERT INTO `lignefrais` ( `datedeplacement`, `libDeplacement`, `kilometrage`, `fraisPeage`, `fraisRepas`, `fraisHeberge`, `id_note`, `id_motif`) 
    VALUES ( :datedeplacement, :libdeplacement, :kilometrage, :fraisPeage , :fraisRepas, :fraisHeberge, :id_note, :id_motif);";
    
    $params = array(
   
        ":datedeplacement" => $datedeplacement,
        ":libdeplacement" =>$libdeplacement,
        ":kilometrage" => $kilometrage,
        ":fraisPeage" => $fraisPeage,
        ":fraisRepas" => $fraisRepas,
        ":fraisHeberge" => $fraisHeberge,
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

    header("Location: ListeNotefrais.php?id_note=$idnote");
  
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
echo '<p><a href="ListeNotefrais.php?id_note=' . $id_note . '">Retour </a>ListeNote</p>';
?>
</body>  
<html>



