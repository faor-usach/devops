<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php"); 

if($dato->accion == "lectura"){
	$outp = "";
	$link=Conectarse();
	$SQL = "Select * From ammuestras Where idItem Like '%$dato->RAM%' Order By idItem";
	$bd=$link->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
			$cEnsayos = 0;
			$i = 0;
			$idEnsayo = '';
			$txtEnsayos ='';
			$SQLc = "Select * From amtabensayos Where idItem = '".$rs['idItem']."'";
			$bdc=$link->query($SQLc);
			while($rowc=mysqli_fetch_array($bdc)){
				$idEnsayo = $rowc['idEnsayo'];
				$cEnsayos = $rowc['cEnsayos'];
				$i++;
				if($i > 1){ 
					$txtEnsayos .= ', '.$rowc['idEnsayo'].'('.$rowc['cEnsayos'].'';
				}else{
					$txtEnsayos = $rowc['idEnsayo'].'('.$rowc['cEnsayos'].')';
				}

			}
			$nSolTaller = '';
			if($rs["Taller"] == 'on'){
				$bdCot=$link->query("Select * From formram Where RAM = '$dato->RAM'");
				if($rowCot=mysqli_fetch_array($bdCot)){
					$nSolTaller = $rowCot['nSolTaller'];
				}
			}
			if ($outp != "") {$outp .= ",";}
			$outp .= '{"CodInforme":"'  . 		$rs["CodInforme"]. 			'",';
			$outp .= '"idItem":"'. 				$rs["idItem"]. 				'",';
			$outp.= '"idMuestra":' 				.json_encode($rs["idMuestra"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp.= '"Objetivo":' 				.json_encode($rs["Objetivo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
			$outp .= '"Taller":"'. 				$rs["Taller"]. 				'",';
			$outp .= '"idEnsayo":"'. 			$idEnsayo. 					'",';
			$outp .= '"nSolTaller":"'. 			$nSolTaller. 				'",';
			$outp .= '"cEnsayos":"'. 			$cEnsayos. 					'",';
			$outp .= '"txtEnsayos":"'. 			$txtEnsayos. 				'",';
		    $outp .= '"conEnsayo":"'. 			$rs["conEnsayo"]. 			'"}';
	}
	$outp ='{"records":['.$outp.']}';
	$link->close();
	echo ($outp);
}

if($dato->accion == "editarTracciones"){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM regtraccion Where idItem like '%$dato->idItem%' Order By idItem Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"idItem":"'.	    $rs["idItem"].	        '",';
        $outp.= '"equipo":"'.	    $rs["equipo"].	        '",';
        $outp.= '"tpMuestra":"'. 	$rs["tpMuestra"]. 	    '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}

if($dato->accion == "editarQuimicos"){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM regquimico Where idItem like '%$dato->idItem%' Order By idItem Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"idItem":"'.	    $rs["idItem"].	        '",';
        $outp.= '"Programa":"'.	    $rs["Programa"].	    '",';
        $outp.= '"tpMuestra":"'. 	$rs["tpMuestra"]. 	    '"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    
}


if($dato->accion == "tipoMuestra"){
	$outp = '';
	$link=Conectarse();
	$bde=$link->query("SELECT * FROM amtpsmuestras Where idEnsayo = '$dato->idEnsayo'");
	while($rs=mysqli_fetch_array($bde)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"tpMuestra":"'.					$rs["tpMuestra"].				'",';
		$outp .= '"Muestra":"'. 					$rs["Muestra"]. 				'"}';
	}
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    

}

if($dato->accion == "equipamiento"){
	$outp = '';
	$link=Conectarse();
	$bde=$link->query("SELECT * FROM equipos Where codigo != ''");
	while($rs=mysqli_fetch_array($bde)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"codigo":"'.						$rs["codigo"].				'",';
		$outp .= '"nSerie":"'. 						$rs["nSerie"]. 				'"}';
	}
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    

}

if($dato->accion == "desplegarEnsayos"){
	$outp = '';
	$link=Conectarse();
	$bde=$link->query("SELECT * FROM amensayos Order By nEns Asc");
	while($rs=mysqli_fetch_array($bde)){
		$cEnsayos = 0;
		$bdte=$link->query("SELECT * FROM amtabensayos Where idItem = '$dato->idItem' and idEnsayo = '".$rs['idEnsayo']."'");
		if($rowte=mysqli_fetch_array($bdte)){
			$cEnsayos = $rowte['cEnsayos'];
		}
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"idEnsayo":"'.					$rs["idEnsayo"].				'",';
		$outp .= '"cEnsayos":"'.					$cEnsayos.						'",';
		$outp.= '"Ensayo":' 						.json_encode($rs["Ensayo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"Suf":"'. 						$rs["Suf"]. 					'"}';
	}
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);    

}

if($dato->accion == "editarDataEnsayos"){
	$res 		= '';
	$cEnsayos 	= 0;
	$link=Conectarse();
	$SQL = "Select * From amtabensayos Where idItem like '%$dato->idItem%' and idEnsayo = '$dato->idEnsayo'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		if($dato->idEnsayo = 'Ch'){
			$tpMuestra = 'Ac';
		}else{
			$tpMuestra = $rs['tpMuestra'];
		}
	
		$obsIng 		= '';
		$Comentarios 	= '';
		$SQLo = "Select * From otams Where idItem = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
		$bdo=$link->query($SQLo);
		if($rso = mysqli_fetch_array($bdo)){
			$obsIng 		= $rso["obsIng"];
			$Comentarios 	= $rso["Comentarios"];
		}
		$tpMuestra = 'Pl';
		$res .= '{"idItem":"'.				$rs["idItem"].				'",';
		$res .= '"idEnsayo":"'. 			$rs["idEnsayo"]. 			'",';
		$res .= '"tpMuestra":"'. 			$rs['tpMuestra']. 			'",';
		$res .= '"Ref":"'. 					$rs["Ref"]. 				'",';
		$res .= '"Tem":"'. 					$rs["Tem"]. 				'",';
		$res .= '"cEnsayos":"'. 			$rs["cEnsayos"]. 			'",';
		$res .= '"Ind":"'. 					$rs["Ind"]. 				'",';
		$res.= '"obsIng":' 					.json_encode($rso["obsIng"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res.= '"Comentarios":' 			.json_encode($rso["Comentarios"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res .= '"equipo":"'. 				$rs["equipo"]. 				'"}';
	}
	$link->close();
	echo $res;	

}

if($dato->accion == "buscarDataMuestra"){
	$res = '';
	$link=Conectarse();
	$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$nSolTaller = 1000;
		$fd = explode('-', $dato->idItem);
		$RAM = $fd[0];
			$bdCot=$link->query("Select * From formRAM Where RAM = '$RAM'");
			if($rowCot=mysqli_fetch_array($bdCot)){
				$nSolTaller = $rowCot['nSolTaller'];
			}
			//$nSolTaller = 1000;
			
		$res.= '{"idItem":"'.				$rs["idItem"].				'",';
		$res.= '"CodInforme":"'. 			$rs["CodInforme"]. 			'",';
		$res.= '"idMuestra":' 				.json_encode($rs["idMuestra"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res.= '"Objetivo":' 				.json_encode($rs["Objetivo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res .= '"Taller":"'. 				$rs["Taller"]. 				'",';
		$res .= '"nSolTaller":"'. 			$nSolTaller. 				'",';
		$res .= '"conEnsayo":"'. 			$rs["conEnsayo"]. 			'"}';
	}
	$link->close();
	echo $res;	

}

if($dato->accion == "buscar"){
	$res = '';
	$link=Conectarse();
	//$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$nSolTaller = 1000;
		$fd = explode('-', $dato->idItem);
		$RAM = $fd[0];
			$bdCot=$link->query("Select * From formram Where RAM = '$RAM'");
			if($rowCot=mysqli_fetch_array($bdCot)){
				$nSolTaller = $rowCot['nSolTaller'];
			}
			//$nSolTaller = 1000;
			
		$res.= '{"idItem":"'.				$rs["idItem"].				'",';
		$res.= '"CodInforme":"'. 			$rs["CodInforme"]. 			'",';
		$res.= '"idMuestra":' 				.json_encode($rs["idMuestra"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res.= '"Objetivo":' 				.json_encode($rs["Objetivo"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res .= '"Taller":"'. 				$rs["Taller"]. 				'",';
		$res .= '"nSolTaller":"'. 			$nSolTaller. 				'",';
		$res .= '"conEnsayo":"'. 			$rs["conEnsayo"]. 			'"}';
	}
	$link->close();
	echo $res;	

}

if($dato->accion == "actualizacEnsayosDo"){
	$link=Conectarse();
	$SQL = "Select * From amtabensayos Where idItem = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$cEnsayos = $rs['cEnsayos'];
		$actSQL="UPDATE amtabensayos SET ";
		$actSQL.="tpMuestra       	= '".$dato->tpMuestra.   	"',";
		$actSQL.="cEnsayos       	= '".$dato->cEnsayos.   	"'";
		$actSQL.="WHERE idItem      = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
		$bdAct=$link->query($actSQL);
		if($cEnsayos != $dato->cEnsayos){
			$fd = explode('-', $dato->idItem);
			$RAM = $fd[0];
			$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
			$bdc=$link->query($SQLc);
			if($rsc = mysqli_fetch_array($bdc)){
				$CAM = $rsc['CAM'];
			}
	
			$sqlm 		= "DELETE FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
			$result 	= $link->query($sqlm);
	
			$sqlm 		= "DELETE FROM regdobladosreal Where idItem LIKE '%".$dato->idItem."%'";  // sentencia sql
			$result 	= $link->query($sqlm);
	
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-Do'.$i;
				if($i<10) { $Otam = $dato->idItem.'-Do0'.$i; }
				$fechaCreaRegistro = date('Y-m-d');
	
				$link->query("insert into otams(	
												CAM,
												RAM,
												fechaCreaRegistro,
												idItem,
												idEnsayo,
												tpMuestra,
												Otam
												) 
										values 	(	
												'$CAM',
												'$RAM',
												'$fechaCreaRegistro',
												'$dato->idItem',
												'$dato->idEnsayo',
												'$dato->tpMuestra',
												'$Otam'
				)");
	
			}
	
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-Do'.$i;
				if($i<10) { $Otam = $dato->idItem.'-Do0'.$i; }
	
				$link->query("insert into regdobladosreal(	
												idItem,
												tpMuestra
												) 
										values 	(	
												'$Otam',
												'$dato->tpMuestra'
				)");
	
	
			}
	
		}
	}else{
		$Ref = 'SR';
		$link->query("insert into amtabensayos(	
												idItem,
												idEnsayo,
												cEnsayos,
												tpMuestra
												) 
										values 	(	
												'$dato->idItem',
												'$dato->idEnsayo',
												'$dato->cEnsayos',
												'$dato->tpMuestra'
		)");

		$fd = explode('-', $dato->idItem);
		$RAM = $fd[0];
		$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
		$bdc=$link->query($SQLc);
		if($rsc = mysqli_fetch_array($bdc)){
			$CAM = $rsc['CAM'];
		}

		$sqlm 		= "SELECT * FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
		$result 	= $link->query($sqlm);

		$sqlm 		= "SELECT * FROM regdobladosreal Where idItem = '%".$dato->idItem."%'";  // sentencia sql
		$result 	= $link->query($sqlm);

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-Do'.$i;
			if($i<10) { $Otam = $dato->idItem.'-Do0'.$i; }
			$fechaCreaRegistro = date('Y-m-d');

			$link->query("insert into otams(	
											CAM,
											RAM,
											fechaCreaRegistro,
											idItem,
											idEnsayo,
											tpMuestra,
											Otam
											) 
									values 	(	
											'$CAM',
											'$RAM',
											'$fechaCreaRegistro',
											'$dato->idItem',
											'$dato->idEnsayo',
											'$dato->tpMuestra',
											'$Otam'
			)");

		}

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-Do'.$i;
			if($i<10) { $Otam = $dato->idItem.'-Do0'.$i; }

			$link->query("insert into regdobladosreal(	
											idItem,
											tpMuestra
											) 
									values 	(	
											'$Otam',
											'$dato->tpMuestra'
			)");


		}

	}

	$link->close();

}

if($dato->accion == "actualizacEnsayosOt"){
	$link=Conectarse();
	$SQL = "Select * From amtabensayos Where idItem = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$cEnsayos = $rs['cEnsayos'];
		$actSQL="UPDATE amtabensayos SET ";
		$actSQL.="Ref       		= '".$dato->Ref.   			"',";
		$actSQL.="cEnsayos       	= '".$dato->cEnsayos.   	"'";
		$actSQL.="WHERE idItem      = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
		$bdAct=$link->query($actSQL);
		if($cEnsayos != $dato->cEnsayos){
			$fd = explode('-', $dato->idItem);
			$RAM = $fd[0];
			$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
			$bdc=$link->query($SQLc);
			if($rsc = mysqli_fetch_array($bdc)){
				$CAM = $rsc['CAM'];
			}
	
			$sqlm 		= "DELETE FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
			$result 	= $link->query($sqlm);
			
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-'.$dato->idEnsayo.$i;
				if($i<10) { $Otam = $dato->idItem.'-'.$dato->idEnsayo.'0'.$i; }
				$fechaCreaRegistro = date('Y-m-d');
	
				$link->query("insert into otams(	
												CAM,
												RAM,
												fechaCreaRegistro,
												idItem,
												idEnsayo,
												Otam
												) 
										values 	(	
												'$CAM',
												'$RAM',
												'$fechaCreaRegistro',
												'$dato->idItem',
												'$dato->idEnsayo',
												'$Otam'
				)");
	
			}
	
	
		}
	}else{
		$Ref = 'SR';
		$link->query("insert into amtabensayos(	
												idItem,
												idEnsayo,
												cEnsayos
												) 
										values 	(	
												'$dato->idItem',
												'$dato->idEnsayo',
												'$dato->cEnsayos'
		)");

		$fd = explode('-', $dato->idItem);
		$RAM = $fd[0];
		$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
		$bdc=$link->query($SQLc);
		if($rsc = mysqli_fetch_array($bdc)){
			$CAM = $rsc['CAM'];
		}

		$sqlm 		= "SELECT * FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
		$result 	= $link->query($sqlm);


		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-'.$dato->idEnsayo.$i;
			if($i<10) { $Otam = $dato->idItem.'-D'.$dato->idEnsayo.'0'.$i; }
			$fechaCreaRegistro = date('Y-m-d');

			$link->query("insert into otams(	
											CAM,
											RAM,
											fechaCreaRegistro,
											idItem,
											idEnsayo,
											Otam
											) 
									values 	(	
											'$CAM',
											'$RAM',
											'$fechaCreaRegistro',
											'$dato->idItem',
											'$dato->idEnsayo',
											'$Otam'
			)");

		}


	}

	$link->close();

}

if($dato->accion == "actualizacEnsayosDu"){
	$link=Conectarse();
	$SQL = "Select * From amtabensayos Where idItem = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$cEnsayos = $rs['cEnsayos'];
		$actSQL="UPDATE amtabensayos SET ";
		$actSQL.="tpMuestra       	= '".$dato->tpMuestra.   	"',";
		$actSQL.="Ind       		= '".$dato->Ind.   			"',";
		$actSQL.="tpMedicion       	= '".$dato->tpMedicion.   	"',";
		$actSQL.="cEnsayos       	= '".$dato->cEnsayos.   	"'";
		$actSQL.="WHERE idItem      = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
		$bdAct=$link->query($actSQL);
		if($cEnsayos != $dato->cEnsayos){
			$fd = explode('-', $dato->idItem);
			$RAM = $fd[0];
			$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
			$bdc=$link->query($SQLc);
			if($rsc = mysqli_fetch_array($bdc)){
				$CAM = $rsc['CAM'];
			}
	
			$sqlm 		= "DELETE FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
			$result 	= $link->query($sqlm);
	
			$sqlm 		= "DELETE FROM regdoblado Where idItem LIKE '%".$dato->idItem."%'";  // sentencia sql
			$result 	= $link->query($sqlm);
	
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-D'.$i;
				if($i<10) { $Otam = $dato->idItem.'-D0'.$i; }
				$fechaCreaRegistro = date('Y-m-d');
	
				$link->query("insert into otams(	
												CAM,
												RAM,
												fechaCreaRegistro,
												idItem,
												ind,
												idEnsayo,
												tpMuestra,
												tpMedicion,
												Otam
												) 
										values 	(	
												'$CAM',
												'$RAM',
												'$fechaCreaRegistro',
												'$dato->idItem',
												'$dato->Ind',
												'$dato->idEnsayo',
												'$dato->tpMuestra',
												'$dato->tpMedicion',
												'$Otam'
				)");
	
			}
	
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-D'.$i;
				if($i<10) { $Otam = $dato->idItem.'-D0'.$i; }
	
				for($ind=1; $ind<=$dato->Ind; $ind++){
					$link->query("insert into regdoblado(	
													idItem,
													nIndenta,
													tpMuestra
													) 
											values 	(	
													'$Otam',
													'$ind',
													'$dato->tpMuestra'
					)");
	
				}
	
	
			}
	
	
		}
	}else{
		$Ref = 'SR';
		$link->query("insert into amtabensayos(	
												idItem,
												idEnsayo,
												cEnsayos,
												Ind,
												tpMedicion,
												tpMuestra
												) 
										values 	(	
												'$dato->idItem',
												'$dato->idEnsayo',
												'$dato->cEnsayos',
												'$dato->Ind',
												'$dato->tpMedicion',
												'$dato->tpMuestra'
		)");

		$fd = explode('-', $dato->idItem);
		$RAM = $fd[0];
		$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
		$bdc=$link->query($SQLc);
		if($rsc = mysqli_fetch_array($bdc)){
			$CAM = $rsc['CAM'];
		}

		$sqlm 		= "SELECT * FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
		$result 	= $link->query($sqlm);

		$sqlm 		= "SELECT * FROM regdoblado Where idItem = '%".$dato->idItem."%'";  // sentencia sql
		$result 	= $link->query($sqlm);

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-D'.$i;
			if($i<10) { $Otam = $dato->idItem.'-D0'.$i; }
			$fechaCreaRegistro = date('Y-m-d');

			$link->query("insert into otams(	
											CAM,
											RAM,
											fechaCreaRegistro,
											idItem,
											ind,
											idEnsayo,
											tpMuestra,
											tpMedicion,
											Otam
											) 
									values 	(	
											'$CAM',
											'$RAM',
											'$fechaCreaRegistro',
											'$dato->idItem',
											'$dato->Ind',
											'$dato->idEnsayo',
											'$dato->tpMuestra',
											'$dato->tpMedicion',
											'$Otam'
			)");

		}

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-D'.$i;
			if($i<10) { $Otam = $dato->idItem.'-D0'.$i; }

			for($ind=1; $ind<=$dato->Ind; $ind++){
				$link->query("insert into regdoblado(	
												idItem,
												nIndenta,
												tpMuestra
												) 
										values 	(	
												'$Otam',
												'$ind',
												'$dato->tpMuestra'
				)");

			}


		}

	}

	$link->close();

}

