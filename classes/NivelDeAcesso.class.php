<?php

/**
 *
 * Classe para manipulação do objeto
 * Nivel de Acesso
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class NivelDeAcesso {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;

    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $tipo;

    public function __construct() {
        $this->tabela = 'niveisdeacesso';
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
                tipo
            )
            VALUES(?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            strtoupper($this->tipo)
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function editar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                codigo = ?,
                tipo = ?
            WHERE codigo = ?
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->codigo,
            $this->tipo,
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
            WHERE tipo = ?
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new NivelDeAcesso();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->tipo = stripslashes($reg['tipo']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT tipo
            FROM $this->tabela
            ORDER BY tipo
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new NivelDeAcesso();
            $obj = $obj->consultar($reg['tipo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT tipo
            FROM $this->tabela
            ORDER BY tipo
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new NivelDeAcesso();
            $obj = $obj->consultar($reg['tipo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT tipo
            FROM $this->tabela
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    //----- METODOS PERSONALIZADOS ------------------------------------------------------

    public function setarNivel($p) {
        $strSQL = "
            SELECT tipo
            FROM $this->tabela
            WHERE tipo = ?
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(strtoupper($p));
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if (!$res) {
            $obj = new NivelDeAcesso();
            $obj->tipo = $p;
            $res = $obj->inserir();
        }
        $stmt = NULL;
        return $res;
    }

}