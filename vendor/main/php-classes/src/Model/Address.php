<?php



namespace main\Model;

use \main\Model;
use \main\DB\Sql;
use \main\Freight;
use \main\Model\User;

class Address extends Model{

public static function get_by_zipcode($deszipcode){

    $deszipcode = str_replace("-","",$deszipcode);   
    $address = Freight::get_address($deszipcode);
    if(!isset($address['logradouro']))
        throw new \Exception("CEP INVÁLIDO");
    $data['desaddress'] = $address['logradouro'];
    $data['desdistrict'] = $address['bairro'];
    $data['desstate'] = $address['uf'];
    $data['descity'] = $address['localidade'];
    $data['descountry'] = 'Brasil';
    $data['descomplement'] = $address['complemento'];
    $data['deszipcode'] = $address['cep'];
    return $data;
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