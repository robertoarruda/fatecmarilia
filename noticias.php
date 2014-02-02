<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$noticiasPags = 9;
$pag = returnGet('p', 1);

$objNoticia = new Noticia();
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!-- Facebook Open Graph -->
        <meta property="og:url" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" >
        <meta property="og:site_name" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nomeFantasia); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php print iconv("UTF-8", "ISO-8859-1", "Notícias"); ?>">
        <meta property="og:image" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . "/imagens/layout/estrutura/png/logoFatec.graphic.png"; ?>">
        <meta property="og:description" content="">
        <meta property="fb:admins" content="100002559673601">
        <!-- Facebook Open Graph -->
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/noticias.css">
        <title><?php print "$objI->nomeFantasia - Notícias"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/noticias.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="noticia">
                <div class="enquadramento1000px">
                    <?php
                    if ($objNoticia->qtdAtivoRegistros() > 0) {
                        print '<ul id="boxNoticias">';
                        $mes = 0;
                        $ano = 0;
                        foreach ($objNoticia->listarAtivoDataLimitado($noticiasPags, $noticiasPags * $pag - $noticiasPags) as $obj) {
                            $mesAtual = date('m', strtotime($obj->data));
                            $anoAtual = date('Y', strtotime($obj->data));
                            if (($ano <> $anoAtual) || ($mes <> $mesAtual)) {
                                $mes = $mesAtual;
                                $ano = $anoAtual;
                                printf('
                                    </ul>
                                    <div class="clear"></div>
                                    <h1 id="title">%s / %s</h1>
                                    <ul id="boxNoticias">
                                    ', $mes, $ano
                                );
                            }
                            $dia = date('d', strtotime($obj->data));
                            $mes = date('m', strtotime($obj->data));
                            $ano = date('Y', strtotime($obj->data));
                            printf('
                                <li>
                                    <article class="boxNoticia">
                                        <figure>
                                            <a href="/noticias/%s.html">
                                                <img class="lazy" src="/imagens/layout/estrutura/gif/lazyload-bg.gif" data-original="/%s">
                                            </a>
                                        </figure>
                                        <h1>%s</h1>
                                        <section>
                                          <p>%s</p>
                                        </section>
                                        <a href="/noticias/%s.html" class="vejaMais">Veja Mais</a>
                                    </article>
                                </li>
                            ', "$ano/$mes/$dia/$obj->urlTitulo", $obj->dirImagem . '400x300/' . $obj->imagem, $obj->titulo, $obj->resumo, "$ano/$mes/$dia/$obj->urlTitulo"
                            );
                        }
                        print '</ul>';
                        ?>
                        <div class="clear"></div>
                        <hr>
                        <ul id="numPag">
                        <?php
                        if ($pag > 1)
                            print '<li><a href="/noticias/01/" class="numPagG">&#8249;&#8249;</a></li>';

                        if ($pag - 1 >= 1)
                            printf('
                                <li><a href="/noticias/%s/" class="numPag">&#8249;</a></li>
                            ', ($pag - 1 < 10) ? str_pad($pag - 1, 2, '0', STR_PAD_LEFT) : $pag - 1
                            );
                        $totalPag = ceil($objNoticia->qtdAtivoRegistros() / $noticiasPags);
                        for ($count = 1; $count <= $totalPag; $count++) {
                            printf('
                            <li><a href="%s" class="numPag%s">%s</a></li>
                            ', ($count < 10) ? '/noticias/' . str_pad($count, 2, '0', STR_PAD_LEFT) . '/' : '/noticias/' . $count . '/', ($count == $pag) ? 'D' : '', $count
                            );
                        }
                        if ($pag + 1 <= $totalPag)
                            printf('
                            <li><a href="/noticias/%s/" class="numPag">&#8250;</a></li>
                            ', ($pag + 1 < 10) ? str_pad($pag + 1, 2, '0', STR_PAD_LEFT) : $pag + 1
                            );
                        if ($pag < $totalPag)
                            printf('
                            <li><a href="/noticias/%s/" class="numPagG">&#8250;&#8250;</a></li>
                            ', ($count < 10) ? str_pad($totalPag, 2, '0', STR_PAD_LEFT) : $count
                            );
                    } else {
                        print "Nenhuma notícia encontrada.";
                    }
                    ?>
                    </ul>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
<?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>