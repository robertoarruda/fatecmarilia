<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('album');

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
        <title><?php print "$objI->nomeFantasia - Álbum de Fotos"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_albuns.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Álbuns - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Álbuns</h1>
                        <a href="/<?php print $tipoUrl; ?>/albuns/novo/cadastro.html">Cadastrar Novo Álbum</a>
                        <?php
                        $album = new _foto();
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
                                        $nome = base64_decode($chave);
                                            $count++;
                                            $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                            print "
                                    <tr$classPar>
                                        <td class=\"alCenter\"><ul>";
                                            if (is_array($valor)) {
                                                $count2 = 0;
                                                foreach ($valor['a'] as $cchave => $vvalor) {
                                                    if ($count2 < 4)
                                                        print "
                                                            <li><img class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/" . $vvalor . "196x196/$cchave\"></li>
                                                        ";
                                                    $count2++;
                                                }
                                            }
                                            print "
                                        </ul></td>
                                        <td class=\"alLeft\">$nome</td>
                                        <td class=\"alCenter\">
                                            <a href=\"/$tipoUrl/albuns/" . _funcoes::urlString(strtolower($nome)) . "/fotos.html\" title=\"Editar Fotos\">Editar Fotos</a>
                                            <a href=\"/$tipoUrl/albuns/" . _funcoes::urlString(strtolower($nome)) . "/cadastro.html\" title=\"Editar Álbum\">Editar Álbum</a>
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