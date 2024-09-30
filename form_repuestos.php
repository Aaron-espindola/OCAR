<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img\icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="estilos/ads.scss?v=<?php echo filemtime('estilos/ads.scss'); ?>">
    <title>Repuestos</title>
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


    <!-- Formulario -->

  <div class= "contenedor_perfil">
    <div class="forms">
    <div class="container_forms">
      <form action="php/create_repuesto.php" method="post" id="form_r">

        <div class="titulo_form">
          <h3>Registro de repuestos</h3>
        </div>

        <?php
              if (isset($_GET['ida'])) {
                $id_arreglo = $_GET['ida'];
              } else {
                  // Manejar el caso en que 'id' no está definido
              }
              if (isset($_GET['idc'])) {
                $id_cliente = $_GET['idc'];
              } else {
                // Manejar el caso en que 'id' no está definido
              }
              if (isset($_GET['patente'])) {
                $patente = $_GET['patente'];
              } else {
                // Manejar el caso en que 'id' no está definido
              }   
              echo "<b>La patente es:</b> " . $patente ;
        ?>
        
        <div>
          <br>
          <label for="repuesto">Descripcion del repuesto: </label>
            <br>
          <textarea required name="desc_repuesto" id="descripcion"></textarea>
        </div>
        <br>

        <div>
          <label for="reparado">¿El repuesto fue reparado?</label>
          <select id="reparado" name="reparado" onchange="toggleReparacion()">
            <option value = "-">-</option>  
            <option value="si">Sí</option>
            <option value="no">No</option>
          </select>
        </div>
        <br>

        <div id="reparacion" class="hidden">
          <label for="valor_reparacion">Valor de la reparación:</label>
            <br>
          <input type="text" id="valor_reparacion" name="valor_reparacion">
            <br>
          <label for="lugar_reparacion">Lugar de la reparación:</label>
            <br>
          <input type="text" id="lugar_reparacion" name="lugar_reparacion">
        </div>
  
        <div>
          <label for="comprado">¿El repuesto fue comprado?</label>
          <select id="comprado" name="comprado" onchange="toggleCompra()">
            <option value = "-">-</option>  
            <option value="si">Sí</option>
            <option value="no">No</option>
          </select>
        </div>

        <div id="origen" class="hidden">
          <label for="origen_r">Origen del repuesto:</label>
          <select id="origen_r" name="origen_r" onchange="toggleCompra()">
            <option value ="-">-</option>
            <option value="cliente">Provisto por el cliente</option>
            <option value="taller">Comprado por el taller</option>
          </select>
        </div>
  
        <div id="compra" class="hidden">
          <label for="valor_compra">Valor de la compra:</label>
          <input type="text" id="valor_compra" name="valor_compra">
            <br>
          <label for="lugar_compra">Lugar de la compra:</label>
          <input type="text" id="lugar_compra" name="lugar_compra">
        </div>
  
        <input type="hidden" name="id_arreglo" value="<?php echo $id_arreglo; ?>">
        <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
        <input type="hidden" name="patente" value="<?php echo $patente; ?>">
          <br>
        <input type="submit" class="button final-button" value= " Registrar ">
    
      </form>
    </div>
  </div>
  </div>
  
<script src= "js/ocultar_opciones.js"></script>
<script src= "js/script_ocar.js"></script>
<script src= "js/menu.js"></script>
</body>
</html>