/**
 * Created by henrique on 13/10/17.
 */

'use strict';

angular.module('moduloInicio', ['serviceGeral'])
    .controller('InicioController', InicioController)
    .controller('MeusArquivosController', MeusArquivosController)
    .controller('DescriptografarController', DescriptografarController);

function InicioController($rootScope, $scope, $location, FileUploader, Notification, GerarChave, SalvarArquivo) {
    $rootScope.__pagina = 'Criptografar';
    $scope.arquivo_erro = false;
    $scope.arquivo = {
        arq_nome: null,
        arq_arquivo: null,
        arq_chave: null
    };

    var uploader = $scope.uploader = new FileUploader({
        url: '../../controller/arquivo.php?upload'
    });

    // FILTERS
    uploader.filters.push({
        name: 'customFilter',
        fn: function (item /*{File|FileLikeObject}*/, options) {
            return this.queue.length < 10;
        }
    });

    $scope.cancelarUpload = function () {
        uploader.clearQueue();
        $scope.arquivo_erro = false;
        $scope.arquivo = {
            arq_nome: null,
            arq_arquivo: null,
            arq_chave: null
        };
    };

    uploader.onSuccessItem = function (fileItem, response, status, headers) {
        if (response.status === false) {
            $scope.arquivo_erro = true;
        } else {
            $scope.arquivo.arq_arquivo = response.arq_arquivo;
            $scope.arquivo.arq_nome = response.arq_nome;
        }
    };

    uploader.onCompleteAll = function () {
        if ($scope.arquivo_erro) {
            Notification.error({
                title: 'Criptografia AES',
                message: 'Erro ao anexar arquivo',
                positionY: 'bottom',
                positionX: 'right',
                delay: 5000
            });
        } else {
            Notification.primary({
                title: 'Criptografia AES',
                message: 'Arquivo anexado',
                positionY: 'bottom',
                positionX: 'right',
                delay: 3000
            });
        }
    };

    $scope.get_nova_chave = function () {
        GerarChave.get({}, function (resul) {
            $scope.arquivo.arq_chave = resul.arq_chave;
        });
    };

    $scope.set_arquivo = function () {
        SalvarArquivo.save({}, $scope.arquivo, function (resul) {
            if (resul.status) {
                Notification.success({
                    title: 'Criptografia AES',
                    message: resul.mensagem,
                    positionY: 'bottom',
                    positionX: 'right',
                    delay: 3000
                });
                $location.path('/meus_arquivos/');
            } else {
                Notification.error({
                    title: 'Criptografia AES',
                    message: resul.mensagem,
                    positionY: 'bottom',
                    positionX: 'right',
                    delay: 5000
                });
            }
        });
    };

    $scope.get_nova_chave();
}

function MeusArquivosController($rootScope, $scope, ListArquivos) {
    $rootScope.__pagina = 'Meus Arquivos';
    $scope.arquivo_erro = false;

    $scope.list_arquivos = function () {
        ListArquivos.get({}, function (resul) {
            $scope.arquivos = resul;
        });
    };
    $scope.list_arquivos();
}

function DescriptografarController($rootScope, $scope, $location, FileUploader, Notification, GerarChave, SalvarArquivo) {
    $rootScope.__pagina = 'Descriptografar';
    $scope.arquivo_erro = false;
    $scope.arquivo = {
        arq_nome: null,
        arq_arquivo: null,
        arq_chave: null
    };

    var uploader = $scope.uploader = new FileUploader({
        url: '../../controller/arquivo.php?upload'
    });

    // FILTERS
    uploader.filters.push({
        name: 'customFilter',
        fn: function (item /*{File|FileLikeObject}*/, options) {
            return this.queue.length < 10;
        }
    });

    $scope.cancelarUpload = function () {
        uploader.clearQueue();
        $scope.arquivo_erro = false;
        $scope.arquivo = {
            arq_nome: null,
            arq_arquivo: null,
            arq_chave: null
        };
    };

    uploader.onSuccessItem = function (fileItem, response, status, headers) {
        if (response.status === false) {
            $scope.arquivo_erro = true;
        } else {
            $scope.arquivo.arq_arquivo = response.arq_arquivo;
            $scope.arquivo.arq_nome = response.arq_nome;
        }
    };

    uploader.onCompleteAll = function () {
        if ($scope.arquivo_erro) {
            Notification.error({
                title: 'Criptografia AES',
                message: 'Erro ao anexar arquivo',
                positionY: 'bottom',
                positionX: 'right',
                delay: 5000
            });
        } else {
            Notification.primary({
                title: 'Criptografia AES',
                message: 'Arquivo anexado',
                positionY: 'bottom',
                positionX: 'right',
                delay: 3000
            });
        }
    };


    $scope.set_arquivo = function () {
        SalvarArquivo.save({}, $scope.arquivo, function (resul) {
            if (resul.status) {
                Notification.success({
                    title: 'Criptografia AES',
                    message: resul.mensagem,
                    positionY: 'bottom',
                    positionX: 'right',
                    delay: 3000
                });
                $location.path('/meus_arquivos/');
            } else {
                Notification.error({
                    title: 'Criptografia AES',
                    message: resul.mensagem,
                    positionY: 'bottom',
                    positionX: 'right',
                    delay: 5000
                });
            }
        });
    };
}