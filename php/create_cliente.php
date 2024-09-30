<?php
    session_start();
    require_once 'conexion.php';

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["nombre"])) {
          // Código para el formulario de clientes
          $stmt = $conexion->prepare("INSERT INTO cliente (nombre_c, apellido_c, alias, dni, correo_c, telefono, calle, numero, localidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
          if ($stmt === false) {
              die($conexion->error);
          }
          $stmt->bind_param("sssssssss", $nombre, $apellido, $alias, $dni, $email, $telefono, $calle, $numero_calle, $localidad);

          $nombre = $_POST["nombre"];
          $apellido = $_POST["apellido"];
          $alias = $_POST["alias"];
          $dni = $_POST["dni"];
          $email = $_POST["email"];
          $telefono = $_POST["telefono"];
          $calle = $_POST["calle"];
          $numero_calle = $_POST["numero"];
          $localidad = $_POST["localidad"];

          $stmt->execute();

          echo "Nuevo registro de cliente creado exitosamente";
          $id_cliente = $conexion->insert_id; 
          $_SESSION['id_cliente'] = $id_cliente;

          $stmt->close();

          /*$result = $conexion->query("SELECT id_cliente FROM cliente WHERE dni= $dni");
          while ($row = $result->fetch_assoc()) {
          //   echo "EL id del Cliente guardado es: " . $row['id_cliente'] . "";
          header("Location: form_vehiculos.php?id=". $row['id_cliente'] ."");
          //   echo"<a href='agregar_vehiculo.php?id=". $row['id_cliente'] ."'><button> agregar auto</button></a>";
          }*/
        } 
      }
    $conexion->close();
  ?>
