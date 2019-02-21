<?php

namespace main\Model;

use \main\Model;
use \main\DB\Sql;
use \main\Mailer;

class Cart extends Model{

    // 16:06
    const SESSION = "Cart";

    public static function get_from_session()
    {
        
        $cart = new Cart;
             
        if(isset($_SESSION[Cart::SESSION]) && ((int)$_SESSION[Cart::SESSION]['idcart']) > 0){
            $cart->setdata(Cart::find($_SESSION[Cart::SESSION]['idcart']));
        } else if(($by_session = Cart::find_by_session()) > 0){
            $cart->setdata($by_session);
        } else {

        }

    }

    public static function find_by_session($idsession)
    {

    }

    public static function find($idcart)
    {

    }


    //implementar a procedure nas functions abaixo
    /*
          CREATE PROCEDURE `sp_carts_save`(
            pidcart INT,
            pdessessionid VARCHAR(64),
            piduser INT,
            pdeszipcode CHAR(8),
            pvlfreight DECIMAL(10,2),
            pnrdays INT
            )
            BEGIN
            
                IF pidcart > 0 THEN
                    
                    UPDATE tb_carts
                    SET
                        dessessionid = pdessessionid,
                        iduser = piduser,
                        deszipcode = pdeszipcode,
                        vlfreight = pvlfreight,
                        nrdays = pnrdays
                    WHERE idcart = pidcart;
                    
                ELSE
                    
                    INSERT INTO tb_carts (dessessionid, iduser, deszipcode, vlfreight, nrdays)
                    VALUES(pdessessionid, piduser, pdeszipcode, pvlfreight, pnrdays);
                    
                    SET pidcart = LAST_INSERT_ID();
                    
                END IF;
                
                SELECT * FROM tb_carts WHERE idcart = pidcart;
            
            END$$
            
        */

    public static function update($data)
    {

    }

    public static function create($data)
    {
        
    }
    
}
?>