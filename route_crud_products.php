<?php

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;

$app->get('/admin/products/all',function(){
    User::verify_admin_login();
    $category_name = 'Produtos';
    $products = Product::listAll();
    $page = new PageAdmin(debug(),get_product_header(0));
    $page->setTpl("products",["products" => $products,"descategory" => $category_name,"idcategory" => 0]);
});

$app->get('/admin/products/:idcategory',function($idcategory){
    User::verify_admin_login();
    $category_name = Category::find($idcategory)['descategory'];
    $products = Product::list_by_category($idcategory);
    $page = new PageAdmin(debug(),get_product_header($idcategory));
    $page->setTpl("products",["products" => $products,"descategory" => $category_name,"idcategory" => $idcategory]);
});

$app->get('/admin/products/create/:idcategory',function($idcategory){
    User::verify_admin_login();
    $category_name = Category::find($idcategory)['descategory'];       
    $page = new PageAdmin(debug(),get_product_header($idcategory));
    $page->setTpl("products-create",["idcategory" => $idcategory,"descategory" => $category_name]);
});

$app->get('/admin/products/edit/:idproduct/:idcategory',function($idproduct,$idcategory){
    User::verify_admin_login();
    $category_name = Category::find($idcategory)['descategory'];    
    $product = new Product;
    $product->setdata(Product::find($idproduct));       
    $idcategory = ($idcategory == '0')?$idcategory+0:$idcategory;//+= 0;
    $page = new PageAdmin(debug(),get_product_header($idcategory));
    $page->setTpl("products-update",["idcategory" => $idcategory,"descategory" => $category_name,'product' => $product->getdata()]);
});



$app->post('/admin/products/edit/:idproduct/:idcategory',function($idproduct,$idcategory){
    User::verify_admin_login();
    Product::update($_POST);
    $product = new Product;
    $product->setdata(Product::find($idproduct));
    $idcategory = ($idcategory==0)?'all':$idcategory;    
    if(isset($_FILES['file'])){      
        $product->addPhoto($_FILES['file']);
    }
    header('Location: /eco/index.php/admin/products/'.$idcategory);
    exit;

});

$app->get('/admin/products/delete/:idproduct/:idcategory',function($idproduct,$idcategory){
    User::verify_admin_login();
    Product::del($idproduct);    
    $idcategory = ($idcategory==0)?'all':$idcategory;   
    header('Location: /eco/index.php/admin/products/'.$idcategory);
    exit;
});



$app->post('/admin/products/create/:idcategory',function($idcategory){
    User::verify_admin_login();
    Product::create($_POST);      
    $idcategory = ($idcategory==0)?'all':$idcategory;  
    header('Location: /eco/index.php/admin/products/'.$idcategory);
    exit;
});


?>