<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="estilos/ads.scss?v=<?php echo filemtime('estilos/ads.scss'); ?>">
    <script src="https://kit.fontawesome.com/48e0e5e260.js" crossorigin="anonymous"></script>
    <title>Resultados</title>
</head>
<body>

    <!-- -.-.-.-.- NAVBAR -.-.-.-.- -->

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


<?php
require_once 'php/conexion.php';

$busqueda = $_POST['input'];

// -.-.-.-.-.-.-.- Determinar el tipo de búsqueda -.-.-.-.-.-.-.-
    if (!empty($busqueda)) {
    
    // -.-.-.-.- Verificar si la búsqueda es por cliente -.-.-.-.-
        $query_cliente = "SELECT cliente.*, vehiculo.patente, vehiculo.marca, vehiculo.modelo
        FROM cliente
        LEFT JOIN vehiculo ON cliente.id_cliente = vehiculo.id_cliente
        WHERE cliente.nombre_c = ? OR cliente.apellido_c = ? OR cliente.alias = ? OR cliente.telefono = ?";
        $stmt_cliente = $conexion->prepare($query_cliente);
        $stmt_cliente->bind_param("ssss", $busqueda, $busqueda, $busqueda, $busqueda);
        $stmt_cliente->execute();
        $resultado_cliente = $stmt_cliente->get_result();

        // -.-.- Si se encontraron resultados de cliente -.-.-

        if ($resultado_cliente->num_rows > 0) {
            echo "<h1 class='titulo_resultado'>RESULTADO CLIENTES</h1>";
            echo "<div class= contenedor_resultados>";

            $clientes_con_vehiculos = array(); // Array para almacenar clientes y sus vehículos asociados
        
            while ($row_cliente = $resultado_cliente->fetch_assoc()) {
                // Almacena los datos del cliente en el array
                $cliente = array(
                    "id_cliente" => $row_cliente["id_cliente"],
                    "nombre" => $row_cliente["nombre_c"],
                    "apellido" => $row_cliente["apellido_c"],
                    "alias" => $row_cliente["alias"],
                    "telefono" => $row_cliente["telefono"],
                    "vehiculos" => array() // Almacena los vehículos asociados al cliente
                );
        
                // Agrega el cliente al array
                if (!isset($clientes_con_vehiculos[$cliente["id_cliente"]])) {
                    $clientes_con_vehiculos[$cliente["id_cliente"]] = $cliente;
                }
        
                // Agrega el vehículo al cliente si existe
                if (!empty($row_cliente["patente"])) {
                    $vehiculo = array(
                        "patente" => $row_cliente["patente"],
                        "marca" => $row_cliente["marca"],
                        "modelo" => $row_cliente["modelo"]
                    );
                    // Agrega el vehículo al array de vehículos asociados al cliente
                    $clientes_con_vehiculos[$cliente["id_cliente"]]["vehiculos"][] = $vehiculo;
                }
            }
        
            // Itera sobre los clientes y sus vehículos asociados
            foreach ($clientes_con_vehiculos as $cliente) {
                echo "<div class='container_datos'>";
                echo "<div class='datos-cliente'>";
                echo "<h4>Datos del Cliente</h4>";
                echo "<span>Nombre:</span>  " . $cliente["nombre"] . "<br>";
                echo "<span>Apellido:</span>  " . $cliente["apellido"] . "<br>";
                echo "<span>Alias:</span>  " . $cliente["alias"] . "<br>";
                echo "</div>";
        
                // Mostrar vehículos asociados al cliente
                if (!empty($cliente["vehiculos"])) {
                    foreach ($cliente["vehiculos"] as $vehiculo) {
                        echo "<div class='datos-vehiculo'>";
                        echo "<h4>Datos del Vehículo</h4>";
                        echo "<span>Marca:</span>  " . $vehiculo["marca"] . "<br>";
                        echo "<span>Modelo:</span>  " . $vehiculo["modelo"] . "<br>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='sin-vehiculo'>";
                    echo "El cliente no tiene vehículos asociados.<br>";
                    echo "</div>";
                }

                // -.-.- Botones de accion -.-.- 
                
                    echo "<div class= 'box_iconos'>";
                    echo "<a href='perfil_cliente.php?id=" . $cliente["id_cliente"] . "' class='icono icono-fill'>
                            <i class='fa-regular fa-user'></i></a>";
                    echo "<p>Ir al perfil</p>";
                    echo "<a href='consulta_cliente.php' class= 'icono icono-fill'>
                            <i class='fa fa-magnifying-glass'></i></a>";
                    echo "<p>Volver a busquedas</p>";
                    echo "</div>";
                    echo "</div>";

            }
        } else {

        // -.-.-.- Verificar si la búsqueda es por vehiculo -.-.-.-

            $query_vehiculo = "SELECT vehiculo.*, cliente.nombre_c, cliente.apellido_c, cliente.alias, cliente.telefono
            FROM vehiculo 
            INNER JOIN cliente ON cliente.id_cliente = vehiculo.id_cliente 
            WHERE vehiculo.patente = ? OR vehiculo.marca = ? OR vehiculo.modelo = ?";
            $stmt_vehiculo = $conexion->prepare($query_vehiculo);
            $stmt_vehiculo->bind_param("sss", $busqueda, $busqueda, $busqueda);
            $stmt_vehiculo->execute();
            $resultado_vehiculo = $stmt_vehiculo->get_result();

        // -.-.- Si se encontraron resultados de vehiculo -.-.-

                if ($resultado_vehiculo->num_rows > 0) {
                    echo "<h1 class='titulo_resultado'>RESULTADO DE CLIENTES</h1>";
            
                    while ($row_vehiculo = $resultado_vehiculo->fetch_assoc()) {
        // -.-.- Mostrar el cliente asociados al vehiculo -.-.-
                        echo "<div class='container_datos'>";
                        echo "<div class='datos-cliente'>";
                        echo "<h4>Datos del Cliente</h4>";
                        echo "ID: " . $row_vehiculo["id_cliente"] . "<br>";
                        echo "<span>Nombre:</span>  " . $row_vehiculo["nombre_c"] . "<br>";
                        echo "<span>Apellido:</span>  " . $row_vehiculo["apellido_c"] . "<br>";
                        echo "<span>Alias:</span>  " . $row_vehiculo["alias"] . "<br>";
                        echo "<span>Teléfono:</span>  " . $row_vehiculo["telefono"] . "<br>";
                        echo "</div>";

                        echo "<div class='datos-vehiculo'>";
                        echo "<h4>Datos del Vehículo</h4>";
                        echo "<span>Patente:</span>  " . $row_vehiculo["patente"] . "<br>";
                        echo "<span>Marca:</span>  " . $row_vehiculo["marca"] . "<br>";
                        echo "<span>Modelo:</span>  " . $row_vehiculo["modelo"] . "<br>";
                        echo "</div>";
                                
                        echo "<div class= 'box_iconos'>";
                        echo "<a href='perfil_cliente.php?id=" . $row_vehiculo["id_cliente"] . "' class='icono icono-fill'>
                            <i class='fa-regular fa-user'></i></a>";
                        echo "<p>Ir al perfil</p>";
                        echo "<a href='consulta_cliente.php' class= 'icono icono-fill'>
                            <i class='fa fa-magnifying-glass'></i></a>";
                        echo "<p>Volver a busquedas</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<hr>";
                    }
                } else {

        // -.-.-.-.- Verificar si la búsqueda es por fecha de ingreso -.-.-.-.-

                        $query_fecha = "SELECT cliente.*, vehiculo.*, arreglo.fecha_ingr 
                        FROM cliente 
                        INNER JOIN vehiculo ON cliente.id_cliente = vehiculo.id_cliente 
                        INNER JOIN arreglo ON vehiculo.patente = arreglo.patente
                        WHERE arreglo.fecha_ingr = ?";
                        $stmt_fecha = $conexion->prepare($query_fecha);
                        $stmt_fecha->bind_param("s", $busqueda);
                        $stmt_fecha->execute();
                        $resultado_fecha = $stmt_fecha->get_result();

        // -.-.- Si se encontraron resultados por fecha de ingreso -.-.-

                        if ($resultado_fecha->num_rows > 0) {

                            while ($row_fecha = $resultado_fecha->fetch_assoc()) {

                                $fecha_ingresada= $row_fecha["fecha_ingr"];

                                echo "<h1 class='titulo_resultado'>RESULTADOS DE CLIENTES</h1>";
                                echo "<h3 class='subtitulo_fecha'><span>FECHA DE INGRESO:</span> $fecha_ingresada</h3>";
                                echo "<div class='container_datos'>";
                                echo "<div class='datos-cliente'>";
                                echo "<h4>Datos del Cliente</h4>";
                                echo "ID: " . $row_fecha["id_cliente"] . "<br>";
                                echo "<span>Nombre:</span>  " . $row_fecha["nombre_c"] . "<br>";
                                echo "<span>Apellido:</span>  " . $row_fecha["apellido_c"] . "<br>";
                                echo "<span>Alias:</span>  " . $row_fecha["alias"] . "<br>";
                                echo "<span>Teléfono:</span>  " . $row_fecha["telefono"] . "<br>";
                                echo "</div>";
                        
                                echo "<div class='datos-vehiculo'>";
                                echo "<h4>Datos del Vehículo</h4>";
                                echo "<span>Patente:</span>  " . $row_fecha["patente"] . "<br>";
                                echo "<span>Marca:</span>  " . $row_fecha["marca"] . "<br>";
                                echo "<span>Modelo:</span>  " . $row_fecha["modelo"] . "<br>";
                                echo "</div>";
                       
                                echo "<div class= 'box_iconos'>";
                                echo "<a href='perfil_cliente.php?id=" . $row_fecha["id_cliente"] . "' class='icono icono-fill'>
                                    <i class='fa-regular fa-user'></i></a>";
                                echo "<p>Ir al perfil </p>";
                                echo "<a href='consulta_cliente.php' class= 'icono icono-fill'>
                                    <i class='fa fa-magnifying-glass'></i></a>";
                                echo "<p>Volver a busquedas</p>";
                                echo "</div>";
                                echo "</div>";
                                echo "<hr>";
                            }
                        } else {
                            echo "<div class='datos-vehiculo'>";
                            echo "<h4>No se encontraron resultados para la búsqueda: </h4>" . $busqueda;
                            echo "</div>";
                            echo "<a href='consulta_cliente.php' class= 'icono icono-fill'>
                                <i class='fa fa-magnifying-glass'></i></a>";
                            echo "<p>Volver a busquedas</p>";    
                        }
                    }
                } 
        } else {            
            echo "El campo de búsqueda está vacío.";
        }
        echo "</div>";
$conexion->close();
?>
<script src= "js/script_ocar.js"></script>
<script src="js/menu.js"></script>
</body>
</html>