<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img\icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="../estilos/ads.scss"> 
    <title>Crear nueva contraseña</title>
</head>
<body>
<div class="navbar">
  <figure class="volver_menu">
      <img class="img_navbar" src="../img/logo.webp" alt="Logo"/>
      <figcaption><p>Menu</p></figcaption>
      <a href="../form_login.php"></a>
  </figure>
    <div class="wrapper">
    <div class="contenedor_cerrar">
    <?php
      session_start();
        if (isset($_SESSION['correo_activo'])) {
          // Obtener el nombre del administrador desde la base de datos
          require_once 'php/conexion.php';
          $email = $_SESSION['correo_activo'];
          $query = "SELECT nombre_adm FROM admin WHERE email_adm ='$email'";
          $result = mysqli_query($conexion, $query);
        if ($row = mysqli_fetch_assoc($result)) {
          echo '<span class="admin_nombre">Bienvenido, ' . $row['nombre_adm'] . '</span>';
        }
      }
    ?>
    </div>
  </div>
</div>
  <form action="recovery.php" method="POST">
    <h2>Recupera tu contraseña</h2>
    <div>
      <input type="password" name="new_pass">
      <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
      <label for="floatingInput">Nueva contraseña</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Recuperar contraseña</button>
  </form>

</body>
</html>