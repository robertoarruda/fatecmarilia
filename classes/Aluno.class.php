<?php
/**
 *
 * Classe para manipulação do objeto
 * Aluno
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2013-07-23 11:41:32 $
 */
class Aluno {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $alunosLogin_cpf;
    private $nome;
    private $nomeAbreviado;
    private $sexo;
    private $dataNascimento;
    private $foto;
    private $estadoCivil;
    private $endereco;
    private $complemento;
    private $bairro;
    private $cep;
    private $estado;
    private $cidade;
    private $telefone;
    private $celular;
    private $telefoneRecado;
    private $nomeRecado;
  
    /**
     * Variáveis para armazenamento o tipo de funcionário usada somente em Sessão
     * Aluno
     * */
    private $tipo;
    private $tipoUrl;

    /**
     * Variáveis para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_nome;
    private $limite_endereco;
    private $limite_complemento;
    private $limite_bairro;
    private $limite_nomeRecado;

    public function __construct() {
        $this->dirFoto = 'imagens/layout/conteudo/alunos/';
        $this->tabela = 'alunos';
        $this->alunosLogin_cpf = new AlunoLogin();
        $this->limite_nome = 50;
        $this->limite_endereco = 100;
        $this->limite_complemento = 50;
        $this->limite_bairro = 50;
        $this->limite_nomeRecado = 50;
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
                alunosLogin_cpf,
                nome,
                nomeAbreviado,
                sexo,
                dataNascimento,
                foto,
                estadoCivil,
                endereco,
                complemento,
                bairro,
                cep,
                estado,
                cidade,
                telefone,
                celular,
                telefoneRecado,
                nomeRecado
            )
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->alunosLogin_cpf->cpf,
            _funcoes::tratarNome($this->nome),
            _funcoes::abreviarNome(_funcoes::tratarNome($this->nome), 35),
            $this->sexo,
            $this->dataNascimento,
            $this->foto,
            $this->estadoCivil,
            $this->endereco,
            $this->complemento,
            $this->bairro,
            $this->cep,
            $this->estado,
            $this->cidade,
            $this->telefone,
            $this->celular,
            $this->telefoneRecado,
            $this->nomeRecado
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
                foto = ?,
                estadoCivil = ?,
                endereco = ?,
                complemento = ?,
                bairro = ?,
                cep = ?,
                estado = ?,
                cidade = ?,
                telefone = ?,
                celular = ?,
                telefoneRecado = ?,
                nomeRecado = ?
            WHERE alunosLogin_cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            _funcoes::tratarNome($this->nome),
            _funcoes::abreviarNome(_funcoes::tratarNome($this->nome), 35),
            $this->sexo,
            $this->dataNascimento,
            $this->foto,
            $this->estadoCivil,
            $this->endereco,
            $this->complemento,
            $this->bairro,
            $this->cep,
            $this->estado,
            $this->cidade,
            $this->telefone,
            $this->celular,
            $this->telefoneRecado,
            $this->nomeRecado,
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
            WHERE alunosLogin_cpf = ?
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
            WHERE alunosLogin_cpf = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new Aluno();
            $obj->alunosLogin_cpf->cpf = stripslashes($reg['alunosLogin_cpf']);
            $obj->nome = stripslashes($reg['nome']);
            $obj->nomeAbreviado = stripslashes($reg['nomeAbreviado']);
            $obj->sexo = stripslashes($reg['sexo']);
            $obj->dataNascimento = stripslashes($reg['dataNascimento']);
            $obj->foto = stripslashes($reg['foto']);
            $obj->estadoCivil = stripslashes($reg['estadoCivil']);
            $obj->endereco = stripslashes($reg['endereco']);
            $obj->complemento = stripslashes($reg['complemento']);
            $obj->bairro = stripslashes($reg['bairro']);
            $obj->cep = stripslashes($reg['cep']);
            $obj->estado = stripslashes($reg['estado']);
            $obj->cidade = stripslashes($reg['cidade']);
            $obj->telefone = stripslashes($reg['telefone']);
            $obj->celular = stripslashes($reg['celular']);
            $obj->telefoneRecado = stripslashes($reg['telefoneRecado']);
            $obj->nomeRecado = stripslashes($reg['nomeRecado']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT a.alunosLogin_cpf, al.situacao, a.nome
            FROM $this->tabela a
            INNER JOIN alunoslogin al
            ON a.alunosLogin_cpf = al.cpf
            ORDER BY al.situacao, a.nome
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Aluno();
            $obj = $obj->consultar($reg['alunosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT a.alunosLogin_cpf, al.situacao, al.ultimoAcesso, a.nome
            FROM $this->tabela a
            INNER JOIN alunoslogin al
            ON a.alunosLogin_cpf = al.cpf
            ORDER BY al.situacao, al.ultimoAcesso DESC, a.nome
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Aluno();
            $obj = $obj->consultar($reg['alunosLogin_cpf']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistros() {
        $strSQL = "
            SELECT alunosLogin_cpf
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
            SELECT a.alunosLogin_cpf, a.nome
            FROM $this->tabela a
            INNER JOIN alunoslogin al
            ON a.alunosLogin_cpf = al.cpf
            WHERE a.alunosLogin_cpf = ?
            AND al.situacao = 'A'
            ORDER BY a.nome
            LIMIT 1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $reg = $stmt->fetch();
        $obj = new Funcionario();
        $obj = $obj->consultar($reg['alunosLogin_cpf']);
        $res = $obj;
        $stmt = NULL;
        return $res;
    }
}