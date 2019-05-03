<?php 

use \Slim\Slim;
use \main\Page;
use \main\PageAdmin;
use \main\Model\User;
use \main\Model\Category;
use \main\Model\Product;


$app->get("/admin/users",function(){
    User::verify_admin_login();
    $search = isset($_GET['search'])?$_GET['search']:'';
    $page = isset($_GET['page'])?$_GET['page']:1;
    $data = User::get_with_pagination($search,$page);

    $users = $data['users'];
    $total = $data['total'];
    $page_total = $data['pages'];
    $pages = array();
    $search_href = ($search == '')?$search:"search=$search&";

    for($cont = 1; $cont <= $page_total; $cont++){
        $pages[$cont]['href'] = "/eco/index.php/admin/users?".$search_href."page=$cont"; 
        $pages[$cont]['text'] = $cont;
    }
    
    $page = new PageAdmin(debug(),get_user_header());
    $page->setTpl("users",array("users" => $users,'page_total' => $page_total, "pages" => $pages ,"search" => $search));
});

$app->get("/admin/users/create",function(){
    User::verify_admin_login();
    $page = new PageAdmin(debug(),get_user_header());
    $page->setTpl("users-create");
});

//precisa ficar antes para não se tornar inalcançável    
$app->get("/admin/users/:iduser/delete", function($iduser){
    User::verify_admin_login();
    $user = new User();
    $user->setdata(User::find($iduser));
    $user->del();
    header("Location: /eco/index.php/admin/users");
    exit;

});

//parametro obrigatorio de rota
$app->get("/admin/users/:iduser",function($iduser){
    $user = User::find($iduser);
    User::verify_admin_login();
    $page = new PageAdmin(debug(),get_user_header());
    $page->setTpl("users-update",array('user'=>$user));
});

$app->post("/admin/users/create",function(){
    User::verify_admin_login();
    User::create_user($_POST);
    header("Location: /eco/index.php/admin/users");
    exit;
});

$app->post("/admin/users/:iduser",function($iduser){
    $user = new User();
    User::verify_admin_login();
    $user->setdata(User::find($iduser));      
    $user->update($_POST);
    header("Location: /eco/index.php/admin/users");
    exit;        
});

?>