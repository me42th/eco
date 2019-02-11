<?php
    //startar session
    session_start();
    require_once('config.php');

    use \Slim\Slim;
    use \main\Page;
    use \main\PageAdmin;
    use \main\Model\User;
    use \main\Model\Category;
    use \main\Model\Product;


    $app = new Slim();
    $app->config('debug',debug());

   function get_config_header($activearea){
        $data = ["active" => $activearea,"categories" => Category::listAll()];
        return array("data" => $data);

    }
    
    $app->get('/',function(){
        $page = new Page(debug());
        $page->setTpl("index");
    });

    $app->get('/admin',function(){
        User::verifyLogin();
        $page = new PageAdmin(debug());
        $page->setTpl("index");
    });

    $app->get('/admin/login',function(){
        $page = new PageAdmin(debug(),['header' => false,'footer'=>false]);
        $page->setTpl("login");
    });

    $app->get('/admin/logout',function(){
        User::logout();
        header("Location: /eco/index.php/admin/login");
        exit;
    });

    $app->post('/admin/login',function(){
        User::login($_POST["login"],$_POST["password"]);
        header("Location: /eco/index.php/admin");
        exit; 
    });

    $app->get("/admin/users",function(){
        User::verifyLogin();
        $users = User::listAll();
        $page = new PageAdmin(debug(),get_config_header("user"));
        $page->setTpl("users",array("users" => $users));
    });

    $app->get("/admin/users/create",function(){
        User::verifyLogin();
        $page = new PageAdmin(debug(),get_config_header("user"));
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
        $page = new PageAdmin(debug(),get_config_header("user"));
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

    // http://localhost/eco/index.php/fck
    $app->get('/fck', function () {
        echo "Hello, ";
    });


    $app->get("/admin/forgot", function(){
        $page = new PageAdmin(debug(),["header" => false,"footer" => false]);
        $page->setTpl("forgot");
    });

    $app->post("/admin/forgot", function(){
       // $page = new PageAdmin(debug(),["header" => false,"footer" => false]);
        $email = $_POST['email'];
        $user = User::getForgot($email);
        header("Location: /eco/index.php/admin/forgot/sent");
        exit;
    });

    $app->get('/admin/forgot/reset/:code',function($code){
        if(User::verifyCode($code) && User::verifyTimeCode($code)){
            $user = new User;
            $user->setdata(User::find(json_decode(User::ssl_decrypt($code),true)["user"]));
            $page = new PageAdmin(debug(),['header' => false, 'footer' => false]);
            $page->setTpl("forgot-reset",array("code" => $code, 'name' => $user->getdesperson()));
        }else{
            header("Location: /eco/index.php/admin/forgot");
            exit;
        }        
    });
 
    $app->post('/admin/forgot/reset', function(){
        if(User::verifyCode($_POST['code']) && User::verifyTimeCode($_POST['code'])){
            User::paz_sword_update($_POST['code'],$_POST['password']);
            header("Location: /eco/index.php/admin/login");
            exit;
        } else {
            header("Location: /eco/index.php/admin/forgot");
            exit;
        }
    });

    $app->get('/admin/forgot/sent',function(){
        $page = new PageAdmin(debug(),["header" => false,"footer" => false]);
        $page->setTpl("forgot-sent");
    });

    $app->get('/admin/categories/:idcategory/delete',function($idcategory){
        User::verifyLogin();
        Category::del($idcategory);
        header('Location: /eco/index.php/admin/categories');
        exit;
    });

    $app->get('/admin/categories/create',function(){
        User::verifyLogin();       
        $page = new PageAdmin(debug(),get_config_header("category"));
        $page->setTpl("categories-create");
    });

    $app->post('/admin/categories/create',function(){
        User::verifyLogin();
        Category::create($_POST);
        header('Location: /eco/index.php/admin/categories');
        exit;
    });

    $app->get('/admin/categories/:idcategory',function($idcategory){
        User::verifyLogin();
        $category = Category::find($idcategory);
        $page = new PageAdmin(debug(),get_config_header("category"));
        $page->setTpl('categories-update',["category" => $category]);
    });

    $app->post('/admin/categories/:idcategory',function($idcategory){
        User::verifyLogin();
        Category::update(['id' => $idcategory, 'descategory' => $_POST['descategory']]);
        header('Location: /eco/index.php/admin/categories');
        exit;
    });

    $app->get('/admin/categories',function(){
        User::verifyLogin();
        $categories = Category::listAll();        
        $page = new PageAdmin(debug(),get_config_header("category"));
        $page->setTpl("categories",["categories" => $categories]);

    });

    $app->get('/categoria/:idcategoria/:nome',function($idcategoria,$nome){
        $category = new Category;
        $category->setdata(Category::find($idcategoria));
        $page = new Page(debug());
        $page->setTpl("category",["category" => $category->getdata()]);
    });    

    $app->get('/admin/products/:idcategory',function($idcategory){
        User::verifyLogin();
        $products = Product::list_by_category($idcategory);
        $page = new PageAdmin(debug(),get_config_header("product"));
        $page->setTpl("products",["products" => $products,"idcategory" => $idcategory]);

    });

    $app->get('/admin/products/create/:idcategory',function($idcategory){
        User::verifyLogin();       
        $page = new PageAdmin(debug(),get_config_header("product"));
        $page->setTpl("products-create",["idcategory" => $idcategory]);
    });

    $app->post('/admin/products/create/:idcategory',function($idcategory){
        User::verifyLogin();     
        print_r($_POST);
        exit;
    });

    $app->run(); ?>