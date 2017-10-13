'use strict';
angular.module('serviceGeral', ['ngResource'])
    .factory('ServUpload', function ($resource, config) {
        return $resource(config.baseURL + 'upload/deletar', {}, {
            save: {
                method: 'POST'
            }
        });
    });