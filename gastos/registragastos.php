<?php
	// echo 'Entra..'.$_GET['Bruto'];
	session_start();
	$fechaBanca     		= '0000-00-00';

	$_SESSION['Grabado'] 	= "NO";
	$MsgUsr 				= "";	
	$TpDoc 					= "B";
	$Proceso 				= "1";
	$nGasto 				= 0;
	$tNetos					= 0;
	$IdAutoriza 			= '';
	$Concepto				= '';
	$NetoF					= 0;
	$IvaF					= 0;
	$nInforme				= '';
	$exento 				= 'off';
	$efectivo 				= 'off';
	$CalCosto				= 0;
	$CalCalidad				= 0;
	$CalPreVenta			= 0;
	$CalPostVenta			= 0;
	$Bruto 					= 0;
	
	if(isset($_GET['exento'])){ $exento	= $_GET['exento']; }
	if($exento != 'on'){
		$exento 	= 'off';
	}
	if(isset($_GET['efectivo'])){ $efectivo	= $_GET['efectivo']; }
	if($efectivo != 'on'){
		$efectivo 	= 'off';
	}
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

	$Proveedor 		= "";
	$nDoc			= "";
	$Bien_Servicio	= "";
	$exento			= 'off';
	$efectivo		= 'off';
	$Neto			= "";
	$Iva			= "";
	$Bruto			= "";
	$FechaGasto    	= date('Y-m-d');
	$Hora			= date("H:i:s");
	$Items 			= "";
	$TpGasto 		= "";
	$Recurso 		= "";
	$IdProyecto 	= "";
	$IdAutoriza		= "";
	$Guardado		= '';
	
	if(isset($_GET['Proceso'])) 	{ $Proceso   = $_GET['Proceso']; 	}
	if(isset($_GET['nGasto']))  	{ $nGasto 	 = $_GET['nGasto']; 	}
	if(isset($_GET['nInforme']))   	{ $nInforme	 = $_GET['nInforme']; 	}
	if(isset($_GET['TpDoc']))   	{ $TpDoc	 = $_GET['TpDoc']; 		}

	if(isset($_GET['Proceso'])) 	{ $Proceso   = $_GET['Proceso']; 	}
	if(isset($_GET['nGasto']))  	{ $nGasto 	 = $_GET['nGasto']; 	}
	if(isset($_GET['nInforme']))  	{ $nInforme	 = $_GET['nInforme']; 	}
	if(isset($_GET['Concepto']))  	{ $Concepto	 = $_GET['Concepto']; 	}

	
	$sw = false;
	if(isset($_GET['Borrar'])){
		if(isset($_GET['TpDoc'])){ 
			if($_GET['TpDoc'] == 'P'){ 
				$link=Conectarse();
				$bdGas=$link->query("DELETE FROM facturas WHERE nMov = '".$nGasto."'");
				$link->close();
				header("Location: igastos.php");
			}else{
				$link=Conectarse();
				$nInforme = 0;
				$bdGas=$link->query("SELECT * FROM movgastos WHERE nGasto = '".$nGasto."'");
				if($row=mysqli_fetch_array($bdGas)){
					$nInforme = $row['nInforme'];
				}

				$bdGas=$link->query("DELETE FROM movgastos WHERE nGasto = '".$nGasto."'");

				$Neto 	= 0;
				$Iva	= 0;
				$Bruto	= 0;
				$bdGas=$link->query("SELECT * FROM movgastos WHERE nInforme = '".$nInforme."'");
				while($row=mysqli_fetch_array($bdGas)){
					$Neto += $row['Neto'];
					$Iva += $row['Iva'];
					$Bruto += $row['Bruto'];
				}

				$bdFor=$link->query("SELECT * FROM formularios WHERE nInforme = '".$nInforme."'");
				if($row=mysqli_fetch_array($bdFor)){
					
					$actSQL="UPDATE formularios SET ";
					$actSQL.="Neto		    	='".$Neto."',";
					$actSQL.="Iva		    	='".$Iva."',";
					$actSQL.="Bruto		    	='".$Bruto."'";
					$actSQL.="WHERE nInforme 	= '".$nInforme."'";
					$bdForm=$link->query($actSQL);
				}

				$link->close();
				//header("Location: igastos.php");
				header("Location: plataformaintranet.php");
			}
		};
	}
	// echo 'Grabar... '.$_GET['Grabar'];
	if(isset($_GET['Grabar'])){
		$CalCosto		= 0;
		$CalCalidad		= 0;
		$CalPreVenta	= 0;
		$CalPostVenta	= 0;
		if(isset($_GET['CalCosto']))		{ $CalCosto 	  	= $_GET['CalCosto']; 	 	}
		if(isset($_GET['CalCalidad']))		{ $CalCalidad 	  	= $_GET['CalCalidad']; 	}
		if(isset($_GET['CalPreVenta']))		{ $CalPreVenta 	  	= $_GET['CalPreVenta']; 	}
		if(isset($_GET['CalPostVenta']))	{ $CalPostVenta 	= $_GET['CalPostVenta']; 	}
		$TpDoc 		= $_GET['TpDoc'];
		if(isset($_GET['Proveedor']))		{ $Proveedor 	  	= $_GET['Proveedor']; 	 	}
		if(isset($_GET['nDoc']))			{ $nDoc 		  	= $_GET['nDoc']; 	  	 	}
		if(isset($_GET['nFactura']))		{ $nFactura 		= $_GET['nFactura']; 	  	}
		if(isset($_GET['FechaFactura']))	{ $FechaFactura	  	= $_GET['FechaFactura'];  	}
		if(isset($_GET['FechaGasto']))		{ $FechaGasto 	  	= $_GET['FechaGasto']; $Hora = $_GET['Hora']; }
		if(isset($_GET['Bien_Servicio']))	{ $Bien_Servicio 	= $_GET['Bien_Servicio'];	}
		if(isset($_GET['Descripcion']))	{ $Descripcion 		= $_GET['Descripcion'];	}
		if(isset($_GET['IdAutoriza']))		{ $IdAutoriza 		= $_GET['IdAutoriza'];		}
		if(isset($_GET['IdProyecto']))		{ $IdProyecto 		= $_GET['IdProyecto'];		}
		if(isset($_GET['Bruto']))			{ $Bruto 		  	= $_GET['Bruto']; 		 	}
		if(isset($_GET['TpCosto']))		{ $TpCosto 			= $_GET['TpCosto'];		}

		$link=Conectarse();
		$bdPro = $link->query("SELECT * FROM proveedores Where Proveedor = '".$Proveedor."'");
		if($rowPro=mysqli_fetch_array($bdPro)){
			$RutProv = $rowPro['RutProv'];
		}
		if($_GET['TpDoc']=="P"){
			$fdFf = explode('-', $FechaFactura);
			$PeriodoPago 	= $fdFf[1].'.'.$fdFf[0];
			$IdRecurso		= '5';
			$nMov 			= $nGasto;
			
			if($nGasto == 0){
				$bdFa = $link->query('SELECT * FROM facturas Order By nMov Desc');
				if($rowFa=mysqli_fetch_array($bdFa)){
					$nMov = $rowFa['nMov'] + 1;
				}
			}
			$nGasto = $nMov;
			$bdFac=$link->query("SELECT * FROM facturas WHERE nMov = '".$nMov."'");
			if($rowFac=mysqli_fetch_array($bdFac)){
				$nInforme = $rowFac['nInforme'];
				$actSQL="UPDATE facturas SET ";
				$actSQL.="nMov	    	='".$nMov.			"',";
				$actSQL.="PeriodoPago   ='".$PeriodoPago.	"',";
				$actSQL.="RutProv	    ='".$RutProv.		"',";
				$actSQL.="nFactura	    ='".$nFactura.		"',";
				$actSQL.="FechaFactura 	='".$FechaFactura.	"',";
				$actSQL.="IdProyecto	='".$IdProyecto.	"',";
				$actSQL.="IdRecurso		='".$IdRecurso.		"',";
				$actSQL.="IdAutoriza	='".$IdAutoriza.	"',";
				$actSQL.="Descripcion	='".$Descripcion.	"',";
				$actSQL.="Bruto		    ='".$Bruto.			"',";
				$actSQL.="TpCosto	    ='".$TpCosto.		"',";
				$actSQL.="CalCosto		='".$CalCosto.		"',";
				$actSQL.="CalCalidad	='".$CalCalidad.	"',";
				$actSQL.="CalPreVenta	='".$CalPreVenta.	"',";
				$actSQL.="CalPostVenta	='".$CalPostVenta.	"'";
				$actSQL.="WHERE nMov  	= '".$nMov."'"; 
				$bdGto=$link->query($actSQL);
				$Guardado = 'Si';
			}else{
				$nLinea 		= '';
				$nItem 			= '';
				$IdGasto		= '';
				$PerIniServ		= date("Y-m-d", strtotime($fechaBlanca));;
				$PerTerServ		= date("Y-m-d", strtotime($fechaBlanca));;
				$LugarTrabajo	= '';
				$FuncionCargo 	= '';
				$Neto 			= 0;
				$Iva			= 0;
				$FechaPago 		= date("Y-m-d", strtotime($fechaBlanca));;
				$Estado 		= '';
				$nInforme 		= '';

				$link->query("insert into facturas	(	nMov			,
														PeriodoPago		,
														RutProv			,
														nFactura		,
														FechaFactura	,
														nLinea,
														IdProyecto		,														
														nItem,
														IdGasto,
														IdRecurso		,
														IdAutoriza		,
														PerIniServ,
														PerTerServ,
														LugarTrabajo,
														FuncionCargo,
														Descripcion		,
														Neto,
														Iva,
														Bruto			,
														TpCosto			,
														FechaPago,
														Estado,
														nInforme,
														CalCosto		,
														CalCalidad		,
														CalPreVenta		,
														CalPostVenta
													) 
										values 		(	'$nMov'			,
														'$PeriodoPago'	,
														'$RutProv'		,
														'$nFactura'		,
														'$FechaFactura'	,
														'$nLinea'	,
														'$IdProyecto'	,
														'$nItem'	,
														'$IdGasto'	,
														'$IdRecurso'	,
														'$IdAutoriza'	,
														'$PerIniServ'	,
														'$PerTerServ'	,
														'$LugarTrabajo'	,
														'$FuncionCargo'	,
														'$Descripcion'	,
														'$Neto'		,
														'$Iva'		,
														'$Bruto'		,
														'$TpCosto'		,
														'$FechaPago'		,
														'$Estado'		,
														'$nInforme'		,
														'$CalCosto'		,
														'$CalCalidad'	,
														'$CalPreVenta'	,
														'$CalPostVenta'
														)");
				$Guardado = 'Si';
			}
		}else{
			if($_GET['TpDoc']=="F"){
				if(isset($_GET['exento']))			{ $exento 		  = $_GET['exento'];			}
				if(isset($_GET['Neto'])){
					$Neto 	= $_GET['Neto'];
					$Iva   	= 0;
					$Bruto 	= $Neto;
					if($exento == 'off'){
						$Iva	= intval(round(($Neto * 0.19)));
						$Bruto	= $Neto + $Iva;
						$Bruto	= $Bruto;
					}
				}
			}
			if(isset($_GET['efectivo']))		{ $efectivo 	  = $_GET['efectivo']; 	 	}
			if(isset($_GET['Items']))			{ $Items 		  = $_GET['Items']; 		 }
			if(isset($_GET['TpGasto']))			{ $TpGasto 		  = $_GET['TpGasto']; 		 }
			if(isset($_GET['Recurso']))			{ $Recurso 		  = $_GET['Recurso']; 		 }
			if(isset($_GET['IdProyecto']))		{ $IdProyecto 	  = $_GET['IdProyecto']; 	 }
			if(isset($_GET['IdAutoriza']))		{ $IdAutoriza 	  = $_GET['IdAutoriza']; 	 }

			$bdIt = $link->query("SELECT * FROM itemsgastos Where Items = '".$_GET['Items']."'");
			if ($row=mysqli_fetch_array($bdIt)){
				$nItem = $row['nItem'];
			}
			$bdTg = $link->query("SELECT * FROM tipogasto Where TpGasto = '".$_GET['TpGasto']."'");
			if ($row=mysqli_fetch_array($bdTg)){
				$IdGasto = $row['IdGasto'];
			}
			$bdRec = $link->query("SELECT * FROM recursos Where Recurso = '".$_GET['Recurso']."'");
			if ($row=mysqli_fetch_array($bdRec)){
				$IdRecurso = $row['IdRecurso'];
			}

			$bdGto=$link->query("SELECT * FROM movgastos WHERE nGasto = '".$nGasto."'");
			if ($rowGto=mysqli_fetch_array($bdGto)){
				$nInforme = $rowGto ['nInforme'];
				$actSQL="UPDATE movgastos SET ";
				$actSQL.="Proveedor	    ='".$Proveedor.		"',";
				$actSQL.="nDoc	    	='".$nDoc.			"',";
				$actSQL.="FechaGasto   	='".$FechaGasto.	"',";
				$actSQL.="Hora   		='".$Hora.			"',";
				$actSQL.="Bien_Servicio	='".$Bien_Servicio.	"',";
				$actSQL.="exento	    ='".$exento.		"',";
				$actSQL.="efectivo	    ='".$efectivo.		"',";
				$actSQL.="Neto		    ='".$Neto.			"',";
				$actSQL.="Iva		    ='".$Iva.			"',";
				$actSQL.="Bruto		    ='".$Bruto.			"',";
				$actSQL.="nItem		    ='".$nItem.			"',";
				$actSQL.="IdGasto	    ='".$IdGasto.		"',";
				$actSQL.="IdRecurso		='".$IdRecurso.		"',";
				$actSQL.="IdProyecto	='".$IdProyecto.	"',";
				$actSQL.="IdAutoriza	='".$IdAutoriza.	"',";
				$actSQL.="CalCosto		='".$CalCosto.		"',";
				$actSQL.="CalCalidad	='".$CalCalidad.	"',";
				$actSQL.="CalPreVenta	='".$CalPreVenta.	"',";
				$actSQL.="CalPostVenta	='".$CalPostVenta.	"'";
				$actSQL.="WHERE nGasto  = '".$nGasto."'";
				$bdGto=$link->query($actSQL);
				$Guardado = 'Si';
			}else{
				$bdGt = $link->query('SELECT * FROM movgastos Order By nGasto Desc');
				if($rowGt=mysqli_fetch_array($bdGt)){
					$nGasto = $rowGt['nGasto'] + 1;
				}
				$Modulo 		= 'G';
				$Estado 		= '';
				$FechaInforme 	= date("Y-m-d", strtotime($fechaBlanca));
				$nInforme		= 0;
				$Fotocopia 		= '';
				$fechaFotocopia = date("Y-m-d", strtotime($fechaBlanca));
				$Reembolso 		= '';
				$fechaReembolso = date("Y-m-d", strtotime($fechaBlanca));
				if($TpDoc == 'B'){
					$Neto 			= 0;
					$Iva  			= 0;
					$CalCosto 		= 0;
					$CalCalidad 	= 0;
					$CalPreVenta 	= 0;
					$CalPosVenta 	= 0;
				}

				$link->query("insert into movgastos	 (	nGasto,
														Modulo,
														FechaGasto,
														Hora,
														TpDoc,
														Proveedor,
														nDoc,
														Bien_Servicio,
														exento,
														efectivo,
														Neto,
														Iva,
														Bruto,
														nItem,
														IdGasto,
														IdRecurso,
														IdProyecto,
														IdAutoriza,
														Estado,
														FechaInforme,
														nInforme,
														Fotocopia,
														fechaFotocopia,
														Reembolso,
														fechaReembolso,
														CalCosto,
														CalCalidad,
														CalPreVenta,
														CalPostVenta) 
										values 		(	'$nGasto',
														'$Modulo',
														'$FechaGasto',
														'$Hora',
														'$TpDoc',
														'$Proveedor',
														'$nDoc',
														'$Bien_Servicio',
														'$exento',
														'$efectivo',
														'$Neto',
														'$Iva',
														'$Bruto',
														'$nItem',
														'$IdGasto',
														'$IdRecurso',
														'$IdProyecto',
														'$IdAutoriza',
														'$Estado',
														'$FechaInforme',
														'$nInforme',
														'$Fotocopia',
														'$fechaFotocopia',
														'$Reembolso',
														'$fechaReembolso',
														'$CalCosto',
														'$CalCalidad',
														'$CalPreVenta',
														'$CalPostVenta'
														)");
				$Guardado = 'Si';
			}
			if($nInforme>0){
				$result  = $link->query("SELECT SUM(Neto) as tNeto FROM movgastos WHERE nInforme = '".$nInforme."'");
				$row 	 = mysqli_fetch_array($result);
				$tNeto = $row['tNeto'];
				$result  = $link->query("SELECT SUM(Iva) as tIva FROM movgastos WHERE nInforme = '".$nInforme."'");
				$row 	 = mysqli_fetch_array($result);
				$tIva = $row['tIva'];
				$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM movgastos WHERE nInforme = '".$nInforme."'");
				$row 	 = mysqli_fetch_array($result);
				$tBruto = $row['tBruto'];

				$bdForm=$link->query("SELECT * FROM formularios WHERE nInforme = '".$nInforme."'");
				if ($rowForm=mysqli_fetch_array($bdForm)){
					$Concepto = $rowForm['Concepto'];
					$actSQL="UPDATE formularios SET ";
					$actSQL.="Concepto	    	='".$Concepto."',";
					$actSQL.="Neto		    	='".$tNeto."',";
					$actSQL.="Iva		    	='".$tIva."',";
					$actSQL.="Bruto		    	='".$tBruto."'";
					$actSQL.="WHERE nInforme 	= '".$nInforme."'";
					$bdForm=$link->query($actSQL);
				}
			}
		}
		$link->close();
		if($sw==false){
   			$MsgUsr = 'Error de Ingreso: Debe ingresar todos los campos ...';
		}
	}
	

	if($nGasto){
		if($TpDoc == 'P'){
			$link=Conectarse();
			$bdGas=$link->query("SELECT * FROM facturas WHERE nMov = '".$nGasto."'");
			if ($row=mysqli_fetch_array($bdGas)){
				$TpDoc			= 'P';
			}
			$link->close();
		}else{
			$link=Conectarse();
			$bdGas=$link->query("SELECT * FROM movgastos WHERE nGasto = '".$nGasto."'");
			if ($row=mysqli_fetch_array($bdGas)){
				$TpDoc			= $row['TpDoc'];
			}
			$link->close();
		}
		if(isset($_GET['Proceso']) == 3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}

if($Guardado == 'Si'){
	//header("Location: igastos.php");
	header("Location: registragastos.php?Proceso=2&nGasto=".$nGasto);
}	

	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Módulo de Gastos</title>

	<link href="estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenu.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenuModulos.css" rel="stylesheet" type="text/css">
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script language="javascript" src="validaciones.js"></script> 
	<script src="../jquery/jquery-1.6.4.js"></script>

<script>
		function regDoc(TpDoc, nGasto, Proceso){
			var parametros = {
				"TpDoc" 	: TpDoc,
				"nGasto" 	: nGasto,
				"Proceso" 	: Proceso
			};
			//alert(nGasto);
			$.ajax({
				data: parametros,
				url: 'registraMovimiento.php', 
				type: 'get',
				success: function (response) {
					$("#resultado").html(response);
				}
			});
		}

	$(document).ready(function(){
	$("#dFactura").click(function(){
			$("#RegistroFactura").css("display", "block");
			$("#RegistroBoleta").css("display", "none");
	});
	$("#dBoleta").click(function(){
			$("#RegistroFactura").css("display", "none");
			$("#RegistroBoleta").css("display", "block");
	});
		
		$("#NetoF").bind('keypress', function(event)
		{
		// alert(event.keyCode);
		if (event.keyCode == '9')
			{
			neto  = document.form.NetoF.value;
			iva	  = parseInt(neto * 0.19);
			bruto = parseInt(neto * 1.19);

			$("#IvaF").val(iva);
			$("#BrutoF").val(bruto);
			
			//document.form.IvaF.value 	= iva;
			//document.form.BrutoF.value 	= bruto;
			// document.form.Iva.focus();
			return 0;
			}
		});
	});
	</script>
</head>

<body ng-app="myApp" ng-controller="ctrlGastos">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<!-- <button ng-click="guardarDataGastos()">
			<img src="imagenes/save_32.png" width="28" height="28"  title="Guardar Gastos Angular">
		</button> -->

		<form name="form" action="registragastos.php" method="get">
		<div id="CajaCpo">
			<?php 
				$nomModulo = 'Registra Gastos';
				include('menuIconos.php');
				include('barraOpciones.php'); 
			?>
			<!-- Fin Caja Cuerpo -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td>
							<span style="font-size:20px;">Registro de Gastos </span>
								<?php 
									if(isset($_GET['Grabar'])){
										echo 'Grabado...';
									} 
								?>

								<div id="ImagenBarra">
									<?php if($Proceso == 1 || $Proceso == 2){ ?>
										<button name="Grabar" id="Grabar">
											<img src="imagenes/save_32.png" width="28" height="28" title="Guardar Gastos">
										</button>
									<?php }else{ ?>
										<button name="Borrar" id="Borrar">
											<img src="imagenes/inspektion.png" width="28" height="28" title="Borrar">
										</button>
									<?php } ?>
								</div>
						</td>
					</tr>
				</table>
				<div id="CajaListadoGastos">
					<?php if($TpDoc==""){?>
							<input name="TpDoc" id="dBoleta"  type="radio" value="B" onclick='regDoc("B",0, 1)'>Boleta
							<input name="TpDoc" id="dFactura" type="radio" value="F" onclick='regDoc("F",0, 1)'>Factura
							<!-- 
								<input name="TpDoc" id="pFactura" type="radio" value="P" onclick='regDoc("P",0,1)'>Factura Pagos
							-->
					<?php } ?>
					<?php if($TpDoc=="B"){?>
							<input name="TpDoc" id="dBoleta"  type="radio" value="B" checked onclick='regDoc("B",0, 1)'>Boleta
							<input name="TpDoc" id="dFactura" type="radio" value="F" onclick='regDoc("F",0, 1)'>Factura
							<!--
								<input name="TpDoc" id="pFactura" type="radio" value="P" onclick='regDoc("P",0, 1)'>Factura Pagos
							-->
					<?php } ?>
					<?php if($TpDoc=="F"){?>
							<input name="TpDoc" id="dBoleta"  type="radio" value="B" onclick='regDoc("B",0, , 1)'>Boleta
							<input name="TpDoc" id="dFactura" type="radio" value="F" checked onclick='regDoc("F",0, , 1)'checked>Factura
							<!-- 
								<input name="TpDoc" id="pFactura" type="radio" value="P" onclick='regDoc("P",0, , 1)'>Factura Pagos
							-->
					<?php } ?>
					<?php if($TpDoc=="P"){?>					
							<input name="TpDoc" id="dBoleta"  type="radio" value="B" onclick='regDoc("B",0, , 1)'>Boleta
							<input name="TpDoc" id="dFactura" type="radio" value="F" onclick='regDoc("F",0, , 1)'checked>Factura
							<!-- 
								<input name="TpDoc" id="pFactura" type="radio" value="P" checked onclick='regDoc("P",0, , 1)'>Factura Pagos
							-->
					<?php } ?>
				</div>
				<?php
					if($TpDoc){?>
						<script>
							regDoc("<?php echo $TpDoc; ?>","<?php echo $nGasto; ?>", 1);
						</script>
						<?php
					}
				?>
				<div id="resultado"></div>
		</form>
	</div>
	<div style="clear:both; "></div>
	<br>
	{{5+5}}
	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="../angular/angular.js"></script>
	<script src="moduloGastos.js"></script>

</body>
</html>