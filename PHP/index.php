<?php
include "ini.php"; //ajout de toute les fonctions + session start
//print_r($_SESSION);
$page="index.php";
logToDisk($page);
$util = verrif_util($conect);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FREDI</title>
</head>

<body>
    <h1>FREDI - Accueil</h1>
    <ul>
        <li><a href="inscription.php"> Inscription</a></p>
        </li>
        <li><a href="connexion.php"> Connexion</a></p>
        </li>
        <li><a href="deconnexion.php"> Deconnexion</a></p>
        </li>
        <li><a href="ListeNote.php"> List</a></p>
        </li>
 
        <?php
        if ($util === ADMIN) {
            echo "<li><a href='administration.php'>Administration</a></p></li>";
        } ?>
    </ul>
</body>

</html>