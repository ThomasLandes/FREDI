<?php
  // Connect to database
  include "fonctions/fonction.php";

  $conn = mysqli_connect("localhost","root","");

  if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
      
      $file = fopen($fileName, "r");
      
      while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
        $sql = "INSERT into motif (id_motif,libmotif)
             values ('" . $column[0] . "','" . $column[1] . "')";
        $result = mysqli_query($conn, $sql);
        
        if (! empty($result)) {
          $type = "success";
          $message = "Les Données sont importées dans la base de données";
        } else {
          $type = "error";
          $message = "Problème lors de l'importation de données CSV";
        }
      }
    }
  }
  //Retourner à la page index.php
  header('Location: index.php');
  exit;
?>