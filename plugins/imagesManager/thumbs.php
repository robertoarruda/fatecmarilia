<?php
require_once('../../config/loadConfig.php');
header('Cache-Control: no-cache');

$filename = corrigeArq(base64_decode(returnGet('f')));

$objImg = new _canvas($filename);
$objImg->redimensiona(750, 450, 'proporcional')->grava();
?>