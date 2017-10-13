/**
 * Created by henrique on 13/10/17.
 */

'use strict';
var app = angular.module('appCriptografia', ['ngRoute', 'angularFileUpload', 'serviceGeral', 'moduloInicio']);

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when('/inicio', {
            templateUrl: 'inicio.html',
            controller: 'InicioController'
        })
        .otherwise({
            redirectTo: '/inicio'
        });
    $locationProvider.hashPrefix('!');
});

app.run(function ($rootScope) {

});

app.filter('dataBancoToHtml', ['$filter', function ($filter) {
    return function (data) {
        if (!data) {
            return "Não informado";
        }
        return $filter('date')(data, 'dd/MM/yyyy');
    };
}]);