<?php
/**
 * Created by PhpStorm.
 * User: henrique
 * Date: 13/10/2017
 * Time: 09:09
 */

require_once '../config/geral.php';

include('../lib/aes.php');

class Arquivos
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

    public function upload_arquivo()
    {
        $tempPath = $_FILES['file']['tmp_name'];
        $resposta = new stdClass();
        $resposta->status = false;
        $arquivo = sha1(time() . '&' . $_FILES["file"]["name"]) . '.' . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        if (move_uploaded_file($tempPath, FILES . $arquivo)) {
            $resposta->arq_nome = $_FILES["file"]["name"];
            $resposta->arq_arquivo = $arquivo;
            $resposta->status = true;
        }
        return $resposta;
    }

    public function gerar_chave($usu_hash)
    {
        $resposta = new stdClass();
        $resposta->arq_chave = bin2hex(random_bytes(16));
        return $resposta;
    }

    public function get_arquivo($arq_arquivo)
    {
        $stmt = $this->DB->prepare("select * from arquivo u where arq_arquivo = '{$arq_arquivo}'");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function list_arquivos($dados)
    {
        $stmt = $this->DB->prepare("select * from arquivo a where a.usu_codigo = {$dados->usu_codigo} order by a.arq_data desc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function set_arquivo($dados)
    {
        $resposta = new stdClass();
        $resposta->status = false;
        $resposta->mensagem = 'Erro interno';

        try {
            $this->criptografar($dados);
        } catch (Error $e) {
            echo $resposta->mensagem = $e->getMessage();
            return $resposta;
        }

        $sql = "INSERT INTO  `arquivo` (`arq_nome`,`arq_arquivo`,`arq_chave`,`usu_codigo`) VALUE (:arq_nome,:arq_arquivo,:arq_chave,:usu_codigo);";
        $stmt = $this->DB->prepare($sql);
        $stmt->bindParam(':arq_nome', $dados->arq_nome);
        $stmt->bindParam(':arq_arquivo', $dados->arq_arquivo);
        $stmt->bindParam(':arq_chave', $dados->arq_chave);
        $stmt->bindParam(':usu_codigo', $dados->usu_codigo);
        $result = $stmt->execute();
        if ($result) {
            $resposta->status = true;
            $resposta->mensagem = 'Arquivo Criptografado com Sucesso';
        } else {
            $resposta->mensagem = json_encode($stmt->errorInfo());
        }
        return $resposta;
    }

    private function criptografar($dados)
    {
        $crypt = new aes_encryption();
        $crypt->key = $dados->arq_chave;
        $crypt->iv = $crypt->rand_iv();
        $file = FILES . $dados->arq_arquivo;
        $crypt->encrypt_file($file, $file . '.aes');
        //$crypt->decrypt_file($file.'.enc', $file);
    }

    public function download($arq_arquivo)
    {
        $dados = $this->get_arquivo($arq_arquivo);
        $path_parts = pathinfo(FILES . urldecode($dados->arq_arquivo).'.aes');
        header('Content-Disposition: attachment; filename="' . urldecode($dados->arq_nome) . '.' . $path_parts['extension']);
        readfile(FILES . urldecode($dados->arq_arquivo).'.aes');
    }

}