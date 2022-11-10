<?php
include 'fonctions/fonction.php';
// Connexion à la base
$conn = mysqli_connect("localhost","root","");
$dbh = db_connect();
// Liste des personnes
$sql = 'select * from utilisateur';
try {
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>administration</title>
    <link rel="stylesheet" href="../CSS/main.css">
</head>

<body>
    <h1>Administration des données</h1>
    <h2>Chargement des fichiers</h2>

    <form enctype="multipart/form-data" action="import_csv.php" method="post">
        <div class="input-row">
            <label class="col-md-4 control-label">Choisir un fichier CSV</label>
            <input type="file" name="file" id="file" accept=".csv">
            <br />
            <br />
            <button type="submit" id="submit" name="import" class="btn-submit">Import</button>
            <br />
        </div>
    </form>
    <?php
    $sql = "SELECT * FROM motif";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    ?>
        <table>
            <thead>
                <tr>
                    <th>motif ID</th>
                    <th>Libelle</th>
                </tr>
            </thead>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tbody>
                    <tr>
                        <td> <?php echo $row['id_motif']; ?> </td>
                        <td> <?php echo $row['libmotif']; ?> </td>
                    </tr>
                <?php } ?>
                </tbody>
        </table>
    <?php } ?>