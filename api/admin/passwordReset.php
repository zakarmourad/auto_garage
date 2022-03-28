<?php
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
$admin= new Admin($db);

$email= $_POST["plsazp"];
$username= $_POST["usn"];

$token= $_POST["faejiaf"];
$p1=$_POST["p1"];
$p2=$_POST["p2"];
if(
    !empty($email) &&
    !empty($token) &&
    !empty($p1) &&
    !empty($p2)

){

    if($p1 == $p2){

        ;

        $admin->password=$p1;
        $admin->email = $email;
        $admin->token = $token;
    
        if($admin->updatePassword()){


            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
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
                $mail->addAddress($email);
             
                // Content
    
                $mail->isHTML(true);   
                $mail->Subject= "Votre garage | Notification de modification du mot de passe!";
                $mail->Body=" Monsieur.
                <b> ".$username." </b>, <br/> <br/>

               
           Nous voulions vous informer que votre mot de passe a changé. <br/>

            Si vous n'avez pas effectué cette action, vous pouvez récupérer l'accès en saisissant ".$email."dans le formulaire sur le site Web pour réinitialiser votre mot de passe!
                  <br/>
                 <b> votre garage </b> ";

              
                $mail->send();
             header("location:../../view/login.php?SucD=PsModF");
                exit;
    
            } catch (Exception $e) {
                header("location:../../view/passwordReset.php?plsazp=$email&faejiaf=$token&err=EmNtSntVThr");
                exit;
            }
            
    
        }else{
                //Redirect to passwordReset.php?plsazp=$email&faejiaf=$token&err=PnOtUP with error 
                header("location:../../view/passwordReset.php?plsazp=$email&faejiaf=$token&err=PnOtUP");
                exit;

        }

    }else{
    //Redirect to passwordReset.php?plsazp=$email&faejiaf=$token&err=PnOcMPt with error 
    header("location:../../view/passwordReset.php?plsazp=$email&faejiaf=$token&err=PnOcMPt");
    exit;

    }
    

}else{
    header("location:../../view/passwordReset.php?plsazp=$email&faejiaf=$token&err=DEmTty");
    exit;

    //Redirect to passwordReset.php?plsazp=$email&faejiaf=$token&err=DEmTty with error of empty data
}

?>