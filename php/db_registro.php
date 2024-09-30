<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = mysqli_real_escape_string($conexion, $_POST['name']);
  $lastName = mysqli_real_escape_string($conexion, $_POST['lastName']);
  $email = mysqli_real_escape_string($conexion, $_POST['email']);
  $pass = mysqli_real_escape_string($conexion, $_POST['pass']);
  $hash = password_hash($pass, PASSWORD_DEFAULT);


  $query = "INSERT INTO admin (nombre_adm, apellido_adm, email_adm, passsword)
  VALUES ('$name','$lastName','$email','$hash')";

  if (mysqli_query($conexion, $query)) {
      echo "Usuario creado correctamente";
      header("Location: ../form_login.php");
  }
  else{
    echo "Error al registrar ";
    die("Error de consulta: " . $conexion->error);
  }
  mysqli_close($conexion);
}
?>