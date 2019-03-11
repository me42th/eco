<?php

use \Slim\Slim;
use \main\MSN;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;
use \main\Model\Cart;
use \main\Model\Address;
use \main\Model\Order;



$app->get('/find_by_id/:model/:id',function($model,$id){
 if($model == 'Order')
   print_r(Order::find_by_id($id));
   exit;
});
?>