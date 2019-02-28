<?php

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\Model\Cart;
use \main\Model\Address;

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
    $address = new Address;
    $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum'])); 
    $page->setTpl("checkout", [
        'cart'=>$cart,
        'address'=>$address->getdata()
    ]);
});

?>