<?php
/**
 * Created by PhpStorm.
 * User: henrique
 * Date: 12/10/17
 * Time: 22:32
 */

error_reporting(-1);
ini_set('display_errors', 1);

require_once '../model/Usuairo.php';

$dados = json_decode($_POST['dados']);

$usuario = new Usuairo();

$resposta = $usuario->login($dados);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($resposta);