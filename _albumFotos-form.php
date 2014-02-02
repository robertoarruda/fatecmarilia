<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('album');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objAlbum = new _foto();

$dir = "/$tipoUrl/albuns/";

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
        case 'cadastrar':
            if (mkdir("$objAlbum->dir$nomeArquivoNovo", 0757)) {
                sleep(2);
                if (mkdir("$objAlbum->dir$nomeArquivoNovo/196x196", 0757))
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
            }
            else
                print($erro);
            break;
        case 'alterar':
            if (rename($objAlbum->dir . '196x196/' . $nomeArquivo, $objAlbum->dir . '196x196/' . $nomeArquivoNovo)) {
                sleep(2);
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
            }
            else
                print($erro);
            break;
        case 'excluir':
            $nome = _funcoes::extrairInfoArq(base64_decode($nomeArquivo));
            $folder = str_replace($nome, '', base64_decode($nomeArquivo));
            if (unlink($folder . '196x196/' . $nome)) {
                sleep(2);
                if (unlink(base64_decode($nomeArquivo)))
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
                else
                    print($erro);
            }
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
        <link rel="stylesheet" type="text/css" href="/plugins/uploadify/uploadify.css">
        <title><?php print "$objI->nomeFantasia - Álbum de Fotos"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_albumFotos-form.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/fotos.js"></script>
        <script type="text/javascript" src="/plugins/uploadify/jquery.uploadify.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#uploadify-cancelAll').hide();
                var tipos = '*.jpg; *.jpeg';
                $('#file_upload').uploadify({
                    swf: '/plugins/uploadify/uploadify.swf',
                    uploader: '/plugins/uploadify/uploadify.php',
                    formData: {
                        folder: '/<?php print "$objAlbum->dir$nomeArquivo"; ?>/',
                        tipos  : tipos.replace(/\*./g,'')
                    },
                    onQueueComplete: function(queueData) {
                        location.reload();
                    },
                    onUploadSuccess: function(file, data, response) {
                        if (data)
                            alert(data);
                    },
                    onUploadStart: function(file) {
                        $('#uploadify-cancelAll').fadeIn();
                    },
                    multi: true,
                    buttonText: 'Adicionar fotos',
                    width: 280,
                    height: 55,
                    fileTypeDesc: 'Image Files',
                    fileTypeExts: tipos
                });
            });
        </script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Álbum de Fotos - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Fotos do Álbum - <?php print base64_decode($nomeArquivo); ?></h1>
                        <input id="file_upload" name="file_upload" type="file" multiple="multiple">
                        <a id="uploadify-cancelAll" href="javascript:$('#file_upload').uploadify('cancel', '*')" class="uploadify-button">Cancelar Todos</a>
                        <ul class="albumView">
                            <?php
                            if ($objAlbum->mostrarFotos($nomeArquivo) <= 0) {
                                print '<p>Nenhum registro encontrado.</p>';
                            } else {
                                foreach ($objAlbum->mostrarFotos($nomeArquivo) as $valor) {
                                    $arquivo = "$objAlbum->dir$nomeArquivo/$valor";
                                    $imgInfo = getimagesize($arquivo);
                                    $imgW = $imgInfo[0];
                                    $imgH = $imgInfo[1];
                                    printf('
                                            <li>
                                                <img class="lazy" src="/imagens/layout/estrutura/gif/lazyload-bg.gif" data-original="/%s" data-src="%s" data-width="%s" data-height="%s" title="%s">
                                                <a class="excluir" data-codigo="%s">excluir</a>
                                            </li>
                                            ',
                                            "$objAlbum->dir$nomeArquivo/196x196/$valor",
                                            $arquivo,
                                            $imgW,
                                            $imgH,
                                            pathinfo($arquivo, 8),
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