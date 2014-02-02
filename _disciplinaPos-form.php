<?php
require_once('ie.php');
require_once('config/loadConfig.php');


$objFL = new FuncionarioLogin();
$objFL->checaLogin('disciplina');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objDisciplina = new DisciplinaPos();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objDisciplina->codigo = returnPost('codigo');
    $objDisciplina->nome = returnPost('nome');
    $objDisciplina->cargaHoraria = returnPost('cargaHoraria');
    $objDisciplina->cursospos_codigo->codigo = returnPost('cursospos_codigo');
    
    $dir = "/$tipoUrl/disciplinas/pos-graduacao/";
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
            if ($objDisciplina->inserir())
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
            if ($objDisciplina->editar($objDisciplina->codigo))
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
            if ($objDisciplina->excluir(returnPost('dados'))){
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
    $objDisciplina = $objDisciplina->consultar(returnGet('c'));
    if (!$objDisciplina) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}

$nameButton = ($objDisciplina->codigo) ? 'Alterar' : 'Cadastrar';
$objCursos = new CursoPos();
$curso = '<option value="">Selecione...</option>';
foreach ($objCursos->listarTudo() as $obj) {
    $selected = ($objDisciplina->cursospos_codigo->codigo == $obj->codigo) ? ' selected=\"selected\"' : '';
    $curso .= "<option value=\"$obj->codigo\"$selected>$obj->nome</option>";
}

$str = <<<STR
        <input
            id="codigo"
            name="codigo"
            type="hidden"
            value="$objDisciplina->codigo"
        >
        <label for="nome">Nome</label>
        <input
            id="nome"
            name="nome"
            type="text"
            value="$objDisciplina->nome"
            maxlength="$objDisciplina->limite_nome"
        >
        <label for="cargaHoraria">Carga Horária (horas)</label>
        <input
            id="cargaHoraria"
            name="cargaHoraria"
            type="number"
            value="$objDisciplina->cargaHoraria"
        >
        <label for="cursospos_codigo">Curso</label>
        <select
            id="cursospos_codigo"
            name="cursospos_codigo"
        >$curso</select>
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
            data-cod="$objDisciplina->codigo"
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
        <title><?php print "$objI->nomeFantasia - Disciplina"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_disciplinaPos-form.js"></script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Disciplina - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Disciplina de Cursos de Pós-graduação</h1>
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