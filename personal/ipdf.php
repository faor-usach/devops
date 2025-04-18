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
		header("Location: index.php");
	}
	//header("Location: formularios/contrato.php?Run=10074437-6&nBoleta=22");
	
	$filtroSQL 	= '';
	$tTot		= 0;
	
	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$fd 	= explode('-', date('Y-m-d'));
	$Mm = "Junio";
	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$fd[0];
	}

	$pPago = 'Periodo '.$Mm.'.'.$fd[0];

	$MesHon 	= $Mm;

	$Proyecto 	= "";
	
	$link=Conectarse();
	$bdPr=$link->query("SELECT * FROM proyectos");
	if ($row=mysqli_fetch_array($bdPr)){
		$Proyecto 	= $row['IdProyecto'];
	}
	$link->close();
	$Estado = "";
	if(isset($_POST['Proyecto']))	{ $Proyecto = $_POST['Proyecto']; 	}
	if(isset($_GET['MesHon']))		{ $MesHon 	= $_GET['MesHon']; 		}
	if(isset($_GET['Proyecto']))	{ $Proyecto = $_GET['Proyecto']; 	}
	if(isset($_GET['Estado']))		{ $Estado 	= $_GET['Estado']; 		}
	
	$nRegistros = 100;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 100;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		if($_GET['inicio']==0){
			$inicio = 0;
			$limite = 100;
		}else{
			$inicio = ($_GET['inicio']-$nRegistros)+1;
			$limite = $inicio+$nRegistros;
		}
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	$link->query("SELECT * FROM honorarios");
		$inicio	=	$bdGto>num_rows - $nRegistros;
		$limite	=	$bdGto>num_rows;
		$link->close();
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo de Sueldos</title>

