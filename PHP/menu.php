<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/menu.css">
</head>
<body>
<header> 

<div class="topnav">
    <div class="accueil">FREDI</div>
        <div class="navbar"> 
        
            <a  href="inscription.php"> Inscription</a>
            <a  href="connexion.php"> Connexion</a>
            <a  href="deconnexion.php"> Deconnexion</a>
            <a href="ListeNote.php"> Liste des notes</a>
            <?php
            if ($util === ADMIN) {
                echo "<div><a href='administration.php'>Administration</a><div>";
            }
            switch($util){
            case ADMIN : $role = "ADMIN";
            break;
            case CONTROLER : $role = "CONTROLLER";
            break;
            case DEFAULT_USER : $role = "ADHERENT";
            break;
            }
            echo "<p class='role' >Rôle : "  .$role."</p>";
            ?>
            
        </div>
     
</div>
</header>
</body>
</html>