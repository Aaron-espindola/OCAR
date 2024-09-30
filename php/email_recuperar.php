<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["recuMail"];
    $correoDestino= $email;

    $consulta = "SELECT * FROM admin WHERE email_adm='$email'";
    $resultado = mysqli_query($conexion, $consulta);
    $row = $resultado->fetch_assoc();

    if (mysqli_num_rows($resultado) > 0) {
        $mail = new PHPMailer(true);
        try {
            //Configuraciones del servidor de correo
            $mail->SMTPDebug = 2;                                 
            $mail->isSMTP();                                      
            $mail->Host = 'smtp-mail.outlook.com; smtp.gmail.com';  
            $mail->SMTPAuth = true;                               
            $mail->Username = 'Ocar.system@outlook.es';                 
            $mail->Password = 'MM93CL16FC43';                     
            $mail->SMTPSecure = 'tls';                            
            $mail->Port = 587;                                    
            
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];
            //Destinatarios
            $mail->setFrom('Ocar.system@outlook.es', 'OCARsystem');
            $mail->addAddress($correoDestino);     

            //Contenido
            $mail->isHTML(true);                                  
            $mail->Subject = 'Recuperacion de contraseña';
            $mail->Body    = 'Hola, este es un correo generado para solicitar tu recuperación de contraseña, por favor, visita la página de <a href="http://localhost/OCAR/php/nuevo_mail.php?id='.$row['id_adm'].'">Recuperación de contraseña</a>';

            $mail->send();
            
            echo 'El mensaje ha sido enviado';
            header("Location: ../form_login.php");
        } catch (Exception $e) {
            echo 'El mensaje no pudo ser enviado. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}  
?>
