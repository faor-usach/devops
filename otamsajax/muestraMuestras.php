<?php
	//session_start(); 
	//include_once("conexion.php");
	$link=Conectarse();
	$tEns 			= 0;
	$vReferencia 	= 0;

	if(isset($_GET['CAM']))  		{ $CAM		= $_GET['CAM']; 		}
	if(isset($_GET['RAM']))  		{ $RAM		= $_GET['RAM']; 		}
	if(isset($_GET['dBuscar']))  	{ $dBuscar  = $_GET['dBuscar']; 	} 
	if(isset($_GET['accion']))  	{ $accion	= $_GET['accion']; 		}
	
	if(isset($_POST['CAM']))  		{ $CAM		= $_POST['CAM']; 		}
	if(isset($_POST['RAM']))  		{ $RAM		= $_POST['RAM']; 		}
	if(isset($_POST['idItem']))  	{ $idItem	= $_POST['idItem']; 	}
	if(isset($_POST['idEnsayo']))  	{ $idEnsayo	= $_POST['idEnsayo']; 	}
	if(isset($_POST['accion']))  	{ $accion	= $_POST['accion']; 	}

	$agnoActual = date('Y'); 
	// $vDir = 'Y://AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM.'/Du/Planos'; 
	$vDir = '../Data/AAA/Archivador-'.$agnoActual.'/Laboratorio/Archivador-AM/'.$RAM; 
	$vDir = '../Data/AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM; 
	if(!file_exists($vDir)){
		mkdir($vDir);
	}
	$vDir = '../Data/AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/Du';   
	if(!file_exists($vDir)){
		//mkdir($vDir);
	}
	$vDir = '../Data/AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/Du/Planos'; 
	if(!file_exists($vDir)){
		//mkdir($vDir);
	}

	$link=Conectarse();
	$vDirEnsayos = '../Data/AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM; 
	if(!file_exists($vDirEnsayos)){
		mkdir($vDirEnsayos);
	}

	// echo 'MUESTRA RAM ....'.$RAM;

	$sqlOtam = "SELECT * FROM otams Where idItem like '%$RAM%' Order By idEnsayo";
	$bdOT=$link->query($sqlOtam);
	while($rowOT=mysqli_fetch_array($bdOT)){
		$vDirEnsayos = '../Data/AAA/LE/LABORATORIO/'.$agnoActual.'/'.$RAM.'/'.$rowOT['idEnsayo']; 
		if(!file_exists($vDirEnsayos)){
			mkdir($vDirEnsayos);
		}	
	}
	// $link->close();





	

	$carpeta = 'Planos/AM-'.$RAM.'/';

	if(isset($_POST['quitarEnsayo']))	{ 
		$bd =$link->query("Delete From amtabensayos Where idItem = '$idItem' and idEnsayo = '$idEnsayo'");
		$bd =$link->query("Delete From regquimico 		Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From regtraccion 		Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From regcharpy 		Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From regdoblado 		Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From regdobladosreal 	Where idItem like '%$idItem%'");
		$bd =$link->query("Delete From otams 			Where idItem = '$idItem' and idEnsayo = '$idEnsayo'");

		$sql = "SELECT * FROM amtabensayos Where idItem like '%$RAM%' and idEnsayo = '$idEnsayo'";
		$bd=$link->query($sql);
		if($rs=mysqli_fetch_array($bd)){

		}else{
			$vDir="Y://AAA/LE/LABORATORIO/".$agnoActual.'/'.$RAM.'/'.$idEnsayo;
			if(file_exists($vDir)){
				echo $vDir;
				// unlink($vDir);
				rmdir($vDir);
			}
		}




	}
	if(isset($_POST['guardarEnsayo']))	{ 
		
		//echo $_POST['idItem'].'<br>';
		//echo $_POST['idEnsayo'].'<br>';
		/*
		echo $_POST['Ref'].'<br>';
		*/

		$Ind 		 	= 0;
		$Tem 		 	= '';
		$equipo  	 	= '';
		$tpMedicion  	= '';
		$tpMuestra   	= '';
		$obsIng 		= 'Las probetas de impacto fueron ensayadas a 21 +/- 1°C, según especificación del cliente.';
		$Comentarios 	= 'La muestra analizada cumple/no cumple (según corresponda) con la energía absorbida establecida por el cliente.';

		if(isset($_POST['Ind']))  		{ $Ind			= $_POST['Ind']; 		}
		if(isset($_POST['Tem']))  		{ $Tem			= $_POST['Tem']; 		}
		if(isset($_POST['tpMedicion'])) { $tpMedicion	= $_POST['tpMedicion']; }
		if(isset($_POST['tpMuestra'])) 	{ $tpMuestra	= $_POST['tpMuestra']; 	}
		if(isset($_POST['vReferencia'])){ $vReferencia	= $_POST['vReferencia'];}
		if(isset($_POST['obsIng']))		{ $obsIng		= $_POST['obsIng'];		}
		if(isset($_POST['Comentarios'])){ $Comentarios	= $_POST['Comentarios'];}
		if(isset($_POST['equipo']))		{ $equipo		= $_POST['equipo'];		}

		if($tpMuestra == 'Tr'){
			if($equipo == ''){
				$equipo = 'Tr-30';
			}
		}

		if($_POST['Ref'] == 'SR'){
			$vReferencia = 0;
		}

		//echo 'Tipo de Muestra: '.$tpMuestra;
		$sql = "SELECT * FROM amtabensayos Where idItem = '$idItem' and idEnsayo = '$idEnsayo'";
		$bd=$link->query($sql);
		if($row=mysqli_fetch_array($bd)){
			$actSQL="UPDATE amtabensayos SET ";
			$actSQL.="cEnsayos		='".$_POST['cEnsayos'].		"',";
			$actSQL.="Ref			='".$_POST['Ref'].			"',";
			$actSQL.="Ind			='".$Ind.					"',";
			$actSQL.="Tem			='".$Tem.					"',";
			$actSQL.="tpMedicion	='".$tpMedicion.			"',";
			$actSQL.="equipo		='".$equipo.				"',";
			$actSQL.="tpMuestra		='".$tpMuestra.				"'";
			$actSQL.="WHERE idItem 	= '$idItem' and idEnsayo = '$idEnsayo'";
			$bdAct=$link->query($actSQL);
			$obsIng 		= 'Las probetas de impacto fueron ensayadas a '.$Tem.' +/- 1°C, según especificación del cliente.';

			$actSQL="UPDATE Otams SET ";
			$actSQL.="Tem			='".$Tem.					"',";
			$actSQL.="obsIng		='".$obsIng.				"',";
			$actSQL.="Comentarios	='".$Comentarios.			"',";
			$actSQL.="vReferencia	='".$vReferencia.			"'";
			$actSQL.="WHERE idItem 	= '$idItem' and idEnsayo = '$idEnsayo'";
			$bdAct=$link->query($actSQL);

			$actSQL="UPDATE regtraccion SET ";
			$actSQL.="equipo		='".$equipo.			"'";
			$actSQL.="WHERE idItem 	like '%$idItem%'";
			$bdAct=$link->query($actSQL);

		}else{
			$tpMuestra 	= '';
			$equipo 	= 'Tr-30';
			$Ref 		= 'SR';
			$cEnsayos	= 0;
			if(isset($_POST['tpMuestra'])) 	{ $tpMuestra	= $_POST['tpMuestra']; 	}
			if(isset($_POST['Ref'])) 		{ $Ref			= $_POST['Ref']; 		}
			if(isset($_POST['cEnsayos'])) 	{ $cEnsayos		= $_POST['cEnsayos']; 	}
			$link->query("insert into amtabensayos(
													idItem			,
													idEnsayo		,
													tpMuestra		,
													equipo		,
													Ref				,
													cEnsayos		,
													Ind				,
													Tem				,
													tpMedicion		
												) 
										values 	(	
													'$idItem'		,
													'$idEnsayo'		,
													'$tpMuestra'	,
													'$equipo'	,
													'$Ref'			,
													'$cEnsayos'		,
													'$Ind'			,
													'$Tem'			,
													'$tpMedicion'	
												)");

		}
		
		$reg = '';
		if($idEnsayo == 'Qu'){ $reg = 'regquimico'; 	}
		if($idEnsayo == 'Tr'){ $reg = 'regtraccion'; 	}
		if($idEnsayo == 'Ch'){ $reg = 'regcharpy'; 		}
		if($idEnsayo == 'Du'){ $reg = 'regdoblado'; 	}
		if($idEnsayo == 'Do'){ $reg = 'regdobladosreal'; }
		if($reg){
			if(isset($_POST['tpMuestra'])) { $tpMuestra	= $_POST['tpMuestra']; }

			$sql = "SELECT count(*) as cEns FROM $reg Where idItem like '%$RAM%' and tpMuestra = '$tpMuestra'";
			$bd=$link->query($sql);
			$row=mysqli_fetch_array($bd);
			
			$cEns = $row['cEns'];

			if(isset($_POST['cEnsayos'])) 	{ $cEnsayos		= $_POST['cEnsayos']; 	}
			$sqly = "SELECT * FROM amensayos Where idEnsayo = '$idEnsayo'";
			$bdy=$link->query($sqly);
			if($rowy=mysqli_fetch_array($bdy)){
			}
			$idOtam = $idItem;
			for($e=1; $e <= $cEnsayos; $e++ ){
				$idOtam = $idItem.'-'.$rowy['Suf'].$e;
				if($e < 10){
					$idOtam = $idItem.'-'.$rowy['Suf'].'0'.$e;
				}
				//echo $tpMuestra;
				$sqlr = "SELECT * FROM $reg Where idItem = '$idOtam' and tpMuestra = '$tpMuestra'";
				$bdr=$link->query($sqlr);
				if($rowr=mysqli_fetch_array($bdr)){

				}else{
					if($idEnsayo == 'Ch' or $idEnsayo == 'Du'){
						if($idEnsayo == 'Ch'){
							for($ch = 1; $ch<= $Ind; $ch++){
								$link->query("insert into $reg(idItem	, tpMuestra, nImpacto  ) 
												  	values ('$idOtam'	,'$tpMuestra', '$ch')");

							}
						}
						if($idEnsayo == 'Du'){
							for($ch = 1; $ch<= $Ind; $ch++){
								$link->query("insert into $reg(idItem	, tpMuestra, nIndenta  ) 
												  	values ('$idOtam'	,'$tpMuestra', '$ch')");

							}
						}
					}else{
						$link->query("insert into $reg(idItem	, tpMuestra  ) 
										  	values ('$idOtam'	,'$tpMuestra')");

					}

					$Tem 		= 'Normal';
					if(isset($_POST['tpMuestra'])) 	{ $tpMuestra	= $_POST['tpMuestra']; 	 }
					if(isset($_POST['Tem']))  		{ $Tem			= $_POST['Tem']; 		 }
					if(isset($_POST['vReferencia'])){ $vReferencia	= $_POST['vReferencia']; }
					$fechaCreaRegistro = date('Y-m-d');
					/*
					$sqlinset = "insert into otams (
														RAM				,
														CAM				,
														fechaCreaRegistro,
														idItem			,
														Otam			,
														tpMuestra		,
														idEnsayo		,
														Ind				,
														Tem				,
														tpMedicion		
													) 
										  	values ( 	
										  				'$RAM'			,
										  				'$CAM'			,
										  				'$fechaCreaRegistro',
										  				'$idItem'		,
										  				'$idOtam'		,
										  				'$tpMuestra'	,
										  				'$idEnsayo'		,
										  				'$Ind'			,
										  				'$Tem'			,
										  				'$tpMedicion'
										  			)";
					*/
					//echo $sqlinset;

					$link->query("insert into otams (
														CAM				,
														RAM				,
														fechaCreaRegistro,
														idItem			,
														Otam			,
														idEnsayo		,
														tpMuestra		,
														Ind				,
														Tem				,
														vReferencia		,
														tpMedicion
													) 
										  	values ( 	
										  				'$CAM'			,
										  				'$RAM'			,
										  				'$fechaCreaRegistro',
										  				'$idItem'		,
										  				'$idOtam'		,
										  				'$idEnsayo'		,
										  				'$tpMuestra'	,
										  				'$Ind'			,
										  				'$Tem'			,
										  				'$vReferencia'	,
										  				'$tpMedicion'
										  			)");

				}

			}
			$e--;
			if($cEns > $e){
				$idOtam = $idItem;
				for($i=$e+1; $i <= $cEns; $i++ ){
					$idOtam = $idItem.'-'.$rowy['Suf'].$i;
					if($i < 10){
						$idOtam = $idItem.'-'.$rowy['Suf'].'0'.$i;
					}
					$bd =$link->query("Delete From $reg Where idItem = '$idOtam' and tpMuestra = '$tpMuestra'");
				}
			}
		}else{
			$tpMuestra 	= '';
			if(isset($_POST['cEnsayos'])) 	{ $cEnsayos		= $_POST['cEnsayos']; 	}
			$fechaCreaRegistro = date('Y-m-d');
			for($e=1; $e <= $cEnsayos; $e++ ){
				$idOtam = $idItem.'-'.$idEnsayo.$e;
				if($e < 10){
					$idOtam = $idItem.'-'.$idEnsayo.'0'.$e;
				}
				$link->query("insert into otams (
														CAM				,
														RAM				,
														fechaCreaRegistro,
														idItem			,
														Otam			,
														idEnsayo		,
														tpMuestra		,
														Ind				,
														Tem				,
														vReferencia		,
														tpMedicion
													) 
										  	values ( 	
										  				'$CAM'			,
										  				'$RAM'			,
										  				'$fechaCreaRegistro',
										  				'$idItem'		,
										  				'$idOtam'		,
										  				'$idEnsayo'		,
										  				'$tpMuestra'	,
										  				'$Ind'			,
										  				'$Tem'			,
										  				'$vReferencia'	,
										  				'$tpMedicion'
										  			)");
			}
			
		}

		// echo 'Entra...'.$RAM;
		$agnoActual = date('Y');
		$sql = "SELECT * FROM amtabensayos Where idItem like '%$RAM%'";
		$bd=$link->query($sql);
		while($rs=mysqli_fetch_array($bd)){
            $vDir="../Data/AAA/LE/LABORATORIO/".$agnoActual;
            if(!file_exists($vDir)){
                mkdir($vDir);
            }
            $vDir="../Data/AAA/LE/LABORATORIO/".$agnoActual.'/'.$RAM;
            if(!file_exists($vDir)){
                mkdir($vDir);
            }
            $vDir="../Data/AAA/LE/LABORATORIO/".$agnoActual.'/'.$RAM.'/'.$rs['idEnsayo'];
            if(!file_exists($vDir)){
                mkdir($vDir);
            }
            $vDir="Planos/AM-".$RAM;
			// echo 'Planos...'.$vDir;
            if(!file_exists($vDir)){
                mkdir($vDir);
            }
		}



	}
	if(isset($_POST['guardarMuestra']))	{ 
		// $vDir="Planos/AM-".$RAM;
		// echo 'Planos...'.$vDir;
		// if(!file_exists($vDir)){
		// 	mkdir($vDir);
		// }

		$vDir="../Data/AAA/LE/LABORATORIO/".$agnoActual;
		if(!file_exists($vDir)){
			mkdir($vDir);
		}
		$vDir="../Data/AAA/LE/LABORATORIO/".$agnoActual.'/'.$RAM;
		if(!file_exists($vDir)){
			mkdir($vDir);
		}

		if(isset($_POST['idItem']))  	{ $idItem	= $_POST['idItem']; 	}



		//echo $_POST['idMuestra'];
		//echo $_POST['conEnsayo'].'<br>';
		//echo $_POST['Taller'];
		//echo $_POST['Objetivo'];
		//echo $_FILES['Plano']['name'].'<br>';
		// echo $_FILES['Plano']['type'].'<br>';
		// echo $_FILES['Plano']['tmp_name'];
		//echo $_FILES['Plano']['size'];
		$archivo = '';
		if(isset($_FILES['Plano']['name'])){
			if($_FILES['Plano']['name']){
				$aExt = '';
				if($_FILES['Plano']['type'] == 'application/pdf'){ $aExt = '.pdf'; }
				if($_FILES['Plano']['type'] == 'image/jpeg'){ $aExt = '.jpg'; }
				if($_FILES['Plano']['type'] == 'image/png'){ $aExt = '.png'; }
				if($_FILES['Plano']['type'] == 'application/vnd.ms-excel'){ $aExt = '.xls'; }
				if($_FILES['Plano']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){ $aExt = '.docx'; }
				$archivo = $_FILES['Plano']['name'];
				if($aExt){
					$archivo = 'Plano-'.$idItem.$aExt;
				}
				if (move_uploaded_file($_FILES['Plano']['tmp_name'], $vDir."/".$archivo)){

				}
			}
		}
		$sql = "SELECT * FROM ammuestras Where idItem = '$idItem'";
		$bd=$link->query($sql);
		if($row=mysqli_fetch_array($bd)){
			if(!$archivo){
				$archivo = $row['Plano'];
			}
			$actSQL="UPDATE ammuestras SET ";
			$actSQL.="idMuestra		='".$_POST['idMuestra'].	"',";
			$actSQL.="conEnsayo		='".$_POST['conEnsayo'].	"',";
			$actSQL.="Taller		='".$_POST['Taller'].		"',";
			$actSQL.="Objetivo		='".$_POST['Objetivo'].		"',";
			$actSQL.="Plano			='".$archivo.				"'";
			$actSQL.="WHERE idItem 	= '$idItem'";
			$bdAct=$link->query($actSQL);
		}
	}

	$txtEnsayos = '';
?>
<form action="idMuestras.php" method="post" enctype="multipart/form-data">
<div class="row">
	<div class="col-4">
		<table id="Muestras" class="table table-dark  table-bordered" style="margin: 5px;">
			<thead>
				<tr>
					<th height="40"><strong>Id.SIMETtt				</strong></th>
					<th>			<strong>Identificación Cliente 	</strong></th>
					<th>			<strong>Serv.<br>Taller 		</strong></th>
					<th>			<strong>OTAMs 					</strong></th>
					<th colspan="3"><strong>Acciones				</strong></th>
				</tr>
			</thead>
			<tbody>
<!--			
				<tr ng-repeat = "x in regMuestras"
				ng-class="verColorLineaPAM(x.idMuestra)">
					<td>
						{{x.idItem}}
					</td>
					<td>
						{{x.idMuestra}}
					</td>
					<td>
						{{x.nSolTaller}}
					</td>
					<td>
						{{x.txtEnsayos}}
					</td>
					<td>
						<a href="" class="btn btn-info" ng-click="editarMuestra(x.idItem)">Editar</a>
					</td>
				</tr>
-->




				<?php
				$firstidItem = '';
				if(isset($_GET['idItem']))  	{ $firstidItem	= $_GET['idItem']; 		}
				$bdfRAM=$link->query("SELECT * FROM ammuestras Where idItem Like '%".$RAM."%' Order By idItem");
				while($rowfRAM=mysqli_fetch_array($bdfRAM)){
					if(!$firstidItem){
						$firstidItem = $rowfRAM['idItem'];
					}
					$txtEnsayos = '';
					$tr = "bg-secondary text-white"; //"Blanca";
					if($rowfRAM['idMuestra'] != ''){
						$tr = "bg-danger text-white"; //"bRoja";
						$i = 0;
						$txtEnsayos = '';
						$SQL = "Select * From amtabensayos Where idItem = '".$rowfRAM['idItem']."'";
						//echo $SQL.'<br>';
						$bdCot=$link->query($SQL);
						while($rowCot=mysqli_fetch_array($bdCot)){
								$tr = "bg-success text-white"; // "bVerde";
								$i++;
								if($i > 1){ 
									$txtEnsayos .= ', '.$rowCot['idEnsayo'].'('.$rowCot['cEnsayos'].'';
								}else{
									$txtEnsayos = $rowCot['idEnsayo'].'('.$rowCot['cEnsayos'].')';
								}
						}
					}
					?>
					<tr class="<?php echo $tr; ?>">
							<td width="08%" style="font-size:16px;"  align="center">
								<?php echo $rowfRAM['idItem']; ?>
							</td>
							<td width="40%" style="font-size:16px;">
								<?php echo $rowfRAM['idMuestra']; ?>
							</td>
							<td width="10%" style="font-size:16px;">
								<?php
									if($rowfRAM['Taller'] == 'on'){
										$bdCot=$link->query("Select * From formram Where RAM = '".$RAM."'");
										if($rowCot=mysqli_fetch_array($bdCot)){
											echo $rowCot['nSolTaller'];
										}
									}
								?>
							</td>
							<td width="20%" style="font-size:12px;" align="left">
								<?php echo $txtEnsayos; ?>
							</td>
							<td width="18%" colspan="3" align="center">
								<a class="btn btn-info" href="idMuestras.php?idItem=<?php echo $rowfRAM['idItem']; ?>&RAM=<?php echo $RAM; ?>&CAM=<?php echo $CAM; ?>&accion=">Editar
								</a>
							</td>
						</tr>
						<?php
				}
				?>
			</tbody>			
		</table>
	</div>

	<div class="col-8">
		<input name="CAM" 		type="hidden"  	value="<?php echo $CAM; ?>">
		<input name="RAM" 		type="hidden"  	value="<?php echo $RAM; ?>">
		<input name="idItem" 	type="hidden" 	value="<?php echo $firstidItem; ?>">
		<input name="accion" 	type="hidden" 	value="<?php echo $accion; ?>">


		<!-- <div class="card" style="margin: 10px;" ng-show="formMuestra"> -->
<!-- 			
		<div class="card" style="margin: 10px;" ng-init="buscarDataMuestra('<?php echo $firstidItem; ?>')">
			<div class="card-header">
				<h5>Muestra {{idItem}} Servicio de Taller {{nSolTaller}}</h5>
			</div>
			<div class="card-body" style="padding:10px;">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Id. Muestra</span>
					</div>
					<input type="text" ng-model="idMuestra" class="form-control">
				</div>				
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="conEnsayo">Con Ensayo:</label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="Taller">Servicio de Taller:</label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<select class     = "form-control"
                      				ng-model  = "conEnsayo" 
                      				ng-options  = "conEnsayo.codEnsayo as conEnsayo.descripcion for conEnsayo in ensayar" >
                			<option value="off">{{conEnsayo}}</option>
              				</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<select class     = "form-control"
                      				ng-model  = "Taller" 
                      				ng-options  = "Taller.codTaller as Taller.descripciontaller for Taller in ServicioTaller" >
                			<option value="off">{{Taller}}</option>
              				</select>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							Objetivo
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<textarea class="form-control" ng-model="Objetivo" rows="4">{{Objetivo}}</textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
						  <label for="Plano">Plano:</label>
						  <input class="form-control-file border" name="Plano" type="file">
						</div>
					</div>
				</div>

			</div>
			<div class="card-footer">
				<a href="" class="btn btn-warning" ng-click="guardarConfiguracionMuestra()">Guardar Muestra</a>
				<span class="alert alert-success alert-dismissible" ng-show="msgGraba">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
  					<strong>Información!</strong> {{resp}}.
				</span>
			</div>
		</div> -->

		<?php
			if(isset($_POST['idItem'])){ $firstidItem = $_POST['idItem']; }
			$bdm=$link->query("SELECT * FROM ammuestras Where idItem = '$firstidItem'");
			if($rowm=mysqli_fetch_array($bdm)){?>
				<div class="card" style="margin: 10px;">
					<div class="card-header">
						<h5>Muestra <?php echo $firstidItem; ?> 
						<?php
				  			if($rowm['Taller'] == 'on'){
								$bdCot=$link->query("Select * From formram Where RAM = '".$RAM."'");
								if($rowCot=mysqli_fetch_array($bdCot)){
				  					?>
									Serv. Taller (<?php echo $rowCot['nSolTaller']; ?>)
									<?php
								}
							}
						?>
						</h5>
					</div>
					<div class="card-body" style="padding:10px;">
						<div class="input-group mb-3">
						     <div class="input-group-prepend">
						       <span class="input-group-text">Id. Muestra</span>
						    </div>
						    <input type="text" name="idMuestra" class="form-control" value="<?php echo $rowm['idMuestra']; ?>">
						 </div>				
						 <div class="row">
						 	<div class="col-6">
								<div class="form-group">
								  <label for="conEnsayo">Con Ensayo:</label>
								  <select class="form-control" name="conEnsayo">
								  	<?php 
								  		if($rowm['conEnsayo'] == 'on'){?>
										    <option selected value='on'>Con Ensayo</option>
								    		<option value='off'>Sin Ensayo</option>
								  			<?php
								  		}elseif($rowm['conEnsayo'] == 'off'){?>
								    		<option value='on'>Con Ensayo</option>
										    <option selected value='off'>Sin Ensayo</option>
								  			<?php
								  		}else{?>
								    		<option value='on'>Con Ensayo</option>
										    <option value='off'>Sin Ensayo</option>
								  			<?php
								  		}
								  	?>
								  </select>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
								  <label for="Taller">Servicio de Taller:</label>
								  <select class="form-control" name="Taller">
								  	<?php 
								  		if($rowm['Taller'] == 'off'){?>
								    		<option selected value='off'>Sin Taller</option>
								    		<option value='on'>Con Servicio de Taller</option>
								    		<?php
								    	}elseif($rowm['Taller'] == 'on'){?>
								    		<option value='off'>Sin Taller</option>
								    		<option selected value='on'>Con Servicio de Taller</option>
								    		<?php
								    	}else{?>
								    		<option value='off'>Sin Taller</option>
								    		<option value='on'>Con Servicio de Taller</option>
								    		<?php
								    	}
								    ?>
								  </select>
								</div>
								<div class="form-group">
								  <label for="Objetivo">Objetivo:</label>
								  <textarea class="form-control" name="Objetivo" rows="2"><?php echo $rowm['Objetivo']; ?></textarea>
								</div>

							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group">
								  <label for="Plano">Plano:</label>
								  <input class="form-control-file border" name="Plano" type="file">
								</div>
							</div>
							<div class="col-6">
								<?php 
									$PlanoY="Y://AAA/LE/LABORATORIO/".$agnoActual.'/'.$RAM.'/';
									if(!file_exists($PlanoY)){
										mkdir($PlanoY);
									}
									$PlanoLocal="Planos/AM-".$RAM.'/';
									if(!file_exists($PlanoLocal)){
										mkdir($PlanoLocal);
									}
									$PlanoY="../Data/AAA/LE/LABORATORIO/".$agnoActual.'/'.$RAM.'/'.$rowm['Plano'];
									if(file_exists($PlanoY)){
										$nuevo_fichero = 'Planos/AM-'.$RAM.'/'.$rowm['Plano'];
										// echo $nuevo_fichero;
										if($rowm['Plano']){
											copy($PlanoY, $nuevo_fichero);
										}
										$carpeta = $vDir.'/'.$rowm['Plano'];
									}
									$carpeta = 'Planos/AM-'.$RAM.'/'.$rowm['Plano'];
									if($rowm['Plano']){?> 
										<img width="50%" src="<?php echo $carpeta; ?>" class="img-thumbnail" alt="Plano">
										<?php
									}
								?>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-warning" name="guardarMuestra">Guardar Muestrass</button>
					</div>
				</div>
				<?php
				if($rowm['idMuestra']){ ?>
					<div class="card" style="margin: 10px;" ng-init="buscarDataMuestra('<?php echo $firstidItem; ?>')">
						<div class="card-header">
							<b>Seleccionar tipo de Ensayos para la Muestra {{idItem}} </b>
							<!-- <li ng-repeat="x in dataEnsayos">{{idEnsayo}}</li> -->
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col" ng-repeat="x in dataEnsayos">
									<a class="btn btn-success m-1" ng-if="x.cEnsayos > 0" ng-click="editarDataEnsayos(x.idEnsayo, idItem)">
										{{x.idEnsayo}}
										<span class="badge badge-pill badge-warning"> {{x.cEnsayos}} </span>
									</a>
									<a class="btn btn-danger m-1" ng-if="x.cEnsayos == 0" ng-click="editarDataEnsayos(x.idEnsayo, idItem)">
										{{x.idEnsayo}}
										<span class="badge badge-pill badge-warning"> {{x.cEnsayos}} </span>
									</a>
								</div>
							</div>

						</div>
					</div>

					<div class="card" style="margin: 10px;">
						<div class="card-header">
							<b>Data Ensayo {{Ensayo}}</b>
						</div>

						<div class="card-body" ng-show="formularioTr">
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email">Cantidad de Tracciones:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosTr(idItem)" placeholder="Número de Tracciones"  ng-model="cEnsayos">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Probeta:</label>
										<select class="form-control" ng-change="actualizacEnsayosTr(idItem)" name="tpMuestra" id="tpMuestra" ng-model="tpMuestra">
        									<option ng-repeat="x in dataMuestras" value="{{x.tpMuestra}}">{{x.Muestra}}</option>
        								</select>
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Equipo:</label>
										<select class="form-control" ng-change="actualizacEnsayosTr(idItem)" name="equipo" id="equipo" ng-model="equipo">
        									<option ng-repeat="x in dataEquipamiento" value="{{x.codigo}}">{{x.nSerie}}</option>
        								</select>

									</div>
								</div>
							</div>
							<b>Tracciones</b>
							<div class="row">
								<div class="col">Id.Traccion</div>
								<div class="col">Equipo</div>
							</div>
							<div class="row" ng-repeat="x in dataTracciones">
								<div class="col">{{x.idItem}}</div>
								<div class="col">
									{{x.equipo}}
									<button type="button" class="btn btn-info m-1" ng-click="cambiarEquipo(x.idItem, x.equipo)">{{x.equipo}}</button>
									</div>
							</div>

						</div>

						<div class="card-body" ng-show="formularioQu">
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email">Cantidad de Quimicos:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosQu(idItem)" placeholder="Número de Químicos"  ng-model="cEnsayos">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Muestra:</label>
										<select class="form-control" ng-change="actualizacEnsayosQu(idItem)" name="tpMuestra" id="tpMuestra" ng-model="tpMuestra">
        									<option ng-repeat="x in dataMuestras" value="{{x.tpMuestra}}">{{x.Muestra}}</option>
        								</select>
									</div>
								</div>
							</div>
							<div ng-show="formularioQu">
								<b>Quimicos</b>
								<div class="row">
									<div class="col">Id.Químico</div>
									<div class="col">Tp.Muestra</div>
									<div class="col">Programa</div>
								</div>
								<div class="row" ng-repeat="x in dataQuimicos">
									<div class="col">{{x.idItem}}</div>
									<div class="col">
										{{x.tpMuestra}}
									</div>
									<div class="col">
										{{x.Programa}}
									</div>
								</div>
							</div>

						</div>

						<div class="card-body" ng-show="formularioCh">
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email">Cantidad de Charpy:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosCh(idItem)" placeholder="Cantidad de Charpy"  ng-model="cEnsayos">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Referencia:</label>
										<select class="form-control" ng-change="actualizacEnsayosCh(idItem)" name="Ref" id="Ref" ng-model="Ref">
        									<option ng-repeat="x in selReferencia" value="{{x.Ref}}">{{x.descripcion}}</option>
        								</select>

									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Valor Ref.:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosCh(idItem)" placeholder="Valor Referencia"  ng-model="vReferencia">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email">Impactos:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosCh(idItem)" placeholder="Número de Impactos"  ng-model="nImpactos">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Temperatura:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosCh(idItem)" placeholder="Temperatura"  ng-model="Tem">
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email">Obs.Ingeniero:</label>
										<textarea class="form-control" ng-blur="actualizacEnsayosCh(idItem)" rows="5" name='obsIng' id="obsIng" ng-model="obsIng">{{obsIng}}</textarea>
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Comentarios:</label>
										<textarea class="form-control" rows="5" ng-blur="actualizacEnsayosCh(idItem)" name='Comentarios' id="Comentarios" ng-model="Comentarios">{{Comentarios}}</textarea>
									</div>
								</div>

							</div>
							<div ng-show="formularioCh">
								<b>Tracciones</b>
								<div class="row">
									<div class="col">Impacto</div>
									<div class="col">Id.Charpy</div>
									<div class="col">Tp.Muestra</div>
								</div>
								<div class="row" ng-repeat="x in dataTracciones">
									<div class="col">{{x.nImpacto}}</div>
									<div class="col">{{x.idItem}}</div>
									<div class="col">
										{{x.tpMuestra}}
										</div>
								</div>
							</div>

						</div>

						<div class="card-body" ng-show="formularioDo"> <!-- XXX -->
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email">Cantidad de Doblados:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosDo(idItem)" placeholder="Cantidad de Durezas"  ng-model="cEnsayos">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Muestra:</label>
										<select class="form-control" ng-change="actualizacEnsayosDo(idItem)" name="tpMuestra" id="tpMuestra" ng-model="tpMuestra">
        									<option ng-repeat="x in dataMuestras" value="{{x.tpMuestra}}">{{x.Muestra}}</option>
        								</select>
									</div>
									
								</div>
							</div>
							<div ng-show="formularioDo">
								<b>Durezas</b>
								<div class="row">
									<div class="col">Id.Dureza</div>
									<div class="col">Tp.Muestra</div>
								</div>
								<div class="row" ng-repeat="x in dataTracciones">
									<div class="col">{{x.idItem}}</div>
									<div class="col">
										{{x.tpMuestra}}
										</div>
								</div>
							</div>

						</div>

						<div class="card-body" ng-show="formularioDu">
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email">Cantidad de Durezas:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosDu(idItem)" placeholder="Cantidad de Durezas"  ng-model="cEnsayos">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Tipo de Dureza:</label>
										<select class="form-control" ng-change="actualizacEnsayosDu(idItem)" name="tpMuestra" id="tpMuestra" ng-model="tpMuestra">
        									<option ng-repeat="x in dataMuestras" value="{{x.tpMuestra}}">{{x.Muestra}}</option>
        								</select>
									</div>
									
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email">Medición:</label>
										<select class="form-control" ng-change="actualizacEnsayosDu(idItem)" name="tpMedicion" id="tpMedicion" ng-model="tpMedicion">
        									<option ng-repeat="x in selMedicion" value="{{x.tpMedicion}}">{{x.descripcion}}</option>
        								</select>
									</div>
								</div>

								<div class="col">
									<div class="form-group">
										<label for="email">Indentaciones:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosDu(idItem)" placeholder="Número de Impactos"  ng-model="nImpactos">
									</div>
								</div>

							</div>
							<div ng-show="formularioDu">
								<b>Durezas</b>
								<div class="row">
									<div class="col">Indentaciones</div>
									<div class="col">Id.Dureza</div>
									<div class="col">Tp.Muestra</div>
								</div>
								<div class="row" ng-repeat="x in dataTracciones">
									<div class="col">{{x.nImpacto}}</div>
									<div class="col">{{x.idItem}}</div>
									<div class="col">
										{{x.tpMuestra}}
										</div>
								</div>
							</div>

						</div>

						<div class="card-body" ng-show="formularioOt">
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email">Cantidad de Ensayos:</label>
										<input type="text" class="form-control" ng-change="actualizacEnsayosOt(idItem)" placeholder="Cantidad de Durezas"  ng-model="cEnsayos">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="email">Referencia:</label>
										<select class="form-control" ng-change="actualizacEnsayosOt(idItem)" name="Ref" id="Ref" ng-model="Ref">
        									<option ng-repeat="x in selReferencia" value="{{x.Ref}}">{{x.descripcion}}</option>
        								</select>

									</div>
								</div>
							</div>

						</div>



					</div>
					<?php
				}
				?>


			</div>
		</div>
		<?php
	}
	$link->close();
?>
</form>