<?php
require_once('../../config/loadConfig.php');

$targetFolder = returnPost('folder', '/uploads');
$fixName = returnPost('fixName', false);
$tipos = str_replace(' ', '', returnPost('tipos', 'jpg; jpeg; gif; png'));
$dimensoes = explode(';', returnPost('dimensao','1000x1000:proporcional;196x196:preenchetudo'));

if (!empty($_FILES)) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    
    if (!is_dir($targetPath)) {
        $tP = iconv('utf-8', 'iso-8859-1', $targetPath);
        if (!is_dir($tP)) {
            $tP = iconv('iso-8859-1', 'utf-8', $targetPath);
        }
        $targetPath = $tP;
    }
    $fileTypes = explode(';', $tipos);
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $ext = strtolower($fileParts['extension']);
    $namefile = $fileParts['filename'];
    if (is_dir($targetPath)) {
        if ($fixName)
            $targetFile = rtrim($targetPath,'/') . "/$fixName.$ext";
        else
            $targetFile = rtrim($targetPath,'/') . "/$namefile.$ext";

        if (in_array($ext, $fileTypes)) {
            if (move_uploaded_file($tempFile,"$targetFile")) {
                if (is_file("$targetFile")) {
                    if (_funcoes::isImage("$targetFile")) {
                        $c = 0;
                        foreach ($dimensoes as $key => $value) {
                            $value = explode(':', $value);
                            $tipo = $value[1];
                            $value = explode('x', $value[0]);
                            $w = $value[0];
                            $h = $value[1];
                            if ($c == 0) {
                                $objImagem = new _canvas("$targetFile");
                                $objImagem->redimensiona($w, $h, $tipo);
                                $objImagem->grava("$targetFile");
                            } else {
                                $objImagem = new _canvas("$targetFile");
                                $objImagem->redimensiona($w, $h, $tipo);
                                if ($fixName)
                                    $objImagem->grava(rtrim($targetPath,'/') . "/$w" . "x$h/$fixName.$ext", 90);
                                else
                                    $objImagem->grava(rtrim($targetPath,'/') . "/$w" . "x$h/$namefile.$ext", 90);
                            }
                            $c++;
                        }
                    }
                    print '';
                } else {
                    print 'Erro ao mover arquivo.';
                }
            } else {
                print 'Erro ao mover arquivo.';
            }
        } else {
            print "Tipo inválido de arquivo.\nEnvie um arquivo do(s) tipo(s): '$tipos'.";
        }
    } else {
        print "Diretório inválido: ".iconv('iso-8859-1', 'utf-8', $targetPath);
    }
} 
?>