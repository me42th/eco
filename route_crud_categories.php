<?php 
    
    use \Slim\Slim;
    use \main\Page;
    use \main\PageAdmin;
    use \main\Model\User;
    use \main\Model\Category;
    use \main\Model\Product;


    $app->get('/admin/categories/:idcategory/delete',function($idcategory){
        User::verify_admin_login();
        Category::del($idcategory);
        header('Location: /eco/index.php/admin/categories');
        exit;
    });

    $app->get('/admin/categories/create',function(){
        User::verify_admin_login();       
        $page = new PageAdmin(debug(),get_category_header());
        $page->setTpl("categories-create");
    });

    $app->post('/admin/categories/create',function(){
        User::verify_admin_login();
        Category::create($_POST);
        header('Location: /eco/index.php/admin/categories');
        exit;
    });

    $app->get('/admin/categories/:idcategory',function($idcategory){
        User::verify_admin_login();
        $productsRelated = Category::getProducts($idcategory);
        $productsNotRelated = Category::getProducts($idcategory,false);
        
        $category = Category::find($idcategory);
        $page = new PageAdmin(debug(),get_category_header());
        $page->setTpl('categories-update',["category" => $category,"productsRelated" => $productsRelated ,"productsNotRelated" => $productsNotRelated]);
    });
    

    $app->get('/admin/categories/:idcategory/products/:idproduct/remove',
    function($idcategory, $idproduct){
        Category::del_pivot_prod($idcategory, $idproduct);
        header('Location: /eco/index.php/admin/categories/'.$idcategory);
        exit;
    });


    $app->get('/admin/categories/:idcategory/products/:idproduct/add',
    function($idcategory, $idproduct){
        Category::new_pivot_prod($idcategory, $idproduct);
        header('Location: /eco/index.php/admin/categories/'.$idcategory);
        exit;
    });

    $app->post('/admin/categories/:idcategory',function($idcategory){
        User::verify_admin_login();
        Category::update(['id' => $idcategory, 'descategory' => $_POST['descategory']]);
        header('Location: /eco/index.php/admin/categories');
        exit;
    });

    $app->get('/admin/categories',function(){
        User::verify_admin_login();
        $search = isset($_GET['search'])?$_GET['search']:'';
        $page = isset($_GET['page'])?$_GET['page']:1;


        
        $data = Category::get_with_pagination($search,$page);

        $page_total = $data['pages'];
        $pages = array();
        $search_href = ($search == '')?$search:"search=$search&";

        for($cont = 1; $cont <= $page_total; $cont++){
            $pages[$cont]['href'] = "/eco/index.php/admin/categories?".$search_href."page=$cont"; 
            $pages[$cont]['text'] = $cont;
        }
        

        $page = new PageAdmin(debug(),get_category_header());
        $page->setTpl("categories",["categories" => $data['categories'], 'page_total' => $page_total, "pages" => $pages ,"search" => $search]);
    });


?>