<?php
    
    session_start();

    require_once('config.php');
    require_once('functions.php');
    require_once('route_start.php');
    require_once('route_site.php');
    require_once('route_crud_categories.php');
    require_once('route_crud_products.php');
    require_once('route_crud_users.php');
    require_once('route_login_admin.php');
    
    
    

   
    
       

    $app->run(); ?>