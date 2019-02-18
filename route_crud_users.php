<?php 

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;


$app->get("/admin/users",function(){
    User::verifyLogin();
    $users = User::listAll();
    $page = new PageAdmin(debug(),get_user_header());
    $page->setTpl("users",array("users" => $users));
});

$app->get("/admin/users/create",function(){
    User::verifyLogin();
    $page = new PageAdmin(debug(),get_user_header());
    $page->setTpl("users-create");
});

//precisa ficar antes para não se tornar inalcançável    
$app->get("/admin/users/:iduser/delete", function($iduser){
    User::verifyLogin();
    $user = new User();
    $user->setdata(User::find($iduser));
    $user->del();
    header("Location: /eco/index.php/admin/users");
    exit;

});

//parametro obrigatorio de rota
$app->get("/admin/users/:iduser",function($iduser){
    $user = User::find($iduser);
    User::verifyLogin();
    $page = new PageAdmin(debug(),get_user_header());
    $page->setTpl("users-update",array('user'=>$user));
});

$app->post("/admin/users/create",function(){
    User::verifyLogin();
    User::create_user($_POST);
    header("Location: /eco/index.php/admin/users");
    exit;
});

$app->post("/admin/users/:iduser",function($iduser){
    $user = new User();
    User::verifyLogin();
    $user->setdata(User::find($iduser));      
    $user->update($_POST);
    header("Location: /eco/index.php/admin/users");
    exit;        
});

?>