<?php
/*
	ini_set("session.cookie_lifetime",60);
	ini_set("session.gc_maxlifetime",60);
*/	
	session_start(); 
	date_default_timezone_set("America/Santiago");
	//header('Content-Type: text/html; charset=utf-8'); 
	
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}
/*
	if($_SESSION[Perfil] != 'WebMaster'){
		header("Location: ../enConstruccion.php");
	}
*/
	$usuario 		= $_SESSION['usuario'];
	$idActividad	= '';
	$accion			= '';
	$usrApertura 	= $_SESSION['usr'];
	$usrRes 		= $_SESSION['usr'];
	$actRepetitiva 	= '';
	$prgActividad 	= '';
	$tpoProx 		= '';
	$tpoAvisoAct 	= '';
	
	$fechaHoy = date('Y-m-d');
	$fechaVen = strtotime ( '-2 day' , strtotime ( $fechaHoy ) );
	$fechaVen= date ( 'Y-m-d' , $fechaVen );
	$link=Conectarse();
	$bdPre=$link->query("Select * From precam where Estado != 'off' Order By idPreCAM");
	while($rowPre=mysqli_fetch_array($bdPre)){
			$idPreCAM = $rowPre['idPreCAM'];
			$seguimiento = 'off';
			if($rowPre['fechaSeg'] < $fechaVen and $rowPre['fechaSeg'] > '0000-00-00'){
				$actSQL="UPDATE precam SET ";
				$actSQL.="seguimiento		='".$seguimiento.	"'";
				$actSQL.="Where idPreCAM	= '".$idPreCAM."'";
				$bdCot=$link->query($actSQL);
			}
	}
	$bddCot=$link->query("Select * From precam Order By idPreCAM");
	if($rowdCot=mysqli_fetch_array($bddCot)){
		//$nSerie = $rowdCot[nSerie];
	}else{
		$accion = 'Vacio';
	}
	$link->close();

	if(isset($_GET['idPreCAM']))	{ $idPreCAM	= $_GET['idPreCAM']; 	}
	if(isset($_GET['accion']))	 	{ $accion	= $_GET['accion']; 		}
	if(isset($_GET['tpAccion']))	{ $tpAccion	= $_GET['tpAccion']; 	}

	if(isset($_POST['idPreCAM']))	{ $idPreCAM = $_POST['idPreCAM'];	}
	if(isset($_POST['accion']))	  	{ $accion	= $_POST['accion']; 	}
	if(isset($_POST['tpAccion']))	{ $tpAccion	= $_POST['tpAccion']; 	}


	if($accion=='Imprimir'){
		//header("Location: formularios/fichaEquipo.php?nSerie=$nSerie");
	}
	
	if(isset($_POST['confirmarBorrar'])){
		$link=Conectarse();
		//$bdCot =$link->query("Delete From precam Where idPreCAM = '".$idPreCAM."'");
		
		$Estado = 'off';
		$actSQL="UPDATE precam SET ";
		$actSQL.="Estado			='".$Estado.	"'";
		$actSQL.="Where idPreCAM	= '".$idPreCAM."'";
		$bdCot=$link->query($actSQL);
		
		$link->close();
		$idPreCAM 	= '';
		$accion		= '';
	}
	
	if(isset($_POST['guardarSeguimiento'])){
		if(isset($_POST['idPreCAM']))		{ $idPreCAM			= $_POST['idPreCAM'];		}
		if(isset($_POST['Correo']))			{ $Correo 			= $_POST['Correo'];			}
		if(isset($_POST['seguimiento']))	{ $seguimiento		= $_POST['seguimiento'];	}
		if(isset($_POST['fechaPreCAM']))	{ $fechaPreCAM		= $_POST['fechaPreCAM'];	}

		$link=Conectarse();
		$bdCot=$link->query("Select * From precam Where idPreCAM = '".$idPreCAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$Estado = 'off';
			$actSQL="UPDATE precam SET ";
			$actSQL.="seguimiento		='".$seguimiento.	"',";
			$actSQL.="Estado			='".$Estado.		"'";
			$actSQL.="Where idPreCAM	= '".$idPreCAM."'";
			$bdCot=$link->query($actSQL);
		}
		$link->close();
		$idPreCAM	= '';
		$accion		= '';
	}
	
	if(isset($_POST['guardarActividad'])){
		$seguimiento = 'off';
		if(isset($_POST['idPreCAM'])) 		{ $idPreCAM			= $_POST['idPreCAM'];		}
		if(isset($_POST['Correo'])) 		{ $Correo 			= $_POST['Correo'];			}
		if(isset($_POST['fechaPreCAM']))	{ $fechaPreCAM 		= $_POST['fechaPreCAM'];	}
		if(isset($_POST['seguimiento']))	{ $seguimiento 		= $_POST['seguimiento'];	}
		if(isset($_POST['usrResponsable'])) { $usrResponsable	= $_POST['usrResponsable'];	}
		$link=Conectarse();
		$bdCot=$link->query("Select * From precam Where idPreCAM = '".$idPreCAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$Estado	= 'on';
			$fechaSeg = '0000-00-00';
			if($seguimiento == 'on'){
				$fechaSeg = date('Y-m-d');;
			}
			$actSQL="UPDATE precam SET ";
			$actSQL.="Correo			='".$Correo.		"',";
			$actSQL.="fechaPreCAM		='".$fechaPreCAM.	"',";
			$actSQL.="seguimiento		='".$seguimiento.	"',";
			$actSQL.="fechaSeg			='".$fechaSeg.		"',";
			$actSQL.="usrResponsable	='".$usrResponsable."',";
			$actSQL.="Estado			='".$Estado."'";
			$actSQL.="WHERE idPreCAM	= '".$idPreCAM."'";
			$bdCot=$link->query($actSQL);
		}else{
			$Estado	= 'on';
			$link->query("insert into precam(	
											idPreCAM,
											fechaPreCAM,
											seguimiento,
											Correo,
											usrResponsable,
											Estado
											) 
									values 	(	
											'$idPreCAM',
											'$fechaPreCAM',
											'$seguimiento',
											'$Correo',
											'$usrResponsable',
											'$Estado'
					)");
		}
		$link->close();
		$idPreCAM	= '';
		$accion		= '';
	}

