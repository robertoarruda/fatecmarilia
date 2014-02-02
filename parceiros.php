<ul id="boxParceiros">
    <?php
    $album = new _foto("imagens/", array('jpg','png','gif'));
    foreach ($album->mostrarFotos("parceiros", false) as $valor) {
        $valor = iconv('iso-8859-1', 'utf-8', $valor);
        $nome = base64_decode(_funcoes::extrairInfoArq("imagens/parceiros/$valor",'nome'));
        if (filter_var($nome, FILTER_VALIDATE_URL))
            print "<li><a href=\"$nome\" target=\"_blank\"><img src=\"/imagens/parceiros/$valor\"></a></li>";
    }
    ?>
</ul>