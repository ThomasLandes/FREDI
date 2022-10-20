<?php
include "ini.php"; //ajout de toute les fonctions + session start
//print_r($_SESSION);
$admin = false;
$controler = false;
$conect = isset($_SESSION['mail']);
$type = isset($_SESSION['type']) ? $_SESSION['type'] : 1;
if (!empty($conect) ){
    switch ($type){
        case 2 : $admin = true;
        break;
        case 3 : $controler = true;
        break;
        default:
        break;
    }
 }else {
    redirect('connexion.php');
}
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
        <?php if ($admin) {
            echo "<li><a href='administration.php'>Administration</a></p></li>";
        } ?>
    </ul>
</body>

</html>