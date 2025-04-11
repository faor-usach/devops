<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("conexionli.php");

if($dato->accion == 'actualizaCotvsInformes'){
    $link=Conectarse();
	$CodInforme 	= '';
	$infoNumero 	= 0;
	$infoSubidos 	= 0;
	$CAM 			= 0;
	$SQL = "Select * From cotizaciones Where infoNumero = 0 and  Estado = 'T' and RAM > 0 and Archivo != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc";
	$bd=$link->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
		$CodInforme = 'AM-'.$rs['RAM'];
		$infoNumero 	= 0;
		$infoSubidos 	= 0;
	
		$CAM = $rs['CAM'];
		$bdAmInf=$link->query("SELECT * FROM aminformes Where CodInforme Like '%".$rs['RAM']."%'");
		while($rowAmInf=mysqli_fetch_array($bdAmInf)){
			$CodInf = $rowAmInf['CodInforme'];
			$RutCli = $rowAmInf['RutCli'];
			$CodVer = $rowAmInf['CodigoVerificacion'];
			$bdInf=$link->query("SELECT * FROM informes Where CodInforme = '".$rowAmInf['CodInforme']."'");
			if($rowInf=mysqli_fetch_array($bdInf)){

			}else{
				$link->query("insert into informes(		CodInforme					,
														RutCli						,
														CodigoVerificacion	
													) 
											values 	(	'$CodInf'					,
														'$RutCli'					,
														'$CodVer'			
				)");

			}
	
		}
		$bdInf=$link->query("SELECT * FROM informes Where CodInforme Like '%".$CodInforme."%'");
		while($rowInf=mysqli_fetch_array($bdInf)){
			$infoNumero++;
			if($rowInf['informePDF']){
				$infoSubidos++;
			}
		}

		$actSQL="UPDATE cotizaciones SET ";
		$actSQL.="infoNumero	 	= '".$infoNumero."',";
		$actSQL.="nInforme	 		= '".$infoNumero."',";
		$actSQL.="infoSubidos 		= '".$infoSubidos."'";
		$actSQL.="WHERE CAM 		= '".$CAM."'";
		$bdCot=$link->query($actSQL);

	}	
	$link->close();

    $link=Conectarse();
	$CodInforme 	= '';
	$infoNumero 	= 0;
	$infoSubidos 	= 0;
	$CAM 			= 0;
	$SQL = "Select * From cotizaciones Where infoNumero > infoSubidos and  Estado = 'T' and RAM > 0 and Archivo != 'on' Order By Facturacion, Archivo, informeUP, fechaTermino Desc";
	$bd=$link->query($SQL);
	while($rs = mysqli_fetch_array($bd)){
		$CodInforme = 'AM-'.$rs['RAM'];
		$infoNumero 	= 0;
		$infoSubidos 	= 0;
	
		$CAM = $rs['CAM'];
		$bdAmInf=$link->query("SELECT * FROM aminformes Where CodInforme Like '%".$rs['RAM']."%'");
		while($rowAmInf=mysqli_fetch_array($bdAmInf)){
			$CodInf = $rowAmInf['CodInforme'];
			$RutCli = $rowAmInf['RutCli'];
			$CodVer = $rowAmInf['CodigoVerificacion'];
			$bdInf=$link->query("SELECT * FROM informes Where CodInforme = '".$rowAmInf['CodInforme']."'");
			if($rowInf=mysqli_fetch_array($bdInf)){

			}else{
				$link->query("insert into informes(		CodInforme					,
														RutCli						,
														CodigoVerificacion	
													) 
											values 	(	'$CodInf'					,
														'$RutCli'					,
														'$CodVer'			
				)");

			}
	
		}

		$bdInf=$link->query("SELECT * FROM informes Where CodInforme Like '%".$CodInforme."%'");
		while($rowInf=mysqli_fetch_array($bdInf)){
			$infoNumero++;
			if($rowInf['informePDF']){
				$infoSubidos++;
			}
		}	
		$actSQL="UPDATE cotizaciones SET ";
		$actSQL.="infoNumero	 	= '".$infoNumero."',";
		$actSQL.="nInforme	 		= '".$infoNumero."',";
		$actSQL.="infoSubidos 		= '".$infoSubidos."'";
		$actSQL.="WHERE CAM 		= '".$CAM."'";
		$bdCot=$link->query($actSQL);

	}	
	$link->close();

    $horaAct = date('H:i');
	if($horaAct >= "7:00" and $horaAct <= "9:00") {

		$sDeuda = 0;
		$cFact	= 0;
		$link=Conectarse();
		
		$RutCli = '';  
		$fechaHoy = date('Y-m-d');
		$fecha90dias 	= strtotime ( '-90 day' , strtotime ( $fechaHoy ) );
		$fecha90dias	= date ( 'Y-m-d' , $fecha90dias );
		$bdDe=$link->query("SELECT * FROM solfactura Where fechaPago = '0000-00-00'  Order By RutCli");
		while($rowDe=mysqli_fetch_array($bdDe)){
			if($RutCli != $rowDe['RutCli']){
				$RutCli = $rowDe['RutCli'];
				$sDeuda = 0;
				$cFact  = 0;
			}
			if($RutCli == $rowDe['RutCli']){

				if($rowDe['fechaFactura'] > '0000-00-00'){
					if($rowDe['fechaFactura'] <= $fecha90dias){
						if($rowDe['Saldo'] > 0){
							$sDeuda += $rowDe['Saldo'];
							$cFact++;

							//echo ' RUT Comprar '.$RutCli .' RUT BD '. $rowDe['RutCli'].' $ '.$rowDe['Bruto'].'<br>';
							//echo '<br>';
			
							$actSQL="UPDATE clientes SET ";
							$actSQL.="nFactPend	 		= '".$cFact."',";
							$actSQL.="sDeuda 			= '".$sDeuda."'";
							$actSQL.="WHERE RutCli 		= '".$RutCli."'";
							$bdCot=$link->query($actSQL);
						}
					}
				}
			}
		}
		$link->close();

	}


}

