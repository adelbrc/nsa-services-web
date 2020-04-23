<?php

require('fpdf/fpdf.php');
require_once("DBManager.php");

$conn = DBManager::getConn();

/**
 *
 */
class Invoice extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('ressources/img/nsa-services.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(45);
        // Title
        $this->Cell(100,10,'Facture',1,0,'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }



}


?>
