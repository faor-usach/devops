<?php
	session_start(); 
	// include_once("Mobile-Detect-2.3/Mobile_Detect.php");
 	// $Detect = new Mobile_Detect();
	date_default_timezone_set("America/Santiago"); 
	$maxCpo = '100%';
	$dBuscar = '';

	$colorHead = "degradado";
	$nomservidor = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	// if($nomservidor == 'servidordata'){
	// 	$colorHead = "degradadoRojo";
	// }

	include_once("conexionli.php"); 

	$link=Conectarse();
	$bdCli=$link->query("SELECT * FROM solfactura Where valorUF > 0 Order By valorUF Desc");
	if($rowCli=mysqli_fetch_array($bdCli)){
		$ultUF = $rowCli['valorUF'];
	}
	$bdCli=$link->query("SELECT * FROM tablaregform");
	if($rowCli=mysqli_fetch_array($bdCli)){
		$ultUF = $rowCli['valorUFRef'];
	}
	$link->close();

	$accion = '';
	$CAM = '';
	$RAM = '';
	$Rev = '';
	$Cta = '';
	$nPerfil = 0;
	

	$CAM = 0;

	if(isset($_GET['CAM'])) 	{	$CAM 	= $_GET['CAM']; 	}
	if(isset($_GET['RAM'])) 	{	$RAM 	= $_GET['RAM']; 	}
	if(isset($_GET['Rev'])) 	{	$Rev 	= $_GET['Rev']; 	}
	if(isset($_GET['Cta'])) 	{	$Cta 	= $_GET['Cta']; 	}
	if(isset($_GET['accion'])) 	{	$accion = $_GET['accion']; 	}
	
	if(isset($_POST['CAM'])) 	{	$CAM 	= $_POST['CAM']; 	}
	if(isset($_POST['RAM'])) 	{	$RAM 	= $_POST['RAM']; 	}
	if(isset($_POST['Rev'])) 	{	$Rev 	= $_POST['Rev']; 	}
	if(isset($_POST['Cta'])) 	{	$Cta 	= $_POST['Cta']; 	}
	if(isset($_POST['accion'])) {	$accion = $_POST['accion']; }
	
	if(isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']		= $rowPer['Perfil'];
			$_SESSION['IdPerfil']	= $rowPer['IdPerfil'];
		}
		$link->close();
	}else{
		//header("Location: http://simet.cl");
		header("Location: index.php");
	}
	// echo $_SESSION['usr'];

	if(isset($_POST['Cerrar'])){
		header("Location: cerrarsesion.php");
	}
	if($accion == "VolverPAM"){
		$Rev = '';
		
		if(isset($_POST['CAM'])) { $CAM = $_POST['CAM']; }
		if(isset($_POST['RAM'])) { $RAM = $_POST['RAM']; }
		if(isset($_POST['Rev'])) { $Rev = $_POST['Rev']; }
		if(isset($_POST['Cta'])) { $Cta	= $_POST['Cta']; }

		if(isset($_GET['CAM'])) { $CAM = $_GET['CAM']; }
		if(isset($_GET['RAM'])) { $RAM = $_GET['RAM']; }
		if(isset($_GET['Rev'])) { $Rev = $_GET['Rev']; }
		if(isset($_GET['Cta'])) { $Cta	= $_GET['Cta']; }
		
		
		$Estado				= 'P';
		
		$link=Conectarse();
		$bdCot=$link->query("Select * From cotizaciones Where CAM = '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$actSQL="UPDATE cotizaciones SET ";
			$actSQL.="Estado	 		='".$Estado."'";
			$actSQL.="WHERE CAM 		= '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
		}
		$link->close();
		$CAM 	= '';
		$RAM 	= '';
		$accion	= '';
		//header("Location: cotizaciones/plataformacotizaciones.php");
	}
	if(isset($_POST['activarRAMam'])){
		if(isset($_POST['activarRAM'])) { $activarRAM = $_POST['activarRAM']; }
		$link=Conectarse();
		$bdCot=$link->query("Select * From cotizaciones Where RAM = '".$activarRAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$blancoArchivo 	= '';
			$fechaArchivo	= '0000-00-00';
			$actSQL="UPDATE cotizaciones SET ";
			$actSQL.="Archivo	 		= '".$blancoArchivo."',";
			$actSQL.="fechaArchivo 		= '".$fechaArchivo."'";
			$actSQL.="WHERE RAM 		= '".$activarRAM."'";
			$bdCot=$link->query($actSQL);
		}
		$link->close();
	}
	if(isset($_POST['guardarSeguimientoAM'])){
		$Facturacion 		= '';
		$Archivo 			= '';
		$informeUP			= '';
		$infUP				= '';
		$Fact				= '';
		$fechaFacturacion 	= '0000-00-00';
		$nSolicitud			= '';
		$HES 				= '';
		if(isset($_POST['CAM'])) { $CAM = $_POST['CAM']; }
		if(isset($_POST['HES'])) { $HES = $_POST['HES']; }
		if(isset($_POST['RAM'])) 				{ $RAM 			 	= $_POST['RAM'];				}
		if(isset($_POST['Rev'])) 				{ $Rev 			 	= $_POST['Rev'];				}
		if(isset($_POST['Cta'])) 				{ $Cta 			 	= $_POST['Cta'];				}
		if(isset($_POST['nOC'])) 				{ $nOC 			 	= $_POST['nOC'];				}
		if(isset($_POST['informeUP'])) 			{ $informeUP 		= $_POST['informeUP'];			}
		if(isset($_POST['infUP'])) 				{ $infUP 			= $_POST['infUP'];				}
		if(isset($_POST['fechaInformeUP'])) 	{ $fechaInformeUP	= $_POST['fechaInformeUP'];		}
		if(isset($_POST['Facturacion'])) 		{ $Facturacion 	 	= $_POST['Facturacion'];		}
		if(isset($_POST['Fact'])) 				{ $Fact 	 		= $_POST['Fact'];				}
		if(isset($_POST['fechaFacturacion'])) 	{ $fechaFacturacion = $_POST['fechaFacturacion'];	}
		if(isset($_POST['Archivo'])) 			{ $Archivo	 	 	= $_POST['Archivo'];			}
		if(isset($_POST['fechaArchivo'])) 		{ $fechaArchivo	 	= $_POST['fechaArchivo'];		}
		if(isset($_POST['nSolicitud'])) 		{ $nSolicitud	 	= $_POST['nSolicitud'];			}
		if(isset($_POST['accion'])) 			{ $accion			= $_POST['accion'];				}
		if($Archivo != 'on') 		{ $fechaArchivo 	= '0000-00-00'; }
		$descargarInforme = '';
		$link=Conectarse();
		$bdCot=$link->query("Select * From cotizaciones Where CAM = '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			if($informeUP == '' and $rowCot['informeUP'] == 'on'){
				$descargarInforme = 'Si';
			}
			$fd = explode('-', $fechaArchivo);
			$actSQL="UPDATE cotizaciones SET ";
			$actSQL.="informeUP	 		='".$informeUP.			"',";
			$actSQL.="nOC		 		='".$nOC.			"',";
			$actSQL.="HES		 		='".$HES.			"',";
			$actSQL.="fechaInformeUP	='".$fechaInformeUP.	"',";
			$actSQL.="Facturacion	 	='".$Facturacion.		"',";
			$actSQL.="fechaFacturacion	='".$fechaFacturacion.	"',";
			$actSQL.="Archivo		 	='".$Archivo.			"',";
			$actSQL.="fechaArchivo		='".$fechaArchivo.		"'";
			$actSQL.="WHERE CAM 		= '".$CAM."' and RAM = '".$RAM."' and Rev = '".$Rev."' and Cta = '".$Cta."'";
			$bdCot=$link->query($actSQL);
			if($Facturacion != 'on'){
				$bdSFac=$link->query("Select * From solfactura Where nSolicitud = '".$nSolicitud."'");
				if($rowSFac=mysqli_fetch_array($bdSFac)){
					// Consultar si Anular o Eliminar Solicitud
					$Nula = 'on';
					$actSQL="UPDATE solfactura SET ";
					$actSQL.="Nula	   			= '".$Nula."'";
					//$actSQL.="WHERE nSolicitud 	= '".$nSolicitud."'";
					//$SQLsf = "Delete From solfactura Where nSolicitud = '".$nSolicitud."'";
				}	
			}
		}
		$link->close();
		if($descargarInforme == 'Si'){
			$link=Conectarse();
			$bdInf=$link->query("Select * From informes Where CodInforme Like '%".$RAM."%'");
			if($rowInf=mysqli_fetch_array($bdInf)){
				do{
					
					$informePDF = $rowInf['informePDF'];
					$host="ftp.simet.cl";
					$login="simet";
					$password="alf.artigas";
					$ftp=ftp_connect($host) or die ("no puedo conectar");
					ftp_login($ftp,$login,$password) or die ("Conexión rechazada");
					ftp_chdir($ftp,"/public_html/intranet/informes/");
					if (ftp_delete($ftp,$informePDF)){
						echo "$informePDF se ha eliminado satisfactoriamente\n";
					}else{
						echo "Error al subir el archivo<br>"; 
					}
					ftp_quit($ftp);

				}while($rowInf=mysqli_fetch_array($bdInf));
			}
			$informePDF = '';
			$fechaUp = '0000-00-00';
			
			$actSQL="UPDATE informes SET ";
			$actSQL.="informePDF	   	='".$informePDF."',";
			$actSQL.="fechaUp	   		='".$fechaUp.	"'";
			$actSQL.="WHERE CodInforme Like	'%".$RAM."%'";
			$bdCot=$link->query($actSQL);

			$link->close();
		}
		$CAM 	= '';
		$RAM 	= '';
		$accion	= '';


	}

	// Crear Carpetas
	// $periodoActual = date('Y');
	// $directorioDoc = 'Y://AAA/LE/FINANZAS/'.$periodoActual;
	// if(!file_exists($directorioDoc)){
	// 	mkdir($directorioDoc);
	// }
	// $directorioDoc = 'Y://AAA/LE/FINANZAS/'.$periodoActual.'/GASTOS/';
	// if(!file_exists($directorioDoc)){
	// 	mkdir($directorioDoc);
	// }
	// $directorioDoc = 'Y://AAA/LE/FINANZAS/'.$periodoActual.'/HONORARIOS/';
	// if(!file_exists($directorioDoc)){
	// 	mkdir($directorioDoc);
	// }
	// $directorioDoc = 'Y://AAA/LE/FINANZAS/'.$periodoActual.'/SOLICITUD-FACTURA/';
	// if(!file_exists($directorioDoc)){
	// 	mkdir($directorioDoc);
	// }

	// $directorioDoc = 'Y://AAA/LE/LABORATORIO/'.$periodoActual;
	// if(!file_exists($directorioDoc)){
	// 	mkdir($directorioDoc);
	// }

	$agnoActual = date('Y');
	// $link=Conectarse();

	// $sqlc = "SELECT * FROM cotizaciones Where Estado = 'P' and RAM > 0" ;
	// $bdc=$link->query($sqlc);
	// while($rsc=mysqli_fetch_array($bdc)){
	// 	$sql = "SELECT * FROM amtabensayos Where idItem like '%".$rsc['RAM']."%'";
	// 	$bd=$link->query($sql);
	// 	while($rs=mysqli_fetch_array($bd)){
			// $vDir="Y://AAA/LE/LABORATORIO/".$agnoActual.'/'.$rsc['RAM'];
			// if(!file_exists($vDir)){
			// 	mkdir($vDir);
			// 	$vDir="Y://AAA/LE/LABORATORIO/".$agnoActual.'/'.$rsc['RAM'].'/'.$rs['idEnsayo'];
			// 	if(!file_exists($vDir)){
			// 		mkdir($vDir);
			// 	}
			// }
	// 	}
	// }
	// $link->close();

	// Fin Crear Carpetas

