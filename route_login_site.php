<?php

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\Model\Cart;
use \main\Model\Freight;
use \main\MSN;

$app->get('/login',function(){        

    $resume = Cart::get_resume(); 
    $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum']));    
    $page->setTpl("login");
});

$app->get('/logout',function(){
    User::logout();
    MSN::set_success_msg('Usuário deslogado do sistema');
    header("Location: /eco");
    exit;
});

$app->post('/login',function(){
   
    try{
        User::login($_POST["deslogin"],$_POST["despassword"]);
    }
    catch(\Exception $ex){
        MSN::set_error_msg($ex->getMessage());
        header("Location: /eco/index.php/checkout");
        exit;
    }
    MSN::set_success_msg('LOGADO');
    header("Location: /eco");
    exit;    
});


?>