<?php

 
include_once '../config/database.php';
include_once '../objects/historique.php';
include_once '../objects/hisfamille.php';
include_once '../objects/hisimage.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
$historique = new Historique($db);
$hisimage = new Historiquei($db);
$hisfamille = new Historiquef($db);

    

// here we used the voiture_id to search for a voiture
$historique->id = isset($_GET['id']) ? $_GET['id'] : die();
$historique->search();



if($historique->cliname!=null){


$hisfamille->his_id=$historique->id;
$hisimage->his_id=$historique->id;

$stm1=$hisfamille->readAll();
$stm2=$hisimage->readAll();


$num1 = $stm1->rowCount();
$num2 = $stm2->rowCount();

if($historique->cliname!=null && $num1>0){

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
    $historiques = array(
        "voiture_imma" =>  $historique->voiture_imma,
        "cliname" => $historique->cliname,
        "mark" => $historique->mark,
        "model" => $historique->model,
        "kilometrage" => $historique->kilometrage,
        "chassis" => $historique->chassis,
        "niveau" => $historique->niveau,
        "t1" => $historique->t1,
        "t2" => $historique->t2,
        "t3" => $historique->t3,
        "id" => $historique->id,
        "images"=>$images,
        "offi"=>$offi,
        "othr"=>$othr,
        "created_at" => $historique->created_at
 
    );
  

    // http_response_code(200);
 
    // // make it json format
    // echo json_encode($historiques);
}
 
else{
    $historiques = array(
        "voiture_imma" =>  "Introuvable",
        "cliname" => "Introuvable",
        "mark" => "Introuvable",
        "model" => "Introuvable",
        "kilometrage" => "Introuvable",
        "chassis" => "Introuvable",
        "niveau" => "Introuvable",
        "t1" =>"Introuvable",
        "t2" => "Introuvable",
        "t3" => "Introuvable",
    
        "images"=>[],
        "offi"=>[],
        "othr"=>[],
        "created_at" => "introuvable"
    
    );
    $errors = "Les données de cette historique sont corrompues! Contactez Votre administrateur pour fixer ce problème.";

}
}
else{
    $historiques = array(
        "voiture_imma" =>  "Introuvable",
        "cliname" => "Introuvable",
        "mark" => "Introuvable",
        "model" => "Introuvable",
        "kilometrage" => "Introuvable",
        "chassis" => "Introuvable",
        "niveau" => "Introuvable",
        "t1" =>"Introuvable",
        "t2" => "Introuvable",
        "t3" => "Introuvable",
    
        "images"=>[],
        "offi"=>[],
        "othr"=>[],
        "created_at" => "introuvable"
    
    );
    $errors = "L'historique de cette voiture est supprimé! Contactez Votre administrateur pour fixer ce problème.";
}




?>

<?php
// Start the session
session_start();
if(!isset($_SESSION['_Gtx'])){
    header("location:login.php");
}


include_once '../objects/client.php';
 
// initiate database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize the client
$client = new Client($db);


