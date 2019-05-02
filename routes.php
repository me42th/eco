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

require_once('route_login_admin.php');
require_once('route_site_user.php');
require_once('route_site_main.php');
require_once('route_site_cart.php');
require_once('route_site_category.php');
require_once('route_site_product.php');
require_once('route_crud_categories.php');
require_once('route_crud_products.php');
require_once('route_crud_users.php');
require_once('route_crud_orders.php');

require_once('route_debug.php');
$app->run();
?>