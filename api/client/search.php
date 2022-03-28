<?php
// Start the session
session_start();
if(!isset($_SESSION['_Gtx'])){
    header("location:../../view/login.php");
}
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

 
include_once '../config/database.php';
include_once '../objects/client.php';
include_once '../objects/historique.php';


// get database connection
$database = new Database();
$db = $database->getConnection();
$client = new Client($db);
$historique = new Historique($db);

$nm="%";
$rm= isset($_GET['name']) ? $_GET['name'] : die();
$rm =ltrim($rm);
$rm =rtrim($rm);
$nm.=$rm;
$nm.="%";

// here we used the client_id to search for a client
$client->name =$nm;


$client->search();


if($client->id!=null){
 $client->count();

 $historique->cliname = $client->name;

 $historique->Regulars();

    // create array
    $clients = array(
        "id" =>  $client->id,
        "name" => $client->name,
        "etat" => $client->etat,
        "tel" => $client->tel,
        "regulars" => $historique->regulars,
        "contact" => $client->contact,
        "count" => $client->count,
        "created_at" => $client->created_at
 
    );
 

}else{
    $clients = array(
        "id" =>  'non Trouvée',
        "name" => 'non Trouvée',
        "etat" => 'non Trouvée',
        "tel" => 'non Trouvée',
        "contact" => 'non Trouvée',
        "regulars" => 'non Trouvée',
        "count" => 'non Trouvée',
        "created_at" => 'non Trouvée'
 
    );
}
?>
<?php

include_once '../objects/admin.php';

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
if(isset($_GET['page'])){
    $page =htmlspecialchars(strip_tags($_GET['page']));
    $dax=array('"',"\"", "&quot;", "'","*","<",">","!","?");
    $page= str_replace($dax, '', $page);
    $page = str_replace( "&#39;", "", $page );
    $page = str_replace( "&#34;", '', $page );


}else{
    $page=1;
}
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chercher Un Client</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="read.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="sweetalert2.all.min.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
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

            <div class="sidebar-header">
                <h3><img src="../../images/3sp.png" class="logo" alt="3sp"></h3>
            </div>

            <ul class="list-unstyled components">
                <p>
                    <pre></pre>
                </p>
                <li class="sdb">
                    <a href="../../view/addvoiture.php">Ajouter une voiture</a>
                </li>
                <li class=" sdb3">
                    <a href="../voiture/read.php"> Liste des voitures</a>
                </li>
                <li class="sdb2">
                    <a href="../../view/addclient.php">Ajouter un client</a>
                </li>
                <li class="active">
                    <a href="read.php">Liste des clients</a>
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
                                    <a class="dropdown-item cdc" href="/3sp/api/admin/logout.php">Deconnexion</a>
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
                    <div class="col-9">
                        <h3> &nbsp;Client : <span style="color:#21B8AF;"><?php echo $clients["name"];?></span></h3>

                    </div>
                    <div class="col-3 purr cidar">
                    <form action="search.php" method="GET">
                        <div class="input-group ">
                            <input type="text" class="form-control darpi" name="name" placeholder="Recherche" required>
                            <div class="input-group-append">
                                &nbsp; &nbsp;
                                &nbsp;

                                <button class="btn  btn-info" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>

                            </div>
                        </div>
      </form>
                    </div>
                </div>
                <div class="row fling">
                    <h3><br>Client : <?php echo $clients["name"];?></h3>
                </div>
                <br>

                <div class="xan">
                    <table class=" gfg bg-light">
                        <thead>
                            <tr>

                                <th>name</th>
                                <th>téléphone</th>
                                <th>contact</th>
                                <th>Nombre des voitures</th>
                                <th>Nombre des visites</th>

                                <th>Voitures</th>

                                <th>Etat</th>

                                <th>Ajouté</th>
                            </tr>
                        </thead>
                    
                        <tbody>
                   
                            <tr>

                                <td class="prf"><?php echo $clients["name"];?></td>

                                <td><?php echo  $clients["tel"];?></td>                
                                <td><?php echo  $clients["contact"];?></td>

                                <td><?php echo  $clients["count"];?></td>
                                <td><?php echo  $clients["regulars"];?></td>

                                <td>
                                <?php 
                                if($clients["name"] != 'non Trouvée'){
?>
                                <button style="color:white;" class="btn btn-warning" onclick="voit('<?php echo $clients['name']; ?>')" type="button"><img style="width:24px;height:auto;" src="../../images/historique.svg" alt="..." /></button>

<?php
                                }else{
                                    echo 'non Trouvée';
                                }
                                ?>
                                
                                </td>

                                <td><?php echo  $clients["etat"];?></td>

                                <td><?php if($clients["created_at"] != 'non Trouvée'){echo date("Y/m/d ",strtotime($clients["created_at"]));}else{echo "non Trouvée";} ?></td>
                            </tr>
                        </tbody>
                    </table>
                
                </div>
            </div>

        </div>
    </div>

    <div class="overlay"></div>


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

    
    function voit(cliname) {
        var his;



        $.ajax({
            type: "GET",
            url: "clients.php?id=" + cliname,
            data: {
                his: his
            },
            success: function(data) {
                Swal.fire({
                    title: 'Voitures!',
                    html: data.his,
                    width: 1000,
                    confirmButtonText: 'Ok!'
                })
            }
        });
    }
    </script>
</body>

</html>