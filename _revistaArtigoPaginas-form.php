<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('revista');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objRevista = new Revista();
$objAlbum = new _foto($objRevista->dirImagem, array('jpg','jpeg'));

$dir = "/$tipoUrl/revista/edicoes/" . returnGet('c') . "/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tituloArtigo = returnPost('tituloArquivo');
    $tituloArtigoNovo = returnPost('tituloArquivoNovo');

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
            }
            else
                print($erro);
            break;
        case 'alterar':
            if (rename("$objAlbum->dir$tituloArtigo", "$objAlbum->dir$tituloArtigoNovo")) {
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
            }
            else
                print($erro);
            break;
        case 'excluir':
            $nome = _funcoes::extrairInfoArq(base64_decode($tituloArtigo));
            $folder = str_replace($nome, '', base64_decode($tituloArtigo));
            if (unlink($folder . '500x707/' . $nome)) {
                sleep(2);
                if (unlink(base64_decode($tituloArtigo)))
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
$nome = explode("-", $revista);
$nome = "Vol. $nome[0], N°. $nome[1] ($nome[2]/$nome[3])";
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
        <title><?php print "$objI->nomeFantasia - Revista Alimentus"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_revistaArtigoPaginas-form.js"></script>
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
                        folder: '/<?php print "$objAlbum->dir$tituloArtigo"; ?>/',
                        dimensao: '1000x1414:proporcional;500x707:proporcional',
                        tipos: tipos.replace(/\*./g, '')
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
                    buttonText: 'Adicionar páginas',
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
                    <h1>Revista Alimentus - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Páginas do Artigo - <?php print $nome . '<br>:: ' . base64_decode($tituloArtigo); ?></h1>
                        <input id="file_upload" name="file_upload" type="file" multiple="multiple">
                        <a id="uploadify-cancelAll" href="javascript:$('#file_upload').uploadify('cancel', '*')" class="uploadify-button">Cancelar Todos</a>
                        <ul class="albumView">
                            <?php
                            if ($objAlbum->mostrarFotos($tituloArtigo) > 0) {
                                foreach ($objAlbum->mostrarFotos($tituloArtigo) as $valor) {
                                    $arquivo = "$objAlbum->dir$tituloArtigo/$valor";
                                    $imgInfo = getimagesize($arquivo);
                                    $imgW = $imgInfo[0];
                                    $imgH = $imgInfo[1];
                                    $nome = pathinfo($arquivo, 8);
                                    if (!in_array($nome, array('capa','capaTraseira')))
                                        printf('
                                                <li>
                                                    <img class="lazy" src="/imagens/layout/estrutura/gif/lazyload-bg.gif" data-original="/%s" data-src="%s" data-width="%s" data-height="%s" title="%s">
                                                    <a class="excluir" data-codigo="%s">excluir</a>
                                                </li>
                                                ',
                                                "$objAlbum->dir$tituloArtigo/500x707/$valor",
                                                $arquivo,
                                                $imgW,
                                                $imgH,
                                                $nome,
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