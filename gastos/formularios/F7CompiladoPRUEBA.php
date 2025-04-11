<?php
include_once('../../conexionli.php');
//require('../../fpdf/fpdf.php');
require_once("../../fpdf182/fpdf.php");

require_once("../../fpdi/src/autoload.php");
use \setasign\Fpdi\Fpdi;

$tBruto = 0;
$tNeto 	= 0;
$tIva 	= 0;
$JefeProyecto = '';

	if(isset($_GET['nInforme'])) { $nInf 		= $_GET['nInforme']; 	}
	if(isset($_GET['nInforme'])) { $nInforme 	= $_GET['nInforme'];	}
	if(isset($_GET['Impuesto'])) { $Iva         = $_GET['Impuesto'];    }
	if(isset($_GET['Concepto'])) { $Concepto    = $_GET['Concepto'];    }
	if(isset($_GET['IdProyecto']))  { $IdProyecto   = $_GET['IdProyecto'];  } 

    $pdf=new Fpdi('P','mm','Legal'); 
	$pdf->AddPage();
	$pdf->Image('../../logossdt/formulariosolicitudes2022.png',10,10);
	$pdf->SetFont('Arial','B',10);

	$pdf->Ln(10);
	$pdf->Cell(370,5,$nInforme,0,0,'C');

	$pdf->Ln(12);
	$fd 	= explode('-', $_GET['Fecha']);
	$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
	// $Fecha = date('Y-m-d');
	$pdf->Cell(70,10,$Fecha,0,0);
	$pdf->MultiCell(110,5,utf8_decode($Concepto), 1, "J");


	//$pdf->Output('F7-00001.pdf','I');
	// $NombreFormulario = "F7-".$nInf.".pdf";
	$NombreFormulario = "F7Compilado.pdf";
	$pdf->Output($NombreFormulario,'I'); //Para Descarga
	//$pdf->Output('F7-00001.pdf','D');
	//$pdf->Output('F7-00001.pdf','F');


?>
