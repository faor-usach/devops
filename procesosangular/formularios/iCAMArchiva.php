﻿<?php
	header ('Content-type: text/html; charset=utf-8'); 
	require_once('../../fpdf/fpdf.php');
    include_once("../../conexionli.php");

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../../imagenes/logonewsimet.jpg',10,02,50);
    $this->Image('../../imagenes/cintaceleste.png',0,47,220,250); 
    $this->SetFont('Arial','',15);
    $this->Ln(10);
}

// Pie de página
function Footer()
{
	$this->SetTextColor(200, 200, 200);
    $this->SetFont('Arial','',12);
    $this->Image('../../gastos/logos/logousach.png',195,250,15,23);

    //$this->SetXY(112, -27);
    //$this->Cell(0,4,'UNIVERSIDAD DE SANTIAGO DE CHILE',0,0);
    $this->SetFont('Arial','',10);
    $this->SetXY(10, -23);
    $this->Cell(0,4, utf8_decode('Departamento de Ingeniería Metalúrgia'),0,0,'C');
    $this->SetXY(10, -19);
    $this->Cell(0,4,utf8_decode('Laboratorio de Ensayos e Investigación de Materiales'),0,0, 'C');
    $this->SetXY(10, -14);
    $this->Cell(0,4,utf8_decode('Av. Ecuador 3769, Estación Central - Santiago - Chile'),0,0, 'C');
    $this->SetXY(10, -10);
    $this->Cell(0,4,utf8_decode('Reg. 0201 V.07'),0,0);
    $this->SetXY(10, -10);
    $this->Cell(0,4,utf8_decode('Fono:(+569)23234780, Email: simet@usach.cl / www.simet.cl'),0,0, 'C');

}
}




$accion = '';
if(isset($_GET['CAM'])) 	{ $CAM 	= $_GET['CAM']; 	}
if(isset($_GET['Rev'])) 	{ $Rev 	= $_GET['Rev'];		}
if(isset($_GET['Cta'])) 	{ $Cta 	= $_GET['Cta'];		}
if(isset($_GET['accion'])) 	{ $accion = $_GET['accion'];}