if($dato->accion == "actualizacEnsayosCh"){
	$tpMuestra = 'Ac';
	$link=Conectarse();
	$SQL = "Select * From amtabensayos Where idItem = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$cEnsayos = $rs['cEnsayos'];
		$actSQL="UPDATE amtabensayos SET ";
		$actSQL.="tpMuestra       	= '".$tpMuestra.   			"',";
		$actSQL.="Ref       		= '".$dato->Ref.   			"',";
		$actSQL.="Ind       		= '".$dato->Ind.   			"',";
		$actSQL.="Tem       		= '".$dato->Tem.   			"',";
		$actSQL.="cEnsayos       	= '".$dato->cEnsayos.   	"',";
		$actSQL.="Ref       		= '".$dato->Ref.   			"'";
		$actSQL.="WHERE idItem      = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
		$bdAct=$link->query($actSQL);
		if($cEnsayos != $dato->cEnsayos){
			$fd = explode('-', $dato->idItem);
			$RAM = $fd[0];
			$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
			$bdc=$link->query($SQLc);
			if($rsc = mysqli_fetch_array($bdc)){
				$CAM = $rsc['CAM'];
			}
	
			$sqlm 		= "DELETE FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
			$result 	= $link->query($sqlm);
	
			$sqlm 		= "DELETE FROM regcharpy Where idItem LIKE '%".$dato->idItem."%'";  // sentencia sql
			$result 	= $link->query($sqlm);
	
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-Ch'.$i;
				if($i<10) { $Otam = $dato->idItem.'-Ch0'.$i; }
				$fechaCreaRegistro = date('Y-m-d');
	
				$link->query("insert into otams(	
												CAM,
												RAM,
												fechaCreaRegistro,
												idItem,
												idEnsayo,
												tpMuestra,
												obsIng,
												Comentarios,
												Otam
												) 
										values 	(	
												'$CAM',
												'$RAM',
												'$fechaCreaRegistro',
												'$dato->idItem',
												'$dato->idEnsayo',
												'$tpMuestra',
												'$dato->obsIng',
												'$dato->Comentarios',
												'$Otam'
				)");
	
			}
	
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-Ch'.$i;
				if($i<10) { $Otam = $dato->idItem.'-Ch0'.$i; }
	
				for($ind=1; $ind<=$dato->Ind; $ind++){
					$link->query("insert into regcharpy(	
													idItem,
													nImpacto,
													tpMuestra
													) 
											values 	(	
													'$Otam',
													'$ind',
													'$tpMuestra'
					)");
	
				}
	
	
			}
	

		}
	}else{
		$Ref = 'SR';
		$link->query("insert into amtabensayos(	
												idItem,
												idEnsayo,
												cEnsayos,
												Ref,
												Ind,
												Tem,
												tpMuestra
												) 
										values 	(	
												'$dato->idItem',
												'$dato->idEnsayo',
												'$dato->cEnsayos',
												'$dato->Ref',
												'$dato->Ind',
												'$dato->Tem',
												'$tpMuestra'
		)");

		$fd = explode('-', $dato->idItem);
		$RAM = $fd[0];
		$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
		$bdc=$link->query($SQLc);
		if($rsc = mysqli_fetch_array($bdc)){
			$CAM = $rsc['CAM'];
		}

		$sqlm 		= "SELECT * FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
		$result 	= $link->query($sqlm);

		$sqlm 		= "SELECT * FROM regcharpy Where idItem = '%".$dato->idItem."%'";  // sentencia sql
		$result 	= $link->query($sqlm);

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-Ch'.$i;
			if($i<10) { $Otam = $dato->idItem.'-Ch0'.$i; }
			$fechaCreaRegistro = date('Y-m-d');

			$link->query("insert into otams(	
											CAM,
											RAM,
											fechaCreaRegistro,
											idItem,
											idEnsayo,
											tpMuestra,
											obsIng,
											Comentarios,
											Otam
											) 
									values 	(	
											'$CAM',
											'$RAM',
											'$fechaCreaRegistro',
											'$dato->idItem',
											'$dato->idEnsayo',
											'$tpMuestra',
											'$dato->obsIng',
											'$dato->Comentarios',
											'$Otam'
			)");

		}

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-Ch'.$i;
			if($i<10) { $Otam = $dato->idItem.'-Ch0'.$i; }

			for($ind=1; $ind<=$dato->Ind; $ind++){
				$link->query("insert into regcharpy(	
												idItem,
												nImpacto,
												tpMuestra
												) 
										values 	(	
												'$Otam',
												'$ind',
												'$tpMuestra'
				)");

			}


		}

	}

	$link->close();

}

