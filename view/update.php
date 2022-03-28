<?php
// Start the session
session_start();
if(!isset($_SESSION['_Gtx'])){
    header("location:login.php");
}
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

 
include_once '../api/config/database.php';
include_once '../api/objects/voiture.php';
include_once '../api/objects/image.php';
include_once '../api/objects/famille.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
$voiture = new Voiture($db);
$famille = new Famille($db);
$image = new Image($db);
if(isset($_GET['id'])){
    $_GET['id']=trim($_GET['id']);
}

// here we used the voiture_id to search for a voiture
$voiture->imma = isset($_GET['id']) ? trim($_GET['id']) : die();

$famille->voiture_imma=isset($_GET['id']) ? trim($_GET['id']) : die();
$image->voiture_imma=isset($_GET['id']) ? trim($_GET['id']) : die();

$voiture->search();
$stm1=$famille->readAll();
$stm2=$image->readAll();


$num1 = $stm1->rowCount();
$num2 = $stm2->rowCount();

if($voiture->cliname!=null && $num1>0){

$images=array();
$othr=array();
$offi=array();


    while ($row = $stm1->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
            if($fam == "offi"){
                    $offi[]=$sfam;
            }
            if($fam == "othr"){
                $othr[]=$sfam;
        }
        
    }

    while ($row = $stm2->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
 
       $images[]=$image;
    }
    // create array
 
 $matricules=   explode("-",$voiture->imma);
    $voitures = array(
        "imma" =>  $voiture->imma,
        "cliname" => $voiture->cliname,
        "mark" => $voiture->mark,
        "model" => $voiture->model,
        "kilometrage" => $voiture->kilometrage,
        "chassis" => $voiture->chassis,
        "niveau" => $voiture->niveau,
        "images"=>$images,
        "offi"=>$offi,
        "othr"=>$othr,
        "t1" => $voiture->t1,
        "t2" => $voiture->t2,
        "t3" => $voiture->t3,
        "last_his" => $voiture->last_his,
        "created_at" => $voiture->created_at,
        "updated_at" => $voiture->updated_at

 
    );
 
}
 
else{
    $matricules=  [ "0", "0", "0"];

  //header not found page ! 
  $voitures = array(
    "imma" =>  "Introuvable",
    "cliname" => "Introuvable",
    "mark" => "Introuvable",
    "model" => "Introuvable",
    "kilometrage" => "Introuvable",
    "chassis" => "Introuvable",
    "niveau" => "Introuvable",
    "t1" =>"Introuvable",
    "t2" => "Introuvable",
    "t3" => "Introuvable",
    "last_his" =>  "Introuvable",

    "images"=>[],
    "offi"=>["introuvable"],
    "othr"=>["introuvable"],
    "created_at" => "introuvable",
    "updated_at" => "introuvable"        
);
$errors = "Les données de cette historique sont corrompues! Contactez Votre administrateur pour fixer ce problème.";

}
$officials=array();
$others=array();
?>
<?php


include_once '../api/objects/client.php';
 
// initiate database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize the client
$client = new Client($db);


// database connection will be here this is just so everyfile can read this ! it'll return data as json format
// including database and voiture file
include_once '../api/objects/admin.php';

// initiate database connection
$database = new Database();
$db = $database->getConnection();
$admin= new Admin($db);
if(isset($_SESSION['_Gtx'])){

    $admin->id= $_SESSION['_Gtx'];
 if($admin->search()){
     $_SESSION['_DLcp']=$admin->username;
     $_SESSION['_xlQm']=$admin->email;

 }
}else{
  header("location:login.php");

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier Une voiture</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="update.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <style>
    .thumb {
        height: 100px;
        border: 1px solid #000;
        margin: 10px 5px 0 0;
    }

    #second-fm {
        display: none;
    }
    </style>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>

