<?php

require_once 'conexion.php';

// Obtener el ID del cliente de la URL
$patente = $_GET['patente'];
$id_arreglo = $_GET['ida'];
$id_cliente = $_GET['idc'];

 /////////////////////////////////////////////////////////// ELIMINACION DE PAGOS

 $query_pago = "DELETE FROM pago WHERE id_presupuesto IN (SELECT id_presupuesto FROM presupuesto WHERE id_arreglo = ?);";
 $stmt_pago = $conexion->prepare($query_pago);

 if ($stmt_pago === false) {
     die('prepare() failed: ' . htmlspecialchars($conexion->error));
 }
 $stmt_pago->bind_param("i", $id_arreglo);

if ($stmt_pago->execute()) {
   echo "Pagos eliminados correctamente";
   echo "<br>";
} else {
   echo "Error: " . $conexion->error;
}

 ///////////////////////////////////////////////////////// ELIMINACION DE PRESUPUESTOS

 $query_presupuestos = "DELETE FROM presupuesto WHERE id_arreglo = ?;";
 $stmt_presupuestos = $conexion->prepare($query_presupuestos);
 if ($stmt_presupuestos === false) {
     die('prepare() failed: ' . htmlspecialchars($conexion->error));
 }
 $stmt_presupuestos->bind_param("i", $id_arreglo);

 if ($stmt_presupuestos->execute()) {
   echo "Presupuestos eliminados correctamente";
   echo "<br>";
 } else {
   echo "Error: " . $conexion->error;
}


  /////////////////////////////////////////////////////////// ELIMINACION DEL COMP_EXTRA

  $query_extra = "DELETE FROM comp_extra WHERE id_arreglo = ?;";
  $stmt_extra = $conexion->prepare($query_extra);
  if ($stmt_extra === false) {
      die('prepare() failed: ' . htmlspecialchars($conexion->error));
  }
  $stmt_extra->bind_param("i", $id_arreglo);
  if ($stmt_extra->execute()) {
      echo "Componentes extras eliminados correctamente";
      echo "<br>";
  } else {
      echo "Error: " . $conexion->error;
  }


/////////////////////////////////////////////////////////// ELIMINAR REPUESTOS
$query_repuestos = "DELETE FROM repuestos WHERE id_arreglo = ?";

// Crear una declaración preparada
$stmt_repuestos = $conexion->prepare($query_repuestos);
if ($stmt_repuestos === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}else{
    echo "El REPUESTO se elimino correctamente :)";
}
$stmt_repuestos->bind_param("s", $id_arreglo);
if ($stmt_repuestos->execute()) {
    echo "Componentes extras eliminados correctamente";
    echo "<br>";
} else {
    echo "Error: " . $conexion->error;
}



/////////////////////////////////////////////////////////// ELIMAR ARREGLOS
$query_arreglo = "DELETE FROM arreglo WHERE id_arreglo = ?";

$stmt_arreglo = $conexion->prepare($query_arreglo);
if ($stmt_arreglo === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}else{
    echo "El ARREGLO se elimino correctamente :)";
}
$stmt_arreglo->bind_param("s", $id_arreglo);

$stmt_arreglo->execute();
if ($stmt_arreglo->execute()) {
    echo "Componentes extras eliminados correctamente";
    echo "<br>";
    header("Location: ../perfil_cliente_datos.php?id=". $id_cliente ."&&patente=" . $patente . "");
} else {
    echo "Error: " . $conexion->error;
}

?>
