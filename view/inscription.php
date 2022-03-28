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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Garage</title>
</head>

<body>
    <div class="wrapper">

        <div class="theheader">
            <span class="a">BIENVENUE</span><span class="b">DANS VOTRE</span><span class="c">GARAGE</span>
        </div>
            <h4 class="formheader">LOGIN</h4>
            
            <div class="theform">
<?php if(isset($_GET['crdn']) && $_GET['crdn'] == "erE"){

echo "<div style='color:red;margin-top:20px;'><b>Mot de passe </b>ou<b> Nom d'utilisateur</b> Invalide</div>";

} ?>
            <form action="../api/admin/postedInscription.php" method="post">
                <input class="inp" type="text" name="un" placeholder="Nom d'utilisateur" required>
                <input class="inp" type="email" name="em" placeholder="Adresse Email" required>
                <input type="text" class="inp" name="tel" placeholder="Téléphone" required>

                <input class="inp" type="password" name="p1" placeholder="Mot de passe" required>
                <input class="inp" type="password" name="p2" placeholder="Confirmer Votre Mot de passe" required>

                <input class="inp" type="submit" value="Se connecter">
            </form>
        </div>
        <img src="../images/car.png" class="car" alt="voiture" />
        <img src="../images/cara.png" class="cara" alt="voiture" />

    </div>
    



</body>

</html>