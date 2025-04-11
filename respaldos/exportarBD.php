<?
include_once("conexion.php");
//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Ensayos.xls");
?>
<HTML LANG="es">
<TITLE>::. Exportacion de Datos .::</TITLE>
</head>
<body>
		
		<table>
			<tr>
			  	<td>codEnsayo</td>
			  	<td>Ensayo</td>
   			</tr>
  				<?php
				$link=Conectarse();
				$bdFac=mysql_query("SELECT * FROM ensayos");
				if ($rowFac=mysql_fetch_array($bdFac)){
					do{ ?>
  						<tr>
							<td>
								<?php
									echo $rowFac['codEnsayo'];
								?>
							</td>
  					  		<td>
								<?php
									echo $rowFac['Ensayo'];
								?>
							</td>
   						</tr>
						<?php
					}while ($rowFac=mysql_fetch_array($bdFac));
				}
				mysql_close($link);
				?>
		</table>
</body>
</html>
