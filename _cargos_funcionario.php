<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('cargos-funcionario');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objFLogin = new FuncionarioLogin();
$objFLogin = $objFLogin->consultar(returnGet('c'));
if (!$objFLogin) {
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
        <link rel="stylesheet" type="text/css" href="/css/_forms.css">
        <title><?php print "$objI->nomeFantasia - Cargos por Funcionários"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/scripts/_cargos_funcionario.js"></script>
    </head>
   <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Cargos - Cargos por Funcionários - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Cargos do Funcionário</h1>
                        <a href="/<?php print $tipoUrl; ?>/funcionarios/cargos/<?php print $objFLogin->cpf; ?>/cadastro.html">Cadastrar Novo Cargo</a>
                        <?php
                        $objAC = new Administrativo_Cargo();
                        if (!$objAC->listarTudoFuncionario($objFLogin->cpf)) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="codigo">Código</th>
                                        <th class="alLeft">Nome</th>
                                        <th class="opcoes1">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="codigo">Código</td>
                                        <td class="alLeft">Nome</td>
                                        <td class="opcoes1">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $objAC = $objAC->listarTudoFuncionario($objFLogin->cpf);
                                    for ($c = 0; $c < count($objAC); $c++) {
                                        $obj = $objAC[$c];
                                        $count++;
                                        $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                        print "
                                            <tr$classPar>
                                                <td class=\"alCenter\">" . $obj->cargos_codigo->codigo . "</td>
                                                <td class=\"alLeft\">" . $obj->cargos_codigo->consultar($obj->cargos_codigo->codigo)->nome . "</td>
                                                <td class=\"alCenter\">
                                                    <a title=\"Excluir\" data-cargo=\"" . $obj->cargos_codigo->codigo . "\" data-cpf=\"" . $objFLogin->cpf . "\">Excluir</a>
                                                </td>
                                            </tr>
                                        ";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </article>
                    <a class="btnVoltar" href="/<?php print $tipoUrl; ?>/funcionarios/cargos/">Voltar</a>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>