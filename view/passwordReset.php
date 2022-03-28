
<?php
// Start the session
session_start();
if(isset($_SESSION['_Gtx'])){
    header("location:../api/voiture/read.php");
}
$email = isset($_GET['plsazp']) ? $_GET['plsazp'] : die();
$token = isset($_GET['faejiaf']) ? $_GET['faejiaf'] : die();
$username = isset($_GET['usn']) ? $_GET['usn'] : die();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="login.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</head>

<body>
   

    <!-- flex container -->
    <div class="container">

        <!-- welcome text -->
        <div class="welcome">
            Bienvenue Sur Votre Garage
        </div>
        <!-- signup and login forms -->

        <div class="forms">
     
            <div id="login">
                <form action="../api/admin/passwordReset.php" method="POST">
                <input type="hidden" value="<?php if(isset($_GET['plsazp'])) echo $_GET['plsazp'];?>" name="plsazp" />
                <input type="hidden" value="<?php if(isset($_GET['faejiaf'])) echo $_GET['faejiaf'];?>" name="faejiaf" />
                <input type="hidden" value="<?php if(isset($_GET['usn'])) echo $_GET['usn'];?>" name="usn" />

                        <div class="form-group">
                            <input type="password" required placeholder="Mot de Passe" name="p1" id="pwdlg">
                            <label for="pwdlg">Mot de Passe</label>

                        </div>
                        <div class="form-group">
                        
                            <input type="password" required name="p2" placeholder="Confirmer le Mot de Passe" id="pwd2">
                            <label for="pwd2">Confirm Password</label>
                        </div>
                  <input type="submit" class="btn-blue" value="Reset Password" />
                </form>
            </div>
            <?php if(isset($_GET['err']) && $_GET['err'] == 'DEmTty'  ) echo "<div class='errors'>Erreur , Veuillez remplir tous les champs.</div>"; ?>
            <?php if(isset($_GET['err']) && $_GET['err'] == 'PnOcMPt'  )  echo "<div class='errors'>Les 2 mots de passe <b>sont différents!</b>, Veuillez confirmer le mot de passe.</div>"; ?>
            <?php if(isset($_GET['err']) && $_GET['err'] == 'PnOtUP'  )  echo "<div class='errors'>Erreur lors la modification de votre mot de passe, Veuillez contacter l'administration.</div>"; ?>
            <?php if(isset($_GET['err']) && $_GET['err'] == 'EmNtSntVThr'  )  echo "<div class='errors'>Votre mot de passe est modifié , Erreur lors l'envoie du notification à votre email.</div>"; ?>

    </div>

    <script>
        $(document).ready(function() {
    
            $("#seconn").click(function(e) {
                e.preventDefault();
                $("#signup").slideUp(function(){
                    $("#signup").hide();

                $("#seconn").addClass('active');
                $("#inscr").removeClass('active');
                $("#login").slideDown(function(){
                    $("#login").show();
                });
                });
              
    
            })
    
            $("#inscr").click(function(e) {
                e.preventDefault();
                $("#login").slideUp(function(){
                    $("#login").hide();

                    $("#inscr").addClass('active');
                $("#seconn").removeClass('active');

                $("#signup").slideDown(function(){
                    $("#signup").show();

                });

                });
                
    
            })
    
        })
        </script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
       integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
   </script> 
</body>


</html>




