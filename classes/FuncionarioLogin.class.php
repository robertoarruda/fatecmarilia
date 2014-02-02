<?php

/**
 *
 * Classe para manipulação do objeto
 * Funcionário Login
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class FuncionarioLogin {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;

    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $cpf;
    private $email;
    private $senha;
    private $situacao; // A: Ativo; D: Desativo;
    private $ultimoAcesso;
    private $instituicao_codigo;
  
    /**
     * Variáveis para armazenamento o tipo de funcionário usada somente em Sessão
     * Funcionário ou Professor
     * */
    private $tipo;
    private $tipoUrl;

    /**
     * Variável para armazenamento o nome da $_SESSION de login
     * */
    private $nomeSessao;

    /**
     * Variável para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_email;
    private $limite_senha;

    public function __construct() {
        $this->tabela = 'funcionarioslogin';
        $this->nomeSessao = '_fatecmarilia';
        $this->instituicao_codigo = new Instituicao();
        $this->limite_email = 100;
        $this->limite_senha = 8;
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
                cpf,
                email,
                senha,
                situacao,
                ultimoAcesso,
                instituicao_codigo
            )
            VALUES(?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->cpf,
            $this->email,
            hash('sha512', stripslashes($this->senha)),
            $this->situacao,
            $this->ultimoAcesso,
            $this->instituicao_codigo->codigo
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function editar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                cpf = ?,
                email = ?,
                situacao = ?,
                ultimoAcesso = ?,
                instituicao_codigo = ?
            WHERE cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->cpf,
            $this->email,
            $this->situacao,
            $this->instituicao_codigo->codigo,
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
            WHERE cpf = ?
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
            WHERE cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new FuncionarioLogin();
            $obj->cpf = stripslashes($reg['cpf']);
            $obj->email = stripslashes($reg['email']);
            $obj->situacao = stripslashes($reg['situacao']);
            $obj->ultimoAcesso = stripslashes($reg['ultimoAcesso']);
            $obj->instituicao_codigo->codigo = stripslashes($reg['instituicao_codigo']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
            ORDER BY cpf
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new FuncionarioLogin();
            $obj = $obj->consultar($reg['cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
            ORDER BY cpf
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new FuncionarioLogin();
            $obj = $obj->consultar($reg['cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    //----- METODOS PERSONALIZADOS ------------------------------------------------------

    public function consultarSituacao($p) {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
            WHERE cpf = ?
            AND situacao = 'A'
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        $stmt = NULL;
        return $res;
    }

    public function alterarSituacao($p1, $p2) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                situacao = ?
            WHERE cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $p2,
            $p1
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function listarSemPerfil() {
        $strSQL = "
            SELECT fl.cpf
            FROM $this->tabela fl
            LEFT JOIN funcionarios f
            ON fl.cpf = f.funcionariosLogin_cpf
            WHERE f.funcionariosLogin_cpf IS NULL
            ORDER BY fl.cpf
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new FuncionarioLogin();
            $obj = $obj->consultar($reg['cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistrosSemPerfil() {
        $strSQL = "
            SELECT fl.cpf
            FROM $this->tabela fl
            LEFT JOIN funcionarios f
            ON fl.cpf = f.funcionariosLogin_cpf
            WHERE f.funcionariosLogin_cpf IS NULL
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }
    
    public function conferirSenha($p1, $p2) {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
            WHERE cpf = ?
            AND senha = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1, hash('sha512', stripslashes($p2)));
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        $stmt = NULL;
        return $res;
    }

    public function alterarSenha($p1, $p2) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                senha = ?
            WHERE cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(hash('sha512', stripslashes($p2)), $p1);
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function alterarUltimoAcesso($p1, $p2) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                ultimoAcesso = ?
            WHERE cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $p2,
            $p1
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function logar($p1, $p2) {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
            WHERE email = ?
            AND senha = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1, hash('sha512', $p2));
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new FuncionarioLogin();
            $obj->alterarUltimoAcesso($reg['cpf'], date('Y-m-d H:i:s', time()));
            $obj = $obj->consultar($reg['cpf']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function gerarSessao($p1, $p2) {
        $objFuncionario = new Funcionario();
        $objFuncionario = $objFuncionario->consultar($p1);
        $objFuncionario->tipo = $p2;
        $objFuncionario->tipoUrl = utf8_decode(_funcoes::urlString(strtolower($p2)));
        @session_start();
        if (isset($_SESSION["$this->nomeSessao"]))
            @session_unset($_SESSION["$this->nomeSessao"]);
        $_SESSION["$this->nomeSessao"] = $objFuncionario;
    }

    public function checaLogin($p) {
        if ($p) {
            $objNiveisDeAcesso = new NivelDeAcesso();
            $objNiveisDeAcesso->setarNivel($p);
        }
        @session_start();
        if (!isset($_SESSION["$this->nomeSessao"])) {
            if ((!isset($_SESSION["$this->nomeSessao" . "Temp"])) || ($p != "perfil")) {
                header('Location: /logout/');
                die();
            }
        } elseif ($p) {
            if (!$this->checaPermissao($p)) {
                $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
                _funcoes::error401($url);
            }
        }
    }
    
    public function checaPermissao($p) {
        $objNiveisDeAcesso = new NivelDeAcesso();
        $objAdministrativo = new Administrativo();
        $objAcademico = new Academico();

        $cpf = $this->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;
        if (!$cpf)
            $cpf = $this->retornaSessaoTemp()->cpf;
        
        $res = false;
        $objNA = $objNiveisDeAcesso->consultar($p);
        if ($objNA) {
            if ($objAdministrativo->consultar($cpf)) {
                $objAdministrativo_Cargo = new Administrativo_Cargo();
                $objCargo_NiveisDeAcesso = new Cargo_NivelDeAcesso();
                $objAC = $objAdministrativo_Cargo->listarTudoFuncionario($cpf);
                if ($objAC) {
                    for ($c = 0; $c < count($objAC); $c++) {
                        $obj = $objAC[$c];
                        if ($objCargo_NiveisDeAcesso->consultar($obj->cargos_codigo->codigo, $objNA->codigo))
                            $res = true;
                    }
                }
            }
            if ($objAcademico->consultar($cpf)) {
                $objAcademico_NiveisDeAcesso = new Academico_NivelDeAcesso();
                if ($objAcademico_NiveisDeAcesso->consultar($objNA->codigo))
                    $res = true;
            }
        }
        return $res;
    }

    public function retornaFuncionarioSessao() {
        $res = false;
        @session_start();
        if (isset($_SESSION["$this->nomeSessao"]))
            $res = $_SESSION["$this->nomeSessao"];
        return $res;
    }
    
    public function editarFuncionarioSessao($p1, $p2) {
        $res = 0;
        @session_start();
        if (isset($_SESSION["$this->nomeSessao"]))
            $_SESSION["$this->nomeSessao"]->$p1 = $p2;
        return $res;
    }
    
    public function consultarCpfEmail($p1, $p2) {
        $strSQL = "
            SELECT cpf
            FROM $this->tabela
            WHERE cpf = ?
            AND email = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1, $p2);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new FuncionarioLogin();
            $obj = $obj->consultar($reg['cpf']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function gerarSessaoTemp($p1, $p2) {
        @session_start();
        if (isset($_SESSION["$this->nomeSessao" . "Temp"]))
            @session_unset($_SESSION["$this->nomeSessao" . "Temp"]);
        $objFL = new FuncionarioLogin();
        $objFL = $objFL->consultar($p1);
        $objFL->tipo = $p2;
        $objFL->tipoUrl = utf8_decode(_funcoes::urlString(strtolower($p2)));
        $_SESSION["$this->nomeSessao" . "Temp"] = $objFL;
    }
    
    public function retornaSessaoTemp() {
        $res = false;
        @session_start();
        if (isset($_SESSION["$this->nomeSessao" . "Temp"]))
            $res = $_SESSION["$this->nomeSessao" . "Temp"];
        return $res;
    }
}