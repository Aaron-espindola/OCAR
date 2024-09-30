<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar cliente</title>
    <link rel="shortcut icon" href="img/icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="estilos/ads.scss?v= <?php echo filemtime('estilos/ads.scss'); ?>">
</head>
<body>

<div class="navbar">
        <figure class="volver_menu">
            <img class="img_navbar" src="img/logo.webp" alt="Logo" />
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
                <button onclick="cerrarSesion()" class="boton_cerrar">Cerrar sesion </button>
                    <div class="rombo-desplegable">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 268.832 268.832">
                            <path d="M265.17 125.577l-80-80c-4.88-4.88-12.796-4.88-17.677 0-4.882 4.882-4.882 12.796 0 17.678l58.66 58.66H12.5c-6.903 0-12.5 5.598-12.5 12.5 0 6.903 5.597 12.5 12.5 12.5h213.654l-58.66 58.662c-4.88 4.882-4.88 12.796 0 17.678 2.44 2.44 5.64 3.66 8.84 3.66s6.398-1.22 8.84-3.66l79.997-80c4.883-4.882 4.883-12.796 0-17.678z"/>
                        </svg>
                    </div>
            </div>
        </div>
    </div>


    <div class="contenedor_busqueda">
    
    <h1 class="tit_busqueda">
  <span>Buscar</span>
  <div class="message">
    <div class="word1">Cliente</div>
    <div class="word2">Arreglo</div>
    <div class="word3">Vehiculo</div>
  </div>
</h1>

<form action="resultado_busqueda.php" method="post" id="barra-busqueda">
  <input type="text" name="input" class="inp-buscar" id="input-buscar">
  <button type="reset" class="btn-buscar" id="button-buscar"></button>
</form>
<div class="descrip">
  <p>Para encontrar a un cliente almacenado,<br> puedes buscarlo por:<br> » nombre,<br> » apellido,<br> » alias,<br> » telefono,<br>
  » marca del vehiculo,<br> » modelo del vehiculo,<br> » patente o<br> » fecha de ingreso del arreglo<br> Formato fecha: (AAAA-MM-DD)</p>
</div>
</div>
<script src="js/barra_anim.js"></script>
<script src= "js/script_ocar.js"></script>
<script src="js/menu.js"></script>
</body>
</html>