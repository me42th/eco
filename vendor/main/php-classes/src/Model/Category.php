<?php

//mysql> desc tb_categories;
//+-------------+-------------+------+-----+-------------------+----------------+
//| Field       | Type        | Null | Key | Default           | Extra          |
//+-------------+-------------+------+-----+-------------------+----------------+
//| idcategory  | int(11)     | NO   | PRI | NULL              | auto_increment |
//| descategory | varchar(32) | NO   |     | NULL              |                |
//| dtregister  | timestamp   | NO   |     | CURRENT_TIMESTAMP |                |
//+-------------+-------------+------+-----+-------------------+----------------+

//mysql> show tables;
//+-----------------------------+
//| Tables_in_db_ecommerce      |
//+-----------------------------+
//| tb_addresses                |
//| tb_carts                    |
//| tb_cartsproducts            |
//| tb_categories               |
//| tb_orders                   |
//| tb_ordersstatus             |
//| tb_persons                  |
//| tb_products                 |
//| tb_productscategories       |
//| tb_users                    |
//| tb_userslogs                |
//| tb_userspasswordsrecoveries |
//+-----------------------------+

namespace main\Model;

use \main\Model;
use \main\DB\Sql;

class Category extends Model{

    public static function listAll(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_categories");
    }

    public static function get_with_pagination($search = '', $page = 1, $itemsPerPage = 8){
        $start = $page - 1;
        $sql = new Sql();
        $query = ($search == '')?
            "SELECT * FROM tb_categories limit $start, $itemsPerPage":
            "SELECT * FROM tb_categories where descategory like '%$search%' limit $start, $itemsPerPage";
        $categories = $sql->select($query);       

       
        
    

        $query = ($search == '')?
            "select count(*) FROM tb_categories":
            "select count(*) FROM FROM tb_categories where descategory like '%$search%';";

        $total = $sql->select($query)[0]['count(*)'];
        
        return [
            'categories' => $categories,
            'total' => $total,
            'pages' => ceil($total/$itemsPerPage)
        ];
    }

    public static function del($id_category){
        $sql = new Sql;
        $sql->select("delete from tb_categories where idcategory = '$id_category';");
        Category::updateFile();
    }

    public static function del_pivot_prod($idcategory, $idproduct){
        $sql = new Sql;
        $sql->select("delete from tb_productscategories where idcategory = '$idcategory' and idproduct = '$idproduct';");
    }

    public static function new_pivot_prod($idcategory, $idproduct){
        $sql = new Sql;
        $sql->select("insert into tb_productscategories values ('$idcategory','$idproduct');");
    }

    public static function getProducts($idcategory, $releated = true){
        $sql = new Sql;
        if($releated){
            return $sql->select("select * from tb_products join tb_productscategories on tb_products.idproduct = tb_productscategories.idproduct where tb_productscategories.idcategory = '$idcategory';");
        }else{
            return $sql->select("select * from tb_products join tb_productscategories on tb_products.idproduct = tb_productscategories.idproduct where tb_productscategories.idcategory <> '$idcategory';");
        }
    }

    

    public static function update($data){
        $category_name = $data['descategory'];
        $id_category = $data['id'];
        $sql = new Sql;
        $sql->select("update tb_categories set descategory = '$category_name' where idcategory = '$id_category';");
        
        Category::updateFile();
    }

    public static function create($data){
        $category_name = $data['descategory'];
        $sql = new Sql;
        
        $sql->select("insert into tb_categories values (default, '$category_name',default);");
        Category::updateFile();
    }

    public static function find($idcategory){
        if($idcategory == 0)
            return array('idcategory' => 0, 'descategory' => 'Produtos', 'dtregister' => null);
        $sql = new Sql;
        return $sql->select("select * from tb_categories where idcategory = '$idcategory';")[0];
    }

    

    public static function updateFile(){
        
        $categories = Category::listAll();
        $html = array();
        foreach($categories as $category){
            $descategory = $category['descategory'];
            $idcategory = $category['idcategory'];
            array_push($html,"<li><a href='/eco/index.php/categoria/$idcategory/$descategory'>$descategory</a></li>");
        }
        file_put_contents($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'eco'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'store'.DIRECTORY_SEPARATOR.'categories-menu.html', implode('',$html));
    }
}
?>