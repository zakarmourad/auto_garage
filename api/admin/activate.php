<?php

// Start the session
session_start();
if(!isset($_SESSION['_Gtx'])){
    header("location:../../view/login.php");
}
header("Access-Control-Max-Age: 3600");
 
// get database connection
include_once '../config/database.php';
include_once '../objects/admin.php';

 
$database = new Database();
$db = $database->getConnection();
 
$admin = new Admin($db);
$id =  isset($_GET['id']) ? $_GET['id'] : die();

$admin->id = $id;
        if($admin->activate()){
            header("location:read.php?SucD=AcaCt");
        }
     
        else{
            header("location:pending.php?sDXl=ErAct");
            exit;

        }


?>