</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <ul class="list-unstyled components">
                <p>
                    <pre></pre>
                </p>
                <li class="ksdb">
                    <a href="addvoiture.php">Ajouter une voiture</a>
                </li>
                <li class="ksdb1">
                    <a href="../api/voiture/read.php"> Liste des voitures</a>
                </li>
                <li class="ksdb2">
                    <a href="addclient.php">Ajouter un client</a>
                </li>
                <li class="ksdb3">
                    <a href="../api/client/read.php">Liste des clients</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">



            <nav class="navbar navbar-expand-sm navbar-white bg-white no-shadow dmr">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info f">
                        <i class="fas fa-align-left"></i>
                        <span></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                            <li class="nav-item"><img src="../images/bg/Groupe 5.png" alt="profile">
                            </li>
                            <li class="nav-item dropdown ">

                                <a class="nav-link dropdown-toggle bsdf  " href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php     if(isset( $_SESSION['_DLcp'])){echo  $_SESSION['_DLcp']; }else{
            echo "Votre Profile";
        } ?> </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" data-toggle="modal" data-target="#exampleModalCenter"
                                        href="#">Voir Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item cdc" href="/project/api/admin/logout.php">Deconnexion</a>
                                </div>
                                <!-- Button trigger modal -->


                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content">

                                            <div class="modal-body">
                                                <div class="row ">
                                                    <div class="col-md-2">
                                                        <img src="../images/bg/Groupe 5.png" class="prof" alt="prof">
                                                    </div>
                                                    <div class="col-md-8 offset-md-1  justify-content-md-center">
                                                        <div class="row ">
                                                            <div class="col cdl">
                                                                <span class="nr"> <?php echo $admin->username;?> </span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <span class="kr"> <?php echo $admin->etat;?> </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <pre></pre>
                                                <br>
                                                <form>
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <input type="text" class="form-control prp"
                                                                placeholder="<?php echo $admin->email;?>" disabled>
                                                            <br>

                                                        </div>

                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <input type="text" class="form-control prp"
                                                            placeholder="<?php echo $admin->phone;?>" disabled>
                                                            <br>
                                                        </div>

                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <a href="addmin.php"
                                                                class="btn btn-outline-warning  btn-block">Ajouter un
                                                                utilisateur </a>
                                                            <pre></pre>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <a href="../api/admin/pending.php"
                                                                class="btn btn-outline-danger  btn-block">Activer un
                                                                utilisateur </a>
                                                            <pre></pre>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                            <button type="button" class="btn jgl btn-block"><a href="../api/admin/read.php">Liste des Utilisateurs</a></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="smrt">


                <div class="row ping">
                
                    <div class="col-9">
                        <h3> &nbsp;Modifier Une Voiture</h3>

                    </div>

                </div>
                <div class="row fling">
                    <h3><br> Modifier Une Voiture</h3>
                </div>
                <br>

                <div class="xan">
<?php if(isset($_GET['err']) && $_GET['err'] == 'FTMC' ) { echo "<span style='color:red;'>La taille de l'image dépasse la taille maximale autorisée 3Mo.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'EXNA' )  { echo "<span style='color:red;'>Vous pouvez ajouter  uniquement des images.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'HSFW' )  { echo "<span style='color:red;'>Erreur lors l'ajout du voiture au historique.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'HSIMW' )  { echo "<span style='color:red;'>Image non ajoutée dans l'historique.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'IMFW' )  { echo "<span style='color:red;'>Image non modifiée.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'famEMP' )  { echo "<span style='color:red;'>Les données de la demande du client sont vides.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'HFamFw' )  { echo "<span style='color:red;'>Erreur lors l'ajout de la demande du client au historique.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'FamFw' )  { echo "<span style='color:red;'>Veuillez verifier les données de la demande du client.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'FamFWw' )  { echo "<span style='color:red;'>Veuillez verifier les données de la demande du client.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'HFamFWw' )  { echo "<span style='color:red;'>Erreur lors l'ajout de la demande du client au historique.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'CFNW' )  { echo "<span style='color:red;'>Erreur lors la modification du voiture.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'TEVD' )  { echo "<span style='color:red;'>Veuillez verifier les données des techniciens.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'EMVOI' )  { echo "<span style='color:red;'>Veuillez remplir tous les champs nécessaires.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'ChkBeM' )  { echo "<span style='color:red;'> les données de la demande du client sont vides.</span>";} ?>



<?php if(isset($_GET['err'])){echo "<br><span style='color:red;'>N'oubliez pas de vérifier/modifier les données Erronées , ainsi de vérfier les nouveaux données entrées dans la liste des voitures.</span>";}?>
<?php if(isset($errors) && $errors != null){
                    echo "<span style='color:red;'>".$errors."</span>";
                } ?>
                    <form action="../api/voiture/update.php" method="post" enctype="multipart/form-data">
                        <div id="first-fm">
                            <input type="hidden" name="hidId" value="<?php if(isset($_GET['id'])){ echo $_GET['id'];} ?>"/>
                            <input type="hidden" name="hisId" value="<?php echo $voitures["last_his"]; ?>"/>

                            <section class="first-sec container">
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Client</label>

                                    </div>
                                    <div class="col">
                                        <?php
