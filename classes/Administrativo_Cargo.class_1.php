<?php
/**
 *
 * Classe para manipulação do objeto
 * Administrativo - Cargo
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class Administrativo_Cargo {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $administrativos_funcionarios_funcionariosLogin_cpf;
    private $cargos_codigo;
    private $data;

    public function __construct() {
        $this->tabela = 'administrativos_cargos';
        $this->administrativos_funcionarios_funcionariosLogin_cpf = new Administrativo();
        $this->cargos_codigo = new Cargo();
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
                administrativos_funcionarios_funcionariosLogin_cpf,
                cargos_codigo,
                data
            )
            VALUES(?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->administrativos_funcionarios_funcionariosLogin_cpf->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf,
            $this->cargos_codigo->codigo,
            $this->data
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function editar($p1, $p2) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                data = ?
            WHERE administrativos_funcionarios_funcionariosLogin_cpf = ?
            AND cargos_codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->data,
            $p1,
            $p2
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function excluir($p1, $p2) {
        $strSQL = "
            DELETE
            FROM $this->tabela
            WHERE administrativos_funcionarios_funcionariosLogin_cpf = ?
            AND cargos_codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1, $p2);
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function consultar($p) {
        $strSQL = "
            SELECT *
            FROM $this->tabela
            WHERE administrativos_funcionarios_funcionariosLogin_cpf =  ?
            ORDER BY data
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $res = array();
            while ($reg = $stmt->fetch()) {
                $obj = new Administrativo_Cargo();
                $obj->administrativos_funcionarios_funcionariosLogin_cpf->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = stripslashes($reg['administrativos_funcionarios_funcionariosLogin_cpf']);
                $obj->cargos_codigo->codigo = stripslashes($reg['cargos_codigo']);
                $obj->data = stripslashes($reg['data']);
                $res[] = $obj;
            }
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT administrativos_funcionarios_funcionariosLogin_cpf
            FROM $this->tabela
            ORDER BY administrativos_funcionarios_funcionariosLogin_cpf
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Administrativo_Cargo();
            $obj = $obj->consultar($reg['administrativos_funcionarios_funcionariosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT administrativos_funcionarios_funcionariosLogin_cpf
            FROM $this->tabela
            ORDER BY administrativos_funcionarios_funcionariosLogin_cpf
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Administrativo_Cargo();
            $obj = $obj->consultar($reg['administrativos_funcionarios_funcionariosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT administrativos_funcionarios_funcionariosLogin_cpf
            FROM $this->tabela
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    //----- METODOS PERSONALIZADOS ------------------------------------------------------
    
    public function consultarCargos($p) {
        $strSQL = "
            SELECT administrativos_funcionarios_funcionariosLogin_cpf, data
            FROM $this->tabela
            WHERE cargos_codigo =  ?
            ORDER BY data
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $res = NULL;
            while ($reg = $stmt->fetch()) {
                $obj = new Administrativo_Cargo();
                $obj = $obj->consultar($reg['administrativos_funcionarios_funcionariosLogin_cpf']);
                $res[] = $obj;
            }
        }
        $stmt = NULL;
        return $res;
    }
}