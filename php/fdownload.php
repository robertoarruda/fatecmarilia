<?php
	require_once('../config/loadConfig.php');
	
	$arquivo= base64_decode(urldecode($_GET["file"]));
		
	if(isset($arquivo) && file_exists($arquivo)){ // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
		switch(strtolower(substr(strrchr(basename($arquivo),"."),1))){ // verifica a extensão do arquivo para pegar o tipo
			case "txt": $tipo="application/txt"; break;
			case "pdf": $tipo="application/pdf"; break;
			case "exe": $tipo="application/octet-stream"; break;
			case "zip": $tipo="application/zip"; break;
			case "docx": $tipo="application/msword"; break;
			case "doc": $tipo="application/msword"; break;
			case "xlsx": $tipo="application/vnd.ms-excel"; break;
			case "xls": $tipo="application/vnd.ms-excel"; break;
			case "pptx": $tipo="application/vnd.ms-powerpoint"; break;
			case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
			case "gif": $tipo="image/gif"; break;
			case "png": $tipo="image/png"; break;
			case "jpg": $tipo="image/jpg"; break;
			case "mp3": $tipo="audio/mpeg"; break;
			case "php": $tipo="block"; break;
			case "htm": $tipo="block"; break;
			case "html": $tipo="block"; break;
			case "js": $tipo="block"; break;
			case "css": $tipo="block"; break;
			default: $tipo="block"; break;
		}
		if ($tipo != "block") {
			header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
			header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
			header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
			readfile($arquivo); // lê o arquivo
			exit; // aborta pós-ações
		}
	} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/padrao.styles.css" />
<link rel="stylesheet" type="text/css" href="/css/layout.styles.css" />
<title><?php echo TITLE_WINDOW; ?></title>
<script type="text/javascript" src="/js/jquery.min.js"></script>
</head>
<body>
<div id="tudo">
  <div id="cabecalho">
    <?php require_once('../cabecalho.php'); ?>
  </div>
  <div id="corpo">
    <div class="box"><img src="/imagens/PNG/download.png" width="150" height="150" class="titulo" />
      <h1>Downloads</h1>
      <h2>Lista de Downloads</h2>
      <br />
      <p>Erro ao efetuar o download: voc&ecirc; n&atilde;o tem privil&eacute;gios de acesso a este arquivo, ou arquivo n&atilde;o existe.</p>
      </div>
  </div>
  <div id="padding_bottom">&nbsp;</div>
</div>
<div id="rodape">
  <?php require_once('../rodape.php'); ?>
</div>
</body>
</html>
<?php } ?>