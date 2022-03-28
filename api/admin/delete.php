<?php 
 
// database connection will be here this is just so everyfile can read this ! it'll return data as json format
// including database and voiture file
include_once '../config/database.php';


include_once '../objects/admin.php';
$database = new Database();
$db = $database->getConnection();
$admin= new Admin($db);

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $admin->id=$id;
    if($admin->delete()){
     // done
    }else{
        // echo "naah";
    }



}else{
    // echo "ulnaah";
}





?>