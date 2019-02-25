<?php

//mysql> desc tb_carts;
//+--------------+---------------+------+-----+-------------------+----------------+
//| Field        | Type          | Null | Key | Default           | Extra          |
//+--------------+---------------+------+-----+-------------------+----------------+
//| idcart       | int(11)       | NO   | PRI | NULL              | auto_increment |
//| dessessionid | varchar(64)   | NO   |     | NULL              |                |
//| iduser       | int(11)       | YES  | MUL | NULL              |                |
//| deszipcode   | char(8)       | YES  |     | NULL              |                |
//| vlfreight    | decimal(10,2) | YES  |     | NULL              |                |
//| nrdays       | int(11)       | YES  |     | NULL              |                |
//| dtregister   | timestamp     | NO   |     | CURRENT_TIMESTAMP |                |
//+--------------+---------------+------+-----+-------------------+----------------+

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
use \main\Mailer;
use \main\Model\User;

class Cart extends Model{

    const SESSION = "cart";

    public static function get_resume($idcart)
    {
        $sql = new Sql;
        $products = $sql->select(
            "select distinct idproduct from tb_cartsproducts where idcart = '$idcart' and dtremoved is null;"
        );
        $amount = 0;
        $sum = count($products);
        $freight_data = ['vlwidth' => 0,'vlheight' => 0,'vllength' => 0,'vlweight' => 0];
        foreach($products as &$product){
            $id_product = $product['idproduct'];
            $qnt = $sql->select(
                "select count(*) from tb_cartsproducts where idcart = '$idcart' and idproduct = '$id_product' and dtremoved is null;"
                )[0]['count(*)'];
            $prod_data = Product::find($id_product);
            $amount += ($money = $prod_data['vlprice'] * $qnt);
            $freight_data['vlwidth'] += ($prod_data['vlwidth'] * $qnt);
            $freight_data['vlheight'] += ($prod_data['vlheight'] * $qnt);
            $freight_data['vllength'] += ($prod_data['vllength'] * $qnt); 
            $freight_data['vlweight'] += ($prod_data['vlweight'] * $qnt); 
            $product = ['product' => $prod_data, 'qnt' => $qnt, 'money' => $money];
        }
        return [
            'freight' => $freight_data,
            'products' => $products,
            'amount' => $amount,
            'sum' => $sum
        ];   
    }
    
    public static function add_prod($idcart, $idproduct)
    {
        $sql = new Sql;
        $sql->select(
            "insert into tb_cartsproducts values (default,'$idcart','$idproduct',null,default);"
        );
    }

    public static function rmv_prod($idcart, $idproduct, $all = 0)
    {           
        $sql = new Sql;
        //caso não queria remover todos limito o update para um elemento
        $all = $all == 0?' limit 1 ':' ';
        
        $sql->select(
            "update tb_cartsproducts set dtremoved = now() where dtremoved is null and idcart = '$idcart' and idproduct = '$idproduct' $all;"
        );       
    }

    public static function find_by_session()
    {  
       $cart = array();
        // verifico se a sessão do carrinho existe e capturo o carrinho na session
        if(isset($_SESSION[Cart::SESSION]) && ((int)$_SESSION[Cart::SESSION]['idcart']) > 0){
            $cart = Cart::find($_SESSION[Cart::SESSION]['idcart'])[0];
        //tento localizar no banco pelo id da sessão
        } else if(count($by_session = Cart::select_with_session()) > 0){
            $cart = $by_session[0];
        //carrinho inexistente, crio um para aquele usuário                
        } else {
            $cart = ["dessessionid" => session_id()];            
            //verifico se o usuário da sessão e armazeno os dados caso aja carrinho abandonado
            if(User::check_login(false)){
                $cart['iduser'] = User::find_by_session()["iduser"];
            }
            $cart["idcart"] = Cart::create($cart);              
            //adciono o carrinho a sessão
            $_SESSION[Cart::SESSION] = $cart;
        }
        return $cart;
    }

    private static function select_with_session()
    {
        $session_id = session_id();
        $sql = new Sql;
        $cart = $sql->select(
            "select * from tb_carts where desssessionid = '$session_id';"
        );
        return $cart;
    }

    public static function find($idcart)
    {
        $sql = new Sql;
        $cart = $sql->select(
            "select * from tb_carts where idcart = '$idcart';"
        );
        return $cart;
    }


    public static function update($data)
    {
        $idcart = "'".$data["idcart"]."'";
        $dessessionid = "'".$data["dessessionid"]."'";
        $iduser = isset($data["iduser"])?"'".$data["iduser"]."'":"null";
        $deszipcode = isset($data["deszipcode"])?"'".str_replace('-','',$data["deszipcode"])."'":"null";
        $vlfreight = isset($data["vlfreight"])?"'".str_replace(',','.',str_replace('.','',$data["vlfreight"]))."'":"null";
        $nrdays = isset($data["nrdays"])?"'".$data["nrdays"]."'":"null";
        $sql = new Sql;
        
        $sql->select(
            "update tb_carts set dessessionid = $dessessionid, iduser = $iduser, deszipcode = $deszipcode, vlfreight = $vlfreight, nrdays = $nrdays where idcart = $idcart;"
        );

    }

    public static function create($data)
    {
        $dessessionid = "'".$data["dessessionid"]."'";
        $iduser = isset($data["iduser"])?"'".$data["iduser"]."'":"null";
        $deszipcode = isset($data["deszipecode"])?"'".$data["deszipecode"]."'":"null";
        $vlfreight = isset($data["vlfreight"])?"'".$data["vlfreight"]."'":"null";
        $nrdays = isset($data["nrdays"])?"'".$data["nrdays"]."'":"null";
        $sql = new Sql;
        $sql->select(
            "insert into tb_carts values (default, $dessessionid, $iduser, $deszipcode, $vlfreight, $nrdays, default);"
        );
        return $sql->select("select max(idcart) from tb_carts;")[0]['max(idcart)'];
    }    
}
?>


