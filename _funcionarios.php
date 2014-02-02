<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('funcionario');

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
        <title><?php print "$objI->nomeFantasia - Funcionários"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_funcionarios.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Funcionários - Área do <?php print $tipo; ?></h1>
                    <article class="boxList">
                        <h1>Funcionários</h1>
                        <a href="/<?php print $tipoUrl; ?>/funcionarios/novo/cadastro.html">Cadastrar Novo Funcionário</a>
                        <a href="/<?php print $tipoUrl; ?>/funcionarios/sem-perfil.html">Logins Sem Perfil</a>
                        <?php
                        $objFuncionarios = new Funcionario();
                        if ($objFuncionarios->qtdRegistros() <= 0) {
                            print '<p>Nenhum registro encontrado.</p>';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="codigo">Imagem</th>
                                        <th class="alLeft">Nome Completo</th>
                                        <th class="alCenter">Último Acesso</th>
                                        <th class="alCenter">Situação</th>
                                        <th class="opcoes1">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="codigo">Imagem</td>
                                        <td class="alLeft">Nome Completo</td>
                                        <td class="alCenter">Último Acesso</td>
                                        <td class="alCenter">Situação</td>
                                        <td class="opcoes1">Opções</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $objFuncionarioLogin = new FuncionarioLogin();
                                    foreach ($objFuncionarios->listarTudo() as $obj) {
                                        $objFuncionarioLogin = $objFuncionarioLogin->consultar($obj->funcionariosLogin_cpf->cpf);
                                        $count++;
                                        $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                        switch ($objFuncionarioLogin->situacao) {
                                            case 'A':
                                                $situacao = 'Ativo';
                                                $btnName = 'Desativar';
                                                break;
                                            case 'D':
                                                $situacao = 'Desativo';
                                                $btnName = 'Ativar';
                                                break;
                                        }
                                        $btnAD = "<a title=\"$btnName\" data-codigo=\"" . $obj->funcionariosLogin_cpf->cpf . "\"class=\"opcoes1\">$btnName</a>";
                                        $foto = $obj->dirFoto . $obj->funcionariosLogin_cpf->cpf . "/150x150/$obj->foto";
                                        $foto = (is_file($foto) ? $foto : 'imagens/layout/estrutura/png/funcionario.png');
                                        print "
                                            <tr$classPar>
                                                <td class=\"alCenter\">
                                                    <img class=\"lazy\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=\"/$foto\">
                                                </td>
                                                <td class=\"alLeft\">$obj->nomeAbreviado</td>
                                                <td class=\"alCenter\">" . date('d/m/Y H:i:s', strtotime($obj->funcionariosLogin_cpf->consultar($obj->funcionariosLogin_cpf->cpf)->ultimoAcesso)) . "</td>
                                                <td class=\"alCenter\">$situacao</td>
                                                <td class=\"alCenter\">
                                                    $btnAD
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