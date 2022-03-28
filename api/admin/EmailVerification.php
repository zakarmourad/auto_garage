<?php
//this shall be the link which is sent to a user's email for verification , which sets email confirmed to true and send a email to an admin for activating the account
$emailed = isset($_GET['email']) ? $_GET['email'] : die();

$tokened =  isset($_GET['CeRt']) ? $_GET['CeRt'] : die();

session_start();
if(isset($_SESSION['_Gtx'])){
    header("location:../voiture/read.php");
}

header("Access-Control-Max-Age: 3600");

// get database connection
include_once '../config/database.php';
include_once '../objects/admin.php';
include_once "../PHPMailer/PHPMailer.php";
include_once "../PHPMailer/SMTP.php";
include_once "../PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

 
$database = new Database();
$db = $database->getConnection();
 
$admin = new Admin($db);
$stmt = $admin->Lookup($emailed,$tokened);
$num = $stmt->rowCount();
if($num>0){

    $admin->token= htmlspecialchars(strip_tags($tokened));
    $admin->email = htmlspecialchars(strip_tags($emailed));
    if($admin->verificationEm()){
        //email sent to admin 


        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
           ;      
            $mail->Username= 'testzakar@gmail.com';
    $mail->Password='mourad99';
                             // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('testzakar@gmail.com');

            $stmt = $admin->allAdmin();


            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
                   extract($row);

                   $mail->addAddress($email,$username);

              }
            
         
            // Content

            $mail->isHTML(true);   
            $mail->Subject= "Activating a New User!";



            $mail->Body="Nous vous informons par la présente qu'un nouvel utilisateur a <b> confirmé son adresse e-mail </b>,
            vous pouvez activer son compte en suivant le lien ci-dessous:
                 <br/> <br/>
             <a href='localhost/project/api/admin/pending.php?email=$admin->email&CeRt=$admin->token'> Cliquez ici </a> <br/>
             Si vous ne reconnaissez rien de tout cela, veuillez ignorer cet e-mail <br/>
             <b>votre garage</b>";
             
            $mail->send();
            header("location:../../view/login.php?SucD=AcVr");
            exit;

        } catch (Exception $e) {
            header("location:../../view/login.php?sDXl=EmNtSntVTwo");
            exit;
        }
        

}else{
    header("location:../../view/login.php?sDXl=EmNtCoF");
    exit;

}

}else{
    header("location:../../view/login.php?sDXl=EmNtVld");
    exit;


}
?>