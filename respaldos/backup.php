<?php
	session_start(); 
	set_time_limit(0);
	
	include("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}

	if(isset($_POST['Cerrar'])){
		header("Location: ../cerrarsesion.php");
	}
	$accion 	= '';
	$carpeta 	= '';
	if(isset($_GET['accion']))	{ $accion 	= $_GET['accion']; 	}
	if(isset($_GET['carpeta']))	{ $carpeta 	= $_GET['carpeta']; }
	// if($accion == 'Levantar'){
	// 	//creatablas();
	// 	$link=Conectarse();
	// 	$archivo = "";
	// 	$ruta	 = '';
		
	// 	$tables = array();
	// 	$result = $link->query('SHOW TABLES');
	// 	while($row = mysql_fetch_row($result))
	// 	{
	// 		$tables[] = $row[0];
	// 	}
	// 	$link->close();
	// 	foreach($tables as $table){
	// 		$ruta = '../Data/backup/'.$carpeta.'/';
	// 		$archivo = $ruta.$table.'.sql';
	// 		if(file_exists($archivo)){
	// 			echo 'Restaurando... '.$archivo.'...';
	// 			$sql = '';
	// 			$fp = fopen($archivo, 'r');
	// 			while(!feof($fp)) {
	// 				$linea = fgets($fp);
	// 				$sql .= $linea;
	// 			}
	// 			fclose($fp);
	// 			//echo $sql;
				
	// 			$fd=explode(';Fin',$sql);
	// 			$link=Conectarse();
	// 			foreach ($fd as $valor) {
	// 				$valor .= ';';
	// 				//echo $valor.'<br><br>';
	// 				$bd=$link->query($valor);
	// 			}
	// 			$link->close();
	// 		}
	// 	}


			
	// 		$fechaBackup 	= date('Y-m-d');
	// 		$usrResponsable = $_SESSION['usr'];
	// 		$horaBackup		= date('H:i');
			
			
	// 		// $link=Conectarse();
	// 		// $link->query("insert into ctrlrestauracion(	
	// 		// 														fechaRestauracion,
	// 		// 														usrResponsable,
	// 		// 														horaBackup,
	// 		// 														archivoBackup
	// 		// 														) 
	// 		// 												values 	(	
	// 		// 														'$fechaBackup',
	// 		// 														'$usrResponsable',
	// 		// 														'$horaBackup',
	// 		// 														'$ruta'
	// 		// 						)");
	// 		// $link->close();
		
	// 	header("Location: backup.php");
	// }	

?>

<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="../touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="../touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="../touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="../css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="../css/styles.css" 	rel="stylesheet" type="text/css">
	<link href="../estilos.css" 	rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">

	<style type="text/css">
		* {
  			box-sizing: border-box;
		}
		.verde-class{
		  background-color 	: green;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.verdechillon-class{
		  background-color 	: #33FFBE;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.azul-class{
		  background-color 	: blue;
		  color 			: #fff;
		  font-weight 		: bold;
		}
		.amarillo-class{
		  background-color 	: yellow;
		  color 			: black;
		}
		.rojo-class{
		  background-color 	: red;
		  color 			: black;
		}
		.default-color{
		  background-color 	: #fff;
		  color 			: black;
		}	
	</style>


</head>

<body ng-app="myApp" ng-controller="CtrlRespaldos" ng-cloak>
	<?php include_once('head.php'); ?>

	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>


	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>
	      		</ul>
	    	</div>
	  	</div>
	</nav>

	<div class="container-fluid m-2">

		<div class="row">
			<div class="col-sm-6">
				<?php 
					include_once('controlRespaldo.php'); 
				?>
			</div>
			<div class="col-sm-6">
				<?php 
					include_once('regRespaldo.php'); 
				?>
			</div>
		</div>

	</div>

	
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../angular/angular.js"></script>
	<script src="respaldos.js"></script>


</body>
</html>