?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="touch-icon-iphone.png" />
	<link rel="apple-touch-icon" href="touch-icon-ipad.png" />
	<link rel="apple-touch-icon" href="touch-icon-iphone4.png" />

	<title>Plataforma ERP de Simet</title>

	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="estilos.css" 	rel="stylesheet" type="text/css">
	<!-- <link rel="stylesheet" href="cssboot/bootstrap.min.css"> -->

  

  	<!-- BAJAR ESTA LIBRERIA -->	
	<script src="jquery/jquery-1.10.2.js"></script>

	<script src="jquery/jquery-3.3.1.min.js"></script>
	<script src="jquery/ajax/popper.min.js"></script>
	<script type="text/javascript" src="jquery/libs/1/jquery.min.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  	<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

	<script type="text/javascript" src="angular/angular.min.js"></script>
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	
	<script language="javascript" src="validaciones.js"></script> 
	

	
	
	<script>
	function seguimientoAM(CAM, RAM, Rev, Cta, accion){
		var parametros = {
			"CAM" 		: CAM,
			"RAM" 		: RAM,
			"Rev" 		: Rev,
			"Cta" 		: Cta,
			"accion"	: accion
		};
		alert(accion);
		$.ajax({
			data: parametros,
			url: 'segAM.php',
			type: 'get',
			success: function (response) {
				$("#resultadoAM").html(response); 
			}
		});
	}
	</script>

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

