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
            <div class="navbar">
                <a href="index.php">FREDI</a>
                <a href="ListeNote.php"> Liste des notes</a>
                <a href="deconnexion.php"> Deconnexion</a>
                <?php
                if ($util === ADMIN) {
                    echo "<a href='administration.php'>Administration</a>";
                }
                echo "</div>";
                switch ($util) {
                    case ADMIN:
                        $role = "ADMIN";
                        break;
                    case CONTROLER:
                        $role = "CONTROLLER";
                        break;
                    case DEFAULT_USER:
                        $role = "ADHERENT";
                        break;
                }
                echo "<p class='role'>Rôle : "  . $role . "</p>";
                ?>
                
            </div>

        </div>
    </header>
</body>

</html>