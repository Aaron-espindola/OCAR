<?php

require_once 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_cliente= $_POST["id_cliente"];
  $patente = $_POST["patente"];
  $marca = $_POST["marca"];
  $modelo = $_POST["modelo"];
  $color = $_POST["color"];
  $año = $_POST["anio"];
  $motor = $_POST["motor"];
  $combustible = $_POST["combustible"];
  $transmision = $_POST["transmision"];

  // Verificar si el cliente existe
  $stmt = $conexion->prepare("SELECT * FROM cliente WHERE id_cliente = ?");
  $stmt->bind_param("i", $id_cliente);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // El cliente existe, insertar el vehículo
    $stmt = $conexion->prepare("INSERT INTO vehiculo (patente, marca, modelo, anio, color, motor, combustible, transmision, id_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die($conexion->error);
    }
    $stmt->bind_param("sssissssi", $patente, $marca, $modelo, $año, $color, $motor, $combustible, $transmision, $id_cliente);

    if ($stmt->execute()) {
      // Exito en el execute
      header("Location: ../perfil_cliente.php?id=". $id_cliente ."");
    } else {
      // Error en el execute
      echo "Hubo un error al crear el registro de vehículo: " . $stmt->error;
    }
  } else {
    // El cliente no existe
    echo "El cliente con id " . $id_cliente . " no existe.";
  }

  $stmt->close();
}

$conexion->close();


// require_once 'conexion.php';
// session_start();

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   $id_cliente= $_POST["id_cliente"];
//   $patente = $_POST["patente"];
//   $marca = $_POST["marca"];
//   $modelo = $_POST["modelo"];
//   $color = $_POST["color"];
//   $año = $_POST["anio"];
  

//   // Código para el formulario de vehículos
//   $stmt = $conexion->prepare("INSERT INTO vehiculo (patente, marca, modelo, anio, color, id_cliente) VALUES (?, ?, ?, ?, ?, ?)");
//   if ($stmt === false) {
//       die($conexion->error);
//   }
//   $stmt->bind_param("sssssi", $patente, $marca, $modelo, $año, $color, $id_cliente);


//   if ($stmt->execute()) {
//     echo "Nuevo registro de vehículo creado exitosamente";
//     // header("Location: ../perfil_cliente.php?id=". $id_cliente ."");
//   } else {
//     echo "Hubo un error al crear el registro de vehículo: " . $stmt->error;
//   }
//   $stmt->close();
// }

// $conexion->close();
?>