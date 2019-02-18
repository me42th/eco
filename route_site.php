<?php

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;


$app->get('/',function(){
    $products = Product::listAll();
    
    foreach($products as &$value){
        $product = new Product;
        $product->setdata($value);
        $value = $product->getdata();
    }

    $page = new Page(debug());
    $page->setTpl("index",[
        'products' => $products
    ]);
});


$app->get('/categoria/:idcategoria/:nome',function($idcategoria,$nome){       
    $category = new Category;
    $category->setdata(Category::find($idcategoria));
    $products = Product::list_by_category($idcategoria);
    $page = new Page(debug());
    $page->setTpl("category",["category" => $category->getdata(),"products" =>$products]);
}); 
?>