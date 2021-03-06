<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('revista');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objRevista = new Revista();
$objAlbum = new _foto($objRevista->dirImagem);

$tituloArtigo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tituloArtigo = returnPost('tituloArtigo');
    $tituloArtigoNovo = base64_encode(trim(returnPost('tituloArtigoNovo')));
    
    $objAlbum->dir .= $objAlbum->nomeDirReal(returnPost('revista')) . '/';

    $dir = "/$tipoUrl/revista/edicoes/" . returnPost('revista') . "/";
    $dir2 = "/$tipoUrl/revista/edicoes/" . returnPost('revista') . "/" . _funcoes::urlString(strtolower(base64_decode($tituloArtigoNovo))) . "/paginas.html";
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
            if (mkdir("$objAlbum->dir$tituloArtigoNovo", 0777)) {
                sleep(2);
                if (mkdir("$objAlbum->dir$tituloArtigoNovo/500x707", 0777))
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
            if (rename("$objAlbum->dir$tituloArtigo", "$objAlbum->dir$tituloArtigoNovo"))
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
            if (unlink("$tituloArtigo"))
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
$revista = returnGet('c');
$objAlbum->dir .= $objAlbum->nomeDirReal($revista) . '/';
if (is_dir("'$objAlbum->dir'")) {
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
    _funcoes::error404($url);
} elseif (returnGet('d') != 'novo') {
    $tituloArtigo = $objAlbum->nomeDirReal(returnGet('d'));
    if ((is_dir("'$objAlbum->dir$tituloArtigo'")) || (!$tituloArtigo)) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}
$tituloArtigoNovo = base64_decode($tituloArtigo);
$nameButton = ($tituloArtigo) ? 'Alterar' : 'Cadastrar';

$str = <<<STR
        <input
            id="revista"
            name="revista"
            type="hidden"
            value="$revista"
        >
        <input
            id="tituloArtigo"
            name="tituloArtigo"
            type="hidden"
            value="$tituloArtigo"
        >
        <label for="tituloArtigoNovo">Título do Artigo</label>
        <input
            id="tituloArtigoNovo"
            name="tituloArtigoNovo"
            type="text"
            value="$tituloArtigoNovo"
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
            data-cod="$tituloArtigo"
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
        <script src="/js/scripts/_revistaArtigo-form.js"></script>
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
                        <h1>Cadastro de Artigo</h1>
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