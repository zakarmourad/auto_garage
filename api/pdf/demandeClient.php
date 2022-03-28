
<?php 
require "fpdf.php";
include_once '../objects/client.php';

include_once '../config/database.php';
include_once '../objects/historique.php';
include_once '../objects/hisfamille.php';
include_once '../objects/hisimage.php';

$database = new Database();
$db = $database->getConnection();
$historique = new Historique($db);
$hisimage = new Historiquei($db);
$hisfamille = new Historiquef($db);
$clientp = new Client($db);

$historique->id = isset($_GET['id']) ? $_GET['id'] : die();
$historique->search();
$clientp->name=$historique->cliname;
 class PDFDemande extends FPDF{


    public $historique;
    public $hisimage;
    public $hisfamille;
    public $imagps;
    public $fams;
    public $clientz;

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

function clientTab(){
    $this->historique->search();



    if($this->historique->cliname!=null){
        $this->clientz->name =$this->historique->cliname;

        $this->clientz->search();
    $this->SetFont('Arial','B',20);
    $this->SetTextColor(225, 155, 42);

    $this->Cell(80,8,'Renseignement sur le Client : ',0,1,'L');
    $this->SetTextColor(0);

    $this->SetFont('Times','B',10);
    $this->Ln();

    $this->Cell(30,13,'Nom du Client :','LTB',0,'C');
    $this->Cell(60,13,$this->clientz->name,'RTB',0,'C');
    $this->Cell(40,13,'Contact/Email :','LTB',0,'C');
    $this->Cell(60,13,$this->clientz->contact,'RTB',0,'C');     
    $this->Ln();
    $this->Cell(15,13,'Etat :','LTB',0,'C');
    $this->Cell(40,13,$this->clientz->etat == 'comp'? 'Client en Compte' : 'Client Compitant' ,'RTB',0,'C');
    $this->Cell(30,13,'Num'.utf8_decode("é").'ro Tel. :','LTB',0,'C');
    $this->Cell(30,13,$this->clientz->tel,'RTB',0,'C');
    $this->Cell(30,13,'Date d\'arriv'.utf8_decode("é").' :','LTB',0,'C');
    $this->Cell(45,13,$this->historique->created_at,'RTB',0,'C');
    $this->Ln();
    $this->Ln();
    }
}

    function headerTable(){
        $this->historique->search();



        if($this->historique->cliname!=null){
        
        
        $this->hisfamille->his_id=$this->historique->id;
        $this->hisimage->his_id=$this->historique->id;
        
        $stm1=$this->hisfamille->readAll();
        $stm2=$this->hisimage->readAll();
        
        
        $num1 = $stm1->rowCount();
        $num2 = $stm2->rowCount();
        
        if($this->historique->cliname!=null && $num1>0){
        
        $images=array();
        $othr=array();
        $offi=array();
        
        
            while ($row = $stm1->fetch(PDO::FETCH_ASSOC)){
               
                extract($row);
                    if($fam == "offi"){
                            $offi[]=$sfam;
                    }
                    if($fam == "othr"){
                        $othr[]=$sfam;
                    }
                
            }
        
        
            while ($row = $stm2->fetch(PDO::FETCH_ASSOC)){
               
                extract($row);
         
                $this->imagps[]=$image;
               
            }
            $this->fams= array_merge($offi,$othr);
            // create array
            $historiques = array(
                "voiture_imma" =>  $this->historique->voiture_imma,
                "cliname" => $this->historique->cliname,
                "mark" => $this->historique->mark,
                "model" => $this->historique->model,
                "kilometrage" => $this->historique->kilometrage,
                "chassis" => $this->historique->chassis,
                "niveau" => $this->historique->niveau,
                "t1" => $this->historique->t1,
                "t2" => $this->historique->t2,
                "t3" => $this->historique->t3,
                "id" => $this->historique->id,              
                "created_at" => $this->historique->created_at
         
                );
            }
        }
          
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(33,184,175);

        $this->Cell(80,8,'Renseignement sur la V'.utf8_decode("é").'hicule : ',0,1,'L');
        $this->SetTextColor(0);
        $this->Ln();
        $this->SetFont('Times','B',10);
        $this->Cell(30,13,'Immatricule :','LTB',0,'C');
        $this->Cell(30,13,$historiques['voiture_imma'],'RTB',0,'C');
        $this->Cell(30,13,'N Chassis :','LTB',0,'C');
        $this->Cell(30,13,$historiques['chassis'],'RTB',0,'C');
        $this->Cell(40,13,'Kilometrage :','LTB',0,'C');
        $this->Cell(30,13,$historiques['kilometrage'],'RTB',0,'C');
        $this->Ln();
        
        $this->Cell(30,13,'Marque :','LTB',0,'C');
        $this->Cell(30,13,$historiques['mark'],'RTB',0,'C');
        $this->Cell(30,13,'Model :','LTB',0,'C');
        $this->Cell(30,13,$historiques['model'],'RTB',0,'C');
        $this->Cell(40,13,'Niveau Carburant :','LTB',0,'C');
        $this->Cell(30,13,$historiques['niveau'],'RTB',0,'C');
        $this->Ln();
        $this->Ln();
    }
    

    function ImagesR(){
        if(!empty($this->imagps)){
            if(count($this->fams)<4){
                $this->SetFont('Arial','B',20);
                $this->SetTextColor(33,184,175);
        
                $this->Cell(80,8,'Etat de la v'.utf8_decode("é").'hicule sans d'.utf8_decode("é").'marrage : ',0,1,'L');
                $this->SetTextColor(0);
                $this->Ln();
        
                    $this->SetFont('Times','',12);
                    $this->Cell(190,35,'',1,1,'C');
                        if(!empty($this->imagps[0])){
                            $this->image("../voiture/uploads/".$this->imagps[0],13,203,0,26);
                        }
                        if(!empty($this->imagps[1])){
                            $this->image("../voiture/uploads/".$this->imagps[1],63,203,0,26);
                        }
                        if(!empty($this->imagps[2])){
                            $this->image("../voiture/uploads/".$this->imagps[2],113,203,0,26);
                        }
                        if(!empty($this->imagps[3])){
                            $this->image("../voiture/uploads/".$this->imagps[3],163,203,0,26);
                        }

            }elseif(count($this->fams)>3 && count($this->fams)<7){

                $this->SetFont('Arial','B',20);
                $this->SetTextColor(33,184,175);
        
                $this->Cell(80,8,'Etat de la v'.utf8_decode("é").'hicule sans d'.utf8_decode("é").'marrage : ',0,1,'L');
                $this->SetTextColor(0);
                $this->Ln();
        
                    $this->SetFont('Times','',12);
                    $this->Cell(190,35,'',1,1,'C');
                        if(!empty($this->imagps[0])){
                            $this->image("../voiture/uploads/".$this->imagps[0],13,217,0,26);
                        }
                        if(!empty($this->imagps[1])){
                            $this->image("../voiture/uploads/".$this->imagps[1],63,217,0,26);
                        }
                        if(!empty($this->imagps[2])){
                            $this->image("../voiture/uploads/".$this->imagps[2],113,217,0,26);
                        }
                        if(!empty($this->imagps[3])){
                            $this->image("../voiture/uploads/".$this->imagps[3],163,217,0,26);
                        }
            }elseif(count($this->fams) > 6){

                
                $this->SetFont('Arial','B',20);
                $this->SetTextColor(33,184,175);
        
                $this->Cell(80,8,'Etat de la v'.utf8_decode("é").'hicule sans d'.utf8_decode("é").'marrage : ',0,1,'L');
                $this->SetTextColor(0);
                $this->Ln();
        
                    $this->SetFont('Times','',12);
                    // $this->Cell(190,35,'',1,1,'C');
                        if(!empty($this->imagps[0])){
                            $this->image("../voiture/uploads/".$this->imagps[0],13,221,0,26);
                        }
                        if(!empty($this->imagps[1])){
                            $this->image("../voiture/uploads/".$this->imagps[1],63,221,0,26);
                        }
                        if(!empty($this->imagps[2])){
                            $this->image("../voiture/uploads/".$this->imagps[2],113,221,0,26);
                        }
                        if(!empty($this->imagps[3])){
                            $this->image("../voiture/uploads/".$this->imagps[3],163,221,0,26);
                        }
            }
           
        }
       
    }


    function demandeClient(){
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(225, 155, 42);

        $this->Cell(80,8,'Demande du Client : ',0,1,'L');
        $this->SetTextColor(0);
        $this->Ln();

        $this->SetFont('Times','B',10);
        for($i=0;$i<count($this->fams);$i+=3 ){
           if(!empty($this->fams[$i]) && !empty($this->fams[$i+1]) ) {$this->Cell(63.4,13,$this->fams[$i],1,0,'C');}elseif(!empty($this->fams[$i]) && empty($this->fams[$i+1])){$this->Cell(63.4,13,$this->fams[$i],1,1,'C');}
           if(!empty($this->fams[$i+1]) && !empty($this->fams[$i+2])  ) {$this->Cell(63.3,13,$this->fams[$i+1],1,0,'C');}elseif(!empty($this->fams[$i+1]) && empty($this->fams[$i+2])){$this->Cell(63.4,13,$this->fams[$i+1],1,1,'C');}
           if(!empty($this->fams[$i+2])) {$this->Cell(63.3,13,$this->fams[$i+2],1,1,'C');}
        }
        $this->Ln();

    }
  
    
}
$pdf = new PDFDemande();
$pdf->historique= $historique;
$pdf->hisimage= $hisimage;
$pdf->hisfamille= $hisfamille;
$pdf->clientz= $clientp;

$pdf->SetTitle("Historique du voiture: ".$historique->voiture_imma);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->clientTab();
$pdf->headerTable();
$pdf->demandeClient();
$pdf->ImagesR();
$pdf->Output("D","Demande_Client_".$historique->voiture_imma.".pdf");

?>

