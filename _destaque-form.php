<?php
require_once('ie.php');
require_once('config/loadConfig.php');


$objFL = new FuncionarioLogin();
$objFL->checaLogin('destaque');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objDestaque = new Destaque();
$objNoticia = new Noticia();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objDestaque->codigo = returnPost('codigo');
    $objDestaque->data = returnPost('data');
    $objDestaque->prioridade = returnPost('prioridade');
    $objDestaque->titulo = returnPost('titulo');
    $objDestaque->resumo = returnPost('resumo');
    $objDestaque->imagem = returnPost('imagem');
    $objDestaque->posicaoTitulo = ($objDestaque->titulo) ? returnPost('posicaoTitulo') : '';
    $objDestaque->linkUrl = returnPost('linkUrl');
    $objDestaque->linkTarget = ($objDestaque->linkUrl) ? returnPost('linkTarget') : '';
    $objDestaque->status = 'P';
    $objDestaque->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = returnPost('funcionarios_funcionariosLogin_cpf');

    $dir = "/$tipoUrl/destaques/";
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
            $objDestaque->codigo = _funcoes::gerarCodAleatorio(3, 0, 4) . time();
            $objDestaque->data = date('Y-m-d H:i:s', time());
            if ($objDestaque->inserir())
                print("
                    <script>
                    $.showMsg({
                        msg: 'Cadastro efetuado com sucesso, aguarde a liberação.',
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
            $objDestaque->dataAlteracao = date('Y-m-d H:i:s', time());
            $objDestaque->cpfAlteracao = returnPost('cpf');
            if ($objDestaque->editar($objDestaque->codigo))
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
            if ($objDestaque->excluir(returnPost('dados'))) {
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
            } else
                print($erro);
            break;
        case 'ativar':
            print returnPost('dados');
            $noticia = $objNoticia->consultar(returnPost('dados'));
            $res = true;
            if ($noticia) 
                $res = $objNoticia->ativar(returnPost('dados'));
            
            if ($res) {
                if ($objDestaque->ativar(returnPost('dados'))) {
                    print("
                        <script>
                        $.showMsg({
                            msg: 'Ativação efetuada com sucesso.',
                            titulo: 'Sucesso'
                        }, function(){
                            window.location = '$dir';
                        });
                        </script>
                    ");
                } else
                    print($erro);
            } else
                print($erro);
            break;
        case 'desativar':
            $noticia = $objNoticia->consultar(returnPost('dados'));
            $res = true;
            if ($noticia) 
                $res = $objNoticia->desativar(returnPost('dados'));
            
            if ($res) {
                if ($objDestaque->desativar(returnPost('dados'))) {
                    print("
                        <script>
                        $.showMsg({
                            msg: 'Desativação efetuada com sucesso.',
                            titulo: 'Sucesso'
                        }, function(){
                            window.location = '$dir';
                        });
                        </script>
                    ");
                } else
                    print($erro);
            } else
                print($erro);
            break;
    }
    die();
}
if (returnGet('c') != 'novo') {
    $objDestaque = $objDestaque->consultar(returnGet('c'));
    if (!$objDestaque) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}

$nameButton = ($objDestaque->codigo) ? 'Alterar' : 'Cadastrar';
$dir = base64_encode($objDestaque->dirImagem);
$LT = (($objDestaque->posicaoTitulo == 'LT') || (!$objDestaque->posicaoTitulo)) ? ' checked' : '';
$RT = ($objDestaque->posicaoTitulo == 'RT') ? ' checked' : '';
$LB = ($objDestaque->posicaoTitulo == 'LB') ? ' checked' : '';
$RB = ($objDestaque->posicaoTitulo == 'RB') ? ' checked' : '';
if ($objDestaque->linkTarget) {
    $a[0] = '';
    $a[1] = ' selected';
} else {
    $a[0] = ' selected';
    $a[1] = '';
}

$prioridade0 = ($objFL->checaPermissao('administrar-destaque')) ? '<option value="0">Altíssima</option>' : '';

$prioridade0 = ($objDestaque->prioridade == '0') ? '<option value="0" selected>Altíssima</option>' : $prioridade0;
$prioridade1 = ($objDestaque->prioridade == '1') ? ' selected' : '';
$prioridade2 = ($objDestaque->prioridade == '2') ? ' selected' : '';
$prioridade3 = ($objDestaque->prioridade == '3') ? ' selected' : '';

$cpf = $objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;

if ($objDestaque->codigo) {
    $funcionario = $objDestaque->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf;
} else {
    $funcionario = $objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;
}


$str = <<<STR
        <input
            id="codigo"
            name="codigo"
            type="hidden"
            value="$objDestaque->codigo"
        >
        <input
            id="data"
            name="data"
            type="hidden"
            value="$objDestaque->data"
        >
        <input
            id="funcionarios_funcionariosLogin_cpf"
            name="funcionarios_funcionariosLogin_cpf"
            type="hidden"
            value="$funcionario"
        >
        <input
            id="cpf"
            name="cpf"
            type="hidden"
            value="$cpf"
        >
        <label for="titulo">Título</label>
        <input
            id="titulo"
            name="titulo"
            type="text"
            value="$objDestaque->titulo"
            maxlength="$objDestaque->limite_titulo"
        >
        <label for="resumo">Resumo</label>
        <input
            id="resumo"
            name="resumo"
            type="text"
            value="$objDestaque->resumo"
            maxlength="$objDestaque->limite_resumo"
        >
        <label for="imagem">Imagem</label>
        <div class="imageManager">
        <input
                id="imagem"
                name="imagem"
                type="text"
                readonly="readonly"
                value="$objDestaque->imagem"
                class="imageManager"
            >
            <input
                id="btnFile"
                name="btnFile"
                type="button"
                class="imageManager"
                value="Procurar"
                imageManager="true"
                imageManager-tipo="destaque"
                imageManager-dir="$dir"
            >
        </div>
        <label>Posição do Título</label>
        <table>
            <tr>
                <td>
                    <label for="posicaoTitulo_LT">
                        <input id="posicaoTitulo_LT" name="posicaoTitulo" type="radio" value="LT"$LT>
                        Topo/Esquerda
                    </label>
                </td>
                <td>
                    <label for="posicaoTitulo_RT">
                        <input id="posicaoTitulo_RT" name="posicaoTitulo" type="radio" value="RT"$RT>
                        Topo/Direita
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="posicaoTitulo_LB">
                        <input id="posicaoTitulo_LB" name="posicaoTitulo" type="radio" value="LB"$LB>
                        Base/Esquerda
                    </label>
                </td>
                <td>
                    <label for="posicaoTitulo_RB">
                        <input id="posicaoTitulo_RB" name="posicaoTitulo" type="radio" value="RB"$RB>
                        Base/Direita
                    </label>
                </td>
            </tr>
        </table>
        <label for="linkUrl">Link (URL)</label>
        <input
            id="linkUrl"
            name="linkUrl"
            type="url"
            placeholder="http://www.site.com.br"
            value="$objDestaque->linkUrl"
            maxlength="$objDestaque->limite_linkUrl"
        >
        <label for="linkTarget">Link (Destino)</label>
        <select
            id="linkTarget"
            name="linkTarget"
        >
            <option value="0" $a[0]>Abrir na mesma janela</option>
            <option value="1" $a[1]>Abrir em uma nova janela</option>
        </select>
        <label for="prioridade">Prioridade</label>
        <select
            id="prioridade"
            name="prioridade"
        >
            <option value="2" $prioridade2>Normal</option>
            $prioridade0
            <option value="1" $prioridade1>Alta</option>
            <option value="3" $prioridade3>Baixa</option>
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
            data-cod="$objDestaque->codigo"
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
        <title><?php print "$objI->nomeFantasia - Destaque"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_destaque-form.js"></script>
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
                    <h1>Destaque - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Destaque</h1>
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