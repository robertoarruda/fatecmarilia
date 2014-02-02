<?php
require_once('ie.php');
require_once('config/loadConfig.php');

$objAL = new AlunoLogin();
$objAL->checaLogin();

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
        <link rel="stylesheet" type="text/css" href="/css/__main.css">
        <title><?php print "$objI->nomeFantasia - Área do Aluno"; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
    </head>
   <body>
        <div id="all">
            <header>
                <?php require_once('header.php'); ?>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <h1>Área do Aluno</h1>
                    <ul id="boxButtons">
                        <li><a href="http://www.projetocps.pro.br/aluno" target="_blank">SIGA</a></li>
                        <li><a href="/aluno/downloads.html">Downloads</a></li>
                        <li><a href="/aluno/fale-conosco.html">Fale Conosco</a></li>
                        <li><a href="/aluno/contrate/perfil.html">Programa Contrate um Tecnólogo</a></li>
                        <li><a href="/aluno/acesso-wifi/cadastro.html">Acesso a Rede Wi-Fi da Fatec</a></li>
                    </ul>
                    <div class="clear"></div>
                    <h1>Meus Dados</h1>
                    <ul id="boxButtons">
                        <li><a href="/aluno/perfil/cadastro.html">Meus Dados</a></li>
                        <li><a href="/aluno/perfil/senha.html">Alterar Senha</a></li>
                    </ul>
                </div>
            </article>
            <div class="clear"></div>
        </div>
        <footer>
            <?php require_once('footer.php'); ?>
        </footer>
    </body>
</html>