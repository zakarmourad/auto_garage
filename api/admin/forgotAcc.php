<?php 

include_once '../config/database.php';
include_once '../objects/admin.php';
include_once "../PHPMailer/PHPMailer.php";
include_once "../PHPMailer/SMTP.php";
include_once "../PHPMailer/Exception.php";
header('Content-type:application/json;charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
$database = new Database();
$db = $database->getConnection();
$admin= new Admin($db);

if(isset($_GET['email'])){
    $email = $_GET['email'];

    $admin->email=$email;

    if($admin->searchByEmail()){
   
        //sends email to this email and returns ok
        $mail = new PHPMailer(true);

        try {
            //Server settings
           // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = "smtp.gmail.com";                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
           ;      
            $mail->Username= "testzakar@gmail.com";
            $mail->Password="mourad99";
                             // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('testzakar@gmail.com ');
            $mail->addAddress($email);
         
            // Content

            $mail->isHTML(true);   
            $mail->Subject= "votre garage  | Modifier Vos Donnees!";
            $mail->Body= " Monsieur.
            <b> ". $admin->username." </b>, <br/> <br/>
            Il semble que nous ayons reçu une demande de réinitialisation de mot de passe pour le compte lié à cet e-mail. Pour réinitialiser votre mot de passe, cliquez simplement sur le lien ci-dessous!
            : <br/>
             <a href='localhost/project/view/passwordReset.php?plsazp=".$email."&faejiaf=".$admin->token."&usn=".$admin->username."'> Réinitialiser votre mot de passe </a> <br/>
             Si vous ne reconnaissez rien de tout cela, veuillez ignorer cet e-mail <br/>
             <b> votre Garage </b>";

           
            $mail->send();
          
            $data=array("success"=>true,"msg"=>"email has been sent ");
            
            
            echo json_encode($data);


        } catch (Exception $e) {
            $data=array("success"=>false,"error"=>$mail->ErrorInfo."email has not been sent ");

            echo json_encode($data);
        }
     // done

    }else{
        $data=array("success"=>false,"error"=>"email doesn't exist ");

        echo json_encode($data);

        // echo "naah";
                //returns email doesn't exist 

    }



}else{
    $data=array("success"=>false,"error"=>"email is not valid ");

    echo json_encode($data);

    // echo "ulnaah";
                    //returns email is not valid 

}





?>