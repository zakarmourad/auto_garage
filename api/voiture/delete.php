<?php 
 
// database connection will be here this is just so everyfile can read this ! it'll return data as json format
// including database and voiture file
include_once '../config/database.php';
include_once '../objects/voiture.php';
include_once '../objects/image.php';
include_once '../objects/famille.php';

include_once '../objects/admin.php';
$database = new Database();
$db = $database->getConnection();
$voiture= new Voiture($db);
$image= new Image($db);
$famille= new Famille($db);

if(isset($_POST['imma'])){
    $imma = $_POST['imma'];

    $voiture->imma=$imma;
    $image->voiture_imma=$imma;
    $famille->voiture_imma=$imma;
    if($voiture->delete()){
        if($famille->delete() && $image->delete()){
            // echo "yay";
        }else{
            // echo " naaaaaaah";
        }
    }else{
        // echo "naah";
    }



}else{
    // echo "ultra naah";
}





?>