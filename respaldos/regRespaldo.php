<?php
// Y://
	// $agnoActual = date('Y');
	// $vDir = 'z://Bkp-'.$agnoActual; 
	// if(!file_exists($vDir)){
	// 	mkdir($vDir, 644);
	// }

?>
<div class="card">
  <div class="card-header">Carpetas con los Respaldos</div>
  <div class="card-body">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th>Carpetas Respaldos</th>
				<th>Editar</th>
				<th>Borrar</th>
			</tr>
		</thead>
		<tbody>
		<?php 
					$tr = "bVerde";
					$ruta = '../Data/backup/';
					$gestorDir = opendir($ruta);
					$agnoActual = date('Y');
					while(false !== ($nombreDir = readdir($gestorDir))){
						$dirActual = explode('-', $nombreDir);
						//echo $nombreDir.' Carpeta '.is_dir($nombreDir).'<br>';
						//echo $nombreDir.' Carpeta '.filemtime($nombreDir).'<br>';
						if($dirActual[0] == 'backup'){
							if($dirActual[3] == $agnoActual ){
								if($nombreDir != '.' and $nombreDir != '..'){?>
									<tr id="<?php echo $tr; ?>">
										<td width="80%" style="font-size:18px;">
											<strong style="font-size:25; font-weight:700">
												<?php echo $nombreDir; ?>
											</strong>
										</td>
											<td width="09%" align="center"><a href="backupRestaurar.php?accion=Levantar&carpeta=<?php echo $nombreDir; ?>"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Levantar">	</a></td>
											<td width="09%" align="center"><a href="backupBorrar.php?accion=Borrar&carpeta=<?php echo $nombreDir; ?>"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar">	</a></td>
										<td>
										</td>
									</tr>

									<?php
								}
							}
						}
					}
				?>

		</tbody>
	</table>
  </div>
</div>