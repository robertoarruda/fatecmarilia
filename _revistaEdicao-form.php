<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('revista');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objRevista = new Revista();
$objAlbum = new _foto($objRevista->dirImagem);

$nomeArquivo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nomeArquivo = returnPost('nomeArquivo');
    $volume = returnPost('volume') + 0;
    $numero = returnPost('numero') + 0;
    $mes = returnPost('mes');
    $ano = returnPost('ano');
    $volume = ($volume < 10) ? "0$volume" : $volume;
    $numero = ($numero < 10) ? "0$numero" : $numero; 
    $nomeArquivoNovo = base64_encode("$volume-$numero-$mes-$ano");

    $dir = "/$tipoUrl/revista/edicoes/";
    $dir2 = "/$tipoUrl/revista/edicoes/" . _funcoes::urlString(strtolower("$volume-$numero-$mes-$ano")) . "/paginas.html";
    $erro = "
        <script>
        $.showMsg({
            msg: 'Ocorreu um erro na operação solicitada.',
            titulo: 'Erro'
        });
        </script>
    ";
    switch (strtolower(returnPost('acao'))) {
        case 'cadastrar':
            if (mkdir("$objAlbum->dir$nomeArquivoNovo", 0777)) {
                sleep(2);
                if (mkdir("$objAlbum->dir$nomeArquivoNovo/500x707", 0777))
                        print("
                    <script>
                    $.showMsg({
                        msg: 'Cadastro efetuado com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                        window.location = '$dir2';
                    });
                    </script>
                ");
                else
                    print($erro);
            } else
                print($erro);
            break;
        case 'alterar':
            if (rename("$objAlbum->dir$nomeArquivo", "$objAlbum->dir$nomeArquivoNovo"))
                print("
                    <script>
                    $.showMsg({
                        msg: 'Alteração efetuada com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                    window.location = '$dir';
                    });
                    </script>
                ");
            else
                print($erro);
            break;
        case 'excluir':
            if (unlink("$nomeArquivo"))
                print("
                    <script>
                    $.showMsg({
                        msg: 'Remoção efetuada com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                        window.location = '$dir';
                    });
                    </script>
                ");
            else
                print($erro);
            break;
    }
    die();
}
if (returnGet('c') != 'novo') {
    $nomeArquivo = $objAlbum->nomeDirReal(returnGet('c'));
    if (is_dir("'$objAlbum->dir$nomeArquivo'")) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}
$mes = array(
    'none' => '',
    'Janeiro' => '',
    'Fevereiro' => '',
    'Março' => '',
    'Abril' => '',
    'Maio' => '',
    'Junho' => '',
    'Julho' => '',
    'Agosto' => '',
    'Setembro' => '',
    'Outubro' => '',
    'Novembro' => '',
    'Dezembro' => ''
);
if ($nomeArquivo) {
    $n = explode('-', base64_decode($nomeArquivo));
    $volume = $n[0] + 0;
    $numero = $n[1] + 0;
    $mes[$n[2]] = ' selected';
    $ano = $n[3];
} else {
    $volume = '';
    $numero = '';
    $data = '';
    $mes['none'] = ' selected';
    $ano = date('Y', time());
}
$selectMes = "
    <option value=\"\"" . $mes['none'] . ">Selecione...</option>
    <option value=\"Janeiro\"" . $mes['Janeiro'] . ">Janeiro</option>
    <option value=\"Fevereiro\"" . $mes['Fevereiro'] . ">Fevereiro</option>
    <option value=\"Março\"" . $mes['Março'] . ">Março</option>
    <option value=\"Abril\"" . $mes['Abril'] . ">Abril</option>
    <option value=\"Maio\"" . $mes['Maio'] . ">Maio</option>
    <option value=\"Junho\"" . $mes['Junho'] . ">Junho</option>
    <option value=\"Julho\"" . $mes['Julho'] . ">Julho</option>
    <option value=\"Agosto\"" . $mes['Agosto'] . ">Agosto</option>
    <option value=\"Setembro\"" . $mes['Setembro'] . ">Setembro</option>
    <option value=\"Outubro\"" . $mes['Outubro'] . ">Outubro</option>
    <option value=\"Novembro\"" . $mes['Novembro'] . ">Novembro</option>
    <option value=\"Dezembro\"" . $mes['Dezembro'] . ">Dezembro</option>
";

$nameButton = ($nomeArquivo) ? 'Alterar' : 'Cadastrar';

$str = <<<STR
        <input
            id="nomeArquivo"
            name="nomeArquivo"
            type="hidden"
            value="$nomeArquivo"
        >
        <label for="volume">Volume</label>
        <input
            id="volume"
            name="volume"
            type="number"
            value="$volume"
            min="1"
        >
        <label for="numero">Número</label>
        <input
            id="numero"
            name="numero"
            type="number"
            value="$numero"
            min="1"
        >
        <label for="mes">Mês</label>
        <select
            id="mes"
            name="mes"
        >
            $selectMes
        </select>
        <label for="ano">Ano</label>
        <input
            id="ano"
            name="ano"
            type="number"
            value="$ano"
        >
    <div class="clear"></div>
    <div class="buttons">
        <input
            id="btnCancelar"
            name="btnCancelar"
            type="button"
            class="btnForm"
            title="Cancelar"
            value="Cancelar"
        >
        <input
            id="btnSalvar"
            name="btnSalvar"
            type="submit"
            class="btnForm"
            title="$nameButton"
            value="$nameButton"
            data-cod="$nomeArquivo"
        >
    </div>
STR;
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/_forms.css">
        <title><?php print "$objI->nomeFantasia - Revista Alimentus"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_revistaEdicao-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Revista Alimentus - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Edição</h1>
                        <form method="post">
                            <?php print $str; ?>
                        </form>
                    </article>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>