$Mes = array(
    'Enero', 
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
);
$Estado = 'E';
$Rev = '0';
$RAM = 0;
$link=Conectarse();
$bdCAM=$link->query("SELECT * FROM cotizaciones WHERE CAM = '$CAM'");
if($rowCAM=mysqli_fetch_array($bdCAM)){
    $RAM = $rowCAM['RAM'];
    if($rowCAM['Estado']){
        $Estado = $rowCAM['Estado'];
    }
    $Rev = $rowCAM['Rev'];
    /* Encabezado Cotización */
    
    //$pdf = new PDF();
    $pdf=new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',12);

    $fd = explode('-', $rowCAM['fechaCotizacion']);
    $ln = 20;
    $pdf->SetXY(85,$ln);
    $Rev = $rowCAM['Rev'];
    if($Rev < 10){ $Rev = '0'.$Rev; }

    $pdf->Cell(30,4, utf8_decode('COTIZACIÓN CAM Nº '.$CAM.' Rev. '.$Rev),0,0,'C');
    $pdf->SetXY(170,$ln);
    $pdf->Cell(30,4,'Fecha: '.$fd[2].'/'.$fd[1].'/'.$fd[0] ,0,0,'R');

    /* CUADRO ID CLIENTE */
    $ln += 7;
    $pdf->SetXY(10,$ln);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.8);
    $pdf->MultiCell(190,23, '',1,0,'',false);
    $pdf->SetDrawColor(0, 0, 0);

    $bdCli=$link->query("SELECT * FROM clientes WHERE RutCli = '".$rowCAM['RutCli']."'");
    if($rowCli=mysqli_fetch_array($bdCli)){

        $ln += 2;
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY(12,$ln);
        $pdf->Cell(30,4, utf8_decode('Empresa / Cliente'),0,0,'L');
        $pdf->SetXY(58,$ln);
        $pdf->Cell(2,4, utf8_decode(':'),0,0,'L');
        $pdf->SetXY(60,$ln);
        $pdf->Cell(2,4, utf8_decode(strtoupper($rowCli['Cliente'])),0,0,'L');
    
        $ln += 5;
        $pdf->SetXY(12,$ln);
        $pdf->Cell(30,4, utf8_decode('Contacto'),0,0,'L');
        $pdf->SetXY(58,$ln);
        $pdf->Cell(2,4, utf8_decode(':'),0,0,'L');

        $bdCon=$link->query("SELECT * FROM contactoscli WHERE RutCli = '".$rowCAM['RutCli']."' and nContacto = '".$rowCAM['nContacto']."'");
        if($rowCon=mysqli_fetch_array($bdCon)){

            $pdf->SetXY(60,$ln);
            $pdf->Cell(2,4, utf8_decode(($rowCon['Contacto'])).', '.($rowCon['Email']),0,0,'L');
            
            $pdf->SetXY(159,$ln);
            $pdf->Cell(175,4, utf8_decode('Teléfono :'),0,0,'L');
            $pdf->SetXY(177,$ln);
            $pdf->Cell(2,4, utf8_decode(strtoupper($rowCon['Telefono'])),0,0,'L');

        }
    }
    $ln += 5;
    $pdf->SetXY(12,$ln);
    $pdf->Cell(30,4, utf8_decode('Servicio'),0,0,'L');
    $pdf->SetXY(58,$ln);
    $pdf->Cell(2,4, utf8_decode(':'),0,0,'L');
    $pdf->SetXY(60,$ln);
    $pdf->Cell(2,4, utf8_decode($rowCAM['Descripcion']),0,0,'L');

    $ln +=5;
    $pdf->SetXY(12,$ln);
    $pdf->Cell(30,4, utf8_decode('Tiempo estimado de entrega :'),0,0,'L');

    $lnTxt = $rowCAM['dHabiles'].' días hábiles, sujeto a carga de trabajo y previo envío de orden de compra.';
    $pdf->SetXY(60,$ln);
    $pdf->Cell(30,4, utf8_decode($lnTxt),0,0,'L');







    /* Fín Encabezado Cotización */

    $pdf->SetDrawColor(255, 255, 255);
