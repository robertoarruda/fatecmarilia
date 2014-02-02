<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$departamento = returnGet('c');
$objDepartamento = new Departamento();
$departamento = $objDepartamento->consultarNomeMural($departamento);
if (!$departamento) {
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
    _funcoes::error404($url);
}
else
    $objDepartamento = $departamento;
$objMural = new Mural();
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
        <meta property="og:title" content="<?php print iconv("UTF-8", "ISO-8859-1", "Mural"); ?>">
        <meta property="og:image" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . "/imagens/layout/estrutura/png/logoFatec.graphic.png"; ?>">
        <meta property="og:description" content="<?php print iconv("UTF-8", "ISO-8859-1", "Mural da $objDepartamento->nome"); ?>">
        <meta property="fb:admins" content="100002559673601">
        <!-- Facebook Open Graph -->
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/mural.css">
        <title><?php print "$objI->nomeFantasia - Mural"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/mural.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="mural">
                <div class="enquadramento1000px">
                    <h1>Mural da <?php print $objDepartamento->nome; ?></h1>
                    <?php
                    if ($objMural->qtdRegistrosDepartamento($objDepartamento->codigo) > 0) {
                        print '<ul id="boxNotas">';
                        foreach ($objMural->listarTudoDepartamento($objDepartamento->codigo) as $obj) {
                            $btn = '';
                            if ($obj->arquivo) {
                                $btn = "<a href=\"/$obj->dirArquivo$obj->arquivo\" class=\"baixar\" target=\"_blank\">Baixar</a>";
                            } elseif ($obj->linkUrl) {
                                $btn = "<a href=\"$obj->linkUrl\" class=\"baixar\" target=\"_blank\">Link</a>";
                            }
                            print "
                                <li>
                                    <article class=\"boxNota\">
                                        <figure>
                                            <a href=\"/$obj->dirArquivo$obj->arquivo\" target=\"_blank\">
                                                <img class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/$obj->dirImagem" . "300x150/$obj->imagem\">
                                            </a>
                                        </figure>
                                        <h1>$obj->titulo</h1>
                                        <section><p>$obj->descricao</p></section>
                                         $btn
                                    </article>
                                </li>
                            ";
                        }
                        print '</ul><div class="clear"></div>';
                    }
                    if ($objNoticia->qtdAtivoDepartamentoRegistros($objDepartamento->codigo) > 0) {
                        foreach ($objNoticia->listarAtivoDepartamentoLimitado($objDepartamento->codigo, 1, 0) as $obj) {
                            $dia = date('d', strtotime($obj->data));
                            $mes = date('m', strtotime($obj->data));
                            $ano = date('Y', strtotime($obj->data));
                            printf('
                                <article id="noticia">
                                    <figure>
                                        <a href="/noticias/%s.html">
                                            <img class="lazy" src="/imagens/layout/estrutura/gif/lazyload-bg.gif" data-original="/%s">
                                        </a>
                                    </figure>
                                    <h1>%s</h1>
                                    <section><p>%s</p></section>
                                     <a href="/noticias/%s.html" class="vejaMais">Veja Mais</a>
                                </article>
                                ', "$ano/$mes/$dia/$obj->urlTitulo", $obj->dirImagem . '400x300/' . $obj->imagem, $obj->titulo, $obj->resumo, "$ano/$mes/$dia/$obj->urlTitulo"
                            );
                        }
                        if ($objNoticia->qtdAtivoDepartamentoRegistros($objDepartamento->codigo) > 1) {
                            print '<ul id="boxNoticias">';
                            foreach ($objNoticia->listarAtivoDepartamentoLimitado($objDepartamento->codigo, 1000, 1) as $obj) {
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
                                        <section><p>%s</p></section>
                                         <a href="/noticias/%s.html" class="vejaMais">Veja Mais</a>
                                    </article>
                                </li>
                                ', "$ano/$mes/$dia/$obj->urlTitulo", $obj->dirImagem . '400x300/' . $obj->imagem, $obj->titulo, $obj->resumo, "$ano/$mes/$dia/$obj->urlTitulo"
                                );
                            }
                            print '</ul>';
                        }
                    } else {
                        print "<p class=\"nenhum\">Nenhuma notícia encontrada.</p>";
                    }
                    ?>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>