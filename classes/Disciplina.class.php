<?php
/**
 *
 * Classe para manipulação do objeto
 * Disciplina
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class Disciplina {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $nome;
    private $cargaHoraria;
    private $cursos_codigo;

    /**
     * Variável para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_nome;

    public function __construct() {
        $this->tabela = 'disciplinas';
        $this->cursos_codigo = new Curso();
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
                nome,
                cargaHoraria,
                cursos_codigo
            )
            VALUES(?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->nome,
            $this->cargaHoraria,
            $this->cursos_codigo->codigo
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
                cargaHoraria = ?,
                cursos_codigo = ?
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->nome,
            $this->cargaHoraria,
            $this->cursos_codigo->codigo,
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
            $obj = new Disciplina();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->nome = stripslashes($reg['nome']);
            $obj->cargaHoraria = stripslashes($reg['cargaHoraria']);
            $obj->cursos_codigo->codigo = stripslashes($reg['cursos_codigo']);
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
            $obj = new Disciplina();
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
            $obj = new Disciplina();
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