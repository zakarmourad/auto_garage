<?php

// Start the session
session_start();

// required headers
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../objects/admin.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$admin = new Admin($db);
 /*
// here we used the admin_id to search for a admin
$admin->id = isset($_GET['id']) ? $_GET['id'] : die();
 */

$admin->username = $_POST['username'];
$cne_exists = $admin->searchEmail();
$password_exists = $admin->verifyPass($_POST['password'],$admin->password);
echo '<script>';
  echo 'console.log('. $cne_exists .')';
  echo '</script>';
if($cne_exists && $password_exists ){
    $_SESSION["_Gtx"] = $admin->id;
    if($admin->etat == "admin"){
        $_SESSION["_AdMs"]=$admin->etat;
    }
    header("location: ../voiture/read.php");
}
 
else{
    header("location:../../view/login.php?crdn=erE");
    exit;

}
?>