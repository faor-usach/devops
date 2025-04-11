<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){ 
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: ../index.php");
	}

	$RutCli = '';
	$regEns	= '';
	
	if(isset($_GET['CodInforme']))  { $CodInforme	= $_GET['CodInforme']; 	}
	if(isset($_GET['RutCli']))  	{ $RutCli		= $_GET['RutCli']; 		}
	if(isset($_GET['idItem']))  	{ $idItem		= $_GET['idItem']; 		}
	if(isset($_GET['Otam']))  		{ $Otam			= $_GET['Otam']; 		}
	if(isset($_GET['accion']))  	{ $accion		= $_GET['accion']; 		}

	$fi 	= explode('-',$CodInforme);
	$RAM 	= $fi['1'];

	if(isset($_GET['accion'])){
		if($_GET['accion'] == 'Guardar'){
			$link=Conectarse();
			$bdMu=$link->query("Select * From ammuestras Where idItem = '".$idItem."'");
			if($rowMu=mysqli_fetch_array($bdMu)){
				$actSQL="UPDATE ammuestras SET ";
				$actSQL.="CodInforme	= '".$CodInforme."'";
				$actSQL.="WHERE idItem	= '".$idItem."'";
				$bdMu=$link->query($actSQL);
			}

				$actSQL="UPDATE otams SET ";
				$actSQL.="CodInforme	= '".$CodInforme."'";
				$actSQL.="WHERE idItem	= '".$idItem."'";
				$bdMu=$link->query($actSQL);

			$bdTe=$link->query("Select * From aminformes Where CodInforme = '".$CodInforme."'");
			if($rowTe=mysqli_fetch_array($bdTe)){
				$nMuestras = $rowTe['nMuestras'];
				$nMuestras++;
				$actSQL="UPDATE aminformes SET ";
				$actSQL.="nMuestras			= '".$nMuestras."'";
				$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
				$bdTe=$link->query($actSQL);
			}


			$bdOT=$link->query("Select * From otams Where idItem = '".$idItem."'");
			if($rowOT=mysqli_fetch_array($bdOT)){
				do{
					$te = explode('-',$rowOT['Otam']);
					if($rowOT['idEnsayo'] == 'Tr') { $regEns = 'regtraccion'; }
					if($rowOT['idEnsayo'] == 'Qu') { $regEns = 'regquimico'; }
					if($rowOT['idEnsayo'] == 'Ch') { $regEns = 'regcharpy'; }
					if($rowOT['idEnsayo'] == 'Du') { $regEns = 'regdoblado'; }
					if($rowOT['idEnsayo'] == 'Do') { $regEns = 'regdobladosreal'; }

					
					$actSQL="UPDATE $regEns SET ";
					$actSQL.="CodInforme   	= '".$CodInforme."'";
					if($regEns == 'regQuimico'){
						$actSQL.="WHERE idItem 	= '".$rowOT['Otam']."' and Programa = ''";
					}else{
						$actSQL.="WHERE idItem 	= '".$rowOT['Otam']."'";
					}
					$bdReg=$link->query($actSQL);
					
					
					//$bdTe=$link->query("Select * From amTabEnsayos Where CodInforme = '".$CodInforme."' and idEnsayo = '".$rowOT['idEnsayo']."' and tpMuestra = '".$rowOT['tpMuestra']."'");
					//if($rowTe=mysqli_fetch_array($bdTe)){
					//}else{
					//	$bdTe=$link->query("Select * From amTabEnsayos Where idItem = '".$idItem."'");
					//	if($rowTe=mysqli_fetch_array($bdTe)){
							$actSQL="UPDATE amtabensayos SET ";
							$actSQL.="CodInforme		= '".$CodInforme."'";
							$actSQL.="WHERE idItem 		= '".$idItem."'";
							$bdTe=$link->query($actSQL);
					//	}					
					//}
				}while ($rowOT=mysqli_fetch_array($bdOT));
			}
			$link->close();
		}
		if($_GET['accion'] == 'AsignarEnsayo'){
			$link=Conectarse();
			$bdMu=$link->query("Select * From otams Where Otam = '".$Otam."'");
			$Blanco = '';
			if($rowMu=mysqli_fetch_array($bdMu)){
				$actSQL="UPDATE otams SET ";
				$actSQL.="CodInforme	= '".$CodInforme."',";
				$actSQL.="idItem		= '".$idItem."'";
				$actSQL.="WHERE Otam	= '".$Otam."'";
				$bdMu=$link->query($actSQL);
				
				$idEnsayo = $rowMu['idEnsayo'];
				if($rowMu['idEnsayo'] == 'Tr') { $regEns = 'regtraccion'; }
				if($rowMu['idEnsayo'] == 'Qu') { $regEns = 'regquimico'; }
				if($rowMu['idEnsayo'] == 'Ch') { $regEns = 'regcharpy'; }
				if($rowMu['idEnsayo'] == 'Du') { $regEns = 'regdoblado'; }
				if($rowMu['idEnsayo'] == 'Do') { $regEns = 'regdobladosreal'; }
				
				$actSQL="UPDATE $regEns SET ";
				$actSQL.="CodInforme	= '".$CodInforme."'";
				$actSQL.="WHERE idItem	= '".$Otam."'";
				$bdMu=$link->query($actSQL);

				$bdTb=$link->query("Select * From amtabensayos Where idItem = '".$rowMu['idItem']."' and idEnsayo = '".$rowMu['idEnsayo']."'");
				$Blanco = '';
				if($rowTb=mysqli_fetch_array($bdTb)){
					$actSQL="UPDATE amtabensayos SET ";
					$actSQL.="CodInforme	= '".$CodInforme."'";
					$actSQL.="WHERE idItem	= '".$rowMu['idItem']."' and idEnsayo = '".$rowMu['idEnsayo']."'";
					$bdTb=$link->query($actSQL);
				}
			}
		}
		
		if($_GET['accion'] == 'QuitarEnsayo'){
			$link=Conectarse();
			$bdMu=$link->query("Select * From otams Where Otam = '".$Otam."'");
			$Blanco = '';
			if($rowMu=mysqli_fetch_array($bdMu)){
				$actSQL="UPDATE otams SET ";
				$actSQL.="CodInforme	= '".$Blanco."'";
				$actSQL.="WHERE Otam	= '".$Otam."'";
				$bdMu=$link->query($actSQL);
				
				$idEnsayo = $rowMu['idEnsayo'];
				if($rowMu['idEnsayo'] == 'Tr') { $regEns = 'regtraccion'; }
				if($rowMu['idEnsayo'] == 'Qu') { $regEns = 'regquimico'; }
				if($rowMu['idEnsayo'] == 'Ch') { $regEns = 'regcharpy'; }
				if($rowMu['idEnsayo'] == 'Du') { $regEns = 'regdoblado'; }
				if($rowMu['idEnsayo'] == 'Do') { $regEns = 'regdobladosreal'; }
				
				$actSQL="UPDATE $regEns SET ";
				$actSQL.="CodInforme	= '".$Blanco."'";
				$actSQL.="WHERE idItem	= '".$Otam."'";
				$bdMu=$link->query($actSQL);
				
				$actSQL="UPDATE amtabensayos SET ";
				$actSQL.="CodInforme	= '".$Blanco."'";
				$actSQL.="WHERE idItem	= '".$rowMu['idItem']."' and idEnsayo = '".$rowMu['idEnsayo']."'";
				$bdTb=$link->query($actSQL);
				
			}
		}
		
		if($_GET['accion'] == 'Quitar'){
			$link=Conectarse();
			$bdMu=$link->query("Select * From ammuestras Where idItem = '".$idItem."'");
			$Blanco = '';
			if($rowMu=mysqli_fetch_array($bdMu)){
				$actSQL="UPDATE ammuestras SET ";
				$actSQL.="CodInforme	= '".$Blanco."'";
				$actSQL.="WHERE idItem	= '".$idItem."'";
				$bdMu=$link->query($actSQL);

				$actSQL="UPDATE otams SET ";
				$actSQL.="CodInforme	= '".$Blanco."'";
				$actSQL.="WHERE idItem	= '".$idItem."'";
				$bdMu=$link->query($actSQL);

				$actSQL="UPDATE amtabensayos SET ";
				$actSQL.="CodInforme	= '".$Blanco."'";
				$actSQL.="WHERE idItem	= '".$idItem."'";
				$bdMu=$link->query($actSQL);
			}
			$bdTe=$link->query("Select * From aminformes Where CodInforme = '".$CodInforme."'");
			if($rowTe=mysqli_fetch_array($bdTe)){
				$nMuestras = $rowTe['nMuestras'];
				$nMuestras--;
				$actSQL="UPDATE aminformes SET ";
				$actSQL.="nMuestras			= '".$nMuestras."'";
				$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
				$bdTe=$link->query($actSQL);
			}

			//$bdTe=$link->query("Delete From amTabEnsayos WHERE idItem = '".$idItem."'");

			$bdOT=$link->query("Select * From otams Where idItem = '".$idItem."'");
			if($rowOT=mysqli_fetch_array($bdOT)){
				do{
					$te = explode('-',$rowOT['Otam']);
					if($rowOT['idEnsayo'] == 'Tr') { $regEns = 'regtraccion'; }
					if($rowOT['idEnsayo'] == 'Qu') { $regEns = 'regquimico'; }
					if($rowOT['idEnsayo'] == 'Ch') { $regEns = 'regcharpy'; }
					if($rowOT['idEnsayo'] == 'Du') { $regEns = 'regdoblado'; }
					if($rowOT['idEnsayo'] == 'Do') { $regEns = 'regdobladosreal'; }
					
					$Blanco = '';
					$actSQL="UPDATE $regEns SET ";
					$actSQL.="CodInforme   	  	= '".$Blanco."'";
					$actSQL.="WHERE idItem 	= '".$rowOT['Otam']."'";
					$bdReg=$link->query($actSQL);
				}while ($rowOT=mysqli_fetch_array($bdOT));
			}
			$link->close();
		}
		$accion = '';
	}
	
	if(isset($_GET['generarInformes'])){	
		$link=Conectarse();
		$bdCot=$link->query("Select * From aminformes Where CodInforme Like '%".$CodInforme."%'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$Estado		= 'P';
			$actSQL="UPDATE aminformes SET ";
			$actSQL.="nroInformes		='".$nroInformes.		"',";
			$actSQL.="fechaRecepcion	='".$fechaRecepcion.	"',";
			$actSQL.="Estado			='".$Estado.			"',";
			$actSQL.="ingResponsable	='".$ingResponsable.	"',";
			$actSQL.="cooResponsable	='".$cooResponsable.	"',";
			$actSQL.="RutCli			='".$RutCli.			"'";
			$actSQL.="WHERE CodInforme	= '".$CodInforme."'";
			$bdCot=$link->query($actSQL);
		}else{
			$Estado		= 'P';
			$cInforme 	= $CodInforme;
			$tInformes 	= $nroInformes;
			if($nroInformes<10){
				$tInformes = '0'.$nroInformes;
			}
			for($i=1; $i<=$nroInformes; $i++){
				$de = $i;
				if($i<10){
					$de = '0'.$i;
				}
				$CodInforme = $cInforme.'-'.$de.$tInformes;
				$link->query("insert into aminformes(
												CodInforme,
												nroInformes,
												fechaRecepcion,
												ingResponsable,
												cooResponsable,
												Estado,
												RutCli
												) 
										values 	(	
												'$CodInforme',
												'$nroInformes',
												'$fechaRecepcion',
												'$ingResponsable',
												'$cooResponsable',
												'$Estado',
												'$RutCli'
					)");

				// Tabla Informes
				$fdInf = explode('-',$fechaRecepcion);
				$DiaInforme  = $fdInf[2];
				$MesInforme  = $fdInf[1];
				$AgnoInforme = $fdInf[0];
				$IdProyecto  = 'IGT-1118';
				$MesInforme  = 1;
				$AgnoInforme = 2015;
				$link->query("insert into informes(
												IdProyecto,
												RutCli,
												CodInforme,
												DiaInforme,
												MesInforme,
												AgnoInforme
												) 
										values 	(	
												'$IdProyecto',
												'$RutCli',
												'$CodInforme',
												'$DiaInforme',
												'$MesInforme',
												'$AgnoInforme'
					)");
				
			}
		}
		$link->close();
	}
	if(isset($_POST['generarInformes'])){	
		if(isset($_POST['CodInforme']))	{	$CodInforme	= $_POST['CodInforme'];	}
		if(isset($_POST['accion'])) 	{	$accion 	= $_POST['accion']; 	}
		if(isset($_POST['RAM'])) 		{	$RAM 		= $_POST['RAM']; 		}
		if(isset($_POST['RutCli'])) 	{	$RutCli 	= $_POST['RutCli']; 	}
	}

