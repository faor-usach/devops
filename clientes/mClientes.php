<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
	
	include_once("../conexionli.php");
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

	$RutCli 		= "";
	$Cliente 		= "";
	$Giro 			= "";
	$Direccion		= "";
	$Telefono		= "";
	$Celular		= "";
	$Email			= "";
	$Sitio			= "";
	$Publicar		= "";
	$HES			= "";
	$Contacto		= "";
	$DeptoContacto	= "";
	$FonoContacto	= "";
	$EmailContacto	= "";
	$Contacto2		= "";
	$FonoContacto2	= "";
	$DeptoContacto2	= "";
	$EmailContacto2	= "";
	$Contacto3		= "";
	$DeptoContacto3	= "";
	$FonoContacto3	= "";
	$EmailContacto3	= "";
	$Contacto4		= "";
	$DeptoContacto4	= "";
	$FonoContacto4	= "";
	$EmailContacto4	= "";
	$cFree			= "";
	$Estado 		= '';
	$Docencia		= "";
	$Msg			= '';

	$Proceso = 1;


	if(isset($_GET['Proceso'])) { $Proceso  = $_GET['Proceso']; }
	if(isset($_GET['RutCli']))  { $RutCli   = $_GET['RutCli']; }

	if(isset($_POST['Proceso'])) { $Proceso  = $_POST['Proceso']; }
	if(isset($_POST['RutCli']))  { $RutCli   = $_POST['RutCli']; }


	if(isset($_POST['SubirLogo'])){ 
	}
	if(isset($_POST['Guardar'])){ 
		$Logo = '';
		/*
		$nombre_archivo = $_FILES['imgLogo']['name'];
		$tipo_archivo 	= $_FILES['imgLogo']['type'];
		$tamano_archivo = $_FILES['imgLogo']['size'];
		$desde 			= $_FILES['imgLogo']['tmp_name'];
		
		if($nombre_archivo){
			$Logo = $nombre_archivo;
			$directorio="../logos";
			if (($tipo_archivo == "image/jpeg" || $tipo_archivo == "image/png" || $tipo_archivo == "image/gif") ) { 
				if (move_uploaded_file($desde, $directorio."/".$nombre_archivo)){ 
					
				}
			}
		}else{
			if(isset($_POST['Logo']))			{ $Logo 			= $_POST['Logo']; 						}
		}
		*/
		// $link=Conectarse();
		// $bdProv=$link->query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
		// if ($row=mysqli_fetch_array($bdProv)){
		// 	$HES = 'off';
		// 	if(isset($_POST['HES'])){ $HES = $_POST['HES']; }
		// 	if(isset($_POST['Cliente']))		{ $Cliente 			= strtoupper($_POST['Cliente']); 		}
		// 	if(isset($_POST['Giro']))			{ $Giro 			= strtoupper($_POST['Giro']); 			}
		// 	if(isset($_POST['Direccion']))		{ $Direccion 		= strtoupper($_POST['Direccion']); 		}
		// 	if(isset($_POST['Telefono']))		{ $Telefono  		= $_POST['Telefono']; 					}
		// 	if(isset($_POST['Email']))			{ $Email  			= strtoupper($_POST['Email']); 			}
		// 	if(isset($_POST['Sitio']))			{ $Sitio  			= $_POST['Sitio']; 						}
		// 	if(isset($_POST['Publicar']))		{ $Publicar			= $_POST['Publicar']; 					}
		// 	if($Publicar=='on'){
		// 		$Publicar = 1;
		// 	}else{
		// 		$Publicar = 0;
		// 	}
		// 	if(isset($_POST['Celular']))		{ $Celular  		= $_POST['Celular']; 		}
		// 	if(isset($_POST['Contacto']))		{ $Contacto  		= strtoupper($_POST['Contacto']); 		}
		// 	if(isset($_POST['DeptoContacto']))	{ $DeptoContacto  	= $_POST['DeptoContacto']; 	}
		// 	if(isset($_POST['FonoContacto']))	{ $FonoContacto  	= $_POST['FonoContacto']; 	}
		// 	if(isset($_POST['EmailContacto']))	{ $EmailContacto  	= $_POST['EmailContacto']; 	}
		// 	if(isset($_POST['Contacto2']))		{ $Contacto2  		= $_POST['Contacto2']; 		}
		// 	if(isset($_POST['DeptoContacto2']))	{ $DeptoContacto2  	= $_POST['DeptoContacto2']; }
		// 	if(isset($_POST['FonoContacto2']))	{ $FonoContacto2  	= $_POST['FonoContacto2']; 	}
		// 	if(isset($_POST['EmailContacto2']))	{ $EmailContacto2  	= $_POST['EmailContacto2']; }
		// 	if(isset($_POST['Contacto3']))		{ $Contacto3  		= $_POST['Contacto3']; 		}
		// 	if(isset($_POST['DeptoContacto3']))	{ $DeptoContacto3  	= $_POST['DeptoContacto3']; }
		// 	if(isset($_POST['FonoContacto3']))	{ $FonoContacto3  	= $_POST['FonoContacto3']; 	}
		// 	if(isset($_POST['EmailContacto3']))	{ $EmailContacto3  	= $_POST['EmailContacto3']; }
		// 	if(isset($_POST['Contacto4']))		{ $Contacto4  		= $_POST['Contacto4']; 		}
		// 	if(isset($_POST['DeptoContacto4']))	{ $DeptoContacto4  	= $_POST['DeptoContacto4']; }
		// 	if(isset($_POST['FonoContacto4']))	{ $FonoContacto4  	= $_POST['FonoContacto4']; 	}
		// 	if(isset($_POST['EmailContacto4']))	{ $EmailContacto4  	= $_POST['EmailContacto4']; }
		// 	if(isset($_POST['cFree']))			{ $cFree  			= $_POST['cFree']; 			}
		// 	if(isset($_POST['Docencia']))		{ $Docencia  		= $_POST['Docencia']; 		}
		// 	if(isset($_POST['Estado']))			{ $Estado  			= $_POST['Estado']; 		}
		// 	if(isset($_POST['Msg']))			{ $Msg  			= $_POST['Msg']; 			}
			
		// 	$actSQL="UPDATE clientes SET ";
		// 	$actSQL.="Cliente		='".$Cliente.		"',";
		// 	$actSQL.="Giro			='".$Giro.			"',";
		// 	$actSQL.="Direccion		='".$Direccion.		"',";
		// 	$actSQL.="Telefono		='".$Telefono.		"',";
		// 	$actSQL.="Celular		='".$Celular.		"',";
		// 	$actSQL.="Sitio			='".$Sitio.			"',";
		// 	$actSQL.="Publicar		='".$Publicar.		"',";
		// 	$actSQL.="HES			='".$HES.			"',";
		// 	$actSQL.="Logo			='".$Logo.			"',";
		// 	$actSQL.="Email		    ='".$Email.			"',";
		// 	$actSQL.="Contacto	    ='".$Contacto.		"',";
		// 	$actSQL.="DeptoContacto	='".$DeptoContacto.	"',";
		// 	$actSQL.="FonoContacto	='".$FonoContacto.	"',";
		// 	$actSQL.="EmailContacto	='".$EmailContacto.	"',";
		// 	$actSQL.="Contacto2	    ='".$Contacto2.		"',";
		// 	$actSQL.="DeptoContacto2='".$DeptoContacto2."',";
		// 	$actSQL.="FonoContacto2	='".$FonoContacto2.	"',";
		// 	$actSQL.="EmailContacto2='".$EmailContacto2."',";
		// 	$actSQL.="Contacto3	    ='".$Contacto3.		"',";
		// 	$actSQL.="DeptoContacto3='".$DeptoContacto3."',";
		// 	$actSQL.="FonoContacto3	='".$FonoContacto3.	"',";
		// 	$actSQL.="EmailContacto3='".$EmailContacto3."',";
		// 	$actSQL.="Contacto4	    ='".$Contacto4.		"',";
		// 	$actSQL.="DeptoContacto4='".$DeptoContacto4."',";
		// 	$actSQL.="FonoContacto4	='".$FonoContacto4.	"',";
		// 	$actSQL.="EmailContacto4='".$EmailContacto4."',";
		// 	$actSQL.="cFree			='".$cFree.			"',";
		// 	$actSQL.="Msg			='".$Msg.			"',";
		// 	$actSQL.="Estado		='".$Estado.		"',";
		// 	$actSQL.="Docencia		='".$Docencia.		"'";
		// 	$actSQL.="WHERE RutCli	= '".$RutCli.		"'";
		// 	$bdProv=$link->query($actSQL);
		// }	
		// $link->close();
	}
	
	if(isset($_POST['consultaCliente'])){
		// if($_POST['RutCli'])  { $RutCli   = $_POST['RutCli']; }
		// $link=Conectarse();
		// $bdProv=$link->query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
		// if ($row=mysqli_fetch_array($bdProv)){
		// 	$Proceso = 2;
		// }
		// $link->close();
	}else{
		// $sw = false;
		// if(isset($_POST['Proceso'])){ 
		// 	$Proceso 	= $_POST['Proceso'];
		// 	if(isset($_POST['Cliente'])){
		// 		$Cliente 	= strtoupper($_POST['Cliente']);
		// 		if(isset($_POST['RutCli'])){
		// 			$RutCli 	= $_POST['RutCli'];
					
		// 			if(isset($_POST['Giro']))			{ $Giro 			= strtoupper($_POST['Giro']); 			}
		// 			if(isset($_POST['Direccion']))		{ $Direccion 		= strtoupper($_POST['Direccion']); 		}
		// 			if(isset($_POST['Telefono']))		{ $Telefono  		= $_POST['Telefono']; 					}
		// 			if(isset($_POST['Email']))			{ $Email  			= strtoupper($_POST['Email']); 			}
		// 			if(isset($_POST['Sitio']))			{ $Sitio  			= $_POST['Sitio']; 						}
		// 			if(isset($_POST['Publicar']))		{ 
		// 				$Publicar			= $_POST['Publicar']; 					
		// 				if($Publicar=='on'){
		// 					$Publicar = 1;
		// 				}else{
		// 					$Publicar = 0;
		// 				}
		// 			}
		// 			if(isset($_POST['Celular']))		{ $Celular  		= $_POST['Celular']; 		}
		// 			if(isset($_POST['Contacto']))		{ $Contacto  		= strtoupper($_POST['Contacto']); 		}
		// 			if(isset($_POST['DeptoContacto']))	{ $DeptoContacto  	= $_POST['DeptoContacto']; 	}
		// 			if(isset($_POST['FonoContacto']))	{ $FonoContacto  	= $_POST['FonoContacto']; 	}
		// 			if(isset($_POST['EmailContacto']))	{ $EmailContacto  	= $_POST['EmailContacto']; 	}
		// 			if(isset($_POST['Contacto2']))		{ $Contacto2  		= $_POST['Contacto2']; 		}
		// 			if(isset($_POST['DeptoContacto2']))	{ $DeptoContacto2  	= $_POST['DeptoContacto2']; }
		// 			if(isset($_POST['FonoContacto2']))	{ $FonoContacto2  	= $_POST['FonoContacto2']; 	}
		// 			if(isset($_POST['EmailContacto2']))	{ $EmailContacto2  	= $_POST['EmailContacto2']; }
		// 			if(isset($_POST['Contacto3']))		{ $Contacto3  		= $_POST['Contacto3']; 		}
		// 			if(isset($_POST['DeptoContacto3']))	{ $DeptoContacto3  	= $_POST['DeptoContacto3']; }
		// 			if(isset($_POST['FonoContacto3']))	{ $FonoContacto3  	= $_POST['FonoContacto3']; 	}
		// 			if(isset($_POST['EmailContacto3']))	{ $EmailContacto3  	= $_POST['EmailContacto3']; }
		// 			if(isset($_POST['Contacto4']))		{ $Contacto4  		= $_POST['Contacto4']; 		}
		// 			if(isset($_POST['DeptoContacto4']))	{ $DeptoContacto4  	= $_POST['DeptoContacto4']; }
		// 			if(isset($_POST['FonoContacto4']))	{ $FonoContacto4  	= $_POST['FonoContacto4']; 	}
		// 			if(isset($_POST['EmailContacto4']))	{ $EmailContacto4  	= $_POST['EmailContacto4']; }
		// 			if(isset($_POST['cFree']))			{ $cFree  			= $_POST['cFree']; 			}
		// 			if(isset($_POST['Docencia']))		{ $Docencia  		= $_POST['Docencia']; 		}
		// 			if(isset($_POST['Estado']))			{ $Estado  			= $_POST['Estado']; 		}
		// 			if(isset($_POST['Msg']))			{ $Msg  			= $_POST['Msg']; 			}
		// 			$sw = true;
		// 		}
		// 	}
		// }
	
		// if($sw == true){
		// 	$sw = false;
			
		// 	if($Proceso == 1 || $Proceso == 2 || $Proceso == 3){ /* Agregar */
		// 		$link=Conectarse();
		// 		$bdProv=$link->query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
		// 		if ($row=mysqli_fetch_array($bdProv)){
		// 			if($Proceso == 2){
		// 				$MsgUsr = 'Registro Actualizado...';
		// 				$bdProv=$link->query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
		// 				if ($row=mysqli_fetch_array($bdProv)){

		// 					$HES = 'off';
		// 					if(isset($_POST['HES'])){ $HES = $_POST['HES']; }

		// 					$actSQL="UPDATE clientes SET ";
		// 					$actSQL.="Cliente		='".$Cliente.		"',";
		// 					$actSQL.="Giro			='".$Giro.			"',";
		// 					$actSQL.="Direccion		='".$Direccion.		"',";
		// 					$actSQL.="Telefono		='".$Telefono.		"',";
		// 					$actSQL.="Celular		='".$Celular.		"',";
		// 					$actSQL.="Sitio			='".$Sitio.			"',";
		// 					$actSQL.="Publicar		='".$Publicar.		"',";
		// 					$actSQL.="HES			='".$HES.			"',";
		// 					$actSQL.="Email		    ='".$Email.			"',";
		// 					$actSQL.="Contacto	    ='".$Contacto.		"',";
		// 					$actSQL.="DeptoContacto	='".$DeptoContacto.	"',";
		// 					$actSQL.="FonoContacto	='".$FonoContacto.	"',";
		// 					$actSQL.="EmailContacto	='".$EmailContacto.	"',";
		// 					$actSQL.="Contacto2	    ='".$Contacto2.		"',";
		// 					$actSQL.="DeptoContacto2='".$DeptoContacto2."',";
		// 					$actSQL.="FonoContacto2	='".$FonoContacto2.	"',";
		// 					$actSQL.="EmailContacto2='".$EmailContacto2."',";
		// 					$actSQL.="Contacto3	    ='".$Contacto3.		"',";
		// 					$actSQL.="DeptoContacto3='".$DeptoContacto3."',";
		// 					$actSQL.="FonoContacto3	='".$FonoContacto3.	"',";
		// 					$actSQL.="EmailContacto3='".$EmailContacto3."',";
		// 					$actSQL.="Contacto4	    ='".$Contacto4.		"',";
		// 					$actSQL.="DeptoContacto4='".$DeptoContacto4."',";
		// 					$actSQL.="FonoContacto4	='".$FonoContacto4.	"',";
		// 					$actSQL.="EmailContacto4='".$EmailContacto4."',";
		// 					$actSQL.="cFree			='".$cFree.			"',";
		// 					$actSQL.="Msg			='".$Msg.			"',";
		// 					$actSQL.="Estado		='".$Estado.		"',";
		// 					$actSQL.="Docencia		='".$Docencia.		"'";
		// 					$actSQL.="WHERE RutCli	= '".$RutCli.		"'";
		// 					$bdProv=$link->query($actSQL);

		// 				}
		// 			}
		// 			if($Proceso == 3){
		// 				//$bdProv=$link->query("DELETE FROM clientes WHERE RutCli = '".$RutCli."'");
		// 				$bdProv=$link->query("DELETE FROM contactoscli WHERE RutCli = '".$RutCli."'");
		// 				$link->close();
		// 				header("Location: clientes.php");
		// 			}
		// 		}else{
		// 			$MsgUsr = 'Se Registro Cliente Nuevo hoy dia...';
		// 			echo $MsgUsr;
		// 			$HES = 'off';
		// 			if(isset($_POST['HES'])){ $HES = $_POST['HES']; }

		// 			$link->query("insert into clientes(		RutCli,
		// 													Cliente,
		// 													Giro,
		// 													Direccion,
		// 													Telefono,
		// 													Celular,
		// 													Email,
		// 													Sitio,
		// 													Publicar,
		// 													HES,
		// 													Contacto,
		// 													DeptoContacto,
		// 													FonoContacto,
		// 													EmailContacto,
		// 													Contacto2,
		// 													DeptoContacto2,
		// 													FonoContacto2,
		// 													EmailContacto2,
		// 													Contacto3,
		// 													DeptoContacto3,
		// 													FonoContacto3,
		// 													EmailContacto3,
		// 													Contacto4,
		// 													DeptoContacto4,
		// 													FonoContacto4,
		// 													EmailContacto4,
		// 													cFree,
		// 													Msg,
		// 													Estado,
		// 													Docencia
		// 													) 
		// 									values 		(	'$RutCli',
		// 													'$Cliente',
		// 													'$Giro',
		// 													'$Direccion',
		// 													'$Telefono',
		// 													'$Celular',
		// 													'$Email',
		// 													'$Sitio',
		// 													'$Publicar',
		// 													'$HES',
		// 													'$Contacto',
		// 													'$DeptoContacto',
		// 													'$FonoContacto',
		// 													'$EmailContacto',
		// 													'$Contacto2',
		// 													'$DeptoContacto2',
		// 													'$FonoContacto2',
		// 													'$EmailContacto2',
		// 													'$Contacto3',
		// 													'$DeptoContacto3',
		// 													'$FonoContacto3',
		// 													'$EmailContacto3',
		// 													'$Contacto4',
		// 													'$DeptoContacto4',
		// 													'$FonoContacto4',
		// 													'$EmailContacto4',
		// 													'$cFree',
		// 													'$Msg',
		// 													'$Estado',
		// 													'$Docencia'
		// 													)");

		// 		}
		// 		$link->close();
		// 	}
		// }

	}	
		// $link=Conectarse();
		// $bdProv=$link->query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
		// if ($row=mysqli_fetch_array($bdProv)){
   		// 	$Cliente 		= $row['Cliente'];
		// 	$Giro			= $row['Giro'];
		// 	$Direccion		= $row['Direccion'];
   		// 	$Telefono  		= $row['Telefono'];
   		// 	$Celular  		= $row['Celular'];
		// 	$Email 			= $row['Email'];
		// 	$Sitio 			= $row['Sitio'];
		// 	$Publicar		= $row['Publicar'];
		// 	$Contacto 		= $row['Contacto'];
		// 	$DeptoContacto 	= $row['DeptoContacto'];
		// 	$FonoContacto 	= $row['FonoContacto'];
		// 	$EmailContacto 	= $row['EmailContacto'];
		// 	$Contacto2 		= $row['Contacto2'];
		// 	$DeptoContacto2	= $row['DeptoContacto2'];
		// 	$FonoContacto2 	= $row['FonoContacto2'];
		// 	$EmailContacto2	= $row['EmailContacto2'];
		// 	$Contacto3 		= $row['Contacto3'];
		// 	$DeptoContacto3	= $row['DeptoContacto3'];
		// 	$FonoContacto3 	= $row['FonoContacto3'];
		// 	$EmailContacto3	= $row['EmailContacto3'];
		// 	$Contacto4 		= $row['Contacto4'];
		// 	$DeptoContacto4	= $row['DeptoContacto4'];
		// 	$FonoContacto4 	= $row['FonoContacto4'];
		// 	$EmailContacto4	= $row['EmailContacto4'];
		// 	$cFree			= $row['cFree'];
		// 	$Msg			= $row['Msg'];
		// 	$Logo			= $row['Logo'];
		// 	$Docencia		= $row['Docencia'];
		// 	$Estado			= $row['Estado'];
		// }
		// $link->close();

	
