<?php
/**
 * Created by PhpStorm.
 * User: henrique
 * Date: 13/10/2017
 * Time: 08:50
 */
error_reporting(-1);
ini_set('display_errors', 1);

require_once '../model/Arquivos.php';
require_once '../model/Usuairo.php';

$arq = new Arquivos();
$usu = new Usuairo();
$resposta = new stdClass();
$resposta->status = false;
$resposta->mensagem = 'Error 404 - Página não encontrada';

if (isset($_REQUEST['list'])) {
    $header = apache_request_headers();
    $usuario = $usu->get_usuario_hash($header['Authorization']);
    if (empty($usuario)) {
        header("HTTP/1.1 401 Unauthorized");
        exit;
    }
    $resposta = $arq->list_arquivos($usuario);
    echo_json($resposta);
}

if (isset($_REQUEST['upload'])) {
    $resposta = $arq->upload_arquivo();
    echo_json($resposta);
}

if (isset($_REQUEST['download'])) {
    $arq->download($_GET['download']);
}

if (isset($_REQUEST['gerar_chave'])) {
    $header = apache_request_headers();
    $resposta = $arq->gerar_chave($header['Authorization']);
    echo_json($resposta);
}

if (isset($_REQUEST['salva_arquivo'])) {
    $header = apache_request_headers();
    $usuario = $usu->get_usuario_hash($header['Authorization']);
    if (empty($usuario)) {
        header("HTTP/1.1 401 Unauthorized");
        exit;
    }
    $dados = json_decode(file_get_contents("php://input"));
    $dados->usu_codigo = $usuario->usu_codigo;
    $resposta = $arq->set_arquivo($dados);
    echo_json($resposta);
}

function echo_json($resposta)
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($resposta);
}

