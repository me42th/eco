<?php



use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;

$app = new Slim();
    $app->config('debug',debug());

function get_config_header($activearea,$category_active = ""){
    $data = ["active" => $activearea,"categories" => Category::listAll(),'category_active' => $category_active];
    return array("data" => $data);
}

function get_category_header(){
    return get_config_header('category');    
}

function get_user_header(){
    return get_config_header('user');
}

function get_product_header($category_active){
    return get_config_header('product',$category_active);
}

?>