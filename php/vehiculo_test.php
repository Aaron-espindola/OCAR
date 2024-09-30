<?php
require_once 'conexion.php';

// Iniciar transacción
$conexion->begin_transaction();

$id_cliente = $_GET['id']; // Patente del vehículo a eliminar
$patente = $_GET['patente'];
try {
    // Primero, obtenemos el id_arreglo asociado a la patente del vehículo
    $sql_obtener = "SELECT id_arreglo FROM arreglo WHERE patente = ?;";
    $stmt_obtener = $conexion->prepare($sql_obtener);
    $stmt_obtener->bind_param("s", $patente);
    $stmt_obtener->execute();
    $stmt_obtener->store_result();
    $stmt_obtener->bind_result($id_arreglo);
    $stmt_obtener->fetch();

  /////////////////////////////////////////////////////////// ELIMINACION DE PAGOS

    $sql_pago = "DELETE FROM pago WHERE id_presupuesto IN (SELECT id_presupuesto FROM presupuesto WHERE id_arreglo = ?);";
    $stmt_pago = $conexion->prepare($sql_pago);
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

    $sql_presupuestos = "DELETE FROM presupuesto WHERE id_arreglo = ?;";
    $stmt_presupuestos = $conexion->prepare($sql_presupuestos);
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

  $sql_extra = "DELETE FROM comp_extra WHERE id_arreglo = ?;";
  $stmt_extra = $conexion->prepare($sql_extra);
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

  /////////////////////////////////////////////////////////// ELIMINACION DE REPUESTOS

  $sql_repuestos = "DELETE FROM repuestos WHERE id_arreglo = ?;";
  $stmt_repuestos = $conexion->prepare($sql_repuestos);
  if ($stmt_repuestos === false) {
      die('prepare() failed: ' . htmlspecialchars($conexion->error));
  }
  $stmt_repuestos->bind_param("i", $id_arreglo);
  if ($stmt_repuestos->execute()) {
      echo "Repuestos eliminados correctamente";
      echo "<br>";
  } else {
      echo "Error: " . $conexion->error;
  }


  /////////////////////////////////////////////////////////// ELIMINACION DE ARREGLOS

  $sql_arreglos = "DELETE FROM arreglo WHERE id_arreglo = ?;";
  $stmt_arreglo = $conexion->prepare($sql_arreglos);
  if ($stmt_arreglo === false) {
    die('prepare() failed: ' . htmlspecialchars($conexion->error));
    }
  $stmt_arreglo->bind_param("i", $id_arreglo);
  if ($stmt_arreglo->execute()) {
      echo "Arreglos eliminados correctamente";
      echo "<br>";
  } else {
      echo "Error: " . $conexion->error;
  }
  
  ////////////////////////////////////////////////////////// ELIMINACION DE VEHICULOS

  $sql_vehiculos = "DELETE FROM vehiculo WHERE patente = ? AND id_cliente = ?;";
  $stmt_vehiculo = $conexion->prepare($sql_vehiculos);
  if ($stmt_vehiculo === false) {
    die('prepare() failed: ' . htmlspecialchars($conexion->error));
    }
    $stmt_vehiculo->bind_param("si", $patente, $id_cliente);
  if ($stmt_vehiculo->execute()) {
      echo "Vehiculos eliminados correctamente";
      echo "<br>";
  } else {
      echo "Error: " . $conexion->error;
  }

  // Si todo salió bien, confirmar los cambios
  $conexion->commit();
} catch (Exception $e) {
  // Si algo salió mal, revertir los cambios
  $conexion->rollback();
}

$conexion->close();


?>
