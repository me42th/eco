<?php
    require_once("vendor/autoload.php");
    $debug = false;

    function debug(){
        global $debug;
        return $debug;
    }

    if(debug()){
        ini_set('display_errors',1);
        ini_set('display_startup_erros',1);
        error_reporting(E_ALL);
    }    
?>