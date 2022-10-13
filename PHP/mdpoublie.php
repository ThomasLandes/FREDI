<?php
include 'fonctions/fonction.php';
$dbh = db_connect();
$mail = isset($_POST['email']) ? $_POST['email'] : '';

if ($mail == "victor@gmail.com") {
    $password = uniqid();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        $stmt = $dbh->prepare("UPDATE utilisateur SET mdputil= :mdputil WHERE mailutil = :mailutil");
        $stmt->execute(array(
":mdputil" => $hashedPassword,
":mailutil" =>$mail,
        ));
     echo"votre mdp est".$hashedPassword."";
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
            <button type="submit">Send me a random password</button>
            <a href="connexion.php" >Retour connexion</a>;
        </div>
    </form>
</body>

</html>

<?php


?>