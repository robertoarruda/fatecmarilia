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
class Revista {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;

    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $descricao;
    private $equipeEditorial;
    private $comiteCientifico;
    private $equipeDiagramacaoWebDesigner;

    /**
     * Variável para armazenamento o do caminho do diretório
     * de imagens correspondente
     * */
    private $dirImagem;
    private $dirArquivo;

    public function __construct() {
        $this->dirImagem = 'imagens/revista/';
        $this->dirArquivo = 'arquivos/revista/';
        $this->tabela = 'revista';
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
                descricao,
                equipeeditorial,
                comitecientifico,
                equipediagramacaowebdesigner
            )
            VALUES(?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->descricao,
            $this->equipeEditorial,
            $this->comiteCientifico,
            $this->equipeDiagramacaoWebDesigner
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function editar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                descricao = ?,
                equipeeditorial = ?,
                comitecientifico = ?,
                equipediagramacaowebdesigner = ?
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->descricao,
            $this->equipeEditorial,
            $this->comiteCientifico,
            $this->equipeDiagramacaoWebDesigner,
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
            $obj = new Revista();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->descricao = stripslashes($reg['descricao']);
            $obj->equipeEditorial = stripslashes($reg['equipeeditorial']);
            $obj->comiteCientifico = stripslashes($reg['comitecientifico']);
            $obj->equipeDiagramacaoWebDesigner = stripslashes($reg['equipediagramacaowebdesigner']);
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
            $obj = new Revista();
            $obj->consultar($reg['codigo']);
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
            $obj = new Revista();
            $obj->consultar($reg['codigo']);
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