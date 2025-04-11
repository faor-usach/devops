<?php
$NombreFormulario = "CAM-23247 Rev-00.pdf";

$agnoActual = date('Y'); 
$vDir = '/Data/AAA/LE/FINANZAS/'.$agnoActual.'/COTIZACIONES/'; 
if(!file_exists($vDir)){
	echo $vDir.$NombreFormulario.'<br>';
}else{
	echo 'Error <br>';
}

$vDir = 'campdfs/'; 
if(!file_exists($vDir)){
    mkdir($vDir);
}


$NombreFormulario = "CAM-23247 Rev-00.pdf";
if(copy($NombreFormulario, $vDir.$NombreFormulario)){
	echo 'Copiado...';
}

echo '<br>Valor Variable',$vDir;

?>