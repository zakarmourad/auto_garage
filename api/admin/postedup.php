<?php

// Start the session
session_start();
if(!isset($_SESSION['_Gtx'])){
    header("location:../../view/login.php");
}
// required headers
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
include_once '../objects/admin.php';

 
$database = new Database();
$db = $database->getConnection();
 
$admin = new Admin($db);
$email=$_POST['em'];
$phone=$_POST['tel'];
$etat=$_POST['gridRadios'];
$password=$_POST['p1'];
$p2=$_POST['p2'];
$id = $_POST['TheID'];
// make sure data is not empty
if(
    !empty($password) &&
    !empty($email) &&
    !empty($p2)&&
    !empty($etat)&&
    !empty($phone)


){
    if($p2 == $password){

   
 $password=password_hash($password,PASSWORD_DEFAULT);
         // set admin property values
         $admin->id = $id;

        $admin->email = $email;
        $admin->etat = $etat;
        $admin->phone = $phone;
        $admin->password = $password;
             // create the admin
        echo $_POST['TheID'];
        echo $etat;
        echo $phone;
        echo $password;
        echo $email;
        if($admin->update()){
            header("location:read.php");
        }
     
        else{
            header("location:../../view/moadmin.php?sDXl=ErCrtd&id=".$_POST['TheID']);
            exit;

        }
     
   
}

else{
    header("location:../../view/moadmin.php?sDXl=ErCp");
    exit;

}
}
// if admin data is incomplete
else{
 
 
header("location:../../view/moadmin.php?sDXl=ErDinC");
exit;

}
?>