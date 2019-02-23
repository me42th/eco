<?php

namespace main\Model;

use \main\Model;
use \main\DB\Sql;
use \main\Mailer;
use \main\Model\User;

class Cart extends Model{

    
    const SESSION = "cart";

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
        $dessessionid = "'".$data["dessessionid"]."'";
        $iduser = isset($data["iduser"])?"'".$data["iduser"]."'":"null";
        $deszipcode = isset($data["deszipecode"])?"'".$data["deszipecode"]."'":"null";
        $vlfreight = isset($data["vlfreight"])?"'".$data["vlfreight"]."'":"null";
        $nrdays = isset($data["nrdays"])?"'".$data["nrdays"]."'":"null";
        $sql = new Sql;
        $sql->select("insert into tb_carts values (default, $dessessionid, $iduser, $deszipcode, $vlfreight, $nrdays, default);");
        return $sql->select("select max(idcart) from tb_carts;")[0]['max(idcart)'];
    }
    
}
?>