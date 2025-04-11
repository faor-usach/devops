<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";
	$tNetos	= 0;
	$TpCosto = '';
	// if(isset($_GET['Grabar'])){
	// 	echo $_GET['Proveedor'];
	// }
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

		
	$RutProv 	= "";
	$Proveedor 	= "";
	$Direccion	= "";
	$Telefono	= "";
	$Celular	= "";
	$Email		= "";
	$Contacto	= "";
	$TpCta		= "";
	$NumCta		= "";
	$Banco		= "";

	$Proceso = 1;
	
	if(isset($_GET['Proceso'])) { $Proceso  = $_GET['Proceso']; }
	if(isset($_GET['RutProv'])) { $RutProv  = $_GET['RutProv']; }

	if($Proceso == 2 or $Proceso ==3){
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM proveedores WHERE RutProv = '".$RutProv."'");
		if ($row=mysqli_fetch_array($bdProv)){
   			$Proveedor 	= $row['Proveedor'];
			$Direccion	= $row['Direccion'];
   			$Telefono  	= $row['Telefono'];
   			$Celular  	= $row['Celular'];
			$Email 		= $row['Email'];
			$Contacto 	= $row['Contacto'];
			$TpCta 		= $row['TpCta'];
			$TpCosto	= $row['TpCosto'];
			$NumCta 	= $row['NumCta'];
			$Banco 		= $row['Banco'];
		}
		$link->close();
	}
	if(isset($_GET['RutProv']))		{ $RutProv 		= $_GET['RutProv']; 	}
	if(isset($_GET['Proveedor']))	{ $Proveedor 	= $_GET['Proveedor']; 	}
	if(isset($_GET['Direccion']))	{ $Direccion 	= $_GET['Direccion']; 	}
	if(isset($_GET['Telefono']))	{ $Telefono  	= $_GET['Telefono']; 	}
	if(isset($_GET['Celular']))		{ $Celular  	= $_GET['Celular']; 	}
	if(isset($_GET['Email']))		{ $Email  		= $_GET['Email']; 		}
	if(isset($_GET['Contacto']))	{ $Contacto 	= $_GET['Contacto']; 	}
	if(isset($_GET['TpCta']))		{ $TpCta  		= $_GET['TpCta']; 		}
	if(isset($_GET['TpCosto']))		{ $TpCosto  	= $_GET['TpCosto']; 	}
	if(isset($_GET['NumCta']))		{ $NumCta  		= $_GET['NumCta'];		}
	if(isset($_GET['Banco']))		{ $Banco  		= $_GET['Banco']; 		}
	if(isset($_GET['Grabar'])){
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM proveedores WHERE RutProv = '".$RutProv."'");
		if($row=mysqli_fetch_array($bdProv)){
			$actSQL="UPDATE proveedores SET ";
			$actSQL.="Proveedor	    ='".$Proveedor.		"',";
			$actSQL.="Direccion	    ='".$Direccion.		"',";
			$actSQL.="Telefono	    ='".$Telefono.		"',";
			$actSQL.="Celular	    ='".$Celular.		"',";
			$actSQL.="Email	    	='".$Email.			"',";
			$actSQL.="Contacto	    ='".$Contacto.		"',";
			$actSQL.="TpCta	    	='".$TpCta.			"',";
			$actSQL.="TpCosto	    ='".$TCosto.		"',";
			$actSQL.="NumCta	    ='".$NumCta.		"',";
			$actSQL.="Banco			='".$Banco.			"'";
			$actSQL.="WHERE RutProv  = '".$RutProv."'";
			$bdGto=$link->query($actSQL);
		}else{

			$RutProv			= '';
			$Proveedor			= '';
			$tpCliente			= '';
			$Direccion			= '';
			$Telefono			= '';
			$Celular			= '';
			$Email				= '';
			$Contacto			= '';
			$TpCta				= '';
			$NumCta				= '';
			$Banco				= '';
			$Msg				= '';
			$UltimoPago			= 0;
			$TpCosto			= '';
			$ProfesionOficio	= '';
			$productoServicio	= '';
			$tpDocumentoEmite	= '';

			if(isset($_GET['RutProv']))		{ $RutProv 		= $_GET['RutProv']; 	}
			if(isset($_GET['Proveedor']))	{ $Proveedor 	= $_GET['Proveedor']; 	}
			if(isset($_GET['Direccion']))	{ $Direccion 	= $_GET['Direccion']; 	}
			if(isset($_GET['Telefono']))	{ $Telefono  	= $_GET['Telefono']; 	}
			if(isset($_GET['Celular']))		{ $Celular  	= $_GET['Celular']; 	}
			if(isset($_GET['Email']))		{ $Email  		= $_GET['Email']; 		}
			if(isset($_GET['Contacto']))	{ $Contacto 	= $_GET['Contacto']; 	}
			if(isset($_GET['TpCta']))		{ $TpCta  		= $_GET['TpCta']; 		}
			if(isset($_GET['TpCosto']))		{ $TpCosto  	= $_GET['TpCosto']; 	}
			if(isset($_GET['NumCta']))		{ $NumCta  		= $_GET['NumCta'];		}
			if(isset($_GET['Banco']))		{ $Banco  		= $_GET['Banco']; 		}
			
			// $insertarSQL = "INSERT INTO `proveedores` (`RutProv`, `Proveedor`, `tpCliente`, `Direccion`, `Telefono`, `Celular`, `Email`, `Contacto`, `TpCta`, `NumCta`, `Banco`, `Msg`, `UltimoPago`, `TpCosto`, `ProfesionOficio`, `productoServicio`, `tpDocumentoEmite`) VALUES 
			// ('$RutProv', 'aaa', 'a', 'aaa', '99', '99', 'aa@gmail.com', 'aa', 'cte', '99', 'Sant', 'don wea', '0', '1', 'a', 'a', 'a')";		

			// $link->query($insertarSQL);
			

				$link->query("INSERT INTO proveedores (	RutProv				,
														Proveedor			,
														tpCliente			,
														Direccion			,
														Telefono			,
														Celular				,
														Email				,
														Contacto			,
														TpCta				,
														NumCta				,
														Banco				,
														Msg					,
														UltimoPago			,
														TpCosto				,
														ProfesionOficio		,
														productoServicio	,
														tpDocumentoEmite
													) 
										values 		(	'$RutProv'			,
														'$Proveedor'		,
														'$tpCliente'		,
														'$Direccion'		,
														'$Telefono'			,
														'$Celular'			,
														'$Email'			,
														'$Contaco'			,
														'$TpCta'			,
														'$NumCta'			,
														'$Banco'			,
														'$Msg'				,
														'$UltimoPago'		,
														'$TpCosto'			,
														'$ProfesionOficio'	,
														'$productoServicio'	,
														'$tpDocumentoEmite'
														)"
							);


		}
		$link->close();

	}

	// $sw = false;
	// if(isset($_GET['Proceso'])){ 
	// 	$Proceso 	= $_GET['Proceso'];
	// 	if(isset($_GET['Proveedor'])){
	// 		$Proveedor 	= $_GET['Proveedor'];
	// 		if(isset($_GET['RutProv'])){
	// 			$RutProv 	= $_GET['RutProv'];
	// 			if(isset($_GET['Direccion']))	{ $Direccion 	= $_GET['Direccion']; 	}
	// 			if(isset($_GET['Telefono']))	{ $Telefono  	= $_GET['Telefono']; 	}
	// 			if(isset($_GET['Email']))		{ $Email  		= $_GET['Email']; 		}
	// 			if(isset($_GET['Contacto']))	{ $Contacto 	= $_GET['Contacto']; 	}
	// 			if(isset($_GET['TpCta']))		{ $TpCta  		= $_GET['TpCta']; 		}
	// 			if(isset($_GET['TpCosto']))		{ $TpCosto  	= $_GET['TpCosto']; 	}
	// 			if(isset($_GET['NumCta']))		{ $NumCta  		= $_GET['NumCta'];		}
	// 			if(isset($_GET['Banco']))		{ $Banco  		= $_GET['Banco']; 		}
	// 			if(isset($_GET['Celular']))		{ $Celular  	= $_GET['Celular']; 	}
	// 			$sw = true;
	// 		}
	// 	}
	// }
	// if($sw == true){
	// 	$sw = false;
		
	// 	if(isset($_GET['Grabar'])){ /* Agregar */
	// 		$link=Conectarse();
	// 		$bdProv=$link->query("SELECT * FROM proveedores WHERE RutProv = '".$RutProv."'");
	// 		if ($row=mysqli_fetch_array($bdProv)){
	// 			if($Proceso == 2){
	//    				$MsgUsr = 'Registro Actualizado...';
	// 				$bdProv=$link->query("SELECT * FROM proveedores WHERE RutProv = '".$RutProv."'");
	// 				if ($row=mysqli_fetch_array($bdProv)){
	// 					$actSQL="UPDATE proveedores SET ";
	// 					$actSQL.="Proveedor		='".$Proveedor."',";
	// 					$actSQL.="Direccion		='".$Direccion."',";
	// 					$actSQL.="Telefono		='".$Telefono."',";
	// 					$actSQL.="Celular		='".$Celular."',";
	// 					$actSQL.="Email		    ='".$Email."',";
	// 					$actSQL.="Contacto		='".$Contacto."',";
	// 					$actSQL.="TpCta		    ='".$TpCta."',";
	// 					$actSQL.="TpCosto	    ='".$TpCosto."',";
	// 					$actSQL.="NumCta		='".$NumCta."',";
	// 					$actSQL.="Banco			='".$Banco."'";
	// 					$actSQL.="WHERE RutProv	= '".$RutProv."'";
	// 					$bdRec=$link->query($actSQL);
	// 				}
	// 			}
	// 			if($Proceso == 3){
	// 				$bdProv=$link->query("DELETE FROM proveedores WHERE RutProv = '".$RutProv."'");
	// 				$link->close();
	// 				header("Location: proveedores.php");
	// 			}
	// 		}else{
	// 			$tpCliente 	= '';
	// 			$Msg 		= '';
	// 			$UltimoPago = 0;

	// 			$ProfesionOficio 	= '';
	// 			$productoServicio 	= '';
	// 			$tpDocumentoEmite	= '';

	// 			$link->query("insert into proveedores(	RutProv,
	// 													Proveedor,
	// 													TpCliente,
	// 													Direccion,
	// 													Telefono,
	// 													Celular,
	// 													Email,
	// 													Contacto,
	// 													TpCta,
	// 													TpCosto,
	// 													NumCta,
	// 													Banco,
	// 													Msg,
	// 													UltimoPago,
	// 													ProfesionOficio,
	// 													productoServicio,
	// 													tpDocumentoEmite
	// 													) 
	// 									values 		(	'$RutProv',
	// 													'$Proveedor',
	// 													'$TpCliente',
	// 													'$Direccion',
	// 													'$Telefono',
	// 													'$Celular',
	// 													'$Email',
	// 													'$Contacto',
	// 													'$TpCta',
	// 													'$TpCosto',
	// 													'$NumCta',
	// 													'$Banco',
	// 													'$Msg',
	// 													'$UltimoPago',
	// 													'$ProfesionOficio',
	// 													'$productoServicio',
	// 													'$tpDocumentoEmite'
	// 													)");
   	// 			$MsgUsr = 'Se ha registrado un nuevo Proveedor ...';
	// 		}
	// 		$link->close();
	// 	}
	// }
	
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


