<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('revista');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objRevista = new Revista();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objRevista->codigo = returnPost('codigo');
    $objRevista->descricao = returnPost('descricao');
    $objRevista->equipeEditorial = returnPost('equipeEditorial');
    $objRevista->comiteCientifico = returnPost('comiteCientifico');
    $objRevista->equipeDiagramacaoWebDesigner = returnPost('equipeDiagramacaoWebDesigner');
    
    $dir = "/$tipoUrl/revista/";

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
            if ($objRevista->editar($objRevista->codigo))
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

if ($objRevista->qtdRegistros())
    $objRevista = $objRevista->consultar(1);

$nameButton = ($objRevista->codigo) ? 'Alterar' : 'Salvar';
$dir = base64_encode($objRevista->dirImagem);
$str = <<<STR
        <input
            id="codigo"
            name="codigo"
            type="hidden"
            value="$objRevista->codigo"
        >
        <input id="file_upload" name="file_upload" type="file" multiple="multiple">
        <a id="uploadify-cancelAll" href="javascript:$('#file_upload').uploadify('cancel', '*')" class="uploadify-button">Cancelar Todos</a>
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao">$objRevista->descricao</textarea>
        <label for="equipeEditorial">Equipe Editorial</label>
        <textarea id="equipeEditorial" name="equipeEditorial">$objRevista->equipeEditorial</textarea>
        <label for="comiteCientifico">Comite Científico (Revisores / Consultores)</label>
        <textarea id="comiteCientifico" name="comiteCientifico">$objRevista->comiteCientifico</textarea>
        <label for="equipeDiagramacaoWebDesigner">Equipe de Diagramação e Web Designer</label>
        <textarea id="equipeDiagramacaoWebDesigner" name="equipeDiagramacaoWebDesigner">$objRevista->equipeDiagramacaoWebDesigner</textarea>
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
            data-cod="$objRevista->codigo"
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
        <link rel="stylesheet" type="text/css" href="/plugins/uploadify/uploadify.css">
        <title><?php print "$objI->nomeFantasia - Revista Alimentus"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_revista-form.js"></script>
        <script type="text/javascript" src="/plugins/uploadify/jquery.uploadify.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#uploadify-cancelAll').hide();
                var tipos = '*.pdf';
                $('#file_upload').uploadify({
                    swf: '/plugins/uploadify/uploadify.swf',
                    uploader: '/plugins/uploadify/uploadify.php',
                    formData: {
                        folder: '/<?php print "$objRevista->dirArquivo"; ?>/',
                        fixName: 'normas',
                        tipos: tipos.replace(/\*./g, '')
                    },
                    onQueueComplete: function(queueData) {
                        $('#uploadify-cancelAll').hide();
                    },
                    onUploadSuccess: function(file, data, response) {
                        if (data)
                            alert(data);
                    },
                    onUploadStart: function(file) {
                        $('#uploadify-cancelAll').fadeIn();
                    },
                    multi: true,
                    buttonText: 'Adicionar Normas',
                    width: 280,
                    height: 55,
                    fileTypeDesc: 'Image Files',
                    fileTypeExts: tipos
                });
            });
        </script>
    </head>
    <body data-tipo="<?php print $tipoUrl; ?>">
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Revista Alimentus - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro</h1>
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