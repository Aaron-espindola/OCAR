<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="../estilos/ads.scss?v=<?php echo filemtime('../estilos/ads.scss'); ?>">
    <title>Update arreglos</title>
</head>
<body>
<div class="navbar">
  <figure class="volver_menu">
      <img class="img_navbar" src="../img/logo.webp" alt="Logo"/>
      <figcaption><p>Menu</p></figcaption>
      <a href="../menu_princip.php"></a>
    </figure>
    <div class="wrapper">
    <div class="contenedor_cerrar">
    <?php
      session_start();
      if (isset($_SESSION['correo_activo'])) {
        // Obtener el nombre del administrador desde la base de datos
        require_once 'conexion.php';
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

<div class="contenedor_perfil">
    <?php
    require_once 'conexion.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Recuperar los datos del arreglo para autorellenar el formulario
    if (isset($_GET['ida'])) {
        $id_arreglo = $_GET['ida'];
    } else {
        die("ID del arreglo no especificado.");
    }

    if (isset($_GET['idc'])) {
        $id_cliente = $_GET['idc'];
    } else {
        die("ID del cliente no especificado.");
    }

    if (isset($_GET['patente'])) {
        $patente_ = $_GET['patente'];
    } else {
        die("Patente no especificada.");
    }

    $query_arreglo = "SELECT * FROM arreglo WHERE id_arreglo = ?";
    $stmt_arreglo = $conexion->prepare($query_arreglo);
    if ($stmt_arreglo === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt_arreglo->bind_param("i", $id_arreglo);
    $stmt_arreglo->execute();
    $resultado_arreglo = $stmt_arreglo->get_result();
    $datos_arreglo = $resultado_arreglo->fetch_assoc();

    $stmt_arreglo->close();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $fecha_ingreso = $_POST['fecha_i'];
        $fecha_salida = $_POST['fecha_s'];
        $descripcion = $_POST['descripcion'];
        $kilometros = $_POST['km'];
        $patente = $_POST['patente_'];
        $id_arreglo = $_POST['id_arreglo'];
        $id_cliente = $_POST['id_cliente'];

        // Preparar la actualización
        $query_update = "UPDATE arreglo SET fecha_ingr = ?, fecha_salida = ?, desc_arreglo = ?, kilometros = ? WHERE id_arreglo = ?";
        $stmt_update = $conexion->prepare($query_update);
        if ($stmt_update === false) {
            die("Error en la preparación de la consulta de actualización: " . $conexion->error);
        }

        $stmt_update->bind_param("sssii", $fecha_ingreso, $fecha_salida, $descripcion, $kilometros, $id_arreglo);
        
        if ($stmt_update->execute()) {
            header("Location: ../perfil_arreglos.php?ida=" . $id_arreglo . "&patente=" . $patente . "&idc=" . $id_cliente);
            exit();
        } else {
            echo "Error al actualizar el registro: " . $stmt_update->error;
        }
        $stmt_update->close();
    }

    // Formatear las fechas correctamente
    $fecha_ingr = $datos_arreglo['fecha_ingr'] == '0000-00-00' ? '' : htmlspecialchars($datos_arreglo['fecha_ingr']);
    $fecha_salida = $datos_arreglo['fecha_salida'] == '0000-00-00' ? '' : htmlspecialchars($datos_arreglo['fecha_salida']);
    ?>

    <!-- Formulario de actualización -->
    <div class="forms">
      <div class= "titulo_form">
        <h3>Actualizar arreglo</h3>
      </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?ida=" . $id_arreglo . "&idc=" . $id_cliente . "&patente=" . $patente_; ?>">
            <?php
            echo "<b>Patente del vehiculo a modificar:</b> " . htmlspecialchars($patente_);
            echo "<br><br>";
            ?>

            <label for="km"> Kilometros: </label>
            <br>
            <input required name="km" type="number" id="km" value="<?php echo htmlspecialchars($datos_arreglo['kilometros']); ?>">
            <br>

            <label for="descripcion"> Descripcion: </label>
            <br>
            <input required name="descripcion" type="text" id="descripcion" value="<?php echo htmlspecialchars($datos_arreglo['desc_arreglo']); ?>">
            <br>

            <label for="fecha_i"> Fecha de ingreso del vehiculo: </label>
            <input required name="fecha_i" type="date" id="fecha_i" value="<?php echo $fecha_ingr; ?>">
            <br>

            <label for="fecha_s"> Fecha de salida del vehiculo: </label>
            <input name="fecha_s" type="date" id="fecha_s" value="<?php echo $fecha_salida; ?>">
            <br>

            <input type="hidden" name="patente_" value="<?php echo htmlspecialchars($patente_); ?>">
            <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($id_cliente); ?>">
            <input type="hidden" name="id_arreglo" value="<?php echo htmlspecialchars($id_arreglo); ?>">
            <br>
            <button type="submit" class="button final-button" id="update_arreglo">Modificar arreglo</button>
        </form>
    </div>
</div>
  </div>
<script src= "../js/script_ocar.js"></script>
<script src="../js/menu.js"></script>
</body>
</html>
