/**
 * Created by henrique on 13/10/17.
 */

'use strict';
var app = angular.module('appCriptografia', ['ngRoute', 'angularFileUpload', 'ui-notification', 'serviceGeral', 'moduloInicio']);

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when('/inicio', {
            templateUrl: 'inicio.html',
            controller: 'InicioController'
        })
        .when('/meus_arquivos', {
            templateUrl: 'meus_arquivos.html',
            controller: 'MeusArquivosController'
        })
        .when('/descriptografar', {
            templateUrl: 'descriptografar.html',
            controller: 'DescriptografarController'
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