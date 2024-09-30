<?php
    require_once 'conexion.php';

      if ($_SERVER["REQUEST_METHOD"] == "POST") {

          // INSERT DE REPUESTOS
          $stmt_repuestos = $conexion->prepare("INSERT INTO repuestos (desc_repuesto, reparacion, valor_reparacion, lugar_reparacion, compra, valor_compra, lugar_compra, origen_repuesto, id_arreglo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
          if ($stmt_repuestos === false) {
              die($conexion->error);
          }
          $stmt_repuestos->bind_param("ssississi", $descripcion, $reparacion, $valor_rep, $lugar_rep, $compra, $valor_compra, $lugar_compra, $or_repuesto, $id_arreglo);

          $descripcion = $_POST["desc_repuesto"];
          $reparacion = $_POST["reparado"];
          $valor_rep = $_POST["valor_reparacion"];
          $lugar_rep = $_POST["lugar_reparacion"];
          $compra = $_POST["comprado"];
          $valor_compra = $_POST["valor_compra"];
          $lugar_compra = $_POST["lugar_compra"];
          $or_repuesto = $_POST["origen_r"];
          $id_arreglo = $_POST["id_arreglo"];
          $id_cliente = $_POST["id_cliente"];
          $patente = $_POST["patente"];
          $stmt_repuestos->execute();

          echo "Repuestos subidos correctamente con el id del arrego:" . $id_arreglo;

          $stmt_repuestos->close();
          header("Location: ../perfil_arreglos.php?idc=". $id_cliente ."&&patente=" . $patente . "&&ida=".$id_arreglo);
        } 

    $conexion->close();
  ?>