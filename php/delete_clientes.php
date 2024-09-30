<?php
require_once 'conexion.php';

$id_cliente = $_GET['id'];

/////////////////////////////////////////////////////////// ELIMINACION DEL PAGO

$sql_pago = " DELETE FROM pago WHERE id_presupuesto IN (SELECT id_presupuesto FROM presupuesto WHERE id_arreglo IN (SELECT id_arreglo FROM arreglo WHERE patente IN (SELECT patente FROM vehiculo WHERE id_cliente = ?)));";
$stmt_pago = $conexion->prepare($sql_pago);
$stmt_pago->bind_param("i", $id_cliente);
if ($stmt_pago->execute()) {
    echo "Pagos eliminados correctamente";
    echo "<br>";
} else {
    echo "Error: " . $conexion->error;
}

/////////////////////////////////////////////////////////// ELIMINACION DE PRESUPUESTOS

$sql_presupuestos = "DELETE FROM presupuesto WHERE id_arreglo IN (SELECT id_arreglo from arreglo where patente in(select patente from vehiculo where id_cliente = ?));";
$stmt_presupuestos = $conexion->prepare($sql_presupuestos);
$stmt_presupuestos->bind_param("i", $id_cliente);
if ($stmt_presupuestos->execute()) {
    echo "Presupuestos eliminados correctamente";
    echo "<br>";
} else {
    echo "Error: " . $conexion->error;
}

/////////////////////////////////////////////////////////// ELIMINACION DE REPUESTOS

$sql_repuestos = "DELETE FROM repuestos WHERE id_repuesto IN (SELECT id_repuesto FROM repuestos WHERE id_arreglo IN (SELECT id_arreglo FROM arreglo WHERE patente IN (SELECT patente FROM vehiculo WHERE id_cliente = ?)));";
$stmt_repuestos = $conexion->prepare($sql_repuestos);
if ($stmt_repuestos === false) {
    die('prepare() failed: ' . htmlspecialchars($conexion->error));
}
$stmt_repuestos->bind_param("i", $id_cliente);
if ($stmt_repuestos->execute()) {
    echo "Repuestos eliminados correctamente";
    echo "<br>";
} else {
    echo "Error: " . $conexion->error;
}

/////////////////////////////////////////////////////////// ELIMINACION DEL COMP_EXTRA

$sql_extra = "DELETE FROM comp_extra WHERE id_arreglo IN (SELECT id_arreglo FROM arreglo WHERE patente IN (SELECT patente FROM vehiculo WHERE id_cliente = ?));";
$stmt_extra = $conexion->prepare($sql_extra);
if ($stmt_extra === false) {
    die('prepare() failed: ' . htmlspecialchars($conexion->error));
}
$stmt_extra->bind_param("i", $id_cliente);
if ($stmt_extra->execute()) {
    echo "Componentes extras eliminados correctamente";
    echo "<br>";
} else {
    echo "Error: " . $conexion->error;
}


/////////////////////////////////////////////////////////// ELIMINACION DE ARREGLOS

$sql_arreglos = "DELETE from arreglo where patente in(select patente from vehiculo where id_cliente = ?);";
$stmt_arreglo = $conexion->prepare($sql_arreglos);
$stmt_arreglo->bind_param("i", $id_cliente);
if ($stmt_arreglo->execute()) {
    echo "Arreglos eliminados correctamente";
    echo "<br>";
} else {
    echo "Error: " . $conexion->error;
}
 
////////////////////////////////////////////////////////// ELIMINACION DE VEHICULOS

$sql_arreglos = "DELETE from vehiculo where id_cliente =?;";
$stmt_arreglo = $conexion->prepare($sql_arreglos);
$stmt_arreglo->bind_param("i", $id_cliente);
if ($stmt_arreglo->execute()) {
    echo "Vehiculos eliminados correctamente";
    echo "<br>";
} else {
    echo "Error: " . $conexion->error;
}

////////////////////////////////////////////////////////// ELIMINACION DE CLIENTES

$sql_cliente = "DELETE from cliente where id_cliente=?;";
$stmt_cliente = $conexion->prepare($sql_cliente);
$stmt_cliente->bind_param("i", $id_cliente);
if ($stmt_cliente->execute()) {
    echo "Clientes eliminados correctamente";
    echo "<br>";
} else {
    echo "Error: " . $conexion->error;
} 

header("Location: ../consulta_cliente.php");
// Cerrar la conexión
$conexion->close();
?>
