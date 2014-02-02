<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('mural');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$departamento = returnGet('c');
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
        <title><?php print "$objI->nomeFantasia - Murais"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_muralDepartamentos.js"></script>
    </head>
   <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Murais - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Notas</h1>
                        <a href="/<?php print "$tipoUrl/mural/$departamento"; ?>/novo/cadastro-nota.html">Cadastrar Nova Nota</a>
                        <a href="/<?php print "$tipoUrl/mural/$departamento"; ?>/novo/cadastro-link.html">Cadastrar Novo Link</a>
                        <a href="/<?php print "$tipoUrl/mural/$departamento"; ?>/novo/cadastro-download.html">Cadastrar Novo Download</a>
                        <?php
                        $objMurais = new Mural();
                        if ($objMurais->qtdRegistrosDepartamento($departamento) <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="codigo">Código</th>
                                        <th class="codigo">Imagem</th>
                                        <th class="alLeft">Título</th>
                                        <th class="opcoes">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="codigo">Código</td>
                                        <td class="codigo">Imagem</td>
                                        <td class="alLeft">Título</td>
                                        <td class="opcoes">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($objMurais->listarTudoDepartamento($departamento) as $obj) {
                                        $tipoMural = 'Nota';
                                        if ($obj->arquivo) {
                                            $tipoMural = 'Download';
                                        } elseif ($obj->linkUrl) {
                                            $tipoMural = 'Link';
                                        }
                                        $count++;
                                        $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                        print "
                                            <tr$classPar>
                                                <td class=\"alCenter\">$obj->codigo</td>
                                                <td class=\"alCenter\">
                                                    <img class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/$obj->dirImagem" . "150x150/$obj->imagem\">
                                                </td>
                                                <td class=\"alLeft\">$obj->titulo</td>
                                                <td class=\"alCenter\">
                                                    <a title=\"Excluir\" data-departamento=\"$departamento\" data-codigo=\"$obj->codigo\" data-tipo=\"$tipoMural\">Excluir</a>
                                                    <a href=\"/$tipoUrl/mural/$departamento/$obj->codigo/cadastro-$tipoMural.html\" title=\"Editar\">Editar</a>
                                                </td>
                                            </tr>
                                        ";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </article>
                    <a class="btnVoltar" href="/<?php print $tipoUrl; ?>/mural/">Voltar</a>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>