<?php 
 
// database connection will be here this is just so everyfile can read this ! it'll return data as json format
// including database and voiture file
include_once '../config/database.php';
include_once '../objects/voiture.php';
include_once '../objects/image.php';
include_once '../objects/famille.php';
include_once '../objects/client.php';

include_once '../objects/admin.php';
$database = new Database();
$db = $database->getConnection();
$voiture= new Voiture($db);
$image= new Image($db);
$famille= new Famille($db);
$client= new Client($db);
$immas  = array();

if(isset($_POST['cliname']) && isset($_POST['id'])){
    $cliname = $_POST['cliname'];
    $id = $_POST['id']; 
    
    $client->id = $id;
    $voiture->cliname= $cliname;
    $stmt = $voiture->searchBCName();
    $num = $stmt->rowCount();
    

 // here we added if there is voitures
if($num>0){
 
      

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);

        $immas[]=$imma;

    }


    if($client->delete()){

        foreach($immas as $voi){

            $voiture->imma=$voi;
            $image->voiture_imma=$voi;
            $famille->voiture_imma=$voi;
            if($voiture->delete()){
                if($famille->delete() && $image->delete()){
                    // echo json_encode(array("message" => "everything deleted created."));
                }else{
                    // echo json_encode(array("message" => "famille or image not deleted ."));
                }
            }else{
                // echo json_encode(array("message" => "voiture not deleted."));
            }

        }
       

    }else{
        // echo json_encode(array("message" => "client not deleted."));

    }



   



}else{
    if($client->delete()){
        // echo json_encode(array("message" => "no voiture but client deleted ."));

    }else{
        // echo json_encode(array("message" => "no voiture and not client deleted."));

    }
}


}else{
    echo json_encode(array("message" => "nothing posted"));

}


?>