<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$curso = returnGet('c');
$objCurso = new CursoPos();
$curso = $objCurso->consultarNome("$curso");
if (!$curso) {
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
    _funcoes::error404($url);
} else
    $objCurso = $curso;
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!-- Facebook Open Graph -->
        <meta property="og:url" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" >
        <meta property="og:site_name" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nomeFantasia); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php print iconv("UTF-8", "ISO-8859-1", $objCurso->nome); ?>">
        <meta property="og:image" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . "/$objCurso->dirImagem$objCurso->imagem"; ?>">
        <meta property="og:description" content="<?php print iconv("UTF-8", "ISO-8859-1", $objCurso->nomeCompleto); ?>">
        <meta property="fb:admins" content="100002559673601">
        <!-- Facebook Open Graph -->
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/cursos.css">
        <title><?php print "$objI->nomeFantasia - $objCurso->nome"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/scripts/instituicao.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <figure>
                        <?php
                        $imgInfo = getimagesize("$objCurso->dirImagem$objCurso->imagem");
                        $imgW = $imgInfo[0];
                        $imgH = $imgInfo[1];
                        printf('
                            <img src="/%s" data-src="%s" data-width="%s" data-height="%s" class="imageInstituicao">
                            ', $objCurso->dirImagem . '400x300/' . $objCurso->imagem,"$objCurso->dirImagem$objCurso->imagem", $imgW, $imgH
                        );
                        ?>
                    </figure>
                    <h1><?php print $objCurso->nomeCompleto; ?></h1>
                    <section>
                        <h2>Objetivo</h2>
                        <p><?php print nl2br($objCurso->objetivo); ?></p>
                        <h2>Público Alvo</h2>
                        <p><?php print nl2br($objCurso->publicoAlvo); ?></p>
                        <h2>Tipo</h2>
                        <p><?php print ($objCurso->tipo == 1) ? 'Lato Sensu' : 'Stricto Sensu' ; ?>.</p>
                        <h2>Quadro de Disciplinas</h2>
                        <p><?php print nl2br($objCurso->quadroDeDisciplinas); ?></p>
                        <h2>Duração</h2>
                        <p><?php print $objCurso->duracao; ?>.</p>
                    </section>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>