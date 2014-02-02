<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('permissao-administrativo');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objCargo = new Cargo();
$objNiveisDeAcesso = new NivelDeAcesso();
$objCargo_NiveisDeAcesso = new Cargo_NivelDeAcesso();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objCargo_NiveisDeAcesso->cargos_codigo->codigo = returnPost('cargos_codigo');
    $objCargo_NiveisDeAcesso->funcionarioLogin_cpf->cpf = returnPost('funcionariosLogin_cpf');

    $dir = "/$tipoUrl/permissoes/administrativo/";

    foreach ($objNiveisDeAcesso->listarTudo() as $obj) {
        if (returnPost($obj->codigo, 0)) {
            $objCargo_NiveisDeAcesso->niveisdeacesso_codigo->codigo = $obj->codigo;
            if (!$objCargo_NiveisDeAcesso->consultar($objCargo_NiveisDeAcesso->cargos_codigo->codigo, $obj->codigo))
                $objCargo_NiveisDeAcesso->inserir();
        } else
            $objCargo_NiveisDeAcesso->excluir($objCargo_NiveisDeAcesso->cargos_codigo->codigo, $obj->codigo);
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
if (returnGet('c') != 'novo') {
    $objCargo = $objCargo->consultar(returnGet('c'));
    if (!$objCargo) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}
$cpf = $objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;

$niveis = '';
foreach ($objNiveisDeAcesso->listarTudo() as $obj) {
    if ($objCargo_NiveisDeAcesso->consultar($objCargo->codigo, $obj->codigo)) {
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
        <input
            id="cargos_codigo"
            name="cargos_codigo"
            type="hidden"
            value="$objCargo->codigo"
        >
        <label for=\"cargos_nome\">Cargo</label>
        <input
            id="cargos_nome"
            name="cargos_nome"
            type="text"
            readonly="readonly"
            value="$objCargo->nome"
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
        <script src="/js/scripts/_permissaoAdministrativo-form.js"></script>
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
                        <h1>Cadastro de Permissões por Cargos</h1>
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