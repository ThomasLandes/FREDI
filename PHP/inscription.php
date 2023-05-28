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
$adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
$ville = isset($_POST['ville']) ? $_POST['ville'] : '';
$codepostal = isset($_POST['codepostal']) ? $_POST['codepostal'] : '';
$club = isset($_POST['club']) ? $_POST['club'] : '';
$licence = isset($_POST['licence']) ? $_POST['licence'] : '';

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
        $messages[] = "Un compte est déjà relié à ce mail ou ce pseudo";
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

                  // Insérer les données dans la table "adherent"
        $sqlAdherent = "INSERT INTO `adherent` (`adresse`, `licence`, `code_postal`, `ville`, `idclub`, `idutil`) VALUES (:adresse , :licence, :codepostal, :ville, :club, :idutil)";
        $paramsAdherent = array(
            ":idutil" => $dbh->lastInsertId(), // Récupère l'ID généré pour l'utilisateur inséré précédemment
            ":licence" => $licence ,
            ":adresse" => $adresse  ,
            ":codepostal" => $codepostal ,
            ":ville" => $ville ,
            ":club" => $club 
           
        );
        try {
            $sthAdherent = $dbh->prepare($sqlAdherent);
            $sthAdherent->execute($paramsAdherent);
            $nbAdherent = $sthAdherent->rowCount();
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
            redirect('connexion.php');
        }else{
            $messages[]= "Mot de passe non comforme : vous devez avoir au moins 8 caractères, 1 Majuscules, 1 minuscule, 1 Chiffre et 1 caractère spécial. Veuillez recommencer => <a href='inscription.php'>recharger la page</a>";
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
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="stylesheet" href="..CSS/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400&family=Raleway&display=swap" rel="stylesheet">
    <title>Accueil FREDI</title>
</head>

<body>
    <div class="container">

        <div class="container-onglets">
            <div class="onglets active">Inscription</div>
        </div>

        <div class="contenu">
            <h3>Portail inscription FREDI </h3>
            <hr>
            <div class="login">
                <form class="login-container" method="POST">
                    <p><input type="username" name="pseudo" placeholder="Nom utilisateur" required></p>
                    <p><input type="text" name="nom" placeholder="Nom" require></p>
                    <p><input type="text" name="prenom" placeholder="Prenom" require></p>
                    <p><input type="text" name="adresse" placeholder="adresse" require></p>
                    <p><input type="text" name="ville" placeholder="ville" require></p>
                    <p><input type="text" name="codepostal" placeholder="codepostal" require></p>
                    <p><input type="text" name="licence" placeholder="licence" require></p>
                    <p><select name="club" required>
                <option value="1">Dojo Burgien</option>
                <option value="2">Saint-Denis Dojo</option>
                <option value="3">Judo Club Vallée Arbent</option>
                <option value="4">Belli Judo</option>
                <option value="5">Racing Club Montluel Judo</option>
                <option value="6">Centre Arts Martiaux Pondinois</option>
                <option value="7">Judo Club Ornex</option>
                <option value="8">Dojo Gessien Valserine</option>
                <option value="9">Dojo La Vallière</option>
                <option value="10">Football club Merville</option>
                <option value="11">Football Club Bassin d'Arcachon</option>
                <option value="12">Andernos Sport Football Club</option>
                </select><br/>
            </p>
                    <p><input type="email" name="mail" placeholder="Email" required></p>
                    <p><input type="password" name="mdp" placeholder="Mot de passe" required></p>
                    <p> <input type="hidden" name="idtype" value="1"> </p>
                    <p> <input type="hidden" name="idligue" value="99"> </p>
                    <p><input onclick=alert() type="submit" name="submit" value="S'inscrire"></p>
                </form>
            </div>
            <div class="changetype">
                <p>déjà inscrit ? <a href="connexion.php"> Connectez vous !</a></p>
            </div>
        </div>
    </div>
    <?php if ($submit) {
                    if (count($messages) > 0) {
                        foreach ($messages as $message) {
                          echo "<div class='erreur'><p>" . $message . "</p></div>";
                        }
                    }
                } ?>
<p id="reussi"></p>
    <script>
        function alert(){
        $message ="<p class='erreur'>Inscription réussi !</p>"
        window.alert($message);
          }
        </script>
</body>
</html>