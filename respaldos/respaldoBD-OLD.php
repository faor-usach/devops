<?php
	session_start(); 
   	include_once("../conexionli.php");
	set_time_limit(0);
	date_default_timezone_set("America/Santiago");

   $fechaHoy 	= date('Y-m-d');
   $fd 			= explode('-',$fechaHoy);
   $fecha		= $fd[2].'-'.$fd[1].'-'.$fd[0];
   
   	$link=Conectarse();
	
	$fechaBackup 	= date('Y-m-d');
	$usrResponsable = $_SESSION['usr'];
	$horaBackup		= date('H:i');
    $ficheroRespaldo = 'db-backup-'.$fechaBackup.'-'.$horaBackup.'.sql';
	$archivoBackup	= $ficheroRespaldo; 
				
	//$bdRes=mysql_query("Select * From ctrlrespaldos Where fechaBackup = '".$fechaBackup."'");
	//if($rowRes=mysql_fetch_array($bdRes)){
	//}else{
		mysql_query("insert into ctrlrespaldos(	
															fechaBackup,
															usrResponsable,
															horaBackup,
															archivoBackup
															) 
													values 	(	
															'$fechaBackup',
															'$usrResponsable',
															'$horaBackup',
															'$archivoBackup'
							)",
		$link);
	//}
	mysql_close($link);

   	$link=Conectarse();
   	backup_tables();
	mysql_close($link);
   

/* backup the db OR just a table */
//En la variable $talbes puedes agregar las tablas especificas separadas por comas:
//profesor,estudiante,clase
//O d�jalo con el asterisco '*' para que se respalde toda la base de datos

