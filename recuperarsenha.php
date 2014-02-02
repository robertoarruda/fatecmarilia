<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFuncionarioLogin = new FuncionarioLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objFuncionarioLogin->cpf = returnPost('cpf');
    $objFuncionarioLogin->email = returnPost('email');
    $objFuncionarioLogin->senha = _funcoes::gerarCodAleatorio(6, false, 4);

    $dir = '/login/';
    $erro1 = "
        <script>
        $.showMsg({
            'msg': 'Nenhum cadastro encontrado.',
            'titulo': 'Informações Incorretas'
        });
        </script>
    ";
    $erro2 = "
        <script>
        $.showMsg({
            'msg': 'Ocorreu um erro na operação solicitada.',
            'titulo': 'Erro'
        });
        </script>
    ";
    if ($objFuncionarioLogin->consultarCpfEmail($objFuncionarioLogin->cpf, $objFuncionarioLogin->email)) {
        if ($objFuncionarioLogin->alterarSenha($objFuncionarioLogin->cpf, $objFuncionarioLogin->senha)) {
            $objFuncionario = new Funcionario();
            $objF = $objFuncionario->consultar($objFuncionarioLogin->cpf);
            $subject = 'Solicitação de nova senha - Fatec Marília';
            $headers = 'Content-type: text/html; charset=utf-8' . "\r\n";
            $nome = ($objF) ? " $objF->nome" : '';
            $message = "
                <html lang=\"pt-br\">
                    <body>
                        <img src=\"http://novosite.fatecmarilia.edu.br/imagens/layout/estrutura/jpeg/headerEmail.jpg\" alt=\"Fatec Marília\">
                        <h1>Conforme sua solicitação,<br>estamos enviando sua nova senha.</h1>
                        <p>Olá$nome,<br>Sua senha antiga foi desativada, agora sua senha é:</p>
                        <p class=\"senha\">Nova senha: $objFuncionarioLogin->senha</p>
                        <p class=\"mini\">Favor não responder a este e-mail.<br><a href=\"http://novosite.fatecmarilia.edu.br/\" target=\"_blank\">novosite.fatecmarilia.edu.br</a></p>
                        <p>Faculdade de Tecnologia \"Rafael Almeida Camarinha\"<br>Fatec Marília</p>
                    </body>
                </html>
            ";

            mail($objFuncionarioLogin->email, $subject, $message, $headers);
            print("
                <script>
                $.showMsg({
                    'msg': 'Uma nova senha foi cadastrada e enviada ao seu email.',
                    'titulo': 'Nova Senha'
                }, function(){
                    window.location = '$dir';
                });
                </script>
            ");
        }
        else
            print($erro2);
    }
    else
        print($erro1);
    die();
}

$str = <<<STR
    <label for="cpf">CPF</label>
    <input
        id="cpf"
        name="cpf"
        type="text"
        placeholder="000.000.000-00"
        value=""
        >
    <label for="email">Email</label>
    <input
        id="email"
        name="email"
        type="email"
        value=""
        >
    <div class="clear"></div>
    <div class="buttons">
        <input
            id="btnCancelar"
            name="btnCancelar"
            type="button"
            class="btnForm"
            title="Cancelar"
            value="Cancelar"
            >
        <input
            id="btnSalvar"
            name="btnSalvar"
            type="submit"
            class="btnForm"
            title="Continuar"
            value="Continuar"
            data-cod=""
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
        <title><?php print "$objI->nomeFantasia - Recuperar Senha"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/jquery.validate.methods.js"></script>
        <script src="/js/jquery.maskedinput.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/recuperarsenha.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Recuperar Senha - Login</h1>
                    <article class="boxForm">
                        <h1>Recuperar Senha</h1>
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