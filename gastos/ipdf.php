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
	
	$Proceso = '';
	
	$Mes = array(
					1 => 'Enero		', 
					2 => 'Febrero	',
					3 => 'Marzo		',
					4 => 'Abril		',
					5 => 'Mayo		',
					6 => 'Junio		',
					7 => 'Julio		',
					8 => 'Agosto	',
					9 => 'Septiembre',
					10 => 'Octubre	',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);

	$MesNum = array(
					'Enero' 		=> 1, 
					'Febrero' 		=> 2,
					'Marzo' 		=> 3,
					'Abril' 		=> 4,
					'Mayo' 			=> 5,
					'Junio' 		=> 6,
					'Julio' 		=> 7,
					'Aosto' 		=> 8,
					'Septiembre'	=> 9,
					'Octubre' 		=> 10,
					'Noviembre' 	=> 11,
					'Diciembre' 	=> 12
				);

	/* Declaracion de Variables */
	$fd 	= explode('-', date('Y-m-d'));
	$MesGasto 	= $fd[1];
	$filtroSQL = "";
	$Proyecto = "Proyectos";

	/* Recive VAriables GET - POST */
	$Agno = date('Y');
	if(isset($_GET['MesGasto'])){ $MesGasto = $_GET['MesGasto']; }
	if(isset($_GET['Agno'])) 	{ $Agno 	= $_GET['Agno']; 	 }
	
?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Intranet Simet</title>

	<link href="estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenu.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenuModulos.css" rel="stylesheet" type="text/css">
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

</head>

<body ng-app="myApp" ng-controller="ctrlGastos">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<div id="CajaCpo">
				<?php 
					$nomModulo = 'Solicitudes en Proceso';
					include('menuIconos.php'); 
					include('barraOpciones.php')

				?>
		</div>
		<div class="row bg-primary text-white p-2">
			<div class="col-sm-1"><img src="imagenes/data_filter_128.png" width="28" height="28"></div>
			<div class="col-sm-4"></div>
			<div class="col-sm-3">
					<!-- Fitra por Fecha -->
					<select class="form-control" name='MesGasto' id='MesGasto' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
						<?php
							for($i=1; $i<=12; $i++){
								if($i == $MesGasto){
									echo "<option selected value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$i."&Agno=".$Agno."'>".$Mes[$i]."</option>";
								}else{
									echo "<option value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$i."&Agno=".$Agno."'>".$Mes[$i]."</option>";
								}
							}
							?>
					</select>
					<!-- Fin Filtro -->

			</div>
			<div class="col-sm-3">
					<!-- Fitra por A�o -->
					<select class="form-control" name='Agno' id='Agno' onChange='window.location = this.options[this.selectedIndex].value; return true;'>
						<?php
							$AgnoAct = date('Y');
							for($a=2013; $a<=$AgnoAct; $a++){
								if($a == $Agno){
									echo "<option selected 	value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$MesGasto."&Agno=".$a."'>".$a."</option>";
								}else{
									echo "<option  			value='ipdf.php?Proyecto=".$Proyecto."&MesGasto=".$MesGasto."&Agno=".$a."'>".$a."</option>";
								}
							}
						?>
					</select>
					<!-- Fin Filtro -->
			</div>
		</div>

		<table class="table table-dark table-hover">
			<thead>
				<tr>
					<th><strong>N°				</strong></th>
					<th><strong>Fecha 			</strong></th>
					<th><strong>Formulario		</strong></th>
					<th><strong>Proyecto		</strong></th>
					<th><strong>Impto.			</strong></th>
					<th><strong>N° Docs.		</strong></th>
					<th><strong>Concepto		</strong></th>
					<th><strong>Neto			</strong></th>
					<th><strong>IVA			</strong></th>
					<th><strong>Total			</strong></th>
					<th>	Acciones			</th>
				</tr>
			</thead>
				<?php
					$SQL = "SELECT * FROM formularios where year(Fecha) = '$Agno' and month(Fecha) = '$MesGasto' and Formulario != 'F5' Order By nInforme Desc, Fecha Desc";
					// echo $SQL;
					$Agno = date('Y');
					$link=Conectarse();
					$bd=$link->query($SQL);
					while($rs=mysqli_fetch_array($bd)){
						$IdRecurso = '';
						$bdG=$link->query("SELECT * FROM movgastos Where nInforme = '".$rs['nInforme']."'");
						if($rowG=mysqli_fetch_array($bdG)){
							$IdRecurso = $rowG['IdRecurso'];
						}

						$tFormulario = '';
						$bdRec=$link->query("SELECT * FROM recursos Where IdRecurso = '".$IdRecurso."'");
						if($rowRec=mysqli_fetch_array($bdRec)){
							$tFormulario = $rowRec['Formulario'].'('.$rowRec['Recurso'].')';
						}
						?>
						<tr>
							<td><?php echo $rs['nInforme']; ?>								</td>
							<td><?php echo $rs['Fecha']; ?>									</td>
							<td><?php echo $tFormulario; ?>									</td>
							<td><?php echo $rs['IdProyecto']; ?>							</td>
							<td><?php echo $rs['Impuesto']; ?>								</td>
							<td><?php echo $rs['nDocumentos']; ?>							</td>
							<td><?php echo $rs['Concepto']; ?>								</td>
							<td><?php echo number_format($rs['Neto'] , 0, ',', '.'); ?>		</td>
							<td><?php echo number_format($rs['Iva'] , 0, ',', '.'); ?>		</td>
							<td><?php echo number_format($rs['Bruto'] , 0, ',', '.'); ?>	</td>
							<td>
								<?php
									$ff = explode('(', $tFormulario);
									$doc = $ff[0].'-'.$rs['nInforme'].'.pdf';
									$vDir = '../Data/AAA/LE/FINANZAS/'.$Agno.'/GASTOS/'.$doc;
									if(file_exists($vDir)){
										echo '<a href="'.$vDir.'" target="_blank"><img src="../imagenes/informes.png"  width="32" style="margin: 2px;"></a>'; 
									}else{
										echo 'NO';
									}

									// echo $doc;
									echo '<a class="btn btn-info" href="formularios/F7Compilado.php?Concepto='.$rs['Concepto'].'&nInforme='.$rs['nInforme'].'&Formulario='.$tFormulario.'&IdProyecto='.$rs['IdProyecto'].'&Impuesto='.$rs['Impuesto'].'&Fecha='.$rs['Fecha'].'">'.$doc.'</a>';
								?>
							</td>

						</tr>
						<?php
					}
					$link->close();
				?>
		</table>

	</div>	
	


	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="../angular/angular.min.js"></script>
	<script src="moduloGastosSolicitudes.js"></script>

</body>
</html>
