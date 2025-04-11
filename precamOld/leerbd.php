<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
date_default_timezone_set('America/Santiago');

include("../conexionli.php"); 
$fechaHoy = date('Y-m-d'); 
$bColor = 'Normal';

$link=Conectarse();
$outp = "";
$SQL = "SELECT * FROM precam where Estado = 'on' Order By fechaPreCAM Desc"; 
$bd=$link->query($SQL);
while($rs=mysqli_fetch_array($bd)){ 

  $fechaVencida 	= strtotime ( '-1 day' , strtotime ( $fechaHoy ) );
  $fechaVencida 	= date ( 'Y-m-d' , $fechaVencida );

  if($rs['fechaPreCAM'] == '0000-00-00'){
    $bColor = "Atrazado";
  }						
  if($rs['seguimiento'] == 'on'){
    $bColor = "Precaucion";
  }


  if($rs["fechaPreCAM"] == $fechaVencida){ $bColor = 'Precaucion'; }
  if($rs["fechaPreCAM"] < $fechaVencida){ $bColor = 'Atrazado'; }
  $fechaSeg = 'Sin Seg.';
  if($rs["fechaSeg"] > '0000-00-00'){ $fechaSeg = $rs["fechaSeg"]; }
  if($rs['seguimiento'] == 'on'){
    $bColor = "Precaucion";
  }

  $largo = 300;
  $Correo = substr($rs["Correo"], 0, $largo);
  if(strlen($rs["Correo"]) > $largo){ $Correo .= "..."; }

  if ($outp != "") {$outp .= ",";}
  $outp .= '{"idPreCAM":"'  		. $rs["idPreCAM"] 		    . '",'; 
  $outp .= '"seguimiento":"'  	. $rs["seguimiento"] 		  . '",';
  $outp .= '"Correo":' 		      . json_encode($Correo, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
  $outp .= '"fechaPreCAM":"'    . $rs["fechaPreCAM"] 		  . '",';
  //$outp .= '"fechaPreCAM":"'    . $fechaVencida 		  . '",';
  $outp .= '"bColor":"'         . $bColor 		            . '",';
  $outp .= '"Tipo":"'           . $rs["Tipo"] 		        . '",';
  $outp .= '"fechaSeg":"'       . $fechaSeg 		          . '",';
  $outp .= '"usrResponsable":"'	. $rs["usrResponsable"]   . '"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo($outp);
?>