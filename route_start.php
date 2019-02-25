<?php



use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\MSN;


$app = new Slim();
$app->config('debug',debug());

function get_config_header($activearea, $category_active = "", $cart_amount = "", $cart_qtd = "")
{   
    $data = [
        "active" => $activearea,
        "categories" => Category::listAll(),
        'category_active' => $category_active,
        "cart_amount" => $cart_amount, 
        "cart_qtd" => $cart_qtd, 
        "error_msg" => MSN::get_error_msg(), 
        "success_msg" => MSN::get_success_msg(), 
        "alert_msg" => MSN::get_alert_msg()
    ];    
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

function get_home_header($cart_amount = "", $cart_qnt = ""){
    return get_config_header("home","",$cart_amount,$cart_qnt);
}

function get_cart_header($cart_amount = "", $cart_qnt = ""){
    return get_config_header("cart","",$cart_amount,$cart_qnt);
}

function get_prod_header($cart_amount = "", $cart_qnt = ""){
    return get_config_header("prod","",$cart_amount,$cart_qnt);
}

?>