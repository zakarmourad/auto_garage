
<?php
// Start the session
session_start();
if(isset($_SESSION['_Gtx'])){
    header("location:../api/voiture/read.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue </title>
    <link rel="stylesheet" href="login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="sweetalert2.all.min.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
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
            <div class="choices">
                <span><a id="seconn" class="active"   href="#">Se connecter</a></span> 
                <span class="khfi">&nbsp;</span>

                <span><a id="inscr" href="#">S'inscrire</a></span>
            </div>

            <div id="login">
                <form action="../api/admin/postedLog.php" method="POST">
                        <div class="form-group">
                            <input type="text" required placeholder="Username" name="username" id="usnlg">
                            <label for="usnlg">Username</label>

                        </div>
                        <div class="form-group">
                            <input type="password" required placeholder="Mot de Passe" name="password" id="pwdlg">
                            <label for="pwdlg">Mot de Passe</label>

                        </div>
                  <input type="submit" class="btn-yell" value="Se connecter" />
                  <div class="forget" style="margin:0.5rem;"  onclick="forgt()"><a href="#">Informations de compte oubliées ?</a></div>

                </form>
            </div>

            <div id="signup">
                <form action="../api/admin/postedInscription.php" method="POST">
                    <div class="form-group">
                        <input type="text" required name="un" placeholder="Username" id="usnlg">
                        <label for="usnlg">Username</label>

                    </div>
                    <div class="form-group">
                        <input type="email" required name="em" placeholder="Email" id="email">
                        <label for="email">Email</label>

                    </div>
                    <div class="form-group">
                      
                        <input type="password"  required name="p1" placeholder="Mot de Passe" id="pwd1">
                        <label for="pwd1">Password</label>

                    </div>
                    <div class="form-group">
                        <input type="password" required name="p2" placeholder="Confirmer le Mot de Passe" id="pwd2">
                        <label for="pwd2">Confirm Password</label>

                    </div>
                    <input class="btn-blue" type="submit" value="S'inscrire" />
                </form>

            </div>

            <?php if(isset($_GET['crdn']) && $_GET['crdn'] == 'erE'  )  echo "<div class='errors'><b>Mot de passe </b>ou<b> Nom d'utilisateur</b> Invalide.</div>"; ?>
            <?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == 'ErEmnTSntExp'  )  echo "<div class='errors'>Erreur lors l'envoie du Email au votre compte, veuillez contacter l'administration.</div>"; ?>
            <?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == 'ErCrtd'  )  echo "<div class='errors'>Erreur lors la creation d'un nouveau utilisateur , veuillez verifier les données entrées.</div>"; ?>
            <?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == 'AdAxISt'  )  echo "<div class='errors'>Erreur , le <b>nom d'utilisateur</b> doit être unique.</div>"; ?>
            <?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == 'ErCp'  )  echo "<div class='errors'>Les 2 mots de passe <b>sont différents!</b>, Veuillez confirmer le mot de passe.</div>"; ?>
            <?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == 'ErDinC'  )  echo "<div class='errors'>Erreur , Veuillez remplir tous les champs.</div>"; ?>


            <?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == 'EmNtSntVTwo'  )  echo "<div class='errors'>Erreur : <b>sDXL</b> ,veuillez contacter l'administration.</div>"; ?>
            <?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == 'EmNtVld'  )  echo "<div class='errors'>Erreur , l'Email n'existe pas dans la base de données.</div>"; ?>
            <?php if(isset($_GET['sDXl']) && $_GET['sDXl'] == 'EmNtCoF'  )  echo "<div class='errors'>Erreur lors la confirmation de votre Email.</div>"; ?>

            <?php if( isset($_GET['SucD']) && $_GET['SucD'] == 'PsModF' ) echo "<div class='status'>Votre mot de passe a été bien modifié.</div>"; ?>
            <?php if( isset($_GET['SucD']) && $_GET['SucD'] == 'EmSnt' ) echo "<div class='status'>Un Email de confirmation est envoyée à votre compte.</div>"; ?>
            <?php if( isset($_GET['SucD']) && $_GET['SucD'] == 'AcVr' ) echo "<div class='status'>Votre mail a été vérifié! Un administrateur se chargera d'activer votre compte.</div>"; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
       integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
   </script> 
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
        
        <script>
        function forgt(){
            Swal.fire({
  title: 'Entrez votre Email',
  input: 'text',
  heightAuto: false,
  inputAttributes: {
    autocapitalize: 'off'
  },
  showCancelButton: true,
  confirmButtonText: 'Envoyer',
  showLoaderOnConfirm: true,
  preConfirm: (login) => {
    return fetch(`../api/admin/forgotAcc.php?email=${login}`)
      .then(response => {
          
        if (!response.ok) {
          throw new Error(response.error)
        }
        return response.json()
      })
      .then(reso=>{
        if (!reso.success) {
          throw new Error(reso.error)
        }
          return reso
      })
      .catch(error => {
        Swal.showValidationMessage(
          ` ${error}`
        )
      })
  },
  allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {

  if (result.value.success) {
    
    Swal.fire({
      type: 'success',
      title: `${result.value.msg}`,
      heightAuto: false

    })
  }

  
})

        }
        </script>

    
</body>


</html>




