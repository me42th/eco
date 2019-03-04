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


/** Esse array determina quais trechos do jquery serão carregados
*   Caso não sejam informados todos será disparado um erro,
*   a function abaixo foi criada para facilitar a fica do desenvolvedor
*/

function get_js_header($a_vlfreight = false,$m_deszipcode = false){
    
    return [
        "a-vlfreight" => $a_vlfreight,
        "m-deszipcode" => $m_deszipcode
    ];
}

function get_config_header($activearea, $category_active = "", $cart_amount = "", $cart_qtd = "",$js = "")
{   
    $data = [
        "active" => $activearea,
        "categories" => Category::listAll(),
        'category_active' => $category_active,
        "cart_amount" => $cart_amount, 
        "cart_qtd" => $cart_qtd, 
        "error_msg" => MSN::get_error_msg(), 
        "success_msg" => MSN::get_success_msg(), 
        "alert_msg" => MSN::get_alert_msg(),
        "js" => $js
    ];    
    return array("data" => $data);
}

function get_login_admin_header(){    
    return array_merge(get_config_header('cart'),['header' => false,'footer'=>false]);    
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
    return get_config_header("home","",$cart_amount,$cart_qnt,get_js_header());
}

function get_cart_header($cart_amount = "", $cart_qnt = ""){
    return get_config_header("cart","",$cart_amount,$cart_qnt,get_js_header(true,true));
}

function get_prod_header($cart_amount = "", $cart_qnt = ""){
    return get_config_header("prod","",$cart_amount,$cart_qnt,get_js_header());
}

?>