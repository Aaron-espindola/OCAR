<?php
	require_once '../php/conexion.php';
	if (isset($_GET['idc'])) {
		$id_cliente = $_GET['idc'];
	} else {
		// Manejar el caso en que 'id' no está definido
	}   
	if (isset($_GET['ida'])) {
		$id_arreglo = $_GET['ida'];
	} else {
		// Manejar el caso en que 'id' no está definido
	}
	if (isset($_GET['idp'])) {
		$id_presupuesto = $_GET['idp'];
	} else {
		// Manejar el caso en que 'id' no está definido
	}
	if (isset($_GET['patente'])) {
		$patente = $_GET['patente'];
	} else {
		// Manejar el caso en que 'id' no está definido
	}
?>


<?php

	# Incluyendo librerias necesarias #
	require "code128.php";
	require_once '../php/conexion.php';

	$pdf = new PDF_Code128('P','mm','Letter');
	$pdf->SetMargins(17,17,17);
	$pdf->AddPage();

	# Logo de la empresa formato png #
	$pdf->Image('./img/icon.png',165,12,35,35,'PNG');

	# Encabezado y datos de la empresa #
	$pdf->SetFont('Arial','B',16);
	$pdf->SetTextColor(32,100,210);
	$pdf->Cell(150,10,iconv("UTF-8", "ISO-8859-1",strtoupper("O_CAR")),0,0,'L');

	$pdf->Ln(9);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","RUC: 0000000000"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Gonzalez Catan, Argentina"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Teléfono: +54 9 11 1306 3393"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Email: o_car_taller@gmail.com"),0,0,'L');

	$pdf->Ln(10);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1","Fecha de emisión:"),0,0);
	$pdf->SetTextColor(97,97,97);
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	$pdf->Cell(116,7,iconv("UTF-8", "ISO-8859-1",date("d/m/Y")." ".date("h:i A")),0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",strtoupper("Factura Nro.")),0,0,'C');
	$pdf->SetFont('Arial','',10);


	$pdf->Ln(10);

/////////////////////////////////////////////////////////////////////////////// DATOS DEL CLIENTE
	$query_cliente = "SELECT * FROM cliente WHERE id_cliente = $id_cliente";
	$result_cliente = $conexion->query($query_cliente);
	if ($result_cliente->num_rows > 0) {
		$fila_cliente = $result_cliente->fetch_assoc();

		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(39,39,51);
		$pdf->Cell(13,7,iconv("UTF-8", "ISO-8859-1","Cliente:"),0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1", $fila_cliente['nombre_c'] . ' ' . $fila_cliente['apellido_c']),0,0,'L');
		$pdf->SetTextColor(39,39,51);
		$pdf->Cell(8,7,iconv("UTF-8", "ISO-8859-1","DNI: "),0,0,'L');
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1", $fila_cliente['dni']),0,0,'L');
		$pdf->SetTextColor(39,39,51);
		$pdf->Cell(7,7,iconv("UTF-8", "ISO-8859-1","Tel:"),0,0,'L');
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1", $fila_cliente['telefono']),0,0);
		$pdf->SetTextColor(39,39,51);
	
		$pdf->Ln(7);
	
		$pdf->SetTextColor(39,39,51);
		$pdf->Cell(6,7,iconv("UTF-8", "ISO-8859-1","Dir:"),0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(109,7,iconv("UTF-8", "ISO-8859-1", $fila_cliente['calle'] . ' ' . $fila_cliente['numero'] . ' ' . $fila_cliente['localidad']),0,0);
	} else {
    	echo "No se encontraron resultados del cliente";
	}	

	$pdf->Ln(9);
/////////////////////////////////////////////////////////////////////////// DATOS DE LOS REPUESTOS
	// Tabla de productos # CREACION DE LA TABLA
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(23,83,201);
	$pdf->SetDrawColor(23,83,201);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(90,8,iconv("UTF-8", "ISO-8859-1","Repuestos"),1,0,'C',true);
	$pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1","Reparacion"),1,0,'C',true);
	$pdf->Cell(25,8,iconv("UTF-8", "ISO-8859-1","Valor reparacion"),1,0,'C',true);
	$pdf->Cell(19,8,iconv("UTF-8", "ISO-8859-1","Compra"),1,0,'C',true);
	$pdf->Cell(32,8,iconv("UTF-8", "ISO-8859-1","Valor compra"),1,0,'C',true);

	$pdf->Ln(8);

	
	$pdf->SetTextColor(39,39,51);

///////////////////////////////////////////////////////////////////////// DETALLES DE LOS REPUESTOS
	/*----------  Detalles de la tabla  ----------*/

	// Consulta para obtener los arreglos
	$quert_repuestos = "SELECT * FROM repuestos
    WHERE id_arreglo = '$id_arreglo'";
	$result_repuestos = $conexion->query($quert_repuestos);

	if ($result_repuestos->num_rows > 0) {
		// Iterar sobre los resultados
		while($fila_repuestos = $result_repuestos->fetch_assoc()) {
			// Agregar el arreglo al PDF
			$pdf->Cell(90,7,iconv("UTF-8", "ISO-8859-1", $fila_repuestos['desc_repuesto']),'L',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1", $fila_repuestos['reparacion']),'L',0,'C');
			$pdf->Cell(25,7,iconv("UTF-8", "ISO-8859-1","$".$fila_repuestos['valor_reparacion']),'L',0,'C');
			$pdf->Cell(19,7,iconv("UTF-8", "ISO-8859-1",$fila_repuestos['compra']),'L',0,'C');
			$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","$".$fila_repuestos['valor_compra']),'LR',0,'C');
			$pdf->Ln(7);
		}
	} else {
		echo "No se encontraron resultados de los repuestos";
	}
	$pdf->SetFont('Arial','B',9);
	/*----------  Fin Detalles de la tabla  ----------*/
	
///////////////////////////////////////////////////////////////////////////// DATOS DE COMPONENTES EXTRAS
	// Tabla de productos # CREACION DE LA TABLA
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(23,83,201);
	$pdf->SetDrawColor(23,83,201);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(90,8,iconv("UTF-8", "ISO-8859-1","Componenetes extras"),1,0,'C',true);
	$pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1"," "),1,0,'C',true);
	$pdf->Cell(25,8,iconv("UTF-8", "ISO-8859-1"," "),1,0,'C',true);
	$pdf->Cell(19,8,iconv("UTF-8", "ISO-8859-1"," "),1,0,'C',true);
	$pdf->Cell(32,8,iconv("UTF-8", "ISO-8859-1","Valor del componente"),1,0,'C',true);

	$pdf->Ln(8);


	$pdf->SetTextColor(39,39,51);
///////////////////////////////////////////////////////////////////////////// DATOS DE COMPONENTES EXTRAS
	/*----------  Detalles de la tabla  ----------*/

	// Consulta para obtener los componentes extras

	$quert_extra = "SELECT *
    FROM comp_extra
    WHERE id_arreglo =  '$id_arreglo';";

	$result_extra = $conexion->query($quert_extra);

	if ($result_extra->num_rows > 0) {
		// Iterar sobre los resultados
		while($fila_extra = $result_extra->fetch_assoc()) {
			// Agregar el arreglo al PDF
			$pdf->Cell(90,7,iconv("UTF-8", "ISO-8859-1", $fila_extra['desc_componente']),'L',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1"," "),'L',0,'C');
			$pdf->Cell(25,7,iconv("UTF-8", "ISO-8859-1"," "),'L',0,'C');
			$pdf->Cell(19,7,iconv("UTF-8", "ISO-8859-1"," "),'L',0,'C');
			$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","$".$fila_extra['valor_componente']),'LR',0,'C');
			$pdf->Ln(7);
		}
	} else {
		echo "No se encontraron resultados de los componenetes extra";
	}
	$pdf->SetFont('Arial','B',9);
	/*----------  Fin Detalles de la tabla  ----------*/
////////////////////////////////////////////////////////////////////////// SUMA DE LOS VALORES
	
	// Consulta para obtener los valores de reparacion y compra
	$consultaRepuestos = $conexion->prepare("SELECT SUM(valor_reparacion) AS total_valor_rep, SUM(valor_compra) AS total_valor_com
	FROM repuestos 
	WHERE id_arreglo = ?");
	$consultaRepuestos->bind_param("i", $id_arreglo);
	$consultaRepuestos->execute();
	$resultadoRepuestos = $consultaRepuestos->get_result();
	$filaRepuestos = $resultadoRepuestos->fetch_assoc();
	$totalValorRep = $filaRepuestos['total_valor_rep'];
	$totalValorCom = $filaRepuestos['total_valor_com'];

	// Consulta para obtener la mano de obra
	$consultaPresupuestos = $conexion->prepare("SELECT mano_obra FROM presupuesto WHERE id_arreglo = ?");
	$consultaPresupuestos->bind_param("i", $id_arreglo);
	$consultaPresupuestos->execute();
	$resultadoPresupuestos = $consultaPresupuestos->get_result();
	$filaPresupuestos = $resultadoPresupuestos->fetch_assoc();
	$manoDeObra = $filaPresupuestos['mano_obra'];
	

	// Consulta para obtener el valor de los componentes extras
	$consultaComponentes = $conexion->prepare("SELECT SUM(valor_componente) AS total_valor_extra 
	FROM comp_extra 
	WHERE id_arreglo = ?");

	$consultaComponentes->bind_param("i", $id_arreglo);
	$consultaComponentes->execute();
	$resultadoComponentes = $consultaComponentes->get_result();
	$filaComponentes = $resultadoComponentes->fetch_assoc();
	$totalValorExtra = $filaComponentes['total_valor_extra'];


	

	// Consulta para obtener el total pagado
	$consultaPagos = "SELECT monto FROM pago WHERE id_presupuesto = $id_presupuesto"; // Ajusta esta consulta según tus necesidades
	$resultadoPagos = $conexion->query($consultaPagos);
	$filaPagos = $resultadoPagos->fetch_assoc();
	// $totalPagado = $filaPagos['monto'];
	if ($filaPagos !== null) {
		$totalPagado = $filaPagos['monto'];
	} else {
		// Manejar el caso en que no hay resultados
		$totalPagado = 0;
	}
	

	// Calcular el subtotal y el total a pagar
	$subtotal = $totalValorRep + $totalValorCom + $totalValorExtra;
	$totalAPagar = $subtotal + $manoDeObra;

	// Agregar los datos al PDF
	$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","SUBTOTAL + EXTRAS"),'T',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ $".$subtotal." ARG"),'T',0,'C');

	$pdf->Ln(7);

	// $pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	// $pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	// $pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","COMPONENTES EXTRAS"),'',0,'C');
	// $pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ $".$totalValorExtras." ARG"),'',0,'C');

	// $pdf->Ln(7);

	$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","MANO DE OBRA"),'',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ $".$manoDeObra." ARG"),'',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR"),'T',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","$".$totalAPagar." ARG"),'T',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');


	$pdf->Ln(7);

	$pdf->Ln(12);

	$pdf->SetFont('Arial','',9);

	$pdf->SetTextColor(39,39,51);
	$pdf->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1","*** Precios de productos incluyen impuestos. Para poder realizar un reclamo debe de presentar esta factura ***"),0,'C',false);

	$pdf->Ln(9);

	# Codigo de barras #
	$pdf->SetFillColor(39,39,51);
	$pdf->SetDrawColor(23,83,201);
	$pdf->Code128(72,$pdf->GetY(),"COD000001V0001",70,20);
	$pdf->SetXY(12,$pdf->GetY()+21);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","COD000001V0001"),0,'C',false);

	# Nombre del archivo PDF #
	$pdf->Output("I","Factura_Nro_1.pdf",true);