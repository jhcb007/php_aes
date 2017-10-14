'use strict';
angular.module('serviceGeral', ['ngResource'])
    .factory('ListArquivos', function ($resource, config) {
        return $resource(config.baseURL + 'controller/arquivo.php?list', {}, {
            'get': {
                method: 'GET',
                isArray: true,
                headers: {
                    'Authorization': config.usuHash
                }
            }
        });
    })
    .factory('GerarChave', function ($resource, config) {
        return $resource(config.baseURL + 'controller/arquivo.php?gerar_chave', {}, {
            'get': {
                method: 'GET',
                isArray: false,
                headers: {
                    'Authorization': config.usuHash
                }
            }
        });
    })
    .factory('SalvarArquivo', function ($resource, config) {
        return $resource(config.baseURL + 'controller/arquivo.php?salva_arquivo', {}, {
            save: {
                method: 'POST',
                headers: {
                    'Authorization': config.usuHash
                }
            }
        });
    })
    .factory('DeletaArquivo', function ($resource, config) {
        return $resource(config.baseURL + 'controller/arquivo.php?delete_arquivo', {}, {
            save: {
                method: 'POST',
                headers: {
                    'Authorization': config.usuHash
                }
            }
        });
    })
    .factory('DescriptografarArquivo', function ($resource, config) {
        return $resource(config.baseURL + 'controller/arquivo.php?descriptografar', {}, {
            save: {
                method: 'POST',
                headers: {
                    'Authorization': config.usuHash
                }
            }
        });
    });