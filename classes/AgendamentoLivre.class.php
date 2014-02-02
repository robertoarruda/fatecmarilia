<?php

/**
 *
 * Classe para manipulação do objeto
 * Academico
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class AgendamentoLivre {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;

    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $data;
    private $horarioInicial;
    private $horarioFinal;
    private $comentarios;
    private $funcionarios_funcionariosLogin_cpf;
    private $agendas_codigo;

    /**
     * Variáveis para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_comentarios;

    public function __construct() {
        $this->tabela = 'agendamentoslivre';
        $this->agendas_codigo = new Agenda();
        $this->funcionarios_funcionariosLogin_cpf = new Funcionario();
        $this->limite_comentarios = 200;
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
                data,
                horarioInicial,
                horarioFinal,
                comentarios,
                agendas_codigo,
                funcionarios_funcionarioslogin_cpf
            )
            VALUES(?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->data,
            $this->horarioInicial,
            $this->horarioFinal,
            $this->comentarios,
            $this->agendas_codigo->codigo,
            $this->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function editar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                data = ?,
                horarioInicial = ?,
                horarioFinal = ?,
                comentarios = ?,
                agendas_codigo = ?,
                funcionarios_funcionarioslogin_cpf = ?
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf,
            $this->data,
            $this->horarioInicial,
            $this->horarioFinal,
            $this->comentarios,
            $this->agendas_codigo->codigo,
            $this->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf,
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
            $obj = new AgendamentoLivre();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->data = stripslashes($reg['data']);
            $obj->horarioInicial = stripslashes($reg['horarioInicial']);
            $obj->horarioFinal = stripslashes($reg['horarioFinal']);
            $obj->comentarios = stripslashes($reg['comentarios']);
            $obj->agendas_codigo->codigo = stripslashes($reg['agendas_codigo']);
            $obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = stripslashes($reg['funcionarios_funcionarioslogin_cpf']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT codigo, data, horarioInicial, horarioFinal
            FROM $this->tabela
            ORDER BY data, horarioInicial, horarioFinal
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoLivre();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT codigo, data, horarioInicial, horarioFinal
            FROM $this->tabela
            ORDER BY data, horarioInicial, horarioFinal
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoLivre();
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
    
    public function listarTudoFuncionarioAgenda($p1, $p2) {
        $strSQL = "
            SELECT codigo, data, horarioInicial, horarioFinal
            FROM $this->tabela
            WHERE funcionarios_funcionarioslogin_cpf = ?
            AND agendas_codigo = ?
            ORDER BY data, horarioInicial, horarioFinal
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1 ,$p2);
        $stmt->execute($data);
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoLivre();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistrosFuncionarioAgenda($p1, $p2) {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE funcionarios_funcionarioslogin_cpf = ?
            AND agendas_codigo = ?
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1, $p2);
        $stmt->execute($data);
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }
    
    public function listarTudoAgenda($p) {
        $strSQL = "
            SELECT codigo, data, horarioInicial, horarioFinal
            FROM $this->tabela
            WHERE agendas_codigo = ?
            ORDER BY data, horarioInicial, horarioFinal
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoLivre();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistrosAgenda($p) {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE agendas_codigo = ?
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    public function excluirAntigos() {
        $strSQL = "
            DELETE
            FROM $this->tabela
            WHERE codigo IN (
                SELECT codigo
                FROM (
                    SELECT codigo
                    FROM $this->tabela
                    WHERE CURDATE() > data
                ) as codigo
            )
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    public function existeAgendamento($p1,$p2,$p3,$p4) {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE data = ?
            AND agendas_codigo = ?
            AND (
                horarioInicial BETWEEN '$p3' AND '$p4'
                OR
                horarioFinal BETWEEN '$p3' AND '$p4'
            )
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1, $p2);
        $stmt->execute($data);
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistrosAgendaHoje($p) {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE agendas_codigo = ?
            AND data = CURDATE()
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }
    
    public function listarTudoAgendaHoje($p) {
        $strSQL = "
            SELECT codigo, data, horarioInicial, horarioFinal
            FROM $this->tabela
            WHERE agendas_codigo = ?
            AND data = CURDATE()
            ORDER BY data, horarioInicial, horarioFinal
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoLivre();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }
    
}