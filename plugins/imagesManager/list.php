<link rel="stylesheet" type="text/css" href="/plugins/imagesManager/imagesManager.css">
<script src="/plugins/imagesManager/imagesManager.js"></script>
<div id="dialogIM">
    <ul class="listImages">
        <?php
        require_once('../../config/loadConfig.php');
        header('Cache-Control: no-cache');

        $dir = corrigeArq(base64_decode(returnGet('d')));
        $sel = returnGet('s');
        $tipo = returnGet('tipo');
        $delBtn = returnGet('delbtn');

        $objArquivo = new _arquivo($dir);
        $objArquivo->extencoes = array('jpg');
        $objArquivo->somenteDiretorios = true;

        foreach ($objArquivo->mostraArquivos() as $value) {
            $nome = _funcoes::extrairInfoArq($value);
            $arq = '/' . str_replace('../', '', $dir);
            $btnDel = ($delBtn) ? "<a class=\"delBtnIM\" data-file=\"$arq$nome\">X</a>" : "";
            $ladyload = (count($objArquivo->mostraArquivos()) > 8) ? "class=\"lazyIM\" src=\"/imagens/layout/estrutura/gif/lazyload-bg.gif\" data-original=" : "src=";
            printf(
                    "<li>$btnDel<img $ladyload\"%s\" data-title=\"$nome\"%s></li>",
                    $arq . '150x150/' . $nome,
                    ($sel == $nome) ? 'class="clicked"' : ''
            );
        }
        ?>
    </ul>
    <div id="boxButtons">
        <iframe src="/plugins/imagesManager/upload.php?d=<?php print base64_encode($dir); ?>&tipo=<?php print $tipo; ?>" ></iframe>
        <input id="nomeImagemSel" name="nomeImagemSel" type="hidden" value="<?php print $sel; ?>">
        <div class="left">
            <input id="btnAddImagem" name="btnAddImagem" type="button" value="Adicionar Nova Imagem">
        </div>
        <div class="right">
            <input id="btnSalvarImagem" name="btnSalvarImagem" type="button" value="Salvar Seleção">
            <input id="btnCancelImagem" name="btnCancelImagem" type="button" value="Cancelar">
        </div>
    </div>
</div>