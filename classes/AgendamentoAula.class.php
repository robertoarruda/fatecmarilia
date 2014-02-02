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
class AgendamentoAula {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;

    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $data;
    private $termo;
    private $turno;
    private $aula1;
    private $aula2;
    private $aula3;
    private $aula4;
    private $aula5;
    private $comentarios;
    private $funcionarios_funcionariosLogin_cpf;
    private $agendas_codigo;

    /**
     * Variáveis para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_comentarios;

    public function __construct() {
        $this->tabela = 'agendamentosaula';
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
                termo,
                turno,
                aula1,
                aula2,
                aula3,
                aula4,
                aula5,
                comentarios,
                agendas_codigo,
                funcionarios_funcionarioslogin_cpf
            )
            VALUES(?,?,?,?,?,?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->data,
            $this->termo,
            $this->turno,
            $this->aula1,
            $this->aula2,
            $this->aula3,
            $this->aula4,
            $this->aula5,
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
                termo = ?,
                turno = ?,
                aula1 = ?,
                aula2 = ?,
                aula3 = ?,
                aula4 = ?,
                aula5 = ?,
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
            $this->termo,
            $this->turno,
            $this->aula1,
            $this->aula2,
            $this->aula3,
            $this->aula4,
            $this->aula5,
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
            $obj = new AgendamentoAula();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->data = stripslashes($reg['data']);
            $obj->termo = stripslashes($reg['termo']);
            $obj->turno = stripslashes($reg['turno']);
            $obj->aula1 = stripslashes($reg['aula1']);
            $obj->aula2 = stripslashes($reg['aula2']);
            $obj->aula3 = stripslashes($reg['aula3']);
            $obj->aula4 = stripslashes($reg['aula4']);
            $obj->aula5 = stripslashes($reg['aula5']);
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
            SELECT codigo, data, turno, aula1, aula2, aula3, aula4, aula5
            FROM $this->tabela
            ORDER BY data, turno, aula1 DESC, aula2 DESC, aula3 DESC, aula4 DESC, aula5 DESC
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoAula();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT codigo, data, turno, aula1, aula2, aula3, aula4, aula5
            FROM $this->tabela
            ORDER BY data, turno, aula1 DESC, aula2 DESC, aula3 DESC, aula4 DESC, aula5 DESC
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoAula();
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
            SELECT codigo, data, turno, aula1, aula2, aula3, aula4, aula5
            FROM $this->tabela
            WHERE funcionarios_funcionarioslogin_cpf = ?
            AND agendas_codigo = ?
            ORDER BY data, turno, aula1 DESC, aula2 DESC, aula3 DESC, aula4 DESC, aula5 DESC
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1 ,$p2);
        $stmt->execute($data);
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoAula();
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
            SELECT codigo, data, turno, aula1, aula2, aula3, aula4, aula5
            FROM $this->tabela
            WHERE agendas_codigo = ?
            ORDER BY data, turno, aula1 DESC, aula2 DESC, aula3 DESC, aula4 DESC, aula5 DESC
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoAula();
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

    public function existeAgendamento($p) {
        $sqlWhere = "";
        if ($p->aula1) {
            $sqlWhere .= "aula1 = '$p->aula1'";
        }
        if ($p->aula2) {
            $sqlWhere .= ($sqlWhere) ? " OR " : "";
            $sqlWhere .= "aula2 = '$p->aula2'";
        }
        if ($p->aula3) {
            $sqlWhere .= ($sqlWhere) ? " OR " : "";
            $sqlWhere .= "aula3 = '$p->aula3'";
        }
        if ($p->aula4) {
            $sqlWhere .= ($sqlWhere) ? " OR " : "";
            $sqlWhere .= "aula4 = '$p->aula4'";
        }
        if ($p->aula5) {
            $sqlWhere .= ($sqlWhere) ? " OR " : "";
            $sqlWhere .= "aula5 = '$p->aula5'";
        }
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE data = ?
            AND agendas_codigo = ?
            AND turno = ?
            AND ($sqlWhere)
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p->data, $p->agendas_codigo->codigo, $p->turno);
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
            SELECT codigo, data, turno, aula1, aula2, aula3, aula4, aula5
            FROM $this->tabela
            WHERE agendas_codigo = ?
            AND data = CURDATE()
            ORDER BY data, turno, aula1 DESC, aula2 DESC, aula3 DESC, aula4 DESC, aula5 DESC
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        while ($reg = $stmt->fetch()) {
            $obj = new AgendamentoAula();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }
    
    public function desabilitaHorarios($p1, $p2, $p3) {
        $strSQL = "
            SELECT SUM(aula1) aula1 , SUM(aula2) aula2, SUM(aula3) aula3, SUM(aula4) aula4, SUM(aula5) aula5
            FROM $this->tabela
            WHERE agendas_codigo = ?
            AND data =  ?
            AND turno = ?
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1, $p2, $p3);
        $stmt->execute($data);
        $reg = $stmt->fetch();
        $obj = array();
        $obj['aula1'] = $reg['aula1'];
        $obj['aula2'] = $reg['aula2'];
        $obj['aula3'] = $reg['aula3'];
        $obj['aula4'] = $reg['aula4'];
        $obj['aula5'] = $reg['aula5'];
        $res = $obj;
        $stmt = NULL;
        return $res;
    }
    
}