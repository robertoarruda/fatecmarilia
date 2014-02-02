<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('destaque');

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
        <title><?php print "$objI->nomeFantasia - Destaques"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_destaques.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Destaques - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Destaques</h1>
                        <a href="/<?php print $tipoUrl; ?>/destaques/novo/cadastro.html">Cadastrar Novo Destaque</a>
                        <?php if ($objFL->checaPermissao('administrar-destaque')) { ?><a href="/<?php print $tipoUrl; ?>/destaques/desativados.html">Desativados</a><?php } ?>
                        <?php if ($objFL->checaPermissao('administrar-destaque')) { ?><a href="/<?php print $tipoUrl; ?>/destaques/pendentes.html">Pendentes</a><?php } ?>
                        <?php
                        $objDestaques = new Destaque();
                        if ($objDestaques->qtdAtivoRegistros() <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            $tdOpcoes = ($objFL->checaPermissao('administrar-destaque')) ? '2' : '';
                            ?>
                        <table>
                            <thead>
                                <tr>
                                    <th class="codigo">Imagem</th>
                                    <th class="alLeft">Título</th>
                                    <th class="opcoes<?php print $tdOpcoes; ?>">Opções</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td class="codigo">Imagem</td>
                                    <td class="alLeft">Título</td>
                                    <td class="opcoes<?php print $tdOpcoes; ?>">Opções</td>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $count = 1;
                                if ($objDestaques->qtdAtivoRegistros() > 0)
                                foreach ($objDestaques->listarAtivoTudo() as $obj) {
                                    $count++;
                                    $classPar = (($count % 2) == 0)?' class="par"': '';
                                    $aDesativar = ($objFL->checaPermissao('administrar-destaque')) ? "<a title=\"Desativar\" data-codigo=\"$obj->codigo\">Desativar</a>" : '';
                                    print "
                                    <tr$classPar>
                                        <td class=\"alCenter\">
                                            <img class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/$obj->dirImagem" . "150x150/$obj->imagem\">
                                        </td>
                                        <td class=\"alLeft\">$obj->titulo</td>
                                        <td class=\"alCenter\">
                                            $aDesativar
                                            <a href=\"/$tipoUrl/destaques/$obj->codigo/cadastro.html\" title=\"Editar\">Editar</a>
                                        </td>
                                    </tr>
                                ";
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </article>
                    <a class="btnVoltar" href="/<?php print $tipoUrl; ?>/">Voltar</a>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>