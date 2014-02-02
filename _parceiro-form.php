<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('revista');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objRevista = new Revista();
$nomeArquivo = $objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;
$nomeArquivoNovo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nomeArquivo = returnPost('nomeArquivo');
    $nomeArquivoExtensao = returnPost('nomeArquivoExtensao');
    $nomeArquivoNovo = base64_encode(returnPost('nomeArquivoNovo'));
    
    $dir = "/$tipoUrl/parceiros/";

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
            if (rename(iconv('utf-8', 'iso-8859-1', "imagens/parceiros/$nomeArquivo$nomeArquivoExtensao"), iconv('utf-8', 'iso-8859-1', "imagens/parceiros/$nomeArquivoNovo$nomeArquivoExtensao")))
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
    }
    die();
}
if (returnGet('c') != 'novo') {
    $nomeArquivo = returnGet('c');
    if (is_file("imagens/parceiros/$nomeArquivo")) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
    $nomeArquivo = base64_decode(urldecode(returnGet('c')));
}
if ($objRevista->qtdRegistros())
    $objRevista = $objRevista->consultar(1);

$dir = base64_encode($objRevista->dirImagem);
$str = <<<STR
        <input
            id="nomeArquivo"
            name="nomeArquivo"
            type="hidden"
            value="$nomeArquivo"
        >
        <input
            id="nomeArquivoExtensao"
            name="nomeArquivoExtensao"
            type="hidden"
            value=""
        >
        <input id="file_upload" name="file_upload" type="file" multiple="multiple">
        <a id="uploadify-cancelAll" href="javascript:$('#file_upload').uploadify('cancel', '*')" class="uploadify-button">Cancelar Todos</a>
        <label for="link">Link (URL)</label>
        <input
            id="nomeArquivoNovo"
            name="nomeArquivoNovo"
            type="url"
            placeholder="http://www.site.com.br"
            value="$nomeArquivoNovo"
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
            type="button"
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
        <link rel="stylesheet" type="text/css" href="/plugins/uploadify/uploadify.css">
        <title><?php print "$objI->nomeFantasia - Revista Alimentus"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/scripts/_parceiro-form.js"></script>
        <script type="text/javascript" src="/plugins/uploadify/jquery.uploadify.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#uploadify-cancelAll').hide();
                var tipos = '*.jpg; *.jpeg; *.png; *.gif';
                $('#file_upload').uploadify({
                    swf: '/plugins/uploadify/uploadify.swf',
                    uploader: '/plugins/uploadify/uploadify.php',
                    formData: {
                        folder: '/imagens/parceiros/',
                        fixName: '<?php print $nomeArquivo; ?>',
                        dimensao: '125x80:preenchetudo',
                        tipos: tipos.replace(/\*./g, '')
                    },
                    onSelect : function(file) {
                        var ext = '.' + file.name.split('.').pop();
                        $('#nomeArquivoExtensao').val(ext);
                    },
                    onQueueComplete: function(queueData) {
                        $('#uploadify-cancelAll').hide();
                        $('form').submit();
                    },
                    onUploadSuccess: function(file, data, response) {
                        if (data)
                            alert(data);
                    },
                    onUploadStart: function(file) {
                        $('#uploadify-cancelAll').fadeIn();
                    },
                    auto: false,
                    multi: false,
                    buttonText: 'Adicionar Imagem',
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