if($dato->accion == 'grabarProyecto'){
    $Grabado = 'Error';

    $link=Conectarse();
    $SQL = "SELECT * FROM proyectos Where IdProyecto = '$dato->IdProyecto'"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $actSQL="UPDATE proyectos SET ";
        $actSQL.="Proyecto	            ='".$dato->Proyecto.	            "',";
        $actSQL.="Rut_JefeProyecto      ='".$dato->Rut_JefeProyecto.	    "',";
        $actSQL.="JefeProyecto          ='".$dato->JefeProyecto.	        "',";
        $actSQL.="Email                 ='".$dato->Email.	                "',";
        $actSQL.="Banco                 ='".$dato->Banco.	                "',";
        $actSQL.="Cta_Corriente	        ='".$dato->Cta_Corriente.	        "'";
        $actSQL.="WHERE IdProyecto	    = '$dato->IdProyecto'";
        $bdCot=$link->query($actSQL);
        $Grabado = 'Actualizado';
    }else{
        $link->query("insert into proyectos(	IdProyecto                      ,
                                                Proyecto                        ,
                                                Rut_JefeProyecto                ,
                                                JefeProyecto                    ,
                                                Email                           ,
                                                Banco                           ,
                                                Cta_Corriente
                                            ) 
                                    values 	(	'$dato->IdProyecto'             ,
                                                '$dato->Proyecto'               ,
                                                '$dato->Rut_JefeProyecto'       ,
                                                '$dato->JefeProyecto'           ,
                                                '$dato->Email'                  ,
                                                '$dato->Banco'                  ,
                                                '$dato->Cta_Corriente'
        )");
        $Grabado = 'Agregado';

    }

    $link->close();
    $res = '';
    $res.= '{"IdProyecto":"'            .	$dato->IdProyecto       .   '",';
    $res.= '"Grabado":"'                .	$Grabado                .   '"}';
    echo $res;

}

if($dato->accion == 'grabarSupervisor'){
    $link=Conectarse();
    if($dato->estadoSuper == 'New'){
        $SQL = "SELECT * FROM supervisor Where rutSuper = '$dato->rutSuper'"; 
        $bd=$link->query($SQL);
        if($rs=mysqli_fetch_array($bd)){
            $actSQL="UPDATE supervisor SET ";
            $actSQL.="rutSuper	        ='".$dato->rutSuper.	    "',";
            $actSQL.="nombreSuper       ='".$dato->nombreSuper.	    "',";
            $actSQL.="cargoSuper	    ='".$dato->cargoSuper.	    "'";
            $actSQL.="WHERE rutSuper	= '$dato->rutSuper'";
            $bdCot=$link->query($actSQL);
        }else{
            $link->query("insert into supervisor(	rutSuper,
                                                    nombreSuper,
                                                    cargoSuper
                                                ) 
                                        values 	(	'$dato->rutSuper',
                                                    '$dato->nombreSuper',
                                                    '$dato->cargoSuper'
            )");
        }
    }else{
        $actSQL="UPDATE supervisor SET ";
        $actSQL.="rutSuper	        ='".$dato->rutSuper.	    "',";
        $actSQL.="nombreSuper       ='".$dato->nombreSuper.	    "',";
        $actSQL.="cargoSuper	    ='".$dato->cargoSuper.	    "'";
        $bdCot=$link->query($actSQL);
    }

    $link->close();

}

if($dato->accion == 'leerProyectos'){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM proyectos";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"IdProyecto":"'          . $rs["IdProyecto"]. 				'",';
        $outp .= '"Proyecto":"'             . $rs["Proyecto"]. 				    '",';
        $outp .= '"JefeProyecto":"'         . $rs["JefeProyecto"]. 				'",';
        $outp .= '"firmaJefe":"'            . $rs["firmaJefe"]. 				'",';
        $outp .= '"Banco":"'                . $rs["Banco"]. 				    '",';
        $outp .= '"Cta_Corriente":"'        . $rs["Cta_Corriente"]. 		    '",';
        $outp .= '"Email":"'                . $rs["Email"]. 		            '",';
	    $outp .= '"Rut_JefeProyecto":"'     . $rs["Rut_JefeProyecto"]. 			'"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);

}

if($dato->accion == 'cargarDatosSupervisor'){
    $res = '';
    
    $link=Conectarse();
    $SQL = "SELECT * FROM supervisor"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $res.= '{"rutSuper":"'          .	$rs['rutSuper']         .   '",';
        $res.= '"nombreSuper":"'        .	$rs['nombreSuper']      .   '",';
        $res.= '"cargoSuper":"'         .	$rs['cargoSuper']       .   '",';
        $res.= '"firmaSuper":"'         .	$rs['firmaSuper']       .   '",';
        $res.= '"imgFirma":"'           .	$rs['imgFirma']         .   '"}';
    }else{
        $res.= '{"rutSuper":"'          .	'Error'         .   '"}';
    }

    $link->close();
    echo $res;

}





?>