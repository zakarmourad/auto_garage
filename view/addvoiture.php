<?php
// Start the session
session_start();
if(!isset($_SESSION['_Gtx'])){
    header("location:login.php");
}

include_once '../api/config/database.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0,  user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter Une voiture</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="addvoiture.css">

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
                <li class="active">
                    <a href="addvoiture.php">Ajouter une voiture</a>
                </li>
                <li class=" sdb">
                    <a href="../api/voiture/read.php"> Liste des voitures</a>
                </li>
                <li class="sdb2">
                    <a href="addclient.php">Ajouter un client</a>
                </li>
                <li class="sdb3">
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
                        <h3> &nbsp;Ajouter Une Voiture</h3>

                    </div>

                </div>

                <br>

                <div class="xan">

<?php if(isset($_GET['err']) && $_GET['err'] == 'STLA' ) { echo "<span style='color:red;'>La taille de l'image dépasse la taille maximale autorisée 3Mo.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'EXNL' )  { echo "<span style='color:red;'>Vous pouvez ajouter  uniquement des images.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'HfWaF' )  { echo "<span style='color:red;'>Erreur lors l'ajout du voiture au historique.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'HIfWaF' )  { echo "<span style='color:red;'>Image non ajoutée dans l'historique.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'IfWaF' )  { echo "<span style='color:red;'>Image non modifiée.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'famEMP' )  { echo "<span style='color:red;'>Les données de la demande du client sont vides.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'HFfWaF' )  { echo "<span style='color:red;'>Erreur lors l'ajout de la demande du client au historique.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'FfWaF' )  { echo "<span style='color:red;'>Veuillez verifier les données de la demande du client.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'FfWaFF' )  { echo "<span style='color:red;'>Veuillez verifier les données de la demande du client.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'HFfWaFF' )  { echo "<span style='color:red;'>Erreur lors l'ajout de la demande du client au historique.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'CfWaF' )  { echo "<span style='color:red;'>Erreur lors la modification du voiture.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'TcHvOd' )  { echo "<span style='color:red;'>Veuillez verifier les données des techniciens.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'DiNcP' )  { echo "<span style='color:red;'>Veuillez remplir tous les champs nécessaires.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'CkBEpt' )  { echo "<span style='color:red;'> les données de la demande du client sont vides.</span>";} ?>
<?php if(isset($_GET['err']) && $_GET['err'] == 'ImmAExSt' )  { echo "<span style='color:red;'>Immatricule existe déja, vérifier vos données.</span>";} ?>


                    <form action="../api/voiture/create.php" method="post" enctype="multipart/form-data">
                        <div id="first-fm">
                            <section class="first-sec container">
                                <div class="row dolr">
                                    <div class="col">
                                        <label class="pinv">Client</label>

                                    </div>
                                    <div class="col">
                                        <?php
echo '<select name="cli">'; // Open your drop down box

