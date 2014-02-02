<?php
header("Content-Type: text/html; charset=utf-8", true);

$objI = new Instituicao();
$objI = $objI->consultar(1);

function corrigeArq($arq) {
    $arq = ltrim(str_replace('../', '', $arq),'/');
    $x = 0;
    while (($x < 10) && (!file_exists($arq))) {
        $arq = '../' . $arq;
        $x++;
    }
    if ($x == 10)
        return '#';
    else
        return $arq;
}

function __autoload($classe) {
    $pagina = corrigeArq(sprintf('classes/%s.class.php', $classe));
    require_once($pagina);
}

function returnGet($key, $default = '') {
    return (isset($_GET[$key])) ? $_GET[$key] : $default;
}

function returnPost($key, $default = '') {
    $res = $default;
    if (isset($_POST)) {
        if (array_key_exists($key, $_POST)) {
            $res = $_POST[$key];
        } elseif (array_key_exists('dados', $_POST)) {
            $array = $_POST['dados'];
            if (is_array($array)) {
                if (array_key_exists('0', $array)) {
                    for ($c = 0; $c < count($array); $c++) {
                        if ($array[$c]['name'] == $key) {
                            $res = $array[$c]['value'];
                        }
                    }
                }
            } else {
                $res = $array;
            }
        }
    }
    return $res;
}

?>