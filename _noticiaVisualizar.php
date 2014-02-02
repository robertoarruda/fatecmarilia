<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('noticia');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objNoticia = new Noticia();
$album = new _foto("$objNoticia->dirImagemAlbum");
$objNoticia = $objNoticia->consultar(returnGet('c'));

if (!$objNoticia) {
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
    _funcoes::error404($url);
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
        <link rel="stylesheet" type="text/css" href="/css/noticia.css">
        <title><?php print "$objI->nomeFantasia - $objNoticia->titulo"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/scripts/noticia.js"></script>
        <script src="/js/scripts/fotos.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script>
            $(function() {
                $('img.lazy').lazyload({
                    effect: "fadeIn"
                });
            });
        </script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="noticia">
                <div class="enquadramento1000px">
                    <h1>Visualizador de Notícia - Notícias Pendentes</h1>
                    <?php
                    $fotos = "";
                    if (is_dir("$objNoticia->dirImagemAlbum$objNoticia->codigo")) {
                        $fotos .= '<h2>Álbum de Fotos da Notícia</h2><ul class="albumView">';
                        foreach ($album->mostrarFotos("$objNoticia->codigo", false) as $valor) {
                            $arquivo = "$objNoticia->dirImagemAlbum$objNoticia->codigo/$valor";
                            $imgInfo = getimagesize($arquivo);
                            $imgW = $imgInfo[0];
                            $imgH = $imgInfo[1];
                            $fotos .= "
                                <li>
                                    <img
                                        class=\"lazy\"
                                        src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\"
                                        data-original=\"/$objNoticia->dirImagemAlbum$objNoticia->codigo/196x196/$valor\"
                                        data-src=\"" . $arquivo . "\"
                                        data-width=\"$imgW\"
                                        data-height=\"$imgH\"
                                        title=\"" . pathinfo($arquivo, 8) . "\"
                                    >
                                </li>";
                        }
                        $fotos .= '</ul>';
                    }
                    $imgInfo = getimagesize("$objNoticia->dirImagem$objNoticia->imagem");
                    $imgW = $imgInfo[0];
                    $imgH = $imgInfo[1];
                    $objFuncionario = new Funcionario();
                    $objFuncionario = $objFuncionario->consultar($objNoticia->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf);
                    $objAcademico = new Academico();
                    if ($objAcademico->consultar($objNoticia->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf))
                        $nomeAbreviado = ($objFuncionario->sexo == 'F') ? "Profª. $objFuncionario->nomeAbreviado" : "Prof. $objFuncionario->nomeAbreviado";
                    else
                        $nomeAbreviado = $objFuncionario->nomeAbreviado;
                    
                    $a = ($objNoticia->linkTarget) ? ' target="_blank"' : '';
                    $a = "<p><a href=\"$objNoticia->linkUrl\"$a\">$objNoticia->linkTitulo</a>.</p>";
                    printf('
                        <figure><img src="/%s" data-src="%s" data-width="%s" data-height="%s" class="imageNoticia" title="%s"></figure>
			<h1>%s</h1>
			<p id="autor-data">Publicado por: %s | em: %s</p>
			<div class="pnlRedeSosiaisShare"></div>
			<section><p>%s</p>%s</section>
                        %s
                        <a class="btnVoltar" href="/%s/noticias/pendentes.html">Voltar</a>
                        ',
                        $objNoticia->dirImagem . '400x300/' . $objNoticia->imagem,
                        "$objNoticia->dirImagem$objNoticia->imagem",
                        $imgW,
                        $imgH,
                        $objNoticia->titulo,
                        $objNoticia->titulo,
                        $nomeAbreviado,
                        date('d/m/Y - H:m:s',  strtotime($objNoticia->data)),
                        nl2br($objNoticia->conteudo),
                        ($objNoticia->linkUrl)? $a : '',
                        $fotos,
                        $tipoUrl
                    );
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