<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");
$agnoAct = date('Y');
$mesAct = date('m');
$outp = "";
$rCot = 0;

$link=Conectarse();
$SQL = "Select * From clientes where Estado = 'on' Order By Cliente"; 
$bd=$link->query($SQL);
while($rs = mysqli_fetch_array($bd)){
	if ($outp != "") {$outp .= ",";}
	$outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",';
	$outp .= '"Cliente":"'. 			trim($rs["Cliente"]). 		'",';
	$outp .= '"Giro":' 					.json_encode($rs["Giro"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	$outp .= '"Direccion":"'. 			trim($rs["Direccion"]). 	'",';
	$outp .= '"cFree":"'. 				$rs["cFree"]. 				'",';
	$outp .= '"Docencia":"'. 			$rs["Docencia"]. 			'",';
	$outp .= '"Clasificacion":"'. 		$rs["Clasificacion"]. 		'"}';
}
$outp ='{"records":['.$outp.']}';
$link->close();
echo ($outp);
?>