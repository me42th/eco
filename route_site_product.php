<?php
use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\Model\Cart;
use \main\Model\Freight;


$app->get('/produto/:desurl',function($desurl){
    $resume = Cart::get_resume(Cart::find_by_session()['idcart']);
    $page = new Page(debug(),get_prod_header($resume['amount'], $resume['sum']));

    $product = Product::find_by_desurl($desurl);    
    $categories = $product['categories'];
    foreach($categories as &$category){
        $category = Category::find($category);
    }    
    
    $page->setTpl("product-detail",["product" => $product, "categories" => $categories]);
});


?>