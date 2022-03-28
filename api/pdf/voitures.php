<?php 
require "fpdf.php";
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();
 class PDFVoitures extends FPDF{
    function header(){
        
        $this->SetFont('Arial','B',20);
        $this->Cell(276,10,'Liste Des Voitures',0,0,'C');
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->Ln();

    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',10);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function headerTable(){
        $this->SetFont('Times','B',12);
        $this->Cell(35,10,'Immatricule',1,0,'C');
        $this->Cell(30,10,'Chassis',1,0,'C');
        $this->Cell(25,10,'Mark',1,0,'C');
        $this->Cell(20,10,'Model',1,0,'C');
        $this->Cell(40,10,'Kilometrage',1,0,'C');
        $this->Cell(25,10,'Niveau Car.',1,0,'C');
        $this->Cell(60,10,'Client',1,0,'C');
        $this->Cell(40,10,'Date d\'Ajout',1,0,'C');
        $this->Ln();
    }
    function viewTable($db){
        $this->SetFont('Times','',12);
        $stmt = $db->query('SELECT * FROM voitures');

        while($data = $stmt->fetch(PDO::FETCH_OBJ)){
            $this->Cell(35,10,$data->imma,1,0,'C');
            $this->Cell(30,10,$data->chassis,1,0,'C');
            $this->Cell(25,10,$data->mark,1,0,'C');
            $this->Cell(20,10,$data->model,1,0,'C');
            $this->Cell(40,10,$data->kilometrage.' Km',1,0,'C');
            $this->Cell(25,10,$data->niveau,1,0,'C');
            $this->Cell(60,10,$data->cliname,1,0,'C');
            $this->Cell(40,10,$data->created_at,1,0,'C');
            $this->Ln();
        }
    }
}
$pdf = new PDFVoitures();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($db);

$pdf->Output();


?>