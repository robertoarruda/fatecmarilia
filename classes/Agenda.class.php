<?php

/**
 *
 * Classe para manipulação do objeto
 * Academico
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2013 - Roberto Arruda
 * @version    1.0 $ 2013-07-31 20:06:29 $
 */
class Agenda {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;

    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $nome;
    private $tipoDeHorario;
    private $diasDeAntecedencia;
    private $departamentos_codigo;

    /**
     * Variáveis para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_nome;

    public function __construct() {
        $this->tabela = 'agendas';
        $this->departamentos_codigo = new Departamento();
        $this->limite_nome = 50;
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
                tipoDeHorario,
                diasdeAntecedencia,
                departamentos_codigo
            )
            VALUES(?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->nome,
            $this->tipoDeHorario,
            $this->diasDeAntecedencia,
            $this->departamentos_codigo->codigo
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
                tipoDeHorario = ?,
                diasDeAntecedencia = ?,
                departamentos_codigo = ?
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->nome,
            $this->tipoDeHorario,
            $this->diasDeAntecedencia,
            $this->departamentos_codigo->codigo,
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
            $obj = new Agenda();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->nome = stripslashes($reg['nome']);
            $obj->tipoDeHorario = stripslashes($reg['tipoDeHorario']);
            $obj->diasDeAntecedencia = stripslashes($reg['diasDeAntecedencia']);
            $obj->departamentos_codigo->codigo = stripslashes($reg['departamentos_codigo']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            ORDER BY codigo
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Agenda();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            ORDER BY codigo
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Agenda();
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
    
    public function consultarDepartamento($p) {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE departamentos_codigo =  ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new Agenda();
            $obj = $obj->consultar($reg['codigo']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }
}