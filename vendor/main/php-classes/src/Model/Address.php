<?php



namespace main\Model;

use \main\Model;
use \main\DB\Sql;
use \main\Freight;

class Address extends Model{

public static function get_address_by_zipcode($deszipcode){
$deszipcode = str_replace("-","",$deszipcode);

return Freight::get_address($deszipcode);

}

public static function update($data){
    /*
        IF pidaddress > 0 THEN
		
		    UPDATE tb_addresses
                SET
		    	idperson = pidperson,
                desaddress = pdesaddress,
                descomplement = pdescomplement,
                descity = pdescity,
                desstate = pdesstate,
                descountry = pdescountry,
                deszipcode = pdeszipcode, 
                desdistrict = pdesdistrict
		WHERE idaddress = pidaddress;
    */
}    

}
?>