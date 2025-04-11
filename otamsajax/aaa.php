<?php
	echo 'Inicio...<br>';
    include_once("../conexionli.php");
    $link=Conectarse();
	$RutCli 		= '11111111-1';
	$Observaciones  = 'Nada de nada';

    $bd=$link->query("SELECT * FROM clientesobs Where RutCli = '$RutCli'");
    if($rs = mysqli_fetch_array($bd)){
        echo 'Entra...';
			$fecha = date('Y-m-d','0000-00-00');
			$actSQL="UPDATE clientesobs SET ";
			$actSQL.="Observaciones	 	    = '".$Observaciones.	"', ";
			$actSQL.="fecha	 	    		= '".$fecha.	"' ";
			$actSQL.="WHERE RutCli 			= '".$RutCli."'";
            $bd=$link->query($actSQL);
	}
    $bd=$link->query("SELECT * FROM cotizaciones Where Estado = 'E' and fechaInicio IS NULL Order By CAM Desc");
    while($rs = mysqli_fetch_array($bd)){
        echo 'Listando...';
		echo 'CAM = '.$rs['CAM'].'<br>';
	}
	$link->close();
	echo 'Fin';
?>
