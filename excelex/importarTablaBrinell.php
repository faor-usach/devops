<?php
		//header('Content-Type: text/html; charset=UTF-8');
		include_once("../conexionli.php");
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
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#" title="Agregar Cotización" onClick="registraEncuesta(0, 'Agrega')">
						<img src="../imagenes/add_32.png" width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a>
					<img src="../gastos/imagenes/r_x.png"  width="32" height="32">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png" width="32" height="32">
					</a>
				</div>
			</div>

			<div id="tablaDatosAjax">
				<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->
				<form name="importa" method="post" action="importarTablaBrinell.php" enctype="multipart/form-data" >
					<input type="file" name="excel" />
					<input type='submit' name='enviar'  value="Importar"  />
					<input type="hidden" value="upload" name="action" />
				</form>
				<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->
			</div>
			<?php
			if(isset($_FILES['excel']['name'])){
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
					echo '<br><table width="100%"  border="1" cellpadding="0" cellspacing="0" style="font-size:8px;" id="CajaTiluloCAM"><tr>';
					for ($row = 1; $row <= $highestRow; ++ $row) {
						echo '<tr>';
						$key = 0;
						$c3000 = 0;
						$c1500 = 0;
						$c1000 = 0;
						$c500 = 0;
						$c250 = 0;
						$c125 = 0;
						$c100 = 0;

						for ($col = 0; $col < $highestColumnIndex; ++ $col) {
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							$val = $cell->getValue();
							$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
							$campo 	= '';


							if($row == 1){
								if($col == 0){ 
									echo '<td align="center" style="color:#fff;background-color:#666666;">' . $val . '</td>';
								}
								if($col > 0){
									// Campos
									echo '<td align="center" style="color:#fff;background-color:#666666;">c' . $val . '</td>';
								}
							}else{
								if($col == 0){
									// Key
									$key 	= $val;
									echo '<td align="center" style="color:#fff;background-color:#666666;">' . $val . '</td>';
								}else{
									echo '<td align="center"><strong>';
										if($val > 0){
											// Data
											$key = number_format($key,2,".",",");
											if($col == 1){ $c3000 = number_format($val,2,",","."); }
											if($col == 2){ $c1500 = number_format($val,2,",","."); }
											if($col == 3){ $c1000 = number_format($val,2,",","."); }
											if($col == 4){ $c500 = number_format($val,2,",","."); }
											if($col == 5){ $c250 = number_format($val,2,",","."); }
											if($col == 5){ $c125 = number_format($val,2,",","."); }
											if($col == 5){ $c100 = number_format($val,2,",","."); }

											echo number_format($key,2,".",",").' '.$campo.' '.number_format($val,2,",",".");
										}
									echo '</strong></td>';
										if($val >0){
											$link=Conectarse();
											//$bdUf=mysql_query("SELECT * FROM UF Where fechaUF Like '".$fechaUfSis."'");
											//if ($rowUf=mysql_fetch_array($bdUf)){
					/*
												$actSQL="UPDATE uf SET ";
												$actSQL.="fecha		='".$fechaUF."',";
												$actSQL.="uf			='".$val."'";
												$actSQL.="WHERE fecha 	= '".$fechaUF."'";
												$bdUf	= mysql_query($actSQL);
					*/							
											//}else{
												/*
												mysql_query("insert into UF ( 	fechaUF,
																				ValorUF
																			) 
																	values	(	'$fechaUfSis',
																				'$val'
																			)",$link);
																			*/
											//}
											$link->close();
										}
	
								}
							}

							if ($row>1){
								switch ($col) {
									case 0: $key 	= $val; break;
									case 1: $c3000 	= $val; break;
									case 2: $c1500 	= $val; break;
									case 3: $c1000 	= $val; break;
									case 4: $c500	= $val; break;
									case 5: $c250 	= $val; break;
									case 6: $c125 	= $val; break;
									case 7: $c100 	= $val; break;
								}
							}
						}
						if($key > 0){
							$link=Conectarse();

							$SQL = "Select * From tablacargadureza Where diametroBola = '$key'"; 
							$bd=$link->query($SQL);
							if($rs = mysqli_fetch_array($bd)){

							}else{
								$link->query("insert into tablacargadureza(
									diametroBola,
									c3000,
									c1500,
									c1000,
									c500,
									c250,
									c125,
									c100
								) values (	
									'$key',
									'$c3000',
									'$c1500',
									'$c1000',
									'$c500',
									'$c250',
									'$c125',
									'$c100'
								)");

							}

							$link->close();
							echo $key.' '.$c3000.' '.$c1500.' '.$c1000.' '.$c500.' '.$c250.' '.$c125.' '.$c100.'<br>';
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