<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('curso');

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
        <title><?php print "$objI->nomeFantasia - Cursos"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_cursosGraduacao.js"></script>
    </head>
   <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Cursos - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Cursos de Graduação</h1>
                        <a href="/<?php print $tipoUrl; ?>/cursos/graduacao/novo/cadastro.html">Cadastrar Novo Curso</a>
                        <?php
                        $objCursos = new Curso();
                        if ($objCursos->qtdRegistros() <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="codigo">Código</th>
                                        <th class="codigo">Imagem</th>
                                        <th class="alLeft">Nome Completo</th>
                                        <th class="opcoes">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="codigo">Código</td>
                                        <td class="codigo">Imagem</td>
                                        <td class="alLeft">Nome Completo</td>
                                        <td class="opcoes">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($objCursos->listarTudo() as $obj) {
                                        $count++;
                                        $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                        print "
                                    <tr$classPar>
                                        <td class=\"alCenter\">$obj->codigo</td>
                                        <td class=\"alCenter\">
                                            <img class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/$obj->dirImagem" . "150x150/$obj->imagem\">
                                        </td>
                                        <td class=\"alLeft\">$obj->nomeCompleto</td>
                                        <td class=\"alCenter\">
                                            <a title=\"Excluir\" data-codigo=\"$obj->codigo\">Excluir</a>
                                            <a href=\"/$tipoUrl/cursos/graduacao/$obj->codigo/cadastro.html\" title=\"Editar\">Editar</a>
                                        </td>
                                    </tr>
                                ";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </article>
                    <a class="btnVoltar" href="/<?php print $tipoUrl; ?>/cursos/">Voltar</a>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>