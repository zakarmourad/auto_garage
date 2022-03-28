<?php 
require "fpdf.php";
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();
 class PDFClients extends FPDF{
    function header(){
        
        $this->SetFont('Arial','B',20);
        $this->Cell(276,10,'Liste Des Clients',0,0,'C');
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
        $this->Cell(20,10,'ID',1,0,'C');
        $this->Cell(60,10,'Nom du Client',1,0,'C');
        $this->Cell(60,10,'Numero Tel.',1,0,'C');
        $this->Cell(70,10,'Contact',1,0,'C');
        $this->Cell(20,10,'Etat',1,0,'C');
        $this->Cell(40,10,'Date d\'Ajout',1,0,'C');
        $this->Ln();
    }
    function viewTable($db){
        $this->SetFont('Times','',12);
        $stmt = $db->query('SELECT * FROM clients');

        while($data = $stmt->fetch(PDO::FETCH_OBJ)){
            $this->Cell(20,10,$data->id,1,0,'C');
            $this->Cell(60,10,$data->name,1,0,'C');
            $this->Cell(60,10,$data->tel,1,0,'C');
            $this->Cell(70,10,$data->contact,1,0,'C');
            $this->Cell(20,10,$data->etat,1,0,'C');
            $this->Cell(40,10,$data->created_at,1,0,'C');
            $this->Ln();
        }
    }
}
$pdf = new PDFClients();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($db);

$pdf->Output();


?>