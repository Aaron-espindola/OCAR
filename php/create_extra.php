<?php
  require_once 'conexion.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // INSERT DE REPUESTOS
      $stmt_extra = $conexion->prepare("INSERT INTO comp_extra (desc_componente, valor_componente, id_arreglo) VALUES (?, ?, ?)");
      if ($stmt_extra === false) {
          die($conexion->error);
      }
      $stmt_extra->bind_param("sii", $descripcion, $valor_extra, $id_arreglo);

      $descripcion = $_POST["desc_extra"];
      $valor_extra= $_POST["valor_extra"];
      $id_arreglo = $_POST["id_arreglo"];
      $id_cliente = $_POST["id_cliente"];
      $patente = $_POST["patente"];
      $stmt_extra->execute();

      echo "Repuestos subidos correctamente con el id del arrego:" . $id_arreglo;

      $stmt_extra->close();
      header("Location: ../perfil_arreglos.php?idc=". $id_cliente ."&&patente=" . $patente . "&&ida=".$id_arreglo);
    } 

$conexion->close();
  ?>