<?php
	session_start(); 

	include_once("../conexionli.php");
    include_once('../PHPExcel/Classes/PHPExcel.php');

    
    date_default_timezone_set("America/Santiago");
    $fechaHoy = date('Y-m-d');    
?>
<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel usando PHP</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">

    <link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script src="../jsboot/bootstrap.min.js"></script>	

</head>
<body ng-app="myApp" ng-controller="ctrlEspectometro">
    {{5+5}}
    <?php echo $fechaHoy; ?>

    <div class="card-body">
        <input id="archivosSeguimiento" multiple type="file"> {{pdf}}
        <button class="btn btn-success" type="button" ng-click="enviarFormularioSeg()">
            Subir Archivo
        </button>
    </div>

    <?php
        $archivo = "tmp2/Espectrometro-2025-01-28.xlsx";
        if(file_exists($archivo)){
            echo 'Existe... Data';
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 8; $row <= $highestRow; $row++){
                $aTit[] = $sheet->getCell("K".$row)->getValue();
                $aTit[] = $sheet->getCell("N".$row)->getValue();
                echo $sheet->getCell("K".$row)->getValue();
                echo $sheet->getCell("N".$row)->getValue();

            }
        }
    ?>

    <script src="../bootstrap/css/bootstrap.min.js"></script> 
    <script src="../angular/angular.js"></script>
	<script src="pruebaQu.js"></script>

</body>
</html>