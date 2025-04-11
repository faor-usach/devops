<?php
	session_start(); 
	//header('Content-Type: text/html; charset=iso-8859-1'); 
	header('Content-Type: text/html; charset=utf-8'); 

	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");

	if(isset($_GET['usrRes']))	{ $usrRes	= $_GET['usrRes'];		}
	if(isset($_GET['tpAccion'])){ $tpAccion	= $_GET['tpAccion'];	}
	
	?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="45%" valign="top">
					<?php 
						informesActividades($usrRes, $tpAccion); 
					?>
				</td>
			</tr>
		</table>
		
		<?php
		function informesActividades($usrRes, $tpAccion){
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">';
				echo '		<tr>';
				echo '			<td  width="11%" align="center" height="40">Fecha<br>Registro			</td>';
				echo '			<td  width="54%">							Correo						</td>';
				echo '			<td  width="07%" align="center">			Responsable<br>Registro		</td>';
				echo '			<td  width="18%" align="center">Acciones								</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">';
				$n 		= 0;

				$link=Conectarse();
				$i = 0;
				$sql = "SELECT * FROM precam Where Estado = 'on' Order By Estado Desc, fechaPreCAM Desc";
				$bdEnc=$link->query($sql);
				while($row=mysqli_fetch_array($bdEnc)){
						$tr = "bVerde";
						$fechaHoy = date('Y-m-d');

						$fechaVencida 	= strtotime ( '-30 day' , strtotime ( $fechaHoy ) );
						$fechaVencida 	= date ( 'Y-m-d' , $fechaVencida );

						if($row['fechaPreCAM'] == '0000-00-00'){
							$tr = "bRoja";
						}						
						if($row['seguimiento'] == 'on'){
							$tr = "bAmarilla";
						}
						$fecha2Dias = '0000-00-00';				
						if($row['Estado'] == 'off'){
							$tr = "bAzul";
							if($row['fechaPreCAM'] <= $fechaVencida){
								$tr = "bRoja";
							}						
						}else{
							$fecha2Dias 	= strtotime ( '-2 day' , strtotime ( $fechaHoy ) );
							$fecha2Dias 	= date ( 'Y-m-d' , $fecha2Dias );
							
							$seguimiento = '';
							$idPreCAM = $row['idPreCAM'];
						}
						if($tr != "bRoja") {
							echo '<tr id="'.$tr.'">';
							echo '	<td width="03%" align="center">';
										echo $row['idPreCAM'];
							echo '	</td>';
							echo '	<td width="11%" style="font-size:12px;" align="center">';
							echo		'<strong style="font-size:16; font-weight:700">';
										$fd = explode('-', $row['fechaPreCAM']);
										echo $fd[2].'/'.$fd[1].'/'.$fd[0];
										if($row['fechaSeg'] != '0000-00-00'){
											$fd = explode('-', $row['fechaSeg']);
											echo '<br>'.$fd[2].'/'.$fd[1].'/'.$fd[0];
										}
										//echo ' <br> '.$fechaHoy.'<br>'.$fechaVencida;
							echo 		'</strong>';
							echo '	</td>';
							echo '	<td width="54%" style="font-size:12px;">';
										echo substr($row['Correo'],0,150).'...';
							echo '	</td>';
							echo '	<td width="07%" style="font-size:12px;">';
										echo $row['usrResponsable'];
										if($row['fechaPreCAM'] < $fecha2Dias){?>
											<br>
											<img src="../imagenes/bola_roja.png">
											<?php
										}
							echo ' 	</td>';
							echo '	<td width="06%" align="center"><a href="../cotizaciones/plataformaCotizaciones.php?idPreCAM='.$row['idPreCAM'].'&accion=Cotizar"	><img src="../imagenes/other_48.png" 		width="40" height="40" title="ir a Proceso">	</a></td>';
							echo '	<td width="06%" align="center"><a href="mPreCAM.php?idPreCAM='.$row['idPreCAM'].'&accion=Actualizar"><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar PreCAM">	</a></td>';
							// echo '	<td width="06%" align="center"><a href="preCAM.php?idPreCAM='.$row['idPreCAM'].'&accion=Actualizar"><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar PreCAM">	</a></td>';
							echo '	<td width="06%" align="center"><a href="preCAM.php?idPreCAM='.$row['idPreCAM'].'&accion=Borrar"	><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar PreCAM">	</a></td>';
							echo '</tr>';
						}
				} 
				$link->close();
				echo '	</table>';
			}
			?>