?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Asocia Muestras</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link href="styles.css"		rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

	<script>
	function realizaProceso(CodInforme){
		var parametros = {
			"CodInforme" 	: CodInforme
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'asMuestras.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

	function subirInformePDF(accion, CodInforme){
		var parametros = {
			"accion" 		: accion,
			"CodInforme" 	: CodInforme
		};
		//alert(CodInforme);
		$.ajax({
			data: parametros,
			url: 'upInfoAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoSubir").html(response);
			}
		});
	}
	
	function titularInforme(CodInforme, RAM, accion){
		var parametros = {
			"CodInforme"	: CodInforme,
			"RAM"			: RAM,
			"accion"		: accion
		};
		//alert(accion);
		$.ajax({
			data: parametros,
			url: 'regInformes.php',
			type: 'get',
			success: function (response) {
				$("#resultadoRegistro").html(response);
			}
		});
	}
	
	</script>

</head>

<body>
	<?php include('head.php'); ?>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
		<div class="container-fluid">
	    	<div class="collapse navbar-collapse" id="navbarResponsive">
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../procesos/plataformaCotizaciones.php"> Procesos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link far fa-file-alt" href="../otamsajax/pOtams.php?RAM=<?php echo $RAM; ?>"> Volver</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>

	<div id="linea"></div>

	<?php include_once('listaMuestras.php'); ?>  

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	
	
	
</body>
</html>
