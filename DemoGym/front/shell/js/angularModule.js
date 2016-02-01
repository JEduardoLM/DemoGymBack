/*jslint white:true*/
/*global angular*/
var myApplication = angular.module('demoGym', ['ngTable', 'ngAnimate', 'ngRoute', 'ngMessages']);

myApplication.controller('loginCommand', ['$scope', '$window', function($scope, $window){
    "use strict";

    //console.log('star demoGym');

    $scope.loginHandler = function(){
        $window.location = "/DemoGym/front/shell/menu.html";
    };


    $scope.backToMenu = function(){
        $window.location = "/DemoGym/front/shell/menu.html";
    };

    /*$scope.names = [{Id: '1', name: 'Alexandra', phone:'83846284357'},
                    {Id: '2', name: 'Daddario', phone:'75473946235'},
                    {Id: '3', name: 'McAdams', phone: '4568523677'}];*/
}]);
