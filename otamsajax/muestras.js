    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.Estado       = "P";
        $rootScope.res          = '';
        $rootScope.Ref          = 'SR'; 
        $rootScope.cEnsayos     = 0;
        $rootScope.regMuestra   = false; 
        $rootScope.formMuestra  = false; 
        $rootScope.msgGraba     = false;
        $rootScope.conRef       = true;
        $rootScope.formularioTr = false;
        $rootScope.formularioQu = false;
        $rootScope.formularioCh = false;
        $rootScope.formularioDo = false;
        $rootScope.formularioDu = false;

        $rootScope.CAM          = '';

        $rootScope.conEnsayo  = "off";
        $rootScope.ensayar = [
            {
                codEnsayo:"on",
                descripcion:"Si"
            },{
                codEnsayo:"off",
                descripcion:"No"
            }
            ];

        $rootScope.selMedicion = [
            {
                tpMedicion:"Medi",
                descripcion:"Medición"
            },{
                tpMedicion:"Perf",
                descripcion:"Perfil"
            }
            ];
        $rootScope.tpMedicion  = "Medi";

        $rootScope.selEquipo = [
            {
                codequipo:"",
                descripcion:""
            },{
                codequipo:"Tr-30",
                descripcion:"Tr-30"
            },{
                codequipo:"Tr-100",
                descripcion:"Tr-100"
            }
            ];

        $rootScope.equipo  = "";

        $rootScope.selReferencia = [
            {
                Ref         : "SR",
                descripcion : "SR"
            },{
                Ref         : "CR",
                descripcion : "CR"
            }
            ];

        $rootScope.codRef  = "SR";

        $rootScope.Taller  = "off";
        $rootScope.RAM = 0;
        $rootScope.ServicioTaller = [
            {
                codTaller:"on",
                descripciontaller:"Si"
            },{
                codTaller:"off",
                descripciontaller:"No"
            }
            ];

    });

    app.controller('CtrlMuestras', function($scope, $http) {

        $scope.buscarDataMuestra = function(idItem){
            // alert(idItem);
            $http.post("leerMuestras.php", {
                                    idItem: idItem, 
                                    accion: "buscarDataMuestra"
                                })   
            .then(function(response){  
                $scope.idItem       = response.data.idItem;
                $scope.idMuestra    = response.data.idMuestra;
                $scope.conEnsayo    = response.data.conEnsayo;
                $scope.Taller       = response.data.Taller;
                $scope.nSolTaller   = response.data.nSolTaller;
                $scope.Objetivo     = response.data.Objetivo;
                $scope.desplegarEnsayos();
            }, function(error) {
                $scope.errors = error.message;
            });

        }
        
        $scope.desplegarEnsayos = function(){
            // alert($scope.idItem);
            $http.post("leerMuestras.php", {
                idItem: $scope.idItem,
                accion: "desplegarEnsayos"
            })   
            .then(function(response){  
                $scope.dataEnsayos = response.data.records;

            }, function(error) {
                $scope.errors = error.message;
            });

        }

        $scope.loadMuestras = function(r, c, idItem){
            // alert('RAM '+r+' CAM '+c)
            $scope.RAM = r;
            $scope.CAM = c;
            $scope.idItem = idItem;
            // alert($scope.idItem);

            $http.post("leerMuestras.php", {RAM: r, accion: "lectura"})   
            .then(function(response){  
                $scope.regMuestras = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.conReferencia = function(){
            alert('Referencia');
        }

        $scope.verColorLineaPAM = function(m){
            mColor = 'Blanco';
            retorno = {'verde-class': true};
            return retorno;
        }

        $scope.verColorLineaMuestras = function(m){
            mColor = 'Blanco';
            retorno = {'default-color': true};
            if(m != ''){
                retorno = {'verde-class': true};
                mColor = 'Verde';
            }
           
            return retorno;
        }



        

        $scope.editarMuestra = function(i){

            $http.post("leerMuestras.php", {idItem: i, accion: "buscar"})   
            .then(function(response){  
                $scope.idItem       = response.data.idItem;
                $scope.idMuestra    = response.data.idMuestra;
                $scope.conEnsayo    = response.data.conEnsayo;
                $scope.Taller       = response.data.Taller;
                $scope.nSolTaller   = response.data.nSolTaller;
                $scope.Objetivo     = response.data.Objetivo;
                $scope.regMuestra   = true;
                $scope.formMuestra  = true;
                $scope.msgGraba     = false;

            }, function(error) {
                $scope.errors = error.message;
            });
        }


        $scope.guardarDatosEnsayo = function(idItem, Otam, equipo){
            alert($scope.cEnsayos);
        }

        $scope.cambiarEquipo = function(idItem, equipo){
            // alert(idItem+' '+equipo);
            $http.post('leerMuestras.php',{
                idItem:     idItem,
                equipo:     equipo,
                accion:     "cambiarEquipo" 
            })
            .then(function (response) {
                $scope.idItem       = response.data.idItem;
                $scope.equipo       = response.data.equipo;
                $scope.idItem = idItem.substr(0, 8);
                $scope.editarTracciones($scope.idItem);

                // alert('Se modifico Equipo por '+response.data.equipo);
                // window.location.href = 'idMuestras.php?idItem='+Otam+'&RAM='+$scope.RAM+'&CAM='+$scope.CAM+'&idEnsayo=Tr&accion';

            }, function(error) {
                $scope.errors = error.message;
                alert('ERROR '+$scope.errors);
            });

        }
        $scope.cambiarEquipoooooo = function(idItem, Otam, equipo){
            $http.post('leerMuestras.php',{
                idItem:     idItem,
                Otam:       Otam,
                equipo:     equipo,
                accion:     "cambiarEquipo" 
            })
            .then(function (response) {
                $scope.idItem       = response.data.idItem;
                $scope.equipo       = response.data.equipo;
                // alert('Se modifico Equipo por '+response.data.equipo);
                window.location.href = 'idMuestras.php?idItem='+Otam+'&RAM='+$scope.RAM+'&CAM='+$scope.CAM+'&idEnsayo=Tr&accion';

            }, function(error) {
                $scope.errors = error.message;
                alert('ERROR '+$scope.errors);
            });

        }
        
        $scope.editarDataEnsayos = function(idEnsayo, idItem){
            // alert(idEnsayo);
            $scope.Ensayo = idEnsayo;
            $scope.formularioTr = false;
            if(idEnsayo == 'Tr'){
                $scope.formularioTr = true;
            }
            $scope.formularioQu = false;
            if(idEnsayo == 'Qu'){
                $scope.formularioQu = true;
            }
            $scope.formularioCh = false;
            if(idEnsayo == 'Ch'){
                $scope.formularioCh = true;
                $scope.tpMuestra = 'Ac';
                $scope.nImpactos = 3;
            }
            $scope.formularioDu = false;
            if(idEnsayo == 'Du'){
                $scope.formularioDu = true;
                $scope.tpMuestra = 'HB';
                $scope.nImpactos = 3;
            }
            $scope.formularioDo = false;
            if(idEnsayo == 'Do'){
                $scope.formularioDo = true;
                $scope.tpMuestra = 'Asme lx';
            }
            $scope.formularioOt = false;
            if(idEnsayo == 'Ot' || idEnsayo == 'M' || idEnsayo == 'Md' || idEnsayo == 'Pl' || idEnsayo == 'Qv' || idEnsayo == 'S' || idEnsayo == 'Fr' || idEnsayo == 'DFX' || idEnsayo == 'El' || idEnsayo == 'FRX'){
                $scope.formularioOt = true;
                $scope.cEnsayos     = 0;
            }

            // alert(idItem);
            $http.post('leerMuestras.php',{
                idItem      :    $scope.idItem,
                idEnsayo    :    idEnsayo,
                accion      :    "editarDataEnsayos" 
            })
            .then(function (response) {
                // $scope.idItem       = $scope.idItem;
                $scope.tpMuestra    = response.data.tpMuestra;
                $scope.cEnsayos     = response.data.cEnsayos;
                if($scope.cEnsayos == undefined){ $scope.cEnsayos = 0; }
                $scope.equipo       = response.data.equipo;
                $scope.Ref          = response.data.Ref;
                if($scope.Ref == undefined){ $scope.Ref = 'SR'; }
                $scope.Ind          = response.data.Ind;
                $scope.Tem          = response.data.Tem;
                $scope.obsIng       = response.data.obsIng;
                $scope.Comentarios  = response.data.Comentarios;
                $scope.tipoMuestra(idEnsayo);
                $scope.equipamiento();
                // alert(idEnsayo);
                if(idEnsayo == 'Tr'){
                    $scope.editarTracciones($scope.idItem);
                }
                if(idEnsayo == 'Qu'){
                    $scope.editarQuimicos($scope.idItem);
                }
            }, function(error) {
                $scope.errors = error.message;
                alert('ERROR '+$scope.errors);
            });

        }

        $scope.equipamiento = function(){
            
            $http.post('leerMuestras.php',{
                accion:     "equipamiento" 
            })
            .then(function (response) {
                $scope.dataEquipamiento = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
                alert('ERROR '+$scope.errors);
            });
        }
    
        $scope.tipoMuestra = function(idEnsayo){
            
            $http.post('leerMuestras.php',{
                idEnsayo:  idEnsayo,
                accion:     "tipoMuestra" 
            })
            .then(function (response) {
                $scope.dataMuestras = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
                alert('ERROR '+$scope.errors);
            });
        }
    
        $scope.editarTracciones = function(idItem){
            // $scope.idItem = idItem.substr(0, 8);
            // alert($scope.idItem);
            $http.post('leerMuestras.php',{
                idItem:     idItem,
                accion:     "editarTracciones" 
            })
            .then(function (response) {
                $scope.dataTracciones = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
                alert('ERROR '+$scope.errors);
            });
        }

        $scope.editarQuimicos = function(idItem){
            // $scope.idItem = idItem.substr(0, 8);
            // alert($scope.idItem);
            $http.post('leerMuestras.php',{
                idItem:     idItem,
                accion:     "editarQuimicos" 
            })
            .then(function (response) {
                $scope.dataQuimicos = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
                alert('ERROR '+$scope.errors);
            });
        }

        $scope.actualizacEnsayosDo = function(idItem){
            if($scope.tpMuestra     == undefined){ $scope.tpMuestra     = '';           }
            if($scope.Ensayo        == undefined){ $scope.Ensayo        = '';           }
            if($scope.cEnsayos      == undefined){ $scope.cEnsayos      = 1 ;           }
            swGrabar = 'off';
            if($scope.cEnsayos > 0){
                if($scope.tpMuestra != ''){
                    swGrabar = 'on';
                }
            }
            if(swGrabar == 'on'){
                // alert('idItem'+idItem+' '+$scope.tpMuestra+' '+$scope.Ref+' '+$scope.Ensayo+' '+$scope.cEnsayos+' '+$scope.nImpactos+' '+$scope.tpMedicion);
                $http.post('leerMuestras.php',{
                    idItem:     idItem,
                    idEnsayo:   $scope.Ensayo,
                    tpMuestra:  $scope.tpMuestra,
                    cEnsayos:   $scope.cEnsayos,
                    accion:     "actualizacEnsayosDo" 
                })
                .then(function (response) {
                    $scope.buscarDataMuestra(idItem);
                    alert('Actualizado ensayo...')
                }, function(error) {
                    $scope.errors = error.message;
                    alert('ERROR '+$scope.errors);
                });

            }
        }

        $scope.actualizacEnsayosDu = function(idItem){
            if($scope.tpMuestra     == undefined){ $scope.tpMuestra     = '';           }
            if($scope.tpMedicion    == undefined){ $scope.tpMedicion    = '';           }
            if($scope.Ensayo        == undefined){ $scope.Ensayo        = '';           }
            if($scope.cEnsayos      == undefined){ $scope.cEnsayos      = 1 ;           }
            if($scope.nImpactos     == undefined){ $scope.nImpactos     = 3 ;           }
            swGrabar = 'off';
            if($scope.cEnsayos > 0){
                if($scope.tpMuestra != ''){
                    if($scope.nImpactos > 0){
                        if($scope.tpMedicion != ''){
                            swGrabar = 'on';
                        }
                    }
                }
            }
            if(swGrabar == 'on'){
                // alert('idItem'+idItem+' '+$scope.tpMuestra+' '+$scope.Ref+' '+$scope.Ensayo+' '+$scope.cEnsayos+' '+$scope.nImpactos+' '+$scope.tpMedicion);
                $http.post('leerMuestras.php',{
                    idItem:     idItem,
                    idEnsayo:   $scope.Ensayo,
                    tpMuestra:  $scope.tpMuestra,
                    tpMedicion: $scope.tpMedicion,
                    cEnsayos:   $scope.cEnsayos,
                    nImpactos:  $scope.nImpactos,
                    Ind:        $scope.nImpactos,
                    accion:     "actualizacEnsayosDu" 
                })
                .then(function (response) {
                    $scope.buscarDataMuestra(idItem);
                    alert('Actualizado ensayo...')
                }, function(error) {
                    $scope.errors = error.message;
                    alert('ERROR '+$scope.errors);
                });

            }
        }

        $scope.actualizacEnsayosOt = function(idItem){
            if($scope.cEnsayos      == undefined){ $scope.cEnsayos      = 0 ;           }
            if($scope.Ref           == undefined){ $scope.Ref           = '';           }
            swGrabar = 'off';
            if($scope.cEnsayos > 0){
                if($scope.Ref != ''){
                    swGrabar = 'on';
                }
            }
            if(swGrabar == 'on'){
                // alert('idItem'+idItem+' '+$scope.tpMuestra+' '+$scope.Ref+' '+$scope.Ensayo+' '+$scope.cEnsayos);
                $http.post('leerMuestras.php',{
                    idItem:     idItem,
                    idEnsayo:   $scope.Ensayo,
                    cEnsayos:   $scope.cEnsayos,
                    Ref:        $scope.Ref,
                    accion:     "actualizacEnsayosOt" 
                })
                .then(function (response) {
                    $scope.buscarDataMuestra(idItem);
                    alert('Actualizado ensayo...')
                }, function(error) {
                    $scope.errors = error.message;
                    alert('ERROR '+$scope.errors);
                });


            }

        }

        $scope.actualizacEnsayosCh = function(idItem){
            if($scope.Ensayo        == undefined){ $scope.Ensayo        = '';           }
            if($scope.cEnsayos      == undefined){ $scope.cEnsayos      = 1 ;           }
            if($scope.Ref           == undefined){ $scope.Ref           = '';           }
            if($scope.vReferencia   == undefined){ $scope.vReferencia   = '' ;          }
            if($scope.nImpactos     == undefined){ $scope.nImpactos     = 3 ;           }
            if($scope.Tem           == undefined){ $scope.Tem           = 'Normal' ;    }
            if($scope.obsIng        == undefined){ $scope.obsIng        = '' ;          }
            if($scope.Comentarios   == undefined){ $scope.Comentarios   = '' ;          }
            swGrabar = 'off';
            if($scope.cEnsayos > 0){
                if($scope.nImpactos > 0){
                    if($scope.Tem != ''){
                        swGrabar = 'on';
                    }
                }
            }
            if(swGrabar == 'on'){
                // alert('idItem'+idItem+' '+$scope.tpMuestra+' '+$scope.Ref+' '+$scope.Ensayo+' '+$scope.cEnsayos);
                $http.post('leerMuestras.php',{
                    idItem:     idItem,
                    idEnsayo:   $scope.Ensayo,
                    cEnsayos:   $scope.cEnsayos,
                    nImpactos:  $scope.nImpactos,
                    Ind:        $scope.nImpactos,
                    Tem:        $scope.Tem,
                    Ref:        $scope.Ref,
                    vReferencia:$scope.vReferencia,
                    obsIng:     $scope.obsIng,
                    Comentarios:$scope.Comentarios,
                    accion:     "actualizacEnsayosCh" 
                })
                .then(function (response) {
                    $scope.buscarDataMuestra(idItem);
                    alert('Actualizado ensayo...')
                }, function(error) {
                    $scope.errors = error.message;
                    alert('ERROR '+$scope.errors);
                });


            }
        }

        $scope.actualizacEnsayosQu = function(idItem){
            if($scope.tpMuestra == undefined){ $scope.tpMuestra = '';   }
            if($scope.Ensayo    == undefined){ $scope.Ensayo    = '';   }
            if($scope.cEnsayos  == undefined){ $scope.cEnsayos  = 1;    }
            swGrabar = 'off';
            if($scope.cEnsayos > 0){
                if($scope.tpMuestra != ''){
                    swGrabar = 'on';
                }
            }
            if(swGrabar == 'on'){
                // alert('idItem'+idItem+' '+$scope.tpMuestra+' '+$scope.Ref+' '+$scope.Ensayo+' '+$scope.cEnsayos);
                $http.post('leerMuestras.php',{
                    idItem:     idItem,
                    idEnsayo:   $scope.Ensayo,
                    tpMuestra:  $scope.tpMuestra,
                    cEnsayos:   $scope.cEnsayos,
                    accion:     "actualizacEnsayosQu" 
                })
                .then(function (response) {
                    $scope.buscarDataMuestra(idItem);
                    $scope.editarQuimicos(idItem);

                    $scope.formularioQu = true;
                    // alert('Actualizado ensayo...')
                }, function(error) {
                    $scope.errors = error.message;
                    alert('ERROR '+$scope.errors);
                });

            }
        }

        $scope.actualizacEnsayosTr = function(idItem){
            if($scope.tpMuestra == undefined){ $scope.tpMuestra = ''; }
            if($scope.equipo    == undefined){ $scope.equipo    = ''; }
            if($scope.Ensayo    == undefined){ $scope.Ensayo    = ''; }
            if($scope.cEnsayos  == undefined){ $scope.cEnsayos  = 1;  }
            swGrabar = 'off';
            if($scope.cEnsayos > 0){
                if($scope.tpMuestra != ''){
                    if($scope.equipo != ''){
                        swGrabar = 'on';
                    }
                }
            }
            if(swGrabar == 'on'){
                // alert('idItem'+idItem+' '+$scope.tpMuestra+' '+$scope.equipo+' '+$scope.Ensayo+' '+$scope.cEnsayos);
                $http.post('leerMuestras.php',{
                    idItem:     idItem,
                    idEnsayo:   $scope.Ensayo,
                    tpMuestra:  $scope.tpMuestra,
                    cEnsayos:   $scope.cEnsayos,
                    equipo:     $scope.equipo,
                    accion:     "actualizacEnsayosTr" 
                })
                .then(function (response) {
                    $scope.buscarDataMuestra(idItem);
                    $scope.editarTracciones(idItem);
                    // alert('Actualizado ensayo...')
                }, function(error) {
                    $scope.errors = error.message;
                    alert('ERROR '+$scope.errors);
                });
            }

        }


    

        $scope.guardarConfiguracionMuestra = function(){
            $scope.resp = 'Guardar '+$scope.idItem;
            $scope.msgGraba = true;
            $http.post("leerMuestras.php", {
                                            idItem:     $scope.idItem, 
                                            idMuestra:  $scope.idMuestra, 
                                            nSolTaller: $scope.nSolTaller, 
                                            conEnsayo:  $scope.conEnsayo, 
                                            Taller:     $scope.Taller, 
                                            Objetivo:   $scope.Objetivo, 
                                            accion:     "guardar"})   
            .then(function(response){  
                //alert('Guardada...');
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.guardarMuestra = function(){
            //alert('Muestra '+$scope.idItem+' '+$scope.idMuestra);
            $http.post("leerMuestras.php", {
                                            idItem: $scope.idItem, 
                                            idMuestra: $scope.idMuestra, 
                                            accion: "guardar"})   
            .then(function(response){  
                $scope.res = response.data.estatus;
                //alert('Guardada...');
            }, function(error) {
                $scope.errors = error.message;
            });

        }

        $scope.guardarMuestra2 = function(i, m, e, t, o){
            //alert('Muestra '+o);
            
            $http.post("leerMuestras.php", {
                                            idItem: i, 
                                            idMuestra: m, 
                                            conEnsayo: e, 
                                            Taller: t, 
                                            Objetivo: o, 
                                            accion: "guardar"})   
            .then(function(response){  
                $scope.res = 'Registro guardado correctamente';
                $scope.loadMuestras($scope.RAM);
                //alert('Guardada...');
            }, function(error) {
                $scope.errors = error.message;
            });
            
        }

    });

