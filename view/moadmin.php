<?php
// Start the session
session_start();
if(!isset($_SESSION['_Gtx']) && !isset($_SESSION["_AdMs"]) ){
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

$Theid = $_GET['id']?trim($_GET['id']):die();
$stmt = $admin->searchId($Theid);
$num = $stmt->rowCount();
if($num > 0 ){

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
           $usr = $username;
           $phon = $phone;
           $ema = $email;
           $et = $etat;
           
    }
    $TheAdmin = array(
        "id" => $Theid,
        "username"=>$usr,
        "phone"=>$phon,
        "ema"=>$ema,
        "et"=>$et
        
        );
}else{
    $TheAdmin = array(
        "id" => 0,
        "username"=>"Introuvable",
        "phone"=>"Introuvable",
        "ema"=>"Introuvable",
        "et"=>"Introuvable"
        
        
        );
        $erreur = "Erreur dans les données de cet utilisateur !";
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter Un Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="addmin.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
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
                                                                <span class="kr"><?php echo $admin->etat;?> </span>
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
                        <h3> &nbsp;Modifier Un Admin</h3>

                    </div>

                </div>
                <div class="row fling">
                    <h3> Modifier Un Admin</h3>
                </div>
                <br>

                <div class="xan">
<?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == "ErCrtd"){
    echo "<span style='color:red;'>Erreur lors la creation d'un nouveau utilisateur , veuillez verifier les données entrées</span> ";
} ?>
<?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == "ErCp"){
    echo "<span style='color:red;'>Les 2 mots de passe sont différents!, Veuillez confirmer le mot de passe</span>";
} ?>
<?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == "ErDinC"){
    echo "<span style='color:red;'>Erreur , Veuillez remplir tous les champs</span>";
} ?>

<?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == "AdAxISt"){
    echo "<span style='color:red;'>Erreur , le nom d'utilisateur doit être unique.</span>";
} ?>
<?php if(isset($erreur) && $erreur!=null){
    echo "<span style='color:red;'>$erreur</span>";
} ?>

                    <form action="../api/admin/postedup.php" method="post">
                        <div class="form-row">
                        <input type="hidden" name="TheID" value="<?php echo $Theid ;?>" />

                            <div class="form-group col-md-6">
                                <label>UserName</label>
                                <input type="text" class="pord form-control" name="un" id="user1"
                                    placeholder="UserName"  value="<?php echo $TheAdmin['username'] ?>" disabled required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Adresse Email</label>
                                <input type="email" class="pord form-control" value="<?php echo $TheAdmin['ema'] ?>" name="em" placeholder="Email" required>
                            </div>
                        </div>


                        <div class="form-row">


                            <div class="form-group col-md-6">
                                <label>Num Téléphone</label>
                                <input type="text" class="pord form-control" name="tel" value="<?php echo $TheAdmin['phone'] ?>" placeholder="Téléphone" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Password</label>
                                <input type="password" class="pord form-control" name="p1" id="password"
                                    placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label>Confirmer Password</label>
                                <input type="password" class="pord form-control" name="p2" id="confirm_password"
                                    placeholder="Confirmer password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label style="margin-bottom: 3%;">Ajouter un role</label> 
                                <br/>
                                <div class="row">
                                    <div style="    padding-left: 20px;" class="col-md-6">
                                        <div class="custom-control  custom-radio custom-control-inline ">
                                            <input class="custom-control-input" type="radio" name="gridRadios"
                                                id="gridRadios1" value="admin" <?php echo ($TheAdmin['et']=='admin'?"checked":""); ?> >
                                            <label class="custom-control-label" style="padding:0 !important;margin:0 !important;" for="gridRadios1">
                                                Admin
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="custom-control custom-radio custom-control-inline ">
                                            <input class="custom-control-input" type="radio" name="gridRadios" <?php echo ($TheAdmin['et']=='utilisateur'?"checked":""); ?>
                                                id="gridRadios2" value="utilisateur">
                                            <label class="custom-control-label" style="padding:0 !important;margin:0 !important;" for="gridRadios2">
                                                Sous Admin
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>



                        <div class="form-row">
                            <div class=" col-md-12">
                                <input type="submit"
                                    style="padding: 12px 15% 12px 15%;margin: 0 0 0 31%;font-size:17px;"
                                    class="btn  btn-outline-primary" value="Modifier"></div>
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
    var password = document.getElementById("password"),
        confirm_password = document.getElementById("confirm_password");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
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