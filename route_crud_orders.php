<?php 

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;


$app->get("/admin/orders",function(){
    User::verify_admin_login();
    
    $page = new PageAdmin(debug(),get_order_header());
    
    $page->setTpl("orders",array("orders" => null));
});



?>