<?php
    require_once("vendor/autoload.php");
    $debug = true;

    header('Content-Type: text/html; charset=utf-8');

    function debug(){
        global $debug;
        return $debug;
    }
    date_default_timezone_set('America/Bahia');
    if(debug()){
        ini_set('display_errors',1);
        ini_set('display_startup_erros',1);
        error_reporting(E_ALL);
    }    
?>