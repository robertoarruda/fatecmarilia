<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('instituicao');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objInstituicao = new Instituicao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objInstituicao->codigo = returnPost('codigo');
    $objInstituicao->nome = returnPost('nome');
    $objInstituicao->nomeFantasia = returnPost('nomeFantasia');
    $objInstituicao->imagem = returnPost('imagem');
    $objInstituicao->descricao = returnPost('descricao');
    $objInstituicao->endereco = returnPost('endereco');
    $objInstituicao->complemento = returnPost('complemento');
    $objInstituicao->cep = returnPost('cep');
    $objInstituicao->cidade = returnPost('cidade');
    $objInstituicao->estado = returnPost('estado');
    $objInstituicao->telefone = returnPost('telefone');
    $objInstituicao->fax = returnPost('fax');
    $objInstituicao->email = returnPost('email');
    $objInstituicao->emailSuporte = returnPost('emailSuporte');

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
        case 'alterar':
            if ($objInstituicao->editar($objInstituicao->codigo))
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
    }
    die();
}

$objInstituicao = $objInstituicao->consultar(1);

$nameButton = ($objInstituicao->codigo) ? 'Alterar' : 'Salvar';
$dir = base64_encode($objInstituicao->dirImagem);
$str = <<<STR
        <input
            id="codigo"
            name="codigo"
            type="hidden"
            value="$objInstituicao->codigo"
        >
        <label for="nome">Nome</label>
        <input
            id="nome"
            name="nome"
            type="text"
            value="$objInstituicao->nome"
            maxlength="$objInstituicao->limite_nome"
        >
        <label for="nomeFantasia">Nome Fantasia</label>
        <input
            id="nomeFantasia"
            name="nomeFantasia"
            type="text"
            value="$objInstituicao->nomeFantasia"
            maxlength="$objInstituicao->limite_nomeFantasia"
        >
        <label for="imagem">Imagem</label>
        <div class="imageManager">
            <input
                id="imagem"
                name="imagem"
                type="text"
                readonly="readonly"
                value="$objInstituicao->imagem"
                class="imageManager"
            >
            <input
                id="btnFile"
                name="btnFile"
                type="button"
                class="imageManager"
                value="Procurar"
                imageManager="true"
                imageManager-tipo="instituicao"
                imageManager-dir="$dir"
            >
        </div>
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao">$objInstituicao->descricao</textarea>
        <label for="endereco">Endereço</label>
        <input
            id="endereco"
            name="endereco"
            type="text"
            value="$objInstituicao->endereco"
            maxlength="$objInstituicao->limite_endereco"
        >
        <label for="complemento">Complemento</label>
        <input
            id="complemento"
            name="complemento"
            type="text"
            value="$objInstituicao->complemento"
            maxlength="$objInstituicao->limite_complemento"
        >
        <label for="endereco">CEP</label>
        <input
            id="cep"
            name="cep"
            type="text"
            placeholder="00000-000"
            value="$objInstituicao->cep"
        >
        <label for="estado">Estado</label>
        <input
            id="estado"
            name="estado"
            type="text"
            value="$objInstituicao->estado"
        >
        <label for="cidade">Cidade</label>
        <input
            id="cidade"
            name="cidade"
            type="text"
            value="$objInstituicao->cidade"
        >
        <label for="telefone">Telefone</label>
        <input
            id="telefone"
            name="telefone"
            type="tel"
            placeholder="(00) 0000-0000"
            value="$objInstituicao->telefone"
        >
        <label for="fax">Fax</label>
        <input
            id="fax"
            name="fax"
            type="tel"
            placeholder="(00) 0000-0000"
            value="$objInstituicao->fax"
        >
        <label for="email">Email</label>
        <input
            id="email"
            name="email"
            type="email"
            value="$objInstituicao->email"
            maxlength="$objInstituicao->limite_email"
        >
        <label for="emailSuporte">Email para Suporte Técnico</label>
        <input
            id="emailSuporte"
            name="emailSuporte"
            type="email"
            value="$objInstituicao->emailSuporte"
            maxlength="$objInstituicao->limite_emailSuporte"
        >
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
            data-cod="$objInstituicao->codigo"
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
        <title><?php print "$objI->nomeFantasia - Instituição"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/jquery.maskedinput.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/jquery.cidades-estados-1.2-utf8.js"></script>
        <script src="/js/scripts/_instituicao-form.js"></script>
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
                    <h1>Instituição - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Instituição</h1>
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