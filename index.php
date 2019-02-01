<?php
    require_once('config.php');
    $app = new \Slim\Slim();
    $app->config('debug',true);

    // http://localhost/eco/index.php/fck
    $app->get('/fck', function () {
        echo "Hello, " ;
    });
    
    $app->run();
?>