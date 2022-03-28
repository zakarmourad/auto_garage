<?php 


//if (valid) then send email notification and redirect to login with green text


// Start the session
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
$username=$_POST['un'];
$email=$_POST['em'];
$etat='utilisateur';
$mailconf='pending';
$accAct='pending';
$password=$_POST['p1'];
$p2=$_POST['p2'];

// make sure data is not empty
if(
    !empty($username) &&
    !empty($password) &&
    !empty($email) &&
    !empty($p2)

){
    if($p2 == $password){

   

$token = password_hash($password,PASSWORD_DEFAULT);
         // set admin property values
        $admin->username = $username;
        $admin->email = $email;
        $admin->etat = $etat;
        $admin->email_confirmed = $mailconf;
        $admin->account_activated = $accAct;
        $admin->token = $token;

        $admin->password = $password;
        $admin->created_at = date('Y-m-d H:i:s');
     if($admin->checkValability()){
             // create the admin

        if($admin->smolCreate()){

         
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
               
                $mail->Username= 'testzakar@gmail.com';
        $mail->Password='mourad99';
                                 // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
                //Recipients
                $mail->setFrom('testzakar@gmail.com');
                $mail->addAddress($email,$username);
             
                // Content
                $mail->Subject= " Email Verification!";

                $mail->isHTML(true);   
                $mail->Subject= " Email Verification!";                // Set email format to HTML

                $mail->Body = "Merci pour votre inscription M.
                <b> ".$username." </b>, <br/> <br/>
                Nous aimerions que vous vérifiiez votre adresse e-mail via ce lien: <br/>
                 <a href='localhost/project/api/admin/EmailVerification.php?email=$email&CeRt=$token'> Vérifiez votre adresse e-mail :) </a> <br/>
                 Si vous ne reconnaissez rien de tout cela, veuillez ignorer cet e-mail <br/>
                 <b> Votre garage - CORP </b> ";

                $mail->send();
                header("location:../../view/login.php?SucD=EmSnt");
                exit;
            } catch (Exception $e) {
                header("location:../../view/login.php?sDXl=ErEmnTSntExp");

            }
                
     
       

        




        }
     
        else{
            header("location:../../view/login.php?sDXl=ErCrtd");
            exit;

        }
     }else{
        header("location:../../view/login.php?sDXl=AdAxISt");
        exit;


     }
   
}

else{
    header("location:../../view/login.php?sDXl=ErCp");
    exit;

}
}
// if admin data is incomplete
else{
 
 
header("location:../../view/login.php?sDXl=ErDinC");
exit;


}
?>
