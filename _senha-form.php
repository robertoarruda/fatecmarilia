<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('perfil');

$objFLogin = new FuncionarioLogin();

if ($objFLogin->retornaSessaoTemp()) {
    $tipo = $objFL->retornaSessaoTemp()->tipo;
    $tipoUrl = $objFL->retornaSessaoTemp()->tipoUrl;
} else {
    $tipo = $objFL->retornaFuncionarioSessao()->tipo;
    $tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objFLogin->cpf = returnPost('cpf');
    $objFLogin->senha = returnPost('novaSenha');
    
    if (!$objFLogin->conferirSenha($objFLogin->cpf, returnPost('senhaAtual'))) {
        print("
            <script>
            $.showMsg({
                msg: 'Senha atual incorreta.',
                titulo: 'Erro'
            });
            </script>
        ");
        die();
    }
    
    if ($objFLogin->retornaSessaoTemp())
        $dir = '/logout/';
    else
        $dir = "/$tipoUrl/";
    $erro = "
        <script>
        $.showMsg({
            msg: 'Ocorreu um erro na operação solicitada.',
            titulo: 'Erro'
        });
        </script>
    ";
    switch (strtolower(returnPost('acao'))) {
        case 'alterar':
            if ($objFLogin->alterarSenha($objFLogin->cpf, $objFLogin->senha))
                print("
                    <script>
                    $.showMsg({
                        msg: 'Alteração efetuada com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                        window.location = '$dir';
                    });
                    </script>
                ");
            else
                print($erro);
            break;
    }
    die();
} else {
    if ($objFLogin->retornaSessaoTemp()) {
        $objFLogin = $objFLogin->retornaSessaoTemp();
        $cpf = $objFLogin->cpf;
    } elseif ($objFLogin->retornaFuncionarioSessao()) {
        $objFuncionario = $objFLogin->retornaFuncionarioSessao();
        $cpf = $objFuncionario->funcionariosLogin_cpf->cpf;
    } else {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}

if (!$objFLogin->retornaSessaoTemp()) {
    $btnCancelar = '
        <input
            id="btnCancelar"
            name="btnCancelar"
            type="button"
            class="btnForm"
            title="Cancelar"
            value="Cancelar"
        >
    ';
}

$str = <<<STR
        <input
            id="cpf"
            name="cpf"
            type="hidden"
            value="$cpf"
        >
        <label for="senhaAtual">Senha Atual</label>
        <input
            id="senhaAtual"
            name="senhaAtual"
            type="password"
            maxlength="$objFLogin->limite_senha"
        >
        <label for="novaSenha">Nova Senha</label>
        <input
            id="novaSenha"
            name="novaSenha"
            type="password"
            maxlength="$objFLogin->limite_senha"
        >
        <label for="repetirNovaSenha">Repetir Nova Senha</label>
        <input
            id="repetirNovaSenha"
            name="repetirNovaSenha"
            type="password"
            maxlength="$objFLogin->limite_senha"
        >
    <div class="clear"></div>
    <div class="buttons">
        $btnCancelar
        <input
            id="btnSalvar"
            name="btnSalvar"
            type="submit"
            class="btnForm"
            title="Alterar"
            value="Alterar"
            data-cod="$cpf"
        >
    </div>
STR;
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
        <title><?php print "$objI->nomeFantasia - Alterar Senha"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_senha-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Meus Dados - Área do <?php print $tipo; ?></h1>
                    <?php
                    if ($objFLogin->retornaSessaoTemp()) {
                    ?>
                        <div id="passos">
                            <p class="p1"><span>2º</span> Passo</p>
                            <p>Seu cadastro já está quase pronto. Cadastre uma nova senha, e depois faça o login novamente.</p>
                        </div>
                        <?php
                    }
                    ?>
                    <article class="boxForm">
                        <h1>Alterar Senha</h1>
                        <form method="post">
                            <?php print $str; ?>
                        </form>
                    </article>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>