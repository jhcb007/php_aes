var host = window.location.protocol + "//" + window.location.host;
var auth = window.localStorage.getItem('usu_hash');
angular.module("appCriptografia").value("config", {
    baseURL: host + "/php_aes/",
    nomeAPP: "Criptografia AES",
    usuHash: auth
});