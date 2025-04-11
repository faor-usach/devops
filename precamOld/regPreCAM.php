<?php 	
	session_start(); 
	//header('Content-Type: text/html; charset=iso-8859-1');
	header('Content-Type: text/html; charset=utf-8'); 
	date_default_timezone_set("America/Santiago");
	include_once("../conexionli.php"); 
	$Rev 	= 0;
	$idPreCAM			= $_GET['idPreCAM'];
	$accion 			= $_GET['accion'];
	$fechaRegPreCAM		= date('Y-m-d');
	$encNew 			= 'Si';
	$usrResponsable		= '';
	$Actividad			= '';
	$Correo				= '';
	$seguimiento		= '';
	
	if($idPreCAM == 0){
		$link=Conectarse();
		$bddCot=$link->query("Select * From precam Order By idPreCAM Desc");
		if($rowdCot=mysqli_fetch_array($bddCot)){
			$idPreCAM = $rowdCot['idPreCAM'] + 1;
		}else{
			$idPreCAM = 1;
		}
		$link->close();
		$fechaPreCAM	= date('Y-m-d');
	}else{
		$link=Conectarse();
		$bdCot=$link->query("SELECT * FROM precam Where idPreCAM = '".$idPreCAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$Correo				= $rowCot['Correo'];
			$fechaPreCAM		= $rowCot['fechaPreCAM'];
			$usrResponsable		= $rowCot['usrResponsable'];
			$seguimiento		= $rowCot['seguimiento'];
		}
		$link->close();
		$encNew = 'No';
	}
?>

<style></style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>
<script src="../angular/angular.min.js"></script>

<div ng-app="myApp" ng-controller="ctrlPreCam" ng-init="loadPreCam('<?php echo $idPreCAM; ?>')">
<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="preCAM.php" method="post">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="3" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; "><img src="../imagenes/poster_teachers.png" width="50" align="middle"> <span style="color:#FFFFFF; font-size:25px; font-weight:700;"> Registro de PreCAM


					    <div id="botonImagen">
								  <?php 
									if($accion=='Vacio'){
										$prgLink = '../plataformaErp.php';
										$accion = 'Agrega';
									}else{
										$prgLink = 'preCAM.php';
									}
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
								?>
				    </div>
						  </span>
				  </td></tr>
				<tr>
				  	<td colspan="3" class="lineaDerBot">
					  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							PreCAM N°
							<?php
								if($accion == 'Actualizar' or $accion == 'Borrar'){ 
									echo $idPreCAM;?>
									<input name="idPreCAM" 	id="idPreCAM" type="hidden" value="<?php echo $idPreCAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" />
									<?php
								}
								if($accion == 'Agrega'){ 
									?>
									<input name="idPreCAM" 	id="idPreCAM" type="text" value="<?php echo $idPreCAM; ?>" size="20" maxlength="20" style="font-size:18px; font-weight:700;" readonly />
									<?php
								}
							?>
							<input name="accion" 				id="accion" 			type="hidden" value="<?php echo $accion; ?>">
							<input name="fechaPreCAM" 			id="fechaPreCAM" 		type="hidden" value="<?php echo $fechaPreCAM; ?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
				  <td colspan="3">&nbsp;
				  
				  </td>
			  	</tr>
				<tr>
					<td colspan="3">
						<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
							<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
								<td colspan="2">Responsable Registro </td>
							</tr>
							<tr>
								<td class="lineaDerBot">
									<select class="form-control" ng-model="usrResponsable" name="usrResponsable" id="usrResponsable" style="font-size:12px; font-weight:700;">
										<option></option>
										<?php
											$link=Conectarse();
											$bdCli=$link->query("SELECT * FROM Usuarios Where nPerfil = '1' and status != 'off' Order By usuario");
											if($rowCli=mysqli_fetch_array($bdCli)){
												do{
													$loginRes = $rowCli['usr'];
													if($rowCli['usr'] == $_SESSION['usr']){
														echo '<option selected 	value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
													}else{
														echo '<option 			value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
													}
												}while ($rowCli=mysqli_fetch_array($bdCli));
											}
											$link->close();
										?>
									</select>
									<span style="padding-left:15px; font-size:18px; ">
										Seguimiento
										<?php 
											//echo $seguimiento;
											if($seguimiento == 'on'){?>
												<input name="seguimiento" value="off" 	type="checkbox" checked>
										<?php }else{ ?>
												<input name="seguimiento" value="on" 	type="checkbox">
										<?php } ?>
									</span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
			  	<td colspan="3" class="lineaDerBot">
			  		
					<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
						<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
							<td width="100%" colspan="2">
								Registro Correo </td>
						</tr>
						<tr>
							<td colspan="2" class="lineaDerBot">
								<textarea name="Correo" id="Correo" cols="100" rows="20"><?php echo $Correo; ?></textarea>
						  	</td>
					  	</tr>

					</table>
			  </td>
		  </tr>
		  <tr>
				<td colspan="3" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardarActividad" style="float:right;" title="Guardar PreCAM">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
				</td>
		  </tr>
		</table>
		</form>
		</center>
	</div>
</div>
</div>

<script src="precam.js"></script> 

<script>
	$(document).ready(function(){
	  $("#CtaCte").click(function(){
		if($("#Cta").css("visibility") == "hidden" ){
			$("#Cta").css("visibility","visible");
		}else{
			$("#Cta").css("visibility","hidden");
		}
	  });
	});
</script>
