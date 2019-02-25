<?php

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\Model\Cart;
use \main\Freight;

$app->post('/carrinho/frete',function(){
    
    $cart = Cart::find_by_session();
    $cart['deszipcode'] = $_POST['deszipcode'];
    Cart::update($cart);
    $cart_data = Cart::get_resume($cart['idcart']);

    $freight_data['deszipcode'] = $cart['deszipcode'];
    $freight_data['vlweight'] = $cart_data['freight']['vlweight'];
    $freight_data['vllength'] = $cart_data['freight']['vllength'];
    $freight_data['vlheight'] = $cart_data['freight']['vlheight'];
    $freight_data['vlwidth'] = $cart_data['freight']['vlwidth'];
    $freight_data['amount'] = $cart_data['amount'];    
    var_dump(Freight::get_data($freight_data));
    
    

    exit;
    
    //'nVlComprimento'=>$data[],
    //'nVlAltura' =>$data[],
    //'nVlLargura'=>$data[],
    //'nVlValorDeclarado'=>$data[],
    
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/carrinho',function(){
    $resume = Cart::get_resume(Cart::find_by_session()['idcart']); 
    $page = new Page(debug(),get_cart_header($resume['amount'], $resume['sum']));    
    $page->setTpl("cart",[
        "cart" => $resume['products'],
        "amount" => $resume['amount']
         ]);
});

$app->get('/carrinho/:idproduct/add',function($idproduct){
    $idcart = Cart::find_by_session()['idcart'];
    $idproduct = (int)$idproduct;
    $qtd = isset($_GET['qtd'])?$_GET['qtd']:1;
    for($cont = 0; $cont<$qtd; ++$cont)
        Cart::add_prod($idcart,$idproduct);
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/carrinho/:idproduct/rmv',function($idproduct){
    $idcart = Cart::find_by_session()['idcart'];
    $idproduct = (int)$idproduct;
    Cart::rmv_prod($idcart,$idproduct);
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});

$app->get('/carrinho/:idproduct/minus',function($idproduct){
    $idcart = Cart::find_by_session()['idcart'];
    $idproduct = (int)$idproduct;
    Cart::rmv_prod($idcart,$idproduct,1);
    header("Location: /eco/index.php/carrinho#tabela");
    exit;
});
?>