<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img\icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="estilos/ads.scss?v=<?php echo filemtime('estilos/ads.scss'); ?>">
    <title>Pagos</title>
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
    <!-- Formulario de Pagos -->
    <div class= 'forms'>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <div class= "titulo_form">
        <h3>Pago</h3>
    </div>
        <?php
            if (isset($_GET['id'])) {
                $id_cliente = $_GET['id'];
            } else {
                // Manejar el caso en que 'id' no está definido
            }   
            if (isset($_GET['ida'])) {
                $id_arreglo = $_GET['ida'];
            } else {
                // Manejar el caso en que 'id' no está definido
            }
            if (isset($_GET['idp'])) {
                $id_presupuesto = $_GET['idp'];
            } else {
                // Manejar el caso en que 'id' no está definido
            };
            if (isset($_GET['patente'])) {
                $patente = $_GET['patente'];
            } else {
                // Manejar el caso en que 'id' no está definido
            };

            require_once 'php/conexion.php';

            //VALOR REPARACION Y VALOR COMPRA
            $stmt_total = $conexion->prepare("SELECT monto_total FROM presupuesto WHERE id_arreglo = ?");
            $stmt_total->bind_param("s", $id_arreglo);
            $stmt_total->execute();

            $resultTotal = $stmt_total->get_result();
            $filaTotal = $resultTotal->fetch_assoc();
            $total = $filaTotal['monto_total'];

            echo "<b>Precio total del arreglo:</b> " . $total ;
            echo "<br>";
            echo "<br>";
        ?>  

    <label for= "fecha_pago"> Fecha de pago:</label>
    <br>
    <input type="date" name="fecha_pago">
    <br>
    <label for= "monto"> Monto a pagar:</label>
    <br>
    <input type="number" name="monto">
    <br>
    <label for= "forma_pago"> Forma de pago:</label>
    <br>
    <input type="text" name="forma_pago">
    <br><br>
    <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
    <input type="hidden" name="id_arreglo" value="<?php echo $id_arreglo; ?>">
    <input type="hidden" name="id_presupuesto" value="<?php echo $id_presupuesto; ?>">
    <input type="hidden" name="patente" value="<?php echo $patente; ?>">
    <button type="submit" class="button final-button"> Realizar pago </button>
    
    </form>
        </div>
    <?php
        require_once 'php/conexion.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fecha_pago = $_POST["fecha_pago"];
            $monto = $_POST["monto"];
            $forma_pago = $_POST["forma_pago"];
            $id_cliente = $_POST["id_cliente"];
            $id_arreglo = $_POST["id_arreglo"];
            $id_presupuesto = $_POST["id_presupuesto"];
            $patente = $_POST["patente"];

            $sql_presup = "INSERT INTO pago (fecha_pago, monto, forma_pago, id_presupuesto) VALUES (?, ?, ?, ?)";
            $stmt_presup = $conexion->prepare($sql_presup);
            $stmt_presup->bind_param('sisi', $fecha_pago, $monto,$forma_pago, $id_presupuesto);
                if ($stmt_presup->execute()) {
                    echo "
                        <script>
                        function redirigir_factura() {
                            var id_cliente = '{$id_cliente}';
                            var id_arreglo = '{$id_arreglo}';
                            var id_presupuesto = '{$id_presupuesto}';
                            var patente = '{$patente}';
                    
                            window.open('fact/invoice.php?idc=' + id_cliente + '&ida=' + id_arreglo + '&idp=' + id_presupuesto + '&patente=' + patente, '_blank');          

                        }
                        redirigir_factura();
                        </script>
                        ";
                }else {
                    echo "Error: " . $stmt_presup->error;
                }
            echo "<br>";
            echo "<script>
            function redirigir_perfil() {
                var idc = '{$id_cliente}';
                var ida = '{$id_arreglo}';
                var patente = '{$patente}';

                // Redirige al perfil del cliente
                window.location.href = 'perfil_arreglos.php?ida=' + ida + '&idc=' + idc + '&patente=' + patente;
            }
            redirigir_perfil();
            </script>";
        }
    ?>
 </div>
<script src= "js/script_ocar.js"></script>
<script src="js/menu.js"></script>
</body>
</html>