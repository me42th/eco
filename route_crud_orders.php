<?php 

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Cart;

use \main\Model\Order;

$app->get("/admin/orders",function(){
    User::verify_admin_login();    
    $page = new PageAdmin(debug(),get_order_header());
    $orders = Order::list_all();
    $page->setTpl("orders",array("orders" => $orders));
});

$app->get("/admin/orders/:idorder/delete",function($idorder){
    User::verify_admin_login();
    Order::delete($idorder);
    header("Location: /eco/index.php/admin/orders");
    exit;
});

$app->get("/admin/orders/:idorder",function($idorder){
    User::verify_admin_login();   
    $order = Order::find_by_id($idorder);
    $products = Cart::get_resume($order['idcart'])["products"];
    
    $page = new PageAdmin(debug(),get_order_header());
    
    $page->setTpl("order",array("order" => $order,"products" => $products));
});

?>