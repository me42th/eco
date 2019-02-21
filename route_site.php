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
    $data = isset($_GET['page'])
                                ?Product::list_by_category_with_pagination($idcategoria,$_GET['page']):Product::list_by_category_with_pagination($idcategoria);
    $pages = [];
    $present_page = isset($_GET['page'])?$_GET['page']:1;
    for($i = 0;$i < $data['pages'];){
        array_push($pages,[
            'link'=>"/eco/index.php/categoria/$idcategoria/$nome?page=".++$i,
            'page'=>$i
        ]);
    }                            
    $page = new Page(debug());
    $page->setTpl("category",["category" => $category->getdata(),"products" => $data['products'],'pages' => $pages]);
});

$app->get('/carrinho',function(){
    $page = new Page(debug());
    $page->setTpl("cart");
});

$app->get('/produto/:desurl',function($desurl){
    $product = Product::find_by_desurl($desurl);    
    $categories = $product['categories'];
    foreach($categories as &$category){
        $category = Category::find($category);
    }    
    $page = new Page(debug());
    $page->setTpl("product-detail",["product" => $product, "categories" => $categories]);
});

?>