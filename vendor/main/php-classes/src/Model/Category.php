<?php

namespace main\Model;

use \main\Model;
use \main\DB\Sql;

class Category extends Model{

    public static function listAll(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_categories");
    }

    public static function del($id_category){
        $sql = new Sql;
        return $sql->select("delete from tb_categories where idcategory = '$id_category';");
    }

    public static function update($data){
        $category_name = $data['descategory'];
        $id_category = $data['id'];
        $sql = new Sql;
        $sql->select("update tb_categories set descategory = '$category_name' where idcategory = '$id_category';");
    }

    public static function create($data){
        $category_name = $data['descategory'];
        $sql = new Sql;
        return $sql->select("insert into tb_categories values (default, '$category_name',default);");
    }

    public static function find($idcategory){
        $sql = new Sql;
        return $sql->select("select * from tb_categories where idcategory = '$idcategory';")[0];
    }


}
?>