<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here this is just so everyfile can read this ! it'll return data as json format
// including database and historique file
include_once '../config/database.php';
include_once '../objects/voiture.php';
 
// initiate database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize the historique
$voiture = new Voiture($db);
// query historique , we used read function so we don't repeat it  
$voiture->cliname = isset($_GET['id']) ? $_GET['id'] : die();

$stmt = $voiture->searchbv();
$num = $stmt->rowCount();
 // here we added if there is historiques
if($num>0){
 
    // historiques array
   
 $his="<table class=' gfg bg-light'><thead><tr><th>ordre</th><th >Immatriculation</th><th >Client</th> <th >chassis</th>      <th >Date </th> <th>Plus</th>   </tr></thead><tbody>";
 $i=1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $dat =date('Y/m/d ',strtotime($created_at));
 $his.="  <tr><td>$i</td> <td class='prf' > $imma</td>
              <td>$cliname</td>
              <td>$chassis</td>
              <td>$dat</td>
              <td><a href='../../view/update.php?id=$imma' class='btn more' style='color:white;background-color: #E1B72A;'
              ><img style='width:20px;height:auto;color:white;' src='../../images/more.svg' alt='...' /></a></td>
            </tr>";


$i=$i+1;
    }
    $his.="       
</tbody>
</table>";

    http_response_code(200);
    $ar=array(
        "his" =>$his
    );

    // show historiques data in json format so we can retrieve it later with react js
    echo json_encode($ar);
}
// if no historiques found it will set a 404 error  for json so that no historiques has been found in our database
else{
    $his="Ce client n'a aucune voiture enregistrée";
    $ar=array(
        "his" =>$his
    );
    echo json_encode($ar);

}