<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");

if($dato->accion == "borrarDataCliente"){
    $link=Conectarse();
	$bd=$link->query("DELETE FROM clientes WHERE RutCli = '".$dato->RutCli."'");
    $bdProv=$link->query("DELETE FROM contactoscli WHERE RutCli = '".$dato->RutCli."'");
    $link->close();
}

if($dato->accion == "verificaExisteCliente"){
    $res = '';
    $link=Conectarse();
    $SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $res.= '{"RutCli":"'.				$rs["RutCli"].			'",';
        $res.= '"Cliente":"'.				$rs["Cliente"].			'"}';
    }
    $link->close();
    echo $res;	
}

if($dato->accion == "listarContactos"){
    $outp = "";
    $link=Conectarse();
    $SQL = "SELECT * FROM contactoscli where RutCli = '$dato->RutCli' Order By nContacto Asc";
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"nContacto":"'           . $rs["nContacto"]. 				'",';
        $outp .= '"Contacto":"'             . $rs["Contacto"]. 				    '",';
        $outp .= '"Email":"'                . $rs["Email"]. 				    '",';
        $outp .= '"Telefono":"'             . $rs["Telefono"]. 				    '",';
	    $outp .= '"Celular":"'              . $rs["Celular"]. 			        '"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);

}

if($dato->accion == "loadDataCliente"){
    $res = '';
    $link=Conectarse();
    
    $SQL = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){
        $HES = 'off';
        if($rs['HES']){
            $HES = $rs['HES'];
        }
    
        $res.= '{"RutCli":"'.				$rs["RutCli"].			'",';
        $res.= '"Cliente":"'.				$rs["Cliente"].			'",';
        $res.= '"Estado":"'.				$rs["Estado"].			'",';
        $res.= '"Publicar":"'.				$rs["Publicar"].		'",';
        $res.= '"cFree":"'.				    $rs["cFree"].		    '",';
        $res.= '"Docencia":"'.				$rs["Docencia"].		'",';
        $res.= '"Giro":' 			        .json_encode($rs["Giro"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res.= '"Direccion":' 			    .json_encode($rs["Direccion"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res.= '"Telefono":' 			    .json_encode($rs["Telefono"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res.= '"Celular":' 			    .json_encode($rs["Celular"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res.= '"Msg":' 			        .json_encode($rs["Msg"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $res.= '"Sitio":"'.				    $rs["Sitio"].		    '",';
        $res.= '"HES":"'. 					$HES. 					'"}';
    }
    $link->close();
    echo $res;	
    
}

if($dato->accion == "grabarDataCliente"){

    $link=Conectarse(); 

    $sql = "SELECT * FROM clientes Where RutCli = '$dato->RutCli'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
		$actSQL="UPDATE clientes SET ";
		$actSQL.="Cliente		='".$dato->Cliente.		    "',";
		$actSQL.="Giro			='".$dato->Giro.			"',";
		$actSQL.="Direccion		='".$dato->Direccion.		"',";
		$actSQL.="Telefono		='".$dato->Telefono.		"',";
		$actSQL.="Celular		='".$dato->Celular.		    "',";
		$actSQL.="Sitio			='".$dato->Sitio.			"',";
		$actSQL.="Publicar		='".$dato->Publicar.		"',";
		$actSQL.="HES			='".$dato->HES.			    "',";
		$actSQL.="cFree			='".$dato->cFree.			"',";
		$actSQL.="Msg			='".$dato->Msg.			    "',";
		$actSQL.="Estado		='".$dato->Estado.		    "',";
		$actSQL.="Docencia		='".$dato->Docencia.		"'";
		$actSQL.="WHERE RutCli	= '".$dato->RutCli.		    "'";
		$bd=$link->query($actSQL);

    }else{
        $Giro           = '';
        $HES            = '';
        $Direccion      = '';
        $Telefono       = '';
        $Celular        = '';
        $Email          = '';
        $Sitio          = '';
        $Logo           = '';
        $Msg            = '';
        $IdPerfil       = '';
        $Publicar       = '';
        $cFree          = '';
        $Docencia       = '';
        $condicionPago  = 0;
        $nFactPend      = 0;
        $sDeuda         = 0;
        $Estado         = '1';
        $vtasUltimos12m = 0;
        $Clasificacion  = 0;

        $link->query("insert into clientes(		RutCli          ,
												Cliente         ,
                                                Giro            ,
                                                HES             ,
                                                Direccion       ,
                                                Telefono        ,
                                                Celular         ,
                                                Sitio           ,
                                                Msg             ,
                                                Publicar        ,
                                                cFree           ,
                                                Docencia        ,
                                                Estado          ,
												Email           ,
												Logo            ,
												IdPerfil        ,
												condicionPago   ,
												nFactPend       ,
												sDeuda          ,
												vtasUltimos12m  ,
												Clasificacion
												) 
									values 		(	'$dato->RutCli'         ,
													'$dato->Cliente'        ,
                                                    '$dato->Giro'           ,
                                                    '$dato->HES'            ,
                                                    '$dato->Direccion'      ,
                                                    '$dato->Telefono'       ,
                                                    '$dato->Celular'        ,
                                                    '$dato->Sitio'          ,
                                                    '$dato->Msg'            ,
                                                    '$dato->Publicar'       ,
                                                    '$dato->cFree'          ,
                                                    '$dato->Docencia'       ,
                                                    '$dato->Estado'         ,
                                                    '$Email'                ,
												    '$Logo'                 ,
												    '$IdPerfil'             ,
												    '$condicionPago'        ,
												    '$nFactPend'            ,
												    '$sDeuda'               ,
												    '$vtasUltimos12m'       ,
												    '$Clasificacion'

												)"
                    );

	}
	$link->close();

}

?>