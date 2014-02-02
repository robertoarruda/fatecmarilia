<?php
/**
 *
 * Classe para manipulação do objeto
 * Destaque
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class Destaque {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;
    
    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $codigo;
    private $data;
    private $prioridade;
    private $titulo;
    private $resumo;
    private $imagem;
    private $posicaoTitulo;
    private $linkUrl;
    private $linkTarget;
    private $status;
    private $funcionarios_funcionariosLogin_cpf;
    private $dataAlteracao;
    private $cpfAlteracao;
            
    /**
     * Variável para armazenamento o do caminho do diretório
     * de imagens correspondente
     * */
    private $dirImagem;

    /**
     * Variáveis para armazenamento do tamanho limite dos campos
     * no banco de dados
     * */
    private $limite_titulo;
    private $limite_resumo;
    private $limite_linkUrl;

    public function __construct() {
        $this->dirImagem = 'imagens/noticias/';
        $this->tabela = 'destaques';
        $this->funcionarios_funcionariosLogin_cpf = new Funcionario();
        $this->limite_titulo = 70;
        $this->limite_resumo = 160;
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
                codigo,
                data,
                prioridade,
                titulo,
                resumo,
                imagem,
                posicaoTitulo,
                linkUrl,
                linkTarget,
                status,
                funcionarios_funcionariosLogin_cpf,
                dataAlteracao,
                cpfAlteracao
            )
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->codigo,
            $this->data,
            $this->prioridade,
            $this->titulo,
            $this->resumo,
            $this->imagem,
            $this->posicaoTitulo,
            $this->linkUrl,
            $this->linkTarget,
            $this->status,
            $this->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf,
            $this->dataAlteracao,
            $this->cpfAlteracao
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
                prioridade = ?,
                titulo = ?,
                resumo = ?,
                imagem = ?,
                posicaoTitulo = ?,
                linkUrl = ?,
                linkTarget = ?,
                status = ?,
                funcionarios_funcionariosLogin_cpf = ?,
                dataAlteracao = ?,
                cpfAlteracao = ?
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->data,
            $this->prioridade,
            $this->titulo,
            $this->resumo,
            $this->imagem,
            $this->posicaoTitulo,
            $this->linkUrl,
            $this->linkTarget,
            $this->status,
            $this->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf,
            $this->dataAlteracao,
            $this->cpfAlteracao,
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
            $obj = new Destaque();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->data = stripslashes($reg['data']);
            $obj->prioridade = stripslashes($reg['prioridade']);
            $obj->titulo = stripslashes($reg['titulo']);
            $obj->resumo = stripslashes($reg['resumo']);
            $obj->imagem = stripslashes($reg['imagem']);
            $obj->posicaoTitulo = stripslashes($reg['posicaoTitulo']);
            $obj->linkUrl = stripslashes($reg['linkUrl']);
            $obj->linkTarget = stripslashes($reg['linkTarget']);
            $obj->status = stripslashes($reg['status']);
            $obj->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = stripslashes($reg['funcionarios_funcionariosLogin_cpf']);
            $obj->dataAlteracao = stripslashes($reg['dataAlteracao']);
            $obj->cpfAlteracao = stripslashes($reg['cpfAlteracao']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT codigo, prioridade, data
            FROM $this->tabela
            ORDER BY prioridade, data DESC
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Destaque();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarTudo() {
        $strSQL = "
            SELECT codigo, prioridade, data
            FROM $this->tabela
            ORDER BY prioridade, data DESC
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Destaque();
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

    public function ativar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                status = 'A'
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }
    
    public function desativar($p) {
        $strSQL = "
            UPDATE $this->tabela
            SET
                status = 'D'
            WHERE codigo = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $res = $stmt->execute($data);
        $stmt = NULL;
        return $res;
    }

    public function listarAtivoSlides($p = 'ASC') {
        if ($p == 'ASC') {
            $from = "$this->tabela d";
            $data = 'DESC';
        } elseif ($p == 'DESC') {
            $from = "
                (
                    SELECT *
                    FROM $this->tabela
                    WHERE status = 'A'
                    ORDER BY prioridade, data DESC
                    LIMIT 5
                ) d
            ";
            $data = 'ASC';
        }
        $strSQL = "
            SELECT d.codigo, d.prioridade, d.data
            FROM $from
            WHERE d.status = 'A'
            ORDER BY d.prioridade $p, d.data $data
            LIMIT 5
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Destaque();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarAtivoTudo() {
        $strSQL = "
            SELECT codigo, prioridade, data
            FROM $this->tabela
            WHERE status = 'A'
            ORDER BY prioridade, data DESC
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Destaque();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdAtivoRegistros() {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE status = 'A'
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    public function listarDesativoTudo() {
        $strSQL = "
            SELECT codigo, prioridade, data
            FROM $this->tabela
            WHERE status = 'D'
            ORDER BY prioridade, data DESC
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Destaque();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdDesativoRegistros() {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE status = 'D'
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

    public function listarPendenteTudo() {
        $strSQL = "
            SELECT codigo, prioridade, data
            FROM $this->tabela
            WHERE status = 'P'
            ORDER BY prioridade, data DESC
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Destaque();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function qtdPendenteRegistros() {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE status = 'P'
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        $res = $stmt->rowCount();
        $stmt = NULL;
        return $res;
    }

}