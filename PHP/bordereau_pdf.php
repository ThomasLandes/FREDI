<?php

require_once "../PDF/fpdf.php";
require_once "classes/monpdf.php";
include "ini.php";

$dbh = db_connect();

try {
    $sql = "SELECT CONCAT(adresse,'-',code_postal,'-',ville) as adresse_util ,id_note, nomclub,licence, CONCAT(adresseclub,'-',villeClub,'-',cpClub) as adresse_club , YEAR(dateNote) as NoteDate , nomutil , prenomutil 
    from adherent,club,utilisateur,notefrais,periodef
    where adherent.idclub=club.idclub 
    and periodef.idperiode = notefrais.idperiode
    and adherent.idutil = utilisateur.idutil 
    and utilisateur.idutil = notefrais.idutil
    and utilisateur.idutil = :id_utilisateur
    and periodef.is_actif = 1";
    $params = array(
        ":id_utilisateur" => $_SESSION["id"]
    );
    $sth = $dbh->prepare($sql);
    $sth->execute($params);
    $row = $sth->fetch(PDO::FETCH_ASSOC);
}
catch (PDOException $e) {
    die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}

try {
    $sql = "SELECT montant FROM periodef";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $fisc = $sth->fetch(PDO::FETCH_ASSOC);
}
catch (PDOException $e) {
    die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}

$id_note = $row["id_note"];

try {
    $sql = "select datedeplacement,libDeplacement , fraisKilometre, fraisPeage,fraisRepas,fraisHeberge,lignefrais.montantTot as Total ,kilometrage
    from lignefrais,utilisateur,notefrais,periodef
    where lignefrais.id_note = notefrais.id_note
    and notefrais.idutil = utilisateur.idutil
    and periodef.idperiode = notefrais.idperiode
    AND utilisateur.idutil = :id_utilisateur
    and notefrais.id_note = :id_note
    and periodef.is_actif = 1;";
    $params = array(
        ":id_utilisateur" => $_SESSION["id"],
       ":id_note" => $id_note
    );
    $sth = $dbh->prepare($sql);
    $sth->execute($params);
    $frais = $sth->fetchAll(PDO::FETCH_ASSOC);
}
catch (PDOException $e) {
    die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}

//require_once "fpdf/fpdf.php";

// Instanciation de l'objet dérivé
$pdf = new FPDF();

// Metadonnées
$pdf->SetTitle('bordereau ', true);
$pdf->SetAuthor('FREDI', true);
$pdf->SetSubject('note de frais des bénévoles', true);


// Création d'une page
$pdf->AddPage();

// Définit l'alias du nombre de pages {nb}
$pdf->SetMargins(2, 10, 40);
$pdf->AliasNbPages();

// Titre de page
$pdf->SetFont('helvetica', '', 16);
$pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Note de frais des bénévoles'), 0, 0, 'L');
$pdf->SetTextColor(0, 31, 243);
$pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row["NoteDate"]), 0, 1, 'R');
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(10);

// Contenu
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(10);
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Je soussigné(e)"), 0, 0, "L");
$pdf->Ln(1);
$pdf->SetTextColor(0, 31, 243);
$pdf->Cell(0, 20, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row["nomutil"] . "  " . $row["prenomutil"]), 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0);

$pdf->SetX(10);
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"demeurant"), 0, 0, "L");
$pdf->Ln(1);
$pdf->SetTextColor(0, 31, 243);
$pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row["adresse_util"]), 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(2);

$pdf->SetX(10);
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"certifie renoncer au remboursement des frais ci-dessous et les laisser à l'association"), 0, 1, "L");
$pdf->Ln(1);
$pdf->SetTextColor(0, 31, 243);
$pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row["nomclub"]), 0, 1, 'C');
$pdf->Cell(0, 0, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row["adresse_club"]), 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(2);

$pdf->SetX(10);
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"en tant que don."), 0, 1, "L");
$pdf->Ln(2);


$pdf->SetX(10);
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Frais de déplacement"), 0, 0, "L");
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"                  Tarif kilométrique appliqué pour le rembourssement : " . $fisc["mt_km"] . " euro"), 0, 1, "L");
$pdf->Ln(1);
$pdf->SetX(10);
$pdf->Cell(25, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Date jj/mm/aaaa"), 1, 0, 'L');
$pdf->Cell(25, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Trajet"), 1, 0, 'L');
$pdf->Cell(22, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Kms parcourus"), 1, 0, 'L');
$pdf->Cell(22, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Total frais Kms"), 1, 0, 'L');
$pdf->Cell(20, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Coût péages"), 1, 0, 'L');
$pdf->Cell(18, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Coût repas"), 1, 0, 'L');
$pdf->Cell(26, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Coût hébergement"), 1, 0, 'L');
$pdf->Cell(15, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Total"), 1, 1, 'L');
$cal_total_frais = 0;
foreach ($frais as $frai) {
    $pdf->SetTextColor(0, 31, 243);
    $pdf->SetX(10);
    $pdf->Cell(25, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$frai["datedeplacement"]), 1, 0, 'L');
    $pdf->Cell(25, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$frai["libDeplacement"]), 1, 0, 'L');
    $pdf->Cell(22, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$frai["kilometrage"]), 1, 0, 'L');
    $pdf->Cell(22, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$frai["fraisKilometre"]), 1, 0, 'L');
    $pdf->Cell(20, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$frai["fraisPeage"]), 1, 0, 'L');
    $pdf->Cell(18, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$frai["fraisRepas"]), 1, 0, 'L');
    $pdf->Cell(26, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$frai["fraisHeberge"]), 1, 0, 'L');
    $pdf->Cell(15, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$frai["Total"]), 1, 1, 'L');
    $cal_total_frais = $frai["Total"] + $cal_total_frais;
}
$pdf->SetX(10);
$pdf->Cell(183, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Montant total des frais de déplacement"), 1, 0, 'L');
$pdf->Cell(15, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"$cal_total_frais"), 1, 1, 'L');
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(2);
$pdf->SetX(10);
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Je suis licencié sous le n° de licence suivant :"), 0, 0, "L");
$pdf->Ln(1);
$pdf->SetTextColor(0, 31, 243);
$pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Licence n° " . $row["licence"]), 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(1);

$pdf->SetX(10);
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Montant total des dons"), 0, 0, "L");
$pdf->SetTextColor(0, 31, 243);
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"           $cal_total_frais"), 0, 1, 'L');
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(2);

$pdf->SetX(30);
$pdf->Cell(30, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Pour bénéficier du reçu de dons, cette note de frais doit être accompagnée de toutes les justificatifs correspondants"), 0, 1, "L");
$pdf->Ln(2);

$pdf->SetX(60);
$pdf->Cell(30, 20, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Signature du bénévole:"), 0, 1, "L");
$pdf->Ln(2);

$pdf->SetX(10);
$pdf->Cell(100, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Partie réservée à l'association"), "LTR", 1, "C");
$pdf->SetX(10);
$pdf->Cell(100, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"N° d'ordre du Reçu : 2009-007"), "LR", 1, "L");
$pdf->SetX(10);
$pdf->Cell(100, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Remis le : "), "LR", 1, "L");
$pdf->SetX(10);
$pdf->Cell(100, 8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Signature du Trésorier : "), "LBR", 1, "L");

// Génération du document PDF
$pdf->Output('F', 'outfiles/bordereau_' . $_SESSION["pseudo"] . '.pdf');
header('Location: outfiles/bordereau_' . $_SESSION["pseudo"] . '.pdf');