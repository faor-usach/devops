<?php
	session_start(); 
   	include_once("../conexionli.php");
	set_time_limit(0);
	date_default_timezone_set("America/Santiago");

   	$fechaHoy 	= date('Y-m-d');
   	$fd 			= explode('-',$fechaHoy);
   	$fecha		= $fd[2].'-'.$fd[1].'-'.$fd[0];
   
	$link=Conectarse();
	$i = 0;
	$bdm=$link->query("SELECT * FROM clientes");
	$rawdata = array();
	while($row = mysqli_fetch_array($bdm))
    {
        $rawdata[$i] = $row;
        $i++;
    }
	echo json_encode($rawdata);


/*	
	   $outp = '';
	   $bdm=$link->query("SELECT * FROM amMuestras");
	   while($rsm=mysqli_fetch_array($bdm)){
			   
			   if ($outp != "") {$outp .= ",";}
			   $outp .= '{"CodInforme":"'  		. $rsm["CodInforme"] 		. '",'; 
			   $outp .= '"idMuestra":"'  		. $rsm["idMuestra"] 	    . '",';
			   $outp .= '"idItem":"'	    	. $rsm["idItem"]  		    . '"}';
		 
	   }
	   $outp ='['.$outp.']';
	   $json_string = $outp;
	   $file = 'json/amMuestras.json';
	   file_put_contents($file, $json_string);
*/

?>	   