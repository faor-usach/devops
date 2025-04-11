<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #ccc;">
	<tr style="height:50px; background-color:#F8F8F8;">
    	<td width="45%" align="center" style="font-family:Geneva, Arial, Helvetica, sans-serif; font-size:14px; font-weight:700;">
			Descargar una copia de Seguridad 
		</td>
    	<td width="55%" align="center"  style="font-family:Geneva, Arial, Helvetica, sans-serif; font-size:14px; font-weight:700;">
			Restaurar copia de seguridad 
		</td>
  </tr>
  <tr>
    <td align="center" style="padding:10px;">
		<a href="respaldoBD.php" title="Respaldo">
			<img src="../imagenes/Respaldar.png" width="48"><br>
		</a>
		Respaldo
	</td>
    <td align="center" style="padding:10px; border-left: 1px solid #ccc;">
		<form action="backup.php" method="post" enctype="multipart/form-data">
			<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
				<input type="hidden" name="MAX_FILE_SIZE"> 
				<input name="copiaRes" type="file" id="copiaRes">
			</strong>
			<input type="submit" name="subirCopiaSeguridad" value="UpLoad">
		</form>
	</td>
  </tr>
  <tr>
  	<td>
		<?php  		
		$data = file_get_contents("z:backup-01-02-2019-20Hrs/regquimico.json");
		$products = json_decode($data, true);

		foreach ($products as $product) {
	    	//echo $products[2]['Nota'];
	    	echo $product['CodInforme'].':<br>';
	    	echo $product['idItem'].'<br><br>';
		}
		?>
  	</td>
  	<td></td>
  </tr>
</table>
