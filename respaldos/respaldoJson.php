<!doctype html>
 
<html lang="es">
<head>

<title>Taller Propiedades Mecánicas</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="../favicon.ico" />
	
	<link href="styles.css" 	rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    
    </head>

<body ng-app="myApp" ng-controller="myCtrl">

<div class="progress">
    <div class="progress-bar" style="width:{{progreso}}%"> {{progreso}}% </div>
</div>  

<?php
    session_start(); 
    include_once("../conexionli.php");
    date_default_timezone_set("America/Santiago");
    $outp = "";
    $i = 0;
    
    $link=Conectarse();
    
    $SQL = "SELECT * FROM cotizaciones where year(fechaCotizacion) > '2016'";
    $bd=$link->query($SQL);
    
    while($rs=mysqli_fetch_array($bd))
    {
        $outp[$i] = $rs;
        $i++;
    }  
     
    $link->Close();
    $json_string = json_encode($outp);
    //echo $json_string;
    $file = 'ficherosJson/cotizaciones.json'; 
    file_put_contents($file, $json_string); 
?>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	

<script>
    var app = angular.module('myApp', []);
    app.controller('myCtrl', function($scope) {
        $scope.progreso = "Cotizaciones";
    });
</script>

</body>
</html>