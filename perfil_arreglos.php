<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img\icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="estilos/ads.scss?v=<?php echo filemtime('estilos/ads.scss'); ?>">
    <script src="https://kit.fontawesome.com/48e0e5e260.js" crossorigin="anonymous"></script>
    <title>Arreglos descripcion</title>
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

    $ida = $_GET['ida'];
    $idc = $_GET['idc'];
    $patente = $_GET['patente'];

    try {
        
// PARTE VEHICULOS /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

    $query_vehiculo = "SELECT * FROM vehiculo WHERE patente = ?";

    // Crear una declaración
    $stmt_vehiculo = $conexion->prepare($query_vehiculo);
    if ($stmt_vehiculo === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }
        
    $stmt_vehiculo->bind_param("s", $patente);
    $stmt_vehiculo->execute();
    $resultado_vehiculo = $stmt_vehiculo->get_result();
        
    // Mostrar los vehículos del cliente
    if ($resultado_vehiculo->num_rows > 0) {
        while($row = $resultado_vehiculo->fetch_assoc()) {
            echo "<div class= 'contenedor_datos_iconos'>";
            echo "<div class='datos_perfil_arreglos'>";
            echo "<div class= 'resaltado'> <span> Vehiculo: </span></div>";
            echo "<b>Patente:</b> " . " " . $row["patente"] . " " .
                 "<b>Marca:</b> " . " " . $row["marca"] . " " . 
                 "<b>Modelo:</b> " . " " . $row["modelo"]. "  ";
            echo "</div>";
        }
    } else 
    { //Else del vehiculo
        echo "<div class='sin_resultado'>";
        echo "No se encontró ningún vehículo asociado a ese cliente";
        echo "</div>";
    }
    echo "<div class= 'box_iconos_horizontal'>";
    echo "<div class= 'icono_individual'>";
    echo "<a href='perfil_cliente_datos.php?patente=" .$patente ." &&id=" .$idc . "' class='icono icono-fill'>
            <i class='fa-solid fa-arrow-left'></i></a>";
    echo "<p>Volver al vehiculo</p>";
    echo "</div>";

    echo "<div class= 'icono_individual'>";
    echo "<a href='perfil_cliente.php?id=" . $idc ."' class='icono icono-fill'> 
        <i class='fa-regular fa-user'></i> </a>";
    echo "<p>Volver al cliente</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    $query_arreglo = "SELECT * FROM arreglo WHERE id_arreglo = ?";
    $stmt_arreglo = $conexion->prepare($query_arreglo);
    if ($stmt_arreglo === false) {
        die("Error en la consulta" . $conexion->error);
    }

    $stmt_arreglo->bind_param("i", $ida);
    $stmt_arreglo->execute();
    $resultado_arreglo = $stmt_arreglo->get_result(); 

    echo "<div class= 'contenedor_datos_iconos'>";
    echo "<div class= 'datos_perfil_arreglos'>";
    echo "<div class= 'resaltado'> <span> Detalles del arreglo: </span></div>";

    if ($resultado_arreglo->num_rows > 0) {
        while ($row_arreglo = $resultado_arreglo->fetch_assoc()) {
            echo "<b>Fecha de ingreso:</b> " . $row_arreglo["fecha_ingr"] . "<br>";
            echo "<b>Fecha de salida:</b> " . $row_arreglo["fecha_salida"] . "<br>";
            echo "<b>kilometraje:</b> " . $row_arreglo["kilometros"] . "<br>";
            echo "<b>Descripcion:</b> " . $row_arreglo["desc_arreglo"]; 
            echo "<br>";
            echo "</div>";

            echo "<div class= 'box_iconos_horizontal'>";
            echo "<div class= 'icono_individual'>";
            echo "<a href='php/update_arreglo.php?ida=" .$row_arreglo["id_arreglo"] . "&&idc=" .$idc . "&&patente=".$patente. "&&ida=" . $ida." ' class='icono icono-fill'>
                 <i class='fa-solid fa-pencil'></i></a>";
            echo "<p>Actualizar<br> arreglo</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } 
    } else { //Else detalles del arreglo 
        echo "<div class= 'sin_resultado'>";
        echo "No se encontraron datos" . $ida;
        echo "</div>";
    }


// PARTE REPUESTOS ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $query_repuestos = "SELECT * FROM repuestos WHERE id_arreglo = ?";
    $stmt_repuestos = $conexion->prepare($query_repuestos);
    if ($stmt_repuestos === false) {
        die("Error en la consulta" . $conexion->error);
    }

    $stmt_repuestos->bind_param("i", $ida);
    $stmt_repuestos->execute();
    $resultado_repuestos = $stmt_repuestos->get_result(); 

    echo "<div class= 'datos_perfil_arreglos'>";

        echo "<div class= 'contenedor_datos_iconos'>";
            echo "<div class='resaltado'><span style='margin-top: 25px;'>Repuestos:</span>";
            echo "</div>";
            echo "<div class= 'box_iconos_horizontal'>";
                echo "<div class= 'icono_individual'>";
                    echo "<a href='form_repuestos.php?idc=" .$idc . " &&patente=".$patente. " &&ida=" .$ida. "' class= 'icono icono-fill'>
                    <i class='fa-solid fa-plus'></i></a>";
                    echo "<p>Agregar<br> repuesto</p>";
                echo "</div>";
            echo "</div>";
        echo "</div>";

    if ($resultado_repuestos->num_rows > 0) {
        $id_u_rep = null; 
        while ($row_repuestos = $resultado_repuestos->fetch_assoc()) {
            $id_u_rep = $row_repuestos["id_repuesto"];

        echo "<div class= 'contenedor_datos_iconos'>";
            echo "<div class= 'datos_perfil_arreglos'>";
                echo "<b>Descripcion del repuesto:</b> " . $row_repuestos["desc_repuesto"];

            if ($row_repuestos["reparacion"] === "si") {
                echo "<b>Reparacion:</b> Sí  <b>Valor reparacion:</b> $" . $row_repuestos["valor_reparacion"]. "<b>Lugar:</b> " . $row_repuestos["lugar_reparacion"];
            }
            if ($row_repuestos["compra"] === "si") {
                echo "<b>Comprado:</b> Sí <b>Origen:</b> " . $row_repuestos["origen_repuesto"] . "<b>Valor:</b> $" . $row_repuestos["valor_compra"]. "<b>Lugar compra:</b> " . $row_repuestos["lugar_compra"];
            } 
            echo "</div>";

            echo "<div class= 'box_iconos_horizontal'>";
                echo "<div class= 'icono_individual'>";
                    echo "<a href='php/delete_repuestos.php?idr=" .$row_repuestos["id_repuesto"] . "&&idc=" .$idc . "&&patente=".$patente. "&&ida=" . $ida."' class= 'icono icono-fill'>
                    <i class='fa-solid fa-trash'></i></a>";
                    echo "<p>Eliminar</p>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
        } 
    } else { //Else repuestos
        echo "<div class= 'sin_resultado'>";
            echo "No se encontraron datos de repuestos para el vehículo con patente: " . $patente;
        echo "</div>";
    }


//// COMPONENTES EXTRAS ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    echo "<div class= 'datos_perfil_arreglos'>";
        echo "<div class= 'contenedor_datos_iconos'>";
            echo "<div class= 'resaltado'> <span> Componentes extra: </span></div>";
    $id_arreglo = $ida;
    $query_extra = "SELECT * FROM comp_extra WHERE id_arreglo = ?";

    $stmt_extra = $conexion->prepare($query_extra);
    if ($stmt_extra === false) {
        die("Error en la consulta: " . $conexion->error);
    
    }
    $stmt_extra->bind_param("i", $id_arreglo);
    $stmt_extra->execute();
            
    $resultado_extra = $stmt_extra->get_result();
    echo "<div class= 'box_iconos_horizontal'>";
    echo "<div class= 'icono_individual'>";
    echo "<a href='form_extra.php?ida=" .$ida ." &&idc=" .$idc ." &&patente=".$patente. "' class= 'icono icono-fill'>
        <i class='fa-solid fa-plus'></i></a>";
    echo "<p>Agregar<br> componente</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    if ($resultado_extra->num_rows > 0) {
        $id_u_extra = null;

        while ($row_extra = $resultado_extra->fetch_assoc()) {
                                        
        $id_u_extra = $row_extra["id_extra"]; 
        echo "<div class= 'contenedor_datos_iconos'>";
        echo "<div class= 'datos_repuestos'>";
        echo "<b>Descripcion del componente:</b> " . $row_extra["desc_componente"]. "<b>Valor del componente:</b> $" . $row_extra["valor_componente"]."  ";
        echo "</div>";

        echo "<div class= 'box_iconos_horizontal'>";
        echo "<div class= 'icono_individual'>";
        echo "<a href='php/delete_extra.php?ide=" . $row_extra["id_extra"] . " &&patente=" . $patente . "' class= 'icono icono-fill'>
            <i class='fa-solid fa-trash'></i></a>";
        echo "<p>Eliminar</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
      
    }
    }else { //Else componentes extra
        echo "<div class= 'sin_resultado'>";
        echo "No se encontraron componentes extras para el vehículo con patente: " . $patente;
        echo "</div>";
        
    }


//// PRESUPUESTOS Y PAGOS ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    echo "<div class= 'datos_perfil_arreglos'>";
    echo "<div class= 'contenedor_datos_iconos'>";
    echo "<div class= 'resaltado'> <span> Presupuesto y pagos: </span></div>";
    echo "<div class= 'box_iconos_horizontal'>";
    echo "<div class= 'icono_individual'>";
    echo "<a href='form_presupuestos.php?patente=".$patente."&idc=".$idc."&ida=".$ida."&ide=".(isset($id_u_extra) ? $id_u_extra : '0')."&idr=".(isset($id_u_rep) ? $id_u_rep : '0')."' class= 'icono icono-fill'>
    <i class='fa-solid fa-file-invoice-dollar'></i></a>";
    echo "<p>Crear<br> presupuesto</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    $query_presup = "SELECT id_presupuesto FROM presupuesto WHERE id_arreglo = ?";
    $stmt_presup = $conexion->prepare($query_presup);
    if ($stmt_presup === false) {
        die("Error en la consulta: " . $conexion->error);
    }
    $stmt_presup->bind_param("i", $id_arreglo);
    $stmt_presup->execute();
    $resultado_presup = $stmt_presup->get_result();

    if ($resultado_presup->num_rows > 0) {
        $row_presup = $resultado_presup->fetch_assoc();
        $id_presup = $row_presup['id_presupuesto'];
    
        // Calcular y mostrar el monto de la mano de obra
        $query_mano_obra = "SELECT mano_obra FROM presupuesto WHERE id_presupuesto = ?";
        $stmt_mano_obra = $conexion->prepare($query_mano_obra);
        if ($stmt_mano_obra === false) {
            die("Error en la consulta SQL: " . $conexion->error);
        }
        $stmt_mano_obra->bind_param("i", $id_presup);
        $stmt_mano_obra->execute();
        $resultado_mano_obra = $stmt_mano_obra->get_result();
        if ($resultado_mano_obra->num_rows > 0) {
            $row_mano_obra = $resultado_mano_obra->fetch_assoc();
            $mano_obra = $row_mano_obra['mano_obra'];
            echo "<div class= 'datos_perfil_arreglos'>";
  
            echo "<b>Mano de obra:</b> $" . $mano_obra;
        }
    
        // Calcular y mostrar el monto total del presupuesto
        $query_monto_total = "SELECT monto_total FROM presupuesto WHERE id_presupuesto = ?";
        $stmt_monto_total = $conexion->prepare($query_monto_total);
        if ($stmt_monto_total === false) {
            die("Error en la consulta SQL: " . $conexion->error);
        }
        $stmt_monto_total->bind_param("i", $id_presup);
        $stmt_monto_total->execute();
        $resultado_monto_total = $stmt_monto_total->get_result();
        if ($resultado_monto_total->num_rows > 0) {
            $row_monto_total = $resultado_monto_total->fetch_assoc();
            $monto_total = $row_monto_total['monto_total'];
            echo "<b>Monto total del presupuesto:</b> $" . $monto_total;
        }
            echo "<div class= 'box_iconos_horizontal'>";
                echo "<div class= 'icono_individual'>";
                echo "<a href='pagos.php?patente=" . $patente . "&id=" . $idc . "&ida=" . $ida . "&idp=" . $row_presup["id_presupuesto"] . "' class= 'icono icono-fill'>
                <i class='fa-solid fa-money-bill-1-wave'></i></a>";
                echo "<p>Realizar<br> pago</p>";
                echo "</div>";
                echo "</div>";
            echo "</div>";
            echo "</div>";

            // PAGOS REALIZADOS Y TOTAL PAGADO //////////////////////////////////////////////////////////////
            $query_pago = "SELECT * FROM pago WHERE id_presupuesto = ?";
            $stmt_pago = $conexion->prepare($query_pago);
            if ($stmt_pago === false) {
                die("Error en la consulta SQL: " . $conexion->error);
            }
            $stmt_pago->bind_param("i", $id_presup);
            $stmt_pago->execute();
            $resultado_pago = $stmt_pago->get_result();
            

            if ($resultado_pago->num_rows > 0) {
                $monto_total_pagado = 0;
                echo "<div class= 'datos_perfil_arreglos'>";
                echo "<div class= 'contenedor_datos_iconos'>";
                echo "<div class= 'resaltado'><span style='margin-top: 25px;'>Pagos realizados: </span></div>";
                echo "</div>";
                while ($row_pago = $resultado_pago->fetch_assoc()) {
                    echo "<div class= 'contenedor_datos_iconos'>";
                    echo "<div class= 'datos_perfil_arreglos'>";
                    echo "<b>Fecha pago:</b> " . $row_pago['fecha_pago'] . "<br>";
                    echo "<b>Monto del pago:</b> $" . $row_pago['monto'] . " ---- " . $row_pago['forma_pago'] . "<br>";
                    $monto_total_pagado += $row_pago['monto'];
                }
                echo "<b>Monto total pagado:</b> $" . $monto_total_pagado . "<br>";
    
                // Calcular el saldo restante
                $saldo_restante = $monto_total - $monto_total_pagado;
                echo "<b>Saldo restante:</b> $" . $saldo_restante . "<br>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }
    
    } catch (Exception $e) {
        $conexion->rollback();
    }
    $conexion->close();
?>

</div>   
<script src= "js/script_ocar.js"></script>
<script src="js/menu.js"></script>
</body>
</html>