<?php include_once("../conexion.php"); ?>
	<?php
	$carpeta 	= '';
	if(isset($_GET['carpeta'])){ $carpeta 	= $_GET['carpeta']; }

	$link=Conectarse();
	$archivo = "";
	$ruta	 = '';
		
	$tables = array();
	$result = mysql_query('SHOW TABLES');
	while($row = mysql_fetch_row($result))
	{
		$tables[] = $row[0];
	}
	mysql_close($link);

	foreach($tables as $table){
		$ruta = 'backup/'.$carpeta.'/';
		$archivo = $ruta.$table.'.sql';
		if(file_exists($archivo)){
			//echo 'Recuperando '.$archivo.'...<br>';

			$sql = '';
			$fp = fopen($archivo, 'r');
			while(!feof($fp)) {
				$linea = fgets($fp);
				$sql .= $linea;
			}
			fclose($fp);
			
			$fd=explode(';Fin',$sql);
			$link=Conectarse();
			foreach ($fd as $valor) {
				$valor .= ';';
				echo $valor.'<br><br>';
				//$bd=mysql_query($valor);
			}
			mysql_close($link);
		}
	}
?>