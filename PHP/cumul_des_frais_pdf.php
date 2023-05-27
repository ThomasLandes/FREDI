<?php

require_once "../PDF/fpdf.php";
require_once "classes/monpdf.php";
include "ini.php";

$laDATA = db_connect();


// Lecture des notes depuis la DB
try {
    $sql = "SELECT * ,lignefrais.montantTot AS montantTotLigne 
    FROM lignefrais, motif, notefrais, periodef 
    WHERE motif.id_motif = lignefrais.id_motif 
    AND notefrais.id_note = lignefrais.id_note 
    AND periodef.idperiode = notefrais.idperiode 
    AND periodef.is_actif = 1;";

    $result = $laDATA->prepare($sql);
    $result->execute();
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    $message += '\n' + $ex->getMessage();
}

// Calcul du montant total
$montantGlobal = 0;
foreach ($rows as $row) {
    $montantGlobal += $row['montantTot'];
}

// Instanciation de l'objet dérivé
$pdf = new Monpdf();

// Metadonnées
$pdf->SetTitle('Cumul des frais', true);
$pdf->SetAuthor('FREDI', true);
$pdf->SetSubject('Cumul des frais', true);
$pdf->mon_fichier = "cumul_des_frais.pdf";

// Création d'une page
$pdf->AddPage();

// Définit l'alias du nombre de pages {nb}
$pdf->AliasNbPages();

// Titre
$pdf->SetFont('', 'B', 16);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Notes de frais'), false, 0, 'C');
$pdf->Ln(15);

// foreach ($clubs as $club) {
//     if (in_array($club['id_club'], $rows)) {
//         $pdf->SetFont('', '', 16);
//         $pdf->SetTextColor(0, 0, 0);
//         $pdf->Cell(0, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$club['lib_club']), false, 0, 'C');

if ($rows === false && $message) {
    $pdf->Cell(40, 10, 'Erreur : impossible de trouver les informations !');
    $pdf->Cell(40, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$message), false);
} else {
    $pdf->SetFont('', 'B', 12);
    $pdf->Cell(10, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT','ID'), true);
    $pdf->Cell(35, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Total'), true);
    $pdf->Cell(35, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Date déplacement'), true);
    $pdf->Cell(35, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Libelle période'), true);
    $pdf->Cell(35, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Libelle Motif'), true);
    $pdf->Ln();

    $pdf->SetFont('', '', 12);
    foreach ($rows as $row) {
        // if ($club['id_club'] === $row['id_club']) {
        $pdf->Cell(10, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row['idligne']), true);
        $pdf->Cell(35, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['montantTotLigne']), true);
        $pdf->Cell(35, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row['datedeplacement']), true);
        $pdf->Cell(35, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row['libelleperiode']), true);
        $pdf->Cell(35, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row['libmotif']), true);
        $pdf->Ln();
        // }
    }
    $pdf->Ln(10);
    $pdf->Cell(40, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Total: ' . count($rows) . ' notes'), false);
    $pdf->Ln();
    $pdf->Cell(40, 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Montant total global: ' . $montantGlobal . ' euros'), false);
}
//     }
// }

// Génération du document PDF
unlink('outfiles/' . $pdf->mon_fichier); // suppr fichier
$pdf->Output('f', 'outfiles/' . $pdf->mon_fichier);
header('Location: outfiles/' . $pdf->mon_fichier); // redirection vers le fichier dans le dossier outfiles
