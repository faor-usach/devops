<?php
require_once('../fpdf/fpdf.php');
$link=Conectarse();

/*
$bdnInf=$link->query("SELECT * FROM tablaRegForm");
if ($rownInf=mysqli_fetch_array($bdnInf)){
	$nInf = $rownInf['nInforme'] + 1;
	$actSQL="UPDATE tablaRegForm SET ";
	$actSQL.="nInforme	='".$nInf."'";
	$bdnInf=$link->query($actSQL);
}
*/
$bdnInf=$link->query("SELECT * FROM formularios Order By nInforme Desc");
if ($rownInf=mysqli_fetch_array($bdnInf)){
	$nInf = $rownInf['nInforme'] + 1;
}
$bdDep=$link->query("SELECT * FROM departamentos");
if ($rowDep=mysqli_fetch_array($bdDep)){
	$NomDirector = $rowDep[NomDirector];
}
$link->close();

if($_POST['Formulario'] == "F3B1" || $_POST['Formulario'] == "F3B2"){

	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$pdf->Image('logos/sdt.png',10,10,33,25);
	$pdf->Image('logos/logousach.png',170,10,18,25);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
	$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
	$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOL�GICO',0,2,'C');
	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInforme,0,0,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,10,'FORMULARIO '.substr($_POST['Formulario'],1,2),1,0,'C');
	
	
	//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
	
	
	$pdf->Cell(130,10,'SOLICITUD DE REEMBOLSO',1,0,'L');
	$pdf->Ln(13);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(70,5,'FECHA:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'DE:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'SE�OR '.strtoupper($rowDep['NomDirector']).' ('.$rowDep['Cargo'].')',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,5,'A:',0,0);
	//$pdf->Cell(2,5,':',0,0);
	$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

	$pdf->Ln(5);
	$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
	//$pdf->Cell(2,5,':',0,0);

	$link=Conectarse();
	$bdPr=$link->query("SELECT * FROM proyectos Where IdProyecto = '".$_POST['IdProyecto']."'");
	if($row=mysqli_fetch_array($bdPr)){
		$pdf->Cell(110,10,$row['Proyecto'],1,0);
		$pdf->Ln(12);
		$pdf->Cell(70,10,'C�DIGO DEL PROYECTO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$_POST['IdProyecto'],1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'SE SOLICITA REEMBOLSO A NOMBRE DE:',0,0);
		//$pdf->Cell(2,5,':',0,0);

		// F3B(Itau) - IGT-1118 - Sin Iva -  Itau    Ok
		// F3B(Itau) - IGT-1118 - Con Iva -
		// F3B(Itau) - IGT-19   - Sin Iva -  Itau    Ok
		// F3B(Itau) - IGT-19   - Con Iva -
		if($Formulario=="F3B1"){
			$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N� ".$row['Cta_Corriente'].", Banco ".$row['Banco'],1,0);
			$JefeProyecto = $row['JefeProyecto'];
		}

		// F3B(AAA) - IGT-1118 - Sin Iva - Edwards     	Ok
		// F3B(AAA) - IGT-1118 - Con Iva -
		// F3B(AAA) - IGT-19   - Sin Iva - 				Ok
		// F3B(AAA) - IGT-19   - Con Iva -
		if($Formulario=="F3B2"){
			if($_POST['IdProyecto']=="IGT-1118"){
				$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N� ".$row['Cta_Corriente2'].", Banco ".$row['Banco2'],1,0);
				$JefeProyecto = $row['JefeProyecto'];
			}else{
				$pdf->Cell(110,10,$row['JefeProyecto'].", Cta.Cte. N� ".$row['Cta_Corriente'].", Banco ".$row['Banco'],1,0);
				$JefeProyecto = $row['JefeProyecto'];
			}
		}
		$pdf->Ln(12);
		$pdf->Cell(70,10,'RUT:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$row['Rut_JefeProyecto'],1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$Concepto,1,0);

		$pdf->Ln(12);
		$pdf->Cell(70,10,'CORREO ELECTR�NICO:',0,0);
		//$pdf->Cell(2,5,':',0,0);
		$pdf->Cell(110,10,$row['Email'],1,0);

	}

	$link->close();

	$pdf->SetFont('Arial','',7);

	$pdf->Ln(10);
	$pdf->Cell(70,5,'La relaci�n de gastos es la siguiente::',0,0);
	//$pdf->Cell(2,5,':',0,0);

	$pdf->SetFont('Arial','B',7);
	$pdf->Ln(5);
	if($Iva=="sIva"){
		$pdf->Cell(55,17,'Proveedor',1,0,'C');
		$pdf->Cell(18,17,'N� Factura',1,0,'C');
		$pdf->Cell(17,17,'Fecha',1,0,'C');
		$pdf->Cell(70,17,'Bien o Servicio Adquirido',1,0,'C');
		$pdf->Cell(20,17,'Monto',1,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(55,18,'',0,0,'C');
		$pdf->Cell(18,18,'o Boleta',0,0,'C');
		$pdf->Cell(17,18,'Factura o',0,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(55,20,'',0,0,'C');
		$pdf->Cell(18,20,'',0,0,'C');
		$pdf->Cell(17,20,'o Boleta',0,0,'C');
	}
	if($Iva=="cIva"){
		$pdf->Cell(50,17,'Proveedor',1,0,'C');
		$pdf->Cell(16,17,'N� Factura',1,0,'C');
		$pdf->Cell(17,17,'Fecha',1,0,'C');
		$pdf->Cell(60,17,'Bien o Servicio Adquirido',1,0,'C');
		$pdf->Cell(15,17,'Neto',1,0,'C');
		$pdf->Cell(15,17,'IVA',1,0,'C');
		$pdf->Cell(15,17,'Bruto',1,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(50,18,'',0,0,'C');
		$pdf->Cell(16,18,'o Boleta',0,0,'C');
		$pdf->Cell(17,18,'Factura o',0,0,'C');
		$pdf->Ln(2);
		$pdf->Cell(50,20,'',0,0,'C');
		$pdf->Cell(16,20,'',0,0,'C');
		$pdf->Cell(17,20,'o Boleta',0,0,'C');
	}
	if($Formulario=="F3B1"){
		if($Iva=="sIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && Iva = 0 && Neto = 0 && Estado != 'I'"; 
		}
		if($Iva=="cIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && Iva > 0 && Estado != 'I'"; 
		}
	}
	if($Formulario=="F3B2"){
		if($Iva=="sIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && Iva = 0 && Neto = 0 && Estado != 'I'"; 
		}
		if($Iva=="cIva"){
			$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' && Iva > 0 && Estado != 'I'"; 
		}
	}
	$pdf->SetFont('Arial','',6);

	$tBrupo = 0;
	$pdf->Ln(13);
	$nLn = 161;
	$nRegistros = 0;
	$link=Conectarse();
	$bdGto=$link->query("SELECT * FROM movgastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($row=mysqli_fetch_array($bdGto)){
		do{
			$nRegistros++;
			if($nRegistros == 20){
				$pdf->addPage();
				$nLn = 13;
			}
			// Inicio Linea de Detalle
			if($Iva=="sIva"){
				$pdf->SetXY(10,$nLn);
				$pdf->Cell(55,5,$row['Proveedor'],1,0);
				$pdf->Cell(18,5,$row['nDoc'],1,0,'R');
				$fd 	= explode('-', $row['FechaGasto']);
				$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
				$pdf->Cell(17,5,$Fecha,1,0,'C');
				$pdf->SetFont('Arial','',5);
				$pdf->Cell(70,5,$row['Bien_Servicio'],1,0);
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$nLn +=5;
				if($nLn>261){
					$pdf->AddPage();
					$nLn = 13;
				}
			}else{
				$pdf->SetXY(10,$nLn);
				$pdf->Cell(50,5,$row['Proveedor'],1,0);
				$pdf->SetXY(60,$nLn);
				$pdf->MultiCell(16,5,$row['nDoc'],1,'R');
				$fd 	= explode('-', $row['FechaGasto']);
				$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
				$pdf->SetXY(76,$nLn);
				$pdf->MultiCell(17,5,$Fecha,1,'C');
				$pdf->SetFont('Arial','',5);
				$pdf->SetXY(93,$nLn);
				if(strlen($row['Bien_Servicio'])>65){
					$pdf->MultiCell(60, 5,$row['Bien_Servicio'],1,'J');
										 //0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789
				}else{
					$pdf->MultiCell(60,5,$row['Bien_Servicio'],1,'J');
				}
				$pdf->SetXY(153,$nLn);
				$pdf->Cell(15,5,number_format($row['Neto'], 0, ',', '.'),1,0,'R');
				$pdf->SetXY(168,$nLn);
				$pdf->MultiCell(15,5,number_format($row['Iva'], 0, ',', '.'),1,'R');
				$pdf->SetXY(183,$nLn);
				$pdf->MultiCell(15,5,number_format($row['Bruto'], 0, ',', '.'),1,'R');
				$tNeto 	+= $row['Neto'];
				$tIva 	+= $row['Iva'];
				$tBruto += $row['Bruto'];
				$nLn +=5;
				if($nLn>261){
					$pdf->AddPage();
					$nLn = 13;
				}
			}
			
			//$nLn = $nLn + 1;
			// Termino Linea de Detalle
		}while ($row=mysqli_fetch_array($bdGto));
	}
	
	$FechaInforme = date('Y-m-d');

	$actSQL="UPDATE movgastos SET ";
	$actSQL.="Estado	    ='I',";
	$actSQL.="Modulo	    ='G',";
	$actSQL.="FechaInforme  ='".$FechaInforme."',";
	$actSQL.="nInforme  	='".$nInf."'";
	$actSQL.=$filtroSQL;
	$bdGto=$link->query($actSQL);

	$f = "F3B";
	$IdProyecto = $_POST['IdProyecto'];
	if($_POST['Formulario'] == "F3B1"){
		$f = "F3B(Itau)";
	}
	if($_POST['Formulario'] == "F3B2"){
		$f = "F3B(AAA)";
	}

	$Modulo 		= 'G';
	$Total 			= 0;
	$Retencion  	= 0;
	$Liquido 		= 0;
	$Fotocopia 		= 'off';
	$Reemboldo 		= 'off';
	$nDocumentos 	= 1;
	$fechaReembolso = date("Y-m-d", strtotime($fechaBlanca));
	$fechaFotocopia = date("Y-m-d", strtotime($fechaBlanca));

	$link->query("insert into formularios (	nInforme				,
											Modulo					,
											IdProyecto,
											Formulario				,
											Impuesto				,
											Fecha					,
											nDocumentos,
											Concepto				,
											Neto					,
											Iva						,
											Bruto					,
											Total,
											Retencion,
											Liquido,
											Fotocopia,
											fechaFotocopia,
											Reembolso,
											fechaReembolso
											) 
							values 		 (	'$nInf'
											'$Modulo',
											'$IdProyecto'			,
											'$f'					,
											'$Iva'					,
											'$FechaInforme'			,
											'$nDocumentos',
											'$Concepto'				,
											'$tNeto'				,
											'$tIva'					,
											'$tBruto'				,
											'$Total',
											'$Retencion',
											'$Liquido',
											'$Fotocopia',
											'$fechaFotocopia',
											'$Reembolso',
											'$fechaReembolso'
											)");


	$link->close();

	//$pdf->Ln(5);

	// Linea Total
	if($Iva=="sIva"){
		$pdf->Cell(55,5,'',0,0,'C');
		$pdf->Cell(18,5,'',0,0,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(70,5,'TOTAL',0,0,'R');
		$pdf->Cell(20,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}else{
		$pdf->Cell(50,5,'',0,0,'C');
		$pdf->Cell(16,5,'',0,0,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(60,5,'TOTAL',0,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tNeto, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tIva, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}

	$ln = $pdf->SetY();
	$ln = 250;

	$pdf->SetXY(10,$ln);

	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, $ln, 90, $ln);
	$pdf->Line(120, $ln, 190, $ln);

	$ln += 1;
	$pdf->SetXY(20,$ln);
	$pdf->SetXY(20,259);

	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->SetXY(20,$ln);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,$JefeProyecto,0,0,"C");
	$pdf->Cell(130,5,strtoupper($NomDirector),0,0,"C");
	
	$ln += 2;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");
	$pdf->Cell(130,5,"Director de Departamento",0,0,"C");

	$ln += 18;
	$pdf->SetXY(10,$ln);
	$Nota = "Nota: Especifique claramente el motivo que gener� los gastos detallados, evitando la devoluci�n de este formulario a su Unidad de origen";
	$pdf->Cell(180,5,$Nota,0,0,"L");


	//$pdf->Output('F3B-00001.pdf','I'); //Para Descarga
	$NombreFormulario = "F3B-".$nInf.".pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F3B-00001.pdf','F');
}

if($_POST['Formulario'] == "F7"){
	$pdf=new FPDF('P','mm','A4');
	$nDocumentos = 0;

	$link=Conectarse();

			$tNeto 	= 0;
			$tIva 	= 0;
			$tBruto = 0;
			
			$pdf->AddPage();
			$pdf->Image('logos/sdt.png',10,10,33,25);
			$pdf->Image('logos/logousach.png',170,10,18,25);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(40);
			$pdf->Cell(100,10,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,2,'C');
			$pdf->Cell(100,1,'SOCIEDAD DE DESARROLLO TECNOL�GICO',0,2,'C');
			$pdf->Ln(10);
			$pdf->Cell(370,5,$nInforme,0,0,'C');
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(50,10,'FORMULARIO F7',1,0,'C');
			//$pdf->Cell(50,10,'FORMULARIO '.$_POST['Formulario'],1,0,'C');
			$pdf->Cell(130,10,'SOLICITUD DE PAGO DE FACTURAS',1,0,'L');

			$pdf->Ln(13);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(70,5,'FECHA:',0,0);
			//$pdf->Cell(2,5,':',0,0);
			$pdf->Cell(110,5,date('d').'/'.date('m').'/'.date('Y'),0,0);

			$pdf->Ln(5);
			$pdf->Cell(70,5,'DE:',0,0);
			//$pdf->Cell(2,5,':',0,0);
			$pdf->Cell(110,5,strtoupper($rowDep['NomDirector']).' ('.$rowDep['Cargo'].')',0,0);
	
			$pdf->Ln(5);
			$pdf->Cell(70,5,'A:',0,0);
			//$pdf->Cell(2,5,':',0,0);
			$pdf->Cell(110,5,'DIRECTOR EJECUTIVO SOCIEDAD DE DESARROLLO TECNOLOGICO  (SDT)',0,0);

			$bdPr=$link->query("SELECT * FROM proyectos Where IdProyecto = '".$_POST['IdProyecto']."'");
			if($rowPr=mysqli_fetch_array($bdPr)){
				$JefeProyecto = $rowPr['JefeProyecto'];
				$pdf->Ln(5);
				$pdf->Cell(70,10,'NOMBRE DEL PROYECTO:',0,0);
				//$pdf->Cell(2,5,':',0,0);
				$pdf->Cell(110,10,$rowPr['Proyecto'],1,0);
				$pdf->Ln(12);
				$pdf->Cell(70,10,'C�DIGO DEL PROYECTO:',0,0);
				//$pdf->Cell(2,5,':',0,0);
				$pdf->Cell(110,10,$_POST['IdProyecto'],1,0);

				$pdf->Ln(12);
				$pdf->Cell(70,10,'CONCEPTO O MOTIVO  DE LOS GASTOS REALIZADOS:',0,0);
				//$pdf->Cell(2,5,':',0,0);
				//$pdf->Cell(110,10,$Concepto,1,0);
				$pdf->Cell(110,10,$Concepto,1,0);
			}
			$pdf->SetFont('Arial','',7);
		
			$pdf->Ln(10);
			$pdf->Cell(180,5,'DETALLE DE FACTURAS',0,0,"C");
	
			$pdf->SetFont('Arial','B',6);
			$pdf->Ln(5);
			if($Iva=="sIva"){
				$pdf->Cell(55,17,'PROVEEDOR',1,0,'C');
				$pdf->Cell(45,17,'CORREO ELECTR�NICO',1,0,'C');
				$pdf->Cell(20,17,'BANCO',1,0,'C');
				$pdf->Cell(20,17,'CTA. CTE.',1,0,'C');
				$pdf->Cell(20,17,'RUT',1,0,'C');
				$pdf->Cell(20,17,'VALOR TOTAL',1,0,'C');
			}
			if($Iva=="cIva"){
				$pdf->Cell(45,17,'PROVEEDOR',1,0,'C');
				$pdf->Cell(42,17,'CORREO ELECTR�NICO',1,0,'C');
				$pdf->Cell(17,17,'BANCO',1,0,'C');
				$pdf->Cell(16,17,'CTA. CTE.',1,0,'C');
				$pdf->Cell(15,17,'RUT',1,0,'C');
				$pdf->Cell(15,17,'NETO',1,0,'C');
				$pdf->Cell(15,17,'IVA',1,0,'C');
				$pdf->Cell(15,17,'BRUTO',1,0,'C');
			}

			$pdf->SetFont('Arial','',6);
			$tBrupo = 0;
			$pdf->Ln(12);

	if($Iva=="sIva"){
		$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' and IdRecurso = 5 and Iva = 0 and Estado != 'I'"; 
	}
	if($Iva=="cIva"){
		$filtroSQL = "Where IdProyecto ='".$_POST['IdProyecto']."' and IdRecurso = 5 and Iva > 0 and Estado != 'I'"; 
	}

	$bdGto=$link->query("SELECT * FROM movgastos ".$filtroSQL." Order By FechaGasto Desc");
	if ($rowGto=mysqli_fetch_array($bdGto)){
		do{
			// Inicio Linea de Detalle
			if($Iva=="sIva"){
				$pdf->Cell(55,5,$rowGto['Proveedor'],1,0).'- Sin Iva '.$Iva;
				$bdProv=$link->query("SELECT * FROM proveedores Where Proveedor = '".$rowGto['Proveedor']."'");
				if ($rowProv=mysqli_fetch_array($bdProv)){
					$pdf->Cell(45,5,$rowProv['Email'],1,0,'L');
					$pdf->Cell(20,5,$rowProv['Banco'],1,0,'L');
					$pdf->Cell(20,5,$rowProv['NumCta'],1,0,'C');
					$pdf->Cell(20,5,$rowProv['RutProv'],1,0,'C');
				}
				$pdf->Cell(20,5,number_format($row['Bruto'], 0, ',', '.'),1,0,'R');
				$tBruto += $row['Bruto'];
				$nDocumentos++;
				$pdf->Ln(5);
			}else{
				$pdf->Cell(45,5,$rowGto['Proveedor'],1,0).'- Con Iva '.$Iva;
				$bdProv=$link->query("SELECT * FROM proveedores Where Proveedor = '".$rowGto['Proveedor']."'");
				if ($rowProv=mysqli_fetch_array($bdProv)){
					$pdf->Cell(42,5,$rowProv['Email'],1,0,'L');
					$pdf->Cell(17,5,$rowProv['Banco'],1,0,'L');
					$pdf->Cell(16,5,$rowProv['NumCta'],1,0,'C');
					$pdf->Cell(15,5,$rowProv['RutProv'],1,0,'C');
				}
				$pdf->Cell(15,5,number_format($rowGto['Neto'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($rowGto['Iva'], 0, ',', '.'),1,0,'R');
				$pdf->Cell(15,5,number_format($rowGto['Bruto'], 0, ',', '.'),1,0,'R');
				$tNeto 	+= $rowGto['Neto'];
				$tIva 	+= $rowGto['Iva'];
				$tBruto += $rowGto['Bruto'];
				$nDocumentos++;
				$pdf->Ln(5);
			}
		}while ($rowGto=mysqli_fetch_array($bdGto));
	}
	$link->close();

	// Termino Linea de Detalle

			// Linea Total
	if($Iva=="sIva"){
		$pdf->Cell(55,5,'',0,0,'C');
		$pdf->Cell(45,5,'',0,0,'C');
		$pdf->Cell(20,5,'',0,0,'C');
		$pdf->Cell(20,5,'',0,0,'C');
		$pdf->Cell(20,5,'TOTAL',0,0,'R');
		$pdf->Cell(20,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}else{
		$pdf->Cell(45,5,'',0,0,'C');
		$pdf->Cell(42,5,'',0,0,'C');
		$pdf->Cell(17,5,'',0,0,'C');
		$pdf->Cell(16,5,'',0,0,'C');
		$pdf->Cell(15,5,'TOTAL',0,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tNeto, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tIva, 0, ',', '.'),1,0,'R');
		$pdf->Cell(15,5,"$ ".number_format($tBruto, 0, ',', '.'),1,0,'R');
	}

	$ln = 250;
		
	$pdf->SetXY(10,$ln);
		
	// Line(Col, FilaDesde, ColHasta, FilaHasta) 
	$pdf->Line(20, $ln, 90, $ln);
	$pdf->Line(120, $ln, 190, $ln);
		
	$ln += 1;
	$pdf->SetXY(20,$ln);
	$pdf->SetXY(20,259);
		
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->SetXY(20,$ln);
	//Cell(LargoMarco ,AltoMarco, Txt, VerMarco, ,Centro)
	$pdf->Cell(70,5,$JefeProyecto,0,0,"C");
	$pdf->Cell(130,5,strtoupper($NomDirector),0,0,"C");
			
	$ln += 2;
	$pdf->SetXY(20,$ln);
	$pdf->Cell(70,5,"Jefe de Proyecto",0,0,"C");
	$pdf->Cell(130,5,"Director de Departamento",0,0,"C");
		
	$ln += 18;
	$pdf->SetXY(10,$ln);
	$Nota = "Nota: Especifique claramente el motivo que gener� los gastos detallados, evitando la devoluci�n de este formulario a su Unidad de origen";
	$pdf->Cell(180,5,$Nota,0,0,"L");

	//$Concepto = $concepto;
	$IdProyecto = $_POST['IdProyecto'];

	$link=Conectarse();
	$FechaInforme    = date('Y-m-d');
	$actSQL  = "UPDATE movgastos SET ";
	$actSQL .= "Estado	    		= 'I',";
	$actSQL .= "FechaInforme  		= '".$FechaInforme.	"',";
	$actSQL .= "nInforme  			= '".$nInf.			"'";
	$actSQL .= $filtroSQL;
	$bdGto = $link->query($actSQL);
		
	$f = "F7";
	$Total 			= 0;
	$Retencion  	= 0;
	$Liquido 		= 0;
	$Fotocopia 		= 'off';
	$Reemboldo 		= 'off';
	$fechaReembolso = date("Y-m-d", strtotime($fechaBlanca));
	$fechaFotocopia = date("Y-m-d", strtotime($fechaBlanca));
	$Modulo 		= 'G';

	$link->query("insert into formularios (	nInforme				,
											Modulo					,
											IdProyecto				,
											Formulario				,
											Impuesto				,
											Fecha					,
											nDocumentos				,
											Concepto				,
											Neto					,
											Iva						,
											Bruto					,
											Total,
											Retencion,
											Liquido,
											Fotocopia,
											fechaFotocopia,
											Reembolso,
											fechaReembolso
											) 
									values 	 (	'$nInf'				,
												'$Modulo',
												'$IdProyecto'		,
												'$f'				,
												'$Iva'				,
												'$FechaInforme'		,
												'$nDocumentos'		,
												'$Concepto'			,
												'$tNeto'			,
												'$tIva'				,
												'$tBruto'			,
												'$Total',
												'$Retencion',
												'$Liquido',
												'$Fotocopia',
												'$fechaFotocopia',
												'$Reembolso',
												'$fechaReembolso'
												)");
	$link->close();

	//$pdf->Output('F7-00001.pdf','I');
	$NombreFormulario = "F7.pdf";
	$pdf->Output($NombreFormulario,'D'); //Para Descarga
	//$pdf->Output('F7-00001.pdf','D');
	//$pdf->Output('F7-00001.pdf','F');
}

?>