<body OnLoad="NoBack();" ng-app="myApp" ng-controller="personCtrl" ng-init="loadConfig('<?php echo $_SESSION['usr']; ?>')" ng-cloak>

	<?php 
		include_once('head.php');
	?>
	<input type="hidden" ng-model="usr" ng-init="leercotizacionesCAM('<?php echo $_SESSION['usr']; ?>')">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="200px" rowspan="5" valign="top">
				<?php include_once('menulateral.php')?> 
			</td>
			<td width="<?php echo $maxCpo; ?>" valign="top">
				<?php
				if($_SESSION['IdPerfil'] == '1'){
					mCAMs();
				}
				if($_SESSION['Perfil'] == 'Acreditación'){
					$nAC = 0;
					$fechaHoyDia = date('Y-m-d');
					$link=Conectarse();
					$bdAC=$link->query("Select * From equipos Where fechaProxCal <= '".$fechaHoyDia."'");
					while($rowAC=mysqli_fetch_array($bdAC)){
						$nAC++;
					}
					$link->close();
					
					if($nAC>0){
						mEquipamiento($_SESSION['usr'], 'Seguimiento');
					}
				}
				muestraPreCAM($_SESSION['usr']);
				$nAC = 0;
				$fechaHoyDia = date('Y-m-d');
				$link=Conectarse();
				$bdAC=$link->query("Select * From actividades Where usrResponsable = '".$_SESSION['usr']."' and Estado = 'P' or Estado = ''");
				while($rowAC=mysqli_fetch_array($bdAC)){
					if($rowAC['usrResponsable'] == $_SESSION['usr']){ 
						$nAC++;
					}
				}
				$link->close();
				if($nAC>0){
					mactividades($_SESSION['usr'], 'Seguimiento');
				}

				if($_SESSION['usr']=='Alfredo.Artigas' or $_SESSION['usr'] == '10074437' or $_SESSION['usr'] == 'RPM'){
					include_once('resumenGeneral.php');  
				}
				?>
				<div ng-show="enProceso">
					<img src="imagenes/ajax-loader.gif"> MOMENTO PROCESANDO DATOS...
				</div>
				<div ng-show="tablasAM">
					<div class="row" style="margin: 10px;">
						<div class="col-md-2">
							Filtrar :
						</div>
						<div class="col-md-4">
							<input class="form-control" type="text" ng-model="search">
						</div>
						<div class="col-md-4">
							<a href="cotizaciones/exportarAM.php" title="Descargar AM..." style="padding:15p; float:right; ">
								<img src="imagenes/AM.png" width="50" height="50">
							</a>
						</div>
					</div>
					<?php
						include_once("trabajosAM.php");
						include_once("trabajosAMrosados.php"); 
						include_once("trabajosAMAmarillos.php");
					?>
				</div>
				<?php
					if($accion == 'SeguimientoAM'){?>
						<script>
							var CAM 	= "<?php echo $CAM; ?>" ;
							var RAM 	= "<?php echo $RAM; ?>" ;
							var Rev 	= "<?php echo $Rev; ?>" ;
							var Cta 	= "<?php echo $Cta; ?>" ;
							var accion 	= "<?php echo $accion; ?>" ;
							seguimientoAM(CAM, RAM, Rev, Cta, accion);
						</script>
						<?php
					}
				?>
				<span id="resultadoAM"></span>

			</td>
		</tr>
	</table>


	<!-- <script src="jsboot/bootstrap.min.js"></script> -->
	<script src="plataforma.js"></script>

