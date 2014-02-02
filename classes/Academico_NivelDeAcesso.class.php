<?php
/**
 *
 * Classe para manipulação do objeto
 * Cargo - Nivel de Acesso
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class Academico_NivelDeAcesso {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $niveisdeacesso_codigo;
    private $funcionarioLogin_cpf;

    public function __construct() {
        $this->tabela = 'academicos_niveisdeacesso';
        $this->niveisdeacesso_codigo = new NivelDeAcesso();
        $this->funcionarioLogin_cpf = new FuncionarioLogin();
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
                niveisdeacesso_codigo,
                funcionarioLogin_cpf
            )
            VALUES(?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->niveisdeacesso_codigo->codigo,
            $this->funcionarioLogin_cpf->cpf
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function excluir($p) {
        $strSQL = "
            DELETE
            FROM $this->tabela
            WHERE niveisdeacesso_codigo = ?
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
            WHERE niveisdeacesso_codigo = ?
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $res = NULL;
            while ($reg = $stmt->fetch()) {
                $obj = new Cargo_NivelDeAcesso();
                $obj->niveisdeacesso_codigo->codigo = stripslashes($reg['niveisdeacesso_codigo']);
                $obj->funcionarioLogin_cpf->cpf = stripslashes($reg['funcionarioLogin_cpf']);
                $res = $obj;
            }
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT niveisdeacesso_codigo
            FROM $this->tabela
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Academico_NivelDeAcesso();
            $obj = $obj->consultar($reg['niveisdeacesso_codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT niveisdeacesso_codigo
            FROM $this->tabela
            ORDER BY niveisdeacesso_codigo
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Academico_NivelDeAcesso();
            $obj = $obj->consultar($reg['niveisdeacesso_codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT niveisdeacesso_codigo
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