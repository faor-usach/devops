<?php
	$RAM = $_GET['RAM'];
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	$fechaHoy 	= date('Y-m-d');
	$link=Conectarse();
	$actSQL ="UPDATE ammuestras SET ";
	$actSQL .= "fechaTerminoTaller = '".$fechaHoy."' ";
	$actSQL .="WHERE idItem like '%".$RAM."%'";
	$bdCot=$link->query($actSQL);
	$link->close();
	header('Location: https://api.whatsapp.com/send?phone=56984910930&text=Trabajo Terminado RAM: $RAM');
	echo '1';
?>