function backup_tables(){
   $return = '';
   $tables = '*';

		$tBases = array(	
					'accesodoc' 				=> 'accesoDoc', 
					'accionescorrectivas' 		=> 'accionesCorrectivas',
					'accionespreventivas' 		=> 'accionesPreventivas',
					'actividades' 				=> 'Actividades',
					'actividadeshistorial' 		=> 'actividadesHistorial',
					'amensayos' 				=> 'amEnsayos',
					'aminformes' 				=> 'amInformes',
					'ammuestras' 				=> 'amMuestras',
					'amnotas'					=> 'amNotas',
					'amtabensayos' 				=> 'amTabEnsayos',
					'amtpensayo' 				=> 'amtTpEnsayo',
					'amtpsmuestras' 			=> 'amTpsMuestras',
					'autoriza' 					=> 'Autoriza',
					'cajachica' 				=> 'CajaChica',
					'clientes' 					=> 'Clientes',
					'codotam' 					=> 'codOtam',
					'contactoscli' 				=> 'contactosCli',
					'cotizaciones' 				=> 'Cotizaciones',
					'cotizacionessegimiento' 	=> 'CotizacionesSegimiento',
					'ctrlrespaldos' 			=> 'ctrlrespaldos',
					'ctrlrestauracion' 			=> 'ctrlrestauracion',
					'cumplimentado' 			=> 'Cumplimentado',
					'dcotizacion' 				=> 'dCotizacion',
					'contacto' 					=> 'contacto',
					'rank' 						=> 'Rank',
					'departamentos' 			=> 'Departamentos',
					'detsolfact' 				=> 'detSolFact',
					'documentacion' 			=> 'Documentacion',
					'empresa' 					=> 'Empresa',
					'encuestas' 				=> 'Encuestas',
					'ensayos' 					=> 'Ensayos',
					'equipos' 					=> 'equipos',
					'equiposhistorial' 			=> 'equiposHistorial',
					'facturas' 					=> 'Facturas',
					'foliosencuestas' 			=> 'foliosEncuestas',
					'formram' 					=> 'formRAM',
					'formularios' 				=> 'Formularios',
					'gastos' 					=> 'Gastos',
					'honorarios' 				=> 'Honorarios',
					'horariolab' 				=> 'horarioLab',
					'hrshombre' 				=> 'HrsHombre',
					'prencuesta' 				=> 'prEncuesta',
					'informes' 					=> 'Informes',
					'ingresos' 					=> 'Ingresos',
					'items' 					=> 'Items',
					'itemsgastos' 				=> 'ItemsGastos',
					'itemsmod' 					=> 'ItemsMod',
					'itencuesta' 				=> 'itEncuesta',
					'laboratorio' 				=> 'Laboratorio',
					'masivos' 					=> 'Masivos',
					'menugrupos' 				=> 'menuGrupos',
					'menuitems' 				=> 'menuItems',
					'modulos' 					=> 'Modulos',
					'modusr' 					=> 'ModUsr',
					'movgastos' 				=> 'MovGastos',
					'otams' 					=> 'OTAMs',
					'pcam' 						=> 'pcam',
					'perfiles' 					=> 'Perfiles',
					'periodo' 					=> 'Periodo',
					'personal' 					=> 'Personal',
					'personalhonorarios' 		=> 'PersonalHonorarios',
					'precam' 					=> 'precam',
					'proveedores' 				=> 'Proveedores',
					'proyectos' 				=> 'Proyectos',
					'ranking' 					=> 'Ranking',
					'recursos' 					=> 'Recursos',
					'regcharpy' 				=> 'regCharpy',
					'regdoblado' 				=> 'regDoblado',
					'regdureza' 				=> 'regDureza',
					'registromuestras' 			=> 'registroMuestras',
					'regquimico' 				=> 'regQuimico',
					'regrevisiones' 			=> 'regRevisiones',
					'regtraccion' 				=> 'regTraccion',
					'respencuesta' 				=> 'respEncuesta',
					'servicios' 				=> 'Servicios',
					'serviciosram' 				=> 'serviciosRAM',
					'solfactura' 				=> 'SolFactura',
					'solicitudes' 				=> 'Solicitudes',
					'sueldos' 					=> 'Sueldos',
					'tabindices' 				=> 'tabIndices',
					'tablaindicadores' 			=> 'tablaIndicadores',
					'tablaregform' 				=> 'tablaRegForm',
					'tipoensayo' 				=> 'tipoEnsayo',
					'tipogasto' 				=> 'tipoGasto',
					'tpescala' 					=> 'tpEscala',
					'tpevaluacion' 				=> 'tpEvaluacion',
					'uf' 						=> 'UF',
					'usuarios' 					=> 'Usuarios',
					'vales' 					=> 'Vales',
					'visitas' 					=> 'Visitas',
					'visitashistorial' 			=> 'visitasHistorial',
					'zonas'						=> 'Zonas'
				);

   //get all of the tables
   if($tables == '*')
   {
      $tables = array();
      $result = mysql_query('SHOW TABLES');
      while($row = mysql_fetch_row($result))
      {
         $tables[] = $row[0];
      }
   }
   else
   {
      $tables = is_array($tables) ? $tables : explode(',',$tables);
   }
   
   //cycle through
   foreach($tables as $table){
   		$sw = 'Si';
   		if($table == 'contador' or $table == 'perfiles' or $table == 'usuarios' or $table == 'rank'){
   			$sw = 'No';
		}
/*		
   		if( $table == 'accesodoc' or $table == 'accionescorrectivas' or $table == 'accionespreventivas' or 
			$table == 'actividades' or $table == 'actividadeshistorial' or $table == 'amensayos' or 
			$table == 'aminformes' or $table == 'ammuestras' or $table == 'amnotas' or $table == 'amtabensayos' or
			$table == 'amtpensayo' or $table == 'ctrlrespaldos' or $table == 'amtpsmuestras' or $table == 'autoriza' or
			$table == 'cajachica' or $table == 'clientes' or $table == 'codotam' or $table == 'contactoscli' or
			$table == 'cotizaciones' or $table == 'cotizacionessegimiento' or $table == 'cumplimentado' or $table == 'dcotizacion' or
			$table == 'departamentos' or $table == 'detsolfact' or $table == 'documentacion' or $table == 'empresa'
			){
*/			

   		if($sw == 'Si'){
			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);
			//$return.= 'DROP TABLE '.$table;
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			//$return.= "\n\n".$row2[1]."\n\n";
			
			$tabBD = $tBases[$table];
		
			for ($i = 0; $i < $num_fields; $i++){
				while($row = mysql_fetch_row($result)){
					$return.= 'INSERT INTO '.$tabBD.' VALUES(';
					for($j=0; $j<$num_fields; $j++){
						//$row[$j] = addslashes($row[$j]);
						//$row[$j] = ereg_replace("\n","\\n",$row[$j]);
						//$row[$j] = preg_replace("\n","\\n",$row[$j]);
						//$row[$j] = preg_replace("'"," ",$row[$j]);
						$Obs = str_replace("'","�",$row[$j]);
						//$Obs = str_replace('"','��',$row[$j]);
						$row[$j] = $Obs;
						if (isset($row[$j])) { $return.= "'".$row[$j]."'" ; } else { $return.= "''"; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");Fin\n";
				}
		  	}
		  	//$return.="\n\n\n";
		  	//echo $return.'<br>';
		}
   }

   //save file
	$fechaBackup 	= date('Y-m-d');
	$usrResponsable = $_SESSION['usr'];
	$horaBackup		= date('H:i');

    //$ficheroRespaldo = 'db-backup.sql';
    $ficheroRespaldo = 'db-backup-'.$fechaBackup.'-'.$horaBackup.'.sql';
	$archivoBackup	= $ficheroRespaldo;

   $handle = fopen($ficheroRespaldo,'w+');
   fwrite($handle,$return);
   fclose($handle);
   
	header( "Content-Disposition: attachment; filename=".$ficheroRespaldo.""); 
	header("Content-type: application/force-download"); 
	readfile($ficheroRespaldo);
	unlink($ficheroRespaldo);

}


?>