?>
<!doctype html>
 
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Módulo de Clientes</title>

<link href="styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<!-- <link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
	<script type="text/javascript" src="../angular/angular.js"></script>



<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
input.mayusculas{text-transform:uppercase;}
</style>
<script language="javascript" src="validaciones.js"></script> 
<script src="../jquery/jquery-1.6.4.js"></script>
</head>
<body ng-app="myApp" ng-controller="CtrlClientes" ng-init="loadDataCliente('<?php echo $RutCli; ?>')">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		
		<form action="mClientes.php" method="get" enctype="multipart/form-data">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Mantención Clientes <!-- <img src="imagenes/room_32.png" width="28" height="28"> -->
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesión">
						<img src="../gastos/imagenes/preview_exit_32.png" width="32" height="32">
					</a>
				</div>
			</div>

			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft"> 
					<a href="clientes.php" title="Clientes">
						<img src="../imagenes/send_48.png"><br>
					</a>
					Clientes
				</div>
				<div id="ImagenBarraLeft">
					<a href="../facturacion/formSolicitaFactura.php?RutCli=<?php echo $RutCli; ?>" title="Solicitud de Factura">
						<img src="../gastos/imagenes/crear_certificado.png"><br>
					</a>
					Facturar
				</div>
				
			</div>
			
			<!-- Fin Caja Cuerpo -->
			<div class="row p-3 mb-2 bg-secondary text-dark">
				<div class="col-sm-10">
					<b>Ficha Registro de Clientes</b>
				</div>
				<div class="col-sm">
					<div class="btn-group">
						<button type="button" class="btn btn-primary" ng-show="btnGuardar"	ng-click="grabarDataCliente()">Grabar	</button>
					</div>
					<div class="btn-group">	
						<button type="button" class="btn btn-danger" ng-show="btnEliminar"	ng-click="borrarDataCliente()">Eliminar </button>
					</div>
				</div>
			</div>

			<div align="center">


				<div id="RegistroFactura">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
						<tr>
							<td>Rut: </td>
						  	<td>
						  		<div class="row">
						  			<div class="col-3">
										<input name="RutCli" 	ng-model="RutCli" ng-blur="verificaExisteCliente('<?php echo $RutCli; ?>')" class="form-control" 	type="text" size="10" maxlength="10" value="<?php echo $RutCli; ?>">
										<input name="Proceso"  	type="hidden" value="<?php echo $Proceso; ?>">
									</div>
								</div>
							</td>
							<?php
							if($RutCli){
								?>
								<td width="44%" colspan="2" rowspan="5" align="center">
									
									<?php
									/*
										if($row['Logo']){
											//$logoEmp = '../../intranet/logos/'.$row['Logo'];
											$logoEmp = '../logos/'.$row['Logo'];
											$size 		= GetImageSize("$logoEmp");
											$anchura	= $size[0]/2; 
											$altura		= $size[1]/2;
										}else{
											$logoEmp = '../imagenes/testnoimg.png';
											$size 		= GetImageSize("$logoEmp");
											$anchura	= $size[0]; 
											$altura		= $size[1];
										}
										echo '<a href="logoClientes.php?RutCli='.$row['RutCli'].'"><img src="'.$logoEmp.'" class="imgCli" width="'.$anchura.'" height="'.$altura.'" title="Modificar Logo"></a>';
									*/
										?>
									<br>
									<!--
										<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
										<input name="imgLogo" type="file" id="imgLogo"><br>
									-->
								</td>
								<?php
							}
							?>
					    </tr>
							<tr>
								<td>Cliente: </td>
								<td>
									<input name="Cliente" ng-model="Cliente"	type="text" size="100" maxlength="100" value="<?php echo $Cliente; ?>" class="mayusculas">
								</td>
							</tr>
							<tr>
								<td>Estado: </td>
								<td> 
									<span style=" font-size:16px; font-weight:700;">
										<select name="Estado" ng-model="Estado">
											<?php if($Estado == 'on'){?>
												<option selected 	value="on">	Activo	</option>
												<option  			value="off">Inactivo</option>
											<?php }else{ ?>
												<option  			value="on">	Activo	</option>
												<option selected 	value="off">Inactivo</option>
											<?php } ?>
										</select>
									</span>
								</td>
							</tr>
								<tr>
								  <td>Publicar:</td>
								  <td>
										<?php if($Publicar==1){?>
												<input name="Publicar" ng-model="Publicar" type="checkbox" checked>
										<?php }else{ ?>
												<input name="Publicar" ng-model="Publicar" type="checkbox">
										<?php } ?>
								  </td>
							  	</tr>
								<tr>
									<td>Cliente Free: </td>
									<td>
										<?php if($cFree){?>
												<input name="cFree" ng-model="cFree" type="checkbox" checked>
										<?php }else{ ?>
												<input name="cFree" ng-model="cFree" type="checkbox">
										<?php } ?>
										&nbsp;Docencia
										<?php if($Docencia){?>
												<input name="Docencia" ng-model="Docencia" type="checkbox" checked>
										<?php }else{ ?>
												<input name="Docencia" ng-model="Docencia" type="checkbox">
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td>HES:</td>
									<td>
										<!-- <input ng-model="RutEmp" type="hidden" ng-init="loadDataCliente()"> -->
										<div class="row">
											<div class="col-3">
									  			<div class="form-group">
									            	<select ng-model="HES" ng-model="HES" name="HES" class="form-control">
									                	<option value="">HES</option>
									                  	<option ng-repeat="h in tipoHes" value="{{h.codHes}}">
									                    	{{h.descripcion}}
									                  	</option>
									              	</select>
									    		</div>
									    	</div>
									    </div>
									</td>
								</tr>
								<tr>
									<td>Giro: </td>
									<td colspan="3">
										<textarea class="form-control" name="Giro" ng-model="Giro" rows="5" id="Giro"><?php echo $Giro; ?></textarea>
									</td>
								</tr>
								<tr>
									<td>Dirección: </td>
									<td colspan="3">
										<input name="Direccion" ng-model="Direccion" 	type="text" size="100" maxlength="100" value="<?php echo $Direccion;?>">
									</td>
								</tr>
								<tr>
									<td>Teléfono: </td>
									<td colspan="3">
										<input name="Telefono" ng-model="Telefono" 	type="text" size="30" maxlength="30" value="<?php echo $Telefono;?>">
									</td>
								</tr>
								<tr>
								  <td height="20">Celular: </td>
								  <td colspan="3"><input name="Celular" ng-model="Celular" 	type="text" size="13" maxlength="13" value="<?php echo $Celular; ?>"></td>
							  </tr>
								<tr>
								  <td height="25">Sitio:</td>
								  <td colspan="3"><input name="Sitio" ng-model="Sitio" 	type="text" size="100" maxlength="100" value="<?php echo $Sitio; ?>"></td>
							  </tr>
								<tr>
									<td height="25">Observaciónes:</td>
									<td colspan="3">
										<textarea name="Msg" ng-model="Msg" cols="90" rows="10"><?php echo $Msg; ?></textarea>
									</td>
								</tr>
								<tr>
									<td height="35" colspan="5" class="tituloficha">Contactos					      </td>
								</tr>
					</table>
				</div>
			</div>
		</div>
		</form>
		<br>
		<div class="container-fluid m-2">
			<table class="mt-5" border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
				<thead>
					<tr>
						<th width="10%">N°			</th>
						<th width="30%">Contacto	</th>
						<th width="30%">Correo		</th>
						<th width="16%">Telefono	</th>
						<th width="14%">	
							<strong>
								Procesos
								<a href="mContacto.php?RutCli=<?php echo $RutCli; ?>&Proceso=1&accion=Agregar" title="Agregar Contacto">
									<img src="../gastos/imagenes/student_add_32.png" width="40" height="40">
								</a>
							</strong>
						</th>
					</tr>
				</thead>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">
					<tbody>
							<?php $tr = "barraVerde"; ?>
							<tr ng-repeat="x in dataContactos" id="<?php echo $tr; ?>">
								<td width="10%">{{x.nContacto}}</td>
								<td width="30%">{{x.Contacto}}</td>
								<td width="30%">{{x.Email}}</td>
								<td width="16%">{{x.telefono}}</td>
								<td colspan="2">
									<a href="mContacto.php?Proceso=2&accion=Editar&RutCli={{RutCli}}&nContacto={{x.nContacto}}"><img src="../gastos/imagenes/corel_draw_128.png"   	width="32" height="32" title="Editar Contacto"></a>
								</td>
								<td>
									<a href="mContacto.php?Proceso=2&accion=Eliminar&RutCli={{RutCli}}&nContacto=x.nContacto"><img src="../gastos/imagenes/delete_32.png" 		width="32" height="32" title="Eliminar Contacto"></a>
								</td>
							</tr>
						</tbody>
			</table>
		</div>
	</div>
	<div style="clear:both; "></div>
	<br>
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

	<script src="mClientes.js"></script>
</body>
</html>