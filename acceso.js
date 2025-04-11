var app = angular.module('myApp', []);
app.controller('CtrlAcceso', function($scope, $http) { 

$scope.nPerfil = '';

$scope.validarAccesoPlataforma = function(){
    // alert($scope.usr+' '+$scope.pwd);
    $http.post('valAcceso.php',{
        usr:        $scope.usr,
        pwd:        $scope.pwd,
        accion:     "valAcceso"
    })
    .then(function(response){  
        $scope.nPerfil  = response.data.nPerfil;
        window.location.href = 'plataformaErp.php';
    }, function(error) {
        alert(error);
    });
}

// $scope.leerSolicitudes();

});
