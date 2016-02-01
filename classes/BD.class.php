<?php
/**
 *
 * Classe para conexão ao banco de dados
 * e configurações de conexão
 *
 * @author     Roberto Arruda <robertoadearruda@gmail.com>
 * @copyright 2012 - Roberto Arruda
 * @version    1.0 $ 2012-12-13 19:11:51 $
 */
class BD {

    private static $conn;

    private function __construct() {
        
    }

    private function __destruct() {
        
    }

    public static function getConn() {
        if (is_null(self::$conn)) {
            
            //$host = 'localhost';
            $host = 'fatecmarilia.edu.br';
            $user = 'fatecmar_fatecma';
            $pass = '********';
            $bd = 'fatecmar_novosite';
            
            $dns = "mysql:host=$host;dbname=$bd";
            $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
            try {
                self::$conn = new PDO($dns, $user, $pass, $opcoes);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                $error = base64_encode('ERROR: ' . $e->getMessage());
                _funcoes::error500($error);
            }
        }
        return self::$conn;
    }

}