//    $pdf->SetLineWidth(0.8);

    $ln += 14;
    $pdf->SetFont('Arial','',10);
    
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(20,8,'Cantidad',1,'C');
    
    $pdf->SetXY(40,$ln);
    $pdf->MultiCell(115,8,'ITEM',1,'C');

    $pdf->SetXY(155,$ln);
    $pdf->MultiCell(22,8,'',1,'C');
    $pdf->SetXY(155,$ln);
    $pdf->Cell(22,4,'Valor',0,0,'C');
    $pdf->SetXY(155,$ln+4);
    if($rowCAM['Moneda']=='U'){
        $pdf->Cell(22,4,'Unitario UF',0,0,'C');
    }else{
        $pdf->Cell(22,4,'Unitario $',0,0,'C');
    }
    $totalNeto      = 0;
    $totalIva       = 0;
    $totalBruto     = 0;
    $tNet           = 0;
    $tIva           = 0;
    $tBru           = 0;

    $Moneda = 'UF';
    $pdf->SetXY(177,$ln);
    $pdf->MultiCell(23,8,'',1,'C');
    $pdf->SetXY(177,$ln);
    $pdf->Cell(23,4,'Valor',0,0,'C');
    $pdf->SetXY(177,$ln+4);
    if($rowCAM['Moneda']=='U'){
        $pdf->Cell(23,4,'Total UF',0,0,'C');
        $tNet = $rowCAM['NetoUF'];
        $tIva = $rowCAM['IvaUF'];
        $tBru = $rowCAM['BrutoUF'];
    }
    if($rowCAM['Moneda']=='P'){
        $pdf->Cell(23,4,'Total $',0,0,'C');
        $Moneda = '$';
        $tNet = $rowCAM['Neto'];
        $tIva = $rowCAM['Iva'];
        $tBru = $rowCAM['Bruto'];
    }			
    if($rowCAM['Moneda']=='D'){
        $pdf->Cell(23,4,'Total $US',0,0,'C');
        $Moneda = 'US$';
        $tNet = $rowCAM['NetoUS'];
        $tIva = $rowCAM['IvaUS'];
        $tBru = $rowCAM['BrutoUS'];
    }			
    $totalCot 	= 0;
    $nlineas  	= 0;
    $totalPesos	= 0;
    $totalDolar = 0;

    $pdf->SetDrawColor(200, 200, 200);

    $bdIns=$link->query("SELECT * FROM empresa");
    if($rowIns=mysqli_fetch_array($bdIns)){
        $nombreFantasia     = $rowIns['nombreFantasia'];
    }

    $ln += 2;
    $nLineas = 0;
    $bddCAM=$link->query("SELECT * FROM dcotizacion WHERE CAM = '$CAM' Order By nLin Asc");
    while($rowdCAM=mysqli_fetch_array($bddCAM)){
        $pdf->SetFont('Arial','',8);
        $nLineas++;
        if($rowCAM['Moneda']=='U'){
            $totalNeto 	+= $rowdCAM['NetoUF'];
        }
        if($rowCAM['Moneda']=='P'){
            $totalNeto += $rowdCAM['Neto'];
        }
        if($rowCAM['Moneda']=='D'){
            $totalNeto += $rowdCAM['NetoUS'];
        }
        $ln += 6;
        $pdf->SetXY(10,$ln);
        $pdf->Cell(20,6,'',1,0,'C');
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(20,6,$rowdCAM['Cantidad'],0,'C');

        $pdf->SetXY(30,$ln);
        $pdf->Cell(125,6,'',1,0,'C');
        $bdSer=$link->query("SELECT * FROM servicios WHERE nServicio = '".$rowdCAM['nServicio']."'");
        if($rowSer=mysqli_fetch_array($bdSer)){
            $Servicio 	= utf8_decode($rowSer['Servicio']);
            $ValorUF 	= $rowSer['ValorUF'];
        }
        $pdf->SetXY(30,$ln);
        $pdf->MultiCell(125,6,$Servicio,0,'L');

        $pdf->SetXY(155,$ln);
        $pdf->Cell(22,6,'',1,0,'C');
        $pdf->SetXY(155,$ln);
        if($rowCAM['Moneda']=='U'){
            $pdf->MultiCell(22,6,number_format($rowdCAM['unitarioUF'], 2, '.', ','),0,'R');
        }
        if($rowCAM['Moneda']=='D'){
            $pdf->MultiCell(22,6,number_format($rowdCAM['unitarioUS'], 0, '.', ','),0,'R');
        }
        if($rowCAM['Moneda']=='P'){
            $pdf->MultiCell(22,6,number_format($rowdCAM['unitarioP'], 0, '.', ','),0,'R');
        }

        $pdf->SetXY(177,$ln);
        $pdf->Cell(23,6,'',1,0,'C');
        $pdf->SetXY(177,$ln);
        if($rowCAM['Moneda']=='U'){
            $pdf->MultiCell(23,6,number_format($rowdCAM['NetoUF'], 2, '.', ','),0,'R');
        }
        if($rowCAM['Moneda']=='P'){
            $pdf->MultiCell(23,6,number_format($rowdCAM['Neto'], 0, '.', ','),0,'R');
        }
        if($rowCAM['Moneda']=='D'){
            $pdf->MultiCell(23,6,number_format($rowdCAM['NetoUS'], 0, '.', ','),0,'R');
        }

    }
    if($nLineas<11){
        for($i=$nLineas; $i<11; $i++){
            $ln += 6;
            $pdf->SetXY(10,$ln);
            $pdf->Cell(20,6,'',1,0,'C');
            $pdf->SetXY(30,$ln);
            $pdf->Cell(125,6,'',1,0,'C');
            $pdf->SetXY(155,$ln);
            $pdf->Cell(22,6,'',1,0,'C');
            $pdf->SetXY(177,$ln);
            $pdf->Cell(23,6,'',1,0,'C');
        }
    }
    $ln += 6;
    $pdf->SetXY(155,$ln);
    $pdf->Cell(22,6,'Neto '.$Moneda,1,0,'C');
    $pdf->SetXY(177,$ln);
    if($Moneda == 'UF'){
        $pdf->Cell(23,6,number_format($totalNeto, 2, '.', ','),1,0,'R');
    }else{
        $pdf->Cell(23,6,number_format($totalNeto, 0, '.', ','),1,0,'R');
    }
    $Desc = 0;
    if($rowCAM['pDescuento']>0){
        $ln += 6;
        $Desc = $totalNeto * ($rowCAM['pDescuento']/100);
        $pdf->SetXY(155,$ln);
        $pdf->Cell(22,6,number_format($rowCAM['pDescuento'],0,'.',',').'% Desc.',1,0,'C');
        $pdf->SetXY(177,$ln);
        if($Moneda == 'UF'){
            $pdf->Cell(23,6,number_format($Desc, 2, '.', ','),1,0,'R');
        }else{
            $pdf->Cell(23,6,number_format($Desc, 0, '.', ','),1,0,'R');
        }
        $ln += 6;
        $pdf->SetXY(155,$ln);
        $pdf->Cell(22,6,'Sub Total '.$Moneda,1,0,'C');
        $pdf->SetXY(177,$ln);
        if($Moneda == 'UF'){
            $pdf->Cell(23,6,number_format($tNet, 2, '.', ','),1,0,'R');
        }ELSE{
            $pdf->Cell(23,6,number_format($tNet, 0, '.', ','),1,0,'R');
        }
    }
    $ln += 6;
    $pdf->SetXY(155,$ln);
    $pdf->Cell(22,6,'IVA '.$Moneda,1,0,'C');
    $pdf->SetXY(177,$ln);
    if($Moneda == 'UF'){
        $pdf->Cell(23,6,number_format($tIva, 2, '.', ','),1,0,'R');
    }else{
        $pdf->Cell(23,6,number_format($tIva, 0, '.', ','),1,0,'R');
    }

    $ln += 6;
    $pdf->SetXY(155,$ln);
    $pdf->Cell(22,6,'TOTAL '.$Moneda,1,0,'C');
    $pdf->SetXY(177,$ln);
    if($Moneda == 'UF'){
        $pdf->Cell(23,6,number_format($tBru, 2, '.', ','),1,0,'R');
    }else{
        $pdf->Cell(23,6,number_format($tBru, 0, '.', ','),1,0,'R');
    }
    $pdf->SetFont('Arial','',10);

    $ln = $pdf->GetY();
    $Observacion = utf8_decode($rowCAM['Observacion']);
    if($Observacion){
        $lnTxt = 'Observaciónes Generales: ';
            
        $pdf->SetFont('Arial','BU',8);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(175,4,utf8_decode($lnTxt),0,'L');

        $ln = $pdf->GetY() + 2;
        $lnTxt = utf8_decode($rowCAM['Observacion']);
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(175,4,$lnTxt,0,'J');
    }


    $ln = $pdf->GetY()+10;

    $pdf->SetXY(10,$ln);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.8);
    $pdf->MultiCell(190,30, '',1,0,'',false);
    $pdf->SetDrawColor(0, 0, 0);

    $ln++;
    $lnTxt = 'EMITIR ORDEN DE COMPRA CON LOS SIGUIENTES DATOS:';       
    $pdf->SetFont('Arial','B',10);
    $pdf->SetXY(10,$ln);
    $pdf->Cell(190,4,utf8_decode($lnTxt),0,0,'C');

    $ln+=4;
    $lnTxt = 'Razón Social';       
    $pdf->SetFont('Arial','B',8);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.1);
    $pdf->SetXY(10,$ln);
    $pdf->Cell(40,5,utf8_decode($lnTxt),1,0,'C');
    // :
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(50,$ln);
    $pdf->Cell(150,5, utf8_decode('Sociedad de desarrollo tecnológico de la USACH LTDA.'),1,0,'L'); // $rowIns['razonSocial']

    $ln+=5;
    $lnTxt = 'Giro';       
    $pdf->SetFont('Arial','B',8);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.1);
    $pdf->SetXY(10,$ln);
    $pdf->Cell(40,5,utf8_decode($lnTxt),1,0,'C');
    // :
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(50,$ln);
    $pdf->Cell(150,5, utf8_decode('Venta al por menor de libros en comercios especializados'),1,0,'L'); // $rowIns['razonSocial']

    $ln+=5;
    $lnTxt = 'RUT';       
    $pdf->SetFont('Arial','B',8);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.1);
    $pdf->SetXY(10,$ln);
    $pdf->Cell(40,5,utf8_decode($lnTxt),1,0,'C');
    // :
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(50,$ln);
    $pdf->Cell(150,5, $rowIns['RutEmp'],1,0,'L'); 

    $ln+=5;
    $lnTxt = 'Dirección';       
    $pdf->SetFont('Arial','B',8);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.1);
    $pdf->SetXY(10,$ln);
    $pdf->Cell(40,5,utf8_decode($lnTxt),1,0,'C');
    // :
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(50,$ln);
    $pdf->Cell(150,5, utf8_decode($rowIns['Direccion']).', '.utf8_decode($rowIns['Comuna']),1,0,'L'); 

    $ln+=5;
    $lnTxt = 'Contacto';       
    $pdf->SetFont('Arial','B',8);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.1);
    $pdf->SetXY(10,$ln);
    $pdf->Cell(40,5,utf8_decode($lnTxt),1,0,'C');
    // :
    $bdLab=$link->query("SELECT * FROM laboratorio");
    if($rowLab=mysqli_fetch_array($bdLab)){
    }
    $bdDep=$link->query("SELECT * FROM departamentos");
    if($rowDep=mysqli_fetch_array($bdDep)){
    }
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(50,$ln);
    $pdf->Cell(150,5, utf8_decode($rowLab['contactoLaboratorio']. ' // '.$rowIns['Fax'].' // Mail: '.$rowDep['EmailDepto']),1,0,'L'); 

    $ln+=10;
    $lnTxt = 'Envío de muestras y horario:';
    $pdf->SetFont('Arial','BU',8);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'L');

    $ln+=5;
    $lnTxt = utf8_decode('El envío de muestras para ensayos debe ser a la dirección ').utf8_decode($rowLab['entregaMuestras']).' '.utf8_decode($rowDep['nombreDepto']).', '. utf8_decode($rowDep['nomSector']).', '. utf8_decode($rowLab['nombreLaboratorio']).'.';
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(190,4,$lnTxt,0,'L');

    $ln = $pdf->GetY() + 2;
    $lnTxt = '* Horario de Atención:';
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'L');

    $ln = $pdf->GetY() + 2;
    $lnTxt = '                        Lunes a Jueves 9:00 a 13:00 hrs // 14:00 a 18:00 hrs';
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(175,4,$lnTxt,0,'L');

    $ln = $pdf->GetY() + 2;
    $lnTxt = '                        Viernes        9:00 a 13:00 hrs // 14:00 a 16:30 hrs';
    $pdf->SetFont('Arial','',8);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(175,4,$lnTxt,0,'L');

    $pdf->AddPage();
    $ln = 30;

    $ultPos = $pdf->GetY();
    $iNota = 0;
    $bdNotas=$link->query("SELECT * FROM cotizanotas Order By nNota");
    while($rowNotas=mysqli_fetch_array($bdNotas)){
        if($rowNotas['Nota']){
            $iNota++;
            $ultPos = $pdf->GetY();
            $ln = $ultPos + 4;

            if($iNota == 1){
                $lnTxt = 'NOTA: ';
                            
                $pdf->SetFont('Arial','BU',8);
                $pdf->SetXY(10,$ln);
                $pdf->MultiCell(190,4,$lnTxt,0,'L');
                $ln += 4;
    
            }
                    
            $lnTxt = '* '.utf8_decode($rowNotas['Nota']);
            $pdf->SetFont('Arial','',8);
            $pdf->SetXY(10,$ln);
            $pdf->MultiCell(190,2.5,$lnTxt,0,'J');
        }
    }

    $ln = $pdf->GetY() + 5;
    $lnTxt = 'Tiempo de validez: ';
    $pdf->SetFont('Arial','BU',9);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'L');
    
    $ln += 5;
    $lnTxt = '* La oferta económica tiene un tiempo de validez de '.$rowCAM['Validez'].' días.';
    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(10,$ln);
    $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'J');


        $ln += 10;
        $lnTxt = 'Forma de Pago: ';
        $pdf->SetFont('Arial','BU',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(155,4,$lnTxt,0,'L');
        
        $ln += 5;
        $lnTxt = '* Tipo de moneda, en pesos, según valor de la UF correspondiente al día de emisión de la Orden de Compra o Factura';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = '* La forma de pago será ';
        $lnTxt .= 'contra factura:';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(190,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = '* Pago en efectivo o cheque en '.utf8_decode($rowIns['Direccion']).', '.utf8_decode($rowIns['Comuna']).'.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(18,$ln);
        $pdf->MultiCell(190,4,$lnTxt,0,'J');

        $ln += 5;
        $lnTxt  = '* Pago mediante depósito o transferencia a nombre de '.$rowIns['razonSocial'].', '.$rowIns['Banco'].' cuenta corriente '.$rowIns['CtaCte'].' Rut: '.$rowIns['RutEmp'];
        $lnTxt .= '. Enviar confirmación a '.$rowDep['EmailDepto'].'.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(18,$ln);
        $pdf->MultiCell(185,5,utf8_decode($lnTxt),0,'J');

        $ln += 10;
        $lnTxt = '* Clientes nuevos, sólo pago anticipado.';
        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = '* La entrega de resultados y/o informes queda sujeta a regularización de pago.';
        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 7;
        $lnTxt = 'Observaciones: ';
        $pdf->SetFont('Arial','BU',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,$lnTxt,0,'L');
        
        
        $ln += 5;
        $lnTxt = '* Después de 10 días de corridos de la emisión de este informe se entenderá como ';
        $lnTxt .= 'aceptado en su versión final, cualquier modificación posterior tendrá un recargo ';
        $lnTxt .= 'adicional de 1 UF + IVA.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');
        
        $ln += 9;
        $lnTxt = '* Se solicita indicar claramente la identificación de la muestra al momento de la recepción, para no rehacer informes. ';
        $lnTxt .= 'Cada informe rehecho por razones ajenas a SIMET-USACH tiene un costo de 1,00 UF + IVA.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 9;
        $lnTxt = '* Visitas a terreno en Santiago, explicativas de informes de análisis de falla o de retiro de muestras en terreno';
        $lnTxt .= ', tienen un costo adicional de 6,0 UF + IVA, visitas fuera de la región metropolitana consultar.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 9;
        $lnTxt = '* En caso de realizar análisis de falla, el laboratorio se reserva el derecho de modificar el tipo y/o cantidad de ensayos.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 5;
        $lnTxt = '* Al aceptar el servicio, el laboratorio SIMET-USACH mantendrá toda la información generada durante el servicio de manera confidencial, a menos que sea requerida por alguna autoridad legal o reglamentaria.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 9;
        $lnTxt = '* En caso de realizar análisis de falla, el laboratorio se reserva el derecho de modificar el tipo y/o cantidad de ensayos.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(185,4,utf8_decode($lnTxt),0,'J');

        $ln += 7;
        $lnTxt = 'En caso de dudas favor comunicarse con: ';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(10,$ln);
        $pdf->MultiCell(155,4,$lnTxt,0,'J');



        $bdUsr=$link->query("SELECT * FROM usuarios Where usr Like '%".$rowCAM['usrCotizador']."%'");
        if($rowUsr=mysqli_fetch_array($bdUsr)){
            $nomCotizador   = $rowUsr['usuario'];
        }

        $ln += 5;
        $lnTxt = '* Ingeniero '.utf8_decode($rowUsr['usuario']).'; mail: '.$rowUsr['email'].';';
        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(20,$ln);
        $pdf->MultiCell(145,4,$lnTxt,0,'J');

        if('simet.avr@usach.cl' != $rowUsr['email']){
            $ln += 5;
            $lnTxt = '* Ingeniero Alejandro Valdes R.; mail: simet.avr@usach.cl;';
            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY(20,$ln);
            $pdf->MultiCell(145,4,utf8_decode($lnTxt),0,'J');
        }

        if('simet.aca@usach.cl' != $rowUsr['email']){
            $ln += 5;
            $lnTxt = '* Ingeniero Alejandro Castillo A.; mail: simet.aca@usach.cl;';
            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY(20,$ln);
            $pdf->MultiCell(145,4,utf8_decode($lnTxt),0,'J');
        }

        $ln += 5;
        $lnTxt = '* Teléfonos +56 2 2323 47 80 o +56 2 2718 32 21.';
        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(20,$ln);
        $pdf->MultiCell(145,4,utf8_decode($lnTxt),0,'J');

        $ln += 7;
        $lnTxt = 'Quedamos a la espera de su confirmación, saluda cordialmente.';
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(20,$ln);
        $pdf->MultiCell(145,4,utf8_decode($lnTxt),0,'J');

        if($rowUsr['firmaUsr']){
            $pdf->Image('../../ft/'.$rowUsr['firmaUsr'],130,205);
        }
        
        $ln = 228;
        $lnTxt = $nomCotizador;
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(130,$ln);
        $pdf->MultiCell(50,4,utf8_decode($lnTxt),0,'C');

        $ln += 4;
        $lnTxt = 'Laboratorio '.$rowLab['idLaboratorio'];
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(130,$ln);
        $pdf->MultiCell(50,4,utf8_decode($lnTxt),0,'C');


        // Pie de Pagina
        $bdIns=$link->query("SELECT * FROM empresa");
        if($rowIns=mysqli_fetch_array($bdIns)){
            $nombreFantasia     = $rowIns['nombreFantasia'];
        }
        $pdf->SetTextColor(128, 128, 128);



}
/* CUADRO ID CLIENTE - FIN */
    $fechaHoy           = date('Y-m-d');
    $proxRecordatorio   = strtotime ( '+10 day' , strtotime ( $rowCAM['fechaCotizacion'] ) );
    //$proxRecordatorio     = strtotime ( '+10 day' , strtotime ( $fechaHoy ) );
    $proxRecordatorio   = date ( 'Y-m-d' , $proxRecordatorio );

