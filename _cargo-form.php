<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('cargo');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objCargo = new Cargo();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objCargo->codigo = returnPost('codigo');
    $objCargo->nome = returnPost('nome');
    $objCargo->departamentos_codigo->codigo = returnPost('departamentos_codigo');
    
    $dir = "/$tipoUrl/cargos/";
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
            if ($objCargo->inserir())
                print("
                    <script>
                    $.showMsg({
                        msg: 'Cadastro efetuado com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                        window.location = '/$tipoUrl/permissoes/administrativo/" . $objCargo->consultarNomeDepartamento(returnPost('nome'), returnPost('departamentos_codigo'))->codigo . "/cadastro.html';
                    });
                    </script>
                ");
            else
                print($erro);
            break;
        case 'alterar':
            if ($objCargo->editar($objCargo->codigo))
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
            if ($objCargo->excluir(returnPost('dados'))){
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
    $objCargo = $objCargo->consultar(returnGet('c'));
    if (!$objCargo) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}

$nameButton = ($objCargo->codigo) ? 'Alterar' : 'Cadastrar';
$objDepartamentos = new Departamento();
$departamento = '<option value="">Selecione...</option>';
foreach ($objDepartamentos->listarTudo() as $obj) {
    $selected = ($objCargo->departamentos_codigo->codigo == $obj->codigo) ? ' selected=\"selected\"' : '';
    $departamento .= "<option value=\"$obj->codigo\"$selected>$obj->nome</option>";
}
$str = <<<STR
        <input
            id="codigo"
            name="codigo"
            type="hidden"
            value="$objCargo->codigo"
        >
        <label for="nome">Nome</label>
        <input
            id="nome"
            name="nome"
            type="text"
            value="$objCargo->nome"
            maxlength="$objCargo->limite_nome"
        >
        <label for="departamentos_codigo">Departamento</label>
        <select
            id="departamentos_codigo"
            name="departamentos_codigo"
        >$departamento</select>
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
            data-cod="$objCargo->codigo"
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
        <title><?php print "$objI->nomeFantasia - Cargo"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_cargo-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Cargo - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Cargo</h1>
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