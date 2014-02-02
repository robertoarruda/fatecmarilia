<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$album = new _foto();
$d = $album->nomeDirReal(returnGet('d'));
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!-- Facebook Open Graph -->
        <meta property="og:url" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" >
        <meta property="og:site_name" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nomeFantasia); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php print iconv("UTF-8", "ISO-8859-1", (isset($_GET['d'])) ? base64_decode($d) : 'Álbum de Fotos'); ?>">
        <meta property="og:image" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . "/imagens/layout/estrutura/png/logoFatec.graphic.png"; ?>">
        <meta property="og:description" content="">
        <meta property="fb:admins" content="100002559673601">
        <!-- Facebook Open Graph -->
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/fotos.css">
        <title><?php print (isset($_GET['d'])) ? "$objI->nomeFantasia - " . base64_decode($d) : $objI->nomeFantasia . ' - Álbum de Fotos'; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/fotos.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <?php
                    if (returnGet('d')) {
                        print "<h1>" . base64_decode($d) . "</h1>";
                        print '<ul class="albumView">';
                        foreach ($album->mostrarFotos($d) as $valor) {
                            $arquivo = "$album->dir$d/$valor";
                            $imgInfo = getimagesize($arquivo);
                            $imgW = $imgInfo[0];
                            $imgH = $imgInfo[1];
                            printf('
                                <li><img class="lazy" src="/imagens/layout/estrutura/gif/lazyload-bg.gif" data-original="/%s" data-src="%s" data-width="%s" data-height="%s" title="%s"></li>
                                ',
                                "$album->dir$d/196x196/$valor",
                                $arquivo,
                                $imgW,
                                $imgH,
                                pathinfo($arquivo, 8)
                            );
                        }
                        print '</ul>';
                        print "<a id=\"btnVoltar\" title=\"Voltar\" href=\"/fotos/\">Voltar</a>";
                    } else {
                        print "<h1>Álbum de Fotos</h1><ul class=\"albumList\">";
                        $array = $album->mostrarAlbuns();
                        foreach ($array['d'] as $chave => $valor) {
                            printf('
                                <li><a href="/fotos/%s.html"><ul class="album">
                                ', _funcoes::urlString(strtolower(base64_decode($chave)))
                            );
                            if (is_array($valor)) {
                                $count = 0;
                                foreach ($valor['a'] as $cchave => $vvalor) {
                                    if ($count < 4)
                                        print "
                                            <li><img class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/" . $vvalor . '196x196/' . $cchave . "\"></li>
                                        ";
                                    $count++;
                                }
                            }
                            print "</ul><p>" . base64_decode($chave) . "</p></a></li>";
                        }
                        print '</ul>';
                    }
                    ?>
                    <div class="clear"></div>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>