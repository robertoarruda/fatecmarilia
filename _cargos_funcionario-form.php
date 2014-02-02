<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('cargos-funcionario');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objAC = new Administrativo_Cargo();
$objFLogin = new FuncionarioLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (returnPost('departamento', false)) {
        $objCargos = new Cargo();
        foreach ($objCargos->consultarDepartamento(returnPost('departamento_codigo')) as $obj) {
            print "<option value=\"$obj->codigo\">$obj->nome</option>";
        }
        die();
    }
    
    $objAC->administrativos_funcionarios_funcionariosLogin_cpf->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = returnPost('cpf');
    $objAC->cargos_codigo->codigo = returnPost('cargos_codigo');

    $dir = "/$tipoUrl/funcionarios/cargos/" . returnPost('cpf') . "/cargos.html";
    
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
            $res = true;
            $objAdministrativo = new Administrativo();
            $r = $objAdministrativo->consultar(returnPost('cpf'));
            if (!$r) {
                $objAdministrativo->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = returnPost('cpf');
                $res = $objAdministrativo->inserir();
            }
            $objAC->data = date('Y-m-d', time());
            if ($res) {
                if ($objAC->inserir())
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
        case 'excluir':
            if ($objAC->excluir(returnPost('cpf'), returnPost('cargo'))){
                print("
                    <script>
                    $.showMsg({
                        msg: 'Remoção efetuada com sucesso.',
                        titulo: 'Sucesso'
                    }, function(){
                        window.location.reload();
                    });
                    </script>
                ");
            } else
                print($erro);
            break;
    }
    die();
}
if (returnGet('c') != 'novo') {
    $objFLogin = $objFLogin->consultar(returnGet('c'));
    if (!$objFLogin) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}

$objDepartamentos = new Departamento();
$departamento = '<option value="">Selecione...</option>';
foreach ($objDepartamentos->listarTudo() as $obj) {
    $departamento .= "<option value=\"$obj->codigo\">$obj->nome</option>";
}

$str = <<<STR
        <input
            id="cpf"
            name="cpf"
            type="hidden"
            value="$objFLogin->cpf"
        >
        <label for="departamentos_codigo">Departamento</label>
        <select
            id="departamentos_codigo"
            name="departamentos_codigo"
        >$departamento</select>
        <label for="cargos_codigo">Cargo</label>
        <select
            id="cargos_codigo"
            name="cargos_codigo"
            disabled="disabled"
        >
            <option value="">Selecione um departamento</option>
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
            title="Cadastrar"
            value="Cadastrar"
            data-cod="$objFLogin->cpf"
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
        <title><?php print "$objI->nomeFantasia - Cargos por Funcionários"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_cargos_funcionario-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Cargos - Cargos por Funcionários</h1>
                    <article class="boxForm">
                        <h1>Cadastrar Novo Cargo do Funcionário</h1>
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