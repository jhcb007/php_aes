<?php
/**
 * Created by PhpStorm.
 * User: henrique
 * Date: 12/10/17
 * Time: 21:43
 */

require_once '../model/Usuairo.php';

$dados = json_decode($_POST['dados']);

$usuario = new Usuairo();

$resposta = $usuario->set_usuario($dados);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($resposta);
