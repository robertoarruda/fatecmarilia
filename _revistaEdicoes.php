<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('revista');

$objRevista = new Revista();

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
        <title><?php print "$objI->nomeFantasia - Revista Alimentus"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_revistaEdicoes.js"></script>
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
                        <h1>Edições</h1>
                        <a href="/<?php print $tipoUrl; ?>/revista/edicoes/novo/cadastro.html">Cadastrar Nova Edição</a>
                        <?php
                        $album = new _foto($objRevista->dirImagem, array('png'));
                        $array = $album->mostrarAlbuns();
                        if (count($array['d']) <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="codigo">Fotos</th>
                                        <th class="alLeft">Nome</th>
                                        <th class="opcoes2">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="codigo">Fotos</td>
                                        <td class="alLeft">Nome</td>
                                        <td class="opcoes2">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    if (count($array['d']) > 0)
                                        foreach ($array['d'] as $chave => $valor) {
                                            $chave2 = $chave;
                                            $chave = base64_decode($chave);
                                            $nome = explode("-", $chave);
                                            $nome = "Vol. $nome[0], N°. $nome[1] ($nome[2]/$nome[3])";
                                            $count++;
                                            $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                            $img = (is_file("$objRevista->dirImagem$chave2/capa.jpg")) ? "$objRevista->dirImagem$chave2/" : $objRevista->dirImagem;
                                            print "
                                                <tr$classPar>
                                                    <td class=\"alCenter\">
                                                        <img class=\"revista\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/" . $img . "capa.jpg\">
                                                    </td>
                                                    <td class=\"alLeft\">$nome</td>
                                                    <td class=\"alCenter\">
                                                        <a href=\"/$tipoUrl/revista/edicoes/" . _funcoes::urlString(strtolower($chave)) . "/\" title=\"Editar Páginas\">Artigos</a>
                                                        <a href=\"/$tipoUrl/revista/edicoes/" . _funcoes::urlString(strtolower($chave)) . "/cadastro.html\" title=\"Editar Edição\">Editar Edição</a>
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </article>
                    <a class="btnVoltar" href="/<?php print "$tipoUrl/revista"; ?>/">Voltar</a>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>