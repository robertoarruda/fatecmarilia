<?php
/**
 *
 * Classe para manipulação do objeto
 * Funcionário
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class Funcionario {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $funcionariosLogin_cpf;
    private $nome;
    private $nomeAbreviado;
    private $sexo;
    private $dataNascimento;
    private $foto;
  
    /**
     * Variáveis para armazenamento o tipo de funcionário usada somente em Sessão
     * Funcionário ou Professor
     * */
    private $tipo;
    private $tipoUrl;

    /**
     * Variáveis para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_nome;

    public function __construct() {
        $this->dirFoto = 'imagens/layout/conteudo/funcionarios/';
        $this->tabela = 'funcionarios';
        $this->funcionariosLogin_cpf = new FuncionarioLogin();
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
                funcionariosLogin_cpf,
                nome,
                nomeAbreviado,
                sexo,
                dataNascimento,
                foto
            )
            VALUES(?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->funcionariosLogin_cpf->cpf,
            _funcoes::tratarNome($this->nome),
            _funcoes::abreviarNome(_funcoes::tratarNome($this->nome), 35),
            $this->sexo,
            $this->dataNascimento,
            $this->foto
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
                nomeAbreviado = ?,
                sexo = ?,
                dataNascimento = ?,
                foto = ?
            WHERE funcionariosLogin_cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            _funcoes::tratarNome($this->nome),
            _funcoes::abreviarNome(_funcoes::tratarNome($this->nome), 35),
            $this->sexo,
            $this->dataNascimento,
            $this->foto,
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
            WHERE funcionariosLogin_cpf = ?
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
            WHERE funcionariosLogin_cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new Funcionario();
            $obj->funcionariosLogin_cpf->cpf = stripslashes($reg['funcionariosLogin_cpf']);
            $obj->nome = stripslashes($reg['nome']);
            $obj->nomeAbreviado = stripslashes($reg['nomeAbreviado']);
            $obj->sexo = stripslashes($reg['sexo']);
            $obj->dataNascimento = stripslashes($reg['dataNascimento']);
            $obj->foto = stripslashes($reg['foto']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT f.funcionariosLogin_cpf, fl.situacao, f.nome
            FROM $this->tabela f
            INNER JOIN funcionarioslogin fl
            ON f.funcionariosLogin_cpf = fl.cpf
            ORDER BY fl.situacao, f.nome
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Funcionario();
            $obj = $obj->consultar($reg['funcionariosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT f.funcionariosLogin_cpf, fl.situacao, fl.ultimoAcesso, f.nome
            FROM $this->tabela f
            INNER JOIN funcionarioslogin fl
            ON f.funcionariosLogin_cpf = fl.cpf
            ORDER BY fl.situacao, fl.ultimoAcesso DESC, f.nome
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Funcionario();
            $obj = $obj->consultar($reg['funcionariosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT funcionariosLogin_cpf
            FROM $this->tabela
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    //----- METODOS PERSONALIZADOS ------------------------------------------------------
    
    public function consultarAtivos($p) {
        $strSQL = "
            SELECT f.funcionariosLogin_cpf, f.nome
            FROM $this->tabela f
            INNER JOIN funcionarioslogin fl
            ON f.funcionariosLogin_cpf = fl.cpf
            WHERE f.funcionariosLogin_cpf = ?
            AND fl.situacao = 'A'
            ORDER BY f.nome
            LIMIT 1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $reg = $stmt->fetch();
        $obj = new Funcionario();
        $res = $obj->consultar($reg['funcionariosLogin_cpf']);
        $stmt = NULL;
        return $res;
    }
}