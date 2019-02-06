<?php
    //startar session
    session_start();
    require_once('config.php');
    
    use \Slim\Slim;
    use \main\Page;
    use \main\PageAdmin;
    use \main\Model\User;

    $app = new Slim();
    $app->config('debug',debug());
    
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
        //$page = new PageAdmin(debug(),['header' => false,'footer'=>false]);
        //$page->setTpl("login");
    });

    $app->get("/admin/users",function(){
        User::verifyLogin();
        $users = User::listAll();
        $page = new PageAdmin(debug());
        $page->setTpl("users",array("users" => $users));
    });


    $app->get("/admin/users/create",function(){
        User::verifyLogin();
        $page = new PageAdmin(debug());
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
        $page = new PageAdmin(debug());
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
        echo "Hello, " ;
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
        if(User::verifyCode($code)){
            $user = new User;
            $user->setdata(User::find(json_decode(User::decodeForgot($code),true)["user"]));
            
            $page = new PageAdmin(debug(),['header' => false, 'footer' => false]);
            $page->setTpl("forgot-reset",array("code" => $code, 'name' => $user->getdesperson()));
        }else{
            header("Location: /eco/index.php/admin/forgot");
            exit;
        }
        
    });

    $app->get('/admin/forgot/sent',function(){
        $page = new PageAdmin(debug(),["header" => false,"footer" => false]);
        $page->setTpl("forgot-sent");
    });

    
    
    $app->run();
?>