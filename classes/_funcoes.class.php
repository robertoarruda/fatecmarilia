<?php

/**
 *
 * Classe para manipulação do funções
 * diversas
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class _funcoes {

    public static function tratarNome($str) {
        $res = "";
        $str = explode(" ", strtolower(trim($str))); // Converter o nome todo para minúsculo e separa o nome por espaços
        for ($i = 0; $i < count($str); $i++) {

            // Tratar cada palavra do nome
            $c = array("de", "das", "da", "e", "dos", "do", "del");
            if (in_array($str[$i], $c)) {
                $res .= $str[$i] . ' '; // Se a palavra estiver dentro das complementares mostrar toda em minúsculo
            } else {
                $res .= ucfirst($str[$i]) . ' '; // Se for um nome, mostrar a primeira letra maiúscula
            }
        }
        return trim($res);
    }
    
    public static function abreviarNome($str, $length) {
        $str = trim($str);
        $loop = 0;
        while ((strlen($str) > $length) && ($loop < 10)) {
            $loop++;
            $res = "";
            $str = explode(" ", $str);
            $res .= $str[0] . ' ';
            $a = false;
            $c = array("de", "das", "da", "e", "dos", "do", "del");
            for ($i = 1; $i < count($str); $i++) {
                if ((in_array($str[$i], $c)) || ($str[$i][1] == ".") || ($a)){
                    $res .= $str[$i] . ' ';
                } else {
                    $res .= $str[$i][0] . '. ';
                    $a = true;
                }
            }
            $str = trim($res);
        }
        if ($loop >= 10) {
            $res = explode(" ", $str);
            $str = trim($res[0] . ' ' . $res[1][0] . '.');
        }
        return $str;
    }

    public static function urlString($str) {
        $str = trim(substr($str, 0, 140));
        $org = array(
            ' ', ' ', '/', '~', 'á', 'é',
            'í', 'ó', 'ú', 'à', 'è', 'ì',
            'ò', 'ù', 'â', 'ê', 'î', 'ô',
            'û', 'ä', 'ë', 'ï', 'ö', 'ü',
            'ã', 'õ', 'ç', 'ñ', 'Á', 'É',
            'Í', 'Ó', 'Ú', 'À', 'È', 'Ì',
            'Ò', 'Ù', 'Â', 'Ê', 'Î', 'Ô',
            'Û', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü',
            'Ã', 'Õ', 'Ç', 'Ñ', '!', '?',
            '@', '#', '$', '%', '�', '&',
            '*', '(', ')', '+', '=', '�',
            '�', '{', '}', '[', ']', '^',
            '.', ',', ':', ';', '�', '\'',
            '\"', '|', '¨', '¹', '²', '³',
            '£', '¢', '¬', '§', 'ª', 'º',
            '°', '´', '`', '_', '–', '“',
            '”', "'", '"'
        );
        $corrig = array(
            '-', '-', '-', '-', 'a', 'e',
            'i', 'o', 'u', 'a', 'e', 'i',
            'o', 'u', 'a', 'e', 'i', 'o',
            'u', 'a', 'e', 'i', 'o', 'u',
            'a', 'o', 'c', 'n', 'A', 'E',
            'I', 'O', 'U', 'A', 'E', 'I',
            'O', 'U', 'A', 'E', 'I', 'O',
            'U', 'A', 'E', 'I', 'O', 'U',
            'A', 'O', 'C', 'N', '', '',
            '', '', '', '', '', '',
            '', '', '', '', '', '',
            '', '', '', '', '', '',
            '', '', '', '', '', '',
            '', '', '', '1', '2', '3',
            '', '', '', '', 'a', 'o',
            'o', '', '', '-', '-', '',
            '', '', ''
        );
        return str_replace($org, $corrig, $str);
    }

    /**
     * Retorna informaçõe sobre a url passada
     * @param String $url a ser consultada
     * @param String $tipo pode se 'dir', 'arq', 'ext' ou 'nome'
     * @return String com as informações solicitadas
     * */
    public static function extrairInfoArq($url, $tipo = 'arq') {

        $res = pathinfo($url);
        switch ($tipo) {
            case 'dir':
                $res = $res['dirname'];
                break;
            case 'arq':
                $res = $res['basename'];
                break;
            case 'ext':
                $res = $res['extension'];
                break;
            case 'nome':
                $res = $res['filename'];
                break;
        }
        return $res;
    }

    public static function error404($url) {
        header('HTTP/1.0 404 Not Found');
        header('Status: 404 Not Found');
        print "
        <script src=\"/js/jquery-1.9.1.min.js\"></script>
        <script>
            $.post('/404.php',
            {
                url:'$url'
            },
            function(res){
                $('body').empty().html(res);
            });
        </script>";
        die();
    }

    public static function error401($url) {
        header('HTTP/1.0 401 Unauthorized');
        header('Status: 401 Unauthorized');
        print "
        <script src=\"/js/jquery-1.9.1.min.js\"></script>
        <script>
            $.post('/401.php',
            {
                url:'$url'
            },
            function(res){
                $('body').empty().html(res);
            });
        </script>";
        die();
    }

    public static function error500($error) {
        header('HTTP/1.0 500 Internal Server Error');
        header('Status: 500 Internal Server Error');
        print "
            <script src=\"/js/jquery-1.9.1.min.js\"></script>
            <script>
                $.post('/500.php',
                {
                    error:'$error'
                },
                function(res){
                    $('body').empty().html(res);
                    
                });
            </script>
        ";
        die();
    }

    public static function gerarCodAleatorio($tamanho = 6, $numerico = false, $forca = 0) {
        if (!$numerico) {
            $vogais = 'aeiou';
            $consoantes = 'bcdfghjmnpqrstvwxyz';
            if ($forca >= 1) {
                $consoantes .= 'BCDFGHJLMNPQRSTVWXYZ';
            } elseif ($forca >= 2) {
                $vogais .= "AEU";
            } elseif ($forca >= 4) {
                $vogais .= '24680';
                $consoantes .= '13579';
            } elseif ($forca >= 8) {
                $vogais .= '@#$%';
            }
        } else {
            $vogais = '24680'; //pares
            $consoantes = '13579'; //impares
        }
        $codigo = '';
        $alt = time() % 2;
        for ($i = 0; $i < $tamanho; $i++) {
            if ($alt == 1) {
                $codigo .= $consoantes[(rand() % strlen($consoantes))];
                $alt = 0;
            } else {
                $codigo .= $vogais[(rand() % strlen($vogais))];
                $alt = 1;
            }
        }
        return $codigo;
    }

    public static function excluirDir($dir){
        $res = false;
        $dir = trim($dir, '/');
        if (is_dir($dir)) {
            $dd = opendir($dir);
            if ($dd) {
                while (false !== ($arq = readdir($dd))) {
                    if ($arq != "." && $arq != "..") {
                        $path = "$dir/$arq";
                        if (is_dir($path))
                            _funcoes::excluirDir($path);
                        elseif (is_file($path))
                            unlink($path);
                    }
                }
                closedir($dd);
            }
            if (rmdir($dir))
                $res = true;
        }
        return $res;
    }
    
    /**
     * Verifica se o arquivo indicado é uma imagem
     * @return Boolean true/false
     * */
    public static function isImage($file) {
        // filtra extensão
        if ($file) {
            $valida = getimagesize($file);
            if (!is_array($valida) || empty($valida))
                return false;
            else
                return true;
        } else 
            return false;
    }
    
    public static function utf8_TO_iso88591($msg){
        $accents = array(
            "á", "à", "â", "ã", "ä", "é", "è", "ê",
            "ë", "í", "ì", "î", "ï", "ó", "ò", "ô",
            "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á",
            "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë",
            "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ",
            "Ö", "Ú", "Ù", "Û", "Ü", "Ç"
        );
        $utf8 = array(
            "Ã¡", "Ã ", "Ã¢", "Ã£", "Ã¤", "Ã©", "Ã¨", "Ãª",
            "Ã«", "Ã­", "Ã¬", "Ã®", "Ã¯", "Ã³", "Ã²", "Ã´",
            "Ãµ", "Ã¶", "Ãº", "Ã¹", "Ã»", "Ã¼", "Ã§", "Ã",
            "Ã€", "Ã‚", "Ãƒ", "Ã„", "Ã‰", "Ãˆ", "ÃŠ", "Ã‹",
            "Ã", "ÃŒ", "ÃŽ", "Ã", "Ã“", "Ã’", "Ã”", "Ã•",
            "Ã–", "Ãš", "Ã™", "Ã›", "Ãœ", "Ã‡"
        );
        $fix = str_replace($utf8, $accents, $msg);
        return $fix;
    }

    /**
     * Função que converte caracteres ISO-8859-1 para UTF-8, mantendo os caracteres UTF-8 intactos.
     * @param string $texto
     * @return string
     */
    public static function iso88591_TO_utf8($texto) {
        $saida = '';

        $i = 0;
        $len = strlen($texto);
        while ($i < $len) {
            $char = $texto[$i++];
            $ord  = ord($char);

            // Primeiro byte 0xxxxxxx: simbolo ascii possui 1 byte
            if (($ord & 0x80) == 0x00) {

                // Se e' um caractere de controle
                if (($ord >= 0 && $ord <= 31) || $ord == 127) {

                    // Incluir se for: tab, retorno de carro ou quebra de linha
                    if ($ord == 9 || $ord == 10 || $ord == 13) {
                        $saida .= $char;
                    }

                // Simbolo ASCII
                } else {
                    $saida .= $char;
                }

            // Primeiro byte 110xxxxx ou 1110xxxx ou 11110xxx: simbolo possui 2, 3 ou 4 bytes
            } else {

                // Determinar quantidade de bytes analisando os bits da esquerda para direita
                $bytes = 0;
                for ($b = 7; $b >= 0; $b--) {
                    $bit = $ord & (1 << $b);
                    if ($bit) {
                        $bytes += 1;
                    } else {
                        break;
                    }
                }

                switch ($bytes) {
                case 2: // 110xxxxx 10xxxxxx
                case 3: // 1110xxxx 10xxxxxx 10xxxxxx
                case 4: // 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx
                    $valido = true;
                    $saida_padrao = $char;
                    $i_inicial = $i;
                    for ($b = 1; $b < $bytes; $b++) {
                        if (!isset($texto[$i])) {
                            $valido = false;
                            break;
                        }
                        $char_extra = $texto[$i++];
                        $ord_extra  = ord($char_extra);

                        if (($ord_extra & 0xC0) == 0x80) {
                            $saida_padrao .= $char_extra;
                        } else {
                            $valido = false;
                            break;
                        }
                    }
                    if ($valido) {
                        $saida .= $saida_padrao;
                    } else {
                        $saida .= ($ord < 0x7F || $ord > 0x9F) ? utf8_encode($char) : '';
                        $i = $i_inicial;
                    }
                    break;
                case 1:  // 10xxxxxx: ISO-8859-1
                default: // 11111xxx: ISO-8859-1
                    $saida .= ($ord < 0x7F || $ord > 0x9F) ? utf8_encode($char) : '';
                    break;
                }
            }
        }
        return $saida;
    }

}
?>