<?php
    require_once 'conexion.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos del arreglo del formulario
    $fecha_ingreso = $_POST['fecha_i'];
    $fecha_salida = isset($_POST['fecha_s']) ? $_POST['fecha_s'] : NULL;
    $descripcion = $_POST['descrip_arreglo'];
    $kilometros = $_POST['km'];
    $patente = $_POST['patente'];
    $id_cliente = $_POST['id_cliente'];
    // Preparar la consulta SQL
    $sql = "INSERT INTO arreglo (id_arreglo, fecha_ingr, fecha_salida, desc_arreglo, kilometros, patente) VALUES (?, ?, ?, ?, ?, ?)";

    // Crear una declaración preparada
    $stmt = $conexion->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    // Vincular los parámetros
    $stmt->bind_param("isssis", $id_arreglo, $fecha_ingreso, $fecha_salida, $descripcion, $kilometros, $patente);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Vehiculo Agregado correctamente";
        echo "<br>";
        header("Location: ../perfil_cliente_datos.php?id=". $id_cliente ."&&patente=" . $patente . "");
    } else {
        echo "Error: " . $conexion->error;
    }
    // Cerrar la conexión
    $conexion->close();
    }
?>