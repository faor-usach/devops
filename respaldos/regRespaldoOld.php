			<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">
				<tr>
					<td  width="15%" align="center" height="40">Fecha<br>Respaldo		</td>
					<td  width="15%">							Hora					</td>
					<td  width="15%">							Responsable<br>Respaldo	</td>
					<td  width="20%">							Arcivo<br>Backup		</td>
					<!-- <td  width="18%" align="center">Acciones						</td> -->
					</tr>
			</table>
			
			<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">
				<?php
					$tr = "bVerde";
					$link=Conectarse();
					$bdEnc=mysql_query("SELECT * FROM ctrlrespaldos Order By fechaBackup Desc, horaBackup Desc Limit 0, 10");
					if($row=mysql_fetch_array($bdEnc)){
						do{?>
						<tr id="<?php echo $tr; ?>">
							<td width="15%" style="font-size:12px;" align="center">
								<strong style="font-size:25; font-weight:700">
									<?php 
										$fd = explode('-',$row['fechaBackup']);
										echo $fd[2].'-'.$fd[1].'-'.$fd[0]; 
									?>
								</strong>
							</td>
							<td width="15%" style="font-size:12px;">
								<?php echo $row['horaBackup']; ?>
							</td>
							<td width="15%" style="font-size:12px;">
								<?php echo $row['usrResponsable']; ?>
							</td>
							<td width="20%" style="font-size:12px;">
								<?php echo $row['archivoBackup']; ?>
							</td>
<!--
							<td width="09%" align="center"><a href="actualizaProyecto.php?IdProyecto=<?php echo $row['IdProyecto']; ?>&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Proyecto">	</a></td>
							<td width="09%" align="center"><a href="actualizaProyecto.php?IdProyecto=<?php echo $row['IdProyecto']; ?>&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Proyecto">	</a></td>
-->
						</tr>
						<?php
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				?>
			</table>
			<div style="clear:both"></div>
			<?php if(file_exists('informess.zip')){?>
				<table border="0" cellspacing="0" cellpadding="0" id="CajaTiluloCAM">
					<tr>
						<td  width="15%" align="center" height="40">Fichero<br>Respaldo		</td>
						<td  width="15%">							Fecha					</td>
						<td  width="15%">							Hora					</td>
						<td  width="20%">							Tamaño					</td>
						<!-- <td  width="18%" align="center">Acciones						</td> -->
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" id="CajaListadoCAM">
					<?php 
						$tr = "bAmarilla"; 
						$nombre_archivo = 'informes.zip';
					?>
					<tr id="<?php echo $tr; ?>">
						<td width="15%" style="font-size:12px;" align="center"><a href="informes.zip">informes.zip</a></td>
						<td width="15%"><?php echo date("d m Y.", filectime($nombre_archivo)); ?></td>
						<td width="15%"><?php echo date("H:i.", filectime($nombre_archivo)); ?></td>
						<td width="20%"><?php echo formatoBytes(filesize($nombre_archivo)); ?></td>
					</tr>
				</table>
			<?php } ?>
			<?php
				function formatoBytes($bytes)
					{
						if ($bytes >= 1073741824)
						{
							$bytes = number_format($bytes / 1073741824, 2) . ' GB';
						}
						elseif ($bytes >= 1048576)
						{
							$bytes = number_format($bytes / 1048576, 2) . ' MB';
						}
						elseif ($bytes >= 1024)
						{
							$bytes = number_format($bytes / 1024, 2) . ' KB';
						}
						elseif ($bytes > 1)
						{
							$bytes = $bytes . ' bytes';
						}
						elseif ($bytes == 1)
						{
							$bytes = $bytes . ' byte';
						}
						else
						{
							$bytes = '0 bytes';
						}
				
						return $bytes;
				}
?>