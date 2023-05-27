<?php

/**
 * Classe héritant de fpdf
 * On s'en sert pour pouvoir ajouter une entête et un bas de page
 */
class Monpdf extends FPDF
{

    var $mon_fichier = "???";

    function Header()
    {
        // Formation
        $this->SetFont('Arial', '', 10); // Police Arial 10
        $this->Cell(50, 8, 'BTS SIO', 'B', 0, 'L');
        // Titre
        $this->SetFont('Arial', 'B', 10); // Police Arial gras 10
        $this->Cell(90, 8, $this->mon_fichier, 'B', 0, 'C');
        // Date du jour
        $this->SetFont('Arial', '', 10); // Police Arial 10
        $this->Cell(50, 8, date("d/m/Y"), 'B', 0, 'R');
        // Saut de ligne
        $this->Ln(15);
    }

    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);

        // Copyright
        $this->SetFont('Arial', '', 10); // Police Arial gras 10
        $this->Cell(50, 8, 'Limayrac', 'T', 0, 'L');
        // nom du fichier
        $this->SetFont('Arial', '', 10); // Police Arial 10
        $this->Cell(90, 8, 'FREDI', 'T', 0, 'C');
        // Numéro de page
        $this->SetFont('Arial', '', 10);  // Police Arial italique 10
        $this->Cell(50, 8, 'Page ' . $this->PageNo() . '/{nb}', 'T', 0, 'R');
    }
}
