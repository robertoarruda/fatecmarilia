<?php
/**
 *
 * Classe para manipulação do objeto
 * Administrativo
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class Administrativo {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $funcionarios_funcionariosLogin_cpf;
    private $formacao;

    public function __construct() {
        $this->tabela = 'administrativos';
        $this->funcionarios_funcionariosLogin_cpf = new Funcionario();
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
                funcionarios_funcionariosLogin_cpf,
                formacao
            )
            VALUES(?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf,
            $this->formacao
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function editar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                formacao = ?
            WHERE funcionarios_funcionariosLogin_cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->formacao,
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
            WHERE funcionarios_funcionariosLogin_cpf = ?
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
            WHERE funcionarios_funcionariosLogin_cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new Administrativo();
            $obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = stripslashes($reg['funcionarios_funcionariosLogin_cpf']);
            $obj->formacao = stripslashes($reg['formacao']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT funcionarios_funcionariosLogin_cpf
            FROM $this->tabela
            ORDER BY funcionarios_funcionariosLogin_cpf
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Administrativo();
            $obj = $obj->consultar($reg['funcionarios_funcionariosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT funcionarios_funcionariosLogin_cpf
            FROM $this->tabela
            ORDER BY funcionarios_funcionariosLogin_cpf
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Administrativo();
            $obj = $obj->consultar($reg['funcionarios_funcionariosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT funcionarios_funcionariosLogin_cpf
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