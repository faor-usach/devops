<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));

include_once("conexionli.php");

if($dato->accion == "valAcceso"){
    $res = '';
    $nPerfil    = 'WM';
    $link=Conectarse(); 
    $sql = "SELECT * FROM usuarios Where usr = '$dato->usr' and pwd = '$dato->pwd'";
    $bd=$link->query($sql);
    if($rs = mysqli_fetch_array($bd)){
        $res.= '{"nPerfil":"'.			    $rs['nPerfil'].					    '",';
        $res.= '"cargoUsr":"'.	            $rs["cargoUsr"]. 				    '",';
        $res.= '"apruebaOfertas":"'.	    $rs["apruebaOfertas"]. 				'",';
        $res.= '"status":"'.	            $rs["status"]. 				        '",';
        $res.= '"ispector":"'.	            $rs["inspector"]. 	                '",';
        $res.= '"usuario":"'.			    $rs['usuario'].					    '"}';
    }
    $link->close();
    echo $res;	
}
