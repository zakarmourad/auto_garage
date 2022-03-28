<?php
// Start the session
session_start();
if(!isset($_SESSION['_Gtx'])){
    header("location:../../view/login.php");
}
?>
<?php
// required headers
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
include_once '../objects/voiture.php';
include_once '../objects/image.php';
include_once '../objects/famille.php';
include_once '../objects/historique.php';
include_once '../objects/hisimage.php';
include_once '../objects/hisfamille.php';


$database = new Database();
$db = $database->getConnection();
 
$voiture = new Voiture($db);
$image = new Image($db);
$famille = new Famille($db);
$historique = new Historique($db);
$hisfamille = new Historiquef($db);
$hisimage = new Historiquei($db);



// get posted data on json 

$othr=$_POST['othr'];
$offi=$_POST['offi'];

$imma=$_POST['i1'].'-'.$_POST['i2'].'-'.$_POST['i3'];
$mark=$_POST['mark'];
$model=$_POST['model'];
$chassis=$_POST['chassis'];
$name=$_POST['cli'];
$kilo=$_POST['kilo'];
$niveau=$_POST['niveau'];
$t1=$_POST['t1'];
$t2=$_POST['t2'];
$t3=$_POST['t3'];

if(!empty($othr) || !empty($offi)){



// make sure data is not empty
if(
    !empty($_POST['i1']) &&
    !empty($_POST['i2']) &&
    !empty($_POST['i3']) &&
    !empty($mark) &&
    !empty($kilo) &&
    !empty($niveau) &&
    !empty($chassis) &&
    !empty($name) &&
    !empty($model) &&
    !empty($_FILES['files'])


){
    if(!empty($_POST['t1']) || !empty($_POST['t2']) || !empty($_POST['t3'])){



           
        for($x=0; $x<count($_FILES['files']['name']); $x++){
            $fname=$_FILES['files']['name'][$x];
            $size=$_FILES['files']['size'][$x];
            $type=$_FILES['files']['type'][$x];
            $tmp_name=$_FILES['files']['tmp_name'][$x];
            $maxSize= 3*1024*1024;
            $targetDir = "../../images/upload_images";
            $allowTypes = array('jpg','png','jpeg','JPG','PNG','JPEG');
            if($size>$maxSize){
               header("location: ../../view/addvoiture.php?err=STLA");
               exit;

        
            }elseif(!in_array(pathinfo($fname,PATHINFO_EXTENSION),$allowTypes)){
               header("location: ../../view/addvoiture.php?err=EXNL");
               exit;

            }
        }



  // set voiture property values
  $voiture->imma = $imma;
  $voiture->model = $model;
  $voiture->mark = $mark;
  $voiture->niveau = $niveau;
  $voiture->chassis = $chassis;
  $voiture->kilometrage = $kilo;
  $voiture->cliname = $name;
  $voiture->t1=$t1;
  $voiture->t2=$t2;
  $voiture->t3=$t3;

  $voiture->created_at = date('Y-m-d H:i:s');
if($voiture->checkValability()){


// create the voiture
if($voiture->create()){


  $historique->voiture_imma = $imma;
  $historique->model = $model;
  $historique->mark = $mark;
  $historique->niveau = $niveau;
  $historique->chassis = $chassis;
  $historique->kilometrage = $kilo;
  $historique->cliname = $name;
  $historique->t1=$t1;
  $historique->t2=$t2;
  $historique->t3=$t3;
  $historique->modification_status="premier_visite";

  $historique->created_at = date('Y-m-d H:i:s');

if($historique->create()){
    $his_id=$historique->last_id;
    $voiture->last_his = $his_id;
    if($voiture->updateOnly()){
        //
    }else{
        header("location: ../../view/addvoiture.php?err=HfWaFpsi");
        exit;

    }
}else{
    header("location: ../../view/addvoiture.php?err=HfWaF");
    exit;

}

  for($x=0; $x<count($_FILES['files']['name']); $x++){
    $fname=$_FILES['files']['name'][$x];
    $size=$_FILES['files']['size'][$x];
    $type=$_FILES['files']['type'][$x];
    $tmp_name=$_FILES['files']['tmp_name'][$x];
    $realname = basename($_FILES['files']['name'][$x]);
    $maxSize= 3*1024*1024;
    $targetDir = "images/";
    $allowTypes = array('jpg','png','jpeg','JPG','PNG','JPEG');
    if($size>$maxSize){
       header("location: ../../view/addvoiture.php?err=STLA");
       exit;

    }elseif(!in_array(pathinfo($fname,PATHINFO_EXTENSION),$allowTypes)){
       header("location: ../../view/addvoiture.php?err=EXNL");
       exit;

    }else{

        $extEn=explode('.',$fname);
        $extE=strtolower(end($extEn));
        $newname=uniqid('',true).".".$extE;
        move_uploaded_file($tmp_name,$targetDir.$realname);
        $image->image=$realname;
        $image->voiture_imma=$imma;
        $image->created_at=date('Y-m-d H:i:s');
        if($image->create()){
                    $hisimage->image=$realname;
                    $hisimage->his_id=$his_id;
                    $hisimage->created_at=date('Y-m-d H:i:s');
                    if($hisimage->create()){
                        //
                    }else{
                        header("location: ../../view/addvoiture.php?err=HIfWaF");
                        exit;

                    }
        }else{
            header("location: ../../view/addvoiture.php?err=IfWaF");
            exit;


        }
    }
}





if(!empty($offi)){
$N=count($offi);
for($i=0;$i<$N;$i++){
    $famille->sfam=$offi[$i];
    $famille->fam="offi";
    $famille->voiture_imma=$imma;
    $famille->created_at=date('Y-m-d H:i:s');
if($famille->create()){

        $hisfamille->sfam=$offi[$i];
        $hisfamille->fam="offi";
        $hisfamille->his_id=$his_id;
        $hisfamille->created_at=date('Y-m-d H:i:s');
    if($hisfamille->create()){
        //
    }else{
        header("location: ../../view/addvoiture.php?err=HFfWaF");
        exit;


    }
    

}else{
    header("location: ../../view/addvoiture.php?err=FfWaF");
    exit;

}
}
}




if(!empty($othr)){

    
$N=count($othr);
for($i=0;$i<$N;$i++){
    $famille->sfam=$othr[$i];
    $famille->fam="othr";
    $famille->voiture_imma=$imma;
    $famille->created_at=date('Y-m-d H:i:s');
if($famille->create()){
        $hisfamille->sfam=$othr[$i];
        $hisfamille->fam="othr";
        $hisfamille->his_id=$his_id;
        $hisfamille->created_at=date('Y-m-d H:i:s');
    if($hisfamille->create()){
        //
    }else{
        header("location: ../../view/addvoiture.php?err=HFfWaFF");
        exit;

    }
    
}else{
    header("location: ../../view/addvoiture.php?err=FfWaFF");
    exit;

}
}

}

header("location: read.php?success=VotDon&XzkdltvdAMwcxByCbe=".$his_id);

}


else{
    header("location: ../../view/addvoiture.php?err=CfWaF");
    exit;

}

}else{
    header("location: ../../view/addvoiture.php?err=ImmAExSt");
    exit;


}
    }else{
        header("location: ../../view/addvoiture.php?err=TcHvOd");
        exit;

    }
 
       
}
 
// if voiture data is incomplete
else{
 
 
    header("location: ../../view/addvoiture.php?err=DiNcP");
    exit;

}
}else{
 
    header("location: ../../view/addvoiture.php?err=CkBEpt");
    exit;

}
?>