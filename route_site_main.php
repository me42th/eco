<?php

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\Model\Cart;
use \main\Model\Freight;

$app->get('/',function(){

    $resume = Cart::get_resume(Cart::find_by_session()['idcart']);
    
    $page = new Page(debug(),get_home_header($resume['amount'], $resume['sum']));
    
    $products = Product::listAll();    
    foreach($products as &$value){
        $product = new Product;
        $product->setdata($value);
        $value = $product->getdata();
    }
    
    $page->setTpl("index",[
        'products' => $products
    ]);
});




?>