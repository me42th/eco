<?php

namespace main\Model;

use \main\Model;
use \main\DB\Sql;
use \main\Freight;
use \main\Model\User;

class Address extends Model{

public static function get_by_zipcode($deszipcode){     
    if(!($address = Address::find_by_zipcode($deszipcode))){
        $address =  Freight::get_address($deszipcode);
        if(!isset($address['logradouro']))
            throw new \Exception("CEP INVÁLIDO");
        $address['desaddress'] = $address['logradouro'];
        unset($address['logradouro']);
        $address['desdistrict'] = $address['bairro'];
        unset($address['bairro']);
        $address['desstate'] = $address['uf'];
        unset($address['uf']);
        $address['descity'] = $address['localidade'];
        unset($address['localidade']);
        $address['descountry'] = 'Brasil';
        $address['descomplement'] = $address['complemento'];
        unset($address['complemento']);
        $address['deszipcode'] = str_replace("-","",$address['cep']);
        unset($address['cep']);
        Address::create($address);        
    }    
    return $address; 
}

private static function find_by_zipcode($deszipcode){
    $deszipcode = str_replace("-","",$deszipcode);   
    $sql = new Sql;
    $address = $sql->select(
        "select * from tb_addresses where deszipcode = '$deszipcode';"
    );
    $address = count($address) >= 1? $address[0] : null;
    return $address;
}

public static function create($data){
    
    $desaddress = $data['desaddress'];
    $desdistrict = $data['desdistrict'];
    $desstate = $data['desstate'] ;
    $descity = $data['descity'] ;
    $descountry = $data['descountry'];
    $descomplement = $data['descomplement'];
    $deszipcode = $data['deszipcode'];
    $sql = new Sql;
    $sql->select(
        "insert into tb_addresses values 
        (default,'$desaddress','$descomplement','$descity','$desstate','$descountry','$deszipcode','$desdistrict',default);"
    );
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