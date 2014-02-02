<?php
/**
 *
 * Classe para exibição de
 * arquivos
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class _arquivo {

    private $dir;
    private $extencoes;
    private $somenteArquivos;
    private $ordem;

    public function __construct($dir = '/') {
        $this->dir = $dir;
        $this->extencoes = 'all';
        $this->somenteArquivos = false;
        $this->ordem = 'crescente';
    }

    public function __destruct() {

    }

    public function __get($key) {
        return $this->$key;
    }

    public function __set($key, $value) {
        $this->$key = $value;
    }

    public function retornaArquivos() {
        $diretorio = $this->dir;
        $resultado = array();
        if (is_dir($diretorio)) {
            $dir = opendir($diretorio);
            if ($dir) {
                while ($arq = readdir($dir)) {
                    if (($this->somenteArquivos) && ($this->extencoes != 'all')) {
                        if ((is_file($diretorio . $arq)) && (in_array(pathinfo($arq, 4), $this->extencoes))) {
                            $resultado[] = $arq;
                        }
                    } elseif ($this->somenteArquivos) {
                        if (is_file($diretorio . $arq)) {
                            $resultado[] = $arq;
                        }
                    } elseif ($this->extencoes != 'all') {
                        if (in_array(pathinfo($arq, 4), $this->extencoes)) {
                            $resultado[] = $arq;
                        }
                    } else {
                        $resultado[] = $arq;
                    }
                }
            }
            closedir($dir);
        }
        if ($this->ordem == 'crescente')
            asort($resultado);
        else 
            rsort($resultado);
        
        return $resultado;
    }

    public function mostraArquivos() {
        $res = array();
        $array = $this->retornaArquivos();
        foreach ($array as $valor) {
            $res[] = iconv('iso-8859-1', 'utf-8', "$this->dir/$valor");
        }
        return $res;
    }
}