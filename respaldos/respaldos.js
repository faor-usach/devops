    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.Estado = "P";
        $rootScope.res = '';
        $rootScope.regMuestra = false;
        $rootScope.formMuestra = false;
        $rootScope.msgGraba = false;

    });

    app.controller('CtrlRespaldos', function($scope, $http) {

    });

