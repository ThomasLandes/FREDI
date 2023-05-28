<?php


include "ini.php";

$dbh = db_connect();

$errorSql = null;

$email = isset($_GET['email']) ? $_GET['email'] : '';
$password = isset($_GET['password']) ? $_GET['password'] : '';

// On récupère le mot de passe hashé de l'utilisateur concerné
$sql = "SELECT * FROM utilisateur WHERE mailutil=:email";
try {
    $sth = $dbh->prepare($sql);
    $sth->execute(array(":email" => $email));
    $rows = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    $errorSql = $ex->getMessage();
}
$userID = $rows['idutil'];
$hashedPassword = $rows['mdputil'];

// on verifie si le mdp est bon
if (password_verify($password, $hashedPassword)) {

    // si c'est la cas, on construit la partie du tableau concernant l'utilisateur, pas besoin de faire de requete, on possede deja les infos
    $utilisateur = array(
        "email" => $rows['mailutil'],
        "nom" => $rows['nomutil'],
        "prenom" => $rows['prenomutil'],
        "role" => $rows['pseudoutil']
    );

    // on construit la partie du tableau concernant la periode
    $sql = "select * from periodef , notefrais where periodef.idperiode = notefrais.idperiode and notefrais.idutil = :userid";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":userid" => $userID));
        $rows = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        $errorSql = $ex->getMessage();
    }
    // if ($rows != NULL) {
    //     $periode = array(
    //         "libelle" => $rows['lib_periode'],
    //         "montant" => $rows['mt_km'],
    //         "statut" => $rows['est_active']
    //     );
    // }

    $periode = array();
    if ($rows != NULL) {
        $periode["libelle"] = $rows['libelleperiode'];
        $periode["montant"] = $rows['montant'];
        $periode["statut"] = $rows['is_actif'];
    }

    // on construit la partie du tableau concernant les lignes
    $sql = "SELECT * FROM  lignefrais, notefrais , utilisateur 
    where lignefrais.id_note = notefrais.id_note 
    and  utilisateur.idutil = notefrais.idutil 
    and utilisateur.idutil =  :userid";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":userid" => $userID));
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        $errorSql = $ex->getMessage();
    }
    $lignes = array();
    if (count($rows) > 0) {
        foreach ($rows as $row) {

            //on reucupere les motifs
            $sql = "SELECT libmotif from motif where id_motif = :motifid";
            try {
                $sth = $dbh->prepare($sql);
                $sth->execute(array(":motifid" => $row['id_motif']));
                $motifs = $sth->fetch(PDO::FETCH_ASSOC);
                $motif = $motifs['libmotif'];
            } catch (PDOException $ex) {
                $errorSql = $ex->getMessage();
            }

            $ligne = array(
                "id " => $row['idligne'],
                "date" => $row['datedeplacement'],
                "libelle" => $row["libDeplacement"],
                "cout_peage" => $row['fraisPeage'],
                "cout_repas" => $row['fraisRepas'],
                "cout_hebergement" => $row['fraisHeberge'],
                "nb_km" => $row['kilometrage'],
                "cout_km" => $row['fraisKilometre'],
                "total_ligne" => $row['montantTot'],
                "motif" => $motif
            );
            $lignes[] = $ligne;
        }
    }

    if (isset($errorSql)) {
        $fraisArray = array(
            "message" => 'KO: ' . $errorSql
        );
    } else {
        // on place le resultat de chaque requete dans le tableau final
        $fraisArray = array(
            "message" => "OK : note g\u00e9n\u00e9r\u00e9e",
            "utilisateur" => $utilisateur,
            "periode" => $periode,
            "lignes" => $lignes,
        );
    }

    // écriture dans les logs
 
} else {
    $fraisArray = array(
        "message" => "KO : erreur sur le mdp",
    );
}

// affichage du JSON
$fraisJSON = json_encode($fraisArray, JSON_PRETTY_PRINT);
header("Content-type: application/json; charset=utf-8");
echo $fraisJSON;
