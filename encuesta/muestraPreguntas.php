	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
	include_once("conexion.php");

	if(isset($_GET['nEnc'])) 	{ $nEnc  	= $_GET['nEnc']; 		}
	if(isset($_GET['nItem'])) 	{ $nItem  	= $_GET['nItem']; 		}
	if(isset($_GET['dBuscar'])) { $dBuscar  = $_GET['dBuscar']; 	}
	
				echo '<div>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="05%" align="center" height="40"><strong>N�		</strong></td>';
				echo '			<td  width="77%" align="center"><strong>Consulta			</strong></td>';
				echo '			<td  width="18%" align="center" colspan="3"><strong>Acciones		</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n 		= 0;
				$link=Conectarse();
				
				if($dBuscar){
					$bdEnc=mysql_query("SELECT * FROM prEncuesta Where nEnc = $nEnc && nItem = $nItem && titItem Like '%".$dBuscar."%' Order By nItem");
				}else{
					$bdEnc=mysql_query("SELECT * FROM prEncuesta Where nEnc = $nEnc && nItem = $nItem Order By nItem");
				}
				if ($row=mysql_fetch_array($bdEnc)){
					do{
						$tr = 'barraVerde';
						echo '<tr id="'.$tr.'">';
						echo '	<td width="05%" style="font-size:16px;">';
						echo		$nEnc.'.'.$nItem.'.'.$row['nCon'];
						echo '	</td>';
						echo '	<td width="77%">'.$row['Consulta'].'</td>';
						echo ' 	</td>';
						echo '		<td width="06%">&nbsp;</td>';
						echo '		<td width="06%"><a href="preguntasEncuesta.php?nEnc='.$row['nEnc'].'&nItem='.$row['nItem'].'&nCon='.$row['nCon'].'&accion=Actualizar"	><img src="../gastos/imagenes/corel_draw_128.png" 	width="40" height="40" title="Editar Encuesta">				</a></td>';
						echo '		<td width="06%"><a href="preguntasEncuesta.php?nEnc='.$row['nEnc'].'&nItem='.$row['nItem'].'&nCon='.$row['nCon'].'&accion=Borrar"		><img src="../gastos/imagenes/del_128.png"   		width="40" height="40" title="Borrar Encuesta">				</a></td>';
						echo '</tr>';
					}while ($row=mysql_fetch_array($bdEnc));
				}
				mysql_close($link);
				echo '	</table>';
				echo '</div>';
			?>
