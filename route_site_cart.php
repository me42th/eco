<?php

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\Model\Cart;

$app->post('/carrinho/frete',function(){
    Cart::set_freight_data($_POST['deszipcode']);    
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/carrinho',function(){        
    $cart = Cart::find_by_session();    
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
    if(isset($cart['deszipcode'])) Cart::set_freight_data();      
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/carrinho/:idproduct/rmv',function($idproduct){
    $cart = Cart::find_by_session();
    $idproduct = (int)$idproduct;
    Cart::rmv_prod($cart['idcart'],$idproduct);
    if(isset($cart['deszipcode'])) Cart::set_freight_data();  
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/carrinho/:idproduct/minus',function($idproduct){
    $cart = Cart::find_by_session();
    $idproduct = (int)$idproduct;
    Cart::rmv_prod($cart['idcart'],$idproduct,1);
    if(isset($cart['deszipcode'])) Cart::set_freight_data();  
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

?>