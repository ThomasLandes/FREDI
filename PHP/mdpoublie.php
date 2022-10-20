<?php
include 'fonctions/fonction.php';
$dbh = db_connect();
$mail = isset($_POST['email']) ? $_POST['email'] : '';
$submit = isset($_POST['submit']);


$sql = 'select * from utilisateur where mailutil = :mailutil';    // Trouve utilisateur depuis BDD
$params = array(
    ":mailutil" => $mail,
);
try {
    $sth = $dbh->prepare($sql);
    $sth->execute($params);
    $result = $sth->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}



if ($submit && $mail == $result["mailutil"]) {   //compare le mail donné avec le mail de la BDD lors du submit 
    $password = generate_random_letters(2).uniqid().getRandomString(2);  // renvoie aléatoire lettreMajuscule.ChiffreLettre.CaracteresSpécial  
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // hash mot de passe

        $stmt = $dbh->prepare("UPDATE utilisateur SET mdputil= :mdputil WHERE mailutil = :mailutil"); //modifie mdp dans la BDD
        $stmt->execute(array(
":mdputil" => $hashedPassword,
":mailutil" =>$mail,
        ));
     echo"votre mdp est ".$password."";
}

?>
 
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site web</title>
</head>

<body>
    <h2>Forgot password</h2>
    <form method="post">
        <div class="container">
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" required>
            <button type="submit" name="submit">Send me a random password</button>
            <a href="connexion.php" >Retour connexion</a>;
        </div>
    </form>
</body>

</html>

<?php


?>