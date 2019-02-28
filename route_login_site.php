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
    MSN::set_success_msg('USUÁRIO DESLOGADO COM SUCESSO');
    header("Location: /eco");
    exit;
});

$app->post('/register',function(){
    try{
        User::create_user($_POST);
    }catch(\Exception $ex){
        $_SESSION['register'] = $_POST;
    }
    //caso dê ruim no cadastro as info não se perdem
    //e o usuário pode apenas corrigir o erro  
    

    MSG::set_success_msg('USUÁRIO CRIADO COM SUCESSO, INFORME SUAS CREDENCIAIS');
    header("Location: /eco/index.php/login");
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
    MSN::set_success_msg('BEM VINDO '.user_name().' :D');
    header("Location: /eco");
    exit;    
});


?>