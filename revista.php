<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objRevista = new Revista();
$album = new _foto($objRevista->dirImagem, array('jpg','jpeg'));
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!-- Facebook Open Graph -->
        <meta property="og:url" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" >
        <meta property="og:site_name" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nomeFantasia); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php print iconv("UTF-8", "ISO-8859-1", "Revista Alimentus"); ?>">
        <meta property="og:image" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . "/imagens/layout/estrutura/png/logoAlimentus.graphic.png"; ?>">
        <meta property="og:description" content="<?php print iconv("UTF-8", "ISO-8859-1", "Revista Alimentus - ISSN 2236-4684"); ?>">
        <meta property="fb:admins" content="100002559673601">
        <!-- Facebook Open Graph -->
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/revista.css">
        <link href="/js/plugins/booklet/jquery.booklet.latest.css" type="text/css" rel="stylesheet" media="screen, projection, tv" />
        <title><?php print "$objI->nomeFantasia - Revista Alimentos"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/revista.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js" type="text/javascript"></script>
        <script src="/js/plugins/booklet/jquery.booklet.latest.min.js" type="text/javascript"></script>
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
                        $pag = 1;
                        $dir = $album->nomeDirReal(returnGet('d'));
                        $array = $album->mostrarAlbuns("$dir");
                        $nome = explode("-", base64_decode($dir));
                        $nome = "Vol. $nome[0], N°. $nome[1] ($nome[2]/$nome[3])";
                        print "<h1>Revista Alimentus - $nome</h1><ol id=\"revistaMenu\"></ol><div id=\"revista\">";
                        print "<div>";
                        if (is_file("$objRevista->dirImagem$dir/capa.jpg"))
                            print "<img title=\"Duplo clique para ampliar\" class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/$objRevista->dirImagem$dir/capa.jpg\" data-src=\"/$objRevista->dirImagem$dir/capa.jpg\">";
                        else
                            print "<img title=\"Duplo clique para ampliar\" class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/" . $objRevista->dirImagem . "capa.jpg\" data-src=\"/" . $objRevista->dirImagem . "capa.jpg\">";
                        print "</div><div class=\"contracapa\"></div>";
                        $menu = array();
                        foreach ($array['d'] as $chave => $valor) {
                            $artigo =  ' title="' . base64_decode($chave) . '"';
                            foreach ($album->mostrarFotosInvertido("$dir/$chave", false) as $valor) {
                                $valor = iconv('iso-8859-1', 'utf-8', $valor);
                                $pagClass = ($pag % 2 ==  0) ? 'e' : 'd';
                                print "
                                    <div$artigo>
                                        <img
                                            title=\"Duplo clique para ampliar\"
                                            class=\"lazy\"
                                            src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\"
                                            data-original=\"/$objRevista->dirImagem$dir/$chave/500x707/$valor\"
                                            data-src=\"/$objRevista->dirImagem$dir/$chave/$valor\"
                                        >
                                        <p class=\"$pagClass\">$pag</p>
                                    </div>
                                ";
                                if ($artigo) {
                                    $menu[] = array('titulo' => base64_decode($chave), 'pagina' => ($pag+2));
                                }
                                $artigo = '';
                                $pag++;
                            }
                        }
                        print "<div class=\"contracapa2\"></div><div>";
                        if (is_file("$objRevista->dirImagem$dir/capaTraseira.jpg"))
                            print "<img title=\"Duplo clique para ampliar\" class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/$objRevista->dirImagem$dir/capaTraseira.jpg\" data-src=\"/$objRevista->dirImagem$dir/capaTraseira.jpg\">";
                        else
                            print "<img title=\"Duplo clique para ampliar\" class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/" . $objRevista->dirImagem . 'capaTraseira.jpg' . "\" data-src=\"/" . $objRevista->dirImagem . 'capaTraseira.jpg' . "\">";
                        print "</div></div>";
                        print "<a id=\"btnVoltar\" title=\"Voltar\" href=\"/revista/\">Voltar</a>";

                        print '<ol id="revistaMenu2"><h1>Sumário</h1>';
                        foreach ($menu as $chave => $valor) {
                            print '<li data-pag="' . $valor['pagina'] . '">' . $valor['titulo'] . '</li>';
                        }
                        print '</ol>';
                    } else {
                        ?>
                        <h1>Revista Alimentus - ISSN 2236-4684</h1>
                        <section>
                        <?php 
                        if ($objRevista->qtdRegistros()) {
                            $objRevista = $objRevista->consultar(1);
                        ?>
                            <p><?php print nl2br($objRevista->descricao); ?></p>
                            <h2>Equipe Editorial</h2>
                            <p class="list"><?php print nl2br($objRevista->equipeEditorial); ?></p>
                            <h2>Comite Científico (Revisores / Consultores)</h2>
                            <p class="list"><?php print nl2br($objRevista->comiteCientifico); ?></p>
                            <h2>Equipe de Diagramação e Web Designer</h2>
                            <p class="list"><?php print nl2br($objRevista->equipeDiagramacaoWebDesigner); ?></p>
                        <?php
                        }
                        ?>
                            <h2>Publicação</h2>
                            <p>Os trabalhos para publicação nas próximas edições deverão ser encaminhados para o email <a href="mailto:revistaalimentus@gmail.com">revistaalimentus@gmail.com</a>.</p>
                            <?php
                            $file = $objRevista->dirArquivo . 'normas.pdf';
                            if (is_file($file))
                                print "<p>Leia agora as <a href=\"/$file\" target=\"_blank\">Normas para Publicação</a>.</p>";
                            ?>
                        </section>
                        <?php
                        print "<h1>Edições</h1><ul class=\"revistaList\">";
                        $array = $album->mostrarAlbuns();
                        foreach ($array['d'] as $chave => $valor) {
                            $nome = explode("-", base64_decode($chave));
                            $nome = "Vol. $nome[0], N°. $nome[1]<br>($nome[2]/$nome[3])";
                            printf("
                                <li>
                                    <a href=\"/revista/%s.html\">
                                        <img class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/%s/capa.jpg\">
                                        <p>$nome</p>
                                    </a>
                                </li>
                                ",
                                _funcoes::urlString(strtolower(base64_decode($chave))),
                                (is_file("$objRevista->dirImagem$chave/capa.jpg")) ? "$objRevista->dirImagem$chave" : $objRevista->dirImagem
                            );
                        }
                        print "</ul>";
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