</body>
</html>

<?php
function muestraPreCAM($usrRes){
	$link=Conectarse();
	$fechaHoyDia = date('Y-m-d');
	$nPreCam = 0;
	$salto = '';

	$SQL = "SELECT Count(*) as nPre FROM precam Where usrResponsable = '".$usrRes."' and Estado = 'on'";
	$result  = $link->query($SQL);  
	$rowRev	 = mysqli_fetch_array($result);
	$nPreCam = $rowRev['nPre'];
	
	if($nPreCam > 0){?>
		<div style="background-color:#CCCCCC; padding:5px; font-size:14px; border-bottom:2px solid #000; border-top:1px solid #000; font-family:Geneva, Arial, Helvetica, sans-serif; color:#FFFFFF;">
			<img src='imagenes/important.png' width=40 align="absmiddle">
			<span style="padding-left:20px;">SEGUIMIENTO PRECAM</span>
		</div>
		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-family:arial;">
			<tr style="background-color:#000; color:#fff; font-size:12px; padding:15px;">
				<td  width="10%" align="center" height="30">Fecha<br>PRECAM		</td>
				<td  width="80%">							Correo				</td>
				<td  width="10%">												</td>
			</tr>
			<?php
			$sql = "SELECT * FROM precam Where usrResponsable = '".$usrRes."' and Estado = 'on'";
			$bdPc=$link->query($sql);
			if($rowPc=mysqli_fetch_array($bdPc)){
				do{
						$tr = "bVerde";
						$fechaHoy = date('Y-m-d');

						$fechaVencida 	= strtotime ( '-30 day' , strtotime ( $fechaHoy ) );
						$fechaVencida 	= date ( 'Y-m-d' , $fechaVencida );

						if($rowPc['fechaPreCAM'] == '0000-00-00'){
							$tr = "bRoja";
						}						
						if($rowPc['seguimiento'] == 'on'){
							$tr = "bAmarilla";
						}
						if($rowPc['fechaPreCAM'] <= $fechaVencida){
							$tr = "bRoja";
						}						
					?>
					<tr id="<?php echo $tr; ?>">
						<td><?php echo $rowPc['fechaPreCAM']; ?></td>
						<td><?php echo $rowPc['Correo']; ?>		</td>
						<td align="center"><a href="precam?idPreCAM=<?php echo $rowPc['idPreCAM']; ?>"	><img src="imagenes/other_48.png" 		width="40" height="40" title="ir a Proceso">	</a></td>
					</tr>
					<?php
				}while ($rowPc=mysqli_fetch_array($bdPc));
			}?>
		</table>
		<?php
	}
	$link->close();
}

