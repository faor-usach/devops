<?php
	session_start(); 
	set_time_limit(0);
	
	include("../conexionli.php");
	$carpeta 	= 'backup';

	$link=Conectarse();
	$archivo = "";
	$ruta	 = '';
	
	$tables = array();
	$result = $link->query('SHOW TABLES');
	while($row = mysqli_fetch_row($result))
	{
		$tables[] = $row[0];
	}
	$link->close();
	foreach($tables as $table){
		$ruta = $carpeta.'/';
		$archivo = $ruta.$table.'.sql';
		if(file_exists($archivo)){
			echo 'Restaurando... '.$archivo.'...';
			$sql = '';
			$fp = fopen($archivo, 'r');
			while(!feof($fp)) {
				$linea = fgets($fp);
				$sql .= $linea;
			}
			fclose($fp);
			//echo $sql;
			
			$fd=explode(';',$sql);
			$link=Conectarse();
			foreach ($fd as $valor) {
				$valor .= ';';
				//echo $valor.'<br><br>';
				$bd=$link->query( ($valor));
			}
			$link->close();
		}
	}

?>	
