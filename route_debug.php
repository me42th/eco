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
use \main\Model\Ticket;


$app->get('/find_by_id/:model/:id',function($model,$id){
 if($model == 'order')
   print_r(Order::find_by_id($id));
   exit;
});

$app->get('/find_by_session/:model',function($model){
  if($model == 'user')
    print_r(User::find_by_session());
  if($model == 'cart')
    print_r(Cart::find_by_session());
      
    exit;
 });

$app->get('/function/:model/:function/:data',function($model,$function,$data){
  if($model == 'cart')
  { 
    if($function == "resume")
      print_r(Cart::get_resume($data));
    if($function == "get_address")
      print_r(Cart::get_address());
    exit;
  }

  if($model == 'order'){
      if($function == "boleto_itau")
        print_r(Order::get_boleto($data,'itau'));
 
      if($function == "list_by_session_user"){
        print_r(Order::list_by_user()); 
      }
      if($function == "list_by_user"){
        print_r(Order::list_by_user($data)); 
      }
  }

  if($model == 'ticket'){
    if($function == "boleto_itau")
      print_r(Ticket::ticket_factory('itau',Order::boleto_data($data,'itau')));
      exit;
  }

  if($model == 'user'){
    if($function == "find")
      print_r(User::find($data));
      exit;
  }

 
 
 });

?>