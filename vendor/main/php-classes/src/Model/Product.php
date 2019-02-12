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
        
        $sql = new Sql();
        $id_products = $sql->select("select * from tb_productscategories where idcategory = '$id_category';");
        $products = array();
         
        foreach($id_products as $id_product){
            array_push($products,Product::find($id_product['idproduct']));       
        }

        return $products;
    }


    public static function del($id_product)
    {
        $sql = new Sql;
        $sql->select("delete from tb_productscategories where idproduct = '$id_product';");
        $sql->select("delete from tb_products where idproduct = '$id_product';");
        
    }


    public static function create($data)
    {
        $sql = new Sql;
        print_r($data);
        $desproduct = $data['desproduct'];
        $vlprice = $data['vlprice'];
        $vlwidth = $data['vlwidth'];
        $vlheight = $data['vlheight'];
        $vllength = $data['vllength'];
        $vlweight = $data['vlweight'];
        $desurl = $data['desurl'];
        $sql->select("insert into tb_products values (default, '$desproduct','$vlprice','$vlwidth','$vlheight','$vllength','$vlweight','$desurl',default);");
        
        $id_product = $sql->select("select max(idproduct) from tb_products;")[0]['max(idproduct)'];
        $id_category = $data['idcategory'];
        $sql->select("insert into tb_productscategories values ('$id_category','$id_product');");
    }

    public static function find($id_product){
        $sql = new Sql;
        return $sql->select("select * from tb_products where idproduct = '$id_product';")[0];
    }

    


}
?>