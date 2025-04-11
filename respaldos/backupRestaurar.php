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
		header("Location: cerrarsesion.php");
	}
	$accion = '';

	if(isset($_POST['accion']))	{ $accion 	= $_POST['accion'];  }
	if(isset($_POST['carpeta'])){ $carpeta 	= $_POST['carpeta']; }

	if(isset($_GET['accion']))	{ $accion 	= $_GET['accion']; 	}
	if(isset($_GET['carpeta']))	{ $carpeta 	= $_GET['carpeta']; }
	
	if(isset($_GET['iniciaRestauracion'])) 	{ 
		// inicioRestauracion(); 
			$link=Conectarse();
			$archivo = "";
			$ruta	 = '';
			
			$tables = array();
			$result = $link->query('SHOW TABLES');
			while($row = mysqli_fetch_row($result))
			{
				$tables[] = $row[0];
			}
			$link->close();
			$tables[] = 'accesodoc';
			foreach($tables as $table){
				//$ruta = 'backup/'.$carpeta.'/';
				$ruta = '../Data/backup/'.$carpeta.'/';
				$archivo = $ruta.$table.'.sql';
				// echo 'Tabla... '.$archivo.'<br>';
				if(file_exists($archivo)){
					echo 'Restaurando... '.$archivo.'...';
					$sql = '';
					$fp = fopen($archivo, 'r');
					while(!feof($fp)) {
						$linea = fgets($fp);
						$sql .= $linea;
					}
					fclose($fp);
					//echo $sql;
					
					$fd=explode(';Fin',$sql);
					$link=Conectarse();
					foreach ($fd as $valor) {
						$valor .= ';';
						// echo $valor.'<br><br>';
						//$bd=$link->query( utf8_decode($valor));
						$bd=$link->query( ($valor));
					}
					$link->close();
				}
			}
	

		// header("Location: ../plataformaErp.php");
	}
?>

<!doctype html>
 
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link rel="shortcut icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="../touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="../touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="../touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="../css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="../css/styles.css" 	rel="stylesheet" type="text/css">
	<link href="../estilos.css" 	rel="stylesheet" type="text/css">

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<script>
	function realizaProceso(accion, carpeta){
		var parametros = {
			"accion" 	: accion,
			"carpeta"	: carpeta
		};
		//alert(carpeta);
		$.ajax({
			data: parametros,
			url: 'rutinaRestablecer.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
	
	</script>
</head>

<body>
	<!-- <span id="resultado"></span> -->
	<?php include_once('head.php');?>
		<div style="padding:10px;">
			<form action="backupRestaurar.php" method="get">
				<input name="carpeta" 	type="hidden" value="<?php echo $_GET['carpeta']; ?>">
				<input name="accion" 	type="hidden" value="<?php echo $_GET['accion']; ?>">
				<button name="iniciaRestauracion">
					Iniciar Restauración Bases de Datos <?php echo $_GET['carpeta']; ?> ...
				</button>
			</form>
		</div>
		<div style="clear:both; "></div>
</body>
</html>

<?php
function inicioRestauracion(){
	$carpeta 	= '';
	if(isset($_GET['carpeta'])){ $carpeta 	= $_GET['carpeta']; }

		$link=Conectarse();
		$archivo = "";
		$ruta	 = '';
		
		$tables = array();
		$result = $link->query('SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
		$link->close();
		foreach($tables as $table){
			//$ruta = 'backup/'.$carpeta.'/';
			$ruta = '../Data/'.$carpeta.'/';
			$archivo = $ruta.$table.'.sql';
			if(file_exists($archivo)){
				echo 'Restaurando... '.$archivo.'...';
				$sql = '';
				$fp = fopen($archivo, 'r');
				while(!feof($fp)) {
					$linea = fgets($fp);
					$sql .= $linea;
				}
				fclose($fp);
				//echo $sql;
				
				$fd=explode(';Fin',$sql);
				$link=Conectarse();
				foreach ($fd as $valor) {
					$valor .= ';';
					//echo $valor.'<br><br>';
					//$bd=$link->query( utf8_decode($valor));
					$bd=$link->query( ($valor));
				}
				$link->close();
			}
		}
}
?>	
