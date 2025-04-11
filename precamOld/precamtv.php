<?php
	session_start(); 
	date_default_timezone_set("America/Santiago");
	
	include_once("../conexionli.php");

?>
<!doctype html>
 
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de PreCAM</title>
	
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<script src="../jquery/jquery-1.6.4.js"></script>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
	<script src="../angular/angular.min.js"></script>

    <style type="text/css">
        * {
            box-sizing: border-box;
        }
        .verde-class{
            background-color : green;
            color : #fff;
            font-weight : bold;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
        }
        .verdechillon-class{
            background-color : #33FFBE;
            color : #fff;
            font-weight : bold;
            font-size: 18px;
        }
        .azul-class{
            background-color : blue;
            color : #fff;
            font-weight : bold;
            font-size: 18px;
        }
        .amarillo-class{
            background-color : yellow;
            color : black;
            font-size: 18px;
        }
        .rojo-class{
            background-color : red;
            color : #fff;
            font-weight : bold;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
        }
        .default-color{
            background-color : #fff;
            color : black;
            font-size: 18px;
        }
    </style>

</head>

<body ng-app="myApp" ng-controller="ctrlPreCam" ng-cloak>
	<?php include_once('head.php'); ?>

    <div ng-show="mInventario"> 
            <!-- <p>{{myNumber | numberWithDots}}</p> --> 

            <div class="row m-2">
                <div class="col-1"> 
                    Buscar:
                </div>
                <div class="col-11">
                    <input type="text" ng-model="search" id="search" class="form-control" placeholder="Ingrese Filtro...">
                </div>
            </div>
            <hr>
            <div class="row m-1">
               
                <div class="col">
                    <table  class="table table-hover"  
                            style="font-size:12px;">
                        <thead>
                            <tr class="table-dark">
                                <th>N°                      </th>
                                <th>Resp.                   </th>
                                <th>Fecha Pre / Seg.        </th>
                                <th>Correo                  </th>
                                <th>Est.                    </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                ng-repeat="x in dataPreCAM | filter:{ $: search  }" 
                                ng-class="verColorLinea(x.bColor)">
                                <td>
                                    {{x.idPreCAM}}<br>{{x.Tipo}}      
                                </td>
                                <td>{{x.usrResponsable}}    </td>
                                <td width="10%">
                                    {{x.fechaPreCAM  | date:'dd-MM-yyyy'}}<br>      
                                    {{x.fechaSeg  | date:'dd-MM-yyyy'}}      
                                </td>
                                <td>{{x.Correo}}            </td>
                                <td>{{x.Estado}}            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    
            </div>

    </div>

    <script src="../jsboot/bootstrap.min.js"></script>	
	<script src="precamtv.js"></script> 
		
</body>
</html>
