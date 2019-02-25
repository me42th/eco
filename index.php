<?php
    session_start();

    require_once('config.php');
    require_once('functions.php');
    
    require_once('route_start.php');

    require_once('route_login_admin.php');
    
    require_once('route_site_main.php');
    require_once('route_site_cart.php');
    require_once('route_site_category.php');
    require_once('route_site_product.php');

    require_once('route_crud_categories.php');
    require_once('route_crud_products.php');
    require_once('route_crud_users.php');
    
    

    $app->run(); ?>