<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'";  
$bd=$link->query($SQL); 
if($row=mysqli_fetch_array($bd)){
    $Descripcion = '';
    $informeUP = '';
    if($row['Fan'] > 0){
        $informeUP = 'on';
    }
    //if($dato->Descripcion){ $Descripcion = $dato->Descripcion; }

    $fechaInicio            = $row['fechaInicio'];
    $dHabiles               = $dato->dHabiles;

    $fechaHoy = date('Y-m-d');
    $fechaTermino = '0000-00-00';
    $fechaTermino = NULL;

    if($dato->Estado == 'E') { $fechaInicio = '0000-00-00'; }
    if($dato->Estado == 'T') { $fechaTermino = $dato->fechaEstimadaTermino; }
    if($dato->Estado == 'P') { $fechaTermino = '0000-00-00'; }
    
    $fechaEstimadaTermino = $dato->aaEstimada.'-'.$dato->mmEstimada.'-'.$dato->ddEstimada;
    if($dato->Estado == 'E') { $fechaInicio = NULL; }
    if($dato->Estado == 'T') { $fechaTermino = $fechaEstimadaTermino; }
    if($dato->Estado == 'P') { $fechaTermino = NULL; }

    // if($row['fechaTermino']){
    //     $fechaTermino = $row['fechaTermino'];
    // }

    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="usrResponzable        = '".$dato->usrResponzable.         "', ";
    $actSQL.="RAM                   = '".$dato->RAM.                    "', ";
    $actSQL.="informeUP             = '".$informeUP.                    "', ";
    $actSQL.="dHabiles              = '".$dato->dHabiles.               "', ";
    $actSQL.="nOC                   = '".$dato->nOC.                    "', ";
    $actSQL.="fechaEstimadaTermino  = '".$fechaEstimadaTermino.         "', ";
    $actSQL.="fechaTermino          = '".$fechaEstimadaTermino.         "', ";
    $actSQL.="tpEnsayo              = '".$dato->tpEnsayo.               "', ";
    // $actSQL.="fechaInicio           = '".$fechaInicio.                  "', ";
    $actSQL.="Estado                = '".$dato->Estado.                 "' ";
    $actSQL.="WHERE CAM             = '$dato->CAM' and RAM = '$dato->RAM' and Fan = '$dato->Fan'";
    $bdAct=$link->query($actSQL); 
}

$link->close();
?>