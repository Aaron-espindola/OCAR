<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img\icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="estilos/ads.scss?v=<?php echo filemtime('estilos/ads.scss'); ?>">
    <title>Presupuestos</title>
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
    <div class= "forms">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                require_once 'php/conexion.php';
                $patente = $_POST['patente'];
                $mano_obra = $_POST['mano_obra'];
                $id_cliente = $_POST['id_cliente'];
                $id_arreglo = $_POST['id_arreglo'];
                $id_repuesto = $_POST['id_repuesto'];
                $id_extra = isset($_POST['id_extra']) ? $_POST['id_extra'] : 0;

                if ($id_extra = 0) {

// Si id_extra tiene un valor distinto de 0, ejecutar la primera consulta

                    $sql = "INSERT INTO presupuesto (mano_obra, id_repuesto, id_extra, id_arreglo) VALUES (?, ?, ?, ?)";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param('siii', $mano_obra, $id_repuesto, $id_extra, $id_arreglo);
                    if ($stmt->execute()) {
                        echo "Presupuesto generado correctamente.";
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    $sql = "SELECT * FROM presupuesto WHERE id_arreglo = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param('i', $id_arreglo);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $presupuesto_mn = $result->fetch_assoc();
                    echo"<div class= 'titulo_form'>";
                    echo "<h3>PRESUPUESTO TOTAL</h3>";
                    echo"</div>";
                    $total = 0;
                    $query_repuestos = "SELECT * FROM repuestos WHERE id_arreglo = ?";        
                    $stmt_repuestos = $conexion->prepare($query_repuestos);
                    if ($stmt_repuestos === false) {
                        die("Error en la consulta" . $conexion->error);
                    }
                    $stmt_repuestos->bind_param("i", $id_arreglo);
                    $stmt_repuestos->execute();
                    $resultado_repuestos = $stmt_repuestos->get_result();
                    if ($resultado_repuestos->num_rows > 0) {
                    $id_u_arreglo = null;
                    echo "<div class='resaltado'><span>Repuestos:</span></div>";
                    while ($row_repuestos = $resultado_repuestos->fetch_assoc()) {            
                        echo "Descripcion del repuesto: " . $row_repuestos["desc_repuesto"]; echo "<br>";
                        echo " Los repuestos necesitan reparacion?: " . $row_repuestos["reparacion"]; echo "<br>";
                        echo " Valor reparacion: " . $row_repuestos["valor_reparacion"]; echo "<br>";
                        echo " Fueron comprados? : " . $row_repuestos["compra"]; echo "<br>";
                        echo " Valor del producto: " . $row_repuestos["valor_compra"];
                        $id_u_arreglo = $row_repuestos["id_arreglo"];
                        $total += $row_repuestos["valor_reparacion"];
                        $total += $row_repuestos["valor_compra"];
                        echo "<br><br>";
                    }
                    }

                    echo "<div class='resaltado'><span>Componentes extra:</span></div>";
                    $query_extra = "SELECT * FROM comp_extra WHERE id_arreglo =  ?;";
                    $stmt_extra = $conexion->prepare($query_extra);
                    if ($stmt_extra === false) {
                        die("Error en la consulta" . $conexion->error);
                    }
                    $stmt_extra->bind_param("i", $id_arreglo);
                    $stmt_extra->execute();
                    $resultado_extra = $stmt_extra->get_result();
                    if ($resultado_extra->num_rows > 0) {
                    while ($row_extra = $resultado_extra->fetch_assoc()) {
                        echo "Componenetes: <br>";
                        echo "Descripcion del componente: " . $row_extra["desc_componente"] . "<br>";
                        echo "Valor del componente: " . $row_extra["valor_componente"] . "<br>";
                        $total += $row_extra["valor_componente"];
                        echo "<br>";
                    }
                    }
                    
                    echo "Mano de obra del taller: " . $presupuesto_mn['mano_obra'];
                    $total += $presupuesto_mn['mano_obra'];
                    $id_presup = $presupuesto_mn['id_presupuesto'];
                    echo "<br>El total del presupuesto es: " . $total;

                    $query_monto = "UPDATE presupuesto SET mano_obra = ?, monto_total = ?, id_repuesto = ?, id_extra = ?, id_arreglo = ? WHERE id_arreglo = ?";
                    $stmt_monto = $conexion->prepare($query_monto);
                    $stmt_monto->bind_param('ssiiii', $mano_obra, $total, $id_repuesto, $id_extra, $id_arreglo, $id_arreglo);
                    if ($stmt_monto->execute()) {
                    echo "<br>El monto ha sido actualizado correctamente.";
                    } else {
                    echo "Error: " . $stmt_monto->error;
                    }
                    echo "<br><br>";
                    echo "
                    <button onclick='redirigir()'>imprimir factura y volver al perfil</button>
                    <script>
                    function redirigir() {
                        var id_cliente = '{$id_cliente}';
                        var id_arreglo = '{$id_u_arreglo}';
                        var id_presupuesto = '{$id_presup}';
                        var patente = '{$patente}';

                        window.open('fact/invoice.php?idc=' + id_cliente + '&ida=' + id_arreglo + '&idp=' + id_presupuesto + '&patente=' + patente, '_blank');
                        window.location.href = 'perfil_cliente_datos.php?id=' + id_cliente + '&patente=' + patente;
                    }
                    </script>
                    ";
                }
            } else { //Si id_extra es cero genera otra consulta.
                $sql = "INSERT INTO presupuesto (mano_obra, id_repuesto, id_extra, id_arreglo) VALUES (?, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param('siii', $mano_obra, $id_repuesto, $id_extra, $id_arreglo);
                if ($stmt->execute()) {
                    echo "Presupuesto generado correctamente.";
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
        ?>
    </div>
</div>
<script src= "js/script_ocar.js"></script>
<script src="js/menu.js"></script>
</body>
</html>