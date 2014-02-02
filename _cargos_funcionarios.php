<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('cargos-funcionario');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objFLogin = new FuncionarioLogin();
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
        <title><?php print "$objI->nomeFantasia - Cargos por Funcionários"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Cargos por Funcionários - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Funcionários</h1>
                        <?php
                        if (!$objFLogin->qtdRegistros()) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="codigo2">CPF</th>
                                        <th class="alLeft">Email</th>
                                        <th class="opcoes1">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="codigo2">CPF</td>
                                        <td class="alLeft">Email</td>
                                        <td class="opcoes1">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($objFLogin->listarTudo() as $obj) {
                                        $count++;
                                        $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                        print "
                                            <tr$classPar>
                                                <td class=\"alCenter\">$obj->cpf</td>
                                                <td class=\"alLeft\">$obj->email</td>
                                                <td class=\"alCenter\">
                                                    <a title=\"Editar\" href=\"/$tipoUrl/funcionarios/cargos/$obj->cpf/cargos.html\">Editar</a>
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