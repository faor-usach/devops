<?php
	include_once("conexionli.php");
	$link=Conectarse();
    $bd=$link->query("SELECT * FROM clientes Where Estado = 'on' and Docencia = '' and cFree = '' Order By Cliente Asc");
    while($rs=mysqli_fetch_array($bd)){
		echo 'Cliente..'.$rs['Cliente'].', '.$rs['RutCli'].', '.$rs['Direccion'].'<br>';
    }
	$link->close();
?>
