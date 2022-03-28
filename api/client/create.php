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
include_once '../objects/client.php';

 
$database = new Database();
$db = $database->getConnection();
 
$client = new Client($db);
 
// get posted data on json 


$tel=$_POST['tel'];
$contact=$_POST['contact'];
$name=$_POST['name'];
$etat=$_POST['etat'];

// make sure data is not empty
if(
    
    !empty($etat) &&
    !empty($contact) &&
    !empty($name) &&
    !empty($tel) 


){
 
         // set client property values
 
        $client->tel = $tel;
        $client->name = $name;
        $client->contact = $contact;
        $client->etat= $etat;
        $client->created_at = date('Y-m-d H:i:s');
     
        if($client->checkValability()){

     
            // create the client
        if($client->create()){
 
            header("location:read.php");
        }
 
        else{
            header("location: ../../view/addclient.php?err=CfW");
            exit;

        }
    }else{
        header("location: ../../view/addclient.php?err=CnMeAxSt");
        exit;

    }
}
 
// if client data is incomplete
else{
 
 
    header("location: ../../view/addclient.php?err=cDiC");  exit;

}
?>