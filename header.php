<?php
require_once('config/loadConfig.php');

$objFL = new FuncionarioLogin();
$objF = $objFL->retornaFuncionarioSessao();
?>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-43238549-1', 'fatecmarilia.edu.br');
    ga('send', 'pageview');
</script>
<div id="efeitoDegradeLinear"></div>
<div class="enquadramento1000px">
    <div id="efeitoDegradeRadial"></div>
    <div id="efeitoElipseDegradeRadial"></div>
</div>
<div id="faixaAzul">
    <div class="enquadramento1000px">
        <a href="/" ><img id="logoFatec" src="/imagens/layout/estrutura/png/logoFatec.graphic.png"></a>
        <nav id="menu">
            <ul>
                <li class="drop">
                    <a>INSTITUIÇÃO</a>
                    <ul class="drop">
                        <li><a href="/instituicao/">A Fatec Marília</a></li>
                        <?php
                            $objD123 = new Departamento();
                            if ($objD123->qtdRegistrosMural() > 0) {
                                foreach ($objD123->listarMural() as $obj) {
                                    print "<li><a href=\"/mural/" . _funcoes::urlString(strtolower($obj->nome)) . ".html\">$obj->nome</a></li>";
                                }
                            }
                        ?>
                    </ul>
                </li>
                <li class="drop">
                    <a>CURSOS</a>
                    <ul class="drop">
                    <?php
                        $objC123 = new Curso();
                        if ($objC123->qtdRegistros() > 0) {
                            foreach ($objC123->listarTudo() as $obj) {
                                print "
                                    <li><a href=\"/cursos/graduacao/" . _funcoes::urlString(strtolower($obj->nome)) . ".html\">$obj->nomeCompleto</a></li>
                                ";
                            }
                        }
                        $objC123 = new CursoPos();
                        if ($objC123->qtdRegistros() > 0) {
                            foreach ($objC123->listarTudo() as $obj) {
                                print "
                                    <li><a href=\"/cursos/pos-graduacao/" . _funcoes::urlString(strtolower($obj->nome)) . ".html\">$obj->nomeCompleto</a></li>
                                ";
                            }
                        }
                    ?>
                    </ul>
                </li>
                <li><a href="/fotos/">FOTOS</a></li>
                <li><a href="/noticias/">NOTÍCIAS</a></li>
            </ul>
        </nav>
        <div class="clear"></div>
        <nav id="redesSociais">
            <ul>
                <?php
                if ($objF) {
                    print "
                        <li id=\"logado\">
                            <a><img src=\"/imagens/layout/estrutura/png/$objF->tipoUrl.ico.png\"></a>
                            <div>
                                <h1>$objF->nomeAbreviado</h1>
                                <p>$objF->tipo</p>
                            </div>
                            <a class=\"area\" href=\"/$objF->tipoUrl/\">Área</a>
                            <a class=\"editar\" href=\"/$objF->tipoUrl/perfil/cadastro.html\">Editar</a>
                            <a class=\"logout\" href=\"/logout/\">Sair</a>
                        </li>
                    ";
                } else {
                    printf("
                    <li id=\"nlogado\">
                        <a href=\"/login/\" ><img src=\"/imagens/layout/estrutura/png/login.ico.png\" title=\"Login\"></a>
                    </li>
                    ");
                }
                ?>
                <li><a href="http://www.facebook.com/fatec.marilia" target="_blank"><img src="/imagens/layout/estrutura/png/facebook.ico.png" title="Facebook"></a></li>
                <li><a href="http://www.twitter.com" target="_blank"><img src="/imagens/layout/estrutura/png/twitter.ico.png" title="Twitter"></a></li>
                <li><a href="http://www.youtube.com/fatecmarilia" target="_blank"><img src="/imagens/layout/estrutura/png/youtube.ico.png" title="Youtube"></a></li>
            </ul>
        </nav>
    </div>
</div>
