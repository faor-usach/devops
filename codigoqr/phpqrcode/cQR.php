<?php
    $PNG_TEMP_DIR 	= dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR 	= 'temp/';
	if(isset($_GET['data'])) { 
		//$CodInforme = substr($_GET['data'],46,14); 
	}
	if(isset($_GET['CodCertificado'])) { 
		$CodCertificado = $_GET['CodCertificado'];
	}
    include "qrlib.php";    
    //if(!file_exists($PNG_TEMP_DIR))
    	//mkdir($PNG_TEMP_DIR);
	    $filename 				= $PNG_TEMP_DIR.$CodCertificado.'.png';
		$matrixPointSize 		= 4;
		$errorCorrectionLevel 	= 'L';
		
		QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';
		//echo '<br>Informe '.$CodCertificado.'<br>';
		//echo 'Request '.$_REQUEST['data'];
	//}
	
// benchmark
//QRtools::timeBenchmark();    
?>