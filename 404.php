<?php
require_once('ie.php');
require_once('config/loadConfig.php');
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
        <link rel="stylesheet" type="text/css" href="/css/404.css">
        <title><?php print "$objI->nomeFantasia - 404"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
    </head>
    <body>
        <div id="all"<?php print (returnPost('url')) ? ' class="post"' : ''; ?>>
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <div class="ops">ops!</div>
                    <div class="c404">404</div>
                    <div class="error">error</div>
                    <div class="clear"></div>
                    <div class="align">
                        <h1>Página não encontrada</h1>
                        <h2>O endereço abaixo não existe no fatecmarilia.edu.br</h2>
                        <p>
                            <?php
                            if (returnPost('url'))
                                print returnPost('url');
                            else
                                print 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
                            ?>
                        </p>
                    </div>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>