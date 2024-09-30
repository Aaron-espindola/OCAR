<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img\icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="estilos/ads.scss?v=<?php echo filemtime('estilos/ads.scss'); ?>">
    <script src="https://kit.fontawesome.com/48e0e5e260.js" crossorigin="anonymous"></script>
    <title>Datos del vehículo</title>
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

<div class="contenedor_perfil">
<?php
    require_once 'php/conexion.php';
// PARTE VEHICULOS /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        // Obtener la patente de la URL
        $idc = isset($_GET['id']) ? $_GET['id'] : null;
        $patente = $_GET['patente'];
        $ida = null;
    try {
        //obtener datos del cliente
        $query_cliente = "SELECT c.id_cliente FROM cliente c INNER JOIN vehiculo v ON v.id_cliente = c.id_cliente WHERE v.patente = ?";
        $stmt_cliente = $conexion->prepare($query_cliente); //Si hay algun error en la query esto devuelve el error
        if ($stmt_cliente === false){
            die("Error en la preparación de la consulta: " . $conexion->error);
        } 
        $stmt_cliente->bind_param("s", $patente);

        $stmt_cliente->execute();

        $resultado_cliente = $stmt_cliente->get_result();
        if ($resultado_cliente->num_rows > 0) {
            while($row = $resultado_cliente->fetch_assoc()) {
                $idc = $row["id_cliente"];
            }
        } else {
            echo "No se encontró ningún cliente con ese ID";
        }
        // Preparar la consulta SQL
        $query_vehiculo = "SELECT * FROM vehiculo WHERE patente = ?";
        // $query_vehiculo = "SELECT v.* FROM vehiculo v INNER JOIN cliente c ON v.id_cliente = c.id_cliente WHERE c.id_cliente = ?";
        // Crear una declaración preparada
        $stmt_vehiculo = $conexion->prepare($query_vehiculo);
        if ($stmt_vehiculo === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        
        // Vincular los parámetros
        $stmt_vehiculo->bind_param("s", $patente);
        
        // Ejecutar la consulta
        $stmt_vehiculo->execute();
        
        // Obtener los resultados
        $resultado_vehiculo = $stmt_vehiculo->get_result();
        
        // Mostrar los vehículos del cliente
        if ($resultado_vehiculo->num_rows > 0) {
            while($row = $resultado_vehiculo->fetch_assoc()) {
                echo "<div class= 'resaltado'> <span> Datos del vehiculo: </span></div>";

                echo "<div class= 'contenedor_datos'>";
                    echo "<div class= 'detalle_datos'>";
                        echo "<b>Patente:</b> " . " " . $row["patente"]  . "<br>";
                        echo "<br>";
                        echo "<b> Marca:</b> " . " " . $row["marca"] . " " . 
                            "<b> Modelo:</b> " . " " . $row["modelo"] . " " .
                            "<b> Año:</b> " . " " . $row["anio"] . " " .
                            "<b> Color:</b> " . " " . $row["color"] . "<br>";
                        echo "<br>";
                        echo "<b> Motor:</b> " . " " . $row["motor"] . " " . 
                            "<b> Combustible:</b> " . " " . $row["combustible"] . " " . 
                            "<b> Transmision:</b> " . " " . $row["transmision"] . "<br>";
                    echo "</div>";

                    echo "<div class= 'box_iconos'>";

                        echo "<div class= 'icono_individual'>";
                            echo "<a href='form_arreglo.php?patente=".$patente. " &&id=" .$row["id_cliente"] ."' class= 'icono icono-fill'>
                                <i class='fa-solid fa-plus'></i></a>";
                            echo "<p>Nuevo arreglo</p>";
                        echo "</div>";
                        echo "<br>";
                    echo "</div>";
                echo "</div>";

// PARTE ARREGLOS ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $patente = $row["patente"];
                $id_u_cliente = $row["id_cliente"];
                    $query_arreglo = "SELECT * FROM arreglo WHERE patente = ?";

                    $stmt_arreglo = $conexion->prepare($query_arreglo);
                    if ($stmt_arreglo === false) {
                        die("Error en la consulta" . $conexion->error);
                    }
                    
                    // Vincular los parámetros
                    $stmt_arreglo->bind_param("s", $patente);
                    
                    // Ejecutar la consulta
                    $stmt_arreglo->execute();
                    
                    // Obtener los resultados
                    $resultado_arreglo = $stmt_arreglo->get_result();

                    echo "<div class= 'mostrar_historial'>";
                        echo "<div class='resaltado'><span>Arreglos: </span></div>";
                    // Mostrar el arreglo del vehículo
                    if ($resultado_arreglo->num_rows > 0) {
                        $id_u_arreglo = null;
        
                            while($row_arreglo = $resultado_arreglo->fetch_assoc()) {
                                $id_u_arreglo = $row_arreglo["id_arreglo"];
                                $ida = $row_arreglo["id_arreglo"];

                                echo "<div class='contenedor_historial'>";

                                    echo "<div class='datos_individuales'>";
                                        echo "<b>Fecha de ingreso:</b> " . " " . $row_arreglo["fecha_ingr"] . "<br>";
                                        echo "<br>";
                                        echo "<b>Descripcion:</b> " . " " . $row_arreglo["desc_arreglo"] . "<br>";
                                        echo "<br>";
                                        echo "<b>Fecha de salida:</b>" . " " . $row_arreglo["fecha_salida"];
                                    echo "</div>";

                                    echo "<div class= 'box_iconos'>";

                                        echo "<div class= 'icono_individual'>";
                                            echo "<a href='perfil_arreglos.php?ida=" .$row_arreglo["id_arreglo"] ." &&idc=" .$row["id_cliente"] ." &&patente=".$row_arreglo["patente"]. "' class='icono icono-fill'>
                                                <i class='fa-solid fa-angles-right'></i></a>";
                                            echo "<p>Ir al arreglo</p>";
                                        echo "</div>";

                                        echo "<div class= 'icono_individual'>";
                                            echo "<a href='php/update_arreglo.php?ida=" .$row_arreglo["id_arreglo"] ." &&idc=" .$row["id_cliente"] ." &&patente=".$row_arreglo["patente"]. "' class='icono icono-fill'>
                                                <i class='fa-solid fa-pen'></i></a>";
                                            echo "<p>Actualizar arreglo</p>";
                                        echo "</div>";

                                        echo "<div class= 'icono_individual'>";
                                            echo "<a href='php/delete_arreglo.php?patente=" . $row_arreglo["patente"] . " &&ida=" . $row_arreglo["id_arreglo"] . " &&idc=". $row["id_cliente"] . "' class= 'icono icono-fill'>
                                                <i class='fa-solid fa-trash-can'></i></a>";
                                            echo "<p>Eliminar arreglo</p>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "<br>";
                        }
                    } else { //ELSE DE ARREGLOS
                        echo "<br>";
                        echo "No se encontraron datos de arreglos para el vehículo con patente: " . $patente;
                        echo "<br>";
                    }   
                }
            }
            else {//ELSE DE VEHICULO
            echo "No se encontró ningún vehículo asociado a ese cliente";
            } 
            echo "</div>";
// Si todo salió bien en el try catch, confirmar los cambios
    $conexion->commit();
    } catch (Exception $e) {
        // Si algo salió mal, revertir los cambios
        $conexion->rollback();
    }
    // Cerrar la conexión
    $conexion->close();
?>
</div>
<script src= "js/script_ocar.js"></script>
<script src="js/menu.js"></script>
</body>
</html>
