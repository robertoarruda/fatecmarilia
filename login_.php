<?php
require_once('ie.php');
require_once('config/loadConfig.php');
$res = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['LoginAluno'])) {
        $objALogin = new AlunoLogin();
        $objALogin = $objALogin->logar(returnPost('LoginAluno'), returnPost('SenhaAluno'));
        if ($objALogin) {
            switch ($objALogin->situacao) {
                case 'A':
                    $res = "<script>window.location = '/aluno/';</script>";
                    break;
                case 'P':
                    $objALogin->gerarSessaoTemp($objALogin->cpf);
                    $res = "<script>window.location = '/aluno/perfil/cadastro.html';</script>";
                    break;
                case 'D':
                    $res = "<script>$.showMsg({msg: 'Usuário desativado!<br>Consulte um administrador.'});</script>";
                    break;
            }
        } else
            $res = '
            <script>$.showMsg({\'msg\': \'Usuário e/ou senha inválido(s)!\'});</script>
        ';
    } elseif (isset($_POST['LoginProfessor'])) {
        $objFLogin = new FuncionarioLogin();
        $objAcademico = new Academico();
        if ($objFLogin = $objFLogin->logar(returnPost('LoginProfessor'), returnPost('SenhaProfessor'))) {
            if ($objAcademico->consultar($objFLogin->cpf)) {
                $objFuncionario = new Funcionario();
                if (!$objFuncionario->consultar($objFLogin->cpf)) {
                    $objFLogin->gerarSessaoTemp($objFLogin->cpf, "Professor");
                    $res = "<script>window.location = '/professor/perfil/cadastro.html';</script>";
                } else {
                    switch ($objFLogin->situacao) {
                        case 'A':
                            $objFLogin->gerarSessao($objFLogin->cpf, "Professor");
                            $res = "<script>window.location = '/professor/';</script>";
                            break;
                        case 'D':
                            $res = "<script>$.showMsg({msg: 'Usuário desativado!<br>Consulte um administrador.'});</script>";
                            break;
                    }
                }
            } else
                $res = '
                <script>$.showMsg({\'msg\': \'Usuário e/ou senha inválido(s)!\'});</script>
            ';
        } else
            $res = '
            <script>$.showMsg({\'msg\': \'Usuário e/ou senha inválido(s)!\'});</script>
        ';
    } elseif (isset($_POST['LoginFuncionario'])) {
        $objFLogin = new FuncionarioLogin();
        $objAdministrativo = new Administrativo();
        if ($objFLogin = $objFLogin->logar(returnPost('LoginFuncionario'), returnPost('SenhaFuncionario'))) {
            if ($objAdministrativo->consultar($objFLogin->cpf)) {
                $objFuncionario = new Funcionario();
                if (!$objFuncionario->consultar($objFLogin->cpf)) {
                    $objFLogin->gerarSessaoTemp($objFLogin->cpf, "Funcionário");
                    $res = "<script>window.location = '/funcionario/perfil/cadastro.html';</script>";
                } else {
                    switch ($objFLogin->situacao) {
                        case 'A':
                            $objFLogin->gerarSessao($objFLogin->cpf, "Funcionário");
                            $res = "<script>window.location = '/funcionario/';</script>";
                            break;
                        case 'D':
                            $res = "<script>$.showMsg({msg: 'Usuário desativado!<br>Consulte um administrador.'});</script>";
                            break;
                    }
                }
            } else
                $res = '
                <script>$.showMsg({\'msg\': \'Usuário e/ou senha inválido(s)!\'});</script>
            ';
        } else
            $res = '
            <script>$.showMsg({\'msg\': \'Usuário e/ou senha inválido(s)!\'});</script>
        ';
    }
} else {
    @session_start();
    $objFLogin = new FuncionarioLogin();
    if (isset($_SESSION["$objFLogin->nomeSessao"])) {
        header('Location:/');
    }
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!-- Facebook Open Graph -->
        <meta property="og:url" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" >
        <meta property="og:site_name" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nomeFantasia); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Login">
        <meta property="og:image" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . "/imagens/layout/estrutura/png/logoFatec.graphic.png"; ?>">
        <meta property="og:description" content="">
        <meta property="fb:admins" content="100002559673601">
        <!-- Facebook Open Graph -->
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/login.css">
        <title><?php print "$objI->nomeFantasia - Login"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/plugins/jquery.centraliza.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/login.js"></script>
    </head>
    <body>
        <?php print $res; ?>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Login</h1>
                    <ul id="boxLogin">
                        <li>
                            <article class="boxLogin">
                                <h1>Área do Aluno</h1>
                                <img src="/imagens/layout/estrutura/png/aluno.png">
                                <form id="frmAlunos" action="/frame/<?php print base64_encode('http://www.fatecmarilia.edu.br/aluno/aluno_login.php'); ?>/" method="post">
                                    <div class="login">
                                        <input type="submit" class="btnLogin" title="Entrar" value="Entrar">
                                    </div>
                                </form>
                            </article>
                        </li>
                        <li>
                            <article class="boxLogin">
                                <h1>Área do Professor</h1>
                                <img src="/imagens/layout/estrutura/png/professor.png">
                                <form id="frmProfessores" name="frmProfessores" action="/login/" method="post">
                                    <label for="LoginProfessor">Email</label>
                                    <input id="LoginProfessor" name="LoginProfessor" type="email">
                                    <label for="SenhaProfessor">Senha</label>
                                    <input id="SenhaProfessor" name="SenhaProfessor" type="password">
                                    <div class="login">
                                        <input type="submit" class="btnLogin" title="Entrar" value="Entrar">
                                        <p>
                                            <a href="/login/professor/recuperar-senha.html">Não consegue acessar a sua conta?</a>
                                            <a class="solicite">Não possui uma conta? Solicite já!</a>
                                        </p>
                                    </div>
                                </form>
                            </article>
                        </li>
                        <li>
                            <article class="boxLogin">
                                <h1>Área do Funcionário</h1>
                                <img src="/imagens/layout/estrutura/png/funcionario.png">
                                <form id="frmFuncionarios" name="frmFuncionarios" action="/login/" method="post">
                                    <label for="LoginFuncionario">Email</label>
                                    <input id="LoginFuncionario" name="LoginFuncionario" type="email">
                                    <label for="SenhaFuncionario">Senha</label>
                                    <input id="SenhaFuncionario" name="SenhaFuncionario" type="password">
                                    <div class="login">
                                        <input type="submit" class="btnLogin"  title="Entrar" value="Entrar">
                                        <p>
                                            <a href="/login/funcionario/recuperar-senha.html">Não consegue acessar a sua conta?</a>
                                            <a class="solicite">Não possui uma conta? Solicite já!</a>
                                        </p>
                                    </div>
                                </form>
                            </article>
                        </li>
                    </ul>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>