<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('departamento');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objDepartamento = new Departamento();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objDepartamento->codigo = returnPost('codigo');
    $objDepartamento->nome = returnPost('nome');
    $objDepartamento->mural = returnPost('mural');
    $objDepartamento->oculto = returnPost('oculto');
    $objDepartamento->instituicao_codigo->codigo = returnPost('instituicao_codigo');

    $dir = "/$tipoUrl/departamentos/";
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
            if ($objDepartamento->inserir())
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
            break;
        case 'alterar':
            if ($objDepartamento->editar($objDepartamento->codigo))
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
        case 'excluir':
            if ($objDepartamento->excluir(returnPost('dados'))) {
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
            }else
                print($erro);
            break;
    }
    die();
}
if (returnGet('c') != 'novo') {
    $objDepartamento = $objDepartamento->consultar(returnGet('c'));
    if (!$objDepartamento) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}

$nameButton = ($objDepartamento->codigo) ? 'Alterar' : 'Cadastrar';
$objInstituicoes = new Instituicao();
$instituicao = '<option value="">Selecione...</option>';
foreach ($objInstituicoes->listarTudo() as $obj) {
    $selected = ($objDepartamento->instituicao_codigo->codigo == $obj->codigo) ? ' selected=\"selected\"' : '';
    $instituicao .= "<option value=\"$obj->codigo\"$selected>$obj->nomeFantasia</option>";
}
if ($objDepartamento->mural) {
    $a[0] = '';
    $a[1] = ' selected';
} else {
    $a[0] = ' selected';
    $a[1] = '';
}
if ($objDepartamento->oculto) {
    $o[0] = '';
    $o[1] = ' selected';
} else {
    $o[0] = ' selected';
    $o[1] = '';
}
$str = <<<STR
        <input
            id="codigo"
            name="codigo"
            type="hidden"
            value="$objDepartamento->codigo"
        >
        <label for="nome">Nome</label>
        <input
            id="nome"
            name="nome"
            type="text"
            value="$objDepartamento->nome"
            maxlength="$objDepartamento->limite_nome"
        >
        <label for="instituicao_codigo">Instituição</label>
        <select
            id="instituicao_codigo"
            name="instituicao_codigo"
        >$instituicao</select>
        <label for="mural">Ativar Mural</label>
        <select
            id="mural"
            name="mural"
        >
            <option value="">Selecione...</option>
            <option value="0"$a[0]>Desabilitado</option>
            <option value="1"$a[1]>Habilitado</option>
        </select>
        <label for="oculto">Oculto</label>
        <select
            id="oculto"
            name="oculto"
        >
            <option value="">Selecione...</option>
            <option value="0"$o[0]>Desabilitado</option>
            <option value="1"$o[1]>Habilitado</option>
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
            data-cod="$objDepartamento->codigo"
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
        <title><?php print "$objI->nomeFantasia - Departamento"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_departamento-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Departamento - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Departamento</h1>
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