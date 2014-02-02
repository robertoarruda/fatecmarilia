<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('agenda');

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
        <title><?php print "$objI->nomeFantasia - Agendas"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/scripts/_agendas.js"></script>
    </head>
   <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Agendas - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Agendas</h1>
                        <?php
                        if ($objFL->checaPermissao('administrar-agenda'))
                            print "<a href=\"/$tipoUrl/agendas/novo/cadastro.html\">Cadastrar Nova Agenda</a>";
                        $objAgendas = new Agenda();
                        if ($objAgendas->qtdRegistros() <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="codigo">Código</th>
                                        <th class="alLeft">Nome</th>
                                        <th class="opcoes3">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="codigo">Código</td>
                                        <td class="alLeft">Nome</td>
                                        <td class="opcoes3">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($objAgendas->listarTudo() as $obj) {
                                        $count++;
                                        $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                        print "
                                    <tr$classPar>
                                        <td class=\"alCenter\">$obj->codigo</td>
                                        <td class=\"alLeft\">$obj->nome</td>
                                        <td class=\"alCenter\">
                                            <a title=\"Excluir\" data-codigo=\"$obj->codigo\">Excluir</a>
                                            <a href=\"/$tipoUrl/agendas/$obj->codigo/cadastro.html\" title=\"Editar\">Editar</a>
                                            <a href=\"/$tipoUrl/agendas/" . strtolower($obj->tipoDeHorario) . "/$obj->codigo/\" title=\"Abrir\">Abrir</a>
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