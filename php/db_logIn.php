<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email= $_POST['mail'];
    $passw = $_POST['pass'];

    $query = "SELECT * FROM admin WHERE email_adm ='$email'";
    $result = mysqli_query($conexion, $query);

  if($row = mysqli_fetch_assoc($result)){
    
    if (password_verify($passw, $row['passsword'])) {
        $_SESSION['correo_activo'] = $email;
        $_SESSION['id_activo'] = $row['id_adm'];
    
        echo "CONTRASEÑA CORRECTA, INICIO DE SESSION ACTIVADO <br>"; 

     header("Location:../menu_princip.php");
    } else {
      header("Location:../form_login.php?message=error_pass");
    }
  } else {
    echo "Usuario no encontrado";
    header("Location:../form_login.php?message=error_user");
  }
}

mysqli_close($conexion);
?>

