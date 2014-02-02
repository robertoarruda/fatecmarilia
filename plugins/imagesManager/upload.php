<script src="/js/jquery-1.9.1.min.js"></script>
<?php
require_once('../../config/loadConfig.php');
header('Cache-Control: no-cache');

$dir = base64_decode(returnGet('d'));
$tipo = returnGet('tipo');
$filename = returnGet('filename', strtolower(time() . '.jpg'));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dir = returnPost('dirIM');
    $tipo = returnPost('tipoIM');
    $filename = returnPost('filenameIM');
    $img = new _canvas($_FILES['arquivoIM']['tmp_name']);
    $img->redimensiona(1500, 1500, 'proporcional')->grava("$dir$filename");
    unlink($_FILES['arquivoIM']['tmp_name']);
    ?>
    <script>
        $(document).ready(function(){
            $('#imagesManager', parent.document)
            .fadeOut('fast', function(){
                $('#imagesManager', parent.document).remove();
                window.parent.$.loadingGif();
            });
            window.parent.setTimeout('jcropView("<?php print base64_encode($dir); ?>","<?php print base64_encode($filename); ?>","<?php print $tipo; ?>")',500);
        });
    </script>
    <?php
}
?>
<script>
    $(document).ready(function(){
        $('#arquivoIM').change(function(){
            $('#btnSubmit').trigger('click');
        });
    });
</script>
<form name="frmImagesManager" method="POST" action="/plugins/imagesManager/upload.php" enctype="multipart/form-data">
    <input name="dirIM" id="dirIM" type="hidden" value="<?php print $dir; ?>">
    <input name="tipoIM" id="tipoIM" type="hidden" value="<?php print $tipo; ?>">
    <input name="filenameIM" id="filenameIM" type="hidden" value="<?php print $filename; ?>">
    <input name="arquivoIM" id="arquivoIM" type="file" accept="image/jpeg">
    <input id="btnSubmit" name="btnSubmit" type="submit">
</form>