<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('permissao-academico');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objNiveisDeAcesso = new NivelDeAcesso();
$objAcademico_NiveisDeAcesso = new Academico_NivelDeAcesso();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objAcademico_NiveisDeAcesso->funcionarioLogin_cpf->cpf = returnPost('funcionariosLogin_cpf');
    $dir = "/$tipoUrl/";

    foreach ($objNiveisDeAcesso->listarTudo() as $obj) {
        if (returnPost($obj->codigo, 0)) {
            $objAcademico_NiveisDeAcesso->niveisdeacesso_codigo->codigo = $obj->codigo;
            if (!$objAcademico_NiveisDeAcesso->consultar($obj->codigo))
                $objAcademico_NiveisDeAcesso->inserir();
        } else
            $objAcademico_NiveisDeAcesso->excluir($obj->codigo);
    }
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
    die();
}
$cpf = $objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;

$niveis = '';
foreach ($objNiveisDeAcesso->listarTudo() as $obj) {
    if ($objAcademico_NiveisDeAcesso->consultar($obj->codigo)) {
        $sAtivo = " selected=\"selected\"";
        $sDesativo = "";
    } else {
        $sAtivo = "";
        $sDesativo = " selected=\"selected\"";
    }
    $niveis .= "<label>" . ucfirst(strtolower($obj->tipo)) . "</label>
        <select
            id=\"$obj->codigo\"
            name=\"$obj->codigo\"
        >
            <option value=\"1\"$sAtivo>Habilitado</option>
            <option value=\"\"$sDesativo>Desabilitado</option>
        </select>";
}

$str = <<<STR
        <input
            id="funcionariosLogin_cpf"
            name="funcionariosLogin_cpf"
            type="hidden"
            value="$cpf"
        >
        <fieldset><legend>Níveis de Acesso</legend>$niveis</fieldset>
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
            title="Cadastrar"
            value="Cadastrar"
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
        <title><?php print "$objI->nomeFantasia - Meus Dados"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_permissaoAcademico-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Permissões - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Permissões para Academicos</h1>
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