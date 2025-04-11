<?php
    $PNG_TEMP_DIR 	= dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR 	= 'temp/';
	if(isset($_GET['data'])) { 
		//$CodInforme = substr($_GET['data'],46,14); 
	}
	if(isset($_GET['CodInforme'])) { 
		echo $CodInforme = $_GET['CodInforme'];
	}
    include "qrlib.php";    
    //if(!file_exists($PNG_TEMP_DIR))
    	//mkdir($PNG_TEMP_DIR);
	    $filename 				= $PNG_TEMP_DIR.$CodInforme.'.png';
		$matrixPointSize 		= 4;
		$errorCorrectionLevel 	= 'L';
		
		QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';
		echo '<br>Informe '.$CodInforme.'<br>';
		echo 'Request '.$_REQUEST['data'];
	//}
	
// benchmark
//QRtools::timeBenchmark();    
?>