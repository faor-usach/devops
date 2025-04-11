<?php
    	session_start();
        if(isset($_GET['Nombre']))   	{ 
            $Nombre	 = $_GET['Nombre']; 		
            echo 'Nombre'.$Nombre.'<br>';
        }
        if(isset($_GET['Guardar']))   	{ 
            echo 'Guardar Datos <br>';
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo 'Entra...';
            if(isset($_POST['Nombre']))   	{ $Nombre	 = $_POST['Nombre']; 		}

            if(isset($_POST['Gardar'])) 	{ 
                echo 'Guardado...'; 	
            }
        }
    
	$exento 	= 'off';
	include_once("../conexionli.php");

	$Proveedor 		= "";
	$nDoc			= "123";
	$Bien_Servicio	= "aaaa";
	$exento			= 'off';
	$efectivo		= 'off';
	$Neto			= 0;
	$Iva			= 0;
	$Bruto			= 1000;
	$FechaGasto    	= date('Y-m-d');
	$Hora			= date("H:i:s");
	$Items 			= "";
	$TpGasto 		= "";
	$Recurso 		= "";
	$IdProyecto 	= "IGT-1118";
	$IdAutoriza		= "";
	$Guardado		= '';

    $link=Conectarse();
	$bdGt = $link->query('SELECT * FROM movgastos Order By nGasto Desc');
	if($rowGt=mysqli_fetch_array($bdGt)){
		$nGasto = $rowGt['nGasto'] + 1;
	}
	echo 'Num Gasto....'.$nGasto;	
                $fechaBanca     = '0000-00-00';

				$Modulo 		= 'G';
				$Estado 		= '';
				$FechaInforme 	= date("Y-m-d", strtotime($fechaBlanca));

				$nInforme		= 0;
				$Fotocopia 		= '';
				$fechaFotocopia = date('Y-m-d');
				$Reembolso 		= '';
				$fechaReembolso = date('Y-m-d');

                $Modulo     = 'G';
                $TpDoc      = 'B';
                $Proveedor  = 'Yo'; 
                $nItem      = '1';
                $IdGasto    = '1';
                $IdRecurso  = '1';
                $CalCosto   = 5;
                $CalCalidad = 5;
                $CalPreVenta= 5;
                $CalPostVenta= 5;
                

				// $link->query("insert into movgastos	 (	nGasto,
				// 										Modulo,
				// 										FechaGasto,
				// 										Hora,
				// 										TpDoc,
				// 										Proveedor,
				// 										nDoc,
				// 										Bien_Servicio,
				// 										exento,
				// 										efectivo,
				// 										Neto,
				// 										Iva,
				// 										Bruto,
				// 										nItem,
				// 										IdGasto,
				// 										IdRecurso,
				// 										IdProyecto,
				// 										IdAutoriza,
				// 										Estado,
				// 										FechaInforme,
				// 										nInforme,
				// 										Fotocopia,
				// 										fechaFotocopia,
				// 										Reembolso,
				// 										fechaReembolso,
				// 										CalCosto,
				// 										CalCalidad,
				// 										CalPreVenta,
				// 										CalPostVenta) 
				// 						values 		(	'$nGasto',
				// 										'$Modulo',
				// 										'$FechaGasto',
				// 										'$Hora',
				// 										'$TpDoc',
				// 										'$Proveedor',
				// 										'$nDoc',
				// 										'$Bien_Servicio',
				// 										'$exento',
				// 										'$efectivo',
				// 										'$Neto',
				// 										'$Iva',
				// 										'$Bruto',
				// 										'$nItem',
				// 										'$IdGasto',
				// 										'$IdRecurso',
				// 										'$IdProyecto',
				// 										'$IdAutoriza',
				// 										'$Estado',
				// 										'$FechaInforme',
				// 										'$nInforme',
				// 										'$Fotocopia',
				// 										'$fechaFotocopia',
				// 										'$Reembolso',
				// 										'$fechaReembolso',
				// 										'$CalCosto',
				// 										'$CalCalidad',
				// 										'$CalPreVenta',
				// 										'$CalPostVenta'
				// 										)");

    $link->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="pruebaGuardar.php" method="get" enctype="multipart/form-data">
        <input name="Nombre"  type="text">Nombre
        <input type="submit" name="Guardar" value"Submit"/>Guardar
    </form>
</body>
</html>