<?php

namespace main\Model;

use \main\Model;
use \main\DB\Sql;

class Product extends Model{

    public static function listAll(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_products;");
    }

    public static function list_by_category($id_category){
        return Product::listAll();
    }


    public static function del($id_product){
        $sql = new Sql;
        $sql->select("delete from tb_products where idproduct = '$id_product';");
        $this->updateFile();
    }


    public static function create($data){
        $sql = new Sql;
        print_r($data);
        exit;
        $sql->select("insert into tb_categories values (default, '$category_name',default);");
        $this->updateFile();
    }

    public static function find($idcategory){
        $sql = new Sql;
        return $sql->select("select * from tb_categories where idcategory = '$idcategory';")[0];
    }

    


}
?>