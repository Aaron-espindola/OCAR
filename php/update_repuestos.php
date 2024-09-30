<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="../estilos/ads.scss?v=<?php echo filemtime('../estilos/ads.scss'); ?>">
    <title>Update repuestos</title>
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
<div class="contenedor" style="color:#fff">
<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Obtener la patente del vehículo de la URL
$id_repuesto = $_POST["id_repuesto"];
$id_cliente = $_POST["id_cliente"];
$patente = $_POST["patente"];
// Obtener los nuevos datos del vehículo del formulario

$descripcion = $_POST["descripcion"];
$reparacion = $_POST["reparacion"];
$valor_rep = $_POST["valor"];
$lugar_rep = $_POST["lugar_reparacion"];
$compra = $_POST["compra"];
$valor_compra = $_POST["valor_compra"];
$lugar_compra = $_POST["lugar_compra"];
$or_repuesto = $_POST["origen_repuesto"];

// Preparar la consulta SQL
$sql = "UPDATE repuestos SET desc_repuesto = ?, reparacion = ?, valor_reparacion = ?, lugar_reparacion = ?, compra = ?, valor_compra = ?, lugar_compra = ?, origen_repuesto = ? WHERE id_repuesto = ?";

// Crear una declaración preparada
$stmt = $conexion->prepare($sql);
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

// Vincular los parámetros
$stmt->bind_param("ssississi", $descripcion, $reparacion, $valor_rep, $lugar_rep, $compra, $valor_compra, $lugar_compra, $or_repuesto, $id_repuesto );


// Ejecutar la consulta
$stmt->execute();

// Verificar si hubo algún error
if ($stmt->error) {
    echo "Error al ejecutar la consulta: " . $stmt->error;
}
// Cerrar la conexión
$conexion->close();



    echo"Vehiculo modificado!";
    header("Location: ../perfil_cliente_datos.php?id=". $id_cliente ."&&patente=" . $patente . "");
}
?>
    <!-- Formulario de repuestos -->
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <h2>Actualización del repuestos</h2>

        <?php
              if (isset($_GET['idr'])) {
                $id_repuesto = $_GET['idr'];
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
          ?>

        Descripcion del repuesto:
        <br> 
        <input type="text" name="descripcion"><br><br>
        Reparacion:
        <br> 
        <input type="text" name="reparacion"><br><br> <!--//checkbox Reparacion SI O NO  -->
        Valor de la reparacion: 
        <br> 
        <input type="number" name="valor"><br><br>
        Lugar de la reparacion: 
        <br> 
        <input type="text" name="lugar_reparacion"><br><br>
        Compra: 
        <br> 
        <input type="text" name="compra"><br><br>
        Valor de la compra: 
        <br> 
        <input type="number" name="valor_compra"><br><br>
        Lugar de la compra: 
        <br> 
        <input type="text" name="lugar_compra"><br><br>
        Origen del repuesto: 
        <br> 
        <input type="text" name="origen_repuesto"><br><br>
        <input type="hidden" name="id_repuesto" value="<?php echo $id_repuesto; ?>">
        <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
        <input type="hidden" name="patente" value="<?php echo $patente; ?>">
        <input type="submit" value="modificar repuestos">
  </form>
</div>
<script src= "js/script_ocar.js"></script>
<script src="js/menu.js"></script>
</body>
</html>