// database connection will be here this is just so everyfile can read this ! it'll return data as json format
// including database and voiture file
include_once '../objects/admin.php';

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
  header("location:../../view/login.php");

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historique Des Voitures</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="search.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <style>
    /* .thumb {
        height: AUTO;
        width: 23%;        
        margin: 10px 5px 0 0;
    } */

    #second-fm {
        display: none;
    }

    * {
        box-sizing: border-box;
    }

    .colz {
        float: left;
        width: 25%;
        padding: 5px;
        text-align: center;
    }

    /* Clearfix (clear floats) */
    .rowz::after {
        content: "";
        clear: both;
        display: table;
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
                    <a href="../../view/addvoiture.php">Ajouter une voiture</a>
                </li>
                <li class="ksdb1">
                    <a href="../voiture/read.php"> Liste des voitures</a>
                </li>
                <li class="ksdb2">
                    <a href="../../view/addclient.php">Ajouter un client</a>
                </li>
                <li class="ksdb3">
                    <a href="../client/read.php">Liste des clients</a>
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
                            <li class="nav-item"><img src="../../images/bg/Groupe 5.png" alt="profile">
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
                                                        <img src="../../images/bg/Groupe 5.png" class="prof" alt="prof">
                                                    </div>
                                                    <div class="col-md-8 offset-md-1  justify-content-md-center">
                                                        <div class="row ">
                                                            <div class="col cdl">
                                                                <span class="nr"> <?php echo $admin->username;?> </span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <span class="kr"> Admin</span>
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
                                                            <a href="../../view/addmin.php"
                                                                class="btn btn-outline-warning  btn-block">Ajouter un
                                                                utilisateur </a>
                                                            <pre></pre>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col">
                                                            <a href="../admin/pending.php"
                                                                class="btn btn-outline-danger  btn-block">Activer un
                                                                utilisateur </a>
                                                            <pre></pre>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                            <button type="button" class="btn jgl btn-block"><a href="../admin/read.php">Liste des Utilisateurs</a></button>
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
                <?php if(isset($errors) && $errors != null){
                    echo "<span style='color:red;'>".$errors."</span>";
                } ?>
                    <div class="col-9">
                        <h3> &nbsp;Données du Voiture : <span
                                style="color:#21B8AF;"><?php echo $historiques["voiture_imma"] ; ?></span>, Le : <span
                                style="color:#21B8AF;"><?php echo $historiques["created_at"] ; ?></span>&nbsp;<span><a href="../pdf/historique.php?id=<?php echo $historiques["id"]; ?>" class='btn pds'   style="font-size:17px;color:white;background-color: #21B8AF;">
                        <img style="width:24px;height:auto;color:white;" src="../../images/print.svg" alt="imprimer" /></a></span></h3>

                    </div>

                </div>
                <div class="row fling">
                    <h3><br> Historique d'une Voiture</h3>
                </div>
                <br>

                <div class="xan">


                    <form>
                        <div id="first-fm">
                            <section class="first-sec row">

                                <table style="width:100%;margin:5px; text-align: center;border-spacing: 1rem;
                                    border-collapse: separate;">
                                    <tr>
                                        <td><label>Client</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Client"
                                                value="<?php echo $historiques["cliname"] ; ?>" disabled></td>
                                        <td><label>Marque</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Marque" disabled
                                                value="<?php echo $historiques["mark"] ; ?>"></td>
                                        <td><label>Immatricule</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Immatricule"
                                                value="<?php echo $historiques["voiture_imma"] ; ?>" disabled></td>

                                    </tr>
                                    <tr>
                                        <td><label>N°Chassis</label></td>
                                        <td> <input type="text" class="darpi" placeholder="N°Chassis" disabled
                                                value="<?php echo $historiques["chassis"] ; ?>"></td>
                                        <td><label>Model</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Model" disabled
                                                value="<?php echo $historiques["model"] ; ?>"></td>
                                        <td><label>Kilométrage</label></td>
                                        <td>
                                            <div class="input-box"> <input type="text" class="darpi"
                                                    placeholder="Kilométrage" disabled
                                                    value="<?php echo $historiques["kilometrage"] ; ?>"><span
                                                    class="unit">KM</span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Niveau</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Niveau" disabled
                                                value="<?php echo $historiques["niveau"] ; ?>"></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                </table>



                            </section>
                            <section class="mob">
                            <table style="width:100%;margin:5px; text-align: center;border-spacing: 1rem;
                                    border-collapse: separate;">
                                    <tr>
                                        <td><label>Client</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Client"
                                                value="<?php echo $historiques["cliname"] ; ?>" disabled></td>
                                    </tr>
                                    <tr>
                                        <td><label>N°Chassis</label></td>
                                        <td> <input type="text" class="darpi" placeholder="N°Chassis" disabled
                                                value="<?php echo $historiques["chassis"] ; ?>"></td>
                                        
                                       
                                    </tr>
                                    <tr>
                                        <td><label>Niveau</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Niveau" disabled
                                                value="<?php echo $historiques["niveau"] ; ?>"></td>
                                      
                                    </tr>
                                    <tr>  <td><label>Marque</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Marque" disabled
                                                value="<?php echo $historiques["mark"] ; ?>"></td>
                                     </tr>
                                    <tr>   <td><label>Immatricule</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Immatricule"
                                                value="<?php echo $historiques["voiture_imma"] ; ?>" disabled></td>
                                            </tr>
                                    <tr> <td><label>Kilométrage</label></td>
                                        <td>
                                            <div class="input-box"> <input type="text" class="darpi"
                                                    placeholder="Kilométrage" disabled
                                                    value="<?php echo $historiques["kilometrage"] ; ?>"><span
                                                    class="unit">KM</span></div>
                                        </td>
                                        </tr>
                                    <tr><td><label>Model</label></td>
                                        <td> <input type="text" class="darpi" placeholder="Model" disabled
                                                value="<?php echo $historiques["model"] ; ?>"></td></tr>


                                </table>
                            </section>

                            <section class="second-sec">
                                <div style="margin :10px;"><span>Etat de véhicule sans démontage</span></div>

                                <div class="rowz">

                                    <?php 
                                  for($x=0; $x<count($historiques['images']); $x++){
                                        echo ' <div class="colz"><img  src="../voiture/images/'.$historiques["images"][$x].'"  class="pisted" alt="image du voiture" onclick="shw(\''.$historiques["images"][$x].'\')" /> </div> ';
                                  }
                                ?>
                                </div>
                            </section>
                            <div class="row">
                                <div class="col">
                                    <section class="third-sec">
                                        <div><span>Véhicule réparé par :</span></div>
                                        <?php if(isset($historiques["t1"]) && $historiques["t1"] != '' ){ echo " <div class='form-inline margB'>
                                            <label>Technicien 1</label>
                                            <input type='text' placeholder=' Technicien 1' disabled
                                                value='".$historiques["t1"]."' >
                                        </div>";} ?>

                                       
                                        <?php if(isset($historiques["t2"]) && $historiques["t2"] != '' ){ echo "
                                        <div class='form-inline margB'>
                                        <label>Technicien 2</label>
                                        <input type='text' placeholder=' Technicien 2' disabled
                                            value='".$historiques["t2"]."' >
                                    </div>
                                        ";} ?>

                                        <?php 
                                        if(isset($historiques["t2"]) && $historiques["t2"] != '' ){ echo "
                                            <div class='form-inline margB'>
                                            <label>Technicien 3</label>
                                            <input type='text' placeholder=' Technicien 3' disabled
                                                value='".$historiques["t3"]."'>
                                        </div>";
                                        
                                        }

                                        ?>
                                        
                                       
                                    </section>
                                </div>
                                <div class="col" style="  margin: auto;">
                                    <section class="sixth-sec">
                                        <button type="button" style="    font-size: 20px;" class="btn btn-outline-warning  btn-block"
                                            id="next-1">Demande de
                                            Client <span style="font-size:20px"><b>&nbsp;></b></span></button>

                                    </section>
                                </div>
                            </div>


                        </div>

                        <div id="second-fm">
                            <div class="fourth-sec">
                                <h4>Fréquemment Demandé:</h4>
                                <?php 
                                  for($x=0; $x<count($historiques['offi']); $x++){
                                        echo " <div class='row'><label><input checked disabled type='checkbox' value=''>&nbsp;".$historiques['offi'][$x]."<br></label>  </div> ";
                                  }
                                ?>
                            </div>
                            <div class="fifth-sec">
                                <h4>Autres:</h4>
                                <?php 
                                  for($x=0; $x<count($historiques['othr']); $x++){
                                        echo "<div class='row'> <label><input checked disabled type='checkbox' value=''>&nbsp;".$historiques['othr'][$x]."<br></label></div>";
                                  }
                                ?>

                            </div>

                            <div class="row bgc">
                                <button type="button" style="font-size:20px" class="btn btn-outline-warning  btn-block" id="pre-1">
                                    <span style="font-size:20px"><b>&nbsp;
                                            <</b> </span> Données du voiture</button>
                                         </div> 
                                        </div> 
                                    </form> 
                                </div>
                                                </div>
                                             </div>
                                             </div>
                                              <div class="overlay">
                            </div>










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
                            function shw(src){
                                var rc = src;
                                Swal.fire({

  padding: '1em',

  imageUrl: '../voiture/uploads/'+rc,
  imageWidth: 2000,
  imageAlt: 'voiture',
  animation: false,
  showConfirmButton: false,

})
                            }
                            
                            </script>

                            <!-- jQuery CDN - Slim version (=without AJAX) -->
                            <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
                            <!-- Popper.JS -->
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
                                integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
                                crossorigin="anonymous">
                            </script>
                            <!-- Bootstrap JS -->
                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
                                integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
                                crossorigin="anonymous">
                            </script>
                            <!-- jQuery Custom Scroller CDN -->
                            <script
                                src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js">
                            </script>

</body>

</html>