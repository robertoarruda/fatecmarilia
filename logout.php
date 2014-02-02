<?php
require_once('ie.php');
require_once('config/loadConfig.php');

session_start();
$objFLogin = new FuncionarioLogin();
session_unset($_SESSION["$objFLogin->nomeSessao"]);
session_unset($_SESSION["$objFLogin->nomeSessao" . "Temp"]);
session_destroy();
header("Location: /login/");
?>