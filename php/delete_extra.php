<?php
require_once 'conexion.php';

$id_extra = $_GET['ide'];
$patente = $_GET['patente'];

$sql_extra = "DELETE FROM comp_extra WHERE id_extra = ? ;";
$stmt_extra = $conexion->prepare($sql_extra);
if ($stmt_extra === false) {
    die('prepare() failed: ' . htmlspecialchars($conexion->error));
}
$stmt_extra->bind_param("i", $id_extra);
if ($stmt_extra->execute()) {
    echo "Componentes extras eliminados correctamente";
    header("Location: ../perfil_cliente_datos.php?patente=" . $patente . "");
    echo "<br>";

} else {
    echo "Error: " . $conexion->error;
}

$conexion->close();
?>