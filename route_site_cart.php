<?php

use \Slim\Slim;
use \main\MSN;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\Model\Cart;
use \main\Model\Address;
use \main\Model\Order;

$app->post('/carrinho/frete',function(){
    $cart = Cart::find_by_session();
    $cart['deszipcode'] = $_POST['deszipcode'];
    Cart::update($cart);     
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/carrinho',function(){        
    $cart = Cart::find_by_session();
    if(isset($cart['deszipcode'])) Cart::set_freight_data();
    $resume = Cart::get_resume(); 
    $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum']));    
    $page->setTpl("cart",[
        "cart" => $cart,
        "resume" => $resume['products'],
        "amount" => $resume['amount']
    ]);
});

$app->get('/carrinho/:idproduct/add',function($idproduct){
    $cart = Cart::find_by_session();
    $qtd = isset($_GET['qtd'])?$_GET['qtd']:1;
    for($cont = 0; $cont<$qtd; ++$cont)
        Cart::add_prod($cart['idcart'],$idproduct);       
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/carrinho/:idproduct/rmv',function($idproduct){
    $cart = Cart::find_by_session();
    $idproduct = (int)$idproduct;
    Cart::rmv_prod($cart['idcart'],$idproduct);
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/carrinho/:idproduct/minus',function($idproduct){
    $cart = Cart::find_by_session();
    $idproduct = (int)$idproduct;
    Cart::rmv_prod($cart['idcart'],$idproduct,1);    
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/checkout', function(){
    User::verify_login();
    $cart = Cart::find_by_session();
    $resume = Cart::get_resume(); 
    
    try{
        $address = Address::get_by_zipcode($cart['deszipcode']);
        $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum'])); 
        $page->setTpl("checkout", [
            'cart'=>$cart,
            'address'=>$address,
            'products'=>$resume['products'],
            'amount'=>$resume['amount'],
            'cart'=>$cart
        ]);
    }
    catch(\Exception $ex){
        MSN::set_error_msg($ex->getMessage());
        header("Location: /eco/index.php/carrinho#tabela");
        exit;
    }

});

$app->post('/checkout', function(){
    User::verify_login();
    $resume = Cart::get_resume(); 
    Cart::find_by_session;
    Cart::set_address();

//    Order::create(['idcart' => ,'vltotal']);



    header("Location: /eco/index.php/pedido/");
});

$app->get('/pedido/:idorder',function($idorder){
    User::verify_login();
    $page = new page();
    $resume = Cart::get_resume(); 
    $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum'])); 
    $page->setTpl("payment");
    
});


?>