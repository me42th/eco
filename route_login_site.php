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



$app->get("/forgot", function(){
    $resume = Cart::get_resume(); 
    $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum']));  
    $page->setTpl("forgot");
});

$app->post("/forgot", function(){
    $email = $_POST['email'];
    try{
        $user = User::getForgot($email);
        header("Location: /eco/index.php/forgot/sent");
        exit;
    }catch(\Exception $ex){
        MSN::set_error_msg($ex->getMessage());
        header("Location: /eco/index.php/forgot");
        exit;
    }
});

$app->get('/forgot/reset/:code',function($code){
    if(User::verifyCode($code) && User::verifyTimeCode($code)){
        $user = new User;
        $user->setdata(User::find(json_decode(User::ssl_decrypt($code),true)["user"]));
        $resume = Cart::get_resume(); 
        $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum']));  
        $page->setTpl("forgot-reset",array("code" => $code, 'name' => $user->getdesperson()));
    }else{
        header("Location: /eco/index.php/forgot");
        exit;
    }        
});

$app->post('/forgot/reset', function(){
    if(User::verifyCode($_POST['code']) && User::verifyTimeCode($_POST['code'])){
        User::paz_sword_update($_POST['code'],$_POST['password']);
        header("Location: /eco/index.php/login");
        exit;
    } else {
        MSN::set_error_msg('LINK EXPIRADO');
        header("Location: /eco/index.php/forgot");
        exit;
    }
});

$app->get('/forgot/sent',function(){
    $resume = Cart::get_resume(); 
    $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum']));
    $page->setTpl("forgot-sent");
});

$app->get('/perfil',function(){
    User::verify_login();
    $resume = Cart::get_resume(); 
    $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum']));
    $page->setTpl("profile",[
        'user' => User::find(User::find_by_session()['iduser']),
        'profileMsg' => '',
        'profileError' => ''
    ]);
});

$app->post("/perfil",function(){
    User::verify_login();
    $user = new User();
    
    $user->setdata(User::find(User::find_by_session()['iduser']));      
    $user->update($_POST);
    header("Location: /eco/index.php/perfil");
    MSN::set_success_msg('DADOS ATUALIZADOS COM SUCESSO');
    exit;        
});

$app->get("/validate",function(){
    
    User::validate(User::find(User::find_by_session()['iduser']));      
    exit;        
});

$app->post('/perfil', function(){
    if(User::verifyCode($_POST['code']) && User::verifyTimeCode($_POST['code'])){
        User::paz_sword_update($_POST['code'],$_POST['password']);
        header("Location: /eco/index.php/login");
        exit;
    } else {
        MSN::set_error_msg('LINK EXPIRADO');
        header("Location: /eco/index.php/forgot");
        exit;
    }
});

?>