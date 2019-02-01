<?php
require_once("vendor/autoload.php");

$app = new \Slim\Slim();
// http://localhost/eco/index.php/fck
$app->get('/fck', function () {

    echo "Hello, " ;
});
$app->run();

?>