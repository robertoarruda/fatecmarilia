<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objInstituicao = new Instituicao();
if ($objInstituicao->qtdRegistros()) {
    $objInstituicao = $objInstituicao->consultar(1);
} else {   
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
    _funcoes::error404($url);
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <!-- Facebook Open Graph -->
        <meta property="og:url" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" >
        <meta property="og:site_name" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nomeFantasia); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nomeFantasia); ?>">
        <meta property="og:image" content="<?php print "http://" . $_SERVER['SERVER_NAME'] . "/$objI->dirImagem$objI->imagem"; ?>">
        <meta property="og:description" content="<?php print iconv("UTF-8", "ISO-8859-1", $objI->nome); ?>">
        <meta property="fb:admins" content="100002559673601">
        <!-- Facebook Open Graph -->
        <link rel="shortcut icon" href="/imagens/layout/estrutura/png/favicon.png" type="image/ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/imagens/layout/estrutura/png/favicon-57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagens/layout/estrutura/png/favicon-72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagens/layout/estrutura/png/favicon-114.png">
        <link rel="stylesheet" type="text/css" href="/css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="/css/instituicao.css">
        <title><?php print "$objI->nomeFantasia - Instituição"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/scripts/instituicao.js"></script>
    </head>
    <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <figure>
                        <?php
                        $imgInfo = getimagesize("$objInstituicao->dirImagem$objInstituicao->imagem");
                        $imgW = $imgInfo[0];
                        $imgH = $imgInfo[1];
                        printf('
				<img src="/%s" data-src="%s" data-width="%s" data-height="%s" class="imageInstituicao">
				', $objInstituicao->dirImagem . '400x300/' . $objInstituicao->imagem, "$objInstituicao->dirImagem$objInstituicao->imagem", $imgW, $imgH
                        );
                        ?>
                    </figure>
                    <h1><?php print "A $objInstituicao->nomeFantasia"; ?></h1>
                    <section>
                        <p><?php print nl2br($objInstituicao->descricao); ?></p>
                    </section>
                    <h1>Corpo Administrativo</h1>
                    <section>
                        <ul class="corpo">
                            <?php
                            $objAdministrativo = new Administrativo();
                            if ($objAdministrativo->qtdRegistros() > 0) {
                                $objDepartamentos = new Departamento();
                                foreach ($objDepartamentos->listarTudoNOculto() as $objD) {
                                    $objCargos = new Cargo();
                                    $objCg = $objCargos->consultarDepartamento($objD->codigo);
                                    if ($objCg) {
                                        print "<li><h2>$objD->nome</h2></li>";
                                        foreach ($objCg as $objC) {
                                            $objAdministrativo_Cargos = new Administrativo_Cargo();
                                            $objAC = $objAdministrativo_Cargos->consultarCargos($objC->codigo);
                                            if ($objAC) {
                                                foreach ($objAC as $objA) {
                                                    $objFuncionario = new Funcionario();
                                                    $objF = $objFuncionario->consultarAtivos($objA->administrativos_funcionarios_funcionariosLogin_cpf->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf);
                                                    if ($objF) {
                                                        $foto = $objF->dirFoto . $objF->funcionariosLogin_cpf->cpf . "/150x150/$objF->foto";
                                                        $foto = (is_file($foto) ? $foto : 'imagens/layout/estrutura/png/funcionario.png');
                                                        print "
                                                            <ul>
                                                                <li>
                                                                    <img src=\"/$foto\">
                                                                    $objF->nome - $objC->nome
                                                                </li>
                                                            </ul>
                                                        ";
                                                    }
                                                }
                                            } else
                                                print '<ul><li>Nenhum registro encontrado</li></ul>';
                                        }
                                    }
                                }
                            } else
                                print '<li>Nenhum registro encontrado</li>';
                            ?>
                        </ul>
                    </section>
                    <h1>Corpo Docente</h1>
                    <section>
                        <ul class="corpo">
                            <?php
                            $objAcademico = new Academico();
                            if ($objAcademico->qtdRegistros() > 0) {
                                $objFuncionario = new Funcionario();
                                foreach ($objAcademico->listarTudo() as $objA) {
                                    $objF = $objFuncionario->consultarAtivos($objA->funcionarios_funcionariosLogin_cpf->funcionariosLogin_cpf->cpf);
                                    if ($objF) {
                                        $foto = $objF->dirFoto . $objF->funcionariosLogin_cpf->cpf . "/150x150/$objF->foto";
                                        $foto = (is_file($foto) ? $foto : 'imagens/layout/estrutura/png/professor.png');
                                        $sexo = ($objF->sexo == 'M') ? "" : "ª";
                                        switch ($objA->titulacao) {
                                           case 'D':
                                               $titulacao = " Dr$sexo.";
                                               break;
                                           case 'M':
                                               $titulacao = ' Ms.';
                                               break;
                                           case 'E':
                                               $titulacao = ' Espec.';
                                               break;
                                           case 'G':
                                               $titulacao = ' Grad.';
                                               break;
                                           default :
                                               $titulacao = '';
                                               break;
                                        }
                                        $lattes = ($objA->urlLattes) ? $objA->urlLattes : '';
                                        $a[1] = ($objA->urlLattes) ? "<a href=\"$lattes\">" : '';
                                        $a[2] = ($objA->urlLattes) ? "</a>" : '';
                                        $prefixo = "Prof$sexo.$titulacao";
                                        print "
                                            <ul>
                                                <li>
                                                    $a[1]
                                                    <img src=\"/$foto\">
                                                    $prefixo $objF->nome - Docente
                                                    $a[2]
                                                </li>
                                            </ul>
                                        ";
                                    }
                                }
                            } else
                                print '<li>Nenhum registro encontrado</li>';
                            ?>
                        </ul>
                    </section>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>