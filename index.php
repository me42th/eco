<?php
    require_once('config.php');
    
    use \Slim\Slim;
    use \main\Page;
    use \main\PageAdmin;

    $app = new Slim();
    $app->config('debug',debug());
    
    $app->get('/',function(){
        $page = new Page(debug());
        $page->setTpl("index");
    });

    $app->get('/admin',function(){
        $page = new PageAdmin(debug());
        $page->setTpl("index");
    });

    // http://localhost/eco/index.php/fck
    $app->get('/fck', function () {
        echo "Hello, " ;
    });
    
    $app->run();
?>