<?php

namespace main\Model;

use \main\Model;
use \main\DB\Sql;
use \main\Mailer;

class Cart extends Model{

    
    const SESSION = "cart";

    public static function get_from_session()
    {
        
        $cart = array();
        if(isset($_SESSION[Cart::SESSION]) && ((int)$_SESSION[Cart::SESSION]['idcart']) > 0){
            $cart = Cart::find(Cart::find($_SESSION[Cart::SESSION]['idcart']));
        } else if(count($by_session = Cart::find_by_session()) > 0){
            $cart = Cart::find_by_session($by_session);
            
        } else {

        }

    }

    public static function find_by_session()
    {
        $session_id = session_id();
        $sql = new Sql;
        $cart = $sql->select("select * from tb_carts where desssessionid = '$session_id';");
        return $cart;
    }

    public static function find($idcart)
    {
        $sql = new Sql;
        $cart = $sql->select("select * from tb_carts where idcart = '$idcart';");
        return $cart;
    }


    public static function update($data)
    {
        /*
            UPDATE tb_carts
            SET
                dessessionid = pdessessionid,
                iduser = piduser,
                deszipcode = pdeszipcode,
                vlfreight = pvlfreight,
                nrdays = pnrdays
            WHERE idcart = pidcart;

            SELECT * FROM tb_carts WHERE idcart = pidcart;
        */

    }

    public static function create($data)
    {
        $dessessionid = $data["dessessionid"];
        $iduser = isset($data["iduser"])?$data["iduser"]:"0";
        $deszipcode = isset($data["deszipecode"])?$data["deszipecode"]:"0";
        $vlfreight = isset($data["vlfreight"])?$data["vlfreight"]:"0";
        $nrdays = isset($data["nrdays"])?$data["nrdays"]:"0";
        $sql = new Sql;
        $sql->select("insert into tb_carts values (default, '$dessessionid', '$iduser', '$deszipcode', '$vlfreight', '$nrdays', default);");
        return $sql->select("select max(idcart) from tb_carts;")[0]['max(idcart)'];
    }
    
}
?>