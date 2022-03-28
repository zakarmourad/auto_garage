<?php
// Start the session
session_start();
if(!isset($_SESSION["_AdMs"]) ){
    header("location:../voiture/read.php");
}

 
// database connection will be here this is just so everyfile can read this ! it'll return data as json format
// including database and voiture file
include_once '../config/database.php';
include_once '../objects/voiture.php';
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
<!doctype html>
        <html lang="en">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Admin list</title>

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
                                                            <a href="pending.php"
                                                                class="btn btn-outline-danger  btn-block">Activer un
                                                                utilisateur </a>
                                                            <pre></pre>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                            <button type="button" class="btn jgl btn-block"><a href="read.php">Liste des Utilisateurs</a></button>
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
                        <h3> &nbsp;Liste des Utilisateurs Non Confirmés</h3>

                    </div>
                    <div class="col-3 purr cidar">
              
                    </div>
                </div>
                <div class="row fling">
                    <h3><br> Liste des Utilisateurs Non Confirmés</h3>
                </div>
                <br>

                
        <div class="xan">
        <?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == "ErAct"){
    echo "<span style='color:red;'>Erreur lors l'activation  d'un  utilisateur , veuillez contacter l'administration.</span> ";
} ?>
                    <table class=" gfg bg-light">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Etat</th>
                                <th>Date</th>    
                                <th>Actions</th>                      
                            </tr>
                        </thead>
                   
                        <tbody>
                        <?php
// required headers

 
// database connection will be here this is just so everyfile can read this ! it'll return data as json format
// including database and admin file
include_once '../config/database.php';
include_once '../objects/admin.php';
 
// initiate database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize the admin
$admin = new Admin($db);
 
// query admin , we used read function so we don't repeat it  
$stmt = $admin->pendingUsers();
$num = $stmt->rowCount();
 // here we added if there is admins
if($num>0){
 
      
          

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
        ?>

                            <tr>
                            <td><?php echo $username?></td>
                            <td><?php echo $email?></td>
                            <td>En attente</td>
                            <td><?php echo $created_at?></td>
                         <td class="kola"><?php if($_SESSION['_Gtx'] == $id){ echo "<button  type='button' class='btn pds' ><img style='width:16px;height:auto;color:white;'  src='../../images/don.svg' /></button>";}else{echo  "<a href='activate.php?id=$id' class='btn pds' style='color:white;background-color: #21B8AF;'
                                       ><img style='width:18px;height:auto;color:white;' src='../../images/IKO/tick.svg' alt='...' /></a> 
                                       <button onclick='del($id)' class='btn pds btn-danger ' style='color:white;'><img style='width:16px;height:auto;color:white;' src='../../images/delete.svg' alt='...' /></button>";} ?> </td>
                           
                            </tr>




                            <?php
    }

}
// if no voitures found it will set a 404 error  for json so that no voitures has been found in our database
else{
    echo "<tr><td colspan='6'><h1>Liste est Vide</h1></td></tr>";
 }?>
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

    function show(imma) {
        var imma;
        var cliname;
        var mark;
        var chassis;
        var model;
        var kilometrage;
        var niveau;
        var created_at;
        var updated_at;


        $.ajax({
            type: "GET",
            url: "search.php?id=" + imma,
            data: {
                imma: imma,
                cliname: cliname,
                mark: mark,
                model: model,
                kilometrage: kilometrage,
                chassis: chassis,
                niveau: niveau,
                created_at: created_at,
                updated_at: updated_at
            },
            success: function(data) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Do you want to continue mr: ' + data.cliname,
                    type: 'error',
                    width: 4000,
                    confirmButtonText: 'Cool'
                })
            }
        });
    }


    function his(imma) {
        var his;



        $.ajax({
            type: "GET",
            url: "his.php?id=" + imma,
            data: {
                his: his
            },
            success: function(data) {
                Swal.fire({
                    title: 'Historique!',
                    html: " <table class=' gfg bg-light'><thead><tr><th>ordre</th><th >Immatriculation</th><th >Client</th> <th >chassis</th>      <th >Date </th>  <th >Details </th>  </tr></thead>" +
                        data.his,
                    width: 1000,
                    confirmButtonText: 'Ok!'
                })
            }
        });
    }






    function del(id){
    const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn jubsi btn-danger'
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  title: 'voulez vous vraiment supprimer cet utilisateur de façon permanente ?',
  text: "",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Oui, Supprimer!',
  cancelButtonText: 'Non!',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    $.ajax({
            type: "POST",
            url: "delete.php",
            data: {
                id: id
            },
            success: function(data) {
                swalWithBootstrapButtons.fire(
      'Supprimée!',
      '',
      'success'
    )
    location.reload();

            }
        });

  
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Action Arrétée',
      'Admin n\'est pas supprimé',
      'error'
    )
  }
})

}


    </script>
</body>


    </html>