<style type="text/css">

	body {
		margin-left: 0px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
	}

</style>
<script language="javascript" src="validaciones.js"></script> 
<script src="../jquery/jquery-1.6.4.js"></script>
</head>

<body onLoad="inicioformulario()">
	<?php include('head.php'); ?>

	<div class="container-fluid">

		<?php 
			$nomModulo = 'Mantención de Proveedores';
			include('menuIconos.php'); 
			include('barraOpciones.php');
		?>
		<form name="form" action="mproveedores.php" method="get">

			<!-- Fin Caja Cuerpo -->
			<div class="row">
    			<div class="col-sm">
      				<h3>Registro de Poveedores</h3>
    			</div>
				
				<div class="btn-group">
  					<button  name="Grabar" 		id="Grabar" 	class="btn btn-primary" value="Grabar">Grabar</button>
  					<button  name="Eliminar" 	id="Eliminar" 	class="btn btn-primary" value="Eliminar">Eliminar</button>
				</div>

				
            	<!-- <input name="Grabar" type="image" id="Grabar" src="imagenes/save_32.png" width="28" height="28" title="Guardar Proveedor">
            	<input name="Eliminar" type="image" id="Eliminar" src="imagenes/inspektion.png" width="28" height="28" title="Eliminar"> -->
			</div>

			<?php
			echo '<div id="RegistroFactura">';
			echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
			echo '		<tr>';
			echo '			<td>Rut: </td>';
			echo '			<td>';
			echo '				<input name="RutProv" 	type="text" size="10" maxlength="10" value="'.$RutProv.'">';
			echo '				<input name="Proceso"  	type="hidden" value="'.$Proceso.'">';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td>Proveedor: </td>';
			echo '			<td>';
			echo '				<input name="Proveedor" 	type="text" size="50" maxlength="50" value="'.$Proveedor.'">';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td>Dirección: </td>';
			echo '			<td>';
			echo '				<input name="Direccion" 	type="text" size="50" maxlength="50" value="'.$Direccion.'">';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td>Email: </td>';
			echo '			<td>';
			echo '				<input name="Email" 	type="email" size="50" maxlength="50" value="'.$Email.'">';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td>Telefono: </td>';
			echo '			<td>';
			echo '				<input name="Telefono" 	type="text" size="30" maxlength="30" value="'.$Telefono.'">';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td>Celular: </td>';
			echo '			<td>';
			echo '				<input name="Celular" 	type="text" size="13" maxlength="13" value="'.$Celular.'">';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td>Contacto: </td>';
			echo '			<td>';
			echo '				<input name="Contacto" 	type="text" size="50" maxlength="50" value="'.$Contacto.'">';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td>Tipo Cuenta: </td>';
			echo '			<td>';
			echo '				<input name="TpCta" 	type="text" size="40" maxlength="40" value="'.$TpCta.'">';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td>Número de Cuenta: </td>';
			echo '			<td>';
			echo '				<input name="NumCta" 	type="text" size="40" maxlength="40" value="'.$NumCta.'">';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td>Banco: </td>';
			echo '			<td>';
			echo '				<input name="Banco" 	type="text" size="50" maxlength="50" value="'.$Banco.'">';
			echo '			</td>';
			echo '		</tr>';?>
				
						<tr>
							<td>Emite Facturas Exenta: </td>
							<td>
									<select name="TpCosto">
										<?php 
											if($TpCosto == 'S'){?>
												<option selected value="S"> Si </option>
												<option value="N">			No </option>
										<?php }else{ ?>
												<option value="S"> 			Si </option>
												<option selected Value "N"> No </option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<?php
				echo '	</table>';
				echo '</div>';


				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaOpcDoc">';
				echo '		<tr>';
				echo '			<td>Mensaje al Usuario... ';
				if($MsgUsr){
					echo '<div id="Saldos">'.$MsgUsr.'</div>';
				}else{
					echo '<div id="Saldos" style="display:none; ">'.$MsgUsr.'</div>';
				}
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';


				if($tNetos > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td width=" 5%">&nbsp;</td>';
					echo '			<td width=" 8%">&nbsp;</td>';
					echo '			<td width="15%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width=" 7%">&nbsp;</td>';
					echo '			<td width="15%">Total Página</td>';
					echo '			<td width="10%">'.number_format($tNeto , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tIva  , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tBruto, 0, ',', '.').'			</td>';
    				echo '			<td></td>';
    				echo '			<td></td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>&nbsp;</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td width=" 5%">&nbsp;</td>';
					echo '			<td width=" 8%">&nbsp;</td>';
					echo '			<td width="15%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width=" 7%">&nbsp;</td>';
					echo '			<td width="15%">Total General</td>';
					echo '			<td width="10%">'.number_format($tNetos , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tIvas  , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tBrutos, 0, ',', '.').'			</td>';
    				echo '			<td></td>';
    				echo '			<td></td>';
					echo '		</tr>';
					echo '	</table>';
				}
				echo '</div>';
			?>
			</div>
		</div>
		</form>
	</div>
	<script src="../jsboot/bootstrap.min.js"></script>	
</body>
</html>