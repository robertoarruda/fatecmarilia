<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objFL->checaLogin('noticia');

$tipo = $objFL->retornaFuncionarioSessao()->tipo;
$tipoUrl = $objFL->retornaFuncionarioSessao()->tipoUrl;

$objNoticia = new Noticia();
$objDestaque = new Destaque();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $objNoticia->codigo = returnPost('codigo');
    $objNoticia->data = returnPost('data');
    $objNoticia->prioridade = returnPost('prioridade');
    $objNoticia->titulo = returnPost('titulo');
    $objNoticia->urlTitulo = _funcoes::urlString(strtolower($objNoticia->titulo));
    $objNoticia->resumo = returnPost('resumo');
    $objNoticia->imagem = returnPost('imagem');
    $objNoticia->conteudo = returnPost('conteudo');
    $objNoticia->linkTitulo = returnPost('linkTitulo');
    $objNoticia->linkUrl = ($objNoticia->linkTitulo) ? returnPost('linkUrl') : '';
    $objNoticia->linkTarget = ($objNoticia->linkTitulo) ? returnPost('linkTarget') : '';
    $objNoticia->status = 'P';
    $objNoticia->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = returnPost('funcionarios_funcionariosLogin_cpf');
    
    if (!$objNoticia->data)
        $objNoticia->data = date('Y-m-d H:i:s', time());

    $dia = date('d', strtotime($objNoticia->data));
    $mes = date('m', strtotime($objNoticia->data));
    $ano = date('Y', strtotime($objNoticia->data));
                            
    $objDestaque->codigo = returnPost('codigo');
    $objDestaque->data = $objNoticia->data;
    $objDestaque->prioridade = returnPost('prioridade');
    $objDestaque->titulo = returnPost('titulo');
    $objDestaque->resumo = returnPost('resumo');
    $objDestaque->imagem = returnPost('imagem');
    $objDestaque->linkUrl = "http://" . $_SERVER['SERVER_NAME'] . "/noticias/$ano/$mes/$dia/$objNoticia->urlTitulo.html";
    $objDestaque->status = 'P';
    $objDestaque->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf = returnPost('funcionarios_funcionariosLogin_cpf');

    $dir = "/$tipoUrl/noticias/";
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
            $objNoticia->codigo = _funcoes::gerarCodAleatorio(3, 0, 4) . time();
            $objDestaque->codigo = $objNoticia->codigo;
            $objDestaque->posicaoTitulo = 'LT';
            $objDestaque->linkTarget = '';
            if ($objNoticia->inserir()) {
                if ($objDestaque->inserir())
                    print("
                    <script>
                    $.showMsg({
                        msg: 'Cadastro efetuado com sucesso, aguarde a liberação.<br>Deseja cadastrar um álbum de fotos para esta notícia?',
                        tipo: 'confirm'
                    }, function(r){
                        if (r)
                            window.location = '/$tipoUrl/noticias/$objNoticia->codigo/album.html';
                        else
                            window.location = '$dir';
                    });
                    </script>
                ");
                else
                    print($erro);
            } else
                print($erro);
            break;
        case 'alterar':
            $objNoticia->dataAlteracao = date('Y-m-d H:i:s', time());
            $objNoticia->cpfAlteracao = returnPost('cpf');
            $destaque = $objDestaque->consultar($objDestaque->codigo);
            $res = true;
            if ($destaque) {
                $objDestaque->dataAlteracao = $objNoticia->dataAlteracao;
                $objDestaque->cpfAlteracao = $objNoticia->cpfAlteracao;
                $objDestaque->posicaoTitulo = ($destaque->posicaoTitulo) ? $destaque->posicaoTitulo : 'LT';
                $res = $objDestaque->editar($objDestaque->codigo);
            }
            
            if ($res) {
                if ($objNoticia->editar($objNoticia->codigo))
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
            } else
                print($erro);
            break;
        case 'ativar':
            print returnPost('dados');
            $destaque = $objDestaque->consultar(returnPost('dados'));
            $res = true;
            if ($destaque) 
                $res = $objDestaque->ativar(returnPost('dados'));
            
            if ($res) {
                if ($objNoticia->ativar(returnPost('dados'))) {
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
            $destaque = $objDestaque->consultar(returnPost('dados'));
            $res = true;
            if ($destaque) 
                $res = $objDestaque->desativar(returnPost('dados'));
            
            if ($res) {
                if ($objNoticia->desativar(returnPost('dados'))) {
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
        case 'excluir':
            $destaque = $objDestaque->consultar(returnPost('dados'));
            $res = true;
            if ($destaque) 
                $res = $objDestaque->excluir(returnPost('dados'));
            
            if ($res) {
                if ($objNoticia->excluir(returnPost('dados'))) {
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
            } else
                print($erro);
            break;
    }
    die();
}
if (returnGet('c') != 'novo') {
    $objNoticia = $objNoticia->consultar(returnGet('c'));
    if (!$objNoticia) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        _funcoes::error404($url);
    }
}

$nameButton = ($objNoticia->codigo) ? 'Alterar' : 'Cadastrar';
$dir = base64_encode($objNoticia->dirImagem);
if ($objNoticia->linkTarget) {
    $a[0] = '';
    $a[1] = ' selected';
} else {
    $a[0] = ' selected';
    $a[1] = '';
}

$prioridade0 = ($objFL->checaPermissao('administrar-noticia')) ? '<option value="0">Altíssima</option>' : '';

$prioridade0 = ($objNoticia->prioridade == '0') ? '<option value="0" selected>Altíssima</option>' : $prioridade0;
$prioridade1 = ($objNoticia->prioridade == '1') ? ' selected' : '';
$prioridade2 = ($objNoticia->prioridade == '2') ? ' selected' : '';
$prioridade3 = ($objNoticia->prioridade == '3') ? ' selected' : '';

$cpf = $objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;

if ($objNoticia->codigo) {
    $funcionario = $objNoticia->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf;
} else {
    $funcionario = $objFL->retornaFuncionarioSessao()->funcionariosLogin_cpf->cpf;
}


$str = <<<STR
        <input
            id="codigo"
            name="codigo"
            type="hidden"
            value="$objNoticia->codigo"
        >
        <input
            id="data"
            name="data"
            type="hidden"
            value="$objNoticia->data"
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
            value="$objNoticia->titulo"
            maxlength="$objNoticia->limite_titulo"
        >
        <label for="resumo">Resumo</label>
        <input
            id="resumo"
            name="resumo"
            type="text"
            value="$objNoticia->resumo"
            maxlength="$objNoticia->limite_resumo"
        >
        <label for="imagem">Imagem</label>
        <div class="imageManager">
            <input
                id="imagem"
                name="imagem"
                type="text"
                readonly="readonly"
                value="$objNoticia->imagem"
                class="imageManager"
            >
            <input
                id="btnFile"
                name="btnFile"
                type="button"
                class="imageManager"
                value="Procurar"
                imageManager="true"
                imageManager-tipo="noticia"
                imageManager-dir="$dir"
            >
        </div>
        <label for="conteudo">Conteúdo</label>
        <textarea id="conteudo" name="conteudo">$objNoticia->conteudo</textarea>
        <label for="linkTitulo">Link (Título)</label>
        <input
            id="linkTitulo"
            name="linkTitulo"
            type="text"
            value="$objNoticia->linkTitulo"
            maxlength="$objNoticia->limite_linkTitulo"
        >
        <label for="linkUrl">Link (URL)</label>
        <input
            id="linkUrl"
            name="linkUrl"
            type="url"
            placeholder="http://www.site.com.br"
            value="$objNoticia->linkUrl"
            maxlength="$objNoticia->limite_linkUrl"
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
            data-cod="$objNoticia->codigo"
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
        <title><?php print "$objI->nomeFantasia - Notícia"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="/js/plugins/jquery.showMsg.js"></script>
        <script src="/js/jquery.lazyload.js"></script>
        <script src="/js/scripts/_noticia-form.js"></script>
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
                    <h1>Notícia - Área do <?php print $tipo; ?></h1>
                    <article class="boxForm">
                        <h1>Cadastro de Notícia</h1>
                        <?php if ($objNoticia->codigo) { ?>
                            <a class="album" data-url="<?php print "/$tipoUrl/noticias/$objNoticia->codigo/album.html"; ?>">
                                <?php print (is_dir("$objNoticia->dirImagemAlbum$objNoticia->codigo")) ? "Editar Álbum" : "Criar Álbum"; ?>
                            </a>
                        <?php } ?>
                        <div class="clear"></div>
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