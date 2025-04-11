<?php
		//header('Content-Type: text/html; charset=UTF-8');
		include("../conexion.php");
?>
<HTML LANG="es">
	<head>
		<!-- <meta http-equiv="content-type" content="text/html; charset=iso-8859-1"> -->
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<TITLE>::. Exportacion de Datos .::</TITLE>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="../css/styles.css" 	rel="stylesheet" type="text/css">
		<link href="../css/tpv.css" 	rel="stylesheet" type="text/css">
		<link href="../estilos.css" 	rel="stylesheet" type="text/css">

		<link rel="shortcut icon" href="../favicon.ico" />
		<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
		<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
		<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	</head>
	<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>

	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/other_48.png" width="32" height="32" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Subir Tabla UF
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesi�n">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#" title="Agregar Cotizaci�n" onClick="registraEncuesta(0, 'Agrega')">
						<img src="../imagenes/add_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Men� Principal">
						<img src="../gastos/imagenes/Menu.png" width="32" height="32">
					</a>
				</div>
			</div>

			<div id="tablaDatosAjax">
				<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->
				<form name="importa" method="post" action="importar.php" enctype="multipart/form-data" >
					<input type="file" name="excel" />
					<input type='submit' name='enviar'  value="Importar"  />
					<input type="hidden" value="upload" name="action" />
				</form>
				<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->
			</div>
			<?php
	
			$archivo 		= $_FILES['excel']['name'];
			$tipo_archivo 	= $_FILES['excel']['type'];
			$tamano_archivo = $_FILES['excel']['size'];
			$desde 			= $_FILES['excel']['tmp_name'];
	
			if (($tipo_archivo == "application/vnd.ms-excel" || $tipo_archivo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) { 
				if (move_uploaded_file($desde, $archivo)){ 
					echo "<div style='background-color: red; color: #fff;'>El archivo ".$archivo." ha sido cargado correctamente....</div>";
				}else{ 
					echo "Ocurri� alg�n error al subir el fichero ".$archivo." No pudo guardarse.... ');</script>";
				} 
				
			}
			
			if (isset($_POST['enviar'])){
				echo '<div id="tablaDatosAjax">';
	
				require_once 'exelmysql/excelamysql/Classes/PHPExcel/IOFactory.php';
				$objPHPExcel = PHPExcel_IOFactory::load($archivo);
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
					$worksheetTitle     = $worksheet->getTitle();
					$highestRow         = $worksheet->getHighestRow(); // e.g. 10
					$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					$nrColumns = ord($highestColumn) - 64;
/*					
					echo "<br>La Hoja ".$worksheetTitle." cuenta con ";
					echo $nrColumns . ' columnas (A-' . $highestColumn . ') '; 
					echo ' y ' . $highestRow . ' registros.';
*/					
					echo '<br><table width="100%"  border="1" cellpadding="0" cellspacing="0" style="font-size:8px;" id="CajaTiluloCAM"><tr>';
					for ($row = 1; $row <= $highestRow; ++ $row) {
						echo '<tr>';
						for ($col = 0; $col < $highestColumnIndex; ++ $col) {
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							$val = $cell->getValue();
							$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
							$diaUf = $row;
							if($row == 1){
								echo '<td align="center" style="color:#fff;background-color:#666666;">' . $val . '</td>';
							}else{
								if($col == 0){
									echo '<td align="center" style="color:#fff;background-color:#666666;">' . $val . '</td>';
								}else{
									$diaUf--;
									$mesUf = $col;
									$fechaHoy 	= date('Y-m-d');
									$fd 		= explode('-', $fechaHoy);
									
									if($diaUf<10) 	{ $diaUf = '0'.$diaUf; }
									if($mesUF<10) 	{ $mesUf = '0'.$mesUf; }
									
									$fechaUF 	= $diaUf.'-'.$mesUf.'-'.$fd[0];
									$fechaUfSis	= $fd[0].'-'.$mesUf.'-'.$diaUf;
									
									echo '<td align="center"><strong>';
										if($val > 0){
											echo number_format($val,2,",",".");
										}
									echo '</strong></td>';
									if($fechaUfSis != '0000-00-00'){
										if($val >0){
											$link=Conectarse();
											$bdUf=mysql_query("SELECT * FROM UF Where fechaUF Like '".$fechaUfSis."'");
											if ($rowUf=mysql_fetch_array($bdUf)){
					/*
												$actSQL="UPDATE uf SET ";
												$actSQL.="fecha		='".$fechaUF."',";
												$actSQL.="uf			='".$val."'";
												$actSQL.="WHERE fecha 	= '".$fechaUF."'";
												$bdUf	= mysql_query($actSQL);
					*/							
											}else{
												mysql_query("insert into UF ( 	fechaUF,
																				ValorUF
																			) 
																	values	(	'$fechaUfSis',
																				'$val'
																			)",$link);
											}
											mysql_close($link);
										}
									}
	
								}
							}
							if ($row>1){
								switch ($col) {
									case 0: $dia 	= $val; break;
									case 1: $ene 	= $val; break;
									case 2: $feb 	= $val; break;
									case 3: $mar 	= $val; break;
									case 4: $abr	= $val; break;
									case 5: $may 	= $val; break;
									case 6: $jun 	= $val; break;
									case 7: $jul 	= $val; break;
									case 8: $ago 	= $val; break;
									case 9: $sep 	= $val; break;
									case 10: $oct 	= $val; break;
									case 11: $nov 	= $val; break;
									case 12: $dic	= $val; break;
								}
							}
						}
						echo '</tr>';
					}
					echo '</table>';
				}
				echo "</div>";
			}?>
		</div>
		<div style="clear:both;"></div>
	</div>
	
	</body>
</html>