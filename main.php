<?php
require_once('ie.php');
require_once('config/loadConfig.php');

session_start();
if (!isset($_SESSION['capa'])) {
    header('Location: /v/');
} else {
    $data = strtotime('-5 minutes');
    $d = $_SESSION['capa'];
    if ($data > $d)
        header('Location: /v/');
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!-- Facebook Open Graph -->
        <meta property="og:url" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" >
        <meta property="og:site_name" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nomeFantasia); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nomeFantasia); ?>">
        <meta property="og:image" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . "/$objI->dirImagem$objI->imagem"; ?>">
        <meta property="og:description" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nome); ?>">
        <meta property="fb:admins" content="100002559673601">
        <!-- Facebook Open Graph -->
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/plugins/slideShow/slideShow.css">
        <title><?php print "$objI->nomeFantasia"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/plugins/slideShow/jquery.slideShow.js"></script>
        <script src="/js/plugins/jquery.marquee.js"></script>
        <script src="/js/scripts/main.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <div id="slideShow">
                        <?php require_once('plugins/slideShow/slideShow.php'); ?>
                    </div>
                    <hr>
                    <aside class="links"><a href="/frame/<?php print base64_encode('http://www.fatecmarilia.edu.br/contrate/login.php'); ?>/"><img id="contrate" src="/imagens/layout/estrutura/png/logoContrate.graphic.png"></a>
                        <hr class="v">
                        <a href="/noticias/2011/02/04/liveedu.html"><img id="liveaedu" src="/imagens/layout/estrutura/png/logoLive@edu.graphic.png"></a>
                        <hr class="v">
                        <a href="/revista/"><img id="alimentus" src="/imagens/layout/estrutura/png/logoAlimentus.graphic.png"></a></aside>
                    <div class="clear"></div>
                    <hr>
                    <?php require_once('boxnoticias.php'); ?>
                    <div class="clear"></div>
                    <hr>
                    <?php require_once('parceiros.php'); ?>
                    <div class="clear"></div>
                    <hr>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>