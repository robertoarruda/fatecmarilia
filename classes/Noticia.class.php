<?php

/**
 *
 * Classe para manipulação do objeto
 * Noticia
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class Noticia {

    /**
     * Variável para armazenamento o nome da tabela
     * */
    private $tabela;

    /**
     * Variáveis correspondentes aos campos da tabela
     * */
    private $dirImagem;
    private $dirImagemAlbum;
    private $codigo;
    private $data;
    private $prioridade;
    private $titulo;
    private $urlTitulo;
    private $resumo;
    private $conteudo;
    private $imagem;
    private $linkTitulo;
    private $linkUrl;
    private $linkTarget;
    private $status;
    private $funcionarios_funcionariosLogin_cpf;
    private $dataAlteracao;
    private $cpfAlteracao;

    public function __construct() {
        $this->dirImagem = 'imagens/noticias/';
        $this->dirImagemAlbum = $this->dirImagem . "albuns/";
        $this->tabela = 'noticias';
        $this->funcionarios_funcionariosLogin_cpf = new Funcionario();
        $this->limite_titulo = 70;
        $this->limite_resumo = 160;
        $this->limite_linkTitulo = 100;
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
                urlTitulo,
                resumo,
                conteudo,
                imagem,
                linkTitulo,
                linkUrl,
                linkTarget,
                status,
                funcionarios_funcionariosLogin_cpf,
                dataAlteracao,
                cpfAlteracao
            )
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array(
            $this->codigo,
            $this->data,
            $this->prioridade,
            $this->titulo,
            $this->urlTitulo,
            $this->resumo,
            $this->conteudo,
            $this->imagem,
            $this->linkTitulo,
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
                urlTitulo = ?,
                resumo = ?,
                conteudo = ?,
                imagem = ?,
                linkTitulo = ?,
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
            $this->urlTitulo,
            $this->resumo,
            $this->conteudo,
            $this->imagem,
            $this->linkTitulo,
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
            $obj = new Noticia();
            $obj->codigo = stripslashes($reg['codigo']);
            $obj->data = stripslashes($reg['data']);
            $obj->prioridade = stripslashes($reg['prioridade']);
            $obj->titulo = stripslashes($reg['titulo']);
            $obj->urlTitulo = stripslashes($reg['urlTitulo']);
            $obj->resumo = stripslashes($reg['resumo']);
            $obj->conteudo = stripslashes($reg['conteudo']);
            $obj->imagem = stripslashes($reg['imagem']);
            $obj->linkTitulo = stripslashes($reg['linkTitulo']);
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
            $obj = new Noticia();
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
            $obj = new Noticia();
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
    
    public function retornaAtivoNoticia($p1, $p2, $p3, $p4) {
        $strSQL = "
            SELECT codigo
            FROM $this->tabela
            WHERE status = 'A'
            AND urlTitulo = ?
            AND YEAR(data) = ?
            AND MONTH(data) = ?
            AND DAY(data) = ?
            LIMIT 1
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1, $p2, $p3, $p4);
        $stmt->execute($data);
        $res = ($stmt->rowCount() > 0) ? true : false;
        if ($res) {
            $reg = $stmt->fetch();
            $obj = new Noticia();
            $obj = $obj->consultar($reg['codigo']);
            $res = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarAtivoMain() {
        $strSQL = "
            SELECT codigo, prioridade, data
            FROM $this->tabela
            WHERE status = 'A'
            ORDER BY prioridade, data DESC
            LIMIT 3
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Noticia();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarAtivoLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT codigo, prioridade, data
            FROM $this->tabela
            WHERE status = 'A'
            ORDER BY prioridade, data DESC
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Noticia();
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
            $obj = new Noticia();
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

    public function listarAtivoDataLimitado($p1, $p2 = 0) {
        $strSQL = "
            SELECT codigo, data
            FROM $this->tabela
            WHERE status = 'A'
            ORDER BY data DESC
            LIMIT $p2, $p1
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $stmt->execute();
        while ($reg = $stmt->fetch()) {
            $obj = new Noticia();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }

    public function listarAtivoDepartamentoLimitado($p1, $p2, $p3 = 0) {
        $strSQL = "
            SELECT
                n.codigo, n.prioridade, n.data
            FROM $this->tabela n
            INNER JOIN administrativos_cargos ac
            ON n.funcionarios_funcionariosLogin_cpf = ac.administrativos_funcionarios_funcionariosLogin_cpf
            INNER JOIN cargos c
            ON ac.cargos_codigo = c.codigo
            INNER JOIN departamentos d
            ON c.departamentos_codigo = d.codigo
            WHERE n.status = 'A'
            AND d.codigo = ?
            ORDER BY n.prioridade, n.data DESC
            LIMIT $p3, $p2
        ";
        $res = NULL;
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p1);
        $stmt->execute($data);
        while ($reg = $stmt->fetch()) {
            $obj = new Noticia();
            $obj = $obj->consultar($reg['codigo']);
            $res[] = $obj;
        }
        $stmt = NULL;
        return $res;
    }
    
    public function qtdAtivoDepartamentoRegistros($p) {
        $strSQL = "
            SELECT n.codigo
            FROM $this->tabela n
            INNER JOIN administrativos_cargos ac
            ON n.funcionarios_funcionariosLogin_cpf = ac.administrativos_funcionarios_funcionariosLogin_cpf
            INNER JOIN cargos c
            ON ac.cargos_codigo = c.codigo
            INNER JOIN departamentos d
            ON c.departamentos_codigo = d.codigo
            WHERE n.status = 'A'
            AND d.codigo = ?
        ";
        $stmt = BD::getConn()->prepare($strSQL);
        $data = array($p);
        $stmt->execute($data);
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
            $obj = new Noticia();
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
            $obj = new Noticia();
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