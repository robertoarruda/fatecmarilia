<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('cargo');

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
        <title><?php print "$objI->nomeFantasia - Cargos"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/scripts/_cargos.js"></script>
    </head>
   <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Cargos - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Cargos</h1>
                        <a href="/<?php print $tipoUrl; ?>/cargos/novo/cadastro.html">Cadastrar Novo Cargo</a>
                        <?php
                        $objCargos = new Cargo();
                        if ($objCargos->qtdRegistros() <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="codigo">Código</th>
                                        <th class="alLeft">Nome</th>
                                        <th class="alLeft">Departamento</th>
                                        <th class="opcoes">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="codigo">Código</td>
                                        <td class="alLeft">Nome</td>
                                        <td class="alLeft">Departamento</td>
                                        <td class="opcoes">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($objCargos->listarTudo() as $obj) {
                                        $count++;
                                        $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                        $objDepartamento = new Departamento();
                                        $objDepartamento = $objDepartamento->consultar($obj->departamentos_codigo->codigo);
                                        print "
                                            <tr$classPar>
                                                <td class=\"alCenter\">$obj->codigo</td>
                                                <td class=\"alLeft\">$obj->nome</td>
                                                <td class=\"alLeft\">$objDepartamento->nome</td>
                                                <td class=\"alCenter\">
                                                    <a title=\"Excluir\" data-codigo=\"$obj->codigo\">Excluir</a>
                                                    <a href=\"/$tipoUrl/cargos/$obj->codigo/cadastro.html\" title=\"Editar\">Editar</a>
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