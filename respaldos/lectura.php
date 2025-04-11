<?php
	include_once("../conexion.php");

	$sql = '';
	$fp = fopen('db-backup.sql', 'r');
	while(!feof($fp)) {
		$linea = fgets($fp);
		$sql .= $linea;
	}
	fclose($fp);
	//echo $sql;
	
	$fd=explode(';',$sql);
	$link=Conectarse();
	foreach ($fd as $valor) {
		//echo $valor.'<br>';
		$bd=mysql_query($valor);
	}
	mysql_close($link);
	
	$link=Conectarse();
	$bd=mysql_query("SELECT * FROM ensayos");
	if($row=mysql_fetch_array($bd)){
		do{
			echo $row['codEnsayo'].'<br>';
		}while ($row=mysql_fetch_array($bd));
	}
	mysql_close($link);
	
?>