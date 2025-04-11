<?php 	
	session_start(); 
	//header('Content-Type: text/html; charset=iso-8859-1');
	header('Content-Type: text/html; charset=utf-8'); 
	date_default_timezone_set("America/Santiago");
	include_once("../conexionli.php"); 
	$Rev 	= 0;
	$idPreCAM			= $_GET['idPreCAM'];
	$accion 			= $_GET['accion'];
	$fechaRegPreCAM		= date('Y-m-d');
	$encNew 			= 'Si';
	$usrResponsable		= '';
	$Actividad			= '';
	$Correo				= '';
	$seguimiento		= '';
	
	if($idPreCAM == 0){
		$link=Conectarse();
		$bddCot=$link->query("Select * From precam Order By idPreCAM Desc");
		if($rowdCot=mysqli_fetch_array($bddCot)){
			$idPreCAM = $rowdCot['idPreCAM'] + 1;
		}else{
			$idPreCAM = 1;
		}
		$link->close();
		$fechaPreCAM	= date('Y-m-d');
	}else{
		$link=Conectarse();
		$bdCot=$link->query("SELECT * FROM precam Where idPreCAM = '".$idPreCAM."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$Correo				= $rowCot['Correo'];
			$fechaPreCAM		= $rowCot['fechaPreCAM'];
			$usrResponsable		= $rowCot['usrResponsable'];
			$seguimiento		= $rowCot['seguimiento'];
		}
		$link->close();
		$encNew = 'No';
	}
?>
<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">
<script src="../angular/angular.min.js"></script>

<body ng-app="myApp" ng-controller="ctrlPreCam" ng-init="loadPreCam('<?php echo $idPreCAM; ?>')">

        <div class="container">
            <form name="form" action="preCAM.php" method="post">
                <table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
                    <tr>
                        <td colspan="3" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; "><img src="../imagenes/poster_teachers.png" width="50" align="middle"> <span style="color:#FFFFFF; font-size:25px; font-weight:700;"> Registro de PreCAM
                            <div id="botonImagen">
                                    <?php 
                                        if($accion=='Vacio'){
                                            $prgLink = '../plataformaErp.php';
                                            $accion = 'Agrega';
                                        }else{
                                            $prgLink = 'preCAM.php';
                                        }
                                        echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
                                    ?>
                        </div>
                            </span>
                    </td></tr>
                    <tr>
                        <td colspan="3" class="lineaDerBot">
                            <strong style=" font-size:20px; font-weight:700; margin-left:10px;">
                                PreCAM N° {{idPreCAM}}
                                <?php
                                    if($accion == 'Actualizar' or $accion == 'Borrar'){ ?>
                                        <input name="idPreCAM" 	id="idPreCAM" type="hidden" value="<?php echo $idPreCAM; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" />
                                        <?php
                                    }
                                    if($accion == 'Agrega'){ 
                                        ?>
                                        <input name="idPreCAM" 	id="idPreCAM" type="text" value="<?php echo $idPreCAM; ?>" size="20" maxlength="20" style="font-size:18px; font-weight:700;" readonly />
                                        <?php
                                    }
                                ?>
                                <input name="accion" 				id="accion" 			type="hidden" value="<?php echo $accion; ?>">
                                <input name="fechaPreCAM" 			id="fechaPreCAM" 		type="hidden" value="<?php echo $fechaPreCAM; ?>">
                            </strong>										
                        </td>
                    </tr>
                    <tr>
                    <td colspan="3">&nbsp;
                    
                    </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
                                <tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
                                    <td colspan="2">Registro </td>
                                </tr>
                                <tr>
                                    <td class="p-2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="usrResponsable"> Responsable </label><br>
                                                <select class="form-control" name="usrResponsable" id="usrResponsable" ng-model="usrResponsable">
                                                    <option ng-repeat="x in dataUsrs" value="{{x.usr}}">{{x.usuario}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="seguimiento"> Seguimiento </label><br>
                                                <select class 	= "form-control"
                                                    ng-change   = "fechaSeguimiento()"
                                		            ng-model	= "seguimiento" 
                                    	            ng-options 	= "seguimiento.codEstado as seguimiento.descripcion for seguimiento in estadoSeguimiento" >
                                	                <option value="seguimiento">{{seguimiento}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="fechaPreCAM">  Inicio </label><br>
                                                <input class="form-control" ng-model="fechaPreCAM" type="date">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="fechaSeg">  Seguimiento </label><br>
                                                <input class="form-control" ng-model="fechaSeg" type="date">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="Tipo"> Tipo </label><br>
                                                <select class 	= "form-control"
                                		            ng-model	= "Tipo" 
                                    	            ng-options 	= "Tipo.codEstado as Tipo.descripcion for Tipo in tipoTipo" >
                                	                <option value="Tipo">{{Tipo}}</option>
                                                </select>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="3" class="lineaDerBot">
                        
                        <table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
                            <tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
                                <td width="100%" colspan="2">
                                    Registro Correo </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="lineaDerBot">
                                    <textarea class="form-control" ng-model="Correo" name="Correo" id="Correo" cols="100" rows="20"></textarea>
                                </td>
                            </tr>

                        </table>
                </td>
            </tr>
            <tr>
                    <td colspan="3" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
                        <?php
                            if($accion == 'Guardar' || $accion == 'Agregar' || $accion == 'Actualizar'){?>
                                <div id="botonImagen">
                                    <button class="btn btn-primary" ng-click="grabarPreCam()" type="button" title="Guarda, Crea PreCAM">
                                        <img src="../gastos/imagenes/guardar.png" width="55" height="55">
                                    </button>
                                </div>
                                <?php
                            }
                            if($accion == 'Borrar'){?>
                                <div id="botonImagen" class="p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button class="btn btn-primary" ng-click="borrarPreCam()" type="button" title="Cerrar PreCAM">
                                                Cerrar PreCAM
                                            </button>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="alert alert-success" ng-show="msgPre">
                                                <strong>Atención!</strong> PreCAM cerrada.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </td>
            </tr>
            </table>
            </form>
        </div>

    <script src="../jsboot/bootstrap.min.js"></script>	
    <script src="precam.js"></script> 
</body>