<?php
include 'ini.php';
// Connexion à la base
$conn = mysqli_connect("localhost","root","","fredi");
$conn->set_charset("utf8_general_ci");
$dbh = db_connect();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>administration</title>
    <link rel="stylesheet" href="../CSS/main.css">
</head>

<body>
    <h1>Administration des données</h1>
    <h2>Chargement des fichiers</h2>

   <!-- <form enctype="multipart/form-data" action="import_csv.php" method="post">
        <div class="input-row">
            <label>Choisir un fichier CSV</label>
            <input type="file" name="file" id="file" accept=".csv">
            <br />
            <br />
            <button type="submit" id="submit" name="import" class="btn-submit">Import</button>
            <br />
        </div>
    </form> -->
    <?php
    $conn = mysqli_connect("localhost","root","","fredi");
    $conn->set_charset("utf8_general_ci");
  
    if (isset($_POST["import"])) {
      
      $fileName = $_FILES["file"]["tmp_name"];
      
      if ($_FILES["file"]["size"] > 0) {
       
        $file = fopen($fileName,"r");
  
        while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
          $sql = "INSERT into motif (id_motif,libmotif)
               values ('" . $column[0] . "','" . $column[1] . "')";
          $result = mysqli_query($conn, $sql);
          
          if (!empty($result)) {
            $type = "success";
            $message = "Les Données sont importées dans la base de données";
          } else {
            $type = "error";
            $message = "Problème lors de l'importation de données CSV";
          }
        } 
      }
    }
    ?>

    <?php
    $sql = "SELECT * FROM motif";
    $result = mysqli_query($conn, $sql);
    $nb_row = mysqli_num_rows($result);
    if ( $nb_row > 0) {
    ?>
        <table>
            <thead>
                <tr>
                    <th>motif ID</th>
                    <th>Libelle</th>
                </tr>
            </thead>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tbody>
                    <tr>
                        <td> <?php echo $row['id_motif']; ?> </td>
                        <td> <?php echo $row['libmotif']; ?> </td>
                    </tr>
                <?php } ?>
                </tbody>
        </table>
    <?php } ?>