if($dato->accion == "actualizacEnsayosQu"){
	$link=Conectarse();
	$SQL = "Select * From amtabensayos Where idItem = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$cEnsayos = $rs['cEnsayos'];
		$actSQL="UPDATE amtabensayos SET ";
		$actSQL.="tpMuestra       	= '".$dato->tpMuestra.   	"',";
		$actSQL.="cEnsayos       	= '".$dato->cEnsayos.   	"'";
		$actSQL.="WHERE idItem      = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
		$bdAct=$link->query($actSQL);
		if($cEnsayos != $dato->cEnsayos){

			$fd = explode('-', $dato->idItem);
			$RAM = $fd[0];
			$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
			$bdc=$link->query($SQLc);
			if($rsc = mysqli_fetch_array($bdc)){
				$CAM = $rsc['CAM'];
			}
	
			$sqlm 		= "DELETE FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
			$result 	= $link->query($sqlm);
	
			$sqlm 		= "DELETE FROM regquimico Where idItem LIKE '%".$dato->idItem."%'";  // sentencia sql
			$result 	= $link->query($sqlm);
	
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-Q'.$i;
				if($i<10) { $Otam = $dato->idItem.'-Q0'.$i; }
				$fechaCreaRegistro = date('Y-m-d');
	
				$link->query("insert into otams(	
												CAM,
												RAM,
												fechaCreaRegistro,
												idItem,
												idEnsayo,
												tpMuestra,
												Otam
												) 
										values 	(	
												'$CAM',
												'$RAM',
												'$fechaCreaRegistro',
												'$dato->idItem',
												'$dato->idEnsayo',
												'$dato->tpMuestra',
												'$Otam'
				)");
	
			}
	
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-Q'.$i;
				if($i<10) { $Otam = $dato->idItem.'-Q0'.$i; }
	
				$link->query("insert into regquimico(	
												idItem,
												tpMuestra
												) 
										values 	(	
												'$Otam',
												'$dato->tpMuestra'
				)");
	
			}
	
		}
	}else{
		$Ref = 'SR';
		$link->query("insert into amtabensayos(	
												idItem,
												idEnsayo,
												cEnsayos,
												tpMuestra
												) 
										values 	(	
												'$dato->idItem',
												'$dato->idEnsayo',
												'$dato->cEnsayos',
												'$dato->tpMuestra'
		)");

		$fd = explode('-', $dato->idItem);
		$RAM = $fd[0];
		$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
		$bdc=$link->query($SQLc);
		if($rsc = mysqli_fetch_array($bdc)){
			$CAM = $rsc['CAM'];
		}

		$sqlm 		= "SELECT * FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
		$result 	= $link->query($sqlm);

		$sqlm 		= "SELECT * FROM regquimico Where idItem = '%".$dato->idItem."%'";  // sentencia sql
		$result 	= $link->query($sqlm);

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-Q'.$i;
			if($i<10) { $Otam = $dato->idItem.'-Q0'.$i; }
			$fechaCreaRegistro = date('Y-m-d');

			$link->query("insert into otams(	
											CAM,
											RAM,
											fechaCreaRegistro,
											idItem,
											idEnsayo,
											tpMuestra,
											Otam
											) 
									values 	(	
											'$CAM',
											'$RAM',
											'$fechaCreaRegistro',
											'$dato->idItem',
											'$dato->idEnsayo',
											'$dato->tpMuestra',
											'$Otam'
			)");

		}

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-Q'.$i;
			if($i<10) { $Otam = $dato->idItem.'-Q0'.$i; }

			$link->query("insert into regquimico(	
											idItem,
											tpMuestra
											) 
									values 	(	
											'$Otam',
											'$dato->tpMuestra'
			)");

		}

	}

	$link->close();

}

