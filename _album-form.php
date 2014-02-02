<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('album');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objAlbum = new _foto();

$nomeArquivo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nomeArquivo = returnPost('nomeArquivo');
    $nomeArquivoNovo = base64_encode(returnPost('nomeArquivoNovo'));

    $dir = "/$tipoUrl/albuns/";
    $dir2 = "/$tipoUrl/albuns/" . _funcoes::urlString(strtolower(returnPost('nomeArquivoNovo'))) . "/fotos.html";
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
                if (mkdir("$objAlbum->dir$nomeArquivoNovo/196x196", 0777))
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
$nomeArquivoNovo = base64_decode($nomeArquivo);
$nameButton = ($nomeArquivo) ? 'Alterar' : 'Cadastrar';

$str = <<<STR
        <input
            id="nomeArquivo"
            name="nomeArquivo"
            type="hidden"
            value="$nomeArquivo"
        >
        <label for="nome">Nome</label>
        <input
            id="nomeArquivoNovo"
            name="nomeArquivoNovo"
            type="text"
            value="$nomeArquivoNovo"
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
        <title><?php print "$objI->nomeFantasia - Álbum de Fotos"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_album-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Álbum de Fotos - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Álbum de Fotos</h1>
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