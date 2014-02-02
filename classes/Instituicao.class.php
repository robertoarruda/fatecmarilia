<?php

/**
 *
 * Classe para manipulação do objeto
 * Instituição
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class Instituicao {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;

    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $nome;
    private $nomeFantasia;
    private $imagem;
    private $descricao;
    private $endereco;
    private $complemento;
    private $cep;
    private $cidade;
    private $estado;
    private $telefone;
    private $fax;
    private $email;
    private $emailSuporte;

    /**
     * Variável para armazenamento o do caminho do diretório
     * de imagens correspondente
     * */
    private $dirImagem;

    /**
     * Variáveis para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_nome;
    private $limite_nomeFantasia;
    private $limite_endereco;
    private $limite_complemento;
    private $limite_email;
    private $limite_emailSuporte;

    public function __construct() {
        $this->dirImagem = 'imagens/layout/conteudo/';
        $this->tabela = 'instituicao';
        $this->limite_nome = 100;
        $this->limite_nomeFantasia = 100;
        $this->limite_endereco = 100;
        $this->limite_complemento = 50;
        $this->limite_email = 100;
        $this->limite_emailSuporte = 100;
    }

    public function __destruct() {

    }

    public function __get($key) {
        if (is_string($this->$key))
            $res = htmlspecialchars($this->$key);
        else
            $res = $this->$key;
        return $res;
    }

    public function __set($key, $value) {
        $this->$key = $value;
    }

    public function inserir() {
        $strSQL = "
            INSERT INTO
            $this->tabela(
                nome,
                nomeFantasia,
                imagem,
                descricao,
                endereco,
                complemento,
                cep,
                cidade,
                estado,
                telefone,
                fax,
                email,
                emailSuporte
            )
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->nome,
            $this->nomeFantasia,
            $this->imagem,
            $this->descricao,
            $this->endereco,
            $this->complemento,
            $this->cep,
            $this->cidade,
            $this->estado,
            $this->telefone,
            $this->fax,
            $this->email,
            $this->emailSuporte
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function editar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                nome = ?,
                nomeFantasia = ?,
                imagem = ?,
                descricao = ?,
                endereco = ?,
                complemento = ?,
                cep = ?,
                cidade = ?,
                estado = ?,
                telefone = ?,
                fax = ?,
                email = ?,
                emailSuporte = ?
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->nome,
            $this->nomeFantasia,
            $this->imagem,
            $this->descricao,
            $this->endereco,
            $this->complemento,
            $this->cep,
            $this->cidade,
            $this->estado,
            $this->telefone,
            $this->fax,
            $this->email,
            $this->emailSuporte,
            $p
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function excluir($p) {
        $strSQL = "
            DELETE
            FROM $this->tabela
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function consultar($p) {
        $strSQL = "
            SELECT *
            FROM $this->tabela
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new Instituicao();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->nome = stripslashes($reg['nome']);
            $obj->nomeFantasia = stripslashes($reg['nomeFantasia']);
            $obj->imagem = stripslashes($reg['imagem']);
            $obj->descricao = stripslashes($reg['descricao']);
            $obj->endereco = stripslashes($reg['endereco']);
            $obj->complemento = stripslashes($reg['complemento']);
            $obj->cep = stripslashes($reg['cep']);
            $obj->cidade = stripslashes($reg['cidade']);
            $obj->estado = stripslashes($reg['estado']);
            $obj->telefone = stripslashes($reg['telefone']);
            $obj->fax = stripslashes($reg['fax']);
            $obj->email = stripslashes($reg['email']);
            $obj->emailSuporte = stripslashes($reg['emailSuporte']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT codigo, nome
            FROM $this->tabela
            ORDER BY nome
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Instituicao();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT codigo, nome
            FROM $this->tabela
            ORDER BY nome
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Instituicao();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    //----- METODOS PERSONALIZADOS ------------------------------------------------------
}