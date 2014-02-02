<?php

/**
 *
 * Classe para manipulação do objeto
 * Aluno Login
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2013-07-23 11:30:15 $
 */
class AlunoLogin_Solicitacao {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;

    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $cpf;
    private $ra;
    private $email;
    private $nome;
    private $data;
    private $codigoDeAtivacao;
    private $instituicao_codigo;

    /**
     * Variável para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_ra;
    private $limite_email;
    private $limite_nome;

    public function __construct() {
        $this->tabela = 'alunoslogin_solicitacao';
        $this->instituicao_codigo = new Instituicao();
        $this->limite_ra = 13;
        $this->limite_email = 100;
        $this->limite_nome = 80;
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
                cpf,
                ra,
                email,
                nome,
                data,
                codigoDeAtivacao,
                instituicao_codigo
            )
            VALUES(?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->cpf,
            $this->ra,
            $this->email,
            $this->nome,
            $this->data,
            $this->codigoDeAtivacao,
            $this->instituicao_codigo->codigo
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function editar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                cpf = ?,
                ra = ?,
                email = ?,
                nome = ?,
                data = ?,
                codigoDeAtivacao = ?,
                instituicao_codigo = ?,
            WHERE cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->cpf,
            $this->ra,
            $this->email,
            $this->nome,
            $this->data,
            $this->codigoDeAtivacao,
            $this->instituicao_codigo->codigo,
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
            WHERE cpf = ?
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
            WHERE cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new AlunoLogin_Solicitacao();
            $obj->cpf = stripslashes($reg['cpf']);
            $obj->ra = stripslashes($reg['ra']);
            $obj->email = stripslashes($reg['email']);
            $obj->nome = stripslashes($reg['nome']);
            $obj->data = stripslashes($reg['data']);
            $obj->codigoDeAtivacao = stripslashes($reg['codigoDeAtivacao']);
            $obj->instituicao_codigo->codigo = stripslashes($reg['instituicao_codigo']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
            ORDER BY cpf
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new AlunoLogin();
            $obj = $obj->consultar($reg['cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
            ORDER BY cpf
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new AlunoLogin();
            $obj = $obj->consultar($reg['cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    //----- METODOS PERSONALIZADOS ------------------------------------------------------

    public function qtdRegistrosCpf_Ou_Email($p1, $p2) {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
            WHERE cpf = ?
            OR email = ?
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1, $p2);
        $stmt->execute($data);
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }
}