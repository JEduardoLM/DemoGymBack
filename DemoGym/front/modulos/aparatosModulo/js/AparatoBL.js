/*jslint white:true*/
/*global angular*/
myApplication.controller('AparatosCommand', ['$scope', '$http', function ($scope, $http) {
    "use strict";
    $scope.aAparato = [];
    /*$scope.aAparato = [{Id: 1, Nombre: 'Rachel', Descripcion: 'McAdams', estatus: '1'},
                   {Id: 2, Nombre: 'Chloe', Descripcion: 'Grace Moretz', estatus: '0'},
                   {Id: 3, Nombre: 'Jessica', Descripcion: 'Chastain', estatus: '1'},
                   {Id: 4, Nombre: 'Zooey', Descripcion: 'Deschanel', estatus: '1'}];*/


    /*$scope.aparatoSelected = null;
    $scope.aparatoID = 0;
    $scope.name = "";
    $scope.descripcion = "";
    $scope.status = true;*/
    $scope.isEdit = false;


    $scope.selectedRow = null;
    $scope.setClickedRow = function(index, aparato){
        $scope.selectedRow = index;
        $scope.aparatoSelected = aparato;
        console.log($scope.aparatoSelected);
    };


    $http.post('/DemoGym/bl/AparatoBL.php', {metodo:'getAparato', id:0})
        .success(function (data) {
            $scope.aAparato = data.aparatos;
            console.log(data);
    })
    .error(function(data){
        console.log('Error: ' + data);
    });

    $scope.saveAparato = function(){
        console.log($scope.aparatoID);
        console.log($scope.aparatoID + " -name " + $scope.name + " -descripcion " + $scope.descripcion + " -status "+$scope.status);
        console.log($scope.aparatoSelected);
        $http.post('/DemoGym/bl/AparatoBL.php', {metodo:'saveAparato', id: $scope.aparatoID, nombre: $scope.name, descripcion: $scope.descripcion, estatus: $scope.status})
            .success(function (data) {
                $scope.aAparato = data.aparatos;
                console.log(data);
                console.log($scope.aAparato);
        })
        .error(function(data){
            console.log('Error: ' + data);
        });

        $scope.name = "";
        $scope.descripcion = "";
        $scope.aparatoID = 0;
        $scope.status = true;
        $scope.isEdit = false;
    };

    $scope.editAparato = function(aparato){
        if(!$scope.isEdit){
            $scope.isEdit = true;
            $scope.aparatoID = parseInt(aparato.Id);
            $scope.name = aparato.Nombre;
            $scope.descripcion = aparato.Descripcion;
            $scope.status = (aparato.estatus === '1');
            console.log($scope.aparatoID);
        }
    };

    $scope.editAparatoHandler = function(){
        if(!$scope.isEdit){
            $scope.isEdit = true;
            $scope.aparatoID = $scope.aparatoSelected.Id;
            $scope.name = $scope.aparatoSelected.Nombre;
            $scope.descripcion = $scope.aparatoSelected.Descripcion;
            $scope.status = ($scope.aparatoSelected.estatus === '1');
        }
    };
}]);
