<?php 
    require_once('conexion.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $pass = mysqli_real_escape_string($conexion, $_POST['new_pass']);
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $query = "UPDATE admin SET passsword= '$hash' WHERE id_adm= $id";
        $conexion->query($query);

        header("Location: ../form_login.php?message=recoveryOK");
    }else{
        echo"Error en la recuperacion de contraseña";
        die("Error de consulta: " . $conexion->error);
    }
    mysqli_close($conexion);
?>