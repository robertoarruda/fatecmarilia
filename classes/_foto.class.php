<?php
/**
 *
 * Classe para exibição de album de fotos
 * e fotos
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class _foto {

    private $dir;
    private $tipo;

    public function __construct($d = 'imagens/fotos/', $t = array('jpg')) {
        $this->dir = $d;
        $this->tipo = $t;
    }

    public function __destruct() {

    }

    public function __get($key) {
        return $this->$key;
    }

    public function __set($key, $value) {
        $this->$key = $value;
    }

    private function diretorios($diretorio) {
        $resultado = array();
        if (is_dir($diretorio)) {
            $dir = opendir($diretorio);
            if ($dir) {
                while (false !== ($arq = readdir($dir))) {
                    if ((is_dir($diretorio . $arq)) && ($arq != '.') && ($arq != '..')) {
                        $resultado[] = $arq;
                    }
                }
            }
        }
        return $resultado;
    }

    private function arquivos($diretorio, $order = true) {
        $resultado = array();
        if (is_dir($diretorio)) {
            $dir = opendir($diretorio);
            if ($dir) {
                while (false !== ($arq = readdir($dir))) {
                    if ((is_file($diretorio . $arq)) && (in_array(pathinfo($arq, 4), $this->tipo))) {
                        $resultado[] = $arq;
                    }
                }
            }
        }
        if ($order)
            rsort($resultado);
        else
            asort($resultado);
        return $resultado;
    }

    private function albuns($diretorio) {
        $resultado['d'] = $resultado['a'] = array();
        if (is_dir($diretorio)) {
            $dir = opendir($diretorio);
            if ($dir) {
                while (false !== ($arq = readdir($dir))) {
                    if (($arq != '.') && ($arq != '..')) {
                        if (is_dir($diretorio . $arq)) {
                            $resultado['d'][$arq] = $this->albuns($diretorio . $arq . '/');
                        } elseif ((is_file($diretorio . $arq)) && (pathinfo($arq, 4) == 'jpg')) {
                            $resultado['a'][$arq] = $diretorio;
                        }
                    }
                }
            }
        }
        ksort($resultado['d']);
        asort($resultado['a']);
        return $resultado;
    }

    public function nomeDirReal($d, $dir = '') {
        $dir = rtrim("$this->dir$dir", '/') . '/';
        $array = $this->diretorios($dir);
        foreach ($array as $valor) {
            if ($d == strtolower(_funcoes::urlString(base64_decode($valor))))
                return $valor;
        }
    }
    
    public function mostrarAlbuns($dir = '') {
        $dir = rtrim("$this->dir$dir", '/') . '/';
        return $this->albuns($dir);
    }

    public function mostrarFotos($dir = '') {
        $dir = rtrim("$this->dir$dir", '/') . '/';
        $array2 = $this->arquivos($dir);
        return $array2;
    }

    public function mostrarFotosInvertido($dir = '') {
        $dir = rtrim("$this->dir$dir", '/') . '/';
        $array2 = $this->arquivos($dir, false);
        return $array2;
    }

}