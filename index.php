<?php
    //startar session
    session_start();
    require_once('config.php');
    
    use \Slim\Slim;
    use \main\Page;
    use \main\PageAdmin;
    use \main\Model\User;


    $app = new Slim();
    $app->config('debug',debug());
    
    $app->get('/',function(){
        $page = new Page(debug());
        $page->setTpl("index");
    });

    $app->get('/admin',function(){
        User::verifyLogin();
        $page = new PageAdmin(debug());
        $page->setTpl("index");
    });

    $app->get('/admin/login',function(){
        $page = new PageAdmin(debug(),['header' => false,'footer'=>false]);
        $page->setTpl("login");
    });

    $app->get('/admin/logout',function(){
        User::logout();
        header("Location: /eco/index.php/admin/login");
        exit;
    });

    $app->post('/admin/login',function(){
        User::login($_POST["login"],$_POST["password"]);
        header("Location: /eco/index.php/admin");
        exit;
        //$page = new PageAdmin(debug(),['header' => false,'footer'=>false]);
        //$page->setTpl("login");
    });

    // http://localhost/eco/index.php/fck
    $app->get('/fck', function () {
        echo "Hello, " ;
    });
    
    $app->run();
?>