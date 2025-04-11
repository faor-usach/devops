        var app = angular.module('myApp', []);

            app.run(function($rootScope) {
                $rootScope.idPreCAM		        = 0;
                $rootScope.Tipo		            = 'CAM';
                $rootScope.seguimiento		    = 'off';
                $rootScope.Correo		        = '';
                $rootScope.fechaPreCAM	        = new Date();
                $rootScope.msgPre 				= false;
				$rootScope.estadoSeguimiento = [
					{
						codEstado:"on",
						descripcion:"Con Seguimiento"  
					},{
						codEstado:"off",
						descripcion:"Sin Seguimiento"
					}
					];
				$rootScope.tipoTipo = [
					{
						codEstado:"CAM",
						descripcion:"CAM"  
					},{
						codEstado:"CAR",
						descripcion:"Caractización"
					},{
                        codEstado:"INFO",
                        descripcion:"INFO"
                    },{
                        codEstado:"Rev",
                        descripcion:"Revisión"
                    }
					];
		
            });
            
            app.controller('ctrlPreCam', function($scope, $http) { 
                $scope.leerPreCAM = function(){ 
                    $http.post("leerbd.php",{
						accion: "leerPreCAM"
					})
                    .then(function (response) {
						//document.getElementById('search').focus();
						$scope.dataPreCAM = response.data.records;
					});        
                };

                $scope.leerUsrs = function(){ 
					$http.post("bdPreCam.php",{accion: "leerUsuarios"})
                    .then(function (response) {
                    	$scope.dataUsrs = response.data.records;
                    }, function(error) {
                        $scope.errors = error.message;
                        alert(error);            
			        });
                };

                
                $scope.leerUsrs();

                $scope.loadPreCam = function(idPreCAM){
                    // alert(idPreCAM);
                    $scope.idPreCAM = idPreCAM;
		            $http.post('bdPreCam.php',{
                        idPreCAM:   $scope.idPreCAM,
                        accion:     "leerDatos"
                    })
		            .then(function (response) {
		                $scope.idPreCAM         = response.data.idPreCAM;
		                $scope.usrResponsable   = response.data.usrResponsable;
		                $scope.Correo           = response.data.Correo;
		                $scope.seguimiento      = response.data.seguimiento;
		                $scope.Tipo             = response.data.Tipo;
                        if($scope.idPreCAM == undefined){
							$scope.idPreCAM = idPreCAM;
						}
                        if($scope.Tipo == undefined){
                            $scope.Tipo         = 'CAM';
                        }
                        if($scope.seguimiento == undefined){
                            $scope.seguimiento  = 'off';
                        }
                        if($scope.Correo == undefined){
                            $scope.Correo  = '';
                        }
                        $scope.fechaPreCAM      = new Date(response.data.fechaPreCAM.replace(/-/g, '\/').replace(/T.+/, ''));
                        $scope.fechaSeg         = new Date(response.data.fechaSeg.replace(/-/g, '\/').replace(/T.+/, ''));
			        }).error(function (error) {
			            alert(error);
			        });

                }

                $scope.fechaSeguimiento = function(){
                    if($scope.seguimiento == 'off'){
                        $scope.fechaSeg = '';
                    }else{
                        $scope.fechaSeg = new Date();
                    };
                }

                $scope.borrarPreCam = function(){
		            $http.post('bdPreCam.php',{
                        idPreCAM:           $scope.idPreCAM,
                        accion:             "cerrarPreCAM" 
                    })
		            .then(function (response) {
						alert('Cerrado...');
                        window.location.href = 'preCAM.php';

			        }).error(function (error) {
			            alert(error);
			        });
				}

                $scope.grabarPreCam = function(){
					if($scope.fechaSeg == ''){
						fechaSeg = '0000-00-00';
                    }else{
						fechaSeg = $scope.fechaSeg;
                    }
					if($scope.fechaSeg == undefined){
						fechaSeg = '0000-00-00';
                    }
					// alert('Entra...'+$scope.idPreCAM+' '+fechaSeg);
		            $http.post('bdPreCam.php',{
                        idPreCAM:           $scope.idPreCAM,
                        usrResponsable:     $scope.usrResponsable,
                        Correo:             $scope.Correo,
                        seguimiento:        $scope.seguimiento,
                        Tipo:               $scope.Tipo,
                        fechaPreCAM:        $scope.fechaPreCAM,
                        fechaSeg:           fechaSeg,
                        accion:             "guardarDatos" 
                    })
		            .then(function (response) {
                        alert('Grabado...');
                        window.location.href = 'preCAM.php';
			        }).error(function (error) {
			            alert(error);
			        });
                }

                $scope.leerDependencias = function(){
                    $http.get("leerDep.php")
                    .then(function (response) {$scope.dataDep = response.data.records;});        
                };
                $scope.leerCategorias = function(){ 
                    $http.get("leerCat.php")
                    .then(function (response) {$scope.dataCat = response.data.records;});        
                };
                $scope.leerSubCategorias = function(){ 
					//alert($scope.IDcat+' '+$scope.IDsub);
					$scope.putThings();
					/*
                    $http.get("leerSub.php")
                    .then(function (response) {$scope.dataSubCat = response.data.records;}); 
					*/       
                };
                

                $scope.selDependencia = function(nDep) {
		            $http.post('buscarDependencia.php',{Dependencia:$scope.Dependencia})
		            .then(function (response) {
		                $scope.nDep           	= response.data.nDep;
		                $scope.Dependencia      = response.data.Dependencia;
			        }).error(function (error) {
			            alert(error);
			        });
                }


		        $scope.eliminarPublicacion  = function(){
					$http.post('actualizarArticulo.php',{
						IDart			: $scope.IDart,
						accion			: "EliminarArticulo"
					}) 
					.then(function (response) {
						$scope.cerrarFormularioArticulos();
						$scope.leerInventario();
					}).error(function (error) {
						alert(error);
					});
				}
		        $scope.guardarPublicacion  = function(){
					//alert($scope.IDart+' '+$scope.IDcat+' '+$scope.IDsub+' '+$scope.SubCategoria+' '+$scope.Articulo+' '+$scope.fechaInventario+' '+$scope.Estado+' '+$scope.codInterno+' '+$scope.numSerie);
					//alert($scope.nUnidades+' '+$scope.nDep);
					//alert($scope.usrResponsable);
					$http.post('actualizarArticulo.php',{
						IDart			: $scope.IDart,
						IDcat			: $scope.IDcat,
						IDsub			: $scope.IDsub,
						nDep			: $scope.nDep,
						usrResponsable	: $scope.usrResponsable,
						numSerie		: $scope.numSerie,
						codInterno		: $scope.codInterno,
						Dependencia		: $scope.Dependencia,
						Observacion		: $scope.Observacion,
						Articulo		: $scope.Articulo,
						fechaInventario	: $scope.fechaInventario,
						Estado			: $scope.Estado,
						Marca 			: $scope.Marca,
						Modelo 			: $scope.Modelo,
						Ubicacion 		: $scope.Ubicacion,
						nUnidades 		: $scope.nUnidades,
						Factura 		: $scope.Factura,
						Financiamiento 	: $scope.Financiamiento,
						accion			: "Grabar"
					}) 
					.then(function (response) {
						$scope.cerrarFormularioArticulos();
						$scope.leerInventario();
					}).error(function (error) {
						alert(error);
					});
					
				}
		        $scope.guardarNuevoArticulo  = function(){
					//alert($scope.IDart+' '+$scope.IDcat+' '+$scope.IDsub+' '+$scope.SubCategoria+' '+$scope.Articulo+' '+$scope.fechaInventario+' '+$scope.Estado+' '+$scope.codInterno+' '+$scope.numSerie);
					//alert($scope.nUnidades+' '+$scope.nDep);
					//alert($scope.usrResponsable);
					$http.post('actualizarArticulo.php',{
						IDart			: $scope.IDart,
						IDcat			: $scope.IDcat,
						IDsub			: $scope.IDsub,
						nDep			: $scope.nDep,
						usrResponsable	: $scope.usrResponsable,
						numSerie		: $scope.numSerie,
						codInterno		: $scope.codInterno,
						Dependencia		: $scope.Dependencia,
						Observacion		: $scope.Observacion,
						Articulo		: $scope.Articulo,
						fechaInventario	: $scope.fechaInventario,
						Estado			: $scope.Estado,
						Marca 			: $scope.Marca,
						Modelo 			: $scope.Modelo,
						Ubicacion 		: $scope.Ubicacion,
						nUnidades 		: $scope.nUnidades,
						Factura 		: $scope.Factura,
						Financiamiento 	: $scope.Financiamiento,
						accion			: "GrabarNuevoArticulo"
					}) 
					.then(function (response) {
						$scope.cerrarFormularioArticulos();
						$scope.leerInventario();
					}).error(function (error) {
						alert(error);
					});
					
				}

		        $scope.nuevoArticulo  = function(){ 
		        	//alert('Art.'+$scope.IDart);
					
					$scope.IDart = "";
		            $scope.formNuevoArticulo = true;
		            $http.post('buscarArticulo.php',{
						IDart:$scope.IDart,
						accion: "nuevoArt"
					}) 
		            .then(function (response) {
						//document.getElementById('Articulo').focus();
						$scope.menuLateral 	= false;
						$scope.menuSuperior = false;

		                $scope.IDart           	= response.data.IDart;
						//alert(response.data.IDart);
						$scope.IDcat           	= '';
						$scope.IDsub           	= '';
						$scope.Articulo        	= 'ARTICULO NUEVO';
						$scope.Dependencia      = '';
						$scope.nDep      		= '';
						$scope.fechaInventario  = new Date();
						$scope.numSerie  		= '';
						$scope.codInterno  		= '';
						$scope.Marca			= '';						
						$scope.Modelo			= '';						
						$scope.Ubicacion		= '';						
						$scope.Factura			= '';						
						$scope.Financiamiento	= '';						
						$scope.Observacion		= '';						
						$scope.Estado			= 'Bueno';						
						$scope.leerDependencias();
						$scope.leerCategorias();
						$scope.leerSubCategorias();
						
						
						

			        }).error(function (error) {
			            alert(error);
			        });
		        }

		        $scope.editarArticulos  = function(id){ 
		        	//alert('Art.'+id);
		            $scope.formPublica = true;
		            if(id > 0){
		            	$scope.Titulo        	= 'Buscando'+id;

		                $http.post('buscarArticulo.php',{
							IDart:id,
							accion: "buscarArt"
						}) 
		                .then(function (response) {
							//document.getElementById('Articulo').focus();
							$scope.menuLateral 		= false;
							$scope.menuSuperior 	= false;

		                    $scope.IDart           	= response.data.IDart;
		                    $scope.IDcat           	= response.data.IDcat;
		                    $scope.IDsub           	= response.data.IDsub;
		                    $scope.Articulo        	= response.data.Articulo;
		                    $scope.Dependencia      = response.data.Dependencia;
		                    $scope.nDep      		= response.data.nDep;
							$scope.fechaInventario  = new Date(response.data.fechaInventario.replace(/-/g, '\/').replace(/T.+/, ''));
							$scope.numSerie  		= response.data.numSerie;
							$scope.codInterno  		= response.data.codInterno;
							$scope.Marca  			= response.data.Marca;
							$scope.Modelo  			= response.data.Modelo;
							$scope.Ubicacion  		= response.data.Ubicacion;
							$scope.Estado  			= response.data.Estado;
							$scope.Observacion  	= response.data.Observacion;
							$scope.Factura  		= response.data.Factura;
							$scope.usrResponsable  	= response.data.usrResponsable;
							$scope.Financiamiento  	= response.data.Financiamiento;
                			
                			$scope.leerDependencias();
                			$scope.leerCategorias();
                			$scope.leerSubCategorias();
                			
			            }).error(function (error) {
			                alert(error);
			            });
		            }else{
		                $scope.Articulo = 'Nueva Publicación...';
		                $scope.IDart = 0;
		            }

		        }


				$scope.verColorLinea = function(Estado){
					retorno = {'verde-class': true};
					
					if(Estado == 'Baja'){ // Bueno
						retorno = {'azul-class': true};
					}
					if(Estado == 'Precaucion'){ // Malo
						retorno = {'amarillo-class': true};
					}
					if(Estado == 'Atrazado'){ // Malo
						retorno = {'rojo-class': true};
					}
					if(Estado == 'ND'){ // Malo
						retorno = {'rojo-class': true};
					}
					if(Estado == 'SinDevolver'){ // Malo
						retorno = {'rojo-class': true};
					}
					
					return retorno;
				}
				
				$scope.seleccion = function(filtro){
					$scope.search = filtro;
				}
		

            });
