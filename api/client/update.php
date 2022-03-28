
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
include_once '../objects/client.php';


$database = new Database();
$db = $database->getConnection();
 
$client = new Client($db);


// get posted data on json 
$hidId = $_POST['hidId'];


$tel=$_POST['tel'];
$contact=$_POST['contact'];
$etat=$_POST['etat'];

// make sure data is not empty
if(

    !empty($tel) &&
    !empty($contact) &&
    !empty($etat) &&
    !empty($hidId) 



){





  // set client property values
  $client->id = $hidId;
  $client->etat=$etat;
  $client->contact=$contact;
  $client->tel=$tel;
  $client->updated_at = date('Y-m-d H:i:s');

// create the client
if($client->update()){

header("location: read.php?sCs=uPd");

}

else{
    header("location: ../../view/updateClient.php?err=CFNW&id=".$hidId);
    exit;

}
    }else{
        header("location: ../../view/updateClient.php?err=EmDHs&id=".$hidId);
        exit;

    }
 
?>