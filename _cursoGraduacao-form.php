<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('curso');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objCurso = new Curso();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objCurso->codigo = returnPost('codigo');
    $objCurso->tipo = returnPost('tipo');
    $objCurso->nome = returnPost('nome');
    $objCurso->nomeCompleto = returnPost('nomeCompleto');
    $objCurso->imagem = returnPost('imagem');
    $objCurso->perfilProfissiografico = returnPost('perfilProfissiografico');
    $objCurso->estruturaCurricular = returnPost('estruturaCurricular');
    $objCurso->duracao = returnPost('duracao');
    $objCurso->instituicao_codigo->codigo = returnPost('instituicao_codigo');

    $dir = "/$tipoUrl/cursos/graduacao/";
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
            if ($objCurso->inserir())
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
            if ($objCurso->editar($objCurso->codigo))
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
            if ($objCurso->excluir(returnPost('dados'))){
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
    $objCurso = $objCurso->consultar(returnGet('c'));
    if (!$objCurso) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}

$nameButton = ($objCurso->codigo) ? 'Alterar' : 'Cadastrar';
$dir = base64_encode($objCurso->dirImagem);
$objInstituicoes = new Instituicao();
$instituicao = '<option value="">Selecione...</option>';
foreach ($objInstituicoes->listarTudo() as $obj) {
    $selected = ($objCurso->instituicao_codigo->codigo == $obj->codigo) ? ' selected=\"selected\"' : '';
    $instituicao .= "<option value=\"$obj->codigo\"$selected>$obj->nomeFantasia</option>";
}

$ep = ($objCurso->tipo == '1') ? ' selected="selected"' : '';
$ead = ($objCurso->tipo == '2') ? ' selected="selected"' : '';

$str = <<<STR
        <input
            id="codigo"
            name="codigo"
            type="hidden"
            value="$objCurso->codigo"
        >
        <label for="tipo">Tipo</label>
        <select
            id="tipo"
            name="tipo"
        >
            <option value="">Selecione...</option>
            <option value="1"$ep>Ensino Presencial</option>
            <option value="2"$ead>Ensino a Distância</option>
        </select>
        <label for="nome">Nome</label>
        <input
            id="nome"
            name="nome"
            type="text"
            value="$objCurso->nome"
            maxlength="$objCurso->limite_nome"
        >
        <label for="nomeCompleto">Nome Completo</label>
        <input
            id="nomeCompleto"
            name="nomeCompleto"
            type="text"
            value="$objCurso->nomeCompleto"
            maxlength="$objCurso->limite_nomeCompleto"
        >
        <label for="imagem">Imagem</label>
        <div class="imageManager">
            <input
                id="imagem"
                name="imagem"
                type="text"
                readonly="readonly"
                value="$objCurso->imagem"
                class="imageManager"
            >
            <input
                id="btnFile"
                name="btnFile"
                type="button"
                class="imageManager"
                value="Procurar"
                imageManager="true"
                imageManager-tipo="curso"
                imageManager-dir="$dir"
            >
        </div>
        <label for="perfilProfissiografico">Perfil Profissiográfico</label>
        <textarea id="perfilProfissiografico" name="perfilProfissiografico">$objCurso->perfilProfissiografico</textarea>
        <label for="estruturaCurricular">Estrutura Curricular</label>
        <textarea id="estruturaCurricular" name="estruturaCurricular">$objCurso->estruturaCurricular</textarea>
        <label for="duracao">Duração</label>
        <input
            id="duracao"
            name="duracao"
            type="text"
            value="$objCurso->duracao"
            maxlength="$objCurso->limite_duracao"
        >
        <label for="instituicao_codigo">Instituição</label>
        <select
            id="instituicao_codigo"
            name="instituicao_codigo"
        >$instituicao</select>
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
            data-cod="$objCurso->codigo"
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
        <title><?php print "$objI->nomeFantasia - Curso"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_cursoGraduacao-form.js"></script>
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
                    <h1>Curso - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Curso de Graduação</h1>
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