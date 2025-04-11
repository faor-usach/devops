<?php
		//header('Content-Type: text/html; charset=iso-8859-1');
		header('Content-Type: text/html; charset=UTF-8');
		include_once("conexion.php");
?>
<HTML LANG="es">
	<head>
		<!-- <meta http-equiv="content-type" content="text/html; charset=iso-8859-1"> -->
		<TITLE>::. Exportacion de Datos .::</TITLE>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="../style.css" rel="stylesheet" type="text/css">
	</head>
	<body>

		<div id="cajatitulomodulo">
			<h3 align="center">Importar Planillas</h3>
		</div>
		<div id="cajatitulomodulo2">
			<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->
			<form name="importa" method="post" action="importarBD.php" enctype="multipart/form-data" >
				<input type="file" 		name="excel" 	text="Planilla" />
				<input type='submit' 	name='enviar'  	value="Importar" text="Enviar"  />
				<input type="hidden" 	name="action"  	value="upload" />
			</form>
			<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->
		</div>
		<?php

		$archivo 		= $_FILES['excel']['name'];
		$tipo_archivo 	= $_FILES['excel']['type'];
		$tamano_archivo = $_FILES['excel']['size'];
		$desde 			= $_FILES['excel']['tmp_name'];

		if (($tipo_archivo == "application/vnd.ms-excel" || $tipo_archivo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) { 
			echo 'Subiendo...';		
			//$directorio="excel";
			//if (!file_exists($directorio)){
			//	mkdir($directorio,0755);
			//}
    		if (move_uploaded_file($desde, $archivo)){ 
   				echo "El archivo ".$archivo." ha sido cargado correctamente....";
    		}else{ 
   				echo "Ocurrió algún error al subir el fichero ".$archivo." No pudo guardarse.... ');</script>";
    		} 
			
		}
		if (isset($_POST['enviar'])){
			echo '<div id="cajatitulomodulo2">';
			echo 'Mostrando...';		

			require_once '../excelex/exelmysql/excelamysql/Classes/PHPExcel/IOFactory.php';
			$objPHPExcel = PHPExcel_IOFactory::load($archivo);
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$nrColumns = ord($highestColumn) - 64;
				echo "<br>La Base de Datos ".$archivo." Registros = ". $highestRow . " Campos = ". $highestColumnIndex;
				echo '<table width="100%"  border="1" cellpadding="0" cellspacing="0" style="font-size:8px;">';
				for ($row = 1; $row <= $highestRow; ++ $row) {
					echo '<tr>';
					for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						$val = $cell->getValue();
						$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
						echo '<td>' . $val . '</td>';
						if ($row>1){
							switch ($col) {
								case 0: $codEnsayo 	= $val; break;
								case 1: $Ensayo		= $val; break;
							}
						}
					}
/*					
					if($codEnsayo){
						$link=Conectarse();
						$bdProd=mysql_query("SELECT * FROM Ensayos Where codEnsayo = '".$codEnsayo."'");
						if ($rowProd=mysql_fetch_array($bdProd)){
							$actSQL="UPDATE Ensayos SET ";
							$actSQL.="codEnsayo			='".$codEnsayo."',";
							$actSQL.="Ensayo			='".$Ensayo.	"'";
							$actSQL.="WHERE codEnsayo 	= '".$codEnsayo."'";
							$bdProd=mysql_query($actSQL);
						}else{
							mysql_query("insert into Ensayos  ( 	codEnsayo,
																	Ensayo
																) 
														values	(	'$codEnsayo',
																	'$Ensayo'
																	)",$link);
						}
						mysql_close($link);
					}
*/
					echo '</tr>';
				}
				echo '</table>';
			}
			echo "</div>";
		}?>
    	<p>&nbsp;</p>
	</body>
</html>