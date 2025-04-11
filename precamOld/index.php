<?php
    session_start(); 
    date_default_timezone_set('America/Santiago');
    include("../conexionli.php");
    $fechaHoy           = date('Y-m-d');
    $horaActual         = date ("h:i:s");
    //echo $fechaHoy.' '.$horaActual;

    $msg = '';
    $Periodo = date('Y');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Backend Liceo Tecnógico Enrique Kirberg</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Angular JavaScript -->
    <script src="../../../angularjs/angular.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script> -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .ventanaModal {
          /*display: none;*/ /* Hidden by default */
          position: fixed; /* Stay in place */
          z-index: 999; /* Sit on top */
          padding-top: 100px; /* Location of the box */
          left: 20;
          top: 0;
          width: 100%; /* Full width */
          height: 100%; /* Full height */
          overflow: auto; /* Enable scroll if needed */
          background-color: rgb(0,0,0); /* Fallback color */
          background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
          background-color: #fefefe;
          margin:  8% auto;
          padding: 20px;
          border: 1px solid #888;
          width: 60%;
        }    
    </style>
    <style type="text/css">
        * {
            box-sizing: border-box;
        }
        .verde-class{
            background-color : green;
            color : #fff;
            font-weight : bold;
        }
        .verdechillon-class{
            background-color : #33FFBE;
            color : #fff;
            font-weight : bold;
        }
        .azul-class{
            background-color : blue;
            color : #fff;
            font-weight : bold;
        }
        .amarillo-class{
            background-color : yellow;
            color : black;
        }
        .rojo-class{
            background-color : red;
            color : black;
        }
        .default-color{
            background-color : #fff;
            color : black;
        }
    </style>


</head>

<body ng-app="myApp" ng-controller="CtrlVitacora" ng-cloak>

    <div class="row">
        <dv class="col-sm-6">
            <?php include_once("vitacora.php"); ?> 
        </dv>
        <dv class="col-sm-6"></dv>
    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="moduloVitacora.js"></script> 
</body>

</html>
