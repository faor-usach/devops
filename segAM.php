<?php
	session_start(); 
?>
<!doctype html>
 
 <html lang="es">
 <head>
	<meta charset="utf-8">
   	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>

<body ng-app="myApp" ng-controller="ctrlCAM" ng-init="loadCAM('<?php echo $_GET['CAM']; ?>', '<?php echo $_GET['RAM']; ?>', '<?php echo $_GET['accion']; ?>' )" ng-cloak>
	<div class="container-fluid mb-2 mt-2">
		<div class="row">
			<div class="col-sm-8">
				<div class="card" ng-cloak>
					<div class="card-header {{bColor}}">
						<h5>Seguimiento AM CAM {{CAM}} - RAM {{RAM}}     (Ing. {{usrResponzable}})</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-2">
								<b>Cliente:</b>
							</div>
							<div class="col-sm-10">
								<h5 class="card-title">	<input type="text" class="form-control" ng-model="Cliente" readonly ></h5>
							</div>

							<div class="col-sm-2">
								<b>Atención:</b>
							</div>
							<div class="col-sm-10">
								<h5 class="card-title">	{{Contacto}} </h5>
							</div>

							<div class="col-sm-2 mt-2">
								Orden de Compra:
							</div>
							<div class="col-sm-3 mt-2">
								<input type="text" class="form-control" ng-model="nOC" ng-change="activarSubidaOC()" >
							</div>
							<div class="col-sm-2 mt-2" ng-show="activaUp">
								Documento :
							</div>
							<div class="col-sm-5 mt-2"  ng-show="activaUp">
								<input id="archivosSeguimiento" ng-model="archivosSeguimiento" multiple type="file"> {{archivosSeguimiento}}
							</div> 
							<div ng-show="clienteHES">
								<div class="row">
									<div class="col-sm-2 mt-2">
										HES: 
									</div>
									<div class="col-sm-3 mt-2">
										<input type="text" class="form-control" ng-model="HES" ng-change="activarSubidaHES()" >
									</div>
									<div class="col-sm-2 mt-2" ng-show="activaHes">
										Documento :
									</div>
									<div class="col-sm-5 mt-2"  ng-show="activaHes"> 
										<input id="archivosSeguimientoHES" ng-model="archivosSeguimientoHES" multiple type="file"> {{archivosSeguimientoHES}}
									</div> 
								</div>
							</div>
							<hr class="mt-2">
							<div class="col-sm-2 mt-2">
								Estado Informe:
							</div>
							<div class="col-sm-5 mt-2">
								<div ng-show="informeUP == 'on'">
									<b>Informe Subido</b>
								</div>
							</div>
							<div class="col-sm-2 mt-2">
								Fecha :
							</div>
							<div class="col-sm-3 mt-2">
								<input type="date" class="form-control" ng-model="fechaInformeUP" >
							</div>

							<div class="col-sm-2 mt-2">
								Tipo CAM:
							</div>
							<div class="col-sm-5 mt-2">
								<div ng-show="Fan > 0">
									<b>CLON {{Fan}} de  RAM {{RAM}}</b>
								</div>
								<div ng-show="Fan == 0">
									<b>Cotización Base</b>
								</div>
							</div>

						</div>
					</div>
					<div class="card-footer">
						<a href="#" ng-click="guardarSeguimientoRosado()" class="btn btn-primary">Guardar Seguimiento</a>
						<a href="#" ng-if="cColor == 'Amarillo'" ng-click="retocederSeguimientoRosado()" class="btn btn-danger">Retroceder AM a paso Anterior</a>
						<a href="#" ng-if="cColor == 'Rosado'" ng-click="retocederATerminadosSinInforme()" class="btn btn-danger">Retroceder AM Informes No Subidos</a>
						<a href="plataformaErp.php" class="btn btn-primary">Volver</a>
					</div>
                </div>
            </div>
            <div class="col-sm-4">
				<div class="card">
					<div class="card-header {{bColor}}">
						<b>Ordenes de Compras Subidas</b>
					</div>
                    <?php
                        $tr = "bVerde";
                        $agnoActual = date('Y'); 
                        $ruta = 'Data/AAA/LE/FINANZAS/'.$agnoActual.'/SOLICITUD-FACTURA/octmp'; 
                        $muestraCAM = 'SI';

                        $gestorDir = opendir($ruta);
                        while(false !== ($nombreDir = readdir($gestorDir))){
                            if($nombreDir != '.' and $nombreDir != '..'){
                                $fd = explode('-', $nombreDir);
                                if(count($fd) > 1){
                                    $fd = explode('.', $fd[1]);
                                }
                                if($fd[0] ==  $_GET['CAM']){
                                    echo $nombreDir.'<br>';
                                    if(file_exists($ruta)){
                                        copy($ruta.'/'.$nombreDir, 'tmp/'.$nombreDir);
                                    } 
                                    ?>
                                    	{{existeOC()}}
                                    <?php
                                    if($muestraCAM == 'SI'){?>
                                        <div class="row">
										    <div class="col-sm-4 m-1">
											    <a style="margin-top: 5px;" class="btn btn-warning" role="button" href="procesosangular/formularios/iCAM.php?CAM={{CAM}}&Rev=0&Cta=0&accion=Reimprime" title="Imprimir Cotización"><i class="far fa-file-pdf"></i>CAM {{CAM}}</a>
										    </div>
									    </div>
                                        <?php
                                        $muestraCAM = 'NO';
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-4 m-1">
                                            <a href="<?php echo 'tmp/'.$nombreDir; ?>" class="btn btn-primary  btn-block" target="_blank" role="button">
                                                <b><?php echo $nombreDir; ?></b>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                    ?>

                    
                </div>
            </div>
        </div>
    </div>





    
	<script type="text/javascript" src="angular/angular.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <!-- <script src="bootstrap/js/bootstrap.min.js"></script> -->
    <script src="erp.js"></script>

</body>
</html>