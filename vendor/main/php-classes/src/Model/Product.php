<?php

//mysql> desc tb_products;
//+------------+---------------+------+-----+-------------------+----------------+
//| Field      | Type          | Null | Key | Default           | Extra          |
//+------------+---------------+------+-----+-------------------+----------------+
//| idproduct  | int(11)       | NO   | PRI | NULL              | auto_increment |
//| desproduct | varchar(64)   | NO   |     | NULL              |                |
//| vlprice    | decimal(10,2) | NO   |     | NULL              |                |
//| vlwidth    | decimal(10,2) | NO   |     | NULL              |                |
//| vlheight   | decimal(10,2) | NO   |     | NULL              |                |
//| vllength   | decimal(10,2) | NO   |     | NULL              |                |
//| vlweight   | decimal(10,2) | NO   |     | NULL              |                |
//| desurl     | varchar(128)  | NO   |     | NULL              |                |
//| dtregister | timestamp     | NO   |     | CURRENT_TIMESTAMP |                |
//+------------+---------------+------+-----+-------------------+----------------+

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

class Product extends Model{

    public static function listAll(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_products;");
    }

    public static function list_by_category_with_pagination($idcategory, $page = 1, $itemsPerPage = 8){
        $start = $page - 1;
        $sql = new Sql();
        $products = $sql->select("
            select sql_calc_found_rows * from tb_products a
            join tb_productscategories b on a.idproduct = b.idproduct
            join tb_categories c on b.idcategory = c.idcategory
            where c.idcategory = '$idcategory' limit $start, $itemsPerPage;"
        );       
        
        $total = $sql->select("
            select FOUND_ROWS() AS total;
        ")[0]['total'];
        
        foreach($products as &$row){
            $product = new Product;
            $product->setdata($row);
            $row = $product->getdata();     
        }

        return [
            'products' => $products,
            'total' => $total,
            'pages' => ceil($total/$itemsPerPage)
        ];
    }

    public static function find_by_desurl($desurl){
        $sql = new Sql;
        $produto_temp = $sql->select("
            select * from tb_products where desurl = '$desurl';
        ");    

        if(count($produto_temp) == 0)
            throw new \Exception('Produto inexistente',204);    

        $produto = new Product;
        $produto->setdata($produto_temp[0]);    
        return $produto->getdata();
    }

    public static function list_by_category($id_category){        
        $sql = new Sql();
        $id_products = $sql->select("select * from tb_productscategories where idcategory = '$id_category';");
        $products = array();         
        foreach($id_products as $id_product){
            $product = new Product;
            $product->setdata(Product::find($id_product['idproduct']));
            array_push($products,$product->getdata());     
        }
        return $products;
    }


    public static function del($id_product)
    {
        $sql = new Sql;
        $sql->select("delete from tb_productscategories where idproduct = '$id_product';");
        $sql->select("delete from tb_products where idproduct = '$id_product';");
        $prod = new Product;
        $prod->setidproduct($id_product);
        $directory = $prod->getImgFolder();
        foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory,\FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST) as $file){
           $file->isFile() ? unlink($file->getPathname()) : rmdir($file->getPathname());
        }
        rmdir($directory);
        
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
        $values = "";
        foreach($data as $key => $value){
            $category = explode('_',$key); 
            if(count($category) < 2) continue;
            $category = $category[1];
            $values = $values.''."('$category','$idproduct')";             
        }            
        $values = str_replace(')(','),(',$values);        
        $sql->select("
          update tb_products set desproduct = '$desproduct', vlprice = '$vlprice', vlwidth = '$vlwidth', vlheight = '$vlheight', vllength = '$vllength', vlweight = '$vlweight', desurl = '$desurl' where idproduct = '$idproduct';
        ");
        $sql->select("
            delete from tb_productscategories where idproduct = '$idproduct';
        ");
        $sql->select("
            insert into tb_productscategories values $values;
        ");
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
        $prod = new Product;
        $sql = new Sql;
        $prod->setdata($sql->select(
            "select * from tb_products where idproduct = '$id_product';"
            )[0]);
        return $prod->getdata();
    }

    private function setCat(){
        $id_product = $this->getidproduct();
        $sql = new Sql;
        $categorias = $sql->select("select * from tb_productscategories where idproduct = $id_product;");
        foreach($categorias as &$categoria){
            $categoria = $categoria['idcategory'];
        }
        $this->setcategories($categorias);
      
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
                $file = '/eco/prdimg/'.$this->getidproduct().'/'.$temp_file;
            };           
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

    public function addPhoto($file){
        $extension = explode('.',$file['name']);
        $extension = end($extension);
        $function_name = 'imagecreatefrom'.(($extension == 'jpg')?'jpeg':$extension);
        $image = $function_name($file["tmp_name"]);
        imagepng($image,$this->getImgFolder().DIRECTORY_SEPARATOR.date("Y-m-d h:i:s").'png');
        imagedestroy($image);
        $this->setImg();        
    }
    
    public function setdata($data = array()){
        parent::setdata($data);        
        $this->setImg();       
        $this->setCat();      
    }   
}
?>