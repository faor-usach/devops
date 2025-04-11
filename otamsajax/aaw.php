<?php
	echo 'Inicio...<br>';
    include_once("../conexionli.php");
    $RutCli         = '11111111-1';
    $Observaciones  = '';
    $EstadoObs      = '';
    $fecha          = date('Y-m-d','0000-00-00');

    $link=Conectarse();

	$link->query("insert into clientesobs(
														RutCli
														) 
												values 	(	
														'$RutCli'
														)");
	$link->close();
	echo 'Fin';
?>