if($dato->accion == "actualizacEnsayosTr"){
	$link=Conectarse();
	$SQL = "Select * From amtabensayos Where idItem = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$cEnsayos = $rs['cEnsayos'];
		$actSQL="UPDATE amtabensayos SET ";
		$actSQL.="tpMuestra       	= '".$dato->tpMuestra.   	"',";
		$actSQL.="cEnsayos       	= '".$dato->cEnsayos.   	"',";
		$actSQL.="equipo       		= '".$dato->equipo.   		"'";
		$actSQL.="WHERE idItem      = '$dato->idItem' and idEnsayo = '$dato->idEnsayo'";
		$bdAct=$link->query($actSQL);
		if($cEnsayos != $dato->cEnsayos){
			$fd = explode('-', $dato->idItem);
			$RAM = $fd[0];
			$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
			$bdc=$link->query($SQLc);
			if($rsc = mysqli_fetch_array($bdc)){
				$CAM = $rsc['CAM'];
			}
	
			$sqlm 		= "DELETE FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
			$result 	= $link->query($sqlm);
	
			$sqlm 		= "DELETE FROM regtraccion Where idItem LIKE '%".$dato->idItem."%'";  // sentencia sql
			$result 	= $link->query($sqlm);

			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-T'.$i;
				if($i<10) { $Otam = $dato->idItem.'-T0'.$i; }
				$fechaCreaRegistro = date('Y-m-d');
	
				$link->query("insert into otams(	
												CAM,
												RAM,
												fechaCreaRegistro,
												idItem,
												idEnsayo,
												tpMuestra,
												Otam
												) 
										values 	(	
												'$CAM',
												'$RAM',
												'$fechaCreaRegistro',
												'$dato->idItem',
												'$dato->idEnsayo',
												'$dato->tpMuestra',
												'$Otam'
				)");
	
			}
	
			for($i=1; $i<=$dato->cEnsayos; $i++){
				$Otam = $dato->idItem.'-T'.$i;
				if($i<10) { $Otam = $dato->idItem.'-T0'.$i; }
	
				$link->query("insert into regtraccion(	
												idItem,
												equipo,
												tpMuestra
												) 
										values 	(	
												'$Otam',
												'$dato->equipo',
												'$dato->tpMuestra'
				)");
	
			}
	
	
		}
	}else{
		$Ref = 'SR';
		$link->query("insert into amtabensayos(	
												idItem,
												idEnsayo,
												cEnsayos,
												equipo,
												Ref,
												tpMuestra
												) 
										values 	(	
												'$dato->idItem',
												'$dato->idEnsayo',
												'$dato->cEnsayos',
												'$dato->equipo',
												'$Ref',
												'$dato->tpMuestra'
		)");

		$fd = explode('-', $dato->idItem);
		$RAM = $fd[0];
		$SQLc = "Select * From cotizaciones Where RAM = '$RAM'";
		$bdc=$link->query($SQLc);
		if($rsc = mysqli_fetch_array($bdc)){
			$CAM = $rsc['CAM'];
		}

		$sqlm 		= "SELECT * FROM otams Where idItem = '".$dato->idItem."' and idEnsayo = '$dato->idEnsayo'";  // sentencia sql
		$result 	= $link->query($sqlm);

		$sqlm 		= "SELECT * FROM regtraccion Where idItem = '%".$dato->idItem."%'";  // sentencia sql
		$result 	= $link->query($sqlm);

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-T'.$i;
			if($i<10) { $Otam = $dato->idItem.'-T0'.$i; }
			$fechaCreaRegistro = date('Y-m-d');

			$link->query("insert into otams(	
											CAM,
											RAM,
											fechaCreaRegistro,
											idItem,
											idEnsayo,
											tpMuestra,
											Otam
											) 
									values 	(	
											'$CAM',
											'$RAM',
											'$fechaCreaRegistro',
											'$dato->idItem',
											'$dato->idEnsayo',
											'$dato->tpMuestra',
											'$Otam'
			)");

		}

		for($i=1; $i<=$dato->cEnsayos; $i++){
			$Otam = $dato->idItem.'-T'.$i;
			if($i<10) { $Otam = $dato->idItem.'-T0'.$i; }

			$link->query("insert into regtraccion(	
											idItem,
											tpMuestra
											) 
									values 	(	
											'$Otam',
											'$dato->tpMuestra'
			)");

		}

	}

	$link->close();
}

