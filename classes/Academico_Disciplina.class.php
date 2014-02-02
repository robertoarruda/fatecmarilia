<?php
/**
 *
 * Classe para manipulação do objeto
 * Academico - Disciplina
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class Academico_Disciplina {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $academicos_funcionarios_funcionariosLogin_cpf;
    private $disciplinas_codigo;
    private $data;

    public function __construct() {
        $this->tabela = 'academicos_disciplinas';
        $this->academicos_funcionarios_funcionariosLogin_cpf = new Funcionario();
        $this->disciplinas_codigo = new Disciplina();
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
                academicos_funcionarios_funcionariosLogin_cpf,
                disciplinas_codigo,
                data
            )
            VALUES(?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->academicos_funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf,
            $this->disciplinas_codigo->codigo,
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
            WHERE academicos_funcionarios_funcionariosLogin_cpf = ?
            AND disciplinas_codigo = ?
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
            WHERE academicos_funcionarios_funcionariosLogin_cpf = ?
            AND disciplinas_codigo = ?
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
            WHERE academicos_funcionarios_funcionariosLogin_cpf = ?
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            while ($reg = $stmt->fetch()) {
                $obj = new Academico_Disciplina();
                $obj->academicos_funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = stripslashes($reg['academicos_funcionarios_funcionariosLogin_cpf']);
                $obj->disciplinas_codigo->codigo = stripslashes($reg['disciplinas_codigo']);
                $obj->data = stripslashes($reg['data']);
                $res[] = $obj;
            }
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT academicos_funcionarios_funcionariosLogin_cpf
            FROM $this->tabela
            ORDER BY academicos_funcionarios_funcionariosLogin_cpf
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Academico_Disciplina();
            $obj = $obj->consultar($reg['academicos_funcionarios_funcionariosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT academicos_funcionarios_funcionariosLogin_cpf
            FROM $this->tabela
            ORDER BY academicos_funcionarios_funcionariosLogin_cpf
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Academico_Disciplina();
            $obj = $obj->consultar($reg['academicos_funcionarios_funcionariosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT academicos_funcionarios_funcionariosLogin_cpf
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