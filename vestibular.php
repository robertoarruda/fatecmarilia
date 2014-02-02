<?php
require_once('ie.php');
require_once('config/loadConfig.php');

session_start();
$data = strtotime('now');
$_SESSION['capa'] = $data;
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
        <link rel="stylesheet" type="text/css" href="/css/vestibular.css">
        <title><?= $objI->nomeFantasia; ?></title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#entrar').hide();
                setInterval(function(){
                    $('#entrar').fadeIn('fast');
                }, 3000); 
            });
        </script>
    </head>
    <body>
        <div id="all">
            <header>
                <div id="efeitoDegradeLinear"></div>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <a id="entrar" href="/">>> Entrar no site</a>
                    <a id="img" href="http://www.vestibularfatec.com.br/" target="_blank"><img src="/imagens/layout/estrutura/jpeg/vestibular.jpg"></a>
                </div>
            </article>
            <div class="clear"></div>
        </div>
    </body>
</html>