/*
    if($accion == 'Reimprime'){
    }else{
        $enviadoCorreo  = 'on';
        $actSQL="UPDATE Cotizaciones SET ";
        $actSQL.="Estado            ='".$Estado.            "',";
        $actSQL.="enviadoCorreo     ='".$enviadoCorreo.     "',";
        $actSQL.="proxRecordatorio  ='".$proxRecordatorio.  "',";
        $actSQL.="fechaEnvio        ='".$fechaHoy.          "'";
        $actSQL.="WHERE CAM         = '".$CAM."'and Rev = '".$Rev."' and Cta = '".$Cta."'";
        $bdCot=$link->query($actSQL);
    }
*/

    $Rev = $rowCAM['Rev'];
    $nSolicitud = $rowCAM['nSolicitud'];
$link->close();

$NombreFormulario = "CAM-".$CAM." Rev-0".$Rev.".pdf";
//$NombreFormulario = "CAM-".$CAM.".pdf";
$agnoActual = date('Y');
$vDir = '../Data/AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/SOL-'.$nSolicitud.'/';
//$pdf->Output($NombreFormulario,'I'); //Muestra en el Navegador
// $pdf->Output($NombreFormulario,'F'); //Guarda en un Fichero
// $pdf->Output($vDir.$NombreFormulario,'F'); //Guarda en un Fichero
$pdf->Output($NombreFormulario,'D'); //Para Descarga
// copy($NombreFormulario, 'Y://AAA/Archivador-2020/CAMs/'.$NombreFormulario);
// copy($NombreFormulario, $vDir.$NombreFormulario);
unlink($NombreFormulario);
//$pdf->Output();
// header("Location: ../../facturacion/formSolicitaFactura.php?nSolicitud=8941&RutCli=76342280-1");
?>