function mCAMs(){
	global $ultUF;
	?>
	<div class="container-fluid m-2">
		<div class="card">
			<div class="card-header">
				<h3>Cotizaciones</h3>
			</div>
  			<div class="card-body" ng-show="swcotizaciones">
				<div ng-show="cargaDatos">
					<img src="../imagenes/enProceso.gif" width="50">
				</div>
				<table  style="margin-top: 5px; font-size: 12px;">
					<thead>
						<tr>
							<th>CAM			</th>
							<th>Fecha		</th>
							<th>clientes	</th>
							<th>Total		</th>
							<th>Valida Hasta		</th>
							<th>Est. 		</th>
							<!-- <th>Acciones	</th> -->
						</tr>
					</thead>
					<tbody>
			
						<tr ng-repeat="Cam in cotizacionesCAM"  
							ng-class="verColorLinea(Cam.Estado, Cam.RAM, Cam.BrutoUF, Cam.nDias, Cam.rCot, Cam.fechaAceptacion, Cam.proxRecordatorio, Cam.colorCam)">
			
							<td>
								<span ng-if="Cam.Fan > 0">
									<span class="badge badge-pill badge-danger">
										<h6 title="Facturas Pendientes">CLON</h6>
									</span>
								</span> 
								C{{Cam.CAM}}
								<span ng-if="Cam.RAM > 0">
									/ R{{Cam.RAM}}<span ng-if="Cam.Fan > 0">-{{Cam.Fan}}</span>
									<span ng-if="Cam.fechaAceptacion != '0000-00-00'">
										<span class="badge badge-warning">Aceptada</span> 
									</span>
								</span>
								<span ng-if="Cam.sDeuda > 0">
									<img class="p-2" src="imagenes/bola_amarilla.png">
									<span class="badge badge-warning" title="Moroso">{{Cam.sDeuda | currency:"$ ":0}}</span>
								</span>
			
							</td>
							<td>
								{{Cam.fechaCotizacion | date:'dd/MM/yyyy'}}<br>
							</td>
							<td>{{Cam.Cliente}}</td>
							<td>
								<div ng-if="Cam.Bruto > 0">
									{{Cam.Bruto | currency:"$ ":0}}
								</div>
								<div ng-if="Cam.BrutoUF > 0">
									{{Cam.BrutoUF | currency:"UF "}}
								</div>
			
							</td>
							<td>
								{{Cam.fechaTermino | date:'dd/MM/yyyy'}}
								<span class="badge badge-pill badge-danger" ng-if="Cam.nDias < 0">
									<b>{{Cam.nDias}}</b>
								</span>
								<span class="badge badge-pill badge-primary" ng-if="Cam.nDias > 0">
									<b>{{Cam.nDias}}</b>
								</span>
								<br>
							</td>
							<td>
								
								<span ng-if="Cam.enviadoCorreo == ''">
									<img style="padding:5px;" src="imagenes/noEnviado.png" align="left" width="40" title="Cotización NO Enviada">
									{{Cam.fechaEnvio | date:'dd/MM/yy'}}
								</span>
								
								<span ng-if="Cam.enviadoCorreo == 'on' && Cam.Contactar == 'No'">
									Email <!-- <img style="padding:5px;" src="imagenes/enviarConsulta.png" align="left" width="40" title="Cotización enviado en correo automatico"> -->
									{{Cam.fechaEnvio | date:'dd/MM/yy'}}
								</span>
								
								<span ng-if="Cam.proxRecordatorio != '0000-00-00'">
									<!-- <img style="padding:5px;" src="imagenes/alerta.gif" align="left" width="50" title="Contactar con Cliente"> -->
									Contactar {{Cam.proxRecordatorio | date:'dd/MM/yy'}}
								</span>
								
							</td>
						</tr>
					</tbody>
				</table>
			</div>	
		</div>	
	</div>
<?php
}						
?>
