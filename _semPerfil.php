<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('cargos-funcionario');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objFLogin = new FuncionarioLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $objAdministrativo = new Administrativo();
    $objAdministrativo_Cargo = new Administrativo_Cargo();
    $objAcademico = new Academico();

    $dir = "/$tipoUrl/funcionarios/sem-perfil.html";
    $erro = "
        <script>
        $.showMsg({
            msg: 'Ocorreu um erro na operação solicitada.',
            titulo: 'Erro'
        });
        </script>
    ";
    switch (strtolower(returnPost('acao'))) {
        case 'excluir':
            $cpf = returnPost('dados');
            $res = true;
            if ($objAdministrativo->consultar($cpf)) {
                if ($objAdministrativo_Cargo->existeFuncionario($cpf))
                    $res = $objAdministrativo_Cargo->excluirFuncionario($cpf);
                if ($res)
                    $res = $objAdministrativo->excluir($cpf);
            } elseif ($objAcademico->consultar($cpf)) {
                $res = $objAcademico->excluir($cpf);
            }
            if ($res) {
                if ($objFLogin->excluir(returnPost('dados'))) {
                    print("
                        <script>
                        $.showMsg({
                            msg: 'Remoção efetuada com sucesso.',
                            titulo: 'Sucesso'
                        }, function(){
                            window.location = '$dir';
                        });
                        </script>
                    ");
                } else
                    print($erro);
            } else
                print($erro);
            break;
    }
    die();
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
        <title><?php print "$objI->nomeFantasia - Funcionários"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/scripts/_semPerfil.js"></script>
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
                        <h1>Logins Sem Perfil</h1>
                        <?php
                        if (!$objFLogin->qtdRegistrosSemPerfil()) {
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
                                    foreach ($objFLogin->listarSemPerfil() as $obj) {
                                        $count++;
                                        $classPar = (($count % 2) == 0) ? ' class="par"' : '';
                                        print "
                                            <tr$classPar>
                                                <td class=\"alCenter\">$obj->cpf</td>
                                                <td class=\"alLeft\">$obj->email</td>
                                                <td class=\"alCenter\">
                                                    <a title=\"Excluir\" data-codigo=\"$obj->cpf\">Excluir</a>
                                                </td>
                                            </tr>
                                        ";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </article>
                    <a class="btnVoltar" href="/<?php print $tipoUrl; ?>/funcionarios/">Voltar</a>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>