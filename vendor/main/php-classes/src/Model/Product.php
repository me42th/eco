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

    public static function update($data)
    {
        $sql = new Sql;
        
        $idproduct = $data['idproduct'];
        $desproduct = $data['desproduct'];
        $vlprice = $data['vlprice'];
        $vlwidth = $data['vlwidth'];
        $vlheight = $data['vlheight'];
        $vllength = $data['vllength'];
        $vlweight = $data['vlweight'];
        $desurl = $data['desurl'];

        $sql->select("update tb_products set desproduct = '$desproduct', vlprice = '$vlprice', vlwidth = '$vlwidth', vlheight = '$vlheight', vllength = '$vllength', vlweight = '$vlweight', desurl = '$desurl' where idproduct = '$idproduct';");

      
    }

    public static function create($data)
    {
        $sql = new Sql;
        $desproduct = $data['desproduct'];
        $vlprice = $data['vlprice'];
        $vlwidth = $data['vlwidth'];
        $vlheight = $data['vlheight'];
        $vllength = $data['vllength'];
        $vlweight = $data['vlweight'];
        $desurl = $data['desurl'];
        $sql->select("insert into tb_products values (default, '$desproduct','$vlprice','$vlwidth','$vlheight','$vllength','$vlweight','$desurl',default);");
        if($data['idcategory'] != 0)
        {
            $id_product = $sql->select("select max(idproduct) from tb_products;")[0]['max(idproduct)'];
            $id_category = $data['idcategory'];
            $sql->select("insert into tb_productscategories values ('$id_category','$id_product');");
        }    
    }

    public static function find($id_product){
        $sql = new Sql;
        return $sql->select("select * from tb_products where idproduct = '$id_product';")[0];
    }

   

    //recupera a atual imagem do produto ou a default
    //imagens excluidas possuem o _ no inicio do arquivo
    //o nome do arquivo contem a data de criação do mesmo
    private function setImg()
    {
        $files = scandir($this->getImgFolder());
        unset($files[0]);
        unset($files[1]);
        $file = '/eco/prdimg/default.jpg';        
        foreach($files as $temp_file){
            if(count(explode('_',$temp_file)) == 1){
                $file = '/eco/prdimg/'.$this->getidproduct.'/'.$temp_file;
            };
            echo count(explode('_',$temp_file)).'<br>';
        }    
        $this->setdesphoto($file);
           
    }

    //identifica a pasta de imagens do produto
    private function getImgFolder(){
        $folder = 
            $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR
            .'eco'.DIRECTORY_SEPARATOR
            .'prdimg'.DIRECTORY_SEPARATOR.        
            $this->getidproduct();
        
        if(!file_exists($folder))
            mkdir($folder);
        return $folder;    
    }

    public function setData($data = array()){
        parent::setData($data);
        $this->setImg();
        
    }

}
?>