echo '<select name="cli">'; // Open your drop down box
echo '<option value="'.$voitures["cliname"].'" selected>'.$voitures["cliname"].'</option>';

$stmt = $client->list();
$num = $stmt->rowCount();
// here we added if there is clients
if($num>0){

  $key=1;
      

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
   
    extract($row);

if($name == $voitures["cliname"]){
    //
}else{
    echo '<option value="'.$name.'">'.$name.'</option>';

}
    


}

}
// if no clients found it will set a 404 error  for json so that no clients has been found in our database
else{
echo '<option value="void">Liste Vide</option>';
}

?></select>
                                    </div>
                                </div>


                                <div class="row dolr">
                                    <div class="col">
                                        <label>N°Chassis</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="darpi" value="<?php echo $voitures["chassis"];?>" name="chassis" placeholder="N°Chassis" required>
                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Marque</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="darpi" value="<?php echo $voitures["mark"];?>" name="mark" placeholder="Marque" required>
                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Model</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="darpi" value="<?php echo $voitures["model"];?>" name="model" placeholder="Model" required>

                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Immatricule</label>

                                    </div>
                                    <div class="col">
                                        <span>
                                            <input type="text" class="i1 darpi" value="<?php echo $matricules[0]; ?>" name="i1" placeholder="ex: 15" disabled>
                                            <input type="text" class="i2 darpi" value="<?php echo $matricules[1]; ?>" name="i2" placeholder="ex: A" disabled>
                                            <input type="text" class="i3 darpi" value="<?php echo $matricules[2]; ?>" name="i3" placeholder="ex: 1533" disabled>
                                        </span>
                                    </div>
                                </div>



                                <div class="row dolr">
                                    <div class="col">
                                        <label>Kilométrage</label>
                                    </div>
                                    <div class="col">
                                        <span style="display:inline"><input type="number" value="<?php echo $voitures["kilometrage"];?>" class="darpi" name="kilo"
                                                placeholder="Kilométrage" required> km</span>

                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Niveau </label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="darpi" value="<?php echo $voitures["niveau"];?>" name="niveau" placeholder="Ex : 1/3" required>

                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col">
                                        <label>Raison de Modification </label>
                                    </div>
                                    <div class="col">
                                    <div class="row">
                                    <div class="col"> <label><input type="radio" name="reason" 
                                     value="modification">&nbsp;<span style="font-size: 1rem;
    line-height: 1.5;
    color: #212529;"><b>Modification</b></span><br></label> </div>
                                    <div class="col"> <label><input type="radio" name="reason" checked
                                            value="new_visite">&nbsp;<span style="font-size: 1rem;
    line-height: 1.5;
    color: #212529;"><b>Nouvelle Visite</b></span><br></label></div>
                                </div>
                                    </div>
                                </div>

                            </section>
                            <section class="second-sec">
                                <div><span>Etat de véhicule sans démontage</span></div>

                                <div> <label><i class="fas fa-plus-circle"></i>Ajouter des Images<input type="file"
                                            onChange="failt()" id="files" name="files[]" accept="image/*"
                                            multiple></label></div>
                                <div><output id="list"><?php 
                                                                  for($x=0; $x<count($voitures['images']); $x++){

                                
                                echo '<img class="thumb"    src="../api/voiture/images/'.$voitures['images'][$x].'" onclick="shw(\''.$voitures["images"][$x].'\')" title="'.$voitures['images'][$x].'" /> ';
                                
                                
                                                                  }
                                ?></output></div>
                            </section>
                            <section class="third-sec">
                                <div><span>Véhicule réparé par</span></div>
                                <input type="text" name="t1" value="<?php echo $voitures["t1"];?>" placeholder=" Technicien 1">
                                <input type="text" name="t2" value="<?php echo $voitures["t2"];?>" placeholder=" Technicien 2">
                                <input type="text" name="t3" value="<?php echo $voitures["t3"];?>" placeholder=" Technicien 3">
                            </section>
                            <section class="sixth-sec">
                                <button type="button" class="btn btn-outline-warning  btn-block" id="next-1">Demande de Client <span
                                        style="font-size:2Opx"><b>==></b></span></button>

                            </section>
                        </div>

                        <div id="second-fm">
                            <div class="fourth-sec">
                                <h4>Fréquemment Demandé:</h4>
                                <div class="row">

                       <?php    for($x=0; $x<count($voitures['offi']); $x++){

                                        $officials[]=$voitures['offi'][$x];
                                            }
                                            for($x=0; $x<count($voitures['othr']); $x++){

                                                $others[]=$voitures['othr'][$x];
                                                    }
                                    ?>      
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                             <?php if(in_array("REVISION",$officials)) echo "checked"; ?>   value="REVISION">&nbsp;REVISION<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("VIDANGE MOTEUR",$officials)) echo "checked"; ?>           value="VIDANGE MOTEUR">&nbsp;VIDANGE MOTEUR<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("FILTRE A HUILE",$officials)) echo "checked"; ?>        value="FILTRE A HUILE">&nbsp;FILTRE A HUILE<br></label></div>
                                    <div class="col"><label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("FILTRE A AIR",$officials)) echo "checked"; ?>      value="FILTRE A AIR">&nbsp;FILTRE A AIR<br></label> </div>
                                    <div class="col"><label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("FILTRE A GASOIL",$officials)) echo "checked"; ?>       value="FILTRE A GASOIL">&nbsp;FILTRE A GASOIL<br></label> </div>


                                </div>
                                <div class="row">
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("HUILE DE DIRECTION",$officials)) echo "checked"; ?>        value="HUILE DE DIRECTION">&nbsp;HUILE DE DIRECTION<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("HUILE DE BOITE A VITESSE",$officials)) echo "checked"; ?>        value="HUILE DE BOITE A VITESSE">&nbsp;HUILE DE BOITE A
                                            VITESSE<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("FILTRE A ESSENCE",$officials)) echo "checked"; ?>         value="FILTRE A ESSENCE">&nbsp;FILTRE A ESSENCE<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("FILTRE A POILEN",$officials)) echo "checked"; ?>     value="FILTRE A POILEN">&nbsp;FILTRE A POILEN<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("PLAQUETTE DE FREIN AV",$officials)) echo "checked"; ?>     value="PLAQUETTE DE FREIN AV">&nbsp;PLAQUETTE DE FREIN AV<br></label>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("PLAQUTTE DE FREIN ARR",$officials)) echo "checked"; ?>     value="PLAQUTTE DE FREIN ARR">&nbsp;PLAQUTTE DE FREIN ARR<br></label>
                                    </div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("HUILE DE FREINS",$officials)) echo "checked"; ?>     value="HUILE DE FREINS">&nbsp;HUILE DE FREINS<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("DIAGNOSTIC",$officials)) echo "checked"; ?>     value="DIAGNOSTIC">&nbsp;DIAGNOSTIC<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("CONTROLE GENERALE",$officials)) echo "checked"; ?>    value="CONTROLE GENERALE">&nbsp;CONTROLE GENERALE<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("CHANGEMENT PNEU",$officials)) echo "checked"; ?>    value="CHANGEMENT PNEU">&nbsp;CHANGEMENT PNEU<br></label></div>


                                </div>
                                <div class="row">
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("EQUILIBRAGE",$officials)) echo "checked"; ?>     value="EQUILIBRAGE">&nbsp;EQUILIBRAGE<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("PARALLELISME",$officials)) echo "checked"; ?>   value="PARALLELISME">&nbsp;PARALLELISME<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("FILTRE A CLIM",$officials)) echo "checked"; ?>       value="FILTRE A CLIM">&nbsp;FILTRE A CLIM<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="offi[]"
                                    <?php if(in_array("CHANGEMENT COURRALE",$officials)) echo "checked"; ?>     value="CHANGEMENT COURRALE">&nbsp;CHANGEMENT COURRALE<br></label> </div>

                                    <div class="col"> </div>

                                </div>



                            </div>
                            <div class="fifth-sec">
                                <h4>Autres:</h4>
                                <div class="row">
                                 
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("COURROIE D'ALTERNATEUR",$others)) echo "checked"; ?>      value="COURROIE D'ALTERNATEUR">&nbsp;COURROIE D'ALTERNATEUR<br></label>
                                    </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("COURROIE DE DISTRIBUTION",$others)) echo "checked"; ?>      value="COURROIE DE DISTRIBUTION">&nbsp;COURROIE DE
                                            DISTRIBUTION<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("POULIE",$others)) echo "checked"; ?>     value="POULIE">&nbsp;POULIE<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("ANTIGEL",$others)) echo "checked"; ?>      value="ANTIGEL">&nbsp;ANTIGEL<br></label> </div>

                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("DISQUE DE FREIN AV",$others)) echo "checked"; ?>     value="DISQUE DE FREIN AV">&nbsp;DISQUE DE FREIN AV<br></label> </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("DISQUE DE FREIN ARR",$others)) echo "checked"; ?>     value="DISQUE DE FREIN ARR">&nbsp;DISQUE DE FREIN ARR<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("LAVE GLACE",$others)) echo "checked"; ?>    value="LAVE GLACE">&nbsp;LAVE GLACE<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("ADDITIFS",$others)) echo "checked"; ?>    value="ADDITIFS">&nbsp;ADDITIFS<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("MICHELIN",$others)) echo "checked"; ?>      value="MICHELIN">&nbsp;MICHELIN<br></label></div>
                                    
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("AMORTISSEUR ARR",$others)) echo "checked"; ?>     value="AMORTISSEUR ARR">&nbsp;AMORTISSEUR ARR<br></label> </div>
                                </div>
                                <div class="row">
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("EAU DEMINIRALISEE",$others)) echo "checked"; ?>    value="EAU DEMINIRALISEE">&nbsp;EAU DEMINIRALISEE<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("HANKOOK",$others)) echo "checked"; ?>     value="HANKOOK">&nbsp;HANKOOK<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("BARUM",$others)) echo "checked"; ?>      value="BARUM">&nbsp;BARUM<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("AMORTISSEUR AV",$others)) echo "checked"; ?>      value="AMORTISSEUR AV">&nbsp;AMORTISSEUR AV<br></label> </div>
                    
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("BUTEE",$others)) echo "checked"; ?>      value="BUTEE">&nbsp;BUTEE<br></label></div>
                                </div>
                                <div class="row">
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("POMPE D'EMBRAYAGE",$others)) echo "checked"; ?>    value="POMPE D'EMBRAYAGE">&nbsp;POMPE D'EMBRAYAGE<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("DETECTEUR",$others)) echo "checked"; ?>     value="DETECTEUR">&nbsp;DETECTEUR<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("RECEPTEUR D'EMBRAYAGE",$others)) echo "checked"; ?>     value="RECEPTEUR D'EMBRAYAGE">&nbsp;RECEPTEUR D'EMBRAYAGE<br></label>
                                    </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("PITLAS",$others)) echo "checked"; ?>     value="PITLAS">&nbsp;PITLAS<br></label> </div>
                       
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("URANIA",$others)) echo "checked"; ?>      value="URANIA">&nbsp;URANIA<br></label></div>

                                </div>
                                <div class="row">
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("SERVICE LASSA",$others)) echo "checked"; ?>     value="SERVICE LASSA">&nbsp;SERVICE LASSA<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("POMPE A EAU",$others)) echo "checked"; ?>     value="POMPE A EAU">&nbsp;POMPE A EAU<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("POMPE HAUTE PRESSION",$others)) echo "checked"; ?>     value="POMPE HAUTE PRESSION">&nbsp;POMPE HAUTE PRESSION<br></label>
                                    </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("ACIDE",$others)) echo "checked"; ?>      value="ACIDE ">&nbsp;ACIDE <br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("DISQUE D'EMBRAYAGE",$others)) echo "checked"; ?>     value="DISQUE D'EMBRAYAGE">&nbsp;DISQUE D'EMBRAYAGE<br></label></div>

                                </div>
                                <div class="row">
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("COURROIE D'ENTRENEMENT",$others)) echo "checked"; ?>        value="COURROIE D'ENTRENEMENT">&nbsp;COURROIE D'ENTRENEMENT<br></label>
                                    </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("ESSUI GLACE",$others)) echo "checked"; ?>    value="ESSUI GLACE">&nbsp;ESSUI GLACE<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("TORNAGE DISQUE",$others)) echo "checked"; ?>      value="TORNAGE DISQUE">&nbsp;TORNAGE DISQUE<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("INTERRUPTEUR",$others)) echo "checked"; ?>       value="INTERRUPTEUR">&nbsp;INTERRUPTEUR<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("ROTULE",$others)) echo "checked"; ?>     value="ROTULE">&nbsp;ROTULE<br></label> </div>

                                </div>
                                <div class="row">
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("HUILE DE DIRECTION",$others)) echo "checked"; ?>      value="HUILE DE DIRECTION">&nbsp;HUILE DE DIRECTION<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("CYLINDRE DE FREIN",$others)) echo "checked"; ?>      value="CYLINDRE DE FREIN">&nbsp;CYLINDRE DE FREIN<br></label></div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("BRIDGESTONE",$others)) echo "checked"; ?>     value="BRIDGESTONE">&nbsp;BRIDGESTONE<br></label> </div>
                                    <div class="col"> <label><input type="checkbox" name="othr[]"
                                    <?php if(in_array("TUBE",$others)) echo "checked"; ?>     value="TUBE">&nbsp;TUBE<br></label> </div>
                                    <div class="col"> </div>

                                </div>

                            </div>

                            <div class="row bgc">
                                <button type="button" class="btn btn-outline-warning  btn-block" id="pre-1">
                                        <span style="font-size:2Opx"><b>
                                                <==</b></span> Données du voiture</button>
                                                
         
                            </div>
                            <?php if(!isset($errors) || $errors == null){
 echo "<div class='row bgc'>

    <input class='btn btn-outline-success btn-block' type='submit'
    value='Modifier La Voiture'></div>
    ";
                } ?>


                        </div>



                    </form>





                </div>
            </div>

        </div>
    </div>

    <div class="overlay"></div>










    <script type="text/javascript">
    $(document).ready(function() {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function() {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });


    });
    </script>


