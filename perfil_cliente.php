<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img\icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="estilos/ads.scss?v=<?php echo filemtime('estilos/ads.scss'); ?>">
    <script src="https://kit.fontawesome.com/48e0e5e260.js" crossorigin="anonymous"></script>
    <title>Cliente</title>
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

// PERFIL CLIENTE ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
    // Obtener el ID del cliente de la URL
    $conexion->begin_transaction();
    $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : null;

    $id_cliente = isset($_GET['id']) ? $_GET['id'] : null;
    try {
        // Preparar el if de las consultas SQL
        if ($busqueda !== null){
            //Preprara la consulta si $busqueda tiene datos
            $query_cliente = "SELECT * FROM cliente WHERE nombre_c = ? OR alias = ? OR telefono = ?";
        }else if ($id_cliente !== null) {
            //Preprara la consulta si $id_cliente tiene datos
            $query_cliente = "SELECT * FROM cliente WHERE id_cliente = ?";
        }else{
            die("No se encontro el usuario por busqueda ni por cliente");
            
        }
        
        // Crear una declaración preparada
        $stmt_cliente = $conexion->prepare($query_cliente); //Si hay algun error en la query esto devuelve el error
        if ($stmt_cliente === false){
            die("Error en la preparación de la consulta: " . $conexion->error);
        }   

        // Preparar el if para la Vinculacion de los parámetros
        if ($busqueda !== null){
            $stmt_cliente->bind_param("sss", $busqueda, $busqueda, $busqueda);
        }else if($id_cliente !== null){
            $stmt_cliente->bind_param("i", $id_cliente);
        }
        
        // Ejecutar la consulta
        $stmt_cliente->execute();

        // Obtener los resultados
        $resultado_cliente = $stmt_cliente->get_result();

        // Mostrar los datos del cliente
        if ($resultado_cliente->num_rows > 0) {
            while($row = $resultado_cliente->fetch_assoc()) {
                $id_cliente = $row["id_cliente"];
                echo "<div class= 'resaltado'> <span>Datos personales:</span> </div>";
                
                echo "<div class= 'contenedor_datos'>";
                    echo "<div class= 'detalle_datos'>";
                        echo "<b> Nombre:</b>" . " " . $row["nombre_c"] . " " . 
                             "<b> Apellido:</b>" . " " . $row["apellido_c"] . " " . 
                             "<b> Alias:</b>" . " " . $row["alias"] . " " . 
                             "<b> DNI:</b>" . " " . $row["dni"] . "<br>";
                        echo "<br>";
                        echo "<b> Direccion:</b>". " " . $row["calle"] . " " . $row["numero"]. " " . 
                             "<b> Localidad:</b>" . " " . $row["localidad"] . "<br>";
                        echo "<br>";
                        echo "<b> Telefono:</b>" . " " . $row["telefono"] . " " .
                             "<b> Email:</b>" . " " . $row["correo_c"] . "<br>";
                    echo "</div>";

                    echo "<div class= 'box_iconos'>";

                        echo "<div class= 'icono_individual'>";
                            echo "<a href='php/update_clientes.php?id=". $row["id_cliente"]."' class='icono icono-fill''>
                                <i class='fa-regular fa-pen-to-square'></i></a>";
                            echo "<p>Actualizar usuario</p>";
                        echo "</div>";

                        echo "<div class= 'icono_individual'>";
                            echo "<a href='php/delete_clientes.php?id=". $row["id_cliente"]."' class= 'icono icono-fill''>
                                <i class='fa-solid fa-trash-can'></i></a>";
                            echo "<p>Eliminar usuario</p>";
                        echo "</div>";

                        echo "<div class= 'icono_individual'>";
                            echo "<a href='form_vehiculo.php?id=". $row["id_cliente"]."' class= 'icono icono-fill''>
                                <i class='fa-solid fa-car'></i></a>";
                            echo "<p>Agregar vehiculo</p>";
                        echo "</div>";
                        echo "<br>";

                    echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No se encontró ningún cliente con ese ID";
        }
    // PARTE VEHICULOS /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    

echo "<div class='mostrar_historial'>";
    echo "<div class= 'resaltado'><span>Vehiculos</span></div>";
            // // Obtener el ID del cliente de la URL
            // $id_cliente = $_GET['id'];
            
            // Preparar la consulta SQL
            $query_vehiculo = "SELECT * FROM vehiculo WHERE id_cliente = ?";
            
            // Crear una declaración preparada
            $stmt_vehiculo = $conexion->prepare($query_vehiculo);
            if ($stmt_vehiculo === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }
            
            // Vincular los parámetros
            $stmt_vehiculo->bind_param("i", $id_cliente);
            
            // Ejecutar la consulta
            $stmt_vehiculo->execute();
            
            // Obtener los resultados
            $resultado_vehiculo = $stmt_vehiculo->get_result();
            
            // Mostrar los vehículos del cliente
            if ($resultado_vehiculo->num_rows > 0) {
                while($row = $resultado_vehiculo->fetch_assoc()) {

                    echo "<div class= 'contenedor_historial'>";

                        echo "<div class= 'datos_individuales'>";
                            echo "<b>Patente:</b>" . " " . $row["patente"] . " " . 
                                "<b>Marca:</b>" . " " .  $row["marca"] . " " . 
                                "<b>Modelo:</b>" . " " . $row["modelo"]. " ";
                        echo "</div>";
                    
                        echo "<div class= 'box_iconos'>";
                        
                            echo "<div class= 'icono_individual'>";
                                echo "<a href='perfil_cliente_datos.php?patente=".$row["patente"]. " &&id=" .$row["id_cliente"] . "'class='icono icono-fill''>
                                    <i class='fa-solid fa-car-on'></i></a>"; 
                                echo "<p>Ir al vehiculo</p>";
                            echo "</div>";

                            // echo "<div class= 'icono_individual'>";
                            //     echo "<a href='php/update_vehiculos.php?patente=".$row["patente"]." &&id=" .$row["id_cliente"] . "'class='icono icono-fill''>
                            //         <i class='fa-regular fa-pen-to-square'></i></a>";
                            //     echo "<p>Modificar vehiculo</p>";
                            // echo "</div>";

                            echo "<div class='icono_individual'>";
                                echo "<a href='php/delete_vehiculos.php?patente=".$row["patente"]. " &&id=" .$row["id_cliente"] . "'class='icono icono-fill''>
                                    <i class='fa-solid fa-trash-can'></i></a>";
                                echo "<p style= padding-left:25px;>Eliminar vehiculo</p>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No se encontró ningún vehículo asociado a ese cliente";
            }
            echo "<br>";
            echo "</div>";
          // Si todo salió bien, confirmar los cambios
        $conexion->commit();
    } catch (Exception $e) {
        // Si algo salió mal, revertir los cambios
        $conexion->rollback();
    }
    
    // Cerrar la conexión
    $conexion->close();
    ?>
    </div>
<script src="js/script_ocar.js"></script>    
</body>
</html>