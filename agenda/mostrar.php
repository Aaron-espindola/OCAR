<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require '../php/conexion.php';
 
$accion = (isset($_GET['accion']))?$_GET['accion']:'leer';

switch ($accion) {
    case 'agregar':
        $stmt_agregar = $conexion->prepare("INSERT INTO eventos (title, descripcion, color, textColor, start, end)
        VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt_agregar === false) {
                die($conexion->error);
            }
        $stmt_agregar->bind_param("ssssss", $title, $descripcion, $color, $textColor, $start, $end);
        
        $title = $_POST['title'];
        $descripcion = $_POST['descripcion'];
        $color = $_POST['color'];
        $textColor = $_POST['textColor'];
        $start = $_POST['start'];
        $end = $_POST['end'];

        $respuesta_agregar = array();
            if ($stmt_agregar->execute()) {
                $respuesta['exito'] = true;
            } else {
                $respuesta['exito'] = false;
            }
        $stmt_agregar->close();
        echo json_encode($respuesta_agregar);
        break;
    case 'eliminar':
            // echo"Eliminar";
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $stmt_delete = $conexion->prepare("DELETE FROM eventos WHERE id = ?");
                $stmt_delete->bind_param("i", $id);

                $respuesta_delete = array();
                    if ($stmt_delete->execute()) {
                        $respuesta_delete['exito'] = true;
                    } else {
                        $respuesta_delete['exito'] = false;
                    }
                $stmt_delete->close();
                echo json_encode($respuesta_delete);
            }            
        break;
    case 'modificar':
        //    echo"Modificar";
           $stmt_modificar = $conexion->prepare("UPDATE eventos SET
           title = ?,
           descripcion = ?,
           color = ?,
           textColor = ?,
           start = ?,
           end = ?
           WHERE id = ?");
            if ($stmt_modificar === false) {
                die($conexion->error);
            }
           $stmt_modificar->bind_param("ssssssi", $title, $descripcion, $color, $textColor, $start, $end, $id);

        
           $title = $_POST['title'];
           $descripcion = $_POST['descripcion'];
           $color = $_POST['color'];
           $textColor = $_POST['textColor'];
           $start = $_POST['start'];
           $end = $_POST['end'];
           $id = $_POST['id'];

           $respuesta_modificar = array();
               if ($stmt_modificar->execute()) {
                   $respuesta['exito'] = true;
               } else {
                   $respuesta['exito'] = false;
               }
            $stmt_modificar->close();
            echo json_encode($respuesta_modificar);
        break;
    default:
            $query_eventos = $conexion->prepare("SELECT * FROM eventos");
            $query_eventos->execute();
                
            $resultado_evento = $query_eventos->get_result();
                
            $eventos_array = [];
            while ($row = $resultado_evento->fetch_assoc()) {
                $eventos_array[] = $row;
            }
            $json_resultado = json_encode($eventos_array);
            echo $json_resultado;
        break;
}
?>
