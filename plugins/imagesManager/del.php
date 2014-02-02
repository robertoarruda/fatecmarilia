<?php
require_once('../../config/loadConfig.php');
header('Cache-Control: no-cache');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dir = corrigeArq(_funcoes::extrairInfoArq(returnPost('file'),'dir'));
    $file = _funcoes::extrairInfoArq(returnPost('file'));

    $erro = "
        <script>
        $.showMsg({
            msg: 'Ocorreu um erro na operação solicitada.',
            titulo: 'Erro'
        });
        </script>
    ";
    
    $sucesso = "
        <script>
        $.showMsg({
            msg: 'Imagem excluida com sucesso!',
            titulo: 'Sucesso'
        }, function(){
            location.reload();
        });
        </script>
    ";

    $msg = "";

    if (returnPost('acao') == 'excluir') {
        if (is_dir($dir)) {
            if (unlink("$dir/$file")) {
                $msg = $sucesso;
                foreach (glob("$dir/*/$file") as $filename) {
                    unlink($filename);
                }
            }
            else
                $msg = $erro;
        }
    }
    //print $msg;
}
?>