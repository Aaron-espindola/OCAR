<?php
require_once 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Código para el formulario de vehículos
  $stmt = $conexion->prepare("INSERT INTO vehiculo (patente, marca, modelo, anio, color, motor, combustible, transmision, id_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  if ($stmt === false) {
      die($conexion->error);
  }
  $stmt->bind_param("sssissssi", $patente, $marca, $modelo, $año, $color, $motor, $combustible, $transmision, $id_cliente);

  $patente = $_POST["patente"];
  $marca = $_POST["marca"];
  $modelo = $_POST["modelo"];
  $color = $_POST["color"];
  $año = $_POST["anio"];
  $motor = $_POST["motor"];
  $combustible = $_POST["combustible"];
  $transmision = $_POST["transmision"];
  $id_cliente= $_SESSION["id_cliente"];

  $stmt->execute();

  echo "Nuevo registro de vehículo creado exitosamente";
  header("Location: ../perfil_cliente.php?id=". $id_cliente ."");
  $stmt->close();
}

$conexion->close();
?>