<link href="styles.css" rel="stylesheet" type="text/css">
<script src="../jquery/jquery-1.6.4.js"></script>

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
<style type="text/css">
<!--
body {
	
	margin-top: 0px;
	margin-bottom: 0px;
	background: url(../gastos/imagenes/Usach.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	max-width:100%;
	width:100%;
	margin-left:auto;
	margin-right:auto;	

	
}
-->
</style>
</head>

<body>
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php //include_once('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/pdf.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					Informes PDF
				</strong>
				<?php include_once('barramenu.php'); ?>
			</div>
			
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="personal.php" title="Personal">
						<img src="../gastos/imagenes/subst_student.png"><br>
					</a>
					Personal
				</div>
				<div id="ImagenBarraLeft" title="Prestadores">
					<a href="phonorarios.php" title="Prestadores">
						<img src="../gastos/imagenes/send_48.png"><br>
					</a>
					Prestadores
				</div>
				<div id="ImagenBarraLeft" title="Proveedores">
					<a href="proveedores.php" title="Proveedores">
						<img src="../gastos/imagenes/contactus_128.png"><br>
					</a>
					Proveedores
				</div>
				<div id="ImagenBarraLeft" title="Cálculo de Sueldos">
					<a href="CalculoSueldos.php" title="Cálculo de Sueldos">
						<img src="../gastos/imagenes/purchase_128.png"><br>
					</a>
					Sueldos
				</div>
				<div id="ImagenBarraLeft" title="Cálculo de Honorarios">
					<a href="CalculoHonorarios.php" title="Servicios de Honorarios">
						<img src="../gastos/imagenes/blank_128.png"><br>
					</a>
					Honorarios
				</div>
				<!--
				<div id="ImagenBarraLeft" title="Pago Factura Proveedores">
					<a href="CalculoFacturas.php" title="Pago con Factura">
						<img src="../gastos/imagenes/crear_certificado.png"><br>
					</a>
					Facturas
				</div>
				-->
				<div id="ImagenBarraLeft" title="Informes Emitidos">
					<a href="ipdf.php" title="Informes Emitidos">
						<img src="../gastos/imagenes/pdf.png"><br>
					</a>
					Emitidos
				</div>
			</div>
			
			
			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">

					<!-- Fitra por Proyecto -->
	  				<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							$link=Conectarse();
							$bdPr=$link->query("SELECT * FROM proyectos");
							if ($row=mysqli_fetch_array($bdPr)){
								DO{
			    					if($Proyecto == $row['IdProyecto']){
										echo "	<option selected value='ipdf.php?Proyecto=".$row['IdProyecto']."&MesHon=".$MesHon."'&Estado='.$Estado.'>".$row['IdProyecto']."</option>";
									}else{
										echo "	<option value='ipdf.php?Proyecto=".$row['IdProyecto']."&MesHon=".$MesHon."'&Estado='.$Estado.'>".$row['IdProyecto']."</option>";
									}
								}WHILE ($row=mysqli_fetch_array($bdPr));
							}
							$link->close();
						?>
					</select>

					<!-- Fitra por Fecha -->
	  					<select name='MesHon' id='MesHon' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
							<?php
								for($i=1; $i <=12 ; $i++){
									if($Mes[$i]==$MesHon){
										echo '		<option selected 									value="ipdf.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'">'.$Mes[$i].'</option>';
									}else{
										if($i > strval($fd[1])){
											echo '	<option style="opacity:.5; color:#ccc;" disabled 	value="ipdf.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'">'.$Mes[$i].'</option>';
										}else{
											echo '	<option 											value="ipdf.php?Proyecto='.$Proyecto.'&MesHon='.$Mes[$i].'&Estado='.$Estado.'">'.$Mes[$i].'</option>';
										}
									}
								}
							?>
						</select>
					<!-- Fin Filtro -->

					<div id="ImagenBarra" style="float:none; display:inline;">
						<?php echo '<a href="formularios/iContratos.php?Proyecto='.$Proyecto.'&Periodo='.$PeriodoPago.'" title="Imprimir Formulario N°5, 1C y Contratos Asociados ">'; ?>
							<img src="../gastos/imagenes/printer_128_hot.png" width="20" height="20"></a>
					</div>
					<div id="ImagenBarra" style="float:none; display:inline;">
						<?php echo '<a href="formularios/iSolicitudes.php?Proyecto='.$Proyecto.'&Periodo='.$PeriodoPago.'" title="Imprimir Formulario 5 Solicitud de Pago de Honorarios">'; ?>
							<img src="../gastos/imagenes/subjects_bystudent.png" width="20" height="20"></a>
					</div>
					<div id="ImagenBarra" style="float:none; display:inline;">
						<?php echo '<a href="formularios/iPrestadores.php?Proyecto='.$Proyecto.'&Periodo='.$PeriodoPago.'" title="Imprimir Formulario 1C Nomina de Prestadores del Proyecto">'; ?>
							<img src="../gastos/imagenes/subjects_bystudent.png" width="20" height="20"></a>
					</div>

			</div>

			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width=" 5%"><strong>N°				</strong></td>';
				echo '			<td  width=" 8%"><strong>Fecha 			</strong></td>';
				echo '			<td  width="15%"><strong>Formularios	</strong></td>';
				echo '			<td  width="10%"><strong>Proyecto		</strong></td>';
				echo '			<td  width=" 6%"><strong>Impto.			</strong></td>';
				echo '			<td  width=" 6%"><strong>N° Doc.		</strong></td>';
				echo '			<td  width="15%"><strong>Concepto		</strong></td>';
				echo '			<td  width="08%"><strong>Total			</strong></td>';
				echo '			<td  width="08%"><strong>Retencion		</strong></td>';
				echo '			<td  width="09%"><strong>Liquido		</strong></td>';
				echo '			<td  width="10%"></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';

				$n = 0;
				$tNeto 	= 0;
				$tIva	= 0;
				$tBruto	= 0;

				$link=Conectarse();
				$result  	= $link->query("SELECT SUM(Total) as tTotal, SUM(Retencion) as tRetencion, SUM(Liquido) as tLiquido FROM Honorarios WHERE Estado = 'P'");  
				//$row   	= mysqli_fetch_array($result, MYSQL_ASSOC);
				$row 	 	= mysqli_fetch_array($result);
				$tTotal  	= $row["tTotal"];
				$tRetencion = $row["tRetencion"];
				$tLiquido 	= $row["tLiquido"];

				$filtroSQL .= "Where Formulario = 'F5' "; 
				if($Proyecto != "Proyectos"){
					$filtroSQL .= " && IdProyecto='".$Proyecto."'"; 
				}

				$link=Conectarse();
				//$bdGto=$link->query("SELECT * FROM formularios ".$filtroSQL.");
				$bdGto=$link->query("SELECT * FROM formularios ".$filtroSQL." Order By Fecha Desc Limit $inicio, $nRegistros");
				//$bdGto=$link->query("SELECT * FROM formularios");
				if ($row=mysqli_fetch_array($bdGto)){
					DO{
						$fd 	= explode('-', $row['Fecha']);
						$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
							$n++;
							$tNeto	+= $row['Neto'];
							$tIva	+= $row['Iva'];
							$tBruto	+= $row['Bruto'];
							echo '<tr>';
							echo '			<td width=" 5%">'.$row['nInforme'].'		</td>';
							echo '			<td width=" 8%">'.$Fecha.'					</td>';
							echo '			<td width="15%">'.$row['Formulario'].'		</td>';
							echo '			<td width="10%">'.$row['IdProyecto'].'		</td>';
							echo '			<td width=" 6%">'.$row['Impuesto'].'		</td>';
							echo '			<td width=" 6%">'.$row['nDocumentos'].'		</td>';
							echo '			<td width="15%">'.$row['Concepto'].'		</td>';
							echo '			<td width="08%">'.number_format($row['Total'] , 0, ',', '.').'			</td>';
							echo '			<td width="08%">'.number_format($row['Retencion']	 , 0, ',', '.').'				</td>';
							echo '			<td width=" 9%">'.number_format($row['Liquido'], 0, ',', '.').'			</td>';
	    					echo '			<td width="10%"><a href="formularios/iContratos.php?IdProyecto='.$row['IdProyecto'].'&Fecha='.$row['Fecha'].'&nInforme='.$row['nInforme'].'"><img src="../gastos/imagenes/pdf.png" width="28" height="28" title="Imprimir Informe PDF"></a></td>';
							echo '		</tr>';
					}WHILE ($row=mysqli_fetch_array($bdGto));
				}
				$link->close();
				echo '	</table>';
				if($tTot){
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
				echo '		<tr>';
				echo '			<td width="60%" align="right">Total Página</td>';
				echo '			<td width="09%" align="right">'.number_format($tTot , 0, ',', '.').'			</td>';
				echo '			<td width="08%" align="right">'.number_format($tRet , 0, ',', '.').'			</td>';
				echo '			<td width="08%" align="right">'.number_format($tLiq , 0, ',', '.').'			</td>';
    			echo '			<td width="05%">&nbsp;</td>';
    			echo '			<td width="05%">&nbsp;</td>';
    			echo '			<td width="05%">&nbsp;</td>';
				echo '		</tr>';
				echo '	</table>';
				}
				echo '</div>';
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
