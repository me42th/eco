<?php

namespace main\Model;

use \main\Model;
use \main\DB\Sql;

class Product extends Model{

    public static function listAll(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_products");
    }

    public static function del($id_product){
        $sql = new Sql;
        $sql->select("delete from tb_products where idproduct = '$id_product';");
        $this->updateFile();
    }


    public static function create($data){
        $category_name = $data['descategory'];
        $sql = new Sql;
        
        //$sql->select("insert into tb_categories values (default, '$category_name',default);");
        //$this->updateFile();
    }

    public static function find($idcategory){
        $sql = new Sql;
        return $sql->select("select * from tb_categories where idcategory = '$idcategory';")[0];
    }

    public static function updateFile(){
        
        //$categories = Category::listAll();
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