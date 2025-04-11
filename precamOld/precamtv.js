        var app = angular.module('myApp', []);

			app.filter('numberWithDots', function() {
				return function(x) {
				if (x == null) {
					return null;
				}
			
				if (x == undefined) {
					return undefined;
				}
			
				let str = '';
				let rest, floor;
			
				do {
					rest = x % 1000;
					floor = Math.floor(x / 1000);
			
					str = (floor == 0) ? rest + str : '.' + x.toString().slice(-3) + str;
			
					x = Math.floor(x / 1000);
				} while (x > 0);
			
				return str;
				}
		  	});

            app.run(function($rootScope) {
                $rootScope.mInventario 			= true;
				$rootScope.tipoEstado = [
					{
						codEstado:"Bueno",
						descripcion:"Bueno"  
					},{
						codEstado:"Malo",
						descripcion:"Mal Estado"
					},{
						codEstado:"Prestado",
						descripcion:"Prestado"
					},{
						codEstado:"Baja",
						descripcion:"Dado de Baja"
					}
					];
		
            });
            
            app.controller('ctrlPreCam', function($scope, $http, $interval) { 
				$scope.myNumber = 17000;
				$scope.theTime = new Date().toLocaleTimeString();
				
				
                $scope.leerPreCAM = function(){ 
					//alert("Entra...");
                    $http.post("leerbd.php",{
						accion: "leerPreCAM"
					})
                    .then(function (response) {
						//document.getElementById('search').focus();
						$scope.dataPreCAM = response.data.records;
						//alert("Sale "+$scope.dataPreCAM);
					});        
                };
				
				$interval(function(){
					$scope.theTime = new Date().toLocaleTimeString();
					$scope.leerPreCAM();
				}, 1000)
				

                

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
                
                $scope.putThings = function(){ 
					$http.post("leerSubCat.php",{IDcat:$scope.IDcat})
                    .then(function (response) {
                    	$scope.dataSubCat = response.data.records;
			        }).error(function (error) {
			            alert(error);
			        });
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