<script>
                            function shw(src){
                                var rc = src;
                                Swal.fire({

  padding: '1em',

  imageUrl: '../api/voiture/images/'+rc,
  imageWidth: 2000,
  imageAlt: 'voiture',
  animation: false,
  showConfirmButton: false,

})
                            }
                            
                            </script>

    <script>
    $(document).ready(function() {

        $("#next-1").click(function(e) {
            e.preventDefault();
            $("#first-fm").hide();
            $("#next-1").hide();
            $("#second-fm").show();

        })

        $("#pre-1").click(function(e) {
            e.preventDefault();
            $("#next-1").show();

            $("#first-fm").show();
            $("#second-fm").hide();

        })

    })
    </script>
    <script>
    function failt() {
        //submit the form here
        var inp = document.getElementById('files');
        if (inp.files.length > 4) {
            alert("Vous ne pouvez pas télécharger plus de 4 images!");
            inp.value = null;
        }


        var allowed_extensions = new Array("jpg", "png", "jpeg");
        var file_extension = inp.value.split('.').pop()
            .toLowerCase(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.


        if (allowed_extensions[0] == file_extension || allowed_extensions[1] == file_extension || allowed_extensions[
                2] == file_extension) {
            return true; // valid file extension
        } else {
            if(inp.files.length < 1){
                inp.value = null;

            }else{
                alert("Vous ne pouvez télécharger que des images");
            inp.value = null;
            }
        }



    };
    //  document.getElementById("file").onchange = function () {
    //     var reader = new FileReader();

    //     reader.onload = function (e) {
    //         // get loaded data and render thumbnail.
    //         document.getElementById("image").src = e.target.result;
    //     };

    //     // read the image file as a data URL.
    //     reader.readAsDataURL(this.files[0]);
    // };


    function handleFileSelect(evt) {
        var files = evt.target.files; // FileList object

        var e = document.getElementById("list");

        if (document.body.contains(document.getElementById('list'))) {
            var child = e.lastElementChild;
            while (child) {
                e.removeChild(child);
                child = e.lastElementChild;
            }
        }

        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // Render thumbnail.
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="thumb"   src="', e.target.result,
                        '" title="', escape(theFile.name), '"/>'
                    ].join('');
                    document.getElementById('list').insertBefore(span, null);
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    }

    document.getElementById('files').addEventListener('change', handleFileSelect, false);
    </script>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>
    <!-- jQuery Custom Scroller CDN -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js">
    </script>

</body>

</html>