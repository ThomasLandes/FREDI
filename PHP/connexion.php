<?php

include "ini.php"; //ajout de toute les fonctions
$dbh = db_connect();

$mail = isset($_POST['mail']) ? $_POST['mail'] : '';

$mdpuncrypt = isset($_POST['mdp']) ? $_POST['mdp'] : '';


$submit = isset($_POST['submit']);



if ($submit) {
    if (!empty($_POST['mail']) && !empty($_POST['mdp'])) { //Verification de l'existance des variable (et qu'elles ne sont pas vide)
        $mail = strtolower($mail); // on s'assure que le mail soit en minuscule
        

        $sql = 'select * from utilisateur where mailutil = :mailutil';
        $params = array(
            ":mailutil" => $mail,
        );
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute($params);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nb = $sth->rowcount();
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
    
        $passwordHash = $result['mdputil'];    
 

        if ($nb == 1 && password_verify($mdpuncrypt, $passwordHash)) { 
                    $_SESSION['pseudo'] = $result['pseudoutil'];
                    $_SESSION['mail'] = $result['mailutil'];
                    $_SESSION['id'] = $result['idutil'];
                    $_SESSION['type'] = $result['typeutil'];
                    $_SESSION['mdp'] = $mdpuncrypt;

                   $page="connexion.php";
                   logToDisk($page,$_SESSION['pseudo'],$mdpuncrypt);

                    redirect('index.php');
        }else{
            $message = "Erreur inscrivez-vous d'abord !";
            echo "<div class='erreur'><p>" . $message . "</p></div>";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400&family=Raleway&display=swap" rel="stylesheet">
    <title>Accueil FREDI</title>
</head>

<body>
    <div class="container">

        <div class="container-onglets">
            <div class="onglets active">Connexion</div>
        </div>

        <div class="contenu">
            <h3>Portail connexion FREDI</h3>
            <hr>
            <div class="login">
                <form class="login-container"  method="POST">
                    <p><input type="email" name="mail" placeholder="Email" value=""></p>
                    <p><input type="password" name="mdp" placeholder="Mot de passe" value=""></p>
                    <p><input type="submit" value="Se connecter" name="submit"></p>
                    <p><a href="mdpoublie.php">mot de passe oublie ?</a></p>
                </form>
            </div>
            <div class="changetype">
                <p>pas encore inscrit ? <a href="inscription.php"> Inscrivez vous !</a></p>
            </div>
        </div>
    </div>
</body>

</html>