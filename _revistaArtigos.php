<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('revista');

$objRevista = new Revista();
$objAlbum = new _foto($objRevista->dirImagem, array('jpg','jpeg'));

$revista = $objAlbum->nomeDirReal(returnGet('c'));
$objAlbum->dir .= "$revista/";
if (is_dir("'$objAlbum->dir'")) {
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
    _funcoes::error404($url);
}

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;
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
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_revistaArtigos.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/fotos.js"></script>
        <script type="text/javascript" src="/plugins/uploadify/jquery.uploadify.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#uploadify-cancelAll1,#uploadify-cancelAll2').hide();
                var tipos = '*.jpg; *.jpeg';
                $('#file_upload1').uploadify({
                    swf: '/plugins/uploadify/uploadify.swf',
                    uploader: '/plugins/uploadify/uploadify.php',
                    formData: {
                        folder: '/<?php print "$objAlbum->dir"; ?>/',
                        fixName: 'capa',
                        dimensao: '1000x1414:proporcional',
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
                        $('#uploadify-cancelAll1').fadeIn();
                    },
                    multi: false,
                    buttonText: 'Adicionar capa',
                    width: 280,
                    height: 55,
                    fileTypeDesc: 'Image Files',
                    fileTypeExts: tipos
                });
                var tipos = '*.jpg; *.jpeg';
                $('#file_upload2').uploadify({
                    swf: '/plugins/uploadify/uploadify.swf',
                    uploader: '/plugins/uploadify/uploadify.php',
                    formData: {
                        folder: '/<?php print "$objAlbum->dir"; ?>/',
                        fixName: 'capaTraseira',
                        dimensao: '1000x1414:proporcional',
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
                        $('#uploadify-cancelAll2').fadeIn();
                    },
                    multi: false,
                    buttonText: 'Adicionar capa traseira',
                    width: 280,
                    height: 55,
                    fileTypeDesc: 'Image Files',
                    fileTypeExts: tipos
                });
            });
        </script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Revista Alimentus - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <?php
                            $nome = explode("-", base64_decode($revista));
                            $nome = "Vol. $nome[0], N°. $nome[1] ($nome[2]/$nome[3])";
                        ?>
                        <h1>Artigos - <?php print $nome; ?></h1>
                        <input id="file_upload1" name="file_upload1" type="file" multiple="multiple">
                        <a id="uploadify-cancelAll1" href="javascript:$('#file_upload1').uploadify('cancel', '*')" class="uploadify-button">Cancelar Todos</a>
                        <input id="file_upload2" name="file_upload2" type="file" multiple="multiple">
                        <a id="uploadify-cancelAll2" href="javascript:$('#file_upload2').uploadify('cancel', '*')" class="uploadify-button">Cancelar Todos</a>
                        <ul class="albumView2">
                            <?php
                            if ($objAlbum->mostrarFotosInvertido() > 0) {
                                foreach ($objAlbum->mostrarFotosInvertido() as $valor) {
                                    $arquivo = "$objAlbum->dir$valor";
                                    $imgInfo = getimagesize($arquivo);
                                    $imgW = $imgInfo[0];
                                    $imgH = $imgInfo[1];
                                    $nome = pathinfo($arquivo, 8);
                                    if (in_array($nome, array('capa','capaTraseira')))
                                        printf('
                                                <li>
                                                    <img class="lazy" src="/imagens/layout/estrutura/gif/lazyload-bg.gif" data-original="/%s" data-src="%s" data-width="%s" data-height="%s" title="%s">
                                                    <a class="excluir" data-codigo="%s">excluir</a>
                                                </li>
                                                ',
                                                "$objAlbum->dir$valor",
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
                        <a href="/<?php print $tipoUrl; ?>/revista/edicoes/<?php print returnGet('c'); ?>/novo/cadastro.html">Cadastrar Novo Artigo</a>
                        <?php
                        $album = new _foto($objRevista->dirImagem, array('png'));
                        $dir = $album->nomeDirReal(returnGet('c'));
                        $array = $album->mostrarAlbuns($dir);
                        if (count($array['d']) <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="alLeft">Título</th>
                                        <th class="opcoes2">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="alLeft">Título</td>
                                        <td class="opcoes2">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    if (count($array['d']) > 0)
                                        foreach ($array['d'] as $chave => $valor) {
                                            $count++;
                                            $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                            $nome = base64_decode($chave);
                                            print "
                                                <tr$classPar>
                                                    <td class=\"alLeft\">$nome</td>
                                                    <td class=\"alCenter\">
                                                        <a href=\"/$tipoUrl/revista/edicoes/" . strtolower(_funcoes::urlString(returnGet('c'))) . "/" . strtolower(_funcoes::urlString($nome)) . "/paginas.html\" title=\"Editar Páginas\">Editar Pgs.</a>
                                                        <a href=\"/$tipoUrl/revista/edicoes/" . strtolower(_funcoes::urlString(returnGet('c'))) . "/" . strtolower(_funcoes::urlString($nome)) . "/cadastro.html\" title=\"Editar Artigo\">Editar Artigo</a>
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </article>
                    <a class="btnVoltar" href="/<?php print "$tipoUrl/revista/edicoes/"; ?>">Voltar</a>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>