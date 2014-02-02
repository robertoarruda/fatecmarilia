<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('revista');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$album = new _foto("imagens/", array('jpg','jpeg','png','gif'));

$dir = "/$tipoUrl/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nomeArquivo = returnPost('nomeArquivo');
    $nomeArquivoNovo = returnPost('nomeArquivoNovo');

    $erro = "
        <script>
        $.showMsg({
            msg: 'Ocorreu um erro na operação solicitada.',
            titulo: 'Erro'
        });
        </script>
    ";
    switch (strtolower(returnPost('acao'))) {
        case 'excluir':
            $nome = _funcoes::extrairInfoArq(base64_decode($nomeArquivo));
            $folder = str_replace($nome, '', base64_decode($nomeArquivo));
            if (unlink(base64_decode($nomeArquivo))) {
                print("
                    <script>
                    $.showMsg({
                        msg: 'Remoção efetuada com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                        location.reload();
                    });
                    </script>
                ");
            }
            else
                print($erro);
            break;
    }
    die();
}
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
        <title><?php print "$objI->nomeFantasia - Parceiros"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_parceiros.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/fotos.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
<?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Parceiros - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Parceiros</h1><a href="/<?php print $tipoUrl; ?>/parceiros/novo/cadastro.html">Cadastrar Novo Parceiro</a>
                        <div class="clear"></div>
                        <ul class="albumView" style="height: 170px; margin-bottom: 30px;">
                            <?php
                            if ($album->mostrarFotos("parceiros") <= 0) {
                                print '<p>Nenhum registro encontrado.</p>';
                            } else {
                                foreach ($album->mostrarFotos("parceiros", false) as $valor) {
                                    $arquivo = "imagens/parceiros/$valor";
                                    $imgInfo = getimagesize($arquivo);
                                    $imgW = $imgInfo[0];
                                    $imgH = $imgInfo[1];
                                    printf('
                                            <li>
                                                <img class="lazy" src="/imagens/layout/estrutura/gif/lazyload-bg.gif" data-original="%s" data-src="%s" data-width="%s" data-height="%s">
                                                <a class="excluir" data-codigo="%s">excluir</a>
                                            </li>
                                            ',
                                            "/imagens/parceiros/$valor",
                                            $arquivo,
                                            $imgW,
                                            $imgH,
                                            base64_encode($arquivo)
                                    );
                                }
                            }
                            ?>
                        </ul>
                        <div class="buttons">
                            <a id="btnVoltar" title="Voltar" href="<?php print $dir; ?>">Voltar</a>
                        </div>
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