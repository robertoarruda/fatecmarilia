<?php
require_once('../../config/loadConfig.php');
header('Cache-Control: no-cache');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $img = returnPost('arqIM');
    $dir = returnPost('dirIM');
    $tipo = returnPost('tipoIM');
    $x = returnPost('xIM');
    $y = returnPost('yIM');
    $w = returnPost('wIM');
    $h = returnPost('hIM');
    $w2 = returnPost('w2IM');
    $h2 = returnPost('h2IM');
    $objImagem = new _canvas("$dir$img");
    if (($objImagem->largura / $w2) > ($objImagem->altura / $h2)) {
        $fator = $objImagem->largura / $w2;
    } else {
        $fator = $objImagem->altura / $h2;
    }
    $x *= $fator;
    $y *= $fator;
    $w *= $fator;
    $h *= $fator;
    $objImagem->posicaoCrop($x, $y, $w, $h);
    $objImagem->redimensiona($w, $h, 'crop');
    $objImagem->grava("$dir$img");
    if (($tipo == 'noticia')||($tipo == 'destaque')) {
        $objImagem984x434 = new _canvas("$dir$img");
        $objImagem400x300 = new _canvas("$dir$img");
        $objImagem150x150 = new _canvas("$dir$img");
        $objImagem145x86 = new _canvas("$dir$img");

        $objImagem984x434->redimensiona(984, 434, 'crop');
        $objImagem984x434->grava($dir . '984x434/' . $img);
        $objImagem400x300->redimensiona(400, 300, 'preenchetudo');
        $objImagem400x300->grava($dir . '400x300/' . $img,90);
        $objImagem150x150->redimensiona(150, 150, 'preenchetudo');
        $objImagem150x150->grava($dir . '150x150/' . $img,60);
        $objImagem145x86->redimensiona(145, 86, 'crop');
        $objImagem145x86->grava($dir . '145x86/' . $img,90);
    }
    elseif (($tipo == 'instituicao')||($tipo == 'curso')) {
        $objImagem400x300 = new _canvas("$dir$img");
        $objImagem150x150 = new _canvas("$dir$img");

        $objImagem400x300->redimensiona(400, 300, 'preenchetudo');
        $objImagem400x300->grava($dir . '400x300/' . $img,90);
        $objImagem150x150->redimensiona(150, 150, 'preenchetudo');
        $objImagem150x150->grava($dir . '150x150/' . $img,60);
    }
    elseif (($tipo == 'funcionario')||($tipo == 'aluno')) {
        $objImagem354x472 = new _canvas("$dir$img");
        $objImagem150x150 = new _canvas("$dir$img");

        $objImagem354x472->redimensiona(354, 472, 'preenchetudo');
        $objImagem354x472->grava($dir . '354x472/' . $img,90);
        $objImagem150x150->redimensiona(150, 150, 'preenchetudo');
        $objImagem150x150->grava($dir . '150x150/' . $img,60);
    }
    elseif ($tipo == 'mural') {
        $objImagem300x150 = new _canvas("$dir$img");
        $objImagem150x150 = new _canvas("$dir$img");

        $objImagem300x150->redimensiona(300, 150, 'preenchetudo');
        $objImagem300x150->grava($dir . '300x150/' . $img,90);
        $objImagem150x150->redimensiona(150, 150, 'preenchetudo');
        $objImagem150x150->grava($dir . '150x150/' . $img,60);
    }
    
    print '1';
    die();
}
$dir = base64_decode(returnGet('d'));
$filename = base64_decode(returnGet('arq'));
$tipo = returnGet('tipo');
?>
<link rel="stylesheet" type="text/css" href="/plugins/imagesManager/imagesManager.css">
<link rel="stylesheet" type="text/css" href="/plugins/imagesManager/Jcrop/jquery.Jcrop.min.css">
<script src="/plugins/imagesManager/imagesManager.js"></script>
<script src="/plugins/imagesManager/Jcrop/jquery.Jcrop.min.js"></script>
<script>
    $(document).ready(function(){
        function exibePreview(c) {
            $('#xIM').val(c.x);
            $('#yIM').val(c.y);
            $('#x2IM').val(c.x2);
            $('#y2IM').val(c.y2);
            $('#wIM').val(c.w);
            $('#hIM').val(c.h);
        }
        $('#imagemJcrop').Jcrop({
            onChange: exibePreview,
            onSelect: exibePreview,
            minSize: [ 50, 50 ],
            maxSize: [ $('#imagemJcrop').width(), $('#imagemJcrop').height() ]
        });
        $('#btnSaveJcrop').click(function(){
            $.post('/plugins/imagesManager/resize.php',
            {
                'arqIM': $('#arqIM').val(),
                'dirIM': $('#dirIM').val(),
                'tipoIM': $('#tipoIM').val(),
                'xIM': $('#xIM').val(),
                'yIM': $('#yIM').val(),
                'wIM': $('#wIM').val(),
                'hIM': $('#hIM').val(),
                'w2IM': $('#imagemJcrop').width(),
                'h2IM': $('#imagemJcrop').height()
            },
            function(res){
                if (res == 1) {
                    $('#imagesManager', parent.document)
                    .fadeOut('fast', function(){
                        $('#imagesManager', parent.document).remove();
                        $.loadingGif();
                    });
                    setTimeout("listView('<?php print base64_encode($dir); ?>', '<?php print $filename; ?>', '<?php print $tipo; ?>')",500);
                }
                else
                    alert(res);
            });
            return false;
        });
        $('#btnCancelJcrop').click(function(){
            var img = $('#dirIM').val() + $('#arqIM').val();
            $.post('/plugins/imagesManager/del.php',
            {
                file: img,
                acao: 'excluir'
            },
            function(){
                $('#imagesManager', parent.document)
                .fadeOut('fast', function(){
                    $('#imagesManager', parent.document).remove();
                    $.loadingGif();
                });
                setTimeout("listView('<?php print base64_encode($dir); ?>', '', '<?php print $tipo; ?>')",500);
            });
        });
    });
</script>
<div id="dialogIM">
    <img id="imagemJcrop" src="/plugins/imagesManager/thumbs.php?f=<?php print base64_encode("$dir$filename"); ?>">
    <div id="boxButtons">
        <input id="arqIM" name="arqIM" type="hidden" value="<?php print $filename; ?>">
        <input id="dirIM" name="dirIM" type="hidden" value="<?php print $dir; ?>">
        <input id="tipoIM" name="tipoIM" type="hidden" value="<?php print $tipo; ?>">
        <input id="xIM" name="xIM" type="hidden" value="0">
        <input id="yIM" name="yIM" type="hidden" value="0">
        <input id="x2IM" name="x2IM" type="hidden" value="0">
        <input id="y2IM" name="y2IM" type="hidden" value="0">
        <input id="wIM" name="wIM" type="hidden" value="0">
        <input id="hIM" name="hIM" type="hidden" value="0">
        <div class="right">
            <input id="btnSaveJcrop" name="btnSaveJcrop" type="button" value="Salvar">
            <input id="btnCancelJcrop" name="btnCancelJcrop" type="button" value="Cancelar">
        </div>
    </div>
</div>