?>
<!doctype html>
 
<html lang="es">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Registro de PreCAM</title>
	
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
		<script src="../jquery/jquery-1.6.4.js"></script>

		<link href="styles.css" rel="stylesheet" type="text/css">
		<link href="../css/tpv.css" rel="stylesheet" type="text/css">
		
		<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
		<script src="../angular/angular.min.js"></script>

	<script>
	function realizaProceso(usrRes, tpAccion){
		var parametros = {
			"usrRes" 	: usrRes,
			"tpAccion"  : tpAccion
		};
		//alert(tpAccion);
		$.ajax({
			data: parametros,
			url: 'muestraPreCAM.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	function registraActividad(idPreCAM, accion){
		var parametros = {
			"idPreCAM"	: idPreCAM,
			"accion"	: accion
		};
		//alert(nSerie);
		$.ajax({
			data: parametros,
			url: 'regPreCAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	function seguimientoActividad(idPreCAM, accion, tpAccion){
		var parametros = {
			"idPreCAM" 	: idPreCAM,
			"accion"	: accion,
			"tpAccion"	: tpAccion
		};
		//alert(idVisita);
		$.ajax({
			data: parametros,
			url: 'segPreCAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}

	</script>

</head>

<body ng-app="myApp" ng-controller="ctrlPreCam" ng-cloak>
	<?php include_once('head.php'); ?>
	<div id="Cuerpo">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../imagenes/consulta.png" width="40" height="40" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					PRECAM 
				</strong>

				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>
			<?php include_once('listaPreCAM.php'); 
			if($accion == 'Seguimiento'){?>
				<script>
					var idPreCAM	= "<?php echo $idPreCAM; 	?>" ;
					var accion 		= "<?php echo $accion; 		?>" ;
					var tpAccion 	= "<?php echo $tpAccion; 	?>" ;
					seguimientoActividad(idPreCAM, accion, tpAccion);
				</script>
				<?php
			}
			if($accion == 'Actualizar' or $accion == 'Borrar' or $accion == 'Vacio'){
				?>
				<script>
					var idPreCAM	= "<?php echo $idPreCAM; 	?>" ;
					var accion 		= "<?php echo $accion; 		?>" ;
					registraActividad(idPreCAM, accion);
				</script>
				<?php
			}
			?>
		</div>
				
	</div>

	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="precam.js"></script> 

	
</body>
</html>
