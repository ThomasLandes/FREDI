<?php

/**
 * Test des fonctions de validation
 */
// Initialisations
include "init.php";
$messages = array();  // Message d'erreur

// Récupère le contenu du formulaire
$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$submit = isset($_POST['submit']);

// Vérifie le user
if ($submit) {
  // le login est obligatoire
  if (is_empty($login)) {
    $messages[] = "le login est obligatoire";
  }
  // au minimum 4 caractères
  if (!min_length($login, 4)) {
    $messages[] = "le login doit faire au moins 4 car.";
  }
  // au maximum 12 caractères
  if (!max_length($login, 12)) {
    $messages[] = "le login doit faire au plus 12 car.";
  }
  /*
  // est alphanumérique
  if (!is_alphanum($login)) {
    $messages[] = "le login doit être alphanumérique";
  }

  // est en majuscule
  if (!is_uppercase($login)){
    $messages[]="le login doit être en majuscules";
  }

  // est en minuscules
  if (!is_lowercase($login)) {
    $messages[] = "le login doit être en minuscules";
  }
  // Contient aaa, bbb ou ccc
  $tableau = array("aaaaaaaa","bbbbbbbb","cccccccc");
  if (!contains_value($login,$tableau)) {
    $messages[] = "le login doit contenir \"aaaaaaaa\",\"bbbbbbbb\" ou \"cccccccc\"";
  }

  // Contient aaa, bbb ou ccc
  $tableau = array("aaaa"=>0,"bbbb"=>0,"cccc"=>0);
  if (!contains_key($login,$tableau)) {
    $messages[] = "le login doit contenir \"aaaa\",\"bbbb\" ou \"cccc\"";
  }
*/

  // contient au moins un chiffre
  if (!contains_num($login)) {
    $messages[] = "le login doit contenir au moins un chiffre";
  }

  // contient au moins moins une minuscule
  if (!contains_lowercase($login)) {
    $messages[] = "le login doit contenir au moins une minuscule";
  }

  // contient au moins moins une majuscule
  if (!contains_uppercase($login)) {
    $messages[] = "le login doit contenir au moins une majuscule";
  }


  // contient au moins moins un caractère spécial
  if (!contains_special($login)) {
    $messages[] = "le login doit contenir au moins un caractère spécial";
  }

  // Pas de message : connecté !
  if (count($messages) == 0) {
    header("Location: ok.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Password Validation</title>
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <div id="content">
    <h1>Password Validation</h1>
    <h2>Connexion</h2>
    <?php
    if (count($messages) > 0) {
      echo "<ul>";
      foreach ($messages as $message) {
        echo "<li class=\"erreur\" >" . $message . "</li>";
      }
      echo "</ul>";
    }
    ?>
    </p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <p>login<br /><input type="text" name="login" id="login" value="<?= $login ?>"></p>
      <p>password<br /><input type="password" name="password" id="password"></p>
      <p><input type="submit" name="submit" value="OK" /></p>
    </form>
  </div>
</body>

</html>