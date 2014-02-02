<?php
require_once('ie.php');
$error = isset($_POST['error']) ? $_POST['error'] : '';
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
        <link rel="stylesheet" type="text/css" href="/css/404.css">
        <title>Error - 500 Internal Server Error</title>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script>
            $(document).ready(function(){
               setInterval(function(){
                   window.location.reload();
               }, 30000); 
            });
        </script>
    </head>
    <body>
        <div id="all">
            <header>
                <div id="efeitoDegradeLinear"></div>
                <div class="enquadramento1000px">
                    <div id="efeitoDegradeRadial"></div>
                    <div id="efeitoElipseDegradeRadial"></div>
                </div>
                <div id="faixaAzul">
                    <div class="enquadramento1000px">
                        <a href="/" ><img id="logoFatec" src="/imagens/layout/estrutura/png/logoFatec.graphic.png"></a>
                    </div>
                </div>
            </header>
            <article id="article">
                <div class="enquadramento1000px">
                    <div class="ops">ops!</div>
                    <div class="c404">500</div>
                    <div class="error">error</div>
                    <div class="clear"></div>
                    <div class="align">
                        <h1>Erro Interno no Servidor</h1>
                        <h2>Erro ao estabelecer conexão com o banco de dados.</h2>
                        <p>Tente novamente mais tarde. Caso o problema persista, consulte o administrador.</p>
                        <p class="server">[ <?php print iconv('iso-8859-1', 'utf-8', base64_decode($error)); ?>]</p>
                    </div>
                </div>
            </article>
            <div class="clear"></div>
        </div>
    </body>
</html>