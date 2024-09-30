<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Agregar cliente </title>
    <link rel="stylesheet" href="estilos/ads.scss?v= <?php echo filemtime('estilos/ads.scss'); ?>">
    <link rel="shotcut icon" href="img/icon2.webp">
    <script src="https://kit.fontawesome.com/48e0e5e260.js" crossorigin="anonymous"></script>

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
                <button onclick="cerrarSesion()" class="boton_cerrar">Cerrar sesion </button>
                    <div class="rombo-desplegable">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 268.832 268.832">
                            <path d="M265.17 125.577l-80-80c-4.88-4.88-12.796-4.88-17.677 0-4.882 4.882-4.882 12.796 0 17.678l58.66 58.66H12.5c-6.903 0-12.5 5.598-12.5 12.5 0 6.903 5.597 12.5 12.5 12.5h213.654l-58.66 58.662c-4.88 4.882-4.88 12.796 0 17.678 2.44 2.44 5.64 3.66 8.84 3.66s6.398-1.22 8.84-3.66l79.997-80c4.883-4.882 4.883-12.796 0-17.678z"/>
                        </svg>
                    </div>
            </div>
        </div>
    </div>

  <div class="container_clientes">
    <div class="wrapper_clientes">
      <ul class="steps">
        <li class="is-active">Datos personales</li>
        <li>Vehiculo</li>
      </ul>

      <div class="form-wrapper">

        <fieldset class="section is-active">
          <form action="php/create_cliente.php" method ="POST" id="form_a">

            <div class="titulo_form">
            <h3> Nuevo cliente </h3>
            </div>

            <label for="nombre"> Nombre: </label>
            <input required name="nombre" type="text" id="nombre" placeholder="*">

            <label for="apellido"> Apellido: </label>
            <input required name="apellido" type="text" id="apellido" placeholder="*">

            <label for="alias"> Alias: </label>
            <input type="text" name="alias" id="alias">

            <label for="dni"> Dni: </label>
            <input type="text" name= "dni" id="dni">

            <label for="calle"> Calle: </label>
            <input required name="calle" type="text" id="calle" placeholder="*">

            <label for="numero"> Numero: </label>
            <input required name="numero" type="text" id="numero" placeholder="*">

            <label for="localidad"> Localidad: </label>
            <input required name="localidad"  type="text" id="localidad" placeholder="*">

            <label for="telefono"> Teléfono: </label>
            <input required name="telefono" type="text" id="telefono" placeholder="*">

            <label for="email"> Correo electronico: </label>
            <input type="email" name="email" id="email">

            <button class="button next-button" type= "submit">Siguiente</button>
          </form>
          
        </fieldset>

        
        <fieldset class="section">
          <form action="php/create_vehiculo.php" method ="POST" id="form_v">
            <div class="titulo_form">
            <h3> Agregar vehiculo </h3>
            </div>
              <?php
              if (isset($_GET['id_cliente'])) {
                $id = $_GET['id_cliente'];
              } else {
                  // Manejar el caso en que 'id' no está definido
              }
              ?>
            
              <label for="patente"> Patente: </label>
              <input required name="patente" type="text" id="patente" placeholder="*">

              <label for="marca"> Marca: </label>
              <input required name="marca" type="text" id="marca" placeholder="*">

              <label for="modelo"> Modelo: </label>
              <input required name="modelo" type="text" id="modelo" placeholder="*">

              <label for="anio"> Año: </label>
              <input required name="anio" type="number" id="anio" placeholder="*">

              <label for="color"> Color: </label>
              <input required name="color" type="text" id="color" placeholder="*">

              <label for="motor"> Motor: </label>
              <input required name="motor" type="text" id="motor" placeholder="*">

              <label for="combustible"> Combustible: </label>
              <input required name="combustible" type="text" id="combustible" placeholder="*">

              <label for="transmision"> Transmision: </label>
              <input required name="transmision" type="text" id="transmision" placeholder="*">

              <input type="hidden" name="id_cliente" value="<?php echo $id; ?>">
            
              <button type="submit" class="button final-button"> Agregar vehiculo </button>
          </form>
        </fieldset>
       
      </div>
    </div>  
  </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/form_pasos.js"></script>
<script src= "js/script_ocar.js"></script>
<script src="js/menu.js"></script>
</body>

</html>