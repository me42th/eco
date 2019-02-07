<?php
    require_once("vendor/autoload.php");
    $debug = true;

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