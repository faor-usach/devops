    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.btnActualizar    = false;
        $rootScope.btnGuardar       = false;
        $rootScope.btnEliminar      = false;

        $rootScope.HES              = "on";
        $rootScope.tipoHes = [
            {
                codHes:"on",
                descripcion:"Requiere HES"
            },{
                codHes:"off",
                descripcion:"Sin HES"
            }
            ];

    });
    app.controller('CtrlClientes', function($scope, $http) {

        $scope.borrarDataCliente = function(){
                $http.post("dataClientes.php",{
                                                    RutCli: $scope.RutCli,
                                                    accion: "borrarDataCliente"
                                                })
                    .then(function(response){
                        alert('Cliente Eliminado...');
                        window.location.href = 'clientes.php';

                        // alert($scope.Cliente);
                }, function(error) {
                    $scope.errors = error.message;
                });

        }
        $scope.loadDataCliente = function(Rut){
            $scope.RutCli = Rut;
            $scope.rutRes = 'Rut '+$scope.RutCli;
            if(Rut != ''){
                $http.post("dataClientes.php",{
                                                    RutCli: Rut,
                                                    accion: "loadDataCliente"
                                                })
                    .then(function(response){
                        // alert('Rut '+response.data.RutCli);
                        if(response.data.RutCli == undefined){
                            $scope.btnActualizar    = true;
                            $scope.btnGuardar       = true;
                            $scope.btnEliminar      = false;
                    

                        }else{
                            $scope.RutCli   = response.data.RutCli;
                            $scope.Cliente  = response.data.Cliente;
                            $scope.Estado   = response.data.Estado;
                            $scope.Publicar = response.data.Publicar;
                            $scope.cFree    = response.data.cFree;
                            $scope.Docencia = response.data.Docencia;
                            $scope.Giro     = response.data.Giro;
                            $scope.Direccion= response.data.Direccion;
                            $scope.Telefono = response.data.Telefono;
                            $scope.Celular  = response.data.Celular;
                            $scope.Msg      = response.data.Msg;
                            $scope.Sitio    = response.data.Sitio;
                            $scope.HES      = response.data.HES;
        
                            $scope.btnActualizar = true;
                            $scope.btnGuardar       = true;
                            $scope.btnEliminar      = true;
                            $scope.listarContactos();

                        }
    
                        // alert($scope.Cliente);
                }, function(error) {
                    $scope.errors = error.message;
                });

            }
        }

        $scope.verificaExisteCliente = function(){
            $http.post("dataClientes.php",{
                                                RutCli: $scope.RutCli,
                                                accion: "verificaExisteCliente"
                                            })
                .then(function(response){
                    $scope.btnActualizar = true;
                    $scope.btnGuardar       = true;
                    $scope.btnEliminar      = true;

                    // $scope.RutCli   = response.data.RutCli;
                    $scope.loadDataCliente($scope.RutCli);
                    // alert($scope.Cliente);
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.listarContactos = function(){
            $http.post("dataClientes.php", {
                RutCli: $scope.RutCli,
                accion: "listarContactos"
            })
            .then(function(response){  
                $scope.dataContactos = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });

        }

        $scope.grabarDataCliente = function(){
            // alert('RutCliente...'+$scope.RutCli+' '+$scope.Cliente);
            $http.post('dataClientes.php',{
                RutCli      : $scope.RutCli,
                Cliente     : $scope.Cliente,
                Estado      : $scope.Estado,
                Publicar    : $scope.Publicar,
                cFree       : $scope.cFree,
                Docencia    : $scope.Docencia,
                Giro        : $scope.Giro,
                Direccion   : $scope.Direccion,
                Telefono    : $scope.Telefono,
                Celular     : $scope.Celular,
                Msg         : $scope.Msg,
                Sitio       : $scope.Sitio,
                HES         : $scope.HES,
                accion:     "grabarDataCliente"
            })
            .then(function(response){  
                alert('Guardado correctamente...');
                $scope.btnGuardar       = true;
                $scope.btnEliminar      = true;
                window.location.href = 'clientes.php';

            }, function(error) {
                alert(error);
            });
        }    

    });
