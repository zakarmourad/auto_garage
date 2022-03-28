<?php 
require "fpdf.php";
header('Content-type: text/html; charset=utf-8');
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();
 class PDFVoitures extends FPDF{
    function header(){
        
        $this->SetFont('Arial','B',25);
        $this->Cell(195,8,'FICHE DE RECEPTION',0,0,'C');
        $this->Ln(20);

    }
    function footer(){
        $this->SetY(-40);
        $this->SetFont('Arial','',10);
        $this->Cell(60,5,'Signature de Client',0,0,'C');
        $this->Cell(70,5,'',0,0,'C');
        $this->Cell(60,5,'Signature d\'Entreprise',0,1,'C');
        $this->Ln();

        $this->Cell(60,15,'',1,0,'C');
        $this->Cell(70,15,'',0,0,'C');
        $this->Cell(60,15,'',1,0,'C');

        $this->SetY(-10);
        $this->SetFont('Arial','',10);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function headerTable(){
        
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(33,184,175);

        $this->Cell(80,8,'Renseignement sur la V'.utf8_decode("é").'hicule : ',0,1,'L');
        $this->SetTextColor(0);
        $this->Ln();
        $this->SetFont('Times','B',10);
        $this->Cell(30,13,'Immatricule :','LTB',0,'C');
        $this->Cell(30,13,'14-A-1568','RTB',0,'C');
        $this->Cell(30,13,'N Chassis :','LTB',0,'C');
        $this->Cell(30,13,'OFCKDc39','RTB',0,'C');
        $this->Cell(40,13,'Kilometrage :','LTB',0,'C');
        $this->Cell(30,13,'30 000 KM','RTB',0,'C');
        $this->Ln();
        
        $this->Cell(30,13,'Marque :','LTB',0,'C');
        $this->Cell(30,13,'DASIA','RTB',0,'C');
        $this->Cell(30,13,'Model :','LTB',0,'C');
        $this->Cell(30,13,'1992','RTB',0,'C');
        $this->Cell(40,13,'Niveau Carburant :','LTB',0,'C');
        $this->Cell(30,13,'2/4','RTB',0,'C');
        $this->Ln();
        $this->Ln();

    }
    function ImagesR(){

        $this->SetFont('Arial','B',20);
        $this->SetTextColor(33,184,175);

        $this->Cell(80,8,'Etat de la v'.utf8_decode("é").'hicule sans d\''.utf8_decode("é").'marrage : ',0,1,'L');
        $this->SetTextColor(0);
        $this->Ln();

            $this->SetFont('Times','',12);
            $this->Cell(190,35,'',1,1,'C');
            $this->image("../voiture/uploads/5ea3e883a47ee5.26095648.jpg",13,215,0,26);
            $this->image("../voiture/uploads/5ea30d5defac10.39835089.jpg",63,215,0,26);
            $this->image("../voiture/uploads/5ea3e883a47ee5.26095648.jpg",113,215,0,26);
            $this->image("../voiture/uploads/5ea30d5defac10.39835089.jpg",163,215,0,26);
    }
    function demandeClient(){
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(225, 155, 42);

        $this->Cell(80,8,'Demande du Client : ',0,1,'L');
        $this->SetTextColor(0);
        $this->Ln();

        $this->SetFont('Times','B',10);
        $this->Cell(63.4,13,'HUILE DE FREINS',1,0,'C');
        $this->Cell(63.3,13,'COURROIE D\'ALTERNATEUR',1,0,'C');
        $this->Cell(63.3,13,'PLAQUETTE DE FREIN AV',1,1,'C');
        $this->Cell(63.3,13,'POMPE HAUTE PRESSION',1,0,'C');
        $this->Cell(63.3,13,'CHANGEMENT COURRALE',1,0,'C');
        $this->Cell(63.4,13,'COURROIE DE DISTRIBUTION',1,0,'C');
        $this->Ln();
        $this->Ln();


    }
    function clientTab(){
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(225, 155, 42);

        $this->Cell(80,8,'Renseignement sur le Client : ',0,1,'L');
        $this->SetTextColor(0);

        $this->SetFont('Times','B',10);
        $this->Ln();

        $this->Cell(30,13,'Nom du Client :','LTB',0,'C');
        $this->Cell(60,13,'Youssef Boutakourt','RTB',0,'C');
        $this->Cell(40,13,'Contact/Email :','LTB',0,'C');
        $this->Cell(60,13,'youssef.boutakourt@gmail.com	','RTB',0,'C');     
        $this->Ln();
        $this->Cell(15,13,'Etat :','LTB',0,'C');
        $this->Cell(40,13,'Client Compitant','RTB',0,'C');
        $this->Cell(30,13,'Num'.utf8_decode("é").'ro Tel. :','LTB',0,'C');
        $this->Cell(30,13,'0958250269','RTB',0,'C');
        $this->Cell(30,13,'Date d\'arriv'.utf8_decode("é").' :','LTB',0,'C');
        $this->Cell(45,13,'2020-04-29 23:25:41','RTB',0,'C');
        $this->Ln();
        $this->Ln();
    }
    
}
$pdf = new PDFVoitures();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->clientTab();
$pdf->headerTable();

$pdf->demandeClient();
$pdf->ImagesR();

$pdf->Output("I","d");


?>