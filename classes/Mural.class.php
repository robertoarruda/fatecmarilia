<?php
/**
 *
 * Classe para manipulação do objeto
 * Mural
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2013 - Roberto Arruda
 * @version    1.0 $ 2013-07-05 11:00:51 $
 */
class Mural {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $titulo;
    private $imagem;
    private $descricao;
    private $arquivo;
    private $linkUrl;
    private $departamento_codigo;
  
    /**
     * Variáveis para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_titulo;
    private $limite_descricao;
    private $limite_linkUrl;
    
    /**
     * Variável para armazenamento o do caminho do diretório
     * de imagens correspondente
     * */
    private $dirImagem;
    private $dirArquivo;

    public function __construct() {
        $this->dirImagem = 'imagens/mural/';
        $this->dirArquivo = 'arquivos/mural/';
        $this->tabela = 'murais';
        $this->departamento_codigo = new Departamento();
        $this->limite_titulo = 70;
        $this->limite_descricao = 100;
        $this->limite_linkUrl = 150;
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
                titulo,
                imagem,
                descricao,
                arquivo,
                linkUrl,
                departamento_codigo
            )
            VALUES(?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->titulo,
            $this->imagem,
            $this->descricao,
            $this->arquivo,
            $this->linkUrl,
            $this->departamento_codigo->codigo
        );
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function editar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                titulo = ?,
                imagem = ?,
                descricao = ?,
                arquivo = ?,
                linkUrl = ?,
                departamento_codigo = ?
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->titulo,
            $this->imagem,
            $this->descricao,
            $this->arquivo,
            $this->linkUrl,
            $this->departamento_codigo->codigo,
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
            $obj = new Mural();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->titulo = stripslashes($reg['titulo']);
            $obj->imagem = stripslashes($reg['imagem']);
            $obj->descricao = stripslashes($reg['descricao']);
            $obj->arquivo = stripslashes($reg['arquivo']);
            $obj->linkUrl = stripslashes($reg['linkUrl']);
            $obj->departamento_codigo->codigo = stripslashes($reg['departamento_codigo']);
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
            $obj = new Mural();
            $obj = $obj->consultar($reg['codigo']);
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
            $obj = new Mural();
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
    
    public function listarTudoDepartamento($p) {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE departamento_codigo = ?
            ORDER BY codigo
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        while ($reg = $stmt->fetch()) {
            $obj = new Mural();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdRegistrosDepartamento($p) {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE departamento_codigo = ?
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }    
}