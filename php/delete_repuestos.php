<!-- PARA ELIMINAR LAS REPUESTOS SE DEBE PRIMERO ELIMINAR LOS PAGOS -> COMPONENTES EXTRAS-> PRESUPUESTOS Y RECIEN ARREGLOS-->

<?php

require_once 'conexion.php';

// Obtener el ID del cliente de la URL

$id_repuesto = $_GET['idr'];
$id_cliente = $_GET['idc'];
$id_arreglo = $_GET['ida'];
$patente = $_GET['patente'];
echo "ID CLIENTE: " .$id_cliente;
echo "<br>";
echo "ID REPUESTO: " .$id_repuesto;

//luego abra que agregar la eliminacion de pagos - compronentes extras y repuestos, luego presupuestos Y

// A LO ULTIMO Prepara la consulta SQL para eliminar los arrelgos del cliente
$query_delete = "DELETE FROM repuestos WHERE id_repuesto = ?";

// Crear una declaración preparada
$stmt_delete = $conexion->prepare($query_delete);
if ($stmt_delete === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}else{
    echo "El arreglo se elimino correctamente :)";
    header("Location: ../perfil_arreglos.php?idc=".$id_cliente ."&&patente=" . $patente . "&&ida=".$id_arreglo);
}

// Vincular los parámetros
$stmt_delete->bind_param("s", $id_repuesto);

// Ejecutar la consulta
$stmt_delete->execute();

?>