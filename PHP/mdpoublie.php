<?php
include 'fonctions/fonction.php';
$dbh = db_connect();
$mail = isset($_POST['email']) ? $_POST['email'] : '';
$submit = isset($_POST['submit']);


$sql = 'select * from utilisateur where mailutil = :mailutil';
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



if ($submit && $mail == $result["mailutil"]) {
    $password = uniqid();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $dbh->prepare("UPDATE utilisateur SET mdputil= :mdputil WHERE mailutil = :mailutil");
        $stmt->execute(array(
":mdputil" => $hashedPassword,
":mailutil" =>$mail,
        ));
     echo"votre mdp est " .$password. "";
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