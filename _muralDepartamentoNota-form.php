<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('mural');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objMural = new Mural();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objMural->codigo = returnPost('codigo');
    $objMural->titulo = returnPost('titulo');
    $objMural->imagem = returnPost('imagem');
    $objMural->descricao = returnPost('descricao');
    $objMural->arquivo = '';
    $objMural->linkUrl = '';
    $objMural->departamento_codigo->codigo = returnPost('departamento_codigo');

    $dir = "/$tipoUrl/mural/" . $objMural->departamento_codigo->codigo . "/";
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
            if ($objMural->inserir())
                print("
                    <script>
                    $.showMsg({
                        msg: 'Cadastro efetuado com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                        window.location = '$dir';
                    });
                    </script>
                ");
            else
                print($erro);
            break;
        case 'alterar':
            if ($objMural->editar($objMural->codigo))
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
            if ($objMural->excluir(returnPost('dados'))) {
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
            }else
                print($erro);
            break;
    }
    die();
}
if (returnGet('c') != 'novo') {
    $objMural = $objMural->consultar(returnGet('c'));
    if (!$objMural) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}

$nameButton = ($objMural->codigo) ? 'Alterar' : 'Cadastrar';
$dir = base64_encode($objMural->dirImagem);
$departamento = returnGet('d');

$str = <<<STR
        <input
            id="codigo"
            name="codigo"
            type="hidden"
            value="$objMural->codigo"
        >
        <input
            id="arquivo"
            name="arquivo"
            type="hidden"
            value="$objMural->arquivo"
        >
        <input
            id="departamento_codigo"
            name="departamento_codigo"
            type="hidden"
            value="$departamento"
        >
        <label for="titulo">Título</label>
        <input
            id="titulo"
            name="titulo"
            type="text"
            value="$objMural->titulo"
            maxlength="$objMural->limite_titulo"
        >
        <label for="imagem">Imagem</label>
        <div class="imageManager">
            <input
                id="imagem"
                name="imagem"
                type="text"
                readonly="readonly"
                value="$objMural->imagem"
                class="imageManager"
            >
            <input
                id="btnFile"
                name="btnFile"
                type="button"
                class="imageManager"
                value="Procurar"
                imageManager="true"
                imageManager-tipo="mural"
                imageManager-dir="$dir"
            >
        </div>
        <label for="descricao">Descrição</label>
        <input
            id="descricao"
            name="descricao"
            type="text"
            value="$objMural->descricao"
            maxlength="$objMural->limite_descricao"
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
        <link rel="stylesheet" type="text/css" href="/plugins/imagesManager/imagesManager.css">
        <title><?php print "$objI->nomeFantasia - Murais"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_muralDepartamentoNota-form.js"></script>
        <script src="/plugins/imagesManager/imagesManager.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Murais - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Nota</h1>
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