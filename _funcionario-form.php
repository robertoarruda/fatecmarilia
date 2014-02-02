<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('funcionario');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objFuncionarioLogin = new FuncionarioLogin();
$objAcademico = new Academico();
$objAdministrativo = new Administrativo;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objFuncionarioLogin->cpf = returnPost('cpf');
    $objFuncionarioLogin->email = returnPost('email');
    $objFuncionarioLogin->senha = _funcoes::gerarCodAleatorio(6, false, 4);
    $objFuncionarioLogin->situacao = 'A';
    $objFuncionarioLogin->instituicao_codigo->codigo = returnPost('instituicao_codigo');

    $objAcademico->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = returnPost('cpf');
    $objAcademico->titulacao = '';
    $objAcademico->urlLattes = '';
    
    $objAdministrativo->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = returnPost('cpf');

    $dir = "/$tipoUrl/funcionarios/";
    $dir2 = (returnPost('tipo') == 'administrativo') ? "/$tipoUrl/funcionarios/cargos/$objFuncionarioLogin->cpf/cadastro.html" : $dir;
    $erro = "
        <script>
        $.showMsg({
            msg: 'Ocorreu um erro na operação solicitada.',
            titulo: 'Erro'
        });
        </script>
    ";
    switch (strtolower(returnPost('acao'))) {
        case 'cadastrar':
            if ($objFuncionarioLogin->inserir()) {
                if (returnPost('tipo') == 'administrativo')
                    $res = $objAdministrativo->inserir();
                else
                    $res = $objAcademico->inserir();
                if ($res) {
                    $objFuncionario = new Funcionario();
                    @mkdir("$objFuncionario->dirFoto$objFuncionarioLogin->cpf/", 0777);
                    sleep(2);
                    @mkdir("$objFuncionario->dirFoto$objFuncionarioLogin->cpf/150x150/", 0777);
                    sleep(2);
                    @mkdir("$objFuncionario->dirFoto$objFuncionarioLogin->cpf/354x472/", 0777);
                    $subject = 'Cadastro - Fatec Marília';
                    $headers = 'Content-type: text/html; charset=utf-8' . "\r\n";
                    $message = "
                        <html lang=\"pt-br\">
                            <body>
                                <img src=\"http://novosite.fatecmarilia.edu.br/imagens/layout/estrutura/jpeg/headerEmail.jpg\" alt=\"Fatec Marília\">
                                <h1>Seu email foi cadastrado no site da Fatec Marília.</h1>
                                <p>Seu email \"$objFuncionarioLogin->email\", foi cadastrado no site da Fatec Marília.<br>
                                Para acessa-lo utilize o seguinte login e senha:</p>
                                <p class=\"senha\">Login: $objFuncionarioLogin->email<br>Senha: $objFuncionarioLogin->senha</p>
                                <p>Para logar acesse o link <a href=\"http://novosite.fatecmarilia.edu.br/login/\" target=\"_blank\">novosite.fatecmarilia.edu.br/login/</a>.
                                <p class=\"mini\">Favor não responder a este e-mail.<br><a href=\"http://novosite.fatecmarilia.edu.br/\" target=\"_blank\">novosite.fatecmarilia.edu.br</a></p>
                                <p>Faculdade de Tecnologia \"Rafael Almeida Camarinha\"<br>Fatec Marília</p>
                            </body>
                        </html>
                    ";

                    @mail($objFuncionarioLogin->email, $subject, $message, $headers);
                    print("
                        <script>
                        $.showMsg({
                            msg: 'Cadastro efetuado com sucesso.<br>Uma notificação foi enviada ao email cadastrado com o login, senha e link para efetuar o login.',
                            titulo: 'Sucesso'
                        }, function(){
                            window.location = '$dir2';
                        });
                        </script>
                    ");
                } else {
                    $objFuncionarioLogin->excluir($objFuncionarioLogin->cpf);
                    print($erro);
                }
            }
            else
                print($erro);
            break;
        case 'ativar':
            if ($objFuncionarioLogin->alterarSituacao(returnPost('dados'), 'A')) {
                print("
                    <script>
                    $.showMsg({
                        msg': 'Funcionário ativado com sucesso.',
                        titulo': 'Sucesso'
                    }, function(){
                        window.location = '$dir';
                    });
                    </script>
                ");
            }
            else
                print($erro);
            break;
        case 'desativar':
            if ($objFuncionarioLogin->alterarSituacao(returnPost('dados'), 'D')) {
                print("
                    <script>
                    $.showMsg({
                        msg: 'Funcionário desativado com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                        window.location = '$dir';
                    });
                    </script>
                ");
            }
            else
                print($erro);
            break;
    }
    die();
}

$nameButton = ($objFuncionarioLogin->cpf) ? 'Alterar' : 'Cadastrar';
$objInstituicoes = new Instituicao();
$instituicao = '<option value="">Selecione...</option>';
foreach ($objInstituicoes->listarTudo() as $obj) {
    $instituicao .= "<option value=\"$obj->codigo\">$obj->nomeFantasia</option>";
}
$objDepartamentos = new Departamento();
$departamento = '<option value="">Selecione...</option>';
foreach ($objDepartamentos->listarTudo() as $obj) {
    $departamento .= "<option value=\"$obj->codigo\">$obj->nome</option>";
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
            maxlength="$objFuncionarioLogin->limite_email"
        >
        <label for="instituicao_codigo">Instituição</label>
        <select
            id="instituicao_codigo"
            name="instituicao_codigo"
        >$instituicao</select>
        <label for="tipo">Tipo</label>
        <select
            id="tipo"
            name="tipo"
        >
            <option value="academico">Acadêmico</option>
            <option value="administrativo">Administrativo</option>
        </select>
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
            title="$nameButton"
            value="$nameButton"
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
        <title><?php print "$objI->nomeFantasia - Funcionário"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/jquery.validate.methods.js"></script>
        <script src="/js/jquery.maskedinput.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_funcionario-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
<?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Funcionário - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Funcionário</h1>
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