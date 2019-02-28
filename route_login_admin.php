<?php

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\MSN;


$app->get('/admin',function(){
    User::verify_admin_login();
    $page = new PageAdmin(debug(),get_config_header("index"));
    $page->setTpl("index");
});

$app->get('/admin/login',function(){    
    $page = new PageAdmin(debug(),get_login_admin_header());
    $page->setTpl("login");
});

$app->get('/admin/logout',function(){
    User::logout();
    MSN::set_success_msg('Usuário deslogado do sistema');
    header("Location: /eco/index.php/admin/login");
    exit;
});

$app->post('/admin/login',function(){
    try{
    User::login($_POST["login"],$_POST["password"]);
    }catch(\Exception $ex){
        MSN::set_error_msg($ex->getMessage());
        header("Location: /eco/index.php/admin/login");
        exit;
    }
    header("Location: /eco/index.php/admin");
    exit; 
});



$app->get("/admin/forgot", function(){
    $page = new PageAdmin(debug(),["header" => false,"footer" => false]);
    $page->setTpl("forgot");
});

$app->post("/admin/forgot", function(){
   // $page = new PageAdmin(debug(),["header" => false,"footer" => false]);
    $email = $_POST['email'];
    $user = User::getForgot($email);
    header("Location: /eco/index.php/admin/forgot/sent");
    exit;
});

$app->get('/admin/forgot/reset/:code',function($code){
    if(User::verifyCode($code) && User::verifyTimeCode($code)){
        $user = new User;
        $user->setdata(User::find(json_decode(User::ssl_decrypt($code),true)["user"]));
        $page = new PageAdmin(debug(),['header' => false, 'footer' => false]);
        $page->setTpl("forgot-reset",array("code" => $code, 'name' => $user->getdesperson()));
    }else{
        header("Location: /eco/index.php/admin/forgot");
        exit;
    }        
});

$app->post('/admin/forgot/reset', function(){
    if(User::verifyCode($_POST['code']) && User::verifyTimeCode($_POST['code'])){
        User::paz_sword_update($_POST['code'],$_POST['password']);
        header("Location: /eco/index.php/admin/login");
        exit;
    } else {
        header("Location: /eco/index.php/admin/forgot");
        exit;
    }
});

$app->get('/admin/forgot/sent',function(){
    $page = new PageAdmin(debug(),["header" => false,"footer" => false]);
    $page->setTpl("forgot-sent");
});


?>