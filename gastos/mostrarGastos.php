<?php
	session_start(); 
	include("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
	}else{
		header("Location: index.php");
	}

	$link=Conectarse();
	$sql = "SELECT * FROM ingresos";  // sentencia sql
	$result = mysql_query($sql);
	$numero = mysql_num_rows($result); // obtenemos el n�mero de filas
	mysql_close($link);

	if($numero==0){
		header("Location: ingresocaja.php?Proceso=1");
	}

	$nRegistros = 18;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 18;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		$inicio = ($_GET['inicio']-$nRegistros)+1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	mysql_query("SELECT * FROM movgastos");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
		mysql_close($link);
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

<link href="../css/barramenu.css" rel="stylesheet" type="text/css">
<link href="../css/barramenuModulos.css" rel="stylesheet" type="text/css">
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Caja Chica
				<!--
					<a href="plataformaintranet.php" title="Inicio">
						<img src="imagenes/room_32.png" width="28" height="28">
					</a>
				-->
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar Sesi�n">
						<img src="imagenes/preview_exit_32.png" width="28" height="28">
					</a>
				</div>
<!--
				<div id="ImagenBarra">
					<a href="plataformaintranet.php" title="Volver">
						<img src="imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
-->					
				<div id="ImagenBarra">
					<a href="ingresocaja.php?Proceso=1" title="Registrar Nuevo Ingreso">
						<img src="imagenes/add_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="registragastos.php" title="Registrar Gasto">
						<img src="imagenes/group_48.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="ingresoscajachica.php" title="Ingresos Caja Chica">
						<img src="imagenes/icon-gastos.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="boletas.php" title="Boletas">
						<img src="imagenes/copy_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="facturas.php" title="Facturas">
						<img src="imagenes/crear_certificado.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="proveedores.php" title="Proveedores">
						<img src="imagenes/contactus_128.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="ipdf.php" title="Informes Emitidos">
						<img src="imagenes/pdf.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="igastos.php" title="Informe de Gastos">
						<img src="imagenes/todo.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="eformularios.php" title="Emitir Formulario">
						<img src="imagenes/printer_128_hot.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="ingresoscajachica.php" title="Volver">
						<img src="imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
				<?php
					include_once('mSaldos.php');
				?>				
			</div>
<!--
			<div id="BarraFiltro">
				<img src="imagenes/data_filter_128.png" width="28" height="28">
			</div>
-->
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%"><strong>N� 			</strong></td>';
				echo '			<td  width="55%"><strong>Detalle		</strong></td>';
				echo '			<td  width="10%"><strong>Ingresos		</strong></td>';
				echo '			<td  width="10%"><strong>Egresos		</strong></td>';
				echo '			<td  width="10%"><strong>&nbsp;			</strong></td>';
				echo '			<td colspan="2"  width="10%"><strong>Estado</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;

				$tGastos 	= 0;
				$nItem = $_GET['nItem'];
				$link=Conectarse();
				$bdIt=mysql_query("SELECT * FROM itemsgastos Where nItem = '".$nItem."'");
				if ($rowIt=mysql_fetch_array($bdIt)){
					do{
						$sItem = 0;
						$bdIng=mysql_query("SELECT * FROM movgastos Where IdRecurso = '1' && nItem = '".$rowIt['nItem']."' Order By FechaGasto Desc");
						if ($row=mysql_fetch_array($bdIng)){
							do{
								$sItem   += $row['Bruto'];
								$tGastos += $row['Bruto'];
								$n++;
								$tr = 'barraVerde';
								if($row[Reembolso] == 'on'){
									$tr = 'barraAmarilla';
								}
								echo '		<tr id="'.$tr.'" style="font-size:18px;">';
								echo '			<td width="05%">'.$n.'	</td>';
								echo '			<td width="55%" align="right">'.$row['Bien_Servicio'].'		</td>';
								echo '			<td width="10%"></td>';
								echo '			<td width="10%" align="right">$ '.number_format($row['Bruto'] , 0, ',', '.').'			</td>';
								echo '			<td width="10%"></td>';
								echo '			<td>';
													if($row[Reembolso] == 'on'){
														echo '<img src="imagenes/Confirmation_32.png" title="Cancelado">';
													}
								echo '			</td>';
								echo '		</tr>';
							}while ($row=mysql_fetch_array($bdIng));
						}
					}while ($rowIt=mysql_fetch_array($bdIt));
				}
				mysql_close($link);
				echo '	</table>';

				if($tGastos > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr style="font-size:16px; ">';
					echo '			<td width="26%" align="right">Totales&nbsp; 						</td>';
					echo '			<td width="10%">$ '.number_format($tGastos , 0, ',', '.').'	</td>';
					echo '		</tr>';
					echo '	</table>';
				}

			?>

		</div>
	</div>
	<div style="clear:both; "></div>
	<br>
<!--
	<div id="CajaPie" class="degradadoNegro">
		Laboratorio Simet
	</div>
-->
</body>
</html>
