<?php

	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
				);

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

	$Agno     	= date('Y');
	
	$dBuscado = '';
	$tpAccion = 'Nada';
	
	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

			<div id="BarraFiltro">
			</div>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft" title="Agregar PreCam"> 
					<a href="rPreCAM.php?idPreCAM=0&accion=Agregar" title="+ PreCAM">
						<img src="../imagenes/mail_html.png"><br>
					</a>
					+ PreCAM
				</div>
				<div id="ImagenBarraLeft" title="Procesos">
					<a href="../procesosangular/plataformaCotizaciones.php" title="+ Cotizar">
						<img src="../imagenes/other_48.png"><br>
					</a>
					+ Proceso
				</div>
			</div>

				<script>
					var usrRes 		= '<?php echo $usrRes; 	 ?>';
					var tpAccion 	= '<?php echo $tpAccion; ?>';
					realizaProceso(usrRes, tpAccion);
				</script>					

			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>