if($dato->accion == "cambiarEquipo"){
	$res 	= '';
	$equipo = '';
	$link=Conectarse();
	//$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$SQL = "Select * From regtraccion Where idItem = '$dato->idItem'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$equipo = 'Tr-30';
		if($rs['equipo'] == 'Tr-100'){
			$equipo = 'Tr-30';
		}
		if($rs['equipo'] == 'Tr-30'){
			$equipo = 'Tr-100';
		}
        $actSQL="UPDATE regtraccion SET ";
        $actSQL.="equipo       	='".$equipo.   "'";
        $actSQL.="WHERE idItem      = '$dato->idItem'";
        $bdAct=$link->query($actSQL);
		$OK = $bdAct;
	}
	$link->close();
	$res.= '{"idItem":"'.				$dato->idItem.			'",';
	$res.= '"equipo":"'.				$equipo.				'"}';
	echo $res;	

}

if($dato->accion == "guardar"){
	$res = '';
	$OK = 'NO';
	$link=Conectarse();
	//$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$SQL = "Select * From ammuestras Where idItem = '$dato->idItem'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
        $actSQL="UPDATE ammuestras SET ";
        $actSQL.="Taller      		='".$dato->Taller.      "',";
        $actSQL.="conEnsayo    		='".$dato->conEnsayo.   "',";
        $actSQL.="Objetivo    		='".$dato->Objetivo.   	"',";
        $actSQL.="idMuestra       	='".$dato->idMuestra.   "'";
        $actSQL.="WHERE idItem      = '$dato->idItem'";
        $bdAct=$link->query($actSQL);
		$OK = $bdAct;
	}
	$link->close();
	$res.= '{"estatus":"'.				$OK.				'"}';
	echo $res;	
}

?>