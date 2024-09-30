<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar contraseña</title>
  <link rel="shortcut icon" href="img\icon2.webp" type="image/x-icon">
  <link rel="stylesheet" href="estilos/ads.scss?v=<?php echo filemtime('estilos/ads.scss'); ?>"> 
</head>
<body>
<div class="navbar">
  <figure class="volver_menu">
      <img class="img_navbar" src="img/logo.webp" alt="Logo"/>
      <figcaption><p>Menu</p></figcaption>
      <a href="menu_princip.php"></a>
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

<div class="container" style="color:#fff">
  <form action="php/email_recuperar.php" method="post">
        <label for="recuMail"><b>Email</b></label>
        <input type="text" placeholder="Ingresa Email" name="recuMail" required>
        <button type="submit">Enviar</button>
    </form>
    <p>
      Si has olvidado tu contraseña, introduce tu correo electrónico y te enviaremos un enlace para restablecerla.
    </p>
  </div>
</body>
</html>