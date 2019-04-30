<?php

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\Model\Cart;
use \main\Model\Freight;
use \main\Model\Order;

use \main\MSN;

$app->get('/login',function(){
    $_SESSION['register']['desperson'] = isset($_SESSION['register']['desperson'])?$_SESSION['register']['desperson']:'';      $_SESSION['register']['desemail'] = isset($_SESSION['register']['desemail'])?$_SESSION['register']['desemail']:'';   
    $_SESSION['register']['nrphone'] = isset($_SESSION['register']['nrphone'])?$_SESSION['register']['nrphone']:'';   
    $_SESSION['register']['deslogin'] = isset($_SESSION['register']['deslogin'])?$_SESSION['register']['deslogin']:'';   
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
        User::validate($_POST);
        User::create_user($_POST);
        MSN::set_success_msg('USUÁRIO CRIADO COM SUCESSO, INFORME SUAS CREDENCIAIS');
        header("Location: /eco/index.php/login");
    }catch(\Exception $ex){
        MSN::set_error_msg($ex->getMessage());
        header("Location: /eco/index.php/login");
        $_SESSION['register'] = $_POST;
    }
    //caso dê ruim no cadastro as info não se perdem
    //e o usuário pode apenas corrigir o erro  
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
    Cart::set_user();   
    header("Location: /eco/index.php");
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
    $page = new Page(debug(),get_home_header($resume['amount'], $resume['sum']));
    $page->setTpl("profile",[
        'user' => User::find(User::find_by_session()['iduser']),
        'profileMsg' => '',
        'profileError' => ''
    ]);
});

$app->post("/perfil",function(){
    User::verify_login(); 

    $iduser = User::find_by_session()['iduser'];
    $user = new User();    
    $user->setdata(User::find($iduser));      
    try{
        User::validate($_POST,$iduser);
        $user->update($_POST);
        header("Location: /eco/index.php/perfil");
        MSN::set_success_msg('DADOS ATUALIZADOS COM SUCESSO');
    }catch(\Exception $ex){                
        header("Location: /eco/index.php/perfil");
        MSN::set_error_msg($ex->getMessage());
    }
    exit;        
});

$app->get("/perfil/pedidos",function(){
    User::verify_login();

    $orders = Order::list_by_user();
    $resume = Cart::get_resume(); 
    $page = new Page(debug(),get_home_header($resume['amount'], $resume['sum']));
    $page->setTpl("profile-orders",[
        'orders' => $orders
    ]);
});

$app->get("/perfil/pedido/:idorder",function($idorder){
    User::verify_login();

    $order = Order::find_by_id($idorder);
    $resume = Cart::get_resume();
    $page = new Page(debug(),get_home_header($resume['amount'], $resume['sum']));
    $resume = Cart::get_resume($order['idcart']); 
    $products = $resume['products'];
    $amount = $resume['amount'];
    $vlfreight = Cart::find($order['idcart'])[0]['vlfreight'];
    $page->setTpl("profile-orders-detail",[
        'order' => $order,
        'products' => $products,
        'amount' => $amount,
        'vlfreight' => $vlfreight
    ]);
});

$app->get("/perfil/alterar-senha",function(){
    User::verify_login();
    
  
    $resume = Cart::get_resume(); 
    $page = new Page(debug(),get_home_header($resume['amount'], $resume['sum']));
    $page->setTpl("profile-change-password");

});

$app->post("/perfil/alterar-senha",function(){ 
    
    try{
        User::change_paz_sword($_POST,$_SESSION['user']['iduser']);
        MSN::set_success_msg('SENHA ALTERADA COM SUCESSO');
        header("Location: /eco/index.php/perfil");
    }catch(\Exception $ex){
        MSN::set_error_msg($ex->getMessage());
        header("Location: /eco/index.php/perfil/alterar-senha");  
    }
    exit;
});

?>