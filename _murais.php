<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('mural');

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
        <title><?php print "$objI->nomeFantasia - Murais"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/scripts/_murais.js"></script>
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
                        <h1>Departamentos</h1>
                        <a href="/<?php print $tipoUrl; ?>/departamentos/">Ativar Mural</a>
                        <?php
                        $objDepartamentos = new Departamento();
                        if ($objDepartamentos->qtdRegistrosMural() <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="codigo">Código</th>
                                        <th class="alLeft">Nome</th>
                                        <th class="codigo">Mural</th>
                                        <th class="opcoes2">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="codigo">Código</td>
                                        <td class="alLeft">Nome</td>
                                        <td class="codigo">Mural</td>
                                        <td class="opcoes2">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($objDepartamentos->listarMural() as $obj) {
                                        $count++;
                                        $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                        $mural = ($obj->mural) ? 'checked' : 'unchecked';
                                        print "
                                    <tr$classPar>
                                        <td class=\"alCenter\">$obj->codigo</td>
                                        <td class=\"alLeft\">$obj->nome</td>
                                        <td class=\"alCenter\"><span class=\"$mural\"></span></td>
                                        <td class=\"alCenter\">
                                            <a href=\"/$tipoUrl/departamentos/$obj->codigo/cadastro.html\" title=\"Desativar\">Desativar</a>
                                            <a href=\"/$tipoUrl/mural/$obj->codigo/\" title=\"Editar\">Editar</a>
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