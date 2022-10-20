<?php

include 'ini.php';

$dbh = db_connect();

$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
$mdpuncrypt = isset($_POST['mdp']) ? $_POST['mdp'] : '';
$idligue = isset($_POST['idligue']) ? $_POST['idligue'] : '';
$typeutil = isset($_POST['idtype']) ? $_POST['idtype'] : '';
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$mdp = password_hash($mdpuncrypt, PASSWORD_BCRYPT);

$submit = isset($_POST['submit']);

// Ajout dans la base
if ($submit) {

    $check = 'select * from utilisateur where mailutil =:mailutil and pseudoutil = :pseudo';
    $checkparams = array(":mailutil" => $mail, ":pseudo" => $pseudo);
    try {
        $sth0 = $dbh->prepare($check);
        $sth0->execute($checkparams);
        $nbresult = $sth0->rowcount();
    } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }

    if ($nbresult > 0) {
        $message = "Un compte est déjà relié à ce mail ou ce pseudo";
        die("<p>Erreur : " . $message . "</p>");
    } else {
        if ( min_length($mdpuncrypt, 8) && contains_num($mdpuncrypt) && contains_lowercase($mdpuncrypt) && contains_uppercase($mdpuncrypt) && contains_special($mdpuncrypt)) {
            $sql = "INSERT INTO utilisateur(pseudoutil, mdputil,nomutil,prenomutil, typeutil, mailutil, idligue) VALUES (:pseudoutil, :mdputil,:nomutil,:prenomutil,:typeutil , :mailutil, :idligue )";
            $params = array(
                ":pseudoutil" => $pseudo,
                ":mdputil" => $mdp,
                "nomutil" => $nom,
                ":prenomutil" => $prenom,
                ":mailutil" => $mail,
                ":typeutil" => $typeutil,
                ":idligue" => $idligue

            );
            try {
                $sth = $dbh->prepare($sql);
                $sth->execute($params);
                $nb = $sth->rowcount();
            } catch (PDOException $e) {
                die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
            }
            redirect('connexion.php');
        }else{
            die("Mot de passe non comforme : vous devez avoir au moins 8 caractères, 1 Majuscules, 1 minuscule, 1 Chiffre et 1 caractère spécial. Veuillez recommencer => <a href='inscription.php'>Inscription</a>");
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400&family=Raleway&display=swap" rel="stylesheet">
    <title>Accueil FAQ MDL</title>
</head>

<body>
    <div class="container">

        <div class="container-onglets">
            <div class="onglets active">Inscription</div>
        </div>

        <div class="contenu">
            <h3>Portail inscription FAQ maison des ligues </h3>
            <hr>
            <div class="login">
                <form class="login-container" method="POST">
                    <p><input type="username" name="pseudo" placeholder="Nom utilisateur" required></p>
                    <p><input type="text" name="nom" placeholder="Nom" require></p>
                    <p><input type="text" name="prenom" placeholder="Prenom" require></p>
                    <p><input type="email" name="mail" placeholder="Email" required></p>
                    <p><input type="password" name="mdp" placeholder="Mot de passe" required></p>
                    <p> <input type="hidden" name="idtype" value="1"> </p>
                    <p> <input type="hidden" name="idligue" value="1"> </p>
                    <p><input type="submit" name="submit" value="S'inscrire"></p>
                </form>
                <?php if ($submit) {
                    echo '<p>' . $message . '</p>';
                } ?>
            </div>
            <div class="changetype">
                <p>déjà inscrit ? <a href="connexion.php"> Connectez vous !</a></p>
            </div>
        </div>
    </div>

    <script>
        window.alert(Document.getElementById('reussi') );
    </script>
</body>