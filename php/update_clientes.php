<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img\icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="../estilos/ads.scss?v=<?php echo filemtime('../estilos/ads.scss'); ?>">
    <title>Update clientes</title>
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

//recuperar los datos del cliente para autorrellenar los inputs
if (isset($_GET['id'])){
  $id_cliente = $_GET['id'];
} else {
  die("ID del cliente no especificado");
}

$query_cliente = "SELECT * FROM cliente WHERE id_cliente = ?";
$stmt_cliente = $conexion->prepare($query_cliente);
if ($stmt_cliente === false) {
  die("Error en la preparacion de la consulta: " . $conexion->error);
}

$stmt_cliente->bind_param("i", $id_cliente);
$stmt_cliente->execute();
$resultado_cliente = $stmt_cliente->get_result();
$datos_cliente = $resultado_cliente->fetch_assoc();

$stmt_cliente->close();

// Obtener los nuevos datos del cliente del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $alias = $_POST['alias'];
    $DNI = $_POST['dni'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $calle = $_POST['calle'];
    $numero = $_POST['numero'];
    $localidad = $_POST['localidad'];
    $id_cliente= $_POST["id_cliente"];

    // Preparar la actualizacion
    $sql = "UPDATE cliente SET nombre_c = ?, apellido_C = ?, alias= ?, dni = ?, correo_c = ?, telefono = ?, calle = ?, numero = ?, localidad = ? WHERE id_cliente = ?";
    $stmt_update = $conexion->prepare($sql);
    if ($stmt_update === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt_update->bind_param("sssssssssi", $nombre, $apellido, $alias, $DNI,  $correo, $telefono, $calle, $numero, $localidad, $id_cliente);
    if ($stmt_update->execute()) {
      header("Location: ../perfil_cliente.php?id=". $id_cliente ."");
      exit();
    } else {
      echo "Error al actualizar el registro: " . $stmt_update->error;
    }
    $conexion->close();
    
}
?>
    <!-- Formulario de clientes -->
     <div class="forms">
     <div class= "titulo_form">
  <h3>Actualizacion de Clientes</h3>
</div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id_cliente;?>">
    <?php
        $id = $_GET['id'];
    ?>

  <label for="nombre"> Nombre: </label>
  <br>
  <input type="text" required name="nombre" id="nombre" value="<?php echo htmlspecialchars($datos_cliente['nombre_c']); ?>">
  <br>
  <label for="apellido"> Apellido: </label>
  <br>
  <input type="text" required name="apellido" id= "apellido" value="<?php echo htmlspecialchars($datos_cliente['apellido_c']); ?>">
  <br>
  <label for= "alias"> Alias: </label>
  <br>
  <input type="text" name="alias" id="alias" value= "<?php echo htmlspecialchars($datos_cliente['alias']); ?>">
  <br>
  <label for= "dni"> DNI: </label>
  <br>
  <input type="text" name="dni" id="dni" value= "<?php echo htmlspecialchars($datos_cliente['dni']); ?>">
  <br>
  <label for="correo"> Email: </label>
  <br>
  <input type="text" name="correo" id="correo" value= "<?php echo htmlspecialchars($datos_cliente['correo_c']); ?>">
  <br>
  <label for= "telefono"> Teléfono: </label>
  <br>
  <input type="text" required name="telefono" id="telefono" value="<?php echo htmlspecialchars($datos_cliente['telefono']); ?>">
  <br>
  <label for= "calle"> Calle: </label>
  <br>
  <input type="text" required name="calle" id="calle" value="<?php echo htmlspecialchars($datos_cliente['calle']); ?>">
  <br>
  <label for="numero"> Número: </label>
  <br>
  <input type="text" required name="numero" id="numero" value="<?php echo htmlspecialchars($datos_cliente['numero']); ?>">
  <br>
  <label for="localidad"> Localidad: </label>
  <br>
  <input type="text" required name="localidad" id="localidad" value= "<?php echo htmlspecialchars($datos_cliente['localidad']); ?>">
  <br>
  <input type="hidden" name="id_cliente" value="<?php echo $id; ?>">
  <br>
  <button type="submit" class="button final-button" id="update_cliente">Actualizar</button>
</form>
</div>
</div>
<script src= "js/script_ocar.js"></script>
<script src="js/menu.js"></script>
</body>
</html>



