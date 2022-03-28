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
$hidId = $_POST['hidId'];
$hisId = $_POST['hisId'];

$othr=$_POST['othr'];
$offi=$_POST['offi'];

$imma=$_POST['hidId'];
$mark=$_POST['mark'];
$model=$_POST['model'];
$chassis=$_POST['chassis'];
$name=$_POST['cli'];
$kilo=$_POST['kilo'];
$niveau=$_POST['niveau'];
$t1=$_POST['t1'];
$t2=$_POST['t2'];
$t3=$_POST['t3'];
$reason=$_POST['reason'];

if(!empty($othr) || !empty($offi)){



// make sure data is not empty
if(

    !empty($mark) &&
    !empty($kilo) &&
    !empty($niveau) &&
    !empty($chassis) &&
    !empty($name) &&
    !empty($model) &&
    !empty($_FILES['files'])&&
    !empty($hidId) 



){
    if(!empty($_POST['t1']) || !empty($_POST['t2']) || !empty($_POST['t3'])){



           
        for($x=0; $x<count($_FILES['files']['name']); $x++){
            $fname=basename($_FILES['files']['name'][$x]);
            $size=$_FILES['files']['size'][$x];
            $type=$_FILES['files']['type'][$x];
            $tmp_name=$_FILES['files']['tmp_name'][$x];
            $maxSize= 3*1024*1024;
            $targetDir = "images/";
            $allowTypes = array('jpg','png','jpeg','JPG','PNG','JPEG');
            if($size>$maxSize){
               header("location: ../../view/update.php?err=FTMC&id=".$hidId);
               exit;

        
            }elseif(!in_array(pathinfo($fname,PATHINFO_EXTENSION),$allowTypes)){
               header("location: ../../view/update.php?err=EXNA&id=".$hidId);
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

  $voiture->updated_at = date('Y-m-d H:i:s');

// create the voiture
if($voiture->update()){


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
  $historique->modification_status = $reason;
  $historique->created_at = date('Y-m-d H:i:s');



if($reason == "modification"){
    $historique->id = $hisId;
    if($historique->updating()){
//works
    }else{
        header("location: ../../view/update.php?err=HSFWCorNw&id=".$hidId);
        exit;

    }


}elseif($reason == "new_visite"){


if($historique->create()){
    $hisId=$historique->last_id;
    $voiture->last_his = $hisId;
    if($voiture->updateOnly()){
        //
    }else{
        header("location: ../../view/update.php?err=HfWaFpsi&id=".$hidId);
        exit;

    }
}else{
    header("location: ../../view/update.php?err=HSFW&id=".$hidId);
    exit;

}
}else{
    header("location: ../../view/update.php?err=HSReaIv&id=".$hidId);
    exit;

}

$image->voiture_imma=$imma;
if($_FILES['files']['name'][0]=='')
{
    //No file selected

}else{
    $image->delete();
   // DELETE IF REASON IS MODIFIED THEN WE CREATE NEW IMAGE FOR THE SAME ONE HEHE LMAO EASY BUT CONSIDER IF HE DIDN'T CHANGE AT ALL SO I WON'T MESS IT UP :) 
   if($reason == "modification"){
    $hisimage->his_id=$hisId;

       $hisimage->delete();
   }

}

  for($x=0; $x<count($_FILES['files']['name']); $x++){
    $fname=basename($_FILES['files']['name'][$x]);
    $size=$_FILES['files']['size'][$x];
    $type=$_FILES['files']['type'][$x];
    $tmp_name=$_FILES['files']['tmp_name'][$x];
    $maxSize= 3*1024*1024;
    $targetDir = "images/";
            $allowTypes = array('jpg','png','jpeg','JPG','PNG','JPEG');
    if($size>$maxSize){
        header("location: ../../view/update.php?err=FTMC&id=".$hidId);
        exit;


    }elseif(!in_array(pathinfo($fname,PATHINFO_EXTENSION),$allowTypes)){
       header("location: ../../view/update.php?err=EXNA&id=".$hidId);
       exit;

    }else{

        
        $newname=$fname;
        move_uploaded_file($tmp_name,$targetDir.$newname);
        $image->image=$newname;
        $image->voiture_imma=$imma;
        $image->created_at=date('Y-m-d H:i:s');
        if($image->create()){

                    $hisimage->image=$newname;
                    $hisimage->his_id=$hisId;
                    $hisimage->created_at=date('Y-m-d H:i:s');
                    if($hisimage->create()){

                    }else{
                        header("location: ../../view/update.php?err=HSIMW&id=".$hidId);
                        exit;

                    }
                
            
            




        }else{
            header("location: ../../view/update.php?err=IMFW&&id=".$hidId);
            exit;


        }
    }
}




if(!empty($offi) || !empty($othr)){
$famille->voiture_imma=$imma;
$famille->delete();
// DELETE his IF REASON IS MODIFIED THEN WE CREATE NEW IMAGE FOR THE SAME ONE
if($reason == "modification"){
    $hisfamille->his_id=$hisId;
    $hisfamille->delete();
}
}else{
    header("location: ../../view/update.php?err=famEMP&id=".$hidId);
    exit;


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
        $hisfamille->his_id=$hisId;
        $hisfamille->created_at=date('Y-m-d H:i:s');
    if($hisfamille->create()){
        //
    }else{
        header("location: ../../view/update.php?err=HFamFw&id=".$hidId);
        exit;


    }
    

}else{
    header("location: ../../view/update.php?err=FamFw&id=".$hidId);
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
        $hisfamille->his_id=$hisId;
        $hisfamille->created_at=date('Y-m-d H:i:s');
    if($hisfamille->create()){
        
    }else{
        header("location: ../../view/update.php?err=HFamFWw&id=".$hidId);
        exit;


    }
    
}else{
    header("location: ../../view/update.php?err=FamFWw&id=".$hidId);
    exit;


}
}

}


header("location: read.php?sCs=uPd&d=".$reason."&ddo=".$hisId);

}

else{
    header("location: ../../view/update.php?err=CFNW&id=".$hidId);
    exit;

}
    }else{
        header("location: ../../view/update.php?err=TEVD&id=".$hidId);
        exit;

    }
 
       
}
 
// if voiture data is incomplete
else{
 
 
    header("location: ../../view/update.php?err=EMVOI&id=".$hidId);
    exit;

}
}else{
 
 
    header("location: ../../view/update.php?err=ChkBeM&id=".$hidId);
    exit;

}
?>