$stmt = $client->list();
$num = $stmt->rowCount();
// here we added if there is clients
if($num>0){

  $key=1;
      

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
   
    extract($row);
    if($key==1){
        echo '<option value="'.$name.'" selected>'.$name.'</option>';
        $key==2;
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
                                    <div class="col-6">
                                        <label>N°Chassis</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="darpi" name="chassis" placeholder="N°Chassis" required>
                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col-6">
                                        <label>Marque</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="darpi" name="mark" placeholder="Marque" required>
                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col-6">
                                        <label>Model</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="darpi" name="model" placeholder="Model" required>

                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col-6">
                                        <label>Immatricule</label>

                                    </div>
                                    <div class="col-6">
                                        <span>
                                            <input type="text" class="i1 darpi" name="i1" placeholder="ex: 15" required>
                                            <input type="text" class="i2 darpi" name="i2" placeholder="ex: A" required>
                                            <input type="text" class="i3 darpi" name="i3" placeholder="ex: 1533" required>
                                        </span>
                                    </div>
                                </div>



                                <div class="row dolr">
                                    <div class="col-6">
                                        <label>Kilométrage</label>
                                    </div>
                                    <div class="col-6">
                                        <span style="display:inline;"><input type="number" class="darpi" name="kilo"
                                                placeholder="Kilométrage" required> <span class="km">km</span></span>

                                    </div>
                                </div>
                                <div class="row dolr">
                                    <div class="col-6">
                                        <label>Niveau </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="darpi" name="niveau" placeholder="Ex : 1/3" required>

                                    </div>
                                </div>

                            </section>
                            <section class="second-sec">
                                <div><span>Etat de véhicule sans démontage</span></div>

                                <div> <label><i class="fas fa-plus-circle"></i>Ajouter des Images<input type="file"
                                            onChange="failt()" id="files" name="files[]" accept="image/*"
                                            multiple></label></div>
                                <div><output id="list"></output></div>
                            </section>
                            <section class="third-sec">
                                <div><span>Véhicule réparé par</span></div>
                                <input type="text" name="t1" placeholder=" Technicien 1">
                                <input type="text" name="t2" placeholder=" Technicien 2">
                                <input type="text" name="t3" placeholder=" Technicien 3">
                            </section>
                            <section class="but-sec">
                                <button type="button" class="btn btn-outline-warning  btn-block" id="next-1">Demande de
                                    Client <span style="font-size:2Opx"><b>==></b></span></button>

                            </section>
                        </div>

                        <div id="second-fm">
                            <div class="fourth-sec">
                                <h4>Fréquemment Demandé:</h4>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="REVISION">&nbsp;REVISION<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="VIDANGE MOTEUR">&nbsp;VIDANGE MOTEUR<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="offi[]"
                                                value="FILTRE A HUILE">&nbsp;FILTRE A HUILE<br></label></div>
                                    <div class="col-2"><label><input type="checkbox" name="offi[]"
                                                value="FILTRE A AIR">&nbsp;FILTRE A AIR<br></label> </div>
                                    <div class="col-2"><label><input type="checkbox" name="offi[]"
                                                value="FILTRE A GASOIL">&nbsp;FILTRE A GASOIL<br></label> </div>


                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="HUILE DE DIRECTION">&nbsp;HUILE DE DIRECTION<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="HUILE DE BOITE A VITESSE">&nbsp;HUILE DE BOITE A
                                            VITESSE<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="offi[]"
                                                value="FILTRE A ESSENCE">&nbsp;FILTRE A ESSENCE<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="offi[]"
                                                value="FILTRE A POILEN">&nbsp;FILTRE A POILEN<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="offi[]"
                                                value="PLAQUETTE DE FREIN AV">&nbsp;PLAQUETTE DE FREIN AV<br></label>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="PLAQUTTE DE FREIN ARR">&nbsp;PLAQUTTE DE FREIN ARR<br></label>
                                    </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="HUILE DE FREINS">&nbsp;HUILE DE FREINS<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="offi[]"
                                                value="DIAGNOSTIC">&nbsp;DIAGNOSTIC<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="offi[]"
                                                value="CONTROLE GENERALE">&nbsp;CONTROLE GENERALE<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="offi[]"
                                                value="CHANGEMENT PNEU">&nbsp;CHANGEMENT PNEU<br></label></div>


                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="EQUILIBRAGE">&nbsp;EQUILIBRAGE<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="PARALLELISME">&nbsp;PARALLELISME<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="offi[]"
                                                value="FILTRE A CLIM">&nbsp;FILTRE A CLIM<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="offi[]"
                                                value="CHANGEMENT COURRALE">&nbsp;CHANGEMENT COURRALE<br></label> </div>

                                    <div class="col-2"> </div>

                                </div>



                            </div>
                            <div class="fifth-sec">
                                <h4>Autres:</h4>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="COURROIE D'ALTERNATEUR">&nbsp;COURROIE D'ALTERNATEUR<br></label>
                                    </div>
                                    
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="COURROIE DE DISTRIBUTION">&nbsp;COURROIE DE
                                            DISTRIBUTION<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="POULIE">&nbsp;POULIE<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="ANTIGEL">&nbsp;ANTIGEL<br></label> </div>
                                                
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="MICHELIN">&nbsp;MICHELIN<br></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="DISQUE DE FREIN AV">&nbsp;DISQUE DE FREIN AV<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="DISQUE DE FREIN ARR">&nbsp;DISQUE DE FREIN ARR<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="LAVE GLACE">&nbsp;LAVE GLACE<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="ADDITIFS">&nbsp;ADDITIFS<br></label> </div>

                                                <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="AMORTISSEUR ARR">&nbsp;AMORTISSEUR ARR<br></label> </div>
                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="EAU DEMINIRALISEE">&nbsp;EAU DEMINIRALISEE<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="HANKOOK">&nbsp;HANKOOK<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="BARUM">&nbsp;BARUM<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="AMORTISSEUR AV">&nbsp;AMORTISSEUR AV<br></label> </div>

                                                <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="BUTEE">&nbsp;BUTEE<br></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="POMPE D'EMBRAYAGE">&nbsp;POMPE D'EMBRAYAGE<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="DETECTEUR">&nbsp;DETECTEUR<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="RECEPTEUR D'EMBRAYAGE">&nbsp;RECEPTEUR D'EMBRAYAGE<br></label>
                                    </div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="PITLAS">&nbsp;PITLAS<br></label> </div>


                                                <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="URANIA">&nbsp;URANIA<br></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="SERVICE LASSA">&nbsp;SERVICE LASSA<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="POMPE A EAU">&nbsp;POMPE A EAU<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="POMPE HAUTE PRESSION">&nbsp;POMPE HAUTE PRESSION<br></label>
                                    </div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="ACIDE ">&nbsp;ACIDE <br></label> </div>

                                                <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="DISQUE D'EMBRAYAGE">&nbsp;DISQUE D'EMBRAYAGE<br></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="COURROIE D'ENTRENEMENT">&nbsp;COURROIE D'ENTRENEMENT<br></label>
                                    </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="ESSUI GLACE">&nbsp;ESSUI GLACE<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="TORNAGE DISQUE">&nbsp;TORNAGE DISQUE<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="INTERRUPTEUR">&nbsp;INTERRUPTEUR<br></label> </div>

                                                <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="ROTULE">&nbsp;ROTULE<br></label> </div>
                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="HUILE DE DIRECTION">&nbsp;HUILE DE DIRECTION<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="CYLINDRE DE FREIN">&nbsp;CYLINDRE DE FREIN<br></label></div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="BRIDGESTONE">&nbsp;BRIDGESTONE<br></label> </div>
                                    <div class="col-2"> <label><input type="checkbox" name="othr[]"
                                                value="TUBE">&nbsp;TUBE<br></label> </div>
                                                
                                    <div class="col-2"> </div>

                                </div>

                            </div>

                            <div class="sixth-sec">
                                <h4>Fréquemment Demandé:</h4>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="REVISION">&nbsp;REVISION<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="VIDANGE MOTEUR">&nbsp;VIDANGE MOTEUR<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="FILTRE A HUILE">&nbsp;FILTRE A HUILE<br></label></div>
                                    <div class="col-3"><label><input type="checkbox" name="offi[]"
                                                value="FILTRE A AIR">&nbsp;FILTRE A AIR<br></label> </div>



                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="HUILE DE DIRECTION">&nbsp;HUILE DE DIRECTION<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="HUILE DE BOITE A VITESSE">&nbsp;HUILE DE BOITE A
                                            VITESSE<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="FILTRE A ESSENCE">&nbsp;FILTRE A ESSENCE<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="FILTRE A POILEN">&nbsp;FILTRE A POILEN<br></label></div>



                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="PLAQUTTE DE FREIN ARR">&nbsp;PLAQUTTE DE FREIN ARR<br></label>
                                    </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="HUILE DE FREINS">&nbsp;HUILE DE FREINS<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="DIAGNOSTIC">&nbsp;DIAGNOSTIC<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="CONTROLE GENERALE">&nbsp;CONTROLE GENERALE<br></label> </div>



                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="EQUILIBRAGE">&nbsp;EQUILIBRAGE<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="PARALLELISME">&nbsp;PARALLELISME<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="FILTRE A CLIM">&nbsp;FILTRE A CLIM<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="CHANGEMENT COURRALE">&nbsp;CHANGEMENT COURRALE<br></label> </div>

                                </div>
                                <div class="row">
                                    <div class="col-3"><label><input type="checkbox" name="offi[]"
                                                value="FILTRE A GASOIL">&nbsp;FILTRE A GASOIL<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="PLAQUETTE DE FREIN AV">&nbsp;PLAQUETTE DE FREIN AV<br></label>
                                    </div>
                                    <div class="col-3"> <label><input type="checkbox" name="offi[]"
                                                value="CHANGEMENT PNEU">&nbsp;CHANGEMENT PNEU<br></label></div>
                                    <div class="col-3">

                                    </div>
                                </div>




                            </div>

                            <div class="seventh-sec">
                                <h4>Autres:</h4>
                                <div class="row">
                                   
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="COURROIE D'ALTERNATEUR">&nbsp;COURROIE D'ALTERNATEUR<br></label>
                                    </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="COURROIE DE DISTRIBUTION">&nbsp;COURROIE DE
                                            DISTRIBUTION<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="POULIE">&nbsp;POULIE<br></label></div>
                                                <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="ADDITIFS">&nbsp;ADDITIFS<br></label> </div>
                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="DISQUE DE FREIN AV">&nbsp;DISQUE DE FREIN AV<br></label>
                                    </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="DISQUE DE FREIN ARR">&nbsp;DISQUE DE FREIN ARR<br></label>
                                    </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="LAVE GLACE">&nbsp;LAVE GLACE<br></label> </div>
                                 
                                                <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="AMORTISSEUR AV">&nbsp;AMORTISSEUR AV<br></label> </div>


                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="EAU DEMINIRALISEE">&nbsp;EAU DEMINIRALISEE<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="HANKOOK">&nbsp;HANKOOK<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="BARUM">&nbsp;BARUM<br></label> </div>

                                                <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="PITLAS">&nbsp;PITLAS<br></label> </div>


                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="POMPE D'EMBRAYAGE">&nbsp;POMPE D'EMBRAYAGE<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="DETECTEUR">&nbsp;DETECTEUR<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="RECEPTEUR D'EMBRAYAGE">&nbsp;RECEPTEUR
                                            D'EMBRAYAGE<br></label>
                                    </div>

                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="ACIDE ">&nbsp;ACIDE <br></label> </div>

                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="SERVICE LASSA">&nbsp;SERVICE LASSA<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="POMPE A EAU">&nbsp;POMPE A EAU<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="POMPE HAUTE PRESSION">&nbsp;POMPE HAUTE PRESSION<br></label>
                                    </div>

                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="INTERRUPTEUR">&nbsp;INTERRUPTEUR<br></label> </div>

                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="COURROIE D'ENTRENEMENT">&nbsp;COURROIE
                                            D'ENTRENEMENT<br></label>
                                    </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="ESSUI GLACE">&nbsp;ESSUI GLACE<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="TORNAGE DISQUE">&nbsp;TORNAGE DISQUE<br></label> </div>

                                                <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="TUBE">&nbsp;TUBE<br></label> </div>

                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="HUILE DE DIRECTION">&nbsp;HUILE DE DIRECTION<br></label>
                                    </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="CYLINDRE DE FREIN">&nbsp;CYLINDRE DE FREIN<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="BRIDGESTONE">&nbsp;BRIDGESTONE<br></label> </div>

                                                <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="URANIA">&nbsp;URANIA<br></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="ANTIGEL">&nbsp;ANTIGEL<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="ROTULE">&nbsp;ROTULE<br></label> </div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="DISQUE D'EMBRAYAGE">&nbsp;DISQUE D'EMBRAYAGE<br></label></div>


                                                <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="MICHELIN">&nbsp;MICHELIN<br></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="BUTEE">&nbsp;BUTEE<br></label></div>
                                    <div class="col-3"> <label><input type="checkbox" name="othr[]"
                                                value="AMORTISSEUR ARR">&nbsp;AMORTISSEUR ARR<br></label> </div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>

                                </div>
                            </div>
                            <div class="row bgc">
                                <button type="button" class="btn btn-outline-warning  btn-block" id="pre-1">
                                    <span style="font-size:2Opx"><b>
                                            <==</b> </span> Données du voiture</button> </div> <div class="row bgc">
                                                <input class="btn btn-outline-success btn-block" type="submit"
                                                    value="Ajouter La Voiture">
                            </div>

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
    $(document).ready(function() {






        $('form').submit(function(e){

            e.preventDefault();


            var inp = document.getElementById('files');
        if (inp.files.length < 1) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Aucune image de voiture n'a été sélectionnée!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui!'
                }).then((result) => {
                if (result.value) {
                    Swal.fire(
                    'OK!',
                    'Votre choix a été bien enregistré.',
                    'success'
                    )


                    $(this).unbind('submit').submit()

                }
                })
        }else{
           
            $(this).unbind('submit').submit()


        }

        })




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