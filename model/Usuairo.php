<?php

/**
 * Created by PhpStorm.
 * User: henrique
 * Date: 12/10/17
 * Time: 21:49
 */

require_once '../config/geral.php';

class Usuairo
{
    private $DB;

    function __construct()
    {
        try {
            $this->DB = new PDO('mysql:host=' . HOST . ';dbname=' . BANCO, USUARIO, SENHA);
        } catch (PDOException $e) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
        }
    }

    public function login($dados)
    {
        $resposta = new stdClass();
        $resposta->status = false;
        $resposta->mensagem = '';
        $usuario = $this->get_usuario($dados);
        if (empty($usuario)) {
            $resposta->mensagem = 'Usuário não localizado';
            return $resposta;
        }
        if (password_verify($dados->usu_senha, $usuario->usu_senha) === FALSE) {
            $resposta->mensagem = 'Senha errada';
            return $resposta;
        }
        $resposta->hash = $usuario->usu_hash;
        $resposta->status = true;
        return $resposta;
    }

    private function get_usuario($dados)
    {
        $stmt = $this->DB->prepare("select * from usuario where usu_email = lower('{$dados->usu_email}')");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function set_usuario($dados)
    {
        $resposta = new stdClass();
        $resposta->status = false;
        $resposta->mensagem = 'Erro interno';
        $hash = sha1($dados->usu_email . time());
        $sql = "INSERT INTO usuario(usu_email, usu_senha, usu_hash) VALUES(lower(:usu_email), :usu_senha, :usu_hash)";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':usu_email', $dados->usu_email);
        $stmt->bindParam(':usu_senha', password_hash($dados->usu_senha, PASSWORD_DEFAULT));
        $stmt->bindParam(':usu_hash', $hash);
        $result = $stmt->execute();
        if ($result) {
            $resposta->status = true;
            $resposta->hash = $hash;
        } else {
            $resposta->mensagem = json_encode($stmt->errorInfo());
        }
        return $resposta;
    }

}