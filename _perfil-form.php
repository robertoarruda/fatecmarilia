<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('perfil');

$objFuncionario = new Funcionario();
$objFLogin = new FuncionarioLogin();

if ($objFLogin->retornaSessaoTemp()) {
    $tipo = $objFL->retornaSessaoTemp()->tipo;
    $tipoUrl = $objFL->retornaSessaoTemp()->tipoUrl;
} else {
    $tipo = $objFL->retornaFuncionarioSessao()->tipo;
    $tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = explode('/', returnPost('dataNascimento'));
    if (count($data) == 3) {
        if ($data[2] > 31)
            $data = "$data[2]-$data[1]-$data[0]";
        else
            $data = returnPost('dataNascimento');
    } else
        $data = returnPost('dataNascimento');
    
    $objFuncionario->funcionariosLogin_cpf->cpf = returnPost('funcionariosLogin_cpf');
    $objFuncionario->nome = returnPost('nome');
    $objFuncionario->sexo = returnPost('sexo');
    $objFuncionario->dataNascimento = $data;
    $objFuncionario->foto = returnPost('foto');
    
    $objAcademico = new Academico();
    $objAc = $objAcademico->consultar($objFuncionario->funcionariosLogin_cpf->cpf);
    if ($objAc) {
        $objAcademico->titulacao = returnPost('titulacao');
        $objAcademico->urlLattes = returnPost('urlLattes');
    }
    $objAdministrativo = new Administrativo();
    $objAd = $objAdministrativo->consultar($objFuncionario->funcionariosLogin_cpf->cpf);
    if ($objAd) {
        $objAdministrativo->formacao = returnPost('formacao');
    }

    if ($objFLogin->retornaSessaoTemp())
        $dir = "/$tipoUrl/perfil/senha.html";
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
        case 'cadastrar':
            $res = '';
            if ($objAc)
                $res = $objAcademico->editar($objFuncionario->funcionariosLogin_cpf->cpf);
            elseif ($objAd)
                $res = $objAdministrativo->editar($objFuncionario->funcionariosLogin_cpf->cpf);
            if ($objFuncionario->inserir()) {
                if ($res)
                    print("
                        <script>
                        $.showMsg({
                            msg: 'Cadastro efetuado com sucesso.',
                            titulo: 'Sucesso'
                        }, function(){
                            window.location = '$dir';
                        });
                        </script>
                    ");
                 else
                    print($erro);
            } else
                print($erro);
            break;
        case 'alterar':
            $res = '';
            if ($objAc)
                $res = $objAcademico->editar($objFuncionario->funcionariosLogin_cpf->cpf);
            elseif ($objAd)
                $res = $objAdministrativo->editar($objFuncionario->funcionariosLogin_cpf->cpf);
            if ($objFuncionario->editar($objFuncionario->funcionariosLogin_cpf->cpf)) {
                if ($res)
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
            } else
                print($erro);
            break;
    }
    $objFuncionario = $objFuncionario->consultar($objFuncionario->funcionariosLogin_cpf->cpf);
    $objFLogin->editarFuncionarioSessao('nome', $objFuncionario->nome);
    $objFLogin->editarFuncionarioSessao('nomeAbreviado', $objFuncionario->nomeAbreviado);
    $objFLogin->editarFuncionarioSessao('sexo', $objFuncionario->sexo);
    $objFLogin->editarFuncionarioSessao('dataNascimento', $objFuncionario->dataNascimento);
    $objFLogin->editarFuncionarioSessao('foto', $objFuncionario->foto);
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

$objAcademico = new Academico();
$objAcademico = $objAcademico->consultar($cpf);

$academico = '';
if ($objAcademico) {
    $a[0] = '';
    $a[1] = '';
    $a[2] = '';
    $a[3] = '';
    switch ($objAcademico->titulacao) {
        case 'D':
            $a[0] = ' selected="selected"';
            break;
        case 'M':
            $a[1] = ' selected="selected"';
            break;
        case 'E':
            $a[2] = ' selected="selected"';
            break;
        case 'G':
            $a[3] = ' selected="selected"';
            break;
    }

    $academico = "
        <label for=\"titulacao\">Titulação</label>
        <select
            id=\"titulacao\"
            name=\"titulacao\"
        >
            <option value=\"\">Selecione...</option>
            <option value=\"D\"$a[0]>Doutor(a)</option>
            <option value=\"M\"$a[1]>Mestre</option>
            <option value=\"E\"$a[2]>Especialista</option>
            <option value=\"G\"$a[3]>Graduado(a)</option>
        </select>
        <label for=\"urlLattes\">Lattes (URL)</label>
        <input
            id=\"urlLattes\"
            name=\"urlLattes\"
            type=\"url\"
            placeholder=\"http://buscatextual.cnpq.br/buscatextual/visualizacv.do?id=\"
            value=\"$objAcademico->urlLattes\"
            maxlength=\"$objAcademico->limite_urlLattes\"
        >
    ";
}
$objAdministrativo = new Administrativo();
$objAdministrativo = $objAdministrativo->consultar($cpf);

$administrativo = '';
if ($objAdministrativo) {
    $administrativo = "
        <label for=\"formacao\">Formação</label>
        <textarea id=\"formacao\" name=\"formacao\">$objAdministrativo->formacao</textarea>
    ";
}

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') === FALSE)
    $objFuncionario->dataNascimento = ($objFuncionario->dataNascimento) ? date('d/m/Y', strtotime($objFuncionario->dataNascimento)) : '';
$nameButton = ($objFuncionario->funcionariosLogin_cpf->cpf) ? 'Alterar' : 'Cadastrar';
$dir = base64_encode("$objFuncionario->dirFoto$cpf/");

$slcFem = ($objFuncionario->sexo == 'F') ? ' selected="selected"' : '';
$slcMas = ($objFuncionario->sexo == 'M') ? ' selected="selected"' : '';

$btnCancelar = '';
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
            id="funcionariosLogin_cpf"
            name="funcionariosLogin_cpf"
            type="hidden"
            value="$cpf"
        >
        <label for="nome">Nome</label>
        <input
            id="nome"
            name="nome"
            type="text"
            value="$objFuncionario->nome"
            maxlength="$objFuncionario->limite_nome"
        >
        <label for="sexo">Sexo</label>
        <select
            id="sexo"
            name="sexo"
        >
            <option value="">Selecione...</option>
            <option value="F"$slcFem>Feminino</option>
            <option value="M"$slcMas>Masculino</option>
        </select>
        <label for="dataNascimento">Data de Nascimento</label>
        <input
            id="dataNascimento"
            name="dataNascimento"
            type="date"
            placeholder="00/00/0000"
            value="$objFuncionario->dataNascimento"
        >
        <label for="foto">Foto</label>
        <div class="imageManager">
        <input
                id="foto"
                name="foto"
                type="text"
                readonly="readonly"
                value="$objFuncionario->foto"
                class="imageManager"
            >
            <input
                id="btnFile"
                name="btnFile"
                type="button"
                class="imageManager"
                value="Procurar"
                imageManager="true"
                imageManager-tipo="funcionario"
                imageManager-dir="$dir"
            >
        </div>
        $academico$administrativo
    <div class="clear"></div>
    <div class="buttons">
        $btnCancelar
        <input
            id="btnSalvar"
            name="btnSalvar"
            type="submit"
            class="btnForm"
            title="$nameButton"
            value="$nameButton"
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
        <link rel="stylesheet" type="text/css" href="/plugins/imagesManager/imagesManager.css">
        <link rel="stylesheet" type="text/css" href="/plugins/imagesManager/Jcrop/jquery.Jcrop.min.css">
        <title><?php print "$objI->nomeFantasia - Meus Dados"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/jquery.maskedinput.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_perfil-form.js"></script>
        <script src="/plugins/imagesManager/imagesManager.js"></script>
        <script src="/plugins/imagesManager/Jcrop/jquery.Jcrop.min.js"></script>
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
                            <p class="p1"><span>1º</span> Passo</p>
                            <p>Seu cadastro já está quase pronto. Siga apenas estes 2 passos para finalizar seu cadastro.</p>
                        </div>
                        <?php
                    }
                    ?>
                    <article class="boxForm">
                        <h1>Meus Dados</h1>
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