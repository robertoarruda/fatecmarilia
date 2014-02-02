<?php
/**
 *
 * Classe para manipulação do objeto
 * Curso
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2013-07-17 14:39:23 $
 */
class CursoPos {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $tipo;
    private $nome;
    private $nomeCompleto;
    private $imagem;
    private $objetivo;
    private $publicoAlvo;
    private $quadroDeDisciplinas;
    private $duracao;
    private $instituicao_codigo;

    /**
     * Variável para armazenamento o do caminho do diretório
     * de imagens correspondente
     * */
    private $dirImagem;

    /**
     * Variáveis para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_nome;
    private $limite_nomeCompleto;

    public function __construct() {
        $this->dirImagem = 'imagens/layout/conteudo/';
        $this->tabela = 'cursospos';
        $this->instituicao_codigo = new Instituicao();
        $this->limite_nome = 50;
        $this->limite_duracao = 50;
        $this->limite_nomeCompleto = 100;
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
                tipo,
                nome,
                nomeCompleto,
                imagem,
                objetivo,
                publicoAlvo,
                quadroDeDisciplinas,
                duracao,
                instituicao_codigo
            )
            VALUES(?,?,?,?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->tipo,
            $this->nome,
            $this->nomeCompleto,
            $this->imagem,
            $this->objetivo,
            $this->publicoAlvo,
            $this->quadroDeDisciplinas,
            $this->duracao,
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
                tipo = ?,
                nome = ?,
                nomeCompleto = ?,
                imagem = ?,
                objetivo = ?,
                publicoAlvo = ?,
                quadroDeDisciplinas = ?,
                duracao = ?,
                instituicao_codigo = ?
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->tipo,
            $this->nome,
            $this->nomeCompleto,
            $this->imagem,
            $this->objetivo,
            $this->publicoAlvo,
            $this->quadroDeDisciplinas,
            $this->duracao,
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
            $obj = new CursoPos();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->tipo = stripslashes($reg['tipo']);
            $obj->nome = stripslashes($reg['nome']);
            $obj->nomeCompleto = stripslashes($reg['nomeCompleto']);
            $obj->imagem = stripslashes($reg['imagem']);
            $obj->objetivo = stripslashes($reg['objetivo']);
            $obj->publicoAlvo = stripslashes($reg['publicoAlvo']);
            $obj->quadroDeDisciplinas = stripslashes($reg['quadroDeDisciplinas']);
            $obj->duracao = stripslashes($reg['duracao']);
            $obj->instituicao_codigo->codigo = stripslashes($reg['instituicao_codigo']);
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
            $obj = new CursoPos();
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
            $obj = new CursoPos();
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
    
    public function consultarNome($p) {
        $strSQL = "
            SELECT codigo, nome
            FROM $this->tabela
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = false;
        while ($reg = $stmt->fetch()) {
            if ($p == _funcoes::urlString(strtolower($reg['nome']))) {
                $obj = new CursoPos();
                $obj = $obj->consultar($reg['codigo']);
                $res = $obj;
                break;
            }
        }
        $stmt = NULL;
        return $res;
    }
}